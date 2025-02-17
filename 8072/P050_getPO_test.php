<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/po?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/po?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/vms/po?sap-client=130";
$urlAPI = $configUrlAPI["P050"];

// Jika butuh parameter dinamis ----------------F
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

	// Body message -------------------------------------------
	$supp = "
	SELECT * FROM vms_db.vw_supplier
	";
	$supp = $db1->query($supp);
	// var_dump($supp);die;
	$no = 0;
	while ($a = $supp->fetch(PDO::FETCH_OBJ)) {
		$sup = $a->supplier_code;
		// var_dump($sup);die;
		$dataPOST = array(
			"purchase_order_no" => "",
			"supplier_code" => $sup,
			"document_date" => $tanggal
		);

		// mundur 1 hari
		date_modify($datexx, '-1 day');

		// save JSON File
		$folder = __DIR__ . "/data/in/";
		$file_in_name = $folder . "PO_" . "_" . $tanggal . "_" . date("Ymd") . ".json";

		include "config/koneksiCURL.php";
		$dataResult = $responseData["header"];
		// $no++;

		$sqlInsert2 = "
	insert
	into
		vms_gateway.purchase_order_stg
	(
		purchase_order_no,
		company_code,
		store_code,
		supplier_code,
		document_date,
		delivery_date,
		order_type,
		category_code,
		category_sub_code,
		total_quantity,
		total_amount,
		total_vat_amount,
		grand_total,
		departement_code,
		departement_desc,
		expired_date_po,
		header_text,
		pk_header
	)
	values
	(	
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?
	);
";

		// eksekusi insert ---
		foreach ($dataResult as $key1 => $value1) {
			try {
				$dataResult2 = $value1["item"];
				unset($value1["item"]);

				// initial data header -----
				$value1["category_code"] = setNol($value1["departement_code"]);
				$value1["total_quantity"] = setNol($value1["total_quantity"]);
				$value1["total_amount"] = setNol($value1["total_amount"]);
				$value1["total_vat_amount"] = setNol($value1["total_vat_amount"]);
				$value1["grand_total"] = setNol($value1["grand_total"]);
				$value1["pk_header"] = $value1["purchase_order_no"];

				if ($value1["total_amount"] > 0 && trim($value1["company_code"]) == 'EC01') {
					// insert to db -----
					$insert2 = $db1->prepare($sqlInsert2);
					try {
						$insert2->execute(array_values($value1));
					} catch (PDOException $e) {
						print "Error! : purchase_order " . $e->getMessage() . "<br/> \n";
					}
				}
			} catch (PDOException $e) {
				// do something here
				print "Error! : purchase_order " . $e->getMessage() . "<br/> \n";
			}
		}

		unset($insert2);
		unset($dataResult);
		unset($dataResult2);
		unset($value1);
		unset($key1);
		echo "$tanggal Rows done .... \n";
	}
}
unset($db1);
include "include/selesai.php";
