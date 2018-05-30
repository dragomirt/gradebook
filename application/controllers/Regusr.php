<?php
class Regusr extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('marks_model');
		$this->load->model('lessons_model');
		$this->load->model('abs_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
		$this->load->library('time');
		$this->load->library('type');
	}

	public function getStudents(){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;

			$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){
				$students = $this->user_model->get_students_list($class_id);
				return $students;
			}
		}
	}

	public function add_usr(){
		if(isset($this->session->class_id) && isset($this->session->user_id)){

			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;
			$checkUsr = $this->user_model->get_user_where('status, class_id, profil', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){

				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$language = $this->input->post('language');
				if(isset($firstname) && isset($lastname) && isset($language)){

					$firstname = ucfirst(strtolower($firstname));
					$lastname = ucfirst(strtolower($lastname));
	
					$pass = $this->randomPassword();
					$login = ucfirst(strtolower($lastname)) . '-' . rand(111,999);
					$login = str_replace(array("ş","ţ","ă"),array("s","t","a"), $login);

					$date = $this->time->get_current_date();
					$year = $this->time->get_year_us($date);
	
					$infoFile = fopen("miscData/secretinfo.txt", "a+");
					fwrite($infoFile, "\n$firstname $lastname — Class Id: $class_id — Login: $login — Pass: $pass — Stat: st — Year: \n");
					fclose($infoFile);
	
					$this->user_model->add_user($firstname, $lastname, $language, $login, $pass);
					header('Content-Type: application/json');
					echo json_encode(array('text'=>"Elevul $firstname $lastname a fost cu succes inregistrat!", 'type'=>'succ'));
				}
			}
		}
	}

	public function view(){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$data['title'] = 'Students Control Page';
			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;

			$checkUsr = $this->user_model->get_user_where('status, class_id, profil', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){
				
				$data['page'] = 'userReg';
				$data['students'] = $this->getStudents();
				$data['type'] = $this->type->getType();
				$data['profil'] = $checkUsr['profil'];

				$this->load->view('templates/header', $data);
				$this->load->view('regusr/main', $data);
				$this->load->view('templates/modals', $data);
				$this->load->view('templates/footer', $data);
			}else{
				redirect('/');
			}
		}else{
			redirect('/');
		}
	}
}