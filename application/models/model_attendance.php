<?php
class model_attendance extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*Krijo nje pjesmarrje per student edhe per profesora*/
	public function createAttendance($typeId=null)
	{
		/*Krijimi i nje attendance sipas type id nese id asht nja ather attendaca krijohet per studenta nese 2 ater per profesora*/
		if($typeId==1)
		{
			//Krijimi i pjesmarrjes per student
			for ($x=1; $x <=count($this->input->post('studentId')); $x++)/*Ketu kemi krijuar nje for e cila do sillet aq her sa kemi studenta*/
			{
				/*Nese me kete date te shenuar kemi sectionid value classid value studentid value ne db
				ateher i fshhijm dhe i insertoim te rejat me posht te insert_data*/
				$this->db->delete('attendance',array(
					'attendance_date'=>$this->input->post('date'),
					'class_id'=>$this->input->post('classId'),
					'section_id'=>$this->input->post('sectionId'),
					'student_id'=>$this->input->post('studentId')[$x],

				));
				$insert_data=array(
					'attendance_type'=>$this->input->post('attendance_type'),
					'student_id'=>$this->input->post('studentId')[$x],/*Ketu je kemi jap x per shkaq me dallu studentin tjeter jo te njejtin gjith*/
				    'class_id'=>$this->input->post('classId'),
				    'section_id'=>$this->input->post('sectionId'),
				    'attendance_date'=>$this->input->post('date'),
				    'mark'=>$this->input->post('attendance_status')[$x],/*Po ashtu status per gjith studentat ne menyr unike*/
				);
				$status=$this->db->insert('attendance',$insert_data);
			}
			return ($status==true)?true:false;

		}
		else if($typeId==2)
		{
			/*Krijimi i nje attendance per profesorat duke u dallue sipas type id*/
			for ($x=1; $x <=count($this->input->post('teacherId')); $x++)
			{
				$this->db->delete('attendance',array(/*E kemi peroduru delet per mi i fshi nese jan me kto atribute ater me i qit*/
					'attendance_date'=>$this->input->post('date'),
					'teacher_id'=>$this->input->post('teacherId')[$x],

				));
				$insert_data=array(
					'attendance_type'=>$this->input->post('attendance_type'),
					'teacher_id'=>$this->input->post('teacherId')[$x],
					'attendance_date'=>$this->input->post('date'),
					'mark'=>$this->input->post('attendance_status')[$x],
				);
				$status=$this->db->insert('attendance',$insert_data);
			}
			return ($status==true)?true:false;

		}

	}
	/*FUnksioni per te nxerr te dhenat nga databaza sipas parametrav te dhene*/
	public function fetchMarkAtt($classId=null,$sectionId=null,$date=null,$typeId=null,$userId=null)
	{
		/*Shfaqja e te dhenav per sherbimin mark e cila tregon nese jane vlersuar keta studenta ose profesor najher*/
		if ($typeId==1){/*Per studenta*/
			if ($classId && $sectionId && $date && $typeId)
			{
				$sql="SELECT * FROM attendance WHERE class_id =? AND section_id=? AND attendance_date=? AND attendance_type=? AND student_id=?";
				$query=$this->db->query($sql,array($classId,$sectionId,$date,$typeId,$userId));
				return $query->row_array();
			}
			/*Student*/

		}else if($typeId==2){/*per profesora*/
			if ($date && $typeId)
			{
				$sql="SELECT * FROM attendance WHERE attendance_date=? AND attendance_type=? AND teacher_id=?";
				$query=$this->db->query($sql,array($date,$typeId,$userId));
				return $query->row_array();
			}

			/*Teacher*/
		}

	}
	/*Funksoni per te shfaqyr ne raport te dhana*/
	public function getAttendance($day=null,$raportDate=null,$candidatId=null,$typeId,$classId,$sectionId)
	{
		$year=substr($raportDate,0,4);
		$month=substr($raportDate,5,7);

		if($day < 10)
		{
			$day='0'.$day;
		}

		if($typeId==1)
		{
			/*for student ku ban select te dhana duke u bazur ne report date classid section id student id dhe attendance type*/
			$sql="SELECT * FROM attendance WHERE date_format(attendance_date,'%Y-%m-%d')='{$year}-{$month}-{$day}'
            AND class_id={$classId} AND section_id={$sectionId} AND student_id={$candidatId} AND attendance_type={$typeId}";
			$query=$this->db->query($sql);
			return $query->result_array();/*kthimi ne array format*/
		}elseif($typeId==2){
			$sql="SELECT * FROM attendance WHERE date_format(attendance_date,'%Y-%m-%d')='{$year}-{$month}-{$day}' AND teacher_id={$candidatId} AND attendance_type={$typeId}";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

	}

}
