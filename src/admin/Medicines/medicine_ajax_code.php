<?php require_once('../../initialize.php'); ?>
<?php
    $medicine = new Medicines();
    
    if (isset($_POST['medicine_image_name'])) {
        $medicine->ajaxUpdateMedicineImage($_POST['medicine_image_name'], $_POST['medicine_id']);
    }
?>