<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requirement extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->helper('directory');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
		$this->load->dbforge();
	}

	public function home($mid = null,$code){
			$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$module_id = '';$mname='';$alias='';

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Requirement') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data["mod_id"] = $module_id;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_owner = '$oid' AND iextetr_gid = '$gid' ");
			$result = $query->result();
			$data['req_list'] = $result;
			
			$data['gid'] = $gid;$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$ert['mid'] = $module_id;$ert['mname'] = $mname;$ert['gid']=$gid;$ert['code']=$code;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('requirement/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function add_req($code,$req_id = null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$module_id = '';$mname='';$alias='';

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Requirement') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
			$result = $query->result();
			$data['contact'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ");
			$result = $query->result();
			$data['oppo'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_gid = '$gid' AND iextpp_owner = '$oid' ");
			$result = $query->result();
			$data['project'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_owner = '$oid' AND iextetr_gid = '$gid' ");
			$result = $query->result();
			$data['req_list'] = $result;

			if ($req_id == null) {
				if ($alias == '') {
					$ert['title'] = $mname." Add";
				}else{
					$ert['title'] = $alias." Add";
				}
			}else{

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_id = '$req_id' AND iextetr_owner = '$oid' AND iextetr_gid = '$gid' ");
				$result = $query->result();
				$data['edit_req'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_mutual as a LEFT JOIN i_customers as b on a.iextetrm_uid = b.ic_uid WHERE iextetrm_req_id = '$req_id' AND ic_owner = '$oid' ");
				$result = $query->result();
				$data['mutual_tag'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_product as a LEFT JOIN i_product as b on a.iextetrp_product_id = b.ip_id WHERE iextetrp_req_id = '$req_id' ");
				$result = $query->result();
				$data['edit_req_list'] = $result;

				$data['edit_req_id'] = $req_id;

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_notes WHERE iextetrn_req_id = '$req_id' ORDER BY iextetrn_id ASC ");
				$result = $query->result();
				$data['edit_notes'] = $result;

				if ($alias == '') {
					$ert['title'] = $mname." Edit";
				}else{
					$ert['title'] = $alias." Edit";
				}
			}

			$data["mod_id"] = $module_id;		
			$data['gid'] = $gid;$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$ert['mid'] = $module_id;$ert['mname'] = $mname;$ert['gid']=$gid;$ert['code']=$code;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('requirement/add_req', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_req_title($code,$type,$txn_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$title = 0;
			if ($type == 'contact') {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$txn_id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$title = $result[0]->ic_name;
				}
			}else if($type == 'project'){
				$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_gid = '$gid' AND iextpp_owner = '$oid' AND iextpp_id = '$txn_id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$title = $result[0]->iextpp_p_name;
				}
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' AND iextetop_id = '$txn_id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$title = $result[0]->iextetop_title;
				}
			}

			echo $title;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_req_product_list($code,$txn_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$query = $this->db->query("SELECT * FROM i_ext_et_requirement_product as a LEFT JOIN i_product as b on a.iextetrp_product_id = b.ip_id WHERE iextetrp_req_id = '$txn_id' ");
			$result = $query->result();
			$data['req_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	// public function save_req_list($code,$req_id=null){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];
	// 		$dt = date('Y-m-d H:i:s');
	// 		$pro_list = $this->input->post('pro_list');
	// 		$req_title = $this->input->post('req_title');
	// 		$txn_id = $this->input->post('txn_id');
	// 		$txn_type = $this->input->post('txn_type');

	// 		if ($req_id == null) {
	// 			$data = array(
	// 				'iextetr_title' => $req_title,
	// 				'iextetr_type' => $txn_type,
	// 				'iextetr_type_id' => $txn_id,
	// 				'iextetr_owner' => $oid,
	// 				'iextetr_created' => $dt,
	// 				'iextetr_created_by' => $uid,
	// 				'iextetr_gid' => $gid
	// 			);
	// 			$this->db->insert('i_ext_et_requirement',$data);
	// 			$req_id = $this->db->insert_id();	
	// 		}else{
	// 			$data = array(
	// 				'iextetr_title' => $req_title,
	// 				'iextetr_type' => $txn_type,
	// 				'iextetr_type_id' => $txn_id,
	// 				'iextetr_modified' => $dt,
	// 				'iextetr_modified_by' => $uid
	// 			);
	// 			$this->db->where(array('iextetr_owner' => $oid,'iextetr_id' => $req_id ));
	// 			$this->db->update('i_ext_et_requirement',$data);

	// 			$this->db->WHERE(array('iextetrp_req_id' => $req_id));
	// 			$this->db->delete('i_ext_et_requirement_product');
	// 		}

	// 		for ($i=0; $i < count($pro_list) ; $i++) { 
	// 			$pro_name = $pro_list[$i]['pro_name'];

	// 			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pro_name' AND ip_owner = '$oid' ");
	// 			$result = $query->result();
	// 			if (count($result) > 0 ) {
	// 				$pro_id = $result[0]->ip_id;
	// 			}else{
	// 				$data = array(
	// 					'ip_product' => $pro_name,
	// 					'ip_owner' => $oid,
	// 					'ip_created' => $dt,
	// 					'ip_created_by' => $uid,
	// 					'ip_section' => 'Products',
	// 					'ip_gid' => $gid,
	// 					'ip_cat_id' => 0 
	// 				);
	// 				$this->db->insert('i_product',$data);
	// 				$pro_id = $this->db->insert_id();
	// 			}

	// 			$data = array(
	// 				'iextetrp_req_id' => $req_id,
	// 				'iextetrp_product_id' => $pro_id,
	// 				'iextetrp_qty' => $pro_list[$i]['qty']
	// 			);
	// 			$this->db->insert('i_ext_et_requirement_product',$data);
	// 		}

	// 		echo $req_id;
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	public function update_req($code,$req_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$dt = date('Y-m-d H:i:s');
			$pro_list = $this->input->post('pro_list');
			$req_title = $this->input->post('req_title');
			$txn_id = $this->input->post('txn_id');
			$txn_type = $this->input->post('txn_type');
			$notes = $this->input->post('notes');
			$mutual = $this->input->post('mutual');
			
			$data = array(
				'iextetr_title' => $req_title,
				'iextetr_type' => $txn_type,
				'iextetr_type_id' => $txn_id,
				'iextetr_modified' => $dt,
				'iextetr_modified_by' => $uid
			);
			$this->db->where(array('iextetr_owner' => $oid,'iextetr_id' => $req_id ));
			$this->db->update('i_ext_et_requirement',$data);

			for ($i=0; $i < count($notes) ; $i++) { 
				$data = array(
					'iextetrn_req_id' => $req_id,
					'iextetrn_type' => 'note',
					'iextetrn_content' => $notes[$i]['content'],
					'iextetrn_date' => $dt
				);
				$this->db->insert('i_ext_et_requirement_notes',$data);
			}

			$this->db->WHERE(array('iextetrp_req_id' => $req_id));
			$this->db->delete('i_ext_et_requirement_product');

			for ($i=0; $i < count($pro_list) ; $i++) { 
				$pro_name = $pro_list[$i]['pro_name'];

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pro_name' AND ip_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$pro_id = $result[0]->ip_id;
				}else{
					$data = array(
						'ip_product' => $pro_name,
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $uid,
						'ip_section' => 'Products',
						'ip_gid' => $gid,
						'ip_cat_id' => 0 
					);
					$this->db->insert('i_product',$data);
					$pro_id = $this->db->insert_id();
				}

				$data = array(
					'iextetrp_req_id' => $req_id,
					'iextetrp_product_id' => $pro_id,
					'iextetrp_qty' => $pro_list[$i]['qty']
				);
				$this->db->insert('i_ext_et_requirement_product',$data);
			}

			$this->db->WHERE('iextetrm_req_id',$req_id);
			$this->db->delete('i_ext_et_requirement_mutual');

			for ($i=0; $i < count($mutual) ; $i++) {
				$cust_name = $mutual[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid' AND ic_uid IS NOT NULL ");
				$result = $query->result();
				$c_uid = 0;
				if (count($result) > 0) {
					$c_uid = $result[0]->ic_uid;	
				}

				$data = array(
					'iextetrm_req_id' => $req_id,
					'iextetrm_uid' => $c_uid,
				);
				$this->db->insert('i_ext_et_requirement_mutual',$data);
			}
			echo $req_id;			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_req($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$pro_list = $this->input->post('pro_list');
			$req_title = $this->input->post('req_title');
			$txn_id = $this->input->post('txn_id');
			$txn_type = $this->input->post('txn_type');
			$notes = $this->input->post('notes');
			$mutual = $this->input->post('mutual');
			
			$data = array(
				'iextetr_title' => $req_title,
				'iextetr_type' => $txn_type,
				'iextetr_type_id' => $txn_id,
				'iextetr_owner' => $oid,
				'iextetr_created' => $dt,
				'iextetr_created_by' => $uid,
				'iextetr_gid' => $gid
			);
			$this->db->insert('i_ext_et_requirement',$data);
			$req_id = $this->db->insert_id();	

			for ($i=0; $i < count($notes) ; $i++) { 
				$data = array(
					'iextetrn_req_id' => $req_id,
					'iextetrn_type' => 'note',
					'iextetrn_content' => $notes[$i]['content'],
					'iextetrn_date' => $dt
				);
				$this->db->insert('i_ext_et_requirement_notes',$data);
			}

			for ($i=0; $i < count($pro_list) ; $i++) { 
				$pro_name = $pro_list[$i]['pro_name'];

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pro_name' AND ip_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$pro_id = $result[0]->ip_id;
				}else{
					$data = array(
						'ip_product' => $pro_name,
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $uid,
						'ip_section' => 'Products',
						'ip_gid' => $gid,
						'ip_cat_id' => 0 
					);
					$this->db->insert('i_product',$data);
					$pro_id = $this->db->insert_id();
				}

				$data = array(
					'iextetrp_req_id' => $req_id,
					'iextetrp_product_id' => $pro_id,
					'iextetrp_qty' => $pro_list[$i]['qty']
				);
				$this->db->insert('i_ext_et_requirement_product',$data);
			}

			for ($i=0; $i < count($mutual) ; $i++) {
				$cust_name = $mutual[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid' AND ic_uid IS NOT NULL ");
				$result = $query->result();
				$c_uid = 0;
				if (count($result) > 0) {
					$c_uid = $result[0]->ic_uid;	
				}

				$data = array(
					'iextetrm_req_id' => $req_id,
					'iextetrm_uid' => $c_uid,
				);
				$this->db->insert('i_ext_et_requirement_mutual',$data);
			}

			echo $req_id;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function req_doc_upload($code,$req_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['code'] = $code;
			$dt = date('Y-m-d H:i:s');
			$module = $sess_data['user_mod'];
			$module_id = '';$mname='';$alias='';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Requirement') {
					$module_id = $module[$i]->mid;
					break;
				}
			}

			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;
			$img_path = "";

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				for ($i=0; $i <count($_FILES['used']['tmp_name']) ; $i++) {
					
					$sourcePath = $_FILES['used']['tmp_name'][$i]; // Storing source path of the file in a variable
					$target = $upload_dir.$_FILES['used']['name'][$i]; // Target path where file is to be stored

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
						'icd_file' => $file_name,
						'icd_owner' => $oid,
						'icd_cid' => $cid,
						'icd_date' => $dt,
						'icd_type' => 'req_note',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $module_id,
						'icd_type_id' => $req_id,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);

					$data = array(
						'iextetrn_req_id' => $req_id,
						'iextetrn_type' => 'file',
						'iextetrn_content' => $timestamp_value.'.'.$ext,
						'iextetrn_date' => $dt
					);
					$this->db->insert('i_ext_et_requirement_notes',$data);


					$timestamp_value = '';
				}
				$img_path = '';
			}

			echo $req_id;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function delete_req($code,$req_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->where(array('iextetr_owner' => $oid,'iextetr_id' => $req_id ));
			$this->db->delete('i_ext_et_requirement');

			$this->db->WHERE(array('iextetrp_req_id' => $req_id));
			$this->db->delete('i_ext_et_requirement_product');

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

}