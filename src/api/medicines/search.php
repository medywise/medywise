<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['med_name']) && !empty($_POST['med_name'])) {
        global $database;

        $med_name = $database->escape($_POST['med_name']);
        $q = "SELECT id,name FROM medicines WHERE name = '".$med_name."'";
        $result = $database->query($q);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $response = array('status'=> 1, 'result'=> $row);
        } else {
            $response = array('status'=> 0, 'message'=> 'No Result Found');
        }
    } else {
        $response = array('status'=> 0, 'message'=> 'Medicine Name is required');
    }
} else {
    $response = array('status'=> 0, 'message'=> 'No route found');
}

echo json_encode($response);
die;
