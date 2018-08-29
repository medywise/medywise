<?php require_once('../../initialize.php'); ?>
<?php
    $company = new Companies();
    
    if (isset($_POST['company_image_name'])) {
        $company->ajaxUpdateCompanyImage($_POST['company_image_name'], $_POST['company_id']);
    }
?>