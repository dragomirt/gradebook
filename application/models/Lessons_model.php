<?php
class Lessons_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	public function get_lessons($dir_id){
		$query = $this->db->get_where('lsn_attr', array('user_id'=>$dir_id, 'type'=>'cl'));
		return $query->result_array();
	}

	public function get_lesson_ids($lesson_id){
		// TODO: Make it sorted by name
		$query = $this->db->get_where('lsn_attr', array('lesson_id'=>$lesson_id, 'type'=>'st'));
		return $query->result_array();
	}

	public function get_lsn_info($lesson_id){
		$this->db->order_by('lesson_name', 'DESC');
		$query = $this->db->get_where('lessons', array('lesson_id'=>$lesson_id));
		return $query->row_array();
	}

	public function get_all_lessons(){
		$this->db->order_by('lesson_name', 'ASC');
		$query = $this->db->get('lessons');
		return $query->result_array();
	}

	public function getType($lesson){
		$query = $this->db->get_where('lessons', array('lesson_shrt'=>$lesson));
		return $query->row_array();
	}

	public function add_lesson($lesson_name, $lesson_shrt, $avg_type){
		$inpt = array(
			'lesson_id' => NULL,
			'lesson_name' => $lesson_name,
			'lesson_shrt' => $lesson_shrt,
			'avg_type' => $avg_type
		);
		$this->db->insert('lessons', $inpt);
	}

	public function delete_lesson($lesson_id){
		$this->db->delete('lessons', array('lesson_id' => $lesson_id));
		$this->db->delete('lsn_attr', array('lesson_id' => $lesson_id));
	}

	public function assignLsn($id, $lesson_id, $type){
		$inpt = array(
			'attr_id' => NULL,
			'user_id' => $id,
			'lesson_id' => $lesson_id,
			'type' => $type
		);
		$this->db->insert('lsn_attr', $inpt);
	}

	public function unassignLsn($id, $lesson_id){
		$this->db->delete('lsn_attr', array('user_id'=> $id, 'lesson_id'=> $lesson_id));
	}

	public function delete_assign($lesson_id, $dir_id, $students){
		$this->db->delete('lsn_attr', array('lesson_id' => $lesson_id, 'user_id'=>$dir_id));
		foreach ($students as $st) {
			$this->db->delete('lsn_attr', array('lesson_id' => $lesson_id, 'user_id'=>$st['user_id']));
		}
	}
}