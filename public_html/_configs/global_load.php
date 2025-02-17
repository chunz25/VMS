<?php
// buat konstanta Root document dan IP address user

//$foldernya_configs='/sample';
set_time_limit(0);

$foldernya_configs='';

if(isset($DOCUMENT_ROOT)):
	define("CONST_ROOT",$DOCUMENT_ROOT.$foldernya_configs);
else:
	define("CONST_ROOT",$_SERVER["DOCUMENT_ROOT"].$foldernya_configs);
endif;

if(isset($REMOTE_ADDR)):
	define("CONST_IP_ADDRESS_USER",$REMOTE_ADDR);
else:
	define("CONST_IP_ADDRESS_USER",$_SERVER["REMOTE_ADDR"]);
endif; 

include CONST_ROOT."/_configs/global.php";

// load file configs database connection 

if($_configs_global_jenis_file=="1")
{
	$_configs_db_connection=parse_ini_file(CONST_ROOT."/_configs/ini_configs/db_connect.ini",TRUE);	

}


// connect database

if($_configs_global_db_conn=="adodb")
{
		require_once(CONST_ROOT."/_db/adodb/adodb.inc.php");
		require_once(CONST_ROOT."/_db/adodb/tohtml.inc.mod1.php");
		$_global_db1=&ADONewConnection($_configs_db_connection[db1][type_nya]);
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;	$_global_db1->Connect($_configs_db_connection[db1][host_nya],$_configs_db_connection[db1][user_nya],$_configs_db_connection[db1][pwd_nya],$_configs_db_connection[db1][name_nya]);

		//require_once(CONST_ROOT."/_lib/function/adodb_/db_class.php");
		//require_once(CONST_ROOT."/_lib/function/adodb_/db_class.php");

}
elseif($_configs_global_db_conn=="ci")
{
}

?>