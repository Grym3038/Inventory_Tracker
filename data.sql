-- -------------------------------------------------------------------
-- 1) Create one client (tenant)
-- -------------------------------------------------------------------
INSERT INTO clients (id, name, domain, created_at)
VALUES
  (1, 'Demo Tenant Co.', 'demo-tenant.local', NOW());

-- -------------------------------------------------------------------
-- 2) Two users for that tenant: a manager (owner) and an employee
-- -------------------------------------------------------------------
INSERT INTO users (id, client_id, name, email, password_hash, role, created_at)
VALUES
  (1, 1, 'ADMIN', 'Admin@email.com',
     '$2y$10$KC5zrfX7wmI5qkQ.Vdg7Ye0KhKUsj5L4vJNpZnDp2l9s61CjmPTAu', 'admin', NOW()),
  (2, 1, 'Owner Test', 'Owner@email.com',
     '$2y$10$dKNt6dtEL1ADW6rgacIHL.GyopCxpaZFr0rPymqdAxhRLTCQDzASy', 'owner', NOW()),
  (3, 1, 'Employee Test', 'employee@email.com',
     '$2y$10$Rcw1N6wQAhYgzE2CLhhm/elZ3.ucBvE3rCmHdUM1BZ8/8u06E4pbO', 'employee', NOW());



-- -------------------------------------------------------------------
-- 4) Multiple inventory items for pagination testing
-- -------------------------------------------------------------------
INSERT INTO items (id, client_id, sku, name, threshold_qty, current_qty, created_at)
VALUES
  (1, 1, 'SKU-APPLE',  'Apple',   10, 50, NOW()),
  (2, 1, 'SKU-BANANA', 'Banana',  20, 30, NOW()),
  (3, 1, 'SKU-ORANGE', 'Orange',  15, 25, NOW()),
  (4, 1, 'SKU-GRAPE',  'Grape',   8, 40, NOW()),
  (5, 1, 'SKU-MANGO',  'Mango',   12, 18, NOW()),
  (6, 1, 'SKU-PINEAPPLE', 'Pineapple', 5, 35, NOW()),
  (7, 1, 'SKU-STRAWBERRY', 'Strawberry', 10, 22, NOW()),
  (8, 1, 'SKU-BLUEBERRY', 'Blueberry', 6, 28, NOW()),
  (9, 1, 'SKU-RASPBERRY', 'Raspberry', 4, 15, NOW()),
  (10, 1, 'SKU-BLACKBERRY', 'Blackberry', 7, 32, NOW()),
  (11, 1, 'SKU-CHERRY', 'Cherry', 9, 45, NOW()),
  (12, 1, 'SKU-PEACH', 'Peach', 11, 38, NOW()),
  (13, 1, 'SKU-PLUM', 'Plum', 6, 20, NOW()),
  (14, 1, 'SKU-APRICOT', 'Apricot', 8, 26, NOW()),
  (15, 1, 'SKU-NECTARINE', 'Nectarine', 10, 33, NOW());

-- -------------------------------------------------------------------
-- 5) One open float for today
-- -------------------------------------------------------------------
INSERT INTO inventory_floats (id, client_id, float_date, status, generated_at)
VALUES
  (1, 1, CURDATE(), 'open', NOW());

-- -------------------------------------------------------------------
-- 6) Two float entries awaiting approval
-- -------------------------------------------------------------------
INSERT INTO inventory_float_entries
  (id, float_id, item_id, reported_qty, approved, approved_qty, manager_id, approved_at, created_at)
VALUES
  (1, 1, 1,  48, FALSE, NULL, NULL,   NULL, NOW()),  -- Alice hasn’t approved yet
  (2, 1, 2,  28, FALSE, NULL, NULL,   NULL, NOW());

-- -------------------------------------------------------------------
-- 7) Manager approves both entries
-- -------------------------------------------------------------------
UPDATE inventory_float_entries
SET approved = TRUE,
    approved_qty = reported_qty,
    manager_id = 1,
    approved_at = NOW()
WHERE float_id = 1;

-- -------------------------------------------------------------------
-- 8) One restock request for the banana entry (since 28 < threshold 20? adjust as needed)
-- -------------------------------------------------------------------
INSERT INTO restock_requests
  (id, entry_id, requested_qty, status, manager_id, employee_id, requested_at)
VALUES
  (1, 2, 12, 'pending', 1, 2, NOW());

-- -------------------------------------------------------------------
-- 9) One ticket generated for that restock
-- -------------------------------------------------------------------
INSERT INTO tickets
  (id, client_id, type, reference_id, status, description, created_at)
VALUES
  (1, 1, 'restock', 1, 'open',
   'Auto‐generated restock ticket for entry #1', NOW());

-- -------------------------------------------------------------------
-- 10) One daily report for today
-- -------------------------------------------------------------------
INSERT INTO reports
  (id, client_id, report_date, variance_flag, generated_at, manager_id)
VALUES
  (1, 1, CURDATE(), TRUE, NOW(), 1);

-- -------------------------------------------------------------------
-- 11) One API key for the tenant
-- -------------------------------------------------------------------
INSERT INTO api_keys
  (id, client_id, api_key, created_at)
VALUES
  (1, 1, 'api_ABCDEFGHIJKLMNOPQRSTUVWXYZ', NOW());

-- -------------------------------------------------------------------
-- 12) Snapshot the float (finalized)
-- -------------------------------------------------------------------
INSERT INTO inventory_snapshots
  (id, float_id, snapshot_date, created_at)
VALUES
  (1, 1, CURDATE(), NOW());

-- -------------------------------------------------------------------
-- 13) Two snapshot entries (copying approved quantities)
-- -------------------------------------------------------------------
INSERT INTO inventory_snapshot_entries
  (id, snapshot_id, item_id, recorded_qty)
VALUES
  (1, 1, 1, 48),
  (2, 1, 2, 28);
