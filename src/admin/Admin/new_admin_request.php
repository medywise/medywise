<?php require_once("../../initialize.php"); ?>
<?php require_once("../includes/header_o.php"); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php $admin = new Admin(); ?>
<div class="container text-center ">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
			<form role="form" method="post">
				<h2>Please Enter Email Address </h2>
				<hr class="colorgraph">
				<?php
                    $admin->displayMessage();
                    $admin->validateNewAdminRequest();
                ?>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="4">
				</div>

				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-md-6"><a href="view.php" class="btn btn-primary btn-block btn-lg">Go Back</a></div>
					<div class="col-xs-12 col-md-6"><input type="submit" name="submit" value="Send Join Request" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
				</div>
			</form>
		</div>
	</div>
</div><!-- container -->
<?php require_once("../includes/footer_o.php"); ?>