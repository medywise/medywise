<?php
	require_once("../initialize.php");

	if(isset($_POST) && !empty($_POST)){

		global $database;
		$id = $_POST['id'];
		$q = "SELECT * FROM medicines WHERE id='".$id."'";

		$result = $database->query($q);
		while($row = $result->fetch_object()){				
			$ar['name'] = $row->name;
			$ar['desc'] = $row->description;
		}

		echo json_encode($ar);
		die;
	}else{
		header("Location: /index.php");
		die;
	}