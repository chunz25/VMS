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
      <?php
      $sql = "SELECT * FROM ta_application";
      $rs = $db->Execute($sql); ?>

      <TABLE id="tbl01" class="table table-striped table-bordered" style="padding:0px;">
        <THEAD>
          <tr valign="top">
            <td align="center"><b>TA_APPLICATION_ID</b></td>
            <td align="center"><b>APPLICATION_CD</b></td>
            <td align="center"><b>APPLICATION_FULL_NM</b></td>
            <td align="center"><b>APPLICATION_SHORT_NM</b></td>
            <td align="center"><b>APPLICATION_DESC</b></td>
            <td align="center"><b>APPLICATION_VERSION</b></td>
            <td align="center"><b>APPLICATION_LOGO_BIG</b></td>
            <td align="center"><b>APPLICATION_LOGO_SMALL</b></td>
            <td align="center"><b>APPLICATION_SEQ</b></td>
          </tr>
        </THEAD>
        <TBODY>
          <?php if ($rs)
            while ($arr = $rs->FetchRow()) { ?>
              <tr valign="top">
                <td><?= $arr['ta_application_id']; ?></td>
                <td><?= $arr['application_cd']; ?></td>
                <td><?= $arr['application_full_nm']; ?></td>
                <td><?= $arr['application_short_nm']; ?></td>
                <td><?= $arr['application_desc']; ?></td>
                <td><?= $arr['application_version']; ?></td>
                <td><?= $arr['application_logo_big']; ?></td>
                <td><?= $arr['application_logo_small']; ?></td>
                <td><?= $arr['application_seq']; ?></td>

              </tr>
            <?php } ?>
        </TBODY>
      </TABLE>
    </div><!-- /.box-body -->
    <!-- <div class="box-footer"> 
               Footer 
            </div>  --><!-- /.box-footer-->
    <!-- <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div> -->
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