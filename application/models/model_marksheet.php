<?php
class model_marksheet extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_classes');
		/*Looding the section model*(Ngarkimi i section model)*/
		$this->load->model('model_section');
		/*Loadinf Model_subject(Ngarkimi i subject model*/
		$this->load->model('model_subject');
		$this->load->model('model_student');
	}


	public function fetchMarksheetDataByClass($classId=null)
	{
		if($classId)
		{
			$sql="SELECT * FROM marksheet WHERE class_id=?";
			$query=$this->db->query($sql,$classId);
			return $query->result_array();
		}
	}
	public function create($classId=null)
	{
		/*Ketu kemi bere krijimin e sectionit duhke u bazuar ne class id dhe dhe me inputet te cilat jane*/
		if($classId)
		{
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);
			$insert_data=array(
				'marksheet_name'=>$this->input->post('marksheetName'),
				'class_id'=> $classId,
				'marksheet_date'=>$this->input->post('examDate')
			);
			$this->db->insert('marksheet',$insert_data);

			$marksheetId=$this->db->insert_id();
			foreach ($sectionData as $key=>$value) {
				$studentData=$this->model_student->fetchStudentDataByClassAndSection($classId,$value['section_id']);
				$subjectData=$this->model_subject->fetchSubjectDataByClass($classId);
				foreach ($studentData as $studentKey=>$studentValue) {
					foreach ($subjectData as $keyS => $subjectValue) {
						$marksheet_studentData=array(
							'student_id'=>$studentValue['student_id'],
							'subject_id'=>$subjectValue['subject_id'],
						    'marksheet_id'=>$marksheetId,
						    'class_id'=>$classId,
						    'section_id'=>$value['section_id']

					    );
						$this->db->insert('marksheet_student',$marksheet_studentData);
					}
				}

			}
			return true;
		}else{
			return false;
		}
	}
}
