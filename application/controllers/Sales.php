<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->library('pagination');
		$this->load->helper('directory');
		$this->load->helper('download');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}	
########## OPPORTUNITY ############

	public function home($mod_id=null,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$data['mod_id'] = $mod_id;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$module_id = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Opportunity') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ORDER BY iextetop_created DESC");
				$result = $query->result();
				$data['opportunity'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid'  GROUP BY iextetop_status ORDER BY iextetop_created DESC");
				$result = $query->result();
				$data['opp_status'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				
				if (count($result)> 0 || $oid == $uid){
					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opportunity'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid'  GROUP BY iextetop_status ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opp_status'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_created_by = '$uid' AND iextetop_gid = '$gid' UNION SELECT * FROM i_ext_et_opportunity WHERE iextetop_id IN(SELECT iexteom_op_id FROM i_ext_et_opportunity_mutual WHERE iexteom_uid = $uid AND iexteom_oid = $oid) ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opportunity'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_created_by = '$uid' AND iextetop_gid = '$gid' UNION SELECT * FROM i_ext_et_opportunity WHERE iextetop_id IN(SELECT iexteom_op_id FROM i_ext_et_opportunity_mutual WHERE iexteom_uid = $uid AND iexteom_oid = $oid)  GROUP BY iextetop_status ORDER BY iextetop_created DESC");
					$result = $query->result();
					$data['opp_status'] = $result;
				}
			}

			$ert['mod'] = $sess_data['user_mod'];
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['code']=$code;$ert['gid']=$gid;$ert['mid']=$module_id;$ert['mname']='Opportunity';
			if ($alias == '') {
				$ert['title'] = $mname;	
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('sales/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_details($code,$type,$inid = null,$aid = null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$module_id = 0;
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$dt = date('Y-m-d');
			$data['admin'] = 'false';

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Opportunity') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data['cust_name'] = '';
			$query = $this->db->query("SELECT ip_id FROM i_property where ip_owner = '$oid' AND ip_property like '%email%'");
			$result = $query->result();
			$pid = $result[0]->ip_id;
			$data['oppo_gid'] = 0;

			if ($type == 'save') {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid'");
				$result = $query->result();
				$data['save_opportunity'] = $result;
				$cid = $result[0]->iextetop_cid;
				$data['oppo_title'] = $result[0]->iextetop_title;
				$data['cust_name'] = $result[0]->iextetop_title;
				$cust_name = $result[0]->iextetop_title;
				$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE a.ic_owner = '$oid' AND a.ic_id = '$cid' AND b.icbd_property = '$pid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['cust'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$cid'");
					$result = $query->result();
					if (count($result) > 0 ) {
						$data['cust_data'] = $result;
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

						$data = array(
							'iextetop_cid' => $cid
						);
						$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid ));
						$this->db->update('i_ext_et_opportunity',$data);

						$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$cid'");
						$result = $query->result();
						$data['cust_data'] = $result;
					}
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_note WHERE iexteon_oid = '$inid' AND iexteon_owner = '$oid'");
				$result = $query->result();
				$data['oppo_note'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid'");
				$result = $query->result();
				$data['save_opportunity'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_information WHERE iexteoi_oid = '$inid' AND iexteoi_owner = '$oid'");
				$result = $query->result();
				$data['info'] = $result;
				
				$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id LEFT JOIN i_property as c on b.icbd_property = c.ip_id WHERE a.ic_owner = '$oid' AND a.ic_id = '$cid' AND ip_owner = '$oid' ");
				$result = $query->result();
				$data['cust_details'] = $result;

				$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid'");
				$data['files'] = $query->result();

				$query = $this->db->query("SELECT * from i_product where ip_owner = '$oid'");
				$data['product'] = $query->result();
				
				$query = $this->db->query("SELECT * from i_ext_et_opportunity_likehood where iexteoh_oid = '$inid' ORDER BY iexteoh_rate DESC");
				$data['likehood'] = $query->result();

				$query = $this->db->query("SELECT * from i_ext_et_opportunity_likehood where iexteoh_oid = '$inid' ORDER BY iexteoh_created DESC");
				$data['likehood_graph'] = $query->result();

				$query = $this->db->query("SELECT * from i_ext_et_opportunity_status where iexteos_owner = '$oid' group BY iexteos_name");
				$data['status'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a LEFT JOIN i_ext_et_opportunity_proposal as b on a.iextepro_id = b.iexteop_proposal_id WHERE iextepro_owner='$oid' AND iexteop_oppo_id = '$inid' ");
				$result = $query->result();
				$data['proposal'] = $result;

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'opportunity' AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id = '$cid')");
				$result = $query->result();
				$data['activity'] = $result;

				$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$oid' ");
				$result = $query->result();
				$data['e_temp'] = $result;

				$query = $this->db->query("SELECT iexteoi_created as f_date FROM i_ext_et_opportunity_information WHERE iexteoi_oid = '$inid' AND iexteoi_owner = '$oid' UNION  SELECT iextepro_created as f_date FROM i_ext_et_proposal WHERE iextepro_customer_id = '$cid' AND iextepro_owner='$oid' UNION SELECT iua_created as f_date FROM i_user_activity WHERE iua_owner = '$oid' AND iua_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id = '$cid') UNION SELECT iexteon_created as f_date FROM i_ext_et_opportunity_note WHERE iexteon_oid = '$inid' AND iexteon_owner = '$oid' ORDER BY f_date ASC");
				$result = $query->result();
				$t_task = count($result);
				$data['t_task'] = $t_task;
				if (count($result) > 0) {
					$d1 = new DateTime($result[0]->f_date);
					$d2 = new DateTime($result[$t_task - 1]->f_date);
					$diff=date_diff($d1,$d2);
					$data['total_day'] = $diff->format("%a");
				}else{
					$data['total_day'] = 0;
				}
				$data['cust_name'] = $cust_name;
				if ($alias == '') {
					$ert['title'] = $mname." Details";	
				}else{
					$ert['title'] = $alias." Details";
				}
			}else if($type == 'edit'){
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid'");
				$result = $query->result();
				$op_title = $result[0]->iextetop_title;
				$cid = $result[0]->iextetop_cid;
				$op_gid = $result[0]->iextetop_gid;
				$cust_name = $result[0]->iextetop_title;
				$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE a.ic_owner = '$oid' AND a.ic_id = '$cid' AND b.icbd_property = '$pid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['cust'] = $result;

					$query = $this->db->query("SELECT it_value as t_name FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_owner = '$oid' AND iet_type = 'opportunity' AND iet_type_id = '$inid')");
					$result = $query->result();
					$data['oppo_tags'] = $result;

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_uid IN (SELECT iexteom_uid FROM i_ext_et_opportunity_mutual WHERE iexteom_op_id = '$inid')");
					$result = $query->result();
					$data['mutual_tag'] = $result;	
				}else{
					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$cid'");
					$result = $query->result();
					if (count($result) > 0 ) {
						$data['cust_data'] = $result;
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

						$data = array(
							'iextetop_cid' => $cid
						);
						$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid ));
						$this->db->update('i_ext_et_opportunity',$data);

						$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$cid'");
						$result = $query->result();
						$data['cust_data'] = $result;
					}
				}
				$data['oppo_gid'] = $op_gid;
				$data['oppo_title'] = $op_title;
				$data['cust_name'] = $cust_name;
				if ($alias == '') {
					$ert['title'] = $mname." Edit";	
				}else{
					$ert['title'] = $alias." Edit";
				}
			}else{
				if ($alias == '') {
					$ert['title'] = $mname." Add";	
				}else{
					$ert['title'] = $alias." Add";
				}
			}

			if ($aid != null) {
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

				$query = $this->db->query("SELECT * FROM i_m_shortcuts where ims_function = '$fid'");
				$data['f_name'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_id IN(SELECT iuat_t_id FROM i_u_activity_tags WHERE iuat_a_id = '$aid')");
				$data['edit_tags'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT iuap_p_id FROM i_u_a_person WHERE iuap_owner ='$oid' AND iuap_a_id = '$aid')");
				$result = $query->result();
				$data['edit_person'] = $result;
				
				$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner = '$oid' AND iuat_a_id = '$aid'");
				$result = $query->result();
				$data['edit_todo'] = $result;
				$data['edit_id'] = $aid;
			}

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();
			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$ert['mod'] = $sess_data['user_mod'];$ert['oid'] = $oid;
			$ert['user_connection']= $sess_data['user_connection'];
			$data['user_connection']= $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['code']=$code;$ert['gid']=$gid;$ert['mid']=$module_id;$ert['mname']='Opportunity';
			$ert['search'] = "false";
		
			$this->load->view('navbar', $ert);
			$this->load->view('sales/opportunity_details', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_opportunity($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$mflg = 0;
			$cust_name = $this->input->post('customer');
			$tags = $this->input->post('tags');
			$mutual = $this->input->post('mutual');
			$title = $this->input->post('title');
			$dt = date('Y-m-d H:i:s');
			$module = $sess_data['user_mod'];
			$module_id = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Opportunity') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			if ($title == '') {
				$title = $cust_name;
			}
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$cust_name' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->ic_id;
				$data = array(
					'iextetop_title' => $title,
					'iextetop_cid' => $cid,
					'iextetop_created' => $dt,
					'iextetop_created_by' => $uid,
					'iextetop_status' => 'open',
					'iextetop_owner' => $oid,
					'iextetop_gid' => $gid
				);
				$this->db->insert('i_ext_et_opportunity',$data);
				$inid = $this->db->insert_id();

				for ($i=0; $i <count($tags) ; $i++) {
					$tname = $tags[$i];
					$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0) {
						$tid = $result[0]->it_id;
					}else{
						$data = array(
							'it_value' => $tname,
							'it_owner' =>$oid
						);
						$this->db->insert('i_tags',$data);
						$tid = $this->db->insert_id();
					}

					$data = array(
						'iet_type_id' => $inid,
						'iet_type' => 'opportunity',
						'iet_m_id' => $module_id,
						'iet_tag_id' => $tid,
						'iet_owner' => $oid
					);
					$this->db->insert('i_ext_tags',$data);
				}

				if (count($mutual) > 0) {
					$mflg = 1;
					for ($i=0; $i <count($mutual) ; $i++) { 
						$m_name = $mutual[$i];

						$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
						$result = $query->result();
						$m_uid = $result[0]->ic_uid;
						if ($m_uid != '') {
							$data = array(
								'iexteom_op_id' => $inid,
								'iexteom_uid' => $m_uid,
								'iexteom_oid' => $oid
							);
							$this->db->insert('i_ext_et_opportunity_mutual',$data);
						}else{
							$data = array(
								'iextetop_mutual' => '0'
							);
							$this->db->where(array('iextetop_id' => $inid));
							$this->db->update('i_ext_et_opportunity',$data);
						}
					}
				}

				$data = array(
					'iextetop_mutual' => $mflg
				);
				$this->db->where(array('iextetop_id' => $inid));
				$this->db->update('i_ext_et_opportunity',$data);
				echo $inid;
			}else{
				echo "false";	
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_opportunity($inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$module_id = '';
			$mflg = 0;
			$cust_name = $this->input->post('customer');
			$tags = $this->input->post('tags');
			$mutual = $this->input->post('mutual');
			$title = $this->input->post('title');
			$dt = date('Y-m-d H:i:s');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Opportunity') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->iextetop_cid;
				$data = array(
					'ic_name' => $cust_name
				);
				$this->db->WHERE(array('ic_id' => $cid , 'ic_owner' => $oid));
				$this->db->update('i_customers' , $data);
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$cust_name' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;
			}else{
				$cid = 0;
			}

			$data = array(
				'iextetop_title' => $title,
				'iextetop_cid' => $cid,
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid
			);
			$this->db->WHERE('iextetop_id',$inid);
			$this->db->update('i_ext_et_opportunity',$data);

			$this->db->WHERE(array('iet_owner'=> $oid, 'iet_type' => 'opportunity','iet_type_id'=> $inid));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE(array('iexteom_oid' => $oid, 'iexteom_op_id' => $inid));
			$this->db->delete('i_ext_et_opportunity_mutual');

			for ($i=0; $i <count($tags) ; $i++) {
				$tname = $tags[$i];
				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
				$result = $query->result();

				if (count($result) > 0) {
					$tid = $result[0]->it_id;
				}else{
					$data = array(
						'it_value' => $tname,
						'it_owner' =>$oid
					);
					$this->db->insert('i_tags',$data);
					$tid = $this->db->insert_id();
				}
				$data = array(
					'iet_type_id' => $inid,
					'iet_type' => 'opportunity',
					'iet_m_id' => $module_id,
					'iet_tag_id' => $tid,
					'iet_owner' => $oid
				);
				$this->db->insert('i_ext_tags',$data);
			}

			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
						$data = array(
							'iexteom_op_id' => $inid,
							'iexteom_uid' => $m_uid,
							'iexteom_oid' => $oid
						);
						$this->db->insert('i_ext_et_opportunity_mutual',$data);
					}
				}
			}

			$data = array(
				'iextetop_mutual' => $mflg
			);
			$this->db->where(array('iextetop_id' => $inid));
			$this->db->update('i_ext_et_opportunity',$data);

			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_delete($code,$oppo_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$this->db->WHERE(array('iextetop_owner'=> $oid,'iextetop_id'=> $oppo_id));
			$this->db->delete('i_ext_et_opportunity');

			$this->db->WHERE(array('iexteoi_owner'=> $oid,'iexteoi_oid'=> $oppo_id));
			$this->db->delete('i_ext_et_opportunity_information');

			$this->db->WHERE(array('iexteoh_oid'=> $oppo_id));
			$this->db->delete('i_ext_et_opportunity_likehood');

			$this->db->WHERE(array('iexteon_oid'=> $oppo_id,'iexteon_owner'=> $oid));
			$this->db->delete('i_ext_et_opportunity_note');

			redirect(base_url().'Sales/home/null/'.$code);
		}else{
			redirect(base_url().'account/login');	
		}	
	}

	public function opportunity_transfer($code,$oppo_id,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextetop_gid' => $gid,
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $uid
			);
			$this->db->where(array('iextetop_id' => $oppo_id));
			$this->db->update('i_ext_et_opportunity',$data);

			echo "true";

		}else{
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_transfer_user($inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$cust_name = $this->input->post('cust_name');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$oppo_uid = $result[0]->ic_uid;
				$data = array(
					'iextetop_created_by' => $oppo_uid
				);
				$this->db->where(array('iextetop_id' => $inid, 'iextetop_owner' => $oid));
				$this->db->update('i_ext_et_opportunity',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_cust_opportunity($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$cust_name = $this->input->post('customer');
			$title = $this->input->post('title');
			$email = $this->input->post('email');
			$dt = date('Y-m-d H:i:s');

			if ($title == '') {
				$title = $cust_name;
			}

			$query = $this->db->query("SELECT ip_id FROM i_property where ip_owner = '$oid' AND ip_property like '%email%'");
			$result = $query->result();
			$pid = $result[0]->ip_id;
			
			$data = array(
				'ic_name' => $cust_name,
				'ic_owner' => $oid,
				'ic_created' => $dt,
				'ic_created_by' => $oid,
				'ic_section' => 'customer'
			);
			$this->db->insert('i_customers',$data);
			$cid = $this->db->insert_id();

			$data = array(
				'icbd_customer_id' => $cid,
				'icbd_property' => $pid,
				'icbd_value' => $email
			);
			$this->db->insert('i_c_basic_details',$data);

			$data = array(
				'iextetop_cid' => $cid,
				'iextetop_title' => $title,
				'iextetop_created' => $dt,
				'iextetop_created_by' => $oid,
				'iextetop_owner' => $oid,
				'iextetop_status' => 'open'
			);
			$this->db->insert('i_ext_et_opportunity',$data);
			$inid = $this->db->insert_id();

			echo $inid;

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_add_note($inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$note = $this->input->post('note');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexteon_note' => $note,
				'iexteon_oid' => $inid,
				'iexteon_created' => $dt,
				'iexteon_created_by' => $oid,
				'iexteon_owner' => $oid
			);
			$this->db->insert('i_ext_et_opportunity_note',$data);

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			echo $inid;

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function fetch_select_temp($code,$temp_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$oid' AND iuetemp_id = '$temp_id' ");
			$result = $query->result();
			$data['temp_title'] = $result[0]->iuetemp_title;
			$path = $this->config->item('document_rt')."assets/data/".$uid."/email_template/";
			$fl = $path.$result[0]->iuetemp_file;
			$data['temp_content'] = file_get_contents($fl);

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$oid' AND icd_cid = '$cid' AND icd_type_id = '$temp_id' AND icd_type = 'temp_attach' ");
			$data['files'] = $query->result();

			print_r(json_encode($data));

		}else{
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_edit_note($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$oppo_id = $this->input->post('opp_id');
			
			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity_note WHERE iexteon_id = '$oppo_id'");
			$result = $query->result();
			$data['edit_note'] = $result;

			print_r(json_encode($data));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_update_note($inid,$code,$opp_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$note = $this->input->post('note');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexteon_note' => $note,
				'iexteon_modify' => $dt,
				'iexteon_modified_by' => $oid
			);
			$this->db->WHERE('iexteon_id',$opp_id);
			$this->db->update('i_ext_et_opportunity_note',$data);

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			echo $inid;

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_add_email($inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$cust_mail = $this->input->post('customer_mail');

			$query = $this->db->query("SELECT * from i_property where ip_owner = '$oid' AND ip_property like '%email%'");
			$result = $query->result();
			$pid = $result[0]->ip_id;

			$query = $this->db->query("SELECT * from i_ext_et_opportunity where iextetop_owner = '$oid' AND iextetop_id = '$inid' ");
			$result = $query->result();
			$cid = $result[0]->iextetop_cid;

			$data = array(
				'icbd_customer_id' => $cid,
				'icbd_property' => $pid,
				'icbd_value' => $cust_mail
			);
			$this->db->insert('i_c_basic_details',$data);

			echo 'true';
			
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opp_file_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$file_name = $this->input->post('file_name');

			$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid' AND icd_file like '%$file_name%'");
			$data['files'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opp_product_search($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$p_name = $this->input->post('product_name');

			$query = $this->db->query("SELECT * from i_product where ip_owner = '$oid' AND ip_product like '%$p_name%'");
			$data['product'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_send_email($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$files = $this->input->post('files');
			$mails = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

			$path = $this->config->item('document_rt')."assets/data/".$oid."/opportunity/";

			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$file_name = $dt_str.'.txt';

			$data = array(
				'iexteoi_title' => $subject,
				'iexteoi_oid' => $inid,
				'iexteoi_created' => $dt,
				'iexteoi_created_by' => $oid,
				'iexteoi_owner' => $oid,
				'iexteoi_content' => $file_name
			 );
			$this->db->insert('i_ext_et_opportunity_information',$data);
			$opp_info_id = $this->db->insert_id();

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			if (count($files) > 0) {
				for ($i=0; $i <count($files) ; $i++) { 
					$data = array(
						'iextetoif_oid' => $opp_info_id,
						'iextetoif_filename' => $files[$i]['file_name']
					);
					$this->db->insert('i_ext_et_opportunity_information_files',$data);	
				}
			}

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			if (count($result3)>0) {
				for ($i=0; $i <count($mails) ; $i++) {
					if ($mails[$i]['status'] == 'true') {
						$body = '';
						$body .= $content;
						$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
						for ($j=0; $j <count($files) ; $j++) {
							$fid = $files[$j]['id'];
							$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid' AND icd_id = '$fid'");
							$result = $query->result();
							$timestamp = $result[0]->icd_timestamp;
							$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($timestamp).'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
							// $body .= '<a href="'.base_url().'Sales/opportunity_file_download/'.urldecode($timestamp).'/'.$oid.'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
							$body .= '<br>';
						}
						$body .='<br>Regards</body></html>';
						$this->Mail->send_mail($subject,$mails[$i]['email'],null,$body,$code);
					}
				}
			}
			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}	
	}

	public function opportunity_prod_email($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$product = $this->input->post('product');
			$mails = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

			$path = $this->config->item('document_rt')."assets/data/".$oid."/opportunity/";

			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$file_name = $dt_str.'.txt';

			$data = array(
				'iexteoi_title' => $subject,
				'iexteoi_oid' => $inid,
				'iexteoi_created' => $dt,
				'iexteoi_created_by' => $oid,
				'iexteoi_owner' => $oid,
				'iexteoi_content' => $file_name
			 );
			$this->db->insert('i_ext_et_opportunity_information',$data);
			$opp_info_id = $this->db->insert_id();

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			if (count($files) > 0) {
				for ($i=0; $i <count($files) ; $i++) { 
					$data = array(
						'iextetoif_oid' => $opp_info_id,
						'iextetoif_filename' => $files[$i]['file_name']
					);
					$this->db->insert('i_ext_et_opportunity_information_files',$data);	
				}
			}

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			if (count($result3)>0) {

				for ($i=0; $i <count($mails) ; $i++) {
					if ($mails[$i]['status'] == 'true') {
						$body = '';

						$body .= $content;
						$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
						for ($j=0; $j <count($files) ; $j++) { 
							$fid = $files[$j]['id'];
							$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid' AND icd_id = '$fid'");
							$result = $query->result();
							$timestamp = $result[0]->icd_timestamp;
							$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($timestamp).'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
							//$body .= '<a href="'.base_url().'Sales/opportunity_file_download/'.urldecode($timestamp).'/'.$oid.'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
							$body .= '<br>';
						}
						$body .='<br>Regards</body></html>';

						$this->Mail->send_mail($subject,$mails[$i]['email'],null,$body,$code);
					}
				}
			}
			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}	
	}

	public function opportunity_temp_email($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$files = $this->input->post('files');
			$mails = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

			$path = $this->config->item('document_rt')."assets/data/".$oid."/opportunity/";

			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $content);
				fclose($handle);
			}
			$file_name = $dt_str.'.txt';

			$data = array(
				'iexteoi_title' => $subject,
				'iexteoi_oid' => $inid,
				'iexteoi_created' => $dt,
				'iexteoi_created_by' => $oid,
				'iexteoi_owner' => $oid,
				'iexteoi_content' => $file_name
			 );
			$this->db->insert('i_ext_et_opportunity_information',$data);
			$opp_info_id = $this->db->insert_id();

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			if (count($files) > 0) {
				for ($i=0; $i <count($files) ; $i++) { 
					$data = array(
						'iextetoif_oid' => $opp_info_id,
						'iextetoif_filename' => $files[$i]['file_name']
					);
					$this->db->insert('i_ext_et_opportunity_information_files',$data);	
				}
			}

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			if (count($result3)>0) {
				for ($i=0; $i <count($mails) ; $i++) {
					if ($mails[$i]['status'] == 'true') {
						$body = '';
						$body .= $content;
						$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
						for ($j=0; $j <count($files) ; $j++) {
							$fid = $files[$j]['id'];
							$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid' AND icd_id = '$fid'");
							$result = $query->result();
							$timestamp = $result[0]->icd_timestamp;
							$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($timestamp).'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
							$body .= '<br>';
						}
						$body .='<br>Regards</body></html>';
						$this->Mail->send_mail($subject,$mails[$i]['email'],null,$body,$code);
					}
				}
			}
			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}	
	}

	// public function opportunity_file_download($name,$oid){
		// $filename = 'kk'
		// $path = base_url().'assets/uploads/'.$oid.'/';
		// $this->load->helper('download');
		// $data = file_get_contents($path.$name); // Read the file's contents
		// force_download($data,null);
    	// force_download($path.$name, NULL);
    	// if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

     //    // get the file mime type using the file extension
     //    $this->load->helper('file');

     //    $mime = get_mime_by_extension($path);

     //    // Build the headers to push out the file properly.
     //    header('Pragma: public');     // required
     //    header('Expires: 0');         // no cache
     //    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     //    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
     //    header('Cache-Control: private',false);
     //    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
     //    header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
     //    header('Content-Transfer-Encoding: binary');
     //    header('Content-Length: '.filesize($path)); // provide file size
     //    header('Connection: close');
     //    readfile($path); // push it out
     //    exit();
	// }

	public function oppo_doc_upload($inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$in_cid = '';
			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid'");
			$result = $query->result();
			$data['save_opportunity'] = $result;
			$cid = $result[0]->iextetop_cid;
			
			$module = $sess_data['user_mod'];
			$mid = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Opportunity') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			}
			$dt = date('Y-m-d H:i:s');
			$a= 0;
			//print_r("reach");
			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";
			$doc_arr = [];
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
						'icd_type_id' => $inid,
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_status' => 'true',
						'icd_mid' => $mid
					);
					$this->db->insert('i_c_doc', $data);
					$did = $this->db->insert_id();
					array_push($doc_arr, $did);
					$timestamp_value = '';
				}
				$img_path = '';
			}
			$doc_id = implode(',', $doc_arr);
			$query = $this->db->query("SELECT * from i_c_doc where icd_id in ($doc_id) AND icd_owner = '$oid' ");
			$data['files'] = $query->result();
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function likehood_opportunity($code,$inid,$num){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d');
			$dt1 = date('Y-m-d H:i:s');

			$data = array(
				'iexteoh_rate' => $num,
				'iexteoh_oid' => $inid,
				'iexteoh_created' => $dt,
				'iexteoh_created_by' => $oid
			);
			$this->db->insert('i_ext_et_opportunity_likehood',$data);

			$data = array(
				'iextetop_modify' => $dt1,
				'iextetop_modified_by' => $oid 
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}	
	}

	public function opportunity_status($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$status = $this->input->post('status');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexteos_name' => $status,
				'iexteos_owner' => $oid
			);
			$this->db->insert('i_ext_et_opportunity_status',$data);

			$data = array(
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid,
				'iextetop_status' => $status
			);
			$this->db->WHERE(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
			$this->db->update('i_ext_et_opportunity',$data);

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}	
	}

	public function opportunity_status_update($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$status = $this->input->post('status');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextetop_status' => $status,
				'iextetop_modify' => $dt,
				'iextetop_modified_by' => $oid 
			);
			$this->db->where(array('iextetop_id' => $inid));
			$this->db->update('i_ext_et_opportunity',$data);
			
			redirect(base_url().'Sales/home');

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_check($code,$inid,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$status = $this->input->post('status');
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id = '$inid' AND iextetop_owner = '$oid'");
			$result = $query->result();
			$cust_name = $result[0]->iextetop_title;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$cid' AND ic_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
			}else{

				$data = array(
					'ic_name' => $cust_name,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_created_by' => $uid,
					'ic_section' => 'customer'
				);
				$this->db->insert('i_customers',$data);
				$cid = $this->db->insert_id();

				$data = array(
					'iextetop_cid' => $cid
				);
				$this->db->where(array('iextetop_id' => $inid , 'iextetop_owner' => $oid));
				$this->db->update('i_ext_et_opportunity',$data);
			}

			echo $cid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function opportunity_filters($flg = null,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$title = $this->input->post('f_title');
			$f_date = $this->input->post('f_date');
			$t_date = $this->input->post('t_date');
			$f_created = $this->input->post('f_created');
			$opp_status = $this->input->post('opp_status');

			if ($flg == 'recent') {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' ORDER BY iextetop_modify DESC");
				$data['filters'] = $query->result();
				print_r(json_encode($data));

			}else if($flg == 'likelihood'){
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity as a left join i_ext_et_opportunity_likehood as b on a.iextetop_id=b.iexteoh_oid WHERE a.iextetop_owner = '$oid' group by b.iexteoh_oid ORDER BY avg(b.iexteoh_rate) DESC ");
				$data['filters'] = $query->result();
				print_r(json_encode($data));

			}else if($flg == 'longest'){

				$query = $this->db->query("SELECT iextetop_id,iextetop_title,iextetop_created,iextetop_status,DATEDIFF(iextetop_modify,iextetop_created) AS DateDiff FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_status != 'closed' ORDER BY DateDiff DESC");
				$data['filters'] = $query->result();
				print_r(json_encode($data));
			}else{
				// $query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' OR iextetop_title like '%$title%' OR iextetop_created_by IN(SELECT iud_u_id FROM i_u_details WHERE iud_name ='$f_created') OR DATE(iextetop_created) BETWEEN '$f_date' AND '$t_date' ORDER BY iextetop_created DESC");
				// $data['filters'] = $query->result();
				// print_r(json_encode($data));

				if ($f_created != null) {
					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$f_created' AND ic_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0 ) {
						$f_created = $result[0]->ic_uid;
					}
				}

				$this->db->select('*');
				$this->db->from('i_ext_et_opportunity');
				$this->db->join('i_customers', 'i_customers.ic_uid = i_ext_et_opportunity.iextetop_created_by','left');
				if ($f_date != '' && $t_date != '') {
					$this->db->where('iextetop_created >=', $f_date);
					$this->db->where('iextetop_created <=', $t_date);
				}
				if ($f_created != '') {
					$this->db->where('iextetop_created_by', $f_created);
				}
				if ($opp_status != 'null') {
					$this->db->where('iextetop_status', $opp_status);
				}
				if ($title != '') {
					$this->db->where('iextetop_title', $title);
				}
				$this->db->where('i_ext_et_opportunity.iextetop_owner', $oid);
				$this->db->group_by('i_ext_et_opportunity.iextetop_id');
				$query = $this->db->get();
				$data['filters'] = $query->result();
				print_r(json_encode($data));
			}

		} else {
			redirect(base_url().'account/login');
		}	
	}

	public function activity_save($code){
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
				'iua_type' => 'opportunity',
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

	public function diff_date(){
		$date1=date_create("2013-03-15");
		$date2=date_create("2013-12-12");
		$diff=date_diff($date1,$date2);

		echo $diff->format("%a");
		// print_r($seconds_diff);
	}

########## Proposal ################
	public function proposal($mod_id=null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$module_id = '';
			
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Proposal') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			if ($gid == 0) {
				$data['admin'] = 'true';
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers AS b ON a.iextepro_customer_id=b.ic_id WHERE a.iextepro_owner = '$oid' AND a.iextepro_gid = '$gid' ORDER BY a.iextepro_id DESC");
				$result = $query->result();
				$data['invoice'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();

				if (count($result) > 0 || $uid == $oid) {
					$data['admin'] = 'true';
					$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers AS b ON a.iextepro_customer_id=b.ic_id WHERE a.iextepro_gid = '$gid' AND a.iextepro_owner = '$oid' ORDER BY a.iextepro_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;	
				}else{
					$data['admin'] = 'false';
					$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers AS b ON a.iextepro_customer_id=b.ic_id WHERE a.iextepro_gid = '$gid' AND a.iextepro_created_by = '$uid' UNION SELECT * FROM i_ext_et_proposal AS c LEFT JOIN i_customers AS d ON c.iextepro_customer_id=d.ic_id WHERE c.iextepro_gid = '$gid' AND c.iextepro_id IN(SELECT iextepm_pid FROM i_ext_et_proposal_mutual WHERE iextepm_uid = '$uid' AND iextepm_oid = '$oid')");
					$result = $query->result();
					$data['invoice'] = $result;	
				}
			}
			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			// $data['use_modules'] = $query->result();

			// $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
			// $result = $query->result();
			// $data['tags'] = $result;

			// $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' GROUP BY iua_status");
			// $result = $query->result();
			// $data['status'] = $result;

			// $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' GROUP BY iua_place");
			// $result = $query->result();
			// $data['place'] = $result;

			// $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' GROUP BY iua_categorise");
			// $result = $query->result();
			// $data['cat'] = $result;

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			// $result = $query->result();
			// $data['user_list'] = $result;

			$data['mod_id'] = $mod_id;

			// $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			// $result = $query->result();
			// $data['tags'] = $result;

			$query = $this->db->query("SELECT iextepro_status FROM i_ext_et_proposal WHERE iextepro_owner = '$oid' GROUP BY iextepro_status ORDER BY iextepro_id DESC ");
			$result = $query->result();
			$data['pro_status'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['gid']=$gid;$ert['mid']=$module_id;$ert['mname']='Proposal';$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('sales/proposal', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$search = $this->input->post('search');
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers AS b ON a.iextepro_customer_id=b.ic_id WHERE a.iextepro_owner = '$oid' AND a.iextepro_gid = '$gid' AND b.ic_name LIKE '%".$search."%' or a.iextepro_txn_id LIKE '%".$search."%' ORDER BY a.iextepro_id DESC");
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers AS b ON a.iextepro_customer_id=b.ic_id WHERE a.iextepro_gid = '$gid' AND b.ic_name LIKE '%".$search."%' or a.iextepro_txn_id LIKE '%".$search."%' ORDER BY a.iextepro_id DESC");
			}
			$result = $query->result();
			$data['invoice'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_filter($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$from_date = $this->input->post('from');
			$to_date = $this->input->post('to');
			$min_amount = $this->input->post('min_amount');
			$max_amount = $this->input->post('max_amount');
			$status = $this->input->post('in_status');
			$p_created = $this->input->post('p_created');

			if ($p_created != null) {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$p_created' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$p_created = $result[0]->ic_uid;
				}
			}

			$this->db->select('*');
			$this->db->from('i_ext_et_proposal');
			$this->db->join('i_customers', 'i_customers.ic_uid = i_ext_et_proposal.iextepro_created_by','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('iextepro_txn_date >=', $from_date);
				$this->db->where('iextepro_txn_date <=', $to_date);
			}
			if ($p_created != '') {
				$this->db->where('iextepro_created_by', $p_created);
			}
			if ($status != '') {
				$this->db->where('iextepro_status', $status);
			}
			if ($min_amount != '') {
				$this->db->where('iextepro_amount >=', $min_amount);
			}
			if ($max_amount != '') {
				$this->db->where('iextepro_amount <=', $max_amount);
			}
			$this->db->where('i_ext_et_proposal.iextepro_owner', $oid);
			$this->db->group_by('i_ext_et_proposal.iextepro_id');
			$query = $this->db->get();

			$data['invoice'] = $query->result();
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function proposal_add($code,$mod_id=null,$tid=null,$oppo_id = null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$module_id = '';

			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Proposal') {
						$module_id = $module[$i]->mid;
						$mname = 'Proposal';
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data["mod_id"] = $module_id;

			$invoice_txn_id = '';
			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$module_id' ORDER BY iumdi_id;");
			$result = $query->result();
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
						$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_owner = '$oid'");
						$result2 = $query->result();
						$val = count($result2)+1;
					}
					$invoice_txn_id .= $val;
				}
			}
			$data['invoice_doc_id'] = $invoice_txn_id;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();
			$data['tax'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

   			//          $query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Proposal' AND iextdt_owner='$oid'");
			// $result = $query->result();
			// $data['term_doc'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid' AND ip_gid = '$gid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id LEFT JOIN i_tax_group as c on b.itxgc_tg_id=c.ittxg_id WHERE a.itx_owner = '$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			// $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' GROUP BY iua_place");
			// $result = $query->result();
			// $data['place'] = $result;

			// $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' GROUP BY iua_categorise");
			// $result = $query->result();
			// $data['cat'] = $result;

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			// $result = $query->result();
			// $data['user_list'] = $result;

			if ($tid != null && $tid != 'null') {
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a left JOIN i_ext_et_proposal_product_details as b on a.iextepro_id=b.iexteprod_pro_id LEFT join i_product as c on b.iexteprod_product_id=c.ip_id WHERE a.iextepro_id ='$tid' AND a.iextepro_owner = '$oid'");
				$result = $query->result();	
				$data['edit_proposal'] = $result;
				$cid = $result[0]->iextepro_customer_id;
				$data['edit_type'] = $result[0]->iextepro_type;
				$data['pro_gid'] = $result[0]->iextepro_gid;

				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Proposal' AND iextdt_owner='$oid'");
				$result = $query->result();
				$data['term_doc'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_proposal_terms as a left join i_ext_et_document_terms as b on a.iexteptm_term_id=b.iextdt_id WHERE iexteptm_pid = '$tid' AND iextdt_owner = '$oid' ");
				$data['p_terms'] = $query->result();

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
				$result = $query->result();
				$data['edit_cust'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_proposal_property where iexteppt_pid = '$tid'");
				$result = $query->result();
				$data['proposal_property'] = $result;

				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				$p_id = $result[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id = '$cid' ");
				$result = $query->result();
				$data['email_ids'] = $result;

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'proposal' AND iet_type_id = '$tid' AND iet_m_id = '$module_id' AND iet_owner = '$oid') ");
				$result = $query->result();
				$data['pro_tags'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_proposal_mutual as a LEFT JOIN i_customers as b on a.iextepm_uid = b.ic_uid WHERE iextepm_pid = '$tid' AND iextepm_oid = '$oid'");
				$result = $query->result();
				$data['mutual'] = $result;

				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$module_id' ");
				$data['helper'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$module_id' ");
				$data['help_parameter'] = $query->result();

				if ($alias == '') {
					$ert['title'] = $mname." Edit";
				}else{
					$ert['title'] = $alias." Edit";
				}

				$data['tid'] = $tid;
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='Proposal'");
				$result = $query->result();
				$data['term_doc'] = $result;

				if ($alias == '') {
					$ert['title'] = $mname." Add";
				}else{
					$ert['title'] = $alias." Add";
				}
			}

			if ($oppo_id != null && $oppo_id != 'null') {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_id ='$oppo_id' AND iextetop_owner = '$oid'");
				$result = $query->result();	
				$cid = $result[0]->iextetop_cid;

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
				$result = $query->result();
				$data['edit_cust'] = $result;
				$data['oppo_id'] = $oppo_id;
			}else{
				$data['oppo_id'] = 'null';
			}
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;$ert['gid']=$gid;$ert['mid']=$module_id;$ert['mname']='Proposal';
			$data['mid']=$module_id;
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('sales/proposal_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextepro_id' => $pid, 'iextepro_owner' => $oid));
			$this->db->update('i_ext_et_proposal',array('iextepro_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_transfer_user($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$cust_name = $this->input->post('cust_name');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				$p_uid = $result[0]->ic_uid;
				$data = array(
					'iextepro_created_by' => $p_uid
				);
				$this->db->where(array('iextepro_id' => $inid, 'iextepro_owner' => $oid));
				$this->db->update('i_ext_et_proposal',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function proposal_download($flg,$code,$mod_id,$invoiceid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
		    // redirect(base_url().'Sales/proposal_print/'.$code.'/'.$mod_id.'/'.$invoiceid);
	 		$page = file_get_contents(base_url().'Sales/proposal_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start(); // unlock the file
		    
		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/proposal/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $invoiceid.'.html';
		    $invoicefile = $invoiceid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
		    if ($flg == 'd') {
		    	$this->load->helper('download');
    			force_download($path.$invoicefile, NULL);	
		    }else if($flg == 'p'){
		    	redirect(base_url().'assets/data/'.$oid.'/proposal/'.$invoicefile);
		    }
		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function proposal_delete($code,$mod_id,$p_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
		$uid = $sess_data['user_details'][0]->i_uid;
		$oid = $sess_data['user_details'][0]->i_owner;
		$gid = $sess_data['gid'];

		$this->db->WHERE('iextepro_id',$p_id);
		$this->db->delete('i_ext_et_proposal');

		redirect(base_url().'Sales/proposal/'.$mod_id.'/'.$code);
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function save_proposal_mail($code,$mod_id,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$mail_id = $this->input->post('cust_mail_id');
			$email = '';
			$query = $this->db->query("SELECT iextepro_customer_id FROM i_ext_et_proposal WHERE iextepro_id='$inid' AND iextepro_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iextepro_customer_id;

			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];

					$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
					$result = $query->result();
					$p_id = $result[0]->ip_id;

					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						echo $this->send_proposal_email($code,$email, $mod_id, $inid);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);

						echo $this->send_proposal_email($code,$email, $mod_id, $inid);
					}
				}$email = '';
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function send_proposal_email($code,$uid, $mod_id, $invoiceid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
		// $uid = $sess_data['user_details'][0]->i_uid;
		$oid = $sess_data['user_details'][0]->i_owner;
		$gid = $sess_data['gid'];

		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
		$result = $query->result();

		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid')");
		$result1 = $query->result();

		$query = $this->db->query("SELECT * from i_ext_et_proposal WHERE iextepro_id='$invoiceid'");
		$result2 = $query->result();

		$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
		$result3=$query3->result();
		if (count($result3)>0) {

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
	 		$page = file_get_contents(base_url().'Sales/proposal_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/proposal/';

		    if(!file_exists($path)) {
					mkdir($path, 0777, true);
			}
			$in_date = date("d-m-Y", strtotime($result2[0]->iextepro_txn_date));
		    $htmlfile = $result1[0]->ic_name.'-'.$in_date.'.html';
		    $invoicefile = $result1[0]->ic_name.'-'.$in_date.'.pdf';
		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

			$subject = $result[0]->iud_company.' - Proposal - '.$result2[0]->iextepro_txn_id;

			$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
			<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached invoice and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
			$attach = $path.$invoicefile;
			$this->Mail->send_mail($subject,$uid,$attach,$body,$code);
		}else {
			echo "enter";
		}
		echo "true";
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function cust_details($code,$customer){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$cust = urldecode($customer);

			$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_name = '$cust' AND ic_owner = '$oid')");
			$result = $query->result();
			$data['details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function proposal_product_rate($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$product_name = $this->input->post('p_name');
			$query = $this->db->query("SELECT * FROM i_product as a left join i_p_price as b on a.ip_id = b.ipp_p_id left join i_p_taxes as c on a.ip_id = c.ipt_p_id WHERE ip_product = '$product_name' AND ip_created_by = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$pid = $result[0]->ip_id;
				$data['pid'] = $pid;
				$que = $this->db->query("SELECT * FROM i_p_child_product WHERE ipcp_p_pid = '$pid' AND ipcp_owner = '$oid' ");
				$res = $que->result();
				if (count($res) > 0 ) {
					$data['child_prod'] = 'true';
					$query1 = $this->db->query("SELECT * FROM i_product as a left join i_p_price as b on a.ip_id = b.ipp_p_id left join i_p_taxes as c on a.ip_id = c.ipt_p_id LEFT JOIN i_p_child_product as d on a.ip_id = d.ipcp_c_pid WHERE ip_created_by = '$oid' AND ipcp_p_pid = '$pid' ");
					$result1 = $query1->result();
					$data['c_prod'] = $result1;
				}else{
					$data['child_prod'] = 'false';
					$data['prod_rate'] = $result[0]->ipp_sell_price;
					$data['prod_tax'] = $result[0]->ipt_t_id;
				}
				print_r(json_encode($data));
			}else{
				echo "false";
			}
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_document_terms ($document,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$dt = date('Y-m-d H:i:s');
			$data = array(
				'iextdt_term' => $this->input->post('name'),
				'iextdt_document' => $document,
				'iextdt_owner' => $oid,
				'iextdt_created' => $dt,
				'iextdt_created_by' => $oid
			);
			$this->db->insert('i_ext_et_document_terms', $data);

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document = '$document' ");
			$result = $query->result();
			$data['terms'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function cust_add_property($code,$cust_name) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = urldecode($cust_name);
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$cust_name'");
			$result = $query->result();
			$cid = $result[0]->ic_id;
			redirect(base_url()."Enterprise/customer_edit/".$code."/".$cid);
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

			$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/email_template/";
			$file_name = $upload_dir.$result[0]->iuetemp_file;
			$data['temp_content'] = file_get_contents($file_name);

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function proposal_save($type,$code,$oppo_id = null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$product = $this->input->post('product');
			$amount = $this->input->post('amount');
			$dt = date('Y-m-d H:i:s');
			$note = $this->input->post('note');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$tags = $this->input->post('tags');
			
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'proposal') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
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

			$data = array(
				'iextepro_customer_id' => $cid, 
				'iextepro_txn_id' => $txn_no,
				'iextepro_txn_date' => $dt,
				'iextepro_type' => $type,
				'iextepro_amount' => $amount,
				'iextepro_status' => 'open',
				'iextepro_note' => $note,
				'iextepro_owner' => $oid,
				'iextepro_created' => $dt,
				'iextepro_created_by' => $uid,
				'iextepro_status' => 'open',
				'iextepro_gid' => $gid
			);
			$this->db->insert('i_ext_et_proposal',$data);
			$pid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iexteptm_pid' => $pid,
						'iexteptm_term_id' => $terms[$i]['id'],
						'iexteptm_status' => $status
					);	
					$this->db->insert('i_ext_et_proposal_terms',$data);	
				}
			}

			if (count($tags) > 0) {
				for ($i=0; $i <count($tags) ; $i++) {
					$tname = $tags[$i];
					$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0) {
						$tid = $result[0]->it_id;
					}else{
						$data = array(
							'it_value' => $tname,
							'it_owner' =>$oid
						);
						$this->db->insert('i_tags',$data);
						$tid = $this->db->insert_id();
					}

					$data = array(
						'iet_type_id' => $pid,
						'iet_type' => 'proposal',
						'iet_m_id' => $module_id,
						'iet_tag_id' => $tid,
						'iet_owner' => $oid
					);
					$this->db->insert('i_ext_tags',$data);
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) {
					$data = array(
						'iexteppt_pid' => $pid,
						'iexteppt_property_value' => $property[$i]['value'],
						'iexteppt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_proposal_property',$data);	
				}
			}

			$mutual = $this->input->post('mutual');
			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
						$data = array(
							'iextepm_pid' => $pid,
							'iextepm_uid' => $m_uid,
							'iextepm_oid' => $oid
						);
						$this->db->insert('i_ext_et_proposal_mutual',$data);
					}
				}
			}
			
			$data1 = array(
				'in_type_id' => $pid, 
				'in_type' => 'proposal',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Proposal - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'pending',
				'iua_categorise' => 'create',
				'iua_p_activity' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid
			);
			$this->db->insert('i_user_activity', $data);
			$aid = $this->db->insert_id();

			$data = array(
				'iuap_a_id' => $aid, 
				'iuap_p_id' => $cid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);

			if ($type != 'note') {
				for ($i=0; $i <count($product) ; $i++) {
					$p_name = $product[$i]['product'];

					$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$p_name' AND ip_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0) {
						$prid = $result[0]->ip_id;
					} else {
						$data1 = array(
							'ip_product' => $p_name,
							'ip_section' => 'Products',
							'ip_owner' => $oid,
							'ip_created' => $dt,
							'ip_created_by' => $oid,
							'ip_gid' => $gid,
							'ip_cat_id' => 0
						);
						$this->db->insert('i_product', $data1);
						$prid = $this->db->insert_id();
					}
					if ($product[$i]['disc'] == '') {
						$p_total = $product[$i]['rate'] * $product[$i]['qty'];	
					}else{
						$disc_amt = $product[$i]['rate'] * $product[$i]['qty'] * ($product[$i]['disc'] / 100);
						$p_total = $product[$i]['rate'] * $product[$i]['qty']; - $disc_amt;
					}
					$data = array(
						'iexteprod_pro_id' => $pid,
						'iexteprod_product_id' => $prid,
						'iexteprod_rate' => $product[$i]['rate'],
						'iexteprod_qty' => $product[$i]['qty'],
						'iexteprod_discount' => $product[$i]['disc'],
						'iexteprod_amount' => $p_total,
						'iexteprod_tax' => $product[$i]['tax_id'],
						'iexteprod_owner' => $oid,
						'iexteprod_alias' => $product[$i]['alias']
					);
					$this->db->INSERT('i_ext_et_proposal_product_details',$data);
				}
			}

			if ($oppo_id != 'null' || $oppo_id != null ) {
				$data = array(
					'iexteop_oppo_id' => $oppo_id,
					'iexteop_proposal_id' => $pid,
					'iexteop_owner' => $oid,
					'iexteop_created' => $dt,
					'iexteop_created_by' => $uid
				);
				$this->db->insert('i_ext_et_opportunity_proposal',$data);
			}
			echo $pid;
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function update_proposal_save($type,$code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$product = $this->input->post('product');
			$amount = $this->input->post('amount');
			$status =$this->input->post('status');
			$dt = date('Y-m-d H:i:s');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$data = array(
				'iextepro_customer_id' => $cid, 
				'iextepro_txn_id' => $txn_no,
				'iextepro_txn_date' => $txn_date,
				'iextepro_amount' => $amount,
				'iextepro_type' => $type,
				'iextepro_modified' => $dt,
				'iextepro_modified_by' => $uid,
				'iextepro_status' => $status,
			);
			$this->db->WHERE(array('iextepro_id'=> $tid , 'iextepro_owner' => $oid));
			$this->db->update('i_ext_et_proposal',$data);

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}	
	}

	public function proposal_update($type,$code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$product = $this->input->post('product');
			$amount = $this->input->post('amount');
			$status =$this->input->post('status');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$note = $this->input->post('note');
			$tags = $this->input->post('tags');
			$module_id = '';

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'proposal') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE('iexteptm_pid',$tid);
			$this->db->delete('i_ext_et_proposal_terms');

			$this->db->WHERE('iexteppt_pid',$tid);
			$this->db->delete('i_ext_et_proposal_property');

			$this->db->WHERE(array('iet_type_id'=>$tid,'iet_owner' => $oid, 'iet_type' => 'proposal', 'iet_m_id' => $module_id));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE(array('iextepm_pid'=>$tid,'iextepm_oid'=>$oid));
			$this->db->delete('i_ext_et_proposal_mutual');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$data = array(
				'iextepro_customer_id' => $cid,
				'iextepro_txn_id' => $txn_no,
				'iextepro_txn_date' => $txn_date,
				'iextepro_amount' => $amount,
				'iextepro_note' => $note,
				'iextepro_type' => $type,
				'iextepro_modified' => $dt,
				'iextepro_modified_by' => $uid,
				'iextepro_status' => $status,
			);
			$this->db->WHERE(array('iextepro_id'=> $tid , 'iextepro_owner' => $oid));
			$this->db->update('i_ext_et_proposal',$data);

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) {
					$data = array(
						'iexteptm_pid' => $tid,
						'iexteptm_term_id' => $terms[$i]['id'],
						'iexteptm_status' => $terms[$i]['status']
					);	
					$this->db->insert('i_ext_et_proposal_terms',$data);	
				}
			}
			if (count($tags) > 0) {
				for ($i=0; $i <count($tags) ; $i++) {
					$tname = $tags[$i];
					$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0) {
						$tag_id = $result[0]->it_id;
					}else{
						$data = array(
							'it_value' => $tname,
							'it_owner' =>$oid
						);
						$this->db->insert('i_tags',$data);
						$tag_id = $this->db->insert_id();
					}

					$data = array(
						'iet_type_id' => $tid,
						'iet_type' => 'proposal',
						'iet_m_id' => $module_id,
						'iet_tag_id' => $tag_id,
						'iet_owner' => $oid
					);
					$this->db->insert('i_ext_tags',$data);
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteppt_pid' => $tid,
						'iexteppt_property_value' => $property[$i]['value'],
						'iexteppt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_proposal_property',$data);	
				}
			}

			$mutual = $this->input->post('mutual');
			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
						$data = array(
							'iextepm_pid' => $tid,
							'iextepm_uid' => $m_uid,
							'iextepm_oid' => $oid
						);
						$this->db->insert('i_ext_et_proposal_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $tid, 
				'in_type' => 'proposal',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Proposal - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'pending',
				'iua_categorise' => 'update',
				'iua_p_activity' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid
			);
			$this->db->insert('i_user_activity', $data);
			$aid = $this->db->insert_id();
			
			$data = array(
				'iuap_a_id' => $aid, 
				'iuap_p_id' => $cid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);

			$this->db->WHERE(array('iexteprod_pro_id'=> $tid, 'iexteprod_owner' => $oid ));
			$this->db->delete('i_ext_et_proposal_product_details');

			for ($i=0; $i <count($product) ; $i++) { 
				$p_name = $product[$i]['product'];

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$p_name' AND ip_owner = '$oid'");
				$result = $query->result();

				if (count($result) <= 0) {
					$data1 = array(
						'ip_product' => $p_name,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $uid,
						'ip_gid' => $gid,
						'ip_cat_id' => 0
					);
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				} else {
					$prid = $result[0]->ip_id;
				}
				if ($product[$i]['disc'] == '') {
					$p_total = $product[$i]['rate'] * $product[$i]['qty'];	
				}else{
					$disc_amt = $product[$i]['rate'] * $product[$i]['qty'] * ($product[$i]['disc'] / 100);
					$p_total = $product[$i]['rate'] * $product[$i]['qty']; - $disc_amt;
				}

				$data = array(
					'iexteprod_pro_id' => $tid,
					'iexteprod_product_id' => $prid,
					'iexteprod_rate' => $product[$i]['rate'],
					'iexteprod_qty' => $product[$i]['qty'],
					'iexteprod_discount' => $product[$i]['disc'],
					'iexteprod_amount' => $p_total,
					'iexteprod_tax' => $product[$i]['tax_id'],
					'iexteprod_owner' => $oid,
					'iexteprod_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_proposal_product_details',$data);
			}

			echo $tid;

		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function pro_doc_upload($code,$pid,$cname){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$cid ='';

			$module_id = '';

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'proposal') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			// $img_path = "";
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
					//print_r($targetPath);
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				
					
					$data = array(
						'icd_file' => $file_name,
						'icd_owner' => $oid,
						'icd_cid' => $cid,
						'icd_date' => $dt,
						'icd_type' => 'document',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $module_id,
						'icd_type_id' => $pid,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);
					$timestamp_value = '';
				}	
				$img_path = '';
			}

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_id IN($cid) AND icd_owner = '$oid'");
			$result = $query->result();
			$data['files']=$result;

			print_r(json_encode($data));

		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_send_email($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mid = '';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Proposal') {
					$mid = $module[$i]->mid;
				}
			}

			$dt = date('Y-m-d H:i:s');
			$files = $this->input->post('files');
			$emails = $this->input->post('email');
			$subject = $this->input->post('subject');
			$content = $this->input->post('content');
			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$amount = $this->input->post('amount');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$data = array(
				'iextepro_customer_id' => $cid, 
				'iextepro_txn_id' => $txn_no,
				'iextepro_txn_date' => $dt,
				'iextepro_type' => 'email',
				'iextepro_amount' => $amount,
				'iextepro_status' => 'open',
				'iextepro_owner' => $oid,
				'iextepro_created' => $dt,
				'iextepro_created_by' => $uid
			);
			$this->db->insert('i_ext_et_proposal',$data);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Proposal - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'pending',
				'iua_categorise' => 'create',
				'iua_p_activity' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid
			);
			$this->db->insert('i_user_activity', $data);

			$tmpstr = implode(',', $emails);
			
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_id IN($tmpstr) AND icbd_property = '$p_id'");
			$result = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			if (count($result3)>0) {
				for ($i=0; $i <count($result) ; $i++) {
					$mail_id = $result[$i]->icbd_value;
					$body = '';

					$body .= $content;
					$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
					for ($j=0; $j <count($files) ; $j++) { 
						$fid = $files[$j]['id'];
						$query = $this->db->query("SELECT * from i_c_doc where icd_owner = '$oid' AND icd_id = '$fid'");
						$result = $query->result();
						$timestamp = $result[0]->icd_timestamp;
						$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($timestamp).'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
						// $body .= '<a href="'.base_url().'Sales/opportunity_file_download/'.urldecode($timestamp).'/'.$oid.'" target="_blank"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
						$body .= '<br>';
					}
					$body .='<br>Regards</body></html>';
					$this->Mail->send_mail($subject,$mail_id,null,$body,$code);
					// try {
					// 	$config = array();
				 //        $config['useragent'] = "CodeIgniter";
				 //        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
				 //        $config['protocol'] = "smtp";
				 //        $config['smtp_host'] = $result3[0]->iumail_domain;
				 //        $config['smtp_user'] = $result3[0]->iumail_mail;
				 //        $config['smtp_pass'] = $result3[0]->iumail_password;
				 //        $config['smtp_port'] = $result3[0]->iumail_port;
				 //        $config['mailtype'] = 'html';
				 //        $config['charset'] = 'utf-8';
				 //        $config['newline'] = "\r\n";
				 //        $config['wordwrap'] = TRUE;

					// 	$this->load->library('email');
					// 	$this->email->initialize($config);
					// 	$this->email->from($result3[0]->iumail_mail);
					// 	$this->email->to($mail_id);
					// 	$this->email->subject($subject);
					// 	$this->email->message($body);
					// 	$this->email->send();

					// } catch (Exception $e) {
					// 	echo "Exception: ".$e;
					// }
					$mail_id = '';
				}
			}
			echo $mid;
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function proposal_print($code,$mod_id, $invoice_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
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

			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers As b ON a.iextepro_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextepro_id='$invoice_id' AND a.iextepro_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers As b ON a.iextepro_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextepro_id='$invoice_id' AND a.iextepro_owner = '$oid' ");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextepro_txn_id;
				$data['s_txn_date'] = $result[0]->iextepro_txn_date;
				$data['s_txn_note'] = $result[0]->iextepro_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextepro_txn_id;
				$data['s_txn_date'] = $result[0]->iextepro_txn_date;
				$data['s_txn_note'] = $result[0]->iextepro_note;
			}


			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$uid'");
			$result = $query->result();
			$data['u_gst'] = $result[0]->iud_gst;
			$data['u_cmp'] = $result[0]->iud_company;
			$data['u_name'] = $result[0]->iud_name;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal AS a LEFT JOIN i_customers As b ON a.iextepro_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iextepro_id='$invoice_id'");
			$result = $query->result();
			
			if(count($result) > 0) {
				$data['s_gst'] = $result[0]->icbd_value;
			} else {
				$data['s_gst'] = '';
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteprod_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON  a.iexteprod_tax=c.ittxg_id LEFT JOIN i_product AS d ON a.iexteprod_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id WHERE a.iexteprod_pro_id='$invoice_id'");
			$result = $query->result();
			$data['details'] = $result;

             $query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_terms WHERE iexteptm_pid='$invoice_id'");
			$result = $query->result();
			$data['terms'] = $result;
			$data['s_title'] = "Proposal";

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_id='$invoice_id'");
			$result = $query->result();
			$data['note']=$result[0]->iextepro_note;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_property WHERE iexteppt_pid ='$invoice_id' AND iexteppt_status = 'true' ");
			$result = $query->result();
			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_proposal_terms as b on a.iextdt_id=b.iexteptm_term_id WHERE iextdt_document='Proposal' AND iextdt_owner='$oid' AND iexteptm_pid= '$invoice_id' ");
			$result = $query->result();
			$data['terms'] = $result;

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

}	