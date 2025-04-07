<?php
include_once('inc_condition2.php');

$sql_400402_02 = "SELECT * FROM payment_po_all_v where  payment_amount is not null " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);

?>
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="box-body table-responsive" style="padding:2px;">
	<TABLE id="tbl03" class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			<tr valign="top">
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>INV NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER CODE</b></td>
				<td align="center"><b>SUPPLIER NAME</b></td>
				<td align="center"><b>INVOICE DATE</b></td>
				<td align="center"><b>DUE DATE</b></td>
				<td align="center"><b>INVOICE AMOUNT</b></td>
				<td align="center"><b>PAYMENT AMOUNT</b></td>
				<td align="center"><b>PAID DATE</b></td>
				<td align="center"><b>PAYMENT NO</b></td>
			</tr>
		</THEAD>
		<TBODY>
			<?php if ($rs)
				while ($arr = $rs->FetchRow()) { ?>
					<tr valign="top">
						<td><?= $arr['purchase_order_no']; ?></td>
						<td><?= $arr['goods_receive_no']; ?></td>
						<td><?= $arr['invoice_no']; ?></td>
						<td><?= $arr['store_code']; ?></td>
						<td><?= $arr['supplier_code']; ?></td>
						<td><?= $arr['supplier_name']; ?></td>
						<td align="center"><?= $arr['posting_date']; ?></td>
						<td align="center"><?= $arr['due_date']; ?></td>
						<td align="right"><?= number_format($arr['amount'], 2); ?></td>
						<td align="right"><?= number_format($arr['payment_amount'], 2); ?></td>
						<td align="center"><?= $arr['paid_date']; ?></td>
						<td align="center"><?= $arr['payment_no']; ?></td>

					</tr>
				<?php } ?>
		</TBODY>
	</TABLE>
</div>

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