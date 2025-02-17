<?php
// ini_set('display_errors',0);
include "include/mulai.php";
/*
$srcPO='d:/aplikasiweb/8072/data/po_1/';
$destPO='d:/aplikasiweb/8072/data/po_2/';
$srcRN='d:/aplikasiweb/8072/data/gr_1/';
$destRN='d:/aplikasiweb/8072/data/gr_2/';
*/



$srcPO = '/home/vms/shareFile/GR/';
$destPO = '/home/vms/public_html/_docs/PO/';
$srcRN = '/home/vms/shareFile/PO/';
$destRN = '/home/vms/public_html/_docs/GR/';
// $srcPO = '/home/vmsdev/shareFile/GR/';
// $destPO = '/home/vmsdev/public_html/_docs/PO/';
// $srcRN = '/home/vmsdev/shareFile/PO/';
// $destRN = '/home/vmsdev/public_html/_docs/GR/';

// print_r($srcPO);
// print_r($srcRN);
// die();
foreach (scandir($srcPO) as $key1 => $value1) {
	print_r($value1);
	echo "\n";
	$newPOArr = explode("-", $value1);
	if (is_file($srcPO . $value1)) {

		if (!copy($srcPO . $value1, $destPO . $newPOArr[1] . ".pdf")) {
			echo "failed to copy $srcPO.$value1...\n";
		}
	}
}

foreach (scandir($srcRN) as $key2 => $value2) {
	print_r($value2);
	echo "\n";
	$newRNArr = explode("-", $value2);
	if (is_file($srcRN . $value2)) {

		if (!copy($srcRN . $value2, $destRN . $newRNArr[0] . ".pdf")) {
			echo "failed to copy $srcRN.$value2...\n";
		}
	}
}
include "include/selesai.php";
