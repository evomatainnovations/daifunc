<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModX extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
	}

	public function index() {
		$sess_data = $this->session->userdata();

		// print_r($sess_data);
		if(isset($sess_data['user_details'][0])) {
			$data['uid'] = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_uid;
			$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid'");
			$result = $query->result();
			$data['module'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Excel Modules";
			$ert['search'] = "false";


			$this->load->view('navbar', $ert);
			$this->load->view('account/module_home', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}


	public function application_generate($module_id, $view_type, $mid='na') {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$data['uid'] = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_uid;
			
			if ($view_type == "view") {
				$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
				$result = $query->result();
				$data['module'] = $result;

				$tble = $result[0]->icem_table;

				$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
				$ert['title'] = $result[0]->icem_name;
				$ert['search'] = "false";
				
				$que = "SELECT * FROM ".$tble;

				$query = $this->db->query($que);
				$result = $query->result();
				$data['module_table'] = $result;

				$data['mid']=$module_id;

				$query = $this->db->query("SELECT * FROM i_c_e_m_columns WHERE icemc_m_id='$module_id'");
				$result = $query->result();
				$data['module_column'] = $result;

				$this->load->view('navbar', $ert);
				$this->load->view('account/module_view', $data);
			} else if($view_type=="add") {
				$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
				$result = $query->result();
				$data['module'] = $result;

				$tble = $result[0]->icem_table;

				$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
				$ert['title'] = $result[0]->icem_name;
				$ert['search'] = "false";
				
				$que = "SELECT * FROM ".$tble;

				$query = $this->db->query($que);
				$result = $query->result();
				$data['module_table'] = $result;

				$data['mid']=$module_id;

				$query = $this->db->query("SELECT * FROM i_c_e_m_columns WHERE icemc_m_id='$module_id'");
				$result = $query->result();
				$data['module_column'] = $result;

				$this->load->view('navbar', $ert);
				$this->load->view('account/module_add_record', $data);
			} else if ($view_type=="edit") {
				$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
				$result = $query->result();
				$data['module'] = $result;

				$tble = $result[0]->icem_table;
				$prefix = $result[0]->icem_col_prefix."_id";

				$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
				$ert['title'] = $result[0]->icem_name;
				$ert['search'] = "false";
				

				$que = "SELECT * FROM ".$tble." WHERE ".$prefix."='".$mid."'";

				$query = $this->db->query($que);
				$result = $query->result();
				$data['edit_module_table'] = $result;

				$data['recid'] = $mid;
				$data['mid']=$module_id;

				$query = $this->db->query("SELECT * FROM i_c_e_m_columns WHERE icemc_m_id='$module_id'");
				$result = $query->result();
				$data['module_column'] = $result;

				$this->load->view('navbar', $ert);
				$this->load->view('account/module_add_record', $data);
			}
		} else {
			redirect(base_url().'Account/login');	
		}
	}

	public function application_save($module_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
			$result = $query->result();
			$tble = $result[0]->icem_table;

			$modval = $this->input->post('mod_val');

			$data = array();

			for ($i=0; $i < count($modval) ; $i++) { 
				$qwe = $result[0]->icem_col_prefix.$modval[$i]['i'];
				$data[$qwe] = $modval[$i]['v'];
			}

			$this->db->insert($tble, $data);

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function application_update($module_id, $recid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
			$result = $query->result();
			$tble = $result[0]->icem_table;
			$prefix = $result[0]->icem_col_prefix;
			$prefix = $prefix.'_id';
			$modval = $this->input->post('mod_val');

			$data = array();

			for ($i=0; $i < count($modval) ; $i++) { 
				$qwe = $result[0]->icem_col_prefix.$modval[$i]['i'];
				$data[$qwe] = $modval[$i]['v'];
			}

			$this->db->where($prefix, $recid);
			$this->db->update($tble, $data);

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function application_record_delete($module_id, $recid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_id = '$module_id'");
			$result = $query->result();
			$tble = $result[0]->icem_table;
			$prefix = $result[0]->icem_col_prefix;
			$prefix = $prefix.'_id';

			$this->db->where($prefix, $recid);
			$this->db->delete($tble);

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function details($uid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'])) {

			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid = '$uid'");
			$result = $query->result();

			$data['user_info'] = $result;
			
			$data['uid'] = $uid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "My Details";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/user_detail', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_details($uid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'])) {

			$data = array(
				'iud_name' => $this->input->post('name'),
				'iud_company' => $this->input->post('company'),
				'iud_email' => $this->input->post('email'),
				'iud_phone' => $this->input->post('phone'),
				'iud_address' => $this->input->post('address'));
			$this->db->where('iud_u_id', $uid);
			$this->db->update('i_u_details', $data);
			
			echo $uid;
		} else {
			redirect(base_url().'Account/login');
		}
	}



	public function login()	{
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'])){
			redirect(base_url().'Account');
		} else {
			$data['mode'] = "user";
			$this->load->view('account/login', $data);
		}
	}

	public function verify(){
		$uname = $this->input->post('uname');
		$upass = $this->input->post('upass');

		$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$uname'");
		$result = $query->result();

		if (count($result) > 0) {
			if ($result[0]->i_status == 'password update') {
				$id = $result[0]->i_uid;

				echo $id;
			} elseif ($result[0]->i_upassword==$upass) {
				$id = $result[0]->i_uid;

				$query1 = $this->db->query("SELECT b.im_address, b.im_name FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id WHERE a.ium_u_id = '$id'");
				$result1 = $query1->result();

				
				$data = array('status' => "user" , "user_details" => $result, "user_mod" => $result1);
				$this->session->set_userdata($data);
	
				echo "true";
			} else {
				echo "false";
			}			
		} else {
			echo "false";
		}		
	}

	public function reset_password($uid) {
		$data['uid'] = $uid;
		$this->load->view('account/reset', $data);
	}

	public function reset_update($uid) {
		$oid = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'i_upassword' => $this->input->post('upass'),
			'i_status' => 'true',
			'i_modified' => $dt,
			'i_modified_by' => $oid
			);
		$this->db->where('i_uid', $uid);
		$this->db->update('i_users', $data);
		
		echo "true";
	}

	public function logout() {
		$this->session->unset_userdata('user_details');
		$this->session->unset_userdata('user_mod');
		$this->session->unset_userdata('status');
		redirect(base_url().'Account');
	}


	public function create_module() {
		$sess_data = $this->session->userdata();
		if($sess_data['user_details'][0]){
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;


			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Module Create";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/module_create', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_module() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$c_name = $this->input->post('name');
			$c_tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'icem_name' => $c_name,
				'icem_owner' => $oid,
				'icem_created' => $dt,
				'icem_created_by' => $oid );

			$this->db->insert('i_c_excel_module', $data);
			$mid = $this->db->insert_id();

			for ($j=0; $j < count($c_tags) ; $j++) { 
				$tmp_tag = $c_tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data3);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data4 = array(
					'icemp_m_id' => $mid,
					'icemp_tag_id' => $tid);

				$this->db->insert('i_c_e_m_prefernces', $data4);
			}

			echo $mid;

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function uploadfile($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/irene/assets/data/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				$img_path = $targetPath;
			
				$img_path = $_FILES['use']['name'];
				echo $_FILES['use']['name'];
			}

			$data = array('icem_path' => $img_path);
			$this->db->where('icem_id', $cid);
			$this->db->update('i_c_excel_module', $data);

		} else {
			redirect(base_url().'Account/login');
		}
	}
	public function read_excel() {
		$this->excel_reader->read('./uploads/file.xls');
		// Get the contents of the first worksheet
		$worksheet = $this->excel_reader->sheets[0];

		$numRows = $worksheet['numRows']; // ex: 14
		$numCols = $worksheet['numCols']; // ex: 4
		$cells = $worksheet['cells']; // the 1st row are usually the field's name
	}
	
}