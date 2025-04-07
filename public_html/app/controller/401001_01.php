<?php
$dept = $_SESSION['lock1'] . $_SESSION['lock2'] . $_SESSION['lock3'];
switch ($_SESSION['tb_id_user_type']) {
	case 1: // admin
		$sql_400402_01 = " ";
		break;
	case 2: // buyer
		$sql_400402_01 = "  AND '" . $dept . "' like concat('%', department ,'%') ";
		break;
	case 3: // finance
		$sql_400402_01 = " ";
		break;
	case 4:
		$sql_400402_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
		break;
	case 5:
		$sql_400402_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
		break;
}

$sql_400402_02 = "SELECT a.* FROM proforma_invoice_all_status_v a  where ( a.status_pfi in('33','32') ) and a.document_status is null" . $sql_400402_01;
$rs = $db->Execute($sql_400402_02);

?>
<TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
	<THEAD>
		<tr valign="top">
			<td align="center"><b>PO NO</b></td>
			<td align="center"><b>RN NO</b></td>
			<td align="center"><b>STORE</b></td>
			<td align="center"><b>SUPPLIER_CODE</b></td>
			<td align="center"><b>SUPPLIER_NAME</b></td>
			<td align="center"><b>RECEIVED DATE</b></td>
			<td align="center"><b>DEPARTMENT</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>SEQ</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) {
				$view_action = ($arr['status_pfi'] == 32) ? "Proses" : "View";
				$view_status = ($arr['status_pfi'] == 32) ? "Dispute Price By Supplier" : "Dispute Price By Electronic-City";
				// $view_status=$arr['status_pfi'];
				?>
				<tr valign="top">
					<td><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['goods_receive_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td><?= $arr['supplier_code']; ?></td>
					<td><?= $arr['supplier_name']; ?></td>
					<td><?= $arr['document_date']; ?></td>
					<td><?= $arr['department']; ?></td>
					<td align="center"><span class="label label-info"><?= $view_status; ?></span></td>
					<td align="center"><span class="label label-info"><?= $arr['revision_seq']; ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('DISPUTE+PRICE','401001_01_01','<?= $arr['proforma_invoice_no']; ?>&param_menu4=<?= $arr['status_pfi']; ?>');"><?= $view_action; ?>
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