<?php require_once('../../initialize.php'); ?>
<?php $admins = Admin::findAllAdmins(); ?>
<div class="modal fade" id="admin-photo-library">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Admin Photos Library</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-9">
             <div class="thumbnails row">
                <!-- PHP LOOP CODE STARTS HERE-->
                <?php foreach ($admins as $admin): ?>
               <div class="col-xs-2">
                 <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#" class="thumbnail">
                   <img class="admin_modal_thumbnails img-responsive" src="<?php echo $admin->adminPicturePath(); ?>" data="<!-- PHP LOOP HERE CODE HERE-->">
                 </a>
                  <div class="photo-id hidden"></div>
               </div>
                <?php endforeach; ?>
                <!-- PHP LOOP CODE ENDS HERE-->
             </div>
          </div><!--col-md-9 -->
  <div class="col-md-3">
    <div id="modal_sidebar"></div>
  </div>

   </div><!--Modal Body-->
      <div class="modal-footer">
        <div class="row">
          <!--Closes Modal-->
          <button id="set_admin_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Apply Selection</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->