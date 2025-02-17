<?php

	$USER_IP_ADDRESS = $_SERVER["REMOTE_ADDR"];
	
	// data PO Header -------------
	$sql001='"select * from payment where payment_no='."'".$_REQUEST["param_menu3"]."'".'"';
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
	$sql004 = "SELECT * FROM payment_item WHERE payment_id='".$_REQUEST["param_menu3"]."' order by CAST(line_item AS UNSIGNED)";
	$rs = $db->Execute($sql004); 
	
	
	
?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header"><?php echo $_REQUEST["param_menu1"];?> #<?php echo $_REQUEST["param_menu3"];?></h2>			 
            </div><!-- /.col -->			
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
               <!--  <?php echo $data_header_store[address];?><br>
                <?php echo $data_header_store[city];?> <?php echo $data_header_store[zip_code];?><br>
                Phone: <?php echo $data_header_store[phone];?><br/>
                Email: <?php echo $data_header_store[email];?> -->
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
              <b>Payment No #<u><?php echo $_REQUEST["param_menu3"];?></u></b><br/><br/>             
			  <table width="75%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header_supplier[supplier_code];?></td>
				  <tr>
				  <tr>
					  <td><b>Payment Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[document_date];?></td>
				  <tr>
				  <tr>
					  <td><b>Payment Description</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[payment_description];?></td>
				  <tr>
				  <tr>
					  <td><b>Bank Name</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[bank_name];?></td>
				  <tr>
				  <tr>
					  <td><b>Bank Account</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header[bank_account];?></td>
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
						<th align=""><b># NO</b></th>
						<th align="center"><b>REFERENCE NO</b></th>
						<th align="center"><b>PO NO</b></th>
						<th align="center"><b>GRN NO</b></th>
						<th align="right"><b>STORE CODE</b></th>						
						<th align="right"><b>PAYMENT AMOUNT</b></th>											
					  </tr>
				</THEAD>
				<TBODY>
				<?php if ($rs) 
				while ($arr = $rs->FetchRow()) { ?>
					  <tr valign="top">						
						<td align=""><?php echo number_format($arr['line_item'],0);?></td>
						<td ><?php echo $arr['reference_no'];?></td>
						<td ><?php echo $arr['purchase_order_no'];?></td>
						<td ><?php echo $arr['goods_receive_no'];?></td>
						<td align=""><?php echo $arr['store_code'];?></td>		
						<td align="right"><?php echo number_format($arr['payment_amount']);?></td>							
					  </tr>
				<?php } ?>
				</TBODY>
				</TABLE>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">            
             
            </div><!-- /.col -->
            <div class="col-xs-6">             
              <div class="table-responsive">
                <table class="table">
                  
                  <tr>
                    <th>Total</th>
                    <td align="right"><b><?php echo number_format($data_header[total_amount],2);?></b></td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->			
		<div class="row">
				<div class="col-xs-12">	
					
					<div class="box-tools pull-left">
					<!-- button 1 --------- -->					
						<a class="btn btn-default btn-flat btn-sm btn-info"  onclick="cobayy('PAYMENT+INFORMATION','400701','<?php echo $_REQUEST["param_menu3"];?>&param_menu4=1');"><i class="fa fa-edit"></i><b>BACK TO LIST PAYMENT</b></a>
					  <!-- button 2 --------- 
						<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PRINT PO</b></a>-->
					</div>
					<div class="box-tools pull-right">
					  <!-- button 3 --------- 
						<a class="btn btn-default btn-flat btn-sm btn-danger" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_01_02&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil2');"><i class="fa fa-edit"></i> <b>REQUEST TO CANCEL</b></a>			-->
					</div>			
				</div>
		</div>
          <!-- this row will not appear when printing -->   
		<div id="tempatmodal"></div>		  
        </section><!-- /.content -->
        <div class="clearfix"></div>