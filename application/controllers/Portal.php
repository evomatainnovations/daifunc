<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$GLOBALS['auto_year_small'] = date('Y');

class Portal extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
	}

########## HOME ################
	public function index() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$ert['title'] = "Home";
			$ert['search'] = "false";

			$query = $this->db->query("SELECT * FROM i_users ");
			$result = $query->result();
			$data['no_usr'] = count($result);

			$paid = 0 ; $unpaid = 0 ;
			$query = $this->db->query("SELECT sum(iutxn_amount) as amt, iutxn_uid FROM i_user_transaction  GROUP by iutxn_uid");
			$result1 = $query->result();

			for ($i=0; $i <count($result) ; $i++) { 
				for ($j=0; $j <count($result1) ; $j++) { 
					if ($result[$i]->i_uid == $result1[$j]->iutxn_uid) {
						$paid++;
					}
				}
			}
			$data['paid'] = $paid;
			$data['unpaid'] = count($result) - $paid;
			$query = $this->db->query("SELECT sum(iutxn_amount) as amt FROM i_user_transaction ");
			$result = $query->result();
			$data['t_amt'] = $result[0]->amt;

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/portal',$data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function testr() {
		print_r(ini_get('upload_max_filesize'));

	}

########## LOGIN, VERIFY, LOGOUT ################
	public function login()	{
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])){
			redirect(base_url().'Portal');

			
		} else {
			$data['mode'] = "portal";
			$this->load->view('portal/login', $data);
		}
	}

	public function verify(){
		$uname = $this->input->post('uname');
		$upass = $this->input->post('upass');

		$query = $this->db->query("SELECT * FROM i_admins WHERE ia_uname = '$uname' AND ia_upassword='$upass'");
		$result = $query->result();

		if (count($result) > 0) {
			$data = array('status' => "admin" , "admin_details" => $result );
			$this->session->set_userdata($data);

			echo "true";
		} else {
			echo "false";
		}		
	}

	public function logout(){
		$this->session->unset_userdata('admin_details');
		$this->session->unset_userdata('status');
		
		redirect(base_url().'Portal');
	}

########## CUSTOMERS ################

	public function customers() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid=a.i_owner;");
			$result = $query->result();

			$data['customer'] = $result;

			$ert['title'] = "Customers";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/customers', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function customer_add() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_adm_tags");
			$result = $query->result();
			$data['tags'] = $result;

			
			$ert['title'] = "Customer Add";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/customer_add', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_customer() {
		$oid = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'i_uname' => $this->input->post('email'),
			'i_status' => 'password update',
			'i_subscription_start' => $this->input->post('subscription'),
			'i_subscription_renew' => $this->input->post('renewal'),
			'i_duration' => $this->input->post('duration'),
			'i_created' => $dt,
			'i_created_by' => $oid,
			'i_owner' => $oid,
			'i_storage' => $this->input->post('cust_storage'),
			'i_g_limit' => $this->input->post('cust_g_limit')
			);
		$this->db->insert('i_users', $data);
		$uid = $this->db->insert_id();
		
		$data = array(
			'i_owner' => $uid,
			);
		$this->db->where('i_uid', $uid);
		$this->db->update('i_users', $data);
		
		

		$data1 = array(
			'iud_u_id' => $uid,
			'iud_name' => $this->input->post('name'),
			'iud_company' => $this->input->post('company'),
			'iud_email' => $this->input->post('email'),
			'iud_phone' => $this->input->post('phone'),
			'iud_address' => $this->input->post('address'));
		$this->db->insert('i_u_details', $data1);

		$c_tags = $this->input->post("tags");

		for ($j=0; $j < count($c_tags) ; $j++) { 
			$tmp_tag = $c_tags[$j];

			$query = $this->db->query("SELECT * FROM i_adm_tags WHERE iat_value = '$tmp_tag'");
			$result = $query->result();

			if(count($result) <= 0) {
				$data3 = array(
					'iat_value' => $tmp_tag);

				$this->db->insert('i_adm_tags', $data3);
				$tid = $this->db->insert_id();
			} else {
				$tid = $result[0]->iat_id;
			}

			$data4 = array(
				'iacp_customer_id' => $uid,
				'iacp_tag_id' => $tid,
				'iacp_created' => $dt);

			$this->db->insert('i_adm_cust_prefernces', $data4);
		}
	}

	function send_email($to, $code) {
		$body = '<!DOCTYPE html> <html> <head> <title>Account Confirmation</title><style type="text/css"> .main {padding-top: 20px; } button {padding: 50px !important; } </style> </head> <body> <div class="container main"> <div class="row"> <div class="col-xs-12" align="center"> <img src="http://onedynamics.in/assets/images/logo-467x128-90.png" class="img img-responsive" /> </div> </div> <hr> <div class="row well"> <div class="col-xs-12" align="center"> <h3>Thank you for signing up!!</h3> <h4>Click on the button below to verify your account and get started</h4> <hr> <a href="'.base_url().'Account/verify/'.urlencode($code).'"><button class="btn btn-lg btn-danger">Verify</button></a> </div> </div> <div class="row "> <div class="col-xs-12" align="center"> <h3>Connect with for latest updates</h3> <h3><a href="">FB</a></h3> <h3><a href="">Twitter</a></h3> </div> </div> <div class="row well well-lg"> <div class="col-xs-12" align="center"> <h3>Cheers and stay productive, <br>Team Onedynamics.</h3> </div> </div> </div> </body> </html>';
		try {
			$config = array();
	        $config['useragent'] = "CodeIgniter";
	        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	        $config['protocol'] = "smtp";
	        $config['smtp_host'] = "onedynamics.in";
	        $config['smtp_user'] = "no-reply@onedynamics.in";
	        $config['smtp_pass'] = "QWE!@#123";
	        $config['smtp_port'] = "587";
	        $config['mailtype'] = 'html';
	        $config['charset'] = 'utf-8';
	        $config['newline'] = "\r\n";
	        $config['wordwrap'] = TRUE;

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from('no-reply@onedynamics.in', 'No-Reply');
			$this->email->to($to);
			$this->email->subject('Account Verify');
			$this->email->message($body);
			$this->email->send();

			//echo $this->email->print_debugger();	
		} catch (Exception $e) {
			echo "Exception: ".$e;
		}
	}
	function generate_code() {
		$state = false;
		$umcode="";
		while ($state == false) {
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$string = '';
			$max = strlen($characters) - 1;
			for ($i = 0; $i < 9; $i++) {
				$string .= $characters[mt_rand(0, $max)];
			}

			$que = $this->db->query("SELECT * FROM um_details WHERE um_code='$string'");
			$res = $que->result();

			if(count($res)>0){
				$state = false;		
			} else {
				$que1 = $this->db->query("SELECT * FROM entities WHERE e_code='$string'");
				$res1 = $que1->result();
				if(count($res1) == 0){
					$state = true;
					$umcode = $string;
				} else {
					$state = false;
				}
			}
		}
		
		return($umcode);
	}

	public function edit_customer($cid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			
			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid='$cid'");
			$result = $query->result();
			$data['edit_customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_adm_cust_prefernces WHERE iacp_customer_id='$cid'");
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$data['cid']=$cid;

			$query = $this->db->query("SELECT * FROM i_adm_tags");
			$result = $query->result();
			$data['tags'] = $result;
			
			$ert['title'] = "Customer Add";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/customer_add', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function delete_customer($cid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			
			$this->db->where('iud_u_id', $cid);
			$this->db->delete('i_u_details');

			$this->db->where('i_uid', $cid);
			$this->db->delete('i_users');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$cid' ");
			$result = $query->result();
			$c_list = [];
			for ($i=0; $i < count($result) ; $i++) { 
				array_push($c_list, $result[$i]->ic_id);
			}
			$cust_list = 0;
			if (count($c_list) > 0) {
				$cust_list = implode(',', $c_list);
			}

			$query = $this->db->query("DELETE FROM i_c_basic_details WHERE icbd_customer_id IN ($cust_list) ");

			$this->db->where('ic_owner', $cid);
			$this->db->delete('i_customers');

			$this->db->where('ium_u_id', $cid);
			$this->db->delete('i_u_modules');

			redirect(base_url().'Portal/customers');
		} else {
			redirect(base_url().'Portal/login');
		}
	}


	public function update_customer($uid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$oid = 0;
			$dt = date('Y-m-d H:i:s');
			print_r("hello");
			$data = array(
				'i_uname' => $this->input->post('email'),
				'i_status' => $this->input->post('status'),
				'i_subscription_start' => $this->input->post('subscription'),
				'i_subscription_renew' => $this->input->post('renewal'),
				'i_duration' => $this->input->post('duration'),
				'i_modified' => $dt,
				'i_modified_by' => $oid,
				'i_storage' => $this->input->post('cust_storage'),
				'i_g_limit' => $this->input->post('cust_g_limit')
				);
			$this->db->where('i_uid', $uid);
			$this->db->update('i_users', $data);
			
			$data1 = array(
				'iud_name' => $this->input->post('name'),
				'iud_company' => $this->input->post('company'),
				'iud_email' => $this->input->post('email'),
				'iud_phone' => $this->input->post('phone'),
				'iud_address' => $this->input->post('address'));

			$this->db->where('iud_u_id', $uid);
			$this->db->update('i_u_details', $data1);

			$c_tags = $this->input->post("tags");

			for ($j=0; $j < count($c_tags) ; $j++) { 
				$tmp_tag = $c_tags[$j];

				$query = $this->db->query("SELECT * FROM i_adm_tags WHERE iat_value = '$tmp_tag'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'iat_value' => $tmp_tag);

					$this->db->insert('i_adm_tags', $data3);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->iat_id;
				}

				$data4 = array(
					'iacp_customer_id' => $uid,
					'iacp_tag_id' => $tid,
					'iacp_created' => $dt);

				$this->db->insert('i_adm_cust_prefernces', $data4);
			}
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## MODULES ################

	public function modules() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_modules AS a LEFT JOIN i_domain AS b ON a.im_domain=b.idom_id  LEFT JOIN i_function AS c ON a.im_function=c.ifun_id ORDER BY im_id DESC");
			$result = $query->result();

			$data['modules'] = $result;

			$ert['title'] = "Modules";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/modules', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function module_add() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_adm_tags");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();

			$data['tables'] = $result;
			
			$ert['title'] = "Module Add";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/module_add', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_functions() {
		$dom = $this->input->post('domain');

		$query = $this->db->query("SELECT * FROM i_function WHERE ifun_domain_id='$dom'");
		$result = $query->result();

		print_r(json_encode($result));
	}

	public function save_module() {
		$oid = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'im_name' => $this->input->post('name'),
			'im_domain' => $this->input->post('domain'),
			'im_function' => $this->input->post('func'),
			'im_created' => $dt,
			'im_created_by' => $oid,
			'im_desc' => $this->input->post('desc'),
			'im_price' => $this->input->post('price'),
			'im_subscription' => $this->input->post('subscription'),
			'im_publish' => $this->input->post('publish'),
			'im_benefit' => $this->input->post('benefit')
		);
		$this->db->insert('i_modules', $data);
		$mid = $this->db->insert_id();

		$c_tags = $this->input->post("tags");

		for ($j=0; $j < count($c_tags) ; $j++) {
			$tmp_tag = $c_tags[$j];

			$query = $this->db->query("SELECT * FROM i_adm_tags WHERE iat_value = '$tmp_tag'");
			$result = $query->result();

			if(count($result) <= 0) {
				$data3 = array(
					'iat_value' => $tmp_tag
				);
				$this->db->insert('i_adm_tags',$data3);
				$tid = $this->db->insert_id();
			} else {
				$tid = $result[0]->iat_id;
			}

			$data4 = array(
				'imp_module_id' => $mid,
				'imp_tag_id' => $tid
			);
			$this->db->insert('i_module_prefernces', $data4);
		}
		echo $mid;
	}

	public function edit_module($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			
			$query = $this->db->query("SELECT * FROM i_modules WHERE im_id='$mid'");
			$result = $query->result();
			$data['edit_module'] = $result;

			$domid = $result[0]->im_domain;

			$query = $this->db->query("SELECT * FROM i_module_prefernces WHERE imp_module_id='$mid'");
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$data['mid']=$mid;

			$query = $this->db->query("SELECT * FROM i_adm_tags");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_function WHERE ifun_domain_id ='$domid'");
			$result = $query->result();
			$data['func'] = $result;

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();

			$data['tables'] = $result;
			
			$ert['title'] = "Module Edit";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/module_add', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function delete_module($mid){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			
			$this->db->where('im_id', $mid);
			$this->db->delete('i_modules');
			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function update_module($mid) {
		$oid = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'im_name' => $this->input->post('name'),
			'im_domain' => $this->input->post('domain'),
			'im_function' => $this->input->post('func'),
			'im_modified' => $dt,
			'im_modified_by' => $oid,
			'im_desc' => $this->input->post('desc'),
			'im_benefit' => $this->input->post('benefit'),
			'im_price' => $this->input->post('price'),
			'im_subscription' => $this->input->post('subscription'),
			'im_publish' => $this->input->post('publish')
		);
		$this->db->where('im_id', $mid);
		$this->db->update('i_modules', $data);
		
		$c_tags = $this->input->post("tags");

		$this->db->where('imp_module_id', $mid);
		$this->db->delete('i_module_prefernces');
		
		for ($j=0; $j < count($c_tags) ; $j++) { 
			$tmp_tag = $c_tags[$j];

			$query = $this->db->query("SELECT * FROM i_adm_tags WHERE iat_value = '$tmp_tag'");
			$result = $query->result();

			if(count($result) <= 0) {
				$data3 = array(
					'iat_value' => $tmp_tag);

				$this->db->insert('i_adm_tags', $data3);
				$tid = $this->db->insert_id();
			} else {
				$tid = $result[0]->iat_id;
			}

			$data4 = array(
				'imp_module_id' => $mid,
				'imp_tag_id' => $tid);

			$this->db->insert('i_module_prefernces', $data4);
		}
		echo $mid;
	}

	public function module_upload($mid){

		$query = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$mid'");
		$result = $query->result();

		$upload_dir = $this->config->item('document_rt')."assets/data/portal/".$result[0]->im_name."/details/";
		if(!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}
		// print_r(count($_FILES['use']['tmp_name']));
		$img_path = "";
		if (is_dir($upload_dir) && is_writable($upload_dir)) {
			for ($i=0; $i <count($_FILES['use']['tmp_name']) ; $i++) {
				if (strpos($_FILES['use']['tmp_name'][$i], ".jpg")) {
				$sourcePath = $_FILES['use']['tmp_name'][$i]; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES['use']['name'][$i]; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				// $img_path = $targetPath;
				//print_r($targetPath);
				$image = imagecreatefromjpeg($targetPath);
				imagejpeg($image, $targetPath, 10);

				} else if (strpos($_FILES['use']['tmp_name'][$i], ".png")) {
					$sourcePath = $_FILES['use']['tmp_name'][$i]; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name'][$i]; // Target path where file is to be stored
					// $img_path = $targetPath;
					//print_r($targetPath);
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file


				} else {
					$sourcePath = $_FILES['use']['tmp_name'][$i]; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name'][$i]; // Target path where file is to be stored
					// $img_path = $targetPath;
					//print_r($targetPath);
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				}
				
					$img_path = $_FILES['use']['name'][$i];
				// print_r($img_path);
					$data = array(
						'imf_file' => $img_path,
						'imf_mid' => $mid,
					);
					$this->db->insert('i_m_files', $data);
			}
			$img_path = '';
		}
		
		echo "Img Path".$img_path;
	}
	
	public function allot_modules() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid=a.i_owner;");
			$result = $query->result();

			$data['customer'] = $result;

			$ert['title'] = "Allot";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/allot_home', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function modules_shortcuts() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_modules ORDER BY im_id DESC");
			$result = $query->result();
			$data['modules'] = $result;

			$ert['title'] = "Shortcuts";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/modules_shortcuts', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function modules_shortcuts_add($mid){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_modules WHERE im_id='$mid'");
			$result = $query->result();
			$data['edit_module'] = $result;

			$domid = $result[0]->im_domain;

			$data['mid']=$mid;

			$query = $this->db->query("SELECT * FROM i_function WHERE ifun_domain_id ='$domid'");
			$result = $query->result();
			$data['func'] = $result;

			// $query = $this->db->query("SELECT * FROM i_m_shortcuts WHERE ims_m_id ='$mid'");
			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id AND ims_m_id = '$mid'");
			$result = $query->result();
			$data['modules'] = $result;
			// print_r($data['modules']);
			$ert['title'] = "Module Add Shortcuts";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/module_add_shortcuts', $data);
			
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function add_shortcuts($mid){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$oid = 0;

			$dt = date('Y-m-d');

			$data = array(
				'ims_m_id' => $mid,
				'ims_function' => $this->input->post('s_function'),
				'ims_created' => $dt,
				'ims_created_by' => $oid,
				'ims_name' => $this->input->post('s_name'),
				'ims_icon' => $this->input->post('s_icon')
			 );
			$this->db->insert('i_m_shortcuts',$data);
			echo $mid;
			// print_r(json_encode($data));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function edit_shortcuts(){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$oid = 0;
			$sid = $this->input->post('sid');
			$dt = date('Y-m-d');

			$data = array(
				'ims_m_id' => $mid,
				'ims_function' => $function,
				'ims_created' => $dt,
				'ims_created_by' => $oid,
				'ims_name' => $name
			 );
			$this->db->insert('i_m_shortcuts',$data);

			$query = $this->db->query("SELECT * FROM i_m_shortcuts WHERE ims_m_id ='$mid'");
			$result = $query->result();
			$data['modules'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function allot_modules_customer($cid, $subcid=null) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_modules");
			$result = $query->result();
			$data['modules'] = $result;

			if ($subcid==null) {
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$cid' AND ium_created_by = 0");
			} else {
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$subcid' AND ium_created_by = $cid");
			}
			
			$result = $query->result();
			$data['modules_user'] = $result;

			if ($subcid==null) {
				$query = $this->db->query("SELECT * FROM i_user_invite WHERE iui_owner_id = '$cid'");
				$result = $query->result();
				$data['user_list'] = $result;
			} else {
				$data['user_list'] = [];
			}
			

			$data['ac_year'] = '2017-2018';
			$data['inv_num'] = '0001';

			$data['subcid'] = $subcid;
			$data['cid'] = $cid;

			$ert['title'] = "Select Module";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/allot_customer_module', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function allot_module_filter() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$domid = $this->input->post('domain');

			$query = $this->db->query("SELECT * FROM i_modules WHERE im_domain='$domid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_modules_customer($cid, $subcid=null) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$oid = 0;
			$dt = date('Y-m-d H:i:s');
			$d_t = date('Y-m-d');

			$module = $this->input->post('module');
			$syntax = $this->input->post('syntax');
			$detail = $this->input->post('detail');

			if ($subcid == null) {
				$this->db->where(array('ium_u_id' => $cid, 'ium_created_by' => 0));
				$this->db->delete('i_u_modules');
			} else {
				$this->db->where(array('ium_u_id' => $subcid, 'ium_created_by' => $cid));
				$this->db->delete('i_u_modules');
			}
			
			for ($i=0; $i < count($module) ; $i++) {
				$sub = '';
				$month = '';
				if ($module[$i]['status'] != 'null') {
					for ($j=0; $j <count($detail) ; $j++) { 
						if ($detail[$j]['mid'] == $module[$i]['mid']) {
							$sub = $detail[$j]['sub'];
							$d_t = date('Y-m-d');
							$s_month = $detail[$j]['moths'];
							$s_days = 30 * $s_month;
							$month = date('Y-m-d', strtotime('+'.$s_days.' days'));
						}
					}
					if ($subcid==null) {
						$data = array(
							'ium_u_id' => $cid,
							'ium_m_id' => $module[$i]['mid'],
							'ium_document_syntax' => $syntax[$i],
							'ium_status' => $module[$i]['status'],
							'ium_created' => $dt,
							'ium_user_limit' => $module[$i]['limit'],
							'ium_created_by' => 0,
							'ium_gid' => 0,
							'ium_subscription_start' => $sub,
							'ium_subscription_end' => $month,
							'ium_renewal_month' => 0,
							'ium_renewal_user' => 0
						);
					} else {
						$data = array(
							'ium_u_id' => $subcid,
							'ium_m_id' => $module[$i]['mid'],
							'ium_document_syntax' => $syntax[$i],
							'ium_status' => $module[$i]['status'],
							'ium_created' => $dt,
							'ium_user_limit' => $module[$i]['limit'],
							'ium_created_by' => $cid,
							'ium_gid' => 0,
							'ium_subscription_start' => $sub,
							'ium_subscription_end' => $month,
							'ium_renewal_month' => 0,
							'ium_renewal_user' => 0
						);
					}
					$this->db->insert('i_u_modules', $data);
				}
			}			
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function create_document_id() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid=a.i_owner;");
			$result = $query->result();

			$data['customer'] = $result;

			$ert['title'] = "Create Document ID";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/create_document_id', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function select_document_module($cid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_modules AS b ON a. ium_m_id=im_id WHERE a.ium_u_id = '$cid'");
			$result = $query->result();

			$data['modules_user'] = $result;

			$data['cid'] = $cid;

			$ert['title'] = "Select Module";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/select_document_module', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function set_document_id($cid, $mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id='$cid' AND iumdi_module_id='$mid' ORDER BY iumdi_id");
			$result = $query->result();

			$data['doc_id'] = $result;

			$data['cid'] = $cid;
			$data['mid'] = $mid;

			$ert['title'] = "Add Doc ID Sections";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/set_document_id', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_document_id($cid, $mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$doc_section = $this->input->post('doc_section');
			$doc_variable = $this->input->post('doc_variable');

			$data1 = array('iumdi_customer_id' => $cid, 'iumdi_module_id' => $mid);
			$this->db->where($data1);
			$this->db->delete('i_u_m_document_id');

			for ($i=0; $i < count($doc_section) ; $i++) { 
				if($doc_section[$i] !== "") {
					$data = array(
						'iumdi_customer_id' => $cid,
						'iumdi_module_id' => $mid,
						'iumdi_doc_syntax' => $doc_section[$i],
						'iumdi_variable' => $doc_variable[$i]
					);

					$this->db->insert('i_u_m_document_id', $data);
				}
			}
		} else {
			redirect(base_url().'Portal/login');
		}	
	}

########## DOMAIN ################

	public function system_domains() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();

			$data['domain'] = $result;

			
			$ert['title'] = "Domains";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/domains', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_system_domain() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dt = date('Y-m-d H:i:s');
			$data = array('idom_name' => $this->input->post('domain'), 'idom_created' => $dt);

			$this->db->insert('i_domain', $data);

		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function edit_system_domain($did) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();

			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain WHERE idom_id='$did'");
			$result = $query->result();

			$data['edit_domain'] = $result;

			$data['did'] = $did;
			$ert['title'] = "Domains";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/domains', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_system_domain($did) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dt = date('Y-m-d H:i:s');
			$data = array('idom_name' => $this->input->post('domain'), 'idom_created' => $dt);

			$this->db->where('idom_id', $did);
			$this->db->update('i_domain', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## FUNCTIONS ################

	public function system_functions() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_function as a LEFT JOIN i_domain as b ON a.ifun_domain_id=b.idom_id ORDER BY a.ifun_id DESC");
			$result = $query->result();

			$data['function'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();

			$data['domain'] = $result;

			$ert['title'] = "Functions";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/functions', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_system_function() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dt = date('Y-m-d H:i:s');
			$data = array('ifun_domain_id' => $this->input->post('domain'), 'ifun_name' => $this->input->post('func'), 'ifun_created' => $dt);

			$this->db->insert('i_function', $data);

		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function edit_system_function($did) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();

			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_function as a LEFT JOIN i_domain as b ON a.ifun_domain_id=b.idom_id");
			$result = $query->result();

			$data['function'] = $result;

			$query = $this->db->query("SELECT * FROM i_function as a LEFT JOIN i_domain as b ON a.ifun_domain_id=b.idom_id WHERE a.ifun_id='$did'");
			$result = $query->result();

			$data['edit_function'] = $result;

			$data['did'] = $did;
			$ert['title'] = "Functions";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/functions', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_system_function($did) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dt = date('Y-m-d H:i:s');
			$data = array('ifun_domain_id' => $this->input->post('domain'), 'ifun_name' => $this->input->post('func'), 'ifun_created' => $dt);

			$this->db->where('ifun_id', $did);
			$this->db->update('i_function', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## KPIS ################

	public function create_kpi() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();

			$data['tables'] = $result;

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT * FROM i_kpis AS a LEFT JOIN i_modules AS b ON a.ikpi_module=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id  LEFT JOIN i_function AS d ON b.im_function=d.ifun_id ");
			$result = $query->result();

			$data['kpi'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();

			$data['domain'] =$result;


			
			$ert['title'] = "KPI";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/kpi', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_kpi_columns() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dbname = $this->db->database;
			$tb = $this->input->post('tbl');
			$query = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name='$tb'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}	
	}

	public function get_kpi_modules() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$domain = $this->input->post('domain');
			$query = $this->db->query("SELECT * FROM i_modules WHERE im_domain = '$domain'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}	
	}

	public function save_kpi() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$name = $this->input->post('name');
			$table = $this->input->post('table');
			$column = $this->input->post('column');
			$query = $this->input->post('query');
			$func = $this->input->post('func');
			$display = $this->input->post('display');
			$domain = $this->input->post('domain');
			$module = $this->input->post('module');

			$data = array(
				'ikpi_name' => $name,
				'ikpi_table' => $table,
				'ikpi_column' => $column,
				'ikpi_query' => $query,
				'ikpi_type' => $func,
				'ikpi_display' => $display,
				'ikpi_module' => $module,
				'ikpi_created' => $dt);

			$this->db->insert('i_kpis', $data);

		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_kpi_details($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_kpis WHERE ikpi_id = '$mid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## TIME CONSTRAINT ################
	public function create_time_constraint() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();
			$data['tables'] = $result;

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT * FROM i_time_constraint AS a LEFT JOIN i_modules AS b ON a.itc_module=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id  LEFT JOIN i_function AS d ON b.im_function=d.ifun_id ");
			$result = $query->result();
			$data['tc'] = $result;

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] =$result;

			$query = $this->db->query("SELECT * FROM i_display");
			$result = $query->result();
			$data['display'] =$result;

			
			$ert['title'] = "Module Time Constraints";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/time_constraint', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_time_constraint() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$name = $this->input->post('name');
			$table = $this->input->post('table');
			$column = $this->input->post('column');
			$query = $this->input->post('query');
			$display = $this->input->post('display');
			$domain = $this->input->post('domain');
			$module = $this->input->post('module');

			$data = array(
				'itc_name' => $name,
				'itc_table' => $table,
				'itc_display' => $column,
				'itc_query' => $query,
				'itc_module' => $module,
				'itc_created' => $dt);

			$this->db->insert('i_time_constraint', $data);
			$tcid = $this->db->insert_id();

			for ($i=0; $i < count($column) ; $i++) { 
				$data1 = array(
					'itcc_tc_id' => $tcid,
					'itcc_column' => $column[$i] );
				$this->db->insert('i_tc_columns', $data1);
			}
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_tc_details($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_time_constraint WHERE itc_id = '$mid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## DISPLAY ################
	public function get_display_details($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_display WHERE id_id = '$mid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function create_display() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_display");
			$result = $query->result();
			$data['dis'] = $result;

			$ert['title'] = "Create Display";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/create_display', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_display() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$name = $this->input->post('name');
			$section_loop = $this->input->post('section_loop');
			$section = $this->input->post('section_header');
			
			$data = array(
				'id_name' => $name);
			$this->db->insert('i_display', $data);
			$did = $this->db->insert_id();

			for ($i=0; $i < count($section) ; $i++) { 
				$data1 = array(
					'idv_d_id' => $did,
					'idv_type' => $section_loop[$i],
					'idv_value' => $section[$i] );
				$this->db->insert('i_d_values', $data1);
			}

		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## COLUMN INDEX ################
	public function column_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();
			$data['tables'] = $result;

			$query = $this->db->query("SELECT * FROM i_column_index AS a LEFT JOIN i_modules AS b ON a.ici_module_entity_id=b.im_id ORDER BY ici_id DESC");
			$result = $query->result();
			$data['index'] = $result;

			$ert['title'] = "Column Index";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/column_index', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_ci_details($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_column_index WHERE ici_id = '$mid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_entity_module() {
		$detail = $this->input->post('detail');
		if($detail == "entity") {
			$query = $this->db->query("SELECT ic_section FROM i_customers GROUP BY ic_section");
			$result = $query->result();
			
			print_r(json_encode($result));
		} else if($detail == "module") {
			$query = $this->db->query("SELECT im_id, im_name FROM i_modules");
			$result = $query->result();
			
			print_r(json_encode($result));
		}
	}

	public function save_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$data = array(
				'ici_type' => $this->input->post('type'),
				'ici_module_entity_id' => $this->input->post('module'),
				'ici_table_name' => $this->input->post('table'),
				'ici_column_name' => $this->input->post('column'),
				'ici_default' => $this->input->post('default'),
				'ici_name' => $this->input->post('name'));
			$this->db->insert('i_column_index', $data);
		} else {
			redirect(base_url().'Portal/login');
		}	
	}

	public function delete_column_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$id = $this->input->post('del');

			$data = array( 'ici_id' => $id );
			$this->db->where($data);
			$this->db->delete('i_column_index');

		} else {
			redirect(base_url().'Portal/login');
		}	
	}

########## COLUMN INDEX ################
	public function join_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$dbname = $this->db->database;
			$query = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'");
			$result = $query->result();
			$data['tables'] = $result;

			$query = $this->db->query("SELECT * FROM i_join_index");
			$result = $query->result();
			$data['index'] = $result;

			$ert['title'] = "Join Index";
			$ert['search'] = "true";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/join_index', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function get_ji_details($mid) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$query = $this->db->query("SELECT * FROM i_join_index WHERE iji_id = '$mid'");
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_join_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$data = array(
				'iji_name' => $this->input->post('name'),
				'iji_table1' => $this->input->post('table1'),
				'iji_column1' => $this->input->post('column1'),
				'iji_table2' => $this->input->post('table2'),
				'iji_column2' => $this->input->post('column2'));
			$this->db->insert('i_join_index', $data);
		} else {
			redirect(base_url().'Portal/login');
		}	
	}

	public function delete_join_index() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$id = $this->input->post('del');

			$data = array( 'iji_id' => $id );
			$this->db->where($data);
			$this->db->delete('i_joint_index');

		} else {
			redirect(base_url().'Portal/login');
		}	
	}

	public function test() {
		$entity = ['Students'];
		$module = ['i_ext_ed_attendance'];
		$prop = ['ic_name','ieea_status'];
		$prop1 = ['iee_date'];
		$val = ['Hitesh','true'];
		
		print_r(array_combine($prop, $val));
		$p_v = array_combine($prop, $val);
		
		$prop1 = array_merge($prop);
		print_r($prop1);
		// $p_v = array('ic_name' => 'Hitesh');

		for ($i=0; $i < count($entity) ; $i++) {
			$this->db->select($prop);
			$this->db->from('i_customers');
			$wer = 'i_customers.ic_id=i_ext_ed_attendance.ieea_customer_id';
			$this->db->join($module[$i], $wer);
			$this->db->where($p_v);
			$query = $this->db->get();
			$result = $query->result();
			print_r($result);
		}
		
	}

########## USER KEY PERFORMANCE INDICATORS ################
	public function create_user_kpi($kid = null) {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_modules");
			$result = $query->result();
			$data['modules'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id");
			$result = $query->result();
			$data['kpi'] = $result;	

			if ($kid != null) {
				$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id WHERE iukpi_id = '$kid' ");
				$result = $query->result();
				$data['edit_kpi'] = $result;
				$data['kid'] = $kid;
				$path = $this->config->item('document_rt')."assets/data/portal/kpi/";
				if ($result[0]->iukpi_code != '') {
					$data['kpi_code'] = file_get_contents($path.$result[0]->iukpi_code.'.txt');
				}else{
					$data['kpi_code'] = '';
				}
			}

			$ert['title'] = "User Key Performance Indicators";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/user_kpi', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function save_user_kpi() {
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$path = $this->config->item('document_rt')."assets/data/portal/kpi/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$jstr = json_encode($this->input->post('kpi_code'));
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
			}

			$data = array(
				'iukpi_title' => $this->input->post('title'),
				'iukpi_query' => $this->input->post('query'),
				'iukpi_domain' => $this->input->post('domain'),
				'iukpi_module' => $this->input->post('module'),
				'iukpi_display_type' => $this->input->post('display'),
				'iukpi_time_dependent' => $this->input->post('time'),
				'iukpi_analytics_trigger' => $this->input->post('analytics'),
				'iukpi_type' => $this->input->post('type'),
				'iukpi_desc' => $this->input->post('desc'),
				'iukpi_code' => $dt_str
			);
			$this->db->insert('i_u_key_performance_indicators', $data);

			echo "true";
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_kpi($kid){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$path = $this->config->item('document_rt')."assets/data/portal/kpi/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$jstr = $this->input->post('kpi_code');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
			}
			
			$data = array(
				'iukpi_title' => $this->input->post('title'),
				'iukpi_query' => $this->input->post('query'),
				'iukpi_domain' => $this->input->post('domain'),
				'iukpi_module' => $this->input->post('module'),
				'iukpi_display_type' => $this->input->post('display'),
				'iukpi_time_dependent' => $this->input->post('time'),
				'iukpi_analytics_trigger' => $this->input->post('analytics'),
				'iukpi_type' => $this->input->post('type'),
				'iukpi_desc' => $this->input->post('desc'),
				'iukpi_code' => $dt_str
			);
			$this->db->WHERE('iukpi_id',$kid);
			$this->db->update('i_u_key_performance_indicators', $data);
			echo "true";
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function delete_kpi($kid){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$this->db->WHERE('iukpi_id',$kid);
			$this->db->delete('i_u_key_performance_indicators');
			redirect(base_url().'Portal/create_user_kpi');
		} else {
			redirect(base_url().'Portal/login');
		}
	}
	
########## USER KEY PERFORMANCE INDICATORS ################
	public function module_data_export() {
	    $sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_modules");
			$result = $query->result();
			$data['modules'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id");
			$result = $query->result();
			$data['kpi'] = $result;

			$ert['title'] = "User Key Performance Indicators";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/user_kpi', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## Template Settings #################	
	public function view_template() {

		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_domain");
			$result = $query->result();
			$data['domain'] = $result;

			$query = $this->db->query("SELECT * FROM i_modules");
			$result = $query->result();
			$data['modules'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id");
			$result = $query->result();
			$data['kpi'] = $result;

			$query = $this->db->query("SELECT * FROM i_template");
			$result = $query->result();
			$data['template'] = $result;

			$ert['title'] = "Template";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/template', $data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}
	public function add_template(){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			
	    	$title = $this->input->post('title');
	        $domain = $this->input->post('domain');
	        $modules = $this->input->post('module');

    		$data = array(
				'itemp_title' => $title,
				'itemp_domain' => $domain,
				'itemp_module' => $modules
			);
			$this->db->insert('i_template',$data);
			$inid = $this->db->insert_id();

			echo $inid;
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function temp_file_upload($in_id){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$upload_dir = VIEWPATH.'template/';
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
		        $sourcePath = $_FILES[0]['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES[0]['name']; // Target path where file is to be stored

				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
				$img_path = $_FILES[0]['name'];
				
        		$data = array('itemp_file_name' => $img_path);
				$this->db->where('itemp_id',$in_id);
				$this->db->update('i_template', $data);
			}

			$upload_dir = $this->config->item('document_rt').'assets/data/portal/template/';
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$sourcePath = $_FILES[1]['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES[1]['name']; // Target path where file is to be stored

				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
				$img_path = $_FILES[1]['name'];
				
        		$data = array('itemp_img_name' => $img_path);
				$this->db->where('itemp_id',$in_id);
				$this->db->update('i_template', $data);
			}
			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}

########## Create User ##################

	public function create_user(){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$query = $this->db->query("SELECT * FROM i_admins WHERE ia_super='false'");
			$result = $query->result();
			$data['users'] = $result;

			$ert['title'] = "Add User";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/create_user',$data);

		} else {
			redirect(base_url().'Portal/login');
		}
	}
	public function invite_user(){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){
			$type = $this->input->post('t_name');
	        $email = $this->input->post('e_name');
	        $super='';
	        $general='';
	        $developer='';
	        if ($type == 'null' && $email == '') {
	        	echo "both";
	        }else if($type == 'null'){
	        	echo "type";
	        }else if($email == ''){
	        	echo "email";
	        }else{
		        $query = $this->db->query("SELECT * FROM i_adm_details WHERE iad_a_email = '$email'");
		        $result = $query->result();
		        if (count($result) > 0) {
		        	echo "exist";
		        }else{
		        	$type = $this->input->post('t_name');
		        	if ($type == 'admin') {
		        		$super='true';
		        		$general='false';
		        		$developer='false';
		        	}elseif ($type == 'user') {
		        		$super='false';
		        		$general='true';
		        		$developer='false';
		        	}elseif ($type == 'developer') {
		        		$super='false';
		        		$general='false';
		        		$developer='true';
		        	}

		    		$data1 = array(
		    			'ia_uname' => $email,
		    			'ia_upassword' => $this->input->post('p_name'),
		    			'ia_super' => $super,
		    			'ia_general' => $general,
		    			'ia_developer' => $developer
		    		);
		    		$this->db->insert('i_admins',$data1);
		    		$in_id = $this->db->insert_id();

		    		$data2 = array(
		    			'iad_a_id' => $in_id,
		    			'iad_a_name' => $this->input->post('u_name'),
		    			'iad_a_phone' => $this->input->post('p_number'),
		    			'iad_a_email' => $email
		    		);
		    		$this->db->insert('i_adm_details',$data2);
		    		echo "true";
		        }
			}
		} else {
			redirect(base_url().'Portal/login');
		}
	}
	public function invite_mail(){

	} 

########## store ##########
	// public function store(){
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['admin_details'])) {

	// 		$query = $this->db->query("SELECT * FROM i_store as b LEFT JOIN i_users as a on a.i_uid=b.is_uid LEFT JOIN i_modules as c on b.is_mid=c.im_id");
	// 		$data['store'] = $query->result();

	// 		$ert['title'] = "Request";
	// 		$ert['search'] = "false";

	// 		$this->load->view('portal_navbar', $ert);
	// 		$this->load->view('portal/store',$data);
	// 	} else {
	// 		redirect(base_url().'Portal/login');
	// 	}
	// }

	// public function request_action(){
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['admin_details'])) {

	// 		$action = $this->input->post('action');
	// 		$mid = $this->input->post('mod_id');
	// 		$uid = $this->input->post('u_id');
	// 		if ($action == 'y') {
	// 			$data = array('is_status' => 'allot');	
	// 		}else{
	// 			$data = array('is_status' => 'delete');	
	// 		}
	// 		$this->db->WHERE(array('is_mid' => $mid, 'is_uid'=> $uid));
	// 		$this->db->update('i_store',$data);

	// 		$query = $this->db->query("SELECT * FROM i_store as b LEFT JOIN i_users as a on a.i_uid=b.is_uid LEFT JOIN i_modules as c on b.is_mid=c.im_id");
	// 		$data['store'] = $query->result();

	// 		print_r(json_encode($data));
			
	// 	} else {
	// 		redirect(base_url().'Portal/login');
	// 	}
	// }

########## Explore Collection ##############
	public function explore_collection(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * from i_explore_collection");
			$result = $query->result();
			$data['collection'] = $result;

			$query = $this->db->query("SELECT * from i_explore_collection_module as a LEFT JOIN i_modules as b on a.iecm_mid=b.im_id");
			$result = $query->result();
			$data['module'] = $result;

			$ert['title'] = "Explore Collection";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/explore_collection',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function explore_collection_add($id = null){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			if ($id != null) {
				$path = $this->config->item('document_rt')."assets/data/portal/explore_collection/";

				$query = $this->db->query("SELECT * from i_explore_collection as a LEFT JOIN i_explore_collection_module as b on a.iec_id=b.iecm_ec_id WHERE a.iec_id = '$id'");
				$result = $query->result();
				$data['collection'] = $result;
				$data['tid'] = $result[0]->iec_id;
				$file_name = $result[0]->iec_file;
				if (file_exists($path.$file_name)) {
					$data['content'] = file_get_contents();
				}else{
					$data['content'] = '';
				}
			}

			$query = $this->db->query("SELECT * FROM i_modules WHERE im_publish = 1 ORDER BY im_id DESC");
			$result = $query->result();
			$data['modules'] = $result;

			$ert['title'] = "Collection Details";
			$ert['search'] = "false";
			
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/explore_collection_add',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function save_explore_collection(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$title = $this->input->post('title');
			$module = $this->input->post('module');
			$html_body = $this->input->post('html_body');
			$cat1 = $this->input->post('cat1');
			$cat2 = $this->input->post('cat2');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

			$path = $this->config->item('document_rt')."assets/data/portal/explore_collection/";

			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $html_body);
				fclose($handle);
			}
			$file_name = $dt_str.'.txt';

			$data = array(
				'iec_title' => $title,
				'iec_file' => $file_name,
				'iec_cat1' => $cat1,
				'iec_cat2' => $cat2
			);
			$this->db->insert('i_explore_collection',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]['status'] == 'add') {
					$data = array(
						'iecm_ec_id' => $inid,
						'iecm_mid' => $module[$i]['id']
					);
					$this->db->insert('i_explore_collection_module',$data);	
				}
			}
			echo $inid;
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function update_explore_collection($tid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$title = $this->input->post('title');
			$module = $this->input->post('module');
			$html_body = $this->input->post('html_body');
			$cat1 = $this->input->post('cat1');
			$cat2 = $this->input->post('cat2');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

			$path = $this->config->item('document_rt')."assets/data/portal/explore_collection/";

			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $html_body);
				fclose($handle);
			}
			$file_name = $dt_str.'.txt';

			$data = array(
				'iec_title' => $title,
				'iec_file' => $file_name,
				'iec_cat1' => $cat1,
				'iec_cat2' => $cat2
			);
			$this->db->WHERE(array('iec_id' => $tid));
			$this->db->update('i_explore_collection',$data);

			$this->db->WHERE(array('iecm_ec_id' => $tid));
			$this->db->delete('i_explore_collection_module');			

			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]['status'] == 'add') {
					$data = array(
						'iecm_ec_id' => $tid,
						'iecm_mid' => $module[$i]['id']
					);
					$this->db->insert('i_explore_collection_module',$data);	
				}
			}
			echo $tid;
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function delete_explore_collection($tid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$this->db->WHERE(array('iec_id' => $tid));
			$this->db->delete('i_explore_collection');

			$this->db->WHERE(array('iecm_ec_id' => $tid));
			$this->db->delete('i_explore_collection_module');			

			redirect(base_url().'Portal/explore_collection');
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function collection_file_upload($inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$upload_dir = $this->config->item('document_rt')."assets/data/portal/explore_collection/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
				// echo $upload_dir;
			}
			$img_path = "";

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				for ($i=0; $i <count($_FILES['used']['tmp_name']) ; $i++) {
					
					$sourcePath = $_FILES['used']['tmp_name']; // Storing source path of the file in a variable
					$target = $upload_dir.$_FILES['used']['name']; // Target path where file is to be stored

					$path_parts = pathinfo($target);
					$file_name = $path_parts['filename'];
					$ext = $path_parts['extension'];

					$dt = date('Y-m-d H:i:s');
					$dt1=date_create(); 
					$dt_str = date_timestamp_get($dt1);
					$timestamp_value = $i.$dt_str;

					$targetPath = $upload_dir.$timestamp_value.'.'.$ext;
					$img_path = $targetPath;

					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file

					$data = array(
						'iec_img' => $file_name,
						'iec_timestamp' => $timestamp_value.'.'.$ext
					);
					$this->db->WHERE(array('iec_id'=> $inid));
					$this->db->update('i_explore_collection', $data);

					$timestamp_value = '';
					// echo "true";
				}	
				$img_path = '';
			}

		}else{
			redirect(base_url().'Portal/login');
		}
	}

########## Pricing #############
	public function pricing(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * FROM i_portal_price");
			$data['p_price'] = $query->result();

			$ert['title'] = "Price";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/all_pricing',$data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function update_price($id){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$name = $this->input->post('name');
			$price = $this->input->post('price');

			$data = array(
				'ipprice_name' => $name,
				'ipprice_amount' => $price
			);
			$this->db->WHERE('ipprice_id',$id);
			$this->db->update('i_portal_price',$data);
			echo "true";
		} else {
			redirect(base_url().'Portal/login');
		}
	}

########## Purchase History ###########
	public function purchase_history(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * FROM i_user_transaction");
			$data['txn'] = $query->result();

			$ert['title'] = "Purchase History";
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/purchase_history',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function purchase_details($id){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'group'");
			$data['g_amount'] = $query->result();

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'storage'");
			$data['s_amount'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_id = '$id'");
			$result = $query->result();
			$data['group'] = $result[0]->iutxn_group;
			$data['storage'] = $result[0]->iutxn_storage;
			$data['txn_details'] = $result;

			$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$id'");
			$data['order'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

########## Module Helper #############
	public function module_helper($flg=null){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * FROM i_modules");
			$data['modules'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_helper");
			$data['helpers'] = $query->result();

			if ($flg != null) {
				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_id = '$flg' ");
				$data['edit_helpers'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters WHERE ihp_ih_id = '$flg' ");
				$data['edit_parameter'] = $query->result();

				$data['hid'] = $flg;
				$ert['title'] = "Edit Helper";
			}else{
				$ert['title'] = "Add Helper";
			}

			
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/add_helper',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function save_helper(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$dt = date('Y-m-d H:i:s');

			$parameter = $this->input->post('parameters');
			$p_flg = 0;

			$data = array(
				'ih_func_name' => $this->input->post('f_name'),
				'ih_title' => $this->input->post('title'),
				'ih_from_module' => $this->input->post('f_module'),
				'ih_to_module' => $this->input->post('t_module'),
				'ih_type' => $this->input->post('h_type'),
				'ih_outcome_type' => $this->input->post('o_type'),
				'ih_outcome_value' => $this->input->post('o_value'),
				'ih_created' => $dt
			);
			$this->db->insert('i_helper',$data);
			$inid = $this->db->insert_id();
			
			if (count($parameter) > 0) {
				$p_flg = 1;
				for ($i=0; $i <count($parameter) ; $i++) { 
					$data = array(
						'ihp_ih_id' => $inid,
						'ihp_value' => $parameter[$i]
					);
					$this->db->insert('i_helper_parameters',$data);
				}
			}

			$this->db->WHERE('ih_id',$inid);
			$this->db->update('i_helper',array('ih_parameter'=>$p_flg));

			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function update_helper($inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$dt = date('Y-m-d H:i:s');
			$parameter = $this->input->post('parameters');
			$p_flg = 0;

			$data = array(
				'ih_func_name' => $this->input->post('f_name'),
				'ih_title' => $this->input->post('title'),
				'ih_from_module' => $this->input->post('f_module'),
				'ih_to_module' => $this->input->post('t_module'),
				'ih_type' => $this->input->post('h_type'),
				'ih_outcome_type' => $this->input->post('o_type'),
				'ih_outcome_value' => $this->input->post('o_value'),
				'ih_modify' => $dt
			);
			$this->db->WHERE('ih_id',$inid);
			$this->db->update('i_helper',$data);

			$this->db->WHERE('ihp_ih_id',$inid);
			$this->db->delete('i_helper_parameters');

			if (count($parameter) > 0) {
				$p_flg = 1;
				for ($i=0; $i <count($parameter) ; $i++) { 
					$data = array(
						'ihp_ih_id' => $inid,
						'ihp_value' => $parameter[$i]
					);
					$this->db->insert('i_helper_parameters',$data);
				}
			}

			$this->db->WHERE('ih_id',$inid);
			$this->db->update('i_helper',array('ih_parameter'=>$p_flg));

			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}


	public function delete_helper($inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$dt = date('Y-m-d H:i:s');
			
			$this->db->WHERE('ih_id',$inid);
			$this->db->delete('i_helper');

			$this->db->WHERE('ihp_ih_id',$inid);
			$this->db->delete('i_helper_parameters');

			redirect(base_url().'Portal/module_helper');
		}else{
			redirect(base_url().'Portal/login');
		}
	}

########## Scheme ###########

	public function user_scheme(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * FROM i_user_scheme");
			$data['s_list'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_details as a LEFT JOIN i_users as b on a.iud_u_id = b.i_uid ");
			$data['u_list'] = $query->result();

			$ert['title'] = "Scheme";
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/scheme',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function add_scheme($inid=null){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			
			if ($inid != null) {
				$query = $this->db->query("SELECT * FROM i_user_scheme as a LEFT JOIN i_u_scheme_parameter as b on a.iush_id = b.iushp_sid WHERE iush_id = '$inid' ");
				$data['s_list'] = $query->result();
				$data['sid'] = $inid;
				$ert['title'] = "Edit Scheme";
			}else{
				$data = 'null';
				$ert['title'] = "Add Scheme";
			}
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/add_scheme',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_save(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$s_limit = $this->input->post('s_limit');
			$s_name = $this->input->post('s_name');
			$s_time = $this->input->post('s_time');
			$p_arr = $this->input->post('p_arr');
			$dt = date('Y-m-d H:i:s');
			
			$data = array(
				'iush_name' => $s_name,
				'iush_limit' => $s_limit,
				'iush_time' => $s_time,
				'iush_created' => $dt,
				'iush_default' => 0
			);
			$this->db->insert('i_user_scheme',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($p_arr) ; $i++) { 
				$data = array(
					'iushp_sid' => $inid,
					'iushp_type' => $p_arr[$i]['s_p_type'],
					'iushp_amount' => $p_arr[$i]['s_amt'],
					'iushp_for' => $p_arr[$i]['s_type']
				);
				$this->db->insert('i_u_scheme_parameter',$data);
			}

			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_update($inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$s_limit = $this->input->post('s_limit');
			$s_name = $this->input->post('s_name');
			$s_time = $this->input->post('s_time');
			$p_arr = $this->input->post('p_arr');
			$dt = date('Y-m-d H:i:s');
			
			$data = array(
				'iush_name' => $s_name,
				'iush_limit' => $s_limit,
				'iush_time' => $s_time,
				'iush_modify' => $dt
			);
			$this->db->WHERE('iush_id',$inid);
			$this->db->update('i_user_scheme',$data);

			$this->db->WHERE('iushp_sid',$inid);
			$this->db->delete('i_u_scheme_parameter');

			for ($i=0; $i < count($p_arr) ; $i++) { 
				$data = array(
					'iushp_sid' => $inid,
					'iushp_type' => $p_arr[$i]['s_p_type'],
					'iushp_amount' => $p_arr[$i]['s_amt'],
					'iushp_for' => $p_arr[$i]['s_type']
				);
				$this->db->insert('i_u_scheme_parameter',$data);
			}

			echo "true";
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function default_scheme($sid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT * FROM i_user_scheme WHERE iush_id = '$sid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				if ($result[0]->iush_default == '1' ) {
					$query = $this->db->query("SELECT * FROM i_users where i_user_scheme IN ('$sid') ");
					$res = $query->result();
					if (count($res) > 0 ) {
						for ($i=0; $i < count($res) ; $i++) {
							$uid = $res[$i]->i_uid;
							$data = array(
								'i_user_scheme' => '0'
							);
							$this->db->WHERE('i_uid',$uid);
							$this->db->update('i_users',$data);
						}
					}

					$data = array(
						'iush_default' => '0'
					);
					$this->db->update('i_user_scheme',$data);
				}else{
					$query = $this->db->query("SELECT * FROM i_user_scheme WHERE iush_default = '1' ");
					$result = $query->result();
					$sh_id = 0;
					if (count($result) > 0 ) {
						$sh_id = $result[0]->iush_id;
					}

					$query = $this->db->query("SELECT * FROM i_users where i_user_scheme IN ('$sh_id','0') ");
					$res = $query->result();
					if (count($res) > 0 ) {
						for ($i=0; $i < count($res) ; $i++) {
							$uid = $res[$i]->i_uid;
							$data = array(
								'i_user_scheme' => $sid
							);
							$this->db->WHERE('i_uid',$uid);
							$this->db->update('i_users',$data);
						}
					}

					$data = array(
						'iush_default' => '0'
					);
					$this->db->update('i_user_scheme',$data);

					$data = array(
						'iush_default' => '1'
					);
					$this->db->WHERE('iush_id',$sid);
					$this->db->update('i_user_scheme',$data);
				}
			}

			redirect(base_url().'Portal/user_scheme');
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_allot(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$u_arr = $this->input->post('u_arr');
			$sid = $this->input->post('s_id');

			for ($i=0; $i < count($u_arr) ; $i++) { 
				if ($u_arr[$i]['flg'] == 'true' ) {
					$uid = $u_arr[$i]['id'];
					$data = array(
						'i_user_scheme' => $sid
					);
					$this->db->WHERE('i_uid',$uid);
					$this->db->update('i_users',$data);
				}else{
					$uid = $u_arr[$i]['id'];
					$query = $this->db->query("SELECT * FROM i_users where i_uid = '$uid' ");
					$res = $query->result();
					if (count($res) > 0 ) {
						if ($res[0]->i_user_scheme == $sid ) {
							$data = array(
								'i_user_scheme' => '0'
							);
							$this->db->WHERE('i_uid',$uid);
							$this->db->update('i_users',$data);
						}
					}
				}
			}

			echo 'true';
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_payout(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			
			$query = $this->db->query("SELECT sum(iushtxn_amount) as s_amount , MONTH(CURRENT_DATE()) as s_month FROM i_user_scheme_txn WHERE MONTH(iushtxn_created) = MONTH(CURRENT_DATE()) AND YEAR(iushtxn_created) = YEAR(CURRENT_DATE()) ");
			$result = $query->result();
			$data['s_amount'] = $result[0]->s_amount;

			$query = $this->db->query("SELECT sum(iushtxn_amount) as s_amount , iud_name ,i_uid FROM i_user_scheme_txn as a LEFT JOIN i_users as b on a.iushtxn_ref_code = b.i_user_code LEFT JOIN i_u_details as c on b.i_uid = c.iud_u_id WHERE MONTH(iushtxn_created) = MONTH(CURRENT_DATE()) AND YEAR(iushtxn_created) = YEAR(CURRENT_DATE()) GROUP BY i_uid ORDER BY s_amount DESC ");
			$result = $query->result();
			$data['u_amount'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_scheme_txn WHERE MONTH(iushtxn_created) = MONTH(CURRENT_DATE()) AND YEAR(iushtxn_created) = YEAR(CURRENT_DATE()) AND iushtxn_status = 'unpaid' GROUP BY iushtxn_uid ");
			$result = $query->result();
			$data['u_status'] = $result;

			$ert['title'] = "Scheme Payout";
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/scheme_payout',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_payout_filter(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$f_date = $this->input->post('f_date');
			$t_date = $this->input->post('t_date');

			$query = $this->db->query("SELECT sum(iushtxn_amount) as s_amount , iushtxn_uid , iud_name ,i_uid FROM i_user_scheme_txn as a LEFT JOIN i_users as b on a.iushtxn_ref_code = b.i_user_code LEFT JOIN i_u_details as c on b.i_uid = c.iud_u_id WHERE date(iushtxn_created) BETWEEN date('$f_date') AND date('$t_date') GROUP BY i_uid ORDER BY s_amount DESC ");
			$result = $query->result();
			$data['u_amount'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_scheme_txn WHERE date(iushtxn_created) BETWEEN date('$f_date') AND date('$t_date') AND iushtxn_status = 'unpaid' GROUP BY iushtxn_uid ");
			$result = $query->result();
			$data['u_status'] = $result;

			$data['f_timestamp'] = strtotime($f_date);
			$data['t_timestamp'] = strtotime($t_date);

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_payout_details($id,$f_date,$t_date){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			if ($f_date == '0') {
				$f_date = date('Y-m-1');
			}else{
				$f_date = date('Y-m-d',$f_date);
			}
			
			if ($t_date == '0') {
				$t_date = date('Y-m-d');
			}else{
				$t_date = date('Y-m-d',$t_date);
			}

			$query = $this->db->query("SELECT * FROM i_user_scheme_txn as a  LEFT JOIN i_user_transaction as b on a.iushtxn_txn_id = b.iutxn_id LEFT JOIN i_user_scheme as c on a.iushtxn_sid = c.iush_id LEFT JOIN i_u_details as d on a.iushtxn_uid = d.iud_u_id LEFT JOIN i_u_scheme_parameter as e on c.iush_id = e.iushp_sid WHERE date(iushtxn_created) BETWEEN date('$f_date') AND date('$t_date') AND iushtxn_ref_code IN ( SELECT i_user_code FROM i_users WHERE i_uid = '$id' )  GROUP BY iushtxn_id ");
			$result = $query->result();
			$data['u_details'] = $result;
			$pay_id = [];
			for ($i=0; $i <count($result) ; $i++) {
				array_push($pay_id, $result[$i]->iushtxn_payment_id );
			}
			$pid = 0 ;
			if (count($pay_id) > 0 ) {
				$pid = implode(',', $pay_id);	
			}

			$query = $this->db->query("SELECT * FROM i_user_scheme_payment WHERE iushpay_id IN ($pid) ");
			$result = $query->result();
			$data['history'] = $result;

			$ert['title'] = "Scheme Payout Details";
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/scheme_payout_details',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function scheme_payment_details(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			$p_mode = $this->input->post('p_mode');
			$p_date = $this->input->post('p_date');
			$p_amt = $this->input->post('p_amt');
			$p_vno = $this->input->post('p_vno');
			$p_desc = $this->input->post('p_desc');
			$sh_arr = $this->input->post('sh_arr');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iushpay_mode' => $p_mode,
				'iushpay_date' => $p_date,
				'iushpay_desc' => $p_desc,
				'iushpay_amount' => $p_amt,
				'iushpay_v_no' => $p_vno,
				'iushpay_created' => $dt,
			);
			$this->db->insert('i_user_scheme_payment',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($sh_arr) ; $i++) {
				$id = $sh_arr[$i]['id'];
				$ref_code = $sh_arr[$i]['ref_code'];
				if($sh_arr[$i]['flg'] == 'true' && $sh_arr[$i]['status'] == 'unpaid' ){
					$data = array(
						'iushtxn_payment_id' => $inid,
						'iushtxn_status' => 'paid'
					);
					$this->db->where(array('iushtxn_ref_code' => $ref_code , 'iushtxn_id' => $id ));
					$this->db->update('i_user_scheme_txn',$data);
				}
			}

			echo 'true';
		}else{
			redirect(base_url().'Portal/login');
		}
	}

########## Module activity type ###########

	public function module_activity_type(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
			
			$query = $this->db->query("SELECT * FROM i_modules");
			$data['modules'] = $query->result();
			$f = $this->config->item('document_rt').'application/views/account';
			$file_arr = [];
			$query = $this->db->query("SELECT * FROM i_portal_module_activity_type");
            $data['mod_act'] = $query->result();
            
		    foreach(glob($f.'/*.*') as $url) {
			    // $name = basename($url);
		     //    $ext = pathinfo($url, PATHINFO_EXTENSION);
		        $name2 =pathinfo($url, PATHINFO_FILENAME);
		        array_push($file_arr, $name2);
			}
			$data['files'] = $file_arr;

			$ert['title'] = "Module activity type";
			$ert['search'] = "false";
			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/module_activity_type',$data);
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function module_activity_type_save(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {
            
            $mid = $this->input->post('mid');
            $mod_act_type = $this->input->post('mod_act_type');
            $mod_act_date = $this->input->post('mod_act_date');
            $mod_act_shortcut = $this->input->post('mod_act_shortcut');
            $mod_act_cat = $this->input->post('mod_act_cat');
            $edit_flg = $this->input->post('edit_flg');
            $dt = date('Y-m-d H:i:s');
            $mname = '';
            $query = $this->db->query("SELECT * FROM i_modules where im_id = '$mid' ");
            $result = $query->result();
            if (count($result) > 0 ) {
            	$mname = $result[0]->im_name;
            }

            if ($edit_flg > 0) {
            	$data = array(
	            	'ipmat_mid' => $mid,
	            	'ipmat_mname' => $mname,
	            	'ipmat_act_type' => $mod_act_type,
	            	'ipmat_date_display' => $mod_act_date,
	            	'ipmat_shortcut_display' => $mod_act_shortcut,
	            	'ipmat_category_display' => $mod_act_cat,
	            	'ipmat_modified' => $dt,
	            	'ipmat_modified_by' => 0
	            );
            	$this->db->where('ipmat_id',$edit_flg);
            	$this->db->update('i_portal_module_activity_type',$data);
            }else{
            	$data = array(
	            	'ipmat_mid' => $mid,
	            	'ipmat_mname' => $mname,
	            	'ipmat_act_type' => $mod_act_type,
	            	'ipmat_date_display' => $mod_act_date,
	            	'ipmat_shortcut_display' => $mod_act_shortcut,
	            	'ipmat_category_display' => $mod_act_cat,
	            	'ipmat_created' => $dt,
	            	'ipmat_created_by' => 0
	            );
            	$this->db->insert('i_portal_module_activity_type',$data);
            }

            $query = $this->db->query("SELECT * FROM i_portal_module_activity_type");
            $data['mod_details'] = $query->result();

            print_r(json_encode($data));
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function module_activity_type_delete($id){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

            $this->db->WHERE('ipmat_id', $id );
            $this->db->delete('i_portal_module_activity_type');

            $query = $this->db->query("SELECT * FROM i_portal_module_activity_type");
            $data['mod_details'] = $query->result();

            print_r(json_encode($data));
		}else{
			redirect(base_url().'Portal/login');
		}
	}

########## Mobile users ###########

	public function mobile_users() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile as a LEFT JOIN i_users as b on a.iextetm_owner_id = b.i_uid ");
			$result = $query->result();
			$data['m_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_users ");
			$result = $query->result();
			$data['u_list'] = $result;

			$ert['title'] = "Mobile Users";
			$ert['search'] = "false";

			$this->load->view('portal_navbar', $ert);
			$this->load->view('portal/mobile_users',$data);
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function mobile_users_save() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$c_name = $this->input->post('company_name');
			$o_name = $this->input->post('owner_name');
			$login_f = $this->input->post('login_f');
			$verify_f = $this->input->post('verify_f');
			$color = $this->input->post('color');
			$dt = date('Y-d-m H:i:s');
		  // iextetm_modified datetime,
		  // iextetm_modified_by int
			$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$o_name' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$oid = $result[0]->i_uid;
				$data = array(
					'iextetm_company_name' => $c_name,
					'iextetm_owner_id' => $oid,
					'iextetm_login_function' => $login_f,
					'iextetm_verify_function' => $verify_f,
					'iextetm_color' => $color,
					'iextetm_created' => $dt,
					'iextetm_created_by' => 0
				);
				$this->db->insert('i_ext_et_mobile',$data);	
				echo $this->db->insert_id();
			}else{
				echo "false";
			}
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function mobile_users_update($inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$c_name = $this->input->post('company_name');
			$o_name = $this->input->post('owner_name');
			$login_f = $this->input->post('login_f');
			$verify_f = $this->input->post('verify_f');
			$color = $this->input->post('color');
			$dt = date('Y-d-m H:i:s');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$o_name' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$oid = $result[0]->i_uid;
				$data = array(
					'iextetm_company_name' => $c_name,
					'iextetm_owner_id' => $oid,
					'iextetm_login_function' => $login_f,
					'iextetm_verify_function' => $verify_f,
					'iextetm_color' => $color,
					'iextetm_modified' => $dt,
					'iextetm_modified_by' => 0
				);
				$this->db->WHERE('iextetm_id',$inid);
				$this->db->update('i_ext_et_mobile',$data);
				echo $inid;
			}else{
				echo "false";
			}
		} else {
			redirect(base_url().'Portal/login');
		}
	}

	public function mobile_logo_upload($in_id){
		$sess_data = $this->session->userdata();
		if($sess_data['admin_details'][0]){

			$upload_dir = $this->config->item('document_rt').'assets/data/portal/mobile_users/';
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$sourcePath = $_FILES[0]['tmp_name']; // Storing source path of the file in a variable
				$target = $upload_dir.$_FILES[0]['name']; // Target path where file is to be stored

				$path_parts = pathinfo($target);
				$file_name = $path_parts['filename'];
				$ext = $path_parts['extension'];
				$dt = date('Y-m-d H:i:s');
				$dt1=date_create();
				$dt_str = date_timestamp_get($dt1);
				$timestamp_value = $in_id.$dt_str;

				$targetPath = $upload_dir.$timestamp_value.'.'.$ext;

				 // ;
				if (move_uploaded_file($sourcePath,$targetPath)) {
					$data = array('iextetm_logo' => $timestamp_value.'.'.$ext);
					$this->db->where('iextetm_id',$in_id);
					$this->db->update('i_ext_et_mobile', $data);
					echo "true";
				}else{
					echo "false";
				}
			}
		}else{
			redirect(base_url().'Portal/login');
		}
	}

	public function mobile_users_delete($inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['admin_details'])) {

			$this->db->WHERE('iextetm_id',$inid);
			$this->db->delete('i_ext_et_mobile');
			echo "true";
		} else {
			redirect(base_url().'Portal/login');
		}
	}
}