<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller
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
		/*Loading  the form validation dhe ngarkimi per form validation*/
		$this->load->library('form_validation');


	}
	/*---------------------------------------------Funksionet per addStudent-------------------------------------------------------------*/
	/*Funksioni per te mor section te cilet te kan classid adekuate e cila i dergohet*/
	public function fetchClassSection($classId=null)
	{
		/*Ky funksion sherben per te nxerr te gjith sectionet te ciletn e kan classId te njeejt si parametri i dhene(classId)*/
		if($classId)
		{
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);/*Ky funksion eshte ne modelin section*/
			if ($sectionData)
			{
				foreach ($sectionData as $key =>$value){
					$option.='<option value="'.$value['section_id'].'">'.$value['section_name'].'</option>';
				 }
			}else{
				$option.='<option value="0">No data</option>';
			}
			echo $option;
		}
	}
	/*Funksioni per krijimin e Studeniti*/
	public function create()
	{
		/*TE ky funksion kemi bere validimin ne formen serverside e cila validon per pjeset te cilat plotesohen*/
		$validator=array('success'=>false,'message'=>array());
		/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
		$validate_data=array(
			array(
				'field'=>'fname',
				'label'=>'Emri',
				'rules'=>"required"
			),
			array(
				'field'=>'lname',
				'label'=>'Mbiemri',
				'rules'=>"required"
			),
			array(
				'field'=>'dob',
				'label'=>'Data e Lindjes',
				'rules'=>"required"
			),
			array(
				'field'=>'age',
				'label'=>'Mosha',
				'rules'=>"required"
			),
			array(
				'field'=>'contact',
				'label'=>'Kontakti',
				'rules'=>"required"
			),
			array(
				'field'=>'email',
				'label'=>'Email',
				'rules'=>"required"
			),
			array(
				'field'=>'registerDate',
				'label'=>'Data e Regjistrimit',
				'rules'=>"required"
			),
			array(
				'field'=>'className',
				'label'=>'className',
				'rules'=>"required"
			),array(
				'field'=>'address',
				'label'=>'Adresa',
				'rules'=>"required"
			),
			array(
				'field'=>'city',
				'label'=>'Qyteti',
				'rules'=>"required"
			),
			array(
				'field'=>'country',
				'label'=>'Shteti',
				'rules'=>"required"
			),array(
				'field'=>'sectionName',
				'label'=>'Emri i Sectioni',
				'rules'=>"required"
			)
		);
		/*Ketu arryes $validate_data i kemi caktuar regulla*/
		$this->form_validation->set_rules($validate_data);
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run()==true)
		{
			$imgUrl=$this->uplodeImage();
			$create=$this->model_student->create($imgUrl);//krijo nje student me te gjithat e dhene nga inputet dhe si parameter dergimi i fotos
			if($create)
			{
				/*Nese validate  asht success asht true shfaqe qit mesazh*/
				$validator['success']=true;
				$validator['message']="Studenti u Shtua me Sukses ";
			}
			else
			{
				/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
				$validator['success']=false;
				$validator['message']="error:Studenti nuk u regjistuar";
			}
		}
		else{
			$validator['success']=false;
			foreach ($_POST as $key=>$value)
			{
				$validator['message'][$key] = form_error($key);//ruj te gjith mesazhet te cilat jan prej errorav
			}
		}
		echo json_encode($validator);//response validator message
	}
	/*Funksioni per ngarkimin e fotos*/
	public function uplodeImage()
	{
		/*Ky funksion perdoret ne create per te derguar te dhenat e fotos dhe nese perdoret ajjo foto
		dergohet ne nje path folder specifik te caktun dhe ruhet aty kurse ne daatabase ruhet vetum pathi*/
		$type=explode('.',$_FILES['photo']['name']);
		$type=$type[count($type)-1];
		$url='assets/images/student/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif','jpg','jpeg','png','JPG','GIF','JPEG','PNG'))){
			if(is_uploaded_file($_FILES['photo']['tmp_name']))
			{
				if(move_uploaded_file($_FILES['photo']['tmp_name'],$url))
				{
					return $url;
				}else{
					return false;
				}
			}

		}

	}
	/*-----------------------------------------------------------------------------------------------------------------------------------*/


	/*------------------------------------Funksionet PER bulk student-------------------------------------------------------------------*/
	/*Funksinoi per em shtu row ne table bashk me kalsat edhe sectioni*/
	public function getAppendBulStudentRow($countId=null)
	{
		if($countId)
		{
			$classData=$this->model_classes->fetchclasesData();/*Ketu kemi merr claset prej model_class e cila i ncerr klaset*/
			/*kETU kemi krijuar nje row dhe kemi futur te gjtia inputet te cilat do te shfaqen kur te bejm add row*/
			/*E gjith kjo kthehet si respomse dhe ne js student response insertohet ne table permes j1uery*/

			$row='
			<tr id="row'.$countId.'">
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="bulkstfname'.$countId.'" name="bulkstfname['.$countId.']" placeholder="Emri">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="bulkstlname'.$countId.'" name="bulkstlname['.$countId.']" placeholder="Mbiemri	">
								</div>
							</td>
							<td>
								<div class="form-group">
									<select class="form-control" name="bulkstclassName['.$countId.']" id="bulkstclassName'.$countId.'"
									onchange="getSelectClassSection('.$countId.')">
										<option value="">Select</option>';
										if($classData){
											foreach ($classData as $key =>$value){
												$row.='<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
											 }
										 }
										 $row.='
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<select class="form-control" name="bulkstsectionName['.$countId.']" id="bulkstsectionName'.$countId.'" >
										<option value="">Select</option>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<button type="button" class="btn btn-danger" onclick="removeRow('.$countId.')"><i class="glyphicon glyphicon-trash"></i></button>
								</div>
							</td>
						</tr>
			';
										echo $row;
		}
	}
	/*Funksoni per krijimin e bukl student*/
	public function createBulk()
	{
		$validator=array('success'=>false,'message'=>array());


		$fname=$this->input->post('bulkstfname');
		if(!empty($fname))
		{
			foreach ($fname as $key =>$value) {
				$this->form_validation->set_rules('bulkstfname['.$key.']','Emri','required');
			}
		}
		/*------------------------------------------------------------------------------------*/
		$lname=$this->input->post('bulkstlname');
		if(!empty($lname))
		{
			foreach ($lname as $key =>$value) {
				$this->form_validation->set_rules('bulkstlname['.$key.']','Mbiemri','required');


			}
		}
		/*------------------------------------------------------------------------------------*/
		$classname=$this->input->post('bulkstclassName');
		if(!empty($classname))
		{
			foreach ($classname as $key =>$value) {
				$this->form_validation->set_rules('bulkstclassName['.$key.']','Klass','required');


			}
		}
		/*------------------------------------------------------------------------------------*/
		$sectionname=$this->input->post('bulkstsectionName');
		if(!empty($sectionname))
		{
			foreach ($sectionname as $key =>$value) {
				$this->form_validation->set_rules('bulkstsectionName['.$key.']','Section','required');


			}
		}
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run()==true)
		{

			$create=$this->model_student->createBulk();//login me kete username dhe kete password duke perdorur funksionin ne model_teacher
			if($create)
			{
				/*Nese validate  asht success asht true shfaqe qit mesazh*/
				$validator['success']=true;
				$validator['message']="Te Gjith Studentat u Insertuan me sukses";
			}
			else
			{
				/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
				$validator['success']=false;
				$validator['message']="error:Studentat nuk u regjistuar";
			}
		}
		else{
			$validator['success']=false;
			foreach ($_POST as $key =>$value)
			{
				if ($key=='bulkstfname')
				{
					foreach ($value as $number=>$data) {

						$validator['message']['bulkstfname'.$number] = form_error('bulkstfname['.$number.']');//ruj te gjith mesazhet te cilat jan prej errorav

					}
				}
				/*-----------------------------------------------------------------------------------------------*/
				if ($key=='bulkstlname')
				{
					foreach ($value as $number=>$data) {

						$validator['message']['bulkstlname'.$number] = form_error('bulkstlname['.$number.']');//ruj te gjith mesazhet te cilat jan prej errorav

					}
				}
				/*-----------------------------------------------------------------------------------------------*/
				if ($key=='bulkstclassName')
				{
					foreach ($value as $number=>$data) {

						$validator['message']['bulkstclassName'.$number] = form_error('bulkstclassName['.$number.']');//ruj te gjith mesazhet te cilat jan prej errorav

					}
				}
				/*-----------------------------------------------------------------------------------------------*/
				if ($key=='bulkstsectionName')
				{
					foreach ($value as $number=>$data) {

						$validator['message']['bulkstsectionName'.$number] = form_error('bulkstsectionName['.$number.']');//ruj te gjith mesazhet te cilat jan prej errorav

					}
				}
			}
		}
		echo json_encode($validator);//response validator message

	}
	/*-----------------------------------------------------------------------------------------------------------------------------------*/


	/*-----------------------------------------------Funksionet per menagjimin e studeentav----------------------------------------------*/
	public function fetchClassSectionTable($classId=null)
	{
		if ($classId)
		{
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);//Ekekutimi i komandes dhe rujatja e saj ne sectiondata
			$classData=$this->model_classes->fetchclasesData($classId);//ekzekutimi i komandes ne model_class e cila na bjen te dhena sipas id


			$tab=array();
			$tab['sectionData']=$sectionData;

			$tab['html']='
			<ul class="nav nav-tabs" role="tablist">
               <li role="presentation" class="active"><a href="#classStudent" aria-controls="classStudent" data-toggle="tab">Te Gjith Studentat</a></li>';
			$x=1;
			if ($sectionData){
				foreach ($sectionData as $key=>$value) {
					$tab['html'].='<li role="presentation"><a href="#countSection'.$x.'" aria-controls="classSection" 
					role="tab"  data-toggle="tab">Sectori '.$value['section_name'].'</a></li>';
					$x++;
				}
			}
            $tab['html'].= '</ul>
               <!--Tabs-->
               <div class="tab-content">
                    <div role="tabpanle" class="tab-pane active" id="classStudent">
                    <br/>
                    <table class="table table-bordered lala" id="managaStudentTable'.$x.'">
                             <thead>
                                 <tr>    
                                     <th>Foto</th>
                                     <th>Emri</th>
                                     <th>Klassa</th>
                                     <th>Sektori</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                         </table>
                        
                    </div>';

			if ($sectionData){
				$x=1;
				foreach ($sectionData as $key=>$value) {
					$teacherData=$this->model_teacher->fetchTeacherData($value['teacher_id']);
					$tab['html'].='<div role="tabpanel" class="tab-pane" id="countSection'.$x.'">
                         <br/>
					    <div class="well">
					        Klassa :'.$classData['class_name'].'<br />
                            Sektori :'.$value['section_name'].'<br/>
                            Profesori: '.$teacherData['fname'].'  '.$teacherData['lname'].'
                       </div>
                       
                       <table class="table table-bordered" id="managaStudentTable'.$x.'" style="width:100%;">
                             <thead>
                                 <tr>    
                                     <th>Foto</th>
                                     <th>Emri</th>
                                     <th>Klassa</th>
                                     <th>Sektori</th>
                                     <th>Addresa</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                         </table>
                     </div>';
					$x++;
				}
			}

			$tab['html'].= '</div>';
			echo json_encode($tab);

		}
	}
	/*Te gjith studentat sipas klases*/
	public function fetchStudentByClass($classId=null)
	{
		if ($classId)
		{
			$result=array('data',array());
			$studentData=$this->model_student->fetchStudentDataByClass($classId);//Nxerrja e te dhenave ne total

			foreach ($studentData as $key=>$value) {
				//$img='<img src="'.base_url().$value['image'].'" class="image-circle candidate-photo" alt="Student Image/>';
				$classData=$this->model_classes->fetchclasesData($value['class_id']);//ekzekutimi i komandes ne model_class e cila na bjen te dhena sipas id
				$sectionData=$this->model_section->fetchSectionByClassSection($value['section_id']);//Ekekutimi i komandes dhe rujatja e saj ne sectiondata


				/*Shfaqja e buttonave edditues dhe delete ne qdo profesor id*/
				$buttons='<div class="btn-group">
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#updateStudentModal" onclick="editStudent('.$value['student_id'].')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Studentin</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeStudentModal" onclick="removeStudent('.$value['student_id'].')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshi Studentin</a>
                        </li>
     
                    </ul>
                   </div>';
				$photo='<img src="'.base_url().$value['image'].'" alt="photo" class="img-circle candidate-photo"/>';//marrja url e fotos

				$result['data'][$key]=array(
					$photo,
					$value['fname'].' '.$value['lname'],
					$classData['class_name'],
					$sectionData['section_name'],
					$buttons//insertimi i buttonav
				);

			}
			echo json_encode($result);

		}
	}
	/*Funksioni oer mi ncerr sectionet sipas class id studentat sipas sctionit*/
	public function fetchStudentByClassAndSection($classId=null,$sectionId=null)
	{
		if ($classId && $sectionId)
		{
			$result=array('data',array());
			$studentData=$this->model_student->fetchStudentDataByClassAndSection($classId,$sectionId);//Nxerrja e te dhenave ne total

			foreach ($studentData as $key=>$value) {
				//$img='<img src="'.base_url().$value['image'].'" class="image-circle candidate-photo" alt="Student Image/>';
				$classData=$this->model_classes->fetchclasesData($value['class_id']);//ekzekutimi i komandes ne model_class e cila na bjen te dhena sipas id
				$sectionData=$this->model_section->fetchSectionByClassSection($value['section_id']);//Ekekutimi i komandes dhe rujatja e saj ne sectiondata


				/*Shfaqja e buttonave edditues dhe delete ne qdo profesor id*/
				$buttons='<div class="btn-group">
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#updateStudentModal" onclick="editStudent('.$value['student_id'].')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Studentin</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeStudentModal" onclick="removeStudent('.$value['student_id'].')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshi Studentin</a>
                        </li>
     
                    </ul>
                   </div>';
				$photo='<img src="'.base_url().$value['image'].'" alt="photo" class="img-circle candidate-photo"/>';//marrja url e fotos

				$result['data'][$key]=array(
					$photo,
					$value['fname'].' '.$value['lname'],
					$classData['class_name'],
					$sectionData['section_name'],
					$value['address'].'/'.$value['city'].'/'.$value['country'],
					$buttons//insertimi i buttonav
				);

			}
			echo json_encode($result);

		}
	}
	/*Funksioni per ndryshimin e fotos faktikisht per te mor foton e re dhe per te insertuar*/
	public function editUplodeImage()
	{
		$type=explode('.',$_FILES['editPhoto']['name']);
		$type=$type[count($type)-1];
		$url='assets/images/student/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif','jpg','jpeg','png','JPG','GIF','JPEG','PNG'))){
			if(is_uploaded_file($_FILES['editPhoto']['tmp_name']))
			{
				if(move_uploaded_file($_FILES['editPhoto']['tmp_name'],$url))
				{
					return $url;
				}else{
					return false;
				}
			}

		}

	}
	/*Editimi i fotos dhe insertmini i te rese*/
	public function updatePhoto($student=null)
	{
		//validimi i fotos
		if($student)
		{
			$validator=array('success'=>false,'message'=>array());
			/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/

			if(empty($_FILES['editPhoto']['tmp_name']))
			{

				/*Nese validate  asht success asht true shfaqe qit mesazh*/
				$validator['success']=false;
				$validator['message']="Foto Duhet te Selectohet";

			}
			else{
				$img=$this->editUplodeImage();//marrja e url se fotos se selectuar
				$update=$this->model_student->updatePhoto($student,$img);//ekzekutimi i funksionit ne model_teacher class
				if($update==true)
				{
					$validator['success']=true;
					$validator['message']="Procesi per Ndryshimin e Fotos u krye me Suksess";
				}else{
					$validator['success']=false;
					$validator['message']="Error Gjate Ndryshimit te fotos";
				}
			}
			echo json_encode($validator);//response validator message
		}

	}
	/*Nxerr studentat nga databaza*/
	public function fetchStudentData($studentId=null)
	{
		if($studentId)
		{
			//nxerr data ne menyre specifike
			$result=$this->model_student->fetchStudentData($studentId);
		}
		echo json_encode($result);
	}
	/*Funksoni per fshirjen e studentit dhe lajmrrimi i ti*/
	public function remove($studentId=null)
	{
		$validator=array('success'=>false,'message'=>array());
		if($studentId)
		{
			$remove=$this->model_student->remove($studentId);
			if($remove)
			{
				$validator['success']=true;
				$validator['message']='Studenti u Fshir me sukses';
			}else
			{
				$validator['success']=false;
				$validator['message']='Error Gjat Fshirjes se Studentit';
			}
		}
		echo json_encode($validator);
	}
	/*Funksioni per editimin e te dhenav te studentit*/
	public function updateInfo($studentId=null)
	{
		if($studentId)
		{
			/*TE ky funksion kemi bere validimin ne formen serverside e cila validon per pjeset te cilat plotesohen*/
			$validator=array('success'=>false,'message'=>array());
			/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
			$validate_data=array(
				array(
					'field'=>'editFname',
					'label'=>'Emri',
					'rules'=>"required"
				),
				array(
					'field'=>'editLname',
					'label'=>'Mbiemri',
					'rules'=>"required"
				),
				array(
					'field'=>'editDob',
					'label'=>'Data e Lindjes',
					'rules'=>"required"
				),
				array(
					'field'=>'editAge',
					'label'=>'Mosha',
					'rules'=>"required"
				),
				array(
					'field'=>'editContact',
					'label'=>'Kontakti',
					'rules'=>"required"
				),
				array(
					'field'=>'editEmail',
					'label'=>'Email',
					'rules'=>"required"
				),
				array(
					'field'=>'editRegisterDate',
					'label'=>'Data e Regjistrimit',
					'rules'=>"required"
				)
			    ,array(
					'field'=>'editAddress',
					'label'=>'Adresa',
					'rules'=>"required"
				),
				array(
					'field'=>'editCity',
					'label'=>'Qyteti',
					'rules'=>"required"
				),
				array(
					'field'=>'editClassName',
					'label'=>'Klassa',
					'rules'=>"required"
				),
				array(
					'field'=>'editSection',
					'label'=>'Sektori',
					'rules'=>"required"
				),
				array(
					'field'=>'editCountry',
					'label'=>'Shteti',
					'rules'=>"required"
				)
			);
			/*Ketu arryes $validate_data i kemi caktuar regulla*/
			$this->form_validation->set_rules($validate_data);
			//Dhe ketu kemi caktuar erroret
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if($this->form_validation->run()==true)
			{
				$updateInfo=$this->model_student->updateInfo($studentId);//login me kete username dhe kete password duke perdorur funksionin ne model_teacher
				if($updateInfo)
				{
					/*Nese validate  asht success asht true shfaqe qit mesazh*/
					$validator['success']=true;
					$validator['message']="Ndryshimi perfundoi me sukses";
				}
				else
				{
					/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
					$validator['success']=false;
					$validator['message']="Error Gjate procesit per ndryshimin e te dhenave";
				}
			}
			else{
				$validator['success']=false;
				foreach ($_POST as $key=>$value)
				{
					$validator['message'][$key] = form_error($key);//ruj te gjith mesazhet te cilat jan prej errorav
				}
			}
			echo json_encode($validator);//response validator message
		}

	}
	/*----------------------------------------------------------------------------------------------------------------------------------*/

}

