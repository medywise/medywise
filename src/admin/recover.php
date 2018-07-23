<?php 
    require_once("../initialize.php");
    require_once("includes/header_o.php");

    if (isset($_SESSION['admin_email'])) {
        header("Location: /src/admin/includes/index.php");
        die;
    }
    $admin = new Admin();
?>
<div class="container text-center ">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
			<form role="form" method="post" autocomplete="off">
				<h2>Recover Password </h2>
				<hr class="colorgraph">
				<?php
                    $admin->displayMessage();
                    $admin->recoverAdminPassword();
                ?>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="4">
				</div>

				<hr class="colorgraph">

				<div class="row">
					<div class="col-xs-12 col-md-6">
						<input type="submit" name="cancel_submit" value="Cancel" class="btn btn-danger btn-block btn-lg" tabindex="7">
					</div>
					<div class="col-xs-12 col-md-6">
						<input type="submit" name="recover-submit" value="Send Password Reset Link" class="btn btn-success btn-block btn-lg" tabindex="7">
					</div>
				</div>
				<input type="hidden" class="hide" name="token" id="token" value="<?php echo $admin->tokenGenerator(); ?>">
			</form>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer_o.php"); ?>