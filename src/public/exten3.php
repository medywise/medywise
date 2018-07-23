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
				<input type="text" class="scrh" name="Crocin" placeholder="Crocin ">
			</div>
			<div class="box">	
				<div class="owl-carousel owl-theme">
				    <div class="item"><h4>Crocin <b>500</b></h4></div>
				    <div class="item"><h4><b>Feve</b> </h4></div>
				    <div class="item"><h4><b>Cough & Cold </b> </h4></div>
				    <div class="item"><h4>Crocin <b>supefast</b> </h4></div>
				</div>
			</div>
		</div>		
	</div><!-- container text-center -->
<?php require_once("includes/footer.php"); ?>