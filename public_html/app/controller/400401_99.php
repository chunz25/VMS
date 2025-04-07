<?php
// PRINT CREDIT NOTE ===========================================
$folder = '/home/helmi/php/b2b/_docs/CN/';
$namafilepdf = md5(sha1($_REQUEST["doc_no"])) . ".pdf";
$docno = $_REQUEST["doc_no"];

if (!is_file($folder . $namafilepdf . ".pdf")) {
	file_get_contents("http://b2b.goro.co.id/14ecf024e18da287f9cbf8e8b6bbf851.php?pwd=730e85e6ce5a47b805e96bf133a8757b&docno=" . $docno);
}
?>
<div class="modal fade" id="tampil12" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT CREDIT NOTE # <?= $_REQUEST["doc_no"]; ?>
				</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">

				<embed src="_docs/CN/<?= $namafilepdf; ?>" frameborder="0" width="100%" height="450px">

			</div>
		</div>
	</div>
</div>