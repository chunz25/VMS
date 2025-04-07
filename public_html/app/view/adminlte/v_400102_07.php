<?php
$sql = "SELECT * FROM tb_user_group";
$rs = $db->Execute($sql); 
echo __FILE__;
?>
<TABLE id="tbl08"  class="table table-striped table-bordered" style="padding:0px;">
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
        <td ><?= $arr['tb_user_group_id'];?></td>
        <td ><?= $arr['ta_application_id'];?></td>
        <td ><?= $arr['user_group_nm'];?></td>
        <td ><?= $arr['user_group_desc'];?></td>
        <td ><?= $arr['admin_fg'];?></td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>