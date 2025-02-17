<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

try {
	// URL tujuan
	$urlAPI = $configUrlAPI["P040"];

	// Determine dynamic parameter
	$d = array_key_exists("d", $_REQUEST) ? $_REQUEST["d"] : "20230710";

	// Fetch top 10 suppliers from the database
	$sqlvendor = 'SELECT code as supplier_code FROM vms_gateway.temp_supplier';
	$stmtVendor = $db1->prepare($sqlvendor);
	$stmtVendor->execute();
	$resultVendors = $stmtVendor->fetchAll(PDO::FETCH_ASSOC);

	if (!$resultVendors) {
		throw new Exception("No supplier codes found.");
	}

	// Begin processing each supplier
	foreach ($resultVendors as $supplier) {
		$supplierCode = $supplier['supplier_code'];

		// Prepare dataPOST with supplier code
		$dataPOST = array(
			"supplier_code" => $supplierCode,
			"company_code" => "EC01"
		);

		// Save JSON File
		$folder = __DIR__ . "/data/in/";
		$file_in_name = $folder . "VND" . "_" . $d . "_" . date("Ymd") . ".json";

		include "config/koneksiCURL.php";

		// Assuming responseData comes from the included koneksiCURL.php
		$dataResult = $responseData["data"];
		// var_dump($dataResult);exit();

		// Prepare SQL Insert statement
		$sqlInsert = "
		INSERT INTO vms_gateway.supplier
        (supplier_code, company_code, name, address1, address2, city, postal_code, contact_person, phone, hp1, hp2, fax, npwp, email, payment_term, bank_code, bank_name, bank_branch_code, bank_branch_name, bank_account_no, active, payment_term_cd, date_created)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		// Execute insert for each dataResult entry for the supplier
		foreach ($dataResult as $key1 => $value1) {
			if ($value1["status"] == "" || $value1["status"] == NULL) {
				$value1["status"] = 0;
			}
			try {
				$insert = $db1->prepare($sqlInsert);
				$insert->execute(array_values($value1));
			} catch (PDOException $e) {
				print "Error!: supplier " . $e->getMessage() . "<br/>\n";
			}
		}

		echo "Supplier code $supplierCode processed. \n";
	}

	// Insert into vms_db
	try {
		$sqlToVmsDb = "CALL vms_db.insert_supplier_sp()";
		$statement = $db1->prepare($sqlToVmsDb);
		$statement->execute();
	} catch (PDOException $e) {
		error_log("Error calling vms_db.insert_supplier_sp: " . $e->getMessage());
		echo "Error!: $sqlToVmsDb --- " . $e->getMessage() . "<br/>\n";
	}

	echo count($resultVendors) . " Suppliers processed successfully.";
} catch (Exception $e) {
	error_log("General error: " . $e->getMessage());
	echo "Error!: " . $e->getMessage() . "<br/>\n";
} finally {
	$insert = null;
	$db1 = null;
	include "include/selesai.php";
}
