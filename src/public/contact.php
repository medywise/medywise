<?php
    $pageTitle = "Contact";
    $pageTitle2 = "Connect with Medywise";
    $keywords = "Medywise, contact";
    $description = "Best way to search medicines";
?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_with_extra_css.php"); ?>
<?php require_once("includes/navigation.php"); ?>
<div class="container text-center">
	<div class="top-header">
		<h1>Contact Us</h1/>
	</div>
	<?php
        $user->displayMessage();
        $user->contactUs();
    ?>
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-signn">
			<p>If you have any suggestion or even you want to say Hello..</p>
			<form role="form" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Name" tabindex="1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="mobile_nmbr" id="mobile_nmbr" class="form-control input-lg" placeholder="Mobile No." tabindex="2">
						</div>
					</div>
				</div>

				<div class="form-group">
					<input type="email" name="email" id="emaill" class="form-control input-lg" placeholder="Email" tabindex="2">
				</div>

				<div class="form-group txtara_contact">
					<textarea name="message" rows="7" id="contact-msg" cols="30" class="form-control input-lg" placeholder="Message" tabindex="3"></textarea>
				</div>

				<div class="col-xs-12 col-md-12"><input type="submit" name="submit" id="sub_btn" class="btn btn-primary btn-block btn-lg" value="Send Message" tabindex="4"></div>
			</form>
		</div>
	</div>
</div><!-- container text-center -->
<?php require_once("includes/footer.php"); ?>