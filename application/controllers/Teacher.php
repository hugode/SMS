<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		/*Ngarkimi i model teacher*/
		$this->load->model('model_teacher');


		/*Loding the form validation library*/

		$this->load->library('form_validation');


	}
	/*Create Funksionon*/
	public function create()
	{

		/*TE ky funksion kemi bere validimin ne formen serverside e cila validon per pjeset te cilat plotesohen*/
		$validator=array('success'=>false,'message'=>array());
		/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
		$validate_data=array(
			array(
				'field'=>'fname',
				'label'=>'Emri',
				'rules'=>"required"
			),
			array(
				'field'=>'lname',
				'label'=>'Mbiemri',
				'rules'=>"required"
			),
			array(
				'field'=>'dob',
				'label'=>'Data e Lindjes',
				'rules'=>"required"
			),
			array(
				'field'=>'age',
				'label'=>'Mosha',
				'rules'=>"required"
			),
			array(
				'field'=>'contact',
				'label'=>'Kontakti',
				'rules'=>"required"
			),
			array(
				'field'=>'email',
				'label'=>'Email',
				'rules'=>"required"
			),
			array(
				'field'=>'registerDate',
				'label'=>'Data e Regjistrimit',
				'rules'=>"required"
			),
			array(
				'field'=>'jobType',
				'label'=>'Lloji Punes',
				'rules'=>"required"
			),array(
				'field'=>'address',
				'label'=>'Adresa',
				'rules'=>"required"
			),
			array(
				'field'=>'city',
				'label'=>'Qyteti',
				'rules'=>"required"
			),
			array(
				'field'=>'country',
				'label'=>'Shteti',
				'rules'=>"required"
			)
		);
		/*Ketu arryes $validate_data i kemi caktuar regulla*/
		$this->form_validation->set_rules($validate_data);
		//Dhe ketu kemi caktuar erroret
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if($this->form_validation->run()==true)
		{
			$imgUrl=$this->uplodeImage();
			$create=$this->model_teacher->create($imgUrl);//login me kete username dhe kete password duke perdorur funksionin ne model_teacher
			if($create)
			{
				/*Nese validate  asht success asht true shfaqe qit mesazh*/
				$validator['success']=true;
				$validator['message']="Profesori u Shtua me Sukses";
			}
			else
			{
				/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
				$validator['success']=false;
				$validator['message']="error";
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

	/*Funksioni per uplodimin e Image*/
	public function uplodeImage()
	{
		$type=explode('.',$_FILES['photo']['name']);
		$type=$type[count($type)-1];
		$url='assets/images/teacher/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif','jpg','jpeg','png','JPG','GIF','JPEG','PNG'))){
			if(is_uploaded_file($_FILES['photo']['tmp_name']))
			{
				if(move_uploaded_file($_FILES['photo']['tmp_name'],$url))
				{
					return $url;
				}else{
					return false;
				}
			}

		}

	}

	//Funksioni per nxerrjen e te dhenave nga db
	public function fetchTeacherData($teacherId=null)
	{
		if($teacherId)
		{
			//nxerr data ne menyre specifike
			$result=$this->model_teacher->fetchTeacherData($teacherId);
		}
		else
		{
			$teacherData=$this->model_teacher->fetchTeacherData();//Nxerrja e te dhenave ne total
			$result= array('data',array());

			foreach ($teacherData as $key=>$value) {
				/*Shfaqja e buttonave edditues dhe delete ne qdo profesor id*/
				$buttons='<div class="btn-group">
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#updateTeacherModal" onclick="editTeacher('.$value['teacher_id'].')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Profesorin</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeTeacherModal" onclick="removeTeacher('.$value['teacher_id'].')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshije Profesorin</a>
                        </li>
     
                    </ul>
                   </div>';
				$photo='<img src="'.base_url().$value['image'].'" alt="photo" class="img-circle candidate-photo"/>';//marrja url e fotos

				$result['data'][$key]=array(

					$photo,
					$value['fname'].' '.$value['lname'],
					$value['age'],
					$value['contact'],
					$value['email'],
					$buttons//insertimi i buttonav
				);
				
			}

		}
		echo json_encode($result);//response me te dhenav nga db

	}
	/*UpdatePhoto*/
	public function updatePhoto($teacherId=null)
	{
		//validimi i fotos
		if($teacherId)
		{
			$validator=array('success'=>false,'message'=>array());
			/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/

			if(empty($_FILES['editPhoto']['tmp_name']))
			{

					/*Nese validate  asht success asht true shfaqe qit mesazh*/
					$validator['success']=false;
					$validator['message']="Foto Duhet te Selectohet";

			}
			else{
				$img=$this->editUplodeImage();//marrja e url se fotos se selectuar
				$update=$this->model_teacher->updatePhoto($teacherId,$img);//ekzekutimi i funksionit ne model_teacher class
				if($update==true)
				{
					$validator['success']=true;
					$validator['message']="Procesi per Ndryshimin e Fotos u krye me Suksess";
				}else{
					$validator['success']=false;
					$validator['message']="Error Gjate Ndryshimit te fotos";
				}
			}
			echo json_encode($validator);//response validator message
		}

	}
	/*editUplodeImage funksion per editimin e fotos*/
	public function editUplodeImage()
	{
		$type=explode('.',$_FILES['editPhoto']['name']);
		$type=$type[count($type)-1];
		$url='assets/images/teacher/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif','jpg','jpeg','png','JPG','GIF','JPEG','PNG'))){
			if(is_uploaded_file($_FILES['editPhoto']['tmp_name']))
			{
				if(move_uploaded_file($_FILES['editPhoto']['tmp_name'],$url))
				{
					return $url;
				}else{
					return false;
				}
			}

		}

	}
	/*Validimi per fshirjen e profesorit*/
	public function remove($teacherId=null)
	{
		$validator=array('success'=>false,'message'=>array());
		if($teacherId)
		{
			$remove=$this->model_teacher->remove($teacherId);
			if($remove)
			{
				$validator['success']=true;
				$validator['message']='Profesori u Fshir me sukses';
			}else
			{
				$validator['success']=false;
				$validator['message']='Error Gjat Fshirjes se Profesorit';
			}
		}
		echo json_encode($validator);
	}
	/*Funksioni per ndryshimin e te dheanve te teacher*/
	public function updateInfo($teacherId=null)
	{
		if($teacherId)
		{
			/*TE ky funksion kemi bere validimin ne formen serverside e cila validon per pjeset te cilat plotesohen*/
			$validator=array('success'=>false,'message'=>array());
			/*Ketu kemi krijuar nje array me ipnutat te cilet duhet te validohen*/
			$validate_data=array(
				array(
					'field'=>'editFname',
					'label'=>'Emri',
					'rules'=>"required"
				),
				array(
					'field'=>'editLname',
					'label'=>'Mbiemri',
					'rules'=>"required"
				),
				array(
					'field'=>'editDob',
					'label'=>'Data e Lindjes',
					'rules'=>"required"
				),
				array(
					'field'=>'editAge',
					'label'=>'Mosha',
					'rules'=>"required"
				),
				array(
					'field'=>'editContact',
					'label'=>'Kontakti',
					'rules'=>"required"
				),
				array(
					'field'=>'editEmail',
					'label'=>'Email',
					'rules'=>"required"
				),
				array(
					'field'=>'editRegisterDate',
					'label'=>'Data e Regjistrimit',
					'rules'=>"required"
				),
				array(
					'field'=>'editJobType',
					'label'=>'Lloji Punes',
					'rules'=>"required"
				),array(
					'field'=>'editAddress',
					'label'=>'Adresa',
					'rules'=>"required"
				),
				array(
					'field'=>'editCity',
					'label'=>'Qyteti',
					'rules'=>"required"
				),
				array(
					'field'=>'editCountry',
					'label'=>'Shteti',
					'rules'=>"required"
				)
			);
			/*Ketu arryes $validate_data i kemi caktuar regulla*/
			$this->form_validation->set_rules($validate_data);
			//Dhe ketu kemi caktuar erroret
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if($this->form_validation->run()==true)
			{
				$updateInfo=$this->model_teacher->updateInfo($teacherId);//login me kete username dhe kete password duke perdorur funksionin ne model_teacher
				if($updateInfo)
				{
					/*Nese validate  asht success asht true shfaqe qit mesazh*/
					$validator['success']=true;
					$validator['message']="Ndryshimi perfundoi me sukses";
				}
				else
				{
					/*Nese validate nuk asht success asht false shfaqe qit mesazh*/
					$validator['success']=false;
					$validator['message']="error Gjate procesit per ndryshimin e te dhenave";
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

	}



}
