<?php

// data GRN Header -------------
$sql001 = '"select * from goods_receive where goods_receive_no=' . "'" . $_REQUEST["param_menu3"] . "'" . '"';
// echo ($_MAIN__CONFIGS_030[5].' -s '.$sql001);
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

// data PO Header ----------------

$sql005 = '"select * from purchase_order where purchase_order_no=' . "'" . $data_header["purchase_order_no"] . "'" . '"';
$exec_sql005 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql005);
$json_exec_sql005 = json_decode($exec_sql005, true);
$data_header_po = $json_exec_sql005["rows"][0];
// print_r($data_header_po);

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002["rows"][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
// echo ($_MAIN__CONFIGS_030[5].' -s '.$sql003);
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003["rows"][0];

// data GRN line -------------
$sql004 = "SELECT * FROM goods_receive_item WHERE goods_receive_no='" . $_REQUEST["param_menu3"] . "' order by CAST(line_item AS UNSIGNED)";
$rs = $db->Execute($sql004);

?>
<!-- Main content -->
<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<?php echo $_REQUEST["param_menu1"]; ?> #<?php echo $_REQUEST["param_menu3"]; ?>
			</h2>
		</div><!-- /.col -->
	</div>
	<!-- info row -->
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			From
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
			To
			<address>
				<strong><?php echo $_MAIN__CONFIGS_040[4] ?></strong><br>
				<strong>Store : <?php echo $data_header["store_code"] . " " . $data_header_store["name"]; ?></strong><br>
				<?php echo $data_header_store["address"]; ?><br>
				<?php echo $data_header_store["city"]; ?> <?php echo $data_header_store["zip_code"]; ?><br>
				Phone: <?php echo $data_header_store["phone"]; ?><br />
				Email: <?php echo $data_header_store["email"]; ?>
			</address>
		</div><!-- /.col -->
		<div class="col-sm-4 invoice-col">
			<b>Goods Receive Note No #<u><?php echo $_REQUEST["param_menu3"]; ?></u></b><br /><br />
			<table width="75%">
				<tr>
					<td><b>Supplier Code</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header_supplier["supplier_code"]; ?></td>
				<tr>
				<tr>
					<td><b>Order No</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header["purchase_order_no"]; ?></td>
				<tr>
				<tr>
					<td><b>Order Date</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header_po["document_date"]; ?></td>
				<tr>
				<tr>
					<td><b>Estimate Receive Date</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header_po["delivery_date"]; ?></td>
				<tr>
				<tr>
					<td><b>Received Date</b></td>
					<td> : </td>
					<td align="right"><?php echo $data_header["document_date"]; ?></td>
				<tr>
			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<?php // echo $sql002;
			?>
			<TABLE class="table table-striped  table-bordered">
				<THEAD>
					<tr valign="top">
						<th align="right"><b># NO</b></th>
						<th align="center"><b>PRODUCT_CODE</b></th>
						<th align="center"><b>BARCODE</b></th>
						<th align="center"><b>DESCRIPTION</b></th>
						<th align="right"><b>UNIT</b></th>
						<th align="right"><b>QUANTITY ORDER</b></th>
						<th align="right"><b>QUANTITY RECEIVED</b></th>
						<th align="right"><b>SERVICE LEVEL</b></th>
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
							<td><?php echo $arr['unit']; ?></td>
							<td align="right"><?php echo number_format($arr['po_quantity']); ?></td>
							<td align="right"><?php echo number_format($arr['quantity']); ?></td>
							<td align="right"><?php echo number_format(($arr['quantity'] / $arr['po_quantity']) * 100); ?>%</td>
						</tr>
					<?php } ?>
				</TBODY>
			</TABLE>
		</div><!-- /.col -->
	</div><!-- /.row -->
	<hr>
	<div class="row">
		<!-- accepted payments column -->
		<div class="col-xs-6">
			<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
				<b> Note :</b> <br>
				- Jika Qty received tidak sesuai silahkan lakukan settlement dengan mengklik tombol "Dispute Quantity"<br>
			</p>
		</div><!-- /.col -->

	</div><!-- /.row -->
	<hr>
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<div class="box-tools pull-left">
				<!-- button 1 --------- -->
				<a class="btn btn-default btn-flat btn-sm btn-info" onclick="cobayy('GOODS+RECEIVE','400402','&param_menu4=1');"><i class="fa fa-edit"></i> <b>BACK TO LIST GR</b></a>
				<!-- button 2 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_90&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil3');"><i class="fa fa-print"></i> <b>PRINT PO</b></a>
				<!-- button 3 ---------- sementara di hidden dulu
					<a class="btn btn-default btn-flat btn-sm btn-default"  onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91&goods_receive_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i class="fa fa-print"></i> <b>PRINT GRN</b></a> -->
				<a class="btn btn-default btn-flat btn-sm btn-default" onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400401_91&gr_no=<?php echo urlencode($data_header['goods_receive_no']); ?>&po_no=<?php echo urlencode($data_header['purchase_order_no']); ?>','','#tampil4');"><i class="fa fa-print"></i> <b>PRINT RN</b></a>

			</div>

			<div class="box-tools pull-right">
				<!-- button 4 ---------- -->
				<a class="btn btn-default btn-flat btn-sm btn-warning" onclick="process_next(
					'Apakah Data quantity sudah benar dan sesuai...?',
					'index.php',
					'400402_01_02',
					'<?php echo $_REQUEST["param_menu3"]; ?>',
					'Data Berhasil Disimpan, Proses selanjutnya.. Settlement Price ',
					'SETTLEMENT+PRICE',
					'400403_01_01',
					'PFI.<?php echo $_REQUEST["param_menu3"]; ?>',
					'Gagal Data Proses masuk ke system, Silahkan dicoba lagi. '
					)"><i class="fa fa-edit"></i> <b>SETTLEMENT QTY CONFIRM</b></a>
				<!-- button 5 -------- -->
				<a class="btn btn-default btn-flat btn-sm btn-danger" onclick="dispute_process('Apakah Anda Yakin akan memproses dispute quantity.... ?','GOODS+RECEIVE','400402_01_03','<?php echo $data_header['goods_receive_no']; ?>')"><i class="fa fa-edit"></i><b>DISPUTE QUANTITY</b></a>
			</div>
		</div>
	</div>
</section><!-- /.content -->
<div class="clearfix"></div>
<div id="tempatmodal"></div>