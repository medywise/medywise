<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Add Category'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    $message = "";
    $category = new Categories();

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $category->addNewCategory($name, $description);
    }

    if (isset($_POST['sub'])) {
        $category->importCategoriesViaFile($_FILES['file']['tmp_name']);
    }
?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?>
    <?php includeAdminCommonFiles('sideNavigation.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Add New Category</h3>
            </div>
            <!-- Form Starts -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <p class="text-primary"><?php echo $message; ?></p>
                        <form role="form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input id="name-text-content" type="text" name="name" class="form-control" onKeyup="name_remaining_character()">
                                <div id="name-character-count" align="right">50</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="description-text-content" class="form-control" name="description" rows="3" class="form-control" onKeyup="description_remaining_character()"></textarea>
                                <div id="description-character-count" align="right">5000</div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Add New Category</button>
                        </form>
                    </div>
                </div><!-- Form Ends -->
                <br><hr>
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <form action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" class="btn btn-outline btn-primary btn-xs" name="file">
                            </div>
                            <button type="submit" name="sub" class="btn btn-primary btn-lg btn-block">Import via File</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>