<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Update Company'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<!-- Modal Starts Here -->
<?php require_once('includes/company_photo_modal.php'); ?>
<!-- Modal Ends Here -->
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    } else {
        $company = Companies::findCompanyById($_GET['id']);
        
        $message = "";
        $name = "";
        $description = "";

        if ($company) {
            $company->updateCompany($name, $description);
            $session->message("The Company has been updated");
        }
    }

    // if (empty($_GET['id'])) {
    //     redirectTo("view.php");
    // } else {
    //     $company = Companies::findCompanyById($_GET['id']);
            
    //     // $message = "";
    //     // $name = "";
    //     // $description = "";

    //     if (isset($_POST['update'])) {
    //         $name = $_POST['name'];
    //         $description = $_POST['description'];

    //         if ($company) {
    //             $company->updateCompany($name, $description);
    //         }
    //     }
    // }
?>
<div id="wrapper">
    <!-- Navigation -->
    <?php includeAdminCommonFiles('topNavigation.php'); ?>
    <!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?>
    <!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Update Company: '<i><?php echo $company->name; ?></i>'</h3>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $company->name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $company->description; ?></textarea>
                            </div>
                            <div class="form-group admin_image_box">
                                <label for="company_image">Image</label>
                                <a class="thumbnailimg" href="#" data-toggle="modal" data-target="#company-photo-library"><img src="<?php echo $company->companyPicturePath(); ?>" alt=""></a>
                            </div>
                            <div class="info-box-footer clearfix">
                                <div class="pull-left">
                                    <a id="company-id" href="delete.php?id=<?php echo $company->id; ?>" type="button" name="delete" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" name="update" value="Update" class="btn btn-success btn-block"><i class="fa fa-edit"> Update</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>