<?php
// configs db connection ------------------------------------------

$dbconn_db_library_conf = "adodb"; // adodb,native,dll
$dbconn_db_configs_file_conf = "php"; // ini, php, xml dll
//-----------------------------------------------------------------
$dbconn_db_library_conf = "adodb";
$address_file_configs = "";


// 1.  include adodb if use it -------------------------------------
if ($dbconn_db_library_conf == "adodb") {
	include_once($address_file_configs . "_third_party/adodb/adodb.inc.php");
}

function koneksi($jenis_db, $host, $username, $password, $database)
{
	// die('cek'."$jenis_db,$host,$username,$password,$database");
	global $ADODB_FETCH_MODE;
	define('ADODB_ASSOC_CASE', 0);

	//var $obj_db;
	$obj_db = ADONewConnection($jenis_db);
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	// $obj_db->debug=true;
	$hasil = $obj_db->Connect($host, $username, $password, $database) or die('error connection xx');
	if ($hasil) {
		$returnnya = $obj_db;
	} else {
		$obj_db = false;
	}
	return $obj_db;
}


function initdb($dbno = 1)
{
	global $_SERVER, $address_file_configs, $dbconn_db_configs_file_conf;
	// die($dbconn_db_configs_file_conf);
	switch ($dbconn_db_configs_file_conf) {
		case "ini":
			$_configs_db_connection = parse_ini_file($address_file_configs . "_configs/ini_configs/db_connect.ini", TRUE);
			//echo $address_file_configs."_configs/ini_configs/db_connect.ini";
			//print_r($_configs_db_connection);									
			$jenis_db[$dbno] = $_configs_db_connection[$dbno]['jenis_db'];
			$host[$dbno] = $_configs_db_connection[$dbno]['host'];
			$username[$dbno] = $_configs_db_connection[$dbno]['username'];
			$password[$dbno] = $_configs_db_connection[$dbno]['password'];
			$database[$dbno] = $_configs_db_connection[$dbno]['database'];
			break;
		case "php":
			// echo ($address_file_configs."_configs/php_config/config_db.php");
			include_once($address_file_configs . "_configs/php_configs/config_db.php");
			// print_r($jenis_db);
			// print_r($host);
			break;
		default:
			include_once($address_file_configs . "_configs/php_configs/config_db.php");
			break;
	}
	return koneksi($jenis_db[$dbno], $host[$dbno], $username[$dbno], $password[$dbno], $database[$dbno]);
}



//die($string_param);

// MODELS --> Database Connection 

//=============================================================================

function selectTable($db, $table = "", $field = "", $condition = "", $output_mode = "1")
{

	if (($table != "") && ($field != "")) {
		$sql = "SELECT $field FROM $table $condition ";
		if ($output_mode == "1") {
			$hasilnya = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode select_table ) from sql = $sql");
		} elseif ($output_mode == "2") {
			$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode select_table ) from sql = $sql");
			$hasilnya = $hasil->GetArray();
		}
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}


//==============================================================================================

function selectSql($db, $sql = "", $output_mode = "1")
{

	if (($sql != "")) {

		if ($output_mode == "1") {
			$hasilnya = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode select_sql ) from sql = $sql");
		} elseif ($output_mode == "2") {
			$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode select_sql ) from sql = $sql");
			$hasilnya = $hasil->GetArray();
		}
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

//==============================================================================================

function selectField($db, $table = "", $field = "", $condition = "")
{

	if (($table != "") && ($field != "")) {
		$sql = "SELECT $field FROM $table $condition ";

		$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode selectField  ) from sql = $sql");

		while ($yy = $hasil->FetchRow()) {
			foreach ($yy as $key => $value) {
				$hasilnya = $value;
			}
		}
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

//==============================================================================================

function selectRow($db, $table = "", $field = "", $condition = "")
{

	if (($table != "") && ($field != "")) {
		$sql = "SELECT $field FROM $table $condition ";

		$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode selectRow  ) from sql = $sql");

		while ($yy = $hasil->FetchRow()) {
			foreach ($yy as $key => $value) {
				$hasilnya[$key] = $value;
			}
		}
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}
//======================================================================================================
function insertTable($db, $table = "", $field = "")
{

	if (($table != "") && ($field != "")) {

		$kosong = $db->Execute("SELECT * FROM $table WHERE 'helmi' is null");
		$executeInsert = $db->GetInsertSQL($kosong, $field);
		$hasilnya = $db->Execute($executeInsert) or die("<br><b>Execute SQL Failed!</b><br>( methode insertTable  ) from sql = $kosong");
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}
// ===================================================================================================

function updateTable($db, $table = "", $field = "", $condition = "")
{

	if (($table != "") && ($field != "")) {

		$sqlUpdate = $db->Execute("SELECT * FROM $table $condition");
		$executeUpdate = $db->GetUpdateSQL($sqlUpdate, $field);
		$hasilnya = $db->Execute($executeUpdate) or die("<br><b>Execute SQL Failed!</b><br>( methode updateTable  ) from sql = $sqlUpdate");
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

// ===================================================================================================

function deleteTable($db, $table = "", $condition = "")
{

	if (($table != "")) {

		$hasilnya = $db->Execute("DELETE FROM $table $condition") or die("<br><b>Execute SQL Failed!</b><br>( methode deleteTable  ) from sql = DELETE FROM $table $condition");
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

// ===================================================================================================

function eksekusiSql($db, $sql)
{

	if (($sql != "")) {

		$hasilnya = $db->Execute($sql);
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

// formListBox ===============================================================

function formListBox($db, $sql = "", $var_name = "helmi", $default_str = '', $moreAttr = '', $blank1stItem = true, $multiple_select = false, $size = 0)
{

	if (($sql != "")) {	//$db->debug=true;				
		$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode formListBox ) from sql = $sql");
		$hasilnya = $hasil->GetMenu2($var_name, $default_str, $blank1stItem, $multiple_select, $size, $moreAttr);
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}


	return $hasilnya;
}

function formListBox2($db, $sql_f, $var_name = "helmi", $default_str = "", $moreAttr = '', $blank1stItem = true, $multiple_select = false, $size = 0)
{

	$res_tabel_f_h = $db->Execute($sql_f) or die("<br><b>Execute SQL Failed!</b><br>( methode formListBox2 ) from sql = $sql");
	//print_r($res_tabel_f_h);
	//die();
	$hanya_pertama = 1;
	?>
	<select name="<?php echo $var_name; ?>">
		<?php
		while ($res_tabel_f = $res_tabel_f_h->FetchRow()) {
			if ($hanya_pertama == 1) {
				$nama_kolom_f = array_keys($res_tabel_f);
				$nama_kolom_pertama = $nama_kolom_f[0];

				if ($nama_kolom_f[1] != "") {
					$nama_kolom_kedua = $nama_kolom_f[1];
				} else {
					$nama_kolom_kedua = $nama_kolom_f[0];
				}
			}
			$hanya_pertama++;



			if ($res_tabel_f[$nama_kolom_pertama] == $default_str) {
				$selected_f = "selected";
			} else {
				$selected_f = "";
			} # end of if odbc_result;
	
			?>
			<option value="<?php echo $res_tabel_f[$nama_kolom_pertama] ?>" <?php echo $selected_f ?>>
				<?php
				echo $res_tabel_f[$nama_kolom_kedua];
				?>
			</option>
		<?php } #end of while odbc_fetch_row;
		?>
	</select>
	<?php
} #end of function formListBox2;

// maxFieldValue ===============================================================

function maxFieldValue($db, $table = "", $field = "", $condition = "")
{

	if (($table != "") && ($field != "")) {
		$sql = "SELECT max($field) as nilai FROM $table $condition ";

		$hasil = $db->Execute($sql) or die("<br><b>Execute SQL Failed!</b><br>( methode selectField  ) from sql = $sql");

		while ($yy = $hasil->FetchRow()) {
			foreach ($yy as $key => $value) {
				$hasilnya = $value;
			}
		}
	} else {
		$hasilnya = "Parameter tidak lengkap !";
	}

	$hasilnya = $hasilnya + 1;
	return $hasilnya;
}

function setNol($param1)
{
	$hasil = ($param1 == "" || $param1 == NULL) ? 0 : $param1;
	return $hasil;
}

include "FunctionData.php";

?>