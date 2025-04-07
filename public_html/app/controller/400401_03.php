<?php
include_once('inc_condition.php');
$sql_400401_02 = "SELECT * FROM purchase_order_all_status_v where ( status_po <> '14' or status_po is null ) and document_status is not null " . $sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02);
?>
<TABLE id="tbl03" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>SUPPLIER <br> CODE</b></td>
			<td align="center"><b>DOC DATE</b></td>
			<td align="center"><b>DELIVERY <br> DATE</b></td>
			<td align="center"><b>AMOUNT</b></td>
			<td align="center"><b>VAT</b></td>
			<td align="center"><b>TOTAL</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) { ?>
				<tr valign="top">
					<td align="center"><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td align="center"><?= $arr['supplier_code']; ?></td>
					<td align="center"><?= $arr['document_date']; ?></td>
					<td align="center"><?= $arr['delivery_date']; ?></td>
					<td align="right"><?= number_format($arr['total_amount'], 2, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['total_vat_amount'], 2, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['grand_total'], 2, ',', '.'); ?></td>
					<td align="center"><span class="label label-danger"><?= "Cancelled" ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('PURCHASE+ORDER','400401_03_01','<?= $arr['purchase_order_no']; ?>');">View
							Detail</button></td>
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