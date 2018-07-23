<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Add Medicine'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
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
    $medicine = new Medicines();
    $medicine->addNewMedicine($name, $short_name, $description, $ratings, $company_id, $category_id, $price, $tags, $type, $used_for, $also_called, $available_as, $how_to_store, $how_to_take, $side_effects, $when_to_take);
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
                <h3 class="page-header">Add New Medicine</h3>
            </div> 
            <div class="panel-body">
                <div class="row">
                            <p class="text-primary"><?php echo $message; ?></p>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="med-name-text-content" name="name" class="form-control" onKeyup="med_name_remaining_character()">
                                <div id="med-name-character-count" align="right">60</div>
                            </div>
                            <div class="form-group">
                                <label>Medicine Image</label>
                                <input class="btn btn-outline btn-primary btn-xs" type="file" name="file_upload">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" id="price-text-content" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company_id">Company</label>
                                <input type="text" id="company-name-text-content" name="company_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <input type="text" id="category-name-text-content" name="category_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="ratings">Ratings</label>
                                <input type="text" id="ratings-text-content" name="ratings" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input type="text" id="tags-text-content" name="tags" class="form-control" onKeyup="tags_remaining_character()">
                                <div id="tags-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" id="type-text-content" name="type" class="form-control" onKeyup="type_remaining_character()">
                                <div id="type-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="also_called">Also Called</label>
                                <input type="text" id="also-called-text-content" name="also_called" class="form-control" onKeyup="also_called_remaining_character()">
                                <div id="also-called-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="available_as">Available As</label>
                                <input type="text" id="available-as-text-content" name="available_as" class="form-control" onKeyup="available_as_remaining_character()">
                                <div id="available-as-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="used_for">Used For</label>
                                <textarea name="used_for" id="used-for-text-content" class="form-control" id="" rows="5" onKeyup="used_for_remaining_character()"></textarea>
                                <div id="used-for-character-count" align="right">255</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" id="short-name-text-content" name="short_name" class="form-control" onKeyup="short_name_remaining_character()">
                                <div id="short-name-character-count" align="right">40</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="med-description-text-content" class="form-control" id="" rows="5" onKeyup="med_description_remaining_character()"></textarea>
                                <div id="med-description-character-count" align="right">6000</div>
                            </div>
                            <div class="form-group">
                                <label for="how_to_store">How To Store</label>
                                <textarea name="how_to_store" id="how-to-store-text-content" class="form-control" id="" rows="5" onKeyup="how_to_store_remaining_character()"></textarea>
                                <div id="how-to-store-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="how_to_take">How To Take</label>
                                <textarea name="how_to_take" id="how-to-take-text-content" class="form-control" id="" rows="5" onKeyup="how_to_take_remaining_character()"></textarea>
                                <div id="how-to-take-character-count" align="right">255</div>
                            </div>
                            <div class="form-group">
                                <label for="side_effects">Side Effects</label>
                                <textarea name="side_effects" id="side-effects-text-content" class="form-control" id="" rows="5" onKeyup="side_effects_remaining_character()"></textarea>
                                <div id="side-effects-character-count" align="right">255</div>
                            </div> <br>
                            <div class="form-group">
                                <label for="when_to_take">When To Take</label>
                                <textarea name="when_to_take" id="when-to-take-text-content" class="form-control" id="" rows="5" onKeyup="when_to_take_remaining_character()"></textarea>
                                <div id="when-to-take-character-count" align="right">255</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Add New Medicine</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row --> 
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>