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
    public string $role;
    public bool $darkmode_on;
    
    /**
     * Find a user by email.
     */
    public static function findByEmail(string $email): ?User
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, name, email, password_hash, client_id, role, darkmode_on FROM users WHERE email = :email LIMIT 1'
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
        $user->role          = $data['role'];
        $user->darkmode_on   = (bool)$data['darkmode_on'];
        return $user;
    }

    /**
     * Insert new or update existing user.
     */
    public function save(): bool
    {
        $db = Database::getConnection();
        if (!empty($this->id)) {
            $sql = 'UPDATE users SET name = :name, email = :email, password_hash = :hash, client_id = :client_id, role = :role, darkmode_on = :darkmode_on WHERE id = :id';
        } else {
            $sql = 'INSERT INTO users (name, email, password_hash, client_id, role, darkmode_on) VALUES (:name, :email, :hash, :client_id, :role, :darkmode_on)';
        }

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':hash', $this->password_hash, PDO::PARAM_STR);
        $stmt->bindValue(':client_id', $this->client_id, PDO::PARAM_INT);
        $stmt->bindValue(':role', $this->role, PDO::PARAM_STR);
        $stmt->bindValue(':darkmode_on', $this->darkmode_on, PDO::PARAM_BOOL);
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
     * Find a user by ID.
     */
    public static function findById(int $id): ?User
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT id, name, email, password_hash, client_id, role, darkmode_on FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
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
        $user->role          = $data['role'];
        $user->darkmode_on   = (bool)$data['darkmode_on'];
        return $user;
    }

    /**
     * Update user name.
     */
    public function updateName(string $name): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET name = :name WHERE id = :id');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        if ($result) {
            $this->name = $name;
        }
        return $result;
    }

    /**
     * Update dark mode preference.
     */
    public function updateDarkMode(bool $darkmode_on): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET darkmode_on = :darkmode_on WHERE id = :id');
        $stmt->bindValue(':darkmode_on', $darkmode_on, PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        if ($result) {
            $this->darkmode_on = $darkmode_on;
        }
        return $result;
    }
}
?>