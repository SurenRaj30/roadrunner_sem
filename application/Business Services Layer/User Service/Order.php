<?php
class Order extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('User Data/products_model','product');
		$this->load->model('User Data/payment_model','payment');
		$this->load->model('User Data/order_model','order');
		$this->load->model('User Data/profile_model','profile');
		$this->load->helper('array_group_by');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('login');
		}
	}

	function index(){
		$this->load->view('Manage User/login_view');
	}

	function cart(){
		$data['meta_title'] = 'Shopping Cart';
		$data['content_heading'] = 'Shopping Cart';
		$data['meta_keywords'] = 'home_meta_keywords';

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['main_content'] = 'template\cart_view';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	function manage_order(){
		$data['meta_title'] = 'Manage Order';
		$data['content_heading'] = 'Manage Order';
		// $data['content_subheading'] = 'Manage Order';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['user_id'] = $this->session->userdata('id');

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$data['main_content'] = 'Manage User\manage_sp_order_view';
			$data['store_id'] = $this->_get_store_id();
			$data['order_data'] = $this->_load_sp_order($data['store_id']);

			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['main_content'] = 'Manage User\manage_cust_order_view';
			$orders = $this->_load_cust_order($data['user_id']);
			$data['order_data'] = array_group_by( $orders, "order_id"); //a function from "array group by" helper

			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='4'){
			$data['meta_title'] = 'Take Order';
			$data['content_heading'] = 'Take Order';
			$data['meta_user_level'] = '4';
			$data['meta_user_level_title'] = 'Runner';
			$data['content_subheading'] = 'Take an order to start delivery';
			$data['main_content'] = 'Manage Tracking & Analytics\manage_runner_order_view';
			$data['order_data'] = $this->_load_runner_order($data['user_id']);

			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	function current_delivery(){
		$data['meta_title'] = 'Current Delivery';
		$data['content_heading'] = 'Current Delivery';
		// $data['content_subheading'] = 'Manage Order';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['user_id'] = $this->session->userdata('id');

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='4'){
			$data['meta_user_level'] = '4';
			$data['meta_user_level_title'] = 'Runner';
			$data['content_subheading'] = 'Your current delivery';
			$data['main_content'] = 'Manage Tracking & Analytics\manage_runner_current_order_view';
			$data['order_data'] = $this->_load_runner_order($data['user_id']);

			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	public function ajax_list_sp_orders($storeId)
	{
		$list = $this->order->get_datatables($storeId);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $order) {
			$no++;
			$row = array();
			// $row[] = $no;
			$row[] = $order->order_id;
			// $row[] = $order->store_id;
			$row[] = $order->user_name;
			$row[] = $order->user_contact_no;
			$row[] = $order->prod_name;
			$row[] = $order->price;
			$row[] = $order->order_qty;
			$row[] = $order->order_qty*$order->price;
			$row[] = $order->order_date;
			$row[] = $order->order_time;
			if($order->runner_name)
				$row[] = $order->runner_name;
			else
				$row[] = "-";
			if($order->runner_contact_no)
				$row[] = $order->runner_contact_no;
			else
				$row[] = "-";
			$row[] = $order->order_status;
			//add html for action
			//Confirm order button
			//if order status is "paid", then show the confirm button
			if($order->order_status=="paid"){
				$row[] = '<button class="btn btn-primary m-0" href="javascript:void(0)" onclick="confirm_order('."'".$order->order_id."','".$order->prod_id."'".')" >Confirm</button>';
			//if order status is anything but "paid", disable the confirm button
			}else{
				$row[] = '<button class="btn btn-primary m-0" href="javascript:void(0)" onclick="confirm_order('."'".$order->order_id."','".$order->prod_id."'".')" disabled>Confirm</button>';
			}
			//Cancel order button
			//if order status is "to-pay" or "paid", then show the cancel button
			if($order->order_status=="to-pay" || $order->order_status=="paid"){
				$row[] = '<button class="btn btn-danger m-0" href="javascript:void(0)" onclick="cancel_order('."'".$order->order_id."','".$order->prod_id."'".')">Cancel</button>';
			//if order status is anything but "to-pay" or "paid", disable the cancel button
			}else{
				$row[] = '<button class="btn btn-danger m-0" href="javascript:void(0)" onclick="cancel_order('."'".$order->order_id."','".$order->prod_id."'".')" disabled>Cancel</button>';
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->order->count_all($storeId),
						"recordsFiltered" => $this->order->count_filtered($storeId),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list_runner_orders($runnerId, $page)
	{
		$list = $this->order->get_runner_datatables($runnerId, $page);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $order) {
			$no++;
			$row = array();
			// $row[] = $no;
			$row[] = $order->order_id;
			$row[] = $order->user_name;
			$row[] = $order->user_contact_no;
			$row[] = $order->user_address;
			$row[] = $order->order_date;
			$row[] = $order->order_time;
			$row[] = $order->order_status;
			//add html for action
			if($order->order_status=="confirmed"){
				$row[] = '<button class="btn btn-primary m-0" href="javascript:void(0)" onclick="confirm_pickup('."'".$order->order_id."','".$order->runner_id."'".')" >Confirm</button>';
			}else{
				$row[] = '<button class="btn btn-success m-0" href="javascript:void(0)" onclick="complete_delivery('."'".$order->order_id."','".$order->runner_id."'".')" >Delivered</button>';
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->order->count_all($runnerId),
						"recordsFiltered" => $this->order->count_filtered($runnerId),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function add_to_cart(){
		$insert_data = array( 'id' => $this->input->post('id'),
			'store_id' => $this->input->post('store_id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'qty' => $this->input->post('qty'),
			'pic' => $this->input->post('pic'),
			'store_type' => $this->input->post('store_type'),
			'qty_left' => $this->input->post('qty_left'), );

		// echo $this->session->set_flashdata('msg', $insert_data['pic']);

		// This function add items into cart.
		$this->cart->insert($insert_data);
		redirect('order/cart');
	}

	function update_cart(){
		// Recieve post values,calculate them and update
		$cart_info = $_POST['cart'] ;
		foreach( $cart_info as $id => $cart)
		{
			$rowid = $cart['rowid'];
			$price = $cart['price'];
			$amount = $price * $cart['qty'];
			$qty = $cart['qty'];

			$data = array(
				'rowid' => $rowid,
				'price' => $price,
				'amount' => $amount,
				'qty' => $qty
			);

			$this->cart->update($data);
		}
		redirect('order/cart');
	}

	function empty_cart(){
		unset($_SESSION['cart_contents']);
		redirect('order/cart');
	}

	function empty_cart_no_redirect(){
		unset($_SESSION['cart_contents']);
	}

	function pay_now($order_id){
		redirect('payment/pay-now/'.$order_id);
	}

	//Customer make payment
	function payment_complete($order_id){
		$this->order->pay_order_cust($order_id);
		$this->payment->update_order_status_paid_by_order_id($order_id);//update payment detail status into paid
		redirect('payment/receipt/'.$order_id);
	}

	//Customer cancel order
	function cancel_order($order_id){
		$this->order->cancel_order_by_order_id($order_id);
		redirect('order/manage-order');
	}

	//SP confirm order
	function confirm_order_sp($order_id,$prod_id){
		$this->order->confirm_order_sp($order_id,$prod_id);
		$this->order->deduct_product_qty($order_id,$prod_id);
		redirect('order/manage-order');
	}

	//SP cancel order
	function cancel_order_sp($order_id,$prod_id){
		$this->order->cancel_order_sp($order_id,$prod_id);
		redirect('order/manage-order');
	}

	//Runner pickup order
	function confirm_pickup($order_id,$runner_id){
		$this->order->confirm_pickup($order_id,$runner_id);
		redirect('order/current-delivery');
	}

	//Runner complete delivery
	function complete_delivery($order_id,$runner_id){
		$this->order->complete_delivery($order_id,$runner_id);
		redirect('page');
	}

	function place_order(){
		$order_id = round(microtime(true) * 1000);

		$cart_info = $_POST['cart'] ;
		foreach( $cart_info as $id => $cart)
		{
			// $rowid = $cart['rowid'];
			$user_id = $this->session->userdata('id');
			$store_id = $cart['store_id'];
			$prod_id = $cart['id'];
			$qty = $cart['qty'];
			$price = $cart['price'];
			$amount = $price * $cart['qty'];
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$order_date = date("Y-m-d");
			$order_time = date("H:i:s");
			$order_status = "to-pay";

			echo $enough = $this->_check_quantity($prod_id,$qty); echo "<br>";

			$orderInfo = array(
				'order_id' => $order_id,
				'user_id' => $user_id,
				'store_id' => $store_id,
				'prod_id' => $prod_id,
				'order_qty' => $qty,
				'price' => $price,
				'order_date' => $order_date,
				'order_time' => $order_time,
				'order_status' => $order_status,
			);

			$insert = $this->payment->save($orderInfo);
		}
		$this->empty_cart_no_redirect();
		redirect('order/manage-order');
	}

	//Server side product quantity check. Used during checkout.
	private function _check_quantity($id,$qty){
		$res = $this->product->enough_products($id,$qty);
		if($res)
			echo TRUE;
		else
			echo FALSE;
	}

	private function _load_cust_order($user_id)
	{
		$data = $this->order->get_all_cust_orders($user_id);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}

	private function _load_sp_order($store_id)
	{
		$data = $this->order->get_all_sp_orders($store_id);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}

    private function _load_runner_order($runner_id)
	{
		$data = $this->order->get_all_runner_orders($runner_id);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}

	private function _get_store_id(){
		//Get store ID
		$data = $this->profile->get_store_by_sp_id($this->session->id);
		$storeId = $data->store_id;
		return $storeId;
	}

}
