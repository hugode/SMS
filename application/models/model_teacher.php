<?php
class model_teacher extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function create($imgUrl)
	{
		if($imgUrl=='')
		{
			/*Nese imgUrl nuk eshte i caktuar ateher i caktohet kjo url e fotos*/
			$imgUrl='assets/images/teacher/default_avatar.png';
		}
		$insert_data=array(
			/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
			'register_date'=>$this->input->post('registerDate'),
			'fname'=>$this->input->post('fname'),
			'lname'=>$this->input->post('lname'),
			'image'=>$imgUrl,
			'date_of_birth'=>$this->input->post('dob'),
			'age'=>$this->input->post('age'),
			'contact'=>$this->input->post('contact'),
			'email'=>$this->input->post('email'),
			'address'=>$this->input->post('address'),
			'city'=>$this->input->post('city'),
			'country'=>$this->input->post('country'),
			'job_type'=>$this->input->post('jobType'),
		);
		$status=$this->db->insert('teacher',$insert_data);//insertimi ne db
		return($status==true)? true:false;
	}
	/*Funksion per marrjen e te dhenav nga db*/
	public function fetchTeacherData($teacherId=null)
	{
		if($teacherId)
		{
			//kjo do te funksionon per editim specifik te profesorit permes id
			$sql="SELECT * FROM teacher WHERE teacher_id=?";
			$query=$this->db->query($sql,array($teacherId));
			$result = $query->row_array();
			return $result;

		}
		//Kjo funksionon per tableen
		$sql="SELECT * FROM teacher";
		$query=$this->db->query($sql);
		$result = $query->result_array();
		return $result;

	}
	/*Funksioni per fshirjen e profesorit*/
	public function remove($teacher=null)
	{
		if($teacher)
		{
			$this->db->where('teacher_id',$teacher);
			$result=$this->db->delete('teacher');
			return($result==true) ? true : false;
		}
	}
	/*UpdateFunksione sherben per ndryshimin e te dhenave ne database permes id e profesorit*/
	public function updateInfo($teacherId=null)
	{
		if($teacherId)
		{
			$insert_data=array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
				'register_date'=>$this->input->post('editRegisterDate'),
				'fname'=>$this->input->post('editFname'),
				'lname'=>$this->input->post('editLname'),
				'date_of_birth'=>$this->input->post('editDob'),
				'age'=>$this->input->post('editAge'),
				'contact'=>$this->input->post('editContact'),
				'email'=>$this->input->post('editEmail'),
				'address'=>$this->input->post('editAddress'),
				'city'=>$this->input->post('editCity'),
				'country'=>$this->input->post('editCountry'),
				'job_type'=>$this->input->post('editJobType'),
			);
			$this->db->where('teacher_id',$teacherId);
			$status=$this->db->update('teacher',$insert_data);//insertimi ne db
			return($status==true)? true:false;
		}
	}

	/*Funksioni per ndryshimin e fotos*/
	public function updatePhoto($teacherId=null,$imgUrl=null)
	{
		if($teacherId&&$imgUrl)
		{
			$insert_data=array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
				'image'=>$imgUrl

			);
			$this->db->where('teacher_id',$teacherId);
			$status=$this->db->update('teacher',$insert_data);//insertimi ne db
			return($status==true)? true:false;
		}

	}
}
