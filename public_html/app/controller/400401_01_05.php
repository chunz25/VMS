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
	$txtupdatenya = " plan_qty_send =" . $value_req2;
	$where_update = " WHERE  purchase_order_no= '" . $po_no . "' and product_code='" . $index_req2 . "'";
	if ($ok)
		$ok = $db->Execute('UPDATE purchase_order_item SET ' . $txtupdatenya . $where_update);
}

// update tabel goods_receive status_grn='22'

$record2['confirm_date'] = date("Y-m-d H:i:s");
$where_update = " purchase_order_no = '$po_no'";
if ($ok)
	$ok = $db->AutoExecute('purchase_order', $record2, 'UPDATE', $where_update);


$db->CommitTrans($ok);

if ($ok) {
	include $address_file_configs . "_lib/smtpmail/poconfirm_mail.php";
} else {
	echo "failed";
}
