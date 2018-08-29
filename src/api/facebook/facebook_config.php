<?php
    require_once MAIN_ROOT . DS . 'vendor' . DS . 'autoload.php';

    //session_start();
    $fb = new \Facebook\Facebook([
        'app_id' => Config::API_FACEBOOK_APP_ID,
        'app_secret' => Config::API_FACEBOOK_APP_SECRET,
        'default_graph_version' => 'v2.10',
        //'default_access_token' => '{access-token}', // optional
    ]);

    $helper = $fb->getRedirectLoginHelper();

