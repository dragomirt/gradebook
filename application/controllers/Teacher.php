<?php

class Teacher extends CI_Controller{

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

	public function display_current_marks(){
		$lesson = $this->input->post('lesson');
		$class_id = $this->session->class_id;
		$date = $this->time->get_current_date();
		$year = $this->time->get_year_us($date);
		$sem = $this->time->get_sem($date, 'us');

		$students = $this->user_model->get_st_where('firstname, lastname, user_id' ,$class_id);
		$data['students'] = $students;
		foreach ($students as $st) {
			$data[$st['user_id']] = $this->marks_model->get_st_marks($st['user_id'], $lesson, $year, $sem);			
		}
		$data['lsn_type'] =  $this->lessons_model->getType($lesson);
		$data['attr_students'] = $this->lessons_model->get_lesson_ids($data['lsn_type']['lesson_id']);

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function getStLsn(){
		$lesson = $this->input->post('lesson_id');
		$temp = $this->lessons_model->get_lesson_ids($lesson);
		$data['students'] = [];
		foreach ($temp as $st) {
			array_push($data['students'], $this->user_model->getUsrData($st['user_id']));
		}

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function genClassAvg($lesson){
		$class_id = $this->session->class_id;
		$date = $this->time->get_current_date();
		$year = $this->time->get_year_us($date);
		$sem = $this->time->get_sem($date, 'us');

		$totAvgSum = 0; $totAvgNum = 0;

		$students = $this->user_model->get_st_where('firstname, lastname, user_id' ,$class_id);
		foreach ($students as $st) {
			$mrkSum = 0; $mrkNum = 0;
			$mrks = $this->marks_model->get_st_marks($st['user_id'], $lesson, $year, $sem);
			foreach ($mrks as $mrk) {
				$mrkSum += $mrk['mark']; $mrkNum++;
			}
			$usrAvg = $mrkSum / $mrkNum;
			$totAvgSum += $usrAvg; $totAvgNum++;
		}
		echo substr(($totAvgSum / $totAvgNum), 0, 4);
	}

	public function update_marks(){
		$user_id = $this->input->post('user_id');
		$lesson = $this->input->post('lesson');
		$class_id = $this->session->class_id;
		$date = $this->time->get_current_date();
		$year = $this->time->get_year_us($date);
		$sem = $this->time->get_sem($date, 'us');

		header('Content-Type: application/json');
		echo json_encode($this->marks_model->get_st_marks($user_id, $lesson, $year, $sem));
	}

	public function update_absences(){
		$user_id = $this->input->post('user_id');
		$lesson = $this->input->post('lesson');
		$class_id = $this->session->class_id;
		$date = $this->time->get_current_date();
		$year = $this->time->get_year_us($date);
		$sem = $this->time->get_sem($date, 'us');

		header('Content-Type: application/json');
		echo json_encode($this->abs_model->get_abs($user_id, $lesson));
	}

	// Modify for dynamic lessons
	public function getStudents(){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;

			$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){
				$students = $this->user_model->get_st_ids($class_id);
				echo json_encode($students);
			}
		}
	}

	// Modify for dynamic lessons
	public function getStudentsInfo(){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;

			$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){
				$students = $this->user_model->get_st($class_id);
				header('Content-Type: application/json');
				echo json_encode($students);
			}
		}
	}

	// Absences
	public function display_get_absences(){
		$lesson = $this->input->post('lesson');
		$class_id = $this->session->class_id;

		$students = $this->user_model->get_st_where('firstname, lastname, user_id' ,$class_id);
		$data['students'] = $students;
		foreach ($students as $st) {
			$data[$st['user_id']] = $this->abs_model->get_abs($st['user_id'], $lesson);			
		}

		$data['lsn_type'] =  $this->lessons_model->getType($lesson);
		$data['attr_students'] = $this->lessons_model->get_lesson_ids($data['lsn_type']['lesson_id']);

		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function getLessonType(){
		$lesson = $this->input->post('lesson');
		$type = $this->lessons_model->getType($lesson);
		echo $type['avg_type'];
	}

	public function view($subpage = 'students'){
		if(isset($this->session->class_id) && isset($this->session->user_id)){
			$data['title'] = 'Teacher Page';
			$class_id = $this->session->class_id;
			$user_id = $this->session->user_id;

			$checkUsr = $this->user_model->get_user_where('status, class_id, profil', $user_id, $class_id);
			
			if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){

				$data['profil'] = $checkUsr['profil'];
				$data['page'] = 'teacher';

				if($subpage == 'students'){
					$data['users'] = $this->user_model->get_st($class_id);
					
					if(is_null($data['users'])){
						$data['users'] = 'null';
					}

				}elseif($subpage == 'marks' || $subpage == 'absences' || $subpage == 'test'){
					$dir_id = $this->user_model->get_dir_id($class_id);
					$data['lessons'] = [];
					$lsn_attr = $this->lessons_model->get_lessons($dir_id['user_id']);
					foreach ($lsn_attr as $lsn) {
						array_push($data['lessons'], $this->lessons_model->get_lsn_info($lsn['lesson_id']));
					}
				}

				$data['subpage'] = $subpage;
				$class_arr = $this->user_model->get_class($class_id);
				$data['class'] = $class_arr['class'];
				$data['stat_st'] = '';
				$data['stat_mrk'] = '';
				$data['stat_abs'] = '';
				$data['stat_tst'] = '';
				$data['stat_misc'] = '';

				if($subpage == 'students'){
					$data['stat_st'] = 'menuElActive';
				}elseif($subpage == 'marks'){
					$data['stat_mrk'] = 'menuElActive';
				}elseif($subpage == 'absences'){
					$data['stat_abs'] = 'menuElActive';
				}elseif($subpage == 'test'){
					$data['stat_tst'] = 'menuElActive';
					$data['usr_list'] = $this->user_model->get_students_list($class_id); //TODO: Mod to load students dynamically
				}elseif($subpage == 'misc'){
					$data['stat_misc'] = 'menuElActive';
				}

				$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
				$data['semMin'] = $this->time->semMin($sem);
				$data['semMax'] = $this->time->semMax($sem);
				$data['type'] = $this->type->getType();

				$this->load->view('templates/header', $data);
				$this->load->view('teacher/class', $data);
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