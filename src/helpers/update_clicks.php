<?php 

require_once("../initialize.php");

global $database;

$med_id = $database->escape($_POST['id']);
$q = "UPDATE medicines SET clicks = clicks + 1 WHERE id = '".$med_id."'";

$result = $database->query($q);