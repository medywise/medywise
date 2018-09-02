jQuery(document).ready(function () {
	new ClipboardJS('.copyme');
 	$(".scrh").autocomplete({
		minLength: 3,
		autoFocus: true,
		source: function (request, response) {
			var med = jQuery('.scrh').val();
			var opselect = jQuery('.opselect').val();
			$.ajax({
				url: '/src/helpers/auto_med.php',
				type: 'post',
				dataType: "json",
				data: '&med=' + med + '&opselect=' + opselect,
				success: function (data, textStatus, jqXHR) {
					console.log(data);
					var items = data;
					response(items);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(textStatus);
				}
			})
		},
		select: function (event, ui) {
			var label = ui.item.label;
			var value = ui.item.value;
			jQuery('body').LoadingOverlay('show')
			jQuery('.mst_ask').hide()
			jQuery('.fullsearch_result').html('');
			jQuery.post('/src/helpers/search_med.php','&s='+value+'&opselect='+jQuery('.opselect').val()).done(function(r){
				// console.log(r)
				jQuery('.search_result').html(r);
				jQuery('.owl-carousel').owlCarousel({
					responsiveClass:true,
				    responsive:{
				        0:{
				            items:1,
				            nav:true
				        },
				        600:{
				            items:3,
				            nav:false
				        },
				        1000:{
				            items:4,
				            nav:true,
				            loop:false
				        },
				    },
				})
				jQuery('body').LoadingOverlay('hide')
				
			})
		}
	}).bind('focus', function(){ jQuery(this).autocomplete("search"); } );

	jQuery(".selector").keydown(function(event){
    if(event.keyCode == 13) {
      if(jQuery(".selector").val().length==0) {
          event.preventDefault();
          return false;
      }
    }
 });

	// jQuery(document).on('click','.frq_asked',function(e){
	// 	e.preventDefault();
	// 	jQuery('.scrh').val(jQuery(this).text());
	// 	jQuery('.opselect').val('medicine');
 // 		jQuery('.scrh').focus();
	// })

	var med = getUrlVars('med');
	if(med.length){
		jQuery('.scrh').val(med);
		jQuery('.opselect').val('medicine');
 		jQuery('.scrh').focus();
	}

	jQuery(document).on('click', '.med_res', function (e) {
		e.preventDefault();
		jQuery('html').LoadingOverlay('show')

		var id = jQuery(this).data('id');
		jQuery.post('/src/helpers/single_med.php', '&id=' + id).done(function (r) {
			var re = JSON.parse(r);
			jQuery('#medmodal').find('.modal-title').html(re.name);
			jQuery('#medmodal').find('.modal-body').html('<p>' + re.name + '</p>');
			jQuery('#medmodal').modal('show');
			jQuery('.search').LoadingOverlay('hide')

		})

	})

	jQuery(document).on('click','.search_result_item',function(e){
		// var id = jQuery(this).attr('id');
		// jQuery.post('/src/helpers/final_search_med.php','&id='+id).done(function(re){
		// 	jQuery('.fullsearch_result').html(re);

		// })
		jQuery('.owl-carousel').fadeOut('fast');
		jQuery('.show_later').removeClass('hidden');

	})	

	jQuery(document).on('click','.grid-inner,.mst_asked',function(e){
		jQuery('.mst_ask').hide()
		var id = jQuery(this).attr('id');

		jQuery.post('/src/helpers/update_clicks.php','&id='+id);
 		jQuery.post('/src/helpers/final_search_med.php','&id='+id).done(function(re){
			jQuery('.fullsearch_result').html(re);

		})

		jQuery('.owl-carousel').fadeOut('fast');
		jQuery('.show_later').removeClass('hidden');

	})
})

window.fbAsyncInit = function () {
	FB.init({
		appId: '209782113001103',
		status: true,
		cookie: true,
		version: 'v2.10'
	});

	var image = 'https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg';
	jQuery(document).on('click', '.share_to_fb', function (e) {
		e.preventDefault();
		FB.ui({
			method: 'share',
			href: document.location.href,
			// action_properties: JSON.stringify({
			// object: {
			// 	'og:url': 'http://dev-medical-web.pantheonsite.io/search' + '?med=' + image,
			// 	'og:title': 'overrideTitle',
			// 	'og:description': 'overrideDescription',
			// 	'og:image': 'overrideImage'
			// }
		// })
		});
	})
};

(function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) { return; }
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars = value;
    });
    return vars;
}