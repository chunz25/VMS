<?php
include('inc_condition2.php');

$libur = "SELECT * FROM harilibur";
$libur = $db->Execute($libur);
$b = array();
while ($a = $libur->fetchRow()) {
	array_push($b, $a['tgl']);
}

// Get supplier list for filter dropdown
$sqlSupplier = "SELECT supplier_code, name FROM supplier WHERE supplier_code IN (SELECT * FROM vw_supplier)";
$dataSupplier = $db->Execute($sqlSupplier);

$date_from = '';
$date_to = '';
$supplier_type = '';
$status_po = '';

if (isset($_POST['date_from']) || isset($_SESSION['param_rs'])) {

	$sesspar = isset($_SESSION['param_rs']) ? json_decode($_SESSION['param_rs']) : '';
	$date_from = ($_POST['date_from']) ?? $sesspar->date_from;
	$date_to = ($_POST['date_to']) ?? $sesspar->date_to;
	$supplier_type = ($_POST['supplier_type']) ?? $sesspar->supplier_type;
	$status_po = ($_POST['statuspo']) ?? $sesspar->statuspo;

	$param = [
		'date_from' => $date_from,
		'date_to' => $date_to,
		'supplier_type' => $supplier_type,
		'statuspo' => $status_po
	];

	$_SESSION['param_rs'] = json_encode($param);

	$sql = "SELECT * FROM vw_rsdispute WHERE insert_date BETWEEN '$date_from' AND '$date_to'";

	if ($status_po != "0") {
		$sql .= " AND status_invr = '$status_po'";
	}

	if ($supplier_type != "0") {
		$sql .= " AND supplier_code = '$supplier_type'";
	}

	$rs = $db->Execute($sql);
} else {
	$sql_400402_02 = "SELECT * FROM vw_rsdispute WHERE insert_date = CAST(now() as date) + 1 " . $sql_400401_01;
	$rs = $db->Execute($sql_400402_02);
}
?>

<!-- Filter Form -->
<div class="filter-form col-md-12">
	<form id="filterForm">
		<input type="text" id="tb_id_user_type" name="tb_id_user_type" value="<?= $_SESSION['tb_id_user_type'] ?>"
			hidden>
		<div class="form-group col-sm-2">
			<input type="text" class="form-control datepicker" id="date_from" name="date_from" autocomplete="off"
				placeholder="Pilih Tanggal Awal" onkeypress="return false;" value="<?php if (isset($date_from)) {
					echo $date_from;
				} ?>">
		</div>
		<div class="form-group col-sm-2">
			<input type="text" class="form-control datepicker" id="date_to" name="date_to" autocomplete="off"
				placeholder="Pilih Tanggal Akhir" onkeypress="return false;" value="<?php if (isset($date_to)) {
					echo $date_to;
				} ?>">
		</div>
		<div class="form-group col-sm-3">
			<select class="form-control" id="statuspo" name="statuspo">
				<option value="" disabled selected hidden>Pilih Status</option>
				<option value="0" <?php if ($status_po == '0')
					echo 'selected' ?>>All</option>
					<option value="51" <?php if ($status_po == '51')
					echo 'selected' ?>>Proses Verifikasi</option>
					<option value="54" <?php if ($status_po == '54')
					echo 'selected' ?>>Verified</option>
					<option value="53" <?php if ($status_po == '53')
					echo 'selected' ?>>File Upload Tidak Sesuai</option>
				</select>
			</div>
			<div class="form-group col-sm-3">
			<?php if ($_SESSION['supplier_code']) { ?>
				<input type="text" id="supplier_type" name="supplier_type" value="<?= $_SESSION['supplier_code'] ?>" hidden>
				<input type="text" class="form-control"
					value="<?= $_SESSION['supplier_code'] . ' - ' . $_SESSION['supplier_name'] ?>" readonly>
			<?php } else { ?>
				<select class="form-control" id="supplier_type" name="supplier_type">
					<option value="" disabled selected hidden>Pilih Supplier</option>
					<option value="0" <?php if ($supplier_type == '0')
						echo 'selected' ?>>All</option>
					<?php while ($supplier = $dataSupplier->FetchRow()) { ?>
						<option value="<?= $supplier['supplier_code']; ?>" <?php if ($supplier_type == $supplier['supplier_code'])
							  echo 'selected' ?>>
							<?= $supplier['supplier_code'] . " - " . $supplier['name']; ?>
						</option>
					<?php } ?>
				</select>
			<?php } ?>
		</div>
		<div class="form-group">
			<button id="filterBtn" type="button" class="btn btn-primary">Apply Filter</button>
		</div>
	</form>
</div>
<br>
<hr>
<hr>

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
				<td align="center"><b>STORE NAME</b></td>
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
		<TBODY>
			<?php if ($rs)
				while ($arr = $rs->FetchRow()) {
					if (($_SESSION['tb_id_user_type'] == '3') && ($arr['status_invr'] < '53')) {
						$tombol_act = "Confirm";
					} else {
						$tombol_act = "Detail";
					}
					?>
					<tr valign="top">
						<td><?= $arr['rs_no_sap']; ?></td>
						<td><?= $arr['insert_date']; ?></td>
						<td><?= $arr['purchase_order_no']; ?></td>
						<td><?= $arr['no_invoice_supplier']; ?></td>
						<td><?= $arr['store_code']; ?></td>
						<td><?= $arr['store_name']; ?></td>
						<td><?= $arr['supplier_code']; ?></td>
						<td><?= $arr['supplier_name']; ?></td>
						<td align="right"><?= number_format($arr['total_amount'], 2); ?></td>
						<td align="right"><?= number_format($arr['vat_amount'], 2); ?></td>
						<td align="right"><?= number_format($arr['biaya_materai'], 2); ?></td>
						<td align="right"><?= number_format(($arr['grand_total'] + $arr['biaya_materai']), 2); ?></td>
						<td align="center">
							<?php
							if ($arr['status_invr'] == '51') { ?>
								<span class="label label-info"> Proses Verifikasi</span>
							<?php } ?>
							<?php
							if (($arr['status_invr'] == '53')) {

								if ($_SESSION['tb_id_user_type'] == '5') {
									?>
									<?php
									$tgl = array('13', '28');
									$day = array('Sat', 'Sun');
									$tglmerah = $b;
									if (in_array(date('d'), $tgl) || in_array(date('D'), $day) || in_array(date("Y-m-d"), $tglmerah)) {
										?>
										<a class="btn btn-danger btn-xs btn-flat"
											onclick="alert('Tidak bisa kirim invoice, karena bukan tanggal operational tukar faktur');">File
											Upload<br> Tidak Sesuai !</a>
										<?php
									} else {
										?>
										<a class="btn btn-danger btn-xs btn-flat"
											onclick="bukaModalHelmizz301('#tempatmodalTF2','index.php?main=040&main_act=010&main_id=400405_01_05&po_no=<?= urlencode($arr['purchase_order_no']); ?>&gr_no=<?= urlencode($arr['goods_receive_no']); ?>&no_inv_sup=<?= urlencode($arr['no_invoice_supplier']); ?>','','#tampil2');">File
											Upload<br> Tidak Sesuai !</a>
										<?php
									}
								} else {
									?>
									<button class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#add01">File
										Upload<br> Tidak Sesuai !</button>
								<?php }
							}
							if ($arr['status_invr'] == '54') { ?>
								<span class="label label-info">Verified</span>
							<?php } ?>
						</td>
						<td align="center">
							<button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
								onclick="cobayy('RECEIPT+SUPPLIER','400405_01_01','<?= urlencode($arr['no_invoice_supplier']); ?>&po_no=<?= urlencode($arr['purchase_order_no']); ?>&invrstat=<?= urlencode($arr['status_invr']); ?>');"><?= $tombol_act; ?></button>
						</td>
						<td align="center">
							<?php
							if (!$arr['proforma_invoice_no']) {
							} else {
								?>
								<button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01"
									onclick="cobayy('PROFORMA+INVOICE','400403_03_01','<?= $arr['proforma_invoice_no']; ?>&param_menu4=<?= $arr['status_pfi']; ?>');"><?= "View"; ?>
								</button>
								<?php
							}
							?>
						</td>
					</tr>
				<?php } ?>
		</TBODY>
	</table>
</div>

<div id="tempatmodalTF2"></div>
<div id="loading" class="modal fade" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body" align="center">
				<img src="_assets/_images/ajax-loader.gif">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tbRS').dataTable();
	$(document).ready(function () {
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});

		// Filter button event
		$('#filterBtn').on('click', function () {
			const date_from = $('#date_from').val();
			const date_to = $('#date_to').val();
			const status_po = $('#statuspo').val();
			const supplier_type = $('#supplier_type').val();
			const tb_id_user_type = $('#tb_id_user_type').val();

			if (!date_from) {
				alert("Pilih Tanggal Awal Terlebih Dahulu");
			} else if (!date_to) {
				alert("Pilih Tanggal Akhir Terlebih Dahulu");
			} else if (!status_po) {
				alert("Pilih Status Terlebih Dahulu");
			} else if (!supplier_type) {
				alert("Pilih Vendor Terlebih Dahulu");
			} else {
				$(".content-wrapper").load("index.php?param_menu1=Receipt+Supplier&main_id=400405", {
					main: "040",
					main_act: "010",
					par: "tabcontent1",
					date_from: date_from,
					date_to: date_to,
					statuspo: status_po,
					supplier_type: supplier_type
				}, '');
			}
		});
	})
</script>