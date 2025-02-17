<?php
// ini_set('display_errors',0);
include "include/mulai.php";
/*
$srcPO='d:/aplikasiweb/8072/data/po_1/';
$destPO='d:/aplikasiweb/8072/data/po_2/';
$srcRN='d:/aplikasiweb/8072/data/gr_1/';
$destRN='d:/aplikasiweb/8072/data/gr_2/';
*/

// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)

$srcPO='/home/vms/shareFile/PO/';
$destPO='/home/vms/public_html/_docs/PO/';
$srcRN='/home/vms/shareFile/GR/';
$destRN='/home/vms/public_html/_docs/GR/';

// PO
$outputPO=null;
$retvalPO=null;
// $paramdatePO=date("Ymd");
$paramdatePO="20240212";
exec('find '.$srcPO.' -type f -name "'.$paramdatePO.'*.pdf" -exec echo {} \;', $outputPO, $retvalPO);

foreach ($outputPO as $key1 => $value1) 
		{	
			// print_r($value1);
			// echo "\n";
			$value11 = basename($value1);
			$newPOArr=explode("-", $value11);
			if(is_file($value1))
			{
				
				if (!copy($value1, $destPO.$newPOArr[1].".pdf")) {
					echo "failed to copy $srcPO.$value11...\n";
				}
				
				
				
			}
	    }   

// GR
$outputRN=null;
$retvalRN=null;
// $paramdateRN=date("Ymd");
$paramdateRN="20240212";
exec('find '.$srcRN.' -type f -name "*'.$paramdateRN.'*.pdf" -exec echo {} \;', $outputRN, $retvalRN);


foreach ($outputRN as $key2 => $value2) 
		{	
			print_r($value2);
			echo "\n";
			$value22 = basename($value2);
			$newRNArr=explode("-", $value22);
			if(is_file($value2))
			{
				
				if (!copy($value2, $destRN.$newRNArr[0].".pdf")) {
					echo "failed to copy $srcRN.$value22...\n";
				}
			}
	    } 

include "include/selesai.php";
?>
