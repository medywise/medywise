<?php 
    require_once("../initialize.php");
    if (isset($_SESSION['admin_email'])) {
        header("Location: /src/admin/includes/index.php");
    } else {
        header("Location: /src/admin/login.php");
    }

    die();
