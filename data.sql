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
  (2, 1, 'Bob Employee', 'bob@demo-tenant.local',
     '$2y$10$bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 'employee', NOW());

-- -------------------------------------------------------------------
-- 3) One OAuth token for Alice (as if she logged in via Google)
-- -------------------------------------------------------------------
INSERT INTO oauth_tokens (id, user_id, provider, access_token, refresh_token, expires_at, created_at)
VALUES
  (1, 1, 'google',
   'ya29.a0ARrdaM-ExampleAccessToken1234567890',
   '1//0gExampleRefreshTokenABCDEFGHIJKLMN', 
   DATE_ADD(NOW(), INTERVAL 1 HOUR),
   NOW());

-- -------------------------------------------------------------------
-- 4) Two inventory items
-- -------------------------------------------------------------------
INSERT INTO items (id, client_id, sku, name, threshold_qty, current_qty, created_at)
VALUES
  (1, 1, 'SKU-APPLE',  'Apple',   10, 50, NOW()),
  (2, 1, 'SKU-BANANA', 'Banana',  20, 30, NOW());

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
