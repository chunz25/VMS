<?php
require 'vendor/autoload.php';
require_once("db_connPDO.php");

use setasign\Fpdi\Fpdi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input parameters
    $supplier_code = isset($_POST['supplier_code']) ? $_POST['supplier_code'] : null;
    $po_from = isset($_POST['po_from']) ? (int)$_POST['po_from'] : null;
    $po_to = isset($_POST['po_to']) ? (int)$_POST['po_to'] : null;

    $sql = "SELECT purchase_order_no AS nopo FROM purchase_order WHERE purchase_order_no BETWEEN :po_from AND :po_to";
    $params = [
        ':po_from' => $po_from,
        ':po_to' => $po_to,
    ];

    if ($supplier_code) {
        $sql .= " AND supplier_code = :supplier_code";
        $params[':supplier_code'] = $supplier_code;
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $ress = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $po_directory = '_docs/PO/'; 
    $zip_name = 'PO_Files_' . $po_from . '_to_' . $po_to . '.pdf';

    $pdf = new FPDI();

    foreach ($ress as $r) {
        $p = $r['nopo'];
        $file_path = $po_directory . $p . '.pdf'; 

        $pageCount = $pdf->setSourceFile($file_path);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }
    }

    if (ob_get_contents()) {
        ob_end_clean();
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="merged.pdf"');
    header('Cache-Control: max-age=0');

    $pdf->Output('I', $zip_name);

    exit;
} else {
    die('Invalid request method.');
}
