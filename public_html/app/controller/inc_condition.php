<?php
$dept = $_SESSION['lock1'] . $_SESSION['lock2'] . $_SESSION['lock3'];
switch ($_SESSION['tb_id_user_type']) {
        case 1:
                $sql_400401_01 = " ";
                break;
        case 2:
                $sql_400401_01 = "  AND '" . $dept . "' like concat('%', department ,'%') ";
                break;
        case 3:
                $sql_400401_01 = " ";
                break;
        case 4:
                $sql_400401_01 = " AND store_code='" . $_SESSION['store_code'] . "'";
                break;
        case 5:
                $sql_400401_01 = " AND supplier_code='" . $_SESSION['supplier_code'] . "'";
                break;
        case 6:
                $sql_400401_01 = " AND supplier_code in (" . $_SESSION['supplier_group'] . ")";
                break;
        case 8:
                $sql_400401_01 = " ";
                break;
}