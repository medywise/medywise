<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Update Category'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<!-- Modal Starts Here -->
<?php require_once('includes/medicine_photo_modal.php'); ?>
<!-- Modal Ends Here -->
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    if (empty($_GET['id'])) {
        redirectTo("view.php");
    } else {
        $medicine = Medicines::findMedicineById($_GET['id']);

        $message = "";
        $name = "";
        $short_name = "";
        $description = "";
        $ratings = "";
        $company_id = "";
        $category_id = "";
        $price = "";
        $tags = "";
        $type = "";
        $used_for = "";
        $also_called = "";
        $available_as = "";
        $how_to_store = "";
        $how_to_take = "";
        $side_effects = "";
        $when_to_take = "";

        if ($medicine) {
            $medicine->updateMedicine($name, $short_name, $description, $ratings, $company_id, $category_id, $price, $tags, $type, $used_for, $also_called, $available_as, $how_to_store, $how_to_take, $side_effects, $when_to_take);
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
                <h3 class="page-header">Update Medicine: '<i><?php echo $medicine->name; ?></i>'</h3>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <p class="text-primary"><?php echo $message; ?></p>
                    <form action="" method="post">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="med-name-text-content" name="name" class="form-control" onKeyup="med_name_remaining_character()" value="<?php echo $medicine->name; ?>">
                                <div id="med-name-character-count" align="right">60</div>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" id="price-text-content" name="price" class="form-control" value="<?php echo $medicine->price; ?>">
                            </div>
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <input type="text" id="company-name-text-content" name="company_id" class="form-control" value="<?php echo $medicine->company_id; ?>">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <input type="text" id="company-name-text-content" name="category_id" class="form-control" value="<?php echo $medicine->category_id; ?>">
                            </div>
                            <div class="form-group">
                                <label for="ratings">Ratings</label>
                                <input type="text" id="ratings-text-content" name="ratings" class="form-control" value="<?php echo $medicine->ratings; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input type="text" id="tags-text-content" name="tags" class="form-control" onKeyup="tags_remaining_character()" value="<?php echo $medicine->tags; ?>">
                                <div id="tags-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" id="type-text-content" name="type" class="form-control" onKeyup="type_remaining_character()" value="<?php echo $medicine->type; ?>">
                                <div id="type-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="tags">Also Called</label>
                                <input type="also_called" id="also-called-text-content" name="also_called" class="form-control" onKeyup="also_called_remaining_character()" value="<?php echo $medicine->also_called; ?>">
                                <div id="also-called-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="available_as">Available As</label>
                                <input type="text" id="available-as-text-content" name="available_as" class="form-control" onKeyup="available_as_remaining_character()" value="<?php echo $medicine->available_as; ?>">
                                <div id="available-as-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="used_for">Used For</label>
                                <textarea name="used_for" id="used-for-text-content" class="form-control" id="" rows="5" onKeyup="used_for_remaining_character()"><?php echo $medicine->used_for; ?></textarea>
                                <div id="used-for-character-count" align="right">255</div>
                            </div> <br>
                            <div class="form-group">
                                <label for="when_to_take">When To Take</label>
                                <textarea name="when_to_take" id="when-to-take-text-content" class="form-control" id="" rows="5" onKeyup="when_to_take_remaining_character()"><?php echo $medicine->when_to_take; ?></textarea>
                                <div id="when-to-take-character-count" align="right">255</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" id="short-name-text-content" name="short_name" class="form-control" onKeyup="short_name_remaining_character()" value="<?php echo $medicine->short_name; ?>">
                                <div id="short-name-character-count" align="right">40</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="med-description-text-content" class="form-control" id="" rows="5" onKeyup="med_description_remaining_character()"><?php echo $medicine->description; ?></textarea>
                                <div id="med-description-character-count" align="right">6000</div>
                            </div>
                            <div class="form-group">
                                <label for="how_to_store">How To Store</label>
                                <textarea name="how_to_store" id="how-to-store-text-content" class="form-control" id="" rows="5" onKeyup="how_to_store_remaining_character()"><?php echo $medicine->how_to_store; ?></textarea>
                                <div id="how-to-store-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="how_to_take">How To Take</label>
                                <textarea name="how_to_take" id="how-to-take-text-content" class="form-control" id="" rows="5" onKeyup="how_to_take_remaining_character()"><?php echo $medicine->how_to_take; ?></textarea>
                                <div id="how-to-take-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="side_effects">Side Effects</label>
                                <textarea name="side_effects" id="side-effects-text-content" class="form-control" id="" rows="5" onKeyup="side_effects_remaining_character()"><?php echo $medicine->side_effects; ?></textarea>
                                <div id="side-effects-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="medicine_image">Medicine Image</label>
                                <a class="thumbnailimg" href="#" data-toggle="modal" data-target="#medicine-photo-library"><img src="<?php echo $medicine->medicinePicturePath(); ?>" alt=""></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="info-box-footer clearfix">
                                        <div class="pull-left">
                                            <a id="medicine-id" href="delete.php?id=<?php echo $medicine->id; ?>" type="button" name="delete" class="btn btn-danger btn-block"><i class="fa fa-trash-o"> Delete</i></a>
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" name="update" value="Update" class="btn btn-success btn-block"><i class="fa fa-edit"> Update</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row --> 
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>