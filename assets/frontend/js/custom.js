jQuery(document).ready(function(){
	jQuery(document).on('submit','.search_med_form',function(e){
		e.preventDefault();

		jQuery('.search').LoadingOverlay('show');
		jQuery('.icon-top').hide();
		jQuery('.box').hide();
		jQuery('.search_result').html('');
		var med = jQuery('.scrh').val();
		jQuery.post('/src/helpers/search_med.php','&med='+med).done(function(r){
			// console.log(r)
			jQuery('.search_result').html(r);
			jQuery('.search').LoadingOverlay('hide')
		})

	})

})