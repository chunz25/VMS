<?php
$sql = "SELECT * FROM tb_user  where tb_id_user_type=2";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<TABLE id="tbl02"  class="table table-striped table-bordered" style="padding:0px;">
<THEAD>
      <tr valign="top">         
        <td align="center"><b>USERNAME</b></td>       
        <td align="center"><b>FULL NAME</b></td> 
        <td align="center"><b>DEPARTMENT</b></td> 
		<td align="center"><b>EMAIL</b></td>		
        <td align="center"><b>LAST LOGIN</b></td>      
        <td align="center"><b>DETAIL</b></td>      
      </tr>
</THEAD>
<TBODY>
<?php if ($rs) 
while ($arr = $rs->FetchRow()) { 
$hp=$arr['hp'];
$email=$arr['email'];
$wa_address="https://api.whatsapp.com/send?phone=".$hp;
?>
      <tr valign="top">  
        
        <td ><?= $arr['username'];?></td>      
        <td ><?= $arr['fullname'];?></td>
        <td ><?= $arr['department'];?></td>
		<td ><?= $arr['email'];?></td>
		<td ><?= $arr['last_login'];?></td>
         <td align="center" >
		<a href="<?= $wa_address;?>" target="whatsappWeb"><button class="btn btn-info btn-xs btn-flat"  data-toggle="tooltip" title="Chat via WhatsApp Web <?= $hp;?> " ><i class="fa fa-whatsapp"></i></button></a>
		<button class="btn btn-info btn-xs btn-flat" onclick="mailto:('<?= $email;?>');" data-toggle="tooltip" title="Send Email <?= $hp;?> " ><i class="fa fa-envelope"></i></button>
		<button class="btn btn-warning btn-xs btn-flat" onclick="window.open('<?= $wa_address;?>');" data-toggle="tooltip" title="Reset Password <?= $hp;?> " ><i class="fa fa-wrench"></i></button>
		<button class="btn btn-info btn-xs btn-flat" onclick="window.open('<?= $wa_address;?>');" data-toggle="tooltip" title="See Detail <?= $hp;?> " ><i class="fa fa-search"></i></button>
		</td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>