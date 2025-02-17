<?php 
 // $db->debug=true;
// get request value ----------------------------

$db->BeginTrans();  

// field records ------------------------------
//$record['id'] = $id; 
$record['qty_1'] = $_REQUEST["p1"]; 
$record['area'] = $_REQUEST["p2"]; 
$record['user_input'] = $_SESSION['username']; 

$sql="INSERT INTO stock_opname_input (kode_product,qty_1,area,user_input) VALUES('".$_REQUEST["p3"]."',".$record['qty_1'].",'".$record['area']."','".$record['user_input']."')";
$ok=$db->Execute($sql);
// UPDATE TABLE -------------
// $where_update="kode_product='".$_REQUEST["p3"]."'"; 
// if ($ok) $ok = $db->AutoExecute('stock_opname',$record,'UPDATE',$where_update);
$db->CommitTrans($ok);

if($ok){ echo "success";}else{echo "failed";}
?>