<?php
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 10;
    $itemsTotalCount = Medicines::countAll();

    $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    $sql = "SELECT * FROM medicines ";
    $sql .= "LIMIT {$itemsPerPage} ";
    $sql .= "OFFSET {$paginate->offset()}";
    $medicines = Medicines::findMedicineByQuery($sql);
