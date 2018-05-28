<?php
class model_section extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*Fetch ne base te klass id per me nxerr te dhena vetum per klasen e caktuar*/
	public function fetchSectionDataByClass($classId=null)
	{
		if($classId)
		{
			$sql="SELECT * FROM section WHERE class_id=?";
			$query=$this->db->query($sql,$classId);
			return $query->result_array();
		}
	}
	/*Funksioni per insertimin e section me class id foren kye*/
	public function create($classId=null)
	{
		/*Ketu kemi bere krijimin e sectionit duhke u bazuar ne class id dhe dhe me inputet te cilat jane*/
		if($classId)
		{
			$insert_data=array(
					'section_name'=>$this->input->post('sectionName'),
					'class_id'=> $classId,
			        'teacher_id'=>$this->input->post('teacherName')
			);
			$query=$this->db->insert('section',$insert_data);
			return($query==true)?true:false;
		}
	}
	/*Funskioni per te nxerr te dhenva nga database ne base te section id*/
	public function fetchSectionByClassSection($sectionId=null)
	{
		/*Ketu kemi bere fetch sectionet*/
		$sql="SELECT * FROM section WHERE section_id=?";
		$query=$this->db->query($sql,$sectionId);
		return $query->row_array();
	}
	/*Funksioni per update te te dhenave te sectionit*/
	public function update($sectionId)
	{
		if ($sectionId) {
			/*I morim te dhanat prej inputav*/

		   $update_data = array(
			  'section_name' => $this->input->post("editSectionName"),
			  'teacher_id' => $this->input->post("editTeacherName")
		   );
		   $this->db->where('section_id', $sectionId);//tregoim se ne cilen id te section me u ndryshi
		   $result=$this->db->update('section',$update_data);//dhe ketu behet ndryshimi
		   return ($result==true)?true:false;//ketu nese result asht true kthe true perndryshe false
		}
	}
	/*Funksioni per fshirjen e section*/
	public function remove($sectionId=null)
	{
		if ($sectionId)
		{
			$this->db->where('section_id',$sectionId);
			$result=$this->db->delete('section');
			return ($result==true)?true:false;
		}

	}

}
