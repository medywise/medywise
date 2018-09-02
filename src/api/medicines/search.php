<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['med_name']) && !empty($_GET['med_name'])) {
        global $database;

        $med_name = $database->escape($_GET['med_name']);
        // $q = "SELECT id FROM company as c LEFT JOIN medicines as m ON m.company_id=c.id WHERE c.name LIKE '%" . $med_name . "%'";
        $q = "SELECT ratings,used_for,m.id as medicine_id,m.name as medicine_name,m.description as medicine_description,c.name as company_name FROM medicines as m LEFT JOIN company as c ON m.company_id=c.id WHERE m.name LIKE '%" . $med_name . "%' OR m.tags LIKE '%" . $med_name . "%'";
// echo $q;
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
