<?php
// DEBIT NOTE ======================================================
    // get the HTML
//ini_set('display_errors', '1');
$folderXX='/home/helmi/php/b2b/_docs/INVR/';
if($_REQUEST['pwd']=='730e85e6ce5a47b805e96bf133a8756b')
{
	if($_REQUEST['docno']!='')
	{
		ob_start();
		$pwdnya='730e85e6ce5a47b805e96bf133a8756b';
		$docnonya=$_REQUEST['docno'];
		include(dirname(__FILE__).'/2bf7c86076439fae01ad525ed26cf261.php');
		$content = ob_get_clean();

		// convert in PDF
		require_once(dirname(__FILE__).'/_third_party/html2pdf/html2pdf.class.php');
		try
		{
			$xxx=md5(sha1($docnonya));
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	//      $html2pdf->setModeDebug();
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output($folderXX.$xxx.'.pdf','F');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	}
}
?>