<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		//$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->helper('directory');
		$this->load->dbforge();
	}

################## store modules ##################

	public function index($flg=null){
		$sess_data = $this->session->userdata();

		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['uid'] = $uid;
			
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;

			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}

			if($flg != null){
				$data['modal'] = $flg;
				// print_r($data['modal']);
			}

			$query = $this->db->query("SELECT * FROM i_domain");
			$data['domain'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_modules");
			$data['module'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_m_files group by imf_mid");
			$data['g_image'] = $query->result();			

			$query = $this->db->query("SELECT * FROM i_m_files");
			$data['files'] = $query->result();

			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Store";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('store/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function module_list($did){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['uid'] = $uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Store";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('store/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}	

	public function send_email_module(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['uid'] = $uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$dt = date('Y-m-d H:i:s');
			$mid = $this->input->post('mid');
			
			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			for ($i=0; $i <count($mid) ; $i++) { 
				$data = array(
					'is_uid' => $oid,
					'is_mid' => $mid[$i],
					'is_status' => 'null',
					'is_created' => $dt,
					'is_created_by' => $oid
				);
				$this->db->insert('i_store',$data);
			}

			$mod_id = implode(',', $mid);
			$query2 = $this->db->query("SELECT * FROM i_modules WHERE im_id IN ($mod_id)");
			$result2 = $query2->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			$subject = 'Request for module access !';

			$body .= '<!DOCTYPE html><html><head></head><body>Dear Team,<br><br>Please provide access for ';
					for ($i=0; $i <count($result2) ; $i++) { 
						$body .= $result2[$i]->im_name.', ';
					}
			$body .= ' and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';

			if (count($result3)>0) {
			
				try {
					$config = array();
			        $config['useragent'] = "CodeIgniter";
			        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
			        $config['protocol'] = "smtp";
			        $config['smtp_host'] = $result3[0]->iumail_domain;
			        $config['smtp_user'] = $result3[0]->iumail_mail;
			        $config['smtp_pass'] = $result3[0]->iumail_password;
			        $config['smtp_port'] = $result3[0]->iumail_port;
			        $config['mailtype'] = 'html';
			        $config['charset'] = 'utf-8';
			        $config['newline'] = "\r\n";
			        $config['wordwrap'] = TRUE;

					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->from($result3[0]->iumail_mail);
					$this->email->to('krishnakant@evomata.com');
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->send();
		            echo "true";
				// 			echo $this->email->print_debugger();
				} catch (Exception $e) {
					echo "Exception: ".$e;
				}
			}	
		}else{
			redirect(base_url().'account/login');
		}
	}

}
