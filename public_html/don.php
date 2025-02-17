<?php
// Increase memory limit lebih tinggi
ini_set('memory_limit', '1024M');
set_time_limit(300); // Tambah timeout limit jadi 5 menit

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

// Database connection code remains same ...
$host = '10.140.1.13';
$user = 'vms';
$pass = 'Vms-ECI2023!';
$db = 'vms_db';
$dsn = "mysql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Validate input parameters
    // if (empty($_POST['date_from']) || empty($_POST['date_to']) || empty($_POST['supplier_code'])) {
    //     throw new Exception('Required parameters are missing');
    // }
    
    $date_from = '2024-10-01';
    $date_to = '2024-10-01';
    $supplier_code = 'E0321';
    
    // Your existing query remains the same...
    $stmt = $pdo->prepare(" 
	SELECT
        po.purchase_order_no,
        po.document_date,
        CASE
            WHEN p.purchase_order_no IS NOT NULL THEN 'Paid'
            WHEN rp.purchase_order_no IS NOT NULL THEN 'Ready to Pay'
            WHEN ir.rs_no_sap IS NOT NULL THEN 'Invoicing Process'
            WHEN ir.purchase_order_no IS NOT NULL AND ir.rs_no_sap IS NULL THEN 'Pengajuan Invoice'
            WHEN sp.purchase_order_no IS NOT NULL THEN 'Settlement Price'
            WHEN gr.purchase_order_no IS NOT NULL THEN 'Settlement Qty'
            ELSE 'Open PO'
        END AS status_po,
        pi.product_code,
        pi.description,
        pi.quantity,
        po.supplier_name,
        po.delivery_date,
        po.supplier_code,
        po.store_code,
        st.name AS store_name,
        pi.departement_desc_item,
        po.expired_date_po AS due_date_po,
        pi.unit_price AS gross_unit_price,
        pi.amount AS nettprice,
        pi.vat_amount AS tax_amount,
        pi.amount_after_tax
    FROM
        purchase_order po
        LEFT JOIN purchase_order_item pi ON pi.purchase_order_no = po.purchase_order_no
        LEFT JOIN goods_receive gr ON gr.purchase_order_no = po.purchase_order_no
        LEFT JOIN proforma_invoice sp ON sp.purchase_order_no = po.purchase_order_no
        LEFT JOIN invoice_receipt ir ON ir.purchase_order_no = po.purchase_order_no
        LEFT JOIN sap_ready_to_pay rp ON rp.purchase_order_no = po.purchase_order_no
        LEFT JOIN sap_paid p ON p.purchase_order_no = po.purchase_order_no
        LEFT JOIN store st ON st.code = po.store_code
    	WHERE
        po.document_date BETWEEN :date_from AND :date_to
        AND po.supplier_code = :supplier_code 
	");     
	$stmt->execute(['date_from' => $date_from, 'date_to' => $date_to, 'supplier_code' => $supplier_code]);
    
        $spreadsheet = new Spreadsheet();
    
    	$sheet = $spreadsheet->getActiveSheet();
    	$rows = $stmt->fetchAll();
    
    if (!empty($rows)) {
        $columnNames = array_keys($rows[0]);
        foreach ($columnNames as $colIndex => $columnName) {
            $sheet->setCellValueExplicitByColumnAndRow(
                $colIndex + 1,
                1,
                $columnName,
                DataType::TYPE_STRING
            );
        }
        
        $rowNumber = 2;
        foreach ($rows as $row) {
            $colIndex = 1;
            foreach ($row as $value) {
                if (is_null($value)) {
                    $value = '';
                }
                
                $sheet->setCellValueExplicitByColumnAndRow(
                    $colIndex,
                    $rowNumber,
                    $value,
                    DataType::TYPE_STRING
                );
                $colIndex++;
            }
            $rowNumber++;
            
            // Free memory periodically
            if ($rowNumber % 100 === 0) {
                gc_collect_cycles();
            }
        }
    }
    

    while (ob_get_contents()) {
        ob_end_clean();
    }
    
    // Set headers
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ReportPO_' . htmlspecialchars($supplier_code) . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    // Create writer with memory optimization
    $writer = new Xlsx($spreadsheet);
    $writer->setPreCalculateFormulas(false);
    
    try {
        $writer->save('php://output');
    } catch (Exception $e) {
        error_log("Excel generation error: " . $e->getMessage());
        http_response_code(500);
        echo "Error generating excel file: " . $e->getMessage();
    }
    
    // Clean up
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    gc_collect_cycles();
    
} catch (Exception $e) {
    error_log("Script error: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred: " . $e->getMessage();
} finally {
    
    $pdo = null;
}
exit();