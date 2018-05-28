<?php
class model_classes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*FUnksioni i krijimit te klases*/
	public function create()
	{
		$insert_data=array(
			'class_name'=>$this->input->post('className'),
			'numeric_name'=>$this->input->post('numricName')
		);
		$status=$this->db->insert('class',$insert_data);
		return ($status==true)?true :false;
	}
	public function fetchclasesData($classId=null)
	{
		if($classId)
		{
			//kjo do te funksionon per editim specifik te profesorit permes id
			$sql="SELECT * FROM class WHERE class_id=?";
			$query=$this->db->query($sql,array($classId));
			$result = $query->row_array();
			return $result;

		}
		//Kjo funksionon per tableen
		$sql="SELECT * FROM class";
		$query=$this->db->query($sql);
		$result = $query->result_array();
		return $result;

	}
	/*Funksioni per kontrollimin ne databaze se a ekziston ky emer se vjen prej inputit me ata te databases*/
	public function validate_className()
	{
		$className=$this->input->post('className');
		$sql="SELECT * FROM class WHERE class_name=?";
		$query=$this->db->query($sql,array($className));
		return($query->num_rows()===1)?true:false;
	}
	/*Funksioni per kontrollimin ne databaze se a ekziston ky numer i klasses se vjen prej inputit me ata te databases*/
	public function validate_numericName()
	{
		$numericName=$this->input->post('numricName');
		$sql="SELECT * FROM class WHERE numeric_name=?";
		$query=$this->db->query($sql,array($numericName));
		return($query->num_rows()===1)?true:false;

	}
	/*Validimi per editmin se a ekziston ky emer ne db*/
	public function validate_editClassName()
	{
		$class_id=$this->input->post('edit_class_id');
		$editclassName=$this->input->post('editClassName');
		$sql="SELECT * FROM class WHERE class_name=? AND class_id !=?";
		$query=$this->db->query($sql,array($editclassName,$class_id));
		return($query->num_rows()===1)?true:false;

	}
	/*Testim per editValidimin*/
	public function validate_editNumericName()
	{
		$class_id=$this->input->post('edit_class_id');
		$editNumericName=$this->input->post('editNumricName');
		$sql="SELECT * FROM class WHERE numeric_name=? AND class_id !=?";
		$query=$this->db->query($sql,array($editNumericName,$class_id));
		return($query->num_rows()===1)?true:false;

	}
	/*funksioni per editimin e te dhenav se klases*/
	public function update($classId=null)
	{
		if($classId)
		{
			$update_data=array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
				'class_name'=>$this->input->post('editClassName'),
				'numeric_name'=>$this->input->post('editNumricName'),
			);
			$this->db->where('class_id',$classId);
			$status=$this->db->update('class',$update_data);//insertimi ne db
			return($status==true)? true:false;
		}
	}
	/*Funksioni per fshrijen e klases ne database sipas id*/
	public function remove($classId=null)
	{
		if ($classId)
		{
			$this->db->where('class_id',$classId);
			$result=$this->db->delete('class');
			return ($result===true)?true:false;
		}
	}
}
