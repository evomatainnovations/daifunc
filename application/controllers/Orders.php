<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {

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
					if ($module[$i]->mname == 'Orders') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_orders as a LEFT JOIN i_customers as c on a.iextetor_customer_id = c.ic_id WHERE iextetor_owner = '$oid' AND iextetor_gid = '$gid' AND ic_owner = '$oid' ");
			$result2 = $query->result();
			$data['edit_orders'] = $result2;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders WHERE iextetor_owner = '$oid' AND iextetor_gid = '$gid' GROUP BY iextetor_status ");
			$result = $query->result();
			$data['status'] = $result;
			
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
			$this->load->view('orders/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function orders_filter($code) {
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
			$in_created = $this->input->post('in_created');

			if ($in_created != null) {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$in_created' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$in_created = $result[0]->ic_uid;
				}
			}

			$this->db->select('*');
			$this->db->from('i_ext_et_orders');
			$this->db->join('i_customers', 'i_customers.ic_id = i_ext_et_orders.iextetor_customer_id','left');
			if ($from_date != '') {
				$this->db->where('iextetor_date >=', $from_date);
			}
			if ($to_date != '') {
				$this->db->where('iextetor_date <=', $to_date);
			}
			if ($in_created != '') {
				$this->db->where('iextetor_created_by', $in_created);
			}
			if ($status != '') {
				$this->db->where('iextetor_status', $status);
			}
			if ($min_amount != '') {
				$this->db->where('iextetor_amount >=', $min_amount);
			}
			if ($max_amount != '') {
				$this->db->where('iextetor_amount <=', $max_amount);
			}
			$this->db->where('i_ext_et_orders.iextetor_owner', $oid);
			$query = $this->db->get();
			$data['query'] = $query;
			$data['filter'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}	

	public function orders_add($mid=null,$code,$txn_id=null) {
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
					if ($module[$i]->mname == 'Orders') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			$invoice_txn_id = '';
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
			$data['invoice_doc_id'] = $invoice_txn_id;

			if ($txn_id != null) {
				$query = $this->db->query("SELECT * FROM i_ext_et_orders as a left JOIN i_ext_et_orders_product_details as b on a.iextetor_id = b.iextetodp_order_id LEFT JOIN i_product as c on b.iextetodp_pid = c.ip_id WHERE iextetor_owner = '$oid' AND iextetor_gid = '$gid' AND iextetor_id = '$txn_id' AND ip_owner = '$oid' ");
				$result2 = $query->result();
				$data['edit_orders'] = $result2;
				$data['invoice_gid'] = $result2[0]->iextetor_gid;
				$cid = $result2[0]->iextetor_customer_id;

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id ='$cid' ");
				$result = $query->result();
				$data['edit_cust'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_orders_property WHERE iextetorp_inid = '$txn_id' ");
				$result = $query->result();
				$data['invoice_property'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_orders_mutual WHERE iextetorm_order_id = '$txn_id' AND iextetorm_oid = '$oid' ");
				$result = $query->result();
				$data['mutual'] = $result;

				$query2 = $this->db->query("SELECT * FROM i_ext_tags as a LEFT JOIN i_tags as b on a.iet_tag_id = b.it_id WHERE iet_type_id='$txn_id' AND iet_type = 'orders' ");
				$result2 = $query2->result();
				$data['pro_tags'] = $result2;

				$query = $this->db->query("SELECT * FROM i_ext_et_orders_terms as a LEFT JOIN i_ext_et_document_terms as b on a.iextetort_term_id = b.iextdt_id WHERE iextetort_inid = '$txn_id' AND iextdt_owner='$oid' ");
				$result = $query->result();
				$data['p_terms'] = $result;

				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$mid' ");
				$data['helper'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$mid' ");
				$data['help_parameter'] = $query->result();

				$data['tid'] = $txn_id;
			}else{
				$data['invoice_doc_id'] = $invoice_txn_id;

				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Orders' AND iextdt_owner='$oid'");
				$result = $query->result();
				$data['term_doc'] = $result;
			}

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid'  AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['tax'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;
			
			$data['oid'] = $oid;$data['code']=$code;$data['mod_id'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('orders/orders_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function orders_product_rate($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$product_name = $this->input->post('pname');
			$query = $this->db->query("SELECT * FROM i_product as a left join i_p_price as b on a.ip_id = b.ipp_p_id left join i_p_taxes as c on a.ip_id = c.ipt_p_id WHERE ip_product = '$product_name' AND ip_created_by = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data['prod_rate'] = $result[0]->ipp_sell_price;
				$data['prod_tax'] = $result[0]->ipt_t_id;
				$pid = $result[0]->ip_id;
				$pro_list = [];
				$que = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' AND iexteid_product_id = '$pid' ");
				$result = $que->result();
				for ($j=0; $j < count($result) ; $j++) {
					$pro_id = $result[$j]->iexteid_product_id;
					$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id WHERE iextei_owner = '$oid' AND iexteid_product_id = '$pro_id' GROUP BY iextei_type ORDER BY inv DESC");
					$res = $que->result();
					$bal = 0 ;
					for ($i=0; $i <count($res); $i++) {
						if ($res[$i]->iextei_type == 'inward') {
							$bal = $bal + $res[$i]->inv;
						}else if ($res[$i]->iextei_type == 'outward') {
							$bal = $bal - $res[$i]->inv;
						}else if ($res[$i]->iextei_type == 'spare') {
							$bal = $bal - $res[$i]->inv;
						}else if ($res[$i]->iextei_type == 'def_sys') {
							$bal = $bal + $res[$i]->inv;
						}else if ($res[$i]->iextei_type == 'def_out') {
							$bal = $bal - $res[$i]->inv;
						}else if ($res[$i]->iextei_type == 'def_in') {
							$bal = $bal + $res[$i]->inv;
						}
					}
					array_push($pro_list, array('pid' => $pro_id, 'bal' => $bal));
				}
				$data['product_list'] = $pro_list;
				print_r(json_encode($data));
			}else{
				echo "false";
			}
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function orders_save($type,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$product = $this->input->post('product');
			$amount = $this->input->post('ord_amt');
			$dt = date('Y-m-d H:i:s');
			$note = $this->input->post('note');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$tags = $this->input->post('tags');
			$mutual = $this->input->post('mutual');
			$wrnt = $this->input->post('wrt_mnt');
			$module_id = '';
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Orders') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;
				$c_uid = $result[0]->ic_uid;
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
				$c_uid = 0;
			}

			$data = array(
				'iextetor_customer_id' => $cid,
				'iextetor_txn_id' => $txn_no,
				'iextetor_date' => $txn_date,
				'iextetor_type' => $type,
				'iextetor_amount' => $amount,
				'iextetor_status' => 'approved',
				'iextetor_note' => $note,
				'iextetor_owner' => $oid,
				'iextetor_created' => $dt,
				'iextetor_created_by' => $uid,
				'iextetor_gid' => $gid
			);
			$this->db->insert('i_ext_et_orders',$data);
			$orid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iextetort_inid' => $orid,
						'iextetort_term_id' => $terms[$i]['id'],
						'iextetort_status' => $status
					);	
					$this->db->insert('i_ext_et_orders_terms',$data);	
				}
			}

			for ($j=0; $j < count($tags) ; $j++) { 
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data3);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data5 = array(
					'iet_type_id' => $orid,
					'iet_type' => 'orders',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iextetorp_inid' => $orid,
						'iextetorp_property_value' => $property[$i]['value'],
						'iextetorp_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_orders_property',$data);
				}
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
							'iextetorm_order_id' => $orid,
							'iextetorm_uid' => $m_uid,
							'iextetorm_oid' => $oid
						);
						$this->db->insert('i_ext_et_orders_mutual',$data);
					}
				}
			}
			
			$data1 = array(
				'in_type_id' => $orid, 
				'in_type' => 'orders',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Orders - '.$txn_no,
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
				'iuap_p_id' => $c_uid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);

			$new_order_flg = 0;

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
						'ip_created_by' => $oid,
						'ip_gid' => $gid,
						'ip_cat_id' => 0
					 );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				} else {
					$prid = $result[0]->ip_id;
				}

				$p_total = $product[$i]['rate'] * $product[$i]['ap_qty'];
				$p_remain = $product[$i]['qty'] - $product[$i]['ap_qty'];
				if ($p_remain > 0 ) {
					$new_order_flg = 1;
				}

				$data = array(
					'iextetodp_order_id' => $orid,
					'iextetodp_pid' => $prid,
					'iextetodp_rate' => $product[$i]['rate'],
					'iextetodp_qty' => $product[$i]['ap_qty'],
					'iextetodp_approved_qty' => $product[$i]['ap_qty'],
					'iextetodp_amount' => $p_total,
					'iextetodp_owner' => $oid,
					'iextetodp_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_orders_product_details',$data);
			}

			if ($new_order_flg == 1) {
				$invoice_txn_id = '';
				$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$module_id' ORDER BY iumdi_id;");
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
				$txn_no = $invoice_txn_id;
				$data = array(
					'iextetor_customer_id' => $cid,
					'iextetor_txn_id' => $txn_no,
					'iextetor_date' => $txn_date,
					'iextetor_type' => $type,
					'iextetor_amount' => 0,
					'iextetor_status' => 'pending',
					'iextetor_note' => $note,
					'iextetor_owner' => $oid,
					'iextetor_created' => $dt,
					'iextetor_created_by' => $uid,
					'iextetor_gid' => $gid
				);
				$this->db->insert('i_ext_et_orders',$data);
				$n_orid = $this->db->insert_id();

				if (count($terms) > 0) {
					for ($i=0; $i <count($terms) ; $i++) { 
						if ($terms[$i]['status'] == 'true') {
							$status = 'true';
						}else{
							$status = 'false';
						}
						$data = array(
							'iextetort_inid' => $n_orid,
							'iextetort_term_id' => $terms[$i]['id'],
							'iextetort_status' => $status
						);	
						$this->db->insert('i_ext_et_orders_terms',$data);	
					}
				}

				for ($j=0; $j < count($tags) ; $j++) { 
					$tmp_tag = $tags[$j];

					$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
					$result = $query->result();

					if(count($result) <= 0) {
						$data3 = array(
							'it_value' => $tmp_tag,
							'it_owner' => $oid );

						$this->db->insert('i_tags', $data3);
						$tid = $this->db->insert_id();
					} else {
						$tid = $result[0]->it_id;
					}

					$data5 = array(
						'iet_type_id' => $n_orid,
						'iet_type' => 'orders',
						'iet_tag_id' => $tid,
						'iet_owner' => $oid,
						'iet_m_id' => $module_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}

				if (count($property) > 0) {
					for ($i=0; $i <count($property) ; $i++) { 
						$data = array(
							'iextetorp_inid' => $n_orid,
							'iextetorp_property_value' => $property[$i]['value'],
							'iextetorp_status' => $property[$i]['status']
						);
						$this->db->insert('i_ext_et_orders_property',$data);
					}
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
								'iextetorm_order_id' => $n_orid,
								'iextetorm_uid' => $m_uid,
								'iextetorm_oid' => $oid
							);
							$this->db->insert('i_ext_et_orders_mutual',$data);
						}
					}
				}
				
				$data1 = array(
					'in_type_id' => $n_orid, 
					'in_type' => 'orders',
					'in_m_id' => $module_id,
					'in_person' => $cid,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt1
				);
				$this->db->insert('i_notifications',$data1);

				$data = array(
					'iua_type' => 'module',
					'iua_title' => 'Orders - '.$txn_no,
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
					'iuap_p_id' => $c_uid,
					'iuap_owner' => $oid
				);
				$this->db->insert('i_u_a_person',$data);

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
							'ip_created_by' => $oid,
							'ip_gid' => $gid,
							'ip_cat_id' => 0
						 );
						$this->db->insert('i_product', $data1);
						$prid = $this->db->insert_id();
					} else {
						$prid = $result[0]->ip_id;
					}

					$p_remain = $product[$i]['qty'] - $product[$i]['ap_qty'];

					if ($p_remain > 0) {
						$data = array(
							'iextetodp_order_id' => $n_orid,
							'iextetodp_pid' => $prid,
							'iextetodp_rate' => $product[$i]['rate'],
							'iextetodp_qty' => $p_remain,
							'iextetodp_approved_qty' => $p_remain,
							'iextetodp_amount' => $product[$i]['rate'] * $p_remain,
							'iextetodp_owner' => $oid,
							'iextetodp_alias' => $product[$i]['alias']
						);
						$this->db->INSERT('i_ext_et_orders_product_details',$data);	
					}
				}
			}

			echo $orid;
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function orders_update($type,$orid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$product = $this->input->post('product');
			$ord_amt = $this->input->post('ord_amt');
			$dt = date('Y-m-d H:i:s');
			$note = $this->input->post('note');
			$status = $this->input->post('status');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$tags = $this->input->post('tags');
			$mutual = $this->input->post('mutual');
			$wrnt = $this->input->post('wrt_mnt');
			$module_id = '';
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Orders') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;
			$c_uid = $result[0]->ic_uid;

			$data = array(
				'iextetor_customer_id' => $cid,
				'iextetor_txn_id' => $txn_no,
				'iextetor_date' => $txn_date,
				'iextetor_type' => $type,
				'iextetor_amount' => $ord_amt,
				'iextetor_status' => $status,
				'iextetor_note' => $note,
				'iextetor_owner' => $oid,
				'iextetor_modified' => $dt,
				'iextetor_modified_by' => $uid,
				'iextetor_gid' => $gid
			);
			$this->db->WHERE(array('iextetor_id' => $orid , 'iextetor_owner' => $oid ));
			$this->db->update('i_ext_et_orders',$data);

			$this->db->WHERE(array('iextetort_inid' => $orid));
			$this->db->delete('i_ext_et_orders_terms');
			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iextetort_inid' => $orid,
						'iextetort_term_id' => $terms[$i]['id'],
						'iextetort_status' => $status
					);	
					$this->db->insert('i_ext_et_orders_terms',$data);	
				}
			}

			$this->db->WHERE(array('iet_type_id' => $orid , 'iet_type' => 'orders' , 'iet_owner' => $oid));
			$this->db->delete('i_ext_tags');
			for ($j=0; $j < count($tags) ; $j++) { 
				$tmp_tag = $tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'it_value' => $tmp_tag,
						'it_owner' => $oid );

					$this->db->insert('i_tags', $data3);
					$tid = $this->db->insert_id();
				} else {
					$tid = $result[0]->it_id;
				}

				$data5 = array(
					'iet_type_id' => $orid,
					'iet_type' => 'orders',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			$this->db->WHERE(array('iextetorp_inid' => $orid));
			$this->db->delete('i_ext_et_orders_property');
			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iextetorp_inid' => $orid,
						'iextetorp_property_value' => $property[$i]['value'],
						'iextetorp_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_orders_property',$data);
				}
			}

			$this->db->WHERE(array('iextetorm_order_id' => $orid));
			$this->db->delete('i_ext_et_orders_mutual');
			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
						$data = array(
							'iextetorm_order_id' => $orid,
							'iextetorm_uid' => $m_uid,
							'iextetorm_oid' => $oid
						);
						$this->db->insert('i_ext_et_orders_mutual',$data);
					}
				}
			}
			
			$data1 = array(
				'in_type_id' => $orid, 
				'in_type' => 'orders',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Orders - '.$txn_no,
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
				'iuap_p_id' => $c_uid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);


			$this->db->WHERE(array('iextetodp_order_id' => $orid , 'iextetodp_owner' => $oid));
			$this->db->delete('i_ext_et_orders_product_details');
			$new_order_flg = 0;
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
						'ip_created_by' => $oid,
						'ip_gid' => $gid,
						'ip_cat_id' => 0
					 );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				} else {
					$prid = $result[0]->ip_id;
				}

				$p_total = $product[$i]['rate'] * $product[$i]['ap_qty'];
				$p_remain = $product[$i]['qty'] - $product[$i]['ap_qty'];
				if ($p_remain > 0 ) {
					$new_order_flg = 1;
				}


				$data = array(
					'iextetodp_order_id' => $orid,
					'iextetodp_pid' => $prid,
					'iextetodp_rate' => $product[$i]['rate'],
					'iextetodp_qty' => $product[$i]['qty'],
					'iextetodp_approved_qty' => $product[$i]['ap_qty'],
					'iextetodp_amount' => $p_total,
					'iextetodp_owner' => $oid,
					'iextetodp_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_orders_product_details',$data);
			}

			if ($new_order_flg == 1) {
				$invoice_txn_id = '';
				$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$module_id' ORDER BY iumdi_id;");
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
				$txn_no = $invoice_txn_id;
				$data = array(
					'iextetor_customer_id' => $cid,
					'iextetor_txn_id' => $txn_no,
					'iextetor_date' => $txn_date,
					'iextetor_type' => $type,
					'iextetor_amount' => 0,
					'iextetor_status' => 'pending',
					'iextetor_note' => $note,
					'iextetor_owner' => $oid,
					'iextetor_created' => $dt,
					'iextetor_created_by' => $uid,
					'iextetor_gid' => $gid
				);
				$this->db->insert('i_ext_et_orders',$data);
				$n_orid = $this->db->insert_id();

				if (count($terms) > 0) {
					for ($i=0; $i <count($terms) ; $i++) { 
						if ($terms[$i]['status'] == 'true') {
							$status = 'true';
						}else{
							$status = 'false';
						}
						$data = array(
							'iextetort_inid' => $n_orid,
							'iextetort_term_id' => $terms[$i]['id'],
							'iextetort_status' => $status
						);	
						$this->db->insert('i_ext_et_orders_terms',$data);	
					}
				}

				for ($j=0; $j < count($tags) ; $j++) { 
					$tmp_tag = $tags[$j];

					$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
					$result = $query->result();

					if(count($result) <= 0) {
						$data3 = array(
							'it_value' => $tmp_tag,
							'it_owner' => $oid );

						$this->db->insert('i_tags', $data3);
						$tid = $this->db->insert_id();
					} else {
						$tid = $result[0]->it_id;
					}

					$data5 = array(
						'iet_type_id' => $n_orid,
						'iet_type' => 'orders',
						'iet_tag_id' => $tid,
						'iet_owner' => $oid,
						'iet_m_id' => $module_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}

				if (count($property) > 0) {
					for ($i=0; $i <count($property) ; $i++) { 
						$data = array(
							'iextetorp_inid' => $n_orid,
							'iextetorp_property_value' => $property[$i]['value'],
							'iextetorp_status' => $property[$i]['status']
						);
						$this->db->insert('i_ext_et_orders_property',$data);
					}
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
								'iextetorm_order_id' => $n_orid,
								'iextetorm_uid' => $m_uid,
								'iextetorm_oid' => $oid
							);
							$this->db->insert('i_ext_et_orders_mutual',$data);
						}
					}
				}
				
				$data1 = array(
					'in_type_id' => $n_orid, 
					'in_type' => 'orders',
					'in_m_id' => $module_id,
					'in_person' => $cid,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $dt1
				);
				$this->db->insert('i_notifications',$data1);

				$data = array(
					'iua_type' => 'module',
					'iua_title' => 'Orders - '.$txn_no,
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
					'iuap_p_id' => $c_uid,
					'iuap_owner' => $oid
				);
				$this->db->insert('i_u_a_person',$data);

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
							'ip_created_by' => $oid,
							'ip_gid' => $gid,
							'ip_cat_id' => 0
						 );
						$this->db->insert('i_product', $data1);
						$prid = $this->db->insert_id();
					} else {
						$prid = $result[0]->ip_id;
					}

					$p_remain = $product[$i]['qty'] - $product[$i]['ap_qty'];

					if ($p_remain > 0) {
						$data = array(
							'iextetodp_order_id' => $n_orid,
							'iextetodp_pid' => $prid,
							'iextetodp_rate' => $product[$i]['rate'],
							'iextetodp_qty' => $p_remain,
							'iextetodp_approved_qty' => $p_remain,
							'iextetodp_amount' => $product[$i]['rate'] * $p_remain,
							'iextetodp_owner' => $oid,
							'iextetodp_alias' => $product[$i]['alias']
						);
						$this->db->INSERT('i_ext_et_orders_product_details',$data);	
					}
				}
			}
			echo $orid;
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function orders_delete($code,$orid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Orders') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE(array('iextetor_id' => $orid, 'iextetor_owner' => $oid));
			$this->db->delete('i_ext_et_orders');

			$this->db->WHERE(array('iextetort_inid' => $orid));
			$this->db->delete('i_ext_et_orders_terms');

			$this->db->WHERE(array('iet_type_id' => $orid , 'iet_type' => 'orders' , 'iet_owner' => $oid));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE(array('iextetorp_inid' => $orid));
			$this->db->delete('i_ext_et_orders_property');

			$this->db->WHERE(array('iextetorm_order_id' => $orid));
			$this->db->delete('i_ext_et_orders_mutual');

			$this->db->WHERE(array('iextetodp_order_id' => $orid , 'iextetodp_owner' => $oid));
			$this->db->delete('i_ext_et_orders_product_details');

			redirect(base_url().'Orders/home/'.$module_id.'/'.$code);
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function orders_doc_upload($code,$orid,$cname){
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
					if ($module[$i]->mname == 'Orders') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE(array('icd_owner' => $oid , 'icd_type_id' => $orid , 'icd_type' => 'document' , 'icd_mid' => $module_id));
			$this->db->delete('i_c_doc');

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
						'icd_type_id' => $orid,
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

	public function orders_print($code,$orid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mod_id = 0 ;
			if (count($module) > 0) {
				for ($i=0; $i < count($module) ; $i++) { 
					if ($module[$i]->mname == 'Orders') {
						$mod_id = $module[$i]->mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$Q=$this->db->query("SELECT * from i_u_details where iud_id = '$oid'");
			$result=$Q->result();
			$data['k']=$result;

			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_orders AS a LEFT JOIN i_customers As b ON a.iextetor_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextetor_id='$orid' AND a.iextetor_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				// $query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner = '$oid'");
				// $result = $query->result();
				// $data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextetor_txn_id;
				$data['s_txn_date'] = $result[0]->iextetor_date;
				$data['s_txn_note'] = $result[0]->iextetor_note;
				// $data['s_txn_disp_hsn'] = $result[0]->iextetor_hsn;
				// $data['s_txn_disp_desc'] = $result[0]->iextetor_desc;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextetor_txn_id;
				$data['s_txn_date'] = $result[0]->iextetor_date;
				$data['s_txn_note'] = $result[0]->iextetor_note;
				// $data['s_txn_disp_hsn'] = $result[0]->iextetor_hsn;
				// $data['s_txn_disp_desc'] = $result[0]->iextetor_desc;
			}

			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();
			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders WHERE iextetor_id='$orid'");
			$result = $query->result();
			$data['note']=$result[0]->iextetor_note;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_product_details AS a LEFT JOIN i_product AS d ON a.iextetodp_pid = d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id WHERE a.iextetodp_order_id = '$orid' AND a.iextetodp_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_invoice_terms as b on a.iextdt_id=b.iexteintm_term_id WHERE iextdt_document='Invoice' AND iextdt_owner='$oid' AND iexteintm_inid= '$orid' AND iexteintm_status = 'true' ");
			$result = $query->result();
			$data['terms'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_orders_property WHERE iextetorp_inid ='$orid' AND iextetorp_status = 'true' ");
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

			$template_name = "template/order_simple";
			$this->load->view("$template_name", $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function orders_download($flg,$invoiceid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
	 		$page = file_get_contents(base_url().'Orders/orders_print/'.$code.'/'.$invoiceid, false, $context);
		    session_start();
		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/orders/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $invoiceid.'.html';
		    $invoicefile = $invoiceid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

		    if($flg == 'd'){
		    	$this->load->helper('download');
    			force_download($path.$invoicefile, NULL);
		    }else if($flg == 'p'){
		    	redirect(base_url().'assets/data/'.$oid.'/orders/'.$invoicefile);
		    }
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function send_orders_email($mod_id, $orid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$email_id = $this->input->post('cust_mail_id');
			$eid = 0;
			for ($i=0; $i <count($email_id) ; $i++) { 
				if ($email_id[0]['status'] == 'true') {
					$eid = $email_id[0]['email'];
				}
			}
			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$eid')");
			$result1 = $query->result();

			$query = $this->db->query("SELECT * from i_ext_et_orders WHERE iextetor_id='$orid'");
			$result2 = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();
			if (count($result3)>0) {

				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close();
		 		$page = file_get_contents(base_url().'Orders/orders_print/'.$code.'/'.$orid, false, $context);
			    session_start();

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/orders/';

			    if(!file_exists($path)) {
						mkdir($path, 0777, true);
				}
			    $htmlfile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextetor_date)).'.html';
			    $invoicefile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextetor_date)).'.pdf';

			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

				$subject = $result[0]->iud_company.' - Orders - '.$result2[0]->iextetor_txn_id;

				$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
				<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached invoice and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
				$attach = $path.$invoicefile;
				for ($i=0; $i < count($email_id) ; $i++) {
					if ($email_id[$i]['status'] == 'true' ) {
						$status = $this->Mail->send_mail($subject,$email_id[$i]['email'],$attach,$body,$code);
					}
				}

				echo $status;
			}else {
				echo "enter";
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}


	public function orders_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextetor_id' => $pid, 'iextetor_owner' => $oid));
			$this->db->update('i_ext_et_orders',array('iextetor_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function orders_transfer_user($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$cust_name = $this->input->post('cust_name');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0) {
				$p_uid = $result[0]->ic_uid;
				$data = array(
					'iextetor_created_by' => $p_uid
				);
				$this->db->where(array('iextetor_id' => $inid, 'iextetor_owner' => $oid));
				$this->db->update('i_ext_et_orders',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}
}