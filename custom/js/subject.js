var base_url=$('#base_url').val();
$(document).ready(function () {


	var classSideBar=$(".classSideBar").attr('id');
	var classId=classSideBar.substring(7);



	getClassSubject(classId);/*Ketu kemi thirrur funksioni me posht dmth ne ready function ne menyr automatike thirret ky funksion*/

});
/*Funksioni per shfaqejn e te dhenav duke u bazur ne class id ku te dhenat jan sectoret
 * dhe per me shum informacion vazhdoni shiqoni funksonin  */
function getClassSubject(classId=null) {
	/*Ketu eshte nje funksion i cili premse ajax ekzekuton nje komand ne subject modul dhe rezultatin e shfaq ne classen result
	* e cila eshte ne subject view ku premes keti funksioni i e realizoim komanden dhe ja dergoim classId i cila specifikon clasen
	* dhe subject te cilat jan ne te dmth gjdo gje se eshte mrena kesaj klass id na shfaqet ne rezult me ndryshe subject te cilat e kan classid
	* adekuate ne shfaqen ketu*/

	if(classId){


		$.ajax({
			url:base_url+'subject/fetchSubjectTable/'+classId,
			type:'post',
			success:function (response) {
				$(".result").html(response);

			}
		});
	}

}
/*Funksioni per insertimin e subject*/
function addSubject(classId=null) {
	if(classId)
	{
		/*Ky function mundeson krijimin e subject dmth prej create form kur bejm submit ekzeutohet gjdo gje me posht duke marr
		* parasyqsh kushtet te cilat jan ne kete from thoim se ne kete kals id krijo kete funksion i cili merr te dhant permes inputu te subject vied
		* dhe nese gjdo gje shkon me sukses shfaq message dhe ban realode table por nese ndonje gje shkon wrong shfaq mesazhe dhe ndalo ekzekutimin*/
		$("#createSubjectForm").unbind('submit').bind('submit',function () {
			var form=$(this);
			var url=form.attr('action');
			var type=form.attr('method');
			$.ajax({
				url:url+'/'+classId,
				type:type,
				data:form.serialize(),
				dataType:'json',
				success:function (response) {
					if(response.success==true){

						$("#add-subject-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-danger').remove();
						$(".result").load(base_url+'subject/fetchSubjectTable/'+classId);
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						$('#createSubjectForm').reset();

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

							$('#add-subject-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								response.message+
								'</div>');
						}
					}


				}


			});
			return false;
		})

	}



}
/*Funksioni per editimin e subject*/
function editSubject(subjectId=null,classId=null) {
	if(subjectId && classId)
	{
		/*Ketu kemi nje editim i cili behet ne baze te subjectId dhe te classid ku i merr te dhenat permes funksionit fetchsubjectbyclassname
		* dhe shfaqi ne menyr specifike ne inpute te edit formes dhe nese behet ndonje ndryshim kur bejm submir ekzekuto komanden me posht
		* ku mundeson ndryshimin e te dhenav ne databaz permes subjectId*/
		$.ajax({
			url:base_url+'subject/fetchSubjectByClassSection/'+subjectId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$("#editSubjectName").val(response.name);
				$("#editTotalMark").val(response.total_mark);
				$("#editTeacherName").val(response.teacher_id);

				$("#editSubjectForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action');
					var type=form.attr('method');
					$.ajax({
						url:url+'/'+subjectId,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){

								$("#edit-subject-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								$('.text-danger').remove();
								$(".result").load(base_url+'subject/fetchSubjectTable/'+classId);
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();
								$('#editSubjectForm').reset();

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

									$('#edit-subject-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.message+
										'</div>');
								}
							}


						}


					});
					return false;
				})

			}
		});
	}

}
/*Funksioni per fshirjen e SUBJECTIT*/
function removeSubject($subjectId=null,classId=null) {
	if ($subjectId && classId) {
		$("#removeBtnSubject").unbind('click').bind('click', function () {
			$.ajax({
				url: base_url + 'subject/remove/' + $subjectId,
				type: 'post',
				dataType: 'json',
				success: function (response) {
					if (response.success == true) {
						$("#message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						$(".result").load(base_url+'subject/fetchSubjectTable/'+classId);
						$("#mbyll").click();
					} else {
						$("#message").html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"  role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
					}

				}
			});
		});
	}
}


