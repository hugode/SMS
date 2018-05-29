<?php if ($this->input->get('atd')=='' || !$this->input->get('atd'))
{
	show_404();
}?>
<div id="kerkesa" style="display: none;"><?php echo $this->input->get('atd');?></div>
<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<?php
	if($this->input->get('atd')=='add')
	{echo ' <li class="active">Pjesmarrja</li>';}
	else if ($this->input->get('atd')=='report')
	{echo ' <li class="active">Raporti i Pjesmarrjes</li>';}
	?>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<?php
		if($this->input->get('atd')=='add')
		{echo 'Pjesmarrja';}
		else if ($this->input->get('atd')=='report')
		{echo 'Raporti i Pjesmarrjes';}
		?>
	</div>
	<div class="panel-body">
		<?php
		/*Gjdo gje perfuni keti if do te sherbej per modulin shto pjessmarrje*/
		if($this->input->get('atd')=='add'){
			?>
			<form class="form-horizontal" method="post" id="getAttendanceForm">
				<div class="form-group">
					<label for="type" class="col-sm-3 control-label">Zgjedh llojin</label>
					<div class="col-md-4">
						<!--Select form for add Attendance-->
						<select class="form-control" name="type" id="type">
							<option value="">Select</option>
							<option value="1">Student</option>
							<option value="2">Profesor</option>
						</select>
					</div>
				</div>
				<div class="result">

				</div>
			</form>
			<div  id="attendance-result"></div>

			<?php
		}
		else if ($this->input->get('atd') == 'report') {
			// echo "report";
			?>
			<form class="form-horizontal" method="post" id="getAttendanceReport" action="<?php echo base_url('attendance/report')?>">
				<div class="form-group">
					<label for="type" class="col-sm-2 control-label">Select Type</label>
					<div class="col-sm-4">
						<!--Select form for getAttendance-->
						<select class="form-control" name="type" id="type">
							<option value="">Select</option>
							<option value="1">Student</option>
							<option value="2">Teacher</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="type" class="col-sm-2 control-label">Date</label>
					<div class="col-sm-4">
						<input type="text" name="reportDate" id="reportDate" autocomplete="off" class="form-control" placeholder="Date"/>
					</div>
				</div>
				<div id="student-form"></div>

				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<input type="hidden" name="num_of_days" id="num_of_days" autocomplete="off" />
						<button type="submit" class="btn btn-success">Ruaj</button>
					</div>
				</div>
			</form>

			<div id="report-div"></div><!--Gjdo gje do te shfaqet ketu nga js jquery-->
			<?php
		} // /report
		?>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('custom/js/attendance.js')?>"></script>
