<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Delete Company'; ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    }

    $company = Companies::findCompanyById($_GET['id']);

    if ($company) {
        $company->deleteCompany();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>