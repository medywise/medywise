<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Dashboard'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div><!-- /.col-lg-12 -->
            <?php includeAdminCommonFiles('snippets.php'); ?>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>