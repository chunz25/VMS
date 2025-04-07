<?php
// data PO Header -------------
$sql001 = '"select * from goods_return where goods_return_no=' . "'" . $_REQUEST["param_menu3"] . "' and backorder_flag='" . $_REQUEST["param_menu4"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

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

// data PO line -------------
$sql002 = "SELECT * FROM goods_return_item WHERE goods_return_no='" . $_REQUEST["param_menu3"] . "' and version=1 and backorder_flag='" . $_REQUEST["param_menu4"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql002);
?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header"><?= $_REQUEST["param_menu1"]; ?> #<?= $data_header["document_no"]; ?></h2>
		</div><!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			From
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
			To
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
			<b>Return No #<u><?= $data_header["document_no"]; ?></u></b><br /><br />
			<table width="75%">
				<tr>
					<td><b>Supplier Code</b></td>
					<td> : </td>
					<td align="right"><?= $data_header_supplier["supplier_code"]; ?></td>
				<tr>
				<tr>
					<td><b>Return Date</b></td>
					<td> : </td>
					<td align="right"><?= $data_header["document_date"]; ?></td>
				<tr>
				<tr>
					<td><b>Delivery Date</b></td>
					<td> : </td>
					<td align="right"><?= $data_header["delivery_date"]; ?></td>
				<tr>
			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
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
						</tr>
					</THEAD>
					<TBODY>
						<?php if ($rs)
							while ($arr = $rs->FetchRow()) { ?>
								<tr valign="top">
									<td align="right"><?= number_format($arr['line_item'], 0); ?></td>
									<td><?= $arr['product_code']; ?></td>
									<td><?= $arr['barcode']; ?></td>
									<td><?= $arr['description']; ?></td>
									<td align="right"><?= number_format($arr['tax_pct'], 0); ?></td>
									<td align="right"><?= number_format($arr['quantity']); ?></td>
									<td align="right"><?= number_format($arr['unit_price']); ?></td>
									<td align="right"><?= number_format($arr['amount']); ?></td>
									<td align="right"><?= number_format($arr['vat_amount']); ?></td>
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
						<th style="width:50%">Subtotal excl tax</th>
						<td align="right"><?= number_format($data_header["total_amount"], 2); ?></td>
					</tr>
					<tr>
						<th>Tax</th>
						<td align="right"><?= number_format($data_header["vat_amount"], 2); ?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td align="right"><?= number_format($data_header["grand_total"], 2); ?></td>
					</tr>
				</table>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<div class="box-tools pull-left">
				<!-- button 1 --------- -->
				<a class="btn btn-default btn-flat btn-sm btn-info"
					onclick="cobayy('RETURN+PROCESS','400501','<?= $_REQUEST["param_menu3"]; ?>&param_menu4=1');"><i
						class="fa fa-edit"></i><b>BACK TO LIST RETURN</b></a>
				<!-- button 2 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_92&po_no=<?= urlencode($data_header['goods_return_no']); ?>&bf=<?= urlencode($data_header['backorder_flag']); ?>','','#tampil5');"><i
						class="fa fa-print"></i> <b>RETURN</b></a>
				<!-- button 3 --------- -->

				<a class="btn btn-default btn-flat btn-sm btn-default"
					onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?= urlencode($data_header['po_no_original']); ?>','','#tampil3');"><i
						class="fa fa-print"></i> <b>PO ORIGINAL</b></a>
			</div>
		</div>
	</div>
	<!-- this row will not appear when printing -->
	<div id="tempatmodal"></div>
</section><!-- /.content -->
<div class="clearfix"></div>