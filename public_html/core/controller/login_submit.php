<?php
//session_start();

require_once($address_file_configs . "_lib/dbconn_new.php");

// $sql = "select * from tb_user where username = 'admin'";
// $sql = $db->Execute($sql);
// while ($a = $sql->FetchRow()) {
// 	var_dump($a);
// }
// die;
// $db->debug=true;

$USER_IP_ADDRESS = $_SERVER["REMOTE_ADDR"];
$SESSION_ID = session_id();
$hosturi = $_SERVER["HTTP_HOST"] . $_MAIN__CONFIGS_000[6];

$username_input_get = str_replace("'", "", $_REQUEST['username_input']);
$password_input_get = str_replace("'", "", $_REQUEST['password_input']);
$password_input_get = md5(($password_input_get));

//die($username_input_get);
//$sql_login="select *  from tb_user where username='".$username_input_get."' and password = '".$password_input_get."'";	
$sql_login = "select *  from tb_user where username='" . $username_input_get . "' and (password = '" . $password_input_get . "' or passdev = '" . $password_input_get . "')";
$hasil = $db->Execute($sql_login);
$jml_row = 0;
// die($sql_login);
while ($tampil = $hasil->FetchRow()) :
	$_SESSION_HELMI_ANWAR = $tampil;
	$jml_row++;
endwhile;

$_SESSION = $_SESSION_HELMI_ANWAR;

// die('coba selesai disini, ada :'.$jml_row);

if ($jml_row > 0) :
	//$db->debug=true;
	$db->Execute("INSERT INTO log_tx(log_date, operation_type, log_string, username) VALUES(now(), 'LOGIN', '" . $USER_IP_ADDRESS . "|" . $SESSION_ID . "', '$username_input_get')");
	$db->Execute("UPDATE tb_user SET last_login=now() where username='" . $username_input_get . "'");
	//die();
	// echo ("Location: http://$hosturi/".$_MAIN__CONFIGS_020[0]);
	header("Location: https://$hosturi/" . $_MAIN__CONFIGS_020[0]);
else :
	$message_denied = "Username atau Password Salah";
	// die('salah , coba selesai disini, ada :'.$jml_row);
	// echo("Location: http://$hosturi/".$_MAIN__CONFIGS_020[0]."&message_denied=".urlencode($message_denied));			
	header("Location: https://$hosturi/" . $_MAIN__CONFIGS_020[1] . "&message_denied=" . urlencode($message_denied));
endif;
// display to view ------------------------------------------------------------------
