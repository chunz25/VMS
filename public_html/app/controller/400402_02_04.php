<?php
/* ------------
1. masukkan ke tabel goods_receive_item qty_rev xx --> iterative
2. update tabel goods_receive status_grn='22' and revision_seq = revision_seq+1
3. masukkan ke tabel log

*/
foreach ($_REQUEST as $index_req => $value_req) {
	$$index_req = $value_req;
}
$db->BeginTrans();
// 1. masukkan ke tabel goods_receive_item --> iterative
$ok = true;
$indeksupdatenyax = $revision_seq + 1;
foreach ($qty_rev as $index_req2 => $value_req2) {
	if ($value_req2 >= 0 && $value_req2 != '') {
		$txtupdatenya = " qty_rev" . $indeksupdatenyax . " =" . $value_req2 . ",qty_finish=" . $value_req2;
	} else {
		$txtupdatenya = " qty_rev" . $indeksupdatenyax . " = -1";
	}
	$where_update = " WHERE  goods_receive_no= '" . $goods_receive_no . "' and product_code='" . $index_req2 . "'";
	if ($ok)
		$ok = $db->Execute('UPDATE goods_receive_item SET ' . $txtupdatenya . $where_update);
}

// update tabel goods_receive status_grn='22'
$indeksupdatenotes = "notes_rev" . $indeksupdatenyax;
$record2[$indeksupdatenotes] = $notes;
$record2['status_grn'] = '22';
$record2['revision_seq'] = $revision_seq + 1;
$where_update = "goods_receive_no = '$goods_receive_no'";
if ($ok)
	$ok = $db->AutoExecute('goods_receive', $record2, 'UPDATE', $where_update);

$db->CommitTrans($ok);

if ($ok) {
	include $address_file_configs . "_lib/smtpmail/disputeqty_mail.php";
} else {
	echo "failed";
}
