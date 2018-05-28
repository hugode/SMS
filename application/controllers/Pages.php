<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {


	public function view($page='Login')
	{
		if(!file_exists(APPPATH.'views/'.$page.'.php')){
			show_404();
		}
		/*-------------------------------------------------------------------------------*/
		if($page=="setting")//Nese faqja asht settings ngarkoi keto te dhena
		{
			$this->load->model('model_users');//Ngarko model_users nga model
			$this->load->library('session');//ngarko session from library
			$userId=$this->session->userdata('id');// dhe ruje te dhenat e sesionit activ ne kete variable
			$data['userdata']=$this->model_users->fetchUserData($userId);//fetch user data eshte funksion ne clasen model users


		}
		/*------------------------------------------------------------------------------*/
		if ($page=="section")
		{
			$this->load->model('model_classes');//looding the model_clases
			$data['classData']=$this->model_classes->fetchclasesData();
			/*Loadinf techer model per te mor te dhena dhe per te insertuar*/
			$this->load->model('model_teacher');
			$data['teacherData']=$this->model_teacher->fetchTeacherData();
		}
		/*-----------------------------------------------------------------------------*/
		if ($page=="subject")
		{
			$this->load->model('model_classes');//looding the model_clases
			$data['classData']=$this->model_classes->fetchclasesData();
			/*Loadinf techer model per te mor te dhena dhe per te insertuar*/
			$this->load->model('model_teacher');
			$data['teacherData']=$this->model_teacher->fetchTeacherData();
		}
		/*-------------------------------------------------------------------------------*/
		if ($page=="student")
		{
			$this->load->model('model_classes');//looding the model_clases
			$data['classData']=$this->model_classes->fetchclasesData();
			/*Loadinf techer model per te mor te dhena dhe per te insertuar*/
			$this->load->model('model_teacher');
			$data['teacherData']=$this->model_teacher->fetchTeacherData();
		}
		/*-------------------------------------------------------------------------------*/
		$data['title']=ucfirst($page);
		if($page=='login'){
			$this->isLoggedIn();
			//$this->load->view($page,$data);
		}else{

			$this->isNotLoggedIn();//Funksion i thirru nga clasa e trashiiguar per te kontrolluar loginin
			$this->load->view('templates/header',$data);
			//$this->load->view($page,$data);
			$this->load->view('templates/footer',$data);
		}
		$this->load->view($page,$data);

	}
}
