<?php
//PRINT PO
	// data PO Header -------------
	$sql001='"select * from purchase_order where purchase_order_no='."'".$_REQUEST["po_no"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
	if(($_SESSION['tb_id_user_type']=="5")||($_SESSION['tb_id_user_type']=="6")){
	// Update status PO,
		if($data_header['status_po']=='11' ){
				$sql005 = "UPDATE purchase_order set status_po='12' where purchase_order_no='".$_REQUEST["po_no"]."'";
				$db->Execute($sql005); 
	
		}
	}

	/*
	1 [rows] => Array 
	( [0] => Array ( [id] => 305598 [purchase_order_no] => 222495 [company_code] => L01 [store_code] => 0002 [supplier_code] => 90000189 [document_date] => 2019-06-19 [delivery_date] => 2019-06-22 [order_type] => P [category_code] => [category_sub_code] => [total_quantity] => 256 [total_amount] => 3234000 [total_vat_amount] => 323400 [grand_total] => 3557400 [isIntegrated] => 1 [insert_date] => 2019-06-19 11:00:03.0 [row_id_cek] => 251276 [status_po] => [department] => )
	*/		
		
	$namafilepdf=md5(sha1($_REQUEST["po_no"])).".pdf";
?>
<div class="modal fade" id="tampil3" role="dialog" style="overflow-y: auto;" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">
		PRINT PO # <?php echo $_REQUEST["po_no"];?>
		</h4>
		
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body" align="left">
				
				<embed src="_docs/PO/<?php echo $namafilepdf;?>" frameborder="0" width="100%" height="450px">
				
			</div>
		</div>
	 </div>
</div>