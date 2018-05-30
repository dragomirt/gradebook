<?php
class Absences extends CI_Controller{
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
	}

	public function add_abs(){

		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$type =  $this->input->post('type');
			$month =  $this->input->post('month');
			$day =  $this->input->post('day');
			$user_id = $this->input->post('user_id');
			$lesson = $this->input->post('lesson');

			$month = $this->time->convert_to_full_time($month);
			$day =  $this->time->convert_to_full_time($day);

			$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
			$year = $this->time->get_year_us($this->time->get_current_date());
			$full_date = $year . '-' . $month . '-' . $day;

			header('Content-Type: application/json');
			if(isset($lesson)){
				$check = $this->user_model->get_usr_classid($user_id);
				if($check['class_id'] == $this->session->class_id){
					$abss = $this->abs_model->get_abs($user_id, $lesson);
					$abs_check = 1;
					foreach ($abss as $ab) {
						if($ab['date'] == $full_date){$abs_check = -1; echo json_encode(array('text'=>'Deja a fost inregistrata o absenta pe aceasta data!', 'type'=>'fail')); break;}	
					}
					if($abs_check == 1){
						if($month >= $this->time->semMin($sem) && $month <= $this->time->semMax($sem)){
							if($day >= 1 && $day <= 31){
								$this->abs_model->add_abs($user_id, $lesson, $type, $month, $day);
								echo json_encode(array('text'=>'Absenta a fost inregistrata!', 'type'=>'succ'));
							}
						}
					}
				}
			}
		}
	}


	public function delete_abs(){

		$dir_class_id = $this->session->class_id;
		$dir_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $dir_id, $dir_class_id);

		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $dir_class_id){
			$absence_id = $this->input->post('absence_id');
			$user_id = $this->input->post('user_id');

			if(isset($absence_id)){
				$this->abs_model->delete_abs($absence_id, $user_id);
				echo json_encode(array('text'=>'Absenta a fost stearsa!', 'type'=>'succ'));
			}
		}
	}

}