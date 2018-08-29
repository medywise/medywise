<?php
    require_once MAIN_ROOT . DS . 'vendor' . DS . 'autoload.php';

    $gClient = new Google_Client();

    $gClient->setClientId(Config::API_GOOGLE_CLIENT_ID);
    $gClient->setClientSecret(Config::API_GOOGLE_CLIENT_SECRET);
    $gClient->setApplicationName(Config::API_GOOGLE_APP_NAME);
    $gClient->setRedirectUri(Config::API_GOOGLE_REDIRECT_URI);
    $gClient->addScope(Config::API_GOOGLE_SCOPE);
