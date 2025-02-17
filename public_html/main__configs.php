<?php
// 000. kode aplikasi dan global setting -----------------------------------------------
// kode aplikasi

$_MAIN__CONFIGS_000[0] = "B2B";										// APP 
$_MAIN__CONFIGS_000[1] = "adminlte";								// THEMES 
$_MAIN__CONFIGS_000[2] = "core/controller/";						// folder core controller
$_MAIN__CONFIGS_000[3] = "core/view/" . $_MAIN__CONFIGS_000[1] . "/";	// folder core view
$_MAIN__CONFIGS_000[4] = "app/controller/";							// folder app controller
$_MAIN__CONFIGS_000[5] = "app/view/" . $_MAIN__CONFIGS_000[1] . "/";	// folder app view
$_MAIN__CONFIGS_000[6] = "";										// folder app view

// 010. halaman login		----------------------------------------------------------------------------------

$_MAIN__CONFIGS_010[0] = "(DEV) VMS ELECTRONIC CITY";	// judul di head
$_MAIN__CONFIGS_010[1] = "(DEV) ECI Vendor MAnagement System";		// judul di div kotak login
$_MAIN__CONFIGS_010[2] = "020";									// action form ke url
$_MAIN__CONFIGS_010[3] = "(DEV) ELECTRONIC CITY VMS";	// Title on browser
$_MAIN__CONFIGS_010[4] = "vmsdev.electronic-city.biz";			// Title login box
$_MAIN__CONFIGS_010[5] = "username, example : 900XXXXX";		// default placeholder username
$_MAIN__CONFIGS_010[6] = "Password";							// default placeholder password
$_MAIN__CONFIGS_010[7] = "_assets/_images/logo1.png";			// logo app
$_MAIN__CONFIGS_010[8] = "adminlte";							// themes "adminor","onepage","gentelella","architect"
$_MAIN__CONFIGS_010[9] = "skin-yellow-light fixed";				// warna themes 

// 020. authentikasi user / cek login -------------------------------------------------------------------

$_MAIN__CONFIGS_020[0] = "index.php?main=030";					// url jika validasi user benar
$_MAIN__CONFIGS_020[1] = "index.php?main=010";					// url jika validasi user salah
$hosturi = $_SERVER["HTTP_HOST"] . $_MAIN__CONFIGS_000[6];

// 030. halaman awal setelah login (main_030.php)------------------------------------------------------------

$_MAIN__CONFIGS_030[0] = "index.php?main=010";					// url logout
$_MAIN__CONFIGS_030[1] = "index.php?main=031";					// url home
$_MAIN__CONFIGS_030[2] = "ELECTRONIC CITY VMS Information System";		// judul
$_MAIN__CONFIGS_030[3] = "db";								// menu dari file excel atau database

//$_MAIN__CONFIGS_030[4]  = '"/home/helmi/java/db2json/configs2.properties"'; // configs for exec jar file 
//$_MAIN__CONFIGS_030[5] = 'java -jar "/home/helmi/java/db2json/db2json.jar" -f '.$_MAIN__CONFIGS_030[4];

//$_MAIN__CONFIGS_030[4]  = '"'.getcwd().'/_exec/db2json/configs2.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_030[4]  = '"' . getcwd() . '/_exec/db2json/configs.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_030[5] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2json/db2json.jar"' . ' -f ' . $_MAIN__CONFIGS_030[4];

$_MAIN__CONFIGS_030[6]  = '"' . getcwd() . '/_exec/db2json/configs2.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_030[7] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2json/db2json.jar"' . ' -f ' . $_MAIN__CONFIGS_030[6];

$_MAIN__CONFIGS_030[8]  = '"' . getcwd() . '/_exec/db2json/configs3.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_030[9] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2json/db2json.jar"' . ' -f ' . $_MAIN__CONFIGS_030[8];
$_MAIN__CONFIGS_030[10] = "_assets/_images/logo4.png";

$_MAIN__CONFIGS_030[11]  = '"' . getcwd() . '/_exec/db2json/configs3.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_030[12] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2json/db2json.jar"' . ' -f ' . $_MAIN__CONFIGS_030[8];

// java exec cek pdf DJP

$_MAIN__CONFIGS_030[13] = 'java -jar ' . '"_exec/pdf1/pdf1.jar"' . " -i ";

// Folder Upload File
$_MAIN__CONFIGS_030[30] = '_docs/';

// 031. Dashboard ------------------------------------------------------------------------------------------

// put here to configs this page

// 032. halaman awal refresh session (main_032.php)---------------------------------------------------------

// put here to configs this page


// 040. halaman menu	---------------------------------------------------------------------------------------


//$_MAIN__CONFIGS_040[0] = "xlsx";				// jenis file configs, default php		
$_MAIN__CONFIGS_040[0] = "db";					// jenis file configs, default php		
$_MAIN__CONFIGS_040[1] = $gg_main_id;			// $itemnya
$_MAIN__CONFIGS_040[2] = 'index.php?main=' . $gg_main . '&main_id=' . $gg_main_id . '&main_tab=' . $gg_main_tab;	//$urlnya
$_MAIN__CONFIGS_040[3] = 20;												// $row_default
$_MAIN__CONFIGS_040[4] = "PT. ELECTRONIC CITY";												// $row_default
$_MAIN__CONFIGS_040[5] = "
							Jl. Jend. Sudirman Kav. 52-53<br>, 
							SCBD Lot. 22 Jakarta Selatan 12190
						";												// $row_default

// $_MAIN__CONFIGS_040[910] = "/home/vms/webFile";		// folder pdf PO 
$_MAIN__CONFIGS_040[910] = "/home/vmsdev/public_html/_docs";		// folder pdf PO 
$_MAIN__CONFIGS_040[911] = $_MAIN__CONFIGS_040[910] . "/PO";		// folder pdf PO 
$_MAIN__CONFIGS_040[912] = $_MAIN__CONFIGS_040[910] . "/GR";		// folder pdf RN / GRN
$_MAIN__CONFIGS_040[912] = "/home/vmsdev/public_html/_docs/GR";		// folder pdf GRN 
$_MAIN__CONFIGS_040[913] = "";		// folder pdf PFI 
$_MAIN__CONFIGS_040[914] = "";		// folder pdf INV 
$_MAIN__CONFIGS_040[915] = "";		// folder pdf INVR



// 050. Logout	(main_050.php)----------------------------------------------------------------------------
$_MAIN__CONFIGS_050[0] = "index.php?main=010";							// $url_logout


// 060. REPORT TO EXCEL ----------------------------------------------------------------------------------
$_MAIN__CONFIGS_060[1]  = '"' . getcwd() . '/_exec/db2xls/configsxls1.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_060[2] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2xls/db2xls.jar"' . ' -f ' . $_MAIN__CONFIGS_060[1];

$_MAIN__CONFIGS_060[3]  = '"' . getcwd() . '/_exec/db2xls/configsxls2.properties"'; // configs for exec jar file 
$_MAIN__CONFIGS_060[4] 	= 'java -jar ' . '"' . getcwd() . '/_exec/db2xls/db2xls.jar"' . ' -f ' . $_MAIN__CONFIGS_060[3];

// 090. Under development	---------------------------------------------------------------------------------------

$gg_message_line_1 = "Under Development";
$gg_message_line_2 = "Still Progress";
//die($gg_message_line_1);

// tambahan -----------------

$L_month_en = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$L_month = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$L_month_short_en = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$L_month_short = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');

$L_day = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
$L_day_short = array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');
$L_day_en = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$L_day_short_en = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
