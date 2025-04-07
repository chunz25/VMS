<?php
	// data GRN Header -------------
	$sql001='"select * from proforma_invoice where proforma_invoice_no='."'".$_REQUEST["param_menu3"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001[rows][0];
	
	// data store -----------------
	$sql002='"select * from store where code='."'".$data_header["store_code"]."'".'"';
	$exec_sql002=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql002);
	$json_exec_sql002=json_decode($exec_sql002,true);
	$data_header_store=$json_exec_sql002[rows][0];
	
	// data supplier -----------------
	$sql003='"select * from supplier where supplier_code='."'".$data_header["supplier_code"]."'".'"';
	$exec_sql003=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql003);
	$json_exec_sql003=json_decode($exec_sql003,true);
	$data_header_supplier=$json_exec_sql003[rows][0];

	// data GRN line -------------
	$sql002 = "SELECT * FROM proforma_invoice_item WHERE proforma_invoice_no='".$_REQUEST["param_menu3"]."' order by CAST(line_item AS UNSIGNED)";
	$rs = $db->Execute($sql002); 	
?>
    <section class="invoice">
		 <form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
				<h2 class="page-header">
					<?= $_REQUEST["param_menu1"];?> #<?= $_REQUEST["param_menu3"];?> [DISPUTE PRICE]
				</h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">		  
		   <div class="col-sm-4 invoice-col">
              From
               <address>
                <strong><?= $data_header_supplier[name];?></strong><br>
                <?= $data_header_supplier[address1];?><br>
                <?= $data_header_supplier[address2];?>, <?= $data_header_supplier[city];?><br>
                Phone : <?= $data_header_supplier[phone];?><br/>
                Email : <?= $data_header_supplier[email];?><br/>
				Npwp : <?= $data_header_supplier[npwp];?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
               <address>
                <strong><?= $_MAIN__CONFIGS_040[4] ?></strong><br>
                <strong>Store : <?= $data_header[store_code]." ".$data_header_store[name];?></strong><br>
                <?= $data_header_store[address];?><br>
                <?= $data_header_store[city];?> <?= $data_header_store[zip_code];?><br>
                Phone: <?= $data_header_store[phone];?><br/>
                Email: <?= $data_header_store[email];?>
              </address>
            </div><!-- /.col -->    
            <div class="col-sm-4 invoice-col">
             <b>Proforma Invoice No #<u><?= $_REQUEST["param_menu3"];?></u></b><br/><br/>     
			  <table width="75%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?= $data_header_supplier[supplier_code];?></td>
				  <tr>
				   <tr>
					  <td><b>PO No</b></td>
					  <td> : </td>
					  <td align="right"><?= $data_header['purchase_order_no'];?></td>
				  <tr>
				  <tr>
					  <td><b>GRN No</b></td>
					  <td> : </td>
					  <td align="right"><?= $data_header['goods_receive_no'];?></td>
				  <tr>
				  
				  <tr>
					  <td><b>Received Date</b></td>
					  <td> : </td>
					  <td align="right"><?= $data_header[document_date];?></td>
				  <tr>
			  </table>            
            </div><!-- /.col -->
          </div><!-- /.row -->
			<hr>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">             
				<TABLE  class="table table-striped">
				<THEAD>
					  <tr valign="top">					
						<th align="right"><b># NO</b></th>
						<th align="center"><b>PRODUCT CODE</b></th>
						<th align="center"><b>BARCODE</b></th>
						<th align="center"><b>DESCRIPTION</b></th>
						<th align="right"><b>TAX RATE(%)</b></th>
						<th align="right"><b>QUANTITY</b></th>
						<th align="right"><b>UNIT PRICE</b></th>
						<th align="right"><b>REVISION UNIT PRICE</b></th>
						<!-- <th align="right"><b>AMOUNT</b></th>						
						<th align="right"><b>TAX AMOUNT</b></th>	-->									
					  </tr>
				</THEAD>			
				<TBODY>
				<?php if ($rs) 
				while ($arr = $rs->FetchRow()) { ?>
					  <tr valign="top">					
						<td align="right"><?= number_format($arr['line_item'],0);?></td>
						<td ><?= $arr['product_code'];?></td>
						<td ><?= $arr['barcode'];?></td>
						<td ><?= $arr['description'];?></td>
						<td align="right"><?= number_format($arr['tax_pct'],0);?></td>
						<td align="right"><?= number_format($arr['quantity']);?></td>
						<td align="right"><?= number_format($arr['unit_price']);?></td>
						<td align="right"><input type="text" name="unit_price[<?= $arr['product_code'];?>]" placeholder="only different qty" size="12"></td>
						<!-- <td align="right"><?= number_format($arr['amount']);?></td>					
						<td align="right"><?= number_format($arr['vat_amount']);?></td> -->
						<td align="right"></td>							
					  </tr>
				<?php } ?>
				</TBODY>
				</TABLE>
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400403_01_04"> 
					<input type="hidden" name="proforma_invoice_no" value="<?= $_REQUEST["param_menu3"]; ?>">
					<input type="hidden" name="revision_seq" value="<?= $data_header["revision_seq"]; ?>">					
			</div><!-- /.col -->
          </div><!-- /.row -->
		<div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-12">            
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
			  <label>Notes :</label></br>
			<textarea name="notes" rows="4" style="width:98%"></textarea>
              </p>
            </div><!-- /.col --> 
			<!-- <div class="col-xs-6">             
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal excl tax</th>
                    <td align="right"><?= number_format($data_header[total_amount],2);?></td>
                  </tr>
                  <tr>
                    <th>Tax</th>
                    <td align="right"><?= number_format($data_header[total_vat_amount],2);?></td>
                  </tr>  
                  <tr>
                    <th>Total</th>
                    <td align="right"><?= number_format($data_header[grand_total],2);?></td>
                  </tr>
                </table>
              </div>
            </div> --><!-- /.col -->
          </div><!-- /.row -->
		  <hr>
		<div class="row no-print">
		
            <div class="col-xs-12">
				<div class="box-tools pull-right">
					<a class="btn btn-default btn-flat btn-sm btn-info"  onclick="cobayy('PROFORMA+INVOICE','400403_01_01','<?= $_REQUEST["param_menu3"];?>');"><i class="fa fa-edit"></i> <b>BACK TO PROFORMA INVOICE</b></a>	
                    <button type="submit" class="btn btn-default btn-flat btn-sm btn-info"><i class="fa fa-edit"></i> <b>SUBMIT DISPUTE PRICE</b></button>
				</div>
            </div>
          </div>       
		</form>
    </section><!-- /.content -->
<div class="clearfix"></div> 
<script>
$("#my_form").submit(function(event){
	 if(confirm('Apakah Data Sudah diisi dengan benar ?')){
	//$('#loading').modal('show');
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
	var form_data = new FormData(this); //Creates new FormData object
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data,
		contentType: false,
		cache: false,
		processData:false
    }).done(function(response){ //
        //$("#server-results").html(response);
		alert(response);
		if(response=='success'){
			alert('Dispute price Sudah diproses, Menunggu confirm dari SUPERECO ...');
			cobayy('PROFORMA+INVOICE','400403','');
		}
		else
		{
			alert('Gagal dispute price...');
			return false;
		}		
    });
}
else
{
	return false;
}
});
</script>