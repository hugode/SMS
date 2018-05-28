<?php if ($this->input->get('opt')=='' || !$this->input->get('opt'))
{
	show_404();
}?>
<div id="kerkesa" style="display: none;"><?php echo $this->input->get('opt');?></div>
<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	 <?php
	 if($this->input->get('opt')=='addst')
	 {echo ' <li class="active">Shto Student</li>';}
	 else if ($this->input->get('opt')=='bulkst')
	 {echo ' <li class="active">Add bulk student</li>';}
	 else if($this->input->get('opt')=='mgst')
	 {echo '<li class="active">Menagjo Studentat</li>';}
	 ?>
</ol>
<!--Gjdo gje perfuni keti ifi do te jete per te shtuar studenata ka nja dhe me shumirc-->
<?php if($this->input->get('opt')=='addst' || $this->input->get('opt')=='bulkst'){?>
	<style>
		.krajee-default.file-preview-frame .kv-file-content {
			width: 317px;
			height: 177px;
		}
	</style>
<div class="panel panel-default">
	<div id="add-student-message"></div>
	<div class="panel-heading">
		       <?php
	           if($this->input->get('opt')=='addst')
	           {
	           	echo ' <li class="active">Shto Student</li>';
	           }
	           else if ($this->input->get('opt')=='bulkst')
	           {
	           	echo ' <li class="active" style="text-align: center;"><b>Shto Grup Studentash</b></li>';
	           } ?>
	</div>
	<div class="panel-body">
		<?php
		/*-------------------------------------Pjesa e fillimit  per add student---------------------------------------------------------------*/
		if($this->input->get('opt')=='addst') { ?>
			<form action="<?php echo base_url('student/create')?>" method="post" id="createStudentForm" enctype="multipart/form-data" >
				<div class="col-md-offset-1">
				<div class="col-md-6">
					<fieldset>
						<legend> Student Info</legend>
					</fieldset>
					<!--------------------------Name----------------------------------------------------------->
					<div class="form-group">
						<label for="fname">Emri</label>
						<input type="text" class="form-control" id="fname" name="fname" placeholder="Emri">
					</div>
					<!--------------------------Mbiemri----------------------------------------------------------->
					<div class="form-group">
						<label for="lname">Mbiemri</label>
						<input type="text" class="form-control" id="lname" name="lname" placeholder="Mbiemri">
					</div>
					<!--------------------------Data lindjes----------------------------------------------------------->
					<div class="form-group">
						<label for="dob">Data e Lindjes</label>
						<input type="text" class="form-control" id="dob" name="dob" placeholder="Data e Lindjes">
					</div>
					<!--------------------------Mosha----------------------------------------------------------->
					<div class="form-group">
						<label for="age">Mosha</label>
						<input type="text" class="form-control" id="age" name="age" placeholder="Mosha">
					</div>
					<!--------------------------Kontakti----------------------------------------------------------->
					<div class="form-group">
						<label for="contact">Kontakt</label>
						<input type="text" class="form-control" id="contact" name="contact" placeholder="Kontakti">
					</div>
					<!--------------------------Kontakti----------------------------------------------------------->
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
					<!--------------------------ADRESA----------------------------------------------------------->
					<div class="form-group">
						<label for="address">Adresa</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="Adresa">
					</div>
					<!--------------------------qYTETI----------------------------------------------------------->
					<div class="form-group">
						<label for="city">Qyteti</label>
						<input type="text" class="form-control" id="city" name="city" placeholder="Qyteti">
					</div>
					<!--------------------------SHTETI----------------------------------------------------------->
					<div class="form-group">
						<label for="country">Shteti</label>
						<input type="text" class="form-control" id="country" name="country" placeholder="Shteti">
					</div>

				</div>

				<!--Col md 6-->
				<div class="col-md-4">
					<fieldset>
						<legend>Register Info</legend>
					</fieldset>
					<!--------------------------Data e regjistrimijn----------------------------------------------------------->
					<div class="form-group">
						<label for="registerDate">Data e Regjistrimin</label>
						<input type="text" class="form-control" id="registerDate" name="registerDate" placeholder="Data e regjistrimin">
					</div>
					<!--------------------------Klasa---------------------------------------------------------------------------->
					<div class="form-group">
						<label for="class">Klasa</label>
						<select class="form-control" name="className" id="className">
							<option value="">Select</option>
							<?php if($classData){
								foreach ($classData as $key =>$value){?>
									<option value="<?php echo $value['class_id']?>"><?php echo $value['class_name'].' ('.$value['numeric_name'].')'?></option>
								<?php }?>
							<?php } ?>
						</select>
					</div>
					<!--------------------------Sectioni------------------------------------------------------------------------->
					<div class="form-group">
						<label for="section">Section</label>
						<select class="form-control" name="sectionName" id="sectionName" >
							<option value="">Select</option>
						</select>
					</div>
					<!---------------------------------------------------------------Foto-->
					<fieldset>
						<legend>Foto</legend>
						<div class="form-group">
							<div class="col-sm-8">
								<div id="kv-avatar-errors-1" class="center-block" style="max-width: 500px;display: none;"></div>
								<div class="kv-avatar center-block" style="width: 158%;">
									<input type="file"  id="photo" name="photo" class="file-loading"style="" />
								</div>
						</div>

					</fieldset>
					<br/><br/><br/><br/>
					<div class="panel-footer">
						<center>
						<button type="button" class="btn btn-default" onclick="clearForm();" data-dismiss="modal">Reset Field</button>
						<button type="submit" name="submit" class="btn btn-success">Ruaj Studentin</button>
						</center>
						</div>

				</div>
				</div>

				<!--Col md 6-->

			</form>

		<!-----------------------------------Pjesa e mbarimit te shto studentin---------------------------------------------------------------->

			<!-------------------------Pjesa e fillimit  bulk student---------------------------------------------------------------------- --->
		<?php } else if ($this->input->get('opt')=='bulkst') { ?>

			<form action="<?php echo base_url('student/createBulk')?>" method="post" id="createBulkForm">
				<div id="add-bulk-student-message"></div>
				<center>
					 <button type="button" class="btn btn-default" onclick="addRow()">Add Row</button>
					 <button type="submit" class="btn btn-primary">Ruaj</button>
				 </center>

			<br/><br/>
			<!--Table-->
			<table class="table" id="addBulkStudentTable">
				<thead>
				    <tr>
					    <td style="width: 20%;"><b>Emri</b></td>
						<td style="width: 20%;"><b>Mbiemri</b></td>
						<td style="width: 20%;"><b>Kalsa</b></td>
						<td style="width: 20%;"><b>Section</b></td>
						<td style="width: 4%;"><b>Action</b></td>
				    </tr>
				</thead>
				<tbody>
				    <?php for ($x=1; $x<4; $x++){?>
						<tr id="row<?php echo $x;?>">
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="bulkstfname<?php echo $x;?>" name="bulkstfname[<?php echo $x;?>]" placeholder="Emri">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="bulkstlname<?php echo $x;?>" name="bulkstlname[<?php echo $x;?>]" placeholder="Mbiemri	">
								</div>
							</td>
							<td>
								<div class="form-group">
									<select class="form-control" name="bulkstclassName[<?php echo $x;?>]" id="bulkstclassName<?php echo $x;?>"
											onchange="getSelectClassSection(<?php echo $x;?>)">
										<option value="">Select</option>
										<?php if($classData){
											foreach ($classData as $key =>$value){?>
												<option value="<?php echo $value['class_id']?>"><?php echo $value['class_name'].' ('.$value['numeric_name'].')'?></option>
											<?php }?>
										<?php } ?>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<select class="form-control" name="bulkstsectionName[<?php echo $x;?>]" id="bulkstsectionName<?php echo $x;?>" >
										<option value="">Select</option>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<button type="button" class="btn btn-danger" onclick="removeRow(<?php echo $x;?>)"><i class="glyphicon glyphicon-trash"></i></button>
								</div>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			 </form>
		<?php } ?>
		<!---------------------------Pjesa e mbarmit te bul student----------------------------------------------------------------------------->

	</div>
</div>
	<!-------------------------------------------------------Menagjimi i Studentatav------------------------------------------------------------>
<?php }/*Kjo pjes ka me kan vetum per me shtu ni student edhe per me shtu shum studenta perniheri*/
else if($this->input->get('opt')=='mgst'){?>
<!--Gjdo gja mnbrena keti else if do te jete per menagjimin e studentav-->
<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading"><h4 class=""><b><a href="<?php echo base_url('classes')?>" class="active">Klaset Aktuale</a><b></h4></div>

                   <!--kLASAT E SHFAQURA AKTUALE -->
			<ul class="nav nav-pills nav-stacked">
				<?php if($classData) {
					$x=1;
					foreach ($classData as $value){
						?>
						<li role="presentation"><a role="tab" data-toggle="tab" class="list-group-item classSideBar"  id="classId<?php echo$value['class_id']?> "
						   onclick="getClassSection(<?php echo$value['class_id']?>)"><b><!--fUNKSIONI getClassSection e perdorim kur ta ndrrojm klasen te
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
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">Menagjo Studentat</div>
			<div class="panel-body">
				<div id="message"></div>
				<div class="result">
					<!--Ne kete div class result shfaqen te gjitha te dhenat te cilat vin prej funksionit getClassSection()
					ku bene te mundur permes class id te shfaqen te gjith section te cilat kane kete classid-->
				</div>
			</div>
		</div>
	</div>
</div>
<!--Model per editimin e Studentit------------------------------------------------------------------------------------>
<div class="modal fade"  tabindex="-1" role="dialog" id="updateStudentModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edito Studentin </h4>
			</div>
			<!--Boduy-->

			<div class="modal-body">
				<div id="student-messages"></div>
				<!-----------------tabs of nav---------------->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Photo</a> </li>
					<li role="presentation"  ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Personal</a> </li>
				</ul>
				<div class="tab-content">
					<br/>
					<div role="tabpanel" class="tab-pane active" id="home">
						<form class="form-horizontal" method="post" id="updateStudentPhotoForm" action="<?php echo base_url('student/updatePhoto')?>"
							  enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6">
										<center>
											<img src="" id="student_photo" alt="Student Photo"style="width: 70%;height: 50%;" class="img-thumbnail">
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
						<form class="form-horizontal" method="post" action="<?php echo base_url('student/updateInfo')?>" id="updateStudentInfo">
							<div class="row">
								<div class="col-md-12">
									<div id="edit-student-messages"></div>
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
											<label for="editClassName" class="col-sm-4  control-label">Klasa :</label>
											<div class="col-sm-8">
											<select class="form-control" name="editClassName" id="editClassName">
												<option value="">Select</option>
												<?php if($classData){
													foreach ($classData as $key =>$value){?>
														<option value="<?php echo $value['class_id']?>"><?php echo $value['class_name'].' ('.$value['numeric_name'].')'?></option>
													<?php }?>
												<?php } ?>
											</select>
											</div>
										</div>
										<!--------------------------Sectioni------------------------------------------------------------------------->
										<div class="form-group">
											<label for="editSection" class="col-sm-4  control-label">Sektori :</label>
											<div class="col-sm-8">
											<select class="form-control" name="editSection" id="editSection" >
												<option value="">Select</option>
											</select>
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

<!--Modeli per Fshirjene e sttudentit Studentin----------------------------------------------------------------------->
<div class="modal fade"  tabindex="-1" role="dialog" id="removeStudentModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Fshi Studentin </h4>
			</div>
			<!--Boduy-->
			<div class="modal-body">
				<div id="remove-message"></div>
				<p>A jeni i sigurt qe deshironi te fshini kete Student?</p>
				<!--------------------------------->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Mbyll</button>
				<button type="submit" name="submit" class="btn btn-danger" id="removeStudentBtn">Po</button>
			</div>
			<!--Footer-->
		</div>
	</div>
</div>
<!------------------------------------------------------------------------------------------>
<?php } ?><!--Kjo pjes shkon per menagjimin e studentav-->


<script type="text/javascript" src="<?php echo base_url('custom/js/student.js')?>"></script>


