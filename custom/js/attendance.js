var base_url=$('#base_url').val();
$(document).ready(function () {

	var kerkesa=$("#kerkesa").text();
	if(kerkesa=='add') {/*Nese requesti i dhene do te jete i barabart me add ateher gjdo gje to ekzekutohet per me kriju pjessmarrrje*/
		$("#takeAttendNav").addClass('active');

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

					}else if(id==2)/*Nese id e dhen prej select forms eshte 2 ateher kjo gjdo gje do te jete per teacher*/
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
		$("#attenReport").addClass('active');/*Nese jemi ne faqen report aktivizimi i classes aktive*/

		/*Zgjedh tipin*/
		/*---------------------------------------------------------------------------*/
		/*Ne tyoe div kur bjem selectimin e llojit ateher do te shfaqet te dhenat sipas
		* id te cilen e morim nga type nese id eshte 1 ateher do te ekzekutohen
		* funksionet per studentat e cila ndodh me posht,por nese type shtyp teacher
		* ateher type id eshte 2 dhe gjdo gje do te ekzekutohet per teacher.........*/
		/*---------------------------------------------------------------------------*/
		$("#type").unbind('change').bind('change', function() {
			var typeId = $(this).val();

			if(typeId == 1) {/*Nese eshte 1 ekzekuto gjdo gje brenda keti ifi*/
				/*student id div ekziston brenda formes getAttendanceReport dhe ku do te shfaqen
				* dhe ne restin e perdorimi te formes ateher form getAttendanceReport do ti merr te dhenat
				* edhe prej keti funksioni se do te shfaqen aty*/
				$("#student-form").load(base_url + 'attendance/fetchClassAndSection', function() {
					/*Gjdo gje e funksionit fetchClassAndSection() do te shfaqet ne student-form
					* dhe ku ne onchange class te cilat do te jene te gjjithat klasat aktuale ne momentin
					* e ndryshimin do te shfaqen sektoret sipas class id dhe ato te dhena shfaqen permes keti
					* funksioni me posht*/
					$("#className").on('change', function () {
						var classId = $(this).val();
						$("#sectionName").load(base_url + 'student/fetchClassSection/' + classId);
					});
				});
			}
			else {
				$("#student-form").html('');/*nese type id asht ==2 ateher mos shfaq asgje*/
			}
		});

		$("#reportDate").calendarsPicker({
			calendar: $.calendars.instance(),
			dateFormat: 'yyyy-mm',
			/*Ne kete funksion kemi bere qe selectimi i dates te jete vetum per muje edhe vit*/
			onChangeMonthYear: function(year, month) {
				if(month < 10) {
					$('#reportDate').val(year + '-' + '0' + month);
				} else {
					$('#reportDate').val(year + '-' + month);
				} // /else
				daysInMonth(month, year);
			},
			onShow: function(picker, calendar, inst) {
				picker.find('table').addClass('alternate-dates');/*Ketu kemi add ni class te dizajnu per te shfaqur vetum mujin dhe viti e jo ditet*/
			},
			onSelect: function(dates) {
				/*Ketu e kemi bere nje for e cila do te ruan te gjith ditet sipas mujve nese p.sh
				* nese muji asht shkurt ateher do te shfaqen vetum 28 dit */
				var minDate = dates[0];
				for (var i = 1; i < dates.length; i++) {
					if (dates[i].getTime() < minDate.getTime()) {
						minDate = dates[i];
					} // /if
				}  // /for
				var year = minDate.year();
				var month = minDate.month();
				daysInMonth(month, year);/*Perdorimi i funksionit daysInMonth*/
			}
		}); // attendance report date

		function daysInMonth(month,year) {
			/*ne kete funksion i kemi pranuar dy parametra */
			var pc = $.calendars.instance();/*nje instanc te calendarit*/
			var dim = pc.daysInMonth(year, month);//perodimi i keti funksioni por duke i ruajtur ne ni variabel

			$("#num_of_days").val(dim);/*dhe duke shfaqyr ne id num_of_days ku do te shfaqen ditet sipas mujit*/
		}
		/*Gjenero raportin nese prekim buttonin submit */
		$("#getAttendanceReport").unbind('submit').bind('submit', function() {
			var form = $(this);

			var type = $("#type").val();
			var reportDate = $("#reportDate").val();

           /*Me posht jane disa validime nese inputet jane empty*/
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
                        /*Disa validime*/
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
						/*Me posht keti kometi ne variablen url e cila do te kete ni path dhe disa parametra,ky url do
						* do ta kete action="pathin e funksionit per realizimin e raportiti" dhe parametrat adekuate te
						* cilat do te specifikoin llojin e raportit permes dates titpit numrit te ditve dhe section,ClassName
						* dhe gjdo gje ruhet ne kete variabel url e cila ekzkutohet dhe rezultatet behen load ne div id #report-div
						* ku do te shfaqet raporti i studentav per ma shum shiqo funksionin e formes getAttendanceReport()*/
						var url = form.attr('action') + '/' + type + '/' + reportDate + '/' + num_of_days + '/' + className + '/' + sectionName;
						$("#report-div").load(url);
					} // /if
				}
				else if(type == 2) {
					/*Ruajtja e pathit te funksionit per realizlimin e raportit per teacher dhe loadimi i ti ne
					* report-div dhe per ma shum shiqo action path of getAttendanceReport per realizimin e keti raporti*/
					var url = form.attr('action') + '/' + type + '/' + reportDate + '/' + num_of_days;
					$("#report-div").load(url);
				}
			} // /if
			return false;

		});

	} // /.per  report

});
