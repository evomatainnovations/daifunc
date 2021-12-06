<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}

########################## Support #############################
	public function home($mid = null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Support') {
						$mod_id = $module[$i]->mid;
						$dom = $module[$i]->domain;
						$mname = 'Support';
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_support as a LEFT JOIN i_customers as b on a.ies_cid = b.ic_id WHERE ies_owner = '$oid' AND ies_gid = '$gid' ");
			$result = $query->result();
			$data['support'] = $result;
			$data['tkt_id'] = count($result) + 1 ;

			$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_owner = '$oid' GROUP BY ies_category ");
			$result = $query->result();
			$data['s_status'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
			$data['cust_data'] = $query->result();

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	   //          $data['use_modules'] = $query->result();

	   //          $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
	   //          $result = $query->result();
	   //          $data['tags'] = $result;

	   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
	   //          $result = $query->result();
	   //          $data['status'] = $result;

	   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
	   //          $result = $query->result();
	   //          $data['place'] = $result;

	   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
	   //          $result = $query->result();
	   //          $data['cat'] = $result;

	   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	   //          $result = $query->result();
	   //          $data['user_list'] = $result;

            $data['client_view'] = 'false';

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mod_id;$ert['mname']='Support';$ert['dom']=$dom;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('support/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_support($code,$tkt_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$cname = $this->input->post('sp_cust');

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE ic_owner = '$oid' AND ic_name = '$cname' AND icbd_property = '$p_id' ");
			$result = $query->result();
			$cid = 0;
			$c_mail = '';
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;
				$c_mail = $result[0]->icbd_value;
			}
			$data = array(
				'ies_ticket_id' => $tkt_id,
				'ies_cid' => $cid,
				'ies_category' => $this->input->post('sp_cat'),
				'ies_subject' => $this->input->post('sp_sub'),
				'ies_desc' => $this->input->post('sp_desc'),
				'ies_date' => $this->input->post('sp_date'),
				'ies_priority' => $this->input->post('sp_status'),
				'ies_contact_person' => $this->input->post('sp_person'),
				'ies_remark' => $this->input->post('sp_remark'),
				'ies_owner' => $oid,
				'ies_created' => $dt,
				'ies_created_by' => $uid,
				'ies_gid' => $gid,
				'ies_user_type' => 'main_user'
			);
			$this->db->insert('i_ext_support',$data);

			$subject = 'Your complaint number '.$tkt_id;
			$body = 'Your complaint number '.$tkt_id;
			$this->Mail->send_mail($subject,$c_mail,null,$body,$code);

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function support_filter($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$from_date = $this->input->post('from');
			$to_date = $this->input->post('to');
			$status = $this->input->post('in_status');
			$in_created = $this->input->post('in_created');

			if ($in_created != null) {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$in_created' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$in_created = $result[0]->ic_id;
				}
			}

			$this->db->select('*');
			$this->db->from('i_ext_support');
			$this->db->join('i_customers', 'i_customers.ic_id = i_ext_support.ies_cid','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('ies_date >=', $from_date);
				$this->db->where('ies_date <=', $to_date);
			}
			if ($in_created != '') {
				$this->db->where('ies_cid', $in_created);
			}
			if ($status != '') {
				$this->db->where('ies_category', $status);
			}
			$this->db->where('i_ext_support.ies_owner', $oid);
			$this->db->where('i_ext_support.ies_gid', $gid);
			$this->db->group_by('i_ext_support.ies_id');
			$query = $this->db->get();
			$data['filter'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function support_details($code,$sid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Support') {
						$mod_id = $module[$i]->mid;
						$dom = $module[$i]->domain;
						$mname = 'Support';
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			// $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value");
			// $result = $query->result();
			// $data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			// $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' GROUP BY iua_place");
			// $result = $query->result();
			// $data['place'] = $result;

			// $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' GROUP BY iua_categorise");
			// $result = $query->result();
			// $data['cat'] = $result;

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			// $result = $query->result();
			// $data['user_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_support as a LEFT JOIN i_customers as b on a.ies_cid = b.ic_id WHERE ies_owner = '$oid' AND ies_id = '$sid' AND ies_gid = '$gid' ");
			$result = $query->result();
			$data['support'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_support_activity as a LEFT JOIN i_user_activity as b on a.iesa_aid = b.iua_id LEFT JOIN i_u_a_log as c on a.iesa_aid = c.iual_a_id LEFT JOIN i_u_a_person  as d on b.iua_id = d.iuap_a_id LEFT JOIN i_customers as e on d.iuap_p_id = e.ic_id WHERE iesa_sid = '$sid' AND iesa_owner = '$oid' AND iua_g_id = '$gid' ORDER BY iual_id DESC ");
			$result = $query->result();
			// for ($i=0; $i < count($result) ; $i++) { 
			// 	print_r($result[$i]);
			// 	echo '<br>';
			// }
			$data['s_details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_id = '$sid' AND ies_owner = '$oid' AND ies_gid = '$gid' ");
			$result = $query->result();
			$s_cid = $result[0]->ies_cid;

			$query = $this->db->query("SELECT ies_category as cat, count(ies_id) as c_count FROM i_ext_support WHERE ies_cid = '$s_cid' AND ies_owner = '$oid' GROUP BY ies_category ");
			$result = $query->result();
			$data['s_chart'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id = '$s_cid' ");
			$result = $query->result();
			$data['c_name'] = $result[0]->ic_name;
			$data['edit_person'] = $result;

			$data['sid'] = $sid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];

			$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mod_id;$ert['mname']='Support';$ert['dom']=$dom;
			if ($alias == '') {
				$ert['title'] = $mname." Details";
			}else{
				$ert['title'] = $alias." Details";
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('support/support_details', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function activity_save($code,$sid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt=date('Y-m-d');
			$tags = $this->input->post('a_tags');
			$gid = $sess_data['gid'];
			$a_flg = $this->input->post('a_mail');
			$type = 'support';
			$td = $this->input->post('a_to_do'); $flg=0;
			if (count($td) > 0) {
				$flg=1;
			}

			$note = $this->input->post('note');
			$person = $this->input->post('a_person');
			$a_date = $this->input->post('a_date');
			$e_date = $this->input->post('e_date');
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
				'iua_status' => 'progress',
				'iua_owner' => $oid,
				'iua_created_by' => $uid,
				'iua_created' => date('Y-m-d H:i:s'),
				'iua_categorise' => $this->input->post('a_cat'),
				'iua_p_activity' => 0,
				'iua_shortcuts' => $fid,
				'iua_m_shortcuts' => $mod_id,
				'iua_g_id' => $gid,
				'iua_modified_by' => $uid,
				'iua_color' => $this->input->post('a_color'),
				'iua_end_date' => $e_date
			);
			$this->db->insert('i_user_activity',$data);
			$aid = $this->db->insert_id();

			for ($i=0; $i <count($person) ; $i++) { 
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
				$result = $query->result();
				$cust_id = $result[0]->ic_id;
				$data = array(
					'iuap_a_id' => $aid,
					'iuap_p_id' => $cust_id,
					'iuap_owner'=> $oid
				);
				$this->db->insert('i_u_a_person',$data);

				$data1 = array(
					'in_type_id' => $aid, 
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $cust_id,
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
				'iual_title' => 'allot'
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
				'iesa_sid' => $sid,
				'iesa_aid' => $aid,
				'iesa_code' => $res,
				'iesa_created' => $dt,
				'iesa_created_by' => $uid,
				'iesa_owner' => $oid
			);
			$this->db->insert('i_ext_support_activity',$data);

			if ($a_flg == 'true') {
				redirect(base_url().'Home/activity_mail/'.$aid.'/'.$code);
			}else{
				echo "true";
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function support_transfer($code,$sid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('ies_id' => $sid, 'ies_owner' => $oid));
			$this->db->update('i_ext_support',array('ies_gid' => $gid));
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}
	// public function search_details($code){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];
	// 		$data['oid'] = $oid;

	// 		$cname = $this->input->post('cust_name');

	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value LIKE '%$cname%' ) GROUP BY ic_id");
	// 		$data['cust_data'] = $query->result();

	// 		print_r(json_encode($data));
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }
}