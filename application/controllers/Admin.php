<?php
class Admin extends CI_Controller{
	
	public function __construct()
	{
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

	public function get_object_list(){
		$data = $this->lessons_model->get_all_lessons();

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function showAllClasses(){
		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			$data['classes'] = $this->user_model->get_all_classes();

			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

	private function randomPassword() { // From StackOverflow cause I'm lazy af XD.
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 9; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function regNewClass(){
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$className = $this->input->post('className');
		$years = $this->input->post('years');
		$profil = $this->input->post('profil');
		
		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;

		header('Content-Type: application/json');
		$className = strtoupper($className);
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			if($this->type->getType() == 'lc' && strlen($className) >= 2 && strlen($className) <= 3 || $this->type->getType() == 'clg' && strlen($className) >= 4 && strlen($className) <= 5){
				$checkClass = $this->user_model->checkClass($className);
				if(!isset($checkClass['class'])){
					$login = ucfirst(strtolower($lastname)) . '-' . rand(111,999);
					$login = str_replace(array("ş","ţ","ă"),array("s","t","a"), $login);
					$password = $this->randomPassword();
					$this->user_model->regNewClass($firstname, $lastname, $className, $years, $profil, $login, $password);
		
		
					$date = $this->time->get_current_date();
					$year = $this->time->get_year_us($date);
		
					$infoFile = fopen("miscData/secretinfo.txt", "a+");
					fwrite($infoFile, "\n$firstname $lastname — Class: $className — Login: $login — Pass: $password — Stat: dir — $year ;\n");
					fclose($infoFile);
					
					
					echo json_encode(array('text'=>"Clasa $className a fost cu succes inregistrata!", 'type'=>'succ'));
				}else{
					echo json_encode(array('text'=>"Clasa $className deja exista!", 'type'=>'fail'));
				}
			}else{
				echo json_encode(array('text'=>"Clasa $className are o denumire incorecta!" . $checkClass['class'], 'type'=>'fail'));
			}
		}
	}

	public function view($subpage = 'classes'){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$data['title'] = 'Admin Page';
            $class_id = $this->session->class_id;
			$user_id = $this->session->user_id;
			
			$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
			
			if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){

				$data['subpage'] = $subpage;
				$name = $this->user_model->get_name($user_id);
				$data['fullname'] = $name['fullname'];
				$data['stat_cls'] = '';
				$data['stat_lsn'] = '';
				$data['stat_cls_reg'] = '';
				$data['page'] = 'admin';
				$data['type'] = $this->type->getType();
				$year = $this->time->get_year_us($this->time->get_current_date(), 'us');
				$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
				
				if($subpage == 'classes'){
					$data['stat_cls'] = 'menuElActive';
					// TODO: Show an overview of all active classes data
				}elseif($subpage == 'dynamic_lessons'){
					$data['stat_lsn'] = 'menuElActive';
					$data['classes'] = $this->user_model->get_all_classes();
				}elseif($subpage == 'reg_class'){
					$data['stat_cls_reg'] = 'menuElActive';
				}

				$this->load->view('templates/header', $data);
				$this->load->view('admin/main', $data);
				$this->load->view('templates/admin_modals', $data);
				$this->load->view('templates/footer', $data);
			}else{
				redirect('/');
			}
		}else{
			redirect('/');
		}
	}
}