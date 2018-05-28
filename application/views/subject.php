<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Manage Subject</li>
</ol>
<!-------------------------------------------------------->
<!--Ne kete row id kemi shfaqur te classet aktuale te regjistruara dhekemi futur functionin getClassId i cili sjell te gjitha te dhenat per ate classid
dhe i shfaq ma posht ne div classen result-->
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"> <a class="active"href="<?php echo base_url('classes')?>"><h4><b>Klaset Aktuale te Regjistruara<b></h4></a> </div>
			<ul class="nav nav-pills nav-stacked">
				<?php if($classData) {
					$x=1;
					foreach ($classData as $value){
						?>
				<li role="presentation"><a class="list-group-item classSideBar" role="tab" data-toggle="tab" id="classId<?php echo $value['class_id']?> "
						   onclick="getClassSubject(<?php echo $value['class_id']?>)"><b><!--fUNKSIONI getClassSection e perdorim kur ta ndrrojm klasen te
						ekzekutohet qaj funksion me qit id te shfaq te dhana-->
								<?php echo $value['class_name'] ?>(<?php echo $value['numeric_name']?>)
						</b></a></li>
						<?php
						$x++;
					}
				} else{
					?>
					<a href="<?php echo base_url('classes')?>" class="list-group-item">No data:Kliko ketu per te shtuar</a>
					<?php
				} ?>
			</ul>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Menage Subject</div>
			<div class="panel-body">
				<div id="message"></div>
				<div class="result">
					<!--Ne kete div class result shfaqen te gjitha te dhenat te cilat vin prej funksionit getClassSubejct()
					ku bene te mundur permes class id te shfaqen te gjith section te cilat kane kete classid-->
				</div>
			</div>
		</div>
	</div>




	<!--Shto Subject modeli i cili thirret permes buttonit ne section dhe bene te mundur futjen e te dhenav ne input dhe dergon te dhenat permes id-->
	<div class="modal fade" tabindex="-1" role="dialog" id="addSubjectModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Shto Subject</h4>
				</div>
				<form class="form-horizontal" method="post" id="createSubjectForm" action="<?php echo base_url('subject/create')?>">
					<div class="modal-body">
						<div id="add-subject-message"></div><!--Shfaqja e mesazhit-->
						<!--Form grupi-->
						<div class="form-group">
							<label for="subjectName" class="col-sm-4 control-label">Emri i Subjectit:</label>
							<div class="col-sm-8">
								<input type="text" id="subjectName" name="subjectName" class="form-control" placeholder="Emri i Subjectit">
							</div>
						</div>
						<div class="form-group">
							<label for="totalMark" class="col-sm-4 control-label">Nota Totale:</label>
							<div class="col-sm-8">
								<input type="text" id="totalMark" name="totalMark" class="form-control" placeholder="Nota Totale">
							</div>
						</div>
						<!------------------------------------------------------------>
						<div class="form-group">
							<label for="teacherName" class="col-sm-4 control-label">Profesori:</label>
							<div class="col-sm-8">
								<select value="" class="form-control" name="teacherName" id="teacherName">
									<option value=""> Zgjedh Profesorin</option>
									<?php
									if($teacherData)
									{
										foreach ($teacherData as $key=>$value)
										{
											?>
											<option value="<?php echo $value['teacher_id']?>"><?php echo $value['fname'] .' '.$value['lname']?></option>
											<?php
										}

									}else{
										?><option value=""> Nuk ka asnje profesor te shtuar</option><?php
									}
									?>
								</select>
							</div>
						</div>



					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-success">Ruaj Ndryshimin</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--Moduli per editimin e Sectiionit po ashtu ekzekutohet permes buttoni ne section dhe bene te munudur dergimin e te dhenav permes inputit-->
	<div class="modal fade" tabindex="-1" role="dialog" id="editSubjectModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edito Section</h4>
				</div>
				<form class="form-horizontal" method="post" id="editSubjectForm" action="<?php echo base_url().'subject/update'?>">
					<div class="modal-body">
						<div id="edit-subject-message"></div><!--Shfaqja e mesazhit-->
						<!--Form grupi-->
						<div class="form-group">
							<label for="editSubjectName" class="col-sm-4 control-label">Emri i Subject:</label>
							<div class="col-sm-8">
								<input type="text" id="editSubjectName" name="editSubjectName" class="form-control" placeholder="Emri i Subject">
							</div>
						</div>
						<div class="form-group">
							<label for="editTotalMark" class="col-sm-4 control-label">Nota Totale:</label>
							<div class="col-sm-8">
								<input type="text" id="editTotalMark" name="editTotalMark" class="form-control" placeholder="notaTotale">
							</div>
						</div>
						<!------------------------------------------------------------>
						<div class="form-group">
							<label for="editTeacherName" class="col-sm-4 control-label">Profesori:</label>
							<div class="col-sm-8">
								<select value="" class="form-control" name="editTeacherName" id="editTeacherName">
									<option value=""> Zgjedh Profesorin</option>
									<?php
									if($teacherData)
									{
										foreach ($teacherData as $key=>$value)
										{
											?>
											<option value="<?php echo $value['teacher_id']?>"><?php echo $value['fname'] .' '.$value['lname']?></option>
											<?php
										}

									}else{
										?><option value=""> Nuk ka asnje profesor te shtuar</option><?php
									}
									?>
								</select>
							</div>
						</div>
					</div><!-- /.modal-content -->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-success">Ruaj Ndryshimin</button>
					</div>
				</form>
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<!--Fshirja e subject realizohet permes buttonit i cili asht ne subject dhe bene te mundur fshrijen e subjectit i shfaq nje lajmrim-->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeSubjectModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Fshirja e Subjectit</h4>
				</div>
				<div class="modal-body">
					<div id="remove-subject-message"></div><!--Shfaqja e mesazhit-->
					<p>A jeni i sigurt per fshirjen e Subjectit</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="mbyll" data-dismiss="modal">Mbyll</button>
					<button type="submit" name="removeBtnSubject" id="removeBtnSubject" class="btn btn-danger">Po</button>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--JavaScript extenal file--------------------------------------------------------------------->
	<script type="text/javascript" src="<?php echo base_url('custom/js/subject.js')?>"></script>

