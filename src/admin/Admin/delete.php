<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Delete Admin'; ?>
<?php if (!$session->isAdminSignedIn()) {
    redirectTo("../login.php");
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    }

    $adimn = Admin::findAdminById($_GET['id']);

    if ($adimn) {
        $adimn->deleteAdmin();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>