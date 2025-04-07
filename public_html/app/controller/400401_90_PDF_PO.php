<?php
//PRINT PO
// data PO Header -------------
$sql001 = '"select * from purchase_order where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

if (($_SESSION['tb_id_user_type'] == "5") || ($_SESSION['tb_id_user_type'] == "6")) {
	// Update status PO,
	if ($data_header['status_po'] == '11') {
		$sql005 = "UPDATE purchase_order set status_po='12' where purchase_order_no='" . $_REQUEST["po_no"] . "'";
		$db->Execute($sql005);

	}
}

$namafilepdf = md5(sha1($_REQUEST["po_no"])) . ".pdf";
?>
<div class="modal fade" id="tampil3" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT PO # <?= $_REQUEST["po_no"]; ?>
				</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">

				<embed src="_docs/PO/<?= $namafilepdf; ?>" frameborder="0" width="100%" height="450px">

			</div>
		</div>
	</div>
</div>