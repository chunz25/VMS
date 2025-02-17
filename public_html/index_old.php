<?php

//1. main cofigs load ------------------
require_once($address_file_configs . "main__configs.php");
//2. koneksi database load --------------
require_once($address_file_configs . "_lib/dbconn_new.php");
// $db->debug=true;
//3. load main_controller ---------------
include $address_file_configs . "main__controller.php";

$sql = "select * from tb_user limit 10";
$sql = $db->Execute($sql);
var_dump($sql);die;
