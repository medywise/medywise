<?php 

require_once("../../initialize.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['med_id']) && !empty($_GET['med_id'])) {
        global $database;

        $med_id = $database->escape($_GET['med_id']);
        $q = "SELECT m.name,m.description,m.ratings,m.clicks,m.company_id,m.cat_id,m.price,m.type,m.used_for,m.also_called,m.available_as,m.how_to_store,m.how_to_take,m.side_effects,m.when_to_take,c.name as company_name FROM medicines as m LEFT JOIN company as c on m.company_id = c.id WHERE m.id = '".$med_id."'";
 
        $result = $database->query($q);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $cat = explode(',', $row['cat_id']);
            $name_str = '';

            foreach ($cat as $key => $value) {
                $q_ = "SELECT name FROM categories WHERE id = '".$value."'";
                $cat = $database->query($q_);
                $name = $cat->fetch_assoc();
                $name_arr[] = $name['name'];
            }

            $name_str = implode(',', $name_arr);
            $row['category'] = $name_str;
            unset($row['cat_id']);

            $response = array('status'=> 1, 'result'=> $row);
        } else {
            $response = array('status'=> 0, 'message'=> 'No Result Found');
        }
    } else {
        $response = array('status'=> 0, 'message'=> 'Bad Request');
    }
} else {
    $response = array('status'=> 0, 'message'=> 'No route found');
}

echo json_encode($response);
die;
