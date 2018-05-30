<?php
class Abs_model extends CI_Model{

	public function __construct(){
		$this->load->database();
		$this->load->library('time');
	}

	public function get_abs($user_id, $lesson){
		$year = $this->time->get_year_us($this->time->get_current_date());
		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');

		$this->db->order_by('date', 'DESC');
		$query = $this->db->get_where('absences', array('user_id' => $user_id, 'lesson' => $lesson, 'year' => $year, 'sem' => $sem));
		return $query->result_array();
	}

	public function updateUserAbs($user_id, $year, $sem){
		$query = $this->db->get_where('absences', array('user_id' => $user_id, 'year'=> $year, 'sem'=>$sem));
		$abs_num = 0;
		foreach ($query->result_array() as $abs) {
			$abs_num++;
		}
		$this->db->where(array('user_id'=> $user_id));
		$this->db->update('users', array('absences'=>$abs_num));
	}

	public function add_abs($user_id, $lesson, $type, $month, $day){
		$this->load->model('user_model');
		$class_id = $this->user_model->get_usr_classid($user_id);
		$class = $this->user_model->get_class($class_id['class_id']);

		$inpt = array(
			'absence_id' => NULL,
			'user_id' => $user_id,
			'class' => $class['class'],
			'class_id' => $class_id['class_id'],
			'type' => $type,
			'lesson' => $lesson,
			'year' => $this->time->get_year_us($this->time->get_current_date()),
			'sem' => $this->time->get_sem($this->time->get_current_date(), 'us'),
			'date' => $this->time->get_year_us($this->time->get_current_date()) . '-' . $month . '-' . $day,
			'reg_date' => NULL
		);
		$this->db->insert('absences', $inpt);

		$year = $this->time->get_year_us($this->time->get_current_date());
		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');
		$this->updateUserAbs($user_id, $year, $sem);
	}

	public function delete_abs($absence, $user_id){
		$this->db->delete('absences', array('absence_id' => $absence));
		$year = $this->time->get_year_us($this->time->get_current_date());
		$sem = $this->time->get_sem($this->time->get_current_date(), 'us');

		$this->updateUserAbs($user_id, $year, $sem);
	}

	// Get all absences
	public function getAllAbsences($user_id, $year, $sem){
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get_where('absences', array('user_id'=>$user_id, 'year'=>$year, 'sem'=>$sem));
		return $query->result_array();
	}
}