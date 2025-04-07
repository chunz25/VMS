<?php
//PRINT PROFORMA INVOICE
// data PO Header -------------
$sql001 = '"select * from proforma_invoice where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

$folder = '/home/helmi/php/b2b/_docs/PFI/';
$namafilepdf = md5(sha1($data_header["proforma_invoice_no"])) . ".pdf";
$docnonya = $data_header["proforma_invoice_no"];
if (!is_file($folder . $namafilepdf . ".pdf")) {
	file_get_contents("http://b2b.goro.co.id/14ecf024e18da287f9cbf8e8b6bbf853.php?pwd=730e85e6ce5a47b805e96bf133a8759b&docno=" . $docnonya);
}


?>
<div class="modal fade" id="tampil6" role="dialog" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalCenterTitle">
					PRINT PROFORMA INVOICE #<?= $data_header["proforma_invoice_no"]; ?> </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" align="left">

				<embed src="_docs/PFI/<?= $namafilepdf; ?>" frameborder="0" width="100%" height="450px">

			</div>
		</div>
	</div>
</div>