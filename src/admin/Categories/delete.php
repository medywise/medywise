<?php require_once('../../src/initialize.php'); ?>
<?php $pageTitle = 'Delete Category'; ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    }

    $category = Categories::findCategoryById($_GET['id']);

    if ($category) {
        $category->delete();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>