$(document).ready(function(){
	var medicine_href;
	var medicine_href_splitted;
	var medicine_id;
	var medicine_image_src;
	var medicine_image_href_splitted;
	var medicine_image_name;

	$(".medicine_modal_thumbnails").click(function(){
		/*Set Select Button To Clicable*/
		$("#set_medicine_image").prop('disabled', false);

		medicine_href = $("#medicine-id").prop('href');
		medicine_href_splitted = medicine_href.split("=");
		medicine_id = medicine_href_splitted[medicine_href_splitted.length -1];

		medicine_image_src = $(this).prop("src");
		medicine_image_href_splitted = medicine_image_src.split("/");
		medicine_image_name = medicine_image_href_splitted[medicine_image_href_splitted.length -1];
	});

	$("#set_medicine_image").click(function(){
		$.ajax({
			url: "medicine_ajax_code.php",
			data:{medicine_image_name:medicine_image_name, medicine_id:medicine_id},
			type: "POST",
			success:function(data){
				if(!data.error){
					location.reload(true);
				}
			}
		});
	});
});