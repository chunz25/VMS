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
					<?php echo $_REQUEST["param_menu1"];?> #<?php echo $_REQUEST["param_menu3"];?>
				</h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">		  
		   <div class="col-sm-4 invoice-col">
              From
               <address>
                <strong><?php echo $data_header_supplier[name];?></strong><br>
                <?php echo $data_header_supplier[address1];?><br>
                <?php echo $data_header_supplier[address2];?>, <?php echo $data_header_supplier[city];?><br>
                Phone : <?php echo $data_header_supplier[phone];?><br/>
                Email : <?php echo $data_header_supplier[email];?><br/>
				Npwp : <?php echo $data_header_supplier[npwp];?>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
               <address>
                <strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
                <strong>Store : <?php echo $data_header[store_code]." ".$data_header_store[name];?></strong><br>
                <?php echo $data_header_store[address];?><br>
                <?php echo $data_header_store[city];?> <?php echo $data_header_store[zip_code];?><br>
                Phone: <?php echo $data_header_store[phone];?><br/>
                Email: <?php echo $data_header_store[email];?>
              </address>
            </div><!-- /.col -->    
            <div class="col-sm-4 invoice-col">
             <b>Proforma Invoice No #<u><?php echo $_REQUEST["param_menu3"];?></u></b><br/><br/>     
			  <table width="75%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header_supplier[supplier_code];?></td>
				  <tr>
				   <tr>
					  <td><b>PO No</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header['purchase_order_no'];?></td>
				  <tr>
				  <tr>
					  <td><b>GRN No</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header['goods_receive_no'];?></td>
				  <tr>
				  
				  <tr>
					  <td><b>Received Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[document_date];?></td>
				  <tr>
			  </table>            
            </div><!-- /.col -->
          </div><!-- /.row -->
			<hr>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">    
<?php echo $data_header[revision_seq];?>			
				<TABLE  class="table table-striped table-bordered">
				<THEAD>
					  <tr valign="top">					
						<th align="right"><b># NO</b></th>
						<th align="center"><b>PRODUCT CODE</b></th>
						<th align="center"><b>BARCODE</b></th>
						<th align="center"><b>DESCRIPTION</b></th>
						<th align="right"><b>TAX RATE(%)</b></th>
						<th align="right"><b>QUANTITY</b></th>
						<th align="right"><b>UNIT PRICE</b></th>
						<?php if($data_header[revision_seq]>0){ ?><th align="right"><b>REVISI 1 [SUPP]</b></th><?php } ?>
						<?php if($data_header[revision_seq]>1){ ?><th align="right"><b>REVISI 2 [BUYER]</b></th><?php } ?>
						<?php if($data_header[revision_seq]>2){ ?><th align="right"><b>REVISI 3 [SUPP]</b></th><?php } ?>
						<?php if($data_header[revision_seq]>3){ ?><th align="right"><b>REVISI 4 [BUYER]</b></th><?php } ?>
						<?php if($data_header[revision_seq]>4){ ?><th align="right"><b>REVISI 5 [SUPP]</b></th><?php } ?>
						<?php if($data_header[revision_seq]>5){ ?><th align="right"><b>REVISI 6 [BUYER]</b></th><?php } ?>
						<th align="right"><b>REVISION UNIT PRICE</b></th>
						<!-- <th align="right"><b>AMOUNT</b></th>						
						<th align="right"><b>TAX AMOUNT</b></th>	-->									
					  </tr>
				</THEAD>			
				<TBODY>
				<?php if ($rs) 
				while ($arr = $rs->FetchRow()) { 
			
					$qty_rev1 = ($arr['unit_price_rev1']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev1'])."</span></h4>" : number_format($arr['unit_price_ori']);
					$qty_rev2 = ($arr['unit_price_rev2']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev2'])."</span></h4>" : number_format($arr['unit_price_finish']);
					$qty_rev3 = ($arr['unit_price_rev3']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev3'])."</span></h4>" : number_format($arr['unit_price_finish']);
					$qty_rev4 = ($arr['unit_price_rev4']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev4'])."</span></h4>" : number_format($arr['unit_price_finish']);
					$qty_rev5 = ($arr['unit_price_rev5']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev5'])."</span></h4>" : number_format($arr['unit_price_finish']);
					$qty_rev6 = ($arr['unit_price_rev6']>0) ? "<h4><span class='label label-success'>".number_format($arr['unit_price_rev6'])."</span></h4>" : number_format($arr['unit_price_finish']);
			
			?>
					  <tr valign="top">					
						<td align="right"><?php echo number_format($arr['line_item'],0);?></td>
						<td ><?php echo $arr['product_code'];?></td>
						<td ><?php echo $arr['barcode'];?></td>
						<td ><?php echo $arr['description'];?></td>
						<td align="right"><?php echo number_format($arr['tax_pct'],0);?></td>
						<td align="right"><?php echo number_format($arr['quantity']);?></td>
						<td align="right"><?php echo number_format($arr['unit_price']);?></td>
						<?php if($data_header[revision_seq]>0){ ?><td align="right"><?php echo $qty_rev1;?></td><?php } ?>
						<?php if($data_header[revision_seq]>1){ ?><td align="right"><?php echo $qty_rev2;?></td><?php } ?>
						<?php if($data_header[revision_seq]>2){ ?><td align="right"><?php echo $qty_rev3;?></td><?php } ?>
						<?php if($data_header[revision_seq]>3){ ?><td align="right"><?php echo $qty_rev4;?></td><?php } ?>
						<?php if($data_header[revision_seq]>4){ ?><td align="right"><?php echo $qty_rev5;?></td><?php } ?>
						<?php if($data_header[revision_seq]>5){ ?><td align="right"><?php echo $qty_rev6;?></td><?php }?>
						<?php if($arr['unit_price_ori']!=$arr['unit_price_finish']) {
						?>
						<td align="right"><input type="text" id="rupiah" name="unit_price[<?php echo $arr['product_code'];?>]" placeholder="only different price" size="12"></td>
						<?php } else { ?>
						<td align="right"><?php echo number_format($arr['unit_price_ori']);?>
						<input type="hidden" name="unit_price[<?php echo $arr['product_code'];?>]" value="0">
						</td>
						<?php } ?>
						<!-- <td align="right"><?php echo number_format($arr['amount']);?></td>					
						<td align="right"><?php echo number_format($arr['vat_amount']);?></td> -->
						<td align="right"></td>							
					  </tr>
				<?php } ?>
				</TBODY>
				</TABLE>
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400403_02_04"> 
					<input type="hidden" name="proforma_invoice_no" value="<?php echo $_REQUEST["param_menu3"]; ?>">
					<input type="hidden" name="revision_seq" value="<?php echo $data_header["revision_seq"]; ?>">					
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
                    <td align="right"><?php echo number_format($data_header[total_amount],2);?></td>
                  </tr>
                  <tr>
                    <th>Tax</th>
                    <td align="right"><?php echo number_format($data_header[total_vat_amount],2);?></td>
                  </tr>  
                  <tr>
                    <th>Total</th>
                    <td align="right"><?php echo number_format($data_header[grand_total],2);?></td>
                  </tr>
                </table>
              </div>
            </div> --><!-- /.col -->
          </div><!-- /.row -->
		  <hr>
		<div class="row no-print">
		
            <div class="col-xs-12">
				<div class="box-tools pull-right">
					<a class="btn btn-default btn-flat btn-sm btn-info"  onclick="cobayy('DISPUTE+PRICE','400403','<?php echo $_REQUEST["param_menu3"];?>&param_menu4=2');"><i class="fa fa-edit"></i> <b>BACK TO LIST</b></a>	
                    <button type="submit" class="btn btn-default btn-flat btn-sm btn-info"><i class="fa fa-edit"></i> <b>SUBMIT DISPUTE PRICE</b></button>
				</div>
            </div>
          </div>       
		</form>
    </section><!-- /.content -->
<div class="clearfix"></div> 

<script>
$("#my_form").submit(function(event){
	 alert('data disubmit');
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
			alert('Dispute price Sudah diproses, Menunggu confirm dari Buyer SUPERECO ...');
			cobayy('DISPUTE+PRICE','400403','');
		}
		else
		{
			alert('Gagal dispute price...');
			return false;
		}		
    });
});

//alert('coba');
$("#rupiah").inputmask("decimal", { allowMinus: false });

</script>