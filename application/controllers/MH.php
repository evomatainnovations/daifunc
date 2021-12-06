<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MH extends CI_Controller {

	public function __construct()	{
			parent:: __construct();
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->library('email');
			$this->load->library('excel_reader');
			$this->load->library('pagination');
			$this->load->model('Code','log_code');
	}

	function load_outcome($func, $code, $txnid, $mod_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$dt = date('Y-m-d H:i:s');
			
			$query = $this->db->query("SELECT * FROM i_helper WHERE ih_func_name='$func'");
			$result = $query->result();
			$outcome = [];$tmpstr='';
			if (count($result) > 0) {
				$tmp = $result[0]->ih_outcome_value;
				eval("\$tmpstr = $tmp;");
				array_push($outcome, array('type'=> $result[0]->ih_outcome_type, 'value' => $tmpstr));
			}

			return $outcome;
		}
	}

	public function transfer_proposal_inventory_outward($code, $proposal_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Proposal') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;
			$cid = 0;
			$txn_gid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_proposal where iextepro_id = '$proposal_id' AND iextepro_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->iextepro_customer_id;
				$txn_gid = $result[0]->iextepro_txn_id;
				$data = array(
					'iextei_customer_id' => $result[0]->iextepro_customer_id,
					'iextei_txn_id' => $result[0]->iextepro_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'outward',
					'iextei_owner' => $oid,
					'iextei_note' => $result[0]->iextepro_note,
					'iextei_gid' => $result[0]->iextepro_gid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid
				);
				$this->db->insert('i_ext_et_inventory',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_property where iexteppt_pid = '$proposal_id'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $ins_id,
						'iexteinvept_property_value' => $result[$i]->iexteppt_property_value,
						'iexteinvept_status' => $result[$i]->iexteppt_status
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'proposal' AND iet_type_id = '$proposal_id' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_mutual WHERE iextepm_pid = '$proposal_id' AND iextepm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinm_pid' => $ins_id,
						'iexteinm_uid' => $result[$i]->iextepm_uid,
						'iexteinm_oid' => $oid
					);
					$this->db->insert('i_ext_et_inventory_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}
			$from_id = $star_acc;
			$from_type = 'account';
			$to_id = $cid;
			$to_type = 'contact';

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a left JOIN i_ext_et_proposal_product_details as b on a.iextepro_id=b.iexteprod_pro_id LEFT join i_product as c on b.iexteprod_product_id=c.ip_id WHERE a.iextepro_id ='$proposal_id' AND a.iextepro_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$inward = 0;
					$outward = 0;
					$inward = $result[$i]->iexteprod_qty;
					$data = array(
						'iin_from' => $from_id,
						'iin_from_type' => $from_type,
						'iin_to' => $to_id,
						'iin_to_type' => $to_type,
						'iin_date' => date('Y-m-d'),
						'iin_order_txn' => $ins_id,
						'iin_p_id' => $result[$i]->iexteprod_product_id,
						'iin_inward' => $inward,
						'iin_outward' => $outward,
						'iin_owner' => $oid,
						'iin_created' => $dt,
						'iin_created_by' => $uid,
						'iin_serial_number' => $result[$i]->iexteprod_serial_number,
						'iin_alias' => 'false',
						'iin_gid' => $txn_gid,
						'iin_txn_type' => 'outward'
					);
					$this->db->insert('i_inventory_new', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $ins_id,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);
				}	
			}
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $proposal_id,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_proposal_inventory_outward', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function add_project($code, $tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Proposal') {
					$mod_id = $module[$i]->mid;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal where iextepro_id = '$tid' AND iextepro_owner = '$oid' ");
			$result = $query->result();
			$desc = '';$pname='';
			if (count($result) > 0 ) {
				$desc = $result[0]->iextepro_note;
				$pname = $result[0]->iextepro_txn_id;
			}

			$data = array(
				'iextpp_p_name' => $pname,
				'iextpp_p_description' => $desc,
				'iextpp_owner' => $oid,
				'iextpp_created' => date('Y-m-d H:i:s'),
				'iextpp_created_by' => $uid,
				'iextpp_gid' => $gid,
				'iextpp_p_start_date' => date('Y-m-d'),
				'iextpp_p_status' => 'open'
			);
			$this->db->insert('i_ext_pro_project', $data);
			$pid = $this->db->insert_id();

			$to_mid = 0 ;
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Projects') {
					$to_mid = $module[$i]->mid;
				}
			}

			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $tid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $pid,
				'iextemt_created' => date('Y-m-d H:i:s'),
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/add_project', $code, $pid, $mod_id)));

		}else{
			redirect(base_url().'account/login');
		}
	}

	public function transfer_proposal_invoice($code,$proposal_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Proposal') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal where iextepro_id = '$proposal_id' AND iextepro_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data = array(
					'iextein_customer_id' => $result[0]->iextepro_customer_id,
					'iextein_txn_id' => $result[0]->iextepro_txn_id,
					'iextein_txn_date' => $dt,
					'iextein_type' => 'unpaid',
					'iextein_amount' => $result[0]->iextepro_amount,
					'iextein_owner' => $oid,
					'iextein_note' => $result[0]->iextepro_note,
					'iextein_gid' => $result[0]->iextepro_gid,
					'iextein_created' => $dt,
					'iextein_created_by' => $uid,
					'iextein_txn_type' => 'invoice'
				);
				$this->db->insert('i_ext_et_invoice',$data);
				$ins_id = $this->db->insert_id();
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_property where iexteppt_pid = '$proposal_id'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinpt_inid' => $ins_id,
						'iexteinpt_property_value' => $result[$i]->iexteppt_property_value,
						'iexteinpt_status' => $result[$i]->iexteppt_status
					);
					$this->db->insert('i_ext_et_invoice_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'proposal' AND iet_type_id = '$proposal_id' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'invoice',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_mutual WHERE iextepm_pid = '$proposal_id' AND iextepm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteim_pid' => $ins_id,
						'iexteim_uid' => $result[$i]->iextepm_uid,
						'iexteim_oid' => $oid
					);
					$this->db->insert('i_ext_et_invoice_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a left JOIN i_ext_et_proposal_product_details as b on a.iextepro_id=b.iexteprod_pro_id LEFT join i_product as c on b.iexteprod_product_id=c.ip_id LEFT JOIN i_p_price as d on b.iexteprod_product_id = d.ipp_p_id LEFT JOIN i_p_taxes as e on b.iexteprod_product_id = e.ipt_p_id WHERE a.iextepro_id ='$proposal_id' AND a.iextepro_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinpd_d_id' => $ins_id,
						'iexteinpd_product_id' => $result[$i]->iexteprod_product_id,
						'iexteinpd_model_number' => $result[$i]->iexteprod_model_number,
						'iexteinpd_serial_number' => $result[$i]->iexteprod_serial_number,
						'iexteinpd_rate' => $result[$i]->iexteprod_rate,
						'iexteinpd_qty' => $result[$i]->iexteprod_qty,
						'iexteinpd_discount' => $result[$i]->iexteprod_discount,
						'iexteinpd_amount' => $result[$i]->iexteprod_amount,
						'iexteinpd_tax' => $result[$i]->iexteprod_tax,
						'iexteinpd_tax_amount' => $result[$i]->iexteprod_tax_amount,
						'iexteinpd_owner' => $result[$i]->iexteprod_owner,
						'iexteinpd_alias' => $result[$i]->iexteprod_alias
					);
					$this->db->insert('i_ext_et_invoice_product_details', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Invoice' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteintm_inid' => $ins_id,
						'iexteintm_term_id' => $result[$i]->iextdt_id,
						'iexteintm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_invoice_terms',$data);				
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $proposal_id,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_proposal_invoice', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function transfer_inventory_outward_invoice($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory  WHERE iextei_id ='$inid' AND iextei_owner = '$oid' AND iextei_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				// for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iextein_customer_id' => $result[0]->iextei_customer_id,
						'iextein_txn_id' => $result[0]->iextei_txn_id,
						'iextein_txn_date' => $dt,
						'iextein_type' => 'unpaid',
						'iextein_owner' => $oid,
						'iextein_note' => $result[0]->iextei_note,
						'iextein_gid' => $result[0]->iextei_gid,
						'iextein_created' => $dt,
						'iextein_created_by' => $uid,
						'iextein_warranty' => $result[0]->iextei_warranty,
						'iextein_txn_type' => 'invoice'
					);
					$this->db->insert('i_ext_et_invoice',$data);
					$ins_id = $this->db->insert_id();
				// }
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_property where iexteinvept_inid = '$inid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinpt_inid' => $ins_id,
						'iexteinpt_property_value' => $result[$i]->iexteinvept_property_value,
						'iexteinpt_status' => $result[$i]->iexteinvept_status
					);
					$this->db->insert('i_ext_et_invoice_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'inventory' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'invoice',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_mutual as a LEFT JOIN i_customers as b on a.iexteinm_uid = b.ic_uid WHERE iexteinm_pid = '$inid' AND iexteinm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteim_pid' => $ins_id,
						'iexteim_uid' => $result[$i]->iexteinm_uid,
						'iexteim_oid' => $oid
					);
					$this->db->insert('i_ext_et_invoice_mutual',$data);
				}
			}
			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a left JOIN i_inventory_new as b on a.iextei_id=b.iin_order_txn LEFT join i_product as c on b.iin_p_id=c.ip_id LEFT JOIN i_p_price as d on b.iin_p_id = d.ipp_p_id LEFT JOIN i_p_taxes as e on b.iin_p_id = e.ipt_p_id WHERE a.iextei_id ='$inid' AND a.iextei_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$amount = $result[$i]->ipp_sell_price * $result[$i]->iin_inward;
					$data = array(
						'iexteinpd_d_id' => $ins_id,
						'iexteinpd_product_id' => $result[$i]->iin_p_id,
						'iexteinpd_serial_number' => $result[$i]->iin_serial_number,
						'iexteinpd_rate' => $result[$i]->ipp_sell_price,
						'iexteinpd_qty' => $result[$i]->iin_inward,
						'iexteinpd_amount' => $amount,
						'iexteinpd_tax' => $result[$i]->ipt_t_id,
						'iexteinpd_owner' => $result[$i]->iin_owner,
						'iexteinpd_alias' => $result[$i]->iin_alias
					);
					$this->db->insert('i_ext_et_invoice_product_details', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Invoice' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteintm_inid' => $ins_id,
						'iexteintm_term_id' => $result[$i]->iextdt_id,
						'iexteintm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_invoice_terms',$data);
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_inventory_outward_invoice', $code, $ins_id, $mod_id)));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function transfer_invoice_inventory_outward($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;
			$cid = 0;
			$txn_gid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a WHERE a.iextein_id ='$inid' AND a.iextein_owner = '$oid' AND a.iextein_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->iextein_customer_id;
				$txn_gid = $result[0]->iextein_gid;
				$data = array(
					'iextei_customer_id' => $result[0]->iextein_customer_id,
					'iextei_txn_id' => $result[0]->iextein_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'outward',
					'iextei_owner' => $oid,
					'iextei_note' => $result[0]->iextein_note,
					'iextei_gid' => $result[0]->iextein_gid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_warranty' => $result[0]->iextein_warranty
				);
				$this->db->insert('i_ext_et_inventory',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_property where iexteinpt_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $ins_id,
						'iexteinvept_property_value' => $result[$i]->iexteinpt_property_value,
						'iexteinvept_status' => $result[$i]->iexteinpt_status
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'invoice' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_mutual as a LEFT JOIN i_customers as b on a.iexteim_uid = b.ic_uid WHERE iexteim_pid = '$inid' AND iexteim_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinm_pid' => $ins_id,
						'iexteinm_uid' => $result[$i]->iexteim_uid,
						'iexteinm_oid' => $oid
					);
					$this->db->insert('i_ext_et_inventory_mutual',$data);
				}
			}
			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}
			$from_id = $star_acc;
			$from_type = 'account';
			$to_id = $cid;
			$to_type = 'contact';

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a left JOIN i_ext_et_invoice_product_details as b on a.iextein_id=b.iexteinpd_d_id LEFT join i_product as c on b.iexteinpd_product_id=c.ip_id WHERE a.iextein_id ='$inid' AND a.iextein_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$inward = $result[$i]->iexteinpd_qty;
					$data = array(
						'iin_from' => $from_id,
						'iin_from_type' => $from_type,
						'iin_to' => $to_id,
						'iin_to_type' => $to_type,
						'iin_date' => date('Y-m-d'),
						'iin_order_txn' => $ins_id,
						'iin_p_id' => $result[$i]->iexteinpd_product_id,
						'iin_inward' => $inward,
						'iin_outward' => 0,
						'iin_owner' => $oid,
						'iin_created' => $dt,
						'iin_created_by' => $uid,
						'iin_serial_number' => $result[$i]->iexteinpd_serial_number,
						'iin_alias' => 'false',
						'iin_gid' => $txn_gid,
						'iin_txn_type' => 'outward'
					);
					$this->db->insert('i_inventory_new', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $ins_id,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);				
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_invoice_inventory_outward', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function transfer_inventory_inward_purchase($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a where a.iextei_id ='$inid' AND a.iextei_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				$data = array(
					'iextep_customer_id' => $result[0]->iextei_customer_id,
					'iextep_txn_id' => $result[0]->iextei_txn_id,
					'iextep_txn_date' => $dt,
					'iextep_type' => 'formal',
					'iextep_status' => 'unpaid',
					'iextep_owner' => $oid,
					'iextep_note' => $result[0]->iextei_note,
					'iextep_gid' => $result[0]->iextei_gid,
					'iextep_created' => $dt,
					'iextep_created_by' => $uid,
					'iextep_warranty' => $result[0]->iextei_warranty
				);
				$this->db->insert('i_ext_et_purchase',$data);
				$ins_id = $this->db->insert_id();
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_property where iexteinvept_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteprpt_inid' => $ins_id,
						'iexteprpt_property_value' => $result[$i]->iexteinvept_property_value,
						'iexteprpt_status' => $result[$i]->iexteinvept_status
					);
					$this->db->insert('i_ext_et_purchase_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'inventory' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'purchase',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_mutual WHERE iexteinm_pid = '$inid' AND iexteinm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteprcm_pid' => $ins_id,
						'iexteprcm_uid' => $result[$i]->iexteinm_uid,
						'iexteprcm_oid' => $oid
					);
					$this->db->insert('i_ext_et_purchase_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a left JOIN i_inventory_new as b on a.iextei_id=b.iin_order_txn LEFT join i_product as c on b.iin_p_id=c.ip_id LEFT JOIN i_p_price as d on b.iin_p_id = d.ipp_p_id LEFT JOIN i_p_taxes as e on b.iin_p_id = e.ipt_p_id WHERE a.iextei_id ='$inid' AND a.iextei_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$amount = $result[$i]->ipp_sell_price * $result[$i]->iin_inward;
					$data = array(
						'iexteppd_d_id' => $ins_id,
						'iexteppd_product_id' => $result[$i]->iin_p_id,
						'iexteppd_serial_number' => $result[$i]->iin_serial_number,
						'iexteppd_rate' => $result[$i]->ipp_sell_price,
						'iexteppd_qty' => $result[$i]->iin_inward,
						'iexteppd_amount' => $amount,
						'iexteppd_tax' => $result[$i]->ipt_t_id,
						'iexteppd_owner' => $oid
					);
					$this->db->INSERT('i_ext_et_purchase_product_details',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Purchase' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteprtm_inid' => $ins_id,
						'iexteprtm_term_id' => $result[$i]->iextdt_id,
						'iexteprtm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_purchase_terms',$data);				
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Purchase') {
					$to_mod_id = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mod_id,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_inventory_inward_purchase', $code, $ins_id, $mod_id)));
		}else{
			redirect(base_url().'account/login');	
		}
	}

	public function transfer_purchase_inventory_inward($code, $inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Purchase') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;
			$cid = 0;
			$txn_gid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_purchase where iextep_id = '$inid' AND iextep_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->iextep_customer_id;
				$txn_gid = $result[0]->iextep_gid;
				$data = array(
					'iextei_customer_id' => $result[0]->iextep_customer_id,
					'iextei_txn_id' => $result[0]->iextep_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'inward',
					'iextei_owner' => $oid,
					'iextei_note' => $result[0]->iextep_note,
					'iextei_gid' => $result[0]->iextep_gid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_warranty' => $result[0]->iextep_warranty
				);
				$this->db->insert('i_ext_et_inventory',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase_property where iexteprpt_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinvept_inid' => $ins_id,
						'iexteinvept_property_value' => $result[$i]->iexteprpt_property_value,
						'iexteinvept_status' => $result[$i]->iexteprpt_status
					);
					$this->db->insert('i_ext_et_inventory_property',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'purchase' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase_mutual WHERE iexteprcm_pid = '$inid' AND iexteprcm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinm_pid' => $ins_id,
						'iexteinm_uid' => $result[$i]->iextepecm_uid,
						'iexteinm_oid' => $oid
					);
					$this->db->insert('i_ext_et_inventory_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}
			$from_id = $cid;
			$from_type = 'contact';
			$to_id = $star_acc;
			$to_type = 'account';

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a left JOIN i_ext_et_purchase_product_details as b on a.iextep_id=b.iexteppd_d_id LEFT join i_product as c on b.iexteppd_product_id=c.ip_id WHERE a.iextep_id ='$inid' AND a.iextep_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$inward = $result[$i]->iexteppd_qty;
					$outward = 0;
					$data = array(
						'iin_from' => $from_id,
						'iin_from_type' => $from_type,
						'iin_to' => $to_id,
						'iin_to_type' => $to_type,
						'iin_date' => date('Y-m-d'),
						'iin_order_txn' => $ins_id,
						'iin_p_id' => $result[$i]->iexteppd_product_id,
						'iin_inward' => $inward,
						'iin_outward' => $outward,
						'iin_owner' => $oid,
						'iin_created' => $dt,
						'iin_created_by' => $uid,
						'iin_serial_number' => $result[$i]->iexteppd_serial_number,
						'iin_alias' => 'false',
						'iin_gid' => $txn_gid,
						'iin_txn_type' => 'inward'
					);
					$this->db->insert('i_inventory_new', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $ins_id,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);
					$this->db->insert('i_ext_et_inventory_terms',$data);
				}
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$to_mod_id = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mod_id,
				'iextemt_to_txn' => $txnid,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);
			
			print_r(json_encode($this->load_outcome('MH/transfer_purchase_inventory_inward', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function transfer_invoice_subscription($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a WHERE a.iextein_id ='$inid' AND a.iextein_owner = '$oid' AND a.iextein_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data = array(
					'iextamc_customer_id' => $result[0]->iextein_customer_id,
					'iextamc_txn_id' => $result[0]->iextein_txn_id,
					'iextamc_txn_date' => $dt,
					'iextamc_type' => 'formal',
					'iextamc_owner' => $oid,
					'iextamc_amount' => $result[0]->iextein_amount,
					'iextamc_note' => $result[0]->iextein_note,
					'iextamc_gid' => $result[0]->iextein_gid,
					'iextamc_created' => $dt,
					'iextamc_created_by' => $uid
				);
				$this->db->insert('i_ext_et_amc',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_property where iexteinpt_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iextamcpt_inid' => $ins_id,
						'iextamcpt_property_value' => $result[$i]->iexteinpt_property_value,
						'iextamcpt_status' => $result[$i]->iexteinpt_status
					);
					$this->db->insert('i_ext_et_amc_property',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'invoice' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_mutual as a LEFT JOIN i_customers as b on a.iexteim_uid = b.ic_uid WHERE iexteim_pid = '$inid' AND iexteim_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iextamcm_pid' => $ins_id,
						'iextamcm_uid' => $result[$i]->iexteim_uid,
						'iextamcm_oid' => $oid
					);
					$this->db->insert('i_ext_et_amc_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a left JOIN i_ext_et_invoice_product_details as b on a.iextein_id=b.iexteinpd_d_id LEFT join i_product as c on b.iexteinpd_product_id=c.ip_id WHERE a.iextein_id ='$inid' AND a.iextein_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$inward = 0;
					$outward = $result[$i]->iexteinpd_qty;
					$data = array(
						'iextamcpd_d_id' => $ins_id,
						'iextamcpd_product_id' => $result[$i]->iexteinpd_product_id,
						'iextamcpd_serial_number' => $result[$i]->iexteinpd_serial_number,
						'iextamcpd_model_number' => $result[$i]->iexteinpd_model_number,
						'iextamcpd_rate' => $result[$i]->iexteinpd_rate,
						'iextamcpd_qty' => $result[$i]->iexteinpd_qty,
						'iextamcpd_discount' => $result[$i]->iexteinpd_discount,
						'iextamcpd_amount' => $result[$i]->iexteinpd_amount,
						'iextamcpd_tax' => $result[$i]->iexteinpd_tax,
						'iextamcpd_owner' => $oid,
						'iextamcpd_alias' => $result[$i]->iexteinpd_alias
					);
					$this->db->insert('i_ext_et_amc_product_details', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='AMC' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iextamctm_inid' => $ins_id,
						'iextamctm_term_id' => $result[$i]->iextdt_id,
						'iextamctm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_amc_terms',$data);				
				}	
			}
			$to_mod_id='';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Subscription') {
					$to_mod_id = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mod_id,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_invoice_subscription', $code, $ins_id, $mod_id)));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function proposal_revision($code,$proposal_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Proposal') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal where iextepro_id = '$proposal_id' AND iextepro_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data = array(
					'iextepro_customer_id' => $result[0]->iextepro_customer_id,
					'iextepro_txn_id' => $result[0]->iextepro_txn_id.'/RE-1',
					'iextepro_txn_date' => $dt,
					'iextepro_type' => $result[0]->iextepro_type,
					'iextepro_status' => $result[0]->iextepro_status,
					'iextepro_amount' => $result[0]->iextepro_amount,
					'iextepro_owner' => $oid,
					'iextepro_note' => $result[0]->iextepro_note,
					'iextepro_gid' => $result[0]->iextepro_gid,
					'iextepro_created' => $dt,
					'iextepro_created_by' => $uid
				);
				$this->db->insert('i_ext_et_proposal',$data);
				$ins_id = $this->db->insert_id();
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_property where iexteppt_pid = '$proposal_id'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteppt_pid' => $ins_id,
						'iexteppt_property_value' => $result[$i]->iexteppt_property_value,
						'iexteppt_status' => $result[$i]->iexteppt_status
					);
					$this->db->insert('i_ext_et_proposal_property',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'proposal' AND iet_type_id = '$proposal_id' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'proposal',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal_mutual WHERE iextepm_pid = '$proposal_id' AND iextepm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iextepm_pid' => $ins_id,
						'iextepm_uid' => $result[$i]->iextepm_uid,
						'iextepm_oid' => $oid
					);
					$this->db->insert('i_ext_et_proposal_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a left JOIN i_ext_et_proposal_product_details as b on a.iextepro_id=b.iexteprod_pro_id LEFT join i_product as c on b.iexteprod_product_id=c.ip_id LEFT JOIN i_p_price as d on b.iexteprod_product_id = d.ipp_p_id LEFT JOIN i_p_taxes as e on b.iexteprod_product_id = e.ipt_p_id WHERE a.iextepro_id ='$proposal_id' AND a.iextepro_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteprod_pro_id' => $ins_id,
						'iexteprod_product_id' => $result[$i]->iexteprod_product_id,
						'iexteprod_model_number' => $result[$i]->iexteprod_model_number,
						'iexteprod_serial_number' => $result[$i]->iexteprod_serial_number,
						'iexteprod_rate' => $result[$i]->iexteprod_rate,
						'iexteprod_qty' => $result[$i]->iexteprod_qty,
						'iexteprod_discount' => $result[$i]->iexteprod_discount,
						'iexteprod_amount' => $result[$i]->iexteprod_amount,
						'iexteprod_tax' => $result[$i]->iexteprod_tax,
						'iexteprod_tax_amount' => $result[$i]->iexteprod_tax_amount,
						'iexteprod_owner' => $result[$i]->iexteprod_owner,
						'iexteprod_alias' => $result[$i]->iexteprod_alias
					);
					$this->db->insert('i_ext_et_proposal_product_details', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Proposal' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteptm_pid' => $ins_id,
						'iexteptm_term_id' => $result[$i]->iextdt_id,
						'iexteptm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_proposal_terms',$data);				
				}	
			}

			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $proposal_id,
				'iextemt_to_mid' => $mod_id,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/proposal_revision', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function transfer_orders_inventory_outward_dispatch($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;
			$cid = 0;
			$txn_gid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_orders as a WHERE a.iextetor_id ='$inid' AND a.iextetor_owner = '$oid' AND a.iextetor_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->iextetor_customer_id;
				$txn_gid = $result[0]->iextetor_gid;
				$data = array(
					'iextei_customer_id' => $result[0]->iextetor_customer_id,
					'iextei_txn_id' => $result[0]->iextetor_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'outward',
					'iextei_owner' => $oid,
					'iextei_note' => $result[0]->iextetor_note,
					'iextei_gid' => $result[0]->iextetor_gid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_status' => 'dispatch'
				);
				$this->db->insert('i_ext_et_inventory',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_property where iextetorp_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $ins_id,
						'iexteinvept_property_value' => $result[$i]->iextetorp_property_value,
						'iexteinvept_status' => $result[$i]->iextetorp_status
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'orders' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_mutual as a LEFT JOIN i_customers as b on a.iextetorm_uid = b.ic_uid WHERE iextetorm_order_id = '$inid' AND iextetorm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinm_pid' => $ins_id,
						'iexteinm_uid' => $result[$i]->iextetorm_uid,
						'iexteinm_oid' => $oid
					);
					$this->db->insert('i_ext_et_inventory_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}
			$from_id = $star_acc;
			$from_type = 'account';
			$to_id = $cid;
			$to_type = 'contact';
			$query = $this->db->query("SELECT * FROM i_ext_et_orders as a left JOIN i_ext_et_orders_product_details as b on a.iextetor_id=b.iextetodp_order_id LEFT join i_product as c on b.iextetodp_pid=c.ip_id WHERE a.iextetor_id ='$inid' AND a.iextetor_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$inward = $result[$i]->iextetodp_approved_qty;
					$outward = 0;
					$data = array(
						'iin_from' => $from_id,
						'iin_from_type' => $from_type,
						'iin_to' => $to_id,
						'iin_to_type' => $to_type,
						'iin_date' => date('Y-m-d'),
						'iin_order_txn' => $ins_id,
						'iin_p_id' => $result[$i]->iextetodp_pid,
						'iin_inward' => $inward,
						'iin_outward' => $outward,
						'iin_owner' => $oid,
						'iin_created' => $dt,
						'iin_created_by' => $uid,
						'iin_serial_number' => $result[$i]->iextetodp_serial_number,
						'iin_alias' => 'false',
						'iin_gid' => $txn_gid,
						'iin_txn_type' => 'outward'
					);
					$this->db->insert('i_inventory_new', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $ins_id,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);				
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_orders_inventory_outward_dispatch', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function transfer_orders_inventory_outward($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mod_id = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Invoice') {
					$mod_id = $module[$i]->mid;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$ins_id = 0;
			$cid = 0;
			$txn_gid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_orders as a WHERE a.iextetor_id ='$inid' AND a.iextetor_owner = '$oid' AND a.iextetor_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$cid = $result[0]->iextetor_customer_id;
				$txn_gid = $result[0]->iextetor_gid;
				$data = array(
					'iextei_customer_id' => $result[0]->iextetor_customer_id,
					'iextei_txn_id' => $result[0]->iextetor_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'outward',
					'iextei_owner' => $oid,
					'iextei_note' => $result[0]->iextetor_note,
					'iextei_gid' => $result[0]->iextetor_gid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_status' => 'ready'
				);
				$this->db->insert('i_ext_et_inventory',$data);
				$ins_id = $this->db->insert_id();
			}
			$txnid=$ins_id;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_property where iextetorp_inid = '$inid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $ins_id,
						'iexteinvept_property_value' => $result[$i]->iextetorp_property_value,
						'iexteinvept_status' => $result[$i]->iextetorp_status
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'orders' AND iet_type_id = '$inid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			if (count($result) > 0 ) {
				for ($j=0; $j < count($result) ; $j++) {
					$data5 = array(
						'iet_type_id' => $ins_id,
						'iet_type' => 'inventory',
						'iet_tag_id' => $result[$j]->it_id,
						'iet_owner' => $oid,
						'iet_m_id' => $mod_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_mutual as a LEFT JOIN i_customers as b on a.iextetorm_uid = b.ic_uid WHERE iextetorm_order_id = '$inid' AND iextetorm_oid = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$data = array(
						'iexteinm_pid' => $ins_id,
						'iexteinm_uid' => $result[$i]->iextetorm_uid,
						'iexteinm_oid' => $oid
					);
					$this->db->insert('i_ext_et_inventory_mutual',$data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}
			$from_id = $star_acc;
			$from_type = 'account';
			$to_id = $cid;
			$to_type = 'contact';
			$query = $this->db->query("SELECT * FROM i_ext_et_orders as a left JOIN i_ext_et_orders_product_details as b on a.iextetor_id=b.iextetodp_order_id LEFT join i_product as c on b.iextetodp_pid=c.ip_id WHERE a.iextetor_id ='$inid' AND a.iextetor_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) { 
					$inward = $result[$i]->iextetodp_approved_qty;
					$outward = 0;
					$data = array(
						'iin_from' => $from_id,
						'iin_from_type' => $from_type,
						'iin_to' => $to_id,
						'iin_to_type' => $to_type,
						'iin_date' => date('Y-m-d'),
						'iin_order_txn' => $ins_id,
						'iin_p_id' => $result[$i]->iextetodp_pid,
						'iin_inward' => $inward,
						'iin_outward' => $outward,
						'iin_owner' => $oid,
						'iin_created' => $dt,
						'iin_created_by' => $uid,
						'iin_serial_number' => $result[$i]->iextetodp_serial_number,
						'iin_alias' => 'false',
						'iin_gid' => $txn_gid,
						'iin_txn_type' => 'outward'
					);
					$this->db->insert('i_inventory_new', $data);
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $ins_id,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);				
				}	
			}

			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mod_id,
				'iextemt_from_txn' => $inid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $ins_id,
				'iextemt_created' => $dt,
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);

			print_r(json_encode($this->load_outcome('MH/transfer_orders_inventory_outward', $code, $ins_id, $mod_id)));
		} else {
			redirect(base_url().'account/login');
		}
	}
} 
?>
