<?php
// $db->debug=true;
// get request value ----------------------------
// print_r($_REQUEST);
// print_r($_SESSION);
// die();
foreach ($_REQUEST as $index_req => $value_req) {
    $$index_req = $value_req;
}

$db->BeginTrans();
// field records ------------------------------ 
$record['req_date'] = date("Y-m-d H:i:s");
$record['purchase_order_no'] = $purchase_order_no;
$record['user_req'] = $_SESSION['username'];
// $record['reason'] = $reason1." ".$reason2." ".$reason3; 
$record['reason'] = $reason;
$record['user_req_note'] = $user_req_note;

// INSERT TABLE -------------
$ok = $db->AutoExecute('purchase_order_req_cancel', $record, 'INSERT');

// UPDATE TABLE -------------
$record2['status_po'] = '13';
$where_update = "purchase_order_no = '$purchase_order_no'";

if ($ok) $ok = $db->AutoExecute('purchase_order', $record2, 'UPDATE', $where_update);
$db->CommitTrans($ok);

if ($ok) {
	include $address_file_configs . "_lib/smtpmail/pocancel_mail.php";
} else {
    echo "failed";
}
