<?php
// data GRN Header -------------
$sql001 = '"select * from goods_receive where goods_receive_no=' . "'" . $_REQUEST["param_menu3"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

// data PO Header ----------------
$sql005 = '"select * from purchase_order where purchase_order_no=' . "'" . $data_header["purchase_order_no"] . "'" . '"';
$exec_sql005 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql005);
$json_exec_sql005 = json_decode($exec_sql005, true);
$data_header_po = $json_exec_sql005["rows"][0];

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002["rows"][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003["rows"][0];

// data GRN line -------------
$sql004 = "SELECT * FROM goods_receive_item WHERE goods_receive_no='" . $_REQUEST["param_menu3"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);
?>
<section class="invoice">
	<form role="form" id="my_form" action="index.php" method="post" enctype="multipart/form-data">
		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header"><?= $_REQUEST["param_menu1"]; ?> #<?= $_REQUEST["param_menu3"]; ?> [ DISPUTE
					QUANTITY ]</h2>
			</div><!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col">
				From
				<address>
					<strong><?= $data_header_supplier["name"]; ?></strong><br>
					<?= $data_header_supplier["address1"]; ?><br>
					<?= $data_header_supplier["address2"]; ?>, <?= $data_header_supplier["city"]; ?><br>
					Phone : <?= $data_header_supplier["phone"]; ?><br />
					Email : <?= $data_header_supplier["email"]; ?><br />
					Npwp : <?= $data_header_supplier["npwp"]; ?>
				</address>
			</div><!-- /.col -->
			<div class="col-sm-4 invoice-col">
				To
				<address>
					<strong><?= $_MAIN__CONFIGS_040[4] ?></strong><br>
					<strong>Store : <?= $data_header["store_code"] . " " . $data_header_store["name"]; ?></strong><br>
					<?= $data_header_store["address"]; ?><br>
					<?= $data_header_store["city"]; ?> <?= $data_header_store["zip_code"]; ?><br>
					Phone: <?= $data_header_store["phone"]; ?><br />
					Email: <?= $data_header_store["email"]; ?>
				</address>
			</div><!-- /.col -->
			<div class="col-sm-4 invoice-col">
				<b>Goods Receive Note No #<u><?= $_REQUEST["param_menu3"]; ?></u></b><br /><br />
				<table width="75%">
					<tr>
						<td><b>Supplier Code</b></td>
						<td> : </td>
						<td align="right"><?= $data_header_supplier["supplier_code"]; ?></td>
					<tr>
					<tr>
						<td><b>Order No</b></td>
						<td> : </td>
						<td align="right"><?= $data_header["purchase_order_no"]; ?></td>
					<tr>
					<tr>
						<td><b>Order Date</b></td>
						<td> : </td>
						<td align="right"><?= $data_header_po["document_date"]; ?></td>
					<tr>
					<tr>
						<td><b>Expected Delivery Date</b></td>
						<td> : </td>
						<td align="right"><?= $data_header_po["delivery_date"]; ?></td>
					<tr>
					<tr>
						<td><b>Received Date</b></td>
						<td> : </td>
						<td align="right"><?= $data_header["document_date"]; ?></td>
					<tr>
				</table>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<hr>
		<!-- Table row -->
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<TABLE class="table table-striped table-bordered">
					<THEAD>
						<tr valign="top">
							<th align="right"><b># NO</b></th>
							<th align="center"><b>PRODUCT_CODE</b></th>
							<th align="center"><b>BARCODE</b></th>
							<th align="center"><b>DESCRIPTION</b></th>
							<th align="right"><b>UNIT</b></th>
							<th align="right"><b>QTY ORDER</b></th>
							<td align="right"><b>QTY RECEIVED</b></td>
							<?php if ($data_header['revision_seq'] > 0) { ?>
								<th align="right"><b>REVISI 1 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 1) { ?>
								<th align="right"><b>REVISI 2 [GR]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 2) { ?>
								<th align="right"><b>REVISI 3 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 3) { ?>
								<th align="right"><b>REVISI 4 [GR]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 4) { ?>
								<th align="right"><b>REVISI 5 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 5) { ?>
								<th align="right"><b>REVISI 6 [GR]</b></th><?php } ?>
							<td align="right"><b>QTY REVISI</b></td>
						</tr>
					</THEAD>

					<TBODY>
						<?php if ($rs)
							while ($arr = $rs->FetchRow()) {

								$qty_rev1 = ($arr['qty_rev1'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev1']), 0) . "</span></h4>" : number_format(setNol($arr['qty_ori']), 0);
								$qty_rev2 = ($arr['qty_rev2'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev2']), 0) . "</span></h4>" : number_format(setNol($arr['qty_finish']), 0);
								$qty_rev3 = ($arr['qty_rev3'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev3']), 0) . "</span></h4>" : number_format(setNol($arr['qty_finish']), 0);
								$qty_rev4 = ($arr['qty_rev4'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev4']), 0) . "</span></h4>" : number_format(setNol($arr['qty_finish']), 0);
								$qty_rev5 = ($arr['qty_rev5'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev5']), 0) . "</span></h4>" : number_format(setNol($arr['qty_finish']), 0);
								$qty_rev6 = ($arr['qty_rev6'] >= 0) ? "<h4><span class='label label-success'>" . number_format(setNol($arr['qty_rev6']), 0) . "</span></h4>" : number_format(setNol($arr['qty_finish']), 0);
								?>
								<tr valign="top">
									<td align="right"><?= number_format($arr['line_item'], 0); ?></td>
									<td><?= $arr['product_code']; ?></td>
									<td><?= $arr['barcode']; ?></td>
									<td><?= $arr['description']; ?></td>
									<td><?= $arr['unit']; ?></td>
									<td align="right"><?= number_format($arr['po_quantity']); ?></td>
									<td align="right"><?= number_format($arr['quantity']); ?></td>
									<?php if ($data_header['revision_seq'] > 0) { ?>
										<td align="right"><?= $qty_rev1; ?></td><?php } ?>
									<?php if ($data_header['revision_seq'] > 1) { ?>
										<td align="right"><?= $qty_rev2; ?></td><?php } ?>
									<?php if ($data_header['revision_seq'] > 2) { ?>
										<td align="right"><?= $qty_rev3; ?></td><?php } ?>
									<?php if ($data_header['revision_seq'] > 3) { ?>
										<td align="right"><?= $qty_rev4; ?></td><?php } ?>
									<?php if ($data_header['revision_seq'] > 4) { ?>
										<td align="right"><?= $qty_rev5; ?></td><?php } ?>
									<?php if ($data_header['revision_seq'] > 5) { ?>
										<td align="right"><?= $qty_rev6; ?></td><?php } ?>
									<td align="right"><input type="text" name="qty_rev[<?= $arr['product_code']; ?>]"
											placeholder="only different qty" size="12"></td>

								</tr>
							<?php } ?>
					</TBODY>
				</TABLE>
				<input type="hidden" name="main" value="040">
				<input type="hidden" name="main_act" value="010">
				<input type="hidden" name="main_id" value="400402_02_04">
				<input type="hidden" name="goods_receive_no" value="<?= $_REQUEST["param_menu3"]; ?>">
				<input type="hidden" name="revision_seq" value="<?= $data_header["revision_seq"]; ?>">

			</div><!-- /.col -->
		</div><!-- /.row -->

		<hr>
		<div class="row no-print">
			<div class="col-xs-12">
				<label>Notes :</label></br>
				<textarea name="notes" rows="4" style="width:98%"></textarea>
				<hr>
			</div>

			<div class="col-xs-12">
				<div class="box-tools pull-right">
					<a class="btn btn-default btn-flat btn-sm btn-info"
						onclick="cobayy('GOODS+RECEIVE','400402','<?= $_REQUEST["param_menu3"]; ?>&param_menu4=2');"><i
							class="fa fa-edit"></i> <b>BACK TO LIST GR</b></a>
					<button type="submit" class="btn btn-default btn-flat btn-sm btn-info"><i class="fa fa-edit"></i>
						<b>SUBMIT DISPUTE QUANTITY</b></button>
				</div>
			</div>
		</div>

	</form>
</section><!-- /.content -->
<div class="clearfix"></div>
<script>
	$("#my_form").submit(function (event) {
		alert('data disubmit');
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
			alert(response);
			if (response == 'success') {
				alert('Dispute quantity Sudah diproses, Menunggu confirm dari Goods receiving ELECTRONIC-CITY ...');
				cobayy('DISPUTE+QTY', '400402', '');
			}
			else {
				alert('Gagal dispute quantity proses...');
				return false;
			}
		});
	});
</script>