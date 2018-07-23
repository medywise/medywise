<?php 
    require_once("../initialize.php");
    if (isset($_SESSION['admin_email'])) {
        header("Location: /src/admin/includes/index.php");
    } else {
        header("Location: /src/admin/login.php");
    }

    die();
?>

<!-- <!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0;url=includes/index.php">
<title>Mediwise</title>
</head>
<body>
Go to <a href="includes/index.php">/includes/index.php</a>
</body>
</html> -->
