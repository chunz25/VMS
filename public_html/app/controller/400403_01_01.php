<?php
// data GRN Header -------------
$sql001 = '"select * from proforma_invoice where proforma_invoice_no=' . "'" . $_REQUEST["param_menu3"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001['rows'][0];
// print_r($data_header);

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002['rows'][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003['rows'][0];

// data GRN line -------------
$sql004 = "SELECT * FROM proforma_invoice_item WHERE proforma_invoice_no='" . $_REQUEST["param_menu3"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

// Data Hari Libur -------------
$libur = "SELECT * FROM harilibur";
$libur = $db->Execute($libur);
$b = array();
while ($a = $libur->fetchRow()) {
	array_push($b, $a['tgl']);
}

// var_dump($b);

// data Buyer -----------

$sql005 = '"select * from department_buyer where dept_code=' . "'" . $data_header_supplier["department"] . "'" . '"';
$exec_sql005 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql005);
$json_exec_sql005 = json_decode($exec_sql005, true);
$data_buyer = isset($json_exec_sql005['rows'][0]) ? $json_exec_sql005['rows'][0] : array();

$hp_buyer = (array_key_exists("buyer_hp", $data_buyer)) ? $data_buyer['buyer_hp'] : '';
$email_buyer = (array_key_exists("email", $data_buyer)) ? $data_buyer['email'] : '';
$name_buyer = (array_key_exists("buyer_name", $data_buyer)) ? $data_buyer['buyer_name'] : '';
$wa_address = "https://api.whatsapp.com/send?phone=" . $hp_buyer;

?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header"><?php echo $_REQUEST["param_menu1"]; ?> #<?php echo $_REQUEST["param_menu3"]; ?>
			</h2>
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
				<strong>Store :
					<?php echo $data_header['store_code'] . " " . $data_header_store['name']; ?></strong><br>
				<?php echo $data_header_store['address']; ?><br>
				<?php echo $data_header_store['city']; ?> <?php echo $data_header_store['zip_code']; ?><br>
				Phone: <?php echo $data_header_store['phone']; ?><br />
				Email: <?php echo $data_header_store['email']; ?>
			</address>
		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<b>Proforma Invoice No #<u><?php echo $_REQUEST["param_menu3"]; ?></u></b><br />
			<br />
			<table width="90%">
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
				<tr>
					<td><b>Received Date</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header['document_date']; ?></td>
				<tr>
				<tr>
					<td><b>Buyer Electronic-City</b></td>
					<td> : </td>
					<td align="right">
						<?php echo $name_buyer; ?>
					</td>
				<tr>
				<tr>
					<td><b>Email Buyer </b></td>
					<td> : </td>
					<td align="right">
						<?php echo $email_buyer; ?>
					</td>
				<tr>
				<tr>
					<td><b>HP Buyer</b></td>
					<td> : </td>
					<td align="right">
						+<?php echo $hp_buyer; ?>
						<a href="<?php echo $wa_address; ?>" target="whatsappWeb"><button
								class="btn btn-info btn-xs btn-flat" data-toggle="tooltip"
								title="Chat via WhatsApp Web <?php echo $hp_buyer; ?> "><i
									class="fa fa-whatsapp"></i></button></a>
					</td>
				<tr>

			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<?php // echo $sql002;
				?>
				<TABLE class="table table-striped">
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
							<th align="right"><b>SUBTOTAL</b></th>
						</tr>
					</THEAD>
					<TBODY>
						<?php if ($rs)
							while ($arr = $rs->FetchRow()) { ?>
						<tr valign="top">
							<td align="right"><?php echo number_format($arr['line_item'], 0); ?></td>
							<td><?php echo $arr['product_code']; ?></td>
							<td><?php echo $arr['barcode']; ?></td>
							<td><?php echo $arr['description']; ?></td>
							<td align="right"><?php echo number_format($arr['tax_pct'], 0); ?></td>
							<td align="right"><?php echo number_format($arr['quantity']); ?></td>
							<td align="right"><?php echo number_format($arr['unit_price']); ?></td>
							<td align="right"><?php echo number_format($arr['amount']); ?></td>
							<td align="right"><?php echo number_format($arr['vat_amount']); ?></td>
							<td align="right"><?php echo number_format($arr['amount'] + $arr['vat_amount']); ?></td>
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
				<b> Note :</b> <br>
				- Jika price unit tidak sesuai silahkan lakukan settlement dengan mengklik tombol "Dispute Price"<br>
			</p>
		</div><!-- /.col -->
		<div class="col-xs-6">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:50%">Subtotal excl tax</th>
						<td align="right"><?php echo number_format($data_header['total_amount'], 2); ?></td>
					</tr>
					<tr>
						<th>Tax</th>
						<td align="right"><?php echo number_format($data_header['vat_amount'], 2); ?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td align="right"><?php echo number_format($data_header['grand_total'], 2); ?></td>
					</tr>
				</table>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<div class="box-tools pull-left">
				<!-- button 1 -------- -->
				<a class="btn btn-default btn-flat btn-sm btn-info"
					onclick="cobayy('GOODS+RECEIVE','400403','&param_menu4=1');"><i class="fa fa-edit"></i> <b>BACK TO
						SETTLEMENT PRC</b></a>
				<!-- button 2 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i
						class="fa fa-print"></i> <b>PRINT PO</b></a>
				<!-- button 3 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i
						class="fa fa-print"></i> <b>PRINT RN</b></a>
				<!-- button 4 -------- 
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400402_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil9');"><i class="fa fa-print"></i> <b>PFI (DRAFT)</b></a>
				-->
			</div>
			<div class="box-tools pull-right">

				<?php
				$tgl = array('13', '28');
				$day = array('Sat', 'Sun');
				$tglmerah = $b;
				// var_dump($tgl);
				if (in_array(date('d'), $tgl) || in_array(date('D'), $day) || in_array(date("Y-m-d"), $tglmerah)) {
				?>
				<a class="btn btn-default btn-flat btn-sm  btn-warning"
					onclick="alert('Tidak bisa kirim invoice, karena bukan tanggal operational tukar faktur')">
					<i class="fa fa-edit"></i>
					<b>CONFIRM & SEND INVOICE </b></a>
				<?php
				} else {
				?>
				<a class="btn btn-default btn-flat btn-sm  btn-warning"
					onclick="bukaModalHelmizz301('#tempatmodalTF','index.php?main=040&main_act=010&main_id=400404_01_04&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&ttl_amt=<?php echo urlencode($data_header['total_amount']); ?>&vat_amt=<?php echo urlencode($data_header['vat_amount']); ?>&grd_amt=<?php echo urlencode($data_header['grand_total']); ?>&npwp_no=<?php echo urlencode($data_header_supplier['npwp']); ?>&pfi_no=<?php echo urlencode($data_header['proforma_invoice_no']); ?>&status_pfi=<?php echo urlencode($data_header['status_pfi']); ?>','','#tampil2');">
					<i class="fa fa-edit"></i>
					<b>CONFIRM & SEND INVOICE </b></a>

				<?php
				}
				?>


				<!-- button 6 -------- -->
				<a class="btn btn-default btn-flat btn-sm btn-danger"
					onclick="dispute_process('Apakah Anda Yakin akan memproses dispute price.... ?','PROFORMA+INVOICE','400403_01_03','<?php echo $_REQUEST["param_menu3"]; ?>')"><i
						class="fa fa-edit"></i><b>DISPUTE PRICE</b></a>
			</div>
		</div>
	</div>
</section><!-- /.content -->
<div class="clearfix"></div>
<div id="tempatmodal"></div>
<div id="tempatmodalTF"></div>
<script>
	$("#my_form").hide();

	$("#my_form").submit(function (event) {
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
		}).done(function (response) { //
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
</script>