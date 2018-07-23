<?php require_once("../initialize.php"); ?>
<?php require_once SITE_ROOT . DS . 'api' . DS . 'google' . DS . 'google_config.php'; ?>
<?php $user = new User(); ?>
<?php
    session_destroy();
    
    if (isset($_COOKIE['email'])) {
        unset($_COOKIE['email']);
        setcookie('email', '', time()-86400);
    } elseif (isset($_SESSION['access_token'])) {
        unset($_SESSION['access_token']);
        $gClient->revokeToken(['refresh_token' => 'xxx']);
    }
    $user->redirect("login.php");
?>