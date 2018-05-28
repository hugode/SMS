<?php
class model_subject extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*Fetch ne base te klass id per me nxerr te dhena vetum per klasen e caktuar*/
	public function fetchSubjectDataByClass($classId=null)
	{
		if($classId)
		{
			$sql="SELECT * FROM subject WHERE class_id=?";
			$query=$this->db->query($sql,$classId);
			return $query->result_array();
		}
	}
	/*Funksioni per insertimin e subject me class id foren kye*/
	public function create($classId=null)
	{
		/*Ketu kemi bere krijimin e subject duhke u bazuar ne class id dhe dhe me inputet te cilat jane*/
		if($classId)
		{
			$insert_data=array(
				'name'=>$this->input->post('subjectName'),
				'total_mark'=>$this->input->post('totalMark'),
				'class_id'=> $classId,
				'teacher_id'=>$this->input->post('teacherName')
			);
			$query=$this->db->insert('subject',$insert_data);
			return($query==true)?true:false;
		}
	}
	/*Funskioni per te nxerr te dhenva nga database ne base te subject id*/
	public function fetchSubjectByClassSection($subjectId=null)
	{
		/*Ketu kemi bere fetch subject*/
		$sql="SELECT * FROM subject WHERE subject_id=?";
		$query=$this->db->query($sql,$subjectId);
		return $query->row_array();
	}
	/*Funksioni per update te te dhenave te subjectit*/
	public function update($subjectId=null)
	{
		if ($subjectId) {
			/*I morim te dhanat prej inputav*/

			$update_data = array(
				'name' => $this->input->post("editSubjectName"),
				'total_mark'=>$this->input->post('editTotalMark'),
				'teacher_id' => $this->input->post("editTeacherName")
			);
			$this->db->where('subject_id', $subjectId);//tregoim se ne cilen id te subject me u ndryshi
			$result=$this->db->update('subject',$update_data);//dhe ketu behet ndryshimi
			return ($result==true)?true:false;//ketu nese result asht true kthe true perndryshe false
		}
	}
	/*Funksioni per fshirjen e subject*/
	public function remove($subjectId=null)
	{
		if ($subjectId)
		{
			$this->db->where('subject_id',$subjectId);
			$result=$this->db->delete('subject');
			return ($result==true)?true:false;
		}

	}

}
