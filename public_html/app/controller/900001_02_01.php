<?php 
// $db->debug=true;
// get request value ----------------------------

$db->BeginTrans();  

// field records ------------------------------
//$record['id'] = $id; 
$record['qty_2'] = $_REQUEST["p1"]; 
// $record['area'] = $_REQUEST["p2"]; 
$record['user_input'] = $_SESSION['username']; 

$sql="UPDATE stock_opname SET  qty_2=".$record['qty_2']." , user_input2='".$record['user_input']."' where  kode_product='".$_REQUEST["p3"]."'";
$ok=$db->Execute($sql);
// UPDATE TABLE -------------
// $where_update="kode_product='".$_REQUEST["p3"]."'"; 
// if ($ok) $ok = $db->AutoExecute('stock_opname',$record,'UPDATE',$where_update);
$db->CommitTrans($ok);

if($ok){ echo "success";}else{echo "failed";}
?>