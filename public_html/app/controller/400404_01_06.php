<?php

/*
	// data PO Header -------------
	$sql001='"select * from proforma_invoice where purchase_order_no='."'".$_REQUEST["po_no"]."'".'"';
	$exec_sql001=shell_exec($_MAIN__CONFIGS_030[5].' -s '.$sql001);
	$json_exec_sql001=json_decode($exec_sql001,true);
	$data_header=$json_exec_sql001["rows"][0];
*/
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
				<h4 id="exampleModalCenterTitle">REJECT RECEIPT SUPPLIER # <?php echo $_REQUEST["gr_no"]; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">
				<?php // print_r($_REQUEST);
				?>
				<form role="form" id="my_form_Reject" action="index.php" method="post" enctype="multipart/form-data">
					<table class="tabelpopup">

						<tbody>

							<tr>
								<td class="tdpopup" align="right" width="40%" valign="top"><b>File yang tidak Sesuai</b>
								</td>
								<td class="tdpopup">
									<b><input type="checkbox" class="form-check-input" name="note1"
											value="Receive Note Tidak Sesuai"> RN ( Receive Note )</b></br>
									<b><input type="checkbox" class="form-check-input" name="note2"
											value="Surat Jalan Tidak Sesuai"> Surat Jalan</b></br>
									<b><input type="checkbox" class="form-check-input" name="note3"
											value="Invoice Tidak Sesuai"> Invoice</b></br>
									<b><input type="checkbox" class="form-check-input" name="note4"
											value="Faktur Pajak Tidak Sesuai">Faktur Pajak</b></br>
								</td>
							</tr>



						</tbody>
					</table>

					<div class="box-body">



						<label>Catatan :</label>
						<textarea name="remark" class="form-control" rows="3"
							placeholder="please fill notes"></textarea>
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">
						<input type="hidden" name="main" value="040">
						<input type="hidden" name="main_act" value="010">
						<input type="hidden" name="main_id" value="400404_01_07">
						<input type="hidden" name="po_no" value="<?php echo $_REQUEST["po_no"]; ?>">
						<input type="hidden" name="gr_no" value="<?php echo $_REQUEST["gr_no"]; ?>">
						<input type="hidden" name="inv_supp_no" value="<?php echo $_REQUEST["inv_supp_no"]; ?>">

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
	function cobayah(xx) {
		alert(xx);
		$('#modalOverlayPra').modal('show');
		$('#tempatmodalXX').load(param2,
			param3,
			function (responseTxt, statusTxt, xhr) {
				if (statusTxt == "success") {
					//$('#loading').modal('hide');
					$('#modalOverlayPra').modal('show');
				}
				if (statusTxt == "error")
					alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
			}
		);

	}

	function cekSize() {
		// var input = document.querySelector('input[type="file"]');
		var files = $("#upload").size;
		var maxSize = 1 * 1024 * 1024; // 5 MB in bytes
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
		}).done(function (response) { //
			// alert(response);
			// $("#server-results").html(response);
			alert(response);
			// console.log(response);
			if (response == 'success') {
				alert(
				'Reject Proses Invoice receipt done , menunggu supplier memenuhi persyaratannya kembali ...');
				// $(".close").click()
				// cobaxx('Invoice+Receipt','400405');

				var targetUrlRInv = "index.php";
				var postDataRInv = {
					main: "030",
					showFirst1: "Receipt+Supplier",
					showFirst2: "400405",
					showFirst3: "1"
				};
				// Panggil fungsi untuk melakukan redirect dengan metode POST
				redirectWithPost(targetUrlRInv, postDataRInv);
			} else {
				alert('Gagal Proses reject Invoice receipt Silahkan dicoba lagi...');
				$('#modalOverlayPra').modal('hide');
				return false;
			}
		});
	}

	$("#my_form_Reject").submit(function (event) {
		// alert('cek dulu...');
		// cekSize();
		// alert('data disubmit');
		if (confirm('Apakah Yakin Data Receipt di Reject ?') == true) {
			$('#modalOverlayPra').modal('show');
			event.preventDefault(); //prevent default action 
			var post_url = $(this).attr("action"); //get form action url
			var request_method = $(this).attr("method"); //get form GET/POST method
			var form_data = new FormData(this); //Creates new FormData object
			prosesSubmitX(post_url, request_method, form_data)
		}
	});
</script>