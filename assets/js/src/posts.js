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


    $("form").each(function(index, el) {
    	$(this).ajaxForm({ 
	        beforeSubmit: showRequest,
	        success: showResponse,
	        dataType: 'json'
	    }); 
    });
});
 
// pre-submit callback 
function showRequest(formData, jqForm, options){ 
	resetAlert('.alert');
	$(jqForm).find('[type=submit]').prop('disabled', true);
    return true; 
} 
 
// post-submit callback 
function showResponse(response, statusText, xhr, $form){ 
	if(response.success){
		$(response.selector).addClass('alert-success').text(response.message);
		setTimeout(function(){
			location.href = base_url+'feed';
		}, 2000);
	}else{
		$(response.selector).addClass('alert-danger').text(response.message);
		$form.find('[type=submit]').prop('disabled', false);
	}
}

function resetAlert(selector){
	$(selector).removeClass('alert-success').removeClass('alert-danger');
}