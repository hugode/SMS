<?php
/*Ky modul punon vetum me databazen per insertimin dhe uplode etc*/
class model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*Funksioni per validimin  e username duke testuar ne database*/
	public function validate_username($username=null)
	{
		 if($username){
		 	$sql="SELECT * FROM users WHERE username=?";
		 	$query=$this->db->query($sql,array($username));
		 	$result=$query->row_array();
		 	return ($query->num_rows()===1)?true:false;

		 }
	}
	/*Ky funksion eshte per testimin e passwordid se a ekziston ne db ky password permes id se caktuarr*/
	public function validate_current_password($password=null,$userId=null)
	{
		/*Kuntrollo ne db per kete password me kete id nese ka return true*/
		if($password && $userId){
			$sql="SELECT * FROM users WHERE password=? AND user_id=?";
			$query=$this->db->query($sql,array($password,$userId));
			$result=$query->row_array();
			return ($query->num_rows()===1)?true:false;

		}
	}

	/*Funksioni per login duke testuar a jan te njetat inputet me te dhenat ne db*/
	public function login($username=null,$password=null)
	{
		if($username&&$password)//Nese username dhe password nuk jane null vazhdo me ekzekutimin e kodit
		{
			$sql="SELECT * FROM users WHERE username=? AND password=?";
			$query=$this->db->query($sql,array($username,$password));
			$result=$query->row_array();

			return ($query->num_rows()==1)?$result['user_id']:false;//nese ne database ekziston resht me keto te dhena.kthe user_id

		}else{
			/*Nese username dhe paswword jan null return false*/
			return false;
		}
	}

	/*fetchUserData merr te dhena nga databasa ne baze te id e cila ipet nga perdorimi i keti funksioni*/
	public function fetchUserData($userId=null)
	{
		if($userId)
		{
			$sql="SELECT * FROM users WHERE $userId=?";//selectio te dhenat
			$query=$this->db->query($sql,array($userId));//Nga databaza dhe ruaj ne kete atribut query
			return $query->row_array();//kthe rresultatin
		}
	}

	/*Funksioni per ndryshimin e te dhenave*/
	public function updateProfile($userId=null)
	{
		if($userId)
		{
			/*Ketu e kemi krijuar nje arry me te dhenat te cilat behen input prej field inputat*/
			$update_data=array(
				'username'=>$this->input->post('username'),
				'fname'=>$this->input->post('fname'),
			    'lname'=>$this->input->post('lname'),
			    'email'=>$this->input->post('email'),
			);
			$this->db->where('user_id',$userId);//E kemi gjetur ne cilen id me rujt te dhenat
			$status=$this->db->update('users',$update_data);//dhe ketu kemi bere ndryshimin  e te dhenav permes metodes update
			return ($status==true) ? true : false;

		}else{
			return false;
		}

	}
	/*Funksioni per editimin e passwordit ne databazee*/
	public function changePassword($userId=null)
	{
		if($userId)
		{
			/*Ketu e kemi krijuar nje arry me te dhenat te cilat behen input prej field inputat*/
			$update_data=array(
				'password'=>md5($this->input->post('newPassword')),
			);
			$this->db->where('user_id',$userId);//Verifikimi i i users_id == userid e cila verifikon se a eshte i njejt
			$status=$this->db->update('users',$update_data);//dhe ketu kemi bere ndryshimin  e te dhenav permes metodes update
			return ($status==true) ? true : false;//nese Status eshte true kthe true perndryshe kthe falsse;

		}else{
			return false;
		}

	}
}
