<?php
class Profile_model extends CI_Model{

	var $table = 'tbl_users';
	var $stores_table = 'tbl_stores';
	// var $user_details_table = 'tbl_user_details';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function add_empty_store($data)
	{
	    $this->db->insert($this->stores_table,$data);
		return $this->db->affected_rows();
	}

	public function get_store_by_sp_id($id)
	{
		$this->db->from($this->stores_table);
		$this->db->where('sp_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update_store_by_id($where, $data)
	{
		$this->db->update($this->stores_table, $data, $where);
		return $this->db->affected_rows();
	}

	//Update business_type in edit_sp_profile_view changes store_type in manage_store_view
	public function update_store_type_by_id($where, $store_type)
	{
		$this->db->set('store_type', $store_type);
		$this->db->where('sp_id', $where);
		$this->db->update($this->stores_table); // gives UPDATE `tbl_stores` SET `store_type` = $store_type WHERE `id` = $where
		return $this->db->affected_rows();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('user_id',$id);
		$query = $this->db->get();

		return $query->row();
	}


	public function update_by_id($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	

}
