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

    $user = User::findUserById($_GET['id']);

    if ($user) {
        $user->deleteUser();
        redirectTo("view.php");
    } else {
        redirectTo("view.php");
    }
?>