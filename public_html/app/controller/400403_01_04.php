<?php
/* ------------
1. masukkan ke tabel proforma_invoice_item qty_rev xx --> iterative
2. update tabel proforma_invoice status_pfi='32' and revision_seq = revision_seq+1
3. masukkan ke tabel log

*/
//$db->debug=true;

//print_r($_REQUEST); //[param_menu3];
foreach ($_REQUEST as $index_req => $value_req) {
	$$index_req = $value_req;
}
$db->BeginTrans();
// print_r($qty_rev);
// 1. masukkan ke tabel proforma_invoice_item --> iterative
$ok = true;
$indeksupdatenyax = $revision_seq + 1;

foreach ($unit_price as $index_req2 => $value_req2) {
	if ($value_req2 >= 0) {

		if ($value_req2 > 0 && $value_req2 != '') {
			$txtupdatenya = " unit_price_rev" . $indeksupdatenyax . " =" . $value_req2 . ",unit_price_finish=" . $value_req2;
		} else {
			$txtupdatenya = " unit_price_rev" . $indeksupdatenyax . " = 0";
		}
		$where_update = " WHERE  proforma_invoice_no= '" . $proforma_invoice_no . "' and product_code='" . $index_req2 . "'";
		if ($ok) $ok   =  $db->Execute('UPDATE proforma_invoice_item SET ' . $txtupdatenya . $where_update);
	}
}

// update tabel proforma_invoice status_grn='22'


$indeksupdatenotes = "notes_rev" . $indeksupdatenyax;
$record2[$indeksupdatenotes] = $notes;

$record2['status_pfi'] = '32';
$record2['revision_seq'] = $revision_seq + 1;
$where_update = "proforma_invoice_no = '$proforma_invoice_no'";
if ($ok) $ok = $db->AutoExecute('proforma_invoice', $record2, 'UPDATE', $where_update);

$db->CommitTrans($ok);

if ($ok) {
	include $address_file_configs . "_lib/smtpmail/disputeprice_mail.php";
} else {
	echo "failed";
}
