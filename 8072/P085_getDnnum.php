<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan --------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/zmst/mststore?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/zmst/mststore?sap-client=130';
$urlAPI = $configUrlAPI["P085"];

// Jika butuh parameter dinamis --------------------------------------------------------------
$xx = array_key_exists("d", $_REQUEST);
if ($xx) {
	$d = $_REQUEST["d"];
} else {
	$d = date("Ymd");
}


$sql = "SELECT a.goods_receive_no,year(a.document_date) as year_doc FROM vms_db.invoice_receipt a 
 WHERE (isIntegrated=0 or isIntegrated is null) and confirm_date is not null and dnnum_sap is null";
$xx = $db1->query($sql);


foreach ($xx as $arr) {

	// message in body ----------------------------------------------
	$dataPOST = array(
		"MBLNR" => $arr["goods_receive_no"],
		"MJAHR" => $arr["year_doc"]
	);

	// Save JSON File ------------------------------------------------
	$folder = __DIR__ . "/data/in/";
	$file_in_name = $folder . "DNNUM" . "_" . $d . "_" . date("Ymd") . ".json";

	include "config/koneksiCURL.php";
	$dataResult = $responseData["data"];

	$sqlUpdate = "UPDATE vms_db.invoice_receipt SET dnnum_sap=? where goods_receive_no=?";
	// eksekusi insert ---
	foreach ($dataResult as $key1 => $value1) {
		try {
			$valueUpdate["dnnum"] = $value1["dnnum"];
			$valueUpdate["goods_receive_no"] = $arr["goods_receive_no"];
			$update = $db1->prepare($sqlUpdate);
			// $updateValue=array_values($valueUpdate);
			$update->execute(array_values($valueUpdate));
		} catch (PDOException $e) {
			print "Err \t DNNUM \t no : \t " . $updateValue[0] . " \t " . $e->getMessage() . "\n";
		}
	}
}
$update = null;
$db1 = null;
// echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
