<?php 
namespace Models;

use PDO;
use Models\Database;

class Item
{
    public int $id;
    public int $client_id;
    public string $sku;
    public string $name;
    public int $threshold_qty;
    public int $current_qty;

    /**
     * Find item by id.
     */
    public static function findById(int $id): ?Item
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, client_id, sku, name, threshold_qty, current_qty
             FROM items WHERE id = :id LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;

        $item = new Item();
        $item->id            = (int)$data['id'];
        $item->client_id     = (int)$data['client_id'];
        $item->sku           = $data['sku'];
        $item->name          = $data['name'];
        $item->threshold_qty = (int)$data['threshold_qty'];
        $item->current_qty   = (int)$data['current_qty'];
        return $item;
    }

    /**
     * List all items for a client.
     */
    public static function findAllByClient(int $client_id): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, client_id, sku, name, threshold_qty, current_qty
             FROM items WHERE client_id = :client_id ORDER BY name'
        );
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new Item();
            $item->id            = (int)$row['id'];
            $item->client_id     = (int)$row['client_id'];
            $item->sku           = $row['sku'];
            $item->name          = $row['name'];
            $item->threshold_qty = (int)$row['threshold_qty'];
            $item->current_qty   = (int)$row['current_qty'];
            $result[] = $item;
        }
        return $result;
    }

    /**
     * Check if a SKU exists for this client (excluding optional item id).
     */
    public static function skuExists(string $sku, int $client_id, ?int $exclude_id = null): bool
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) FROM items WHERE sku = :sku AND client_id = :client_id';
        if ($exclude_id !== null) {
            $sql .= ' AND id != :exclude_id';
        }
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':sku', $sku, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
        if ($exclude_id !== null) {
            $stmt->bindValue(':exclude_id', $exclude_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Insert or update item.
     */
    public function save(): bool
    {
        $db = Database::getConnection();
        if (!empty($this->id)) {
            $sql = 'UPDATE items SET
                        sku = :sku,
                        name = :name,
                        threshold_qty = :threshold_qty,
                        current_qty = :current_qty
                    WHERE id = :id';
        } else {
            $sql = 'INSERT INTO items
                        (client_id, sku, name, threshold_qty, current_qty)
                    VALUES
                        (:client_id, :sku, :name, :threshold_qty, :current_qty)';
        }

        $stmt = $db->prepare($sql);
        if (empty($this->id)) {
            $stmt->bindValue(':client_id', $this->client_id, PDO::PARAM_INT);
        }
        $stmt->bindValue(':sku', $this->sku, PDO::PARAM_STR);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':threshold_qty', $this->threshold_qty, PDO::PARAM_INT);
        $stmt->bindValue(':current_qty', $this->current_qty, PDO::PARAM_INT);
        if (!empty($this->id)) {
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        }

        $result = $stmt->execute();
        if ($result && empty($this->id)) {
            $this->id = (int)$db->lastInsertId();
        }
        return $result;
    }

    /**
     * Delete this item.
     */
    public function delete(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM items WHERE id = :id');
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
