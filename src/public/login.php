<?php require_once("../initialize.php"); ?>
<?php require_once SITE_ROOT . DS . 'api' . DS . 'google' . DS . 'google_config.php'; ?>
<?php require_once SITE_ROOT . DS . 'api' . DS . 'facebook' . DS . 'facebook_config.php'; ?>
<?php $loginGoogleURL = $gClient->createAuthUrl(); ?>
<?php
    $redirectURL = "http://localhost/medicine/src/api/facebook/fb-callback.php";
    $permissions = ['email', 'user_birthday', 'user_hometown', 'user_location', 'user_gender', 'user_photos'];
    $loginFacebookURL = $helper->getLoginUrl($redirectURL, $permissions);
    //echo $loginFacebookURL;
?>
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
			<form method="post" role="form">
				<h2>Please Login</h2>

				<hr class="colorgraph">

				<?php

                    $user->displayMessage();
                    $user->validateUserLogin();
                    if (isset($_SESSION['email'])) {
                        user_log_action('Login', "{$_SESSION['email']} logged in.");
                    }
                ?>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
				</div>
	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<span class="button-checkbox">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" value="">Remember Me
								</label>
							</div>
						</span>
					</div>
				</div>

				<hr class="colorgraph">

				<div class="row">
					<div class="col-xs-12 col-md-12">
						<input type="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="7">
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<a href="recover.php" tabindex="5" class="forgot-password">Forgot Password?</a>
								New User, <a href="register.php" tabindex="5" class="forgot-password">Register Here</a>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="row">
				<button class="loginBtn loginBtn--facebook" onclick="window.location = '<?php echo $loginFacebookURL; ?>'">
					Login with Facebook
				</button>

				<button class="loginBtn loginBtn--google" onclick="window.location = '<?php echo $loginGoogleURL; ?>'">
					Login with Google
				</button>
			</div>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer.php"); ?>