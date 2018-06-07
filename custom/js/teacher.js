var manageTeacherTable;
var base_url=$('#base_url').val();
$(document).ready(function () {
	manageTeacherTable=$("#manageTeacherTable").DataTable({
		'ajax':base_url+'teacher/fetchTeacherData',
		'order':[],
	});
	/*Krijimi i funksionit  --------------------Kliko ne teacher add model*/
	/*-----------------------------------------Funksioni per notifaction -------------------------------------------------*/
	$("#addTeacherModelBtn").unbind('click').bind('click',function () {
		$("#dob").calendarsPicker({
			dateFormat:'yyyy-mm-dd'
		});
		$("#registerDate").calendarsPicker({
			dateFormat:'yyyy-mm-dd'
		});
		var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
			'onclick="alert(\'Call your custom code here.\')">' +
			'<i class="glyphicon glyphicon-tag"></i>' +
			'</button>';
		$("#photo").fileinput({
			overwriteInitial: true,
			maxFileSize: 1500,
			showClose: false,
			showCaption: false,
			browseLabel: '',
			removeLabel: '',
			browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			removeTitle: 'Cancel or reset changes',
			elErrorContainer: '#kv-avatar-errors-1',
			msgErrorClass: 'alert alert-block alert-danger',
			defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
			layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			allowedFileExtensions: ["jpg", "png", "gif",'JPG','PNG']
		});
		$("#createTeacherForm").unbind('submit').bind('submit',function () {
			var form=$(this);
			var formData=new FormData($(this)[0]);
			var url=form.attr('action');
			var type=form.attr('method');
			$.ajax({
				url:url,
				type:type,
				data:formData,
				dataType:'json',
				cache:false,
				contentType:false,
				processData:false,
				success:function (response) {
					if(response.success==true){

						$("#add-teacher-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						manageTeacherTable.ajax.reload(null,false);
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						clearForm();

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
		})

	});


});
/*Funksioni per editimin e profesorit--------------------------------------------------------------------------------------------------------------------------------*/
function editTeacher(teacherId=null) {
	if(teacherId)
	{
		$('#editDob').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		$('#editRegisterDate').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		/*iNSERTIMI I MODULIT PER INSERTIMIN E FOTOS SE RE*/
		var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
			'onclick="alert(\'Call your custom code here.\')">' +
			'<i class="glyphicon glyphicon-tag"></i>' +
			'</button>';
		$("#editPhoto").fileinput({
			overwriteInitial: true,
			maxFileSize: 1500,
			showClose: false,
			showCaption: false,
			browseLabel: '',
			removeLabel: '',
			browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			removeTitle: 'Cancel or reset changes',
			elErrorContainer: '#kv-avatar-errors-1',
			msgErrorClass: 'alert alert-block alert-danger',
			defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Ndrysho">',
			layoutTemplates: {main2: '{preview} '  + ' {remove} {browse}'},
			allowedFileExtensions: ["jpg", "png", "gif",'PNG','JPEG']
		});
		/*fOTO aktuale e teacher id-----------------------------------------------------------------------------------*/
		$.ajax({
			url:base_url+'teacher/fetchTeacherData/'+teacherId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$("#editFname").val(response.fname);
				$("#editLname").val(response.lname);
				$("#editAge").val(response.age);
				$("#editDob").val(response.date_of_birth);
				$("#editContact").val(response.contact);
				$("#editEmail").val(response.email);
				$("#editAddress").val(response.address);
				$("#editCity").val(response.city);
				$("#editCountry").val(response.country);
				$("#editRegisterDate").val(response.register_date);
				$("#editJobType").val(response.job_type);

				$("#teacher_photo").attr('src', base_url+response.image);
				/*Prej submit clekimit ekzekuto keto komanda te cilat shihen  me posht*/
				$("#updateTeacherPhotoForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var formData=new FormData($(this)[0]);
					var url=form.attr('action')+'/'+teacherId;
					var type=form.attr('method');
					$.ajax({
						url:url,
						type:type,
						data:formData,
						dataType:'json',
						cache:false,
						contentType:false,
						processData:false,
						success:function (response) {
							if(response.success==true){

								$("#edit-teacher-messages").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center;">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								manageTeacherTable.ajax.reload(null,false);
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();
								/*Krijimi i ni ajax per te marr data prej db dhe per te shfaqur ne response dhe ne kete sektor
								* jemi duke e bere load image ne real time*/
								$.ajax({
									url:base_url+'teacher/fetchTeacherData/'+teacherId,
									type:'post',
									dataType:'json',
									success:function (response) {
										$("#teacher_photo").attr('src', base_url + response.image);
									}

								});

							}else{
									$('#dit-teacher-messages').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.message+
										'</div>');

							}


						}
					})

					return false;

				});
				$("#updateTeacherInfo").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action')+'/'+teacherId;
					var type=form.attr('method');
					$.ajax({
						url:url,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){
								$("#editInfo-teacher-messages").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center;">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								manageTeacherTable.ajax.reload(null,false);
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

									$('#editInfo-teacher-messages').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*funksioni i buttoni per fshirjen e profesorit*/
function removeTeacher(teacherId=null) {
	if(teacherId)
	{
		$("#removeTeacherBtn").unbind('click').bind('click',function () {
			 $.ajax({
				 url:base_url+'teacher/remove/'+teacherId,
				 type:'post',
				 dataType:'json',
				 success:function (response) {
					 if(response.success==true) {

						 $("#message").html('<div class="alert alert-success alert-dismissible" role="alert">' +
							 '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							 response.message +
							 '</div>');
						 manageTeacherTable.ajax.reload(null, false);
						 $("#removeTeacherModal").model('hide');
					 }else
					 {
						 $("#remove-message").html('<div class="alert alert-danger alert-dismissible" role="alert">' +
							 '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							 response.message +
							 '</div>');
					 }
					 
				 }
			 });
		});
	}




}


/*funksioni per fshirjen e fildav*/
function clearForm() {
	$("input[type=text]").val('');
	$("select").val('');
	$(".fileinput-remove-button").click();

}
