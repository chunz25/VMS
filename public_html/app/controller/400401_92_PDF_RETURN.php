<?php
//PRINT RETURN 
// data PO Header -------------
$sql001 = '"select * from goods_return where goods_return_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

$namafilepdf = md5(sha1($_REQUEST["po_no"] . $_REQUEST["bf"])) . ".pdf";
?>
<div class="modal fade" id="tampil5" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT RETURN # <?= $_REQUEST["po_no"] . $_REQUEST["bf"]; ?>
				</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">

				<embed src="_docs/RETURN/<?= $namafilepdf; ?>" frameborder="0" width="100%" height="450px">

			</div>
		</div>
	</div>
</div>