<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'View Categories'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php require_once('includes/view_categories.php'); ?>
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
                <h1 class="page-header">Categories</h1>
            </div>  -->
            <!-- Table Starts -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Categories
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Action</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category) : ?>
                                        <tr>
                                            <td><?php echo $category->id; ?></td>
                                            <td>
                                                <div class="span2">
                                                    <a href="update.php?id=<?php echo $category->id; ?>" class="btn btn-success btn-block"><i class="fa fa-edit"> Update</i></a>
                                                    <a href="delete.php?id=<?php echo $category->id; ?>" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                                </div>
                                            </td>
                                            <td><?php echo $category->name; ?></td>
                                            <td><?php echo $category->description; ?></td>
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