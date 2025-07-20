-- -------------------------------------------------------------------
-- Drop everything
-- -------------------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS inventory_snapshot_entries;
DROP TABLE IF EXISTS inventory_snapshots;
DROP TABLE IF EXISTS api_keys;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS restock_requests;
DROP TABLE IF EXISTS inventory_float_entries;
DROP TABLE IF EXISTS inventory_floats;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS oauth_tokens;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS clients;

SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------
-- SCHEMA
-- ------------------------------------------------

-- Clients (tenants)
CREATE TABLE clients (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)    NOT NULL,
  -- index prefix to stay under 1000-byte limit (191×4=764 bytes)
  domain      VARCHAR(255)    NOT NULL,
  created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_clients_domain (domain(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users (store owners & employees)
CREATE TABLE users (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id      INT UNSIGNED NOT NULL,
  name           VARCHAR(255)    NOT NULL,
  email          VARCHAR(255)    NOT NULL,
  password_hash  VARCHAR(255),
  role           VARCHAR(50)     NOT NULL,  -- 'owner' or 'employee'
  darkmode_on    BOOLEAN         NOT NULL DEFAULT FALSE,
  created_at     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  -- OAuth fields
  oauth_provider VARCHAR(50)     NOT NULL DEFAULT 'local',
  google_id      VARCHAR(191),              -- indexed prefix
  oauth_avatar   VARCHAR(512),
  oauth_id_token TEXT,

  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email       (email),
  UNIQUE KEY uq_users_google_id   (google_id),
  INDEX idx_users_client          (client_id),
  CONSTRAINT fk_users_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Migration script for existing databases
-- ALTER TABLE users ADD COLUMN darkmode_on BOOLEAN NOT NULL DEFAULT FALSE AFTER role;

-- OAuth tokens (if you want to store access/refresh tokens)
CREATE TABLE oauth_tokens (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id        INT UNSIGNED NOT NULL,
  provider       VARCHAR(50)     NOT NULL,  -- e.g. 'google'
  access_token   TEXT            NOT NULL,
  refresh_token  TEXT,
  expires_at     TIMESTAMP,
  created_at     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_oauth_user_provider (user_id, provider),
  INDEX idx_oauth_user             (user_id),
  CONSTRAINT fk_oauth_tokens_user
    FOREIGN KEY (user_id) REFERENCES users(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inventory items
CREATE TABLE items (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id      INT UNSIGNED NOT NULL,
  sku            VARCHAR(255)    NOT NULL,
  name           VARCHAR(255)    NOT NULL,
  threshold_qty  INT             NOT NULL,
  current_qty    INT             NOT NULL,
  created_at     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_items_sku     (sku),
  INDEX idx_items_client      (client_id),
  CONSTRAINT fk_items_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daily inventory floats
CREATE TABLE inventory_floats (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id    INT UNSIGNED NOT NULL,
  float_date   DATE            NOT NULL,
  status       VARCHAR(50)     NOT NULL,  -- 'open' or 'finalized'
  generated_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_floats_client_date (client_id, float_date),
  INDEX idx_floats_client         (client_id),
  CONSTRAINT fk_floats_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Float entries awaiting approval
CREATE TABLE inventory_float_entries (
  id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  float_id      INT UNSIGNED  NOT NULL,
  item_id       INT UNSIGNED  NOT NULL,
  reported_qty  INT           NOT NULL,
  approved      BOOLEAN       NOT NULL DEFAULT FALSE,
  approved_qty  INT,
  manager_id    INT UNSIGNED,
  approved_at   TIMESTAMP,
  created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  INDEX idx_ife_float   (float_id),
  INDEX idx_ife_item    (item_id),
  INDEX idx_ife_manager (manager_id),
  CONSTRAINT fk_ife_float
    FOREIGN KEY (float_id) REFERENCES inventory_floats(id)
      ON DELETE CASCADE,
  CONSTRAINT fk_ife_item
    FOREIGN KEY (item_id) REFERENCES items(id)
      ON DELETE RESTRICT,
  CONSTRAINT fk_ife_manager
    FOREIGN KEY (manager_id) REFERENCES users(id)
      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Restock requests
CREATE TABLE restock_requests (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  entry_id       INT UNSIGNED NOT NULL,
  requested_qty  INT           NOT NULL,
  status         VARCHAR(50)   NOT NULL,  -- 'pending','approved','rejected','completed'
  manager_id     INT UNSIGNED,
  employee_id    INT UNSIGNED,
  requested_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  responded_at   TIMESTAMP,
  completed_at   TIMESTAMP,

  PRIMARY KEY (id),
  INDEX idx_rr_entry    (entry_id),
  INDEX idx_rr_manager  (manager_id),
  INDEX idx_rr_employee (employee_id),
  CONSTRAINT fk_rr_entry
    FOREIGN KEY (entry_id) REFERENCES inventory_float_entries(id)
      ON DELETE CASCADE,
  CONSTRAINT fk_rr_manager
    FOREIGN KEY (manager_id) REFERENCES users(id)
      ON DELETE SET NULL,
  CONSTRAINT fk_rr_employee
    FOREIGN KEY (employee_id) REFERENCES users(id)
      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Notifications (tickets)
CREATE TABLE tickets (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id    INT UNSIGNED NOT NULL,
  type         VARCHAR(50)    NOT NULL,  -- e.g. 'invalid_data','restock','report'
  reference_id INT            NOT NULL,  -- FK to related record (no enforced FK here)
  status       VARCHAR(50)    NOT NULL,  -- 'open','resolved'
  description  VARCHAR(255)   NOT NULL,
  created_at   TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  INDEX idx_tickets_client (client_id),
  CONSTRAINT fk_tickets_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daily management reports
CREATE TABLE reports (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id     INT UNSIGNED NOT NULL,
  report_date   DATE            NOT NULL,
  variance_flag BOOLEAN         NOT NULL DEFAULT FALSE,
  generated_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  manager_id    INT UNSIGNED    NOT NULL,

  PRIMARY KEY (id),
  UNIQUE KEY uq_reports_client_date (client_id, report_date),
  INDEX idx_reports_manager        (manager_id),
  CONSTRAINT fk_reports_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE,
  CONSTRAINT fk_reports_manager
    FOREIGN KEY (manager_id) REFERENCES users(id)
      ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- API keys
CREATE TABLE api_keys (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  client_id   INT UNSIGNED NOT NULL,
  api_key     VARCHAR(255)   NOT NULL,
  created_at  TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_api_keys_key (api_key),
  INDEX idx_api_keys_client  (client_id),
  CONSTRAINT fk_apikeys_client
    FOREIGN KEY (client_id) REFERENCES clients(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Finalized daily snapshots
CREATE TABLE inventory_snapshots (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  float_id      INT UNSIGNED NOT NULL,
  snapshot_date DATE            NOT NULL,
  created_at    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  INDEX idx_snapshots_float   (float_id),
  INDEX idx_snapshot_date     (snapshot_date),
  CONSTRAINT fk_snapshots_float
    FOREIGN KEY (float_id) REFERENCES inventory_floats(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Snapshot entries
CREATE TABLE inventory_snapshot_entries (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  snapshot_id   INT UNSIGNED NOT NULL,
  item_id       INT UNSIGNED NOT NULL,
  recorded_qty  INT           NOT NULL,

  PRIMARY KEY (id),
  INDEX idx_sne_snapshot (snapshot_id),
  INDEX idx_sne_item     (item_id),
  CONSTRAINT fk_sne_snapshot
    FOREIGN KEY (snapshot_id) REFERENCES inventory_snapshots(id)
      ON DELETE CASCADE,
  CONSTRAINT fk_sne_item
    FOREIGN KEY (item_id) REFERENCES items(id)
      ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


