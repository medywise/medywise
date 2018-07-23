<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'View Medicines'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php require_once('includes/view_medicine.php'); ?>
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
                <h1 class="page-header">View Medicines</h1>
            </div>  -->
            
            <!-- Table Starts -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Medicines
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Action</th>
                                        <th>Medicine Picture</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>Description</th>
                                        <th>Ratings</th>
                                        <th>Clicks</th>
                                        <th>Company</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Tags</th>
                                        <th>Type</th>
                                        <th>Used For</th>
                                        <th>Also Called</th>
                                        <th>Available As</th>
                                        <th>How to Store</th>
                                        <th>How to Take</th>
                                        <th>Side Effects</th>
                                        <th>When to Take</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($medicines as $medicine) : ?>
                                    <tr>
                                        <td><?php echo $medicine->id; ?></td>
                                        <td>
                                            <div>
                                            <a href="update.php?id=<?php echo $medicine->id; ?>"  class="btn btn-success btn-block"><i class="fa fa-edit"> Update</i></a>
                                            <a href="delete.php?id=<?php echo $medicine->id; ?>" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                            </div>
                                        </td>
                                        <td><img class="admin-photo-thumbnail company_image" src="<?php echo $medicine->medicinePicturePath(); ?>"></td>
                                        <td><?php echo $medicine->name; ?></td>
                                        <td><?php echo $medicine->short_name; ?></td>
                                        <td><?php echo $medicine->description; ?></td>
                                        <td><?php echo $medicine->ratings; ?></td>
                                        <td><?php echo $medicine->clicks; ?></td>
                                        <td><?php echo $medicine->company_id; ?></td>
                                        <td><?php echo $medicine->category_id; ?></td>
                                        <td><?php echo $medicine->price; ?></td>
                                        <td><?php echo $medicine->tags; ?></td>
                                        <td><?php echo $medicine->type; ?></td>
                                        <td><?php echo $medicine->used_for; ?></td>
                                        <td><?php echo $medicine->also_called; ?></td>
                                        <td><?php echo $medicine->available_as; ?></td>
                                        <td><?php echo $medicine->how_to_store; ?></td>
                                        <td><?php echo $medicine->how_to_take; ?></td>    
                                        <td><?php echo $medicine->side_effects; ?></td>
                                        <td><?php echo $medicine->when_to_take; ?></td>
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