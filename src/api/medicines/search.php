<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['med_name']) && !empty($_GET['med_name'])) {
        global $database;

        $med_name = $database->escape($_GET['med_name']);
        $q = "SELECT id,name,type FROM medicines WHERE type LIKE '%".$med_name."%'";
        $result = $database->query($q);

        if ($result->num_rows) {
            while($r = mysqli_fetch_object($result)){
                $row[] = $r;
            }
            
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
