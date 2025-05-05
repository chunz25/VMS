<?php
include_once('inc_condition.php');

$sql = "SELECT * FROM payment WHERE ucase(payment_description) not like '%CANCEL%' " . $sql_400401_01 . " order by document_date desc";
$rs = $db->Execute($sql);
?>
<style>
	#custom-progress-container {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 3px;
		z-index: 9999;
		background-color: #f3f3f3;
		display: none;
	}

	#custom-progress-bar {
		height: 100%;
		width: 0%;
		background-color: #337ab7;
		animation: progress-animation 2s infinite ease-in-out;
	}

	@keyframes progress-animation {
		0% {
			width: 0%;
		}

		50% {
			width: 70%;
		}

		100% {
			width: 100%;
		}
	}
</style>
<div id="custom-progress-container">
	<div id="custom-progress-bar"></div>
</div>
<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content" style="padding:3px;">
  <!-- Default box -->
  <div class="box box-solid" id="isicontent1" style="padding:0px;"> <!--style="overflow-y:auto;padding:0px;"-->
    <!---->
    <div class="box-header with-border">
      <font size="3">
        <b> <?= $_REQUEST["param_menu1"]; ?></b>
      </font>
    </div>
    <div class="box-body table-responsive" style="padding:4px;">
      <TABLE id="tbl10" class="table table-striped table-bordered" style="padding:0px;">
        <THEAD>
          <tr valign="top">
            <td align="center"><b>DOCUMENT DATE</b></td>
            <td align="center"><b>PAYMENT NO</b></td>
            <td align="center"><b>SUPPLIER CODE</b></td>
            <td align="center"><b>SUPPLIER NAME</b></td>
            <td align="center"><b>BANK ACCOUNT</b></td>
            <td align="center"><b>BANK NAME</b></td>
            <td align="center"><b>TOTAL TAGIHAN</b></td>
            <td align="center"><b>POTONGAN</b></td>
            <td align="center"><b>NET PAYMENT</b></td>
            <td align="center"><b>ACTION</b></td>
          </tr>
        </THEAD>
        <TBODY>
          <?php if ($rs)
            while ($arr = $rs->FetchRow()) { ?>
              <tr valign="top">
                <td><?= $arr['document_date']; ?></td>
                <td><?= $arr['payment_no']; ?></td>
                <td><?= $arr['supplier_code']; ?></td>
                <td><?= $arr['supplier_name']; ?></td>
                <td><?= $arr['bank_account']; ?></td>
                <td><?= $arr['bank_name']; ?></td>
                <td align="right"><?= number_format($arr['total_amount'], 0); ?></td>
                <td align="right"><?= number_format($arr['potongan'], 0); ?></td>
                <td align="right"><?= number_format($arr['net_payment'], 0); ?></td>
                <td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
                    onclick="cobayy('PAYMENT+DETAIL','400701_00_01','<?= $arr['payment_no']; ?>&cc=<?= $arr['company_code']; ?>');">VIEW
                    DETAIL</button></td>
              </tr>
            <?php } ?>
        </TBODY>
      </TABLE>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->

<div id="tempatmodal"></div>
<div id="loading" class="modal fade" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body" align="center">
        <img src="_images/ajax-loader.gif">
      </div>
    </div>
  </div>
</div>
<script>
  $('#tbl10').DataTable({ "aaSorting": [[2, 'desc']] });
</script>