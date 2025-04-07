<?php
include_once('inc_condition.php');

$sql_400402_02 = "SELECT * FROM invoice_all_status_v where ( status_inv in ('41') or status_inv is null ) and document_status is null" . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);
?>
<div class="box-body table-responsive" style="padding:4px;">
	<TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			<tr valign="top">
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>PFI NO</b></td>
				<td align="center"><b>INVOICE NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER_CODE</b></td>
				<td align="center"><b>AMOUNT</b></td>
				<td align="center"><b>VAT AMOUNT</b></td>
				<td align="center"><b>GRAND TOTAL</b></td>
				<td align="center"><b>ACTION</b></td>
			</tr>
		</THEAD>
		<TBODY>
			<?php if ($rs)
				while ($arr = $rs->FetchRow()) { ?>
					<tr valign="top">
						<td><?= $arr['purchase_order_no']; ?></td>
						<td><?= $arr['goods_receive_no']; ?></td>
						<td><?= $arr['proforma_invoice_no']; ?></td>
						<td><?= $arr['invoice_no']; ?></td>
						<td><?= $arr['store_code']; ?></td>
						<td><?= $arr['supplier_code']; ?></td>
						<td align="right"><?= number_format($arr['total_amount'], 2); ?></td>
						<td align="right"><?= number_format($arr['vat_amount'], 2); ?></td>
						<td align="right"><?= number_format($arr['grand_total'], 2); ?></td>
						<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal"
								data-target="#add01"
								onclick="cobayy('INVOICE','400404_01_01','<?= $arr['invoice_no']; ?>');">Proses</button></td>
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