<?php
class Marks_model extends CI_Model{

	public function __construct(){
		$this->load->database();
		$this->load->library('time');
		$this->load->model('lessons_model');
	}

	public function get_st_marks($user_id, $lesson, $year, $sem){
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get_where('marks', array('user_id'=>$user_id, 'lesson'=>$lesson, 'year'=>$year, 'sem'=>$sem));
		return $query->result_array();
	}

	public function add_mark($user_id, $lesson, $mark, $month, $day, $test){
		$this->load->model('user_model');
		$class_id = $this->user_model->get_usr_classid($user_id);
		$class = $this->user_model->get_class($class_id['class_id']);

		$inpt = array(
			'mark_id' => NULL,
			'user_id' => $user_id,
			'lesson' => $lesson,
			'class' => $class['class'],
			'class_id' => $class_id['class_id'],
			'status' => $test,
			'mark' => $mark,
			'year' => $this->time->get_year_us($this->time->get_current_date()),
			'sem' => $this->time->get_sem($this->time->get_current_date(), 'us'),
			'date' => $this->time->get_year_us($this->time->get_current_date()) . '-' . $month . '-' . $day,
			'reg_date' => NULL
		);
		$this->db->insert('marks', $inpt);
	}

	public function delete_mark($mark_id){
		$this->db->delete('marks', array('mark_id' => $mark_id));
	}

	public function get_info($mark_id){
		$query = $this->db->get_where('marks', array('mark_id'=> $mark_id));
		return $query->row_array();
	}

	public function edit_mark($mark_id, $lesson, $mark, $month, $day, $test){
		$year = $this->time->get_year_us($this->time->get_current_date());
		$date = $year.'-'.$month.'-'.$day;

		$data = array('mark'=> $mark, 'date'  => $date, 'status'  => $test);
		$this->db->where('mark_id', $mark_id);
		$this->db->update('marks', $data);
	}

	public function get_avg($user_id, $lesson, $year, $sem){
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get_where('marks', array('user_id'=>$user_id, 'lesson'=>$lesson, 'year'=>$year, 'sem'=>$sem));
		$marks = $query->result_array();

		$lsn_type = $this->lessons_model->getType($lesson);

		$marks_sum = 0; $marks_num = 0; $teza = null;
		foreach($marks as $mark){
			if($mark['status'] != 2){
				$marks_sum += $mark['mark']; $marks_num++;
			}elseif($mark['status'] == 2){
				$teza = $mark['mark'];
			}
		}

		if($marks_num > 0){
			$med = substr($marks_sum / $marks_num, 0, 4);
			if($lsn_type['avg_type'] == 'de' && $teza != null){
				$avg = ($med + $teza) / 2;
			}elseif($lsn_type['avg_type'] == 'pr'  && $teza != null){
				$avg = $med*0.6 + $teza*0.4;
			}else{
				$avg = $med;
			}
		}else{
			$avg = null;
		}

		return $avg;
	}

	// Check mark's date
	public function checkDates($id, $lesson, $year, $full_date, $sem){

		$marks = $this->marks_model->get_st_marks($id, $lesson, $year, $sem);
		$mrk_check = 1;
		foreach ($marks as $mrk) {
			if($mrk['date'] == $full_date){$mrk_check = -1; break;}	
		}
		return $mrk_check;
	}

	// Get all marks
	public function getAllMarks($user_id, $year, $sem){
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get_where('marks', array('user_id'=>$user_id, 'year'=>$year, 'sem'=>$sem));
		return $query->result_array();
	}

}