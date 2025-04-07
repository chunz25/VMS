<?php


// data PO Header -------------
$sql001 = '"select * from proforma_invoice where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

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
				<h4 id="exampleModalCenterTitle">PROSES INVOICE RECEIPT # <?= $_REQUEST["gr_no"]; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">
				<form role="form" id="my_form_TF" action="index.php" method="post" enctype="multipart/form-data">
					<table class="tabelpopup">

						<tbody>
							<tr>
								<td class="tdpopup" align="right" width="40%">No. PO</td>
								<td class="tdpopup"><b><?= $_REQUEST["po_no"] ?></b></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Amount</td>
								<td class="tdpopup"><b><?= number_format($_REQUEST["ttl_amt"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">VAT</td>
								<td class="tdpopup"><b><?= number_format($_REQUEST["vat_amt"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Total Amount</td>
								<td class="tdpopup"><b><?= number_format($_REQUEST["grd_amt"], 0, ".") ?></b>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">No. NPWP</td>
								<td class="tdpopup"><b><?= $_REQUEST["npwp_no"] ?></b></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">No Invoice Supplier:</td>
								<td class="tdpopup"><input type="text" class="form-control" name="no_invoice_supplier"
										placeholder="Isi No Invoice Supplier exp. 123/ABC/2023"
										style="background-color:lightblue;" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Tanggal faktur Pajak</td>
								<td class="tdpopup">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" id="datepicker" name="tgl_fp"
											value="<?= date("Y-m-d"); ?>" style="background-color:lightblue;">
									</div>
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">No Faktur Pajak</td>
								<td class="tdpopup"><input type="text" class="form-control" name="no_fp" value=""
										style="background-color:lightblue;" required></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%"><b>Upload File Faktur Pajak</b></td>
								<td class="tdpopup"><input type="file" id="idfakturpajak" name="fakturpajak"></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%"><b>Upload File RN( Receive Note)</b></td>
								<td class="tdpopup"><input type="file" id="idrn" name="rn"></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload File Invoice Supplier</td>
								<td class="tdpopup"><input type="file" id="idinvoicesupplier" name="invoicesupplier">
								</td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload File Surat Jalan</td>
								<td class="tdpopup"><input type="file" id="idsuratjalan" name="suratjalan"></td>
							</tr>
							<tr>
								<td class="tdpopup" align="right" width="40%">Upload Dokumen Lainnya [optional]</td>
								<td class="tdpopup"><input type="file" id="iddoklain" name="doklain"></td>
							</tr>

						</tbody>
					</table>

					<div class="box-body">



						<label>Catatan :</label>
						<textarea name="remark" class="form-control" rows="3"
							placeholder="please fill notes"></textarea>
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">
						<input type="hidden" name="biaya_materai" value="0">
						<input type="hidden" name="main" value="040">
						<input type="hidden" name="main_act" value="010">
						<input type="hidden" name="main_id" value="400404_01_05">
						<input type="hidden" name="vat_amount" value="<?= $_REQUEST["vat_amt"]; ?>">
						<input type="hidden" name="total_amount" value="<?= $_REQUEST["ttl_amt"]; ?>">
						<input type="hidden" name="po_no" value="<?= $_REQUEST["po_no"]; ?>">
						<input type="hidden" name="gr_no" value="<?= $_REQUEST["gr_no"]; ?>">
						<input type="hidden" name="pfi_no" value="<?= $_REQUEST["pfi_no"]; ?>">
						<input type="hidden" name="status_pfi" value="<?= $_REQUEST["status_pfi"]; ?>">
						<input type="hidden" name="npwp_no" value="<?= $_REQUEST["npwp_no"]; ?>">
						<input type="hidden" name="newnamefile" value="<?= $_REQUEST["gr_no"]; ?>">
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
	function cekSize() {
		// var input = document.querySelector('input[type="file"]');
		var files = $("#upload").size;
		var maxSize = 5 * 1024 * 1024; // 5 MB in bytes
		console.log(JSON.stringify(files));

		for (var i = 0; i < files.length; i++) {

			if (files[i].size > maxSize) {
				alert("File " + files[i].name + " melebihi batas ukuran (5 MB).");
				return false; // Mencegah form dikirim jika ada file yang melebihi batas
			}
		}

	}

	function prosesSubmitX(param1, param2, param3) {
		$.ajax({
			url: param1,
			type: param2,
			data: param3,
			contentType: false,
			cache: false,
			processData: false
		}).done(function(response) { //
			if (response == 'success') {
				alert('Proses Invoicing sudah selesai, Tinggal menunggu Approve dan Pembayaran ...');
				$('#modalOverlayPra').modal('hide');
				// cobaxx('Invoice+Receipt','400405');

				var targetUrlTF1 = "index.php";
				var postDataTF1 = {
					main: "030",
					showFirst1: "Receipt+Supplier",
					showFirst2: "400405",
					showFirst3: "1"
				};
				// Panggil fungsi untuk melakukan redirect dengan metode POST
				redirectWithPost(targetUrlTF1, postDataTF1);
				// console.log(param3);
			} else {
				alert(response);
				alert('Gagal Proses Invoice receipt Silahkan dicoba lagi...');
				$('#modalOverlayPra').modal('hide');
				return false;
			}
		})
	}


	$("#my_form_TF").submit(function(event) {
		// alert('cek dulu...');
		// cekSize();
		// alert('data disubmit');
		if (confirm('Apakah Data sudah benar ? ') == true) {
			$('#modalOverlayPra').modal('show');
			event.preventDefault(); //prevent default action 
			var post_url = $(this).attr("action"); //get form action url
			var request_method = $(this).attr("method"); //get form GET/POST method
			var form_data = new FormData(this); //Creates new FormData object
			prosesSubmitX(post_url, request_method, form_data)
		}
	});

	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
</script>