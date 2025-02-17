<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

$urlAPI = $configUrlAPI["P075"];

$tahun_ini = date("Y");
$tgl = "
	SELECT DISTINCT document_date FROM vms_db.purchase_order
	";
$tgl = $db1->query($tgl);

$db1->exec("delete from vms_gateway.sap_ready_to_pay");

while ($a = $tgl->fetch(PDO::FETCH_OBJ)) {
	// var_dump($a->document_date);
	// message in body ----------------------------------------------
	$dataPOST = array(
		"company_code" => "EC01",
		"year" => $tahun_ini,
		"accounting_no" => "",
		"document_date" => $a->document_date
	);
	var_dump($dataPOST);
// 	// Save JSON File ------------------------------------------------
	// $folder = __DIR__ . "/data/in/";
	// $file_in_name = $folder . "RTP" . "_" . date("Ymd") . ".json";

	// include "config/koneksiCURL.php";
	// $dataResult = $responseData["data"];

	// $sqlInsert = "INSERT INTO vms_gateway.sap_ready_to_pay (typ, goods_receive_no, accounting_no, invoice_no, purchase_order_no, reference_no, company_code, store_code,supplier_code, document_date, posting_date, due_date, payment_date, status, amount, insert_date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,current_timestamp());";
// 	// eksekusi insert ---
// 	foreach ($dataResult as $key1 => $value1) {
// 		try {
// 			$value1["document_date"] = setNull($value1["document_date"]);
// 			$value1["supplier_code"] = trim($value1["supplier_code"]);
// 			$value1["posting_date"] = setNull($value1["posting_date"]);
// 			$value1["due_date"] = setNull($value1["due_date"]);
// 			$value1["payment_date"] = setNull($value1["payment_date"]);
// 			$value1["amount"] = setNol($value1["amount"]);
// 			$insert = $db1->prepare($sqlInsert);
// 			$insertValue = array_values($value1);
// 			$insert->execute(array_values($value1));
// 		} catch (PDOException $e) {
// 			print "Err \t readyTOPay \t no : \t " . $insertValue[0] . " \t " . $e->getMessage() . "\n";
// 		}
// 	}

// 	// masukkan ke vms_db ---------------------------------------------------	
// 	$db1->exec("call vms_db.update_nama_sp()");
}
// die;

// $db1->exec("call vms_db.sp_insertreadytopay()");
$insert = null;
$db1 = null;
include "include/selesai.php";
