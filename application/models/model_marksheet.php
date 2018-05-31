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
}
