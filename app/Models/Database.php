<?php
namespace App\Models;

use PDO;

/**
 * Database Singleton Class.
 * Manages a single instance of the PDO connection throughout the application.
 */
class Database {
    private static $instance = null;
    private $pdo;

    /**
     * The constructor is private to prevent direct creation of the object.
     * It establishes a PDO connection using the provided configuration.
     */
    private function __construct($config) {
        $dsn = "mysql:host={$config->db_host};port={$config->db_port};dbname={$config->db_name};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, $config->db_user, $config->db_pass, $options);
    }

    /**
     * Gets the single instance of the database connection.
     * If an instance does not exist, it creates one.
     */
    public static function getInstance($config) {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * Returns the PDO object.
     */
    public function pdo(): PDO {
        return $this->pdo;
    }
}
