<?php
include_once('inc_condition.php');

$sql_400401_02 = "SELECT a.*,b.reason, s.name as store_name FROM purchase_order a
LEFT JOIN purchase_order_req_cancel b ON a.purchase_order_no = b.purchase_order_no
LEFT JOIN store s ON s.code = a.store_code
WHERE a.status_po='13' " . $sql_400401_01;
$rs = $db->Execute($sql_400401_02);
?>
<TABLE id="tbl02" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>STORE NAME</b></td>
			<td align="center"><b>DEPARTMENT</b></td>
			<td align="center"><b>SUPPLIER <br> CODE</b></td>
			<td align="center"><b>SUPPLIER <br> NAME</b></td>
			<td align="center"><b>DOC DATE</b></td>
			<td align="center"><b>DELIVERY <br> DATE</b></td>
			<td align="center"><b>AMOUNT</b></td>
			<td align="center"><b>VAT</b></td>
			<td align="center"><b>TOTAL</b></td>
			<td align="center"><b>DESC</b></td>
			<td align="center"><b>REASON</b></td>
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
					<td><?= $arr['store_name']; ?></td>
					<td><?= $arr['department']; ?></td>
					<td align="center"><?= $arr['supplier_code']; ?></td>
					<td align=""><?= $arr['supplier_name']; ?></td>
					<td align="center"><?= $arr['document_date']; ?></td>
					<td align="center"><?= $arr['delivery_date']; ?></td>
					<td align="right"><?= number_format($arr['total_amount'], 0, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['total_vat_amount'], 0, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['grand_total'], 0, ',', '.'); ?></td>
					<td align="center"><?= $arr['header_text']; ?></td>
					<td align="center"><?= $arr['reason']; ?></td>
					<td align="center"><span class="label label-danger"><?= "Req Cancel" ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('PURCHASE+ORDER','400401_02_01','<?= $arr['purchase_order_no']; ?>');">View
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