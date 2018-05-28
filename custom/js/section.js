var base_url=$('#base_url').val();
$(document).ready(function () {


	var classSideBar=$(".classSideBar").attr('id');
	var classId=classSideBar.substring(7);


	getClassSection(classId);/*Ketu kemi thirrur funksioni me posht dmth ne ready function ne menyr automatike thirret ky funksion*/

});
/*Funksioni per shfaqejn e te dhenav duke u bazur ne class id ku te dhenat jan sectoret
 * dhe per me shum informacion vazhdoni shiqoni funksonin  */
function getClassSection(classId=null) {
	/*Ketu eshte nje funksion i cili premse ajax ekzekuton nje komand ne section modul dhe rezultatin e shfaq ne classen result
	* e cila eshte ne section view ku premes keti funksioni i e realizoim komanden dhe ja dergoim classId i cila specifikon clasen
	* dhe sectionet te cilat jan ne te dmth gjdo gje se eshte mrena kesaj klass id na shfaqet ne rezult me ndryshe sectionet te cilat e kan classid
	* adekuate ne shfaqen ketu*/
	if(classId){

		$.ajax({
			url:base_url+'section/fetchSectionTable/'+classId,
			type:'post',
			success:function (response) {
				$(".result").html(response);
				
			}
		});
	}

}
/*Funksioni per insertimin e sectionit*/
function addSection(classId=null) {
	if(classId)
	{
		/*Ky function mundeson krijimin e Sectioni dmth prej create form kur bejm submit ekzeutohet gjdo gje me posht duke marr
		* parasyqsh kushtet te cilat jan ne kete from thoim se ne kete kals id krijo kete funksion i cili merr te dhant permes inputu te section vied
		* dhe nese gjdo gje shkon me sukses shfaq message dhe ban realode table por nese ndonje gje shkon wrong shfaq mesazhe dhe ndalo ekzekutimin*/
		$("#createSectionForm").unbind('submit').bind('submit',function () {
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

						$("#add-section-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-danger').remove();
						$(".result").load(base_url+'section/fetchSectionTable/'+classId);
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						$('#createSectionForm').reset();

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

							$('#add-section-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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
/*Funksioni per editimin e section*/
function editSection(sectionId=null,classId=null) {
	if(sectionId && classId)
	{
		/*Ketu kemi nje editim i cili behet ne baze te sectionid dhe te classid ku i merr te dhenat permes funksionit fetchsectionbyclassname
		* dhe shfaqi ne menyr specifike ne inpute te edit formes dhe nese behet ndonje ndryshim kur bejm submir ekzekuto komanden me posht
		* ku mundeson ndryshimin e te dhenav ne databaz permes sectionid*/
		$.ajax({
			url:base_url+'section/fetchSectionByClassSection/'+sectionId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$("#editSectionName").val(response.section_name);
				$("#editTeacherName").val(response.teacher_id);

				$("#editSectionForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action');
					var type=form.attr('method');
					$.ajax({
						url:url+'/'+sectionId,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){

								$("#edit-section-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								$('.text-danger').remove();
								$(".result").load(base_url+'section/fetchSectionTable/'+classId);
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();
								$('#createSectionForm').reset();

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

									$('#edit-section-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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
/*Funksioni per fshirjen e section*/
function removeSection(sectionId=null,classId=null) {
	if (sectionId && classId) {
		$("#removeBtnSection").unbind('click').bind('click', function () {
			$.ajax({
				url: base_url + 'section/remove/' + sectionId,
				type: 'post',
				dataType: 'json',
				success: function (response) {
					if (response.success == true) {
						$("#message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						$(".result").load(base_url+'section/fetchSectionTable/'+classId);
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


