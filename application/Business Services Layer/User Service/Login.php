<?php
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('hash');
		$this->load->model('User Data/login_model','login');
	}

	function index(){
		$data['meta_title'] = 'Login';
		$data['content_heading'] = 'Log in to Your Account';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage User/login_view';
		$this->load->view('template/login_template', $data);
	}

	function auth(){
		$email    = $this->input->post('email',TRUE);
		$password = $this->input->post('password',TRUE);
	// $validate = $this->login->validate($email,$password);
		$result = $this->login->login($email, $password);
		$adminApproval = $this->login->validateAdminApproval($email);
		if(!$this->login->isExistingEmail($email)){
			echo $this->session->set_flashdata('login-error','Email does not exist, create a new account');
			redirect('login');
		}
		if(!$adminApproval){
			echo $this->session->set_flashdata('login-error','Wait for admin approval');
			redirect('login');
		}
		if(count($result) > 0)
		{
			foreach ($result as $res)
			{
				$sessionArray = array('id'=>$res->user_id,
					'username'=>$res->user_name,
					'email'=>$res->user_email,
					'level'=>$res->user_level,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($sessionArray);
				// access login for admin
				if($res->user_level === '1'){
					redirect('page');

				// access login for staff
				}elseif($res->user_level === '2'){
					redirect('page');

				// access login for author
				}else{
					redirect('page');
				}
			}
		}else{
			echo $this->session->set_flashdata('login-error','Incorrect email or password.');
			redirect('login');
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}

}
