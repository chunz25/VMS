<?php
switch ($_SESSION['tb_id_user_type']) {
	case 1:
		$sql_400402_01 = " ";
		break;
	case 2:
		$sql_400402_01 = " AND  ";
		break;
	case 3:
		$sql_400402_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
		break;
	case 4:
		$sql_400402_01 = " AND store_code='" . $_SESSION['store_code'] . "'";
		break;
	case 5:
		$sql_400402_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
		break;
	case 8:
		$sql_400402_01 = " ";
		break;
}

$sql_400402_02 = "SELECT a.*,b.name FROM goods_receive_all_status_v a left join supplier b on a.supplier_code=b.supplier_code  where  status_grn in ('24')  and revision_seq>0 and document_status is null" . $sql_400402_01;
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
			<td align="center"><b>SUPPLIER_CODE</b></td>
			<td align="center"><b>SUPPLIER NAME</b></td>
			<td align="center"><b>RECEIVED DATE</b></td>
			<td align="center"><b>STATUS</b></td>
			<td align="center"><b>SEQ</b></td>
			<td align="center"><b>ACTION</b></td>
		</tr>
	</THEAD>
	<TBODY>
		<?php if ($rs)
			while ($arr = $rs->FetchRow()) {
				$view_action = ($arr['status_grn'] == 23) ? "Proses" : "View";
				$view_status = ($arr['status_grn'] == 23) ? "Dispute qty By Electronic-City" : "Dispute qty By Supplier";
				?>
				<tr valign="top">
					<td><?= $arr['purchase_order_no']; ?></td>
					<td><?= $arr['goods_receive_no']; ?></td>
					<td><?= $arr['store_code']; ?></td>
					<td><?= $arr['supplier_code']; ?></td>
					<td><?= $arr['name']; ?></td>
					<td><?= $arr['document_date']; ?></td>
					<td align="center"><span class="label label-info">Dispute Qty Finished</span></td>
					<td align="center"><span class="label label-info"><?= $arr['revision_seq']; ?></span></td>
					<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
							onclick="cobayy('DISPUTE+QUANTITY','401101_02_01','<?= $arr['goods_receive_no']; ?>&param_menu4=<?= $arr['status_grn']; ?>');"><?= $view_action; ?>
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