<?php
include_once($_MAIN__CONFIGS_000[4] . 'inc_condition.php');

// $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
$sql_400401_02 = "SELECT * FROM purchase_order_all_status_v where ( status_po in ('14','99') ) " . $sql_400401_01;
//die($sql_400401_02);
$rs = $db->Execute($sql_400401_02);
?>

<?php  //echo $sql_400401_02;
?>
<TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>DEPARTMENT</b></td>
			<td align="center"><b>SUPPLIER <br> CODE</b></td>
			<td align="center"><b>SUPPLIER <br> NAME</b></td>
			<td align="center"><b>DOC DATE</b></td>
			<td align="center"><b>DELIVERY <br> DATE</b></td>
			<td align="center"><b>AMOUNT</b></td>
			<td align="center"><b>VAT</b></td>
			<td align="center"><b>TOTAL</b></td>
			<td align="center"><b>DESC</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) {

				switch ($arr['status_po']) {
					case '10':
						$status_po = "NEW";
						break;
					case '11':
						$status_po = "Ready To Print";
						break;
					case '12':
						$status_po = "Ready To Delivery";
						break;
					case '13':
						$status_po = "Req To Cancel";
						break;
					case '14':
						$status_po = "Delivered";
						break;
					default:
						$status_po = "Delivered";
						break;
				}
		?>
			<tr valign="top">
				<td align="center"><?php echo $arr['purchase_order_no']; ?></td>
				<td><?php echo $arr['store_code']; ?></td>
				<td><?php echo $arr['department']; ?></td>
				<td align="center"><?php echo $arr['supplier_code']; ?></td>
				<td align="center"><?php echo $arr['supplier_name']; ?></td>
				<td align="center"><?php echo $arr['document_date']; ?></td>
				<td align="center"><?php echo $arr['delivery_date']; ?></td>
				<td align="right"><?php echo number_format($arr['total_amount'], 0, ',', '.'); ?></td>
				<td align="right"><?php echo number_format($arr['total_vat_amount'], 0, ',', '.'); ?></td>
				<td align="right"><?php echo number_format($arr['grand_total'], 0, ',', '.'); ?></td>
				<td align="center"><?php echo $arr['header_text']; ?></td>
				<td align="center"><span class="label label-info"><?php echo $status_po; ?></span></td>
				<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('PURCHASE+ORDER','401302_01_01','<?php echo $arr['purchase_order_no']; ?>');">View</button></td>
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