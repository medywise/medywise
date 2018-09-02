<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        global $database;

        $q = "SELECT m.id as medicine_id,m.name as medicine_name,m.description as medicine_description,c.name as company_name FROM medicines as m LEFT JOIN company as c ON m.company_id=c.id WHERE m.clicks >=3 ";

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
    $response = array('status'=> 0, 'message'=> 'No route found');
}

echo json_encode($response);
die;