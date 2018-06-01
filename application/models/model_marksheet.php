<?php
class model_marksheet extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
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
			$insert_data=array(
				'marksheet_name'=>$this->input->post('marksheetName'),
				'class_id'=> $classId,
				'marksheet_date'=>$this->input->post('examDate')
			);
			$query=$this->db->insert('marksheet',$insert_data);
			return($query==true)?true:false;
		}
	}
}
