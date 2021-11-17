<?php
class Payment_model extends CI_Model{

	var $stores_table = 'tbl_stores';
	var $products_table = 'tbl_products';
	var $orders_table = 'tbl_orders';
	var $order_payments = 'tbl_payments';

	//SP get store view count
	public function get_store_views($store_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('store_id', $store_id);
		$query = $this->db->get();

		return $query->result();
	}

	//SP get product product sold count
	public function get_product_sold_count($store_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('store_id', $store_id);
		$query = $this->db->get('order_qty');

		return $query->result();
	}

	//SP get sales total
	public function get_sales($store_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('store_id', $store_id);
		$query = $this->db->get('price');

		return $query->result();
	}

	//Runner get delivery count
	public function get_deliveries($runner_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('runner_id', $runner_id);
		$query = $this->db->get();

		return $query->result();
	}

	//Runner get delivery on time count
	public function get_delivery_on_time($runner_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('runner_id', $runner_id);
		$query = $this->db->get();

		return $query->result();
	}

	//Runner get total earning
	public function get_total_earning($runner_id)
	{
		$this->db->from($this->orders_table);
		$this->db->where('runner_id', $runner_id);
		$query = $this->db->get();

		return $query->result();
	}



}
