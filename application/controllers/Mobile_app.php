<?php
use PHPMailer\PHPMailer\PHPMailer AS phpmail;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH. 'PHPMailer/src/Exception.php');
require_once(APPPATH. 'PHPMailer/src/PHPMailer.php');
require_once(APPPATH. 'PHPMailer/src/SMTP.php');
class Mobile_app extends CI_Controller {
	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('directory');
		$this->load->helper('cookie');
		$this->load->model('Mobile_Code','log_owner');
		$this->load->model('Mail','Mail');
	}
################ Mobile App Registartion And password reset And login ####################
	public function index($id){
		$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_id = '$id' ");
		$result = $query->result();
		if (count($result) > 0 ) {
			$data['oid'] = $result[0]->iextetm_owner_id;
			$data['mob_id'] = $result[0]->iextetm_id;
			$data['c_details'] = $result;
			$x = $result[0]->iextetm_login_function;
			$this->load->view($x, $data);
		}else{
			echo "Not Found !";
		}
	}

	public function check_mobile_sess($code){
		$sess_data = $this->log_owner->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			echo "true";
		}else{
			echo "false";
		}
	}

	public function send_reg_user_otp($owner){
		$to = $this->input->post('email');
		$phone = $this->input->post('phone');
		$flg = '';
		$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_email = '$to'");
		$result1 = $query->result();
		if (count($result1)>0) {
			$flag='nn';
		}
		$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_phone_no = '$phone'");
		$result2 = $query->result();
		if (count($result2)>0) {
			$flag='nnn';
		}
		if ($flg != '') {
			echo $flg;
		}else{
			$sub = "Plz find OTP.";
			$chars = "0123456789";
			$res = "";
			for ($i = 0; $i < 6; $i++) {
			    $res .= $chars[mt_rand(0, strlen($chars)-1)];
			}

			$body = "OTP No. is ".$res;
			$this->Mail->mobile_app_send_mail($sub,$to,null,$body);
			echo $res;
		}
	}

	public function verify(){
		$uname = $this->input->post('uname');
		$upass = $this->input->post('upass');
		$dt = date('Y-m-d');

	    $query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_email = '$uname' ");
		$result = $query->result();
		if (count($result) > 0) {
			if ($result[0]->iextetmu_status == 'block'){
				echo "block";
			}else if ($result[0]->iextetmu_password==$upass) {
				$id = $result[0]->iextetmu_id;

				$key='';
				$keys = array_merge(range(0, 9), range('a', 'z'));
			    for ($i = 0; $i < 256; $i++) {
			        $key .= $keys[array_rand($keys)];
			    }
			    $dt=date_create();
				$timestamp = date_timestamp_get($dt);
				$code = $key.$timestamp;

				$data = array(
					'iextetmu_code' => $code
				);
				$this->db->WHERE(array('iextetmu_email' => $uname));
				$this->db->update('i_ext_et_mobile_users',$data);

				echo "t".$code;
			} else {
				echo "unknown";
			}			
		} else {
			echo "false";
		}
	}

	public function save_reg_user($owner,$mob_id){
		$dt1 = date('Y-m-d H:i:s');

		$data1 = array(
			'iextetmu_name' => $this->input->post('name'),
			'iextetmu_company' => $this->input->post('company'),
			'iextetmu_email' => $this->input->post('email'),
			'iextetmu_phone_no' => $this->input->post('phone'),
			'iextetmu_address' => $this->input->post('address'),
			'iextetmu_gst_no' => $this->input->post('gst'),
			'iextetmu_code' => $code,
			'iextetmu_owner' => $owner,
			'iextetmu_mobile_id' => $mob_id,
			'iextetmu_password' => $this->input->post('pwd'),
			'iextetmu_created' => $dt1,
			'iextetmu_created_by' => $owner
		);
		$this->db->insert('i_ext_et_mobile_users', $data1);
		$email = $this->input->post('email');

		$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_customers as b on a.icbd_customer_id = b.ic_id WHERE icbd_value = '$email' AND ic_owner = '$owner' ");
		$result = $query->result();
		if (count($result) > 0) {
		}else{
			$data1 = array(
				'ic_name' => $this->input->post('name'),
				'ic_owner' => $owner,
				'ic_created' => $dt1,
				'ic_section' => 'customer',
				'ic_created_by' => $owner );
			$this->db->insert('i_customers', $data1);
			$cid = $this->db->insert_id();

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$owner' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$p_id = $result[0]->ip_id;	
			}else{
				$data = array(
					'ip_property' => 'email',
					'ip_owner' => $owner,
					'ip_section' => 'customer'
				);
				$this->db->insert('i_property',$data);
				$p_id = $this->db->insert_id();
			}

			$data = array(
				'icbd_customer_id' => $cid,
				'icbd_property' => $p_id,
				'icbd_value' => $email
			);
			$this->db->insert('i_c_basic_details',$data);
		}

		echo 'true';
	}

	public function update_reg_user($owner,$mob_id){
		$dt1 = date('Y-m-d H:i:s');

		$data1 = array(
			'iextetmu_password' => $this->input->post('pwd')
		);
		$this->db->where(array('iextetmu_email' => $this->input->post('email'),'iextetmu_owner' => $owner));
		$this->db->update('i_ext_et_mobile_users', $data1);

		echo 'true';
	}

	public function logout($code){
		$data = array(
			'iextetmu_code' => null
		);
		$this->db->WHERE(array('iextetmu_code' => $code));
		$this->db->update('i_ext_et_mobile_users',$data);

		echo "true";
	}

	public function redirect_module($code){
		$sess_data = $this->log_owner->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['oid'];
			$data['oid'] = $oid;
			$mod_name = $this->input->post('mod_name');

			$query = $this->db->query("SELECT * FROM i_modules as a left join i_function as b on a.im_function = b.ifun_id left join i_domain as c on a.im_domain = c.idom_id WHERE im_name = '$mod_name' ");
			$result = $query->result();
			if(count($result) > 0) {
				$data['mid'] = $result[0]->im_id;
				$data['dom_name'] = $result[0]->idom_name;
				$data['fun_name'] = $result[0]->ifun_name;
			}
			print_r(json_encode($data));
		}else{
			redirect(base_url().'mobile_app/index/1');
		}
	}
################ Cosmos App #################
	############ Cosmos Setting #############
		public function cosmos_home($code){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$gid = $sess_data['gid'];
				$data['oid'] = $oid;
				$data['code'] = $code;

				$email = $sess_data['user_details'][0]->iextetmu_email;
				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				$p_id = 0;
				if (count($result) > 0 ) {
					$p_id = $result[0]->ip_id;	
				}
				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$email' AND icbd_property = '$p_id' ");
				$result = $query->result();
				$cid = 0;
				if (count($result) > 0 ) {
					$cid = $result[0]->ic_id;
				}

				$query = $this->db->query("SELECT * FROM i_ext_support_activity as a LEFT JOIN i_ext_support as b on a.iesa_sid = b.ies_id  WHERE ies_user_type = 'sub_user' AND ies_owner = '$oid' AND ies_user_id = '$uid' AND ies_gid = '$gid' ");
				$result = $query->result();
				$data['support'] = $result;

				$aid = 0;
				$aid_arr = [];
				if (count($result) > 0 ) {
					for ($i=0; $i < count($result) ; $i++) { 
						array_push($aid_arr, $result[$i]->iesa_aid);
					}
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_amc as a LEFT JOIN i_ext_et_amc_task as b on a.iextamc_id = b.iextamct_amc_id  WHERE iextamct_owner = '$oid' AND iextamc_customer_id = '$cid' AND iextamc_gid = '$gid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					for ($i=0; $i < count($result) ; $i++) { 
						array_push($aid_arr, $result[$i]->iextamct_aid);
					}
				}
				if (count($aid_arr) > 0) {
					$aid = implode(',', $aid_arr);
				}
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_id IN ($aid) AND iua_g_id = '$gid' ");
				$result = $query->result();
				$data['act_list'] = $result;
				
				$query = $this->db->query("SELECT * FROM i_u_a_person as a LEFT JOIN i_customers as b on a.iuap_p_id = b.ic_id WHERE iuap_owner = '$oid' AND ic_owner = '$oid' AND iuap_a_id IN ($aid)");
				$result = $query->result();
				$data['act_person'] = $result;

				$data['act_log'] = [];
				for ($i=0; $i < count($aid_arr) ; $i++) {
					$aid = $aid_arr[$i];
					$query = $this->db->query("SELECT * FROM i_u_a_log WHERE iual_owner = '$oid' AND iual_a_id = $aid AND iual_feedback_type = 'true' AND iual_comment IS NULL ORDER BY iual_id DESC");
					$result = $query->result();
					if (count($result) > 0 ) {
						array_push($data['act_log'] , $result[0]);
					}
				}
				$ert['code'] = $code;
				$ert['color'] = $sess_data['color'];
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Home";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_home', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_setting($code){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$data['oid'] = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$data['code'] = $code;
				$data['gid'] = $gid;

				$data['u_data'] = $sess_data['user_details'];

				$ert['code'] = $code;
				$ert['color'] = $sess_data['color'];
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Setting";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_setting', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function setting_update_user($code){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];

				$data1 = array(
					'iextetmu_name' => $this->input->post('name'),
					'iextetmu_company' => $this->input->post('company'),
					'iextetmu_email' => $this->input->post('email'),
					'iextetmu_phone_no' => $this->input->post('phone'),
					'iextetmu_address' => $this->input->post('address'),
					'iextetmu_gst_no' => $this->input->post('gst'),
					'iextetmu_code' => $code
				);
				$this->db->where(array('iextetmu_code' => $code));
				$this->db->update('i_ext_et_mobile_users', $data1);
				
				echo "true";
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function get_feedback_detail($code,$id){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];

				$query = $this->db->query("SELECT * FROM i_u_a_log WHERE iual_owner = '$oid' AND iual_id = $id AND iual_feedback_type = 'true' ORDER BY iual_id DESC");
				$result = $query->result();
				$data['action_taken'] = $result[0]->iual_action_taken;
				$aid = 0;
				if (count($result) > 0) {
					$aid = $result[0]->iual_a_id;
				}
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_id = $aid ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['act_title'] = $result[0]->iua_title;
				}
				
				$query = $this->db->query("SELECT * FROM i_u_a_person as a LEFT JOIN i_customers as b on a.iuap_p_id = b.ic_id WHERE iuap_a_id = $aid ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['act_person'] = $result[0]->ic_name;	
				}
				
				print_r(json_encode($data));
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function get_feedback_update($code,$id){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];

				$remark = $this->input->post('remark');
				$rat = $this->input->post('rat');

				$data2 = array(
					'iual_comment' => $remark,
					'iual_star_rating' => $rat
				);
				$this->db->WHERE('iual_id',$id);
				$this->db->update('i_u_a_log',$data2);

				echo "true";
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}
	############ Cosmos Support #############

		public function cosmos_support_home($mid = null,$code) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$gid = $sess_data['gid'];
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_customers as b on a.icbd_customer_id = b.ic_id WHERE icbd_value = '$email' ");
				$result = $query->result();
				$cid = $result[0]->ic_id;

				$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_user_type = 'sub_user' AND ies_owner = '$oid' AND ies_gid = '$gid' ");
				$result = $query->result();
				$data['support'] = $result;
				$data['tkt_id'] = count($result) + 1 ;

				$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_owner = '$oid' AND ies_gid = '$gid' GROUP BY ies_category ");
				$result = $query->result();
				$data['s_status'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id = '$cid' AND iextamc_owner = '$oid' AND iextamc_gid = '$gid' ORDER BY iextamc_id DESC ");
				$result = $query->result();
				$data['amc'] = $result;
				// $inid = 0;
				// if (count($result) > 0 ) {
				// 	$inid = $result[0]->iextamc_id;
				// 	if (strtotime($result[0]->iextamc_period_from) > strtotime(date('Y-m-d')) && strtotime($result[0]->iextamc_period_to) < strtotime(date('Y-m-d')) ) {
				// 		$status = 'open';
				// 	}else{
				// 		$status = 'expired';
				// 	}
				// 	$data1 = array(
				// 		'iextamc_status' => $status
				// 	);
				// 	$this->db->where('iextamc_id', $inid);
				// 	$this->db->update('i_ext_et_amc', $data1);
				// }

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
				$data['cust_data'] = $query->result();

		        $data['client_view'] = 'false';

				$ert['code'] = $code;
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Support";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;

				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_support_home', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_support_save($code,$tkt_id) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$data['oid'] = $oid;

				$dt = date('Y-m-d H:i:s');
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$p_id = $result[0]->ip_id;
				}else{
					$data = array(
						'ip_property' => 'email',
						'ip_owner' => $oid,
						'ip_section' => 'customer'
					);
					$this->db->insert('i_property',$data);
					$p_id = $this->db->insert_id();
				}

				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$email' AND icbd_property = '$p_id' ");
				$result = $query->result();
				$cid = 0;
				if (count($result) > 0 ) {
					$cid = $result[0]->ic_id;
				}
				$data = array(
					'ies_ticket_id' => $tkt_id,
					'ies_cid' => $cid,
					'ies_category' => $this->input->post('sp_cat'),
					'ies_subject' => $this->input->post('sp_sub'),
					'ies_desc' => $this->input->post('sp_desc'),
					'ies_date' => $this->input->post('sp_date'),
					'ies_priority' => $this->input->post('sp_status'),
					'ies_owner' => $oid,
					'ies_created' => $dt,
					'ies_created_by' => $oid,
					'ies_gid' => $gid,
					'ies_user_type' => 'sub_user',
					'ies_user_id' => $uid
				);
				$this->db->insert('i_ext_support',$data);

				$subject = 'Your complaint number '.$tkt_id;
				$body = 'Your complaint number '.$tkt_id;
				$this->Mail->mobile_app_send_mail($subject,$email,null,$body);

				echo "true";
			} else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_support_details($code,$sid){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$data['oid'] = $sess_data['oid'];
				$data['code'] = $code;
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];;

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
				$result = $query->result();
				$data['customer'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_support as a LEFT JOIN i_customers as b on a.ies_cid = b.ic_id WHERE ies_owner = '$oid' AND ies_id = '$sid' AND ies_gid = '$gid' ");
				$result = $query->result();
				$data['support'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_support_activity as a LEFT JOIN i_user_activity as b on a.iesa_aid = b.iua_id LEFT JOIN i_u_a_log as c on a.iesa_aid = c.iual_a_id LEFT JOIN i_u_a_person  as d on b.iua_id = d.iuap_a_id LEFT JOIN i_customers as e on d.iuap_p_id = e.ic_id WHERE iesa_sid = '$sid' AND iesa_owner = '$oid' AND iua_g_id = '$gid' ORDER BY iual_id DESC ");
				$result = $query->result();
				$data['s_details'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_id = '$sid' AND ies_owner = '$oid' AND ies_gid = '$gid' ");
				$result = $query->result();
				$s_cid = 0;
				if (count($result) > 0 ) {
					$s_cid = $result[0]->ies_cid;	
				}

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id = '$s_cid' ");
				$result = $query->result();
				$data['c_name'] = $result[0]->ic_name;
				$data['edit_person'] = $result;

				$data['sid'] = $sid;
				$ert['code'] = $code;
				$ert['color'] = $sess_data['color'];
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Support Details";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;

				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_support_details', $data);
			} else{
				redirect(base_url().'mobile_app/index/1');
			}
		}
	############ Cosmos AMC #################
		public function cosmos_subscription_home($mid = null,$code) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$gid = $sess_data['gid'];

				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_customers as b on a.icbd_customer_id = b.ic_id WHERE icbd_value = '$email' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$cid = $result[0]->ic_id;	
				}else{
					$cid = 0;
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id = '$cid' AND iextamc_owner = '$oid' AND iextamc_gid = '$gid' ORDER BY iextamc_id DESC ");
				$result = $query->result();
				$data['amc'] = $result;

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
				$data['cust_data'] = $query->result();

		        $data['client_view'] = 'false';

				$ert['code'] = $code;
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Subscription";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;

				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_subscription_home', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_subscription_details($code,$sub_id) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$gid = $sess_data['gid'];
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$data['sub_id'] = $sub_id;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextamc_id='$sub_id' AND a.iextamc_owner='$oid' AND a.iextamc_gid = '$gid' ");
				$result = $query->result();
				$data['basic'] = $result;

				if(count($result) > 0) {
					$data['s_name'] = $result[0]->ic_name;
					$data['s_address'] =$result[0]->icbd_value;
					$data['s_txn_id'] = $result[0]->iextamc_txn_id;
					$data['s_txn_date'] = $result[0]->iextamc_txn_date;
					$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
					$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
					$data['s_txn_note'] = $result[0]->iextamc_note;
					$data['s_txn_amount'] = $result[0]->iextamc_amount;
					$data['status'] = $result[0]->iextamc_status;
				} else {
					$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextamc_id='$sub_id' AND a.iextamc_owner = '$oid' AND a.iextamc_gid = '$gid' ");
					$result = $query->result();
					$data['basic'] = $result;
					if (count($result) > 0 ) {
						$data['s_name'] = $result[0]->ic_name;
						$data['s_address'] = '';
						$data['s_txn_id'] = $result[0]->iextamc_txn_id;
						$data['status'] = $result[0]->iextamc_status;
						$data['s_txn_date'] = $result[0]->iextamc_txn_date;
						$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
						$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
						$data['s_txn_note'] = $result[0]->iextamc_note;
						$data['s_txn_amount'] = $result[0]->iextamc_amount;	
					}
				}

	            $tx = $data['basic'][0]->iextamc_tax;
	            $query1 = $this->db->query("SELECT * FROM i_tax_group_collection AS a LEFT JOIN i_taxes AS b ON a.itxgc_tx_id=b.itx_id  WHERE a.itxgc_tg_id='$tx' AND b.itx_owner='$oid'");
	            $result1 = $query1->result();
				$data['taxes'] = $result1;

				$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$oid'");
				$result = $query->result();
				$data['u_gst'] = $result[0]->iud_gst;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iextamc_id='$sub_id' AND a.iextamc_gid = '$gid' ");
				$result = $query->result();
				
				if(count($result) > 0) {
					$data['s_gst'] = $result[0]->icbd_value;
				} else {
					$data['s_gst'] = '';
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_amc_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iextamcpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON a.iextamcpd_tax = c.ittxg_id LEFT JOIN i_product AS d ON a.iextamcpd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id LEFT JOIN i_ext_et_amc as g on g.iextamc_id = a.iextamcpd_d_id WHERE a.iextamcpd_d_id='$sub_id' AND a.iextamcpd_owner='$oid'");
				$result = $query->result();
				$data['details'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_amc_terms as b on a.iextdt_id=b.iextamctm_term_id WHERE iextdt_document='AMC' AND iextdt_owner='$oid' AND iextamctm_inid= '$sub_id' AND iextamctm_status = 'true' ");
				$result = $query->result();
				$data['terms'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc_property WHERE iextamcpt_inid ='$sub_id' AND iextamcpt_status = 'true' ");
				$result = $query->result();
				$data['property'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc_task as a LEFT JOIN i_user_activity as b on a.iextamct_aid = b.iua_id WHERE iextamct_amc_id = '$sub_id' AND iextamct_owner = '$oid' ");
				$result = $query->result();
				$data['amc_act'] = $result;

				$ert['code'] = $code;
				$ert['gid'] = $gid;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Subscription Details";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;

				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_subscription_details', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_subscription_satatus_update($code,$sub_id) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				
				$data1 = array(
					'iextamc_status' => 'cb_client'
				);
				$this->db->where('iextamc_id', $sub_id);
				$this->db->update('i_ext_et_amc', $data1);

				redirect(base_url().'mobile_app/cosmos_subscription_details/'.$code.'/'.$sub_id);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}
	############ Cosmos Product #############
		public function cosmos_product_home($mid = null,$code , $p_cat = 0) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				if ($p_cat == 0) {
					$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_pic as b on a.ip_id=b.ipp_pid LEFT JOIN i_p_price as c on a.ip_id = c.ipp_sell_price WHERE ip_owner = '$oid' AND ip_publish = 'true' GROUP BY ip_id ");
					$result = $query->result();
					$cat_list = [];
					for ($i=0; $i < count($result) ; $i++) {
						array_push($cat_list, $result[$i]->ip_cat_id);
					}
					if (count($cat_list) > 0 ) {
						$cat_id = implode(',', $cat_list);
					}else{
						$cat_id = 'null';
					}

					$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_id IN ($cat_id) AND iproc_pid = '0' ");
					$result = $query->result();
					$data['cat_list'] = $result;	
				}else{
					$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_pic as b on a.ip_id=b.ipp_pid LEFT JOIN i_p_price as c on a.ip_id = c.ipp_sell_price WHERE ip_owner = '$oid' AND ip_publish = 'true' AND ip_cat_id = '$p_cat' GROUP BY ip_id ");
					$result = $query->result();
					$data['product'] = $result;
					$cat_list = [];
					for ($i=0; $i < count($result) ; $i++) {
						array_push($cat_list, $result[$i]->ip_cat_id);
					}
					if (count($cat_list) > 0 ) {
						$cat_id = implode(',', $cat_list);
					}else{
						$cat_id = 'null';
					}
					
					$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_pid IN ($cat_id)");
					$result = $query->result();
					$data['cat_list'] = $result;
				}

				$ert['code'] = $code;
				$ert['gid'] = 0;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Product";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_product_home', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_product_details($code,$pid) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_pic as b on a.ip_id=b.ipp_pid LEFT JOIN i_p_price as c on a.ip_id = c.ipp_p_id LEFT JOIN i_p_additional_info as d on a.ip_id = d.ipai_p_id WHERE ip_owner = '$oid' AND ip_id = '$pid' AND ip_publish = 'true' ");
				$result = $query->result();
				$data['product'] = $result;

				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_p_features as b on a.ip_id = b.ipf_product_id WHERE ip_owner = '$oid' AND ip_id = '$pid' AND ip_publish = 'true' ");
				$result = $query->result();
				$data['p_f'] = $result;

				$ert['code'] = $code;
				$ert['gid'] = 0;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Product";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_product_details', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_add_cart($code,$pid=0) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$mobile_id = $sess_data['user_details'][0]->iextetmu_mobile_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$date = date('Y-m-d H:i:s');
				
				if ($pid != 0 ) {
					$p_qty = $this->input->post('p_qty');

					$data = array(
						'iextetmc_pid' => $pid,
						'iextetmc_qty' => $p_qty,
						'iextetmc_mobile_id' => $mobile_id,
						'iextetmc_owner' => $oid,
						'iextetmc_created_by' => $uid,
						'iextetmc_created' => $date,
						'iextetmc_status' => 'false'
					);
					$this->db->insert('i_ext_et_mobile_cart',$data);	
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_mobile_cart WHERE iextetmc_created_by = '$uid' AND iextetmc_status = 'false' AND iextetmc_owner = '$oid' ");
				$result = $query->result();
				echo count($result);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_mobile_cart($code){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$mobile_id = $sess_data['user_details'][0]->iextetmu_mobile_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$date = date('Y-m-d H:i:s');

				$query = $this->db->query("SELECT * FROM i_ext_et_mobile_cart as a LEFT JOIN i_product as b on a.iextetmc_pid = b.ip_id LEFT JOIN i_p_price as c on b.ip_id = c.ipp_p_id LEFT JOIN i_p_taxes as d on b.ip_id = d.ipt_p_id LEFT JOIN i_tax_group as e on d.ipt_t_id = e.ittxg_id WHERE iextetmc_created_by = '$uid' AND iextetmc_status = 'false' AND iextetmc_owner = '$oid'  ");
				$result = $query->result();
				$data['cart'] = $result;

				$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
				$result = $query->result();
				$data['taxes'] = $result;

				$ert['code'] = $code;
				$ert['gid'] = 0;
				$ert['mname'] = 0;
				$ert['mid'] = 0;
				$ert['title'] = "Cart";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_cart', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function cosmos_place_order($code) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$gid = $sess_data['gid'];
				$mobile_id = $sess_data['user_details'][0]->iextetmu_mobile_id;
				$email = $sess_data['user_details'][0]->iextetmu_email;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$date = date('Y-m-d H:i:s');

				$query = $this->db->query("SELECT * FROM i_modules as a left join i_function as b on a.im_function = b.ifun_id left join i_domain as c on a.im_domain = c.idom_id WHERE im_name = 'Orders' ");
				$result = $query->result();
				$mid = 0;
				if (count($result) > 0 ) {
					$mid = $result[0]->im_id;
				}

				$cart = $this->input->post('cart');
				$tax = $this->input->post('tax');
				$total_amt = $this->input->post('total_amt');

				$invoice_txn_id = 0;
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
								$query = $this->db->query("SELECT * FROM i_ext_et_orders WHERE iextetor_owner = '$oid'");
								$result2 = $query->result();
								$val = count($result2)+1;
							}
							$invoice_txn_id .= $val;
						}
					}	
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_orders WHERE iextetor_owner = '$oid'");
					$result2 = $query->result();
					$val = count($result2)+1;
					$invoice_txn_id = $val;
				}

				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$email' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$cid = $result[0]->ic_id;
				}else{
					$data = array(
						'ic_name' => $email,
						'ic_owner' => $oid,
						'ic_created' => $date,
						'ic_created_by' => $oid,
						'ic_section' => 'customer'
					);
					$this->db->insert('i_customers',$data);
					$cid = $this->db->insert_id();
				}

				$data = array(
					'iextetor_customer_id' => $cid,
					'iextetor_txn_id' => $invoice_txn_id,
					'iextetor_date' => $date,
					'iextetor_type' => 'mobile',
					'iextetor_amount' => $total_amt,
					'iextetor_status' => 'pending',
					'iextetor_owner' => $oid,
					'iextetor_created' => $date,
					'iextetor_created_by' => $uid,
					'iextetor_gid' => $gid
				);
				$this->db->insert('i_ext_et_orders',$data);
				$orid = $this->db->insert_id();
				
				for ($i=0; $i < count($cart) ; $i++) { 
					$pid = $cart[$i]['pid'];
					$id = $cart[$i]['c_id'];
					$p_total = $cart[$i]['rate'] * $cart[$i]['qty'];

					$data = array(
						'iextetodp_order_id' => $orid,
						'iextetodp_pid' => $pid,
						'iextetodp_rate' => $cart[$i]['rate'],
						'iextetodp_qty' => $cart[$i]['qty'],
						'iextetodp_approved_qty' => $cart[$i]['qty'],
						'iextetodp_amount' => $p_total,
						'iextetodp_owner' => $oid,
						'iextetodp_alias' => 'false'
					);
					$this->db->INSERT('i_ext_et_orders_product_details',$data);

					$data = array(
						'iextetmc_qty' => $cart[$i]['qty'],
						'iextetmc_modified_by' => $uid,
						'iextetmc_modified' => $date,
						'iextetmc_status' => 'true',
						'iextetmc_order_id' => $orid
					);
					$this->db->WHERE(array('iextetmc_pid' => $pid , 'iextetmc_id' => $id));
					$this->db->update('i_ext_et_mobile_cart',$data);
				}

				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$email' AND ic_owner = '$oid'");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) { 
					$data = array(
						'iextetorp_inid' => $orid,
						'iextetorp_property_value' => $result[$i]->icbd_value,
						'iextetorp_status' => 'false'
					);
					$this->db->insert('i_ext_et_orders_property',$data);
				}


				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Orders' AND iextdt_owner='$oid'");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) { 
					$data = array(
						'iextetort_inid' => $orid,
						'iextetort_term_id' => $result[$i]->iextdt_id,
						'iextetort_status' => 'false'
					);	
					$this->db->insert('i_ext_et_orders_terms',$data);
				}

				$data1 = array(
					'in_type_id' => $orid,
					'in_type' => 'orders',
					'in_m_id' => $mid,
					'in_person' => $cid,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $date
				);
				$this->db->insert('i_notifications',$data1);

				echo "true";
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}
	############ Cosmos Invoice #############
		public function cosmos_invoice($mid = null,$code) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * FROM i_modules as a left join i_function as b on a.im_function = b.ifun_id left join i_domain as c on a.im_domain = c.idom_id WHERE im_name = 'Invoice' ");
				$result = $query->result();
				$mid = 0;
				if (count($result) > 0 ) {
					$mid = $result[0]->im_id;
				}

				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$email' AND ic_owner = '$oid'");
				$result = $query->result();
				$cid = 0;
				if (count($result) > 0 ) {
					$cid = $result[0]->ic_id;
				}

				$q = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_customer_id = '$cid' AND iextein_owner = '$oid' AND iextein_gid = '$gid' ");
				$data['invoice'] = $q->result();

				$ert['code'] = $code;
				$ert['gid'] = 0;
				$ert['mname'] = 0;
				$ert['mid'] = $mid;
				$ert['title'] = "Invoice";
				$ert['search'] = "false";
				$ert['name'] = $sess_data['user_details'][0]->iextetmu_name;
				$this->load->view('mob_navbar', $ert);
				$this->load->view('mobile_app/cosmos_invoice', $data);
			}else{
				redirect(base_url().'mobile_app/index/1');
			}
		}

		public function check_template($code,$mod_id){
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$ert['color'] = $sess_data['color'];
				$data['oid'] = $oid;
				$email = $sess_data['user_details'][0]->iextetmu_email;

				$query = $this->db->query("SELECT * from i_user_template WHERE iut_mid = '$mod_id' and iut_owner = '$oid';");
				$result = $query->result();
				if (count($result) > 0) {
					echo "true";
				}else{
					echo "false";
				}
			}else{
				redirect(base_url().'account/login');
			}
		}

		public function invoice_download($flg,$mod_id,$code,$invoiceid){
		$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;

				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close();

		 		$page = file_get_contents(base_url().'Mobile_app/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
			    session_start();

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/invoice/';

			    if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
			   
			    $htmlfile = $invoiceid.'.html';
			    $invoicefile = $invoiceid.'.pdf';

			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

		    	$this->load->helper('download');
    			force_download($path.$invoicefile, NULL);
			}else{
				redirect(base_url().'Account/login');
			}
		}

		public function invoice_print($code,$mod_id, $invoice_id) {
			$sess_data = $this->log_owner->get_session_value($code,true);
			if($sess_data['session'] == 'true') {
				$oid = $sess_data['oid'];
				$gid = $sess_data['gid'];
				$uid = $sess_data['user_details'][0]->iextetmu_id;
				$u_owner = $oid;
				$data['oid'] = $oid;
				$Q=$this->db->query("SELECT * from i_u_details where iud_id = '$oid'");
				$result=$Q->result();
				$data['k']=$result;
				$dat = array('skip_edit' => "true");
				$this->session->set_userdata($dat);

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner='$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				if(count($result) <= 0) {
					$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner = '$oid'");
					$result = $query->result();
					$data['basic'] = $result;

					$data['s_name'] = $result[0]->ic_name;
					$data['s_address'] = '';
					$data['s_txn_id'] = $result[0]->iextein_txn_id;
					$data['s_txn_date'] = $result[0]->iextein_txn_date;
					$data['s_txn_note'] = $result[0]->iextein_note;
					$data['s_txn_disp_hsn'] = $result[0]->iextein_hsn;
					$data['s_txn_disp_desc'] = $result[0]->iextein_desc;
				} else {
					$data['s_name'] = $result[0]->ic_name;
					$data['s_address'] =$result[0]->icbd_value;
					$data['s_txn_id'] = $result[0]->iextein_txn_id;
					$data['s_txn_date'] = $result[0]->iextein_txn_date;
					$data['s_txn_note'] = $result[0]->iextein_note;
					$data['s_txn_disp_hsn'] = $result[0]->iextein_hsn;
					$data['s_txn_disp_desc'] = $result[0]->iextein_desc;
				}

				$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$u_owner'");
				$result = $query->result();
				$data['u_gst'] = $result[0]->iud_gst;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id='$invoice_id'");
				$result = $query->result();
				$data['note']=$result[0]->iextein_note;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteinpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON a.iexteinpd_tax = c.ittxg_id LEFT JOIN i_product AS d ON a.iexteinpd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id WHERE a.iexteinpd_d_id='$invoice_id' AND a.iexteinpd_owner='$oid'");
				$result = $query->result();
				$data['details'] = $result;


	            $query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
				$result = $query->result();
				$data['taxes'] = $result;
	            
				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_invoice_terms as b on a.iextdt_id=b.iexteintm_term_id WHERE iextdt_document='Invoice' AND iextdt_owner='$oid' AND iexteintm_inid= '$invoice_id' AND iexteintm_status = 'true' ");
				$result = $query->result();
				$data['terms'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice_property WHERE iexteinpt_inid ='$invoice_id' AND iexteinpt_status = 'true' ");
				$result = $query->result();
				$data['property'] = $result;

				$data['s_title'] = "Tax Invoice";

				$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
				$result = $query->result();
				$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/'.$result[0]->iud_logo;

				$query1 = $this->db->query("SELECT * FROM i_template WHERE itemp_id IN (SELECT iut_tempid FROM i_user_template WHERE iut_owner = '$oid' AND iut_mid = '$mod_id');");
				$result = $query1->result();
				$temp_id = $result[0]->itemp_id;

				$query = $this->db->query("SELECT * FROM i_u_t_copies WHERE iutc_owner = '$oid' AND iutc_mod_id = '$mod_id' AND iutc_temp_id = '$temp_id'");
				$result = $query->result();
				$data['temp_copies']=$result;

				foreach ($query1->result() as $user){
				    $template_name = "template/$user->itemp_file_name"; 
				}
				$this->load->view("$template_name", $data);
			} else {
				redirect(base_url().'Account/login');
			}
		}
################ X App #################
}