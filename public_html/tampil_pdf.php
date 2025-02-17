<?php
if($_REQUEST["kode"]="helmianwar999"){
header("Content-type: application/pdf");
if(is_file($_REQUEST["lokasifile"])){
	echo file_get_contents($_REQUEST["lokasifile"]);
	}else
	{
		echo "File tidak ditemukan !";
	}
}
?>