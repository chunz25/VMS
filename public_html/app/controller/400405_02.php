<?php
include_once('inc_condition2.php');
if ($_POST['par'] == 'tabcontent2') {
	$sql_rtp = "SELECT a.*, s.name as store_name FROM sap_ready_to_pay a
				LEFT JOIN store s ON s.code = a.store_code 
				where invoice_no is not null AND invoice_no <> '' AND company_code='EC01' " . $sql_400401_01;
	$rs = $db->Execute($sql_rtp);
}
?>
<div class="box-body table-responsive" style="padding:2px;">
	<TABLE id="tbl02" class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
			<tr valign="top">
				<td align="center"><b>RS NO</b></td>
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>GRN NO</b></td>
				<td align="center"><b>INV NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>STORE NAME</b></td>
				<td align="center"><b>SUPPLIER_CODE</b></td>
				<td align="center"><b>SUPPLIER_NAME</b></td>
				<td align="center"><b>INVOICE_DATE</b></td>
				<td align="center"><b>DUE DATE</b></td>
				<td align="center"><b>INVOICE AMOUNT</b></td>
			</tr>
		</THEAD>
		<TBODY>
			<?php if ($rs)
				while ($arr = $rs->FetchRow()) { ?>
					<tr valign="top">
						<td><?= $arr['reference_no']; ?></td>
						<td><?= $arr['purchase_order_no']; ?></td>
						<td><?= $arr['goods_receive_no']; ?></td>
						<td><?= $arr['invoice_no']; ?></td>
						<td><?= $arr['store_code']; ?></td>
						<td><?= $arr['store_name']; ?></td>
						<td><?= $arr['supplier_code']; ?></td>
						<td><?= $arr['supplier_name']; ?></td>
						<td align="center"><?= $arr['posting_date']; ?></td>
						<td align="center"><?= $arr['due_date']; ?></td>
						<td align="right"><?= number_format($arr['amount'], 2); ?></td>
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

<script type="text/javascript">
	$('#tbl02').dataTable();
</script>