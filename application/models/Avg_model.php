<?php
class Avg_model extends CI_Model{

	public function __construct(){
		$this->load->database();
		$this->load->library('time');
	}

	public function checkAvg($user_id, $lesson, $year, $sem){
		$query = $this->db->get_where('avg_marks', array('user_id'=>$user_id, 'lesson'=>$lesson, 'year'=>$year, 'sem'=>$sem));
		return $query->row_array();
	}

	public function create_mark($user_id, $lesson, $year, $sem){
		$this->load->model('user_model');
		$this->load->model('marks_model');
		$class_id = $this->user_model->get_usr_classid($user_id);
		$class = $this->user_model->get_class($class_id['class_id']);
		$data = array(
			'mark_id' => NULL,
			'user_id' => $user_id,
			'lesson' => $lesson,
			'class' => $class['class'],
			'class_id' => $class_id['class_id'],
			'year' => $year,
			'sem' => $sem,
			'mark' => $this->marks_model->get_avg($user_id, $lesson, $year, $sem)
		);
		$this->db->insert('avg_marks', $data);
	}

	public function update_mark($user_id, $lesson, $year, $sem){
		$this->load->model('marks_model');
		$data = array(
			'mark' => $this->marks_model->get_avg($user_id, $lesson, $year, $sem)
		);
		$this->db->where(array('user_id'=> $user_id, 'year'=>$year, 'sem'=>$sem));
		$this->db->update('avg_marks', $data);
		$query = $this->db->get_where('avg_marks', array('user_id' => $user_id, 'year'=> $year, 'sem'=>$sem));
		$marks_sum = 0; $marks_num = 0;


		foreach ($query->result_array() as $mark) {
			$marks_sum += $mark['mark'];
			$marks_num++;
		}
		$this->db->where(array('user_id'=> $user_id));
		if($marks_num > 0 && $marks_sum > 0){$avg_mark = substr($marks_sum / $marks_num, 0, 4);}else{$avg_mark = null;}
		$this->db->update('users', array('avg_mark'=>$avg_mark));
	}

	public function getAllAvgs($user_id, $year, $sem){
		$query = $this->db->get_where('avg_marks', array('user_id'=>$user_id, 'year'=>$year, 'sem'=>$sem));
		return $query->result_array();
	}

}