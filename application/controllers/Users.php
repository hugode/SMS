<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
	public function __construct()
	{
		parent::__construct();

		//Ne fillim do ta bjem uplodim prej user_model
		$this->load->model('model_users');

		//Dhe ngarkimin e formes validuese prej librarise
		$this->load->library('form_validation');

	}
	public function login()
	{

		/*TE ky funksion kemi bere validimin ne formen serverside e cila validon per pjeset te cilat plotesohen*/
		$validator=array('success'=>false,'message'=>array());
		/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
		$validate_data=array(
			array(
				'field'=>'username',
				'label'=>'Username',
				'rules'=>"required|callback_validate_username"
			),
			array(
				'field'=>'password',
				'label'=>'Password',
				'rules'=>"required"
			)
		);
		/*Ketu arryes $validate_data i kemi caktuar regulla*/
		$this->form_validation->set_rules($validate_data);
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run()==true)
		{
			/*Ne keto dy jane rujtur inputet edhe metoda e realizimit post e cila do te ekzekutohen ne
			model_users function login*/
			$username=$this->input->post('username');
			$password=md5($this->input->post('password'));

			$login=$this->model_users->login($username,$password);//login me kete username dhe kete password duke perdorur funksionin ne model_users
			if($login)
			{
				$this->load->library('session');
				$user_data=array(
					'id'=>$login,
					'logged_in'=>true
				);
				$this->session->set_userdata($user_data);
				/*Nese validate  asht success asht true shfaqe qit mesazh*/
				$validator['success']=true;
				$validator['message']="dashboard";
			}
			else
			{
				/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
				$validator['success']=false;
				$validator['message']="Username ose Password Gabim";
			}
		}
		else{
			$validator['success']=false;
			foreach ($_POST as $key=>$value)
			{
				$validator['message'][$key] = form_error($key);//ruj te gjith mesazhet te cilat jan prej errorav
			}
		}
		echo json_encode($validator);//response validator message

	}

	/**
	 * @return object
	 */
	public function validate_username()
	{
		/*Valido username duke e ekzekutuar funksionin validate_username tek classa mode_users*/
		$validate= $this->model_users->validate_username($this->input->post('username'));
		if($validate==true)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate_username','Ky {field} nuk ekziston');
			return false;
		}
	}
	 /*Funksioni per shkyqje nga llogaria*/
	 public function logout()
	 {
	 	$this->load->library('session');//Merre sesionin
	 	$this->session->sess_destroy();//Shkatrro sesionin
	 	redirect('login','refresh');//Masi te shkatrohet sesoni hape loginn page
	 }

	/**/
	public function updateProfile()
	{
		$this->load->library('session');//loaf sesion librari
		$userId=$this->session->userdata('id');

		$validator=array('success'=>false,'message'=>array());//nese succes asht false trego mesazhin
		/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
		$validate_data=array(
			array(
				'field'=>'username',
				'label'=>'Username',
				'rules'=>"required"
			),
			array(
				'field'=>'fname',
				'label'=>'Frist Name',
				'rules'=>"required"
			)
		);
		/*Ketu arryes $validate_data i kemi caktuar regulla*/
		$this->form_validation->set_rules($validate_data);
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run()==true)
		{
			$update=$this->model_users->updateProfile($userId);//Funksioni updateProfile vjen nga model_users
			if($update==true)
			{
				$validator['success']=true;
				$validator['message']='Ndryshimi perfundoi me Sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error Gjate Ndryshimit te Informacionit ne database';

			}
		}else{
			$validator['success']=false;
			foreach ($_POST as $key=>$value)
			{
				$validator['message'][$key] = form_error($key);
			}
		}
		echo json_encode($validator);
	}

	public function changePassword()
	{
		$this->load->library('session');
		$userId=$this->session->userdata('id');

		$validator=array('success'=>false,'message'=>array());
		/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
		$validate_data=array(
			array(
				'field'=>'currentPassword',
				'label'=>'Current Password',
				'rules'=>"required|callback_validate_current_password"
			),
			array(
				'field'=>'newPassword',
				'label'=>'Passwordi i ri',
				'rules'=>"required|matches[confirmPassword]"
			),
			array(
				'field'=>'confirmPassword',
				'label'=>'Konfermimi i Passwordit',
				'rules'=>"required"
			)
		);
		/*Ketu arryes $validate_data i kemi caktuar regulla*/
		$this->form_validation->set_rules($validate_data);
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run()==true)
		{
			$update=$this->model_users->changePassword($userId);//Funksioni changePassword vjen nga model_users
			if($update==true)
			{
				$validator['success']=true;
				$validator['message']='Ndryshimi i paswordit perfundoi me Sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error Gjate Ndryshimit te Informacionit ne database';

			}
		}else{
			$validator['success']=false;//nese asht false
			foreach ($_POST as $key=>$value)
			{
				$validator['message'][$key] = form_error($key);//ruj te qith messages ne validator
			}
		}
		echo json_encode($validator); //return json validator
	}

	public function validate_current_password()//Ky Funksion eshte per validimin e passwordit activ
	{
		$this->load->library('session');//load sessiion
		$userId=$this->session->userdata('id');//id e accountit te loguar ruje ne user id
		$password=md5($this->input->post('currentPassword'));//enkrepto paswwordin dhe merre prej current password of input
		$validate=$this->model_users->validate_current_password($password,$userId);//perdore funksionon adekuat dhe dergo dy atribute
		if($validate==true){
			return true;
		}else{
			$this->form_validation->set_message('validate_current_password','Ky password eshte gabim');//shfaqe kit meshazh
			return false;
		}
	}

}
