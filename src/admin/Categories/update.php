<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Update Category'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    } else {
        $category = Categories::findCategoryById($_GET['id']);
        
        $message = "";
        $name = "";
        $description = "";

        if ($category) {
            $category->updateCategory($name, $description);
        }
    }
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
                <h3 class="page-header">Update Category: '<i><?php echo $category->name; ?></i>'</h3>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name-text-content" class="form-control" value="<?php echo $category->name; ?>"  onKeyup="name_remaining_character()">
                                <div id="name-character-count" align="right">50</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description-text-content" cols="30" rows="10" onKeyup="description_remaining_character()"><?php echo $category->description; ?></textarea>
                                <div id="description-character-count" align="right">5000</div>
                            </div>
                            <div class="info-box-footer clearfix">
                                <div class="pull-left">
                                    <a href="delete.php?id=<?php echo $category->id; ?>" type="button" name="delete" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" name="update" class="btn btn-success btn-block"><i class="fa fa-edit"> Update</i></button>
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