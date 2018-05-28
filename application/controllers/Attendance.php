<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		/*Loading the model_clases(Ngarkimi i classes model*/
		$this->load->model('model_classes');
		/*Looding the student model*(Ngarkimi i section model)*/
		$this->load->model('model_student');
		/*Loadinf Model_section(Ngarkimi i taxher model*/
		$this->load->model('model_section');
		/*Ngarkimi i profesorit*/
		$this->load->model('model_teacher');
		/*Ngarkimi i attendance*/
		$this->load->model('model_attendance');
		/*Loading  the form validation dhe ngarkimi per form validation*/
		$this->load->library('form_validation');


	}
	/*---------------------Keta funksioni qe jane perfuni do te sherbejn per shto attendance---------------------------------------------*/
	public function fetchAttendanceType($id=null)
	{
		if($id==1)/*Id asht e barabart me 1 ateher shfaq te dhenat e studentit*/
		{
			/*Studenti e ka id->2 ||| Profesori e ka id ->1*/

			$classData=$this->model_classes->fetchclasesData();/*Ketu i kemi bere fetch klaset aktuale*/

			$form='<!--Ketu  kemi krijuar nje form e cila do te shfaqet e gjitha te moduli attendance views-->
			<div class="form-group">
					<label for="className" class="col-sm-3 control-label">Zgjedh Klassen</label>
					<div class="col-md-4">
						<select class="form-control" name="className" id="className">
						<!--/*Ne kete foreach i kemi nxerr te gjitha klasat dhe shfaqurs ne opsione duke ju cekur edhe value*/-->
							<option value="">Select</option>';
			                      foreach ($classData as $key=>$value)
								  {
								  	$form.='<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
								  }
								  $form.='</select>
					</div>
				</div>
				<!-------------------------------------------------------------------------->
				<div class="form-group">
					<label for="sectionName" class="col-sm-3 control-label">Zgjedh Sektorin</label>
					<div class="col-md-4">
					<!--Ne kete form grup e kemi section name e cila do te shfaqen opsionet prej js file e cila do ti
					perditeson onchange of class ateher do te shfaqen sectionName duke u bazu sipas classId-->
						<select class="form-control" name="sectionName" id="sectionName">
							<option value="">Select</option>
						</select>
					</div>
				</div>
				<!---------------------------------------------------------------------------->
				<div class="form-group">
					<label for="date" class="col-sm-3 control-label">Zgjedh Daten</label>
					<div class="col-md-4">
					<!--Nje input date e cila do te paisejt ne js file me ni plungis-->
						<input type="text" class="form-control" name="date" id="date">
					</div>
				</div>
				<!---------------------------------------------------------------------------->
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
							<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
			
			';

		}
		elseif ($id==2)/*Tash qdo gje perfuni keti if do te jete per teacher form*/
		{
			/*Profesori part*/
			$form='
			<!---------------------------------------------------------------------------->
				<div class="form-group">
					<label for="date" class="col-sm-3 control-label">Zgjedh Daten</label>
					<!--Nje input date e cila do te paisejt ne js file me ni plungis-->
					<div class="col-md-4">
						<input type="text" class="form-control" name="date" id="date">
					</div>
				</div>
				<!---------------------------------------------------------------------------->
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
				';
		}else{
			/*Nese nuk asht asnja prej tyne form nuk ka te dhena ateher*/
			$form='No data';
		}
		echo $form;
	}
	/*Funksioni per te nxerr studenta sipas classnAME dhe section name dhe per ti shfaqur si table*/
	public function getAttendanceTable($classId=null,$sectionId=null,$date=null,$typeId=null)
	{
		if($typeId==1){
			/*for student*/
			/*Studentat e nxerr nga databaza*/
			$studentData=$this->model_student->fetchStudentDataByClassAndSection($classId,$sectionId);
			/*classet e nxerr nga model_classes e cila e nxerr classn sipas class id tte dhene*/
			$classData=$this->model_classes->fetchclasesData($classId);
			/*Section e nxerr prej funnksionit adekuat sipas section id i cili eshte dhene si parameter*/
			$sectionData=$this->model_section->fetchSectionByClassSection($sectionId);

			$div='
			      <div class="well"><!--Nje form per te shfaqur informacion mbas submit buttonit-->
			            Lloji i Pjesmarrjes :<b>Student</b><br/>
			            Class :<b>'.$classData['class_name'].'</b><br/>
			            Sektori :<b>'.$sectionData['section_name'].'</b><br/>
			            Data :<b>'.$date.'</b><br/>
			      
                  </div>
                  
                  <div id="att-message"></div>
                  <!--Krijimi i nje form e cila will be served for creating a attendance-->
                  <form method="post" class="form-horizontal" action="'.base_url('attendance/createAttendance').'" id="createAttendanceForm">
                       <table class="table table-bordered">
                       <!--Krijimi i nje tabele e cila do te shfaq te dhana sipas madhsis te cilen jane ne ddatabase te studentit ose te profesorit-->
                            <thead>
                            <th width="5%">Foto</th>
                            <th>Emri</th>
                            <th>Email</th>
                            <th>Adresa</th>
                            <th width="20%">Action</th>
                            </thead>
                            <tbody>';
			                    if($studentData)
								{
									/*Nese ka studenta sipas classid dhe section id te dhene si parameter
									ateher shfaq deri sa nuk ka ma*/
									$x=1;
									foreach ($studentData as $key=>$value) {

										$attData=$this->model_attendance->fetchMarkAtt($classId,$sectionId,$date,$typeId,$value['student_id']);
										$div.='<tr>
                                                 <td>
                                                    <img src="'.base_url().$value['image'].'" alt="photo" class="img-circle candidate-photo"/>
                                                 </td>
                                                 <td>
                                                     '.$value['fname'].' '.$value['lname'].'
                                                     <input type="hidden" name="studentId['.$x.']" value="'.$value['student_id'].'"/>
                                                 </td>
                                                 <td>
                                                     '.$value['email'].'<br/>
                                                     '.$value['contact'].'
                                                 </td>
                                                 <td> '.$value['address'].'/'.$value['city'].'/'.$value['country'].'</td>
                                                 <td>
                                                 <!--/*Ky if perdor funksioni i cili nxerr te dhanta per mark dhe she nese ka value ose jo
										                  nese ka value ateher e selecton ne menyr automatike nese jo atheer duhet te shenohet manual*/
										                  /*dmth nese nje student asht vlersu me ni present per qat dit ather kur te shenoish apet daten
										                  aj student do te i shfaqet vlera vet present
										                  -->
                                                     <select name="attendance_status['.$x.']" id="attendance_status['.$x.']" class="form-control">
                                                         <option value=""';
										                  if($attData['mark']==0){
										                  	$div.='selected';
														  }
										                  $div.='></option>
                                                         <option value="1"';
										                  if($attData['mark']==1){
										                  	$div.='selected';
														  }
										                  $div.='>Prezent</option>
                                                         <option value="2"';
										                  if($attData['mark']==2){
										                  	$div.='selected';
														  }
										                  $div.='>Mungon</option>
                                                         <option value="3"';
										                  if($attData['mark']==3){
										                  	$div.='selected';
														  }
										                  $div.='>Vones</option>
                                                     
                                                     </select>
                                                 </td>
                                               </tr>';
										$x++;
									}

								}else{
			                    	$div.='<tr><td colspan="3">Ska te dhena</td></tr>';
								}

			        $div.='</tbody>
                       </table>
                       <center>
                       <!--Disa inpute hidden te pa shfaqur vetum me value te paisur per te sherbyer ne model_users-->
                       <input type="hidden" name="attendance_type" value="'.$typeId.'" >
                       <input type="hidden" name="date" value="'.$date.'" >
                       <input type="hidden" name="classId" value="'.$classData['class_id'].'">
                       <input type="hidden" name="sectionId" value="'.$sectionData['section_id'].'">
                       <button type="submit" class="btn btn-success">Ruaji</button>
                       </center>
                  </form> 
			
			';

		}
	    else if($typeId==2)/*Kjo type id nese asht e barabart me 2 ateher gjdo gje perfuni keti ifi do te jete per profesorat*/
		{
		     $teacherData=$this->model_teacher->fetchTeacherData();/*Fetch te gjith profesorat*/
			/*for the teacher*/
			$div='
			<div class="well">
			            Lloji i Pjesmarrjes : Teacher<br/>
			             Data :<b>'.$date.'</b><br/>
                  </div>
                  
                  <div id="att-message"></div>
                  
                  <form method="post" class="form-horizontal" action="'.base_url('attendance/createAttendance').'" id="createAttendanceForm">
                       <table class="table table-bordered">
                            <thead>
                           <th width="5%">Foto</th>
                            <th>Emri</th>
                            <th>Email</th>
                            <th>Adresa</th>
                            <th width="20%">Action</th>
                            </thead>
                            <tbody>';
			                    if($teacherData)
								{
									$x=1;
									foreach ($teacherData as $key=>$value) {
										$attData=$this->model_attendance->fetchMarkAtt('','',$date,$typeId,$value['teacher_id']);
										$div.='<tr>
                                                  <td>
                                                    <img src="'.base_url().$value['image'].'" alt="photo" class="img-circle candidate-photo"/>
                                                 </td>
                                                 <td>
                                                     '.$value['fname'].' '.$value['lname'].'
                                                     <input type="hidden"   name="teacherId['.$x.']" id="teacherId"  value="'.$value['teacher_id'].'"/>
                                                 </td>
                                                 <td>
                                                     '.$value['email'].'<br/>
                                                     '.$value['contact'].'
                                                 </td>
                                                 <td> '.$value['address'].'/'.$value['city'].'/'.$value['country'].'</td>
                                                 <td>
                                                     <select name="attendance_status['.$x.']" id="attendance_status['.$x.']" class="form-control">
                                                         <option value=""';
										                  if($attData['mark']==0){
										                  	$div.='selected';
														  }
										                  $div.='></option>
                                                         <option value="1"';
										                  if($attData['mark']==1){
										                  	$div.='selected';
														  }
										                  $div.='>Prezent</option>
                                                         <option value="2"';
										                  if($attData['mark']==2){
										                  	$div.='selected';
														  }
										                  $div.='>Mungon</option>
                                                         <option value="3"';
										                  if($attData['mark']==3){
										                  	$div.='selected';
														  }
										                  $div.='>Vones</option>
                                                     
                                                     </select>
                                                 </td>
                                               </tr>';
										$x++;
									}

								}else{
			                    	$div.='<tr><td colspan="3">Ska te dhena</td></tr>';
								}

			        $div.='</tbody>
                       </table>
                       
                       <center>
                       <input type="hidden" name="attendance_type" value="'.$typeId.'" >
                       <input type="hidden" name="date" value="'.$date.'" >
                       <button type="submit" class="btn btn-success">Ruaji</button>
                       </center>
                  </form> 
			
			';
		}

		echo $div;/*Nfund shfaqja e te dhenav ne views e cila do te ekzekutohet nga js file*/
	}
	/*Funksioni per insertimin e studentav ne addtencexas*/
	public function createAttendance()
	{
		$validator=array('success'=>false, 'message'=>array());/*Realizimi i nje validimini se a u inerstua a jo*/
		$create=$this->model_attendance->createAttendance($this->input->post('attendance_type'));/*Crijo attendacne sipas tipit a student a profesor*/

		if($create==true)
		{

			$validator['success']=true;
			$validator['message']='Te dhenat u ruajten me sukses';
		}else{
			$validator['success']=false;
			$validator['message']='Te dhenat nuk u ruajten me sukses';
		}

		echo json_encode($validator);/*Nje json encode response*/
	}
	/*-------------------------------Fundi i krijo pjesmarrje-------------------------------------------------------------------------------------*/

	/*----------------------------THis part is for report-----------------------------------------------------------------------------------*/
	public function fetchClassAndSection()
	{
		/*classet e nxerr nga model_classes e cila e nxerr classn sipas class id tte dhene*/
		$classData=$this->model_classes->fetchclasesData();

		$select='
		        <div class="form-group">
					<label for="className" class="col-sm-2 control-label">Zgjedh Klassen</label>
					<div class="col-md-4">
						<select class="form-control" name="className" id="className">
						<!--/*Ne kete foreach i kemi nxerr te gjitha klasat dhe shfaqurs ne opsione duke ju cekur edhe value*/-->
							<option value="">Select</option>';
		                      if($classData)
							  {
								  foreach ($classData as $key=>$value) {
								  	$select.='<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';

							  	}
							  }
		                         $select.='</select>

					</div>
				</div>
				<!-------------------------------------------------------------------------->
				<div class="form-group">
					<label for="sectionName" class="col-sm-2 control-label">Zgjedh Sektorin</label>
					<div class="col-md-4">
					<!--Ne kete form grup e kemi section name e cila do te shfaqen opsionet prej js file e cila do ti
					perditeson onchange of class ateher do te shfaqen sectionName duke u bazu sipas classId-->
						<select class="form-control" name="sectionName" id="sectionName">
							<option value="">Select</option>
						</select>
					</div>
				</div>
		';
			 echo $select;

	}
	/*funksioni per raport*/
	public function report($id=null,$raportDate=null,$numOfDays=null,$classId=null,$sectionId=null)
	{
		$viti=substr($raportDate,0,4);
		$muaji=substr($raportDate,5,7);

		$classData=$this->model_classes->fetchClasesData($classId);
		$sectionData=$this->model_section->fetchSectionByClassSection($sectionId);


		if($id==1)
		{
			$date='
			     <div class="well">
			     <center>
			     <h4>Lloji pjessmarrjes: <b>Student</b></h4>
			     <h4>Klasa : <b>'.$classData['class_name'].'</b> / Sektori : <b>'.$sectionData['section_name'].'</b></h4>
			     <h4>Data : <b>'.$raportDate.'</b></h4>
			     <small><b>P</b> :Prezent<br/>
			            <b>M</b> :Mungon<br/>
			            <b>V</b> :Vonese<br/>
			            <b>UN</b> :E pa shenume<br/>
			     </small>
			     </center>
                 </div>
                 <table class="table table-bordered">
                     <tbody>
                       <tr>
                           <td>Name</td>';
			            for ($i=1;$i<=$numOfDays;$i++)
						{
							$date.='<td>'.$i.'</td>';
						}
			           $date.='</tr>';
			            $studentInfo=$this->model_student->fetchStudentDataByClassAndSection($classId,$sectionId);

			            foreach ($studentInfo as $key => $value)
						{
							$studentName=$value['fname'].' '.$value['lname'];
							$date.='
                                 <tr>
                                     <td>'.$studentName.'</td>';
							        for($i=1;$i<=$numOfDays;$i++){
							      	$attendanceData=$this->model_attendance->getAttendance($i,$raportDate,$value['student_id'],$id,$classId,$sectionId);

							      	$date.='<td>';
							      	$attendanceStatus="";
										foreach ($attendanceData as $keyA=>$valueA) {
											if($valueA['mark']==1){
												$attendanceStatus='<span class="label label-success">P</span>';
											}elseif($valueA['mark']==2){
												$attendanceStatus='<span class="label label-danger">M</span>';
											}elseif($valueA['mark']==3){
												$attendanceStatus='<span class="label label-primary">L</span>';
											}else
											{
												$attendanceStatus='<span class="label label-default">UN</span>';
											}
										}
										$date.=$attendanceStatus;

										$date.=' </td>';


								  }
                                $date.=' </tr>';
						}

			            
                     
                   $date.=' </tbody>
                 
                 </table>
			';
		}elseif ($id==2){
			$date='
			     <div class="well">
			     <center>
			     <h4>Lloji pjessmarrjes: <b>Prof</b></h4>
			     <h4>Data : <b>'.$raportDate.'</b></h4>
			     <small><b>P</b> :Prezent<br/>
			            <b>M</b> :Mungon<br/>
			            <b>V</b> :Vonese<br/>
			            <b>UN</b> :E pa shenume<br/>
			     </small>
			     </center>
                 </div>
                 <table class="table table-bordered">
                     <tbody>
                       <tr>
                           <td>Name</td>';
			for ($i=1;$i<=$numOfDays;$i++)
			{
				$date.='<td>'.$i.'</td>';
			}
			$date.='</tr>';
			$teacherData=$this->model_teacher->fetchTeacherData();

			foreach ($teacherData as $key => $value)
			{
				$teacherName=$value['fname'].' '.$value['lname'];
				$date.='
                                 <tr>
                                     <td>'.$teacherName.'</td>';
				for($i=1;$i<=$numOfDays;$i++){
					$attendanceData=$this->model_attendance->getAttendance($i,$raportDate,$value['teacher_id'],$id,$classId,$sectionId);

					$date.='<td>';
					$attendanceStatus="";
					foreach ($attendanceData as $keyA=>$valueA) {
						if($valueA['mark']==1){
							$attendanceStatus='<span class="label label-success">P</span>';
						}elseif($valueA['mark']==2){
							$attendanceStatus='<span class="label label-danger">M</span>';
						}elseif($valueA['mark']==3){
							$attendanceStatus='<span class="label label-primary">L</span>';
						}else
						{
							$attendanceStatus='<span class="label label-default">UN</span>';
						}
					}
					$date.=$attendanceStatus;

					$date.=' </td>';


				}
				$date.=' </tr>';
			}



			$date.=' </tbody>
                 
                 </table>
			';

		}

		echo $date;

	}



}
