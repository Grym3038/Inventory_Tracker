<?php 
namespace Models;

use PDO;
use Models\Database;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password_hash;
    public int $client_id;

    /**
     * Find a user by email.
     */
    public static function findByEmail(string $email): ?User
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, name, email, password_hash, client_id FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $user = new User();
        $user->id            = (int)$data['id'];
        $user->name          = $data['name'];
        $user->email         = $data['email'];
        $user->password_hash = $data['password_hash'];
        $user->client_id     = (int)$data['client_id'];
        return $user;
    }

    /**
     * Insert new or update existing user.
     */
    public function save(): bool
    {
        $db = Database::getConnection();
        if (!empty($this->id)) {
            $sql = 'UPDATE users SET name = :name, email = :email, password_hash = :hash, client_id = :client_id WHERE id = :id';
        } else {
            $sql = 'INSERT INTO users (name, email, password_hash, client_id) VALUES (:name, :email, :hash, :client_id)';
        }

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':hash', $this->password_hash, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $this->client_id, PDO::PARAM_INT);
        if (!empty($this->id)) {
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        }

        $result = $stmt->execute();
        if ($result && empty($this->id)) {
            $this->id = (int)$db->lastInsertId();
        }
        return $result;
    }
}
?>