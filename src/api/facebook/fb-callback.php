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
        header("Location: /login");
        exit();
    }

    $oAuth2Client = $fb->getOAuth2Client();
  
    $response = $fb->get("/me?fields=id, gender,first_name, last_name, email, birthday, location, picture.type(large)", $accessToken);
    $userData = $response->getGraphNode()->asArray();
 
    $obj = new User();
    $result = $obj->registerUserFB($userData['first_name'], $userData['last_name'],$userData['first_name'].'_'.$userData['id'], $userData['email'],$userData['email'].'_'.$userData['id']);

    if($result == 'exists'){
        $_SESSION['email'] = $userData['email'];
        $_SESSION['givenName'] = $userData['first_name'].'_'.$userData['id'];
    }

    header("Location: /login");
    exit();