<?php
// include 'don.php';
// die();
ini_set('memory_limit', '512M');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once("db_connPDO.php");

$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$supplier_code = $_POST['supplier_code'];
if ($supplier_code == "") {
    $supplier_code = '%';
}
$status_po = $_POST['statuspo'];
if ($status_po !== "") {
    $status_po = "
            AND CASE
                WHEN p.goods_receive_no IS NOT NULL THEN 7
                WHEN rp.goods_receive_no IS NOT NULL THEN 6
                WHEN ir.goods_receive_no IS NOT NULL AND ir.rs_no_sap IS NOT NULL THEN 5
                WHEN ir.goods_receive_no IS NOT NULL AND ir.rs_no_sap IS NULL THEN 4
                WHEN sp.goods_receive_no IS NOT NULL THEN 3
                WHEN gr.purchase_order_no IS NOT NULL THEN 2
                ELSE 1
            END = $status_po
        ";
}

$stmt = $pdo->prepare("
    WITH cteGR AS (
        SELECT
            a.purchase_order_no,
            GROUP_CONCAT(a.goods_receive_no SEPARATOR' | ') as gr_no,
            b.product_code,
            SUM( b.quantity ) AS gr_qty,
            b.po_quantity 
        FROM
            goods_receive a
            LEFT JOIN goods_receive_item b ON b.goods_receive_no = a.goods_receive_no 
        GROUP BY
            a.purchase_order_no,
            b.product_code,
            b.po_quantity 
        ) 
    SELECT DISTINCT
        po.purchase_order_no AS 'PO Number',
        po.document_date as 'PO Date',
        gr.gr_no as 'GR Number' ,
        CASE
            WHEN p.goods_receive_no IS NOT NULL THEN 'Paid'
            WHEN rp.goods_receive_no IS NOT NULL THEN 'Ready to Pay'
            WHEN ir.goods_receive_no IS NOT NULL AND ir.rs_no_sap IS NOT NULL THEN 'Invoicing Process'
            WHEN ir.goods_receive_no IS NOT NULL AND ir.rs_no_sap IS NULL THEN 'Pengajuan Invoice'
            WHEN sp.goods_receive_no IS NOT NULL THEN 'Settlement Price'
            WHEN gr.purchase_order_no IS NOT NULL THEN 'Settlement Qty'
            ELSE 'Open PO'
        END AS 'PO Status',
				po.header_text as 'Remark PO' ,
        pi.product_code as 'Article Code',
        pi.description as 'Article Name',
        pi.quantity as 'PO Quantity',
        po.supplier_name as 'Supplier Name',
        po.delivery_date as 'Delivery Date',
        po.supplier_code as 'Supplier Code',
        po.store_code as 'Site Code',
        st.NAME AS 'Site Name' ,
        pi.departement_desc_item as 'Department Name',
        po.expired_date_po AS 'Due Date PO',
        pi.unit_price AS 'Gross Unit Price',
        pi.amount AS 'Nett Price',
        pi.vat_amount AS 'Tax Amount',
        pi.amount_after_tax as 'Amount After Tax' 
    FROM
        purchase_order po
        LEFT JOIN purchase_order_item pi ON pi.purchase_order_no = po.purchase_order_no
        LEFT JOIN store st ON st.`code` = po.store_code
        LEFT JOIN cteGR gr ON gr.purchase_order_no = po.purchase_order_no
                            AND gr.product_code = pi.product_code
                            AND gr.gr_qty = pi.quantity
        LEFT JOIN proforma_invoice sp ON gr.gr_no LIKE CONCAT('%',sp.goods_receive_no,'%')
        LEFT JOIN invoice_receipt ir ON ir.goods_receive_no = sp.goods_receive_no
        LEFT JOIN sap_ready_to_pay rp ON rp.goods_receive_no = ir.goods_receive_no
        LEFT JOIN sap_paid p ON p.goods_receive_no = rp.goods_receive_no
    WHERE
        po.document_date BETWEEN :date_from AND :date_to
        AND po.supplier_code LIKE :supplier_code
        $status_po
");
$stmt->execute(['date_from' => $date_from, 'date_to' => $date_to, 'supplier_code' => $supplier_code]);
$rows = $stmt->fetchAll();

if (count($rows) > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (!empty($rows)) {
        $columnNames = array_keys($rows[0]);
        $col = 0;
        foreach ($columnNames as $columnName) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $columnName);
            $col++;
        }
    }

    $rowNumber = 2;
    foreach ($rows as $row) {
        $col = 0;
        foreach ($row as $cell) {
            $sheet->setCellValueByColumnAndRow($col + 1, $rowNumber, $cell);
            $col++;
        }
        $rowNumber++;
    }

    if (ob_get_contents()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    if ($supplier_code == '%') {
        header('Content-Disposition: attachment;filename="ReportPO_All_Supplier.xlsx"');
    } else {
        header('Content-Disposition: attachment;filename="ReportPO_' . $supplier_code . '.xlsx"');
    }
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1'); // For IE 9 

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();

} else {
    echo "<script type='text/javascript'>alert('Tidak ditemukan data.'); window.close();</script>";

}