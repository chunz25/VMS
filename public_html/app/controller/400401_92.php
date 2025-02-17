<?php
//PRINT RETURN 
	// data PO Header -------------
	$sql001='"select * from goods_return where goods_return_no='."'".$_REQUEST["po_no"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];

	
	

	/*
	1 [rows] => Array 
	( [0] => Array ( [id] => 305598 [purchase_order_no] => 222495 [company_code] => L01 [store_code] => 0002 [supplier_code] => 90000189 [document_date] => 2019-06-19 [delivery_date] => 2019-06-22 [order_type] => P [category_code] => [category_sub_code] => [total_quantity] => 256 [total_amount] => 3234000 [total_vat_amount] => 323400 [grand_total] => 3557400 [isIntegrated] => 1 [insert_date] => 2019-06-19 11:00:03.0 [row_id_cek] => 251276 [status_po] => [department] => )
	*/		
		
	// $namafilepdf=md5(sha1($_REQUEST["goods_receive_no"])).".pdf";
	 $namafilepdf=md5(sha1($_REQUEST["po_no"].$_REQUEST["bf"])).".pdf";
?>
<div class="modal fade" id="tampil5" role="dialog" style="overflow-y: auto;" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">
		PRINT RETURN # <?php echo $_REQUEST["po_no"].$_REQUEST["bf"];?> <!-- || <?php echo $namafilepdf;?> || <?php echo $_REQUEST["po_no"];?> -->
		</h4>
		
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body" align="left">
				
				<embed src="_docs/RETURN/<?php echo $namafilepdf;?>" frameborder="0" width="100%" height="450px">
				
			</div>
		</div>
	 </div>
</div>