<?php
header('Access-Control-Allow-Origin: *');
class Page extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/profile_model','profile');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('homepage');
		}
	}

	public function index()
	{
		$data['meta_title'] = 'Homepage';
		$data['content_heading'] = 'Welcome to Roadrunner!';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'template\homepage';
		$data['user_id'] = $this->session->userdata('id');

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$data['main_content'] = 'template\admin_homepage';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$data['store_id'] = $this->_get_store_id($data['user_id']);
			$data['store_data'] = $this->profile->get_store_by_sp_id($data['user_id']);


			$data['main_content'] = 'template\sp_homepage';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['main_content'] = 'template\cust_homepage';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='4'){
			$data['meta_user_level'] = '4';
			$data['meta_user_level_title'] = 'Runner';
			$data['main_content'] = 'template\runner_homepage';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	private function _get_store_id(){
		//Get store ID
		$data = $this->profile->get_store_by_sp_id($this->session->id);
		$storeId = $data->store_id;
		return $storeId;
	}
}
