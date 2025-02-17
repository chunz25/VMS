<?php

//require_once("maintestis.php");die;
//ini_set('display_errors',0);
//echo session_status();
session_start();
//1. adddress file ------------
$address_file_configs = "";
$address_file_www = "";
$limitTimeProcess = 0;
// include_once ("_log/cekTimeProcess.php");

$cek_param_main = array_key_exists("main", $_REQUEST);
$cek_param_username = array_key_exists("username", $_SESSION);
$message_login = array_key_exists("message_denied", $_REQUEST) ? $_REQUEST["message_denied"] : "";

//var_dump($_REQUEST);
//die($cek_param_main);


if ($cek_param_main) {

	if ((!$cek_param_username) && $_REQUEST["main"] != '020') {
		$message_denied = "Session Expired , Please .....";
		header("Location: https://" . $_SERVER["HTTP_HOST"] . "/index.php?message_denied=" . urlencode($message_denied));
	}
	//die($cek_param_main);
}



if ($cek_param_main) {
	$gg_main = $_REQUEST['main'];
	if (array_key_exists("main_id", $_REQUEST)) {
		$gg_main_id = $_REQUEST['main_id'];
	} else {
		$gg_main_id = "";
	};

	if (array_key_exists("main_tab", $_REQUEST)) {
		$gg_main_tab = $_REQUEST['main_tab'];
	} else {
		$gg_main_tab = "";
	};

	if (array_key_exists("main_act", $_REQUEST)) {
		$gg_main_act = $_REQUEST['main_act'];
	} else {
		$gg_main_act = "";
	};
} else // ini default --- halaman login ----------------------------------------------
{

	$gg_main = "010";
	$gg_main_id = "";
	$gg_main_tab = "";
}
//1. main cofigs load ------------------
require_once($address_file_configs . "main__configs.php");
//2. koneksi database load --------------
require_once($address_file_configs . "_lib/dbconn_new.php");
// $db->debug=true;
//3. load main_controller ---------------
include $address_file_configs . "main__controller.php";
