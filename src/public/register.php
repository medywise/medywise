<?php require_once("../initialize.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php require_once("includes/nav_unreg.php"); ?>
<?php $user = new User(); ?>
<?php if ($user->userLoggedIn()) {
    $user->redirect("index.php");
} ?>
	<div class="container text-center ">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
				<form role="form" method="post">
					<h2>Please Sign Up </h2>
					<hr class="colorgraph">
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
						<div class="col-xs-4 col-sm-3 col-md-3">
							<span class="button-checkbox">
								<div class="checkbox">
			  						<label><input type="checkbox" name="iagree" value="">I Agree</label>
								</div>
							</span>
						</div>
						<div class="col-xs-8 col-sm-9 col-md-9">
							 By clicking Register, you agree to the <a href="#" >Terms and Conditions</a> set out by Mediwise.
						</div>
					</div>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-12 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
						<div class="col-xs-12 col-md-6"><a href="login.php" class="btn btn-success btn-block btn-lg">Sign In</a></div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- container -->
<?php require_once("includes/footer.php"); ?>