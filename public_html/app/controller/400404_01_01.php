<?php
	// data GRN Header -------------
	$sql001='"select * from invoice where invoice_no='."'".$_REQUEST["param_menu3"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001["rows"][0];
	
	// data store -----------------
	$sql002='"select * from store where code='."'".$data_header["store_code"]."'".'"';
	$exec_sql002=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql002);
	$json_exec_sql002=json_decode($exec_sql002,true);
	$data_header_store=$json_exec_sql002["rows"][0];
	
	// data supplier -----------------
	$sql003='"select * from supplier where supplier_code='."'".$data_header["supplier_code"]."'".'"';
	$exec_sql003=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql003);
	$json_exec_sql003=json_decode($exec_sql003,true);
	$data_header_supplier=$json_exec_sql003["rows"][0];

	// data GRN line -------------
	$sql002 = "SELECT * FROM invoice_item WHERE invoice_no='".$_REQUEST["param_menu3"]."' order by CAST(line_item AS UNSIGNED)";
	$rs = $db->Execute($sql002); 	
?>
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
				<h2 class="page-header"> <?php echo $_REQUEST["param_menu1"];?> #<?php echo $_REQUEST["param_menu3"];?> </h2>
           </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
				<address>
					<strong><?php echo $data_header_supplier["name"];?></strong><br>
					<?php echo $data_header_supplier["address1"];?><br>
					<?php echo $data_header_supplier["address2"];?>, <?php echo $data_header_supplier["city"];?><br>
					Phone : <?php echo $data_header_supplier["phone"];?><br/>
					Email : <?php echo $data_header_supplier["email"];?><br/>
					Npwp : <?php echo $data_header_supplier["npwp"];?>
				</address>
            </div><!-- /.col -->			 
            <div class="col-sm-4 invoice-col">
              To
			  <address>
					<strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
					<strong>Store : <?php echo $data_header["store_code"]." ".$data_header_store["name"];?></strong><br>
					<?php echo $data_header_store["address"];?><br>
					<?php echo $data_header_store["city"];?> <?php echo $data_header_store["zip_code"];?><br>
					Phone: <?php echo $data_header_store["phone"];?><br/>
					Email: <?php echo $data_header_store["email"];?>
				</address>
				
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
             <b>Invoice No #<u><?php echo $_REQUEST["param_menu3"];?></u></b><br/><br/>            
			  <table width="75%">
				  <tr>
					  <td><b>Supplier Code</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header_supplier["supplier_code"];?></td>
				  <tr>
				  <tr>
					  <td><b>Order Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header["document_date"];?></td>
				  <tr>
				  <tr>
					  <td><b>Received Date</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header["delivery_date"];?></td>
				  <tr>
				  <tr>
					  <td><b>PO NO</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header["purchase_order_no"];?></td>
				  <tr>
				  <tr>
					  <td><b>GR NO</b></td>
					  <td> : </td>
					  <td align="right"><?php echo $data_header["goods_receive_no"];?></td>
				  <tr>
			  </table>            
            </div><!-- /.col -->
          </div><!-- /.row -->
		<hr>
		
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
			  <?php // print_r($data_header);?>
				<TABLE  class="table table-striped">
				<THEAD>
					  <tr valign="top">					
						<th align="right"><b># NO</b></th>
						<th align="center"><b>PRODUCT_CODE</b></th>
						<th align="center"><b>BARCODE</b></th>
						<th align="center"><b>DESCRIPTION</b></th>
						<th align="right"><b>UNIT</b></th>
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
						<td ><?php echo $arr['unit'];?></td>
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
		<hr>
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6"  >&nbsp;
			 <form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
			 <div class="alert alert-info alert-dismissable">
					<div class="form-group">
					<label for="Notes">Catatan</label></br>
					  - File Pajak yang diUpload, harus File Asli dari DJP ( PAJAK )</br>
					  - Selisih Pembulatan Total Amount < 1000 ( lebih kecil dari Seribu rupiah )</br>
					  - Selisih Pembulatan Pajak < 100 ( lebih kecil dari Seratus rupiah )</br>
					</div>
					<div class="form-group">
                      <label for="exampleInputFile">File Faktur Pajak</label>
                      <input type="file" id="exampleInputFile" name="fakturpajak">
                    </div>
					<input type="hidden" name="main" value="040">
					<input type="hidden" name="main_act" value="010">
					<input type="hidden" name="main_id" value="400404_01_02">
					<input type="hidden" name="newnamefile" value="<?php echo $data_header["purchase_order_no"];?>">
					<input type="hidden" name="main_id_key" value="<?php echo $_REQUEST["param_menu3"]; ?>">	
					<input type="hidden" name="vat_amount" value="<?php echo $data_header["vat_amount"]; ?>">	
					<input type="hidden" name="total_amount" value="<?php echo $data_header["total_amount"]; ?>">	
					<button type="submit" class="btn btn-default btn-flat btn-sm btn-warning" align="right"><i class="fa fa-edit"></i> <b>SUBMIT TO INVOICE RECEIPT</b></button>
              
			  </form>
			  </div>
            </div><!-- /.col -->
			<div class="col-xs-6">             
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal excl tax</th>
                    <td align="right"><?php echo number_format($data_header["total_amount"],2);?></td>
                  </tr>
                  <tr>
                    <th>Tax</th>
                    <td align="right"><?php echo number_format($data_header["vat_amount"],2);?></td>
                  </tr>  
                  <tr>
                    <th>Total</th>
                    <td align="right"><?php echo number_format($data_header["grand_total"],2);?></td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <!-- this row will not appear when printing -->
		<hr>
		
          <div class="row no-print">
            <div class="col-xs-12">
				<div class="box-tools pull-left">
				  <!-- button 1 -------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="cobayy('INVOICE','400404','&param_menu4=1');"><i class="fa fa-edit"></i> <b>BACK TO LIST INVOICE</b></a>
					<!-- button 2 ---------- -->
						<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90_PDF_PO&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PO</b></a>
				  <!-- button 3 ---------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91_PDF_GRN&goods_receive_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i class="fa fa-print"></i> <b>GRN</b></a>
				   <!-- button 4 -------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_93_PDF_PFI&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil6');"><i class="fa fa-print"></i> <b>PFI</b></a>
					<!-- button 5 -------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_94_PDF_INV&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil7');"><i class="fa fa-print"></i> <b>INVOICE</b></a>
					
					
					
				</div>
				<div class="box-tools pull-right">
				  <?php
				  if($data_header['vat_amount']>0){
					?>
					 <!-- button 6 -------- 
					<a class="btn btn-default btn-flat btn-sm btn-warning" id="klikproses"  onclick="ngilangNongol('#klikproses','#my_form');"><i class="fa fa-edit"></i> <b>PROCESS TO INVOICE RECEIPT WITH FP</b></a>
					-->
					<a class="btn btn-default btn-flat btn-sm btn-danger" onclick="bukaModalHelmizz301('#tempatmodalTF','index.php?main=040&main_act=010&main_id=400404_01_04&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&ttl_amt=<?php echo urlencode($data_header['total_amount']); ?>&vat_amt=<?php echo urlencode($data_header['vat_amount']); ?>','','#tampil2');"><i class="fa fa-edit"></i> <b>PROCESS TO INVOICE RECEIPT WITH FP</b></a>	
				<?php	
				  }
				  else
				  {
					  ?>
				 <!-- button 5 -------- -->
					<a class="btn btn-default btn-flat btn-sm btn-warning" onclick="process_next(
					'Apakah Data sudah benar dan sesuai...?',
					'index.php',
					'400404_01_03',
					'<?php echo $_REQUEST["param_menu3"]; ?>',
					'Data Berhasil Disimpan, Proses Invoicing sudah selesai.... ',
					'INVOICE+RECEIPT',
					'400405',
					'INV4<?php echo $data_header["goods_receive_no"]; ?>',
					'Data Berhasil Disimpan, Proses selanjutnya.. Menunggu Pembayaran ',
					'Gagal Data Proses masuk ke system, Silahkan dicoba lagi. '
					)"><i class="fa fa-edit"></i><b>PROCESS TO INVOICE RECEIPT NO FP</b></a>
				  <?php } ?>
				</div>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div> 
<div id="tempatmodalTF"></div>	
<script>
$("#my_form").hide();

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
			alert('Proses Invoicing sudah selesai, Tinggal menunggu Pembayaran ...');
			cobayy('INVOICE+RECEIPT','400405','');
		}
		else
		{
			alert('Gagal Tukar faktur Silahkan dicoba lagi...');
			return false;
		}		
    });
});
</script>