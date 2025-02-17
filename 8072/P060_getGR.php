<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan -----------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/gr?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/gr?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/vms/gr?sap-client=130";
$urlAPI = $configUrlAPI["P060"];


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

	$supp = "
	SELECT * FROM vms_db.vw_supplier
	";
	$supp = $db1->query($supp);
	// var_dump($supp);die;
	$no = 0;
	while ($a = $supp->fetch(PDO::FETCH_OBJ)) {
		$sup = $a->supplier_code;
		// message body -----------------------------------------------------
		$dataPOST = array(
			"goods_receive_no" => "",
			"year" => $tahun,
			"supplier_code" => $sup,
			"posting_date" => $tanggal,
			"purchase_order_no" => "",
			"status_cancel" => ""
		);

		// save JSON File ----------------------------------------------------
		$folder = __DIR__ . "/data/in/";
		$file_in_name = $folder . "GR_" . $tanggal . "_" . date("Ymd") . ".json";

		include "config/koneksiCURL.php";
		$dataResult = $responseData["header"];

		$sqlInsert = "
				insert
				into
					vms_gateway.goods_receive
				(
					purchase_order_no,
					goods_receive_no,
					company_code,
					store_code,
					supplier_code,
					document_date,
					trade_type,
					total_quantity,
					total_amount,
					vat_amount,
					grand_total,
					departement_code,
					departement_desc
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
					?
				)
				";

		$sqlInsertDetail = "
				insert
				into
					vms_gateway.goods_receive_item
				(
					goods_receive_no,
					line_item,
					product_code,
					barcode,
					description,
					uom,
					unit,
					conversion_value,
					po_quantity,
					quantity,
					unit_price,
					amount,
					tax_pct,
					vat_amount,
					amount_after_tax,
					departement_code_item,
					departement_desc_item,
					store_code_item,
					store_desc_item,
					status_cancel,
					delivery_no,
					delivery_item
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
					?,
					?,
					?,
					?,
					?
				)
				";

		// eksekusi insert -----------------------------------------------------------
		foreach ($dataResult as $key1 => $value1) {
			try {
				$dataResult2 = $value1["item"];
				unset($value1["item"]);

				$value1["total_quantity"] = setNol($value1["total_quantity"]);
				$value1["total_amount"] = setNol($value1["total_amount"]);
				$value1["vat_amount"] = setNol($value1["vat_amount"]);
				$value1["grand_total"] = setNol($value1["grand_total"]);

				$valueDelete["goods_receive_no"] = $value1["goods_receive_no"];
				$valueDelete["purchase_order_no"] = $value1["purchase_order_no"];
				$valueDelete["departement_code"] = $value1["departement_code"];

				// $delete1=$db1->prepare($sqlDelete);
				// $delete1->execute(array_values($valueDelete));

				$insert = $db1->prepare($sqlInsert);
				try {
					$insert->execute(array_values($value1));
					// $insertValue=array_values($value1);
				} catch (PDOException $e) {
					// do something here
					print "Err \t goods_receive \t no : \t " . $value1["goods_receive_no"] . " \t " . $e->getMessage() . "\n";
				}

				if ($value1["total_amount"] > 0 && trim($value1["company_code"]) == 'EC01') {

					foreach ($dataResult2 as $key2 => $value2) {
						try {
							$value2["uom"] = setNol($value2["uom"]);
							$value2["conversion_value"] = setNol($value2["conversion_value"]);
							$value2["unit_price"] = setNol($value2["unit_price"]);
							$value2["quantity"] = setNol($value2["quantity"]);
							$value2["po_quantity"] = setNol($value2["po_quantity"]);
							$value2["amount"] = setNol($value2["amount"]);
							$value2["tax_pct"] = setNol($value2["tax_pct"]);
							$value2["vat_amount"] = setNol($value2["vat_amount"]);
							$value2["amount_after_tax"] = setNol($value2["amount_after_tax"]);
							$insert2 = $db1->prepare($sqlInsertDetail);
							$insert2->execute(array_values($value2));
							// $insertValue2=array_values($value2);
						} catch (PDOException $e) {
							print "Err \t goods_receive_item \t no : \t " . $value1["goods_receive_no"] . " \t " . $value2["product_code"] . " \t " . $e->getMessage() . "\n";
						}
					}
				}
			} catch (PDOException $e) {
				// do something here
				print "Err \t goods_receive \t no : \t " . $value1["goods_receive_no"] . " \t " . $e->getMessage() . "\n";
			}
		}
	}

	// hitung mundur 1 hari ----------------------------------------------
	date_modify($datexx, '-1 day');
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

try {
	$sqlToVmsDb = "call vms_db.insert_goods_receive_sp()";
	$statement 	= $db1->prepare($sqlToVmsDb);
	$statement->execute();
} catch (PDOException $e) {
	print "Err : $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
}
unset($db1);
include "include/selesai.php";
