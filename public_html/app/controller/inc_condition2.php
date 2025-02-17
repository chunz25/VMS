<?php
switch ($_SESSION['tb_id_user_type']) {
    case 1:
        $sql_400401_01 = " ";
        break;
    case 2:
        $sql_400401_01 = " ";
        break;
    case 3:
        $sql_400401_01 = " ";
        break;
	case 4:
        $sql_400401_01 = " AND store_code='".$_SESSION['store_code']."'";
        break;
	case 5:
        $sql_400401_01 = " AND supplier_code='".$_SESSION['supplier_code']."'";
		break;
	case 6:
        $sql_400401_01 = " AND supplier_code in (".$_SESSION['supplier_group'].")";
        break;
}
?>