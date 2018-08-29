<?php require_once('../../initialize.php'); ?>
<?php
    // $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    // $itemsPerPage = 10;
    // $itemsTotalCount = User::countAll();

    // $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    // $sql = "SELECT * FROM users ";
    // $sql .= "LIMIT {$itemsPerPage} ";
    // $sql .= "OFFSET {$paginate->offset()}";
    // $users = User::findUserByQuery($sql);

    $users = User::findAllUsers();
?>