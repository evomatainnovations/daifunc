<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quote_compare extends CI_Controller {

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
					if ($module[$i]->mname == 'Quote compare') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_uid IS NOT NULL ");
			// $result = $query->result();
			// $data['contact'] = $result;

			// $query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_gid = '$gid' ");
			// $result = $query->result();
			// $data['oppo'] = $result;

			// $query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_gid = '$gid' AND iextpp_owner = '$oid' ");
			// $result = $query->result();
			// $data['project'] = $result;

			// // $query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE ic_owner = '$oid' ");
			// // $result = $query->result();
			// // $data['mutual_tag'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' ");
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
			$this->load->view('quote_compare/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function get_quote_details($code,$txn_type,$txn_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			if ($txn_type == 'boq') {
				$path = $this->config->item('document_rt')."assets/data/boq/";
				$boq_arr = [];
				$query = $this->db->query("SELECT * FROM i_ext_et_boq WHERE iextetboq_owner = '$oid' AND iextetboq_gid = '$gid' AND iextetboq_id = '$txn_id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$file_name = $result[0]->iextetboq_file;
				}
	            $fl = $path.$file_name;
	            $boq_arr = json_decode(file_get_contents($fl));
	            $data['boq_arr'] = $boq_arr;

				$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE iextetboqm_boq_id = '$txn_id' AND ic_owner = '$oid' ");
				$result = $query->result();
				$mutual_arr = [];
				for ($i=0; $i < count($result) ; $i++) { 
					$file_name = $result[$i]->iextetboqm_file;
		            $fl = $path.$file_name;
		            $m_arr = json_decode(file_get_contents($fl));
		            array_push($mutual_arr, array('uid' => $result[$i]->iextetboqm_uid , 'uname' => $result[$i]->ic_name ,'data' => $m_arr ));
				}
				$data['mutual_arr'] = $mutual_arr;

				$query = $this->db->query("SELECT * FROM i_ext_et_boq_mutual as a LEFT JOIN i_customers as b on a.iextetboqm_uid = b.ic_uid WHERE iextetboqm_boq_id = '$txn_id' AND ic_owner = '$oid' ");
				$result = $query->result();
				$data['users'] = $result;
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}
}