<?php
//DISPUTEQTY BY ECI
$sql4004020102 = "CALL ip01_pfi_insert_02_sp_eci('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);
if ($rs) {
    include $address_file_configs . "_lib/smtpmail/disputeqtyconfirm_mail.php";
} else {
    echo "failed";
}
;
