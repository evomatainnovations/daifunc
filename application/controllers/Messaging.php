<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messaging extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}

	public function index($code)	{
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$m_id = [];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['code'] = $code;
			$mid = 0;
			$mname = '';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Messaging') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			$displays = array();
			$modid = array();

			for ($i=0; $i < count($module) ; $i++) { 
				array_push($modid, $module[$i]->mid);
			}

			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_status = 'true' AND ime_id IN (SELECT imm_m_id FROM i_m_members WHERE imm_c_id='$uid')");
			$data['messages'] = $query->result();

			for ($i=0; $i < count($module) ; $i++) { 
			    if ($module[$i]->status == 'active') {
			    	array_push($m_id, $module[$i]->mid);
			    }
			}
			
			$cust_str = implode(",", $m_id);

			if(count($m_id) > 0){
				$query = $this->db->query("SELECT * FROM  i_modules WHERE im_id IN ($cust_str)");
				$data['modules'] = $query->result();
			}

			$ert['code'] = $code;
			$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;
			$ert['mid'] = $mid;
			$data['display'] = $displays;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Messaging";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('messaging/messaging', $data);
			$this->load->view('home/search_modal');

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function search_messages_contacts($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['owner'] = $oid;
			$s = $this->input->post('s');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_name LIKE '%$s%' ");
			$res = $query->result();
			if (count($res) > 0 ) {
				for ($i=0; $i < count($res) ; $i++) { 
					$s_cid = $res[$i]->ic_id;
					if ($res[$i]->ic_uid != '' || $res[$i]->ic_uid != null ) {
						$data = array(
							'ic_msg_invite' => 1
						);
						$this->db->where(array('ic_id' => $s_cid));
						$this->db->update('i_customers',$data);	
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_name LIKE '%$s%' ");
			$data['customer'] = $query->result();			

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_chat_history($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$c_uid = 0 ;
			$customer = [];
			$query = $this->db->query("SELECT * FROM i_m_members as a LEFT JOIN i_messaging as b on a.imm_m_id = b.ime_id WHERE imm_c_id ='$uid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) {
					$msg_id = $result[$i]->imm_m_id;

					$q = $this->db->query("SELECT * FROM i_m_members WHERE imm_m_id ='$msg_id'");
					$res = $q->result();
					if (count($res) > 2 ) {
						for ($ij=0; $ij < count($res) ; $ij++) { 
							if ($res[$ij]->imm_c_id != $uid) {
								$c_uid = $res[$ij]->imm_c_id;
								$title = $result[$i]->ime_title;
							}
						}
						$q = $this->db->query("SELECT * FROM i_customers WHERE ic_uid = '$c_uid' ");
						$r = $q->result();
						$cid = 0;
						if (count($r) > 0 ) {
							$cid = $r[0]->ic_id;
							array_push($customer , array('id' => $cid , 'title' => $title , 'msg_id' => $msg_id , 'uid' => $c_uid , 'invite' => $r[0]->ic_msg_invite ,'1' => '1'));
						}
					}else{
						for ($ij=0; $ij < count($res) ; $ij++) {
							if ($res[$ij]->imm_c_id != $uid) {
								$c_uid = $res[$ij]->imm_c_id;
							}
						}

						$q = $this->db->query("SELECT * FROM i_customers WHERE ic_uid = '$c_uid' ");
						$r = $q->result();
						$cid = 0;
						if (count($r) > 0 ) {
							$cid = $r[0]->ic_id;
							array_push($customer , array('id' => $cid , 'title' => $r[0]->ic_name , 'msg_id' => $msg_id , 'uid' => $c_uid , 'invite' => $r[0]->ic_msg_invite,'2' => '2' ));
						}
					}
				}
			}
			$data['customer'] = $customer;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function check_chat_history($code,$cid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$c_uid = 0 ;
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_id = '$cid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$c_uid = $result[0]->ic_uid;
			}
			$data['msg_id'] = 0;
			$query = $this->db->query("SELECT * FROM i_m_members WHERE imm_c_id ='$c_uid'");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($i=0; $i < count($result) ; $i++) { 
					$msg_id = $result[$i]->imm_m_id;
					$query = $this->db->query("SELECT * FROM i_m_members WHERE imm_m_id = '$msg_id'");
					$res = $query->result();
					if (count($res) == 2 ) {
						$data['msg_id'] = $msg_id;
					}
				}
			}else{
				$data['msg_id'] = 0;
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_messages($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$handle ='';

			$msg_id = $this->input->post('i');

			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_id ='$msg_id'");
			$result = $query->result();

			$path = $this->config->item('document_rt')."assets/data/msg/";
			$data=[];
			if (count($result) > 0) {
				$fl = $path.$result[0]->ime_file.'.json';
				array_push($data, json_decode(file_get_contents($fl)));

				for ($i=0; $i < count($data[0]) ; $i++) {
					$ruid = [];
					if (isset($data[0][$i]->data->unread)) {
						for ($ij=0; $ij < count($data[0][$i]->data->unread) ; $ij++) {
							if ($uid == $data[0][$i]->data->unread[$ij]) {
								$r_uid = $uid;
								array_splice($data[0][$i]->data->unread , $ij, 1);
								array_push($data[0][$i]->data->read , $r_uid );
								$this->db->WHERE(array('in_type_id' => $msg_id, 'in_type' => 'messaging' , 'in_owner' => $r_uid ));
								$this->db->delete('i_notifications');
							}
						}
					}
				}

				if (is_dir($path)&& is_writable($path)) {
					$jstr = json_encode($data[0]);
					$handle = fopen($fl, 'w') or die('Error');
					fwrite($handle, $jstr);
					fclose($handle);
				}

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_uid IN(SELECT imm_c_id FROM i_m_members WHERE imm_m_id ='$msg_id') GROUP BY ic_uid");
				$result = $query->result();
				$data['uname'] = $result;

				$data['m_owner']= $uid;

				print_r(json_encode($data));
			}else{
				echo "error";
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_function($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$mid = $this->input->post('m');
				
			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a left join i_function as b on a.ims_function = b.ifun_id WHERE ims_m_id = '$mid'");
			$data['s_function'] = $query->result();
			
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_modules($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$m_function = $this->input->post('m_function');
				
			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a left join i_function as b on a.ims_function = b.ifun_id left join i_domain as c on b.ifun_domain_id=c.idom_id WHERE ims_function = '$m_function'");
			$result = $query->result();

			echo base_url().$result[0]->idom_name.'/'.$result[0]->ifun_name.'/'.$result[0]->ims_m_id;	

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function send_share_data($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$type = $this->input->post('type');
			$type_name = $this->input->post('type_name');
            $type_id = $this->input->post('type_id');
            $req_arr = $this->input->post('req_arr');
            $boq_arr = $this->input->post('boq_arr');
            $oppo_arr = $this->input->post('oppo_arr');
            $project_arr = $this->input->post('project_arr');
            $grp_list = $this->input->post('grp_list');
            $cat_list = $this->input->post('dm_cat');
            $to_cid = $this->input->post('share_to');
            $module = $sess_data['user_mod'];
            $mid = 0;
            if ($type == 'oppo') {
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Opportunity') {
						$mid = $module[$i]->mid;
						$mname = 'Opportunity';
					}
				}
            }else if ($type == 'req') {
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Requirement') {
						$mid = $module[$i]->mid;
						$mname = 'Requirement';
					}
				}
            } else if ($type == 'dm'){
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Design Manager') {
						$mid = $module[$i]->mid;
						$mname = 'Design Manager';
					}
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_type = '$type_name' AND iextetdm_type_id = '$type_id' AND iextetdm_owner = '$oid' ");
	            $result = $query->result();
	            if (count($result) > 0 ) {
	            	$type_id = $result[0]->iextetdm_id;
	            }
            } else if ($type == 'boq'){
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'BOQ') {
						$mid = $module[$i]->mid;
						$mname = 'BOQ';
					}
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_type = '$type_name' AND iextetboq_type_id = '$type_id' AND iextetboq_owner = '$oid' ");
	            $result = $query->result();
	            if (count($result) > 0 ) {
	            	$type_id = $result[0]->iextetboq_id;
	            }
            } else if ($type == 'project'){
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = 'Projects';
					}
				}
            }

            $to_uid = 0 ;
            $query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$to_cid' AND ic_owner = '$oid' ");
            $result = $query->result();
            if (count($result) > 0 ) {
            	$to_uid = $result[0]->ic_uid;
            }

            $data = array(
            	'iextetes_mid' => $mid,
				'iextetes_type' => $mname,
				'iextetes_type_id' => $type_id,
				'iextetes_from' => $uid,
				'iextetes_to' => $to_uid,
				'iextetes_created' => $dt,
				'iextetes_created_by' => $uid,
				'iextetes_owner' => $oid,
  				'iextetes_gid' => $gid
            );
            $this->db->insert('i_ext_et_extension_share',$data);
            $inid = $this->db->insert_id();

            if ($type == 'oppo') {
            	for ($i=0; $i < count($oppo_arr) ; $i++) {
            		if ($oppo_arr[$i]['flg'] == 'true' ) {
            			$data = array(
							'iextetesi_sid' => $inid,
							'iextetesi_type' => $oppo_arr[$i]['name'],
							'iextetesi_owner' => $oid
						);
						$this->db->insert('i_ext_et_extension_share_info',$data);
            		}
            	}
            }else if ($type == 'req') {
            	for ($i=0; $i < count($req_arr) ; $i++) {
            		if ($req_arr[$i]['flg'] == 'true' ) {
            			$data = array(
							'iextetesi_sid' => $inid,
							'iextetesi_type' => $req_arr[$i]['name'],
							'iextetesi_owner' => $oid
						);
						$this->db->insert('i_ext_et_extension_share_info',$data);
            		}
            	}
            }else if ($type == 'dm') {
            	for ($i=0; $i < count($cat_list) ; $i++) {
            		$cat_name = $cat_list[$i];
        			$data = array(
						'iextetesi_sid' => $inid,
						'iextetesi_type' => $cat_name,
						'iextetesi_owner' => $oid
					);
					$this->db->insert('i_ext_et_extension_share_info',$data);
            	}
            }else if ($type == 'boq'){
            	for ($i=0; $i < count($boq_arr) ; $i++) {
            		if ($boq_arr[$i]['flg'] == 'true') {
            			$boq_name = $boq_arr[$i]['name'];
	        			$data = array(
							'iextetesi_sid' => $inid,
							'iextetesi_type' => $boq_name,
							'iextetesi_owner' => $oid
						);
						$this->db->insert('i_ext_et_extension_share_info',$data);	
            		}
            	}
            }else if ($type == 'project'){
            	for ($i=0; $i < count($project_arr) ; $i++) {
            		if ($project_arr[$i]['flg'] == 'true') {
            			$pro_name = $project_arr[$i]['name'];
	        			$data = array(
							'iextetesi_sid' => $inid,
							'iextetesi_type' => $pro_name,
							'iextetesi_owner' => $oid
						);
						$this->db->insert('i_ext_et_extension_share_info',$data);	
            		}
            	}

            	for ($i=0; $i < count($grp_list) ; $i++) {
        			$grp_name = $grp_list[$i];
        			$data = array(
						'iextetesi_sid' => $inid,
						'iextetesi_type' => $grp_name,
						'iextetesi_owner' => $oid
					);
					$this->db->insert('i_ext_et_extension_share_info',$data);
            	}
            }

            echo $inid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_messages($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$mid = $this->input->post('mid');
			$m = $this->input->post('m');
			$title = $this->input->post('title');
			$uid_to = $this->input->post('uid_to');
			$msg_type = $this->input->post('msg_type');
			$msg_type_id = $this->input->post('msg_type_id');

			echo $this->addmessage($code,$mid, $m, $title, 'null', $uid_to, $dt, $oid, $uid ,$msg_type ,$msg_type_id);
		} else {
			redirect(base_url().'account/login');
		}
	}

	function addmessage($code,$mid, $m, $title, $attachment, $to, $dt, $oid, $uid ,$msg_type ,$msg_type_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_id ='$mid'");
			$result = $query->result();
			$path = $this->config->item('document_rt').'assets/data/msg/';
			$data=[];

			$insid = 0;
			if (count($result) > 0) {
				$unread_uid = [];
				$fl = $path.$result[0]->ime_file.'.json';
				$query = $this->db->query("SELECT * FROM i_m_members WHERE imm_m_id = '$mid' ");
				$result1 = $query->result();
				for ($i=0; $i < count($result1) ; $i++) {
					if ($result1[$i]->imm_c_id != $oid) {
						array_push($unread_uid, $result1[$i]->imm_c_id);
					}
				}

				$jarr = []; 
				$handle = fopen($fl, 'r') or die('Error');
				$jarr = json_decode(fread($handle, filesize($fl)));
				fclose($handle);

				$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$uid'");
				$result1 = $query->result();
				$m_name = $result1[0]->iud_name;

				array_push($jarr, array('mid' => $result[0]->ime_id, 'title' => $title, 'data' => array('from' => $uid,'read' => array() , 'unread' => $unread_uid ,'name' => $m_name, 'attachment' => $attachment, 'message' => $m, 'date' => $dt , 'msg_type' => $msg_type , 'msg_type_id' => $msg_type_id )));
				$jstr = json_encode($jarr);

				$handle = fopen($fl, 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
				$insid=$mid;
			}else {
				$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
				$data = array(
					'ime_title' => $title,
					'ime_file' => (string)$dt_str,
					'ime_owner' => $oid,
					'ime_created' => $dt,
					'ime_created_by' => $uid,
					'ime_status' => 'true'
				);
				$this->db->insert('i_messaging', $data);
				$insid = $this->db->insert_id();

				$data = array(
					'imm_c_id' => $oid,
					'imm_m_id' => $insid,
					'imm_owner' => $oid
				);
				$this->db->insert('i_m_members', $data);

				// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$to' ");
				// $result = $query->result();

				// if (count($result) > 0) {
				// 	$cid = $result[0]->ic_uid;
				// }else{
				// 	$cid = $to;
				// }
				$data = array(
					'imm_c_id' => $to,
					'imm_m_id' => $insid,
					'imm_owner' => $oid
				);
				$this->db->insert('i_m_members', $data);

				$unread_uid = [];

				$query = $this->db->query("SELECT * FROM i_m_members WHERE imm_m_id = '$insid' and imm_owner = '$oid' ");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) {
					if ($result[$i]->imm_c_id != $oid) {
						array_push($unread_uid, $result[$i]->imm_c_id);
					}
				}

				$jarr = [];

				array_push($jarr, array('mid' => $insid, 'title' => $title, 'data' => array('from' => $oid, 'read' => array() , 'unread' => $unread_uid , 'attachment' => $attachment, 'message' => $m, 'date' => $dt , 'msg_type' => $msg_type , 'msg_type_id' => $msg_type_id)));
				$jstr = json_encode($jarr);

				$upload_dir = $this->config->item('document_rt')."assets/data/msg/";

				if(!file_exists($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}

				if (is_dir($upload_dir) && is_writable($upload_dir)) {
					$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
					fwrite($handle, $jstr);
				}
				fclose($handle);
			}
			return $insid;
			// return $msg_type_id;
		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function delete_messages($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
		
			$path = $this->config->item('document_rt').'assets/data/msg/';
			$data=[];			
			$insid =0;
			$m = $this->input->post('m'); $mid=$this->input->post('mid');
			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_id ='$mid'");
			$result = $query->result();

			if (count($result) > 0) {
				$jarr = []; $fl=$path.$result[0]->ime_file.'.json';
				$handle = fopen($fl, 'r') or die('Error');
				$jarr=json_decode(fread($handle, filesize($fl)), true);
				fclose($handle);

				for ($i=0; $i < count($m); $i++) { 
					if ($jarr[$m[0]]['data']['type'] == $oid) {
						unset($jarr[$m[$i]]);
					}
				}
				$jarr_new=array_values($jarr);
				$jstr = json_encode($jarr_new);
				$handle = fopen($fl, 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
				echo "true";
			} else {
				echo "false";
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function remind_messages($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
		
			$path = $this->config->item('document_rt').'assets/data/msg/';
			$data=[];			
			$insid =0;
			$m=$this->input->post('m'); $mid=$this->input->post('mid'); $rdt=$this->input->post('dt');
			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_id ='$mid'");
			$result = $query->result();

			if (count($result) > 0) {
				$jarr = []; $fl=$path.$result[0]->ime_file.'.json';
				$handle = fopen($fl, 'r') or die('Error');
				$jarr=json_decode(fread($handle, filesize($fl)), true);
				fclose($handle);
				$rmndstr = "";
				for ($i=0; $i < count($m); $i++) { 
					$rmndstr.=$jarr[$m[$i]]['data']['message'];
					$jarr[$m[$i]]['data']['remind'] = $rdt;
				}
				// print_r(json_encode($jarr));
				$jarr_new=array_values($jarr);

				$jstr = json_encode($jarr_new);
				$handle = fopen($fl, 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
				$title = trim(preg_replace('/\s\s+/', ' ', $rmndstr));

				$data = array(
					'iua_type' => 'Reminder',
					'iua_title' => "Message Reminder - ".$title,
					'iua_date' => $rdt,
					'iua_place' => '',
					'iua_to_do' => 0,
					'iua_status' => 'pending',
					'iua_note' => '',
					'iua_owner' => $oid,
					'iua_created_by' => $uid,
					'iua_created' => date('Y-m-d H:i:s'),
					'iua_categorise' => '',
					'iua_p_activity' => 0,
					'iua_m_shortcuts' => 0,
					'iua_shortcuts' => 0,
					'iua_g_id' =>0
				);
				$this->db->insert('i_user_activity',$data);
				
				echo "true";
			
			} else {
				echo "false";
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function star_messages($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
		
			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/msg/';
			$data=[];			
			$insid =0;
			$m=$this->input->post('m'); $mid=$this->input->post('mid');
			$query = $this->db->query("SELECT * FROM i_messaging WHERE ime_id ='$mid'");
			$result = $query->result();

			if (count($result) > 0) {
				$jarr = []; $fl=$path.$result[0]->ime_file.'.json';
				$handle = fopen($fl, 'r') or die('Error');
				$jarr=json_decode(fread($handle, filesize($fl)), true);
				fclose($handle);
				for ($i=0; $i < count($m); $i++) { 
					if (isset($jarr[$m[$i]]['data']['star'])) {
						if ($jarr[$m[$i]]['data']['star']='true') {
							unset($jarr[$m[$i]]['data']['star']);	
						} else {
							$jarr[$m[$i]]['data']['star'] = 'true';
						}	
					} else {
						$jarr[$m[$i]]['data']['star'] = 'true';
					}
					
					
				}
				print_r(json_encode($jarr));
				$jarr_new=array_values($jarr);

				$jstr = json_encode($jarr_new);
				$handle = fopen($fl, 'w') or die('Error');
				fwrite($handle, $jstr);
				fclose($handle);
				echo "true";
			
			} else {
				echo "false";
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function uploadfile($code,$mid, $to) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
		
			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/msg/attach/';
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			if (is_dir($path) && is_writable($path)) {
				for ($i=0; $i < count($_FILES); $i++) { 
					$sourcePath = $_FILES[$i]['tmp_name']; // Storing source path of the file in a variable
					$ext = pathinfo($_FILES[$i]['name'], PATHINFO_EXTENSION);
					$targetPath = $path.$dt_str.".".$ext; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					echo $this->addmessage($mid, 'null', 'null', base_url().'assets/data/'.$oid.'/msg/attach/'.$dt_str.'.'.$ext, $to, $dt, $oid, $uid);
				}
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function msg_notification(){
		$path = $this->config->item('document_rt').'assets/data/msg/';
		$count_arr = [];
		$data = [];
		$query = $this->db->query("SELECT * FROM i_messaging");
		$result = $query->result();
		for ($i=0; $i < count($result) ; $i++) {
			$fl = $path.$result[$i]->ime_file.'.json';
			array_push($data, json_decode(file_get_contents($fl)));

			$msg_id = $result[$i]->ime_id;
			$query = $this->db->query("SELECT * FROM i_m_members WHERE imm_m_id = '$msg_id' ");
			$res = $query->result();
			for ($ijk=0; $ijk < count($data[0]) ; $ijk++) {
				if (isset($data[0][$ijk]->data->unread)) {
					for ($ij=0; $ij < count($data[0][$ijk]->data->unread) ; $ij++) {
						for ($ik=0; $ik < count($res) ; $ik++) {
							if ($res[$ik]->imm_c_id == $data[0][$ijk]->data->unread[$ij]) {
								if (count($count_arr) > 0 ) {
									for ($jk=0; $jk < count($count_arr) ; $jk++) { 
										if ($count_arr[$jk]['uid'] == $res[$ik]->imm_c_id ) {
											$c_count = $count_arr[$jk]['count'] + 1;
											$count_arr[$jk]['count'] = $c_count;
										}
									}
								}else{
									array_push($count_arr , array('mid' => $msg_id ,'uid' => $res[$ik]->imm_c_id, 'count' => 1 ));
								}
							}
						}
					}
				}
			}
		}

		$dt1 = date('Y-m-d H:i:s');
		for ($i=0; $i < count($count_arr) ; $i++) {
			$uid = $count_arr[$i]['uid'];
			$msg_id = $count_arr[$i]['mid'];

			$q = $this->db->query("SELECT * FROM i_notifications WHERE in_type_id = '$msg_id' AND in_m_id = 0 AND in_owner = '$uid' ");
			$res = $q->result();
			if (count($res) > 0 ) {
				$data1 = array(					
					'in_status' => 0,
					'in_date' => $dt1,
					'in_content' => 'You have '.$count_arr[$i]['count'].' unread messages .'
				);
				$this->db->WHERE(array('in_type_id' => $msg_id,'in_type' => 'messaging','in_m_id' => 0,'in_owner' => $uid));
				$this->db->update('i_notifications',$data1);
			}else{
				$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$cid = $result[0]->i_ref;	
				}else{
					$cid = 0;
				}

				$data1 = array(
					'in_type_id' => $msg_id,
					'in_type' => 'messaging',
					'in_m_id' => 0,
					'in_person' => $cid,
					'in_owner' => $uid,
					'in_status' => 0,
					'in_date' => $dt1,
					'in_content' => 'You have '.$count_arr[$i]['count'].' unread messages .'
				);
				$this->db->insert('i_notifications',$data1);
			}
		}
	}

	public function send_invite_chat($code,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$p_id' ");
			$result = $query->result();

			if (count($result) > 0) {
				$to = $result[0]->icbd_value;
				$sub = 'Accept daifunc messaging request.';
				$body = 'Accept daifunc messaging request.';
				$body .= '<p style="text-align:center;margin-top:35%;"><a href="'.base_url().'Messaging/update_cid/'.$oid.'/'.$cid.'"><button class="btn btn-lg btn-danger pic_button send_invite_cid">Accept</button></a><p>';
				$body .= '<p style="text-align:center;">Click on accept button for send message.</p>';
				$temp_id = $this->Mail->send_mail($sub,$to,null,$body,$code);

				$data = array(
					'ic_msg_invite' => 0
				);
				$this->db->WHERE(array('ic_id' => $cid , 'ic_owner' => $oid ));
				$this->db->update('i_customers',$data);

				echo $temp_id;
			}else{
				echo "no_email";
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_cid($oid,$cid){
		$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
		$result = $query->result();
		$p_id = $result[0]->ip_id;

		$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$p_id' ");
		$result = $query->result();
		if (count($result) > 0 ) {
			$to = $result[0]->icbd_value;

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$to' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$c_uid = $result[0]->i_uid;
				$data = array(
					'ic_uid' => $result[0]->i_uid,
					'ic_msg_invite' => 1
				);
				$this->db->WHERE(array('ic_id' => $cid , 'ic_owner' => $oid ));
				$this->db->update('i_customers',$data);

				$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
				$result = $query->result();
				$data = array(
					'ic_name' => $result[0]->i_uname,
					'ic_owner' => $c_uid,
					'ic_created' => date('Y-m-d H:i:s'),
					'ic_created_by' => $c_uid,
					'ic_section' => 'customer',
					'ic_uid' => $oid,
					'ic_msg_invite' => '1'
				);
				$this->db->insert('i_customers',$data);
			}
		}
	}

	public function get_extension_data($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			
			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ");
			$result = $query->result();
			$data['oppo'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_owner = '$oid' AND iextetr_gid = '$gid' ");
			$result = $query->result();
			$data['req'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['contact'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
			$result = $query->result();
			$data['boq'] = $result;

		    $query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' ");
			$result = $query->result();
			$data['projects'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_pro_project as a LEFT JOIN i_ext_pro_task_group as b on a.iextpp_id=b.iextptg_p_id WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' ");
			$result = $query->result();
			$data['p_grp'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_extension_view($code,$type,$type_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$query = $this->db->query("SELECT * FROM i_ext_et_extension_share WHERE iextetes_id = '$type_id' ");
			$result = $query->result();
			$inid = $result[0]->iextetes_type_id;
			$oid = $result[0]->iextetes_owner;
			$data['oid'] = $result[0]->iextetes_owner;
			if ($type == 'oppo') {
				$data['likehood'] = [];
				$data['cust_details'] = [];
				$data['oppo_note'] = [];
				$data['info'] = [];
				$data['proposal'] = [];
				$data['activity'] = [];
				$data['status'] = [];
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' ");
				$result = $query->result();
				$data['save_opportunity'] = $result;
				$cid = $result[0]->iextetop_cid;

				$query = $this->db->query("SELECT * FROM i_ext_et_extension_share_info WHERE iextetesi_owner = '$oid' AND iextetesi_sid = '$type_id' ");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) { 
					if ($result[$i]->iextetesi_type == 'Likeihood of conversion') {
						$query = $this->db->query("SELECT avg(iexteoh_rate) as oppo_rate from i_ext_et_opportunity_likehood where iexteoh_oid = '$inid' ORDER BY iexteoh_rate DESC");
						$data['likehood'] = $query->result();
					}
					
					if ($result[$i]->iextetesi_type == 'Basic Details') {
						$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id LEFT JOIN i_property as c on b.icbd_property = c.ip_id WHERE a.ic_owner = '$oid' AND a.ic_id = '$cid' AND ip_owner = '$oid' ");
						$data['cust_details'] = $query->result();
					}

					if ($result[$i]->iextetesi_type == 'Notes') {
						$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_note WHERE iexteon_oid = '$inid' AND iexteon_owner = '$oid'");
						$data['oppo_note'] = $query->result();
					}

					if ($result[$i]->iextetesi_type == 'Send information') {
						$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_information WHERE iexteoi_oid = '$inid' AND iexteoi_owner = '$oid'");
						$data['info'] = $query->result();
					}

					if ($result[$i]->iextetesi_type == 'Proposal') {
						$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a LEFT JOIN i_ext_et_opportunity_proposal as b on a.iextepro_id = b.iexteop_proposal_id WHERE iextepro_owner='$oid' AND iexteop_oppo_id = '$inid' ");
						$data['proposal'] = $query->result();
					}

					if ($result[$i]->iextetesi_type == 'Activity') {
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'opportunity' AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id = '$cid')");
						$data['activity'] = $query->result();
					}

					if ($result[$i]->iextetesi_type == 'Status') {
						$query = $this->db->query("SELECT * from i_ext_et_opportunity_status where iexteos_owner = '$oid' group BY iexteos_name");
						$data['status'] = $query->result();
					}
				}
			}else if ($type == 'req') {
				$data['edit_notes'] = [];
				$data['edit_req_list'] = [];
				$query = $this->db->query("SELECT * FROM i_ext_et_requirement WHERE iextetr_owner = '$oid' AND iextetr_id = '$inid' ");
				$result = $query->result();
				$data['req'] = $result;	

				$query = $this->db->query("SELECT * FROM i_ext_et_extension_share_info WHERE iextetesi_owner = '$oid' AND iextetesi_sid = '$type_id' ");
				$result = $query->result();
				for ($i=0; $i < count($result) ; $i++) {
					if ($result[$i]->iextetesi_type == 'Images And notes') {
						$query = $this->db->query("SELECT * FROM i_ext_et_requirement_notes WHERE iextetrn_req_id = '$inid' ORDER BY iextetrn_id ASC ");
						$data['edit_notes'] = $query->result();
					}
					if ($result[$i]->iextetesi_type == 'Requirement List') {
						$query = $this->db->query("SELECT * FROM i_ext_et_requirement_product as a LEFT JOIN i_product as b on a.iextetrp_product_id = b.ip_id WHERE iextetrp_req_id = '$inid' ");
						$data['edit_req_list'] = $query->result();
					}
				}
			}else if ($type == 'dm'){
				$query = $this->db->query("SELECT * FROM i_ext_et_design_manager WHERE iextetdm_id = '$inid' AND iextetdm_gid = '$gid' ");
				$result = $query->result();
				$data['dm_details'] = $result;
				$dm_id = 0;
				if (count($result) > 0 ) {
					$dm_id = $result[0]->iextetdm_id;
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_design_manager_category WHERE iextetdmc_dm_id = '$dm_id' ");
				$result = $query->result();
				$data['edit_dmc'] = $result;

				$data['edit_dmc_upload'] = [] ;
				for ($i=0; $i < count($result) ; $i++) {
					$dmc_name = $result[$i]->iextetdmc_name;
					$dmc_id = $result[$i]->iextetdmc_id;
					$query = $this->db->query("SELECT * FROM i_ext_et_extension_share_info WHERE iextetesi_sid = '$type_id' AND iextetesi_type = '$dmc_name' ");
					$result1 = $query->result();
					if (count($result1) > 0 ) {
						$query = $this->db->query("SELECT * FROM i_ext_et_dm_category_upload WHERE iextetdmcu_dmc_id = '$dmc_id' AND iextetdmcu_final = 'true' ");
						$res = $query->result();
						array_push($data['edit_dmc_upload'], $res);	
					}
				}
			}else if($type == 'boq'){
				$path = $this->config->item('document_rt')."assets/data/boq/";
				$boq_arr = [];
				$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_gid = '$gid' AND iextetboq_id = '$inid' ");
				$result = $query->result();
				$data['boq_title'] = $result[0]->iextetboq_title;
				$oid = $result[0]->iextetboq_owner;
				if (count($result) > 0 ) {
					$file_name = $result[0]->iextetboq_file;
				}
	            $fl = $path.$file_name;
	            $boq_arr = json_decode(file_get_contents($fl));
	            $data['boq_arr'] = $boq_arr;

				$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE iextetboqm_boq_id = '$inid' AND ic_owner = '$oid' AND ic_name IN ( SELECT iextetesi_type FROM i_ext_et_extension_share_info WHERE iextetesi_sid = '$type_id' ) ");
				$result = $query->result();
				$mutual_arr = [];
				for ($i=0; $i < count($result) ; $i++) { 
					$file_name = $result[$i]->iextetboqm_file;
		            $fl = $path.$file_name;
		            $m_arr = json_decode(file_get_contents($fl));
		            array_push($mutual_arr, array('uid' => $result[$i]->iextetboqm_uid , 'uname' => $result[$i]->ic_name ,'data' => $m_arr ));
				}
				$data['mutual_arr'] = $mutual_arr;

				$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE iextetboqm_boq_id = '$inid' AND ic_owner = '$oid' AND ic_name IN ( SELECT iextetesi_type FROM i_ext_et_extension_share_info WHERE iextetesi_sid = '$type_id' ) ");
				$result = $query->result();
				$data['users'] = $result;
			}else if($type == 'project'){
				$module = $sess_data['user_mod'];
            	$mid = 0;
            	for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
					}
				}
				$data['doc'] = [];
				$data['project_chart'] = [];

				$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$inid' ");
				$result = $query->result();
				$data['pro'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_extension_share_info WHERE iextetesi_owner = '$oid' AND iextetesi_sid = '$type_id' ");
				$result = $query->result();
				$grp_list = [];
				$pro_list = 'false';
				$grp_status = 'false';
				for ($i=0; $i < count($result) ; $i++) {
					if ($result[$i]->iextetesi_type == 'Uploaded Files') {
						$query1 = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner= '$oid' AND icd_mid = '$mid' AND icd_type_id = '$inid' ");
						$result1 = $query1->result();
						$data['doc'] = $result1;
					}else if ($result[$i]->iextetesi_type == 'Project Status') {
						$pro_act = [];
						$pro_act_list = [];
						$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$inid' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' GROUP BY b.iua_status ");
						$res = $q->result();
						for ($ij=0; $ij < count($res) ; $ij++) { 
							array_push($pro_act, array('pid' => $inid , 'aid' => $res[$ij]->aid , 'status' => $res[$ij]->iua_status ));
						}

						$q = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$inid' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND iua_status = 'progress' ORDER BY iua_id DESC limit 5 ");
		    			$res = $q->result();
		    			for ($ij=0; $ij < count($res) ; $ij++) {
	    					array_push($pro_act_list, array('pid' => $inid , 'aid' => $res[$ij]->iua_id , 'title' => $res[$ij]->iua_title ));
	    				}

						$a = '';
						$a.= '<div class="mdl-cell mdl-cell--12-col mgr_view_content">';
						$a.= '<div class="mdl-grid"><div class="mdl-cell mdl-cell--3-col"></div><div class="mdl-cell mdl-cell--6-col">';
				            if (count($pro_act) > 0 ) {
				                $a.= '<canvas id="ch1" width="60" height="60"></canvas>';
				                $labels = [];
				                $tmp_lbl = [];
				                $values = [];
				                for ($ij=0; $ij < count($pro_act) ; $ij++) {
				                    if ($pro_act[$ij]['pid'] == $inid ) {
				                        array_push($labels , $pro_act[$ij]['status']);
				                        array_push($values , $pro_act[$ij]['aid']);
				                    }
				                }
				                $labels_str = json_encode($labels);
				                $values_str = json_encode($values);
				                if (count($pro_act) > 0) {
				                    $a.= '<script>var ctx = document.getElementById("ch1").getContext("2d");';
				                    $a.= 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "Project task", data: '.$values_str.', backgroundColor: ["#ff0000", "#999", "rgba(202, 200, 16, 0.79)","#800000", "#000"] }] }, options: { title : { display: false, text: "Project Status" } , rotation : -0.1 * Math.PI } });</script>';   
				                }
				            }
				        $a.= '</div></div>';
						$a.= '</p>';
						$a.= '</div>';
						$data['project_chart'] = $a;
					}else if ($result[$i]->iextetesi_type == 'Group Status') {
						$grp_status = 'true';
					}else if ($result[$i]->iextetesi_type == 'Product List') {
						$pro_list = 'true';
					}else{
						array_push($grp_list, $result[$i]->iextetesi_type);
					}
				}
				$project_details = [];
				if($grp_status == 'true'){
					$child_group_arr = [];
					if (count($grp_list) > 0 ) {
						for ($ij=0; $ij < count($grp_list) ; $ij++) {
							$grp_name = $grp_list[$ij];
							$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$inid' AND iextptg_name = '$grp_name' ");
			    			$result = $query->result();
			    			for ($ik=0; $ik < count($result) ; $ik++) { 
			    				array_push($project_details, $result[$ik]);
			    			}
			    			for ($k=0; $k < count($result); $k++) {
			    				array_push($child_group_arr, array('key' => $result[$k]->iextptg_id, 'group_ids' => [$result[$k]->iextptg_id], 'current' => [$result[$k]->iextptg_id], 'activities' => []));
			    				$flg_while=false;
			    				while ($flg_while==false) {
				    				$str_tmp = implode(',', $child_group_arr[$k]['current']);
				    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid' AND iextptg_p_id='$inid'");
				    				$res123 = $que123->result();

				    				if(count($res123) > 0) {
				    					$child_group_arr[$k]['current'] = [];
				    					for ($ijk=0; $ijk < count($res123); $ijk++) { 
					    					array_push($child_group_arr[$k]['group_ids'], $res123[$ijk]->iextptg_id);
					    					array_push($child_group_arr[$k]['current'], $res123[$ijk]->iextptg_id);
					    				}
				    				} else {
				    					$flg_while=true;
				    				}
				    			}
			    			}
						}	
					}else{
						$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$inid' ");
		    			$result = $query->result();
		    			for ($ik=0; $ik < count($result) ; $ik++) { 
		    				array_push($project_details, $result[$ik]);
		    			}

		    			for ($k=0; $k < count($result); $k++) {
		    				array_push($child_group_arr, array('key' => $result[$k]->iextptg_id, 'group_ids' => [$result[$k]->iextptg_id], 'current' => [$result[$k]->iextptg_id], 'activities' => []));
		    				$flg_while=false;
		    				while ($flg_while==false) {
			    				$str_tmp = implode(',', $child_group_arr[$k]['current']);
			    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid' AND iextptg_p_id='$inid'");
			    				$res123 = $que123->result();

			    				if(count($res123) > 0) {
			    					$child_group_arr[$k]['current'] = [];
			    					for ($ijk=0; $ijk < count($res123); $ijk++) { 
				    					array_push($child_group_arr[$k]['group_ids'], $res123[$ijk]->iextptg_id);
				    					array_push($child_group_arr[$k]['current'], $res123[$ijk]->iextptg_id);
				    				}
			    				} else {
			    					$flg_while=true;
			    				}
			    			}
		    			}
					}
					$data['child_group_arr'] = $child_group_arr;
					for ($ij=0; $ij < count($child_group_arr); $ij++) {
						$grp_str_tmp = implode(',', $child_group_arr[$ij]['group_ids']);

						$query = $this->db->query("SELECT iua_status AS status, COUNT(iua_status) AS count FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id = '$inid' AND iextpt_tg_id IN ($grp_str_tmp) GROUP BY iua_status");
						$result = $query->result();

						for ($ijk=0; $ijk < count($result); $ijk++) {
							array_push($child_group_arr[$ij]['activities'], array('status' => $result[$ijk]->status, 'count' => $result[$ijk]->count));
						}
						$project_details_tasks = $child_group_arr;
					}
					$a = '';
					for($i=0;$i < count($project_details); $i++) {
						$values_str=[];
			            $arr_color = [];
						$opacity = rand(0.0, 1.0);

						$labels = [];
						$values = [];
						$value_title = "Testing My chart-element";
						$a.= '<div class="mdl-cell mdl-cell--12-col mdl-shadow--3dp mdl-cell--12-col-tablet" style="border-radius:20px;" id="'.$project_details[$i]->iextptg_id.'"><div class="mdl-grid" style="text-align:center;"><div class="mdl-cell mdl-cell--3-col"></div><div class="mdl-cell mdl-cell--6-col"><div class="chart-element" style="margin:3px auto;"><canvas id="ch1'.$i.'" width="60" height="60"></canvas></div></div><div class="mdl-cell mdl-cell--12-col"><h2>'.$project_details[$i]->iextptg_name.'</h2></div></div></div>';
						for ($j=0; $j <count($project_details_tasks) ; $j++) { 
							for ($ij=0; $ij < count($project_details_tasks[$j]['activities']); $ij++) {
								if ($project_details[$i]->iextptg_id == $project_details_tasks[$j]['key']) {
									if ($project_details_tasks[$j]['activities'][$ij]['status']!=null) {
										array_push($labels, $project_details_tasks[$j]['activities'][$ij]['status']);
										array_push($values, $project_details_tasks[$j]['activities'][$ij]['count']);
									}
								}
				            }	
						}
			            $tmp_lbl = array_values(array_unique($labels));
				        $labels_str = json_encode($tmp_lbl);
				        $values_str = json_encode($values);

				        $a.= '<script>var ctx = document.getElementById("ch1'.$i.'").getContext("2d");';
						$a.= 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: ["#ff0000", "#999", "rgba(202, 200, 16, 0.79)","#800000", "#000"] }] }, options: { title : { display: false, text: "Group Status" } , rotation : -0.1 * Math.PI } });</script>';
					}
					$data['group_chart'] = $a;
				}
				$data['prod_list'] = [];
				if($pro_list == 'true'){
					$grp_ids = [];
					if (count($grp_list) > 0) {
						for ($ij=0; $ij < count($grp_list) ; $ij++) {
							$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$inid' AND iextptg_name = '$grp_name' ");
			    			$result = $query->result();
			    			array_push($grp_ids, $result[0]->iextptg_id);
						}	
					}else{
						$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$inid' ");
		    			$result = $query->result();
		    			array_push($grp_ids, $result[0]->iextptg_id);
					}
					if (count($grp_ids) > 0 ) {
						$p_gid = implode(',', $grp_ids);	
					}else{
						$p_gid = 0;
					}
					$query = $this->db->query("SELECT * FROM i_ext_pro_product_list as a LEFT JOIN i_product as b on a.iextppl_product_id = b.ip_id WHERE iextppl_owner = '$oid' AND iextppl_project_id = '$inid' AND iextppl_project_group IN($p_gid) ");
					$result = $query->result();
					$data['prod_list'] = $result;
				}
				$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$inid' ");
				$data['pro_grp'] = $query->result();
			}
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function download_msg_doc($code,$file_name,$oid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

		    $path = $this->config->item('document_rt')."assets/uploads/".$oid."/";

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

	    	$this->load->helper('download');
			force_download($path.$file_name, NULL);

		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function get_boq_users($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

		    $type = $this->input->post('type');
		    $val = $this->input->post('val');

			$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE ic_owner = '$oid' AND ic_uid IS NOT NULL AND iextetboqm_boq_id IN (SELECT iextetboq_id FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_type = '$type' AND iextetboq_title = '$val' ) ");
			$result = $query->result();
			$data['boq_user'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}    
	}
}