<?php
// ini_set('display_errors',0);

// Database

//PRD
$jenis_db = 'mysql';
$host = '10.140.1.13'; // PRD
$username = 'vms';
$password = 'Vms-ECI2023!';
$database = 'vms_db';

//QAS
// $jenis_db = 'mysql';
// $host = '10.101.0.8';
// $username = 'root';
// $password = 'Admin2021!';
// $database = 'vms_db';

try {
    $db = new PDO($jenis_db . ":host=" . $host . ";dbname=" . $database, $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}
