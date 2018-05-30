<?php

class Student extends CI_Controller{

	public function __construct()
	{
			parent::__construct();
			$this->load->model('user_model');
			$this->load->model('marks_model');
			$this->load->model('avg_model');
			$this->load->model('abs_model');
			$this->load->model('lessons_model');
			$this->load->helper('url_helper');
			$this->load->library('session');
			$this->load->library('time');
	}

	public function getAllMarks(){
		$user_id = $this->session->user_id;
		$year = $this->time->get_year_us($this->time->get_current_date(), 'us');
		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
		return $this->marks_model->getAllMarks($user_id, $year, $sem);
	}

	public function getAllAbsences(){
		$user_id = $this->session->user_id;
		$year = $this->time->get_year_us($this->time->get_current_date(), 'us');
		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
		return $this->abs_model->getAllAbsences($user_id, $year, $sem);
	}
	
    public function view($subpage = 'marks'){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$data['title'] = 'Student Page';
            $class_id = $this->session->class_id;
			$user_id = $this->session->user_id;
			
			$checkUsr = $this->user_model->get_user_where('status, class_id, profil', $user_id, $class_id);
			
			if($checkUsr['status'] == 'st' && $checkUsr['class_id'] == $class_id){

			$data['subpage'] = $subpage;
            $name = $this->user_model->get_name($user_id);
			$data['fullname'] = $name['fullname'];
			$data['stat_mrk'] = '';
			$data['stat_abs'] = '';
			$data['page'] = 'student';
			$year = $this->time->get_year_us($this->time->get_current_date(), 'us');
			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			
			if($subpage == 'marks'){
				$data['stat_mrk'] = 'menuElActive';
				$data['marks'] = $this->getAllMarks();
				$data['avgs'] = $this->avg_model->getAllAvgs($user_id, $year, $sem);
			}elseif($subpage == 'absences'){
				$data['stat_abs'] = 'menuElActive';
				$data['abs'] = $this->getAllAbsences();
			}

			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			$data['semMin'] = $this->time->semMin($sem);
			$data['semMax'] = $this->time->semMax($sem);

			$this->load->view('templates/header', $data);
			$this->load->view('student/st', $data);
			$this->load->view('templates/footer', $data);
			}else{
				redirect('/');
			}
		}else{
			redirect('/');
		}
	}
}