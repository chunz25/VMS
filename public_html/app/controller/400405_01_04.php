<?php
$gr_no = $_REQUEST["gr_no"];
$sql4004020102 = "UPDATE invoice_receipt SET user_confirm='" . $_SESSION['username'] . "', confirm_date='" . date("Y-m-d H:i:s") . "',status_invr='54' WHERE no_invoice_supplier='" . $_REQUEST['main_id_key'] . "' and purchase_order_no='" . $_REQUEST['po_no'] . "'";
$rs = $db->Execute($sql4004020102);

if ($rs) {
    include $address_file_configs . "_lib/smtpmail/sendinvconfirm_mail.php";
} else {
    echo "failed";
}
;
