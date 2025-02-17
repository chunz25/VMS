<?php
$USER_IP_ADDRESS = $_SERVER["REMOTE_ADDR"];

// data PO Header -------------
$sql001 = '"select * from purchase_order where purchase_order_no=' . "'" . $_REQUEST["param_menu3"] . "'" . '"';
// echo $_MAIN__CONFIGS_030[5].' -s '.$sql001;
// echo shell_exec("dir");
//  echo ($_MAIN__CONFIGS_030[5].' -s '.$sql001);
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

// echo "test";
// print_r($exec_sql001);

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
// echo $_MAIN__CONFIGS_030[5].' -s '.$sql002;
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002["rows"][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003["rows"][0];

// data PO line -------------
$sql004 = "SELECT * FROM purchase_order_item WHERE purchase_order_no='" . $_REQUEST["param_menu3"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

if (($_SESSION['tb_id_user_type'] == "5") || ($_SESSION['tb_id_user_type'] == "6")) {
	// Update status PO,
	// $db->debug=true;
	//status null atau 10 itu new, status 11 itu opened on process, jika confirm_date isi berarti sudah confirm
	if ($data_header['status_po'] == '10' || $data_header['status_po'] == '') {
		$sql005 = "UPDATE purchase_order set status_po='11' where purchase_order_no='" . $_REQUEST["param_menu3"] . "'";
		$db->Execute($sql005);

		$sql006 = "INSERT INTO log_invoicing_process (process_date, purchase_order_no, code_process, seq, process_name, user_id, ip_address) VALUES(now(), '" . $_REQUEST["param_menu3"] . "', '11', null , 'PO Ready To Print', '" . $_SESSION['username'] . "', '" . $USER_IP_ADDRESS . "')";
		$db->Execute($sql006);
	}
	// echo "balikin lagi yaa";
	// $db->debug=false;
}

?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header"><?php echo $_REQUEST["param_menu1"]; ?> #<?php echo $_REQUEST["param_menu3"]; ?></h2>
			</div><!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col">
				<hr>
				<b>From</b>
				<address>
					<strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
					<strong>Site : <?php echo $data_header["store_code"] . " " . $data_header_store["name"]; ?></strong><br>
					<?php echo $data_header_store["address"]; ?><br>
					<?php echo $data_header_store["city"]; ?> <?php echo $data_header_store["zip_code"]; ?><br>
					Phone: <?php echo $data_header_store["phone"]; ?><br />
					Email: <?php echo $data_header_store["email"]; ?>
				</address>

			</div><!-- /.col -->
			<div class="col-sm-4 invoice-col">
				<hr>
				<b>To</b>
				<address>
					<strong><?php echo $data_header_supplier["name"]; ?></strong><br>
					<?php echo $data_header_supplier["address1"]; ?><br>
					<?php echo $data_header_supplier["address2"]; ?>, <?php echo $data_header_supplier["city"]; ?><br>
					Phone : <?php echo $data_header_supplier["phone"]; ?><br />
					Email : <?php echo $data_header_supplier["email"]; ?><br />
					Npwp : <?php echo $data_header_supplier["npwp"]; ?>
				</address>

			</div><!-- /.col -->
			<div class="col-sm-4 invoice-col">
				<hr>
				<b>Purchase Order No #<u><?php echo $_REQUEST["param_menu3"]; ?></u></b><br /><br />
				<table width="75%">
					<tr>
						<td><b>Supplier Code</b></td>
						<td> : </td>
						<td align="right"><?php echo $data_header_supplier["supplier_code"]; ?></td>
					<tr>
					<tr>
						<td><b>Order Date</b></td>
						<td> : </td>
						<td align="right"><?php echo $data_header["document_date"]; ?></td>
					<tr>
					<tr>
						<td><b>Estimate Delivery Date</b></td>
						<td> : </td>
						<td align="right"><?php echo $data_header["delivery_date"]; ?></td>
					<tr>
					<tr>
						<td><b>Expired Date PO</b></td>
						<td> : </td>
						<td align="right"><?php echo $data_header["expired_date_po"]; ?></td>
					<tr>
					<tr>
						<td><b>Desc</b></td>
						<td> : </td>
						<td align="right"><?php echo $data_header["header_text"]; ?></td>
					<tr>
				</table>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<hr>
		<!-- Table row -->
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-bordered table-striped">
					<THEAD>
						<tr valign="top">
							<th align="right"><b># NO</b></th>
							<th align="center"><b>PRODUCT CODE</b></th>
							<th align="center"><b>PRODUCT NAME</b></th>
							<th align="right"><b>TAX(%)</b></th>
							<th align="right"><b>QTY</b></th>
							<th align="center"><b>PLAN <br>QTY SEND</b></th>
							<th align="right"><b>UNIT PRICE</b></th>
							<th align="right"><b>AMOUNT</b></th>
							<th align="right"><b>TAX AMOUNT</b></th>
							<th align="right"><b>SUB TOTAL AMOUNT</b></th>
						</tr>
					</THEAD>
					<TBODY>
						<?php
						$no = 0;
						if ($rs)
							while ($arr = $rs->FetchRow()) {
								$no++;
						?>
							<tr valign="top">
								<td align="right"><?php echo number_format($no, 0); ?><?php // echo number_format($arr['line_item'],0);
																						?></td>
								<td><?php echo $arr['product_code']; ?></td>
								<!-- <td ><?php echo $arr['barcode']; ?></td> -->
								<td><?php echo $arr['description']; ?></td>
								<td align="right"><?php echo number_format($arr['tax_pct'], 0); ?></td>
								<td align="right"><?php echo number_format($arr['quantity']); ?></td>
								<td align="right">
									<?php
									if ((($_SESSION['tb_id_user_type'] == "5") || ($_SESSION['tb_id_user_type'] == "6")) && ($arr['plan_qty_send'] == '')) {
									?>
										<input type="text" name="qty_rev[<?php echo $arr['product_code']; ?>]" value="<?php echo number_format($arr['quantity']); ?>" size="6">
										<?php
									} else {
										?><?php echo number_format($arr['plan_qty_send']); ?>
									<?php }
									?>
								</td>
								<td align="right"><?php echo number_format($arr['unit_price']); ?></td>
								<td align="right"><?php echo number_format($arr['amount']); ?></td>
								<td align="right"><?php echo number_format($arr['vat_amount']); ?></td>
								<td align="right"><?php echo number_format(($arr['amount'] + $arr['vat_amount'])); ?></td>
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
					- Currency / Mata Uang dalam Rupiah (IDR)</br>
					- Pastikan data unit price dan tax rate sudah benar</br>
					- Jika Tax atau Unit Price ada yang tidak benar,Silahkan lakukan Request Cancel,<br>
					&nbsp; &nbsp;Lalu Informasikan Buyer Electronic City untuk setting price/tax rate dengan benar
				</p>
			</div><!-- /.col -->
			<div class="col-xs-6">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th style="width:50%">Subtotal excl tax</th>
							<td align="right"><?php echo number_format($data_header["total_amount"], 0); ?></td>
						</tr>
						<tr>
							<th>Tax</th>
							<td align="right"><?php echo number_format($data_header["total_vat_amount"], 0); ?></td>
						</tr>
						<tr>
							<th>Total</th>
							<td align="right"><?php echo number_format($data_header["grand_total"], 0); ?></td>
						</tr>
					</table>
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<div class="row">
			<div class="col-xs-12">

				<div class="box-tools pull-left">
					<!-- button 1 --------- -->
					<a class="btn btn-default btn-flat btn-sm btn-info" onclick="cobayy('PURCHASE+ORDER','400401','<?php echo $_REQUEST["param_menu3"]; ?>&param_menu4=1');"><b>BACK TO LIST PO</b></a>
					<!-- button 2 --------- -->
					<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PRINT PO</b></a>
				</div>
				<div class="box-tools pull-right">


					<!-- button 3 --------- -->
					<?php
					if ((($_SESSION['tb_id_user_type'] == "5") || ($_SESSION['tb_id_user_type'] == "6")) && ($data_header['confirm_date'] == '')) {
					?>

						<input type="hidden" name="main" value="040">
						<input type="hidden" name="main_act" value="010">
						<input type="hidden" name="main_id" value="400401_01_05">
						<input type="hidden" name="po_no" value="<?php echo $_REQUEST["param_menu3"]; ?>">
						<input type="hidden" name="store_mail" value="<?= $data_header["store_code"] . ' ' . $data_header_store["name"]; ?>">
						<input type="hidden" name="suppcode_mail" value="<?= $data_header_supplier["supplier_code"]; ?>">
						<input type="hidden" name="suppname_mail" value="<?= $data_header_supplier["name"]; ?>">
						<input type="hidden" name="docdate_mail" value="<?= $data_header["document_date"]; ?>">
						<input type="hidden" name="docexp_mail" value="<?= $data_header["expired_date_po"]; ?>">
						<a class="btn btn-default btn-flat btn-sm btn-danger" onclick="bukaModalHelmizz301('#tempatmodalXX','index.php?main=040&main_act=010&main_id=400401_01_02&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil2');"><i class="fa fa-edit"></i> <b>REQUEST TO CANCEL</b></a>

						<button type="submit" class="btn btn-default btn-flat btn-sm btn-info"><b> <b>CONFIRM</b></a>
							<?php
						}
							?>
				</div>
			</div>
		</div>
		<!-- this row will not appear when printing -->
	</form>
	<div id="tempatmodal"></div>
	<div id="tempatmodalXX"></div>
</section><!-- /.content -->
<div class="clearfix"></div>
<script>
	$("#my_form").submit(function(event) {
		if (confirm('Apakah Data Sudah diisi dengan benar ?')) {
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
				// alert(response);
				if (response == 'success') {
					alert('Confirm sudah diproses ... \n Silahkan siapkan Product yang akan dikirim ..');
					//$(".close").click()
					// console.log()
					cobayy('PURCHASE+ORDER', '400401', '');
				} else {
					alert('Gagal Proses Confirm ...');
					return false;
				}
			});
		} else {
			return false;
		}
	});
</script>