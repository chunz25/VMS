<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

$urlAPI = $configUrlAPI["P075"];
// $xx = array_key_exists("d", $_REQUEST);
$tahun_ini = date("Y");
$db1->exec("delete from vms_db.sap_ready_to_pay");
// $tgl = "	SELECT DISTINCT document_date FROM vms_db.purchase_order ";
// $sql = "SELECT DISTINCT document_date  FROM vms_db.invoice_receipt WHERE rs_no_sap IS NOT NULL AND  payment_date IS NULL";

// message in body ----------------------------------------------
$dataPOST = array(
	"company_code" => "EC01",
	"year" => $tahun_ini,
	"accounting_no" => "",
	"document_date" => ""
);
// Save JSON File ------------------------------------------------
$folder = __DIR__ . "/data/in/";
$file_in_name = $folder . "RTP" . "_" . date("Ymd") . ".json";

include "config/koneksiCURL.php";
$dataResult = $responseData["data"];

// print_r($dataPOST);

$sqlInsert = "
		INSERT 
			INTO vms_db.sap_ready_to_pay (typ, goods_receive_no, accounting_no, invoice_no, purchase_order_no, reference_no, company_code, store_code,supplier_code, document_date, posting_date, due_date, payment_date, status, amount, insert_date) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,current_timestamp());
		";

// eksekusi insert ---
foreach ($dataResult as $key1 => $value1) {
	try {
		$value1["document_date"] = setNull($value1["document_date"]);
		$value1["supplier_code"] = trim($value1["supplier_code"]);
		$value1["posting_date"] = setNull($value1["posting_date"]);
		$value1["due_date"] = setNull($value1["due_date"]);
		$value1["payment_date"] = setNull($value1["payment_date"]);
		$value1["amount"] = setNol($value1["amount"]);
		$insert = $db1->prepare($sqlInsert);
		$insertValue = array_values($value1);
		$insert->execute(array_values($value1));
	} catch (PDOException $e) {
		print "Err \t readyTOPay \t no : \t " . $insertValue[0] . " \t " . $e->getMessage() . "\n";
	}
}

// masukkan ke vms_db ---------------------------------------------------	
$db1->exec("call vms_db.update_nama_sp()");
// echo $sqlInsert."\n";
$insert = null;
$db1 = null;
// echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
