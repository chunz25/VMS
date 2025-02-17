<?php
// ini_set('display_errors',0);
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";
/*
$srcPO='d:/aplikasiweb/8072/data/po_1/';
$destPO='d:/aplikasiweb/8072/data/po_2/';
$srcRN='d:/aplikasiweb/8072/data/gr_1/';
$destRN='d:/aplikasiweb/8072/data/gr_2/';
*/

// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)

$srcPO = '/home/vms/shareFile/PO/';
$destPO = '/home/vms/public_html/_docs/PO/';
$srcRN = '/home/vms/shareFile/GR/';
$destRN = '/home/vms/public_html/_docs/GR/';

// Proses PO -------------------------------------------------------

$sql1 = "SELECT purchase_order_no FROM vms_db.purchase_order";
$xxx = $db1->query($sql1);

foreach ($xxx as $arr1) {

	$outputPO = null;
	$retvalPO = null;
	// $paramdatePO=date("Ymd");
	$paramdatePO = $arr1["purchase_order_no"];
	exec('find ' . $srcPO . ' -type f -name "' . $paramdatePO . '*.pdf" -exec echo {} \;', $outputPO, $retvalPO);
	// echo "Returned with status $retval and output:\n";
	// print_r($outputPO);

	// print_r($srcPO);
	// print_r($srcRN);
	// die();

	foreach ($outputPO as $key1 => $value1) {
		// print_r($value1);
		// echo "\n";
		$value11 = basename($value1);
		$newPOArr = explode("-", $value11);
		if (is_file($value1)) {
			copy($value1, $destPO . $newPOArr[1] . ".pdf");
			if (!copy($value1, $destPO . $newPOArr[1] . ".pdf")) {
				echo "failed to copy $srcPO.$value11...\n";
			}
		}
	}
}


// $sql2 = "SELECT goods_receive_no FROM vms_db.goods_receive WHERE sendmail = 0 ";
// $yyy = $db1->query($sql2);

// foreach ($yyy as $arr2) {

// 	$outputRN = null;
// 	$retvalRN = null;
// 	// $paramdateRN=date("Ymd");
// 	$paramdateRN = $arr2["goods_receive_no"];
// 	exec('find ' . $srcRN . ' -type f -name "*' . $paramdateRN . '*.pdf" -exec echo {} \;', $outputRN, $retvalRN);


// 	foreach ($outputRN as $key2 => $value2) {
// 		// print_r($value2);
// 		// echo "\n";
// 		$value22 = basename($value2);
// 		$newRNArr = explode("-", $value22);
// 		if (is_file($value2)) {
// 			copy($value2, $destRN . $newRNArr[0] . ".pdf");
// 			if (!copy($value2, $destRN . $newRNArr[0] . ".pdf")) {
// 				echo "failed to copy $srcRN.$value22...\n";
// 			}
// 		}
// 	}
// }
include "include/selesai.php";
