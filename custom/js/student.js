var managaStudentTable=$(".lala");
var studentSectionTable={};
var base_url=$('#base_url').val();
$(document).ready(function () {

	var kerkesa=$("#kerkesa").text();
	if(kerkesa=='addst') {
		/*Kalenderi per dob*/
		$("#dob").calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		/*Kalendari per register date*/
		$("#registerDate").calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		/*Plugins per foto*/
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
			layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
			allowedFileExtensions: ["jpg", "png", "gif", 'JPG', 'PNG']
		});

		/*Funksioni per mi nxerr sectionit duke u bazuar nga inputi i class id */
		$("#className").on('change', function () {
			var classId = $(this).val();
			$("#sectionName").load(base_url + 'student/fetchClassSection/' + classId);
		});


		/*Forma qe bene te mundur shtimi e studieti duke e thirr dhe more respones*/
		$("#createStudentForm").unbind('submit').bind('submit', function () {
			var form = $(this);
			var formData = new FormData($(this)[0]);
			var url = form.attr('action');
			var type = form.attr('method');
			$.ajax({
				url: url,
				type: type,
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				success: function (response) {
					if (response.success == true) {

						$("#add-student-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						$('#createStudentForm')[0].reset();
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						clearForm();

					} else {
						if (response.message instanceof Object) {
							$.each(response.message, function (index, value) {
								var key = $("#" + index);
								key.closest(".form-group")
									.removeClass('has-error')
									.removeClass('has-success')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('.text-danger').remove();

								key.after(value);
							});


						} else {
							$('.text-danger').remove();
							$('.text-group').removeClass('has-error').removeClass('has-success');

							$('#add-student-message').html('<div class="alert alert-warning alert-dismissible" role="alert">' +
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
								response.message +
								'</div>');
						}
					}


				}


			});
			return false;
		})
	}/*Te gjitha funksionet per optionin addst*/
	else if(kerkesa=='bulkst')/*Te gjitha funksonet per optionin bulkst*/{
		$("#createBulkForm").unbind('submit').bind('submit', function () {
			var form = $(this);
			var url = form.attr('action');
			var type = form.attr('method');
			$.ajax({
				url: url,
				type: type,
				data: form.serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.success == true) {

						$("#add-bulk-student-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						clearForm();

					} else {
						if (response.message instanceof Object) {
							$.each(response.message, function (index, value) {
								var key = $("#" + index);
								key.closest(".form-group")
									.removeClass('has-error')
									.removeClass('has-success')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('.text-danger').remove();

								key.after(value);
							});


						} else {
							$('.text-danger').remove();
							$('.text-group').removeClass('has-error').removeClass('has-success');

							$('#add-bulk-student-message').html('<div class="alert alert-warning alert-dismissible" role="alert">' +
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
								response.message +
								'</div>');
						}
					}


				}


			});
			return false;
		})
	}
	else if(kerkesa=='mgst'){/*Te gjitha funksonet per mgst*/
		var classSideBar=$(".classSideBar").attr('id');
		var class_Id=classSideBar.substring(7);
		getClassSection(class_Id);
		/*Ky funkson me posht bene te mundur se ne ndryshimin e zzgjehdjes se
		kalses ne edit form te shfaqen sectionet per at klass*/
		$("#editClassName").on('change', function () {
			var classId = $(this).val();
			$("#editSection").load(base_url + 'student/fetchClassSection/' + classId);
		});
	}/*Te Gjitha te dhenat dhe funksionet per option menagjimiin e studentit insertohen ketu*/




});
/*Funksioni per mi nxerr studentat sipas sectionit*/
function getClassSection(classId=null) {
	/*Ketu eshte nje funksion i cili premse ajax ekzekuton nje komand ne section modul dhe rezultatin e shfaq ne classen result
	* e cila eshte ne section view ku premes keti funksioni i e realizoim komanden dhe ja dergoim classId i  specifikon clasen
	* dhe sectionet te cilat jan ne te dmth gjdo gje se eshte mrena kesaj klass id na shfaqet ne rezult me ndryshe sectionet te cilat e kan classid
	* adekuate ne shfaqen ketu*/
	if(classId){
		/*nESE KEMI KLASS ID ather i bjem section ftch duke u bazu ne klass id*/
		$.ajax({
			url:base_url+'student/fetchClassSectionTable/'+classId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$(".result").html(response.html);
                    /*fetch te gjith studentat ne table*/
				managaStudentTable=$(".lala").DataTable({
					'ajax': base_url+'student/fetchStudentByClass/'+classId,
					'order':[]
				});
				$.each(response.sectionData,function (index,value) {
					index+=1;
					/*Fetch studentat duhe u bazuar sipas class id dhe section id ne menyr specifike fetchStudentByClassAndSection*/
					studentSectionTable['studentTable'+index]=$("#managaStudentTable"+index).DataTable({
						'ajax':'student/fetchStudentByClassAndSection/'+value.class_id+'/'+value.section_id,
						'order':[]
					});

					
				});
			}
		});
	}
}
/*------------------------------------------------------------------------------------------------------------------*/
/*Funksoni per me shtu row ne tablele*/
function addRow() {
	var countTotalTr =$("#addBulkStudentTable tbody tr").length;
	var countId=0;
		if(countTotalTr<=0){
				countId=1;
		}else{
			var lastRowNumber=$("#addBulkStudentTable tbody tr:last").attr('id');
			var countId=lastRowNumber.substring(3);
			countId=Number(countId)+1;

		}
		$.ajax({
			url:base_url+'student/getAppendBulStudentRow/'+countId,
			type:'post',
			success:function (response) {
				if($("#addBulkStudentTable tbody tr").length>1)
				{
					$("#addBulkStudentTable tbody tr:last").after(response);

				}else{
					$("#addBulkStudentTable tbody").append(response);

				}

			}

		});


}
/*Funksioni per fshrijen e row*/
function removeRow(rowId=null) {
	if(rowId)
	{
		$("#row"+rowId).remove();

	}

}
/*Funksioni per me i nxerr section duke u bazu ne classid*/
function getSelectClassSection(rowId=null) {
	if(rowId)
	{
		var classId=$("#bulkstclassName"+rowId).val();/*E kemi mor cclass id*/
		$("#bulkstsectionName"+rowId).load(base_url+'student/fetchClassSection/'+classId);
	}
}
/*--------------------------------------------------------------------------------------------------------------------------*/
/*funksioni per fshirjen e fildav*/
function clearForm() {
	$("input[type=text]").val('');
	$("input[type=email]").val('');
	$("select").val('');
	$(".fileinput-remove-button").click();

}

/*Funksioni per editimin e studeniti*/
function editStudent(studentId=null) {
	if(studentId)
	{
		/*dy format te paisura me plugins*/
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
		/*fOTO aktuale e student id-----------------------------------------------------------------------------------*/
		$.ajax({
			url:base_url+'student/fetchStudentData/'+studentId,
			type:'post',
			dataType:'json',
			success:function (response) {
				/*Te dhenat e ardhuara nga student kontrolleri funksioni fetchstudentData*/
				$("#editFname").val(response.fname);
				$("#editLname").val(response.lname);
				$("#editAge").val(response.age);
				$("#editDob").val(response.dob);
				$("#editContact").val(response.contact);
				$("#editEmail").val(response.email);
				$("#editAddress").val(response.address);
				$("#editCity").val(response.city);
				$("#editCountry").val(response.country);
				$("#editRegisterDate").val(response.register_date);
				$("#editClassName").val(response.class_id);

                 /*Funksioni per te shfaqur section sipas class id*/
				$("#editSection").load('student/fetchClassSection'+response.class_id,function () {
					$("#editSection").val(response.section_id);
				})

				$("#editClassName").on('change', function () {
					var classId = $(this).val();
					$("#editSection").load(base_url + 'student/fetchClassSection/' + classId);
				});


				$("#student_photo").attr('src', base_url+response.image);
				/*Prej submit clekimit ekzekuto keto komanda te cilat shihen  me posht te cilat sherbejn per ndryshimin e fotos dhe
				* infon per te*/
				$("#updateStudentPhotoForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var formData=new FormData($(this)[0]);
					var url=form.attr('action')+'/'+studentId;
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

								$("#student-messages").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center;">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();
								/*Krijimi i ni ajax per te marr data prej db dhe per te shfaqur ne response dhe ne kete sektor
								* jemi duke e bere load image ne real time*/
								$.ajax({
									url:base_url+'student/fetchStudentData/'+studentId,
									type:'post',
									dataType:'json',
									success:function (response) {
										$("#student_photo").attr('src', base_url+response.image);
									}
								});
								managaStudentTable.ajax.reload(null, false);
								/*Reload table studentSectionTable*/
								$.each(studentSectionTable,function (index,value) {
									studentSectionTable[index].ajax.reload(null, false);
								});

							}else{
								$('#student-messages').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');

							}


						}
					})

					return false;

				});
				$("#updateStudentInfo").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action')+'/'+studentId;
					var type=form.attr('method');
					$.ajax({
						url:url,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){
								$("#edit-student-messages").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center;">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								managaStudentTable.ajax.reload(null, false);
								/*Reload table studentSectionTable*/
								$.each(studentSectionTable,function (index,value) {
									studentSectionTable[index].ajax.reload(null, false);
								});

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

									$("#edit-student-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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

/*Funksoni per fshirjen e  studentit*/
function removeStudent(studentId=null) {
	if(studentId)
	{
		$("#removeStudentBtn").unbind('click').bind('click',function () {
			$.ajax({
				url:base_url+'student/remove/'+studentId,
				type:'post',
				dataType:'json',
				success:function (response) {
					if(response.success==true) {

						$("#message").html('<div class="alert alert-success alert-dismissible" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						/*Reload Tablea manage student*/
						managaStudentTable.ajax.reload(null, false);
						/*Reload table studentSectionTable*/
						$.each(studentSectionTable,function (index,value) {
							studentSectionTable[index].ajax.reload(null, false);
						});
						$("#removeStudentModal").model('hide');
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

