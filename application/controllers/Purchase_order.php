<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase_order extends CI_Controller {
	public function __construct(){
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

	public function purchase_order($module_id,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
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
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND a.iextein_gid = '0' AND a.iextein_txn_type = 'purchase' ORDER BY a.iextein_id DESC");
				$result = $query->result();
				$data['invoice'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND a.iextein_gid = '$gid' AND a.iextein_txn_type = 'purchase' ORDER BY a.iextein_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_gid = '$gid' AND a.iextein_created_by = '$uid' UNION SELECT * FROM i_ext_et_invoice AS c LEFT JOIN i_customers AS d ON c.iextein_customer_id=d.ic_id WHERE c.iextein_gid = '$gid' AND a.iextein_txn_type = 'purchase' AND c.iextein_id IN(SELECT iexteim_pid FROM i_ext_et_invoice_mutual WHERE iexteim_uid = '$uid' AND iexteim_oid = '$oid')");
					$result = $query->result();
					$data['invoice'] = $result;
				}
			}

			$query = $this->db->query("SELECT iextein_status FROM i_ext_et_invoice WHERE iextein_status != '' AND iextein_txn_type = 'purchase' GROUP BY iextein_status");
			$result = $query->result();
			$data['status'] = $result;

			$data['mod_id'] = $module_id;$data['gid']=$gid;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = 'Purchase Order';
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$this->load->view('navbar', $ert);
			$this->load->view('purchase_order/purchase_order', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND a.iextein_txn_type = 'purchase' AND a.iextein_txn_id LIKE '%".$search."%' OR b.ic_name LIKE '%".$search."%' ORDER BY a.iextein_id DESC");
			$result = $query->result();
			$data['invoice'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_filter($code) {
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
			$this->db->from('i_ext_et_invoice');
			$this->db->join('i_customers', 'i_customers.ic_id = i_ext_et_invoice.iextein_customer_id','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('iextein_txn_date >=', $from_date);
				$this->db->where('iextein_txn_date <=', $to_date);
			}
			if ($in_created != '') {
				$this->db->where('iextein_created_by', $in_created);
			}
			if ($status != '') {
				$this->db->where('iextein_status', $status);
			}
			if ($min_amount != '') {
				$this->db->where('iextein_amount >=', $min_amount);
			}
			if ($max_amount != '') {
				$this->db->where('iextein_amount <=', $max_amount);
			}
			$this->db->where('i_ext_et_invoice.iextein_owner', $oid);
			$this->db->where('i_ext_et_invoice.iextein_txn_type', 'purchase');
			$this->db->group_by('i_ext_et_invoice.iextein_id');
			$query = $this->db->get();
			$data['filter'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function cust_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('c');
			$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid')");
			$result = $query->result();
			$data['details'] = $result;
			$cid = 0 ;
			if (count($result) > 0 ) {
				$cid = $result[0]->icbd_customer_id;	
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id = '$cid' AND iextamc_owner = '$oid' ORDER BY iextamc_id DESC ");
			$result = $query->result();
			$data['amc'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function invoice_download($flg,$mod_id,$invoiceid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
		    // redirect(base_url().'Purchase_order/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid);
	 		$page = file_get_contents(base_url().'Purchase_order/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/invoice/';

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
		    	redirect(base_url().'assets/data/'.$oid.'/invoice/'.$invoicefile);
		    }
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextein_id' => $pid, 'iextein_owner' => $oid , 'iextein_txn_type' => 'purchase'));
			$this->db->update('i_ext_et_invoice',array('iextein_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function invoice_transfer_user($code,$inid){
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
					'iextein_created_by' => $p_uid
				);
				$this->db->where(array('iextein_id' => $inid, 'iextein_owner' => $oid , 'iextein_txn_type' => 'purchase'));
				$this->db->update('i_ext_et_invoice',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function invoice_add($module_id,$code,$tid=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id = '';$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
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
						$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_owner = '$oid' AND iextein_txn_type = 'purchase' ");
						$result2 = $query->result();
						$val = count($result2)+1;
					}
					$invoice_txn_id .= $val;
				}
			}
			$data['invoice_doc_id'] = $invoice_txn_id;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
            $result = $query->result();
            $data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid'  AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['tax'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			if ($tid != null && $tid != 'null') {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a WHERE a.iextein_id ='$tid' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'purchase' ");
				$result = $query->result();
				$cid = $result[0]->iextein_customer_id;
				$in_amount = $result[0]->iextein_amount;
				$status = $result[0]->iextein_status;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice_terms as a left join i_ext_et_document_terms as b on a.iexteintm_term_id=b.iextdt_id WHERE iexteintm_inid = '$tid'");
				$data['p_terms'] = $query->result();

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
				$result = $query->result();
				$data['edit_cust'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice_property where iexteinpt_inid = '$tid'");
				$result = $query->result();
				$data['invoice_property'] = $result;

				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				$p_id = $result[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id = '$cid' ");
				$result = $query->result();
				$data['email_ids'] = $result;

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'invoice' AND iet_type_id = '$tid' AND iet_m_id = '$module_id' AND iet_owner = '$oid') ");
				$result = $query->result();
				$data['pro_tags'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice_mutual as a LEFT JOIN i_customers as b on a.iexteim_uid = b.ic_uid WHERE iexteim_pid = '$tid' AND iexteim_oid = '$oid'");
				$result = $query->result();
				$data['mutual'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextepay_mid = '$module_id' AND iextepay_mname = '$mname' AND iextepay_oid = '$oid' AND iextepay_gid = '$gid' AND iextepay_tx_no = '$tid' ");
				$result = $query->result();
				$pay['history'] = $result;
				$p_amount = 0;
				for ($i=0; $i <count($result); $i++) { 
					$p_amount = $p_amount + $result[$i]->iextepay_amount;
				}
				$in_amount = $in_amount - $p_amount;
				if ($in_amount == 0) {
					$this->db->WHERE(array('iextein_id'=>$tid,'iextein_owner'=>$oid , 'iextein_txn_type' => 'purchase'));
					$this->db->update('i_ext_et_invoice',array('iextein_status'=>'paid'));
				}else{
					if ($status == 'paid') {
						$this->db->WHERE(array('iextein_id'=>$tid,'iextein_owner'=>$oid , 'iextein_txn_type' => 'purchase'));
						$this->db->update('i_ext_et_invoice',array('iextein_status'=>'unpaid'));
					}
				}
				$pay['bal_amount'] = $in_amount;
				$data['tid'] = $tid;

				$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid IN($cid) AND icd_mid = '$module_id' AND icd_type_id = '$tid' AND icd_owner = '$oid'");
				$result = $query->result();
				$data['doc']=$result;

				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$module_id' ");
				$data['helper'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$module_id' ");
				$data['help_parameter'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a left JOIN i_ext_et_invoice_product_details as b on a.iextein_id=b.iexteinpd_d_id LEFT join i_product as c on b.iexteinpd_product_id=c.ip_id WHERE a.iextein_id ='$tid' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'purchase' ");
				$result = $query->result();	
				$data['edit_invoice'] = $result;
				$data['edit_type'] = $result[0]->iextein_type;
				$data['invoice_gid'] = $result[0]->iextein_gid;
				if ($alias == '') {
				$ert['title'] = "Purchase Order Edit";
				}else{
					$ert['title'] = $alias." Edit";
				}
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='purchase_order'");
				$result = $query->result();
				$data['term_doc'] = $result;
				$pay=0;
				if ($alias == '') {
					$ert['title'] = "Purchase Order Add";
				}else{
					$ert['title'] = $alias." Add";
				}
			}

			$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id LEFT JOIN i_tax_group as c on b.itxgc_tg_id=c.ittxg_id WHERE a.itx_owner = '$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$ert['mid'] = $module_id;$ert['mname'] = $mname;$ert['gid']=$gid;$ert['code']=$code;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('payment_modal',$pay);
			$this->load->view('purchase_order/purchase_order_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_save($type,$code){
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
			$mutual = $this->input->post('mutual');
			$wrnt = $this->input->post('wrt_mnt');
			$module_id = '';
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
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
				$data1 = array(
					'ic_name' => $cust_name,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => 'customer',
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
				$c_uid = 0;
			}

			$data = array(
				'iextein_customer_id' => $cid, 
				'iextein_txn_id' => $txn_no,
				'iextein_txn_date' => $txn_date,
				'iextein_type' => $type,
				'iextein_amount' => $amount,
				'iextein_status' => 'open',
				'iextein_note' => $note,
				'iextein_owner' => $oid,
				'iextein_created' => $dt,
				'iextein_created_by' => $uid,
				'iextein_status' => 'open',
				'iextein_gid' => $gid,
				'iextein_warranty' => $wrnt,
				'iextein_txn_type' => 'purchase'
			);
			$this->db->insert('i_ext_et_invoice',$data);
			$pid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iexteintm_inid' => $pid,
						'iexteintm_term_id' => $terms[$i]['id'],
						'iexteintm_status' => $status
					);	
					$this->db->insert('i_ext_et_invoice_terms',$data);	
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
					'iet_type_id' => $pid,
					'iet_type' => 'invoice',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteinpt_inid' => $pid,
						'iexteinpt_property_value' => $property[$i]['value'],
						'iexteinpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_invoice_property',$data);
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
							'iexteim_pid' => $pid,
							'iexteim_uid' => $m_uid,
							'iexteim_oid' => $oid
						);
						$this->db->insert('i_ext_et_invoice_mutual',$data);
					}
				}
			}
			
			$data1 = array(
				'in_type_id' => $pid, 
				'in_type' => 'invoice',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Purchase order - '.$txn_no,
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

			if ($type != 'note') {
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
					if ($product[$i]['disc'] == '') {
						$p_total = $product[$i]['rate'] * $product[$i]['qty'];	
					}else{
						$disc_amt = $product[$i]['rate'] * $product[$i]['qty'] * ($product[$i]['disc'] / 100);
						$p_total = $product[$i]['rate'] * $product[$i]['qty']; - $disc_amt;
					}

					$data = array(
						'iexteinpd_d_id' => $pid,
						'iexteinpd_product_id' => $prid,
						'iexteinpd_rate' => $product[$i]['rate'],
						'iexteinpd_qty' => $product[$i]['qty'],
						'iexteinpd_discount' => $product[$i]['disc'],
						'iexteinpd_serial_number' => $product[$i]['sn'],
						'iexteinpd_amount' => $p_total,
						'iexteinpd_tax' => $product[$i]['tax_id'],
						'iexteinpd_owner' => $oid,
						'iexteinpd_alias' => $product[$i]['alias']
					);
					$this->db->INSERT('i_ext_et_invoice_product_details',$data);
				}
			}
			// echo $pid;
			$data['pid'] = $pid;
			$data['cid'] = $cid;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_email_doc_upload($code,$cname){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$dt = date('Y-m-d H:i:s');
			$in_cid ='';
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

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
						'icd_status' => 'true',
						'icd_mid' => $module_id,
						'icd_type_id' => $cid
					);
					$this->db->insert('i_c_doc', $data);
					if ($in_cid == '') {
						$in_cid = $this->db->insert_id();	
					}else{
						$in_cid .= ','.$this->db->insert_id();
					}
				}	
				$img_path = '';
			}

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_id IN($in_cid) AND icd_owner = '$oid'");
			$result = $query->result();
			$data['files']=$result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_doc_upload($code,$pid,$cname){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$module_id = '';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			$cid = $cname;

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

	public function invoice_print($code,$mod_id, $invoice_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$u_owner = $sess_data['user_details'][0]->i_owner;
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

			$Q=$this->db->query("SELECT * from i_u_details where iud_id = '$oid'");
			$result=$Q->result();
			$data['k']=$result;

			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner='$oid' AND a.iextein_txn_type = 'purchase' ");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'purchase'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextein_txn_id;
				$data['s_txn_date'] = $result[0]->iextein_txn_date;
				$data['s_txn_note'] = $result[0]->iextein_note;
				$data['s_txn_disp_hsn'] = $result[0]->iextein_hsn;
				$data['s_txn_disp_desc'] = $result[0]->iextein_desc;
				$data['note']=$result[0]->iextein_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextein_txn_id;
				$data['s_txn_date'] = $result[0]->iextein_txn_date;
				$data['s_txn_note'] = $result[0]->iextein_note;
				$data['s_txn_disp_hsn'] = $result[0]->iextein_hsn;
				$data['s_txn_disp_desc'] = $result[0]->iextein_desc;
				$data['note']=$result[0]->iextein_note;
			}

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$u_owner'");
			$result = $query->result();
			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteinpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON a.iexteinpd_tax = c.ittxg_id LEFT JOIN i_product AS d ON a.iexteinpd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id WHERE a.iexteinpd_d_id='$invoice_id' AND a.iexteinpd_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

            $query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;
            
			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_invoice_terms as b on a.iextdt_id=b.iexteintm_term_id WHERE iextdt_document='Purchase_order' AND iextdt_owner='$oid' AND iexteintm_inid= '$invoice_id' AND iexteintm_status = 'true' ");
			$result = $query->result();
			$data['terms'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_property WHERE iexteinpt_inid ='$invoice_id' AND iexteinpt_status = 'true' ");
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

			foreach ($query1->result() as $user){
			    $template_name = "template/$user->itemp_file_name"; 
			}

			$this->load->view("$template_name", $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_update($type,$tid,$code){
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
			$mutual = $this->input->post('mutual');
			$wrnt = $this->input->post('wrt_mnt');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$module_id = '';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase_order') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE('iexteintm_inid',$tid);
			$this->db->delete('i_ext_et_invoice_terms');

			$this->db->WHERE('iexteinpt_inid',$tid);
			$this->db->delete('i_ext_et_invoice_property');

			$this->db->WHERE(array('iet_type_id'=>$tid,'iet_owner' => $oid, 'iet_type' => 'purchase_order', 'iet_m_id' => $module_id));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE(array('iexteim_pid'=>$tid, 'iexteim_oid' => $oid));
			$this->db->delete('i_ext_et_invoice_mutual');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$data = array(
				'iextein_customer_id' => $cid, 
				'iextein_txn_id' => $txn_no,
				'iextein_txn_date' => $txn_date,
				'iextein_type' => $type,
				'iextein_amount' => $amount,
				'iextein_note' => $note,
				'iextein_modified' => $dt,
				'iextein_modified_by' => $uid,
				'iextein_status' => $status,
				'iextein_warranty' => $wrnt
			);
			$this->db->WHERE(array('iextein_id'=> $tid , 'iextein_owner' => $oid));
			$this->db->update('i_ext_et_invoice',$data);

			$data5 = array(
				'iet_type_id' => $tid,
				'iet_type' => 'purchase_order',
				'iet_owner' => $oid,
				'iet_m_id' => $module_id
			);
			$this->db->WHERE($data5);
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
					$tgid = $this->db->insert_id();
				} else {
					$tgid = $result[0]->it_id;
				}

				$data5 = array(
					'iet_type_id' => $tid,
					'iet_type' => 'purchase_order',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iexteintm_inid' => $tid,
						'iexteintm_term_id' => $terms[$i]['id'],
						'iexteintm_status' => $status
					);	
					$this->db->insert('i_ext_et_invoice_terms',$data);	
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteinpt_inid' => $tid,
						'iexteinpt_property_value' => $property[$i]['value'],
						'iexteinpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_invoice_property',$data);
				}
			}
			
			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];
					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					if (count($result) > 0 ) {
						$m_uid = $result[0]->ic_uid;
						$data = array(
							'iexteim_pid' => $tid,
							'iexteim_uid' => $m_uid,
							'iexteim_oid' => $oid
						);
						$this->db->insert('i_ext_et_invoice_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $tid, 
				'in_type' => 'purchase_order',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Purchase order - '.$txn_no,
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

			$this->db->WHERE(array('iexteinpd_d_id'=> $tid, 'iexteinpd_owner' => $oid ));
			$this->db->delete('i_ext_et_invoice_product_details');

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
					'iexteinpd_d_id' => $tid,
					'iexteinpd_product_id' => $prid,
					'iexteinpd_rate' => $product[$i]['rate'],
					'iexteinpd_qty' => $product[$i]['qty'],
					'iexteinpd_discount' => $product[$i]['disc'],
					'iexteinpd_serial_number' => $product[$i]['sn'],
					'iexteinpd_amount' => $p_total,
					'iexteinpd_tax' => $product[$i]['tax_id'],
					'iexteinpd_owner' => $oid,
					'iexteinpd_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_invoice_product_details',$data);
			}

			$data['pid'] = $tid;
			$data['cid'] = $cid;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function invoice_product_rate($code){
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
				print_r(json_encode($data));
			}else{
				echo "false";
			}
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function cust_add_property($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('c_name');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$cust_name'");
			$result = $query->result();
			if (count($result)>0) {
				$cid = $result[0]->ic_id;	
			}else{
				$data1 = array(
					'ic_name' => $cust_name,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => 'customer',
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			echo $cid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_terms ($document,$code) {
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
	
	public function invoice_delete($mod_id,$prid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$this->db->where('iextein_id', $prid);
			$this->db->delete('i_ext_et_invoice');

			$this->db->where('iexteinpd_d_id',$prid);
			$this->db->delete('i_ext_et_invoice_product_details');

			
			$this->db->where('iexteinpt_inid', $prid);
			$this->db->delete('i_ext_et_invoice_property');

			$this->db->WHERE('iexteintm_inid',$prid);
			$this->db->delete('i_ext_et_invoice_terms');

			redirect(base_url().'Purchase_order/purchase_order/'.$mod_id.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_send_email($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$mid = '';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Purchase_order') {
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
				'iextein_customer_id' => $cid, 
				'iextein_txn_id' => $txn_no,
				'iextein_txn_date' => $dt,
				'iextein_type' => 'email',
				'iextein_amount' => $amount,
				'iextein_status' => 'open',
				'iextein_owner' => $oid,
				'iextein_created' => $dt,
				'iextein_created_by' => $oid,
				'iextein_status' => 'open',
				'iextein_txn_type' => 'Purchase_order'
			);
			$this->db->insert('i_ext_et_invoice',$data);
			$inid = $this->db->insert_id();

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Purchase order - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $oid,
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
						$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($files[$j]['file_name']).'"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
						$body .= '<br>';
					}
					$body .='<br>Regards</body></html>';
					$temp = $this->Mail->send_mail($subject,$mail_id,null,$body,$code);
					$mail_id = '';
				}
			}
			echo $inid;
		}else{
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

	public function save_invoice_mail($mod_id,$inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$mail_id = $this->input->post('cust_mail_id');
			$email = '';
			$query = $this->db->query("SELECT iextein_customer_id FROM i_ext_et_invoice WHERE iextein_id='$inid' AND iextein_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iextein_customer_id;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];

					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						 echo $this->send_invoice_email($email, $mod_id, $inid,$code);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);

						echo $this->send_invoice_email($email, $mod_id, $inid,$code);
					}
				}$email = '';
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function send_invoice_email($uid, $mod_id, $invoiceid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid')");
			$result1 = $query->result();

			$query = $this->db->query("SELECT * from i_ext_et_invoice WHERE iextein_id='$invoiceid'");
			$result2 = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();
			if (count($result3)>0) {

				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close();
		 		$page = file_get_contents(base_url().'Purchase_order/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
			    session_start();

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/purchase_order/';

			    if(!file_exists($path)) {
						mkdir($path, 0777, true);
				}
			    $htmlfile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextein_txn_date)).'.html';
			    $invoicefile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextein_txn_date)).'.pdf';

			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

				$subject = $result[0]->iud_company.' - Purchase_order - '.$result2[0]->iextein_txn_id;

				$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
				<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached invoice and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
				$attach = $path.$invoicefile;

				$this->Mail->send_mail($subject,$uid,$attach,$body,$code);
			}else {
				echo "enter";
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function upload_doc_download($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$file = $this->input->post('doc_name');

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$oid' AND icd_id = '$id' ");
			$res = $query->result();
			if (count($res) > 0 ) {
				$file = $res[0]->icd_timestamp;
				$path = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			    if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
		    	$this->load->helper('download');
				force_download($path.$file, NULL);	
			}
		}else{
			redirect(base_url().'Account/login');
		}    
	}
}