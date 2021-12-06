<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design_manager extends CI_Controller {

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

	public function home($mod_id = null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';$alias='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Design Manager') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_owner = '$oid' AND iextetdm_gid = '$gid' ");
			$result = $query->result();
			$data['dm_list'] = $result;

			$data['mod_id'] = $module_id;$data['gid']=$gid;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$this->load->view('navbar', $ert);
			$this->load->view('design_manager/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function add_design_manager($code,$dm_id=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';$alias='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Design Manager') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_dm_template WHERE iextetdmt_owner = '$oid' AND iextetdmt_gid = '$gid' ");
			$result = $query->result();
			$data['dm_temp_list'] = $result;

			$data['dm_temp'] = [];
			if ($dm_id != null) {
				$data['dm_id'] = $dm_id;

				$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_owner = '$oid' AND iextetdm_gid = '$gid' AND iextetdm_id = '$dm_id' ");
				$result = $query->result();
				$data['dm_list'] = $result;
				if (count($result) > 0 ) {
					$file_name = $result[0]->iextetdm_file;
					$path = $this->config->item('document_rt')."assets/data/design_manager/";
		            $fl = $path.$file_name;
		            $data['edit_dm_temp'] = json_decode(file_get_contents($fl));
				}

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
				$result = $query->result();
				$data['c_list'] = $result;
			}

			$data['mod_id'] = $module_id;$data['gid']=$gid;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$this->load->view('navbar', $ert);
			$this->load->view('design_manager/add_design_manager', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_design_manager($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

			$dm_type = 0;
			$dm_type_id = 0;
			$dm_title = $this->input->post('dm_title');
			$dm_cat = $this->input->post('dm_cat');
			$dm_remark = $this->input->post('dm_remark');
			$dm_id = $this->input->post('dm_id');
			$dm_arr = $this->input->post('dm_arr');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($dm_arr);
			$upload_dir = $this->config->item('document_rt')."assets/data/design_manager/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_owner = '$oid' AND iextetdm_gid = '$gid' AND iextetdm_id = '$dm_id' ");
			$result = $query->result();

			if (count($result) > 0 ) {
				$inid = $result[0]->iextetdm_id;
				$data = array(
					'iextetdm_file' => $dt_str.'.json',
					'iextetdm_title' => $dm_title,
					'iextetdm_modified' => $dt,
					'iextetdm_modified_by' => $uid
				);
				$this->db->WHERE(array('iextetdm_id' => $inid , 'iextetdm_owner' => $oid));
				$this->db->update('i_ext_et_design_manager',$data);
				
			}else{
				$data = array(
					'iextetdm_file' => $dt_str.'.json',
					'iextetdm_type' => $dm_type,
					'iextetdm_type_id' => $dm_type_id,
					'iextetdm_title' => $dm_title,
					'iextetdm_owner' => $oid,
					'iextetdm_created' => $dt,
					'iextetdm_created_by' => $uid,
					'iextetdm_gid' => $gid
				);
				$this->db->insert('i_ext_et_design_manager',$data);
				$inid = $this->db->insert_id();
			}
			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function dm_doc_upload($code,$dm_id,$inid,$dm_remark){
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
				if ($module[$i]->mname == 'Design_manager') {
					$module_id = $module[$i]->mid;
					break;
				}
			}

			$dm_remark = str_replace("%20"," ",$dm_remark);

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
						'icd_type' => 'design_manager',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $module_id,
						'icd_type_id' => $dm_id,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);

  					$data = array(
  						'iextetdmcu_dmc_id' => $dm_id,
  						'iextetdmcu_cat_id' => $inid,
						'iextetdmcu_file_name' => $file_name,
						'iextetdmcu_timestamp' => $timestamp_value.'.'.$ext,
						'iextetdmcu_final' => 'false',
						'iextetdmcu_upload_by' => $uid,
						'iextetdmcu_date' => $dt,
						'iextetdmcu_remark' => $dm_remark
  					);
  					$this->db->insert('i_ext_et_dm_category_upload', $data);

					$timestamp_value = '';
				}
				$img_path = '';
			}

			echo $dm_id;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_dm_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$dm_id = $this->input->post('dm_id');

			$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_owner = '$oid' AND iextetdm_gid = '$gid' AND iextetdm_id = '$dm_id' ");
			$result = $query->result();
			$dm_id = 0;
			if (count($result) > 0 ) {
				$dm_id = $result[0]->iextetdm_id;
			}
			$data['edit_dm'] = $result;

			$data['edit_dmc_upload'] = [];
			$query = $this->db->query("SELECT * FROM i_ext_et_dm_category_upload WHERE iextetdmcu_dmc_id = '$dm_id' AND iextetdmcu_cat_id = '$id' ");
			$res = $query->result();
			array_push($data['edit_dmc_upload'], $res);

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE  icbd_property = '$p_id' AND ic_id = '$oid' ");
			$result = $query->result();
			$data['users'] = $result;

			print_r(json_encode($data));

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function change_dm_status($code,$id,$status,$dm_id,$cat_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextetdmcu_final' => 'false',
				'iextetdmcu_final_on' => null
			);
			$this->db->where(array('iextetdmcu_dmc_id' => $dm_id , 'iextetdmcu_cat_id' => $cat_id));
			$this->db->update('i_ext_et_dm_category_upload',$data);
			if ($status == 'false') {
				$dt = null;
			}
			$data = array(
				'iextetdmcu_final' => $status,
				'iextetdmcu_final_on' => $dt
			);
			$this->db->where('iextetdmcu_id',$id);
			$this->db->update('i_ext_et_dm_category_upload',$data);

			echo $dt;

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function download_dm_doc($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

		    $path = $this->config->item('document_rt')."assets/uploads/".$oid."/";

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_dm_category_upload WHERE iextetdmcu_id = '$id' ");
			$res = $query->result();
			$file_name = $res[0]->iextetdmcu_timestamp;

	    	$this->load->helper('download');
			force_download($path.$file_name, NULL);

		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function update_remark($code,$dm_id,$upload_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

		    $remark = $this->input->post('remark_edit');

		    $data = array(
				'iextetdmcu_remark' => $remark
			);
			$this->db->WHERE(array('iextetdmcu_id' => $upload_id , 'iextetdmcu_dmc_id' => $dm_id));
			$this->db->update('i_ext_et_dm_category_upload', $data);

	    	echo "true";
		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function dm_delete($code,$dm_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->where(array('iextetdmcu_dmc_id' => $dm_id));
			$this->db->delete('i_ext_et_dm_category_upload');

			$this->db->where(array('iextetdm_id' => $dm_id , 'iextetdm_owner' => $oid));
			$this->db->delete('i_ext_et_design_manager');

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

############################# DM template #########################

	public function add_dm_template($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';$alias='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Design Manager') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_dm_template WHERE iextetdmt_owner = '$oid' AND iextetdmt_gid = '$gid' ");
			$result = $query->result();
			$data['dm_temp_list'] = $result;

			$data['mod_id'] = $module_id;$data['gid']=$gid;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$this->load->view('navbar', $ert);
			$this->load->view('design_manager/add_dm_template', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function dm_template_save($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$arr = $this->input->post('arr');
			$title = $this->input->post('title');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($arr);
			$upload_dir = $this->config->item('document_rt')."assets/data/design_manager/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$data = array(
			  'iextetdmt_title' => $title,
			  'iextetdmt_file' => $dt_str.'.json',
			  'iextetdmt_owner' => $oid,
			  'iextetdmt_created' => $dt,
			  'iextetdmt_created_by' => $uid,
			  'iextetdmt_gid' => $gid
			);
			$this->db->insert('i_ext_et_dm_template',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function dm_template_update($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$arr = $this->input->post('arr');
			$title = $this->input->post('title');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($arr);
			$upload_dir = $this->config->item('document_rt')."assets/data/design_manager/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$data = array(
			  'iextetdmt_title' => $title,
			  'iextetdmt_file' => $dt_str.'.json',
			  'iextetdmt_modified' => $dt,
			  'iextetdmt_modified_by' => $uid,
			);
			$this->db->where(array('iextetdmt_owner' => $oid , 'iextetdmt_id' => $id));
			$this->db->update('i_ext_et_dm_template',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_dm_template($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			if ($id != 'null') {
				$query = $this->db->query("SELECT * FROM i_ext_et_dm_template WHERE iextetdmt_gid = '$gid' AND iextetdmt_created_by = '$uid' AND iextetdmt_id = '$id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$file_name = $result[0]->iextetdmt_file;
					$title = $result[0]->iextetdmt_title;
				}
				$data['title'] = $title;
				$path = $this->config->item('document_rt')."assets/data/design_manager/";
	            $fl = $path.$file_name;
	            $data['dm_temp'] = json_decode(file_get_contents($fl));	
			}else{
				$data = [];
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function dm_delete_temp($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->where(array('iextetdmt_owner' => $oid , 'iextetdmt_id' => $id));
			$this->db->delete('i_ext_et_dm_template');
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function dm_send_mail($code,$dm_id,$dm_cat_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$email = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');

			$query = $this->db->query("SELECT * FROM i_ext_et_dm_category_upload WHERE iextetdmcu_dmc_id = '$dm_id' AND iextetdmcu_cat_id = '$dm_cat_id' ");
			$result = $query->result();
			$file_name = '';
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetdmcu_timestamp;
				$title = $result[0]->iextetdmcu_file_name;
			}

			for ($i=0; $i < count($email) ; $i++) {
				if ($email[$i]['status'] == 'true') {
					$mail_id = $email[$i]['value'];
					$body = '';
					$body .= $content;
					$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
					$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($file_name).'"><button class="btn btn-lg btn-danger">'.$title.'</button></a>';
					$temp = $this->Mail->send_mail($subject,$mail_id,null,$body,$code);
				}
			}

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}
}