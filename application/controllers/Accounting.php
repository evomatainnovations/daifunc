<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accounting extends CI_Controller {

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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}


			$query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner='$oid' AND iextetacl_starred='1'");
			$data['ledgers'] = $query->result();

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
			$this->load->view('accounting/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}
################# journal_entries ########################################################

	public function journal_entries($code) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}
		   	
		   	$query = $this->db->query("SELECT a.iextetacje_id AS id, b.iextetacl_name AS account_from, c.iextetacl_name AS account_to, a.iextetacje_description AS account_description, a.iextetacje_date AS date,  a.iextetacje_amount AS amount FROM i_ext_et_ac_journal_entries AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id WHERE a.iextetacje_owner='$oid' AND a.iextetacje_date BETWEEN '$fy' AND '$ty' ORDER BY iextetacje_date, iextetacje_id");
		   	$data['txn'] = $query->result();
		   	
		   	$query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner='$oid'");
		   	$data['ledgers'] = $query->result();
		   	
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Journal Entries";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/journal_entries', $data);
			$this->load->view('home/search_modal');
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function journal_entry_details($ref,$code,$jid=null,$refid=null) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}

		   	if ($jid!=null && $jid!='null') {
		   		$query = $this->db->query("SELECT  a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM i_ext_et_ac_journal_entries AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_id = '$jid' AND a.iextetacje_owner='$oid'");
			   	$data['detail'] = $query->result();
			   	$ert['title'] = "Edit Journal Entry";
		   	} else {
		   		$ert['title'] = "Add Journal Entry";
		   	}
		   	
		   	$query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner='$oid'");
		   	$data['ledgers'] = $query->result();
		   	
		   	
			$data['jid'] = $jid;
			$data['ref'] = $ref;
			$data['refid'] = $refid;
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Journal Entries";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/add_filter_journal_entry', $data);
			$this->load->view('home/search_modal');
		
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function filter_journal_entries($code) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}
			
		   	$query = $this->db->query("SELECT a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM `i_ext_et_ac_journal_entries` AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_date BETWEEN '$fy' AND '$ty' AND a.iextetacje_owner='$oid' AND b.iextetacl_name LIKE '%".$this->input->post('f')."%' AND c.iextetacl_name LIKE '%".$this->input->post('t')."%' AND a.iextetacje_date BETWEEN '".$this->input->post('f_dt')."' AND '".$this->input->post('t_dt')."' AND a.iextetacje_description LIKE '%".$this->input->post('d')."%' ORDER BY a.iextetacje_date DESC");
		   	print_r(json_encode($query->result()));
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function delete_journal_entry($code,$jid, $type=null, $typeid=null) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}
			
			$this->db->where(array('iextetacje_id' => $jid, 'iextetacje_owner' => $oid));
			$this->db->delete('i_ext_et_ac_journal_entries');

			if ($type==null) {
				$query = $this->db->query("SELECT a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM `i_ext_et_ac_journal_entries` AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_date BETWEEN '$fy' AND '$ty' AND a.iextetacje_owner='$oid' ORDER BY a.iextetacje_date DESC");
		   		print_r(json_encode($query->result()));
			} else if($type == "l") {
			    if($typeid==null) {
			        $query = $this->db->query("SELECT a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM `i_ext_et_ac_journal_entries` AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_owner='$oid' ORDER BY a.iextetacje_date DESC, a.iextetacje_id");
			    } else {
			        $query = $this->db->query("SELECT a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM `i_ext_et_ac_journal_entries` AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_from='$typeid' OR a.iextetacje_to='$typeid' AND a.iextetacje_owner='$oid' ORDER BY a.iextetacje_date DESC, a.iextetacje_id");
			    }
				print_r(json_encode($query->result()));
			} else if($type == "g") {
				// $query = $this->db->query("SELECT a.inaje_id AS id, a.inaje_date AS date, b.inal_ledger AS account_from, a.inaje_from AS from_id, c.inal_ledger AS account_to, a.inaje_to AS to_id, a.inaje_description AS account_description, a.inaje_amt AS amount FROM i_n_ac_journal_entries AS a LEFT JOIN i_n_ac_ledgers AS b ON a.inaje_from=b.inal_id LEFT JOIN i_n_ac_ledgers AS c ON a.inaje_to=c.inal_id WHERE a.inaje_from IN (SELECT inagl_l_id FROM i_n_ac_group_ledgers WHERE inagl_g_id='$typeid' AND inagl_owner='$oid' GROUP BY inagl_l_id) OR a.inaje_to IN (SELECT inagl_l_id FROM i_n_ac_group_ledgers WHERE inagl_g_id='$typeid' AND inagl_owner='$oid' GROUP BY inagl_l_id) AND a.inaje_owner='$oid'");
				// print_r(json_encode($query->result()));
			}
		   	
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function edit_journal_entry($code,$jid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
		    
		   	$uid = $sess_data['user_details'][0]->iu_id;
		   	$query = $this->db->query("SELECT  a.iextetnaje_id AS id, a.iextetnaje_date AS date, b.iextetnal_ledger AS account_from, a.iextetnaje_from AS from_id, c.iextetnal_ledger AS account_to, a.iextetnaje_to AS to_id, a.iextetnaje_description AS account_description, a.iextetnaje_amt AS amount FROM i_ext_et_n_ac_journal_entries AS a LEFT JOIN i_ext_et_n_ac_ledgers AS b ON a.iextetnaje_from=b.iextetnal_id LEFT JOIN i_ext_et_n_ac_ledgers AS c ON a.iextetnaje_to=c.iextetnal_id  WHERE a.iextetnaje_id = '$jid' AND a.iextetnaje_owner='$oid'");
		   	$data['detail'] = $query->result();
		   	// $query = $this->db->query("SELECT * FROM i_n_ac_je_groups AS a LEFT JOIN i_n_ac_groups AS b ON a.inajg_g_id=b.inag_id WHERE a.inajg_je_id='$jid' AND a.inajg_owner='$oid'");
		   	// $data['group'] = $query->result();
		   	print_r(json_encode($data));
		} else {
		    redirect(base_url().'account/login');
		}
	} 
	
	public function record_journal_entry($code,$type=null, $id=null) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}
			
			$dt = date('Y-m-d H:m:s');
			
			$r = $this->input->post('r');
			$sel = $this->input->post('selected');
			
			for($i=0;$i<count($r);$i++) {
				if(isset($r[$i]['g'])) {
					$g = $r[$i]['g'];	
				} else {
					$g = [];
				}
			    
			    $f = $r[$i]['f'];
    			$t = $r[$i]['t'];
    			
    			if($f == null) {
    			    $fid = 0;
    			} else {
    			    $query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner = '$oid' AND iextetacl_name='$f'");
        			$result = $query->result();
        			
        			if(count($result) > 0) {
        			    $fid = $result[0]->iextetacl_id;
        			} else {
        			    $data1 = array('iextetacl_name' => $f, 'iextetacl_owner' => $oid, 'iextetacl_created' => $dt, 'iextetacl_created_by' => $uid);
        			    $this->db->insert('i_ext_et_ac_ledgers', $data1);
        			    $fid = $this->db->insert_id();
        			}
    			}
    			
    			if($t==null) {
    			    $tid=0;
    			} else {
    			    $query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner = '$oid' AND iextetacl_name='$t'");
        			$result = $query->result();
        			
        			if(count($result) > 0) {
        				$tid = $result[0]->iextetacl_id;
        			} else {
        			    $data1 = array('iextetacl_name' => $t, 'iextetacl_owner' => $oid, 'iextetacl_created' => $dt, 'iextetacl_created_by' => $uid);
        			    $this->db->insert('i_ext_et_ac_ledgers', $data1);
        			    $tid = $this->db->insert_id();
        			}
    			}
        			
    			
    			if($sel == "true") {
    			    $this->db->where(array('iextetacje_id' => $r[$i]['id'], 'iextetacje_owner' => $oid ));
    			    $this->db->delete('i_ext_et_ac_journal_entries');
    			} 
    			
    			$data = array('iextetacje_date' => $r[$i]['dt'], 'iextetacje_from' => $fid, 'iextetacje_to' => $tid, 'iextetacje_description' => $r[$i]['d'], 'iextetacje_amount' => $r[$i]['a'], 'iextetacje_link_type' => 'Manual', 'iextetacje_link_id' => 0, 'iextetacje_owner' => $oid, 'iextetacje_created' => $dt, 'iextetacje_created_by' => $uid);
    			$this->db->insert('i_ext_et_ac_journal_entries', $data);
			}
		} else {
		    redirect(base_url().'account/login');
		}
	}
################# Classes ########################################################

	public function classes($code) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_owner='$oid'");
		   	$data['classes'] = $query->result();
			$data['oid'] = $oid;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Classes';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/classes', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_classes($code) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_owner='$oid'");
		   	$data['classes'] = $query->result();
			$data['oid'] = $oid;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Classes Add';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/classes_add', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_classes($code,$cid=null) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
		    $dt = date('Y-m-d H:i:s');
		    
		    if($cid==null) {
		    	$data = array(
		    		'iextetacc_name' => $this->input->post('name'), 
		    		'iextetacc_owner' => $oid, 
		    		'iextetacc_type' => $this->input->post('type'), 
		    		'iextetacc_created' => $dt, 
		    		'iextetacc_created_by' => $uid
		    	);
		        $this->db->insert('i_ext_et_ac_classes', $data);
		    } else {
		    	$data = array(
		    		'iextetacc_name' => $this->input->post('name'), 
		    		'iextetacc_type' => $this->input->post('type'), 
		    		'iextetacc_modified' => $dt, 
		    		'iextetacc_modified_by' => $uid
		    	);
		        $this->db->where(array('iextetacc_owner' => $oid, 'iextetacc_id' => $cid));
		        $this->db->update('i_ext_et_ac_classes',$data );
		    }
		    echo "true";
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function search_classes($code) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

		   	$l=$this->input->post('keywords');
		   	$query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_name LIKE '%$l%' AND iextetacc_owner='$oid'");
		   	print_r(json_encode($query->result()));
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function edit_classes($code,$cid) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
		
		    $query=$this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_id='$cid' AND iextetacc_owner='$oid'");
			$data['detail'] = $query->result();
			$data['cid'] = $cid;
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Classes Edit';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/classes_add', $data);
			$this->load->view('home/search_modal');
		} else {
		    redirect(base_url().'distributors/Account/login');
		}
	}

	public function delete_classes($code,$cid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
		    $this->db->where(array('iextetacc_id' => $cid, 'iextetacc_owner' => $oid));
		    $this->db->delete('i_ext_et_ac_classes');

		    redirect(base_url().'Accounting/classes/'.$code);
		} else {
		    redirect(base_url().'account/login');
		}
	}
################# GROUPS ########################################################

	public function groups($code) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid'");
			$data['groups'] = $query->result();

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Group Add';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/groups', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function search_group($code) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
			$g=$this->input->post('keywords');
			$query=$this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_name LIKE '%$g%' AND iextetacg_owner='$oid'");
			print_r(json_encode($query->result()));
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function add_group($code) {
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
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid'");
			$data['groups'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_owner='$oid'");
			$data['classes'] = $query->result();
			$data['oid'] = $oid;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Group Add';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/group_add', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function edit_group($code,$gid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$query=$this->db->query("SELECT a.iacg_id AS iextetacg_id, a.iacg_name AS iextetacg_name, b.iacg_name AS parent_name, c.iacc_name AS class_name FROM i_ext_et_ac_groups AS a LEFT JOIN i_ext_et_ac_groups AS b ON a.iextetacg_parent_id=b.iextetacg_id LEFT JOIN i_ext_et_ac_classes AS c ON a.iextetacg_class_id=c.iextetacc_id  WHERE a.iextetacg_id='$gid' AND a.iextetacg_owner='$oid'");
			$data['detail'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid'");
			$data['groups'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_owner='$oid'");
			$data['classes'] = $query->result();
			
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = 'Group Edit';
			
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/groups_add', $data);
			$this->load->view('home/search_modal');
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function fetch_group_classes($code) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
		    $g=$this->input->post('g');
		    
		    $query = $this->db->query("SELECT b.iextetacc_name AS parent FROM i_ext_et_ac_groups AS a LEFT JOIN i_ext_et_ac_classes AS b ON a.iextetacg_class_id=iextetacc_id WHERE iextetacg_name='$g'");
		    $result = $query->result();
		    if(count($result) > 0) {
		        echo $result[0]->parent;
		    } else {
		        echo "";
		    }
		}
	}

	public function save_group($code,$gid=null) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
		    $dt = date('Y-m-d H:i:s');
		    
		    $groups = $this->input->post('groups');
		    $classes = $this->input->post('classes');
		    
		    $sgid=0; $scid=0;
	        $query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_name='$groups' AND iextetacg_owner='$oid'");
	        $result = $query->result();
	        if(count($result) > 0) {
	            $sgid = $result[0]->iextetacg_id;
	        }
		    
	        $query = $this->db->query("SELECT * FROM i_ext_et_ac_classes WHERE iextetacc_name='$classes' AND iextetacc_owner='$oid'");
	        $result = $query->result();
	        if(count($result) > 0) {
	            $scid = $result[0]->iextetacc_id;
	        }
		    
		    if($gid==null) {
		    	$data = array(
		    		'iextetacg_name' => $this->input->post('name'), 
		    		'iextetacg_parent_id' => $sgid, 
		    		'iextetacg_class_id' => $scid, 
		    		'iextetacg_owner' => $oid, 
		    		'iextetacg_created_by' => $uid, 
		    		'iextetacg_created' => $dt
		    	);
		        $this->db->insert('i_ext_et_ac_groups', $data);
		    } else {
		    	$data = array(
		    		'iextetacg_name' => $this->input->post('name'), 
		    		'iextetacg_parent_id' => $sgid, 
		    		'iextetacg_class_id' => $scid, 
		    		'iextetacg_owner' => $oid, 
		    		'iextetacg_modified_by' => $uid, 
		    		'iextetacg_modified' => $dt
		    	);
		        $this->db->where(array('iextetacg_id' => $gid, 'iextetacg_owner' => $oid));
		        $this->db->update('i_ext_et_ac_groups', $data);
		    }
		    echo "true";
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function delete_group($code,$gid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
		    $this->db->where(array('iextetacg_id' => $gid, 'iextetacg_owner' => $oid));
		    $this->db->delete('i_ext_et_ac_groups');
		    
		    redirect(base_url().'Accounting/groups/'.$code);
		} else {
		    redirect(base_url().'account/login');
		}
	}

	public function group_details($code,$gid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
	    if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Accounting') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			
		    $dt = date('Y-m-d H:i:s');
		    $que = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid' AND iextetacg_id='$gid'");
		    $res = $que->result();
		    
		    $query = $this->db->query("SELECT z.iextetacl_name AS name, z.iextetacl_id AS main_id, z.iextetacl_group_id AS groupid, x.iextetacg_name AS groupname, ((SELECT IFNULL(SUM(a.iextetacje_amount),0) FROM i_ext_et_ac_journal_entries AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_to=b.iextetacl_id WHERE b.iextetacl_id=main_id) - (SELECT IFNULL(SUM(a.iextetacje_amount),0) FROM i_ext_et_ac_journal_entries AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id WHERE b.iextetacl_id=main_id)) AS balance FROM i_ext_et_ac_ledgers AS z LEFT JOIN i_ext_et_ac_groups AS x ON z.iextetacl_group_id=x.iextetacg_id WHERE z.iextetacl_group_id='$gid' AND z.iextetacl_owner='$oid'");
		    $data['detail'] = $query->result();
		    
            $data['gid']=$gid;
		    $data['oid'] = $oid;

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Group Details: ".$res[0]->iextetacg_name;
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/group_details', $data);
		} else {
		    redirect(base_url().'account/login');
		}
	}

################# LEDGERS ########################################################

	public function ledgers($code) {
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
    				if ($module[$i]->mname == 'Accounting') {
    					$mid = $module[$i]->mid;
    					$mname = $module[$i]->mname;
    					$alias = $module[$i]->m_alias;
    				}
    			}
    		} else {
    			$data['dom'] = "[]";
    		}
		   	
		   	$query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner = '$oid'");
			$data['ledgers'] = $query->result();

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Ledgers";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/ledgers', $data);
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function search_ledgers($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
        if($sess_data['session'] == 'true') {
    		$uid = $sess_data['user_details'][0]->i_uid;
    		$oid = $sess_data['user_details'][0]->i_owner;
    		$gid = $sess_data['gid'];

		   	$l=$this->input->post('keywords');
		   	$query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_name LIKE '%$l%' AND iextetacl_owner='$oid'");
		   	print_r(json_encode($query->result()));
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function fetch_link_type($code,$t) {
	    $sess_data = $this->log_code->get_session_value($code,true);
        if($sess_data['session'] == 'true') {
    		$uid = $sess_data['user_details'][0]->i_uid;
    		$oid = $sess_data['user_details'][0]->i_owner;
			
			$g=$this->input->get('term');
			
			if($t=="contact") {
			    $query = $this->db->query("SELECT ic_name AS name FROM i_customers WHERE ic_owner='$oid' AND ic_name LIKE '%$g%' LIMIT 10");
			} else if($t=="tax") {
			    $query = $this->db->query("SELECT itx_name AS name FROM i_taxes WHERE itx_owner='$oid' AND itx_name LIKE '%$g%' LIMIT 10");
			} else if($t=="module") {
			    $query = $this->db->query("SELECT im_name AS name FROM i_modules WHERE im_name LIKE '%$g%' LIMIT 10");
			}
			$result = $query->result();
			$arr = [];
			for($i=0;$i<count($result);$i++) {
			    array_push($arr, array('label' => $result[$i]->name, 'value' => $result[$i]->name));
			}
			print_r(json_encode($arr));
		}else{
			redirect(base_url().'account/login');
		}
	}
	
	public function add_ledger($code) {
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
    				if ($module[$i]->mname == 'Accounting') {
    					$mid = $module[$i]->mid;
    					$mname = $module[$i]->mname;
    					$alias = $module[$i]->m_alias;
    				}
    			}
    		} else {
    			$data['dom'] = "[]";
    		}
			$query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid'");
			$data['groups'] = $query->result();

		 	// $query=$this->db->query("SELECT inald_property FROM i_n_ac_l_details WHERE inald_owner='$oid' GROUP BY inald_property");
			// $data['prop'] = $query->result();

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Ledgers Add";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('accounting/ledger_add', $data);
		} else {
		    redirect(base_url().'distributors/Account/login');
		}
	}
	
	public function edit_ledger($code,$lid) {
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
    				if ($module[$i]->mname == 'Accounting') {
    					$mid = $module[$i]->mid;
    					$mname = $module[$i]->mname;
    					$alias = $module[$i]->m_alias;
    				}
    			}
    		} else {
    			$data['dom'] = "[]";
    		}

			$data['lid'] = $lid;
		    $query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_owner='$oid'");
			$data['groups'] = $query->result();

		   	$query=$this->db->query("SELECT a.iextetacl_id AS id, a.iextetacl_name AS ledger_name, a.iextetacl_link AS type, a.iextetacl_link_id AS link_id, b.ic_name AS contact, c.itx_name AS tax, e.im_name AS module, d.iextetacg_name AS grp FROM i_ext_et_ac_ledgers AS a LEFT JOIN i_customers AS b ON a.iextetacl_link_id=b.ic_id LEFT JOIN i_taxes AS c ON a.iextetacl_link_id=c.itx_id LEFT JOIN i_ext_et_ac_groups AS d ON a.iextetacl_group_id=d.iextetacg_id LEFT JOIN i_modules AS e ON a.iextetacl_link_id=e.im_id WHERE a.iextetacl_id='$lid' AND a.iextetacl_owner='$oid'");
			$data['detail'] = $query->result();

			// $query=$this->db->query("SELECT inald_property FROM i_n_ac_l_details WHERE inald_owner='$oid' GROUP BY inald_property");
			// $data['prop'] = $query->result();

			// $query=$this->db->query("SELECT * FROM i_n_ac_l_details WHERE inald_l_id='$lid' AND inald_owner='$oid'");
			// $data['detail_prop'] = $query->result();

			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Ledgers Edit";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$this->load->view('navbar', $ert);
			$this->load->view('accounting/ledger_add', $data);
		} else {
		    redirect(base_url().'distributors/Account/login');
		}
	}
	
	public function save_ledger($code,$lid=null) {
	    $sess_data = $this->log_code->get_session_value($code,true);
        if($sess_data['session'] == 'true') {
    		$uid = $sess_data['user_details'][0]->i_uid;
    		$oid = $sess_data['user_details'][0]->i_owner;
    		$gid = $sess_data['gid'];
			
		    $dt = date('Y-m-d H:i:s');
		    $g=$this->input->post('groups');
		    $query = $this->db->query("SELECT * FROM i_ext_et_ac_groups WHERE iextetacg_name='$g' AND iextetacg_owner='$oid'");
		    $result = $query->result();
		    
		    $gid=0;
		    if(count($result) > 0) {
		        $gid=$result[0]->iextetacg_id;
		    }
		    $cname=$this->input->post('link_name');
		    $cid=0;
		    if($this->input->post('link_type') == 'contact') {
		        $q1 = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cname' AND ic_owner='$oid'");
		        $r1 = $q1->result();
		        if(count($r1) > 0) {
		            $cid=$r1[0]->ic_id;
		        }
		    } else if($this->input->post('link_type') == 'tax') {
		        $q1 = $this->db->query("SELECT * FROM i_taxes WHERE itx_name='$cname' AND itx_owner='$oid'");
		        $r1 = $q1->result();
		        if(count($r1) > 0) {
		            $cid=$r1[0]->itx_id;
		        }
		    } else if($this->input->post('link_type') == 'module') {
		        $q1 = $this->db->query("SELECT * FROM i_modules WHERE im_name='$cname'");
		        $r1 = $q1->result();
		        print_r($r1);
		        if(count($r1) > 0) {
		            $cid=$r1[0]->im_id;
		        }
		    }
		    
		    if($lid==null) {
		    	$data = array(
		    		'iextetacl_name' => $this->input->post('name'), 
		    		'iextetacl_group_id' => $gid, 
		    		'iextetacl_owner' => $oid, 
		    		'iextetacl_created_by' => $uid, 
		    		'iextetacl_created' => $dt, 
		    		'iextetacl_link' => $this->input->post('link_type'), 
		    		'iextetacl_link_id' => $cid, 
		    		'iextetacl_starred' => 0 
		    	);
		        $this->db->insert('i_ext_et_ac_ledgers', $data);
		    } else {
		    	$data = array(
		    		'iextetacl_name' => $this->input->post('name'), 
		    		'iextetacl_group_id' => $gid, 
		    		'iextetacl_owner' => $oid, 
		    		'iextetacl_modified_by' => $uid, 
		    		'iextetacl_modified' => $dt, 
		    		'iextetacl_link' => $this->input->post('link_type'), 
		    		'iextetacl_link_id' => $cid 
		    	);
		        $this->db->where(array('iextetacl_id' => $lid, 'iextetacl_owner' => $oid));
		        $this->db->update('i_ext_et_ac_ledgers', $data);
		    }
		    
		    // $prp = $this->input->post('p_t');
		    // $val = $this->input->post('p_v');
		    // $this->db->where(array('inald_l_id' => $lid, 'inald_owner' => $oid));
		    // $this->db->delete('i_n_ac_l_details');
		    // for ($i=0; $i < count($prp); $i++) { 
		    // 	$this->db->insert('i_n_ac_l_details', array('inald_l_id' => $lid, 'inald_property' => $prp[$i], 'inald_value' => $val[$i], 'inald_owner' => $oid));
		    // }

		    echo "true";

		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function delete_ledger($code,$lid) {
	    $sess_data = $this->log_code->get_session_value($code,true);
        if($sess_data['session'] == 'true') {
    		$uid = $sess_data['user_details'][0]->i_uid;
    		$oid = $sess_data['user_details'][0]->i_owner;
    		$gid = $sess_data['gid'];
			
		    $this->db->where(array('iextetacl_id' => $lid, 'iextetacl_owner' => $oid));
		    $this->db->delete('i_ac_ledgers');
		    
		    $this->db->where(array('iextetacje_from' => $lid, 'iextetacje_owner' => $oid));
		    $this->db->delete('i_ext_et_ac_journal_entries');

		    $this->db->where(array('iextetacje_to' => $lid, 'iextetacje_owner' => $oid));
		    $this->db->delete('i_ext_et_ac_journal_entries');
		    
		    redirect(base_url().'accounting/ledgers/'.$code.'/'.$lid);
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function ledger_details($code,$lid) {
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
    				if ($module[$i]->mname == 'Accounting') {
    					$mid = $module[$i]->mid;
    					$mname = $module[$i]->mname;
    					$alias = $module[$i]->m_alias;
    				}
    			}
    		} else {
    			$data['dom'] = "[]";
    		}
    		$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' AND iua_status = 'true' ");
			$result1 = $query->result();
			$fy=0;$ty=0;
			if (count($result1) > 0 ) {
				$fy = $result1[0]->iua_start_date;
				$ty = $result1[0]->iua_end_date;	
			}
			
		    $dt = date('Y-m-d H:i:s');
		    
		    $query = $this->db->query("SELECT a.iextetacje_id AS id, a.iextetacje_date AS date, b.iextetacl_name AS account_from, a.iextetacje_from AS from_id, c.iextetacl_name AS account_to, a.iextetacje_to AS to_id, a.iextetacje_description AS account_description, a.iextetacje_amount AS amount FROM `i_ext_et_ac_journal_entries` AS a LEFT JOIN i_ext_et_ac_ledgers AS b ON a.iextetacje_from=b.iextetacl_id LEFT JOIN i_ext_et_ac_ledgers AS c ON a.iextetacje_to=c.iextetacl_id  WHERE a.iextetacje_from='$lid' OR a.iextetacje_to='$lid' AND a.iextetacje_owner='$oid' AND a.iextetacje_date BETWEEN '$fy' AND '$ty' ORDER BY a.iextetacje_date DESC, a.iextetacje_id");
    	    $data['txn'] = $query->result();
    	    
    	    $query = $this->db->query("SELECT * FROM i_ext_et_ac_ledgers WHERE iextetacl_owner='$oid' AND iextetacl_id='$lid'");
    	    $data['details'] = $query->result();
    	    
		// 		    $data['txn']= $this->acc_model->load_ledger_details($oid, $lid, $fy, $ty);
		// 		    $data['details'] = $this->acc_model->load_ledgers($oid, null, $lid);
		// 			$data['ledgers'] = $this->acc_model->load_ledgers($oid);
		// 			$data['groups'] = $this->acc_model->load_groups($oid);
			
			// $query = $this->db->query("SELECT * FROM i_n_ac_group_ledgers AS a LEFT JOIN i_n_ac_groups AS b ON a.inagl_g_id=b.inag_id WHERE a.inagl_l_id='$lid' AND a.inagl_owner='$oid'");
			// $data['g_details'] = $query->result();

			$data['lid']=$lid;
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;$data['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['title'] = "Ledgers Details: ".$data['details'][0]->iextetacl_name;
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$this->load->view('navbar', $ert);
			$this->load->view('accounting/ledger_details', $data);
		} else {
		    redirect(base_url().'account/login');
		}
	}
	
	public function update_ledger_star($code) {
	    $sess_data = $this->log_code->get_session_value($code,true);
        if($sess_data['session'] == 'true') {
    		$uid = $sess_data['user_details'][0]->i_uid;
    		$oid = $sess_data['user_details'][0]->i_owner;
    		$gid = $sess_data['gid'];
			
			$this->db->where(array('iextetacl_id' => $this->input->post('l'), 'iextetacl_owner' => $oid));
			$this->db->update('i_ext_et_ac_ledgers', array('iextetacl_starred' => $this->input->post('s')));

			echo "true";
		} else {
		    redirect(base_url().'account/login');
		}
	}
}