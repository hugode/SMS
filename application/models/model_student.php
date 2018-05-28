<?php
class model_student extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/*Funksioni per Krijimin e studentit*/
	public function create($imgUrl)
	{
		/*Kjo asht pjesa per te shtuar nje student me te gjitha te dhenat e plotesuara*/
		if($imgUrl=='')
		{
			/*Nese imgUrl nuk eshte i caktuar ateher i caktohet kjo url e fotos*/
			$imgUrl='assets/images/teacher/default_avatar.png';
		}
		$insert_data=array(
			/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
			'register_date'=>$this->input->post('registerDate'),
			'class_id'=>$this->input->post('className'),
			'section_id'=>$this->input->post('sectionName'),
			'fname'=>$this->input->post('fname'),
			'lname'=>$this->input->post('lname'),
			'image'=>$imgUrl,
			'dob'=>$this->input->post('dob'),
			'age'=>$this->input->post('age'),
			'contact'=>$this->input->post('contact'),
			'email'=>$this->input->post('email'),
			'address'=>$this->input->post('address'),
			'city'=>$this->input->post('city'),
			'country'=>$this->input->post('country'),
		);
		$status=$this->db->insert('student',$insert_data);//insertimi ne db
		return($status==true)? true:false;
	}
	/*Funksoni per krijimin e shums studentav ne databas prej opsionit opt*/
	public function createBulk()
	{
		/*Ky funksion sherben per futjen e nje grup studentash me nje komande*/

		for ($x=1; $x <=count($this->input->post('bulkstfname')); $x++) {
			$insert_data = array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/

				'class_id' => $this->input->post('bulkstclassName')[$x],
				'section_id' => $this->input->post('bulkstsectionName')[$x],
				'image' =>'assets/images/default_avatar.png',
				'fname' => $this->input->post('bulkstfname')[$x],
				'lname' => $this->input->post('bulkstlname')[$x],
			);
			$status=$this->db->insert('student',$insert_data);//insertimi ne db
		}
		return($status==true)? true:false;
	}

	/*Funksionet me posht jan per menagjimin e studentav*/
	/*-------------------------------------------------------------------------------------*/
	/*Ky funksoon eshte per te nxerr studenta sipas classid*/
	public function fetchStudentDataByClass($classId=null)
	{
		/*Kjo pjese sherben per nxerrjen e studentav sipas class_id*/
		if ($classId)
		{
				$sql='SELECT * FROM student WHERE class_id=?';
				$query=$this->db->query($sql,array($classId));
				return $query->result_array();
		}
	}
	/*Funksioni per te nxerr te dhena nga databasa per pjesen e sektorit bashk me klass*/
	public function fetchStudentDataByClassAndSection($classId=null,$sectionId=null)
	{
		/*Ketu kemi nxerr studentat qe jane me classiD adekuate dhe sectionid adekuat*/
		if ($classId)
		{
			$sql='SELECT * FROM student WHERE class_id=? AND section_id=?';
			$query=$this->db->query($sql,array($classId,$sectionId));
			return $query->result_array();
		}
	}
	/*Funksioni oer editimin e fotos*/
	public function updatePhoto($studentId=null,$imgUrl=null)
	{
		if($studentId&&$imgUrl)
		{
			/*Kjo pjese sherben per editimin e fotos te studentit adekuat i cili specifikohet sipas id*/
			$insert_data=array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
				'image'=>$imgUrl

			);
			$this->db->where('student_id',$studentId);
			$status=$this->db->update('student',$insert_data);//insertimi ne db
			return($status==true)? true:false;
		}

	}
	/*Nxerrja e te dhenav nga databaza*/
	public function fetchStudentData($studentID=null)
	{
		if($studentID)
		{
			//kjo do te funksionon per editim specifik te profesorit permes id
			/*Ketu kemi more te dhenat e sttudentit sipas id dhe e kami kthyr me ni row array ne resul*/
			$sql="SELECT * FROM student WHERE student_id=?";
			$query=$this->db->query($sql,array($studentID));
			$result = $query->row_array();
			return $result;

		}
	}
	/*Funksoni per fhsirjen e studentit nga databasa sipas id*/
	public function remove($studenti=null)
	{
		if($studenti)
		{
			/*E kemi gjetur studentin sipas id dhe e kemi fshir studentin sipas id*/
			$this->db->where('student_id',$studenti);
			$result=$this->db->delete('student');
			return($result==true) ? true : false;
		}
	}
	/*Funksoni per editmin e te dhenave te sttudentit*/
	public function updateInfo($studentId=null)
	{
		if($studentId)
		{
			$update_data=array(
				/*Ne kete form kemi mor te dhenat prej inputav dhe i kemi derguar ne db*/
				'register_date'=>$this->input->post('editRegisterDate'),
				'class_id'=>$this->input->post('editClassName'),
				'section_id'=>$this->input->post('editSection'),
				'fname'=>$this->input->post('editFname'),
				'lname'=>$this->input->post('editLname'),
				'age'=>$this->input->post('editAge'),
				'dob'=>$this->input->post('editDob'),
				'contact'=>$this->input->post('editContact'),
				'email'=>$this->input->post('editEmail'),
				'address'=>$this->input->post('editAddress'),
				'city'=>$this->input->post('editCity'),
				'country'=>$this->input->post('editCountry'),
			);
			$this->db->where('student_id',$studentId);
			$status=$this->db->update('student',$update_data);//insertimi ne db
			return($status==true)? true:false;
		}
	}
	/*--------------------------------------------------------------------------------------*/
}
