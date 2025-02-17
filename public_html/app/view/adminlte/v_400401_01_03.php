<?php 
// $db->debug=true;
// get request value ----------------------------
foreach ($_REQUEST as $index_req => $value_req) {
$$index_req = $value_req;
}
$db->BeginTrans();  

// field records ------------------------------
//$record['id'] = $id; 
$record['req_date'] = date("Y-m-d H:i:s"); 
$record['purchase_order_no'] = $purchase_order_no; 
$record['backorder_flag'] = $backorder_flag; 
$record['user_req'] = $user_req; 
$record['reason'] = $reason1." ".$reason2." ".$reason3; 
$record['user_req_note'] = $user_req_note; 
$record['user_approve'] = $user_approve; 
$record['user_app_note'] = $user_app_note; 
$record['status_req'] = $status_req; 
// INSERT TABLE -------------
$ok = $db->AutoExecute('purchase_order_req_cancel',$record,'INSERT');
// field records ------------------------------
$record2['status_po'] ='13'; 
// UPDATE TABLE -------------
$where_update ="purchase_order_no = '$purchase_order_no'";
if ($ok) $ok = $db->AutoExecute('purchase_order',$record2,'UPDATE',$where_update);
$db->CommitTrans($ok);

if($ok){ echo "success";}else{echo "failed";}
?>