<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Delete Subscription'; ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    }

    $subscription = Subscriptions::findSubscriptionById($_GET['id']);

    if ($subscription) {
        $subscription->deleteUser();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>