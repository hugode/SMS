<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $title;?></title>
	<!--Bootstrap exteneal i jashtem i css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>">

	<!--Bootstrap thema hhe-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap-theme.css')?>">

	<!--Css i zhviluar Custum Css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/custom.css')?>">

	<!--jquery-->
	<script type="text/javascript" src="<?php echo base_url("assets\jquery\jquery.min.js")?>"></script>

	<!--bootstrap prej js-->
</head>
<body style="background-image:url('assets/images/ubt.jpg');">
    <div class="col-md-4 col-md-offset-4 vertical-off-4">
		<div class="panel panel-default login-form">
			<div class="panel-body">
				<!--Ketu kemi krejuar nje login form per te u qasur ne smis-->
				<form action="<?php echo base_url("users/login")?>" method="post" id="loginForm">
					<fieldset>
						<legend>Login</legend>
					</fieldset>
					<div id="message"></div>

					<div class="form-group">
						<!--Nje inpur username-->
						<label for="username">Username</label>
						<input type="text" name="username" id="username" placeholder="Username" class="form-control"autofocus >
					</div>
					<div class="form-group">
						<!--Nje input Password-->
						<label for="password">Password</label>
						<input type="password" name="password" id="password" placeholder="password" class="form-control"autofocus >
					</div>
					<!--Dhe nje submit button -->
					<button type="submit" class="col-md-12 btn btn-success login-button">Submit</button>

				</form>
				<!--Te gjitha keto jane te dizajnuara nga bootstrap css-->

			</div>

		</div>

	</div>
<script type="text/javascript" src="<?php echo base_url("custom\js\login.js")?>"></script>
</body>
</html>
