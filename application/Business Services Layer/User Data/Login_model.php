<?php
class Login_model extends CI_Model{

	var $table = 'tbl_users';
	// var $user_details_table = 'tbl_user_details';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function validateAdminApproval($email){
		$this->db->from($this->table);
		$this->db->where('user_email',$email);
		$this->db->where('is_admin_approved',1);
		$query = $this->db->get();

		$result = $query->result();

		if(!empty($result)){
			return TRUE;
		} else {
			return FALSE;
		}

		return $result;
	}

	function login($email, $password)
	{
		$this->db->from($this->table);
		$this->db->where('user_email',$email);
		$query = $this->db->get();

		$user = $query->result();

		if(!empty($user)){
			if(verifyHashedPassword($password, $user[0]->user_password)){
				// echo print_r("OK");
				return $user;
			} else {
				// echo print_r("Wrong pass");
				return array();
			}
		} else {
			// echo print_r("Email does not exist");
			return array();
		}
	}

	function isExistingEmail($email)
	{
		$this->db->from($this->table);
		$this->db->where('user_email',$email);
		$query = $this->db->get();

		$result = $query->result();

		if(!empty($result)){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function addNewUser($userInfo)
	{
		$this->db->insert($this->table, $userInfo);

		//insert_id() function gets the user_id of the insert query into tbl_user
		return $this->db->insert_id();
	}

	// public function addNewCust($userInfo)
	// {
	// 	$this->db->insert($this->table, $userInfo);

	// 	//insert_id() function gets the user_id of the insert query into tbl_user
	// 	return $this->db->insert_id();
	// }

	// public function addNewSP($userInfo)
	// {
	// 	$this->db->insert($this->table, $userInfo);
	// 	//insert_id() function gets the user_id of the insert query into tbl_user
	// 	return $this->db->insert_id();
	// }

}
