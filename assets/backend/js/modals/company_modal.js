$(document).ready(function(){
	var company_href;
	var company_href_splitted;
	var company_id;
	var company_image_src;
	var company_image_href_splitted;
	var company_image_name;

	$(".company_modal_thumbnails").click(function(){
		/*Set Select Button To Clicable*/
		$("#set_company_image").prop('disabled', false);

		company_href = $("#company-id").prop('href');
		company_href_splitted = company_href.split("=");
		company_id = company_href_splitted[company_href_splitted.length -1];

		company_image_src = $(this).prop("src");
		company_image_href_splitted = company_image_src.split("/");
		company_image_name = company_image_href_splitted[company_image_href_splitted.length -1];
	});

	$("#set_company_image").click(function(){
		$.ajax({
			url: "company_ajax_code.php",
			data:{company_image_name:company_image_name, company_id:company_id},
			type: "POST",
			success:function(data){
				if(!data.error){
					location.reload(true);
				}
			}
		});
	});
});