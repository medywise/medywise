<?php require_once('../../initialize.php'); ?>
<?php
    // $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    // $itemsPerPage = 10;
    // $itemsTotalCount = Admin::countAll();

    // $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    // $sql = "SELECT * FROM admin ";
    // $sql .= "LIMIT {$itemsPerPage} ";
    // $sql .= "OFFSET {$paginate->offset()}";
    // $admins = Admin::findAdminByQuery($sql);
    $admins = Admin::findAllAdmins();
?>