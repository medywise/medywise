<?php
	$pageTitle = "Search Medicine";
	$pageTitle2 = "Search Medicines on the go";
	$keywords = "Medywise, search, medicine";
	$description = "Best way to search medicines";
?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_with_extra_css.php"); ?>
<?php require_once("includes/navigation.php"); ?>
<?php $user = new User(); ?>
<?php
	if (!$user->userLoggedIn()) {
		$user->redirect("login?redirect_to=".$_SERVER['HTTP_X_PROTO'].$_SERVER['HTTP_HOST']."/search?med=".$_GET['med']."");
	}

	$user->checkSubscriptionStatus();
?>
<div class="container text-center">
	<div class="top-header">
		<h1>Medywise</h1/>
		<span> we know how important is to <b>get the right medicine</b> </span>
	</div>
	<div  class="search">					
		<div class="search-top">
			<form class="search_med_form" method="post">
				<!-- <select name='opselect' class='opselect'>
					<option value='medicine'>Medicine</option>
					<option value='company'>Company</option>
					<option value='category'>Category</option>
				</select> -->
				<input type="text" class="scrh" name="med" alt="Search Medicines" placeholder="Enter the medicine name">
				<input type="hidden" class="opselect" name="opselect" value="medicine">

				<!-- <button type="submit" class="search_med btn btn-primary">Search</button> -->
			</form>
		</div>
		<div class="fullsearch_result"></div>
		<div class="search_result"></div>


		<?php

	 		$q = "SELECT m.id as mid,m.name as mname,m.description as mdesc FROM medicines as m WHERE m.clicks >=3 ";
	 		$result = $database->query($q);
        	
        	if ($result->num_rows) {

				echo'<div class="mst_ask"><div class="icon-top" style="margin-bottom:10px; color:#000">  
						<b>Most Frequently asked </b>
					</div>
					<div class="box">	
					<ul>';

	            	while($row = $result->fetch_object()){
	            		// print_r($row);
						echo '<li  id="'.$row->mid.'" class="clr1 mst_asked frq_asked"><div><b>'.$row->mname.'</b></div></li>';
					}

					echo '</ul></div></div>';
			}
		?> 

	</div>		
</div><!-- container text-center -->
<?php require_once("includes/footer.php"); ?>