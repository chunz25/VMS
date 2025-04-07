<?php
//PRINT FAKTUR PAJAK
$a = md5(md5("helmianwar999" . date("Ymd"))); // key 
$b = $_REQUEST["po_no"]; // nama file pdf
$c = $_MAIN__CONFIGS_040[910] . "/PO/"; // folder
$urlFull = "showFile.php?a=" . urlencode($a) . "&b=" . urlencode($b) . "&c=" . urlencode($c);
?>
<div class="modal fade" id="tampil3" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT # PO No #<?= $_REQUEST["po_no"]; ?>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">
				<embed src="<?= ($urlFull) ?>" frameborder="0" width="100%" height="450px">
			</div>
		</div>
	</div>
</div>