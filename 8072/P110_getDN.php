<?php
// ini_set('display_errors',0);
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan -----------------------------------------------------------------------------
// $urlAPI = "http://$serverAPI/sap/ws/vms/dn?sap-client=400";
$urlAPI = $configUrlAPI["P110"];


// Jika butuh parameter dinamis -----------------------------------------------------------
$xx = array_key_exists("1", $argv);
$yy = array_key_exists("2", $argv);
if ($xx) {
	$jml_hari = $argv[1];
} else {
	$jml_hari = 1;
}
if ($yy) {
	$tgl_mulai = $argv[2];
} else {
	$tgl_mulai = date("Y-m-d");
}

$datexx = date_create($tgl_mulai);

for ($i = 1; $i <= $jml_hari; $i++) {
	$tanggal = date_format($datexx, 'Y-m-d');
	$tahun = date_format($datexx, 'Y');

	// message body -----------------------------------------------------
	$dataPOST = array(
		"goods_receive_no" => "",
		"year" => $tahun,
		"supplier_code" => "",
		"posting_date" => $tanggal,
		"purchase_order_no" => ""
	);

	// hitung mundur 1 hari ----------------------------------------------
	date_modify($datexx, '-1 day');

	// save JSON File ----------------------------------------------------
	$folder = __DIR__ . "/data/in/";
	$file_in_name = $folder . "DN_" . $tanggal . "_" . date("Ymd") . ".json";

	include "config/koneksiCURL.php";
	$dataResult = $responseData["header"];

	/* kalau mau tampilin --- */
	$arraySource = $dataResult;
	// print_r($dataResult);
	// include "include/arrayToTabelHTML.php";

	$sqlInsert = "
INSERT INTO 
	vms_gateway.debit_note
	(debit_note_no, company_code, store_code, supplier_code, supplier_name, document_date, due_date, total_amount, tax_reg_no, faktur_pajak_no, tax_id)
VALUES
	(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
";

	$sqlInsertDetail = "
INSERT INTO 
	vms_gateway.debit_note_item
	(line_item, store_code, sub_amt, vat, wht, remark1, remark2, buy_amt, payment_term, posting_date, payment_date, cfm_fg, appro_date, reference_no, bank_name, depositor_name, acc_code, acc_name, acc_no, emp_no, chg_fg, sir_no, apply_rate, apply_start_date, apply_end_date,debit_note_no)
VALUES
	(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

	// eksekusi insert ---
	foreach ($dataResult as $key1 => $value1) {

		try {
			$dataResult2 = $value1["item"];
			// $dataResult2["debit_note_no"]=$value1["debit_note_no"];
			unset($value1["item"]);

			$value1["deduct_fg"] = setNol($value1["deduct_fg"]);
			$value1["total_amount"] = setNol($value1["total_amount"]);

			$value1["document_date"] = setNull($value1["document_date"]);
			$value1["due_date"] = setNull($value1["due_date"]);

			$insert = $db1->prepare($sqlInsert);
			$insert->execute(array_values($value1));

			foreach ($dataResult2 as $key2 => $value2) {
				try {
					// print_r($value2);
					$value2["sub_amt"] = setNol($value2["sub_amt"]);
					$value2["vat"] = setNol($value2["vat"]);
					$value2["wht"] = setNol($value2["wht"]);
					$value2["buy_amt"] = setNol($value2["buy_amt"]);
					$value2["apply_rate"] = setNol($value2["apply_rate"]);

					$value2["posting_date"] = setNull($value2["posting_date"]);
					$value2["payment_date"] = setNull($value2["payment_date"]);
					$value2["appro_date"] = setNull($value2["appro_date"]);
					$value2["apply_start_date"] = setNull($value2["apply_start_date"]);
					$value2["apply_end_date"] = setNull($value2["apply_end_date"]);

					$value2["debit_note_no"] = $value1["debit_note_no"];

					$insert2 = $db1->prepare($sqlInsertDetail);
					$insert2->execute(array_values($value2));
				} catch (PDOException $e) {
					print "Error Insert Item !: " . $e->getMessage() . "<br/>\n";
				}
			}
		} catch (PDOException $e) {
			// do something here
			print "Error! Insert Header : " . $e->getMessage() . "<br/>\n";
		}
	}

	// masukkan ke vms_db ---------------------------------------------------	

	try {
		$sqlToVmsDb = "call vms_db.insert_debit_note_sp()";
		$statement 	= $db1->prepare($sqlToVmsDb);
		$statement->execute();
	} catch (PDOException $e) {
		print "Error!: $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
	}


	echo "$tanggal Rows done .... \n";
	unset($insert);
	unset($insert2);
	unset($dataResult);
	unset($dataResult2);
	unset($value1);
	unset($value2);
	unset($key1);
	unset($key2);
}
unset($db1);

include "include/selesai.php";
