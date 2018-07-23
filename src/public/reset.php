<?php require_once("../initialize.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_without_extra_css.php"); ?>
<?php $user = new User(); ?>
<div class="container text-center ">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
			<form role="form" method="post" autocomplete="off">
				<h2>Reset Password </h2>
				<hr class="colorgraph">
				<?php
                    $user->displayMessage();
                    $user->passwordReset();
                ?>
				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="4" required>
				</div>

				<div class="form-group">
					<input type="password" name="confirm_password" id="confirm-password" class="form-control input-lg" placeholder="Confirm Password" tabindex="4" required>
				</div>

				<hr class="colorgraph">

				<div class="row">
					<div class="col-xs-12">
						<input type="submit" name="reset-password-submit" id="reset-password-submit" value="Reset Password" class="btn btn-success btn-block btn-lg" tabindex="7">
					</div>
				</div>
				<input type="hidden" class="hide" name="token" id="token" value="<?php echo $user->tokenGenerator(); ?>">
			</form>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer.php"); ?>