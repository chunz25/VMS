<?php
// sleep(5);
// data Header -------------
$sql001 = '"select max(goods_receive_no) as goods_receive_no,SUM(total_amount) AS total_amount,SUM(vat_amount) AS vat_amount,SUM(grand_total) AS grand_total,MAX(biaya_materai) AS biaya_materai,purchase_order_no,supplier_code,no_invoice_supplier,supplier_name,rs_no_sap,max(status_invr) status_invr,company_code,store_code  from invoice_receipt where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . ' and no_invoice_supplier=' . "'" . $_REQUEST["param_menu3"] . "' GROUP BY purchase_order_no,supplier_code,no_invoice_supplier,supplier_name,rs_no_sap,company_code,store_code " . '"';
// $sql001 = "select max(goods_receive_no) as goods_receive_no,SUM(total_amount) AS total_amount,SUM(vat_amount) AS vat_amount,SUM(grand_total) AS grand_total,MAX(biaya_materai) AS biaya_materai,purchase_order_no,supplier_code,no_invoice_supplier,supplier_name,rs_no_sap,max(status_invr) status_invr,company_code,store_code  from invoice_receipt where purchase_order_no='" . $_REQUEST['po_no'] . "' and no_invoice_supplier='" . $_REQUEST['param_menu3'] . "' GROUP BY purchase_order_no,supplier_code,no_invoice_supplier,supplier_name,rs_no_sap,company_code,store_code ";
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001['rows'][0];
// echo $_MAIN__CONFIGS_030[5] . ' -s ' . $sql001;
// $data_header0 = $db->Execute($sql001);
// $data_header = $data_header0->fetch();
// var_dump($data_header); 
// print_r($data_header);

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
// $data_header_store = $db->Execute($sql002);
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002['rows'][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
// $data_header_supplier = $db->Execute($sql003);
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003['rows'][0];

// data GRN line -------------
// $db->debug=true;
$sql002 = 'select * from invoice_receipt where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . ' and no_invoice_supplier=' . "'" . $_REQUEST["param_menu3"] . "'";
$rs = $db->Execute($sql002);


?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header"> <?php echo $_REQUEST["param_menu1"]; ?> #<?php echo $_REQUEST["param_menu3"]; ?> </h2>
		</div><!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			From
			<address>
				<strong><?php echo $data_header_supplier['name']; ?></strong><br>
				<?php echo $data_header_supplier['address1']; ?><br>
				<?php echo $data_header_supplier['address2']; ?>, <?php echo $data_header_supplier['city']; ?><br>
				Phone : <?php echo $data_header_supplier['phone']; ?><br />
				Email : <?php echo $data_header_supplier['email']; ?><br />
				Npwp : <?php echo $data_header_supplier['npwp']; ?>
			</address>
		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			To
			<address>
				<strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
				<strong>Site : <?php echo $data_header['store_code'] . " " . $data_header_store['name']; ?></strong><br>
				<?php echo $data_header_store['address']; ?><br>
				<?php echo $data_header_store['city']; ?> <?php echo $data_header_store['zip_code']; ?><br>
				Phone: <?php echo $data_header_store['phone']; ?><br />
				Email: <?php echo $data_header_store['email']; ?>
			</address>

		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<b>Invoice No #<u><?php echo $_REQUEST["param_menu3"]; ?></u></b><br /><br />
			<table width="75%">
				<tr>
					<td><b>Supplier Code</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header_supplier['supplier_code']; ?></td>
				<tr>
				<tr>
					<td><b>PO No</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header['purchase_order_no']; ?></td>
				<tr>
				<tr>
					<td><b>GRN No</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header['goods_receive_no']; ?></td>
				<tr>
					<!-- <tr>
					  <td><b>Order Date</b></td>
					  <td> : </td>
					  <td align="right"><?php // echo $data_header['document_date'];
										?></td>
				  <tr> -->

			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>

	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<?php // echo $sql002;
			?>
			<TABLE class="table table-bordered table-striped">
				<THEAD>
					<tr valign="top">
						<th align="right"><b># NO</b></th>
						<th align="center"><b>COMPANY CODE</b></th>
						<th align="center"><b>PO NO</b></th>
						<th align="center"><b>RECEIVE NO</b></th>
						<th align="right"><b>SITE CD</b></th>
						<th align="right"><b>AMOUNT</b></th>
						<th align="right"><b>VAT</b></th>
						<th align="right"><b>TOTAL AMOUNT</b></th>
					</tr>
				</THEAD>
				<TBODY>
					<?php
					$hh = 0;
					if ($rs)
						while ($arr = $rs->FetchRow()) {
							$hh++;
					?>
						<tr valign="top">
							<td><?php echo $hh; ?></td>
							<td><?php echo $arr['company_code']; ?></td>
							<td><?php echo $arr['purchase_order_no']; ?></td>
							<td><?php echo $arr['goods_receive_no']; ?></td>
							<td><?php echo $arr['store_code']; ?></td>

							<td align="right"><?php echo number_format($arr['total_amount'], 0); ?></td>
							<td align="right"><?php echo number_format($arr['vat_amount'], 0); ?></td>
							<td align="right"><?php echo number_format($arr['grand_total'], 0); ?></td>
						</tr>
					<?php } ?>
				</TBODY>
			</TABLE>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<div class="row">
		<!-- accepted payments column -->
		<div class="col-xs-6">&nbsp;
		</div><!-- /.col -->
		<div class="col-xs-6">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:50%">Subtotal excl tax</th>
						<td align="right"><?php echo number_format($data_header['total_amount'], 0); ?></td>
					</tr>
					<tr>
						<th>Tax</th>
						<td align="right"><?php echo number_format($data_header['vat_amount'], 0); ?></td>
					</tr>
					<tr>
						<th>Materai</th>
						<td align="right"><?php echo number_format($data_header['biaya_materai'], 0); ?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td align="right"><b><?php echo number_format($data_header['grand_total'] + $data_header['biaya_materai'], 0); ?></b></td>
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
				<a class="btn btn-default btn-flat btn-sm btn-info" onclick="cobayy('INVOICE+RECEIPT','400405','&param_menu4=1');"><i class="fa fa-edit"></i> <b>BACK TO RECEIPT SUPPLIER</b></a>

				<!-- button 2 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PO</b></a>
				<!-- button 3 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i class="fa fa-print"></i> <b>GRN</b></a>
				<!-- button 4 --------  
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_93&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil6');"><i class="fa fa-print"></i> <b>PFI</b></a> -->
				<!-- button 5 -------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_80&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil8');"><i class="fa fa-print"></i> <b>SURAT JALAN</b></a>
				<!-- button 6 -------- -->

				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_81&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil7');"><i class="fa fa-print"></i> <b>INVOICE</b></a>
				<!-- button 7 -------- -->
				<?php
				if ($data_header['vat_amount'] > 0) {
				?>
					<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_82&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil9');"><i class="fa fa-print"></i> <b>FAKTUR PAJAK</b></a>
				<?php } ?>
				<!-- button 6 -------- -->

				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_83&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil10');"><i class="fa fa-print"></i> <b>DOK LAIN</b></a>
			</div>
			<div class="box-tools pull-right">
				<?php if (($_SESSION['tb_id_user_type'] == '3') && ($_REQUEST["invrstat"] < '53')) { ?>
					<!-- button 5 -------- -->
					<a class="btn btn-default btn-flat btn-sm  btn-danger" onclick="bukaModalHelmizz303('#tempatmodalReject',
				 'index.php?main=040&main_act=010&main_id=400404_01_06&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&inv_supp_no=<?php echo urlencode($data_header['no_invoice_supplier']); ?>',
				 '',
				 '#tampil2');"><i class="fa fa-edit"></i> <b>REJECT</b></a>
					<!-- button 6 -->
					<a class="btn btn-default btn-flat btn-sm btn-warning" onclick="process_next(
					'Apakah Sudah dicek Kelengkapan Berkas dan Isi nya ... ?',
					'index.php?po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>',
					'400405_01_04',
					'<?php echo $_REQUEST["param_menu3"]; ?>',
					'Data Berhasil Disimpan .. ',
					'RECEIPT+SUPPLIER',
					'400405',
					'1',
					'Gagal Data Proses masuk ke system, Silahkan dicoba lagi. '
					)"><i class="fa fa-edit"></i> <b>CONFIRM</b></a>

					<!-- <a class="btn btn-default btn-flat btn-sm btn-danger" onclick="dispute_process('Apakah Sudah dicek Kelengkapan Berkas dan Isi nya ... ?','RECEIPT+SUPPLIER','400405_01_04','<?php echo $_REQUEST["param_menu3"]; ?>')"><i class="fa fa-edit"></i><b>CONFIRM</b></a>	-->
				<?php } ?>


			</div>
		</div>
	</div>
</section><!-- /.content -->
<div class="clearfix"></div>
<div id="tempatmodal"></div>
<div id="tempatmodalReject"></div>
<script>
	$("#my_form_kirim_ulang").submit(function(event) {
		alert('data disubmit');
		//$('#loading').modal('show');
		event.preventDefault(); //prevent default action 
		var post_url = $(this).attr("action"); //get form action url
		var request_method = $(this).attr("method"); //get form GET/POST method
		var form_data = new FormData(this); //Creates new FormData object
		$.ajax({
			url: post_url,
			type: request_method,
			data: form_data,
			contentType: false,
			cache: false,
			processData: false
		}).done(function(response) { //
			//$("#server-results").html(response);
			alert(response);
			if (response == 'success') {
				alert('Proses Invoicing sudah selesai, Tinggal menunggu Pembayaran ...');
				cobayy('INVOICE+RECEIPT', '400405', '');
			} else {
				alert('Gagal Tukar faktur Silahkan dicoba lagi...');
				return false;
			}
		});
	});

	function bukaModalHelmizz303(param1, param2, param3, param4) {
		//$('#loading').modal('show');
		$(param1).load(param2,
			param3,
			function(responseTxt, statusTxt, xhr) {
				if (statusTxt == "success") {
					//$('#loading').modal('hide');
					$(param4).modal('show');
				}
				if (statusTxt == "error")
					alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
			}
		);
	}
</script>