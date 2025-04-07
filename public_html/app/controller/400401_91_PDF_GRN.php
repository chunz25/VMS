<?php
//PRINT GOODS RECEIVE NOTE
// data PO Header -------------
$sql001 = '"select * from goods_receive where goods_receive_no=' . "'" . $_REQUEST["goods_receive_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

$namafilepdf = md5(sha1($_REQUEST["po_no"])) . ".pdf";
?>
<div class="modal fade" id="tampil4" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT GOODS RECEIVE NOTE (GRN) # <?= $_REQUEST["goods_receive_no"]; ?>
				</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">

				<embed src="_docs/GR/<?= $namafilepdf; ?>" frameborder="0" width="100%" height="450px">

			</div>
		</div>
	</div>
</div>