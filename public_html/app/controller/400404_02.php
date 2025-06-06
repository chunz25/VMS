<?php
include_once('inc_condition.php');

$sql_400402_02 = "SELECT * FROM goods_receive_all_status_v where  status_grn in ('22','23')  and document_status is null " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);
?>
<!-- Content Header (Page header) -->
<!-- Main content -->


<?php // echo $sql_400402_02; ?>
<TABLE id="tbl02" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>GRN NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>SUPPLIER_CODE</b></td>
			<td align="center"><b>ORDER_DATE</b></td>
			<td align="center"><b>EST DELIVERY DATE</b></td>
			<td align="center"><b>RECEIVED DATE</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) { ?>
				<tr valign="top">
					<td><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['goods_receive_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td><?= $arr['supplier_code']; ?></td>
					<td><?= $arr['document_date']; ?></td>
					<td><?= $arr['document_date']; ?></td>
					<td><?= $arr['document_date']; ?></td>
					<td align="center"><span class="label label-info"><?= "NEW" ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('GOODS+RECEIVE','400402_00_01','<?= $arr['goods_receive_no']; ?>');">Proses</button>
					</td>
				</tr>
			<?php } ?>
	</TBODY>
</TABLE>

<div id="tempatmodal"></div>
<div id="loading" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body" align="center">
				<img src="_images/ajax-loader.gif">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#tbl02').dataTable();
</script>