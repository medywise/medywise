<?php

require_once("../initialize.php");

if(isset($_POST) && !empty($_POST)){

    global $database;
	$med_name = $database->escape($_POST['med']);
	$q = "SELECT * FROM medicines WHERE name LIKE '%".$med_name."%' OR tags LIKE '%".$med_name."%'";

	$result = $database->query($q);
	if($result->num_rows){

		if($result->num_rows == 1){

			echo '<div class="grid-full">';
				while($row = $result->fetch_object()){
					echo '<div class="full-inner">
								<h1>'.$row->name.'</h1>
								<p>'.$row->description.'</p>
							</div>';
				}
			echo '</div>';

		}else{
			echo '<div class="grid-box">';
			while($row = $result->fetch_object()){
				echo '<div class="grid-inner">
							<h1>'.$row->name.'</h1>
							<p>'.$row->description.'</p>
						</div>';
			}
			echo '</div>';
		}		
	}else{ //No Result
		echo "<h1>No Result Found! </h1>";
	}

}else{
    header("Location: /index.php");
    die;
}