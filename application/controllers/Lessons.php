<?php
class Lessons extends CI_Controller{

	public function __construct()
	{
			parent::__construct();
			$this->load->model('user_model');
			$this->load->model('lessons_model');
			$this->load->library('session');
			$this->load->library('time');
	}

	public function add_lesson(){
		$lesson_name = $this->input->post('lesson_name');
		$lesson_shrt = $this->input->post('lesson_shrt');
		$avg_type = $this->input->post('avg_type');

		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			if(strlen($lesson_name) > 0 && strlen($lesson_name) == strlen($lesson_shrt) && $avg_type != null){
				$this->lessons_model->add_lesson($lesson_name, $lesson_shrt, $avg_type);

				header('Content-Type: application/json');
				echo json_encode(array('text'=>'Obiectul a fost adaugat!', 'type'=>'succ'));
			}
		}
	}

	public function delete_lesson(){
		$lesson_id = $this->input->post('lesson_id');

		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			$this->lessons_model->delete_lesson($lesson_id);
			echo "Done!";
		}
	}

	public function get_cls_lessons(){
		$dir_id = $this->input->post('dir_id');
		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			$assigned = $this->lessons_model->get_lessons($dir_id);
			$unassigned = $this->lessons_model->get_all_lessons();
			$show = [];
			foreach($unassigned as $us){
				$stat = 1;
				foreach ($assigned as $as) {
					if($us['lesson_id'] == $as['lesson_id']){
						$stat = -1;
					}
				}
				if($stat == 1){
					array_push($show, $us);
				}
			}
			$data['unassigned'] = $show;
			$data['assigned'] = [];
			foreach ($assigned as $lsn) {
				array_push($data['assigned'], $this->lessons_model->get_lsn_info($lsn['lesson_id']));
			}

			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

	// Assign lesson to a class
	public function assignObject(){
		$lesson_id = $this->input->post('lesson_id');
		$dir_id = $this->input->post('dir_id');
		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			$checkLsn = $this->lessons_model->get_lessons($dir_id);
			$stat = true;
			foreach ($checkLsn as $lsn) {
				if($lsn['lesson_id'] == $lesson_id){
					$stat = false;
				}
			}
			if($stat){
				$this->lessons_model->assignLsn($dir_id, $lesson_id, 'cl');
				$dir_class_id = $this->user_model->get_usr_classid($dir_id)['class_id'];
				$students = $this->user_model->get_st_ids($dir_class_id);
				foreach ($students as $st) {
					$this->lessons_model->assignLsn($st['user_id'], $lesson_id, 'st');
				}
				echo 'Done!';
			}
		}
	}

	// Delete Assign
	public function delete_assign(){
		$lesson_id = $this->input->post('lesson_id');
		$dir_id = $this->input->post('dir_id');

		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		if($checkUsr['status'] == 'adm' && $checkUsr['class_id'] == $class_id){
			$dir_cls_id = $this->user_model->get_usr_classid($dir_id);
			$dir_cls_id = $dir_cls_id['class_id'];
			$students = $this->user_model->get_st_ids($dir_cls_id);
			$this->lessons_model->delete_assign($lesson_id, $dir_id, $students);
			echo 'Done!';
		}
	}

	public function assignSt(){
		$values = $this->input->post('data');
		$lsn = $this->input->post('lsn');

		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;
		$checkUsr = $this->user_model->get_user_where('status, class_id', $user_id, $class_id);
		if($checkUsr['status'] == 'dir' && $checkUsr['class_id'] == $class_id){

			$assigned_students = $this->lessons_model->get_lesson_ids($lsn);
			$assigned_students_ids = [];
			foreach ($assigned_students as $st) {
				array_push($assigned_students_ids, $st['user_id']);
			}

			$assign = [];
			$unassign = [];

			foreach ($assigned_students_ids as $id) {
				foreach ($values as $st) {
					if($st['user_id'] == $id && $st['val'] == 'false'){
						array_push($unassign, $st['user_id']);
					}
				}
			}

			$allStudentsTemp = $this->user_model->get_st_ids($class_id);
			$allStudents = [];
			foreach ($allStudentsTemp as $st) {
				array_push($allStudents, $st['user_id']);
			}

			$uns = array_diff($allStudents, $assigned_students_ids);


			foreach ($values as $st) {
				foreach ($uns as $un) {

					if($st['user_id'] == $un && $st['val'] == 'true'){
						array_push($assign, $st['user_id']);
					}
				}
			}

			foreach ($unassign as $usr) {
				$this->lessons_model->unassignLsn($usr, $lsn);
			}

			foreach ($assign as $usr) {
				$this->lessons_model->assignLsn($usr, $lsn, 'st');

			}
			echo 'Done!';
		}
	}
}