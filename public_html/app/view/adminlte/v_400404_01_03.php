<?php
$sql4004020102="CALL inv_receipt_insert_sp ('".$_REQUEST[main_id_key]."')";
$rs = $db->Execute($sql4004020102);
if($rs){echo "success";} else {echo "failed";};
?>