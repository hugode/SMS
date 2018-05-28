var base_url=$('#base_url').val();
$(document).ready(function () {

	var kerkesa=$("#kerkesa").text();
	if(kerkesa=='add') {/*Nese requesti i dhene do te jete i barabart me add ateher gjdo gje to ekzekutohet per me kriju pjessmarrrje*/

		$("#type").on('change',function () {
			/*Ne seclet option ne change do te shfaqen keto te dhena*/
			var id=$(this).val();
			$(".result").load(base_url+'attendance/fetchAttendanceType/'+id,function () {
				/*Ne change option ateher behet load i gjith funksioni i cili gjendet ne controllerin attendance
				* dhe gjitha te dhenat do te shfaqen ne div classen result*/
				$("#date").calendarsPicker({
					dateFormat: 'yyyy-mm-dd'
				});
				/*Ne optionin select className prej attendance/fetchAttendanceType aty shfaqen klaset aktuale ne db
				 * dhe ne momentin se selektohet nje klasea ather ky funksion perfuni do te sherben per ti sshfaqur ne
				  * section name te gjith section te cilat jan ne kete klasee id*/
				$("#className").on('change', function () {
					var classId = $(this).val();
					$("#sectionName").load(base_url + 'student/fetchClassSection/' + classId);
				});

				$("#getAttendanceForm").on('submit', function() {
					$('.text-danger').remove();
					/*Ne formen e krijuar ne attendance controlleer ne submit do te realizohet te gjitha funksionet perfuni kesaj forme
					* duke u bazuar ne type id nese asht 1 do te sherben per student nese asht 2 ateher per profesor*/
					if(id==1)
					{
						/*Gjdo gje brena keti if do te sherbne per student form*/
						var className=$("#className").val();
						var sectionName=$("#sectionName").val();
						var date=$("#date").val();


						/*Validimi per klassName----------------------------------------------------------------------*/
						if(className=="")
						{
							$("#className").closest(".form-group").removeClass('has-success').addClass('has-error');
							$("#className").after("<p class='text-danger' >Zgjedh Emrin e klases</p>")
						}
						else{
							$("#className").closest(".form-group").removeClass('has-error').addClass('has-success');
							$('.text-danger').remove();
						}
						/*Validimi per sectionName----------------------------------------------------------------------*/
						if(sectionName=="")
						{
							$("#sectionName").closest(".form-group").removeClass('has-success').addClass('has-error');
							$("#sectionName").after("<p class='text-danger' >Zgjedh Emrin e Sektorit</p>")
						}
						else{
							$("#sectionName").closest(".form-group").removeClass('has-error').addClass('has-success');
							$('.text-danger').remove();
						}
						/*Validimi per sectionName----------------------------------------------------------------------*/
						if(date=="")
						{
							$("#date").closest(".form-group").removeClass('has-success').addClass('has-error');
							$("#date").after("<p class='text-danger' >Sheno daten</p>")
						}
						else{
							$("#date").closest(".form-group").removeClass('has-error').addClass('has-success');
							$('.text-danger').remove();
						}
						if(className && sectionName && date)/*Nese kmei classname sectionname edhe date ateher shfaqi te dhant*/
						{
							/*ne dic id attendance-result sshfaq te dhant e marra nga getattendancetable duke ja derguar edhe parametrat*/
							$("#attendance-result").load(base_url+'attendance/getAttendanceTable/'+className+'/'+sectionName+'/'+date+'/'+id,function () {
								$("#createAttendanceForm").on('submit',function () {/*Ne submit e krijimit te attendance posht tabeles valido */
									/*me lajmrimin se a pat sukses a jo*/
									var form=$(this);
									var url=form.attr('action');
									var type=form.attr('method');

									$.ajax({
										url:url,
										type:type,
										data:form.serialize(),
										dataType:'json',
										success:function (response) {
											if (response.success == true) {
												$("#att-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
													'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
													response.message +
													'</div>');
												$('.form-group').removeClass('has-error').removeClass('has-success')
												$('.text-danger').remove();
												window.location(base_url('http://localhost/sms/attendance?atd=add'));


											}else{
												$('.text-danger').remove();
												$('.text-group').removeClass('has-error').removeClass('has-success');

												$('#att-message').html('<div class="alert alert-warning alert-dismissible" role="alert">' +
													'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
													response.message +
													'</div>');
											}
										}
									});
									return false;

								});

							});
						}

						/*student*/

					}else if(id==2)
					{
						var date=$("#date").val();
						if(date=="")
						{
							$("#date").closest(".form-group").removeClass('has-success').addClass('has-error');
							$("#date").after("<p class='text-danger' >Sheno Daten</p>")
						}
						else{
							$("#date").closest(".form-group").removeClass('has-error').addClass('has-success');
							$('.text-danger').remove();
						}
						if(date)
						{
							$("#attendance-result").load(base_url+'attendance/getAttendanceTable/""/""/'+date+'/'+id,function () {
								$("#createAttendanceForm").on('submit',function () {
									var form=$(this);
									var url=form.attr('action');
									var type=form.attr('method');
									$.ajax({
										url:url,
										type:type,
										data:form.serialize(),
										dataType:'json',
										success:function (response) {
											if (response.success == true) {
												$("#att-message").html('<div class="alert alert-success alert-dismissible" style="text-align: center;" role="alert">' +
													'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
													response.message +
													'</div>');
												$('.form-group').removeClass('has-error').removeClass('has-success')
												$('.text-danger').remove();


											}else{
												$('.text-danger').remove();
												$('.text-group').removeClass('has-error').removeClass('has-success');

												$('#att-message').html('<div class="alert alert-warning alert-dismissible" role="alert">' +
													'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
													response.message +
													'</div>');
											}
										}
									});
									return false;

								});

							});
						}
						/*Teeacher form*/
					}
					return false;

				});


			});

		});





	}/*Te gjitha funksionet per optionin add*/
	else if(kerkesa == 'report') {
		$("#attenReport").addClass('active');

		/*Zgjedh tipin*/

		$("#type").unbind('change').bind('change', function() {
			var typeId = $(this).val();

			if(typeId == 1) {
				$("#student-form").load(base_url + 'attendance/fetchClassAndSection', function() {
					$("#className").on('change', function () {
						var classId = $(this).val();
						$("#sectionName").load(base_url + 'student/fetchClassSection/' + classId);
					});
				});
			}
			else {
				$("#student-form").html('');
			}
		});

		$("#reportDate").calendarsPicker({
			calendar: $.calendars.instance(),
			dateFormat: 'yyyy-mm',
			onChangeMonthYear: function(year, month) {
				if(month < 10) {
					$('#reportDate').val(year + '-' + '0' + month);
				} else {
					$('#reportDate').val(year + '-' + month);
				} // /else
				daysInMonth(month, year);
			},
			onShow: function(picker, calendar, inst) {
				picker.find('table').addClass('alternate-dates');
			},
			onSelect: function(dates) {
				var minDate = dates[0];
				for (var i = 1; i < dates.length; i++) {
					if (dates[i].getTime() < minDate.getTime()) {
						minDate = dates[i];
					} // /if
				}  // /for
				var year = minDate.year();
				var month = minDate.month();
				daysInMonth(month, year);
			}
		}); // attendance report date

		function daysInMonth(month,year) {
			var pc = $.calendars.instance();
			var dim = pc.daysInMonth(year, month);

			$("#num_of_days").val(dim);
		}
		/*Gjenero raportin */
		$("#getAttendanceReport").unbind('submit').bind('submit', function() {
			var form = $(this);

			var type = $("#type").val();
			var reportDate = $("#reportDate").val();


			if(type == "") {
				$("#type").closest('.form-group').removeClass('has-success').addClass('has-error');
				$("#type").after('<p class="text-danger">The Type field is required</p>');
			}
			else {
				$("#type").closest('.form-group').removeClass('has-error').addClass('has-success');
				$(".text-danger").remove();
			}

			if(reportDate == "") {
				$("#reportDate").closest('.form-group').removeClass('has-success').addClass('has-error');
				$("#reportDate").after('<p class="text-danger">The Date field is required</p>');
			}
			else {
				$("#reportDate").closest('.form-group').removeClass('has-error').addClass('has-success');
				$(".text-danger").remove();
			}


			if(type && reportDate) {
				$('.form-group').removeClass('has-error').removeClass('has-success');
				$('.text-danger').remove();

				var num_of_days = $("#num_of_days").val();
				var className = $("#className").val();
				var sectionName = $("#sectionName").val();

				if(type == 1) {
					// student

					if($("#className").val() == "") {
						$("#className").closest('.form-group').removeClass('has-success').addClass('has-error');
						$("#className").after('<p class="text-danger">The Date field is required</p>');
					}
					else {
						$("#className").closest('.form-group').removeClass('has-error').addClass('has-success');
						$(".text-danger").remove();
					}

					if($("#sectionName").val() == "") {
						$("#sectionName").closest('.form-group').removeClass('has-success').addClass('has-error');
						$("#sectionName").after('<p class="text-danger">The Date field is required</p>');
					}
					else {
						$("#sectionName").closest('.form-group').removeClass('has-error').addClass('has-success');
						$(".text-danger").remove();
					}

					if($("#className").val() && $("#sectionName").val()) {
						$(".form-group").removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();

						var url = form.attr('action') + '/' + type + '/' + reportDate + '/' + num_of_days + '/' + className + '/' + sectionName;
						$("#report-div").load(url);
					} // /if
				}
				else if(type == 2) {
					var url = form.attr('action') + '/' + type + '/' + reportDate + '/' + num_of_days;
					$("#report-div").load(url);
				}
			} // /if
			return false;

		});

	} // /.else report

});
