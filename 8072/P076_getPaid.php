<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

$urlAPI = $configUrlAPI["P076"];

$tahun_ini = date("Y");

// message in body ----------------------------------------------
$dataPOST = array(
	"year" => $tahun_ini,
	"accounting_no" => ""
);
// Save JSON File ------------------------------------------------
$folder = __DIR__ . "/data/in/";
$file_in_name = $folder . "RTP" . "_" . date("Ymd") . ".json";

include "config/koneksiCURL.php";
$dataResult = $responseData["data"];

// $db1->exec("delete from vms_db.sap_ready_to_pay");

$sqlInsert = "INSERT INTO vms_db.sap_paid (typ, goods_receive_no, accounting_no, invoice_no, purchase_order_no, reference_no, company_code, store_code,supplier_code, document_date, posting_date, due_date, payment_date, status, amount, insert_date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,current_timestamp());
";

$sqlUpdate = "UPDATE vms_db.invoice_receipt SET payment_date=? WHERE rs_no_sap=? and supplier_code=?";
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

		$value2["payment_date"] = setNull($value1["payment_date"]);
		$value2["rs_no_sap"] = setNull($value1["reference_no"]);
		$value2["supplier_code"] = trim($value1["supplier_code"]);
		$Update = $db1->prepare($sqlUpdate);
		$Update->execute(array_values($value2));
	} catch (PDOException $e) {
		print "Err \t Paid \t no : \t " . $insertValue[0] . " \t " . $e->getMessage() . "\n";
	}
}

// masukkan ke vms_db ---------------------------------------------------	

$insert = null;
$db1 = null;
// echo "$key1 Rows done .... ";
/**/
// include "config/insertDB.php";
// var_dump($dataResult);
include "include/selesai.php";
