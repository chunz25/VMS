<?php
//DISPUTEQTY BY VENDOR
$sql4004020102 = "CALL ip01_pfi_insert_sp ('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);

if ($rs) {
    echo "success";
} else {
    echo "failed";
}
;
