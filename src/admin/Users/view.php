<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'View Users'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php require_once('includes/view_users.php'); ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php includeAdminCommonFiles('topNavigation.php'); ?>
    <!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?>
    <!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
        <br>
            <!-- <div class="col-lg-12">
                <h1 class="page-header">View Users</h1>
            </div>  -->
            
            <!-- Table Starts -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Users
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Action</th>
                                        <th>Profile Pic</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <!-- <th>Password</th> -->
                                        <th>eMail</th>
                                        <th>Date of Birth</th>
                                        <th>Sex</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>Contact</th>
                                        <th>Register Date</th>
                                        <th>Subscription Status</th>
                                        <th>Last Login</th>
                                        <th>Number of Logins</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td>
                                                <div>
                                                    <a href="delete.php?id=<?php echo $user->id; ?>" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                                </div>
                                            </td>
                                            <td><img class="admin-photo-thumbnail company_image" src="<?php echo $user->userPicturePath(); ?>"></td>
                                            <td><?php echo $user->first_name; ?></td>
                                            <td><?php echo $user->last_name; ?></td>
                                            <td><?php echo $user->username; ?></td>
                                            <!-- <td><?php //echo $user->password;?></td> -->
                                            <td><?php echo $user->email; ?></td>
                                            <td><?php echo $user->date_of_birth; ?></td>
                                            <td><?php echo $user->sex; ?></td>
                                            <td><?php echo $user->address; ?></td>
                                            <td><?php echo $user->counrty; ?></td>
                                            <td><?php echo $user->contact; ?></td>
                                            <td><?php echo $user->register_date; ?></td>
                                            <td><?php echo $user->subscription_status; ?></td>
                                            <td><?php echo $user->last_login; ?></td>
                                            <td><?php echo $user->number_of_logins; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                        <?php require_once ADMIN_PATH . DS . 'includes' . DS . 'paginate_code.php'; ?>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>