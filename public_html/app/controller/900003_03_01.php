<?php 
 // $db->debug=true;
// get request value ----------------------------

$db->BeginTrans();  

// field records ------------------------------
//$record['id'] = $id; 

$sql="UPDATE supereco_vms_db.fix_barcode SET MP_BARCODE_NEW='".$_REQUEST["p1"]."',user_input='".$_SESSION['username']."' WHERE MP_SKU='".$_REQUEST["p2"]."'";
$ok=$db->Execute($sql);
// UPDATE TABLE -------------
// $where_update="kode_product='".$_REQUEST["p3"]."'"; 
// if ($ok) $ok = $db->AutoExecute('stock_opname',$record,'UPDATE',$where_update);
$db->CommitTrans($ok);

if($ok){ echo "success";}else{echo "failed";}
?>