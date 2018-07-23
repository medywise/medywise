<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_with_extra_css.php"); ?>
<?php require_once("includes/navigation.php"); ?>
<?php
    if (!$user->userLoggedIn()) {
        $user->redirect("index.php");
    }
?>
<div class="container text-center">
	<div class="top-header">
		<h1> Sample Headline Text</h1/>
		<span> we know important is to <b>get the right medicine</b> </span>
	</div>
	<div  class="search">					
		<div class="search-top">
			<form class="search_med_form" method="post">
				<input type="text" class="scrh" name="med" placeholder="Crocin ">
				<button type="submit" class="search_med btn btn-primary">Search</button>
			</form>
		</div>
		<div class="search_result"></div>
		<div class="icon-top" style="margin-bottom:10px; color:#000">  
			<b>Most Frequently asked </b>
		</div>
		<div class="box">	
			<ul>
				<li><div>Crocin <b>500</b></div></li>
				<li><div> <b>Feve</b> </div></li>
				<li><div> <b>Cough & Cold </b></div></li>
				<li><div>Crocin <b>supefast</b></div></li>
				<li><div> <b>Cough & Cold </b></div></li>
				<li><div>Crocin <b>supefast</b></div></li>
			</ul>
		</div>
	</div>		
</div><!-- container text-center -->
<?php require_once("includes/footer.php"); ?>