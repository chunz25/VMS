<?php
// print_r($_REQUEST); //[param_menu3];
//  $db->debug=true;
//(print_r($_REQUEST));
// die();
$sql4004020102 = "CALL inv_insert_sp ('" . $_REQUEST["main_id_key"] . "')";
$rs = $db->Execute($sql4004020102);
if ($rs) {
    echo "success";
} else {
    echo "failed";
};
// if($rs){print_r($data_header);} else {echo "failed";};
