<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marksheet extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		/*Loading the model_clases(Ngarkimi i classes model*/
		$this->load->model('model_classes');
		/*Looding the section model*(Ngarkimi i section model)*/
		$this->load->model('model_section');
		/*Loadinf Model_teacher(Ngarkimi i taxher model*/
		$this->load->model('model_marksheet');
		/*Loadinf Model_marksheet(Ngarkimi marksheet model*/
		$this->load->model('model_teacher');
		/*Loading  the form validation dhe ngarkimi per form validation*/
		$this->load->library('form_validation');


	}

	/*Funksoni per shfaqjen e te dhenav duke u bazzuar ne classid
	Katu shfaqim te dhena ne menyre tablera dhe kur klikoim ne class 1 ateher dergohet class id dhe nxerren te gjitha
	marksheet te cilt kane ate klass id*/
	public function fetchMarksheetTable($classId = null)
	{
		if ($classId) {
			$classData = $this->model_classes->fetchclasesData($classId);//ekzekutimi i komandes ne model_class e cila na bjen te dhena sipas id
			$marksheetData = $this->model_marksheet->fetchMarksheetDataByClass($classId);//Ekekutimi i komandes dhe rujatja e saj ne marksheetdata

			$table = '<!--Ketu kemi krijuar nje tablele e cila i shfaq te dhenat ne result in scetion view-->
            <div class="well">Emri i Klases :<b>' . $classData['class_name'] . '</b><b>' . $classData['numeric_name'] . '</b> /ID:<b>' . $classData['class_id'] . '</b></div>
            <div id="message"></div>
            <div class="pull pull-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addMarksheetModal" id="add" value="'.$classData['class_id'].'">Shto Marksheet</button>
            </div>
            <br/><br/><br/>

			<table class="table table-responsive table-bordered" id="manageMarksheetTable">
			<thead>
			<tr>
				<th>Emri i Marksheet</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>';
			if ($marksheetData) {/*Ketu kemi thene se nese kemi marksheetData ekzekuto ata mrena saj*/
				foreach ($marksheetData as $key => $value)//Ketu kemi thene nxerr te gjitha te dhant si key in value
				{
					//$marksheetData = $this->model_teacher->fetchTeacherData($value['teacher_id']);//kemi ekzekutuar kete funksion dhe te return e kemi ruajtur te dhenat ne teacherData

					$button = '<div class="btn-group"><!--Ketu kemi krijuar dy buttona me funksione ne te te cilat do te shfaqen ne table-->
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Marksheet</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet(' . $value['marksheet_id'] . ',' . $value['class_id'] . ')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshije marksheet</a>
                        </li>
     
                    </ul>
                   </div>';
					$table .= '
					    <tr><!--Te dhenat te cilat do te sshaqen ne teble -->
					        <td>' . $value['marksheet_name'] . '</td>
					        <td>' . $value['marksheet_date'] . '</td>
					        <td>' . $button . '</td>
					    </tr>
					';
				}
			}

		} else {
			$table .= '<tr><td colspan="3">Nuk ka te dhena </td</tr>.';
		}


		$table .= '</tbody>

		</table>
		';
		echo $table;
	}

	/*Funksioni per krijimin e marksheet*/
	public function create($classId=null)
	{
		/*KY funksion bene te mundur validmin ne krijimin e marksheetit tash nese sectuion Name asht null jep nje info
		Dhe nese gjdo gje i ploteson kushtet ather vazhdon me ekzekutimin e komandes ne model_marksheet*/
		if ($classId)
		{
			$validator=array('success'=>false,'message'=>array());
			$validate_data=array(
				array(
					'field'=>'marksheetName',
					'label'=>'MarksheetName',
					'rules'=>"required"
				),
				array(
					'field'=>'examDate',
					'label'=>'Date',
					'rules'=>"required"
				),
			);
			//Dhe ketu kemi caktuar erroret rregullat
			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');//Ketu e kemi dizajnu errorin i cili ka mu shfaq

			if($this->form_validation->run()==true)//Nese forma e validimi funksionjon ateher qoi te dhenat ne mdulin model_classes per insertimi
			{
				/*Insert data into db form funksionit te cilit do ta perdorim ne model_classes*/
				$create=$this->model_marksheet->create($classId);
				if($create===true)
				{
					$validator['success']=true;
					$validator['message']='Procesi per Regjistrimin e Marksheet perfundoi me sukses';
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
	//Remove funksion
	public function remove($marksheetId=null)
	{
		/*Ketu kemi bere fshirjen e marksheet duke u bazuar ne marksheet id dhe nese fshirja perfundon me sukses ateher
		ipet nje message se  u fshir me sukses*/
		/*Kjo funksion ekzekutohet prej marksheet.js e cila thirr kete funksion dhe ky e thirr funksionin remove tek
		model model_marksheet dhe ai e ekzekuton komanden dhe fshin marksheet sipas marksheetid*/
		if($marksheetId)
		{
			$remove=$this->model_marksheet->remove($marksheetId);
			if($remove==true)
			{
				$validator['success']=true;
				$validator['message']='Marksheet u fshir me sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error :Procesi per Fshirje Shkoi Gabim';

			}
			echo json_encode($validator);
		}

	}
}
