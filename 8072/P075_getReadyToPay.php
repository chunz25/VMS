<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

$urlAPI = $configUrlAPI["P075"];
$tahun_ini = date("Y");
$db1->exec("DELETE FROM vms_db.sap_ready_to_pay");

$dataPOST = array(
	"company_code" => "EC01",
	"year" => "",
	// "year" => $tahun_ini,
	"accounting_no" => "",
	"document_date" => ""
);

$folder = __DIR__ . "/data/in/";
$file_in_name = $folder . "RTP" . "_" . date("Ymd") . ".json";

include "config/koneksiCURL.php";
$dataResult = $responseData["data"];

$insertValues = [];
$placeholders = [];
foreach ($dataResult as $value1) {
	$value1["document_date"] = setNull($value1["document_date"]);
	$value1["supplier_code"] = trim($value1["supplier_code"]);
	$value1["posting_date"] = setNull($value1["posting_date"]);
	$value1["due_date"] = setNull($value1["due_date"]);
	$value1["payment_date"] = setNull($value1["payment_date"]);
	$value1["amount"] = setNol($value1["amount"]);

	$fields = array_values($value1);
	$insertValues = array_merge($insertValues, $fields);
	$placeholders[] = "(" . rtrim(str_repeat("?,", count($fields)), ",") . ", CURRENT_TIMESTAMP())";
}

if (!empty($placeholders)) {
	$sqlInsert = "
        INSERT INTO vms_db.sap_ready_to_pay (
            typ, goods_receive_no, accounting_no, invoice_no, purchase_order_no, reference_no,
            company_code, store_code, supplier_code, document_date, posting_date, due_date,
            payment_date, status, amount, insert_date
        ) VALUES " . implode(", ", $placeholders);

	try {
		$db1->beginTransaction();
		$stmt = $db1->prepare($sqlInsert);
		$stmt->execute($insertValues);
		$db1->commit();
	} catch (PDOException $e) {
		$db1->rollBack();
		echo "Bulk Insert Error: " . $e->getMessage();
	}
}

$db1->exec("CALL vms_db.update_nama_sp()");

$db1 = null;
include "include/selesai.php";
