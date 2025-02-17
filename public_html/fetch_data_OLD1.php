<?php
require_once("db_connPDO.php");

$date_from = $_POST['date_from'] ?? null;
$date_to = $_POST['date_to'] ?? null;
$supplier_type = $_POST['supplier_type'] ?? "";
$user_type = $_POST['tb_id_user_type'] ?? "";
$status_po = $_POST['status_po'] ?? "";
$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$rowsPerPage = 10; // Number of rows per page

// Calculate offset
$offset = ($page - 1) * $rowsPerPage;

// Prepare base SQL with filters
$sql = "SELECT * FROM vw_rsdispute WHERE insert_date BETWEEN :date_from AND :date_to";
$params = [
    ':date_from' => $date_from,
    ':date_to' => $date_to,
];
if ($supplier_type) {
    $sql .= " AND supplier_code = :supplier_type";
    $params[':supplier_type'] = $supplier_type;
}
if ($status_po) {
    $sql .= " AND status_invr = :status_po";
    $params[':status_po'] = $status_po;
}

// Get total rows count for pagination
$countSql = "SELECT COUNT(*) FROM ($sql) AS total";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $rowsPerPage);

// Add LIMIT for pagination
$sql .= " LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', (int)$rowsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();

// Display data rows
if ($stmt->rowCount() > 0) {
    while ($arr = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr valign="top">
    <td><?= htmlspecialchars($arr['rs_no_sap']); ?></td>
    <td><?= htmlspecialchars($arr['insert_date']); ?></td>
    <td><?= htmlspecialchars($arr['purchase_order_no']); ?></td>
    <td><?= htmlspecialchars($arr['no_invoice_supplier']); ?></td>
    <td><?= htmlspecialchars($arr['store_code']); ?></td>
    <td><?= htmlspecialchars($arr['supplier_code']); ?></td>
    <td><?= htmlspecialchars($arr['supplier_name']); ?></td>
    <td align="right"><?= number_format($arr['total_amount'], 2); ?></td>
    <td align="right"><?= number_format($arr['vat_amount'], 2); ?></td>
    <td align="right"><?= number_format($arr['biaya_materai'], 2); ?></td>
    <td align="right"><?= number_format(($arr['grand_total'] + $arr['biaya_materai']), 2); ?></td>
    <td align="center">
        <?php
                if ($arr['status_invr'] == '51') {
                    echo '<span class="label label-info"> Proses Verifikasi</span>';
                } elseif ($arr['status_invr'] == '53') {
                    if ($user_type == '5') {
                ?>
        <a class="btn btn-default btn-flat btn-sm btn-danger"
            onclick="bukaModalHelmizz301('#tempatmodalTF2','index.php?main=040&main_act=010&main_id=400405_01_05&po_no=<?= urlencode($arr['purchase_order_no']); ?>&gr_no=<?= urlencode($arr['goods_receive_no']); ?>&no_inv_sup=<?= urlencode($arr['no_invoice_supplier']); ?>','','#tampil2');">File
            Upload<br> Tidak Sesuai !</a>
        <?php
                    } else {
                    ?>
        <button class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#add01">File Upload<br> Tidak
            Sesuai !
        </button>
        <?php
                    }
                } elseif ($arr['status_invr'] == '54') {
                    echo '<span class="label label-info">Verified</span>';
                }
                ?>
    </td>
    <td align="center">
        <button class="btn btn-warning btn-xs btn-flat" data-toggle="modal" data-target="#add01"
            onclick="cobayy('RECEIPT+SUPPLIER','400405_01_01','<?= urlencode($arr['no_invoice_supplier']); ?>&po_no=<?= urlencode($arr['purchase_order_no']); ?>&invrstat=<?= urlencode($arr['status_invr']); ?>');">
            <?php 
             if (($user_type == '3') && ($arr['status_invr'] === '51')) {
                echo "Confirm";
            } else {
                echo "Detail";
            }
            ?>
        </button>
    </td>
    <td align="center">
        <?php
                if ($arr['proforma_invoice_no']) {
                ?>
        <button class="btn btn-success btn-xs btn-flat" data-toggle="modal" data-target="#add01"
            onclick="cobayy('PROFORMA+INVOICE','400403_03_01','<?= urlencode($arr['proforma_invoice_no']); ?>&param_menu4=<?= htmlspecialchars($arr['status_pfi']); ?>');">
            View
        </button>
        <?php
                }
                ?>
    </td>
</tr>
<?php
    }
} else {
    echo '<tr><td colspan="14" align="center">No data found</td></tr>';
}

// Add a split marker to separate data and pagination
echo '<!--PAGINATION_SPLIT-->';

if ($totalPages > 1) {
    echo '<div class="pagination">';
    echo "<a href='#' class='pagination-link' data-page='1'>First</a>";

    // Pages range limit, showing only 5 pages at a time
    $start = max(1, $page - 2);
    $end = min($totalPages, $page + 2);

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            echo "<span class='current-page'>$i</span>";
        } else {
            echo "<a href='#' class='pagination-link' data-page='$i'>$i</a>";
        }
    }

    echo "<a href='#' class='pagination-link' data-page='$totalPages'>Last</a>";
    echo '</div>';
}
?>