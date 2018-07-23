<?php require_once("../initialize.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_with_extra_css.php"); ?>
<?php //require_once("includes/navigation.php");?>
<div class="container text-center">
	<div class="top-header">
		<h1>Sample Headline Text</h1/>
		<span> we know important is to <b>get the right medicine</b></span>
		<?php
            $user = new User();
            $user->displayMessage();
        ?>
	</div>
	<div class="video">
	<h2>Video/Gif Section </h2>
		<section id="demos">
			<div class="row">
				<div class="large-12 columns">
					<div class="owl-carousel owl-theme">
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://vimeo.com/23924346"></a> 
						</div>
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://www.youtube.com/watch?v=JpxsRwnRwCQ"></a> 
						</div>
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://www.youtube.com/watch?v=FBu_jxT1PkA"></a> 
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<button class="add">Add Extension</button>
	<div class="or">or </div>
		<?php
            if ($user->userLoggedIn()) {
                echo '<a href="search.php">';
            } else {
                echo '<a href="login.php">';
            }
        ?>
		<h3 class="wrk">Work Online </h3></a>
		<p>“User Comments or reviews will be viewed here user Comments or reviews will be viewed here”</p>
	</div>
<?php require_once("includes/footer.php"); ?>