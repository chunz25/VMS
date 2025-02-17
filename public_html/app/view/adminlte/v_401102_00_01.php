<?php

	// data PO Header -------------
	$sql001='"select * from purchase_order where purchase_order_no='."'".$_REQUEST["param_menu3"]."'".'"';
	//die($_MAIN__CONFIGS_030[5].' -s '.$sql001);
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

	// data PO line -------------
	$sql004 = "SELECT * FROM purchase_order_item WHERE purchase_order_no='".$_REQUEST["param_menu3"]."' order by CAST(line_item AS UNSIGNED)";
	$rs = $db->Execute($sql004); 
	
	// note request cancel ------------
	
	$sql005='"select * from purchase_order_req_cancel where purchase_order_no='."'".$_REQUEST["param_menu3"]."'".'"';
	$exec_sql005=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql005);
	$json_exec_sql005=json_decode($exec_sql005,true);
	$data_note_req=$json_exec_sql005[rows][0];
	

	/*
	1 [rows] => Array 
	( [0] => Array ( [id] => 305598 [purchase_order_no] => 222495 [company_code] => L01 [store_code] => 0002 [supplier_code] => 90000189 [document_date] => 2019-06-19 [delivery_date] => 2019-06-22 [order_type] => P [category_code] => [category_sub_code] => [total_quantity] => 256 [total_amount] => 3234000 [total_vat_amount] => 323400 [grand_total] => 3557400 [isIntegrated] => 1 [insert_date] => 2019-06-19 11:00:03.0 [row_id_cek] => 251276 [status_po] => [department] => )
	*/			
?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <?php echo $_REQUEST["param_menu1"];?> [CANCELLED] #<?php echo $_REQUEST["param_menu3"];?>
					
              </h2>			 
            </div><!-- /.col -->			
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
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
              To
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
              <b>Purchase Order No #<u><?php echo $_REQUEST["param_menu3"];?></u></b><br/>
              <br/>            
			  <table width="95%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header_supplier[supplier_code];?></td>
				  <tr>
				  <tr>
					  <td><b>Order Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[document_date];?></td>
				  <tr>
				  <tr>
					  <td><b>Delivery Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[delivery_date];?></td>
				  <tr>
				  <tr>
					  <td valign="top"><b>Req Cancel Dt</b></td>
					  <td valign="top"> : </td>
					  <td valign="top" align="right"><?php echo $data_note_req[req_date];?></td>
				  <tr>
			  </table>             
            </div><!-- /.col -->
          </div><!-- /.row -->
			<hr>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">			  
				<TABLE  class="table table-striped">
				<THEAD>
					  <tr valign="top">					
						<th align="right"><b># NO</b></th>
						<th align="center"><b>PRODUCT_CODE</b></th>
						<th align="center"><b>BARCODE</b></th>
						<th align="center"><b>DESCRIPTION</b></th>
						<th align="right"><b>TAX RATE(%)</b></th>
						<th align="right"><b>QUANTITY</b></th>
						<th align="right"><b>UNIT PRICE</b></th>
						<th align="right"><b>AMOUNT</b></th>						
						<th align="right"><b>TAX AMOUNT</b></th>											
					  </tr>
				</THEAD>
				<TBODY>
				<?php if ($rs) 
				while ($arr = $rs->FetchRow()) { ?>
					  <tr valign="top">						
						<td align="right"><?php echo number_format($arr['line_item'],0);?></td>
						<td ><?php echo $arr['product_code'];?></td>
						<td ><?php echo $arr['barcode'];?></td>
						<td ><?php echo $arr['description'];?></td>
						<td align="right"><?php echo number_format($arr['tax_pct'],0);?></td>
						<td align="right"><?php echo number_format($arr['quantity']);?></td>
						<td align="right"><?php echo number_format($arr['unit_price']);?></td>
						<td align="right"><?php echo number_format($arr['amount']);?></td>					
						<td align="right"><?php echo number_format($arr['vat_amount']);?></td>							
					  </tr>
				<?php } ?>
				</TBODY>
				</TABLE>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">             
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
			  <b> Note :</b> </br>
				- <?php echo $data_note_req[reason];?></br>
                - <?php echo $data_note_req[user_req_note];?></br>          
              </p>
            </div><!-- /.col -->
            <div class="col-xs-6">             
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
            </div><!-- /.col -->
          </div><!-- /.row -->
			
		<div class="row">
			<div class="col-xs-12">	
				<div class="box-tools pull-left">	
					<!-- button 1 -------- -->				
					<a class="btn btn-default btn-flat btn-sm btn-info"  onclick="cobayy('PURCHASE+ORDER','401102','<?php echo urlencode($data_header['purchase_order_no']); ?>&param_menu4=3');"><i class="fa fa-edit"></i> <b>BACK TO LIST PO CANCELLED</b></a>
					<!-- button 2 -------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PRINT PO</b></a>					
				</div>			
			</div>
		</div>
          <!-- this row will not appear when printing -->        
        </section><!-- /.content -->
        <div class="clearfix"></div>   
<div id="tempatmodal"></div>	