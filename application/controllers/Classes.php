<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		/*Loading the model_clases(Ngarkimi i classes model*/
		$this->load->model('model_classes');
		/*Loading  the form validation*/
		$this->load->library('form_validation');


	}
	public function create()
	{
		$validator=array('success'=>false,'message'=>array());
		$validate_data=array(
			array(
				'field'=>'className',
				'label'=>'Emri i Klases',
				'rules'=>"required|callback_validate_className"
			),
			array(
				'field'=>'numricName',
				'label'=>'Numri i Klasses',
				'rules'=>"required|callback_validate_numericName"
			),
		);
		//Dhe ketu kemi caktuar erroret rregullat
		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');//Ketu e kemi dizajnu errorin i cili ka mu shfaq

		if($this->form_validation->run()==true)//Nese forma e validimi funksionjon ateher qoi te dhenat ne mdulin model_classes per insertimi
		{
			/*Insert data into db form funksionit te cilit do ta perdorim ne model_classes*/
			$create =$this->model_classes->create();
			if($create===true)
			{
				$validator['success']=true;
				$validator['message']='Procesi per Regjistrimin e Klases perfundoi me sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error :Procesi per Regjistrimin Shkoi Gabim';

			}

		}else{
			$validator['success']=false;
			foreach ($_POST as$key=>$value){
				$validator['message'][$key]=form_error($key);
			}
		}
		echo json_encode($validator);

	}
	/*Funksioni per nxerrje te dhenav dhe per strukturimin e tyre dhe ne menyre specifike permes id*/
	public function fetchclasesData($classId=null)
	{
		if($classId)
		{
			//nxerr data ne menyre specifike
			$result=$this->model_classes->fetchclasesData($classId);
		}
		else
		{
			$classesData=$this->model_classes->fetchclasesData();//Nxerrja e te dhenave ne total
			$result= array('data',array());
			foreach ($classesData as $key=>$value) {
				/*Shfaqja e buttonave edditues dhe delete ne qdo profesor id*/
				$buttons='<div class="btn-group">
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action <span class="caret"></span>
                       </button>
                     <ul class="dropdown-menu">
                        <li><a type="button"  data-toggle="modal" data-target="#editClass" onclick="editClass('.$value['class_id'].')">
                                 <i class="glyphicon glyphicon-edit"></i></>Edito Klasen</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a type="button"  data-toggle="modal" data-target="#removeClassModel" onclick="deleteClass('.$value['class_id'].')">
                        <i class="glyphicon glyphicon-trash"></i></>Fshije Klasen</a>
                        </li>
     
                    </ul>
                   </div>';
				$result['data'][$key]=array(

					$value['class_id'],
					$value['class_name'],
					$value['numeric_name'],
					$buttons//insertimi i buttonav
				);


			}

		}
		echo json_encode($result);//response me te dhenav nga db

	}
	/*Ky funksion validate_className do te sherbej per te kontrolluar se a ka kalass ne dabase me emrin e kalses se re*/
	public function validate_className()
	{
		$validate=$this->model_classes->validate_className();
		if($validate==true)
		{
			$this->form_validation->set_message('validate_className','Ky emer Ekziston nuk mund vazhdoni');
			return false;
		}else{
			return true;
		}
	}
	/*Ky funksion validate_numericName do te sherbej per te kontrolluar se a ka kalass ne dabase me emrin e kalses se re*/
	public function validate_numericName()
	{
		$validate=$this->model_classes->validate_numericName();
		if($validate==true)
		{
			$this->form_validation->set_message('validate_numericName','Ky numer i klases ekziston nuk mund vazhdoni');
			return false;
		}else{
			return true;
		}
	}
	/*Validimi per editClassNumri*/
	public function validate_editClassName()
	{
		$validate=$this->model_classes->validate_editClassName();
		if($validate==true)
		{
			$this->form_validation->set_message('validate_editClassName','Ky emer Ekziston nuk mund vazhdoni');
			return false;
		}else{
			return true;
		}
	}
	/*Funksioni per testimin se a ekziston ky numeric name*/
	public function validate_editNumericName()
	{
		$validate=$this->model_classes->validate_editNumericName();
		if($validate==true)
		{
			$this->form_validation->set_message('validate_editNumericName','Ky numer i klases ekziston nuk mund vazhdoni');
			return false;
		}else{
			return true;
		}
	}
	/*Editimi i klases*/
	public function update($classId=null)
	{
		if($classId) {
			$validator = array('success' => false, 'message' => array());
			$validate_data = array(
				array(
					'field' => 'editClassName',
					'label' => 'Emri i Klases',
					'rules' => "required|callback_validate_editClassName"
				),
				array(
					'field' => 'editNumricName',
					'label' => 'Numri i Klasses',
					'rules' => "required|callback_validate_editNumericName"
				),
			);
			//Dhe ketu kemi caktuar erroret rregullat
			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');//Ketu e kemi dizajnu errorin i cili ka mu shfaq

			if ($this->form_validation->run() == true)//Nese forma e validimi funksionjon ateher qoi te dhenat ne mdulin model_classes per insertimi
			{
				/*Insert data into db form funksionit te cilit do ta perdorim ne model_classes*/
				$update = $this->model_classes->update($classId);
				if ($update === true) {
					$validator['success'] = true;
					$validator['message'] = 'Procesi per Editimin  e Klases perfundoi me sukses';
				} else {
					$validator['success'] = false;
					$validator['message'] = 'Error :Procesi per Editimin Shkoi Gabim';

				}

			} else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['message'][$key] = form_error($key);
				}
			}
			echo json_encode($validator);
		}

	}
	/*Funksioni per fshirjen e kalses validimi*/
	public function remove($classId=null)
	{
		if ($classId)
		{
			$remove=$this->model_classes->remove($classId);
			if ($remove===true)
			{
				$validator['success']=true;
				$validator['message']='Procesi per fshirjen e klases u krye me sukses';
			}else{
				$validator['success']=false;
				$validator['message']='Error->Procesi per fshirjen e klases shkoi wrong';
			}
			echo json_encode($validator);
		}
	}
}
