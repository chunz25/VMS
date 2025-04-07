<?php
include_once($_MAIN__CONFIGS_000[4] . 'inc_condition.php');

$sql_400401_02 = "SELECT * FROM purchase_order_all_status_v where ( status_po in ('10','11','12') or status_po is null ) and document_status is null " . $sql_400401_01;
$rs = $db->Execute($sql_400401_02);
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
			<td align="center"><b>EST <br> DELIVERY <br> DATE</b></td>
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
						$status_po = "On Process";
						break;
					case '12':
						$status_po = "On Process";
						break;
					default:
						$status_po = "NEW";
						break;
				}
				?>
				<tr valign="top">
					<td align="center"><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td><?= $arr['department']; ?></td>
					<td align="center"><?= $arr['supplier_code']; ?></td>
					<td align=""><?= $arr['supplier_name']; ?></td>
					<td align="center"><?= $arr['document_date']; ?></td>
					<td align="center"><?= $arr['delivery_date']; ?></td>
					<td align="right"><?= number_format($arr['total_amount'], 0, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['total_vat_amount'], 0, ',', '.'); ?></td>
					<td align="right"><?= number_format($arr['grand_total'], 0, ',', '.'); ?></td>
					<td align="center"><?= $arr['header_text']; ?></td>
					<td align="center"><span class="label label-info"><?= $status_po; ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('PURCHASE+ORDER','400401_01_01','<?= $arr['purchase_order_no']; ?>');">Proses</button>
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