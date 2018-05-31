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
            <div class="well">Emri i Klases :<b>' . $classData['class_name'] . '</b><b>' . $classData['numeric_name'] . '</b></div>
            <div id="message"></div>
            <div class="pull pull-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addMarksheetModal" onclick="addMarksheet(' . $classId . ')">Shto Marksheet</button>
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
}
