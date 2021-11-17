<?php
class Register extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('hash');
		$this->load->model('User Data/login_model','login');
		$this->load->model('User Data/profile_model','profile');
	}

	function index(){
		// $this->load->view('register_type_view');

		$data['meta_title'] = 'Register';
		$data['content_heading'] = 'Register';
		$data['main_content'] = 'Manage User/register_type_view';
		$this->load->view('template/login_template', $data);
	}

	public function cust(){
		$data['meta_title'] = 'Register';
		$data['content_heading'] = 'Register';
		$data['main_content'] = 'Manage User/register_customer_view';
		$data['user_level'] = '3';
		$data['heading'] = 'Customer';
		$this->load->view('template/login_template', $data);
	}

	public function sp(){
		$data['meta_title'] = 'Register';
		$data['content_heading'] = 'Register';
		$data['main_content'] = 'Manage User/register_sp_view';
		$data['user_level'] = '2';
		$data['heading'] = 'Service Provider';
		$this->load->view('template/login_template', $data);
	}

	public function runner(){
		$data['meta_title'] = 'Register';
		$data['content_heading'] = 'Register';
		$data['main_content'] = 'Manage User/register_runner_view';
		$data['user_level'] = '4';
		$data['heading'] = 'Runner';
		$this->load->view('template/login_template', $data);
	}

	public function registerCust()
	{
		$this->_validate_cust_reg();

		$name = ucwords(strtolower($this->input->post('name')));
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');
		$admin_approval = 1; //Customer does not need admin approval.

		$userInfo = array(
			'user_name' => $name,
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
			'is_admin_approved' => $admin_approval,
			'user_level' => $level,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
		);

		$insert = $this->login->addNewUser($userInfo);

		// echo $this->session->set_flashdata('user-id',$insert);

		echo $this->session->set_flashdata('msg','Registered new acc successfully!');

		echo json_encode(array("status" => TRUE));
	}


	public function registerSP()
	{
		$this->_validate_sp_reg();

		$name = ucwords(strtolower($this->input->post('name')));
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');
		$ssm_no = $this->input->post('ssm_no');
		$business_name = $this->input->post('business_name');
		$business_contact_no = $this->input->post('business_contact_no');
		$business_address = $this->input->post('business_address');
		$business_type = $this->input->post('business_type');
		$admin_approval = 0; //SP needs admin approval.

		$userInfo = array(
			'user_name' => $name,
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
			'user_level' => $level,
			'is_admin_approved' => $admin_approval,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
			'sp_ssm_no' => $ssm_no,
			'sp_business_name' => $business_name,
			'sp_business_contact_no' => $business_contact_no,
			'sp_business_address' => $business_address,
			'sp_business_type' => $business_type,
		);



		$insert = $this->login->addNewUser($userInfo);

		//Create empty store row in tbl_stores for SP
		$newStoreData = array(	"sp_id"=>$insert,
			    				"store_type"=>$business_type,
							);
		$insert2 = $this->profile->add_empty_store($newStoreData);

		// echo $this->session->set_flashdata('user-id',$insert);

		echo $this->session->set_flashdata('msg','Registered new acc successfully!');

		echo json_encode(array("status" => TRUE));
	}

	public function registerRunner()
	{
		$this->_validate_runner_reg();

		$name = ucwords(strtolower($this->input->post('name')));
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');
		$license_no = $this->input->post('license_no');
		$admin_approval = 0; //Runner needs admin approval.

		$userInfo = array(
			'user_name' => $name,
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
			'is_admin_approved' => $admin_approval,
			'user_level' => $level,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
			'runner_license_no' => $license_no,
		);

		$insert = $this->login->addNewUser($userInfo);

		// echo $this->session->set_flashdata('user-id',$insert);

		echo $this->session->set_flashdata('msg','Registered new acc successfully!');

		echo json_encode(array("status" => TRUE));
	}

	//Validation for register_cust_view form
	private function _validate_cust_reg()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		//For email, check if empty, if follows valid format and if email exists in db
		$email = $this->input->post('email');

		if($email== '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Invalid email format';
			$data['status'] = FALSE;
		}

		if ($this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Please select user level';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '')
		{
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Address is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('contact_no') == '')
		{
			$data['inputerror'][] = 'contact_no';
			$data['error_string'][] = 'Contact no. is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


	//Validation for register_sp_view form
	private function _validate_sp_reg()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		//For email, check if empty, if follows valid format and if email exists in db
		$email = $this->input->post('email');

		if($email== '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Invalid email format';
			$data['status'] = FALSE;
		}

		if ($this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Please select user level';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '')
		{
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Address is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('contact_no') == '')
		{
			$data['inputerror'][] = 'contact_no';
			$data['error_string'][] = 'Contact no. is required';
			$data['status'] = FALSE;
		}


		//SP validation
		if($this->input->post('ssm_no') == '')
		{
			$data['inputerror'][] = 'ssm_no';
			$data['error_string'][] = 'SSM no. is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('business_name') == '')
		{
			$data['inputerror'][] = 'business_name';
			$data['error_string'][] = 'Business Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('business_contact_no') == '')
		{
			$data['inputerror'][] = 'business_contact_no';
			$data['error_string'][] = 'Business Contact No. is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('business_address') == '')
		{
			$data['inputerror'][] = 'business_address';
			$data['error_string'][] = 'Business Address is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('business_type') == '')
		{
			$data['inputerror'][] = 'business_type';
			$data['error_string'][] = 'Business Type is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	//Validation for register_cust_view form
	private function _validate_runner_reg()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		//For email, check if empty, if follows valid format and if email exists in db
		$email = $this->input->post('email');

		if($email== '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Invalid email format';
			$data['status'] = FALSE;
		}

		if ($this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Please select user level';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '')
		{
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Address is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('contact_no') == '')
		{
			$data['inputerror'][] = 'contact_no';
			$data['error_string'][] = 'Contact no. is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('license_no') == '')
		{
			$data['inputerror'][] = 'license_no';
			$data['error_string'][] = 'Vehicle plate no. is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}