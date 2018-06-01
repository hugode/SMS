<?php if ($this->input->get('opt')=='' || !$this->input->get('opt'))
{show_404();}?>
<div id="kerkesa" style="display: none;"><?php echo $this->input->get('opt');?></div>
<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<?php
	if($this->input->get('opt')=='mngms')
	{echo ' <li class="active">Menagjo Marksheet</li>';}
	else if ($this->input->get('opt')=='mngmk')
	{echo ' <li class="active">Menagjo Marks</li>';}
	?>
</ol>
<?php if($this->input->get('opt')=='mngms'){?>
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading " ><h4><b>Klaset Aktuale te Regjistruara<b></h4></div>
			<ul class="nav nav-pills nav-stacked">
				<?php if($classData) {
					$x=1;
					foreach ($classData as $value){
						?>
						<li role="presentation"><a role="tab" data-toggle="tab" class="list-group-item classSideBar"  id="classId<?php echo$value['class_id']?>"
												   onclick="getClassMarksheet(<?php echo$value['class_id']?>)"><b><!--fUNKSIONI getClassmarksheet e perdorim kur ta ndrrojm klasen te
						ekzekutohet qaj funksion me qit id te shfaq te dhana-->
									<?php echo $value['class_name'] ?>(<?php echo $value['numeric_name']?>)
								</b></a></li>
						<?php
						$x++;
					}
				} else{
					?>
					<a href="" class="list-group-item">No data</a>
					<?php
				} ?>
			</ul>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Menage Marksheet</div>
			<div class="panel-body">
				<div id="message"></div>
				<div class="result">
					<!--Ne kete div class result shfaqen te gjitha te dhenat te cilat vin prej funksionit getClassmarksheet()
					ku bene te mundur permes class id te shfaqen te gjith marksheet te cilat kane kete classid-->
				</div>
			</div>
	</div>
</div>
</div>
	<!--Modeli per te krijuar nje marksheet-->
	<div class="modal fade" tabindex="-1" role="dialog" id="addMarksheetModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Shto Marksheet</h4>
				</div>
				<form class="form-horizontal" method="post" id="createMarksheetForm" action="<?php echo base_url('marksheet/create')?>">
					<div class="modal-body">
						<div id="add-marksheet-message"></div><!--Shfaqja e mesazhit-->
						<!--Form grupi-->
						<div class="form-group">
							<label for="marksheetName" class="col-sm-4 control-label">Emri i marksheet:</label>
							<div class="col-sm-8">
								<input type="text" id="marksheetName" name="marksheetName" class="form-control" placeholder="Emri i marksheet">
							</div>
						</div>
						<!------------------------------------------------------------------------------------------------>
						<div class="form-group">
							<label for="examDate" class="col-sm-4 control-label">Data e exam:</label>
							<div class="col-sm-8">
								<input type="text" id="examDate" name="examDate" class="form-control" placeholder="Data e marksheet">
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
	<!--Modeli per editimin e  marksheet-->
	<div class="modal fade" tabindex="-1" role="dialog" id="editMarksheetModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edito Marksheet</h4>
				</div>
				<form class="form-horizontal" method="post" id="editMarksheetForm" action="<?php echo base_url().'marksheet/update'?>">
					<div class="modal-body">
						<div id="edit-marksheet-message"></div><!--Shfaqja e mesazhit-->
						<!--Form grupi-->
						<div class="form-group">
							<label for="editMarksheetName" class="col-sm-4 control-label">Emri i marksheet`:</label>
							<div class="col-sm-8">
								<input type="text" id="editMarksheetName" name="editMarksheetName" class="form-control" placeholder="Emri i marksheet`">
							</div>
						</div>
						<!------------------------------------------------------------>
						<div class="form-group">
							<!--<label for="editTeacherName" class="col-sm-4 control-label">Profesori:</label>-->
							<div class="col-sm-8">
								<!--<select value="" class="form-control" name="editTeacherName" id="editTeacherName">
									<option value=""> Zgjedh Profesorin</option>
									<?php
/*									if($teacherData)
									{
										foreach ($teacherData as $key=>$value)
										{
											*/?>
											<option value="<?php /*echo $value['teacher_id']*/?>"><?php /*echo $value['fname'] .' '.$value['lname']*/?></option>
											<?php
/*										}

									}else{
										*/?><option value=""> Nuk ka asnje profesor te shtuar</option><?php
/*									}
									*/?>
								</select>-->
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
	<!--Modeli per fshirjen e marksheet-->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeMarksheetModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Fshirja e Markshet</h4>
				</div>
				<div class="modal-body">
					<div id="remove-marksheet-message"></div><!--Shfaqja e mesazhit-->
					<p>A jeni i sigurt per fshirjen e Marksheet</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="mbyll" data-dismiss="modal">Mbyll</button>
					<button type="submit" name="removeBtnMarksheet" id="removeBtnMarksheet" class="btn btn-danger">Po</button>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


<?php
}else if( $this->input->get('opt')=='mngmk'){


}?>

<script type="text/javascript" src="custom/js/marksheet.js"></script>
