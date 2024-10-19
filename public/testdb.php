<?php
$host = 'localhost';
$db   = 'gestion_carnicos';
$user = 'root';
$pass = 'tu_contraseña_mysql';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "Conexión exitosa a la base de datos";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
