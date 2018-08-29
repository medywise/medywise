$(document).ready(function(){
	var admin_href;
	var admin_href_splitted;
	var admin_id;
	var admin_image_src;
	var admin_image_href_splitted;
	var admin_image_name;

	$(".admin_modal_thumbnails").click(function(){
		/*Set Select Button To Clicable*/
		$("#set_admin_image").prop('disabled', false);

		admin_href = $("#admin-id").prop('href');
		admin_href_splitted = admin_href.split("=");
		admin_id = admin_href_splitted[admin_href_splitted.length -1];

		admin_image_src = $(this).prop("src");
		admin_image_href_splitted = admin_image_src.split("/");
		admin_image_name = admin_image_href_splitted[admin_image_href_splitted.length -1];
	});

	$("#set_admin_image").click(function(){
		$.ajax({
			url: "admin_ajax_code.php",
			data:{admin_image_name: admin_image_name, admin_id:admin_id},
			type: "POST",
			success:function(data){
				if(!data.error) {
					location.reload(true);
				}
			}
		});
	});
});