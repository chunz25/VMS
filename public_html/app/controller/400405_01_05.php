<?php
// data PO Header -------------
$sql001 = '"select * from invoice_receipt where no_invoice_supplier=' . "'" . $_REQUEST["no_inv_sup"] . "'" . ' and purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

$libur = "SELECT * FROM harilibur";
$libur = $db->Execute($libur);
$b = array();
while ($a = $libur->fetchRow()) {
	array_push($b, $a['tgl']);
}

?>
<style>
	.tabelpopup {
		width: 100%;
		border: 1px solid #b3adad;
		border-collapse: collapse;
		padding: 5px;
	}

	.tdpopup {
		border: 1px solid #b3adad;
		padding: 5px;
		background: #ffffff;
		color: #313030;
	}
</style>
<div class="modal fade" id="tampil2" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="exampleModalCenterTitle">UPLOAD ULANG FILE RN NO # <?php echo $_REQUEST["gr_no"]; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">
				<?php // print_r($data_header);
				?>
				<form role="form" id="my_form_TF" action="index.php" method="post" enctype="multipart/form-data">
					<table class="tabelpopup">

						<tbody>
							<tr>
								<td class="tdpopup" align="right" width="40%">No. PO</td>
								<td class="tdpopup"><b><?php echo $_REQUEST["po_no"] ?></b></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Amount</td>
								<td class="tdpopup">
									<b><?php echo number_format($data_header["total_amount"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">VAT</td>
								<td class="tdpopup">
									<b><?php echo number_format($data_header["vat_amount"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Total Amount</td>
								<td class="tdpopup">
									<b><?php echo number_format($data_header["grand_total"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" valign="top" width="40%">Keterangan :</td>
								<td class="tdpopup">
									<b><?php echo str_replace(",", "<br>", $data_header["reject_reason"]); ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">No Invoice Supplier:</td>
								<td class="tdpopup"><input type="text" class="form-control" name="no_invoice_supplier"
										value="<?php echo $data_header['no_invoice_supplier'] ?>" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Tanggal faktur Pajak</td>
								<td class="tdpopup">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" id="datepicker" name="tgl_fp"
											value="<?php echo $data_header['tgl_faktur_pajak'] ?>"
											onkeypress="return false;"
											autocomplete="off"
											style="background-color:lightblue;">
									</div>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">No Faktur Pajak</td>
								<td class="tdpopup"><input type="text" class="form-control" name="no_fp"
										value="<?php echo $data_header['no_faktur_pajak'] ?>"
										style="background-color:lightblue;" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%"><b>Upload File Faktur Pajak</b></td>
								<td class="tdpopup"><input type="file" id="idfakturpajak" name="fakturpajak" accept="application/pdf" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%"><b>Upload File RN( Receive Note)</b></td>
								<td class="tdpopup"><input type="file" id="idrn" name="rn" accept="application/pdf" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload File Invoice Supplier</td>
								<td class="tdpopup"><input type="file" id="idinvoicesupplier" name="invoicesupplier" accept="application/pdf" required>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload File Surat Jalan</td>
								<td class="tdpopup"><input type="file" id="idsuratjalan" name="suratjalan" accept="application/pdf" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload Dokumen Lainnya [optional]</td>
								<td class="tdpopup"><input type="file" id="iddoklain" accept="application/pdf" name="doklain"></td>
							</tr>

						</tbody>
					</table>

					<div class="box-body">
						<label>Catatan :</label>
						<textarea name="remark" class="form-control"
							rows="3"><?php echo $data_header['remark'] ?> </textarea>
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">
						<input type="hidden" name="biaya_materai" value="0">
						<input type="hidden" name="main" value="040">
						<input type="hidden" name="main_act" value="010">
						<input type="hidden" name="main_id" value="400405_01_06">
						<input type="hidden" name="vat_amount" value="<?php echo $data_header["vat_amount"]; ?>">
						<input type="hidden" name="total_amount" value="<?php echo $data_header["grand_total"]; ?>">
						<input type="hidden" name="po_no" value="<?php echo $data_header["purchase_order_no"]; ?>">
						<input type="hidden" name="gr_no" value="<?php echo $data_header["goods_receive_no"]; ?>">
						<input type="hidden" name="no_inv_sup"
							value="<?php echo $data_header["no_invoice_supplier"]; ?>">
						<input type="hidden" name="pfi_no" value="<?php echo $data_header["pfi_no"]; ?>">
						<input type="hidden" name="status_pfi" value="<?php echo $data_header["status_pfi"]; ?>">
						<input type="hidden" name="npwp_no" value="<?php echo $_REQUEST["npwp_no"]; ?>">
						<input type="hidden" name="newnamefile" value="<?php echo $data_header["goods_receive_no"]; ?>">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="tempatmodalXX"></div>

<div class="modal fade" id="modalOverlayPra" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="exampleModalCenterTitle">Mohon bersabar, sedang proses ....</h4>
			</div>
			<div class="modal-body" align="left">
				<img src="_assets/_images/ajax-loader.gif">

			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<script>
	function validateFileType(fileInput) {
		const file = fileInput.files[0];
		const fileName = file ? file.name : '';
		const fileExtension = fileName.split('.').pop().toLowerCase();
		const maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes

		// Check if the file is a PDF
		if (file && fileExtension !== 'pdf') {
			alert('Only PDF files are allowed for upload: ' + fileName);
			fileInput.value = ''; // Clear the input
			return false;
		}

		// Check if the file size exceeds 5 MB
		if (file && file.size > maxFileSize) {
			alert('File size exceeds 2 MB: ' + fileName);
			fileInput.value = ''; // Clear the input
			return false;
		}
		return true;
	}

	// Attach change event listeners to file inputs
	document.getElementById('idfakturpajak').addEventListener('change', function() {
		validateFileType(this);
	});
	document.getElementById('idrn').addEventListener('change', function() {
		validateFileType(this);
	});
	document.getElementById('idinvoicesupplier').addEventListener('change', function() {
		validateFileType(this);
	});
	document.getElementById('idsuratjalan').addEventListener('change', function() {
		validateFileType(this);
	});
	document.getElementById('iddoklain').addEventListener('change', function() {
		validateFileType(this);
	});

	function prosesSubmitX(param1, param2, param3) {
		$.ajax({
			url: param1,
			type: param2,
			data: param3,
			contentType: false,
			cache: false,
			processData: false
		}).done(function(response) {
			if (response === 'success') {
				alert('Proses Invoicing sudah selesai, Tinggal menunggu Approve dan Pembayaran ...');
				$('#modalOverlayPra').modal('hide');

				var targetUrlTF1 = "index.php";
				var postDataTF1 = {
					main: "030",
					showFirst1: "Receipt+Supplier",
					showFirst2: "400405",
					showFirst3: "1"
				};
				// Call function to redirect with POST method
				redirectWithPost(targetUrlTF1, postDataTF1);
			} else {
				alert(response);
				alert('Gagal Proses Invoice receipt Silahkan dicoba lagi...');
				$('#modalOverlayPra').modal('hide');
			}
		}).fail(function(jqXHR, textStatus) {
			$('#modalOverlayPra').modal('hide');
			alert('Error: ' + textStatus);
		});
	}

	$("#my_form_TF").submit(function(event) {
		const noInvoiceSupplier = document.getElementById('no_invoice_supplier').value;
		if (!noInvoiceSupplier) {
			alert('Nomor Invoice tidak boleh kosong.');
			event.preventDefault(); // Prevent form submission
			return;
		}
		if (confirm('Apakah Data sudah benar ? ') == true) {
			$('#modalOverlayPra').modal('show');
			event.preventDefault(); // Prevent default action 
			var post_url = $(this).attr("action"); // Get form action url
			var request_method = $(this).attr("method"); // Get form GET/POST method
			var form_data = new FormData(this); // Creates new FormData object
			prosesSubmitX(post_url, request_method, form_data);
		}
	});

	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		editable: false
	});
</script>