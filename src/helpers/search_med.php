<?php
    require_once("../initialize.php");

    if (isset($_POST) && !empty($_POST)) {
        global $database;
        $med_name = $database->escape($_POST['s']);


	    if ($_POST['opselect'] == 'medicine') {
	        $q = "SELECT m.id as mid,m.name as mname,m.description as mdesc FROM medicines as m WHERE name LIKE '%" . $med_name . "%' OR tags LIKE '%" . $med_name . "%'";
	    } elseif ($_POST['opselect'] == 'company') {
	        $q = "SELECT id FROM company as c LEFT JOIN medicines as m ON m.company_id=c.id WHERE c.name LIKE '%" . $med_name . "%'";
	    } elseif ($_POST['opselect'] == 'category') {
	        $q = "SELECT m.id as mid,m.name as mname,m.description as mdesc FROM medicines as m LEFT JOIN categories as c ON m.category_id=c.id WHERE c.name LIKE '%" . $med_name . "%'";
	    } 
 
        $result = $database->query($q);
        $result_ = $result;
        
        if ($result->num_rows) {
            echo '<div class="box">   
                <div class="owl-carousel owl-theme">';
                while($row = $result->fetch_object()){
                    echo '<div id="'.$row->mid.'" class="search_result_item item"><h4>'.$row->mname.'</h4></div>';
                }
           echo'</div></div>';
           
            
        } else { //No Result
            echo "<h1>No Result Found! </h1>";
        }

         $result_ = $database->query($q);
         if($result_->num_rows == 1){

                echo '<div class="hidden show_later"><div class="grid-full">';
                    while($row_ = $result_->fetch_object()){
                        // print_r($row_);
                        echo '<div class="full-inner">
                                    <h1>'.$row_->mname.'</h1>
                                    <p>'.$row_->mdesc.'</p>
                                </div>';
                    }
                echo '<div class="new-btn">
                    <a href="#" class="btn btn-primary">Copy Text</a>
                 <a href="whatsapp://send?text='.$name.' – '.urlencode("http://dev-medical-web.pantheonsite.io/search?med=asd").'" data-action="share/whatsapp/share" class="btn btn-primary"> Share</a>
                </div></div></div>';

            }else{
                echo '<div class="hidden show_later"><div class="grid-box">';
                while($row_ = $result_->fetch_object()){
                    echo '<div id="'.$row_->mid.'" class="grid-inner">
                                <h1>'.$row_->mname.'</h1>
                                <p>'.$row_->mdesc.'</p>
                            </div>';
                }
                echo'</div></div>';
            }


    } else {
        header("Location: /index.php");
        die;
    }
