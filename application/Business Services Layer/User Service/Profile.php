<?php
header('Access-Control-Allow-Origin: *');
class Profile extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/profile_model','profile');
		$this->load->model('User Data/login_model','login');
		$this->load->model('User Data/products_model','products');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('login');
		}
	}

	//Redirect to edit profile view according to the right user level
	public function index()
	{
		$data['meta_title'] = 'Profile';
		$data['content_heading'] = 'Profile page';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['user_id'] = $this->session->id;

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$data['main_content'] = 'edit_admin_profile_view';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$data['main_content'] = 'Manage User/edit_sp_profile_view';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$data['main_content'] = 'Manage User/edit_cust_profile_view';
			$this->load->view('template/template', $data);
		}elseif($this->session->userdata('level')==='4'){
			$data['meta_user_level'] = '4';
			$data['meta_user_level_title'] = 'Runner';
			$data['main_content'] = 'Manage User/edit_runner_profile_view';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	//Loads service provider manage_products_view
	public function manage_products()
	{
		$data['meta_title'] = 'Manage Store Products';
		$data['content_heading'] = 'Manage Store Products';
		$data['content_subheading'] = 'Manage Products';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['sp_id'] = $this->session->id;
		$data['store_id'] = $this->_get_store_id($this->session->id);
		$data['main_content'] = 'Manage User/manage_products_view';

		if($this->session->userdata('level')==='1'){
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$this->load->view('template/template', $data);
		}else if($this->session->userdata('level')==='2'){
			$data['meta_user_level'] = '2';
			$data['meta_user_level_title'] = 'Service Provider';
			$this->load->view('template/template', $data);
		}else if($this->session->userdata('level')==='3'){
			$data['meta_user_level'] = '3';
			$data['meta_user_level_title'] = 'Customer';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	//Loads service provider manage_store_view
	public function manage_store()
	{
		$data['meta_title'] = 'Manage Store Information';
		$data['content_heading'] = 'Manage Store Page';
		$data['content_subheading'] = 'Manage Store Information';
		$data['meta_keywords'] = 'home_meta_keywords';
		$data['main_content'] = 'Manage User/manage_store_view';
		$data['sp_id'] = $this->session->id;
		$data['store_id'] = $this->_get_store_id();

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
		}else{
			echo "Access Denied";
		}
	}

	//Mange Store Page
	//Products table
	//Output data into DataTables
	public function ajax_list_products($storeId)
	{
		$list = $this->products->get_datatables($storeId);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $product) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $product->id;
			// $row[] = $product->store_id;
			$row[] = $product->prod_name;
			$row[] = $product->prod_descr;
			$row[] = $product->prod_qty;
			$row[] = $product->prod_price;
			if($product->prod_pic)
				$row[] = '<a href="'.base_url('upload/'.$product->prod_pic).'" target="_blank"><img src="'.base_url('upload/'.$product->prod_pic).'" class="img-responsive" height="35px"/></a>';
			else
				$row[] = '(No photo)';
			//add html for action
			$row[] = '<button class="btn btn-warning m-0" href="javascript:void(0)" onclick="updateProduct('."'".$product->id."'".')">Update</button>';
			$row[] = '<button class="btn btn-danger m-0" href="javascript:void(0)" onclick="deleteProduct('."'".$product->id."'".')">Delete</button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->products->count_all($storeId),
						"recordsFiltered" => $this->products->count_filtered($storeId),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	//Get store ID
	private function _get_store_id(){
		$data = $this->profile->get_store_by_sp_id($this->session->id);
		$storeId = $data->store_id;
		return $storeId;
	}

	//Load single product by id
	public function loadProduct($id)
	{
		$data = $this->products->get_product_by_id($id);
		echo json_encode($data);
	}

	//Save product to database
	public function saveProduct()
	{
		$this->_validate_product();
		$data = array(
				'store_id' => $this->input->post('store_id'),
				'prod_name' => $this->input->post('prod_name'),
				'prod_descr' => $this->input->post('prod_descr'),
				'prod_qty' => $this->input->post('prod_qty'),
				'prod_price' => $this->input->post('prod_price'),
			);

		if(!empty($_FILES['prod_pic']['name']))
		{
			$upload = $this->_do_upload_prod();
			$data['prod_pic'] = $upload;
		}

		$insert = $this->products->save($data);
		echo json_encode(array("status" => TRUE));
	}

	//Update product in database
	public function updateProduct()
	{
		$this->_validate_product();
		$data = array(
				'id' => $this->input->post('id'),
				'prod_name' => $this->input->post('prod_name'),
				'prod_descr' => $this->input->post('prod_descr'),
				'prod_qty' => $this->input->post('prod_qty'),
				'prod_price' => $this->input->post('prod_price'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('upload/'.$this->input->post('remove_photo'));
			$data['prod_pic'] = '';
		}

		if(!empty($_FILES['prod_pic']['name']))
		{
			$upload = $this->_do_upload_prod();

			//delete file
			// get_product_by_id
			$prod = $this->products->get_product_by_id($this->input->post('id'));
			if(file_exists('upload/'.$prod->prod_pic) && $prod->prod_pic)
				unlink('upload/'.$prod->prod_pic);

			$data['prod_pic'] = $upload;
		}

		$this->products->update_product_by_id(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	// Delete product in database
	public function deleteProduct($id)
	{
		//delete file
		$product = $this->products->get_product_by_id($id);
		if(file_exists('upload/'.$product->prod_pic) && $product->prod_pic)
			unlink('upload/'.$product->prod_pic);

		$this->products->delete_product_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	//Load store information
	//Takes current session user_id, finds a match in tbl_stores at sp_id column
	public function loadStore($id)
	{
		$data = $this->profile->get_store_by_sp_id($id);
		//Create store if current SP doesn't alrdy have one. Only for users created b4 tbl_users
		if(!$data){
			$profileData = $this->profile->get_by_id($id);
			$newStoreData = array(	"sp_id"=>$id,
			    					"store_type"=>$profileData->sp_business_type,
							);
			$insert = $this->profile->add_empty_store($newStoreData);
			redirect('profile/manage-store');
		}
		echo json_encode($data);
	}

	//Loads user profile information
	public function loadProfile($id)
	{
		$data = $this->profile->get_by_id($id);
		echo json_encode($data);
	}

	//Edit store profile in database
	public function editStoreProfile()
	{
		$this->_validate_store();
		$data = array(
				'store_id' => $this->input->post('store_id'),
				'sp_id' => $this->input->post('sp_id'),
				'store_name' => $this->input->post('store_name'),
				'store_descr' => $this->input->post('store_descr'),
				'store_type' => $this->input->post('store_type'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('upload/'.$this->input->post('remove_photo'));
			$data['store_pic'] = '';
		}

		if(!empty($_FILES['store_pic']['name']))
		{
			$upload = $this->_do_upload();

			//delete file
			$store = $this->profile->get_store_by_sp_id($this->input->post('sp_id'));
			if(file_exists('upload/'.$store->store_pic) && $store->store_pic)
				unlink('upload/'.$store->store_pic);

			$data['store_pic'] = $upload;
		}

		$this->profile->update_store_by_id(array('sp_id' => $this->input->post('sp_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	//Edit service provider profile info in database
	public function editSPProfile(){
		$this->_validate_sp_reg();

		$id = $this->input->post('user_id');
		$name = ucwords(strtolower($this->input->post('name')));
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');
		$ssm_no = $this->input->post('ssm_no');
		$business_name = $this->input->post('business_name');
		$business_contact_no = $this->input->post('business_contact_no');
		$business_address = $this->input->post('business_address');
		$business_type = $this->input->post('business_type');

		$userInfo = array(
			'user_name' => $name,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
			'sp_ssm_no' => $ssm_no,
			'sp_business_name' => $business_name,
			'sp_business_contact_no' => $business_contact_no,
			'sp_business_address' => $business_address,
			'sp_business_type' => $business_type,
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);
		$this->profile->update_store_type_by_id($id, $business_type);
		// echo $this->session->set_flashdata('user-id',$insert);

		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Edit service provider email and password only in database
	public function editSPProfileEmailPass(){
		$this->_validate_sp_email_pass();

		$id = $this->input->post('user_id');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$userInfo = array(
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);

		// echo $this->session->set_flashdata('user-id',$insert);

		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Edit customer profile info in database
	public function editCustProfile(){
		$this->_validate_cust_reg();

		$id = $this->input->post('user_id');
		$name = ucwords(strtolower($this->input->post('name')));
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');

		$userInfo = array(
			'user_name' => $name,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);
		// echo $this->session->set_flashdata('user-id',$insert);

		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Edit customer email and password only in database
	public function editCustProfileEmailPass(){
		$this->_validate_cust_email_pass();

		$id = $this->input->post('user_id');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$userInfo = array(
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);

		// echo $this->session->set_flashdata('user-id',$insert);
		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Edit runner profile info in database
	public function editRunnerProfile(){
		$this->_validate_runner_reg();

		$id = $this->input->post('user_id');
		$name = ucwords(strtolower($this->input->post('name')));
		$address = $this->input->post('address');
		$contact_no = $this->input->post('contact_no');
		$license_no = $this->input->post('license_no');

		$userInfo = array(
			'user_name' => $name,
			'user_address' => $address,
			'user_contact_no' => $contact_no,
			'runner_license_no' => $license_no,
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);
		// echo $this->session->set_flashdata('user-id',$insert);

		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Edit customer email and password only in database
	public function editRunnerProfileEmailPass(){
		$this->_validate_runner_email_pass();

		$id = $this->input->post('user_id');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$userInfo = array(
			'user_email' => $email,
			'user_password' => getHashedPassword($password),
		);

		$this->profile->update_by_id(array('user_id' => $id), $userInfo);

		// echo $this->session->set_flashdata('user-id',$insert);
		echo json_encode(array("status" => TRUE));
		$this->_update_session($id);
	}

	//Upload product picture
	private function _do_upload_prod()
	{
		$config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|svg';
        $config['max_size']             = 3000; //set max size allowed in Kilobyte
        $config['max_width']            = 1024; // set max width image allowed
        $config['max_height']           = 1024; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just millisecond timestamp for unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('prod_pic')) //upload and validate
        {
            $data['inputerror'][] = 'prod_pic';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	//Upload store picture
	private function _do_upload()
	{
		$config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|svg';
        $config['max_size']             = 3000; //set max size allowed in Kilobyte
        $config['max_width']            = 1024; // set max width image allowed
        $config['max_height']           = 1024; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just millisecond timestamp for unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('store_pic')) //upload and validate
        {
            $data['inputerror'][] = 'store_pic';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	//Update php session data when user updates their profile
	private function _update_session($id){

		$data = $this->profile->get_by_id($id);
		$array = get_object_vars($data);

		$name = ucwords(strtolower($array['user_name']));
		$email = $array['user_email'];
		$level = $array['user_level'];

		$sessionArray = array(
					'username'=>$name,
					'email'=>$email,
					'level'=>$level,
				);
		$this->session->set_userdata($sessionArray);
	}

	//Validation for product form
	private function _validate_product()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if($this->input->post('prod_name') == '')
		{
			$data['inputerror'][] = 'prod_name';
			$data['error_string'][] = 'Product name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('prod_descr') == '')
		{
			$data['inputerror'][] = 'prod_descr';
			$data['error_string'][] = 'Product description is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('prod_qty') == '')
		{
			$data['inputerror'][] = 'prod_qty';
			$data['error_string'][] = 'Product quantity is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('prod_price') == '')
		{
			$data['inputerror'][] = 'prod_price';
			$data['error_string'][] = 'Product price is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	//Validation for Store Information form
	private function _validate_store()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if($this->input->post('store_name') == '')
		{
			$data['inputerror'][] = 'store_name';
			$data['error_string'][] = 'Store name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('store_descr') == '')
		{
			$data['inputerror'][] = 'store_descr';
			$data['error_string'][] = 'Store description is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	//Validation for Service Provider form
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

	//Validation for Service Provider form email and password only
	private function _validate_sp_email_pass()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

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

		if ($email == $this->session->user_email && $this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	//Validation for Customer form
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

	//Validation for Customer form email and password only
	private function _validate_cust_email_pass()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

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

		if ($email == $this->session->user_email && $this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	//Validation for Runner form
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
			$data['error_string'][] = 'License no. is required';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	//Validation for Runner form email and password only
	private function _validate_runner_email_pass()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

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

		if ($email == $this->session->user_email && $this->login->isExistingEmail($email)){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email already exists';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
