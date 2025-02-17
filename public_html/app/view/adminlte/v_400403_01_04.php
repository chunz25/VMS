<?php
/* ------------
1. masukkan ke tabel proforma_invoice_item qty_rev xx --> iterative
2. update tabel proforma_invoice status_pfi='32' and revision_seq = revision_seq+1
3. masukkan ke tabel log

*/
//$db->debug=true;

//print_r($_REQUEST); //[param_menu3];
foreach ($_REQUEST as $index_req => $value_req) {
$$index_req = $value_req;
}
$db->BeginTrans();  
// print_r($qty_rev);
// 1. masukkan ke tabel proforma_invoice_item --> iterative
$ok=true;
$indeksupdatenyax = $revision_seq+1;

foreach ($unit_price as $index_req2 => $value_req2) 
{
	if($value_req2>=0)
	{
		/*
		if($revision_seq==0){$record['unit_price_rev1'] = $value_req2;}
		if($revision_seq==1){$record['unit_price_rev2'] = $value_req2;}
		if($revision_seq==2){$record['unit_price_rev3'] = $value_req2;}
		if($revision_seq==3){$record['unit_price_rev4'] = $value_req2;}
		if($revision_seq==4){$record['unit_price_rev5'] = $value_req2;}
		if($revision_seq==5){$record['unit_price_rev6'] = $value_req2;}
		$where_update ="proforma_invoice_no= '".$proforma_invoice_no."' and product_code='".$index_req2."'";
		if($ok) $ok   =  $db->AutoExecute('proforma_invoice_item',$record,'UPDATE',$where_update);
		*/
		
		if($value_req2>0 && $value_req2!='')
		{ $txtupdatenya=" unit_price_rev".$indeksupdatenyax." =".$value_req2.",unit_price_finish=".$value_req2;}
		else
		{$txtupdatenya=" unit_price_rev".$indeksupdatenyax." = 0";}
		$where_update =" WHERE  proforma_invoice_no= '".$proforma_invoice_no."' and product_code='".$index_req2."'";
		if($ok) $ok   =  $db->Execute('UPDATE proforma_invoice_item SET '.$txtupdatenya.$where_update);
			
		}
}

// update tabel proforma_invoice status_grn='22'
	
	/*
	if($revision_seq==0){$record2['notes_rev1'] = $notes;}
	if($revision_seq==1){$record2['notes_rev2'] = $notes;}
	if($revision_seq==2){$record2['notes_rev3'] = $notes;}
	if($revision_seq==3){$record2['notes_rev4'] = $notes;}
	if($revision_seq==4){$record2['notes_rev5'] = $notes;}
	if($revision_seq==5){$record2['notes_rev6'] = $notes;}
	*/
	
	$indeksupdatenotes="notes_rev".$indeksupdatenyax;
	$record2[$indeksupdatenotes] = $notes;

	$record2['status_pfi'] ='32'; 
	$record2['revision_seq'] =$revision_seq+1; 
	$where_update ="proforma_invoice_no = '$proforma_invoice_no'";
	if ($ok) $ok = $db->AutoExecute('proforma_invoice',$record2,'UPDATE',$where_update);
	
$db->CommitTrans($ok);

if($ok){ echo "success";}else{echo "failed";}
?>