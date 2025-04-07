<?php
include_once('inc_condition.php');

$sql_400402_02 = "select * from dashboard_inv_process_v " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);

?>
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="box-body table-responsive" style="padding:2px;">
	<TABLE id="tbl02" class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>


			<tr valign="top">
				<td align="center"><b>supplier_code</b></td>
				<td align="center"><b>supplier_name</b></td>
				<td align="center"><b>DEPT</b></td>
				<td align="center"><b>INV PROC</b></td>
				<td align="center"><b>INV CLOSE</b></td>
				<td align="center"><b>TOT INV</b></td>
				<td align="center"><b>EMAIL</b></td>
				<td align="center"><b>NAME</b></td>
				<td align="center"><b>HP</b></td>
				<td align="center"><b>LASTLGN</b></td>
				<td align="center"><b>SUPP GROUP</b></td>
				<td align="center"><b>ACTION</b></td>

			</tr>
		</THEAD>
		<TBODY>
			<?php if ($rs)
				while ($arr = $rs->FetchRow()) { ?>
					<tr valign="top">
						<td><?= $arr['supplier_code']; ?></td>
						<td><?= $arr['supplier_name']; ?></td>
						<td><?= $arr['department']; ?></td>
						<td><?= $arr['inv_belum_selesai']; ?></td>
						<td><?= $arr['inv_sudah_selesai']; ?></td>
						<td><?= $arr['total_inv_process']; ?></td>
						<td><?= $arr['email']; ?></td>
						<td><?= $arr['fullname']; ?></td>
						<td><?= $arr['hp']; ?></td>
						<td><?= $arr['last_login']; ?></td>
						<td><?= $arr['supplier_group']; ?></td>
						<td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal"
								data-target="#add01"
								onclick="bukaModalHelmizz301('#tempatmodal','index.php?main=040&main_act=010&main_id=400205_01_01&po_no=<?= urlencode($arr['purchase_order_no']); ?>','','#tampil2');">View
								Detail</button></td>

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