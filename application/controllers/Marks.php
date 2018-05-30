<?php
class Marks extends CI_Controller{
	
	public function __construct()
	{
			parent::__construct();
			$this->load->model('user_model');
			$this->load->model('marks_model');
			$this->load->model('avg_model');
			$this->load->model('lessons_model');
			$this->load->helper('url_helper');
			$this->load->library('session');
			$this->load->library('time');
			$this->load->library('type');
	}

	public function add_mark(){

		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$mark =  $this->input->post('mark');
			$month =  $this->input->post('month');
			$day =  $this->input->post('day');
			$test =  $this->input->post('test');
			$user_id = $this->input->post('user_id');
			$lesson = $this->input->post('lesson');

			$month = $this->time->convert_to_full_time($month);
			$day =  $this->time->convert_to_full_time($day);

			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			$year = $this->time->get_year_us($this->time->get_current_date());
			$full_date = $year . '-' . $month . '-' . $day;

			if($test == 1){ $stat = 1; }else { $stat = 0; }; 

			header('Content-Type: application/json');
			if(isset($lesson)){
				$check = $this->user_model->get_usr_classid($user_id);
				if($check['class_id'] == $this->session->class_id){
					$marks = $this->marks_model->get_st_marks($user_id, $lesson, $year, $sem);
					$mrk_check = 1;
					foreach ($marks as $mrk) {
						if($mrk['date'] == $full_date){$mrk_check = -1; echo json_encode(array('text'=>'Deja a fost inregistrata o nota pe aceasta data!', 'type'=>'fail')); break;}	
					}
					if($mrk_check == 1){
						if($mark >= 1 && $mark <= 10){
							if($month >= $this->time->semMin($sem) && $month <= $this->time->semMax($sem)){
								if($day >= 1 && $day <= 31){
									$this->marks_model->add_mark($user_id, $lesson, $mark, $month, $day, $stat);
									echo json_encode(array('text'=>'Nota a fost inregistrata!', 'type'=>'succ'));
								}
							}
						}
					}
				}
			}
		}
	}

	public function delete_mark(){

		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$mark_id =  $this->input->post('mark_id');

			if(isset($mark_id)){
				$this->marks_model->delete_mark($mark_id);
				echo json_encode(array('text'=>'Nota a fost stearsa!', 'type'=>'succ'));
			}
		}
	}

	public function mrkdata(){
		$mrk = $this->marks_model->get_info($this->input->post('mark_id'));
		header('Content-Type: application/json');
		echo json_encode(array('info'=>$mrk));
	}

	public function edit_marks(){
		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$mark =  $this->input->post('mark');
			$mark_id = $this->input->post('mark_id');
			$month =  $this->input->post('month');
			$day =  $this->input->post('day');
			$test =  $this->input->post('test');
			$user_id = $this->input->post('user_id');
			$lesson = $this->input->post('lesson');

			$month = $this->time->convert_to_full_time($month);
			$day =  $this->time->convert_to_full_time($day);

			if($test == -1){
				$test = 0;
			}

			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			$year = $this->time->get_year_us($this->time->get_current_date());
			$full_date = $year . '-' . $month . '-' . $day;

			header('Content-Type: application/json');
			if(isset($lesson)){
				$check = $this->user_model->get_usr_classid($user_id);
				if($check['class_id'] == $this->session->class_id){
					$marks = $this->marks_model->get_st_marks($user_id, $lesson, $year, $sem);
					$mrk_check = 1;
					foreach ($marks as $mrk) {
						if($mrk['date'] == $full_date && $mrk['mark_id'] != $mark_id){$mrk_check = -1; echo json_encode(array('text'=>'Deja a fost inregistrata o nota pe aceasta data!', 'type'=>'fail')); break;}	
					}
					if($mrk_check == 1){
						if($mark >= 1 && $mark <= 10){
							if($month >= $this->time->semMin($sem) && $month <= $this->time->semMax($sem)){
								if($day >= 1 && $day <= 31){
									$this->marks_model->edit_mark($mark_id, $lesson, $mark, $month, $day, $test);
									echo json_encode(array('text'=>'Nota a fost editata!', 'type'=>'succ'));
								}
							}
						}
					}
				}
			}
		}
	}

	public function update_avg(){
		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$user_id = $this->input->post('user_id');
			$lesson = $this->input->post('lesson');
			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			$year = $this->time->get_year_us($this->time->get_current_date());
			$checkAvg = $this->avg_model->checkAvg($user_id, $lesson, $year, $sem);
			if(isset($checkAvg['mark_id'])){
				$this->avg_model->update_mark($user_id, $lesson, $year, $sem);
			}else{
				$this->avg_model->create_mark($user_id, $lesson, $year, $sem);
			}
		}
	}

	// Test subpage function. TODO: Refactor to support dynamic lessons.
	public function insert_multimarks(){
		$class_id = $this->session->class_id;
		$month = $this->input->post('month');
		$day = $this->input->post('day');
		$test = $this->input->post('test');
		$teza = $this->input->post('teza');
		$lesson = $this->input->post('lesson');
		$data = $this->input->post('data');

		$month = $this->time->convert_to_full_time($month);
		$day =  $this->time->convert_to_full_time($day);

		if($test == 1 && $teza == -1){
			$test = 1;
		}elseif($teza == 1){
			$test = 2;
		}elseif($test == -1 && $teza == -1){
			$test = 0;
		}

		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
		$year = $this->time->get_year_us($this->time->get_current_date());
		$full_date = $year . '-' . $month . '-' . $day;
		$stat = -1;

		foreach ($data as $id => $value) {
			if($value >= 1 && $value <= 10){
				if($this->marks_model->checkDates($id, $lesson, $year, $full_date, $sem) == 1){
					if($month >= $this->time->semMin($sem) && $month <= $this->time->semMax($sem)){
						if($day >= 1 && $day <= 31){
							$this->marks_model->add_mark($id, $lesson, $value, $month, $day, $test);
							$stat = 1;
						}
					}
				}
			}
		}

		header('Content-Type: application/json');
		if($stat == 1){
			echo json_encode(array('text'=>'Notele au fost adaugate!', 'type'=>'succ'));
		}else{
			echo json_encode(array('text'=>"Erroare!", 'type'=>'fail'));
		}
	}
}