<?php
if (!session_id()) {
    session_start();
}
print_r($_SESSION);
	$pageTitle = "Login";
	$pageTitle2 = "Login here to access Medywise";
	$keywords = "Medywise, login";
	$description = "Best way to search medicines";
?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php require_once("includes/nav_unreg.php"); ?>

<?php require_once SITE_ROOT . DS . 'api' . DS . 'google' . DS . 'google_config.php'; ?>
<?php require_once SITE_ROOT . DS . 'api' . DS . 'facebook' . DS . 'facebook_config.php'; ?>
<?php $loginGoogleURL = $gClient->createAuthUrl(); ?>
<?php
    $redirectURL = "https://dev-medical-web.pantheonsite.io/src/api/facebook/fb-callback.php";
    $permissions = ['email', 'user_birthday', 'user_hometown', 'user_location', 'user_gender', 'user_photos'];
    $loginFacebookURL = $helper->getLoginUrl($redirectURL, $permissions);
    //echo $loginFacebookURL;
?>


<?php $user = new User(); ?>


<?php if ($user->userLoggedIn()) {
    $user->redirect("index");
} ?>
<div class="container text-center ">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4 foam-sign">
			<div class="row">
				<h2>Medywise - Sign In </h2>
				<button class="loginBtn loginBtn--facebook" onclick="window.location = '<?php echo $loginFacebookURL; ?>'">
					Login with Facebook
				</button>
				<br>
				<button class="loginBtn loginBtn--google" onclick="window.location = '<?php echo $loginGoogleURL; ?>'">
					Login with Google
				</button>
			</div>
			<br>
			<b>OR</b>
			<br>
			<form method="post" role="form">
				<?php
                    $user->displayMessage();
                    $user->validateUserLogin();
                    
                    if (isset($_SESSION['email'])) {
                        user_log_action('Login', "{$_SESSION['email']} logged in.");
                    }
				?>
				
				<div class="form-group wid">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="1">
				</div>

				<div class="form-group wid">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="2">
				</div>
	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<span class="button-checkbox">
							<div class="checkbox">
								<label>
									<input class="ckbx" type="checkbox" name="remember" value="">Remember Me
								</label>
							</div>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<input type="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="3">
					</div>
				</div>
				<br>
			</form>
			
			<div class="form-group">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-center">
							<a href="recover" tabindex="5" class="forgot-password">Forgot Password?</a>
							New User, <a href="register" tabindex="5" class="forgot-password">Register Here</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer.php"); ?>