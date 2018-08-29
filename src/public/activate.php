<?php require_once("../initialize.php"); ?>
<?php $user = new User(); ?>
<?php if ($user->userLoggedIn()) {
    $user->redirect("index.php");
} ?>
<?php $user->activateUser() ?>