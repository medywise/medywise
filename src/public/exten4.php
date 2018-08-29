<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php require_once("includes/navigation.php"); ?>
<?php $user = new User(); ?>
<?php
    if (!$user->userLoggedIn()) {
        $user->redirect("index");
    }
?>
		<div class="container text-center">
			<div class="top-header">
				<h1>Sample Headline Text</h1/>
			</div>
			<div  class="search">				
				<div class="search-top">
					<input type="text" class="scrh" name="Crocin" placeholder="Crocin ">
				</div>	

				<div class="in">  
					25 Results: <button type="button" id="formButton">cxcv</button>
				</div>
				<!-- <div class="icon-top">  
					25 Results: <button type="button" class="glyphicon glyphicon-filter"  id="formButton">cxcv</button>
				</div> -->

				<div id="divShowHide" >
					<div class="checkbox">
						<label><input type="checkbox" value="">Option 1</label>
						</div>
						<div class="checkbox">
						<label><input type="checkbox" value="">Option 2</label>
						</div>
						<div class="checkbox">
						<label><input type="checkbox" value="">Option 3</label>
					</div>

					<div class="radio">
					<label><input type="radio" name="optradio" checked>Option 1</label>
					</div>
					<div class="radio">
					<label><input type="radio" name="optradio">Option 2</label>
					</div>
					<div class="radio">
					<label><input type="radio" name="optradio">Option 3</label>
					</div>
				</div>

				<div class="grid-box">		
					<div class="grid-inner">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from  fever without treating the underlying cause.</p>
						<h1> Headache</h1>
						<p> Crocin 500 MG Tablet is used to relieve acute headaches including migraine. Crocin 500 MG Tablet is used to relieve acute headaches including migraine.</p>
					</div>

					<div class="grid-inner">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
						<p> Crocin 500 MG Tablet is used to relieve acute headaches including migraine. Crocin 500 MG Tablet is used to relieve acute headaches including migraine.</p>
					</div>
				
					<div class="grid-inner">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
						<p> Crocin 500 MG Tablet is used to relieve acute headaches including migraine. Crocin 500 MG Tablet is used to relieve acute headaches including migraine.</p>
					</div>
					
					<div class="grid-inner">
						<h1> Crocin 500</h1>
						<p>used to provide temporary relief from fever without treating the underlying cause.</p>
						<h1> Headache</h1>
						<p> Crocin 500 MG Tablet is used to relieve acute headaches including migraine. Crocin 500 MG Tablet is used to relieve acute headaches including migraine.</p>
					</div>
				</div>
			</div>
		</div><!-- container -->


<style>#divShowHide{display:none;}</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("#formButton").click(function(){
			$("#divShowHide").toggle();
		});
	})
	$("body").on("click", "#btnShowHide", function() {
		$("#divShowHide").toggle();	
	})
</script>
<?php require_once("includes/footer.php"); ?>