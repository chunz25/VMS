<?php
$sql4004020102 = "CALL ip02_inv_insert_02_sp('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);
if ($rs) {
    echo "success";
} else {
    echo "failed";
}
;
