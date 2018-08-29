<?php
    require_once("../../initialize.php");
    require_once MAIN_ROOT . DS . 'vendor' . DS . 'guzzlehttp' . DS . 'guzzle' . DS . 'src' . DS . 'Client.php';
    require_once SITE_ROOT . DS . 'api' . DS . 'google' . DS . 'google_config.php';

    if (isset($_SESSION['access_token'])) {
        $gClient->setAccessToken($_SESSION['access_token']);
    } elseif (isset($_GET['code'])) {
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    } else {
        header("Location: ../../public/login.php");
        exit();
    }

    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

    $_SESSION['givenName'] = $userData['givenName']; //First Name
    $_SESSION['familyName'] = $userData['familyName']; //Last Name
    $_SESSION['displayName'] = $userData['displayName']; //Username
    $_SESSION['email'] = $userData['email']; //Email
    $_SESSION['gender'] = $userData['gender']; //Sex or Gender
    $_SESSION['picture'] = $userData['picture']; //Profile Picture
    $_SESSION['birthday'] = $userData['birthday']; //Date Of Birth

    header("Location: ../../public/index.php");
    user_log_action('Login', "{$_SESSION['email']} logged in via Google.");
    exit();
