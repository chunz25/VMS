<?php
include_once('inc_condition.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400402_02 = "SELECT * FROM proforma_invoice_all_status_v where ( status_pfi in ('31','34') ) and document_status is null " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);

?>
<!-- Content Header (Page header) -->
<!-- Main content -->
<?php // echo $sql_400402_02;
?>
<TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>GRN NO</b></td>

			<td align="center"><b>STORE</b></td>
			<td align="center"><b>SUPPLIER CODE</b></td>
			<td align="center"><b>SUPPLIER NAME</b></td>
			<td align="center"><b>DEPARTMENT</b></td>
			<td align="center"><b>RECEIVED DATE</b></td>
			<td align="center"><b>AMOUNT</b></td>
			<td align="center"><b>VAT AMOUNT</b></td>
			<td align="center"><b>AMOUNT</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) { ?>
			<tr valign="top">
				<td><?php echo $arr['purchase_order_no']; ?></td>
				<td><?php echo $arr['goods_receive_no']; ?></td>

				<td><?php echo $arr['store_code']; ?></td>
				<td><?php echo $arr['supplier_code']; ?></td>
				<td><?php echo $arr['supplier_name']; ?></td>
				<td><?php echo $arr['department']; ?></td>
				<td><?php echo $arr['document_date']; ?></td>
				<td><?php echo number_format($arr['total_amount'], 2); ?></td>
				<td align="right"><?php echo number_format($arr['vat_amount'], 2); ?></td>
				<td align="right"><?php echo number_format($arr['grand_total'], 2); ?></td>
				<td align="center"><?php // echo $arr['status_pfi'];
									?>
					<?php
					if ($arr['status_pfi'] == '34') {
					?>
						<button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('SETTLEMENT+PRICE','400403_02_01','<?php echo $arr['proforma_invoice_no']; ?>&param_menu4=<?php echo $arr['status_pfi']; ?>');">Proses </button>
					<?php
					} else {
					?>
						<button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('SETTLEMENT+PRICE','400403_01_01','<?php echo $arr['proforma_invoice_no']; ?>');">Proses</button>
					<?php
					}
					?>

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