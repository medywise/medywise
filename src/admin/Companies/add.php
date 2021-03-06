<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Add Company'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    //$message = "";
    $company = new Companies();

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        
        // if (empty($_FILES['file_upload'])) {
        //     $company->save();
        // } else {
        $company->addNewCompany($name, $description);
        // }
    }

    if (isset($_POST['sub'])) {
        $company->importCompaniesViaFile($_FILES['file']['tmp_name']);
    }
?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?>
    <?php includeAdminCommonFiles('sideNavigation.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <p class="bg-success"><?php echo $message; ?></p>
                <h3 class="page-header">Add New Company</h3>
            </div>
            <!-- Form Starts -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <p class="text-primary">
                        <form role="form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="name-text-content" name="name" class="form-control" onKeyup="name_remaining_character()">
                                <div id="name-character-count" align="right">50</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description-text-content" name="description" rows="5" onKeyup="description_remaining_character()"></textarea>
                                <div id="description-character-count" align="right">5000</div>
                            </div>
                            <div class="form-group">
                                <label>Company Image</label>
                                <input class="btn btn-outline btn-primary btn-xs" type="file" name="file_upload">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Add New Company</button>
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
                                <input class="btn btn-outline btn-primary btn-xs" type="file" name="file">
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