<?php
require_once(APPPATH. 'razorpay-php/Razorpay.php');
use Razorpay\Api\Api as RazorpayApi;
class Home extends CI_Controller {
	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('directory');
		$this->load->helper('cookie');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}

	public function index($code,$type = null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['v_type'] = $sess_data['user_details'][0]->i_u_home_view;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mname = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}
			if ($type == null) {
				$data['type'] = 'home';
			}else{
				$data['type'] = $type;
			}

			$displays = array();
			$modid = array();

			$dt=date('Y-m-d');

			$ert['code'] = $sess_data['code'];
			$ert['gid'] = $sess_data['gid'];
			$ert['mname'] = '';
			$ert['mod'] = $sess_data['user_mod'];
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Home";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('home/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function account_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$swicth_account = $this->input->post('s_account');
			$query = $this->db->query(" SELECT * FROM i_user_group WHERE iug_owner= '$oid' AND iug_name LIKE '%$swicth_account%' AND iug_id IN(SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' OR ium_u_id = '$uid' AND ium_gid != '0')");
			$data['account'] = $query->result();
			
			print_r(json_encode($data));		
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function widget_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$name = $this->input->post('name');

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id WHERE iukpi_id NOT IN(SELECT iuk_kpi_id FROM i_user_kpi WHERE iuk_uid = '$oid' AND iuk_gid = '$gid' AND iuk_mid = '0') AND iukpi_module IN(SELECT ium_m_id FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid') AND iukpi_title LIKE '%$name%'");
			$result = $query->result();
			$data['widget'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_widget($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iuk_uid' => $uid,
				'iuk_kpi_id' => $id,
				'iuk_mid' => 0,
				'iuk_gid' => $gid,
				'iuk_created' => $dt,
				'iuk_created_by' => $uid
			);
			$this->db->insert('i_user_kpi',$data);

			redirect(base_url().'Home/index/'.$code);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function module_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;

			$m_name = $this->input->post('m_name');
			if($m_name == ''){
				$data['module'] = $sess_data['user_mod'];
			}else{
				if ($gid == 0) {
					$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status , a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_u_id = '$uid' AND a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND b.im_name LIKE '%$m_name%' UNION SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status , a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_u_id = '$uid' AND a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_module_alias LIKE '%$m_name%'");
					$data['module'] = $query1->result();
				}else{
					if ($uid == $oid) {
						$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias  FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_gid = '0' AND ium_status = 'active') AND b.im_name LIKE '%$m_name%' UNION SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias  FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_gid = '0' AND ium_status = 'active') AND a.ium_module_alias LIKE '%$m_name%'");
						$data['module'] = $query1->result();
					}else{
						$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_u_id='$oid' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_status = 'active') AND b.im_name LIKE '%$m_name%' UNION SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_u_id='$oid' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_status = 'active') AND a.ium_module_alias LIKE '%$m_name%'");
						$data['module'] = $query1->result();
					}
				}
			}
			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function getnotification($code,$yr,$mn,$day,$hr,$min,$flg=null){
		$sess_data = $this->log_code->get_session_value($code);
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$property =[];
			$pid = '0';
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%'");
			$result1 = $query->result();
			if (count($result1) > 0) {
				for ($i=0; $i <count($result1) ; $i++) { 
					array_push($property,$result1[$i]->ip_id);
				}
				$pid = implode(',', $property);	
			}

			$query = $this->db->query("SELECT ic_id FROM i_customers as a left JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE b.icbd_property in($pid)  and b.icbd_value IN(SELECT i_uname FROM i_users WHERE i_uid = '$uid')");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->ic_id;
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_owner = '$oid' AND iextamc_status = 'sheduled' AND iextamc_sheduled != 'none' ");
			$result = $query->result();
			for ($i=0; $i <count($result) ; $i++) {
				$s_date = strtotime($result[$i]->iextamc_period_from);
				$e_date = strtotime($result[$i]->iextamc_period_to);
				$c_month= strtotime(date("y-m-d"));
				if ($c_month >= $s_date && $c_month <= $e_date ) {
					$dt = date('Y-m-d');
					$year1 = date('Y', $s_date);
					$year2 = date('Y', $e_date);
					$month1 = date('m', $s_date);
					$month2 = date('m', $e_date);
					$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
					if ($result[$i]->iextamc_sheduled == 'monthly' ) {
						$dt1 = date('Y-m-01', strtotime($dt));	
					}else if ($result[$i]->iextamc_sheduled == 'by_monthly' ) {
						$d_flg = $diff / 2 ;
						$flg = 1 ;
						do{
							$m = $flg * 2 ;
							$w_date = date('Y-m-01', strtotime("+".$m." months", $s_date));
							if ( strtotime($w_date) < $e_date ) {
								$dt1 = $w_date;
							}
							$flg++;
						}while ($d_flg >= $flg);
					}else if ($result[$i]->iextamc_sheduled == 'quarterly'){
						$d_flg = $diff / 3 ;
						$flg = 1 ;
						do{
							$m = $flg * 3 ;
							$w_date = date('Y-m-01', strtotime("+".$m." months", $s_date));
							if ( strtotime($w_date) < $e_date ) {
								$dt1 = $w_date;
							}
							$flg++;
						}while ($d_flg >= $flg);
					}else if ($result[$i]->iextamc_sheduled == 'half_year'){
						$d_flg = $diff / 6 ;
						$flg = 1 ;
						do{
							$m = $flg * 6 ;
							$w_date = date('Y-m-01', strtotime("+".$m." months", $s_date));
							if ( strtotime($w_date) < $e_date ) {
								$dt1 = $w_date;
							}
							$flg++;
						}while ($d_flg >= $flg);
					}
					if ($dt == $dt1) {
						$n_dt = date('Y-m-d H:i:s');
						$amc_id = $result[$i]->iextamc_id;
						$query = $this->db->query("SELECT * FROM i_notifications WHERE in_type = 'sub_act' AND in_type_id = '$amc_id' ORDER BY in_date ASC");
						$result1= $query->result();
						if (count($result1) == 0) {
							$data = array(
								'in_type' => 'sub_act',
								'in_type_id' => $amc_id,
								'in_m_id' => 42,
								'in_person' => $cid,
								'in_owner' => $uid,
								'in_status' => 0,
								'in_date' => $n_dt
							);
							$this->db->insert('i_notifications',$data);	// notification start of the month
						}
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_owner = '$oid' ");
			$result = $query->result();
			for ($i=0; $i <count($result) ; $i++) {
				$s_date = date('Y-m-d',strtotime($result[$i]->iextein_txn_date));
				$wrnt = intval($result[$i]->iextein_warranty) - 1;
				$w_date = date('Y-m-27', strtotime("+".$wrnt." months", strtotime($s_date))); // notification end of the month
				$c_date = date('Y-m-d');
				if ($c_date == $w_date) {
					$n_dt = date('Y-m-d H:i:s');
					$invoice_id = $result[$i]->iextein_id;
					$query = $this->db->query("SELECT * FROM i_notifications WHERE in_type = 'create_sub' AND in_type_id = '$invoice_id' ORDER BY in_date ASC");
					$result1= $query->result();
					if (count($result1) == 0) {
						$data = array(
							'in_type' => 'create_sub',
							'in_type_id' => $invoice_id,
							'in_m_id' => 35,
							'in_person' => $cid,
							'in_owner' => $uid,
							'in_status' => 0,
							'in_date' => $n_dt
						);
						$this->db->insert('i_notifications',$data);
					}
				}
			}

			if ($flg != null) {
				$query = $this->db->query("SELECT * FROM i_notifications WHERE in_status != 1 AND year(in_date) <= '$yr' AND month(in_date) <= '$mn' AND day(in_date) <= '$day' AND hour(in_date) <= '$hr' AND in_person in (SELECT ic_id FROM i_customers as a left JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE b.icbd_property in($pid)  and b.icbd_value IN(SELECT i_uname FROM i_users WHERE i_uid = '$uid')) ORDER BY in_date ASC");
				$result = $query->result();	
			}else{
				$query = $this->db->query("SELECT * FROM i_notifications WHERE in_status != 1 AND year(in_date) = '$yr' AND month(in_date) = '$mn' AND day(in_date) = '$day' AND hour(in_date) = '$hr' AND minute(in_date) = '$min' AND in_person in (SELECT ic_id FROM i_customers as a left JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE b.icbd_property in($pid)  and b.icbd_value IN(SELECT i_uname FROM i_users WHERE i_uid = '$uid')) ORDER BY in_date ASC");
				$result = $query->result();	
			}
			$data['notification'] = array();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					if ($result[$i]->in_type == 'customer') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					// array_push($data['customer'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->ic_name , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'invoice') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) {
	    					// array_push($data['invoice'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextein_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'inward' || $result[$i]->in_type == 'outward') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					// array_push($data['inventory'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextei_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'purchase') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					// array_push($data['purchase'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextep_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'activity') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					// array_push($data['activity'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iua_title , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'proposal') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) {
	    					// array_push($data['proposal'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextepro_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'subscription') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					// array_push($data['amc'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextamc_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'sub_act') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) {
	    					// array_push($data['sub_act'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextamc_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';

					if ($result[$i]->in_type == 'create_sub') {
						$tid = $result[$i]->in_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id = '$tid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) {
	    					// array_push($data['create_sub'], $result2[$j]);
	    					array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result2[$j]->iextein_txn_id , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
	    				}
					}$tid = '';
				}
			}

			$query = $this->db->query("SELECT * FROM i_notifications WHERE in_owner = '$oid' AND in_status != 1 AND in_type = 'messaging' AND in_m_id = 0 AND in_person in (SELECT i_ref FROM i_users WHERE i_uid = '$uid') ORDER BY in_date ASC");
			$result = $query->result();
			// array_push($data['notification'] , $result);

			for ($i=0; $i < count($result) ; $i++) { 
				// array_push($data['msg'], array('text' => $result[$i]->in_content , 'nid' => $result[$i]->in_id ));
				array_push($data['notification'] , array('inid' => $result[$i]->in_id , 'type' => $result[$i]->in_type , 'type_id' => $result[$i]->in_type_id , 'content' => $result[$i]->in_content , 'mid' => $result[$i]->in_m_id , 'person' => $result[$i]->in_person , 'status' => $result[$i]->in_status ));
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function notification_update($code,$id=null){
		$sess_data = $this->log_code->get_session_value($code);
		if(isset($sess_data['user_details'][0])) {
			$data = array(
				'in_status' => 1
			);
			$this->db->where('in_id',$id);
			$this->db->update('i_notifications',$data);

			echo 'true';

		}else{
			redirect(base_url().'account/login');
		}	
	}

	// public function get_notification_count($code){
	// 	$sess_data = $this->log_code->get_session_value($code);
	// 	if(isset($sess_data['user_details'][0])) {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$property = [];
	// 		$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%'");
	// 		$result1 = $query->result();
	// 		$pid = '0';
	// 		if (count($result1) > 0 ) {
	// 			for ($i=0; $i <count($result1) ; $i++) { 
	// 				array_push($property,$result1[$i]->ip_id);
	// 			}
	// 			$pid = implode(',', $property);	
	// 		}
				
	// 		$query = $this->db->query("SELECT * FROM i_notifications WHERE in_status != 1 AND in_person in (SELECT ic_id FROM i_customers as a left JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE b.icbd_property in($pid)  and b.icbd_value IN(SELECT i_uname FROM i_users WHERE i_uid = '$uid')) ORDER BY in_date ASC");
	// 		$n_count = $query->result();

	// 		$query = $this->db->query("SELECT * FROM i_notifications WHERE in_owner = '$oid' AND in_status != 1 AND in_type = 'messaging' AND in_m_id = 0 AND in_person in (SELECT i_ref FROM i_users WHERE i_uid = '$uid') ORDER BY in_date ASC");
	// 		$nn_count = $query->result();

	// 		$t_count = count($n_count) + count($nn_count);

	// 		echo $t_count;
	// 	}else{
	// 		redirect(base_url().'account/login');
	// 	}	
	// }

	public function activity_view($view){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$data = array(
				'i_view' => $view
			);
			$this->db->where('i_uid',$oid);
			$this->db->update('i_users',$data);

			echo "true";

		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function fetch_views($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

            $intent = $this->input->post('intent');
            $action = $this->input->post('action');
            $parameters = json_decode($this->input->post('parameters'), true);
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id WHERE iukpi_analytics_trigger  = '$intent' AND iukpi_id IN(SELECT iuk_kpi_id FROM i_user_kpi WHERE iuk_uid = '$oid' AND iuk_gid = '$gid' AND iuk_mid = '0')");
			$result = $query->result();
			$displays = array();

			for ($j=0;$j<count($result);$j++) { 
				$dt = date('Y-m-d');
				$que_str = $result[$j]->iukpi_query;

				eval("\$que_str = \"$que_str\";");
				
				$que = $this->db->query($que_str);
				$res = $que->result_array();
				
				if(count($res) > 0) {
					$wer = '';
					if($result[$j]->iukpi_display_type == "table") {
						$wer .= '<table  class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">';
						foreach ($res as $key => $value) {
							$wer .= '<tr>';
							foreach ($value as $key1 => $value1) {
								$wer.= '<th class="mdl-data-table__cell--non-numeric">'.$key1."</th>";
							}
							$wer .= '</tr>';
							break;
						}
						foreach ($res as $key => $value) {
							$wer.="<tr>";
							foreach ($value as $key1 => $value1) {
								$wer.= '<td class="mdl-data-table__cell--non-numeric">'.$value1."</td>";
							}
							$wer.="</tr>";
						}
						$wer.='</table>';
					} else if($result[$j]->iukpi_display_type == "number") {
						$wer .= '<div class="mdl-grid">';
						$wer .= '<h1 style="font-size:6em;">';
						foreach ($res as $key => $value) {
							foreach ($value as $key1 => $value1) {
								$wer.= " ".$value1;
							}
							$wer.="<br>";
						}
						$wer.='</h1></div>';
					} else if($result[$j]->iukpi_display_type == "line") {
						$red = rand(10, 255);
						$green = rand(10, 255);
						$blue = rand(10, 255);
						$opacity = rand(0.0, 1.0);
						$wer .= '<canvas id="'.$j.'line" width="400" height="300"></canvas>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'line").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "line", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: "rgba('.$red.','.$green.','.$blue.',1)"}] }, options: {scales: {yAxes: [{ticks: {beginAtZero:true } }] } } }); </script>';

					} else if($result[$j]->iukpi_display_type == "bar") {
						$red = rand(10, 255);
						$green = rand(10, 255);
						$blue = rand(10, 255);
						$opacity = rand(0.0, 1.0);
						
						$wer .= '<canvas id="'.$j.'bar" width="400" height="300"></canvas> </div> </div>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'bar").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "bar", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: "rgba('.$red.','.$green.','.$blue.',1)"}] }, options: {scales: {yAxes: [{ticks: {beginAtZero:true } }] } } }); </script>';
					
					} else if($result[$j]->iukpi_display_type == "pie") {
						
						$arr_color = [];

						$opacity = rand(0.0, 1.0);

						$wer .= '<canvas id="'.$j.'pai" width="400" height="300"></canvas>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'pai").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									$red = rand(10, 255);
									$green = rand(10, 255);
									$blue = rand(10, 255);

									$color = 'rgba('.$red.','.$green.','.$blue.',1)';
									array_push($arr_color, $color);
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: '.json_encode($arr_color).' }] }, options: { title : { display: true, fontSize : 20 } , rotation : -0.1 * Math.PI } }); </script>';
					}

					$chart = $wer;
					$title = $result[$j]->iukpi_title;
					$desc = $result[$j]->iukpi_desc;

					$path = $this->config->item('document_rt')."assets/data/portal/kpi/";
                    if ($result[$j]->iukpi_code != '') {
                        $d_file = file_get_contents($path.$result[$j]->iukpi_code.'.txt');
                    }else{
                        $d_file = '';
                    }
					$dis ='';
					eval("\$dis = \"$d_file\";");
					array_push($displays, $dis);
				}
			}
			if(count($displays) > 0) {
			    print_r($displays[0]);
			} else {
			    print_r("no_records");
			}
		}
	}

	public function search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$data['dom'] = $sess_data['user_mod'][0]->idom_name;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']= $sess_data['user_connection'];
			$ert['title'] = "Search";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('home/search', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function search_records($code) {
		$sess_data = $this->log_code->get_session_value($code);
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			// $gid = $sess_data['gid'];

			$tags = $this->input->post("keywords");
			$data = [];
			$data['customer'] = [];
            $data['invoice'] = [];
            $data['inventory'] = [];
            $data['amc'] = [];
            $data['purchase'] = [];
            $data['activity'] = [];
            $data['expenses'] = [];
            $data['opportunity'] = [];
            $data['product'] = [];
            $data['proposal'] = [];
            $data['project'] = [];

			$query = $this->db->query("SELECT it_id FROM i_tags WHERE it_owner = '$oid' AND it_value LIKE '%$tags%'");
			$result = $query->result();
			
			if(count($result) > 0) {
			    $tagid = [];
			    
    			for ($i=0; $i < count($result) ; $i++) { 
    				array_push($tagid, $result[$i]->it_id);
    			}
    			$temp = implode(',', $tagid);
    		}else{
    			$temp = 0;
    		}

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_property LIKE 'email' AND ip_owner = '$oid'");
			$result1 = $query->result();
			$pid = $result1[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_ext_tags WHERE iet_tag_id IN ('$temp') AND iet_owner = '$oid'");
			$result = $query->result();			
			$data['tags'] = $result;

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					if ($result[$i]->iet_type == 'customers') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$tid' AND ic_owner = '$oid'");
		    			$result1 = $query->result();
		    			for ($j=0; $j < count($result1) ; $j++) { 
	    					array_push($data['customer'], $result1[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'invoice') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id = '$tid' AND iextein_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['invoice'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'inward' || $result[$i]->iet_type == 'outward') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_id = '$tid' AND iextei_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['inventory'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'subscription') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_id = '$tid' AND iextamc_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['amc'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'proposal') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_id = '$tid' AND iextepro_owner = '$oid' ");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['proposal'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'products') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_product WHERE ip_id = '$tid' AND ip_owner = '$oid' ");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) {
	    					array_push($data['product'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'purchase') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_id = '$tid' AND iextep_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['purchase'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'expenses') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_id = '$tid' AND iextete_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['expenses'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'opportunity') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$tid' AND iextetop_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['opportunity'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'project') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_id = '$tid' AND iextpp_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['project'], $result2[$j]);
	    				}
					}$tid = '';

					if ($result[$i]->iet_type == 'activity') {
						$tid = $result[$i]->iet_type_id;
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$tid' AND iua_owner = '$oid'");
		    			$result2 = $query->result();
		    			for ($j=0; $j < count($result2) ; $j++) { 
	    					array_push($data['activity'], $result2[$j]);
	    				}
					}$tid = '';
				}
			}
			print_r(json_encode($data));
		} else {
			echo "Session expired. Please refresh to login again.";
		}	
	}
################### user history ####################
	public function user_history($code){
		$sess_data = $this->log_code->get_session_value($code);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$sel_mod_id = $this->input->post('s_mod_id');
			$dt = date('Y-m-d H:i:s');
			$data1 = array(
				'iuh_owner' => $oid,
				'iuh_mid' => $sel_mod_id, 
				'iuh_date' => $dt
			);
			$this->db->insert('i_user_history', $data1);
		
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mid == $sel_mod_id) {
					$data['mid'] = $module[$i]->mid;
					$data['dom_name'] = $module[$i]->domain;
					$data['fun_name'] = $module[$i]->function;
				}
			}
			print_r(json_encode($data));

		}else{
			redirect(base_url().'Account/login');
		}
	}

################### Activity ########################
	public function activity($code,$aid=null,$pid=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d');
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

			if ($oid == $uid) {
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND DATE(iua_date)='$dt' UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$data['activity'] = $query->result();

				$query = $this->db->query("SELECT iua_date FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' UNION SELECT iua_date FROM i_user_activity WHERE iua_g_id= '$gid' and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$result1 = $query->result();
				$data['activity_date'] = $result1;

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND date(iua_date) IN('$dt','0') UNION SELECT * FROM i_user_activity WHERE iua_g_id= '$gid' and date(iua_date) IN('$dt','0') and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) GROUP BY iua_categorise ORDER BY iua_date DESC");
				$result1 = $query->result();
				$data['activity_cat'] = $result1;

			}else{
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND DATE(iua_date)='$dt' AND iua_type in('Event','Reminder','subscription') UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type in('Event','Reminder','subscription') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$data['activity'] = $query->result();

				$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
				$result = $query->result();
				$property = [];
				if (count($result) > 0) {
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($property,$result[$i]->iextpt_aid);
					}
					$p_aid = implode(',', $property);

					$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$dt' AND iua_id IN ($p_aid)");
					$result = $query->result();
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($data['activity'], $result[$i]);
					}	
				}

				$query = $this->db->query("SELECT iua_date FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND iua_type in('Event','Reminder','subscription') UNION SELECT iua_date FROM i_user_activity WHERE iua_g_id= '$gid' AND iua_type in('Event','Reminder','subscription') and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$result1 = $query->result();
				$data['activity_date'] = $result1;

				$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
				$result = $query->result();
				$property = [];
				if (count($result) > 0) {
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($property,$result[$i]->iextpt_aid);
					}
					$p_aid = implode(',', $property);

					$query = $this->db->query("SELECT iua_date FROM i_user_activity WHERE iua_id IN ($p_aid)");
					$result = $query->result();
					for ($i=0; $i <count($result) ; $i++) {
						array_push($data['activity_date'], $result[$i]);
					}
				}

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND DATE(iua_date)='$dt' AND iua_type in('Event','Reminder','subscription') UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type in('Event','Reminder','subscription') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) GROUP BY iua_categorise ORDER BY iua_date DESC");
				$data['activity_cat'] = $query->result();

				$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
				$result = $query->result();
				$property = [];
				if (count($result) > 0) {
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($property,$result[$i]->iextpt_aid);
					}
					$p_aid = implode(',', $property);

					$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$dt' AND iua_id IN ($p_aid) GROUP BY iua_categorise");
					$result = $query->result();
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($data['activity_cat'], $result[$i]);
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_u_a_person as a left join i_customers as b on a.iuap_p_id=b.ic_id WHERE a.iuap_owner = '$oid' AND b.ic_section = 'customer' GROUP BY iuap_p_id");
			$result = $query->result();
			$data['a_person'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			$data['activity_todo'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_person as a left join i_customers as b on a.iuap_p_id=b.ic_id WHERE a.iuap_owner = '$oid'");
			$data['activity_person'] = $query->result();

			$query = $this->db->query("SELECT ic_name,ic_uid FROM i_customers WHERE ic_uid IN (SELECT iua_modified_by FROM i_user_activity)");	
			$data['activity_perform'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			if ($pid != null) {
				$data['pid'] = $pid;
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_id = '$pid'");
				$data['pid_name'] = $query->result();
			}

			$ert['mod'] = $sess_data['user_mod'];
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['code'] = $code;
			$ert['mid'] = 0;
			$ert['gid'] = $gid;
			$ert['title'] = "Activity";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('home/activity', $data);
			$this->load->view('home/search_modal');

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function calendar_filter($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			// $data['activity_date'] = [];
			$search = $this->input->post('calander_date');

			if ($oid == $uid) {
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND DATE(iua_date) = '$search' UNION SELECT * FROM i_user_activity WHERE iua_g_id= '$gid' and DATE(iua_date) = '$search' and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$result = $query->result();
				$data['activity_d'] = $result;

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND DATE(iua_date) = '$search' AND iua_g_id = '$gid' GROUP BY iua_categorise ORDER BY iua_date DESC");
				$result = $query->result();
				$data['activity_cat'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND DATE(iua_date) = '$search' AND iua_type in('Event','Reminder') UNION SELECT * FROM i_user_activity WHERE iua_g_id= '$gid' and DATE(iua_date) = '$search' AND iua_type in('Event','Reminder') and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
				$result = $query->result();
				$data['activity_d'] = $result;

				$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
				$result = $query->result();
				$property = [];
				if (count($result) > 0) {
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($property,$result[$i]->iextpt_aid);
					}
					$p_aid = implode(',', $property);

					$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$search' AND iua_id IN ($p_aid)");
					$result = $query->result();
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($data['activity_d'], $result[$i]);
					}
				}

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND DATE(iua_date) = '$search' GROUP BY iua_categorise ORDER BY iua_date DESC");
				$result = $query->result();
				$data['activity_cat'] = $result;

				$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
				$result = $query->result();
				$property = [];
				if (count($result) > 0) {
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($property,$result[$i]->iextpt_aid);
					}
					$p_aid = implode(',', $property);

					$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$search' AND iua_id IN ($p_aid) GROUP BY iua_categorise");
					$result = $query->result();
					for ($i=0; $i <count($result) ; $i++) { 
						array_push($data['activity_cat'], $result[$i]);
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner = '$oid' AND iuat_a_id IN ( SELECT iua_id FROM i_user_activity WHERE iua_owner = '$oid' AND DATE(iua_date)='$search')");
			$data['todo_d'] = $query->result();
			
			$date = strtotime($search);
			$data['date_c'] = date('d-m-Y', $date);
			
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND DATE(iua_date) LIKE '%$search%' OR iua_title LIKE '%$search%' OR iua_place LIKE '%$search%' ORDER BY iua_date DESC");
			$result = $query->result();
			$data['activity_s'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner = '$oid' AND iuat_a_id IN ( SELECT iua_id FROM i_user_activity WHERE iua_owner = '$oid' AND DATE(iua_date) LIKE '%$search%' OR iua_title LIKE '%$search%' OR iua_place LIKE '%$search%')");
			$data['todo_s'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_update($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$tags = $this->input->post('a_tags');
			$gid = $sess_data['gid'];
			$a_flg = $this->input->post('a_mail');
			$type = '';
			$td = $this->input->post('a_to_do'); $flg=0;
			if (count($td) > 0) {
				$flg=1;
			}

			$note = $this->input->post('note');
			$person = $this->input->post('a_person');
			$a_date = $this->input->post('a_date');
			$e_date = $this->input->post('e_date');
			if ($a_date == '') {
				$type = 'note';
				$a_date = date('Y-m-d H:i:s');
			}else{
				$type = 'Event';
			}
			if ($e_date == '') {
				$e_date = date('Y-m-d H:i:s');
			}


			$s_func = $this->input->post('a_func_short');
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_name = '$s_func'");
			$result = $query->result();
			if (count($result) > 0) {
				$fid = $result[0]->ims_function;
				$mod_id = $result[0]->ims_m_id;	
			}else{
				$fid = 0;
				$mod_id = 0;
			}

			$data = array(
				'iua_type' => $type,
				'iua_title' => $this->input->post('a_title'),
				'iua_date' => $a_date,
				'iua_place' => $this->input->post('a_place'),
				'iua_to_do' => $flg,
				'iua_status' => 'pending',
				'iua_owner' => $oid,
				'iua_created_by' => $uid,
				'iua_created' => date('Y-m-d H:i:s'),
				'iua_categorise' => $this->input->post('a_cat'),
				'iua_p_activity' => 0,
				'iua_shortcuts' => $fid,
				'iua_m_shortcuts' => $mod_id,
				'iua_g_id' => $gid,
				'iua_modified_by' => 0,
				'iua_color' => $this->input->post('a_color'),
				'iua_end_date' => $e_date
			);
			$this->db->insert('i_user_activity',$data);
			$aid = $this->db->insert_id();

			for ($i=0; $i <count($person) ; $i++) { 
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
				$result = $query->result();

				$data = array(
					'iuap_a_id' => $aid,
					'iuap_p_id' => $result[$i]->ic_id,
					'iuap_owner'=> $oid
				);
				$this->db->insert('i_u_a_person',$data);

				$data1 = array(
					'in_type_id' => $aid, 
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $result[$i]->ic_id,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt
				);
				$this->db->insert('i_notifications',$data1);
			}

			$str1 = preg_replace('/\s+/', ' ', trim($note));
			if ($str1 != '') {
				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
				if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				$txt_file = $aid.'.txt';
				file_put_contents($path.$txt_file, $note);

				$data = array(
					'iua_note' => $txt_file
				);
				$this->db->where('iua_id',$aid);
				$this->db->update('i_user_activity',$data);
			}

			$data2 = array(
				'iual_a_id' => $aid,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'add'
			);
			$this->db->insert('i_u_a_log',$data2);

			for ($i=0; $i < count($td); $i++) {
				$data1 = array(
					'iuat_a_id' => $aid,
					'iuat_title' => $td[$i]['title'],
					'iuat_status' => $td[$i]['status'],
					'iuat_owner' => $oid
				);
				$this->db->insert('i_u_a_todo',$data1);
			}

			for ($j=0; $j < count($tags) ; $j++) {
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data2 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data2);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data3 = array(
					'iuat_a_id' => $aid,
					'iuat_t_id' => $tid,
					'iuat_owner'=>$oid
				);
				$this->db->insert('i_u_activity_tags', $data3);

				$data5 = array(
					'iet_type_id' => $aid,
					'iet_type' => 'activity',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => 0
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if ($a_flg == 'true') {
				redirect(base_url().'Home/activity_mail/'.$aid.'/'.$code);	
			}else{
				echo "true";
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_mail($aid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_property like '%email%' ");
			$result = $query->result();
			$pid = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_u_a_person as b left JOIN i_user_activity as a on a.iua_id=b.iuap_a_id WHERE a.iua_id = '$aid' AND a.iua_owner = '$oid' ");
			$result = $query->result();
			$a_oid = $result[0]->iua_owner;

			$query1 = $this->db->query("SELECT * FROM i_users as a left JOIN i_u_details as b on a.i_uid=b.iud_u_id WHERE a.i_uid = '$a_oid'");
			$result1 = $query1->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			for ($i=0; $i <count($result) ; $i++) { 

				$cid = $result[0]->iuap_p_id;
				$query2 = $this->db->query("SELECT * FROM i_customers as a left JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE a.ic_id = '$cid' and b.icbd_property = '$pid' ");
				$result2 = $query2->result();
				$cid = '';
				$subject = $result1[0]->iud_name.' tag you in '.$result[0]->iua_title.' activity';

				if (count($result2) > 0) {
					for ($i=0; $i <count($result2) ; $i++) { 
						$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head><body>Dear '.$result2[$i]->ic_name.',<br><br>Please check account for further details.<br><br>Thanks & Regards</body></html>';
						$to = $result2[$i]->icbd_value;
						$temp = $this->Mail->send_mail($subject,$to,null,$body,$code);
					}
				}
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}	
	}

	public function activity_edit_fetch($aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$aid'");
			$result = $query->result();
			if ($result[0]->iua_owner != $oid) {
				$oid = $result[0]->iua_owner;
				$data['sid'] = $oid;
			}

			$str1 = preg_replace('/\s+/', ' ', trim($result[0]->iua_note));
			if ($str1 != '') {

				$txt_file = $result[0]->iua_note;
				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
				$data['note'] = file_get_contents($path.$txt_file);
			}

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_id='$aid'");
			$result = $query->result();
			$data['edit_activity'] = $result;
			$fid = $result[0]->iua_shortcuts;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_id IN(SELECT iuat_t_id FROM i_u_activity_tags WHERE iuat_a_id = '$aid')");
			$data['edit_tags'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_m_shortcuts where ims_function = '$fid'");
			$data['f_name'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT iuap_p_id FROM i_u_a_person WHERE iuap_owner ='$oid' AND iuap_a_id = '$aid')");
			$result = $query->result();
			$data['edit_person'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner = '$oid' AND iuat_a_id = '$aid'");
			$result = $query->result();
			$data['edit_todo'] = $result;
			$data['edit_id'] = $aid;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function add_to_active_list($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT * FROM i_u_a_active_list WHERE iuaal_owner = '$oid' AND iuaal_aid = '$aid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				echo "false";
			}else{
				$data = array(
					'iuaal_aid' => $aid,
					'iuaal_owner' => $oid,
					'iuaal_created' => $dt,
					'iuaal_created_by' => $uid
				);
				$this->db->insert('i_u_a_active_list',$data);
				echo 'true';
			}
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function activity_add_child($pid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$tags = $this->input->post('a_tags');
			$gid = $sess_data['gid'];
			$a_flg = $this->input->post('a_mail');

			$td = $this->input->post('a_to_do'); $flg=0;
			if (count($td) > 0) {
				$flg=1;
			}
			$person = $this->input->post('a_person');
			$note = $this->input->post('note');
			$s_func = $this->input->post('a_func_short');
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_name = '$s_func'");
			$result = $query->result();
			$fid = $result[0]->ims_function;
			$mod_id = $result[0]->ims_m_id;

			$data = array(
				'iua_type' => 'Event',
				'iua_title' => $this->input->post('a_title'),
				'iua_date' => $this->input->post('a_date'),
				'iua_place' => $this->input->post('a_place'),
				'iua_to_do' => $flg,
				'iua_status' => 'pending',
				'iua_note' => $this->input->post('a_note'),
				'iua_owner' => $oid,
				'iua_created_by' => $uid,
				'iua_created' => date('Y-m-d H:i:s'),
				'iua_categorise' => $this->input->post('a_cat'),
				'iua_p_activity' => $pid,
				'iua_shortcuts' => $fid,
				'iua_m_shortcuts' =>$mod_id,
				'iua_g_id' => $gid,
				'iua_end_date' => $this->input->post('e_date'),
				'iua_color' => $this->input->post('a_color')
			);
			$this->db->insert('i_user_activity',$data);
			$aid = $this->db->insert_id();

			for ($i=0; $i <count($person) ; $i++) { 
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
				$result = $query->result();

				$data = array(
					'iuap_a_id' => $aid,
					'iuap_p_id' => $result[$i]->ic_id,
					'iuap_owner'=> $oid
				);
				$this->db->insert('i_u_a_person',$data);

				$data1 = array(
					'in_type_id' => $aid, 
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $result[$i]->ic_id,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt
				);
				$this->db->insert('i_notifications',$data1);
			}

			$str1 = preg_replace('/\s+/', ' ', trim($note));
			if ($str1 != '') {
				// echo $note."hello";
				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
				if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				$txt_file = $aid.'.txt';
				file_put_contents($path.$txt_file, $note);

				$data = array(
					'iua_note' => $txt_file
				);
				$this->db->where('iua_id',$aid);
				$this->db->update('i_user_activity',$data);
			}

			$data2 = array(
				'iual_a_id' => $aid,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'add'
			);
			$this->db->insert('i_u_a_log',$data2);

			for ($i=0; $i < count($td); $i++) {
				$data1 = array(
					'iuat_a_id' => $aid,
					'iuat_title' => $td[$i]['title'],
					'iuat_status' => $td[$i]['status'],
					'iuat_owner' => $oid
				);
				$this->db->insert('i_u_a_todo',$data1);
			}

			for ($j=0; $j < count($tags) ; $j++) {
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data2 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data2);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data3 = array(
					'iuat_a_id' => $aid,
					'iuat_t_id' => $tid,
					'iuat_owner'=>$oid
				);
				$this->db->insert('i_u_activity_tags', $data3);

				$data5 = array(
					'iet_type_id' => $aid,
					'iet_type' => 'activity',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => 0
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if ($a_flg == 'true') {
				redirect(base_url().'Home/activity_mail/'.$aid.'/'.$code);
			}else{
				echo "true";	
			}

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_get_parent($code,$pid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$p=$pid;
			$gid = $sess_data['gid'];

			do{
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = $p");
				$result = $query->result();
				$p = $result[0]->iua_p_activity;
				$pid.= ','.$result[0]->iua_p_activity;
			}while($p != 0);

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id IN($pid)");
			$data['activity_s']=$query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_a_id IN($pid)");
			$data['todo_s']=$query->result();

			print_r(json_encode($data));
			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_update_todo($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$data1 = array(
				'iuat_status' => $this->input->post('s')
			);
			$this->db->where(array(	'iuat_id' => $this->input->post('i'), 'iuat_owner' => $oid));
			$this->db->update('i_u_a_todo',$data1);
		
			echo "true";

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_resheduled($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			
			$data1 = array(
				'iua_date' => $this->input->post('r_date'),
				'iua_status' => "reschedule",
				'iua_modify' =>$dt,
				'iua_modified_by' => $uid
			);
			$this->db->where(array(	'iua_id' => $this->input->post('id')));
			$this->db->update('i_user_activity',$data1);

			$data2 = array(
				'iual_a_id' => $this->input->post('id'),
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'reschedule',
				'iual_comment' => $this->input->post('cmt')
			);
			$this->db->insert('i_u_a_log',$data2);
		
			echo "true";

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_status_update($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d H:i:s');

			$s = $this->input->post('s');
			$status = 'pending';
			if ($s=='d') {
				$status='done';
			} else if($s=='c') {
				$status='cancel';
			} else if($s == 'p'){
				$status = 'progress';
			}
			$aid = $this->input->post('i');
			$data1 = array(
				'iua_status' => $status,
				'iua_modify' => $dt,
				'iua_modified_by' => $uid
			);
			$this->db->where(array('iua_id' => $aid));
			$this->db->update('i_user_activity',$data1);
			$cmt = $this->input->post('cmt');
			if ($cmt == null || $cmt == 'null') {
				$cmt = $status;
			}

			$data2 = array(
				'iual_a_id' => $aid,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => $status,
				'iual_comment' => $cmt
			);
			$this->db->insert('i_u_a_log',$data2);

			$query = $this->db->query("SELECT * from i_user_activity WHERE iua_id = '$aid' ");
			$result = $query->result();
			if ($result[0]->iua_type == 'project') {
				$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_aid = '$aid' ");
				$result = $query->result();
				$tid = $result[0]->iextpt_id;
				$pid = $result[0]->iextpt_p_id;
				$grp = $result[0]->iextpt_tg_id;
				$data = array(
					'iextptc_p_id' => $pid,
					'iextptc_tg_id' => $grp,
					'iextptc_t_id' => $tid,
					'iextptc_comment' => $cmt,
					'iextptc_created' => $dt,
					'iextptc_owner' => $oid,
					'iextptc_created_by' => $uid
				);
				$this->db->insert('i_ext_pro_task_comments',$data);
			}

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_activity_comments($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$aid = $this->input->post('id');
			$p_note = $this->input->post('p_note');
			$dt = date('Y-m-d H:i:s');
			
			$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_aid = '$aid' AND iextpt_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$tid = $result[0]->iextpt_id;
				$pid = $result[0]->iextpt_p_id;
				$grp = $result[0]->iextpt_tg_id;
			}
			$data = array(
				'iextptc_p_id' => $pid,
				'iextptc_tg_id' => $grp,
				'iextptc_t_id' => $tid,
				'iextptc_comment' => $p_note,
				'iextptc_created' => $dt,
				'iextptc_owner' => $oid,
				'iextptc_created_by' => $uid
			);
			$this->db->insert('i_ext_pro_task_comments',$data);

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function activity_filters($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$date = $this->input->post('f_date');
			$t_date = $this->input->post('t_date');
			$status = $this->input->post('f_status');
			$title = $this->input->post('f_title');
			$todo = $this->input->post('f_todo');
			$place = $this->input->post('f_place');
			$cat = $this->input->post('f_cat');
			$person = $this->input->post('f_person');
			$property = [];

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id= '$gid' AND iua_type in('Event','Reminder') UNION SELECT * FROM i_user_activity WHERE iua_g_id= '$gid' AND iua_type in('Event','Reminder') and iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
			$result = $query->result();
			for ($i=0; $i <count($result) ; $i++) {
				array_push($property,$result[$i]->iua_id);
			}

			$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
			$result = $query->result();
			for ($i=0; $i <count($result) ; $i++) {
				array_push($property,$result[$i]->iextpt_aid);
			}

			$this->db->select('*');
			$this->db->from('i_user_activity');
			if ($date != '' && $t_date != '') {
				$this->db->where('iua_date >=', $date);
				$this->db->where('iua_date <=', $t_date);
			}
			if ($status != 'null') {
				$this->db->where('iua_status', $status);
			}
			if ($title != 'null') {
				$this->db->like('iua_title',$title , 'both');
			}
			if ($place != 'null') {
				$this->db->where('iua_place', $place);
			}
			if ($cat != 'null') {
				$this->db->like('iua_categorise',$cat , 'both');
			}
			for ($i=0; $i <count($property) ; $i++) { 
				$this->db->where_in('iua_id', $property);
			}

			$query = $this->db->get();
			$data['activity_f'] = $query->result();
			$result = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_edit($id,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$note = $this->input->post('note');
			$a_flg = $this->input->post('a_mail');
			$person = $this->input->post('a_person');

            $tags = $this->input->post('a_tags');

			$td = $this->input->post('a_to_do'); $flg=0;
			if (count($td) > 0) {
				$flg=1;
			}

			$s_func = $this->input->post('a_func_short');
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_name = '$s_func'");
			$result = $query->result();
			if (count($result) > 0) {
				$fid = $result[0]->ims_function;
				$mid = $result[0]->ims_m_id;
			}else{
				$fid = 0;
				$mid = 0;
			}

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$id'");
			$result = $query->result();
			$a_type = $result[0]->iua_type;
			if ($a_type == 'note') {
				$data = array(
					'iua_title' => $this->input->post('a_title'),
					'iua_place' => $this->input->post('a_place'),
					'iua_to_do' => $flg,
					'iua_categorise' => $this->input->post('p_cat'),
					'iua_p_activity' => $result[0]->iua_p_activity,
					'iua_modify' => $dt,
					'iua_modified_by' =>$uid,
					'iua_shortcuts' => $fid,
					'iua_m_shortcuts' => $mid,
					'iua_color' => $this->input->post('a_color')
				);
			}else{
				$data = array(
					'iua_title' => $this->input->post('a_title'),
					'iua_date' => $this->input->post('a_date'),
					'iua_place' => $this->input->post('a_place'),
					'iua_to_do' => $flg,
					'iua_categorise' => $this->input->post('a_cat'),
					'iua_p_activity' => $result[0]->iua_p_activity,
					'iua_modify' => $dt,
					'iua_modified_by' =>$uid,
					'iua_shortcuts' => $fid,
					'iua_m_shortcuts' => $mid,
					'iua_color' => $this->input->post('a_color'),
					'iua_end_date' => $this->input->post('e_date')
				);
			}
			$this->db->where(array('iua_id'=>$id));
			$this->db->update('i_user_activity',$data);

			$data = array('iuat_a_id' =>$id, 'iuat_owner'=> $oid);
			$this->db->where($data);
			$this->db->delete('i_u_a_todo');

			$data = array('iuap_a_id' =>$id, 'iuap_owner'=> $oid);
			$this->db->where($data);
			$this->db->delete('i_u_a_person');

			$data = array('in_type_id' =>$id, 'in_owner'=> $oid);
			$this->db->where($data);
			$this->db->delete('i_notifications');
			
			for ($i=0; $i <count($person) ; $i++) { 
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
				$result = $query->result();

				$data = array(
					'iuap_a_id' => $id,
					'iuap_p_id' => $result[0]->ic_id,
					'iuap_owner'=> $oid
				);
				$this->db->insert('i_u_a_person',$data);

				$data1 = array(
					'in_type_id' => $id, 
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $result[0]->ic_id,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt
				);
				$this->db->insert('i_notifications',$data1);
			}

			$str1 = preg_replace('/\s+/', ' ', trim($note));
			if ($str1 != '') {
				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
				if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				$txt_file = $id.'.txt';
				file_put_contents($path.$txt_file, $note);

				$data = array(
					'iua_note' => $txt_file
				);
				$this->db->where('iua_id',$id);
				$this->db->update('i_user_activity',$data);
			}

			$data2 = array(
				'iual_a_id' => $id,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'update'
			);
			$this->db->insert('i_u_a_log',$data2);
			
			for ($i=0; $i < count($td); $i++) { 
				$data1 = array(
					'iuat_a_id' => $id,
					'iuat_title' => $td[$i]['title'],
					'iuat_status' => $td[$i]['status'],
					'iuat_owner' => $oid
				);
				$this->db->insert('i_u_a_todo',$data1);
			}

			$this->db->WHERE('iuat_a_id',$id);
			$this->db->delete('i_u_activity_tags');

			$this->db->WHERE('iet_type_id',$id);
			$this->db->delete('i_ext_tags');

			for ($j=0; $j < count($tags) ; $j++) {
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data2 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data2);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data3 = array(
					'iuat_a_id' => $id,
					'iuat_t_id' => $tid,
					'iuat_owner'=>$oid
				);
				$this->db->insert('i_u_activity_tags', $data3);

				$data5 = array(
					'iet_type_id' => $id,
					'iet_type' => 'activity',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => 0
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if ($a_flg == 'true') {
				redirect(base_url().'Home/activity_mail/'.$aid);	
			}else{
				echo "true";
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_delete($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			
			$data = array(
                "iua_id" => $id,
                "iua_owner" => $oid
                );
            $this->db->where($data);
            $this->db->delete("i_user_activity");

            $this->db->where(array('iextpt_aid'=>$id,'iextpt_owner'=>$oid));
			$this->db->delete('i_ext_pro_task');

            $data1 = array(
                "iuat_a_id" => $id,
                "iuat_owner" => $oid
                );
            $this->db->where($data1);
            $this->db->delete("i_u_a_todo");

            $data2 = array(
				'iual_a_id' => $id,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'delete'
			);
			$this->db->insert('i_u_a_log',$data2);
			
			redirect(base_url().'Home/index/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tp($l,$g){

		$geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($l).','.trim($g).'&sensor=false'); 
        $output = json_decode($geocodeFromLatLong);
        $status=  $output->status;

        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
		echo $address;
	}

	public function folderSize (){
		$filename ='';
		$f = $this->config->item('document_rt').'assets/uploads/6';
	    $io = popen ( '/usr/bin/du -sk ' . $f, 'r' );
	    $size = fgets ( $io, 4096);
	    $size = substr ( $size, 0, strpos ( $size, "\t" ) );
	    pclose ( $io );
	    echo 'Directory: ' . $f . ' => Size: ' . $size.'<br>';

	    if (is_dir($f)){
		  if ($dh = opendir($f)){
		    while (($file = readdir($dh)) !== false){
		      echo "<br>filename:" . $file . "<br>";
		      // $filename .= $file;  
		    }
		    closedir($dh);
		  }
		}
		echo $filename;

		$files2 = scandir($f);
		print_r($files2);
	}

	public function hello($a){
		echo "hello ".$a;
	}

################### Explore Collection ##############
	public function collection($inid=0,$code,$add_on = 0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;

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
			$query = $this->db->query("SELECT * FROM i_explore_collection");
			$data['collection'] = $query->result();

			$ref_code = $sess_data['user_details'][0]->iud_ref_code;
			$data['credit_amt'] = $sess_data['user_details'][0]->i_credit_amount;
			$data['ref_code'] = 'null';
			$data['renew_ref_code'] = 'null';
			$query = $this->db->query("SELECT * FROM i_users as a LEFT JOIN i_user_scheme as b on a.i_user_scheme = b.iush_id LEFT JOIN i_u_scheme_parameter as c on b.iush_id = c.iushp_sid WHERE i_user_code = '$ref_code' ");
			$result = $query->result();
			$data['ref_disc'] = $result;
			for ($i=0; $i < count($result) ; $i++) {
				if ($result[$i]->iush_limit == '-1') {
					if ($result[$i]->iush_time == 'one_time') {
						$query = $this->db->query("SELECT count(iutxn_ref_code) as code_count FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' AND iutxn_uid = '$uid' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
						$ref_count = $query->result();
						if (count($ref_count) > 0 ) {
							if($ref_count[0]->code_count <= 1 ){
								$data['ref_code'] = $ref_code;
								$data['renew_ref_code'] = 'null';
							}
						}else{
							$data['ref_code'] = $ref_code;
							$data['renew_ref_code'] = 'null';
						}
					} else if($result[$i]->iush_time == 'every_renewal') {
						$data['renew_ref_code'] = $ref_code;
						$data['ref_code'] = 'null';
					} else if($result[$i]->iush_time == 'every_txn') {
						$data['renew_ref_code'] = $ref_code;
						$data['ref_code'] = $ref_code;
					}
				}else if ($result[$i]->iush_limit > 0) {
					$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
					$user_count = $query->result();
					if (count($user_count) < $result[$i]->iush_limit ) {
						if ($result[$i]->iush_time == 'one_time') {
							$query = $this->db->query("SELECT count(iutxn_ref_code) as code_count FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' AND iutxn_uid = '$uid' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
							$ref_count = $query->result();
							if (count($ref_count) > 0 ) {
								if($ref_count[0]->code_count <= 1 ){
									$data['ref_code'] = $ref_code;
									$data['renew_ref_code'] = 'null';
								}
							}else{
								$data['ref_code'] = $ref_code;
								$data['renew_ref_code'] = 'null';
							}
						} else if($result[$i]->iush_time == 'every_renewal') {
							$data['renew_ref_code'] = $ref_code;
							$data['ref_code'] = 'null';
						} else if($result[$i]->iush_time == 'every_txn') {
							$data['renew_ref_code'] = $ref_code;
							$data['ref_code'] = $ref_code;
						}
					}else{
						$usr_flg = 'false';
						$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
						$ref_count = $query->result();
						for ($ij=0; $ij < count($ref_count) ; $ij++) { 
							if ($ref_count[$ij]->iutxn_uid == $uid ) {
								$usr_flg = 'true';
							}
						}
						if ($result[$i]->iush_time == 'every_renewal') {
							if ($usr_flg == 'true' ) {
								$data['renew_ref_code'] = $ref_code;
								$data['ref_code'] = 'null';
							}
						}else if ($result[$i]->iush_time == 'every_txn') {
							if ($usr_flg == 'true' ) {
								$data['renew_ref_code'] = $ref_code;
								$data['ref_code'] = $ref_code;
							}
						}
					}
				}else{
					$data['ref_code'] = 'null';
					$data['renew_ref_code'] = 'null';
				}
			}

			$query = $this->db->query("SELECT * FROM i_users as a LEFT JOIN i_u_details as b on a.i_uid=b.iud_u_id WHERE i_uid = '$uid'");
			$result = $query->result();
			$data['uname'] = $result[0]->iud_name;
			$data['umail'] = $result[0]->iud_email;
			$data['uadd'] = $result[0]->iud_address;
			$data['ucont'] = $result[0]->iud_phone;

			$data['p_key'] = $this->config->item('p_key');
			$data['p_secret'] = $this->config->item('p_secret');

			$query = $this->db->query("SELECT * FROM i_portal_price");
			$data['portal'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_modules as a LEFT JOIN i_m_files as b on a.im_id = b.imf_mid WHERE a.im_publish =1  AND a.im_id  NOT IN(SELECT ium_m_id FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '0' AND ium_status IN('active','suspend')) GROUP BY im_id ");
			$data['col_module'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_modules  as a left join i_modules as b on a.ium_m_id=b.im_id WHERE ium_u_id = '$oid' AND ium_gid = '0' AND ium_status IN('active','suspend') GROUP BY im_id ");
			$data['my_module'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
			$result = $query->result();
			$data['user_data'] = $result;

			if ($inid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_id = '$inid'");
				$data['txn'] = $query->result();
			}

			if ($add_on != 0 ) {
				$data['cart'] = 'show';
			}

			$ert['mod'] = $sess_data['user_mod'];
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['gid'] = $gid;
			$ert['mid'] = 0;
			$ert['mname'] = '';
			$ert['code'] = $code;
			$ert['title'] = "Explore Collection";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('home/collection',$data);
			$this->load->view('home/search_modal');

		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function get_collection_details($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$upload_dir = $this->config->item('document_rt')."assets/data/portal/explore_collection/";

			$query = $this->db->query("SELECT * FROM i_explore_collection WHERE iec_id = '$id'");
			$result = $query->result();
			$data['id'] = $result[0]->iec_id;
			$data['img'] = $result[0]->iec_timestamp;
			$data['title'] = $result[0]->iec_title;
			$file_name = $result[0]->iec_file;
			if (file_exists($upload_dir.$file_name)) {
				$data['file_data'] =  file_get_contents($upload_dir.$file_name);
			}else{
				$data['file_data'] =  '';
			}

			$query = $this->db->query("SELECT * FROM i_explore_collection_module as b LEFT JOIN i_modules as c on b.iecm_mid=c.im_id WHERE b.iecm_ec_id='$id'");
			$data['module'] = $query->result();

			print_r(json_encode($data));

		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function get_collection_cat($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_explore_collection GROUP BY iec_cat1");
			$data['cat1'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_collection_subcat($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$cat1 = $this->input->post('cat1');
			$query = $this->db->query("SELECT * FROM i_explore_collection WHERE iec_cat1 = '$cat1' GROUP BY iec_cat2");
			$data['cat2'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_explore_collection WHERE iec_cat1 = '$cat1'");
			$data['collection'] = $query->result();
			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_collection_subcat2($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$cat1 = $this->input->post('cat1');
			$cat2 = $this->input->post('cat2');

			$query = $this->db->query("SELECT * FROM i_explore_collection WHERE iec_cat1 = '$cat1' AND iec_cat2 = '$cat2' ");
			$data['collection'] = $query->result();
			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	// public function collection_mail($id){
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $oid;
	// 		$data['uid'] = $uid;

	// 		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$uid'");
	// 		$result1 = $query->result();
	// 		$u_name = $result1[0]->iud_name;

	// 		$query = $this->db->query("SELECT * FROM i_explore_collection WHERE iec_id = '$id'");
	// 		$result = $query->result();

	// 		$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$uid'");
	// 		$result3=$query3->result();

	// 		$subject = 'Explore Collection : '.$u_name;

	// 		$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head><body>Dear DaiFunc Team,<br><br>Please find my request and kindly acknowledge the same.<br><br>Regards,<br>'.$u_name.'</body></html>';
	// 		try {
	// 			$config = array();
	// 	        $config['useragent'] = "CodeIgniter";
	// 	        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	// 	        $config['protocol'] = "smtp";
	// 	        $config['smtp_host'] = $result3[0]->iumail_domain;
	// 	        $config['smtp_user'] = $result3[0]->iumail_mail;
	// 	        $config['smtp_pass'] = $result3[0]->iumail_password;
	// 	        $config['smtp_port'] = $result3[0]->iumail_port;
	// 	        $config['mailtype'] = 'html';
	// 	        $config['charset'] = 'utf-8';
	// 	        $config['newline'] = "\r\n";
	// 	        $config['wordwrap'] = TRUE;

	// 			$this->load->library('email');
	// 			$this->email->initialize($config);
	// 			$this->email->from($result3[0]->iumail_mail);
	// 			$this->email->to('hello@evomata.com');
	// 			$this->email->subject($subject);
	// 			$this->email->message($body);
	// 			$this->email->send();
	//             echo "true";
	// 		// 			echo $this->email->print_debugger();
	// 		} catch (Exception $e) {
	// 			echo "Exception: ".$e;
	// 		}
	// 	}else{
	// 		redirect(base_url().'account/login');
	// 	}	
	// }

	public function add_to_cart($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid = '$uid'");
			$result = $query->result();
			if (count($result) > 0) {
				$inid = $result[0]->iuc_id;
			}else{
				$data = array(
					'iuc_uid' => $uid,
					'iuc_group' => 0,
					'iuc_storage' => 0
				);
				$this->db->insert('i_users_cart',$data);
				$inid = $this->db->insert_id();
			}
			
			$query = $this->db->query("SELECT * FROM i_explore_collection_module WHERE iecm_ec_id = '$id'");
			$result = $query->result();

			for ($i=0; $i <count($result) ; $i++) { 
				$mid = $result[$i]->iecm_mid;
				$query = $this->db->query("SELECT * FROM i_users_cart_modules WHERE iucm_mid = '$mid' AND iucm_iuc_id IN (SELECT iuc_id FROM i_users_cart WHERE iuc_uid = '$uid') ");
				$result1 = $query->result();
				if (count($result1) <= 0) {
					$data = array(
						'iucm_iuc_id' => $inid,
						'iucm_mid' => $mid,
						'iucm_users' => 1,
						'iucm_status' => 'unpaid',
						'iucm_sub_month' => 1
					);
					$this->db->insert('i_users_cart_modules',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_users_cart_modules WHERE iucm_status = 'unpaid' AND iucm_iuc_id IN(SELECT iuc_id FROM i_users_cart WHERE iuc_uid = '$uid')");
			$result = $query->result();
			$count = count($result);

			echo $count;
		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function delete_module_cart($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$this->db->where(array('iucm_id'=>$id));
			$this->db->delete('i_users_cart_modules');
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_module_cart($code,$mid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid = '$uid'");
			$result = $query->result();

			if (count($result) > 0) {
				$inid = $result[0]->iuc_id;
			}else{
				$data = array(
					'iuc_uid' => $uid,
					'iuc_group' => 0,
					'iuc_storage' => 0
				);
				$this->db->insert('i_users_cart',$data);
				$inid = $this->db->insert_id();
			}

			$query = $this->db->query("SELECT * from i_users_cart_modules WHERE iucm_mid = '$mid' AND iucm_iuc_id IN(SELECT iuc_id FROM i_users_cart WHERE iuc_uid = '$uid')");
			$result = $query->result();
			if (count($result) > 0) {
				echo "exist";
			}else{
				$data = array(
					'iucm_iuc_id' => $inid,
					'iucm_mid' => $mid,
					'iucm_users' => 1,
					'iucm_status' => 'unpaid',
					'iucm_sub_month' => 1
				);
				$this->db->insert('i_users_cart_modules',$data);
				echo "true";
			}
		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function get_my_cart($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			$query = $this->db->query("SELECT * FROM i_users_cart_modules WHERE iucm_status IN ('unpaid','add_on') AND iucm_iuc_id IN(SELECT iuc_id FROM i_users_cart WHERE iuc_uid = '$uid')");
			$result = $query->result();

			echo count($result);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_cart_details($code,$type=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;

			if ($type == 'renew') {
				$query = $this->db->query("SELECT * FROM i_users_cart as a LEFT JOIN i_users_cart_modules as b on a.iuc_id=b.iucm_iuc_id LEFT JOIN i_modules as c on b.iucm_mid=c.im_id WHERE iuc_uid = '$uid' AND iucm_status IN ('paid')");
				$result = $query->result();
				$data['cart_details'] = $result;
				$id_arr = [];
				if (count($result) > 0) {
					$data['sub'] = $result[0]->iucm_sub_month;
					for ($i=0; $i < count($result) ; $i++) { 
						array_push($id_arr , $result[$i]->iucm_txn_id);
					}
				}else{
					$data['sub'] = 0;
					$inid = 0;
					$data['group'] = 0;
					$data['storage'] = 0;
				}
				if (count($id_arr) > 0) {
					$inid = implode(',', $id_arr);	
				}else{
					$inid = 0;
				}
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' ");
				$result1 = $query->result();
			 	$data['group'] = count($result1);

			 	$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
				$result1 = $query->result();
				$data['storage'] = ($result1[0]->i_storage/1000);

				print_r(json_encode($data));
			}else{
				$query = $this->db->query("SELECT * FROM i_users_cart as a LEFT JOIN i_users_cart_modules as b on a.iuc_id=b.iucm_iuc_id LEFT JOIN i_modules as c on b.iucm_mid=c.im_id WHERE iuc_uid = '$uid' AND iucm_status IN ('unpaid','add_on')");
				$result = $query->result();
				$data['cart_details'] = $result;
				if (count($result) > 0) {
				 	$data['group'] = $result[0]->iuc_group;
					$data['storage'] = $result[0]->iuc_storage;
				}else{
					$data['group'] = 0;
					$data['storage'] = 0;
				}
				print_r(json_encode($data));
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_renew_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['u_list'] = [];
			$data['mod_list'] = [];

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' ORDER BY iug_id DESC");
			$result = $query->result();
			$data['grp_list'] = $result;
			$data['grp_count'] = count($result);

			$query = $this->db->query("SELECT * FROM i_user_group ORDER BY iug_id DESC");
			$result = $query->result();
			if (count($result) > 0) {
				$data['max_gid'] = $result[0]->iug_id;
			}else{
				$data['max_gid'] = 0;
			}

			$query = $this->db->query("SELECT * FROM i_users ORDER BY i_uid DESC");
			$result = $query->result();
			if (count($result) > 0 ) {
				$data['max_uid'] = $result[0]->i_uid;
			}else{
				$data['max_uid'] = 0;
			}

			$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_created_by = '$oid' AND ium_gid != '0' ORDER BY ium_u_id DESC");
			$result = $query->result();
			if (count($result) > 0 ) {
				$end_sub = $result[0]->ium_subscription_end;
			}else{
				$end_sub = 0;
			}

			$today = date('y-m-d');

			$ts1 = strtotime($end_sub);
			$ts2 = strtotime($today);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			for ($i=0; $i < count($result) ; $i++) {
				$ium_uid = $result[$i]->ium_u_id;
				$query = $this->db->query("SELECT * from i_customers WHERE ic_uid = '$ium_uid' AND ic_owner = '$oid' ");
				$res1 = $query->result();
				$c_name = '';
				if (count($res1) > 0 ) {
					$c_name = $res1[0]->ic_name;
				}else{
					$query = $this->db->query("SELECT * from i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE icbd_value = '$ium_uid' AND ic_owner = '$oid' ");
					$res2 = $query->result();
					if (count($res2) > 0 ) {
						$c_name = $res2[0]->ic_name;
					}
				}

				array_push($data['u_list'], array('uid' => $result[$i]->ium_u_id , 'uname' => $c_name , 'gid' => $result[$i]->ium_gid , 'mid' => $result[$i]->ium_m_id ,'admin' => $result[$i]->ium_admin ));
				
				if ($i == 0) {
					array_push($data['mod_list'], array('mid' => $result[$i]->ium_m_id , 'count' => 1));
				}else{
					$flg = 'false';
					for ($ij=0; $ij < count($data['mod_list']) ; $ij++) {
						if ($data['mod_list'][$ij]['mid'] == $result[$i]->ium_m_id) {
							$data['mod_list'][$ij]['count'] = $data['mod_list'][$ij]['count']+1;
							$flg = 'true';
						}
					}
					if ($flg == 'false') {
						array_push($data['mod_list'], array('mid' => $result[$i]->ium_m_id , 'count' => 1));
					}
				}
			}
			$data['sub_bal'] = $diff;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function change_ref_code($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$ref_code = $this->input->post('ref_code');
			$data['ref_disc'] = '';

			$query = $this->db->query("SELECT * FROM i_user_scheme as b LEFT JOIN i_u_scheme_parameter as c on b.iush_id = c.iushp_sid WHERE iush_name = '$ref_code' ");
			$result = $query->result();
			$ref_flg = 'false';
			$renew_ref_flg = 'false';

			for ($i=0; $i < count($result) ; $i++) {
				if ($result[$i]->iush_limit == '-1') {
					if ($result[$i]->iush_time == 'one_time') {
						$query = $this->db->query("SELECT count(iutxn_ref_code) as code_count FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' AND iutxn_uid = '$uid' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
						$ref_count = $query->result();
						if (count($ref_count) > 0 ) {
							if($ref_count[0]->code_count <= 1 ){
								// $data['ref_code'] = $ref_code;
								// $data['renew_ref_code'] = 'null';
								$ref_flg = 'true';
							}
						}else{
							$ref_flg = 'true';
							// $data['ref_code'] = $ref_code;
							// $data['renew_ref_code'] = 'null';
						}
					} else if($result[$i]->iush_time == 'every_renewal') {
						// $data['renew_ref_code'] = $ref_code;
						// $data['ref_code'] = 'null';
						$renew_ref_flg = 'true';
					} else if($result[$i]->iush_time == 'every_txn') {
						// $data['renew_ref_code'] = $ref_code;
						// $data['ref_code'] = $ref_code;
						$renew_ref_flg = 'true';
						$ref_flg = 'true';
					}
				}else if ($result[$i]->iush_limit > 0) {
					$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
					$user_count = $query->result();
					if (count($user_count) < $result[$i]->iush_limit ) {
						if ($result[$i]->iush_time == 'one_time') {
							$query = $this->db->query("SELECT count(iutxn_ref_code) as code_count FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' AND iutxn_uid = '$uid' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
							$ref_count = $query->result();
							if (count($ref_count) > 0 ) {
								if($ref_count[0]->code_count <= 1 ){
									// $data['ref_code'] = $ref_code;
									// $data['renew_ref_code'] = 'null';
									$ref_flg = 'true';
								}
							}else{
								$ref_flg = 'true';
								// $data['ref_code'] = $ref_code;
								// $data['renew_ref_code'] = 'null';
							}
						} else if($result[$i]->iush_time == 'every_renewal') {
							$renew_ref_flg = 'true';
							// $data['renew_ref_code'] = $ref_code;
							// $data['ref_code'] = 'null';
						} else if($result[$i]->iush_time == 'every_txn') {
							$renew_ref_flg = 'true';
							$ref_flg = 'true';
						}
					}else{
						$usr_flg = 'false';
						$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_ref_code = '$ref_code' GROUP BY iutxn_uid ORDER BY iutxn_date ASC ");
						$ref_count = $query->result();
						for ($ij=0; $ij < count($ref_count) ; $ij++) { 
							if ($ref_count[$ij]->iutxn_uid == $uid ) {
								$usr_flg = 'true';
							}
						}
						if ($result[$i]->iush_time == 'every_renewal') {
							if ($usr_flg == 'true' ) {
								// $data['renew_ref_code'] = $ref_code;
								// $data['ref_code'] = 'null';
								$renew_ref_flg = 'true';
							}
						}else if ($result[$i]->iush_time == 'every_txn') {
							if ($usr_flg == 'true' ) {
								$renew_ref_flg = 'true';
								$ref_flg = 'true';
							}
						}
					}
				}else{
					$renew_ref_flg = 'false';
					$ref_flg = 'false';
				}
			}

			if ($ref_flg == 'true') {
				$query1 = $this->db->query("SELECT * FROM i_user_scheme as b LEFT JOIN i_u_scheme_parameter as c on b.iush_id = c.iushp_sid WHERE iush_name = '$ref_code' ");
				$result1 = $query1->result();
				$data['ref_disc'] = $result1;
			}else{
				$query = $this->db->query("SELECT * FROM i_users as a LEFT JOIN i_user_scheme as b on a.i_user_scheme = b.iush_id LEFT JOIN i_u_scheme_parameter as c on b.iush_id = c.iushp_sid WHERE i_user_code = '$ref_code' ");
				$result = $query->result();
				$data['ref_disc'] = $result;
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function send_payment_mail($code,$txn_type){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			$subscription = $this->input->post('subscription');
			$group = $this->input->post('group');
			$storage = $this->input->post('storage');
			$payment_id = $this->input->post('payment_id');
			$amount = $this->input->post('amount');
			$ref_code = $this->input->post('ref_code');
			$ref_disc = $this->input->post('ref_disc');
			$disc_amount = $this->input->post('disc_amt');
			$cart = $this->input->post('cart');
			$credit_amt = $this->input->post('credit_amt');

			if ($amount = 0 ) {
				$credit_amt = $credit_amt - $amount;
				if ($credit_amt <= 0) {
					$credit_amt = 0;
				}
			}

			$inid = 0 ;
			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$email = $result[0]->i_uname;
			}
			if ($payment_id == '0') {
				$data = array(
					  'iutxn_uid' => $uid,
					  'iutxn_payment_id' => '0',
					  'iutxn_timestamp' => '0',
					  'iutxn_group' => $group,
					  'iutxn_group_month' => $subscription,
					  'iutxn_storage' => $storage,
					  'iutxn_storage_month' => $subscription,
					  'iutxn_date' => $dt,
					  'iutxn_entity' => 'payment',
					  'iutxn_amount' => $amount,
					  'iutxn_currency' => 'INR',
					  'iutxn_status' => 'uncaptured',
					  'iutxn_method' => 'cheque',
					  'iutxn_amount_refunded' => '0',
					  'iutxn_captured' => '0',
					  'iutxn_description' => 'DaiFunc cheque',
					  'iutxn_email' => $email,
					  'iutxn_created_at' => $dt_str,
					  'iutxn_ref_code' => $ref_code,
					  'iutxn_discount_amount' => $disc_amount,
					  'iutxn_txn_type' => $txn_type,
					  'iutxn_credit_amount' => $credit_amt
				);
				$this->db->insert('i_user_transaction',$data);
				$inid = $this->db->insert_id();
			}else{
				$api = new RazorpayApi($this->config->item('p_key'), $this->config->item('p_secret'));
				$payment  = $api->payment->fetch($payment_id)->capture(array('amount'=>$amount));
				$dt1=date_create();
				$dt_str = date_timestamp_get($dt1);
				$timestamp = $uid.$dt_str;
				if ($payment->amount == $amount) {
					$data = array(
						  'iutxn_uid' => $uid,
						  'iutxn_payment_id' => $payment_id,
						  'iutxn_timestamp' => $timestamp,
						  'iutxn_group' => $group,
						  'iutxn_group_month' => $subscription,
						  'iutxn_storage' => $storage,
						  'iutxn_storage_month' => $subscription,
						  'iutxn_date' => $dt,
						  'iutxn_entity' => $payment->entity,
						  'iutxn_amount' => $payment->amount,
						  'iutxn_currency' => $payment->currency,
						  'iutxn_status' => $payment->status,
						  'iutxn_order_id' => $payment->order_id,
						  'iutxn_invoice_id' => $payment->invoice_id,
						  'iutxn_international' => $payment->international,
						  'iutxn_method' => $payment->method,
						  'iutxn_amount_refunded' => $payment->amount_refunded,
						  'iutxn_refund_status' => $payment->refund_status,
						  'iutxn_captured' => $payment->captured,
						  'iutxn_description' => $payment->description,
						  'iutxn_card_id' => $payment->card_id,
						  'iutxn_bank' => $payment->bank,
						  'iutxn_wallet' => $payment->wallet,
						  'iutxn_vpa' => $payment->vpa,
						  'iutxn_email' => $payment->email,
						  'iutxn_contact' => $payment->contact,
						  // 'iutxn_notes' => $payment->notes,
						  // 'iutxn_address' => $payment->address,
						  'iutxn_fee' => $payment->fee,
						  'iutxn_tax' => $payment->tax,
						  'iutxn_error_code' => $payment->error_code,
						  'iutxn_error_description' => $payment->error_description,
						  'iutxn_created_at' => $payment->created_at,
						  'iutxn_ref_code' => $ref_code,
						  'iutxn_discount_amount' => $disc_amount,
						  'iutxn_txn_type' => $txn_type,
						  'iutxn_credit_amount' => $credit_amt
					);
					$this->db->insert('i_user_transaction',$data);
					$inid = $this->db->insert_id();
				}
			}

			for ($i=0; $i < count($ref_disc) ; $i++) {
				if ($ref_disc[$i]['for'] == 'referrer' ) {
					$amt = ($amount / 100 ) + $disc_amount;
					if ($ref_disc[$i]['type'] == 'percentage' ) {
						$d_amt = $amt * ( $ref_disc[$i]['amount'] / 100 );
					}else{
						$d_amt = $amt - $ref_disc[$i]['amount'];
					}
					$data = array(
						'iushtxn_sid' => $ref_disc[$i]['id'],
						'iushtxn_uid' => $uid,
						'iushtxn_amount' => $d_amt,
						'iushtxn_status' => 'unpaid',
						'iushtxn_txn_id' => $inid,
						'iushtxn_ref_code' => $ref_code,
						'iushtxn_created' => $dt
					);
					$this->db->insert('i_user_scheme_txn',$data);
					$sid = $this->db->insert_id();
				}
			}

			$amount = intval($amount)/100 ;
			$pid = 'N/A';
			$property = [];
			for ($i=0; $i < count($cart) ; $i++) { 
				$mid = $cart[$i]['id'];
				$query = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$mid' ");
				$result1 = $query->result();
				if (count($result1) > 0 ) {
					array_push($property,$result1[0]->im_name);	
				}
			}
			if (count($property) > 0 ) {
				$pid = implode(',', $property);
			}
			if ($inid != 0) {
				$subject = "Payment Successful";
				$body = '<html><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td,th {border: 1px solid #dddddd;text-align: left;padding: 8px;}h3{font-weight: normal;}</style><body><div style="text-align: center;"><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;padding:20px;"><h1 style="height: 30px;font-weight: bold;">DAIFUNC</h1><h1 style="padding:20px;color: green;">Your payment succesfully done.</h1></div><div><h3>Your payment will be received by '.date('M d, Y').'.</div><div><h3>Payment Details ..</h3><table style="width:100%;"><tbody><tr><td style="width:30%;">Amount</td><td style="width:70%;">'.$amount.'</td></tr><tr><td style="width:30%;">Payment ID</td><td style="width:70%;">'.$payment_id.'</td></tr><tr><td style="width:30%;">Module</td><td style="width:70%;">'.$pid.'</td></tr><tr><td style="width:30%;">Group</td><td style="width:70%;">'.$group.'</td></tr><tr><td style="width:30%;">Storage</td><td style="width:70%;">'.$storage.'</td></tr></tbody></table><br><h3>Thank you for connecting with DAIFUNC .</h3></div><div style="text-align: center;"><p style="font-size: 0.8em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></div></body></html>';
				
				$temp = $this->Mail->send_daifunc_mail($subject,$email,null,$body,$code);
			}
			// echo $inid;
			$data['inid'] = $inid;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function module_allot($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			$subscription = $this->input->post('subscription');
			$group = $this->input->post('group');
			$storage = $this->input->post('storage');
			$amount = $this->input->post('amount');
			$ref_code = $this->input->post('ref_code');
			$ref_disc = $this->input->post('ref_disc');
			$disc_amount = $this->input->post('disc_amt');
			$cart = $this->input->post('cart');
			$group_arr = $this->input->post('group_arr');
			$remain_cost = $this->input->post('remain_cost');

			$this->db->WHERE('iugs_uid',$uid);
			$this->db->delete('i_u_group_subscription');

			$this->db->WHERE('iuss_uid',$uid);
			$this->db->delete('i_u_storage_subscription');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$result = $query->result();
			$credit = $result[0]->i_credit_amount;
			if ($remain_cost > 0 ) {
				$credit = abs($remain_cost - $credit);
			}else{
				$credit = 0;
			}

			$data = array(
				'i_credit_amount' => $credit
			);
			$this->db->WHERE(array('i_uid'=>$oid));
			$this->db->update('i_users',$data);

			$data = array(
				'iuss_uid' => $uid,
				'iuss_sub_start' => $dt,
				'iuss_sub_month' => $subscription
			);
			$this->db->insert('i_u_storage_subscription',$data);

			$data = array(
				'iugs_uid' => $uid,
				'iugs_sub_start' => $dt,
				'iugs_sub_month' => $subscription
			);
			$this->db->insert('i_u_group_subscription',$data);

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
			$result = $query->result();
			$cart_id = $result[0]->iuc_id;
			for ($i=0; $i <count($cart) ; $i++) {
				$u_flg=0;
				for ($m = 0; $m < count($group_arr); $m++) {
					for($mn = 0 ; $mn < count($group_arr[$m]['users']); $mn++){
						for ($n = 0; $n < count($group_arr[$m]['users'][$mn]['module_access']); $n++) {
							if ($cart[$i]['id'] == $group_arr[$m]['users'][$mn]['module_access'][$n]['mid'] ) {
								if($group_arr[$m]['users'][$mn]['module_access'][$n]['access'] == 'true'){
									$u_flg++;
								}
							}
						}
					}
				}
				$data = array(
					'iucm_users' => $u_flg,
					'iucm_sub_month' => $subscription,
					'iucm_status' => 'paid',
					'iucm_txn_id' => $inid
				);
				$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'unpaid','iucm_id'=>$cart[$i]['id']));
				$this->db->update('i_users_cart_modules',$data);
			}

			for ($i=0; $i < count($cart) ; $i++) {
				$t_id = $cart[$i]['id'];
				$query = $this->db->query("SELECT * from i_users_cart_modules WHERE iucm_id = '$t_id' AND iucm_iuc_id = '$cart_id' ");
				$result = $query->result();
				$mid = $result[0]->iucm_mid;
				$data1 = array(
					'ium_u_id' => $oid,
					'ium_m_id'=> $mid,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => 0,
					'ium_insert_id' => 0,
					'ium_gid' => 0,
					'ium_subscription_start' => date('Y-m-d'),
					'ium_subscription_end' => date('Y-m-d',strtotime('+'.$subscription.' months',strtotime(date('Y-m-d'))))					
				);
				$this->db->insert('i_u_modules',$data1);
			}

			for ($j=0; $j < count($group_arr) ; $j++) {
				$gname = $group_arr[$j]['gname'];

				$data = array(
					'iug_name' => $gname,
					'iug_created_by' => $uid,
					'iug_created' =>$dt,
					'iug_owner' => $oid
				);
				$this->db->insert('i_user_group',$data);
				$group_id = $this->db->insert_id();

				$c_status = '';
				for ($i=0; $i <count($group_arr[$j]['users']) ; $i++) {
					$cname = $group_arr[$j]['users'][$i]['email'];

					$query = $this->db->query("SELECT * FROM i_property WHERE ip_property LIKE '%email%' AND ip_owner = '$oid'");
					$result = $query->result();
					$pid = 0;
					if (count($result) > 0 ) {
						$pid = $result[0]->ip_id;	
					}

					$query = $this->db->query("SELECT * FROM i_c_basic_details a LEFT JOIN i_customers as b on a.icbd_customer_id = b.ic_id WHERE icbd_property = '$pid' AND ic_name = '$cname' AND ic_owner = '$oid' ");
					$result = $query->result();
					$email = '';
					$cid = 0;
					$cust_id = 0;
					if (count($result) > 0 ) {
						$email = $result[0]->icbd_value;
						$cid = $result[0]->ic_id;
						$cust_id = $result[0]->ic_id;
					}

					$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
					$result = $query->result();
					if(count($result) > 0){
						$cid = $result[0]->i_uid;
						$c_status = 'true';
					}else{
						$cid = $email;
						$c_status = 'false';
					}

					if ($group_arr[$j]['users'][$i]['email'] != 'owner') {
						for ($ij=0; $ij < count($group_arr[$j]['users'][$i]['module_access']) ; $ij++) {
							if ($group_arr[$j]['users'][$i]['module_access'][$ij]['access'] == 'true') {
								$t_id = $group_arr[$j]['users'][$i]['module_access'][$ij]['mid'];

								$query = $this->db->query("SELECT * from i_users_cart_modules WHERE iucm_id = '$t_id' AND iucm_iuc_id = '$cart_id' ");
								$result = $query->result();
								$mid = $result[0]->iucm_mid;

								$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_m_id = '$mid' and ium_u_id = '$oid' ");
								$result = $query->result();
								$alias = '';
								if (count($result) > 0 ) {
									$alias = $result[0]->ium_module_alias;	
								}

								$data1 = array(
									'ium_u_id' => $cid,
									'ium_m_id'=> $mid,
									'ium_status' => 'active',
									'ium_created' => $dt,
									'ium_created_by' => $oid,
									'ium_insert_id' => 0,
									'ium_gid' => $group_id,
									'ium_admin' => $group_arr[$j]['users'][$i]['module_access'][$ij]['admin'],
									'ium_reg_status' => $c_status,
									'ium_user_limit' => 0,
									'ium_module_alias' => $alias
								);
								$this->db->insert('i_u_modules',$data1);	
							}
						}
					}

					$data = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
					$result2 = $data->result();

					if(count($result2)>0){
						$s_email = "exist";
					}else{
						$s_email = "not";
					}

					$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$oid' ");
					$result3 = $data->result();

					$subject = "Evomata - Invitation mail";

					$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3>'.$result3[0]->iud_name.' invite you .</h3><h3 style="font-weight: normal; ">Please click on the button to accept request.</h3><a href="'.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($cust_id).'"><button class="btn btn-lg btn-danger pic_button">Accept</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($cust_id).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

					$this->Mail->send_mail($subject,$email,null,$body,$code);
				}
			}

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_subuscription_module($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			$subscription = $this->input->post('subscription');
			$group = $this->input->post('group');
			$storage = $this->input->post('storage');
			$amount = $this->input->post('amount');
			$ref_code = $this->input->post('ref_code');
			$ref_disc = $this->input->post('ref_disc');
			$disc_amount = $this->input->post('disc_amt');
			$cart = $this->input->post('cart');
			$group_arr = $this->input->post('group_arr');
			$remain_cost = $this->input->post('remain_cost');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$result = $query->result();
			$credit = $result[0]->i_credit_amount;
			if ($remain_cost > 0 ) {
				$credit = abs($remain_cost - $credit);
			}else{
				$credit = 0;
			}

			$data = array(
				'i_credit_amount' => $credit
			);
			$this->db->WHERE(array('i_uid'=>$oid));
			$this->db->update('i_users',$data);

			$this->db->WHERE('iugs_uid',$uid);
			$this->db->delete('i_u_group_subscription');

			$this->db->WHERE('iuss_uid',$uid);
			$this->db->delete('i_u_storage_subscription');

			$data = array(
				'iuss_uid' => $uid,
				'iuss_sub_start' => $dt,
				'iuss_sub_month' => $subscription
			);
			$this->db->insert('i_u_storage_subscription',$data);

			$data = array(
				'iugs_uid' => $uid,
				'iugs_sub_start' => $dt,
				'iugs_sub_month' => $subscription
			);
			$this->db->insert('i_u_group_subscription',$data);

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
			$result = $query->result();
			$cart_id = $result[0]->iuc_id;

			for ($i=0; $i < count($cart) ; $i++) {
				$t_id = $cart[$i]['id'];
				$query = $this->db->query("SELECT * from i_users_cart_modules WHERE iucm_id = '$t_id' AND iucm_iuc_id = '$cart_id' ");
				$result = $query->result();
				$mid = $result[0]->iucm_mid;
				$created = 0;
				$gid = 0;
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_m_id = '$mid' AND ium_gid = '0' AND ium_created_by = '0'");
				$result = $query->result();
				$end_date = $result[0]->ium_subscription_end;

				$data1 = array(
					'ium_status' => 'active',
					'ium_subscription_end' => date('Y-m-d',strtotime('+'.$subscription.' months',strtotime($end_date)))
				);
				$this->db->where(array('ium_u_id' => $oid,'ium_m_id'=> $mid,'ium_created_by' => $gid,'ium_gid' => $created));
				$this->db->update('i_u_modules',$data1);
			}
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function update_module_subscription($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			$subscription = $this->input->post('subscription');
			$group = $this->input->post('group');
			$storage = $this->input->post('storage');
			$amount = $this->input->post('amount');
			$ref_code = $this->input->post('ref_code');
			$ref_disc = $this->input->post('ref_disc');
			$disc_amount = $this->input->post('disc_amt');
			$cart = $this->input->post('cart');
			$group_arr = $this->input->post('group_arr');
			$credit_amt = $this->input->post('credit_amt');
			$remain_cost = $this->input->post('remain_cost');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$result = $query->result();
			$credit = $result[0]->i_credit_amount;
			if ($remain_cost > 0 ) {
				$credit = abs($remain_cost - $credit);
			}else{
				$credit = 0;
			}

			$pre_storage = $result[0]->i_storage;
			$storage = ($storage * 1000) + $pre_storage;

			$data = array(
				'i_storage' => $storage,
				'i_credit_amount' => $credit
			);
			$this->db->WHERE(array('i_uid'=>$oid));
			$this->db->update('i_users',$data);

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
			$result = $query->result();
			$cart_id = $result[0]->iuc_id;

			for ($j=0; $j < count($group_arr) ; $j++) {
				$gname = $group_arr[$j]['gname'];

				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_name = '$gname' AND iug_created_by = '$uid' AND iug_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$group_id = $result[0]->iug_id;
					$this->db->where(array('ium_gid' => $group_id));
					$this->db->delete('i_u_modules');
				}else{
					$data = array(
						'iug_name' => $gname,
						'iug_created_by' => $uid,
						'iug_created' =>$dt,
						'iug_owner' => $oid
					);
					$this->db->insert('i_user_group',$data);
					$group_id = $this->db->insert_id();
				}

				$c_status = '';
				for ($i=0; $i <count($group_arr[$j]['users']) ; $i++) {
					$cname = $group_arr[$j]['users'][$i]['email'];

					$query = $this->db->query("SELECT * FROM i_property WHERE ip_property LIKE '%email%' AND ip_owner = '$oid'");
					$result = $query->result();
					$pid = 0;
					if (count($result) > 0 ) {
						$pid = $result[0]->ip_id;	
					}

					$query = $this->db->query("SELECT * FROM i_c_basic_details a LEFT JOIN i_customers as b on a.icbd_customer_id = b.ic_id WHERE icbd_property = '$pid' AND ic_name = '$cname' AND ic_owner = '$oid' ");
					$result = $query->result();
					$email = '';
					$cid = 0;
					$cust_id = 0;
					if (count($result) > 0 ) {
						$email = $result[0]->icbd_value;
						$cid = $result[0]->ic_id;
						$cust_id = $result[0]->ic_id;
					}

					$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
					$result = $query->result();
					if(count($result) > 0){
						$cid = $result[0]->i_uid;
						$c_status = 'true';
					}else{
						$cid = $email;
						$c_status = 'false';
					}

					if ($group_arr[$j]['users'][$i]['email'] != 'owner') {
						for ($ij=0; $ij < count($group_arr[$j]['users'][$i]['module_access']) ; $ij++) {
							if ($group_arr[$j]['users'][$i]['module_access'][$ij]['access'] == 'true') {
								$t_id = $group_arr[$j]['users'][$i]['module_access'][$ij]['mid'];

								$query = $this->db->query("SELECT * from i_users_cart_modules WHERE iucm_id = '$t_id' AND iucm_iuc_id = '$cart_id' ");
								$result = $query->result();
								$mid = $result[0]->iucm_mid;

								$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_m_id = '$mid' and ium_u_id = '$oid' ");
								$result = $query->result();
								$alias = '';
								if (count($result) > 0 ) {
									$alias = $result[0]->ium_module_alias;	
								}

								$data1 = array(
									'ium_u_id' => $cid,
									'ium_m_id'=> $mid,
									'ium_status' => 'active',
									'ium_created' => $dt,
									'ium_created_by' => $oid,
									'ium_insert_id' => 0,
									'ium_gid' => $group_id,
									'ium_admin' => $group_arr[$j]['users'][$i]['module_access'][$ij]['admin'],
									'ium_reg_status' => $c_status,
									'ium_user_limit' => 0,
									'ium_module_alias' => $alias
								);
								$this->db->insert('i_u_modules',$data1);	
							}
						}
					}

					$data = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
					$result2 = $data->result();

					if(count($result2)>0){
						$s_email = "exist";
					}else{
						$s_email = "not";
					}

					$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$oid' ");
					$result3 = $data->result();

					$subject = "Evomata - Invitation mail";

					$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3>'.$result3[0]->iud_name.' invite you .</h3><h3 style="font-weight: normal; ">Please click on the button to accept request.</h3><a href="'.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($cust_id).'"><button class="btn btn-lg btn-danger pic_button">Accept</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($cust_id).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

					$this->Mail->send_mail($subject,$email,null,$body,$code);
				}
			}
			$gid_arr = [];
			for ($j=0; $j < count($group_arr) ; $j++) {
				$gname = $group_arr[$j]['gname'];
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_name = '$gname' AND iug_created_by = '$uid' AND iug_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					array_push($gid_arr, $result[0]->iug_id);
				}
			}

			if (count($gid_arr) > 0) {
				$gids = implode(',', $gid_arr);
				$this->db->query("DELETE FROM i_user_group WHERE iug_id NOT IN ($gids) AND iug_created_by = '$uid' AND iug_owner = '$oid' ");

				$this->db->query("DELETE FROM i_u_modules WHERE ium_gid NOT IN ($gids) AND ium_created_by = '$uid' ");
			}

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	// public function add_module_user($code){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $oid;
	// 		$data['uid'] = $uid;
	// 		$dt = date('Y-m-d H:i:s');
	// 		$ref_disc = $this->input->post('ref_disc');
	// 		$disc_amount = $this->input->post('disc_amt');
	// 		$amount = $this->input->post('amount');
	// 		$inid = 0 ;
	// 		$this->db->WHERE('iugs_uid',$uid);
	// 		$this->db->delete('i_u_group_subscription');

	// 		$this->db->WHERE('iuss_uid',$uid);
	// 		$this->db->delete('i_u_storage_subscription');

	// 		$data = array(
	// 			'iuss_uid' => $uid,
	// 			'iuss_sub_start' => $dt,
	// 			'iuss_sub_month' => $this->input->post('s_month')
	// 		);
	// 		$this->db->insert('i_u_storage_subscription',$data);

	// 		$data = array(
	// 			'iugs_uid' => $uid,
	// 			'iugs_sub_start' => $dt,
	// 			'iugs_sub_month' => $this->input->post('g_month')
	// 		);
	// 		$this->db->insert('i_u_group_subscription',$data);
	// 		$dt1=date_create();
	// 		$dt_str = date_timestamp_get($dt1);
	// 		if ($amount == 0 && $disc_amount > 0 ) {
	// 			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
	// 			$result = $query->result();
	// 			if (count($result) > 0 ) {
	// 				$email = $result[0]->i_uname;
	// 			}
	// 			$data = array(
	// 				  'iutxn_uid' => $uid,
	// 				  'iutxn_payment_id' => '0',
	// 				  'iutxn_timestamp' => '0',
	// 				  'iutxn_group' => $this->input->post('group'),
	// 				  'iutxn_group_month' => $this->input->post('g_month'),
	// 				  'iutxn_storage' => $this->input->post('storage'),
	// 				  'iutxn_storage_month' => $this->input->post('s_month'),
	// 				  'iutxn_date' => $dt,
	// 				  'iutxn_entity' => 'payment',
	// 				  'iutxn_amount' => $amount,
	// 				  'iutxn_currency' => 'INR',
	// 				  'iutxn_status' => 'uncaptured',
	// 				  'iutxn_method' => 'cheque',
	// 				  'iutxn_amount_refunded' => '0',
	// 				  'iutxn_captured' => '0',
	// 				  'iutxn_description' => 'DaiFunc cheque',
	// 				  'iutxn_email' => $email,
	// 				  'iutxn_created_at' => $dt_str,
	// 				  'iutxn_ref_code' => $this->input->post('ref_code'),
	// 				  'iutxn_discount_amount' => $disc_amount,
	// 				  'iutxn_txn_type' => 'purchase'
	// 			);
	// 			$this->db->insert('i_user_transaction',$data);
	// 			$inid = $this->db->insert_id();

	// 			for ($i=0; $i < count($ref_disc) ; $i++) {
	// 				if ($ref_disc[$i]['for'] == 'referrer' ) {
	// 					$amt = ($amount / 100 ) + $disc_amount;
	// 					if ($ref_disc[$i]['type'] == 'percentage' ) {
	// 						$d_amt = $amt * ( $ref_disc[$i]['amount'] / 100 );
	// 					}else{
	// 						$d_amt = $amt - $ref_disc[$i]['amount'];
	// 					}
	// 					$data = array(
	// 						'iushtxn_sid' => $ref_disc[$i]['id'],
	// 						'iushtxn_uid' => $uid,
	// 						'iushtxn_amount' => $d_amt,
	// 						'iushtxn_status' => 'unpaid',
	// 						'iushtxn_txn_id' => $inid,
	// 						'iushtxn_ref_code' => $ref_code,
	// 						'iushtxn_created' => $dt
	// 					);
	// 					$this->db->insert('i_user_scheme_txn',$data);
	// 					$sid = $this->db->insert_id();
	// 				}
	// 			}

	// 			$cart = $this->input->post('cart');
	// 			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
	// 			$result = $query->result();
	// 			$cart_id = $result[0]->iuc_id;
	// 			for ($i=0; $i <count($cart) ; $i++) {
	// 				$data = array(
	// 					'iucm_users' => $cart[$i]['users'],
	// 					'iucm_sub_month' => $cart[$i]['sub'],
	// 					'iucm_status' => 'paid',
	// 					'iucm_txn_id' => $inid
	// 				);
	// 				$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'unpaid','iucm_id'=>$cart[$i]['id']));
	// 				$this->db->update('i_users_cart_modules',$data);
	// 			}

	// 			$data = array(
	// 				'iucm_txn_id' => $inid
	// 			);
	// 			$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'add_on'));
	// 			$this->db->update('i_users_cart_modules',$data);

	// 			$property = [];
	// 			$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$inid' AND iucm_status = 'paid'");
	// 			$result1 = $query->result();
	// 			for ($i=0; $i <count($result1) ; $i++) { 
	// 				array_push($property,$result1[$i]->im_name);
	// 			}
	// 			$pid = implode(',', $property);
	// 			$amount = intval($amount)/100 ;
	// 			$subject = "Payment Successful";
	// 			$body = '<html><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td,th {border: 1px solid #dddddd;text-align: left;padding: 8px;}h3{font-weight: normal;}</style><body><div style="text-align: center;"><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;padding:20px;"><h1 style="height: 30px;font-weight: bold;">DAIFUNC</h1><h1 style="padding:20px;color: green;">Your payment succesfully done.</h1></div><div><h3>Your payment will be received by '.date('M d, Y').'.</div><div><h3>Payment Details ..</h3><table style="width:100%;"><tbody><tr><td style="width:30%;">Amount</td><td style="width:70%;">'.$amount.'</td></tr><tr><td style="width:30%;">Payment ID</td><td style="width:70%;">0</td></tr><tr><td style="width:30%;">Module</td><td style="width:70%;">'.$pid.'</td></tr><tr><td style="width:30%;">Group</td><td style="width:70%;">'.$this->input->post('group').'</td></tr><tr><td style="width:30%;">Storage</td><td style="width:70%;">'.$this->input->post('storage').'</td></tr></tbody></table><br><h3>Thank you for connecting with DAIFUNC .</h3></div><div style="text-align: center;"><p style="font-size: 0.8em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></div></body></html>';

	// 			$temp = $this->Mail->send_daifunc_mail($subject,$email,null,$body,$code);
	// 			echo $inid;
	// 		}else{
	// 			for ($i=0; $i < count($ref_disc) ; $i++) {
	// 				if ($ref_disc[$i]['for'] == 'referrer' ) {
	// 					$amt = ($amount / 100 ) + $disc_amount;
	// 					if ($ref_disc[$i]['type'] == 'percentage' ) {
	// 						$d_amt = $amt * ( $ref_disc[$i]['amount'] / 100 );
	// 					}else{
	// 						$d_amt = $amt - $ref_disc[$i]['amount'];
	// 					}
	// 					$data = array(
	// 						'iushtxn_sid' => $ref_disc[$i]['id'],
	// 						'iushtxn_uid' => $uid,
	// 						'iushtxn_amount' => $d_amt,
	// 						'iushtxn_status' => 'unpaid'
	// 					);
	// 					$this->db->insert('i_user_scheme_txn',$data);
	// 					$inid = $this->db->insert_id();
	// 				}
	// 			}

	// 			$cart = $this->input->post('cart');
	// 			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
	// 			$result = $query->result();
	// 			$cart_id = $result[0]->iuc_id;
	// 			for ($i=0; $i <count($cart) ; $i++) {
	// 				$data = array(
	// 					'iucm_users' => $cart[$i]['users'],
	// 					'iucm_sub_month' => $cart[$i]['sub']
	// 				);
	// 				$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'unpaid','iucm_id'=>$cart[$i]['id']));
	// 				$this->db->update('i_users_cart_modules',$data);
	// 			}
	// 			echo $inid;
	// 		}
	// 	}else{
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function pay_details($code,$id,$amount,$group,$g_month,$storage,$s_month,$ref_code,$disc_amount,$txn_type,$sid){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $oid;
	// 		$data['uid'] = $uid;
	// 		$dt = date('Y-m-d H:i:s');

	// 		$api = new RazorpayApi($this->config->item('p_key'), $this->config->item('p_secret'));
	// 		$payment  = $api->payment->fetch($id)->capture(array('amount'=>$amount));
	// 		$dt1=date_create();
	// 		$dt_str = date_timestamp_get($dt1);
	// 		$timestamp = $uid.$dt_str;

	// 		if ($payment->amount == $amount) {
	// 			$data = array(
	// 				  'iutxn_uid' => $uid,
	// 				  'iutxn_payment_id' => $id,
	// 				  'iutxn_timestamp' => $timestamp,
	// 				  'iutxn_group' => $group,
	// 				  'iutxn_group_month' => $g_month,
	// 				  'iutxn_storage' => $storage,
	// 				  'iutxn_storage_month' => $s_month,
	// 				  'iutxn_date' => $dt,
	// 				  'iutxn_entity' => $payment->entity,
	// 				  'iutxn_amount' => $payment->amount,
	// 				  'iutxn_currency' => $payment->currency,
	// 				  'iutxn_status' => $payment->status,
	// 				  'iutxn_order_id' => $payment->order_id,
	// 				  'iutxn_invoice_id' => $payment->invoice_id,
	// 				  'iutxn_international' => $payment->international,
	// 				  'iutxn_method' => $payment->method,
	// 				  'iutxn_amount_refunded' => $payment->amount_refunded,
	// 				  'iutxn_refund_status' => $payment->refund_status,
	// 				  'iutxn_captured' => $payment->captured,
	// 				  'iutxn_description' => $payment->description,
	// 				  'iutxn_card_id' => $payment->card_id,
	// 				  'iutxn_bank' => $payment->bank,
	// 				  'iutxn_wallet' => $payment->wallet,
	// 				  'iutxn_vpa' => $payment->vpa,
	// 				  'iutxn_email' => $payment->email,
	// 				  'iutxn_contact' => $payment->contact,
	// 				  // 'iutxn_notes' => $payment->notes,
	// 				  // 'iutxn_address' => $payment->address,
	// 				  'iutxn_fee' => $payment->fee,
	// 				  'iutxn_tax' => $payment->tax,
	// 				  'iutxn_error_code' => $payment->error_code,
	// 				  'iutxn_error_description' => $payment->error_description,
	// 				  'iutxn_created_at' => $payment->created_at,
	// 				  'iutxn_ref_code' => $ref_code,
	// 				  'iutxn_discount_amount' => $disc_amount,
	// 				  'iutxn_txn_type' => $txn_type
	// 			);
	// 			$this->db->insert('i_user_transaction',$data);
	// 			$inid = $this->db->insert_id();

	// 			$data = array(
	// 				'iushtxn_txn_id' => $inid,
	// 				'iushtxn_ref_code' => $ref_code,
	// 				'iushtxn_created' => $dt
	// 			);
	// 			$this->db->WHERE(array('iushtxn_id' => $sid));
	// 			$this->db->update('i_user_scheme_txn',$data);

	// 			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
	// 			$result = $query->result();
	// 			$cart_id = $result[0]->iuc_id;

	// 			$data = array(
	// 				'iucm_status' => 'paid',
	// 				'iucm_txn_id' => $inid
	// 			);
	// 			$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'unpaid'));
	// 			$this->db->update('i_users_cart_modules',$data);

	// 			$data = array(
	// 				'iucm_txn_id' => $inid
	// 			);
	// 			$this->db->WHERE(array('iucm_iuc_id'=>$cart_id,'iucm_status'=>'add_on'));
	// 			$this->db->update('i_users_cart_modules',$data);

	// 			$property = [];
	// 			$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$inid' AND iucm_status = 'paid'");
	// 			$result1 = $query->result();
	// 			for ($i=0; $i <count($result1) ; $i++) { 
	// 				array_push($property,$result1[$i]->im_name);
	// 			}
	// 			$pid = implode(',', $property);
	// 			$amount = intval($amount)/100 ;
	// 			$subject = "Payment Successful";
	// 			$body = '<html><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td,th {border: 1px solid #dddddd;text-align: left;padding: 8px;}h3{font-weight: normal;}</style><body><div style="text-align: center;"><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;padding:20px;"><h1 style="height: 30px;font-weight: bold;">DAIFUNC</h1><h1 style="padding:20px;color: green;">Your payment succesfully done.</h1></div><div><h3>Your payment will be received by '.date('M d, Y').'.</div><div><h3>Payment Details ..</h3><table style="width:100%;"><tbody><tr><td style="width:30%;">Amount</td><td style="width:70%;">'.$amount.'</td></tr><tr><td style="width:30%;">Payment ID</td><td style="width:70%;">'.$id.'</td></tr><tr><td style="width:30%;">Module</td><td style="width:70%;">'.$pid.'</td></tr><tr><td style="width:30%;">Group</td><td style="width:70%;">'.$group.'</td></tr><tr><td style="width:30%;">Storage</td><td style="width:70%;">'.$storage.'</td></tr></tbody></table><br><h3>Thank you for connecting with DAIFUNC .</h3></div><div style="text-align: center;"><p style="font-size: 0.8em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></div></body></html>';

	// 			$temp = $this->Mail->send_daifunc_mail($subject,$payment->email,null,$body,$code);

	// 			redirect(base_url().'Home/cart_module_allot/'.$code.'/'.$inid.'/'.$group.'/'.$storage);
	// 		}else{
	// 			redirect(base_url().'Home/cart_module_allot/'.$code.'/0');
	// 		}
	// 	}else{
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function cart_module_allot($code,$inid,$group=null,$storage=null){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $oid;
	// 		$data['uid'] = $uid;
	// 		$dt = date('Y-m-d H:i:s');
	// 		if ($inid == 0) {
	// 			redirect(base_url().'Home/collection/0/'.$code);
	// 		}else{
	// 			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid='$uid'");
	// 			$result = $query->result();
	// 			$e_group = $result[0]->i_g_limit;
	// 			$e_storage = $result[0]->i_storage;

	// 			$group = intval($group)+intval($e_group);
	// 			$storage = intval($storage) * 1000 + intval($e_storage);

	// 			$data = array(
	// 				'i_storage' => $storage,
	// 				'i_g_limit' => $group
	// 			);
	// 			$this->db->WHERE('i_uid',$uid);
	// 			$this->db->update('i_users',$data);

	// 			$data = array(
	// 				'iuc_storage' => 0,
	// 				'iuc_group' => 0
	// 			);
	// 			$this->db->WHERE('iuc_uid',$uid);
	// 			$this->db->update('i_users_cart',$data);

	// 			$query = $this->db->query("SELECT * FROM i_users_cart_modules WHERE iucm_txn_id = '$inid'");
	// 			$result1 = $query->result();
	// 			for ($i=0; $i <count($result1) ; $i++) {
	// 				$mid = $result1[$i]->iucm_mid;
	// 				if ($result1[$i]->iucm_status == 'add_on' ) {
	// 					$u_limit = 0 ;
	// 					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_m_id = '$mid' AND ium_gid = '0' AND ium_created_by = '0'");
	// 					$result = $query->result();
	// 					if (count($result) > 0) {
	// 						$u_limit = $result[0]->ium_user_limit;	
	// 					}
	// 					$data = array(
	// 						'ium_user_limit'=> intval($result1[$i]->iucm_users) + intval($u_limit)
	// 					);
	// 					$this->db->WHERE(array('ium_u_id' => $uid, 'ium_m_id' => $mid, 'ium_status' => 'active', 'ium_created_by' => 0));
	// 					$this->db->update('i_u_modules',$data);
	// 				}else{
	// 					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_m_id = '$mid' AND ium_gid = '0' AND ium_created_by = '0'");
	// 					$result = $query->result();
	// 					if (count($result) > 0) {
	// 						$data = array(
	// 							'ium_status' => 'active'
	// 						);
	// 						$this->db->WHERE(array('ium_u_id' => $uid,'ium_m_id' => $mid,'ium_gid' => '0','ium_created_by' => '0'));
	// 						$this->db->update('i_u_modules',$data);
	// 					}else{
	// 						$d_t = date('Y-m-d');
	// 						$s_month = $result1[$i]->iucm_sub_month;
	// 						$s_days = 30 * $s_month;
	// 						$e_t = date('Y-m-d', strtotime('+'.$s_days.' days'));
	// 						$data = array(
	// 							'ium_u_id' => $uid,
	// 							'ium_m_id' => $mid,
	// 							'ium_status' => 'active',
	// 							'ium_created' => $dt,
	// 							'ium_created_by' => 0,
	// 							'ium_insert_id'=> 0,
	// 							'ium_user_limit'=>$result1[$i]->iucm_users,
	// 							'ium_gid' => 0,
	// 							'ium_subscription_start' => $d_t,
	// 							'ium_subscription_end' => $e_t
	// 						);
	// 						$this->db->insert('i_u_modules',$data);	
	// 					}
	// 				}
	// 			}

	// 			$data = array(
	// 				'iucm_status' => 'paid'
	// 			);
	// 			$this->db->WHERE(array('iucm_txn_id' => $inid,'iucm_status'=>'add_on'));
	// 			$this->db->update('i_users_cart_modules',$data);

	// 			redirect(base_url().'Home/collection/'.$inid.'/'.$code);
	// 		}
	// 	}else{
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	public function renewal_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$dt = date('Y-m-d H:i:s');

			$cart = $this->input->post('mcart');
			$id = $this->input->post('pay_id');
			$amount = $this->input->post('amount');

			$disc_amount = $this->input->post('disc_amt');
			$ref_code = $this->input->post('ref_code');
			$ref_disc = $this->input->post('ref_disc');

			$api = new RazorpayApi($this->config->item('p_key'), $this->config->item('p_secret'));
			$payment  = $api->payment->fetch($id)->capture(array('amount'=>$amount));

			$dt1=date_create(); 
			$dt_str = date_timestamp_get($dt1);
			$timestamp = $uid.$dt_str;

			if ($payment->amount == $amount) {
				$data = array(
					  'iutxn_uid' => $uid,
					  'iutxn_payment_id' => $id,
					  'iutxn_timestamp' => $timestamp,
					  'iutxn_group' => 0,
					  'iutxn_group_month' => 0,
					  'iutxn_storage' => 0,
					  'iutxn_storage_month' => 0,
					  'iutxn_date' => $dt,
					  'iutxn_entity' => $payment->entity,
					  'iutxn_amount' => $payment->amount,
					  'iutxn_currency' => $payment->currency,
					  'iutxn_status' => $payment->status,
					  'iutxn_order_id' => $payment->order_id,
					  'iutxn_invoice_id' => $payment->invoice_id,
					  'iutxn_international' => $payment->international,
					  'iutxn_method' => $payment->method,
					  'iutxn_amount_refunded' => $payment->amount_refunded,
					  'iutxn_refund_status' => $payment->refund_status,
					  'iutxn_captured' => $payment->captured,
					  'iutxn_description' => $payment->description,
					  'iutxn_card_id' => $payment->card_id,
					  'iutxn_bank' => $payment->bank,
					  'iutxn_wallet' => $payment->wallet,
					  'iutxn_vpa' => $payment->vpa,
					  'iutxn_email' => $payment->email,
					  'iutxn_contact' => $payment->contact,
					  'iutxn_fee' => $payment->fee,
					  'iutxn_tax' => $payment->tax,
					  'iutxn_error_code' => $payment->error_code,
					  'iutxn_error_description' => $payment->error_description,
					  'iutxn_created_at' => $payment->created_at,
					  'iutxn_ref_code' => $ref_code,
					  'iutxn_discount_amount' => $disc_amount,
					  'iutxn_txn_type' => 'renew'
				);
				$this->db->insert('i_user_transaction',$data);
				$inid = $this->db->insert_id();

				for ($i=0; $i < count($ref_disc) ; $i++) { 
					if ($ref_disc[$i]['for'] == 'referrer' ) {
						$amt = ($amount / 100 ) + $disc_amount;
						if ($ref_disc[$i]['type'] == 'percentage' ) {
							$d_amt = $amt * ( $ref_disc[$i]['amount'] / 100 );
						}else{
							$d_amt = $amt - $ref_disc[$i]['amount'];
						}
						$data = array(
							'iushtxn_uid' => $uid,
							'iushtxn_sid' => $ref_disc[$i]['id'],
							'iushtxn_amount' => $d_amt,
							'iushtxn_txn_id' => $inid,
							'iushtxn_ref_code' => $ref_code,
							'iushtxn_created' => $dt,
							'iushtxn_status' => 'unpaid'
						);
						$this->db->insert('i_user_scheme_txn',$data);
					}
				}

				$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid='$uid'");
				$result = $query->result();
				$cart_id = $result[0]->iuc_id;

				for ($i=0; $i <count($cart) ; $i++) {
					$mid = $cart[$i]['mid'];
					if ($cart[$i]['no_user'] == '') {
						$cart[$i]['no_user'] = 0;
					}
					if ($cart[$i]['sub'] == '') {
						$cart[$i]['sub'] = 0;
					}
					$data = array(
						'iucm_status' => 'paid',
						'iucm_txn_id' => $inid,
						'iucm_mid' => $mid,
						'iucm_users' => $cart[$i]['no_user'],
						'iucm_iuc_id' => $cart_id,
						'iucm_sub_month' => $cart[$i]['sub']
					);
					$this->db->insert('i_users_cart_modules',$data);

					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_m_id = '$mid' AND ium_gid = '0' AND ium_created_by = '0'");
					$result = $query->result();
					$user = intval($result[0]->ium_renewal_user) + intval($cart[$i]['no_user']);
					$month = intval($result[0]->ium_renewal_month) + intval($cart[$i]['sub']);

					$data = array(
						'ium_renewal_user' => $user,
						'ium_renewal_month' => $month
					);
					$this->db->WHERE(array('ium_u_id' => $uid,'ium_m_id' => $cart[$i]['mid'],'ium_gid' => '0','ium_created_by' => '0'));
					$this->db->update('i_u_modules',$data);
				}
				
				$property = [];
				$pid = '';
				$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$inid' AND iucm_status = 'paid'");
				$result1 = $query->result();
				for ($i=0; $i <count($result1) ; $i++) { 
					array_push($property,$result1[$i]->im_name);
				}

				$pid = implode(',', $property);
				$amount = intval($amount)/100 ;
				$subject = "Subscription of your module extended successfully .";
				$body = '<!DOCTYPE html><html><head><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} h3{font-weight: normal;}</style></head><body><div style="text-align: center;"><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;padding:20px;"><h1 style="height: 30px;font-weight: bold;">DAIFUNC</h1><h1 style="padding:20px;color: green;">Your payment succesfully done.</h1></div><div><h3>Your payment will be received by '.date('M d, Y').'.</div><div><h3> Payment Details ..</h3><table style="width:100%;"><tbody><tr><td style="width:30%;">Amount</td><td style="width:70%;">'.$amount.'</td></tr><tr><td style="width:30%;">Payment ID </td><td style="width:70%;">'.$id.'</td></tr><tr><td style="width:30%;">Module</td><td style="width:70%;">'.$pid.'</td></tr><tr><td style="width:30%;">Group</td><td style="width:70%;">0</td></tr><tr><td style="width:30%;">Storage</td><td style="width:70%;">0</td></tr></tbody></table><br><h3>Thank you for connecting with DAIFUNC .</h3></div><div style="text-align: center;"><p style="font-size: 0.8em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></div></body></html>';

				$temp = $this->Mail->send_daifunc_mail($subject,$payment->email,null,$body,$code);

				echo $inid;
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

################### Notification Activity ###########

	public function notification_activity_update($code,$type,$txn_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$tags = $this->input->post('a_tags');
			$gid = $sess_data['gid'];
			$a_flg = $this->input->post('a_mail');
			$td = $this->input->post('a_to_do'); $flg=0;
			if (count($td) > 0) {
				$flg=1;
			}

			$note = $this->input->post('note');
			$person = $this->input->post('a_person');
			$a_date = $this->input->post('a_date');
			$e_date = $this->input->post('e_date');
			if ($a_date == '') {
				$a_date = date('Y-m-d H:i:s');
			}
			if ($e_date == '') {
				$e_date = date('Y-m-d H:i:s');
			}

			$s_func = $this->input->post('a_func_short');
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_name = '$s_func'");
			$result = $query->result();
			if (count($result) > 0) {
				$fid = $result[0]->ims_function;
				$mod_id = $result[0]->ims_m_id;	
			}else{
				$fid = 0;
				$mod_id = 0;
			}

			$data = array(
				'iua_type' => $type,
				'iua_title' => $this->input->post('a_title'),
				'iua_date' => $a_date,
				'iua_place' => $this->input->post('a_place'),
				'iua_to_do' => $flg,
				'iua_status' => 'pending',
				'iua_owner' => $oid,
				'iua_created_by' => $uid,
				'iua_created' => date('Y-m-d H:i:s'),
				'iua_categorise' => $this->input->post('a_cat'),
				'iua_p_activity' => 0,
				'iua_shortcuts' => $fid,
				'iua_m_shortcuts' => $mod_id,
				'iua_g_id' => $gid,
				'iua_modified_by' => 0,
				'iua_color' => $this->input->post('a_color'),
				'iua_end_date' => $e_date
			);
			$this->db->insert('i_user_activity',$data);
			$aid = $this->db->insert_id();

			for ($i=0; $i <count($person) ; $i++) { 
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
				$result = $query->result();

				$data = array(
					'iuap_a_id' => $aid,
					'iuap_p_id' => $result[$i]->ic_id,
					'iuap_owner'=> $oid
				);
				$this->db->insert('i_u_a_person',$data);

				$data1 = array(
					'in_type_id' => $aid, 
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $result[$i]->ic_id,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt
				);
				$this->db->insert('i_notifications',$data1);
			}

			$str1 = preg_replace('/\s+/', ' ', trim($note));
			if ($str1 != '') {
				$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
				if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
				$txt_file = $aid.'.txt';
				file_put_contents($path.$txt_file, $note);

				$data = array(
					'iua_note' => $txt_file
				);
				$this->db->where('iua_id',$aid);
				$this->db->update('i_user_activity',$data);
			}

			$data2 = array(
				'iual_a_id' => $aid,
				'iual_owner' => $oid,
				'iual_created' => $dt,
				'iual_created_by' => $uid,
				'iual_title' => 'add'
			);
			$this->db->insert('i_u_a_log',$data2);

			for ($i=0; $i < count($td); $i++) {
				$data1 = array(
					'iuat_a_id' => $aid,
					'iuat_title' => $td[$i]['title'],
					'iuat_status' => $td[$i]['status'],
					'iuat_owner' => $oid
				);
				$this->db->insert('i_u_a_todo',$data1);
			}

			for ($j=0; $j < count($tags) ; $j++) {
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data2 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data2);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data3 = array(
					'iuat_a_id' => $aid,
					'iuat_t_id' => $tid,
					'iuat_owner'=>$oid
				);
				$this->db->insert('i_u_activity_tags', $data3);

				$data5 = array(
					'iet_type_id' => $aid,
					'iet_type' => 'activity',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => 0
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			$chars = "0123456789";
			$res = "";
			for ($i = 0; $i < 6; $i++) {
			    $res .= $chars[mt_rand(0, strlen($chars)-1)];
			}

			$data = array(
				'iextamct_owner' => $oid,
				'iextamct_amc_id' => $txn_id,
				'iextamct_created_by' => $uid,
				'iextamct_gid' => $gid,
				'iextamct_aid' => $aid,
				'iextamct_code' => $res
			);
			$this->db->insert('i_ext_et_amc_task',$data);

			if ($a_flg == 'true') {
				redirect(base_url().'Home/activity_mail/'.$aid.'/'.$code);	
			}else{
				echo "true";
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function subscription_mail_send($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$uid' AND iextetm_gid = '$gid' ");
			$result1 = $query->result();
			$feedback_type = '';
			if (count($result1) > 0) {
				$feedback_type = $result1[0]->iextetm_feedback_type;
			}

			if ($feedback_type == '' || $feedback_type == 'false') {
				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like '%email%' ");
				$result1 = $query->result();
				$pid = 0;
				if (count($result1) > 0 ) {
					$pid = $result1[0]->ip_id;	
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_amc as a left join i_ext_et_amc_task as b on a.iextamc_id = b.iextamct_amc_id left join i_c_basic_details as c on a.iextamc_customer_id=c.icbd_customer_id WHERE iextamct_aid = '$aid' AND icbd_property = '$pid' ");
				$result = $query->result();
				$sub_code='';
				$to='';
				if (count($result) > 0 ) {
					$sub_code = $result[0]->iextamct_code;
					$to = $result[0]->icbd_value;
				}
				$sub = 'Verify subscription code';
				$body = 'plz verify subscription code <b>'.$sub_code.'</b>';
				$temp = $this->Mail->send_mail($sub,$to,null,$body,$code);

				echo $feedback_type;
			}else{
				echo $feedback_type;
			}
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function subscription_code_verify($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$sub_code = $this->input->post('sub_code');
			$cmt = $this->input->post('cmt');
			$rat = $this->input->post('rat');
			$action = $this->input->post('sub_action');
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$oid' AND iextetm_gid = '$gid' ");
			$result1 = $query->result();
			$feedback_type = '';
			if (count($result1) > 0) {
				$feedback_type = $result1[0]->iextetm_feedback_type;
			}
			if ($feedback_type == '' || $feedback_type == 'false') {
				$query = $this->db->query("SELECT * FROM i_user_activity as a left join i_ext_et_amc_task as b on a.iua_id = b.iextamct_aid  WHERE iextamct_aid = '$aid' AND iextamct_code = '$sub_code' AND iua_g_id = '$gid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data = array('iua_status' => 'done' );
					$this->db->WHERE(array('iua_id' => $aid));
					$this->db->update('i_user_activity',$data);

					$data2 = array(
						'iual_a_id' => $aid,
						'iual_owner' => $oid,
						'iual_created' => $dt,
						'iual_created_by' => $uid,
						'iual_title' => 'done',
						'iual_comment' => $cmt,
						'iual_star_rating' => $rat,
						'iual_action_taken' => $action,
						'iual_feedback_type' => $feedback_type
					);
					$this->db->insert('i_u_a_log',$data2);

					echo "true";
				}else{
					echo "false";
				}
			}else{
				$data = array('iua_status' => 'done' );
				$this->db->WHERE(array('iua_id' => $aid));
				$this->db->update('i_user_activity',$data);

				$data2 = array(
					'iual_a_id' => $aid,
					'iual_owner' => $oid,
					'iual_created' => $dt,
					'iual_created_by' => $uid,
					'iual_title' => 'done',
					'iual_action_taken' => $action,
					'iual_feedback_type' => $feedback_type
				);
				$this->db->insert('i_u_a_log',$data2);
				echo "true";
			}
		}else{
			redirect(base_url().'Account/login');
		}
	}

################### support #########################

	public function support_mail_send($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$oid' AND iextetm_gid = '$gid' ");
			$result1 = $query->result();
			$feedback_type = '';
			if (count($result1) > 0) {
				$feedback_type = $result1[0]->iextetm_feedback_type;
			}

			if ($feedback_type == '' || $feedback_type == 'false') {
				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%'");
				$result1 = $query->result();
				$pid = 0;
				if (count($result1) > 0 ) {
					$pid = $result1[0]->ip_id;	
				}

				$query = $this->db->query("SELECT * FROM i_ext_support as a LEFT JOIN i_ext_support_activity as b on a.ies_id = b.iesa_sid WHERE iesa_aid = '$aid' AND ies_gid = '$gid' ");
				$result = $query->result();
				$cid = 0;
				$sub_code='';
				if (count($result) > 0 ) {
					$cid = $result[0]->ies_cid;
					$s_oid = $result[0]->ies_owner;
					$sub_code = $result[0]->iesa_code;
				}

				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner = '$s_oid' ");
				$result1 = $query->result();
				$pid = $result1[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$pid' AND icbd_customer_id = '$cid' ");
				$result = $query->result();

				$to='';
				if (count($result) > 0 ) {
					$to = $result[0]->icbd_value;
				}

				$sub = 'Verify subscription code';
				$body = 'plz verify subscription code <b>'.$sub_code.'</b>';
				$temp = $this->Mail->send_mail($sub,$to,null,$body,$code);
				echo $feedback_type;
			}else{
				echo $feedback_type;
			}
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function support_code_verify($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$sub_code = $this->input->post('sub_code');
			$cmt = $this->input->post('cmt');
			$rat = $this->input->post('rat');
			$action = $this->input->post('sub_action');

			$dt = date('Y-m-d H:i:s');
			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$oid' AND iextetm_gid = '$gid' ");
			$result1 = $query->result();
			$feedback_type = '';
			if (count($result1) > 0) {
				$feedback_type = $result1[0]->iextetm_feedback_type;
			}

			if ($feedback_type == '' || $feedback_type == 'false') {
				$query = $this->db->query("SELECT * FROM i_ext_support_activity as a left join i_u_a_person as b on a.iesa_aid = b.iuap_a_id  WHERE iesa_aid = '$aid' AND iesa_code = '$sub_code' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data = array('iua_status' => 'done' );
					$this->db->WHERE(array('iua_id' => $aid));
					$this->db->update('i_user_activity',$data);

					$data2 = array(
						'iual_a_id' => $aid,
						'iual_owner' => $oid,
						'iual_created' => $dt,
						'iual_created_by' => $uid,
						'iual_title' => 'done',
						'iual_comment' => $cmt,
						'iual_star_rating' => $rat,
						'iual_action_taken' => $action,
						'iual_feedback_type' => $feedback_type
					);
					$this->db->insert('i_u_a_log',$data2);
					echo "true";
				}else{
					echo "false";
				}	
			}else{
				$data = array('iua_status' => 'done' );
				$this->db->WHERE(array('iua_id' => $aid));
				$this->db->update('i_user_activity',$data);

				$data2 = array(
					'iual_a_id' => $aid,
					'iual_owner' => $oid,
					'iual_created' => $dt,
					'iual_created_by' => $uid,
					'iual_title' => 'done',
					'iual_action_taken' => $action,
					'iual_feedback_type' => $feedback_type
				);
				$this->db->insert('i_u_a_log',$data2);
				echo "true";
			}
		}else{
			redirect(base_url().'Account/login');
		}
	}

################### Client Corner ###################

	public function client_view($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_customer_id IS NOT NULL AND icbd_value IN ( SELECT i_uname FROM i_users WHERE i_uid = '$uid' ) ");
			$result = $query->result();
			$cust_id = [];
			if (count($result)) {
				for ($i=0; $i < count($result) ; $i++) {
					array_push($cust_id, $result[$i]->icbd_customer_id);
				}
			}
			$c_id = implode(',', $cust_id);

			$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_cid IN ($c_id) ");
			$result = $query->result();
			$data['support'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_id IN (SELECT iextprour_pid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' ) ");
			$result = $query->result();
			$data['project'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_customer_id IN ($c_id) ");
			$result = $query->result();
			$data['invoice'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_customer_id IN ($c_id) ");
			$result = $query->result();
			$data['proposal'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id IN ($c_id) AND iextamc_type = 'formal' ");
			$result = $query->result();
			$data['amc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_customer_id IN ($c_id) AND iextei_type IN('inward','outward') ");
			$result = $query->result();
			$data['inv'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_id IN (SELECT iextetboqm_boq_id FROM i_ext_et_boq_mutual WHERE iextetboqm_uid = '$uid' ) ");
			$result = $query->result();
			$data['boq'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual WHERE iextetboqm_uid = '$uid' ");
			$result = $query->result();
			$data['boq_details'] = $result;

	        $data['client_view'] = 'false';

			$data['gid'] = $gid;$data['code']=$code;$data['oid']=$oid;
			$ert['mod'] = $sess_data['user_mod'];$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['gid'] = $gid;$ert['mid'] = 0;$ert['mname'] = '';$ert['code'] = $code;
			$ert['title'] = "My Network";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('home/client_view',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function get_boq_details($code,$boq_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual WHERE iextetboqm_boq_id = '$boq_id' AND iextetboqm_uid = '$uid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetboqm_file;
			}

			$path = $this->config->item('document_rt')."assets/data/boq/";
            $fl = $path.$file_name;
            $data_arr = json_decode(file_get_contents($fl));

			print_r(json_encode($data_arr));
			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function send_boq_details($code,$boq_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;

			$jarr = $this->input->post('table_arr');

			$upload_dir = $this->config->item('document_rt')."assets/data/boq/";
			$fl = '';
			$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual WHERE iextetboqm_boq_id = '$boq_id' AND iextetboqm_uid = '$uid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$fl = $upload_dir.$result[0]->iextetboqm_file;
			}

			$handle = fopen($fl, 'w') or die('Error');
			fwrite($handle, json_encode($jarr));
			fclose($handle);

			$data = array(
			  	'iextetboqm_status' => 'done'
			);
			$this->db->WHERE(array('iextetboqm_boq_id' => $boq_id , 'iextetboqm_uid' => $uid ));
			$this->db->update('i_ext_et_boq_mutual',$data);

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}
	
################### Home View ###################
	public function change_view($code,$type=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;

			$this->db->where('i_uid',$oid);
			$this->db->update('i_users',array('i_u_home_view' => $type));

			if ($type == 'default_view') {
				echo $this->default_view($code);
			}else if ($type == 'manager_view') {
				echo $this->manager_view($code);
			}else if ($type == 'employee_view') {
				echo $this->employee_view($code);
			}else if ($type == 'inventory_view') {
				echo $this->inventory_view($code);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function default_view($code,$type=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mname = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}

			if ($type == null) {
				$data['type'] = 'home';
			}else{
				$data['type'] = $type;
			}

			$displays = array();
			$modid = array();

			$dt=date('Y-m-d');

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND DATE(iua_date)='$dt' UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT in('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' ) ORDER BY iua_date DESC");
			$data['s_activity'] = $query->result();

			$query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
			$result = $query->result();
			$property = [];
			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					array_push($property,$result[$i]->iextpt_aid);
				}
				$p_aid = 0;
				if (count($property) > 0 ) {
					$p_aid = implode(',', $property);
				}

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$dt' AND iua_id IN ($p_aid) UNION SELECT * FROM i_user_activity WHERE iua_status = 'progress' AND iua_id IN ($p_aid) ");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) { 
					array_push($data['s_activity'], $result[$i]);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			$data['s_activity_todo'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') AND iua_g_id IN (SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' GROUP BY ium_gid) AND iua_g_id != 0 UNION SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND iua_g_id != 0 AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND iua_g_id != 0 AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' )  ORDER BY iua_date DESC");
			$data['g_activity'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			$data['g_activity_todo'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND DATE(iua_date)='$dt'UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) UNION SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') AND iua_g_id IN (SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' GROUP BY ium_gid) AND iua_g_id != 0 UNION SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND iua_g_id != 0 AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE iua_created_by = '$uid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' ) ORDER BY iua_date DESC");
			$data['a_activity'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			$data['a_activity_todo'] = $query->result();

			// if($gid == 0){
				// $query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND DATE(iua_date)='$dt'UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT in('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' ) ORDER BY iua_date DESC");
				// $data['s_activity'] = $query->result();

				// $query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
				// $data['s_activity_todo'] = $query->result();

				// $query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') AND iua_g_id IN (SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' GROUP BY ium_gid) AND iua_g_id != 0 UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id != 0 AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id != 0 AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' )  ORDER BY iua_date DESC");
				// $data['g_activity'] = $query->result();

				// $query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
				// $data['g_activity_todo'] = $query->result();

				// $query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND DATE(iua_date)='$dt'UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') AND iua_g_id IN (SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' GROUP BY ium_gid) AND iua_g_id != 0 UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id != 0 AND iua_status = 'progress' UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' ) ORDER BY iua_date DESC");
				// $data['a_activity'] = $query->result();

				// $query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
				// $data['a_activity_todo'] = $query->result();
			// }else{
			// 	if ($oid == $uid) {
			// 		$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_status = 'progress' AND iua_type NOT IN('module', 'note') UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_status != 'done' AND iua_id IN (SELECT iuaal_aid FROM i_u_a_active_list WHERE iuaal_owner = '$oid' ) ORDER BY iua_date DESC");
			// 		$data['s_activity'] = $query->result();
			// 	}else{
			// 		$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND DATE(iua_date)='$dt' AND iua_type NOT IN('module', 'note') UNION SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_g_id = '$gid' AND iua_status = 'progress' AND iua_type NOT IN('module', 'note') UNION SELECT * FROM i_user_activity WHERE DATE(iua_date)='$dt' AND iua_g_id = '$gid' AND iua_type NOT IN('module', 'note') AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid')) ORDER BY iua_date DESC");
			// 		$data['s_activity'] = $query->result();

					// $query = $this->db->query("SELECT iextpt_aid FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = $uid AND iextprour_group = 'true' AND iextprour_task_gid != '' )");
					// $result = $query->result();
					// $property = [];
					// if (count($result) > 0 ) {
					// 	for ($i=0; $i <count($result) ; $i++) { 
					// 		array_push($property,$result[$i]->iextpt_aid);
					// 	}
					// 	$p_aid = implode(',', $property);

					// 	$query = $this->db->query("SELECT * FROM i_user_activity WHERE DATE(iua_date) = '$dt' AND iua_id IN ($p_aid) UNION SELECT * FROM i_user_activity WHERE iua_status = 'progress' AND iua_id IN ($p_aid) ");
					// 	$result = $query->result();
					// 	for ($i=0; $i <count($result) ; $i++) { 
					// 		array_push($data['s_activity'], $result[$i]);
					// 	}	
					// }
				// }

			// 	$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			// 	$data['s_activity_todo'] = $query->result();
			// }

			$query = $this->db->query("SELECT ic_name,ic_uid FROM i_customers WHERE ic_uid IN (SELECT iua_modified_by FROM i_user_activity)");
			$data['activity_perform'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_u_a_person as a left join i_customers as b on a.iuap_p_id=b.ic_id WHERE a.iuap_owner = '$oid'");
			$data['activity_person'] = $query->result();
			
			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid'");
			$data['users'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id WHERE iukpi_id NOT IN(SELECT iuk_kpi_id FROM i_user_kpi WHERE iuk_uid = '$oid' AND iuk_gid = '$gid' AND iuk_mid = '0') AND iukpi_module IN(SELECT ium_m_id FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid')");
			$result = $query->result();
			$data['widget'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_key_performance_indicators AS a LEFT JOIN i_domain AS b ON a.iukpi_domain=b.idom_id LEFT JOIN i_modules AS c ON a.iukpi_module=c.im_id WHERE iukpi_id IN(SELECT iuk_kpi_id FROM i_user_kpi WHERE iuk_uid = '$oid' AND iuk_gid = '$gid' AND iuk_mid = '0')");
			$result = $query->result();
			$displays = array();

			for ($j=0;$j<count($result);$j++) { 
				$dt = date('Y-m-d');
				$que_str = $result[$j]->iukpi_query;

				eval("\$que_str = \"$que_str\";");
				
				$que = $this->db->query($que_str);
				$res = $que->result_array();
				
				if(count($res) > 0) {
					$wer = '';
					if($result[$j]->iukpi_display_type == "table") {
						$wer .= '<table  class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">';
						foreach ($res as $key => $value) {
							$wer .= '<tr>';
							foreach ($value as $key1 => $value1) {
								$wer.= '<th class="mdl-data-table__cell--non-numeric">'.$key1."</th>";
							}
							$wer .= '</tr>';
							break;
						}
						foreach ($res as $key => $value) {
							$wer.="<tr>";
							foreach ($value as $key1 => $value1) {
								$wer.= '<td class="mdl-data-table__cell--non-numeric">'.$value1."</td>";
							}
							$wer.="</tr>";
						}
						$wer.='</table>';
					} else if($result[$j]->iukpi_display_type == "number") {
						$wer .= '<div class="mdl-grid">';
						$wer .= '<h1 style="font-size:6em;">';
						foreach ($res as $key => $value) {
							foreach ($value as $key1 => $value1) {
								$wer.= " ".$value1;
							}
							$wer.="<br>";
						}
						$wer.='</h1></div>';
					} else if($result[$j]->iukpi_display_type == "line") {
						$red = rand(10, 255);
						$green = rand(10, 255);
						$blue = rand(10, 255);
						$opacity = rand(0.0, 1.0);
						$wer .= '<canvas id="'.$j.'line" width="400" height="300"></canvas>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'line").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "line", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: "rgba('.$red.','.$green.','.$blue.',1)"}] }, options: {scales: {yAxes: [{ticks: {beginAtZero:true } }] } } }); </script>';

					} else if($result[$j]->iukpi_display_type == "bar") {
						$red = rand(10, 255);
						$green = rand(10, 255);
						$blue = rand(10, 255);
						$opacity = rand(0.0, 1.0);
						
						$wer .= '<canvas id="'.$j.'bar" width="400" height="300"></canvas> </div> </div>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'bar").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "bar", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: "rgba('.$red.','.$green.','.$blue.',1)"}] }, options: {scales: {yAxes: [{ticks: {beginAtZero:true } }] } } }); </script>';
					
					} else if($result[$j]->iukpi_display_type == "pie") {
						
						$arr_color = [];

						$opacity = rand(0.0, 1.0);

						$wer .= '<canvas id="'.$j.'pai" width="400" height="300"></canvas>';
						$wer .= '<script> var ctx = document.getElementById("'.$j.'pai").getContext("2d");';
						$labels = [];
						$values = [];
						$value_title = "";
						foreach ($res as $key => $value) {
							$state = false;
							foreach ($value as $key1 => $value1) {
								if ($state == false) {
									array_push($labels, $value1);
									$state = true;
								} else {
									$red = rand(10, 255);
									$green = rand(10, 255);
									$blue = rand(10, 255);

									$color = 'rgba('.$red.','.$green.','.$blue.',1)';
									array_push($arr_color, $color);
									array_push($values, $value1);
									$value_title = $key1;
									$state = false;
								}
							}
						}

						$labels_str = json_encode($labels);
						$values_str = "[".implode(',', $values)."]";
						$wer .= 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: '.json_encode($arr_color).' }] }, options: { title : { display: true, fontSize : 20 } , rotation : -0.1 * Math.PI } }); </script>';
					}

					$chart = $wer;
					$title = $result[$j]->iukpi_title;
					$desc = $result[$j]->iukpi_desc;

					$path = $this->config->item('document_rt')."assets/data/portal/kpi/";
                    if ($result[$j]->iukpi_code != '') {
                        $d_file = file_get_contents($path.$result[$j]->iukpi_code.'.txt');
                    }else{
                        $d_file = '';
                    }
					$dis ='';
					eval("\$dis = \"$d_file\";");
					array_push($displays, $dis);
				}
			}
			$data['get_chart'] = $displays;
			$data['code'] = $code;
			$data['gid'] = $gid;
			$this->load->view('home/default_view', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function manager_view($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$dt = DATE('Y-m-d H:i:s');

		/////////// Opportunity ////////////
			$module = $sess_data['user_mod'];
			$module_id = 0;
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Opportunity') {
					$module_id = $module[$i]->mid;
				}
			}
			$data['oppo_activity_update'] = [];
			$data['oppo_activity_next'] = [];
			$data['oppo_mutual'] = [];
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ORDER BY iextetop_created DESC");
				$result = $query->result();
				$data['opportunity'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result)> 0 || $oid == $uid){
					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opportunity'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_created_by = '$uid' AND iextetop_gid = '$gid' UNION SELECT * FROM i_ext_et_opportunity WHERE iextetop_id IN(SELECT iexteom_op_id FROM i_ext_et_opportunity_mutual WHERE iexteom_uid = $uid AND iexteom_oid = $oid) ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opportunity'] = $result;
				}
			}

			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					$oppo_id = $result[$i]->iextetop_id;
					$query = $this->db->query("SELECT * FROM i_user_activity as a left JOIN i_ext_et_opportunity_activity as b on a.iua_id = b.iexteoa_aid WHERE iua_owner = '$oid' AND iexteoa_oppo_id = '$oppo_id' AND iua_date < '$dt' AND iua_status = 'done' ORDER BY iua_date DESC");
					$res = $query->result();
					if (count($res) > 0 ) {
						array_push( $data['oppo_activity_update'], $res[0]);
					}

					$query = $this->db->query("SELECT * FROM i_user_activity as a left JOIN i_ext_et_opportunity_activity as b on a.iua_id = b.iexteoa_aid WHERE iua_owner = '$oid' AND iexteoa_oppo_id = '$oppo_id' AND iua_date > '$dt' AND iua_status IN ('pending','progress','reschedule') ORDER BY iua_date DESC");
					$res = $query->result();
					if (count($res) > 0 ) {
						array_push( $data['oppo_activity_next'], $res[0]);
					}

					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_mutual as a LEFT JOIN i_customers as b on b.ic_uid = a.iexteom_uid WHERE iexteom_op_id = '$oppo_id' ");
					$res = $query->result();
					if(count($res) > 0) { 
						array_push( $data['oppo_mutual'], $res[0]);
					}
				}
			}

		/////////// Requirement ////////////
			$module_id = 0;
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Requirement') {
					$module_id = $module[$i]->mid;
				}
			}
			$data['req_list'] = [];
			$data['req_notes'] = [];
			$data['req_tag'] = [];
			$data['req_owner'] = [];
			$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_owner = '$oid' AND iextetr_gid = '$gid' ");
			$result = $query->result();
			$data['req'] = $result;
			for ($i=0; $i < count($result) ; $i++) { 
				$req_id = $result[$i]->iextetr_id;

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_product as a LEFT JOIN i_product as b on a.iextetrp_product_id = b.ip_id WHERE iextetrp_req_id = '$req_id' ");
				$res = $query->result();
				if (count($res) > 0) {
					array_push($data['req_list'], $res);	
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_notes WHERE iextetrn_req_id = '$req_id' ORDER BY iextetrn_id ASC ");
				$res = $query->result();
				if (count($res) > 0) {
					array_push($data['req_notes'], $res);
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_requirement_mutual as a LEFT JOIN i_customers as b on a.iextetrm_uid = b.ic_uid WHERE iextetrm_req_id = '$req_id' AND ic_owner = '$oid' ");
				$res = $query->result();
				for ($ij=0; $ij < count($res) ; $ij++) {
					array_push($data['req_tag'], $res[$ij]);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_requirement as a LEFT JOIN i_customers as b on a.iextetr_created_by = b.ic_uid WHERE iextetr_owner = '$oid' AND iextetr_gid = '$gid' AND ic_owner = '$oid' ");
			$res = $query->result();
			for ($ij=0; $ij < count($res) ; $ij++) {
				array_push($data['req_owner'], $res[$ij]);
			}

		/////////// Project ////////////
			$module_id = 0;
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Projects') {
					$module_id = $module[$i]->mid;
				}
			}
			$data['pro_activity_update'] = [];
			$data['pro_activity_next'] = [];
			$admin = 'false';
			if($gid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$uid' AND iug_id = '$gid'");
				$result = $query->result();
				if (count($result) > 0){
					$admin = 'true';
				}else{
					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$module_id'");
					$result = $query->result();
					if (count($result) > 0) {
						$admin = 'true';
					}
				}
				$pro_act = [];
				if ($admin == 'true') {
					$pro_act_list = [];
					$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid'");
					$result = $query->result();
	    			$data['projects'] = $result;
	    			$data['userflow'] = "true";
	    			for ($ij=0; $ij < count($result) ; $ij++) {
	    				$pro_id = $result[$ij]->iextpp_id ;
	    				$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' GROUP BY b.iua_status ");
	    				$res = $q->result();
	    				for ($i=0; $i < count($res) ; $i++) {
	    					array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
	    				}
	    				$que = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND b.iua_owner = '$oid' AND b.iua_g_id = '$gid' AND b.iua_status = 'progress' ORDER BY b.iua_id DESC limit 5 ");
		    			$res1 = $que->result();
		    			for ($i=0; $i < count($res1) ; $i++) {
	    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res1[$i]->iua_id , 'title' => $res1[$i]->iua_title ));
	    				}
	    			}
	    			$data['act_list'] = $pro_act_list;
	    			$data['pro_act'] = $pro_act;
				}else{
					$pro_act_list = [];
					$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' AND iextpp_id IN(SELECT iextprour_pid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_group = 'true')");
					$result = $query->result();
	    			$data['projects'] = $result;
	    			$data['userflow'] = "false";
	    			for ($ij=0; $ij < count($result) ; $ij++) {
	    				$pro_id = $result[$ij]->iextpp_id ;
	    				$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND a.iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL)  GROUP BY b.iua_status ");
	    				$res = $q->result();
	    				
	    				for ($i=0; $i < count($res) ; $i++) { 
	    					array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
	    				}

	    				$q = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND iua_status = 'progress' AND a.iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ORDER BY iua_id DESC limit 5 ");
		    			$res = $q->result();
		    			for ($i=0; $i < count($res) ; $i++) {
	    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res[$i]->iua_id , 'title' => $res[$i]->iua_title ));
	    				}
	    			}

	    			$data['act_list'] = $pro_act_list;
	    			$data['pro_act'] = $pro_act;
				}
			} else {
			    $query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' ");
    			$result = $query->result();
    			$data['projects'] = $result;
    			$pro_act = [];
    			$pro_act_list = [];
    			for ($ij=0; $ij < count($result) ; $ij++) {
					$pro_id = $result[$ij]->iextpp_id ;
					$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' GROUP BY b.iua_status ");
					$res = $q->result();
					for ($i=0; $i < count($res) ; $i++) { 
						array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
					}

					$q = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND iua_status = 'progress' ORDER BY iua_id DESC limit 5 ");
	    			$res = $q->result();
	    			for ($i=0; $i < count($res) ; $i++) { 
    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res[$i]->iua_id , 'title' => $res[$i]->iua_title ));
    				}
				}
				$data['act_list'] = $pro_act_list;
				$data['pro_act'] = $pro_act;
			}
			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					$pro_id = $result[$i]->iextpp_id;
					$query = $this->db->query("SELECT * FROM i_user_activity as a left JOIN i_ext_pro_task as b on a.iua_id = b.iextpt_aid WHERE iua_owner = '$oid' AND iextpt_p_id = '$pro_id' AND iua_date < '$dt' AND iua_status IN ('pending','progress') ORDER BY iua_date DESC");
					$res = $query->result();
					if (count($res) > 0 ) {
						array_push( $data['pro_activity_next'], $res[0]);
					}
				}
			}

			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					$pro_id = $result[$i]->iextpp_id;
					$query = $this->db->query("SELECT * FROM i_user_activity as a left JOIN i_ext_pro_task as b on a.iua_id = b.iextpt_aid WHERE iua_owner = '$oid' AND iextpt_p_id = '$pro_id' AND iua_date < '$dt' AND iua_status NOT IN ('pending','progress') ORDER BY iua_date DESC");
					$res = $query->result();
					if (count($res) > 0 ) {
						array_push( $data['pro_activity_update'], $res[0]);
					}
				}
			}
			$data['pro_manage'] = [];
			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					$pro_id = $result[$i]->iextpp_id;
					$query = $this->db->query("SELECT * FROM i_ext_pro_user_role as a LEFT JOIN i_customers as b on a.iextprour_uid = b.ic_uid WHERE iextprour_pid = '$pro_id' AND iextprour_group = 'true' AND iextprour_project = 'true' AND ic_owner = '$oid' AND ic_uid IS NOT NULL  ");
					$res = $query->result();
					if (count($res) > 0 ) {
						array_push( $data['pro_manage'], $res[0]);
					}
				}
			}
			$this->load->view('home/manager_view',$data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function employee_view($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mname = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}
			$data['v_type'] = 'employee_view';
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section LIKE '%employee%' AND ic_owner = '$oid' AND ic_uid IS NOT NULL ");
			$result = $query->result();
			$data['emp_list'] = $result;
			$emp_id = [];
			for ($i=0; $i < count($result) ; $i++) { 
				array_push($emp_id, $result[$i]->ic_uid);
			}
			if (count($emp_id) > 0){
				$emp_list = implode(',', $emp_id);	
			}else{
				$emp_list = 0;
			}
			$query = $this->db->query("SELECT * FROM i_user_activity as a LEFT JOIN i_u_a_log as b on a.iua_id = b.iual_a_id WHERE a.iua_owner = '$oid' AND a.iua_g_id = '$gid' AND b.iual_created_by IN ($emp_list) ORDER BY iual_created  DESC");
			$result = $query->result();
			$data['emp_progress'] = $result;
			
			$this->load->view('home/employee_view',$data);
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_view($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mname = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}
			$data['v_type'] = 'inventory_view';

			
			
			$this->load->view('home/inventory_view',$data);
		}else{
			redirect(base_url().'Account/login');
		}
	}
}