<?php
include_once('inc_condition.php');

$sql = "SELECT * FROM debit_note WHERE 1=1 " . $sql_400401_01;
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
    <div class="box-body table-responsive" style="padding:2px;">

      <TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
        <THEAD>
          <tr valign="top">
            <td align="center"><b>DEBIT_NOTE_NO</b></td>
            <td align="center"><b>STORE_CODE</b></td>
            <td align="center"><b>SUPPLIER_CODE</b></td>
            <td align="center"><b>SUPPLIER_NAME</b></td>
            <td align="center"><b>DOCUMENT_DATE</b></td>
            <td align="center"><b>TOTAL_AMOUNT</b></td>
            <td align="center"><b>TAX_REG_NO</b></td>
            <td align="center"><b>ACTION</b></td>
          </tr>
        </THEAD>
        <TBODY>
          <?php if ($rs)
            while ($arr = $rs->FetchRow()) { ?>
              <tr valign="top">
                <td><?= $arr['debit_note_no']; ?></td>
                <td><?= $arr['store_code']; ?></td>
                <td><?= $arr['supplier_code']; ?></td>
                <td><?= $arr['supplier_name']; ?></td>
                <td align="center"><?= $arr['document_date']; ?></td>
                <td align="right"><?= number_format($arr['total_amount']); ?></td>
                <td align="center"><?= $arr['tax_reg_no']; ?></td>
                <td align="center"><button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
                    onclick="cobayy('DEBIT+NOTE','400602_00_01','<?= $arr['debit_note_no']; ?>');">VIEW DETAIL</button></td>
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