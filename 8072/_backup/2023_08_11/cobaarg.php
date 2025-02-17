<?php
echo "ini argc nya :\n";
var_dump($argc);
echo "\n";
echo "ini argc nya :\n";
var_dump($argv);

$xx=array_key_exists("1",$argv);
$yy=array_key_exists("2",$argv);
if($xx){$jml_hari=$argv[1];}else{$jml_hari=1;}
if($yy){$tgl_mulai=$argv[2];}else{$tgl_mulai=date("Y-m-d");}

$datexx = date_create($tgl_mulai);

for($i=1;$i<=$jml_hari;$i++)
{
	date_modify($datexx, '-1 day');
$tanggal= date_format($datexx, 'Y-m-d');
	echo "$i. ".$tanggal."\n";
}

include "include/coba.php";





?>