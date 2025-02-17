<?php
// $db->debug=true;
$db->BeginTrans();
// field records ------------------------------ 
$reason = array();
array_push($reason, $_REQUEST['note1'], $_REQUEST['note2'], $_REQUEST['note3'], $_REQUEST['note4']);
$reason = array_filter($reason);
$a = 0;
while ($a < count($reason)) {
    $r .= $reason[$a] . ", ";
    $a++;
}
// var_dump($r);die;
$gr_no = $_REQUEST["gr_no"];
$record['reject_date'] = date("Y-m-d H:i:s");
$record['status_invr'] = '53';
$record['reject_reason'] = $r . "catatan : -" . $_REQUEST['remark'];
// print_r($record);

// UPDATE TABLE -------------
$sql = "
        UPDATE invoice_receipt 
            set reject_date='" . date("Y-m-d H:i:s") . "',
            status_invr= 53,
            reject_reason='" . $record['reject_reason'] . "'
        where no_invoice_supplier='" . $_REQUEST['inv_supp_no'] . "' 
        and purchase_order_no='" . $_REQUEST['po_no'] . "'";

$ok = $db->Execute($sql);
// print_r($ok);
$db->CommitTrans($ok);
if ($ok) {
    include $address_file_configs . "_lib/smtpmail/sendinvreject_mail.php";
} else {
    echo "failed";
}