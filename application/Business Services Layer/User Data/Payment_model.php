<?php
class Payment_model extends CI_Model{

	var $stores_table = 'tbl_stores';
	var $products_table = 'tbl_products';
	var $orders_table = 'tbl_orders';
	var $order_payments = 'tbl_payments';


	//Non Datatables
	public function save($data)
	{
		$this->db->insert($this->orders_table, $data);
		return $this->db->insert_id();
	}

	/*public function update_order_status_by_order_id($order_id)
	{
		//$this->payment->update_order_status_paid_by_order_id($order_id);
	}*/

	//update order status to paid
	public function update_order_status_paid_by_order_id($order_id)
	{
		$data = array('order_status' => 'paid');
		$user_id = $this->session->userdata("id");
		$this->db->where('order_id', $order_id);
		$this->db->where('user_id', $user_id);
		$this->db->update($this->order_payments, $data);
	}

	//get receipt details from tbl_payments
	public function get_receipt_details($order_id)
	{
		$this->db->from($this->order_payments);
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();

		return $query->result();

	}

}
