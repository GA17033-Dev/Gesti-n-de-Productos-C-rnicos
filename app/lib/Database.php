<?php

namespace App\Lib;

use PDO;
use PDOException;

class Database
{
    public $host;
    public $user;
    public $password;
    public $database;
    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_DATABASE'];
    }
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->database";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
