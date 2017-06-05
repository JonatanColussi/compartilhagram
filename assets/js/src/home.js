jQuery(document).ready(function($) {
	$("#attachImage").on('click', function(event){
		event.preventDefault();
		$("[name=image]").click();
	});
	
	$("[name=image]").on('change', function(event){
		event.preventDefault();
		var image = $(this).val().split("\\");
		image = image[image.length-1]
		$(this).siblings('span').text(image);
	});
});