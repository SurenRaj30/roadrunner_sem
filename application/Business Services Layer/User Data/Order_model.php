<?php
class Order_model extends CI_Model{

	var $stores_table = 'tbl_stores';
	var $products_table = 'tbl_products';
	var $orders_table = 'tbl_orders';
	var $order_payments = 'tbl_payments';
	// var $user_details_table = 'tbl_user_details';
	var $column_order = array('order_id','u.user_name','u.user_contact_no','prod_name','prod_price',null,'order_qty','order_date','order_time','r.user_name','r.user_contact_no','order_status'); //set column field database for datatable orderable
	var $column_search = array('order_id','u.user_name','u.user_contact_no','prod_name','prod_price','order_qty','order_date','order_time','r.user_name','r.user_contact_no','order_status'); //set column field database for datatable searchable just name, class are searchable
	var $order = array('order_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//DataTables
	private function _get_datatables_query($storeId)
	{

		//Query to list orders that have a specific store_id
		$this->get_all_sp_orders($storeId);

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

	private function _get_datatables_runner_query($runnerId, $page)
	{

		//Query used to load datatable depends on 2nd parameter, $page
		if ($page == "1") {
			$this->get_all_runner_orders();
		}else{
			$this->get_current_runner_orders($runnerId);
		}

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

	function get_runner_datatables($runnerId, $page)
	{
		$this->_get_datatables_runner_query($runnerId, $page);
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
		$this->db->from($this->get_all_sp_orders($storeId));
		return $this->db->count_all_results();
	}


	//Non Datatables
	public function save($data)
	{
		$this->db->insert($this->orders_table, $data);
		return $this->db->insert_id();
	}

	public function pay_order_cust($order_id)
	{
		$data = array('order_status' => 'paid');
		$this->db->where('order_id', $order_id);
		$this->db->update($this->orders_table, $data);
	}


	public function cancel_order_by_order_id($order_id)
	{
		$data = array('order_status' => 'cancelled');
		$this->db->where('order_id', $order_id);
		$this->db->update($this->orders_table, $data);
	}

	//SP confirm customer order to inform runner
	public function confirm_order_sp($order_id,$prod_id)
	{
		$data = array('order_status' => 'confirmed');
		$this->db->where('order_id', $order_id);
		$this->db->where('prod_id', $prod_id);
		$this->db->update($this->orders_table, $data);
	}

	//SP cancel customer order
	public function cancel_order_sp($order_id,$prod_id)
	{
		$data = array('order_status' => 'cancelled');
		$this->db->where('order_id', $order_id);
		$this->db->where('prod_id', $prod_id);
		$this->db->update($this->orders_table, $data);
	}

	//Deduct product when SP confirms order
	public function deduct_product_qty($order_id,$prod_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('order_id', $order_id);
		$this->db->where('prod_id', $prod_id);
		$qty = $this->db->get()->row()->order_qty;

		$this->db->set('prod_qty', 'prod_qty-'. $qty.'',false);
		$this->db->where('id', $prod_id);
		$this->db->update($this->products_table);
	}

    //add order details into tbl_payments
	public function add_cust_orders_by_order_id($order_id)
	{
		$user_id = $this->session->userdata("id");
		$this->db->select("o.user_id, u.user_name, o.order_id, o.prod_id, p.prod_name, o.order_qty, (o.price*o.order_qty) as total_price , o.order_date, o.order_time, o.order_status");
		$this->db->from('tbl_orders o');
	    $this->db->join('tbl_products p', 'p.id=o.prod_id', 'left');
	    $this->db->join('tbl_users u', 'u.user_id=o.user_id', 'left');
	    $this->db->where('o.user_id',$user_id);
	    $this->db->where('o.order_id',$order_id);
	    $this->db->where('o.order_status','to-pay');
	    $query = $this->db->get();
	    $this->db->insert_batch("tbl_payments", $query->result_array());
	}


	public function get_all_cust_orders($user_id)
	{
		$this->db->select("o.*, p.*, s.*, u.user_name as user_name, u.user_contact_no as user_contact_no, u.user_address as user_address, r.user_name as runner_name, r.user_contact_no as runner_contact_no");//Assign aliases to the user_name and user_address to identify user's and runner's details
		$this->db->from('tbl_orders o');
	    $this->db->join('tbl_products p', 'p.id=o.prod_id', 'left');
	    $this->db->join('tbl_stores s', 's.store_id=o.store_id', 'left');
	    $this->db->join('tbl_users u', 'u.user_id=o.user_id', 'left');
	    $this->db->join('tbl_users r', 'r.user_id=o.runner_id', 'left');
	    $this->db->where('o.user_id',$user_id);
	    $this->db->order_by('o.order_id','desc');
	    $query = $this->db->get();
	    if($query->num_rows() != 0)
	    {
	        return $query->result();
	    }
	    else
	    {
	        return array();
	    }
	}

	public function get_all_sp_orders($store_id)
	{
		$this->db->select("o.*, p.*, s.*, u.user_name as user_name, u.user_contact_no as user_contact_no, r.user_name as runner_name, r.user_contact_no as runner_contact_no");//Assign aliases to the user_name and user_address to identify user's and runner's details
		$this->db->from('tbl_orders o');
	    $this->db->join('tbl_products p', 'p.id=o.prod_id', 'left');
	    $this->db->join('tbl_stores s', 's.store_id=o.store_id', 'left');
	    $this->db->join('tbl_users u', 'u.user_id=o.user_id', 'left');
	    $this->db->join('tbl_users r', 'r.user_id=o.runner_id', 'left');
	    $query = $this->db->where('o.store_id',$store_id);

	}

	public function get_all_runner_orders()
	{
		$this->db->select("o.*, p.*, s.*, u.user_name as user_name, u.user_contact_no as user_contact_no, u.user_address as user_address, r.user_name as runner_name, r.user_contact_no as runner_contact_no");//Assign aliases to the user_name and user_address to identify user's and runner's details
		$this->db->from('tbl_orders o');
	    $this->db->join('tbl_products p', 'p.id=o.prod_id', 'left');
	    $this->db->join('tbl_stores s', 's.store_id=o.store_id', 'left');
	    $this->db->join('tbl_users u', 'u.user_id=o.user_id', 'left');
	    $this->db->join('tbl_users r', 'r.user_id=o.runner_id', 'left');
	    $this->db->where('o.order_status','confirmed');
	    $this->db->where('o.runner_id is NULL');
	    $query = $this->db->group_by('o.order_id');//groups duplicate orders into 1 row
	}

	public function get_current_runner_orders($runner_id)
	{
		$this->db->select("o.*, p.*, s.*, u.user_name as user_name, u.user_contact_no as user_contact_no, u.user_address as user_address, r.user_name as runner_name, r.user_contact_no as runner_contact_no");//Assign aliases to the user_name and user_address to identify user's and runner's details
		$this->db->from('tbl_orders o');
	    $this->db->join('tbl_products p', 'p.id=o.prod_id', 'left');
	    $this->db->join('tbl_stores s', 's.store_id=o.store_id', 'left');
	    $this->db->join('tbl_users u', 'u.user_id=o.user_id', 'left');
	    $this->db->join('tbl_users r', 'r.user_id=o.runner_id', 'left');
	    $this->db->where('o.order_status','out-for-delivery');
	    $this->db->where('o.runner_id', $runner_id);
	    $query = $this->db->group_by('o.order_id');//groups duplicate orders into 1 row
	}

	//Runner confirm pickup
	public function confirm_pickup($order_id,$runner_id)
	{
		$data = array('order_status' => 'out-for-delivery', 'runner_id' => $runner_id);
		$this->db->where('order_id', $order_id);
		$this->db->update($this->orders_table, $data);
	}

	//Runner complete delivery
	public function complete_delivery($order_id,$runner_id)
	{
		$data = array('order_status' => 'delivered', 'runner_id' => $runner_id);
		$this->db->where('order_id', $order_id);
		$this->db->update($this->orders_table, $data);
	}

}
