<?php
// print_r($_REQUEST); //[param_menu3];
 //$db->debug=true;
$sql4004020102="CALL pfi_insert_sp ('".$_REQUEST[main_id_key]."')";
$rs = $db->Execute($sql4004020102);
if($rs){echo "success";} else {echo "failed";};
?>