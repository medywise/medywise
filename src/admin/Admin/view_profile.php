<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'View Profile'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    $em = $_SESSION['admin_email'];
    $admin = new Admin();
    $adId = $admin->showAdminId($em);
    $admin = Admin::findAdminById($adId);
?>
<div id="wrapper">
    <!-- Navigation -->
    <?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
			<br>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="update.php?id=<?php echo $adId; ?>" class="btn btn-primary">Edit Profile</a>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                    	<form action="" method="post">
                    		<div class="col-lg-4">
                    			<div class="form-group">
	                                <label for="profile_pic">Profile Pic</label>
	                                <a class="thumbnail" href="#"><img src="<?php echo $admin->adminPicturePath(); ?>" alt=""></a>
	                            </div>
                    		</div>
                        	<div class="col-lg-8">
                        		<div class="form-group">
	                                <label for="first_name">First Name</label>
	                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $admin->first_name; ?>">
                            	</div>
                            	<div class="form-group">
	                                <label for="last_name">Last Name</label>
	                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $admin->last_name; ?>">
                            	</div>
                            	<div class="form-group">
	                                <label for="username">Username</label>
	                                <input type="text" id="username" name="username" class="form-control" value="<?php echo $admin->username; ?>">
                            	</div>
                            	<div class="form-group">
	                                <label for="email">Email</label>
	                                <input type="text" id="email" name="email" class="form-control" value="<?php echo $admin->email; ?>">
                            	</div>
                        	</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php includeAdminCommonFiles('footer.php'); ?>