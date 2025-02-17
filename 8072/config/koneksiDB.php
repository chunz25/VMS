<?php
// connect to database

try {
	//$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	// echo ($jenis_db[1].":host=".$host[1].";dbname=".$database[1].", $username[1], $password[1]");
	$db1 = new PDO($jenis_db[1] . ":host=" . $host[1] . ";dbname=" . $database[1], $username[1], $password[1]);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	// die();
}

function setNol($param1)
{
	$hasil = ($param1 == "" || $param1 == NULL) ? 0 : $param1;
	return $hasil;
}
function setNull($param1)
{
	$hasil = ($param1 == "" || $param1 == 0) ? null : $param1;
	return $hasil;
}
