<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php require_once("includes/navigation.php"); ?>
<?php
    if (!$user->userLoggedIn()) {
        $user->redirect("index");
    }
?>
	<div class="container text-center">
		<div class="top-header">
			<h1>Sample Headline Text</h1>
		</div>
		<div  class="search">
			<div class="search-top">			
				<input type="text" class="scrh" name="Crocin" placeholder="Crocin 500 ">
		</div>
		<div class="icon-top">  
			25 Results: <span class="glyphicon glyphicon-filter"></span>
		</div>
		<div class="grid-box-2">				
					<div class="grid-inner-2">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
						<p> Crocin 500 MG Tablet is used to relieve acute</p>
					</div>
					<div class="grid-inner-2">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
					</div>
					<div class="grid-inner-2">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
					</div>
					<div class="grid-inner-2">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
					</div>
				</div>
			<div class="grid-box-right "></div>
		</div>
	</div><!-- container -->
<?php require_once("includes/footer.php"); ?>