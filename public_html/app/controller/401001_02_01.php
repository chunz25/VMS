<?php
// data GRN Header -------------
$sql001 = '"select * from proforma_invoice where proforma_invoice_no=' . "'" . $_REQUEST["param_menu3"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001['rows'][0];

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
$sql002 = "SELECT * FROM proforma_invoice_item WHERE proforma_invoice_no='" . $_REQUEST["param_menu3"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql002);

$indeks_notesnya = "notes_rev" . $data_header['revision_seq'];
$indeks_revnya = "unit_price_rev" . $data_header['revision_seq'];
$notesnya = $data_header[$indeks_notesnya];

?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header"><?= $_REQUEST["param_menu1"]; ?> #<?= $_REQUEST["param_menu3"]; ?> [Dispute Price
				Finished]</h2>
		</div><!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			From
			<address>
				<strong><?= $data_header_supplier['name']; ?></strong><br>
				<?= $data_header_supplier['address1']; ?><br>
				<?= $data_header_supplier['address2']; ?>, <?= $data_header_supplier['city']; ?><br>
				Phone : <?= $data_header_supplier['phone']; ?><br />
				Email : <?= $data_header_supplier['email']; ?><br />
				Npwp : <?= $data_header_supplier['npwp']; ?>
			</address>
		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			To
			<address>
				<strong><?= $_MAIN__CONFIGS_040[4] ?></strong><br>
				<strong>Store : <?= $data_header['store_code'] . " " . $data_header_store['name']; ?></strong><br>
				<?= $data_header_store['address']; ?><br>
				<?= $data_header_store['city']; ?> <?= $data_header_store['zip_code']; ?><br>
				Phone: <?= $data_header_store['phone']; ?><br />
				Email: <?= $data_header_store['email']; ?>
			</address>
		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<b>Proforma Invoice No #<u><?= $_REQUEST["param_menu3"]; ?></u></b><br />
			<br />
			<table width="75%">
				<tr>
					<td><b>Supplier Code</b></td>
					<td> : </td>
					<td align="right"><?= $data_header_supplier['supplier_code']; ?></td>
				<tr>
				<tr>
					<td><b>PO No</b></td>
					<td> : </td>
					<td align="right"><?= $data_header['purchase_order_no']; ?></td>
				<tr>
				<tr>
					<td><b>GRN No</b></td>
					<td> : </td>
					<td align="right"><?= $data_header['goods_receive_no']; ?></td>
				<tr>

				<tr>
					<td><b>Received Date</b></td>
					<td> : </td>
					<td align="right"><?= $data_header['document_date']; ?></td>
				<tr>

			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<?php // echo $sql002; ?>
				<TABLE class="table table-striped table-bordered">
					<THEAD>
						<tr valign="top">
							<th align="right"><b># NO</b></th>
							<th align="center"><b>PRODUCT_CODE</b></th>
							<th align="center"><b>BARCODE</b></th>
							<th align="center"><b>DESCRIPTION</b></th>
							<th align="right"><b>TAX RATE(%)</b></th>
							<th align="right"><b>QUANTITY</b></th>
							<th align="right"><b>UNIT PRICE</b></th>
							<?php if ($data_header['revision_seq'] > 0) { ?>
								<th align="right"><b>REVISI 1 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 1) { ?>
								<th align="right"><b>REVISI 2 [BUYER]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 2) { ?>
								<th align="right"><b>REVISI 3 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 3) { ?>
								<th align="right"><b>REVISI 4 [BUYER]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 4) { ?>
								<th align="right"><b>REVISI 5 [SUPP]</b></th><?php } ?>
							<?php if ($data_header['revision_seq'] > 5) { ?>
								<th align="right"><b>REVISI 6 [BUYER]</b></th><?php } ?>
							<th align="right"><b>AMOUNT</b></th>
							<th align="right"><b>TAX AMOUNT</b></th>
						</tr>
					</THEAD>
					<TBODY>
						<?php
						$total_amountnya = 0;
						$total_vat_amountnya = 0;
						$total_subtotalnya = 0;

						if ($rs)
							while ($arr = $rs->FetchRow()) {
								$qty_rev1 = ($arr['unit_price_rev1'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev1']) . "</span></h4>" : number_format($arr['unit_price_ori']);
								$qty_rev2 = ($arr['unit_price_rev2'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev2']) . "</span></h4>" : number_format($arr['unit_price_finish']);
								$qty_rev3 = ($arr['unit_price_rev3'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev3']) . "</span></h4>" : number_format($arr['unit_price_finish']);
								$qty_rev4 = ($arr['unit_price_rev4'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev4']) . "</span></h4>" : number_format($arr['unit_price_finish']);
								$qty_rev5 = ($arr['unit_price_rev5'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev5']) . "</span></h4>" : number_format($arr['unit_price_finish']);
								$qty_rev6 = ($arr['unit_price_rev6'] > 0) ? "<h4><span class='label label-success'>" . number_format($arr['unit_price_rev6']) . "</span></h4>" : number_format($arr['unit_price_finish']);

								$unit_pricenya = ($arr[$indeks_revnya] > 0) ? $arr[$indeks_revnya] : $arr['unit_price'];
								$amountnya = $unit_pricenya * $arr['quantity'];
								$vat_amountnya = $amountnya * ($arr['tax_pct'] / 100);
								$subtotalnya = $amountnya + $vat_amountnya;

								$total_amountnya = $total_amountnya + $amountnya;
								$total_vat_amountnya = $total_vat_amountnya + $vat_amountnya;
								$total_subtotalnya = $total_subtotalnya + $subtotalnya;
								?>
								<tr valign="top">
									<td align="right"><?= number_format($arr['line_item'], 0); ?></td>
									<td><?= $arr['product_code']; ?></td>
									<td><?= $arr['barcode']; ?></td>
									<td><?= $arr['description']; ?></td>
									<td align="right"><?= number_format($arr['tax_pct'], 0); ?></td>
									<td align="right"><?= number_format($arr['quantity']); ?></td>
									<td align="right"><?= number_format($arr['unit_price']); ?></td>
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
									<td align="right"><?= number_format($amountnya, 2); ?></td>
									<td align="right"><?= number_format($vat_amountnya, 2); ?></td>
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
				<?= $notesnya; ?> <br>
			</p>
		</div><!-- /.col -->
		<div class="col-xs-6">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:50%">Subtotal excl tax</th>
						<td align="right"><?= number_format($total_amountnya, 2); ?></td>
					</tr>
					<tr>
						<th>Tax</th>
						<td align="right"><?= number_format($total_vat_amountnya, 2); ?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td align="right"><?= number_format($total_subtotalnya, 2); ?></td>
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
					onclick="cobayy('DISPUTE+PRICE','401001','&param_menu4=2');"><i class="fa fa-edit"></i> <b>BACK TO
						LIST DISPUTE PRICE</b></a>
				<!-- button 2 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?= urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i
						class="fa fa-print"></i> <b>PO</b></a>
				<!-- button 3 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91&goods_receive_no=<?= urlencode($data_header['goods_receive_no']); ?>&po_no=<?= urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i
						class="fa fa-print"></i> <b>GRN</b></a>
			</div>
			<div class="box-tools pull-right">
				&nbsp;
			</div>
		</div>
	</div>
</section><!-- /.content -->
<div class="clearfix"></div>
<div id="tempatmodal"></div>