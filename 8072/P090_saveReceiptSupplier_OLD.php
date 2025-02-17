<?php
include "include/mulai.php";
include "config/config.php";
include "config/koneksiDB.php";

// URL tujuan ------------------------------------------------------------------------------
// $urlAPI = 'http://devecc.electronic-city.co.id:8000/sap/ws/vms/savers?sap-client=130';
// $urlAPI = 'http://10.140.3.2:8000/sap/ws/vms/savers?sap-client=130';
// $urlAPI = "http://$serverAPI/sap/ws/vms/savers?sap-client=130";
$urlAPI = $configUrlAPI["P090"];

// Jika butuh parameter dinamis ------------------------------------------------------------
$xx = array_key_exists("1", $argv);
$yy = array_key_exists("2", $argv);
if ($xx) {
	$jml_hari = $argv[1];
} else {
	$jml_hari = 1;
}
if ($yy) {
	$tgl_mulai = $argv[2];
} else {
	$tgl_mulai = date("Y-m-d");
}

$datexx = date_create($tgl_mulai);

for ($i = 1; $i <= $jml_hari; $i++) {

	date_modify($datexx, '-1 day');
	$tanggal = date_format($datexx, 'Y-m-d');
	$tahun = date_format($datexx, 'Y');
	$jumRow = 0;

	$sql = "SELECT * FROM vms_db.vw_savers";

	$xx = $db1->query($sql);
	$noxx = 0;
	$detno = 1;

	foreach ($xx as $arr) {

		unset($data_item);
		$sql2 = "SELECT 
				a.purchase_order_no,
				a.dnnum_sap,
				a.goods_receive_no,
				YEAR(a.insert_date) as year_doc ,
				b.line_item AS sapdocitem
			from 
				vms_db.invoice_receipt a
			LEFT JOIN
				vms_db.invoice_item b
			ON
				a.invoice_no=b.invoice_no
			WHERE 
				b.quantity>0 and  a.no_invoice_supplier='" . $arr['no_invoice_supplier'] . "' and a.supplier_code='" . $arr['supplier_code'] . "' and a.purchase_order_no='" . $arr['purchase_order_no'] . "'";

		$yy = $db1->query($sql2);

		foreach ($yy as $arr2) {
			$data_item[] = array(
				"itmno" => "1", // item no
				"detno" => $detno, // detail no
				"rnnum" => "", // no Good receive ( RN )
				"ebeln" => $arr2['purchase_order_no'], // no PO
				"dnnum" => $arr2['dnnum_sap'], // DN No.
				"coniv" => "", // invoice consignment
				"congi" => "", // GI Invoice
				"mwskz" => "", // tax code
				"sapdocno" => $arr2['goods_receive_no'], // SAP doc no di isi no RN
				"sapdocitem" => $arr2['sapdocitem'], // sap item doc no
				"sapdocyear" => $arr2['year_doc'] // sap doc year
			);
			$detno++;
		};

		$total = "SELECT no_invoice_supplier ,
						 purchase_order_no , 
						 SUM(grand_total) AS grand_total, 
						 SUM(vat_amount) AS vat_amount 
				  FROM vms_db.invoice_receipt 
				  WHERE 
				  total_quantity > 0 and  no_invoice_supplier='" . $arr['no_invoice_supplier'] . "' and supplier_code='" . $arr['supplier_code'] . "' and purchase_order_no='" . $arr['purchase_order_no'] . "'
				  GROUP BY no_invoice_supplier,purchase_order_no";
		$total = $db1->query($total);

		foreach ($total as $t) {
			$gt = $t['grand_total'];
			$tx = $t['vat_amount'];
		}
		// var_dump($gt);die;
		$dataPOST = array(
			"header" => array(
				"bukrs" => $arr['company_code'], // company_code
				"prctr" => $arr['prctr'], // profit center
				"lifnr" => $arr['supplier_code'], // kode supplier
				"zterm" => $arr['payment_term_cd'], // payment term code
				"rcdat" => $arr['document_date'],  // tanggal receipt supplier
				"matwr" => (int)$arr['biaya_materai'], // biaya materai
				"waerk" => "IDR", // mata uang
				"aenam" => $arr['user_confirm']
			), // user create

			"item" => array(
				array(
					"itmno" => "1", // item nomor
					"sgtxt" => $arr['no_invoice_supplier'], // nomor invoice supplier
					"trnty" => "2001", // transaction type
					"netwr" => $gt, // total amount
					// "netwr" => $arr['grand_total'], // total amount
					"mwskz" => "P8", // tax code, P8
					"taxwr" => $tx, // tax amount
					// "taxwr" => $arr['vat_amount'], // tax amount
					"xblnr" => $arr['delivery_no_sap'], // remark , ini tadinya remark diganti inbound delivery
					"bktxt" => $arr['no_faktur_pajak'], // no faktur pajak
					"fktdt" => $arr['tgl_faktur_pajak'], // tanggal faktur
					"waerk" => "IDR"
				)
			), // mata uang			
			"detail" => $data_item

		);
		// var_dump($dataPOST);

		// save JSON File --------------------------------------------------------------
		$folder = __DIR__ . "/data/in/";
		$file_in_name = $folder . "INVR_" . $tanggal . "_" . date("Ymd") . ".json";

		include "config/koneksiCURL.php";

		if ($responseData['rsno'] != '') {
			$sql2 = "UPDATE vms_db.invoice_receipt SET rs_no_sap='" . $responseData['rsno'] . "',integrasi_date='" . date("Y-m-d H:i:s") . "' WHERE purchase_order_no='" . $arr['purchase_order_no'] . "' and no_invoice_supplier='" . $arr['no_invoice_supplier'] . "' and rs_no_sap is null";
			$statement 	= $db1->prepare($sql2);
			$statement->execute();
		}

		$jumRow++;

		$noxx++;
		echo "\n No. $noxx >>>>>>>--------------- \n";
		echo "jsondata :\n";
		print_r($jsonData);
		echo "\n response : \n";
		print_r($response);
		echo "\n respon data json : \n";
		print_r($responseData);
		echo "\n selesai cek -------------------- \n";
	}
}

unset($db1);
include "include/selesai.php";
