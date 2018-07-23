<?php require_once('../../initialize.php'); ?>
<?php
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 10;
    $itemsTotalCount = Categories::countAll();

    $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    $sql = "SELECT * FROM categories ";
    $sql .= "LIMIT {$itemsPerPage} ";
    $sql .= "OFFSET {$paginate->offset()}";
    $categories = Categories::findCategoryByQuery($sql);
?>