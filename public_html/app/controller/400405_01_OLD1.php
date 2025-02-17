<?php
include_once('inc_condition2.php');

// Get supplier list for filter dropdown
$sqlSupplier = "SELECT supplier_code, name FROM supplier WHERE supplier_code IN (SELECT * FROM vw_supplier)";
$dataSupplier = $db->Execute($sqlSupplier);
?>

<style>
	.pagination {
		text-align: center;
		margin-top: 10px;
	}

	.pagination a {
		margin: 0 5px;
		padding: 5px 10px;
		background-color: #007bff;
		color: white;
		border-radius: 3px;
		text-decoration: none;
	}

	.pagination a:hover {
		background-color: #0056b3;
	}

	.pagination .current-page {
		margin: 0 5px;
		padding: 5px 10px;
		background-color: #0056b3;
		color: white;
		border-radius: 3px;
		font-weight: bold;
	}
</style>
<!-- Filter Form -->
<div class="filter-form col-md-12">
	<form id="filterForm">
		<input type="text" id="tb_id_user_type" name="tb_id_user_type" value="<?= $_SESSION['tb_id_user_type'] ?>"
			hidden>
		<div class="form-group col-sm-2">
			<input type="text" class="form-control datepicker" id="date_from" name="date_from" autocomplete="off"
				placeholder="Pilih Tanggal Awal" onkeypress="return false;" required>
		</div>
		<div class="form-group col-sm-2">
			<input type="text" class="form-control datepicker" id="date_to" name="date_to" autocomplete="off"
				placeholder="Pilih Tanggal Akhir" onkeypress="return false;" required>
		</div>
		<div class="form-group col-sm-3">
			<select class="form-control" id="statuspo" name="statuspo">
				<option value="0" disabled selected hidden>Pilih Status</option>
				<option value="">All</option>
				<option value="51">Proses Verifikasi</option>
				<option value="54">Verified</option>
				<option value="53">File Upload Tidak Sesuai</option>
			</select>
		</div>
		<div class="form-group col-sm-3">
			<?php if ($_SESSION['supplier_code']) { ?>
			<input type="text" id="supplier_type" name="supplier_type" value="<?= $_SESSION['supplier_code'] ?>" hidden>
			<input type="text" class="form-control"
				value="<?= $_SESSION['supplier_code'] . ' - ' . $_SESSION['supplier_name'] ?>" readonly>
			<?php } else { ?>
			<select class="form-control" id="supplier_type" name="supplier_type">
				<option value="0" disabled selected hidden>Pilih Supplier</option>
				<option value="">All</option>
				<?php while ($supplier = $dataSupplier->FetchRow()) { ?>
				<option value="<?= $supplier['supplier_code']; ?>">
					<?= $supplier['supplier_code'] . " - " . $supplier['name']; ?>
				</option>
				<?php } ?>
			</select>
			<?php } ?>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-primary" onclick="loadFilteredData()">Apply
				Filter</button>
		</div>
	</form>
</div>

<!-- Table for Displaying Data -->
<div class="box-body table-responsive" style="padding:2px;">
	<table id="tbRS" class="table table-striped table-bordered" style="padding:0px;">
		<thead>
			<tr valign="top">
				<td align="center"><b>INVOICE RECEIPT NO</b></td>
				<td align="center"><b>TANGGAL PENGAJUAN RS</b></td>
				<td align="center"><b>PO NO</b></td>
				<td align="center"><b>INV SUPP NO</b></td>
				<td align="center"><b>STORE</b></td>
				<td align="center"><b>SUPPLIER CODE</b></td>
				<td align="center"><b>SUPPLIER NAME</b></td>
				<td align="center"><b>AMOUNT</b></td>
				<td align="center"><b>VAT</b></td>
				<td align="center"><b>MATERAI</b></td>
				<td align="center"><b>TOTAL AMT</b></td>
				<td align="center"><b>STATUS</b></td>
				<td align="center"><b>ACTION</b></td>
				<td align="center"><b>CHANGE PRICE</b></td>
			</tr>
		</thead>
		<tbody id="data-table-body">
			<!-- Data will be loaded here via AJAX -->
		</tbody>
	</table>
</div>
<div id="pagination-controls" class="pagination">
	<!-- Pagination links will be loaded here via AJAX -->
</div>


<div id="tempatmodalTF2"></div>
<div id="loading" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body" align="center">
				<img src="_images/ajax-loader.gif">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function () {
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	});

	// AJAX call and response handling
	function loadFilteredData(page = 1) {
		const date_from = document.forms["filterForm"]["date_from"].value;
		const date_to = document.forms["filterForm"]["date_to"].value;
		const supplier_type = document.forms["filterForm"]["supplier_type"].value;
		const status_po = document.forms["filterForm"]["statuspo"].value;
		const tb_id_user_type = document.forms["filterForm"]["tb_id_user_type"].value;

		if (date_from == "") {
			alert("Pilih Tanggal Awal Terlebih Dahulu");
		} else if (date_to == "") {
			alert("Pilih Tanggal Akhir Terlebih Dahulu");
		} else if (status_po == '0') {
			alert("Pilih Status Terlebih Dahulu");
		} else if (supplier_type == '0') {
			alert("Pilih Vendor Terlebih Dahulu");
		} else {
			$.ajax({
				url: 'fetch_data.php',
				type: 'POST',
				data: {
					date_from: date_from,
					date_to: date_to,
					supplier_type: supplier_type,
					status_po: status_po,
					tb_id_user_type: tb_id_user_type,
					page: page // Send the page number
				},
				success: function (response) {
					// Split the response to get data and pagination separately
					const dataParts = response.split('<!--PAGINATION_SPLIT-->');
					$('#data-table-body').html(dataParts[0]);
					$('#pagination-controls').html(dataParts[1]);
				}
			});
		}
	}

	// Event listener for pagination links
	$(document).on('click', '.pagination-link', function (e) {
		e.preventDefault();
		const page = $(this).data('page');
		loadFilteredData(page);
	});
</script>