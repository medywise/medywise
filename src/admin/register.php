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
			<form role="form" method="post">
				<h2>Please Sign Up </h2>
				<hr class="colorgraph">
				<?php
                    $admin->displayMessage();
                    $admin->validateRegisterAdminByMail();
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

				<!-- <div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="4">
				</div> -->

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
						 By clicking Register, you agree to the <a href="includes/terms_and_conditions.html" >Terms and Conditions</a> set out by Mediwise.
					</div>
				</div>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
					<div class="col-xs-12 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Sign In</a></div>
				</div>
			</form>
		</div>
	</div>
</div><!-- container -->
<?php require_once("includes/footer_o.php"); ?>