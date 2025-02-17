<?php
include_once('inc_condition2.php');

//$sql_400402_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
//$sql_400402_02 = "SELECT * FROM invoice_receipt_all_status_v where status_invr in ('51','52','53','54') and payment_amount is null ".$sql_400401_01." ";
//$sql_400402_02 = "SELECT * FROM invoice_receipt where status_invr in ('51','52','53','54') ".$sql_400401_01." ";
$sql_400402_02 = "SELECT * FROM vw_rsdispute WHERE 1=1 " . $sql_400401_01;
$rs = $db->Execute($sql_400402_02);

?>
<div class="box-body table-responsive" style="padding:2px;">
	<TABLE id="tbl08" class="table table-striped table-bordered" style="padding:0px;">
		<THEAD>
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
				<td align="center"><b>STATUS </b></td>
				<td align="center"><b>ACTION</b></td>
				<td align="center"><b>CHANGE PRICE</b></td>
			</tr>
		</THEAD>

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
					<td><?php echo $arr['rs_no_sap']; ?></td>
					<td><?= $arr['insert_date']; ?></td>
					<td><?php echo $arr['purchase_order_no']; ?></td>
					<td><?php echo $arr['no_invoice_supplier']; ?></td>
					<td><?php echo $arr['store_code']; ?></td>
					<td><?php echo $arr['supplier_code']; ?></td>
					<td><?php echo $arr['supplier_name']; ?></td>
					<td align="right"><?php echo number_format($arr['total_amount'], 2); ?></td>
					<td align="right"><?php echo number_format($arr['vat_amount'], 2); ?></td>
					<td align="right"><?php echo number_format($arr['biaya_materai'], 2); ?></td>
					<td align="right"><?php echo number_format(($arr['grand_total'] + $arr['biaya_materai']), 2); ?></td>
					<td align="center">
						<?php
						if ($arr['status_invr'] == '51') { ?>
							<span class="label label-info"> Proses Verifikasi</span>
						<?php } ?>
						<?php
						if (($arr['status_invr'] == '53')) {

							if ($_SESSION['tb_id_user_type'] == '5') {
						?>
								<a class="btn btn-default btn-flat btn-sm  btn-danger" onclick="bukaModalHelmizz301('#tempatmodalTF2','index.php?main=040&main_act=010&main_id=400405_01_05&po_no=<?php echo urlencode($arr['purchase_order_no']); ?>&gr_no=<?php echo urlencode($arr['goods_receive_no']); ?>&no_inv_sup=<?php echo urlencode($arr['no_invoice_supplier']); ?>','','#tampil2');" );">File Upload<br> Tidak Sesuai !</a>
							<?php
							} else {
							?>
								<button class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#add01">File Upload<br> Tidak Sesuai !</button>
							<?php }
						}
						if ($arr['status_invr'] == '54') { ?>
							<span class="label label-info">Verified</span>
						<?php } ?>
					</td>
					<td align="center">
						<button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('RECEIPT+SUPPLIER','400405_01_01','<?php echo urlencode($arr['no_invoice_supplier']); ?>&po_no=<?php echo urlencode($arr['purchase_order_no']); ?>&invrstat=<?php echo urlencode($arr['status_invr']); ?>');"><?php echo $tombol_act; ?></button>
					</td>
					<td align="center">
						<?php
						if (!$arr['proforma_invoice_no']) {
						?>

						<?php
						}else {
						?>
						<button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01" onclick="cobayy('PROFORMA+INVOICE','400403_03_01','<?php echo $arr['proforma_invoice_no'];?>&param_menu4=<?php echo $arr['status_pfi'];?>');" ><?php echo "View";?> </button>
						<?php
						}
						?>
					</td>
				</tr>
			<?php } ?>
		</TBODY>
	</TABLE>
</div>
<div id="tempatmodal"></div>
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