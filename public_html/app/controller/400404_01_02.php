<?php

//$db->debug=true;
// ambil data file
$uploads_dir = '_docs/FP/';
$tmp_name = $_FILES["fakturpajak"]["tmp_name"];
$tmp_name2 = $_FILES["fakturpajak"]["name"];
$name_ori = $_REQUEST["newnamefile"];
$name = $_REQUEST["newnamefile"] . ".pdf";
$type_file = strtolower(pathinfo($tmp_name2, PATHINFO_EXTENSION));

if ($type_file == "pdf") {
	move_uploaded_file($tmp_name, "$uploads_dir.$name");


	$nama_file_fp = "." . $name_ori;
	$folder_file_fp = "/home/helmi/php/b2b/_docs/FP/";
	if (is_file($folder_file_fp . $nama_file_fp . ".pdf")) {

		$content_xml0 = shell_exec('java -jar ' . '"/home/helmi/php/b2b/_exec/pdf1/pdf1.jar"' . " -i " . '"' . $nama_file_fp . '" -fi ' . '"' . $folder_file_fp . '"');
		$content_xml1 = json_decode(($content_xml0), true);
		$resultX = $content_xml1['result'];
		$address = $content_xml1['data'];

		if ($resultX == "success") {
			$xmlcontent = file_get_contents($address);
			$hasil_xml = simplexml_load_string($xmlcontent);
			$noFP = $hasil_xml->kdJenisTransaksi . $hasil_xml->fgPengganti . $hasil_xml->nomorFaktur;

			if ($noFP != '' and $noFP != null) {
				$tanggalFaktur = $hasil_xml->tanggalFaktur;
				$jumlahDpp = $hasil_xml->jumlahDpp;
				$jumlahPpn = $hasil_xml->jumlahPpn;
				$referensi = $hasil_xml->referensi;

				$diff_vat_amount = abs($_REQUEST[vat_amount] - $jumlahPpn);
				$diff_amount = abs($_REQUEST[total_amount] - $jumlahDpp);

				if ($diff_vat_amount <= 100 and $diff_amount <= 1000) {
					$result = "success";
				} else {
					$result = "failed4";
				}
			} else {
				$result = "failed1";
			}
		} else {
			$result = "failed2";
		}
	} else {
		$result = "File Yang diUpload Harus dalam format pdf dan harus asli dari DJP ";
	}


	if ($result == "success") {
		$sql4004020102 = "CALL inv_receipt_insert_sp ('" . $_REQUEST["main_id_key"] . "')";
		$rs = $db->Execute($sql4004020102);
	} else {
		echo "file Faktur Pajak not valid, only pdf file from DJP....!" . $result;
	}
} else {
	echo "file Faktur Pajak not valid, only pdf file from DJP....!";
}

//  print_r($_FILES); //[param_menu3];

if ($rs) {
	echo "success";
} else {
	echo "failed";
};
