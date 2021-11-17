<?php
header('Access-Control-Allow-Origin: *');
class Tracking extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/products_model','products');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('login');
		}
	}

	public function sp_analytics()
	{
		$data['meta_title'] = 'Analytics';
		$data['content_heading'] = 'Dashboard';
		$data['content_subheading'] = "Your store's performance";
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Tracking & Analytics/sp_analytics_view';

		if($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	public function runner_analytics()
	{
		$data['meta_title'] = 'Analytics';
		$data['content_heading'] = 'Dashboard';
		$data['content_subheading'] = "Your delivery performance";
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage Tracking & Analytics/runner_analytics_view';

		if($this->session->userdata('level')==='4'){
			$data['meta_user_level'] = '4';
			$data['meta_user_level_title'] = 'Runner';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

}
