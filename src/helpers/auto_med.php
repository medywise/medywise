<?php

require_once("../initialize.php");

if (isset($_POST) && !empty($_POST)) {
    global $database;
    $med_name = $database->escape($_POST['med']);

    if ($_POST['opselect'] == 'medicine') {
        $q = "SELECT * FROM medicines WHERE name LIKE '%" . $med_name . "%' OR tags LIKE '%" . $med_name . "%'";
    } elseif ($_POST['opselect'] == 'company') {
        $q = "SELECT * FROM company WHERE name LIKE '%" . $med_name . "%'";
    } elseif ($_POST['opselect'] == 'category') {
        $q = "SELECT * FROM categories WHERE name LIKE '%" . $med_name . "%'";
    }


    $result = $database->query($q);
    if ($result->num_rows) {
        while ($row = $result->fetch_object()) {
            $arr[] = $row->name;
        }
    } else { //No Result
        $arr = array();
    }

    echo json_encode($arr);
} else {
    header("Location: /index.php");
    die;
}
