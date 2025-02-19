<?php
// ini_set('display_errors',1);
/*
1. cek ukuran file dulu
2. cek jenis file pajak, harus pdf
3. simpan dulu file pdf Pajak
4. cek ke DJP file pajaknya valid engga ?
5. simpan file lainnya
6. masukkan ke database dan proses

*/
// die(print_r($_REQUEST));
// sleep(5);

// $db->debug = true;
$gr_no = $_REQUEST["gr_no"];
// echo $param;die;

function cek_ukuran_file($param1 = "", $param2 = "", $param3 = "", $param4 = "")
{
	$limitSize = 10 * 1024 * 1024;

	$resultnya = (($param1 < $limitSize) and ($param2 < $limitSize) and ($param3 < $limitSize) and ($param3 < $limitSize)) ? "success" : "Ukuran File tidak boleh lebih dari 5 MB ";
	// .$param1." === ".$param2."===".$param3;

	return $resultnya;
}

function cek_jenis_file($param = "")
{
	$type_file = strtolower(pathinfo($param, PATHINFO_EXTENSION));
	if ($type_file == "pdf") {
		$resultnya = "success";
	} else {
		die("File Yang diUpload Harus dalam format pdf...");
		// die("File Yang diUpload Harus dalam format pdf dan harus asli dari DJP...");
	}

	return $resultnya;
}


function validasi_file($param3 = "")
{
}

function simpan_file($param1 = "", $param2 = "")
{

	$resultnya = move_uploaded_file($param1, $param2) ? "success" : "File gagal disimpan \n" . $param1 . "\n" . $param2;

	return $resultnya;
}

function proses_cek_djp($param1 = "", $param2 = "", $param3 = "")
{
	// global $_SERVER,$_REQUEST;
	global $no_faktur_pajak, $tgl_faktur_pajak;
	$folder_root = $_SERVER['DOCUMENT_ROOT'];
	$folder_file_fp = $folder_root . "/_docs/FP/";
	// $folder_file_fp="D:/aplikasiweb/8071/_docs/FP/";
	$exec = 'java -jar ' . '"' . $folder_root . '/_exec/pdf1/pdf1.jar"';
	// $exec='java -jar '.'"D:/aplikasiweb/8071/_exec/pdf1/pdf1.jar"';
	// $resultnya = ($exec." -i ".'"'.$param1.'" -fi '.'"'.$folder_file_fp.'"');

	$content_xml0 = shell_exec($exec . " -i " . '"' . $param1 . '" -fi ' . '"' . $folder_file_fp . '"');
	$content_xml1 = json_decode(($content_xml0), true);
	$resultX = $content_xml1['result'];
	$address = $content_xml1['data'];


	if ($resultX == "success") {
		$xmlcontent = file_get_contents($address);
		$hasil_xml = simplexml_load_string($xmlcontent);
		$noFP = $hasil_xml->kdJenisTransaksi . $hasil_xml->fgPengganti . $hasil_xml->nomorFaktur;
		$noNPWP = $hasil_xml->npwpPenjual;
		$noNPWPdata = str_replace("-", "", str_replace(".", "", $_REQUEST["npwp_no"]));
		$no_faktur_pajak = $noFP;

		if ($noFP != '' and $noFP != null) {
			// if(	$noNPWP==$noNPWPdata)
			{
				$tanggalFaktur = $hasil_xml->tanggalFaktur;
				$jumlahDpp = $hasil_xml->jumlahDpp;
				$jumlahPpn = $hasil_xml->jumlahPpn;
				$referensi = $hasil_xml->referensi;

				$parsing_tgl = explode("/", $tanggalFaktur);
				$tgl_faktur_pajak = $parsing_tgl[2] . "-" . $parsing_tgl[1] . "-" . $parsing_tgl[0];

				$param4 = $_REQUEST["vat_amount"];
				$param5 = $_REQUEST["total_amount"];

				$diff_vat_amount = abs($param4 - $jumlahPpn);
				$diff_amount = abs($param5 - $jumlahDpp);

				if ($diff_vat_amount <= 100 and $diff_amount <= 1000) {
					$resultnya = "success";
				} else {
					$resultnya = "Selisih VAT / Pajak Berbeda , \n 
							$param4 , $param5 \n
							$jumlahPpn , $jumlahDpp
							Selisih VAT = " . $diff_vat_amount . " Selisih Amount= " . $diff_amount;
				}
			}
			/*
																																	 else
																																	 {
																																		 $resultnya="No NPWP tidak sama dengan faktur Pajak \n Silahkan Hubungi Bagian Finance..\n No NPWP Faktur : ".$noNPWP."\n".$noNPWPdata;
																																	 }
																																	 */
		} else {
			$resultnya = "No Faktur Pajak Tidak Ditemukan";
		}
	} else {
		$resultnya = "File Faktur Pajak tidak original dari DJP";
	}

	return $resultnya;
}
// echo "cek";

$fileUpload1 = $_FILES["fakturpajak"];
$fileUpload2 = $_FILES["invoicesupplier"];
$fileUpload3 = $_FILES["suratjalan"];
$fileUpload4 = $_FILES["rn"];
$fileUpload5 = $_FILES["doklain"];

if ($_REQUEST["no_invoice_supplier"] == '' or $fileUpload1["name"] == '' or $fileUpload2["name"] == '' or $fileUpload3["name"] == '' or $fileUpload4["name"] == '') {
	if ($_REQUEST["no_invoice_supplier"] == '') {
		echo "No Invoice Supplier belum diisi";
	} else {
		echo "Ada file yang belum di upload! Silahkan cek kembali.";
	}
} else {
	// 1. cek ukuran file dulu ------------------------------------
	$resultnya = cek_ukuran_file($fileUpload1["size"], $fileUpload2["size"], $fileUpload3["size"], $fileUpload4["size"]);
	if ($resultnya == "success") {
		//  2. cek jenis file pajak, harus pdf --------------------
		$resultnya = cek_jenis_file($fileUpload1["name"], $fileUpload2["name"], $fileUpload3["name"], $fileUpload4["name"]);
		if ($resultnya == "success") {
			// 3. simpan dulu file pdf Pajak 
			$folder_root = $_SERVER['DOCUMENT_ROOT'];
			$newfilefp = $folder_root . "/_docs/FP/" . $_REQUEST["newnamefile"] . ".pdf";
			$resultnya = simpan_file($fileUpload1["tmp_name"], $newfilefp);
			if ($resultnya == "success") {
				if (trim($fileUpload2["name"]) != '') {
					$extfile2 = pathinfo($fileUpload2["name"], PATHINFO_EXTENSION);
					$newfile2 = $folder_root . "/_docs/INVSUP/" . $_REQUEST["newnamefile"] . "." . $extfile2;
					$resultnya = simpan_file($fileUpload2["tmp_name"], $newfile2);
				}

				if (trim($fileUpload3["name"]) != '') {
					$extfile3 = pathinfo($fileUpload3["name"], PATHINFO_EXTENSION);
					$newfile3 = $folder_root . "/_docs/SJ/" . $_REQUEST["newnamefile"] . "." . $extfile3;
					$resultnya = simpan_file($fileUpload3["tmp_name"], $newfile3);
				}

				if (trim($fileUpload4["name"]) != '') {
					$extfile4 = pathinfo($fileUpload4["name"], PATHINFO_EXTENSION);
					$newfile4 = $folder_root . "/_docs/RN/" . $_REQUEST["newnamefile"] . "." . $extfile4;
					$resultnya = simpan_file($fileUpload4["tmp_name"], $newfile4);
				}

				if (trim($fileUpload5["name"]) != '') {
					$extfile5 = pathinfo($fileUpload5["name"], PATHINFO_EXTENSION);
					$newfile5 = $folder_root . "/_docs/DL/" . $_REQUEST["newnamefile"] . "." . $extfile5;
					$resultnya = simpan_file($fileUpload5["tmp_name"], $newfile5);
				}
			}


			// 4. cek ke DJP file pajaknya valid engga ?
			// if ($resultnya == "success") {

			// 	$resultnya = proses_cek_djp($_REQUEST["newnamefile"], 1000, 2000);
			// 	$resultnya = "success";
			// 	if ($resultnya == "success") {

			// 		if ($_REQUEST["status_pfi"] == '34') {
			// 			$nama_sp = "ip02_inv_insert_02_sp";
			// 		} else {
			// 			$nama_sp = "ip02_inv_insert_sp";
			// 		}

			// 		if ((trim($no_faktur_pajak) == '') or ($no_faktur_pajak == null)) {
			// 			$no_faktur_pajak = $_REQUEST["no_fp"];
			// 		}
			// 		if ((trim($tgl_faktur_pajak) == '') or ($tgl_faktur_pajak == null)) {
			// 			$tgl_faktur_pajak = $_REQUEST["tgl_fp"];
			// 		}


			// 		$sql4004020102 = "CALL " . $nama_sp . "('" . $_REQUEST["pfi_no"] . "','" . $_REQUEST["no_invoice_supplier"] . "'," . $_REQUEST["biaya_materai"] . ",'" . $_REQUEST["remark"] . "','" . trim($no_faktur_pajak) . "','" . trim($tgl_faktur_pajak) . "')";
			// 		$rs = $db->Execute($sql4004020102);

			// 		if ($rs) {
			// 			// include $address_file_configs . "_lib/smtpmail/sendinv_mail.php";
			// 			$resultnya = "success";
			// 		} else {
			// 			$resultnya = "failed";
			// 		}
			// 	}
			// }

			if ($resultnya == "success") {
				$resultnya = proses_cek_djp($_REQUEST["newnamefile"], 1000, 2000);
				$resultnya = "success";
				if ($resultnya == "success") {
					if ($_REQUEST["status_pfi"] == '34') {
						$nama_sp = "ip02_inv_insert_02_sp";
					} else {
						$nama_sp = "ip02_inv_insert_sp";
					}

					if (empty(trim($no_faktur_pajak))) {
						$no_faktur_pajak = $_REQUEST["no_fp"];
					}
					if (empty(trim($tgl_faktur_pajak))) {
						$tgl_faktur_pajak = $_REQUEST["tgl_fp"];
					}

					try {
						$params = [
							'pfi_no' => $_REQUEST["pfi_no"],
							'no_invoice_supplier' => $_REQUEST["no_invoice_supplier"],
							'biaya_materai' => $_REQUEST["biaya_materai"],
							'remark' => $_REQUEST["remark"],
							'no_faktur_pajak' => trim($no_faktur_pajak),
							'tgl_faktur_pajak' => trim($tgl_faktur_pajak)
						];
						
						$sql4004020102 = "CALL " . $nama_sp . "('" . $_REQUEST["pfi_no"] . "','" . $_REQUEST["no_invoice_supplier"] . "'," . $_REQUEST["biaya_materai"] . ",'" . $_REQUEST["remark"] . "','" . trim($no_faktur_pajak) . "','" . trim($tgl_faktur_pajak) . "')";
						$rs = $db->Execute($sql4004020102);

						if ($rs) {
							$resultnya = "success";
						} else {
							$errorMessage = "Gagal menjalankan stored procedure " . $nama_sp . ". Error: " . $db->ErrorMsg() . ". Detail Parameter: " . json_encode($params);
							// $errorMessage = json_encode($stmt);
							throw new Exception($errorMessage);
						}
					} catch (Exception $e) {
						$resultnya = "failed";
						error_log("Error: " . $e->getMessage());
						echo json_encode(["status" => "failed", "message" => $e->getMessage()]);
						exit;
					}
				}
			}

		}
	}
}


echo ($resultnya);
