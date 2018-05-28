<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Menagjo Settings</li>
</ol>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel panel-heading"style="text-align: center;">Menagjimi i Settings</div>
				<div class="panel panel-body" style="border: 1px solid black;">
					<!--Shfaqja e Mesazhit-->
					<div class="col-md-12">
						<div id="update-profile-message"></div>
					</div>
					<!--Shfaqja e te dhenav-->
					<div class="col-md-6">
						<form action="<?php echo base_url('users/updateProfile') ?> " method="post" id="updateProfilForm">
							<fieldset>
								<legend>Menagjo te Dhenat</legend>
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" name="username" class="form-control" id="username" placeholder="Username"
										   value="<?php echo $userdata['username']?>" >
								</div>
								<div class="form-group">
									<label for="fname">First Name</label>
									<input type="text" name="fname" class="form-control" id="fname" placeholder="Frist Name"
										   value="<?php echo $userdata['fname']?>" >
								</div>
								<div class="form-group">
									<label for="lname">Last Name</label>
									<input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name"
										   value="<?php echo $userdata['lname']?>" >
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" name="email" class="form-control" id="email" placeholder="Email"
										   value="<?php echo $userdata['email']?>" >
								</div>
								<button class="btn btn-primary" type="submit">Ruaj Ndryshimet</button>

							</fieldset>

						</form>
					</div>
					<!------------------------------------------------------>
					<div class="col-md-6">
						<form action="<?php echo base_url('users/changePassword') ?> " method="post" id="changePasswordForm">
							<fieldset>
								<!--Passwordi actual-->
								<legend>Ndrysho Passwordin</legend>
								<div class="form-group">
									<label for="currentPassword">Current Password</label>
									<input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Current Password" >
								</div>
								<!--Passwordi i ri-->
								<div class="form-group">
									<label for="newPassword">New Password</label>
									<input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="New Password"  >
								</div>
								<!--Passwordi i confirmuar-->
								<div class="form-group">
									<label for="confirmPassword">Confirm Password</label>
									<input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password"  >
								</div>
								<button class="btn btn-primary" type="submit">Ndrysho Passwordin</button>

							</fieldset>
						</form>

					</div>

				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#updateProfilForm").unbind('submit').bind('submit',function(){
			var form=$(this);
			var url=form.attr('action');
			var type=form.attr('method');
			$.ajax({
				url:url,
				type:type,
				data:form.serialize(),
				dataType:'json',
				success:function (response) {
					if(response.success==true){
						$('#update-profile-message').html('<div class="alert alert-success alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();

					}
					else{
							$.each(response.message,function (index,value){
								var key=$("#"+index);
								key.closest(".form-group")
									.removeClass('has-error')
									.removeClass('has-success')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('.text-danger').remove();

								key.after(value);
							});
					}

				}
			});

			return false;
		});
		/*Kjo ne kete form shfaqen mesazhet per ndryshimin e passwordid kurse forma ma nelt per ndryshimet e infomacionit*/
		$("#changePasswordForm").unbind('submit').bind('submit',function(){
			var form=$(this);
			var url=form.attr('action');
			var type=form.attr('method');
			$.ajax({
				url:url,
				type:type,
				data:form.serialize(),
				dataType:'json',
				success:function (response) {
					if(response.success==true){
						$('#update-profile-message').html('<div class="alert alert-success alert-dismissible" role="alert">'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							response.message+
							'</div>');
						$('.text-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();

					}
					else{
						$.each(response.message,function (index,value){
							var key=$("#"+index);
							key.closest(".form-group")
								.removeClass('has-error')
								.removeClass('has-success')
								.addClass(value.length > 0 ? 'has-error' : 'has-success')
								.find('.text-danger').remove();

							key.after(value);
						});
					}

				}
			});

			return false;
		});

	})


</script>
