<?php
//DISPUTEQTY BY VENDOR
//  print_r($_REQUEST); //[param_menu3];
// $db->debug=true;
// $sql4004020102 = "CALL sp_disputeqty ('" . $_REQUEST["main_id_key"] . "')";
$sql4004020102 = "CALL ip01_pfi_insert_sp ('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);

// var_dump($rs);
// die;
// echo "cek";
if ($rs) {
    echo "success";
} else {
    echo "failed";
};
