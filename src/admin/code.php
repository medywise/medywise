<?php require_once("../initialize.php"); ?>
<?php require_once("includes/header_o.php"); ?>
<?php $admin = new Admin(); ?>
<div class="container text-center ">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
			<form role="form" method="post" autocomplete="off">
				<h2>Enter Code </h2>
				<hr class="colorgraph">
				<?php
                    $admin->displayMessage();
                    $admin->codeValidation();
                ?>
				<div class="form-group">
					<input type="text" name="code" id="code" tabindex="4" class="form-control input-lg" placeholder="######" autocomplete="off" required>
				</div>

				<hr class="colorgraph">

				<div class="row">
					<div class="col-xs-12">
						<input type="submit" name="code-submit" value="Continue" class="btn btn-success btn-block btn-lg" tabindex="7">
					</div>
				</div>
				<input type="hidden" class="hide" name="token" id="token" value="">
			</form>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer_o.php"); ?>