<?php
namespace Models;

use Models\Database;
use PDO;
use PDOException;

class AdminDBAccess
{

   

    /**
     * Fetch all clients
     *
     * @return array  each element is ['id','name']
     */
    public static function getAllClients(): array
    {
        $db   = Database::getConnection();
        $stmt = $db->query('SELECT id, name FROM clients ORDER BY name');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total users for a given client + optional email filter
     public static function countUsers(int $clientId, string $emailFilter = ''): int
    {
        $db = Database::getConnection();
        $sql = 'SELECT COUNT(*) FROM users WHERE client_id = :cid'
             . ($emailFilter ? ' AND email LIKE :email' : '');
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':cid', $clientId, PDO::PARAM_INT);
        if ($emailFilter) {
            $stmt->bindValue(':email', "%{$emailFilter}%", PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // Fetch a page of users for a given client + optional email filter
    public static function getUsers(
        int    $clientId,
        string $emailFilter = '',
        int    $limit,
        int    $offset
    ): array {
        $db = Database::getConnection();
        $sql = 'SELECT id, name, email, role
                  FROM users
                 WHERE client_id = :cid'
             . ($emailFilter ? ' AND email LIKE :email' : '')
             . ' ORDER BY name
                 LIMIT :lim OFFSET :off';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':cid', $clientId, PDO::PARAM_INT);
        if ($emailFilter) {
            $stmt->bindValue(':email', "%{$emailFilter}%", PDO::PARAM_STR);
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user’s role and client assignment
     *
     * @param int    $userId
     * @param string $newRole
     * @param int    $newClientId
     * @return bool
     */
    public static function updateUser(int $userId, string $newRole, int $newClientId): bool
    {
        $db = Database::getConnection();
        $sql = 'UPDATE users
                   SET role      = :role,
                       client_id = :client_id
                 WHERE id        = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':role',      $newRole,     PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $newClientId, PDO::PARAM_INT);
        $stmt->bindValue(':id',        $userId,      PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // log $e->getMessage() if you have a logger
            return false;
        }
    }

    /**
     * Delete a user by ID (only if they are not protected)
     *
     * @param int $userId
     * @return bool
     */
    public static function deleteUser(int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // e.g. foreign key constraint; log if desired
            return false;
        }
    }
}
