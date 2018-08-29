<?php
    require_once("../initialize.php");

    if (isset($_POST) && !empty($_POST)) {
        global $database;
        $med_id = $database->escape($_POST['id']);
        $q = "SELECT * FROM medicines WHERE id='$med_id'";

        $result = $database->query($q);
        if ($result->num_rows) {
                echo '<div class="grid-full">';
                 while($row = $result->fetch_object()){
                 	$name = $row->name;
                     echo '<div class="full-inner">
                                 <h1>'.$row->name.'</h1>
                                 <p>'.$row->description.'</p>
                             </div>';
                 }
             echo '<div class="new-btn">
                 <a href="#" class="btn btn-primary">Copy Text</a>
                 <a href="whatsapp://send?text='.$name.' – '.urlencode("http://dev-medical-web.pantheonsite.io/search?med=asd").'" data-action="share/whatsapp/share" class="btn btn-primary"> Share</a>
                </div></div>';
 

            // if($result->num_rows == 1){

    //        

    //         }else{
    //         	echo '<div class="grid-box">';
    //         	while($row = $result->fetch_object()){
    //         		echo '<div class="grid-inner">
    //         					<h1>'.$row->mname.'</h1>
    //         					<p>'.$row->mdesc.'</p>
    //         				</div>';
    //         	}
    //         	echo '<div class="new-btn">
				// 	<a href="#" class="btn btn-primary">Copy Text</a>
				// 	<a href="#" class="btn btn-primary share_to_fb"> Share</a>
				// </div></div>';
    //         }
            
        } else { //No Result
            echo "<h1>No Result Found! </h1>";
        }
    } else {
        header("Location: /index.php");
        die;
    }
