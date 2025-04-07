<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan
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
	SELECT supp as supplier_code, nopo FROM vms_db.stg_pomandek
	";
	$supp = $db1->query($supp);
	// var_dump($supp);die;
	while ($a = $supp->fetch(PDO::FETCH_OBJ)) {
		$sup = $a->supplier_code;
		$nopo = $a->nopo;
		// var_dump($sup);die;
		$dataPOST = array(
			"purchase_order_no" => $nopo,
			"supplier_code" => $sup,
			"release_date" => ""
		);

		// save JSON File
		$folder = __DIR__ . "/data/in/";
		$file_in_name = $folder . "PO_" . "_" . $tanggal . "_" . date("Ymd") . ".json";

		// var_dump($dataPOST);
		// die;
		include "config/koneksiCURL.php";

		$dataResult = $responseData["header"];
		// $no++;
		// die(var_dump($dataResult));

		$sqlInsert = "
				insert
				into
					vms_gateway.purchase_order
				(
					purchase_order_no,
					company_code,
					store_code,
					supplier_code,
					document_date,
					delivery_date,
					release_date,
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
					?,
					?
				)
				";

		$sqlInsertDetail = "
				insert
				into
					vms_gateway.purchase_order_item
				(
					purchase_order_no,
					line_item,
					category_code,
					category_sub_code,
					product_code,
					barcode,
					description,
					uom,
					conversion_value,
					unit,
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
					expired_po_item,
					delivery_date_item,
					deletion_ind		
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
					?,
					?
				)
				";

		// eksekusi insert ---
		foreach ($dataResult as $key1 => $value1) {
			try {
				$dataResult2 = $value1["item"];
				unset($value1["item"]);
				// var_dump($value1);
				// initial data header -----
				$value1["category_code"] = setNol($value1["departement_code"]);
				$value1["total_quantity"] = setNol($value1["total_quantity"]);
				$value1["total_amount"] = setNol($value1["total_amount"]);
				$value1["total_vat_amount"] = setNol($value1["total_vat_amount"]);
				$value1["grand_total"] = setNol($value1["grand_total"]);
				$value1["pk_header"] = $value1["purchase_order_no"];

				if (trim($value1["company_code"]) == 'EC01') {
				// if ($value1["total_amount"] > 0 && trim($value1["company_code"]) == 'EC01') {
					// insert to db -----

					$insert = $db1->prepare($sqlInsert);
					try {
						$insert->execute(array_values($value1));
					} catch (PDOException $e) {
						print "Error! : purchase_order " . $e->getMessage() . "<br/> \n";
					}


					// detail item -------
					foreach ($dataResult2 as $key2 => $value2) {
						try {
							// initial data item -----------------------------------------------
							$value2["category_code"] = setNol($value2["departement_code"]);
							$value2["uom"] = setNol($value2["uom"]);
							$value2["conversion_value"] = setNol($value2["conversion_value"]);
							$value2["unit_price"] = setNol($value2["unit_price"]);
							$value2["quantity"] = setNol($value2["quantity"]);
							$value2["amount"] = setNol($value2["amount"]);
							$value2["tax_pct"] = setNol($value2["tax_pct"]);
							$value2["vat_amount"] = setNol($value2["vat_amount"]);
							$value2["amount_after_tax"] = setNol($value2["amount_after_tax"]);
							// insert to db ----------------------------------------------------
							if (strtoupper($value2["deletion_ind"]) != 'L') {
								$insert2 = $db1->prepare($sqlInsertDetail);
								$insert2->execute(array_values($value2));
							}
						} catch (PDOException $e) {
							print "Error!: purchase_order_item " . $e->getMessage() . "<br/>\n";
						}
					}
				}
			} catch (PDOException $e) {
				// do something here
				print "Error! : purchase_order " . $e->getMessage() . "<br/> \n";
			}
		}
	}
	date_modify($datexx, '-1 day');
	unset($insert);
	unset($insert2);
	unset($dataResult);
	unset($dataResult2);
	unset($value1);
	unset($value2);
	unset($key1);
	unset($key2);
	echo "$tanggal Rows done .... \n";
}

try {
	$sqlToVmsDb = "call vms_db.insert_purchase_order_sp()";
	$statement 	= $db1->prepare($sqlToVmsDb);
	$statement->execute();
} catch (PDOException $e) {
	print "Error!: $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
}
unset($db1);
include "include/selesai.php";
