<?php
require_once "../initialize.php";
    $admin = new Admin();

   

    if ($admin->sendMailToNewAdmin()) {
        echo "Hi";
    }
