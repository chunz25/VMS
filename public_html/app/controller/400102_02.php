<?php
$sql = "SELECT * FROM tb_user  where tb_id_user_type=7";
$rs = $db->Execute($sql); 
//echo __FILE__;
?>
<div class="box-body table-responsive" style="padding:2px;">
<button class="btn btn-success btn-xs btn-flat" onclick="bukaModalHelmizz301('#tempatmodal02','index.php?main=040&main_act=010&main_id=400102_02_01','','#tampil02');"><i class="fa fa-edit"></i> Add User SNDP</button>					 
    <button class="btn btn-info btn-xs btn-flat" data-toggle="modal" data-target="#add01"><i class="fa fa-print"></i> PRINT</button>  
    <button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01">XLSX</button>  
    <hr>
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
        
        <td ><?php echo $arr['username'];?></td>      
        <td ><?php echo $arr['fullname'];?></td>
        <td ><?php echo $arr['department'];?></td>
		<td ><?php echo $arr['email'];?></td>
		<td ><?php echo $arr['last_login'];?></td>
         <td align="center" >
		<a href="<?php echo $wa_address;?>" target="whatsappWeb"><button class="btn btn-info btn-xs btn-flat"  data-toggle="tooltip" title="Chat via WhatsApp Web <?php echo $hp;?> " ><i class="fa fa-whatsapp"></i></button></a>
		<button class="btn btn-info btn-xs btn-flat" onclick="mailto:('<?php echo $email;?>');" data-toggle="tooltip" title="Send Email <?php echo $hp;?> " ><i class="fa fa-envelope"></i></button>
		<button class="btn btn-warning btn-xs btn-flat" onclick="window.open('<?php echo $wa_address;?>');" data-toggle="tooltip" title="Reset Password <?php echo $hp;?> " ><i class="fa fa-wrench"></i></button>
		<button class="btn btn-info btn-xs btn-flat" onclick="window.open('<?php echo $wa_address;?>');" data-toggle="tooltip" title="See Detail <?php echo $hp;?> " ><i class="fa fa-search"></i></button>
		</td>
      </tr>
<?php } ?>
</TBODY>
</TABLE>
</div>
<div id="tempatmodal02"></div>