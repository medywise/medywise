<?php require_once('../../initialize.php'); ?>
<?php
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 10;
    $itemsTotalCount = Companies::countAll();

    $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    $sql = "SELECT * FROM company ";
    $sql .= "LIMIT {$itemsPerPage} ";
    $sql .= "OFFSET {$paginate->offset()}";
    $companies = Companies::findCompanyByQuery($sql);
?>