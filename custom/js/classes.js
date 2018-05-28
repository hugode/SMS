var manageClassTable;
var base_url=$('#base_url').val();
$(document).ready(function () {
	manageClassTable=$("#manageClassTable").DataTable({
		'ajax':base_url+'Classes/fetchclasesData',
		'order':[]
	});

	/*Krijimi i funksionit  --------------------Kliko ne teacher add model*/
	/*-----------------------------------------Funksioni per notifaction -------------------------------------------------*/
	$("#addClass").unbind('click').bind('click',function () {

		$("#createClassForm").unbind('submit').bind('submit',function () {
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

						$("#class-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-danger').remove();
						manageClassTable.ajax.reload(null,false);
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						$('#createClassForm').reset();

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

							$('#class-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								response.message+
								'</div>');
						}
					}


				}


			});
			return false;
		})

	});

});
/*Funksioni per editimin e Clases*/
function editClass(classId=null) {
	if(classId)
	{
		$.ajax({
			url:base_url+'classes/fetchclasesData/'+classId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$("#editClassName").val(response.class_name);
				$("#editNumricName").val(response.numeric_name);
				$("#edit_class_id").val(response.class_id);
				/*Prej submit clekimit ekzekuto keto komanda te cilat shihen  me posht*/
				$("#editClassForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action')+'/'+classId;
					var type=form.attr('method');
					$.ajax({
						url:url,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){

								$("#edit-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								$('.text-danger').remove();
								manageClassTable.ajax.reload(null,false);
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();

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

									$('#edit-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.message+
										'</div>');
								}
							}
						}
					});
					return false;

				});
			}
		});
	}

}
/*Funksoni remove*/
function deleteClass(classId=null) {
	if(classId)
	{
		$("#removeBtn").unbind('click').bind('click',function () {
			$.ajax({
				url:base_url+'classes/remove/'+classId,
				type:'post',
				dataType:'json',
				success:function (response) {
					if(response.success==true) {


						manageClassTable.ajax.reload(null, false);
						$("#remove-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
					}else
					{
						$("#remove-message").html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"  role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
					}

				}
			});
		});
	}




}
