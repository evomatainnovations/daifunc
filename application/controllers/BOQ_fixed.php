<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BOQ_fixed extends CI_Controller {

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
					if ($module[$i]->mname == 'BOQ_fixed') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_fixed WHERE iextetboqf_gid = '$gid' AND iextetboqf_created_by = '$uid' ");
			$result = $query->result();
			$data['boq_list'] = $result;

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
			$this->load->view('boq_fixed/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_boq_temp($code) {
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
					if ($module[$i]->mname == 'BOQ_fixed') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_template WHERE iextetboqt_gid = '$gid' AND iextetboqt_created_by = '$uid' ");
			$result = $query->result();
			$data['boq_temp_list'] = $result;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = 'Add Template';
			}else{
				$ert['title'] = 'Add Template';
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('boq_fixed/add_boq_template', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function create_boq($code,$id=null) {
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
					if ($module[$i]->mname == 'BOQ_fixed') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_template WHERE iextetboqt_gid = '$gid' AND iextetboqt_created_by = '$uid' ");
			$result = $query->result();
			$data['boq_temp_list'] = $result;

			if ($id != null) {
				$query = $this->db->query("SELECT * FROM i_ext_et_boq_fixed WHERE iextetboqf_gid = '$gid' AND iextetboqf_created_by = '$uid' AND iextetboqf_id = '$id' ");
				$result = $query->result();
				$data['edit_boq'] = $result;

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
				$result = $query->result();
				$data['c_list'] = $result;
			}

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Create BOQ';

			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('boq_fixed/create_boq', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_template_save($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'BOQ_fixed') {
					$mid = $module[$i]->mid;
				}
			}
			$boq_arr = $this->input->post('boq_arr');
			$title = $this->input->post('title');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($boq_arr);
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
			  'iextetboqt_title' => $title,
			  'iextetboqt_file' => $dt_str.'.json',
			  'iextetboqt_owner' => $oid,
			  'iextetboqt_created' => $dt,
			  'iextetboqt_created_by' => $uid,
			  'iextetboqt_gid' => $gid
			);
			$this->db->insert('i_ext_et_boq_template',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_template_update($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$boq_arr = $this->input->post('boq_arr');
			$title = $this->input->post('title');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($boq_arr);
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
			  'iextetboqt_title' => $title,
			  'iextetboqt_file' => $dt_str.'.json',
			  'iextetboqt_modified' => $dt,
			  'iextetboqt_modified_by' => $uid,
			);
			$this->db->where(array('iextetboqt_owner' => $oid , 'iextetboqt_id' => $id));
			$this->db->update('i_ext_et_boq_template',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_delete($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->where(array('iextetboqt_owner' => $oid , 'iextetboqt_id' => $id));
			$this->db->delete('i_ext_et_boq_template');

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_boq_template($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			if ($id != 'null') {
				$query = $this->db->query("SELECT * FROM i_ext_et_boq_template WHERE iextetboqt_gid = '$gid' AND iextetboqt_created_by = '$uid' AND iextetboqt_id = '$id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$file_name = $result[0]->iextetboqt_file;
					$title = $result[0]->iextetboqt_title;
				}
				$data['title'] = $title;
				$path = $this->config->item('document_rt')."assets/data/boq/";
	            $fl = $path.$file_name;
	            $data['boq'] = json_decode(file_get_contents($fl));	
			}else{
				$data = [];
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_boq_details($code,$id=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_fixed WHERE iextetboqf_gid = '$gid' AND iextetboqf_created_by = '$uid' AND iextetboqf_id = '$id' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboqf_file;
				$title = $result[0]->iextetboqf_title;
			}
			$data['title'] = $title;
			$path = $this->config->item('document_rt')."assets/data/boq/";
            $fl = $path.$file_name;
            $data['boq'] = json_decode(file_get_contents($fl));	

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_save($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$boq_arr = $this->input->post('boq_arr');
			$title = $this->input->post('title');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($boq_arr);
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
			  'iextetboqf_title' => $title,
			  'iextetboqf_file' => $dt_str.'.json',
			  'iextetboqf_owner' => $oid,
			  'iextetboqf_created' => $dt,
			  'iextetboqf_created_by' => $uid,
			  'iextetboqf_gid' => $gid
			);
			$this->db->insert('i_ext_et_boq_fixed',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_update($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$boq_arr = $this->input->post('boq_arr');
			$title = $this->input->post('title');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($boq_arr);
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
			  'iextetboqf_title' => $title,
			  'iextetboqf_file' => $dt_str.'.json',
			  'iextetboqf_modified' => $dt,
			  'iextetboqf_modified_by' => $uid,
			);
			$this->db->where(array('iextetboqf_owner' => $oid , 'iextetboqf_id' => $id));
			$this->db->update('i_ext_et_boq_fixed',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function boq_download($code,$id){
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
					if ($module[$i]->mname == 'BOQ_fixed') {
						$mid = $module[$i]->mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}


			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
		    // redirect(base_url().'BOQ_fixed/boq_print/'.$code.'/'.$mid.'/'.$id);
	 		$page = file_get_contents(base_url().'BOQ_fixed/boq_print/'.$code.'/'.$mid.'/'.$id, false, $context);
		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/boq/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $id.'.html';
		    $invoicefile = $id.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

		    redirect(base_url().'assets/data/'.$oid.'/boq/'.$invoicefile);

		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function boq_print($code,$mod_id, $id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_fixed WHERE iextetboqf_gid = '$gid' AND iextetboqf_created_by = '$uid' AND iextetboqf_id = '$id' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboqf_file;
				$title = $result[0]->iextetboqf_title;
			}
			$data['title'] = $title;
			$path = $this->config->item('document_rt')."assets/data/boq/";
            $fl = $path.$file_name;
            $data['boq'] = json_decode(file_get_contents($fl));

			$this->load->view('boq_fixed/boq_print', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function cust_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cname = $this->input->post('c');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = 0;
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;	
			}

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = 0;
			if (count($result) > 0 ) {
				$p_id = $result[0]->ip_id;	
			}

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$p_id'");
			$result = $query->result();
			$data['details'] = [];
			for ($i=0; $i < count($result) ; $i++) {
				if ($result[$i]->icbd_value != '') {
					array_push($data['details'] , $result[$i]->icbd_value);
				}
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function boq_send_mail($code,$id) {
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
					if ($module[$i]->mname == 'BOQ_fixed') {
						$mid = $module[$i]->mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}


			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
		    // redirect(base_url().'BOQ_fixed/boq_print/'.$code.'/'.$mid.'/'.$id);
	 		$page = file_get_contents(base_url().'BOQ_fixed/boq_print/'.$code.'/'.$mid.'/'.$id, false, $context);
		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/boq/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $id.'.html';
		    $invoicefile = $id.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

		    // redirect(base_url().'assets/data/'.$oid.'/boq/'.$invoicefile);

			$email = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_fixed WHERE iextetboqf_gid = '$gid' AND iextetboqf_created_by = '$uid' AND iextetboqf_id = '$id' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboqf_file;
				$title = $result[0]->iextetboqf_title;
			}

			for ($i=0; $i < count($email) ; $i++) {
				if ($email[$i]['status'] == 'true') {
					$mail_id = $email[$i]['value'];
					$body = '';
					$body .= $content;
					$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
					$body .= '<a href="'.base_url().'assets/data/'.$oid.'/boq/'.urldecode($invoicefile).'"><button class="btn btn-lg btn-danger">'.$title.'</button></a>';
					$temp = $this->Mail->send_mail($subject,$mail_id,null,$body,$code);
				}
			}

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}
}