<?php
 //$db->debug=true;
if($_REQUEST["proses"]=='1')
{
		$address= $_REQUEST["address"];
		$xmlcontent = file_get_contents($address);
		$hasil_xml = simplexml_load_string($xmlcontent);
		// print_r($hasil_xml);
		$noFP=$hasil_xml->kdJenisTransaksi.$hasil_xml->fgPengganti.$hasil_xml->nomorFaktur;
// print_r($hasil_xml);
		//echo "\n";	
		$record['purchase_order_no'] =  $_REQUEST["po_no"]; 
		$record['result'] = "Revisi"; 
		$record['address'] = $address; 
		//$record['xml'] = $xml; 
		$record['no_fp'] = $noFP; 
		$record['kdJenisTransaksi'] = $hasil_xml->kdJenisTransaksi; 
		$record['fgPengganti'] = $hasil_xml->fgPengganti; 
		$record['nomorFaktur'] = $hasil_xml->nomorFaktur; 
		$record['tanggalFaktur'] = $hasil_xml->tanggalFaktur; 
		$record['jumlahDpp'] = $hasil_xml->jumlahDpp; 
		$record['jumlahPpn'] = $hasil_xml->jumlahPpn; 
		$record['jumlahPpnBm'] = $hasil_xml->jumlahPpnBm; 
		$record['statusApproval'] = $hasil_xml->statusApproval; 
		$record['statusFaktur'] = $hasil_xml->statusFaktur; 
		$record['referensi'] = $hasil_xml->referensi; 
		//$record['insert_date'] = $insert_date; 

		
		// delete dulu 1 record
		$sql_delete1="delete from invoice_fp where purchase_order_no='". $_REQUEST["po_no"]."'";
		$sql_delete1_exec = $db->Execute($sql_delete1);
		// INSERT TABLE -------------
		
		if($noFP!='' and $noFP != null)
			{
						$eksekusi=$db->AutoExecute('invoice_fp',$record,'INSERT');	
						if($eksekusi)
						{
							$sql_update1="update invoice_receipt set status_invr='52' where purchase_order_no='". $_REQUEST["po_no"]."'";
							$sql_update1_exec = $db->Execute($sql_update1);
							echo "success";
						}
						else
						{
							echo "notvalid_1";
						}
			}
			else
			{
				echo "notvalid_2";
			}
}

if($_REQUEST["proses"]=='2')
{
	$sql_update1="update invoice_receipt set status_invr='53' where purchase_order_no='". $_REQUEST["po_no"]."'";
	$sql_update1_exec = $db->Execute($sql_update1);
	if($sql_update1_exec)
	{
		echo "success";
	}
	else
	{
		echo "Gagal Update invoice_receipt set status_invr='53'";
	}
}	
?>