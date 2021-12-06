<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_module extends CI_Controller {

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
########## USER ACCOUNT AND DETAILS ########
	public function home($mid=null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Work Module') {
						$mid = $module[$i]->mid;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_uid IS NOT NULL ");
			$result = $query->result();
			$data['cust_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module WHERE iextetwm_owner = '$oid' AND iextetwm_gid = '$gid' ");
			$result = $query->result();
			$data['work_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module_allot as a LEFT JOIN i_customers as b on a.iextetwma_uid = b.ic_uid LEFT JOIN i_ext_et_work_module as c on a.iextetwma_wm_id = c.iextetwm_id WHERE ic_uid IS NOT NULL AND ic_owner = '$oid' AND iextetwm_owner = '$oid' AND iextetwm_gid = '$gid' ");
			$result = $query->result();
			$data['work_allot'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module_allot as a LEFT JOIN i_user_activity as c on a.iextetwma_id = c.iua_allot_id WHERE iextetwma_wm_id IN ( SELECT iextetwm_id FROM i_ext_et_work_module WHERE iextetwm_owner = '$oid' AND iextetwm_gid = '$gid' ) ");
			$result = $query->result();
			$data['work_activity'] = $result;

			$data['gid'] = $gid;$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;$ert['mid'] = $mid;$ert['search'] = "false";
			if ($alias == '') {
				$ert['title'] = "Work Module";
			}else{
				$ert['title'] = $alias;
			}

			$this->load->view('navbar', $ert);
			$this->load->view('work_module/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function work_add($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Work Module') {
						$mid = $module[$i]->mid;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module WHERE iextetwm_owner = '$oid' AND iextetwm_gid = '$gid' ");
			$result = $query->result();
			$data['work_list'] = $result;

			$data['gid'] = $gid;$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;$ert['mid'] = $mid;$ert['search'] = "false";
			if ($alias == '') {
				$ert['title'] = "Work Module Add";
			}else{
				$ert['title'] = $alias." Add";
			}

			$this->load->view('navbar', $ert);
			$this->load->view('work_module/work_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_work_activity($code,$wm_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module as a LEFT JOIN i_ext_et_work_module_activity as b on a.iextetwm_id = b.iextetwma_wm_id WHERE iextetwm_owner = '$oid' AND iextetwm_gid = '$gid' AND iextetwm_id = '$wm_id' ");
			$result = $query->result();
			$data['work_edit'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function work_save($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$dt = date('Y-m-d H:i:s');
			$title = $this->input->post('title');
			$act_list = $this->input->post('act_list');

			$data = array(
				'iextetwm_title' => $title,
				'iextetwm_owner' => $oid,
				'iextetwm_created' => $dt,
				'iextetwm_created_by' => $uid,
				'iextetwm_gid' => $gid
			);
			$this->db->insert('i_ext_et_work_module',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($act_list) ; $i++) { 
				$data = array(
					'iextetwma_wm_id' => $inid,
					'iextetwma_title' => $act_list[$i]['act_title']
				);
				$this->db->insert('i_ext_et_work_module_activity',$data);
			}

			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function work_update($code,$inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$dt = date('Y-m-d H:i:s');
			$title = $this->input->post('title');
			$act_list = $this->input->post('act_list');

			$data = array(
				'iextetwm_title' => $title,
				'iextetwm_modified' => $dt,
				'iextetwm_modified_by' => $uid
			);
			$this->db->WHERE(array('iextetwm_owner' => $oid,'iextetwm_gid' => $gid,'iextetwm_id' => $inid));
			$this->db->update('i_ext_et_work_module',$data);

			$this->db->WHERE(array('iextetwma_wm_id' => $inid));
			$this->db->delete('i_ext_et_work_module_activity');

			for ($i=0; $i < count($act_list) ; $i++) { 
				$data = array(
					'iextetwma_wm_id' => $inid,
					'iextetwma_title' => $act_list[$i]['act_title']
				);
				$this->db->insert('i_ext_et_work_module_activity',$data);
			}

			echo $inid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function work_delete($code,$inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$this->db->WHERE(array('iextetwm_owner' => $oid,'iextetwm_gid' => $gid,'iextetwm_id' => $inid));
			$this->db->delete('i_ext_et_work_module');

			$this->db->WHERE(array('iextetwma_wm_id' => $inid));
			$this->db->delete('i_ext_et_work_module_activity');

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function work_allot($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$user_list = $this->input->post('user_list');
			$template_name = $this->input->post('template_name');

			$query = $this->db->query("SELECT * FROM i_ext_et_work_module WHERE iextetwm_owner = '$oid' AND iextetwm_created_by = '$uid' AND iextetwm_title = '$template_name' ");
			$result = $query->result();
			$temp_id = 0;
			if (count($result) > 0 ) {
				$temp_id = $result[0]->iextetwm_id;
			}

			for ($i=0; $i < count($user_list) ; $i++) {
				$c_name = $user_list[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$c_name' AND ic_uid IS NOT NULL ");
				$result = $query->result();
				$user_id = $result[0]->ic_uid;

				$data = array(
					'iextetwma_wm_id' => $temp_id,
					'iextetwma_uid' => $user_id,
					'iextetwma_date' => $dt
				);
				$this->db->insert('i_ext_et_work_module_allot',$data);
				$inid = $this->db->insert_id();

				$query = $this->db->query("SELECT * FROM i_ext_et_work_module_activity WHERE iextetwma_wm_id = '$temp_id' ");
				$result = $query->result();
				for ($ij=0; $ij < count($result) ; $ij++) {
					$data = array(
						'iua_type' => 'work_allot',
						'iua_title' => $result[$ij]->iextetwma_title,
						'iua_date' => $dt,
						'iua_status' => 'pending',
						'iua_owner' => $oid,
						'iua_created_by' => $user_id,
						'iua_created' => $dt,
						'iua_p_activity' => 0,
						'iua_g_id' => $gid,
						'iua_color' => 'rgba(255, 0, 0, 0.63)',
						'iua_end_date' => $dt,
						'iua_repeat' => 'one_time',
						'iua_allot_id' => $inid,
						'iua_to_do' => '0'
					);
					$this->db->insert('i_user_activity',$data);
				}
			}
			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}
}