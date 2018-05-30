<?php

class Login extends CI_Controller{

	public function __construct()
	{
			parent::__construct();
			$this->load->model('user_model');
			$this->load->helper('url_helper');
			$this->load->library('session');
	}

	public function choice($usrStatus, $class_id){
		if($usrStatus == 'adm'){
			redirect('/admin/view/');
		}elseif($usrStatus == 'dir'){
			redirect('/teacher/view/');
		}elseif($usrStatus == 'st'){
			redirect('/student/view/');
		}
	}
	
	public function sign_in(){
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$data['title'] = 'Sign In';
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('login/sign_in.php');
			$this->load->view('templates/footer');
		}
		else
		{
			$data['user'] = $this->user_model->login_user();
			if(is_null($data['user']['status'])){
				$data['title'] = 'Sign In';
				$this->load->view('templates/header', $data);
				$this->load->view('login/sign_in.php');
				$this->load->view('templates/footer');
			}else{
				$this->session->set_userdata(array('class_id'=> $data['user']['class_id'], 'user_id'=> $data['user']['user_id']));
				$this->choice($data['user']['status']);
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
	}
}