<?php require_once('../../initialize.php'); ?>
<?php
    $session->adminLogout();
    redirectTo("../login.php");
?>