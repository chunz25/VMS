<?php
// include 'don.php';
// die();
ini_set('memory_limit', '512M');

// PRD
// $host = '10.140.1.13';
// $user = 'vms';
// $pass = 'Vms-ECI2023!';

// DEV
$host = '10.101.0.8';
$user = 'root';
$pass = 'Admin2021!';

$db = 'vms_db';
$dsn = "mysql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}