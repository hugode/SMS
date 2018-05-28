<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		/*Loading the model_clases(Ngarkimi i classes model*/
		$this->load->model('model_classes');
		/*Looding the section model*(Ngarkimi i section model)*/
		$this->load->model('model_section');
		/*Loadinf Model_teacher(Ngarkimi i taxher model*/
		$this->load->model('model_teacher');
		/*Loading  the form validation dhe ngarkimi per form validation*/
		$this->load->library('form_validation');


	}
	/*Funksoni per shfaqjen e te dhenav duke u bazzuar ne classid
	Katu shfaqim te dhena ne menyre tablera dhe kur klikoim ne class 1 ateher dergohet class id dhe nxerren te gjitha
	section te cilt kane ate klass id*/
	public function fetchSectionTable($classId=null)
	{
		if($classId)
		{
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);//Ekekutimi i komandes dhe rujatja e saj ne sectiondata
			$classData=$this->model_classes->fetchclasesData($classId);//ekzekutimi i komandes ne model_class e cila na bjen te dhena sipas id

			$table='<!--Ketu kemi krijuar nje tablele e cila i shfaq te dhenat ne result in scetion view-->
            <div class="well">Emri i Klases :<b>'.$classData['class_name'].'</b><b>'.$classData['numeric_name'].'</b></div>
            <div id="message"></div>
            <div class="pull pull-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal" onclick="addSection('.$classId.')">Shto Section</button>
            </div>
            <br/><br/><br/>

			<table class="table table-responsive table-bordered" id="manageSectionTable">
			<thead>
			<tr>
				<th>ID</th>
				<th>Emri i Section</th>
				<th>Emri i Profesorit</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>';
			if ($sectionData){/*Ketu kemi thene se nese kemi sectionData ekzekuto ata mrena saj*/
				foreach ($sectionData as $key => $value)//Ketu kemi thene nxerr te gjitha te dhant si key in value
				{
					$teacherData=$this->model_teacher->fetchTeacherData($value['teacher_id']);//kemi ekzekutuar kete funksion dhe te return e kemi ruajtur te dhenat ne teacherData

					$button='<div class="btn-group"><!--Ketu kemi krijuar dy buttona me funksione ne te te cilat do te shfaqen ne table-->
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#editSectionModal" onclick="editSection('.$value['section_id'].','.$value['class_id'].')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Section</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeSectionModal" onclick="removeSection('.$value['section_id'].','.$value['class_id'].')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshije Section</a>
                        </li>
     
                    </ul>
                   </div>';
					$table.='
					    <tr><!--Te dhenat te cilat do te sshaqen ne teble -->
					        <td>'.$value['section_id'].'</td>
					        <td>'.$value['section_name'].'</td>
					        <td>'.$teacherData['fname'].' '.$teacherData['lname'].'</td>
					        <td>'.$button.'</td>
					    </tr>
					';
				}
			}
				
			}else{
				$table.='<tr><td colspan="3">Nuk ka te dhena </td</tr>.';
			}
				

			$table .='</tbody>

		</table>
		';
			echo $table;
	}
	/*Nxerrja e te dhenav te sectuonit */
	public function fetchSectionByClassSection($sectionId=null)
	{
		if ($sectionId)
		{/*Nese kemi section id ateher ekzekutoim komanden te cilen asht me posht
		   Ku ben te mundur ncerrjen e te dhenav ne baze te sectuion id  dhe i shfaq si respons json encode*/
			$sectionData=$this->model_section->fetchSectionByClassSection($sectionId);
			echo json_encode($sectionData);
		}
	}

	/*Funksoni per krijimin e Section*/
	public function create($classId =null)
	{
		/*KY funksion bene te mundur validmin ne krijimin e sectionit tash nese sectuion Name asht null jep nje info
		Dhe nese gjdo gje i ploteson kushtet ather vazhdon me ekzekutimin e komandes ne model_section*/
		if ($classId)
		{
			$validator=array('success'=>false,'message'=>array());
			$validate_data=array(
				array(
					'field'=>'sectionName',
					'label'=>'Emri i Section',
					'rules'=>"required"
				),
				array(
					'field'=>'teacherName',
					'label'=>'Profesori',
					'rules'=>"required"
				),
			);
			//Dhe ketu kemi caktuar erroret rregullat
			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');//Ketu e kemi dizajnu errorin i cili ka mu shfaq

			if($this->form_validation->run()==true)//Nese forma e validimi funksionjon ateher qoi te dhenat ne mdulin model_classes per insertimi
			{
				/*Insert data into db form funksionit te cilit do ta perdorim ne model_classes*/
				$create =$this->model_section->create($classId);
				if($create===true)
				{
					$validator['success']=true;
					$validator['message']='Procesi per Regjistrimin e Section perfundoi me sukses';
				}else{
					$validator['success']=false;
					$validator['message']='Error :Procesi per Regjistrimin Shkoi Gabim';

				}

			}else{
				$validator['success']=false;
				foreach ($_POST as$key=>$value){
					$validator['message'][$key]=form_error($key);
				}
			}
			echo json_encode($validator);
		}
	}
	/*Funskioni per ndryshimin  e te dhenave*/
	public function update($sectionId)
	{
		/*Funksioni per editimin e te dhenav te sectionit nese gjdo kusht plotesohet aather ekzekutimi vazhdon me sukses*/
		if ($sectionId)
		{
			$validator=array('success'=>false,'message'=>array());
			$validate_data=array(
				array(
					'field'=>'editSectionName',
					'label'=>'Emri i Section',
					'rules'=>"required"
				),
				array(
					'field'=>'editTeacherName',
					'label'=>'Profesori',
					'rules'=>"required"
				),
			);
			//Dhe ketu kemi caktuar erroret rregullat
			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');//Ketu e kemi dizajnu errorin i cili ka mu shfaq

			if($this->form_validation->run()==true)//Nese forma e validimi funksionjon ateher qoi te dhenat ne mdulin model_classes per insertimi
			{
				/*Insert data into db form funksionit te cilit do ta perdorim ne model_classes*/
				$update=$this->model_section->update($sectionId);
				if($update===true)
				{
					$validator['success']=true;
					$validator['message']='Procesi per Ndryshimin e Section perfundoi me sukses';
				}else{
					$validator['success']=false;
					$validator['message']='Error :Procesi per Ndryshim Shkoi Gabim';

				}

			}else{
				$validator['success']=false;
				foreach ($_POST as$key=>$value){
					$validator['message'][$key]=form_error($key);
				}
			}
			echo json_encode($validator);
		}
	}
	/*Funkssioni per fshirjen e sectiorit*/
	public function remove($sectionId=null)
	{
		/*Ketu kemi bere fshirjen e sectioni duke u bazuar ne section id dhe nese fshirja perfundon me sukses ateher
		ipet nje message se Sectioni u fshir me sukses*/
		if($sectionId)
		{
			$remove=$this->model_section->remove($sectionId);
			if($remove==true)
			{
				$validator['success']=true;
				$validator['message']='Section u fshir me sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error :Procesi per Fshirje Shkoi Gabim';

			}
			echo json_encode($validator);
		}

	}
}
