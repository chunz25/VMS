<?php
include_once('inc_condition.php');

$sql_400402_02 = "SELECT * FROM proforma_invoice_all_status_v where ( status_pfi in('32','33') ) and document_status is null " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);

?>
<!-- Content Header (Page header) -->
<!-- Main content -->
<TABLE id="tbl02" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>GRN NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>STORE NAME</b></td>
			<td align="center"><b>SUPPLIER_CODE</b></td>
			<td align="center"><b>SUPPLIER_NAME</b></td>
			<td align="center"><b>DEPARTMENT</b></td>
			<td align="center"><b>RECEIVED DATE</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>SEQ</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) {
				$view_action = ($arr['status_pfi'] == 33) ? "Proses" : "View";
				$view_status = ($arr['status_pfi'] == 33) ? "Dispute Prc By Electronic City" : "Dispute Prc By Supplier";
				?>
				<tr valign="top">
					<td><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['goods_receive_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td><?= $arr['store_name']; ?></td>
					<td><?= $arr['supplier_code']; ?></td>
					<td><?= $arr['supplier_name']; ?></td>
					<td><?= $arr['department']; ?></td>
					<td><?= $arr['document_date']; ?></td>

					<td align="center"><span class="label label-info"><?= $view_status; ?></span></td>
					<td align="center"><span class="label label-info"><?= $arr['revision_seq']; ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('SETTLEMENT+PRICE','400403_02_01','<?= $arr['proforma_invoice_no']; ?>&param_menu4=<?= $arr['status_pfi']; ?>');"><?= $view_action; ?>
						</button></td>
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