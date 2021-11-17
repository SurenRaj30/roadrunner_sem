<?php
class Admin extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('User Data/admin_model','admin');
		if($this->session->userdata('logged_in') !== TRUE){
			redirect('login');
		}
	}

	function index(){
		$this->load->view('Manage User/login_view');
	}

	function admin_sp_approval(){
		if($this->session->userdata('level')==='1'){
			$data['meta_title'] = 'Admin Approval';
			$data['content_heading'] = 'Approve Service Providers';
			$data['meta_keywords'] = 'home_meta_keywords';
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$data['main_content'] = 'Manage User/admin_sp_approval_view';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	function admin_runner_approval(){
		if($this->session->userdata('level')==='1'){
			$data['meta_title'] = 'Admin Approval';
			$data['content_heading'] = 'Approve Service Providers';
			$data['meta_keywords'] = 'home_meta_keywords';
			$data['meta_user_level'] = '1';
			$data['meta_user_level_title'] = 'Admin';
			$data['main_content'] = 'Manage User/admin_runner_approval_view';
			$this->load->view('template/template', $data);
		}else{
			echo "Access Denied";
		}
	}

	function approve_user($id){
		if($this->session->userdata('level')==='1'){
			$success = $this->admin->approveUser($id);

			if($success)
				return TRUE;
			else
				return FALSE;

			echo json_encode(array("status" => TRUE));
		}else{
			echo "Access Denied";
		}
	}

	//Output data into DataTables
	public function ajax_list()
	{
		$list = $this->admin->get_datatables(2); //2 for SP
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->user_id;
			$row[] = $user->user_name;
			$row[] = $user->user_email;
			// $row[] = $user->user_level;
			$row[] = $user->user_address;
			$row[] = $user->user_contact_no;
			$row[] = $user->sp_ssm_no;
			$row[] = $user->sp_business_name;
			$row[] = $user->sp_business_contact_no;
			$row[] = $user->sp_business_address;
			$row[] = $user->sp_business_type;
			//add html for action
			$row[] = '<button class="btn btn-primary m-0" href="javascript:void(0)" onclick="approveUser('."'".$user->user_id."'".')">Approve</button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->admin->count_all(),
						"recordsFiltered" => $this->admin->count_filtered(2),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list_runner()
	{
		$list = $this->admin->get_datatables(4); //4 for runner
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->user_id;
			$row[] = $user->user_name;
			$row[] = $user->user_email;
			// $row[] = $user->user_level;
			$row[] = $user->user_address;
			$row[] = $user->user_contact_no;
			$row[] = $user->runner_license_no;

			//add html for action
			$row[] = '<button class="btn btn-primary m-0" href="javascript:void(0)" onclick="approveUser('."'".$user->user_id."'".')">Approve</button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->admin->count_all(),
						"recordsFiltered" => $this->admin->count_filtered(4),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
}
