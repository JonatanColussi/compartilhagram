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

    $("form[name=formComment]").on('submit', function(event){
    	event.preventDefault();
    	var $form  = $(this);
    	var data   = $form.serialize();
    	var action = $form.attr('action');
    	var method = $form.attr('method');

    	$button = $form.find('[type=submit]');
    	
    	$.ajax({
    		url: action,
    		type: method,
    		data: data,
    		beforeSend: function(){
    			$button.prop('disabled', true);
    		},
    		success: function(response){
    			$button.prop('disabled', false);

				if(response != false){
					$form.siblings('.comments').append(response);
					$form.find('textarea').val('');
					$form.find('.textarea-counter').text('140 caracteres restantes');
				}else
					alert('Ocorreu um erro inesperado');
    		},
    		error: function(){
    			alert('Ocorreu um erro inesperado');
    		}
    	});
    });

    $("button.like").on('click', function(event){
    	event.preventDefault();
    	var idPost = $(this).data('idpost');

    	var $likeButton = $(this);

    	$.ajax({
    		url: base_url+'posts/like',
    		type: 'GET',
    		dataType: 'json',
    		data: {
    			idPost: idPost
    		},
    		success: function(response){
				$likeButton.html(response[1]+' Likes');
    			if(response[0])
    				$likeButton.addClass('liked');
    			else
    				$likeButton.removeClass('liked');

    		},
    		error: function(){
    			alert('Ocorreu um erro inesperado');
    		}
    	});
    });

    $("textarea").on('keydown keyup', function(){
    	$counter = $(this).siblings('.textarea-counter');
    	if($(this).attr('maxlength')){
    		let rest = $(this).attr('maxlength') - $(this).val().length;
    		$counter.text(rest+' Caracteres restantes');
    	}
    });

    $("form[name=formPost]").ajaxForm({ 
        beforeSubmit: showRequest,
        success: showResponse
    });
});

// pre-submit callback 
function showRequest(formData, jqForm, options){ 
	$(jqForm).find('[type=submit]').prop('disabled', true);
    return true; 
} 
 
// post-submit callback 
function showResponse(response, statusText, xhr, $form){ 
	$form.find('[type=submit]').prop('disabled', false);
	
	if(response != false){
		$('.feed').prepend(response);
		$form.find('textarea').val('');
		$form.find('input').val('');
		$form.find('input[type=file]').siblings('span').text('');
		$form.find('.textarea-counter').text('140 caracteres restantes');
	}else
		alert('Ocorreu um erro inesperado');
}