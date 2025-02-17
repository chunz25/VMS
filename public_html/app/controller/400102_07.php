<?php
$sql = "SELECT * FROM tb_user_group";
$rs = $db->Execute($sql); 
// echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">              
	<button class="btn btn-success btn-xs btn-flat" onclick="bukaModalHelmizz301('#tempatmodal07','index.php?main=040&main_act=010&main_id=400102_07_01','','#tampil07');"><i class="fa fa-edit"></i> Add Group User</button>					 
    <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01"><i class="fa fa-print"></i> PRINT</button>  
    <button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01">XLSX</button>  
    <hr>
<TABLE id="tbl07"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">
        <td align="center"><b>TB_USER_GROUP_ID</b></td>
        <td align="center"><b>TA_APPLICATION_ID</b></td>
        <td align="center"><b>USER_GROUP_NM</b></td>
        <td align="center"><b>USER_GROUP_DESC</b></td>
        <td align="center"><b>ADMIN_FG</b></td>
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { ?>
      <tr valign="top">
        <td ><?php echo $arr['tb_user_group_id'];?></td>
        <td ><?php echo $arr['ta_application_id'];?></td>
        <td ><?php echo $arr['user_group_nm'];?></td>
        <td ><?php echo $arr['user_group_desc'];?></td>
        <td ><?php echo $arr['admin_fg'];?></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>
<div id="tempatmodal07"></div>