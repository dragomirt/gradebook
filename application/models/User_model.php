<?php

class User_model extends CI_Model{

	public function __construct()
	{
			$this->load->database();
	}

	private function myhash($login1, $pass){
		$salt1 = "io65$"; $salt2 = 'jb#pp1';
		$passhash = hash('ripemd128' , "$salt1$pass$salt2");
		$login = ucfirst(strtolower($login1));

		for ($i = 0; $i < strlen($login); $i++){
		  if($login[$i] == '-'){
		   $up = strtoupper($login[$i+1]);
		   $login[$i+1] = $up;
		  }
		}

		return array('login' => $login, 'password' => $passhash);
	}

	public function login_user(){
		$log = $this->myhash($this->input->post('title'), $this->input->post('password'));
		$query = $this->db->get_where('users', array('login' => $log['login'], 'password'=> $log['password']));
        return $query->row_array();
	}

	public function get_st($class_id){
		$query = $this->db->get_where('users', array('class_id'=>$class_id, 'status'=>'st'));
		return $query->result_array();
	}

	public function get_st_where($params ,$class_id){
		$this->db->select($params);
		$this->db->order_by('fullname', 'ASC');
		$query = $this->db->get_where('users', array('class_id'=>$class_id, 'status'=>'st'));
		return $query->result_array();
	}

	public function get_st_ids($class_id){
		$this->db->select('user_id');
		$query = $this->db->get_where('users', array('class_id'=>$class_id, 'status'=>'st'));
		return $query->result_array();
	}

	public function get_dir_id($class_id){
		$this->db->select('user_id');
		$query = $this->db->get_where('users', array('status'=>'dir', 'class_id'=>$class_id));
		return $query->row_array();
	}
	
	public function get_class($class_id){
		$this->db->select('class');
		$query = $this->db->get_where('users', array('class_id'=>$class_id));
		return $query->row_array();
	}

	public function get_usr_classid($user_id){
		$this->db->select('class_id');
		$query = $this->db->get_where('users', array('user_id'=>$user_id));
		return $query->row_array();
	}

	public function get_name($user_id){
		$this->db->select('fullname');
		$query = $this->db->get_where('users', array('user_id'=>$user_id));
		return $query->row_array();
	}

	public function get_user_where($params ,$user_id, $class_id){
		$this->db->select($params);
		$this->db->order_by('fullname', 'ASC');
		$query = $this->db->get_where('users', array('class_id'=>$class_id, 'user_id'=> $user_id));
		return $query->row_array();
	}

	public function get_students_list($class_id){
		$query = $this->db->get_where('users', array('class_id'=> $class_id, 'status'=>'st'));
		return $query->result_array();
	}

	public function add_user($firstname, $lastname, $language, $login, $password){
		
		$arr = $this->myhash($login, $password);
		$login = $arr['login'];
		$pass = $arr['password'];
		
		$class_id = $this->session->class_id;
		$user_id = $this->session->user_id;

		$checkUsr = $this->user_model->get_user_where('class_id, profil, class, sy, csy', $user_id, $class_id);

		$inpt = array(
			'user_id' => NULL,
			'status' => 'st',
			'firstname' => $firstname,
			'lastname' => $lastname,
			'fullname' => $firstname . ' ' . $lastname,
			'class' => $checkUsr['class'],
			'profil' => $checkUsr['profil'],
			'class_id' => $class_id,
			'sy' => $checkUsr['sy'],
			'csy' => $checkUsr['csy'],
			'avg_mark' => NULL,
			'absences' => 0,
			'login' => $login,
			'password' => $pass
		);
		$this->db->insert('users', $inpt);
	}

	public function get_all_classes(){
		$this->db->select('user_id, class');
		$this->db->order_by('class', 'ASC');
		$query = $this->db->get_where('users', array('class_id != '=> NULL, 'status'=>'dir'));
		return $query->result_array();
	}

	public function getUsrData($user_id){
		$this->db->select('firstname, lastname, user_id');
		$query = $this->db->get_where('users', array('user_id'=>$user_id));
		return $query->row_array();
	}

	private function randomPassword() { // From StackOverflow cause I'm lazy af XD.
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 9; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function regNewClass($firstname, $lastname, $className, $years, $profil, $login, $password){
		$password = $this->randomPassword();
		$hash = $this->myhash($login, $password);
		
		$this->db->select('class_id');
		$this->db->order_by('class_id', 'DESC');
		$query = $this->db->get_where('users', array('status'=> 'dir'));
		$last_class_id = $query->row_array()['class_id'];

		$inpt = array(
			'user_id' => NULL,
			'status' => 'dir',
			'firstname' => $firstname,
			'lastname' => $lastname,
			'fullname' => $firstname . ' ' . $lastname,
			'class' => $className,
			'profil' => $profil,
			'class_id' => $last_class_id+1,
			'sy' => '1',
			'csy' => $years,
			'avg_mark' => NULL,
			'absences' => 0,
			'login' => $hash['login'],
			'password' => $hash['password']
		);
		$this->db->insert('users', $inpt);

	}

	public function checkClass($className){
		$this->db->select('class');
		$query = $this->db->get_where('users', array('class'=>$className));
		return $query->row_array();
	}
}