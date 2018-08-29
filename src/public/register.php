<?php
	$pageTitle = "Register";
	$pageTitle2 = "Register here to access Medywise";
	$keywords = "Medywise, register";
	$description = "Best way to search medicines";
?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php require_once("includes/nav_unreg.php"); ?>
<?php $user = new User(); ?>
<?php if ($user->userLoggedIn()) {
    $user->redirect("index");
} ?>
	<div class="container text-center ">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
				<form role="form" method="post">
					<h2>Medywise - Sign Up </h2>
					<?php
                        $user->displayMessage();
                        $user->validateUserRegistration();
                    ?>
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
		                        <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
							</div>
						</div>
					</div>

					<div class="form-group">
						<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" tabindex="3">
					</div>

					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="4">
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
		                        <input type="text" name="counrty" id="counrty" class="form-control input-lg" placeholder="Country" tabindex="1">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="text" name="contact" id="contact" class="form-control input-lg" placeholder="Phone Number" tabindex="2">
							</div>
						</div>
					</div>

					<div class="form-group">
						<input type="text" name="address" id="address" class="form-control input-lg" placeholder="Address" tabindex="4">
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="confirm_password" id="confirm_password" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
							</div>
						</div>
					</div>

					<div class="row">
						<label for="sex">Gender</label>
						<input type="radio" name="sex" value="Male" /> Male
						<input type="radio" name="sex" value="Female" /> Female 
						<input type="radio" name="sex" value="Other" /> Other
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<span class="button-checkbox">
								<div class="checkbox">
			  						<label><input type="checkbox" name="iagree" value="">I Agree</label> to the <a href="#" >Terms and Conditions</a> set out by Medywise.
								</div>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6"><a href="login" class="btn btn-success btn-block btn-lg">Sign In</a></div>
						<div class="col-xs-12 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- container -->
<?php require_once("includes/footer.php"); ?>