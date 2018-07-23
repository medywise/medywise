<?php require_once("../initialize.php"); ?>
<?php require_once("../public/includes/header.php"); ?>
<?php $admin = new Admin(); ?>
<div class="container text-center ">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
            <form method="post" role="form">
                <h2>Admin (Mediwise) - Please Login</h2>
                <hr class="colorgraph">
                <?php
                    $admin->displayMessage();
                    $admin->validateAdminLogin();
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- container -->
<?php require_once("../public/includes/footer.php"); ?>