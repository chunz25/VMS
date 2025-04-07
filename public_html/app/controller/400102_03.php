<?php
$sql = "SELECT * FROM tb_user where tb_id_user_type=3";
$rs = $db->Execute($sql);
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">

  <button class="btn btn-success btn-xs btn-flat"
    onclick="bukaModalHelmizz301('#tempatmodal03','index.php?main=040&main_act=010&main_id=400102_03_01','','#tampil03');"><i
      class="fa fa-edit"></i> Add User Finance</button>
  <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01"><i class="fa fa-print"></i>
    PRINT</button>
  <button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01">XLSX</button>
  <hr>
  <TABLE id="tbl03" class="table table-striped table-bordered" style="padding:0px;">
    <THEAD>
      <tr valign="top">
        <td align="center"><b>EMAIL</b></td>
        <td align="center"><b>USERNAME</b></td>
        <td align="center"><b>EMPLOYEE_NO</b></td>
        <td align="center"><b>STORE_CODE</b></td>
      </tr>
    </THEAD>
    <TBODY>
      <?php if ($rs)
        while ($arr = $rs->FetchRow()) { ?>
          <tr valign="top">
            <td><?= $arr['email']; ?></td>
            <td><?= $arr['username']; ?></td>
            <td><?= $arr['employee_no']; ?></td>
            <td><?= $arr['store_code']; ?></td>
          </tr>
        <?php } ?>
    </TBODY>
  </TABLE>
</div>
<div id="tempatmodal03"></div>