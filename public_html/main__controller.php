<?php
// session_start();

/* -------------------------------------------------------------------------------
kode halaman aplikasi :

1. halaman login					---------> 010
2. validasi user					---------> 020
3. halaman awal setelah login 		---------> 030
	31.halaman dashboard			---------> 031
	32.halaman refresh session		---------> 032
4. halaman menu						---------> 040 ---- ini yang bertingkat banyak
5. logout							---------> 050
99. under development / construction --------> 099
----------------------------------------------------------------------------------*/

$cek_param_main = array_key_exists("main", $_REQUEST);

if ($cek_param_main) {

	//$gg_main=$_REQUEST['main'];
	//$gg_main_id=$_REQUEST['main_id'];
	//$gg_main_tab=$_REQUEST['main_tab'];
	//$gg_main_act=$_REQUEST['main_act'];

	//die($gg_main);

	if ($gg_main == "010") // halaman login ------------------------------------------------
	{
		// echo("core/controller/login_form.php");
		include_once "core/controller/login_form.php";
	} else if ($gg_main == "020") // validasi user / login submit --------------------------------------------
	{
		// die('disini');
		 $db = initdb(2);
		include_once "core/controller/login_submit.php";
	} else if ($gg_main == "030") // halaman awal setelah login -------------------------------
	{

		// jika configs menu menggunakan excel/xlsx ------------------------------
		if ($_MAIN__CONFIGS_040[0] == 'xlsx') {


			if (is_file($address_file_configs . "_configs/xls_configs/modul.xlsx")) {
				include $address_file_configs . '_third_party/PHPExcel/PHPExcel/IOFactory.php';
				$inputFileName = $address_file_configs . '_configs/xls_configs/modul.xlsx';
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetNames = $objPHPExcel->getSheetNames();
				foreach ($sheetNames as $sheetIndex => $sheetName) {
					$sheetData[$sheetName] = $objPHPExcel->getSheetByName($sheetName)->toArray(null, true, true, true);
					if ($sheetName == "000000") {
						$_CONFIGS_MODUL = $sheetData["000000"];
					} else {
						$_CONFIGS_MENU[$sheetName] = $sheetData[$sheetName];
					}
				}

			}
		}
		// jika menggunakan tabel database (db) --------------------------
		if ($_MAIN__CONFIGS_040[0] == 'db') {
			$db = initdb(2);

			$sql_menu_submenu = "select * from menu_v where submenu_status=1 and ta_modul_id=4 and tb_user_group_id=" . $_SESSION['tb_group_user_id'] . " order by modul_seq,menu_seq,submenu_seq";

			$hasil_menu_submenu = $db->Execute($sql_menu_submenu);

			while ($tampil_menu_submenu = $hasil_menu_submenu->FetchRow()) :
				$id_modul = $tampil_menu_submenu['ta_modul_id'];
				$id_menu = $tampil_menu_submenu['ta_menu_id'];
				$id_submenu = $tampil_menu_submenu['ta_submenu_id'];
				$nm_modul = $tampil_menu_submenu['modul_nm'];
				$nm_menu = $tampil_menu_submenu['menu_nm'];
				$nm_submenu = $tampil_menu_submenu['submenu_nm'];
				$_CONFIGS_MODUL[$id_modul] = $nm_modul;
				$_CONFIGS_MENU[$id_modul][$id_menu] = $nm_menu;
				$_CONFIGS_SUBMENU[$id_modul][$id_menu][$id_submenu] = $nm_submenu;
			endwhile;

		}
		include_once $_MAIN__CONFIGS_000[2] . "login_sukses.php";
		// include_once "main_030_00.php";
	} else if ($gg_main == "031") // dashboard -------------------------------
	{
		$db = initdb(1);
		include_once "main_031_00.php";
	} else if ($gg_main == "032") // refresh session -------------------------------
	{
		$db = initdb(1);
		include_once "main_032_00.php";
	} else if ($gg_main == "040") // halaman menu --------------------------------------------
	{
		$db = initdb(1);
		// include_once ("_log/cekTimeProcess.php");
		// $cekTimeProcessNya=new cekTimeProcess("",3,__FILE__);

		if ($gg_main_tab == "") {
			$gg_main_tab = "00";
		}
		//die($gg_main_id.'_configs.php');
		if (is_file($_MAIN__CONFIGS_000[4] . $gg_main_id . '.php')) {
			if (class_exists('cekTimeProcess')) {
				$cekTimeProcessNya = new cekTimeProcess("", $limitTimeProcess, __FILE__, $_SESSION["username"], $_MAIN__CONFIGS_000[4] . $gg_main_id . '.php');
				// sleep(1);
			}
			include $_MAIN__CONFIGS_000[4] . $gg_main_id . '.php';
		} else {
			//echo "Under Development";
			//die("main_099_00.php");
			include_once $_MAIN__CONFIGS_000[2] . "under_development.php";
			//include_once "main_099_00.php";
		}
	} else if ($gg_main == "050") // logout --------------------------------------------------
	{
		include_once $_MAIN__CONFIGS_000[2] . "logout.php";
	} else if ($gg_main == "060") // Report --------------------------------------------------
	{
		include_once "main_060_00.php";
	} else if ($gg_main == "098") // get data list  --------------------------------------------------
	{
		include $gg_main_id . '_configs.php';
		include_once "main_098_00.php";
	} else if ($gg_main == "099") // logout --------------------------------------------------
	{
		include_once "main_099_00.php";
	}
} else // ini default --- halaman login ----------------------------------------------
{
	$gg_main = "010";
	include_once "core/controller/login_form.php";
}
