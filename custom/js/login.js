$(document).ready(function () {
	$("#loginForm").unbind('submit').bind('submit',function(){
		var form=$(this);
		var url=form.attr('action');
		var type=form.attr('method');
		$.ajax({
			url:url,
			type:type,
			data:form.serialize(),
			dataType:'json',
			success:function (response) {
				if(response.success==true){

					window.location=response.message ;

				}else{
					if(response.message instanceof Object){
						$.each(response.message,function (index,value){
							var key=$("#"+index);
							key.closest(".form-group")
								.removeClass('has-error')
								.removeClass('has-success')
								.addClass(value.length > 0 ? 'has-error' : 'has-success')
								.find('.text-danger').remove();

							 key.after(value);
						});
							

					}else{
						$('.text-danger').remove();
						$('.text-group').removeClass('has-error').removeClass('has-success');

						$('#message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
					}
				}
				
			}
		});

		return false;
	});

})
