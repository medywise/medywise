<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'View Admins'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php $admin = new Admin(); ?>
<?php require_once('includes/view_admin.php'); ?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
        <br>
            <div class="col-lg-12">
                <?php $admin->displayMessage(); ?>
            </div>
            
            <!-- Table Starts -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="new_admin_request.php" class="btn btn-primary">Add New Admin</a>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Profile Pic</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>eMail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($admins as $admin) : ?>
                                    <tr>
                                        <td><img class="admin-photo-thumbnail company_image" src="<?php echo $admin->adminPicturePath(); ?>"></td>
                                        <td><?php echo $admin->username; ?></td>
                                        <td><?php echo $admin->first_name; ?></td>
                                        <td><?php echo $admin->last_name; ?></td>
                                        <td><?php echo $admin->email; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php //require_once ADMIN_PATH . DS . 'includes' . DS . 'paginate_code.php';?>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>