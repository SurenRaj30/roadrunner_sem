<?php
class Products_model extends CI_Model{

	var $stores_table = 'tbl_stores';
	var $products_table = 'tbl_products';
	// var $user_details_table = 'tbl_user_details';
	var $column_order = array('id','prod_name', 'prod_descr', 'prod_qty', 'prod_price'); //set column field database for datatable orderable
	var $column_search = array('id','prod_name', 'prod_descr', 'prod_qty', 'prod_price'); //set column field database for datatable searchable just name, class are searchable
	var $order = array('id' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//DataTables
	private function _get_datatables_query($storeId)
	{

		//Query to list products that have a specific store_id
		$this->get_product_by_store_id($storeId);

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

	function get_datatables($storeId)
	{
		$this->_get_datatables_query($storeId);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($storeId)
	{
		$this->_get_datatables_query($storeId);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($storeId)
	{
		$this->db->from($this->get_product_by_store_id($storeId));
		return $this->db->count_all_results();
	}


	//Non Datatables
	public function get_product_by_store_id($storeId){
		//Query to list products that have a specific store_id
		$this->db->select('*');
		$this->db->from($this->products_table);
	    $this->db->where('store_id', $storeId);
	}

	public function save($data)
	{
		$this->db->insert($this->products_table, $data);
		return $this->db->insert_id();
	}

	public function update_product_by_id($where, $data)
	{
		$this->db->update($this->products_table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_product_by_id($id)
	{
		$this->db->from($this->products_table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function delete_product_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->products_table);
	}

	public function get_all_stores_by_type($type)
	{
		$this->db->from($this->stores_table);
		$this->db->where('store_type',$type);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_all_products_by_store_id($store_id)
	{
		$this->db->from($this->products_table);
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();

		return $query->result();
	}


	public function get_by_id($id)
	{
		$this->db->from($this->stores_table);
		$this->db->where('store_id',$id);
		$query = $this->db->get();

		return $query->row();
	}


	public function update_by_id($where, $data)
	{
		$this->db->update($this->stores_table, $data, $where);
		return $this->db->affected_rows();
	}

	public function enough_products($id,$qty){
		$this->db->from($this->products_table);
		$this->db->where('id',$id);
		$prodQty = $this->db->get()->row()->prod_qty;

		if($prodQty>0 && $prodQty>=$qty)
			return TRUE;
	}

}
