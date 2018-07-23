<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Delete User'; ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    }

    $medicine = Medicines::findMedicineById($_GET['id']);

    if ($medicine) {
        $medicine->deleteMedicine();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>