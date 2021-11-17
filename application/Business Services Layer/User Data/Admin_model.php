<?php
class Admin_model extends CI_Model{

	var $table = 'tbl_users';

	var $column_order = array('user_id','user_name','user_email', 'user_address', 'user_contact_no', 'sp_ssm_no', 'sp_business_name', 'sp_business_contact_no', 'sp_business_address', 'sp_business_type', 'runner_license_no'); //set column field database for datatable orderable
	var $column_search = array('user_id','user_name','user_email', 'user_address', 'user_contact_no', 'sp_ssm_no', 'sp_business_name', 'sp_business_contact_no', 'sp_business_address', 'sp_business_type','runner_license_no'); //set column field database for datatable searchable just name, class are searchable
	var $order = array('user_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//Aprove user
	public function approveUser($id)
	{
		$this->db->where('user_id', $id);
		$this->db->set('is_admin_approved', '1');
		$this->db->update('tbl_users');  // Produces: INSERT INTO mytable (`name`) VALUES ('{$name}')
		return TRUE;
	}


	//DataTables
	private function _get_datatables_query($id)
	{

		// $this->db->from($this->table);

		//Query to list users who are not approved and are also service providers
		$this->db->select('*');
		$this->db->from('tbl_users');
	    $this->db->where('is_admin_approved', '0');
	    $this->db->where('user_level', $id);

		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
				}
				$i++;
			}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id)
	{
		$this->_get_datatables_query($id);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	//End of Datatables

}
