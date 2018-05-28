<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Manage Teacher</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">Teacher</div>
	<div class="panel-body">
		<fieldset>
			<legend>Manage Teacher</legend>
		</fieldset>
		<div id="message"></div>

		<div class="pull pull-right">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTeacher" id="addTeacherModelBtn" >
				<i class="glyphicon glyphicon-plus-sign"></i> Add Teacher
			</button>
		</div>
		<br/><br/><br/><br/><br/>
		<table id="manageTeacherTable" class="table table-responsive table-bordered">
			<thead>
			      <tr>
					  <th>ID</th>
					  <th>Name</th>
					  <th>Age</th>
					  <th>Contact</th>
					  <th>Email</th>
					  <th>Action</th>

				  </tr>

			</thead>
		</table>
	</div>
</div>
<!--Shto Teacher Model---------------------------------------------------------------------->
<div class="modal fade"  tabindex="-1" role="dialog" id="addTeacher">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Shto Profesorin </h4>
			</div>
			<!--Boduy-->
			<form class="form-horizontal" method="post" id="createTeacherForm" action="<?php echo base_url('teacher/create')?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div id="add-teacher-messages"></div>
					<!--------------------------------->
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">

								<div class="form-group">
									<label for="fname" class="col-sm-4 control-label">Emri:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="fname" name="fname" placeholder="Sheno Emrin"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="lname" class="col-sm-4  control-label">Mbiemri:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="lname" name="lname" placeholder="Sheno Mbiemrin"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="age" class="col-sm-4 control-label">Mosha:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="age" name="age" placeholder="Age"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="dob" class="col-sm-4  control-label">Data e Lindjes:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="dob" name="dob" placeholder="DOB"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="contact" class="col-sm-4  control-label">Kontakti:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="contact" name="contact" placeholder="Contact"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="email" class="col-sm-4  control-label">Email:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="email" name="email" placeholder="Email"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="address" class="col-sm-4  control-label">Adresa:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="address" name="address" placeholder="Addressa"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="city" class="col-sm-4  control-label">Qyteti:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="city" name="city" placeholder="City"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
								<div class="form-group">
									<label for="country" class="col-sm-4  control-label">Shteti:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="country" name="country" placeholder="Country"/>
									</div>
								</div>
								<!------------------------------------------------------------------------------------------------------------------------>
							</div>
							<!--c----------------------------------------------------------------------ol-md-6------------------------------------------------>
							<div class="col-md-6">
								<div class="form-group">
									<label for="registerDate" class="col-sm-4  control-label">Register Date:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="registerDate" name="registerDate" placeholder="Register Date"/>
									</div>
								</div>
								<!----------------------------------------------------------------------------------------------------------------------->
								<div class="form-group">
									<label for="jobType" class="col-sm-4  control-label">Loji i Punes:</label>
									<div class="col-sm-8">
										<select class="form-control" id="jobType" name="jobType">
											<option value="">Select a value</option>
											<option value="1">Full Time</option>
											<option value="2">Part Time</option>
										</select>
									</div>
								</div>
								<!----------------------------------------------------------------------------------------------------------------------->
								<div class="form-group">
									<label for="photo" class="col-sm-4  control-label">Photo:</label>
									<div class="col-sm-8">
										<div id="kv-avatar-errors-1" class="center-block" style="max-width: 500px;display: none;"></div>
										<div class="kv-avatar center-block" style="width: 100%;">
										       <input type="file"  id="photo" name="photo" class="file-loading" />
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" class="btn btn-success">Ruaj</button>
				</div>
			</form>
			<!--Footer-->
		</div>
	</div>
</div>

<!--Edit Profesorin Model------------------------------------------------------------------->
<div class="modal fade"  tabindex="-1" role="dialog" id="updateTeacherModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edito Profesorin </h4>
			</div>
			<!--Boduy-->

				<div class="modal-body">
					<div id="edit-teacher-messages"></div>
					<!-----------------tabs of nav---------------->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Photo</a> </li>
						<li role="presentation"  ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Personal</a> </li>
					</ul>
					<div class="tab-content">
						<br/>
						<div role="tabpanel" class="tab-pane active" id="home">
							<form class="form-horizontal" method="post" id="updateTeacherPhotoForm" action="<?php echo base_url('teacher/updatePhoto')?>"
							enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-6">
											<center>

												<img src="" id="teacher_photo" alt="Teacher Photo"style="width: 70%;height: 50%;" class="img-thumbnail">
											</center>

										</div>


										<!--c----------------------------------------------------------------------ol-md-6------------------------------------------------>
										<div class="col-md-6">
											<div class="form-group">
												<label for="editPhoto" class="col-sm-4  control-label">Foto e Re:</label>
												<div class="col-sm-8">
													<div id="kv-avatar-errors-1" class="center-block" style="max-width: 500px;display: none;"></div>
													<div class="kv-avatar center-block" style="width: 100%;">
														<input type="file"  id="editPhoto" name="editPhoto" class="file-loading" />
													</div>
												</div>
											</div>

										</div>

									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Mbyll</button>
									<button type="submit" name="submit" class="btn btn-success">Ndrysho</button>
								</div>


							</form>
						</div>
						<div role="tabpanel" class="tab-pane " id="profile">
							<form class="form-horizontal" method="post" action="<?php echo base_url('teacher/updateInfo')?>" id="updateTeacherInfo">
								<div class="row">
									<div class="col-md-12">
										<div id="editInfo-teacher-messages"></div>
									</div>
									<div class="col-md-12">
										<div class="col-md-6">

											<div class="form-group">
												<label for="editFname" class="col-sm-4 control-label">Emri:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editFname" name="editFname" placeholder="Sheno Emrin"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editLname" class="col-sm-4  control-label">Mbiemri:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editLname" name="editLname" placeholder="Sheno Mbiemrin"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editAge" class="col-sm-4 control-label">Mosha:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editAge" name="editAge" placeholder="Age"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editDob" class="col-sm-4  control-label">Data e Lindjes:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editDob" name="editDob" placeholder="DOB"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editContact" class="col-sm-4  control-label">Kontakti:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editContact" name="editContact" placeholder="Contact"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editEmail" class="col-sm-4  control-label">Email:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editAddress" class="col-sm-4  control-label">Adresa:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editAddress" name="editAddress" placeholder="Addressa"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editCity" class="col-sm-4  control-label">Qyteti:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editCity" name="editCity" placeholder="City"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
											<div class="form-group">
												<label for="editCountry" class="col-sm-4  control-label">Shteti:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editCountry" name="editCountry" placeholder="Country"/>
												</div>
											</div>
											<!------------------------------------------------------------------------------------------------------------------------>
										</div>
										<!--Left information-->
										<div class="col-md-6">
											<div class="form-group">
												<label for="editRegisterDate" class="col-sm-4  control-label">Register Date:</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="editRegisterDate" name="editRegisterDate" placeholder="Register Date"/>
												</div>
											</div>
											<!----------------------------------------------------------------------------------------------------------------------->
											<div class="form-group">
												<label for="editJobType" class="col-sm-4  control-label">Loji i Punes:</label>
												<div class="col-sm-8">
													<select class="form-control" id="editJobType" name="editJobType">
														<option value="">Select a value</option>
														<option value="1">Full Time</option>
														<option value="2">Part Time</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group left">
												<div class="col-sm-offset-2 col-md-10 left">
													<center>
														<button type="button" class="btn btn-default" data-dismiss="modal">Mbyll</button>
														<button type="submit"  name="submit" class="btn btn-success">Ndrysho</button>
													</center>
												</div>
											</div>
										</div>


										<!--Buttons-->

									</div>
								</div>

							</form>
						</div>
					</div>

				</div>


			<!--Footer-->
		</div>
	</div>
</div>

<!--Fshije Profesorin----------------------------------------------------------------------->
<div class="modal fade"  tabindex="-1" role="dialog" id="removeTeacherModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Fshije Profesorin </h4>
			</div>
			<!--Boduy-->
				<div class="modal-body">
					<div id="remove-message"></div>
					<p>A jeni i sigurt qe deshironi te fshini kete Profesor?</p>
					<!--------------------------------->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Mbyll</button>
					<button type="submit" name="submit" class="btn btn-danger" id="removeTeacherBtn">Po</button>
				</div>
			<!--Footer-->
		</div>
	</div>
</div>
<!------------------------------------------------------------------------------------------>
<script type="text/javascript" src="<?php echo base_url('custom/js/teacher.js')?>"></script>


