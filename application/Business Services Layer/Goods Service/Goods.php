<?php
header('Access-Control-Allow-Origin: *');
class Goods extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/products_model','products');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('login');
		}
	}

	public function index()
	{
		$data['meta_title'] = 'Goods Stores';
		$data['content_heading'] = 'Here are the Goods stores';
		$data['content_subheading'] = 'Purchase confidently from a wide variety of sellers.';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Goods/goods_stores_view';
		$data['store_type'] = 'good';

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$data['store_tiles'] = $this->_loadStore($data['store_type']);
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['store_tiles'] = $this->_loadStore($data['store_type']);
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}


	public function products($store_id)
	{
		$data['meta_title'] = 'Goods Stores';
		$data['content_heading'] = 'Here are the Goods products';
		$data['content_subheading'] = 'Purchase from a wide variety of products.';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Goods/goods_store_products_view.php';
		$data['store_type'] = 'good';

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$data['prod_tiles'] = $this->_loadProducts($store_id);
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['prod_tiles'] = $this->_loadProducts($store_id);
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	public function view_product($prod_id)
	{
		$data['meta_title'] = 'Goods Stores';
		$data['content_heading'] = 'Here are the Goods products';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Goods/goods_view_product_view.php';
		$data['store_type'] = 'good';

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
			$data['prod_info'] = $this->_loadSingleProduct($prod_id);
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}



	//Load store information
	//Takes current session user_id, finds a match in tbl_stores at sp_id column
	private function _loadStore($store_type)
	{
		$data = $this->products->get_all_stores_by_type($store_type);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}

	private function _loadProducts($store_id)
	{
		$data = $this->products->get_all_products_by_store_id($store_id);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}

	private function _loadSingleProduct($prod_id)
	{
		$data = $this->products->get_product_by_id($prod_id);
		// print_r("<br><br><br>");
		// print_r($data);
		return $data;
	}
}
