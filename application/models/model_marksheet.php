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
		/*Loding the model_student*/
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
		/*Ketu kemi bere krijimin e marksheet dhe marksheet_student duhke u bazuar ne class id dhe dhe me inputet te cilat jane*/
		if($classId)
		{
			/*Pjesa pare merr te dhenat prej inputit dhe i ruan ne databaze*/
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);
			$insert_data=array(
				'marksheet_name'=>$this->input->post('marksheetName'),
				'class_id'=> $classId,
				'marksheet_date'=>$this->input->post('examDate')
			);
			$this->db->insert('marksheet',$insert_data);

			$marksheetId=$this->db->insert_id();//ruajtja e id kur insertohet ne marksheet table
			/*Ne kete pjese kemi bere 3 foreach e cila e para na sjell section id ku permes sja
			i ruajm studentat ne ni variabel dhe ateher kemi subjectData ku permes classId duke perdor
			funksiconin ne model_subjekt morim subjektet adekuate te asaj kase dhe permes foreach studentData
			ateher morim id e studentav dhe permes foreach subjectData morim subjectet per qddo student dhe
			te gjith keto te dhena i ruajm ne tabelen marksheet_student e cila do te perdoret per raporte
			te rezultati dhe mesatares se lendve dmth kemi foreach te nderthuar dhe perderisa ka studenta shto dhe perderisa
			ka subjcetdata shto*/
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
	//Funksioni per remove
	public function remove($marksheetId=null)
	{
		if ($marksheetId)//Testo  a kemi vlere ne parametrin marksheet id
		{
			/*Ne kete pjese e bejm fshirjen tek tabela marksheet kurse ma posht*/
			$this->db->where('marksheet_id',$marksheetId);
			$result=$this->db->delete('marksheet');
			//Kurse ne kete pjese ma posht bejm fshirjen e marksheet_Student e dila ka subjctet sectionin classen
			//po ashtu edhe ketu kemi nje marksheet_id e cila asht forenkey prej tabeles marksheet dhe
			//permes kesaj id ateher i fshijm te dhenat ne menyr unike
			$this->db->where('marksheet_id',$marksheetId);
			$marksheet_studentResult=$this->db->delete('marksheet_student');

			return ($result==true&&$marksheet_studentResult==true)?true:false;//Kthe rezultat nese fshihen ose jo
		}

	}
	/*Fetching data for marksheet*/
	public function fetchMarksheetByClassMarksheet($marksheet=null)
	{
		/*Ketu kemi bere fetch sectionet*/
		$sql="SELECT * FROM marksheet WHERE marksheet_id=?";
		$query=$this->db->query($sql,$marksheet);
		return $query->row_array();
	}
	//funksioni per editimin e te dhenave te marksheet
	public function update($marksheetId=null,$classId=null)
	{
		if ($marksheetId&&$classId) {
			$sectionData=$this->model_section->fetchSectionDataByClass($classId);
			/*I morim te dhanat prej inputav*/

			$update_data = array(
				'marksheet_name' => $this->input->post("editMarksheetName"),
				'marksheet_date' => $this->input->post("editExamDate")
			);
			$this->db->where('marksheet_id', $marksheetId);//tregoim se ne cilen id te marksheet me u ndryshi
			$this->db->update('marksheet',$update_data);//dhe ketu behet ndryshimi

			$this->db->where('marksheet_id',$marksheetId);
			$this->db->where('class_id',$classId);
			$this->db->delete('marksheet_student');

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
			return true;//ketu nese result asht true kthe true perndryshe false
		}
		return false;
	}
}
