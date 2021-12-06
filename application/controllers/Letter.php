<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Letter extends CI_Controller {

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
					if ($module[$i]->mname == 'Letter') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_letter as a left join i_customers as b on a.iextel_cid = b.ic_id WHERE iextel_owner = '$oid' AND iextel_gid = '$gid' ");
			$result = $query->result();
			$data['letter'] = $result;
			
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id']=$mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			$this->load->view('navbar', $ert);
			$this->load->view('letter/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function letter_add($code,$lid = 0) {
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
					if ($module[$i]->mname == 'Letter') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			$invoice_txn_id = '';
			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$mid' ORDER BY iumdi_id;");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($i=0; $i <count($result) ; $i++) {
					if ($result[$i]->iumdi_variable == 'false') {
						$invoice_txn_id .= $result[$i]->iumdi_doc_syntax;
					}else{
						if ($result[$i]->iumdi_doc_syntax == 'acc_yr') {
							$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
							$result1 = $query->result();
							if (count($result1) > 0) {
								$val = $result1[0]->iua_year_code;
							}else{
								$val = '';
							}
						}else{
							$query = $this->db->query("SELECT * FROM i_ext_et_letter WHERE iextel_owner = '$oid'");
							$result2 = $query->result();
							$val = count($result2)+1;
						}
						$invoice_txn_id .= $val;
					}
				}	
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_letter WHERE iextel_owner = '$oid'");
				$result2 = $query->result();
				$val = count($result2)+1;
				$invoice_txn_id = $val;
			}
			$data['invoice_doc_id'] = $invoice_txn_id;

			if ($lid != 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_letter as a LEFT JOIN i_ext_et_letter_details as b on a.iextel_id = b.iexteld_l_id WHERE iextel_owner = '$oid' AND iextel_gid = '$gid' AND iextel_id = '$lid' ");
				$result = $query->result();
				$data['edit_letter'] = $result;
				$file_name = '';
				$cid = 0;
				if (count($result) > 0) {
					$data['lid'] = $result[0]->iextel_id;
					$file_name = $result[0]->iextel_file;
					$cid = $result[0]->iextel_cid;
				}
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_id = '$cid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['cname'] = $result[0]->ic_name;
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_letter_details WHERE iexteld_l_id = '$lid' ");
				$result = $query->result();
				$data['p_details'] = $result;

				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/letter/';
				$data['letter_content'] = file_get_contents($path.$file_name);
				if ($alias == '') {
					$ert['title'] = $mname.' Edit';
				}else{
					$ert['title'] = $alias.' Edit';
				}
			}else{
				if ($alias == '') {
					$ert['title'] = $mname.' Add';
				}else{
					$ert['title'] = $alias.' Add';
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;
			
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id']=$mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['search'] = "true";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			$this->load->view('navbar', $ert);
			$this->load->view('letter/letter_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function letter_save($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cname = $this->input->post('cname');
			$txn_id = $this->input->post('txn_id');
			$date = $this->input->post('date');
			$content = $this->input->post('content');
			$subject = $this->input->post('subject');
			$prop_details = $this->input->post('details');
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid' ");
			$result = $query->result();
			$cid = 0;
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;	
			}else{
				$data = array(
					'ic_name' => $cust_name,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_created_by' => $oid,
					'ic_section' => 'customer'
				);
				$this->db->insert('i_customers',$data);
				$cid = $this->db->insert_id();
			}
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);
			$path = $this->config->item('document_rt')."assets/data/".$oid."/letter/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$timestamp = $dt_str.'.txt';

			$data = array(
				'iextel_cid' => $cid,
				'iextel_txn_id' => $txn_id,
				'iextel_date' => $date,
				'iextel_file' => $timestamp,
				'iextel_created' => $dt,
				'iextel_created_by' => $uid,
				'iextel_owner' => $oid,
				'iextel_subject' => $subject,
				'iextel_gid' => $gid
			);
			$this->db->insert('i_ext_et_letter',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($prop_details) ; $i++) { 
				$data = array(
					'iexteld_l_id' => $inid,
					'iexteld_d_val' => $prop_details[$i]['value']
				);
				$this->db->insert('i_ext_et_letter_details',$data);
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function letter_update($code,$lid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cname = $this->input->post('cname');
			$txn_id = $this->input->post('txn_id');
			$date = $this->input->post('date');
			$content = $this->input->post('content');
			$prop_details = $this->input->post('details');
			$subject = $this->input->post('subject');
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid' ");
			$result = $query->result();
			$cid = 0;
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;	
			}
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			$query = $this->db->query("SELECT * FROM i_ext_et_letter WHERE iextel_owner = '$oid' AND iextel_id = '$lid' AND iextel_gid = '$gid' ");
			$result2 = $query->result();
			if (count($result2) > 0 ) {
				$file = $result2[0]->iextel_file;
				$path = $this->config->item('document_rt')."assets/data/".$oid."/letter/".$file;
				unlink($path);
			}

			$path = $this->config->item('document_rt')."assets/data/".$oid."/letter/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$timestamp = $dt_str.'.txt';

			$data = array(
				'iextel_cid' => $cid,
				'iextel_txn_id' => $txn_id,
				'iextel_date' => $date,
				'iextel_file' => $timestamp,
				'iextel_subject' => $subject,
				'iextel_modified' => $dt,
				'iextel_modified_by' => $uid
			);
			$this->db->where(array('iextel_owner' => $oid , 'iextel_id' => $lid));
			$this->db->update('i_ext_et_letter',$data);

			$this->db->WHERE(array('iexteld_l_id' => $lid));
			$this->db->delete('i_ext_et_letter_details');

			for ($i=0; $i < count($prop_details) ; $i++) { 
				if ($prop_details[$i]['status'] == 'true') {
					$data = array(
						'iexteld_l_id' => $lid,
						'iexteld_d_val' => $prop_details[$i]['value']
					);
					$this->db->insert('i_ext_et_letter_details',$data);	
				}
			}

			echo $lid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_email_body($code,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$oid' AND iuetemp_id = '$pid'");
			$result = $query->result();
			if (count($result) > 0 ) {
				$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/email_template/";
				$file_name = $upload_dir.$result[0]->iuetemp_file;
				$data['temp_content'] = file_get_contents($file_name);
			}else{
				$data['temp_content'] = '';
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function cust_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$cust = $this->input->post('c');

			$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_name = '$cust' AND ic_owner = '$oid')");
			$result = $query->result();
			$data['details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function add_to_email_temp($code,$lid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$content = $this->input->post('content');
			$title = $this->input->post('title');

			$path = $this->config->item('document_rt')."assets/data/".$oid."/email_template/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);
			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$timestamp = $dt_str.'.txt';

			$data = array(
				'iuetemp_title' => $title,
				'iuetemp_owner' => $oid,
				'iuetemp_file' => $timestamp
			);
			$this->db->insert('i_user_email_template',$data);

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function letter_template_print($code,$lid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
	 		$page = file_get_contents(base_url().'Letter/letter_template_view/'.$code.'/'.$lid, false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/letter/template/';

		    if(!file_exists($path)) {
					mkdir($path, 0777, true);
			}
		   	$invoiceid = 'test';

		    $htmlfile = $invoiceid.'.html';
		    $invoicefile = $invoiceid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
		    
		    redirect(base_url().'assets/data/'.$oid.'/letter/template/'.$invoicefile);
		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function letter_template_view($code,$lid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_letter WHERE iextel_owner = '$oid' AND iextel_gid = '$gid' AND iextel_id = '$lid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->iextel_cid;
				$file_name = $result[0]->iextel_file;
				$data['date'] = $result[0]->iextel_date;
				$data['txn_id'] = $result[0]->iextel_txn_id;
				$data['subject'] = $result[0]->iextel_subject;
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$cid' AND ic_owner = '$oid' ");
				$result = $query->result();
				$data['cname'] = '';
				if (count($result) > 0 ) {
					$data['c_name'] = $result[0]->ic_name;
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_letter_details WHERE iexteld_l_id = '$lid' ");
				$result = $query->result();
				$data['property'] = $result;

				$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid = '$uid'");
				$result = $query->result();
				if (count($result) >0 ) {
					if ($result[0]->iud_logo != '') {
						$data['logo'] = base_url().'assets/uploads/'.$oid.'/'.$result[0]->iud_logo;
					}
				}

				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/letter/';
				$data['content'] = file_get_contents($path.$file_name);	
			}

			$this->load->view('letter/letter_view', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}
}