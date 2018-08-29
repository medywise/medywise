<?php require_once('../../initialize.php'); ?>
<?php
    $admin = new Admin();

    if (isset($_POST['admin_image_name'])) {
        $admin->ajaxUpdateAdminImage($_POST['admin_image_name'], $_POST['admin_id']);
    }
?>