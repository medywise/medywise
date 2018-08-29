<?php require_once('../../initialize.php'); ?>
<?php $medicines = Medicines::findAllMedicines(); ?>
<div class="modal fade" id="medicine-photo-library">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Medicine's Photos Library</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-9">
             <div class="thumbnails row">
                <!-- PHP LOOP HERE CODE HERE-->
                <?php foreach ($medicines as $medicine): ?>
               <div class="col-xs-2">
                 <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#" class="thumbnail">
                   <img class="medicine_modal_thumbnails img-responsive" src="<?php echo $medicine->medicinePicturePath(); ?>" data="<!-- PHP LOOP HERE CODE HERE-->">
                 </a>
                  <div class="photo-id hidden"></div>
               </div>
                    <!-- PHP LOOP HERE CODE HERE-->
                    <?php endforeach; ?>
             </div>
          </div><!--col-md-9 -->

  <div class="col-md-3">
    <div id="modal_sidebar"></div>
  </div>

   </div><!--Modal Body-->
      <div class="modal-footer">
        <div class="row">
               <!--Closes Modal-->
              <button id="set_medicine_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Apply Selection</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->