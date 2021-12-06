<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agreement extends CI_Controller {

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

	public function home($mid,$code) {
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
			} else {
				$data['dom'] = "[]";
			}

			$data['gid'] = $gid;
			$ert['code'] = $code;
			$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;
			$ert['mid'] = $mid;
			$ert['title'] = "Agreement";
			$ert['search'] = "false";
			$this->load->view('navbar', $ert);
			$this->load->view('agreement/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}


	public function add_agreement($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';$alias='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Agreement') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data['gid'] = $gid;
			$ert['code'] = $code;
			$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;
			$ert['mid'] = $mid;
			if ($alias != '') {
				$ert['title'] = $alias .'Add';
			}else{
				$ert['title'] = "Agreement Add";
			}
			$ert['search'] = "false";
			$this->load->view('navbar', $ert);
			$this->load->view('agreement/add_agreement', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}
}