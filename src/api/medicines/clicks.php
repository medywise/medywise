<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['med_id']) && !empty($_POST['med_id'])) {
        global $database;

        $med_id = $database->escape($_POST['med_id']);
        $q = "UPDATE medicines SET clicks = clicks + 1 WHERE id = '".$med_id."'";
 
        $result = $database->query($q);
        $response = array('status'=> 1, 'message'=> 'Updated');
    } else {
        $response = array('status'=> 0, 'message'=> 'Bad Request');
    }
} else {
    $response = array('status'=> 0, 'message'=> 'No route found');
}

echo json_encode($response);
die;
