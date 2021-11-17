<?php
header('Access-Control-Allow-Origin: *');
class Payment extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/Payment_model','payment');
		$this->load->model('order_model','order');
	}


	public function index()
	{
		$data['meta_title'] = 'Payment';
		$data['content_heading'] = 'Credit or Debit card';
		$data['content_subheading'] = 'Please fill in the card details.';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Payments/payment_card_view';

		if($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	public function pay_now($order_id)
	{
		$data['meta_title'] = 'Payment';
		$data['content_heading'] = 'Credit or Debit card';
		$data['content_subheading'] = 'Please fill in the card details.';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Payments/payment_card_view';
		$data['order_id'] = $order_id;

		if($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['receipt'] = $this->_payment($order_id);
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	public function receipt($order_id)
	{
		$data['meta_title'] = 'Receipt';
		$data['content_heading'] = 'Here is your Receipt';
		$data['content_subheading'] = 'Receipt';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Payments/payment_receipt_view';
		$data['order_id'] = $order_id;

		if($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			//$data['receipt'] = $this->_loadreceipt($data['user_id']);
			$data['receipt'] = $this->_loadreceipt($order_id);
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	//add order details into tbl_payments
	private function _payment($order_id)
	{
		$this->order->add_cust_orders_by_order_id($order_id);//add payment detail
	}

	//Load receipt information
	private function _loadreceipt($order_id)
	{
		$data = $this->payment->get_receipt_details($order_id);
		return $data;
	}
}
