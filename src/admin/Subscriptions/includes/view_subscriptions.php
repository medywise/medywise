<?php require_once('../../initialize.php'); ?>
<?php
    // $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    // $itemsPerPage = 10;
    // $itemsTotalCount = Subscriptions::countAll();
    
    // $paginate = new Paginate($page, $itemsPerPage, $itemsTotalCount);
    // $sql = "SELECT * FROM subscription ";
    // $sql .= "LIMIT {$itemsPerPage} ";
    // $sql .= "OFFSET {$paginate->offset()}";
    // $subscriptions = Subscriptions::findSubscriptionByQuery($sql);

    $subscriptions = Subscriptions::findAllSubscriptions();
?>