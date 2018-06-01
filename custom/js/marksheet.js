var base_url=$('#base_url').val();
$(document).ready(function () {
	var kerkesa=$("#kerkesa").text();
	if(kerkesa=='mngms') {/*Gjdo gje brenda keti statment do te jete per menagjimin e marksheet per editim per add edhe remove*/

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
				url:url+'/'+class_id,
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
