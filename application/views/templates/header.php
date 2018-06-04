<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $title;?></title>
	<!--Bootstrap exteneal i jashtem i css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>">

	<!--Bootstrap thema hhe-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap-theme.css')?>">
	<!--keith calendar-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/keith-calendar/css/jquery.calendars.picker.css')?>">
	<!--File input plugin-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fileinput/css/fileinput.min.css')?>">

	<!--DATA tables css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css')?>">

	<!--Css i zhviluar Custum Css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/custom.css')?>">

	<!--jquery-->
	<script type="text/javascript" src="<?php echo base_url("assets\jquery\jquery.min.js")?>"></script>

	<!--bootstrap prej js-->
	<script type="text/javascript" src="<?php echo base_url("assets\bootstrap\js\bootstrap.js")?>"></script>
	<!--datatables prej js-->
	<script type="text/javascript" src="<?php echo base_url("assets/datatables/datatables.min.js")?>"></script>
	<!--datatables prej js--------------------------------------------------------------------------------------------------->
	<script type="text/javascript" src="<?php echo base_url("assets/keith-calendar/js/jquery.calendars.js")?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/keith-calendar/js/jquery.calendars.plus.js")?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/keith-calendar/js/jquery.plugin.js")?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/keith-calendar/js/jquery.calendars.picker.js")?>"></script>
	<!-----------------------------------------File Input js------------------------------------------------------------------------------->
	<script type="text/javascript" src="<?php echo base_url("assets/fileinput/js/fileinput.min.js")?>"></script>
	<!------------------------------------------------------------------------------------------------------------------------>



</head>
<body>
<input type="hidden" id="base_url" value="<?php echo base_url()?>">
<nav class="navbar navbar-default">
	<div class="container-flud">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url('dashboard')?>" style="color: white;">UBT SMS</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo base_url('dashboard')?>"><i class="glyphicon glyphicon-dashboard"></i>Dashboard</a></li>
				<!----------------------------------------------Faqja Clases---------------------------------------------------------------------------------------------------->
				<li class="dropdown" id="topClassMainNav">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="glyphicon glyphicon-edit"></i>Classes <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li id="topNavClass"><a href="<?php echo base_url('classes')?>">Manage Class</a></li>
						<li id="topNavClass"><a href="<?php echo base_url('section')?>">Mange Section</a></li>
						<li id="topNavClass"><a href="<?php echo base_url('subject')?>">Manage Subject</a></li>

					</ul>
				</li>
				<!----------------------------------------------Faqja Studenti---------------------------------------------------------------------------------------------------->
				<li class="dropdown" id="topStudentMainNav">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="glyphicon glyphicon-list-alt"></i>Studenti <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li id="addStudentNav"><a href="<?php echo base_url('student?opt=addst')?>">Add Student</a></li>
						<li id="addBulkStudentNav"><a href="<?php echo base_url('student?opt=bulkst')?>">Add More Student</a></li>
						<li id="manageStudentNav"><a href="<?php echo base_url('student?opt=mgst')?>">Manage Student</a></li>

					</ul>
				</li>
				<!----------------------------------------------Faqja e Teacher---------------------------------------------------------------------------------------------------->
				<li id="topTeacherMainNav">
					<a href="<?php echo base_url('teacher') ?>">
						<i class="glyphicon glyphicon-briefcase"></i>Teacher </a>
				</li>
				<!----------------------------------------------Faqja e Pjesmarrjes---------------------------------------------------------------------------------------------------->
				<li class="dropdown" id="topAttendanceMainNav">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="glyphicon glyphicon-time"></i>Attendance <span class="caret"></span></a>
					<ul class="dropdown-menu">

						<li id="takeAttendNav"><a href="<?php echo base_url('attendance?atd=add	')?>">Krijo Pjesmarrjen</a></li>
						<li id="attenReport"><a href="<?php echo base_url('attendance?atd=report')?>">Raporti i Pjesmarrjes</a></li>

					</ul>
				</li>
				<!----------------------------------------------Faqja e Flet Shenimit---------------------------------------------------------------------------------------------------->
				<li class="dropdown" id="topMarksheetMainNav">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="glyphicon glyphicon-duplicate"></i>Marksheet <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li id="manageMarksheet"><a href="<?php echo base_url('marksheet?opt=mngms')?>">Manage Marksheet</a></li>
						<li id="manageMarks"><a href="<?php echo base_url('marksheet?opt=mngmk')?>">Mange Marks</a></li>

					</ul>
				</li>
				<!----------------------------------------------Faqja e Kontabilistit---------------------------------------------------------------------------------------------------->
				<li class="dropdown" id="topAccountingMainNav">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="glyphicon glyphicon-indent-left"></i>Accounting <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li id="createStudentNav"><a href="<?php echo base_url('accounting?opt=crtpay')?>">Create Student Payment</a></li>
						<li id="managePayNav"><a href="<?php echo base_url('accounting?opt=mgpay')?>">Manage Payment</a></li>
						<li id="expNav"><a href="<?php echo base_url('accounting?opt=mgexp')?>">Expenses</a></li>
						<li id="incomeNav"><a href="<?php echo base_url('accounting?opt=ime')?>">Income</a></li>

					</ul>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> <b><?php echo $userdata['fname'].' '.$userdata['lname']?></b><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('setting')?>">Setting</a></li>
						<li><a href="<?php echo base_url('users/logout')?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">

