<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Update Admin'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<!-- Modal Starts Here -->
<?php require_once('includes/admin_photo_modal.php'); ?>
<!-- Modal Ends Here -->
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    } else {
        $admin = Admin::findAdminById($_GET['id']);

        $message = "";
        $username = "";
        $pwd = "";
        $first_name = "";
        $last_name = "";
        $email = "";

        if ($admin) {
            $admin->updateAdmin($username, $pwd, $first_name, $last_name, $email);
        }
    }
?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Update Your Profile, <b><?php echo $admin->username; ?></b></h3>
            </div><!-- /.col-lg-12 -->
            <div class="panel-body">
                <div class="row">
                    <p class="text-primary"><?php echo $message; ?></p>
                    <form action="" method="post">                            
                        
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" id="username-text-content" name="username" class="form-control" onKeyup="username_remaining_character()" value="<?php echo $admin->username; ?>">
                                <div id="username-character-count" align="right">50</div>
                            </div>

                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="text" id="password-text-content" name="password" class="form-control" onKeyup="password_remaining_character()" value="<?php echo $admin->password; ?>">
                                <div id="password-character-count" align="right">50</div>
                            </div>

                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" id="first-name-text-content" name="first_name" class="form-control" onKeyup="first_name_remaining_character()" value="<?php echo $admin->first_name; ?>">
                                <div id="first-name-character-count" align="right">50</div>
                            </div>

                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" id="last-name-text-content" name="last_name" class="form-control" onKeyup="last_name_remaining_character()" value="<?php echo $admin->last_name; ?>">
                                <div id="last-name-character-count" align="right">50</div>
                            </div>

                            <div class="form-group">
                                <label for="name">eMail</label>
                                <input type="text" id="email-text-content" name="email" class="form-control" onKeyup="email_remaining_character()" value="<?php echo $admin->email; ?>">
                                <div id="email-character-count" align="right">50</div>
                            </div>
                        </div>

                        <div class="col-lg-4">                                    
                            <div class="form-group admin_image_box">
                                <label for="company_image">Profile Pic</label>
                                <a class="thumbnailimg" href="#" data-toggle="modal" data-target="#admin-photo-library"><img src="<?php echo $admin->adminPicturePath(); ?>" alt=""></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="info-box-footer clearfix">
                                    <div class="pull-left">
                                        <a id="admin-id" href="delete.php?id=<?php echo $admin->id; ?>" type="button" name="delete" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete Profile</i></a>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" name="update" class="btn btn-success btn-block"><i class="fa fa-edit"> Update Profile</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form><!-- form -->
                </div><!-- row -->
            </div><!-- panel-body -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>