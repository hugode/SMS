var base_url=$('#base_url').val();
$(document).ready(function () {
	var kerkesa=$("#kerkesa").text();
	if(kerkesa=='mngms') {/*Gjdo gje brenda keti statment do te jete per menagjimin e marksheet per editim per add edhe remove*/
	$("#manageMarksheet").addClass('active');
	var classSideBar=$(".classSideBar").attr('id');
	var classId=classSideBar.substring(7);
	getClassMarksheet(classId);/*Ketu kemi thirrur funksioni me posht dmth ne ready function ne menyr automatike thirret ky funksion*/
		/*==================================================Add Form================================================================*/
		$("#createMarksheetForm").unbind('submit').bind('submit',function () {
			var class_id=$("#add").val();
			var form=$(this);
			var url=form.attr('action');
			var type=form.attr('method');
			$.ajax({
				url:url+'/'+class_id,//Dergimi i class_id
				type:type,
				data:form.serialize(),
				dataType:'json',
				success:function (response) {
					if(response.success==true){

						$("#add-marksheet-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-danger').remove();
						$(".result").load(base_url+'marksheet/fetchMarksheetTable/'+class_id);
						$('.form-group').removeClass('has-error').removeClass('has-success')
						$('.text-danger').remove();
						$('#createMarksheetForm').reset();

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

							$('#add-marksheet-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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




/*Funksioni per shfaqejn e te dhenav duke u bazur ne class id ku te dhenat jan marksheet
 * dhe per me shum informacion vazhdoni shiqoni funksonin  */
function getClassMarksheet(classId=null) {
	/*Ketu eshte nje funksion i cili premse ajax ekzekuton nje komand ne marksheet modul dhe rezultatin e shfaq ne classen result
	* e cila eshte ne marksheet view ku premes keti funksioni i e realizoim komanden dhe ja dergoim classId i cila specifikon clasen
	* dhe marksheetet te cilat jan ne te dmth gjdo gje se eshte mrena kesaj klass id na shfaqet ne rezult me ndryshe marksheetet te cilat e kan classid
	* adekuate ne shfaqen ketu*/
	if(classId){

		$.ajax({
			url:base_url+'marksheet/fetchMarksheetTable/'+classId,
			type:'post',
			success:function (response) {
				$(".result").html(response);

			}
		});
		$("#examDate").calendarsPicker({
			dateFormat:'yyyy-mm-dd'
		});
	}

}
/*Funksioni per editimin e section*/
function editMarksheet(marksheetId=null,classId=null) {
	$("#editExamDate").calendarsPicker({
		dateFormat:'yyyy-mm-dd'
	});
	if(marksheetId && classId)
	{
		/*Ketu kemi nje editim i cili behet ne baze te sectionid dhe te classid ku i merr te dhenat permes funksionit fetchsectionbyclassname
		* dhe shfaqi ne menyr specifike ne inpute te edit formes dhe nese behet ndonje ndryshim kur bejm submir ekzekuto komanden me posht
		* ku mundeson ndryshimin e te dhenav ne databaz permes sectionid*/
		$.ajax({
			url:base_url+'marksheet/fetchMarksheetByClassMarksheet/'+marksheetId,
			type:'post',
			dataType:'json',
			success:function (response) {
				$("#editMarksheetName").val(response.marksheet_name);
				$("#editExamDate").val(response.marksheet_date);

				$("#editMarksheetForm").unbind('submit').bind('submit',function () {
					var form=$(this);
					var url=form.attr('action');
					var type=form.attr('method');
					$.ajax({
						url:url+'/'+marksheetId+'/'+classId,
						type:type,
						data:form.serialize(),
						dataType:'json',
						success:function (response) {
							if(response.success==true){

								$("#edit-marksheet-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">'+
									'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									response.message+
									'</div>');
								$('.text-danger').remove();
								$(".result").load(base_url+'marksheet/fetchMarksheetTable/'+classId);
								$('.form-group').removeClass('has-error').removeClass('has-success')
								$('.text-danger').remove();
								//$('#editMarksheetForm').reset();

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

									$('#edit-marksheet-message').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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
/*Funksioni per fshirjen e marksheet*/
function removeMarksheet(marksheetId=null,classId=null) {
	if (marksheetId && classId) {
		$("#removeBtnMarksheet").unbind('click').bind('click', function () {
			$.ajax({
				url: base_url + 'marksheet/remove/' + marksheetId,
				type: 'post',
				dataType: 'json',
				success: function (response) {
					if (response.success == true) {
						$("#message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
							response.message +
							'</div>');
						$(".result").load(base_url+'marksheet/fetchMarksheetTable/'+classId);
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
		return false;
	}
}
