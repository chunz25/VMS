<?php

	$USER_IP_ADDRESS = $_SERVER["REMOTE_ADDR"];
	
	// data PO Header -------------
	$sql001='"select * from debit_note where debit_note_no='."'".$_REQUEST["param_menu3"]."'".'"';
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
	$sql004 = "SELECT * FROM debit_note_item WHERE dn_id='".$_REQUEST["param_menu3"]."' order by CAST(line_item AS UNSIGNED)";
	$rs = $db->Execute($sql004); 
	
	
	
?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header"><?php echo $_REQUEST["param_menu1"];?> #<?php echo $data_header["tax_file_name"];?></h2>			 
            </div><!-- /.col -->			
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
				<?php echo $_MAIN__CONFIGS_040[5] ?>
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
              <b>DEBIT NOTE NO #<u><?php echo $data_header["tax_file_name"];?></u></b><br/><br/>             
			  <table width="75%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header_supplier[supplier_code];?></td>
				  <tr>
				  <tr>
					  <td><b>Debit Note Date</b></td>
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
              <table class="table table-striped">		  
				<TABLE  class="table table-striped">
				<THEAD>
					  <tr valign="top">					
						<th align=""><b># NO</b></th>
						<th align="center"><b>REFERENCE NO</b></th>
						<th align="right"><b>STORE CODE</b></th>
						<th align="center"><b>REMARK 1</b></th>
						<th align="center"><b>REMARK 2</b></th>
						
												
						<th align="right"><b>AMOUNT</b></th>											
						<th align="right"><b>TAX</b></th>											
						<th align="right"><b>SUB TOT AMOUNT</b></th>											
					  </tr>
				</THEAD>
				<TBODY>
				<?php if ($rs) {
					$tot_sub_amt=0;
					$tot_vat=0;
					$sub_amt_ori=0;
					$tot_sub_amt_ori=0;
				
				while ($arr = $rs->FetchRow()) { 
				$tot_sub_amt=$arr['sub_amt']+$tot_sub_amt;
				$tot_vat=$arr['vat']+$tot_vat;
				$sub_amt_ori=$arr['sub_amt']-$arr['vat'];
				$tot_sub_amt_ori=$sub_amt_ori+$tot_sub_amt_ori;
			
			?>
					  <tr valign="top">						
						<td align=""><?php echo number_format($arr['line_item'],0);?></td>
						<td ><?php echo $arr['reference_no'];?></td>
						<td align=""><?php echo $arr['store_code'];?></td>	
						<td ><?php echo $arr['remark1'];?></td>
						<td ><?php echo $arr['acc_name'];?></td>
							
						<td align="right"><?php echo number_format($sub_amt_ori);?></td>							
						<td align="right"><?php echo number_format($arr['vat']);?></td>							
						<td align="right"><?php echo number_format($arr['sub_amt']);?></td>							
					  </tr>
				<?php } 
				}
				?>
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
                    <th>Sub Total</th>
                    <td align="right"><b><?php echo number_format($tot_sub_amt_ori,2);?></b></td>
                  </tr>
				   <tr>
                    <th>Tax</th>
                    <td align="right"><b><?php echo number_format($tot_vat,2);?></b></td>
                  </tr>
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
						<a class="btn btn-default btn-flat btn-sm btn-info"  onclick="cobayy('DEBIT+NOTE+FINISHED','400602','<?php echo $_REQUEST["param_menu3"];?>&param_menu4=1');"><i class="fa fa-edit"></i><b>BACK TO LIST DEBET NOTE</b></a>
					  <!-- button 2 --------- -->
						<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_97&doc_no=<?php echo urlencode($data_header["tax_file_name"]); ?>','','#tampil10');"><i class="fa fa-print"></i> <b>PRINT FAKTUR PAJAK</b></a>
					
					  <!-- button 3 --------- -->
						<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_98_PDF_DN&doc_no=<?php echo urlencode($data_header['tax_file_name']); ?>','','#tampil11');"><i class="fa fa-edit"></i> <b>PRINT DEBIT NO</b></a>			
					</div>			
				</div>
		</div>
          <!-- this row will not appear when printing -->   
		<div id="tempatmodal"></div>		  
        </section><!-- /.content -->
        <div class="clearfix"></div>