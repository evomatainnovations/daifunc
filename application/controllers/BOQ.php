<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BOQ extends CI_Controller {

public function __construct()	{
	parent:: __construct();
	$this->load->database();
	$this->load->helper('url');
	$this->load->library('session');
	$this->load->library('email');
	$this->load->library('excel_reader');
	$this->load->library('pagination');
	$this->load->model('Code','log_code');
	$this->load->model('Mail','Mail');
}

########## HOME ################
	public function home($mid=0,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];

			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'BOQ') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
			$result = $query->result();
			$data['boq_list'] = $result;

			$q = $this->db->query("SELECT * FROM i_ext_et_boq_mail WHERE iextetboqm_owner = '$oid' AND iextetboqm_res_date IS NOT NULL ");
			$r = $q->result();
			$data['boq_count'] = $r;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('boq/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_boq($code,$boq_id = null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'BOQ') {
					$mid = $module[$i]->mid;
					$mname = $module[$i]->mname;
					$alias = $module[$i]->m_alias;
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_uid IS NOT NULL ");
			$result = $query->result();
			$data['contact'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ");
			$result = $query->result();
			$data['oppo'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_gid = '$gid' AND iextpp_owner = '$oid' ");
			$result = $query->result();
			$data['project'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
			$result = $query->result();
			$data['boq_list'] = $result;

			if ($boq_id != null) {
				$data['boq_id'] = $boq_id;
				$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_id = '$boq_id' AND iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
				$result = $query->result();
				$data['edit_boq'] = $result;
				$path = $this->config->item('document_rt')."assets/data/boq/";
	            $file_name = $result[0]->iextetboq_file;
	            $fl = $path.$file_name;
	            $file_arr = json_decode(file_get_contents($fl));
	            $data['table_arr'] = $file_arr->table[0];
	            $data['info_arr'] = $file_arr->info[0];
	            $data['req_arr'] = $file_arr->req[0];

				if ($alias == '') {
					$ert['title'] = 'Edit '.$mname;
				}else{
					$ert['title'] = 'Edit '.$alias;
				}
			}else{
				if ($alias == '') {
					$ert['title'] = 'Add '.$mname;
				}else{
					$ert['title'] = 'Add '.$alias;
				}
			}

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			$this->load->view('navbar', $ert);
			$this->load->view('boq/add_boq', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function cust_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('c');

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;
			$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_property = '$p_id' AND a.icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid')");
			$result = $query->result();
			$data['details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function send_boq_mail($code,$boq_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$e_arr = $this->input->post('email_arr');
			$sub = $this->input->post('sub');
			$content = $this->input->post('content');

			for ($i=0; $i < count($e_arr) ; $i++) {
				$cid = 0;
				$cust_name = $e_arr[$i]['cname'];
				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$p_id = $result[0]->ip_id;
					$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_property = '$p_id' AND a.icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid')");
					$result = $query->result();
					if (count($result) > 0) {
						$cid = $result[0]->icbd_customer_id;
						if ($result[0]->icbd_value == '') {
							$data = array(
								'icbd_customer_id' => $cid,
								'icbd_property' => $p_id,
								'icbd_value' => $e_arr[$i]['email']
							);
							$this->db->insert('i_c_basic_details',$data);
						}
					}else{
						$data1 = array(
							'ic_name' => $cust_name,
							'ic_owner' => $oid,
							'ic_created' => $dt,
							'ic_section' => 'customer',
							'ic_created_by' => $oid );
						$this->db->insert('i_customers', $data1);
						$cid = $this->db->insert_id();
						$data = array(
							'icbd_customer_id' => $cid,
							'icbd_property' => $p_id,
							'icbd_value' => $e_arr[$i]['email']
						);
						$this->db->insert('i_c_basic_details',$data);
					}

					$data1 = array(
						'iextetboqm_boq_id' => $boq_id,
						'iextetboqm_cid' => $cid,
						'iextetboqm_send_date' => $dt,
						'iextetboqm_owner' => $oid );
					$this->db->insert('i_ext_et_boq_mail', $data1);
					$inid = $this->db->insert_id();

					$content .= ' Plz find bellow link .. <br>'.base_url().'BOQ/vendor_submit_boq/'.$oid.'/'.$boq_id.'/'.$inid;
					$this->Mail->send_mail($sub,$e_arr[$i]['email'],null,$content,$code);
				}
			}
			echo $boq_id;
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_boq($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$table = $this->input->post('table_arr');
			$txn_name = $this->input->post('txn_name');
			$req = $this->input->post('req_arr');
			$info = $this->input->post('info_arr');
			$com_name = $this->input->post('com_name');
			$jarr['table'] = [];
			$jarr['req'] = [];
			$jarr['info'] = [];
			array_push($jarr['table'],$table);
			array_push($jarr['req'],$req);
			array_push($jarr['info'],$info);

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($jarr);
			$upload_dir = $this->config->item('document_rt')."assets/data/boq/";

			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$data = array(
			  'iextetboq_title' => $txn_name,
			  'iextetboq_file' => $dt_str.'.json',
			  'iextetboq_owner' => $oid,
			  'iextetboq_created' => $dt,
			  'iextetboq_created_by' => $uid,
			  'iextetboq_gid' => $gid,
			  'iextetboq_status' => 'pending',
			  'iextetboq_col_name' => $com_name
			);
			$this->db->insert('i_ext_et_boq',$data);
			$boq_id = $this->db->insert_id();

			echo $boq_id;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function update_boq($code,$boq_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$table = $this->input->post('table_arr');
			$txn_name = $this->input->post('txn_name');
			$req = $this->input->post('req_arr');
			$info = $this->input->post('info_arr');
			$com_name = $this->input->post('com_name');
			$jarr['table'] = [];
			$jarr['req'] = [];
			$jarr['info'] = [];
			array_push($jarr['table'],$table);
			array_push($jarr['req'],$req);
			array_push($jarr['info'],$info);

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($jarr);
			$upload_dir = $this->config->item('document_rt')."assets/data/boq/";

			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$data = array(
			  'iextetboq_title' => $txn_name,
			  'iextetboq_file' => $dt_str.'.json',
			  'iextetboq_col_name' => $com_name
			);
			$this->db->where(array('iextetboq_owner' => $oid , 'iextetboq_id' => $boq_id ));
			$this->db->update('i_ext_et_boq',$data);

			echo $boq_id;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_boq_template($code,$boq_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_id = '$boq_id' AND iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboq_file;
			}

			$path = $this->config->item('document_rt')."assets/data/boq/";
            $fl = $path.$file_name;
            $data_arr = json_decode(file_get_contents($fl));

			print_r(json_encode($data_arr));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function delete_boq($code,$boq_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$this->db->where(array('iextetboq_owner' => $oid , 'iextetboq_id' => $boq_id ));
			$this->db->delete('i_ext_et_boq');

			$this->db->WHERE(array('iextetboqm_boq_id' => $boq_id ));
			$this->db->delete('i_ext_et_boq_mail');

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function vendor_submit_boq($oid,$boq_id,$inid=0) {
		$data['boq_id'] = $boq_id;
		$data['oid'] = $oid;
		$data['inid'] = $inid;

		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$oid' ");
		$result = $query->result();
		if (count($result) > 0 ) {
			$data['logo'] = $result[0]->iud_logo;
		}

		$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_id = '$boq_id' AND iextetboq_owner = '$oid' ");
		$result = $query->result();
		$data['edit_boq'] = $result;
		$path = $this->config->item('document_rt')."assets/data/boq/";
        $file_name = $result[0]->iextetboq_file;
        $fl = $path.$file_name;
        $file_arr = json_decode(file_get_contents($fl));
        $data['table_arr'] = $file_arr->table[0];
        $data['info_arr'] = $file_arr->info[0];
        $data['req_arr'] = $file_arr->req[0];
		$this->load->view('boq/vendor_form_submit',$data);
	}

	public function boq_doc_upload($oid,$boq_id,$inid=0){
		$dt = date('Y-m-d H:i:s');
		$query = $this->db->query("SELECT * FROM i_modules as a left join i_function as b on a.im_function = b.ifun_id left join i_domain as c on a.im_domain = c.idom_id WHERE im_name = 'BOQ' ");
		$result = $query->result();
		$mid = 0;
		if (count($result) > 0 ) {
			$mid = $result[0]->im_id;
		}

		$q = $this->db->query("SELECT * FROM i_ext_et_boq_mail WHERE iextetboqm_boq_id = '$boq_id' AND iextetboqm_id = '$inid' ");
		$r = $q->result();
		$cid = 0;
		if (count($r) > 0 ) {
			$cid = $r[0]->iextetboqm_cid;
		}

		$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
		if(!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}

		$img_path = "";
		$upload_id = [];
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
					'icd_type' => 'document',
					'icd_timestamp' => $timestamp_value.'.'.$ext,
					'icd_mid' => $mid,
					'icd_type_id' => $boq_id,
					'icd_status' => 'true'
				);
				$this->db->insert('i_c_doc', $data);
				array_push($upload_id, $this->db->insert_id());
				$timestamp_value = '';
			}	
			$img_path = '';
		}
		$data['upload_id'] = $upload_id;
		print_r(json_encode($data));
	}

	public function boq_res_submit($oid,$boq_id,$inid=0) {
		$data['boq_id'] = $boq_id;
		$data['oid'] = $oid;
		$data['inid'] = $inid;
		$dt = date('Y-m-d H:i:s');
		$table = $this->input->post('table_arr');
		$req = $this->input->post('req_arr');
		$info = $this->input->post('info_arr');
		$note = $this->input->post('note');

		$jarr['table'] = [];
		$jarr['req'] = [];
		$jarr['info'] = [];
		$jarr['note'] = [];
		array_push($jarr['table'],$table);
		array_push($jarr['req'],$req);
		array_push($jarr['info'],$info);
		array_push($jarr['note'],$note);
		$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
		$jstr = json_encode($jarr);
		$upload_dir = $this->config->item('document_rt')."assets/data/boq/";

		if(!file_exists($upload_dir)) {
			mkdir($upload_dir, 0777, true);
		}

		if (is_dir($upload_dir) && is_writable($upload_dir)) {
			$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
			fwrite($handle, $jstr);
		}
		fclose($handle);

		if ($inid == '0' || $inid == 0) {
			$data1 = array(
				'iextetboqm_cid' => 0,
				'iextetboqm_res_date' => $dt,
				'iextetboqm_file' => $dt_str.'.json',
				'iextetboqm_id' => $inid ,
				'iextetboqm_boq_id' => $boq_id ,
				'iextetboqm_owner' => $oid
				// 'iextetboqm_note' => $note
			);
			$this->db->insert('i_ext_et_boq_mail', $data1);
		}else{
			$data1 = array(
				'iextetboqm_res_date' => $dt,
				'iextetboqm_file' => $dt_str.'.json'
				// 'iextetboqm_note' => $note
			);
			$this->db->where(array('iextetboqm_id' => $inid , 'iextetboqm_boq_id' => $boq_id , 'iextetboqm_owner' => $oid ));
			$this->db->update('i_ext_et_boq_mail', $data1);
		}
		echo "true";
	}

	public function boq_res_view($code,$boq_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];

			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'BOQ') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			$path = $this->config->item('document_rt')."assets/data/boq/";

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' AND iextetboq_id = '$boq_id' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboq_file;
	            $fl = $path.$file_name;
	            $file_arr = json_decode(file_get_contents($fl));
	            $data['table_arr'] = $file_arr->table[0];
				$data['boq_list'] = $result;
			}

			$q = $this->db->query("SELECT * FROM i_ext_et_boq_mail WHERE iextetboqm_owner = '$oid' AND iextetboqm_boq_id = '$boq_id' AND iextetboqm_res_date IS NOT NULL ");
			$r = $q->result();
			$data['boq_count'] = $r;
			$data['quote_info'] = [];
			$data['quote_req'] = [];
			$data['quote_table'] = [];
			$data['quote_note'] = [];
			for($i = 0 ; $i < count($r); $i++ ) {
				$file_name = $r[$i]->iextetboqm_file;
	            $fl = $path.$file_name;
	            $file_arr = json_decode(file_get_contents($fl));
	            array_push($data['quote_info'], $file_arr->info[0]);
	            array_push($data['quote_req'], $file_arr->req[0]);
	            array_push($data['quote_table'], $file_arr->table[0]);
	            array_push($data['quote_note'], array('note' => $file_arr->note[0] , 'id' => $i));
			}
			$q1 = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$oid' AND icd_mid = '$mid' ");
			$r1 = $q1->result();
			$data['doc_list'] = $r1;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = "BOQ Quote Compare";
			}else{
				$ert['title'] = $alias ." Quote Compare";
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('boq/boq_res_view', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function upload_doc_download($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$file = $this->input->post('doc_name');

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$oid' AND icd_id = '$id' ");
			$res = $query->result();
			if (count($res) > 0 ) {
				$file = $res[0]->icd_timestamp;
				$path = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			    if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
		    	$this->load->helper('download');
				force_download($path.$file, NULL);	
			}
		}else{
			redirect(base_url().'Account/login');
		}    
	}
}