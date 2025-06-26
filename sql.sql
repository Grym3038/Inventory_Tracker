-- purge all data so we start fresh, LOL
TRUNCATE
  inventory_snapshot_entries,
  inventory_snapshots,
  api_keys,
  reports,
  tickets,
  restock_requests,
  inventory_float_entries,
  inventory_floats,
  items,
  users,
  clients
RESTART IDENTITY CASCADE;

-- ------------------------------------------------
-- SCHEMA DEFINITIONS
-- ------------------------------------------------

-- tenants table, yay
DROP TABLE IF EXISTS clients CASCADE;
CREATE TABLE clients (
  id          SERIAL PRIMARY KEY,
  name        VARCHAR NOT NULL,
  domain      VARCHAR UNIQUE NOT NULL,  -- gotta have a domain duh
  created_at  TIMESTAMP NOT NULL DEFAULT now()
);

-- users, store peeps
DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
  id            SERIAL PRIMARY KEY,
  client_id     INT NOT NULL REFERENCES clients(id),
  name          VARCHAR NOT NULL,
  email         VARCHAR UNIQUE NOT NULL,
  password_hash VARCHAR NOT NULL,      -- store those hashes!
  role          VARCHAR NOT NULL,      -- 'owner' or 'employee'
  created_at    TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX idx_users_client ON users(client_id);

-- stuff we track
DROP TABLE IF EXISTS items CASCADE;
CREATE TABLE items (
  id             SERIAL PRIMARY KEY,
  client_id      INT NOT NULL REFERENCES clients(id),
  sku            VARCHAR UNIQUE NOT NULL,
  name           VARCHAR NOT NULL,
  threshold_qty  INT NOT NULL,
  current_qty    INT NOT NULL,
  created_at     TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX idx_items_client ON items(client_id);

-- daily float, messy floats
DROP TABLE IF EXISTS inventory_floats CASCADE;
CREATE TABLE inventory_floats (
  id            SERIAL PRIMARY KEY,
  client_id     INT NOT NULL REFERENCES clients(id),
  float_date    DATE NOT NULL,
  status        VARCHAR NOT NULL,  -- 'open' or 'finalized'
  generated_at  TIMESTAMP NOT NULL DEFAULT now(),
  UNIQUE (client_id, float_date)
);

-- float entries before manager thumbs up
DROP TABLE IF EXISTS inventory_float_entries CASCADE;
CREATE TABLE inventory_float_entries (
  id               SERIAL PRIMARY KEY,
  float_id         INT NOT NULL REFERENCES inventory_floats(id),
  item_id          INT NOT NULL REFERENCES items(id),
  reported_qty     INT NOT NULL,
  approved         BOOLEAN NOT NULL DEFAULT false,
  approved_qty     INT,            -- manager-adjusted
  manager_id       INT REFERENCES users(id),
  approved_at      TIMESTAMP,
  created_at       TIMESTAMP NOT NULL DEFAULT now()
);

-- employees restock
DROP TABLE IF EXISTS restock_requests CASCADE;
CREATE TABLE restock_requests (
  id             SERIAL PRIMARY KEY,
  entry_id       INT NOT NULL REFERENCES inventory_float_entries(id),
  requested_qty  INT NOT NULL,
  status         VARCHAR NOT NULL,  -- 'pending','approved','rejected','completed'
  manager_id     INT REFERENCES users(id),
  employee_id    INT REFERENCES users(id),
  requested_at   TIMESTAMP NOT NULL DEFAULT now(),
  responded_at   TIMESTAMP,
  completed_at   TIMESTAMP
);

-- notifications, cuz tickets are cool
DROP TABLE IF EXISTS tickets CASCADE;
CREATE TABLE tickets (
  id           SERIAL PRIMARY KEY,
  client_id    INT NOT NULL REFERENCES clients(id),
  type         VARCHAR NOT NULL,   -- invalid_data, restock, report
  reference_id INT NOT NULL,       -- link to related record
  status       VARCHAR NOT NULL,   -- open, resolved
  created_at   TIMESTAMP NOT NULL DEFAULT now()
);

-- daily management reports
DROP TABLE IF EXISTS reports CASCADE;
CREATE TABLE reports (
  id            SERIAL PRIMARY KEY,
  client_id     INT NOT NULL REFERENCES clients(id),
  report_date   DATE NOT NULL,
  variance_flag BOOLEAN NOT NULL DEFAULT false,
  generated_at  TIMESTAMP NOT NULL DEFAULT now(),
  manager_id    INT NOT NULL REFERENCES users(id),
  UNIQUE (client_id, report_date)
);

-- API keys so POS talks to us
DROP TABLE IF EXISTS api_keys CASCADE;
CREATE TABLE api_keys (
  id          SERIAL PRIMARY KEY,
  client_id   INT NOT NULL REFERENCES clients(id),
  key         VARCHAR UNIQUE NOT NULL,
  created_at  TIMESTAMP NOT NULL DEFAULT now()
);

-- finalized snapshots for history
DROP TABLE IF EXISTS inventory_snapshots CASCADE;
CREATE TABLE inventory_snapshots (
  id            SERIAL PRIMARY KEY,
  float_id      INT NOT NULL REFERENCES inventory_floats(id),
  snapshot_date DATE NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT now()
);
CREATE INDEX idx_snapshot_date ON inventory_snapshots(snapshot_date);

-- snapshot entries detail
DROP TABLE IF EXISTS inventory_snapshot_entries CASCADE;
CREATE TABLE inventory_snapshot_entries (
  id            SERIAL PRIMARY KEY,
  snapshot_id   INT NOT NULL REFERENCES inventory_snapshots(id),
  item_id       INT NOT NULL REFERENCES items(id),
  recorded_qty  INT NOT NULL
);

-- ------------------------------------------------
-- SUPPORTING FUNCTIONS
-- ------------------------------------------------

-- convert float to snapshot, plpgsql version
CREATE OR REPLACE FUNCTION convert_float_to_snapshot(p_float_id INT, p_manager_id INT)
RETURNS VOID LANGUAGE plpgsql AS $$
DECLARE
  v_snapshot_id INT;
  rec RECORD;
BEGIN
  -- lock the float row
  SELECT id INTO rec FROM inventory_floats
    WHERE id = p_float_id AND status = 'open'
    FOR UPDATE;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'float % not found or already finalized', p_float_id;
  END IF;

  -- insert snapshot header
  INSERT INTO inventory_snapshots(float_id, snapshot_date, created_at)
  SELECT id, float_date, now() FROM inventory_floats WHERE id = p_float_id
  RETURNING id INTO v_snapshot_id;

  -- copy approved entries
  INSERT INTO inventory_snapshot_entries(snapshot_id, item_id, recorded_qty)
  SELECT
    v_snapshot_id,
    ife.item_id,
    COALESCE(ife.approved_qty, ife.reported_qty)
  FROM inventory_float_entries AS ife
  WHERE ife.float_id = p_float_id AND ife.approved = TRUE;

  -- mark float done
  UPDATE inventory_floats SET status = 'finalized' WHERE id = p_float_id;
END;
$$;

-- ------------------------------------------------
-- DUMMY DATA
-- ------------------------------------------------

-- two clients
INSERT INTO clients(name, domain) VALUES
  ('Acme Store', 'acme.example.com'),
  ('Beta Mart', 'beta.example.com');

-- two users: manager and employee for Acme
INSERT INTO users(client_id, name, email, password_hash, role) VALUES
  (1, 'Alice Manager', 'alice@acme.com', 'hashed_pwd_mgr', 'owner'),  -- mgr login
  (1, 'Bob Cashier',   'bob@acme.com',   'hashed_pwd_emp', 'employee');

-- some items
INSERT INTO items(client_id, sku, name, threshold_qty, current_qty) VALUES
  (1, 'A100', 'Apple',    10, 50),
  (1, 'B200', 'Banana',   20, 30);

-- create an open float for today
INSERT INTO inventory_floats(client_id, float_date, status) VALUES
  (1, CURRENT_DATE, 'open');

-- entries for that float (id = 1)
INSERT INTO inventory_float_entries(float_id, item_id, reported_qty) VALUES
  (1, 1, 48),  -- Alice will approve these later
  (1, 2, 28);

-- manager approves entries
UPDATE inventory_float_entries
SET approved = TRUE, approved_qty = reported_qty, manager_id = 1, approved_at = now()
WHERE float_id = 1;

-- extra approved dummy entries
INSERT INTO inventory_float_entries (float_id, item_id, reported_qty, approved, approved_qty, manager_id, approved_at)
VALUES
  (1, 1, 65, TRUE, 65, 1, now()),
  (1, 2, 12, TRUE, 12, 1, now());

-- restock request for Banana since reported_qty < threshold
INSERT INTO restock_requests(entry_id, requested_qty, status, manager_id, employee_id)
VALUES (2, 10, 'pending', 1, 2);

-- ticket for restock
INSERT INTO tickets(client_id, type, reference_id, status) VALUES
  (1, 'restock', 1, 'open');

-- daily report
INSERT INTO reports(client_id, report_date, variance_flag, manager_id)
VALUES (1, CURRENT_DATE, TRUE, 1);

-- API key for Acme
INSERT INTO api_keys(client_id, key) VALUES
  (1, 'abcdef123456');

-- convert the float to a snapshot
SELECT convert_float_to_snapshot(1, 1);

-- extra dummy inventory entries for more testing
INSERT INTO inventory_float_entries(float_id, item_id, reported_qty, approved, approved_qty, manager_id, approved_at)
VALUES
  (1, 1, 75, TRUE, 75, 1, now()), -- apple overflow test
  (1, 2, 0, TRUE,  0, 1, now()), -- out of banana
  (1, 1, 5, TRUE,   5, 1, now()), -- low apple again
  (1, 2, 22, TRUE,  22, 1, now()); -- banana normal re-count

-- corresponding restock tickets for new entries
INSERT INTO restock_requests(entry_id, requested_qty, status, manager_id, employee_id, requested_at)
VALUES
  (LASTVAL()-3, 5, 'pending', 1, 2, now()), -- for apple low
  (LASTVAL()-1, 10, 'pending', 1, 2, now());

-- done adding more data
-- verify updated entries
SELECT * FROM inventory_float_entries WHERE float_id = 1;
-- verify restock requests
SELECT * FROM restock_requests;

-- verify snapshot entries again after conversion if needed
SELECT * FROM inventory_snapshot_entries;

-- verify snapshot list
SELECT * FROM inventory_snapshots;
