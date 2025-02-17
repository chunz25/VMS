<?php
require_once("db_connPDO.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input parameters
    $supplier_code = isset($_POST['supplier_code']) ? $_POST['supplier_code'] : null;
    $po_from = isset($_POST['po_from']) ? (int)$_POST['po_from'] : null;
    $po_to = isset($_POST['po_to']) ? (int)$_POST['po_to'] : null;

    $sql = "SELECT goods_receive_no AS noid FROM invoice_receipt WHERE goods_receive_no BETWEEN :po_from AND :po_to";
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

    // die(var_dump($ress));

    // Define the directory where PO files are stored
    $po_directory = '_docs/FP/'; // Change this to your actual PO files directory

    // Name the ZIP file
    $zip_name = 'FP_Files_' . $po_from . '_to_' . $po_to . '.zip';

    // Initialize ZIP archive
    $zip = new ZipArchive();
    $zip_path = sys_get_temp_dir() . '/' . $zip_name; // Create zip in the temp directory

    if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($ress as $r) {
            $p = $r['noid'];
            $file_path = $po_directory . $p . '.pdf'; // Example filename: PO_123.pdf

            if (file_exists($file_path)) {
                $zip->addFile($file_path, basename($file_path)); // Add file to the ZIP archive
            }
        }

        // Close the ZIP file
        $zip->close();

        // Serve the ZIP file for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zip_name . '"');
        header('Content-Length: ' . filesize($zip_path));

        // Read the file
        readfile($zip_path);

        // Clean up temporary file
        unlink($zip_path);

        exit;
    } else {
        die('Failed to create ZIP file.');
    }
} else {
    die('Invalid request method.');
}
