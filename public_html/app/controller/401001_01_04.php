<?php
/* ------------
1. masukkan ke tabel proforma_invoice_item qty_rev xx --> iterative
2. update tabel proforma_invoice status_pfi='32' and revision_seq = revision_seq+1
3. masukkan ke tabel log

*/

foreach ($_REQUEST as $index_req => $value_req) {
	$$index_req = $value_req;
}
$db->BeginTrans();
// 1. masukkan ke tabel proforma_invoice_item --> iterative
$ok = true;
$indeksupdatenyax = $revision_seq + 1;


foreach ($unit_price as $index_req2 => $value_req2) {
	if ($value_req2 > 0) {
		$txtupdatenya = " unit_price_rev" . $indeksupdatenyax . " =" . $value_req2 . ",unit_price_finish=" . $value_req2;
		$where_update = " WHERE  proforma_invoice_no= '" . $proforma_invoice_no . "' and product_code='" . $index_req2 . "'";
		if ($ok)
			$ok = $db->Execute('UPDATE proforma_invoice_item SET ' . $txtupdatenya . $where_update);
	}
}

// update tabel proforma_invoice status_grn='22'
$indeksupdatenotes = "notes_rev" . $indeksupdatenyax;
$record2[$indeksupdatenotes] = $notes;
$record2['status_pfi'] = '33';
$record2['revision_seq'] = $indeksupdatenyax;
$where_update = "proforma_invoice_no = '$proforma_invoice_no'";
if ($ok)
	$ok = $db->AutoExecute('proforma_invoice', $record2, 'UPDATE', $where_update);

if ($indeksupdatenyax == 6) {
	$sql4004020102 = "CALL buyer_settlement_price_sp('" . $proforma_invoice_no . "')";
	if ($ok)
		$ok = $db->Execute($sql4004020102);
}

$db->CommitTrans($ok);

if ($ok) {
	include $address_file_configs . "_lib/smtpmail/disputepricereject_mail.php";
} else {
	echo "failed";
}
