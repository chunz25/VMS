<?php

// data PO Header -------------
$sql001 = '"select * from purchase_order where purchase_order_no=' . "'" . $_REQUEST["po_no"] . "'" . '"';
$exec_sql001 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql001);
$json_exec_sql001 = json_decode($exec_sql001, true);
$data_header = $json_exec_sql001["rows"][0];

// data supplier -----------------
$sql003 = '"select * from supplier where supplier_code=' . "'" . $data_header["supplier_code"] . "'" . '"';
$exec_sql003 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql003);
$json_exec_sql003 = json_decode($exec_sql003, true);
$data_header_supplier = $json_exec_sql003["rows"][0];

// data store -----------------
$sql002 = '"select * from store where code=' . "'" . $data_header["store_code"] . "'" . '"';
$exec_sql002 = shell_exec($_MAIN__CONFIGS_030[5] . ' -s ' . $sql002);
$json_exec_sql002 = json_decode($exec_sql002, true);
$data_header_store = $json_exec_sql002["rows"][0];

?>
<div class="modal fade" id="tampil2" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="exampleModalCenterTitle">REQUEST CANCEL PO
					#<?= $_REQUEST["po_no"]; ?></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" align="left">
				<form role="form" id="form_cancel_po" action="index.php" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<label>Reason :</label></br>
						<input name="reason" type="radio" value="Quantity"> Quantity Tidak Mencukupi</br>
						<input name="reason" type="radio" value="Unit Price" checked> Unit Price Salah </br>
						<input name="reason" type="radio" value="Others"> Others </br>
						<label>Note :</label>
						<textarea name="user_req_note" class="form-control" rows="5"
							placeholder="Silahkan isi catatan di kolom ini"></textarea>
					</div><!-- /.box-body -->
					<div class="box-footer" align="center">
						<input type="hidden" name="main" value="040">
						<input type="hidden" name="main_act" value="010">
						<input type="hidden" name="main_id" value="400401_01_03">
						<input type="hidden" name="purchase_order_no" value="<?= $_REQUEST["po_no"]; ?>">
						<input type="hidden" name="store_mail"
							value="<?= $data_header["store_code"] . ' ' . $data_header_store["name"]; ?>">
						<input type="hidden" name="suppcode_mail"
							value="<?= $data_header_supplier["supplier_code"]; ?>">
						<input type="hidden" name="suppname_mail" value="<?= $data_header_supplier["name"]; ?>">
						<input type="hidden" name="docdate_mail" value="<?= $data_header["document_date"]; ?>">
						<input type="hidden" name="docexp_mail" value="<?= $data_header["expired_date_po"]; ?>">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>
	$("#form_cancel_po").submit(function (event) {
		event.preventDefault(); //prevent default action 
		var post_url = $(this).attr("action"); //get form action url
		var request_method = $(this).attr("method"); //get form GET/POST method
		var form_data = new FormData(this); //Creates new FormData object
		$.ajax({
			url: post_url,
			type: request_method,
			data: form_data,
			contentType: false,
			cache: false,
			processData: false
		}).done(function (response) { //
			if (response == 'success') {
				alert('Request cancel PO Sudah diproses, Menunggu confirm dari ELECTRONIC CITY ...');
				var targetUrlCP = "index.php";
				var postDataCP = {
					main: "030",
					showFirst1: "Purchase+Order",
					showFirst2: "400401",
					showFirst3: "2"
				};
				// Panggil fungsi untuk melakukan redirect dengan metode POST
				redirectWithPost(targetUrlCP, postDataCP);
			} else {
				alert(response);
				alert('Gagal request to cancel...');
				return false;
			}
		});
	});
</script>