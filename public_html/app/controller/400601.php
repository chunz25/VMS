<?php
switch ($_SESSION['tb_id_user_type']) {
  case 1:
    $sql_400401_01 = " ";
    break;
  case 2:
    $sql_400401_01 = "  ";
    break;
  case 3:
    $sql_400401_01 = " ";
    break;
  case 4:
    $sql_400401_01 = " AND store_code='" . $_SESSION['store_code'] . "'";
    break;
  case 5:
    $sql_400401_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
    break;
  case 6:
    $sql_400401_01 = " AND supplier_group in (" . $_SESSION['supplier_code'] . ")";
    break;
}

$sql_condition = "";
$sql = "SELECT * FROM debit_note WHERE 1=1 " . $sql_400401_01;
$rs = $db->Execute($sql);
?>
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
    <div class="box-body table-responsive" style="padding:2px;">
      <TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
        <THEAD>
          <tr valign="top">
            <td align="center"><b>DN NO</b></td>
            <td align="center"><b>SUPPLIER_CODE</b></td>
            <td align="center"><b>SUPPLIER_NAME</b></td>
            <td align="center"><b>DOCUMENT_DATE</b></td>
            <td align="center"><b>DUE_DATE</b></td>
            <td align="center"><b>TOTAL_AMOUNT</b></td>
            <td align="center"><b>TAX_REG_NO</b></td>
            <td align="center"><b>FAKTUR_PAJAK_NO</b></td>
            <td align="center"><b>TAX_ID</b></td>
            <td align="center"><b>ADDRESS</b></td>
          </tr>
        </THEAD>
        <TBODY>
          <?php if ($rs)
            while ($arr = $rs->FetchRow()) { ?>
              <tr valign="top">
                <td><?= $arr['debit_note_no']; ?></td>
                <td><?= $arr['supplier_code']; ?></td>
                <td><?= $arr['supplier_name']; ?></td>
                <td><?= $arr['document_date']; ?></td>
                <td><?= $arr['due_date']; ?></td>
                <td><?= number_format($arr['total_amount']); ?></td>
                <td><?= $arr['tax_reg_no']; ?></td>
                <td><?= $arr['faktur_pajak_no']; ?></td>
                <td><?= $arr['tax_id']; ?></td>
                <td><?= $arr['address']; ?></td>
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
  function klikallcekbox() {
    alert('test');
    $('.cekboxpilih').each(function () { //iterate all listed checkbox items
      this.checked = true; //change ".checkbox" checked status
    });
  }

  function bukaModalHelmizz301(param1, param2, param3, param4) {
    $('#loading').modal('show');
    $(param1).load(param2,
      param3,
      function (responseTxt, statusTxt, xhr) {
        if (statusTxt == "success") {
          $('#loading').modal('hide');
          $(param4).modal('show');
        }
        if (statusTxt == "error")
          alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
      }
    );
  }
</script>