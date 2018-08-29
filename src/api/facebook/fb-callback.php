<?php
    require_once("../../initialize.php");
    require_once SITE_ROOT . DS . 'api' . DS . 'facebook' . DS . 'facebook_config.php';

    try {
        $accessToken = $helper->getAccessToken();
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo "Response Exception: " . $e->getMessage();
        exit();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo "SDK Exception: " . $e->getMessage();
        exit();
    }

    if (!$accessToken) {
        header("Location: ../../public/login.php");
        exit();
    }

    $oAuth2Client = $fb->getOAuth2Client();
    if (!$accessToken->isLongLived()) {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

        $response = $fb->get("/me?fields=id, first_name, last_name, email, birthday, location, picture.type(large)", $accessToken);
        $userData = $response->getGraphNode()->asArray();
        //echo "<pre>";
        //var_dump($userData);
        $_SESSION['userData'] = $userData;
        $_SESSION['access_token'] = (string) $accessToken;
        header("Location: ../../public/index.php");
        exit();
    }
