<?php
// PRINT CREDIT NOTE ===========================================
/*
	// data PO Header -------------
	$sql001='"select * from invoice_receipt where purchase_order_no='."'".$_REQUEST["po_no"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];

	*/
	

	/*
	1 [rows] => Array 
	( [0] => Array ( [id] => 305598 [purchase_order_no] => 222495 [company_code] => L01 [store_code] => 0002 [supplier_code] => 90000189 [document_date] => 2019-06-19 [delivery_date] => 2019-06-22 [order_type] => P [category_code] => [category_sub_code] => [total_quantity] => 256 [total_amount] => 3234000 [total_vat_amount] => 323400 [grand_total] => 3557400 [isIntegrated] => 1 [insert_date] => 2019-06-19 11:00:03.0 [row_id_cek] => 251276 [status_po] => [department] => )
	*/		
		
	// $namafilepdf=md5(sha1($_REQUEST["goods_receive_no"])).".pdf";
	
	$folder='/home/helmi/php/b2b/_docs/CN/';
	 $namafilepdf=md5(sha1($_REQUEST["doc_no"])).".pdf";
	 $docno = $_REQUEST["doc_no"];
	 
	  if(!is_file($folder.$namafilepdf.".pdf"))
		 {
			file_get_contents("http://b2b.goro.co.id/14ecf024e18da287f9cbf8e8b6bbf851.php?pwd=730e85e6ce5a47b805e96bf133a8757b&docno=".$docno);
		 }
?>
<div class="modal fade" id="tampil12" role="dialog" style="overflow-y: auto;" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">
		PRINT CREDIT NOTE # <?php echo $_REQUEST["doc_no"];?> <!-- || <?php echo $namafilepdf;?> || <?php echo $_REQUEST["po_no"];?> -->
		</h4>
		
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body" align="left">
				
				<embed src="_docs/CN/<?php echo $namafilepdf;?>" frameborder="0" width="100%" height="450px">
				
			</div>
		</div>
	 </div>
</div>