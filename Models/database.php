<?php 

namespace Models;


use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Get a PDO connection (singleton)
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn      = 'mysql:host=localhost;dbname=shelfaware;charset=utf8mb4';
                $username = 'root';
                $password = '';
                $options  = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT         => false,
                ];

                self::$connection = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                // Log error or display a user-friendly message
                http_response_code(500);
                die('Database connection error: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}



?>