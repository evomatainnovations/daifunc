<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH. 'vendor/autoload.php');
class Inventory extends CI_Controller {
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

	public function inventory_new($mod_id=null,$code) {
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
					if ($module[$i]->mname == 'Inventory_new') {
						$mod_id = $module[$i]->mid;
						$dom = $module[$i]->domain;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' AND a.iextei_gid = '0' ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['inventory'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$mod_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' AND a.iextei_gid = '$gid' ORDER BY a.iextei_id DESC");
					$result = $query->result();
					$data['inventory'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_gid = '$gid' AND a.iextei_created_by = '$uid' UNION SELECT * FROM i_ext_et_inventory AS c LEFT JOIN i_customers AS d ON c.iextei_customer_id=d.ic_id WHERE c.iextei_gid = '$gid' AND c.iextei_id IN(SELECT iexteinm_pid FROM i_ext_et_inventory_mutual WHERE iexteinm_uid = '$uid' AND iexteinm_oid = '$oid')");
					$result = $query->result();
					$data['inventory'] = $result;
				}
			}

			$query = $this->db->query("SELECT iextei_type FROM i_ext_et_inventory WHERE iextei_owner = '$oid' GROUP BY iextei_type");
			$result = $query->result();
			$data['type'] = $result;

			$query = $this->db->query("SELECT iextei_status FROM i_ext_et_inventory WHERE iextei_owner = '$oid' GROUP BY iextei_status");
			$result = $query->result();
			$data['status'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mod_id;$ert['mname']='Inventory';$ert['dom']=$dom;
			$data['mod_id'] = $mod_id;
			if ($alias == '') {
				$ert['title'] = "Inventory";	
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('inventory/inventory', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}

	public function inventory_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' AND b.ic_name LIKE '%".$search."%' OR a.iextei_txn_id LIKE '%".$search."%' ORDER BY a.iextei_id DESC");
			$result = $query->result();

			$data['inventory'] = $result;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function inventory_filter($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$from_date = $this->input->post('from');
			$to_date = $this->input->post('to');
			$min_amount = $this->input->post('min_amount');
			$max_amount = $this->input->post('max_amount');
			$type = $this->input->post('in_type');
			$status = $this->input->post('in_status');
			$inv_created = $this->input->post('inv_created');

			if ($inv_created != null) {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$inv_created' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$inv_created = $result[0]->ic_uid;	
				}
			}

			$this->db->select('*');
			$this->db->from('i_ext_et_inventory');
			$this->db->join('i_customers', 'i_customers.ic_uid = i_ext_et_inventory.iextei_created_by','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('iextei_txn_date >=', $from_date);
				$this->db->where('iextei_txn_date <=', $to_date);
			}
			if ($inv_created != '') {
				$this->db->where('iextei_created_by', $inv_created);
			}
			if ($status != '') {
				$this->db->where('iextei_status', $status);
			}
			if ($type != '') {
				$this->db->where('iextei_type', $type);
			}
			$this->db->where('i_ext_et_inventory.iextei_owner', $oid);
			$this->db->group_by('i_ext_et_inventory.iextei_id');
			$query = $this->db->get();
			$data['filter'] = $query->result();
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}
######################## Inward And Outward #####################

	public function inventory_doc_upload($code,$mid,$pid,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

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
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file

					$data = array(
						'icd_file' => $file_name,
						'icd_owner' => $oid,
						'icd_cid' => $cid,
						'icd_date' => $dt,
						'icd_type' => 'document',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $mid,
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

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function inventory_add($type,$code,$mod_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Inventory_new') {
						$mod_id = $module[$i]->mid;
						$dom = $module[$i]->domain;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data['mod_id'] = $mod_id;
			$invoice_txn_id = '';
			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$mod_id' ORDER BY iumdi_id;");
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
						$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='outward'");
						$result2 = $query->result();
						$val = count($result2)+1;
					}
					$invoice_txn_id .= $val;
				}
			}
			$data['invoice_doc_id'] = $invoice_txn_id;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['term_doc'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$data['type'] = $type;$ert['search'] = "false";
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['mname'] = 'Inventory';$ert['mid']=$mod_id;$ert['code']=$code;$ert['gid']=$gid;

			if ($type == "inward") {
				$ert['title'] = "Add Inward";
			} else if($type == "outward" ) {
				$ert['title'] = "Add Outward";
			}

			$this->load->view('navbar', $ert);
			$this->load->view('inventory/inventory_add', $data);
			$this->load->view('home/search_modal');

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function add_product_inventory($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$u_ref = $sess_data['user_details'][0]->i_ref;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$pname = $this->input->post('pname');
			$pro_list = [];

			$que = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = '1' ");
			$res = $que->result();
			$aid = 0;
			if (count($res) > 0 ) {
				$aid = $res[0]->iia_id;
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pname' AND ip_owner = '$oid' ");
			$res = $query->result();
			if (count($res) > 0 ) {
				$pid = $res[0]->ip_id;
			    $y=[];
			    for($j=0;$j<count($res);$j++) {
			        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_to_type='account' AND iin_to='$aid' AND iin_from_type != 'location' AND iin_to_type != 'location' ) - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_from_type='account' AND iin_from='$aid' AND iin_from_type != 'location' AND iin_to_type != 'location' )) AS bal FROM i_inventory_new WHERE iin_gid = '$gid' AND iin_p_id='$pid' GROUP BY iin_p_id");
			        $res2 = $que2->result();
			        if(count($res2) > 0) {
			            $bal = $res2[0]->bal;
			        } else {
			            $bal = 0;
			        }
			    }
				array_push($pro_list, array('pid' => $pid, 'bal' => $bal));
			}else{
				$data1 = array(
					'ip_product' => $pname,
					'ip_section' => 'Products',
					'ip_owner' => $oid,
					'ip_created' => $dt,
					'ip_created_by' => $uid,
					'ip_gid' => $gid,
					'ip_cat_id' => 0
				);
				$this->db->insert('i_product', $data1);
				$pid = $this->db->insert_id();
				array_push($pro_list, array('pid' => $pid, 'bal' => 0));
			}
			
			$data['product_list'] = $pro_list;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function save_inventory($code,$type) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$u_ref = $sess_data['user_details'][0]->i_ref;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('product');
			$dt = date('Y-m-d H:i:s');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$status = $this->input->post('status');
			$module_id = '';
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$note = $this->input->post('note');
			$wrnt = $this->input->post('wrnt');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Inventory_new') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$dt1 = date('Y-m-d');
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cust_name' AND ic_owner='$oid'");
			$result = $query->result();
			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $cust_name,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => 'customer',
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$data = array(
				'iextei_customer_id' => $cid,
				'iextei_txn_id' => $txn_no,
				'iextei_txn_date' => $txn_date,
				'iextei_type' => $type,
				'iextei_owner' => $oid,
				'iextei_created' => $dt,
				'iextei_created_by' => $oid,
				'iextei_status' => $status,
				'iextei_note' => $note,
				'iextei_gid' => $gid,
				'iextei_fid' => $uid,
				'iextei_warranty' => $wrnt
			);
			$this->db->insert('i_ext_et_inventory', $data);
			$inid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iexteinvetm_inid' => $inid,
						'iexteinvetm_term_id' => $terms[$i]['id'],
						'iexteinvetm_status' => $status
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);	
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $inid,
						'iexteinvept_property_value' => $property[$i]['value'],
						'iexteinvept_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
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
					$tgid = $this->db->insert_id();
				} else {
					$tgid = $result[0]->it_id;
				}

				$data5 = array(
					'iet_type_id' => $inid,
					'iet_type' => 'inventory',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
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
							'iexteinm_pid' => $inid,
							'iexteinm_uid' => $m_uid,
							'iexteinm_oid' => $oid
						);
						$this->db->insert('i_ext_et_inventory_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $inid,
				'in_type' => $type,
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Inventory - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'close',
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

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i]['product'];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;
				} else {
					$data1 = array(
						'ip_product' => $pd,
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
				$inward = $products[$i]['qty'];
				$outward = 0;
				if ($type == 'inward') {
					$from_id = $cid;
					$from_type = 'contact';
					$to_id = $star_acc;
					$to_type = 'account';
				}else{
					$from_id = $star_acc;
					$from_type = 'account';
					$to_id = $cid;
					$to_type = 'contact';
				}

				$data = array(
					'iin_from' => $from_id,
					'iin_from_type' => $from_type,
					'iin_to' => $to_id,
					'iin_to_type' => $to_type,
					'iin_date' => $txn_date,
					'iin_order_txn' => $inid,
					'iin_p_id' => $prid,
					'iin_inward' => $inward,
					'iin_outward' => $outward,
					'iin_owner' => $oid,
					'iin_created' => $dt,
					'iin_created_by' => $uid,
					'iin_serial_number' => $products[$i]['sn'],
					'iin_alias' => $products[$i]['alias'],
					'iin_gid' => $gid,
					'iin_txn_type' => $type
				);
				$this->db->insert('i_inventory_new', $data);
			}

			$data['inid'] = $inid;
			$data['cid'] = $cid;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextei_id' => $pid, 'iextei_owner' => $oid));
			$this->db->update('i_ext_et_inventory',array('iextei_gid' => $gid));

			$this->db->WHERE(array('iin_order_txn' => $pid, 'iin_owner' => $oid));
			$this->db->update('i_inventory_new',array('iin_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function inventory_transfer_user($code,$inid){
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
					'iextei_created_by' => $p_uid
				);
				$this->db->where(array('iextei_id' => $inid, 'iextei_owner' => $oid));
				$this->db->update('i_ext_et_inventory',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_inventory_mail($mod_id, $inid,$code,$type){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$mail_id = $this->input->post('cust_mail_id');
			$email = '';

			$query = $this->db->query("SELECT iextei_customer_id FROM i_ext_et_inventory WHERE iextei_id='$inid' AND iextei_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iextei_customer_id;
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];
					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						 echo $this->send_inventory_email($code,$email, $mod_id, $inid,$type);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);
						echo $this->send_inventory_email($code,$email, $mod_id, $inid,$type);
					}
				}$email = '';
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_download($flg,$code,$mod_id,$invoiceid,$type){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
		    // redirect(base_url().'Enterprise/inventory_outward_print/'.$code.'/'.$mod_id.'/'.$invoiceid.'/Inventory');
	 		$page = file_get_contents(base_url().'Inventory/inventory_outward_print/'.$code.'/'.$mod_id.'/'.$invoiceid.'/Inventory', false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/inventory_new/';

		    if(!file_exists($path)) {
					mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $invoiceid.'.html';
		    $invoicefile = $invoiceid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf -O landscape '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
		    if ($flg == 'd') {
		    	$this->load->helper('download');
    			force_download($path.$invoicefile, NULL);
		    }else{
		    	redirect(base_url().'assets/data/'.$oid.'/inventory_new/'.$invoicefile);
		    }
		}else{
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

	public function send_inventory_email($code,$uid, $mod_id, $invoiceid,$type) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid')");
			$result1 = $query->result();

			$query = $this->db->query("SELECT * from i_ext_et_inventory WHERE iextei_id='$invoiceid'");
			$result2 = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();
			if (count($result3)>0) {
				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close(); // unlock the file
		 		$page = file_get_contents(base_url().'Inventory/inventory_outward_print/'.$code.'/'.$mod_id.'/'.$invoiceid.'/Inventory', false, $context);
			    session_start(); // unlock the file

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/inventory/';

			    if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}
			   	$htmlfile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextei_txn_date)).'.html';
			    $invoicefile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextei_txn_date)).'.pdf';
			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

				$subject = $result[0]->iud_company.' - INVENTORY - '.$result2[0]->iextei_txn_id;

				$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
				<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached inventory and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
				$attach = $path.$invoicefile;
				$this->Mail->send_mail($subject,$uid,$attach,$body,$code);

				echo "true";
			}else {
				echo "enter";
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_edit($type,$code,$mod_id,$tid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Inventory_new') {
						$mod_id = $module[$i]->mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a left JOIN i_inventory_new as b on a.iextei_id=b.iin_order_txn LEFT join i_product as c on b.iin_p_id=c.ip_id WHERE a.iextei_id ='$tid' AND a.iextei_owner = '$oid'");
			$result = $query->result();	
			$data['edit_invoice'] = $result;
			$cid = $result[0]->iextei_customer_id;
			$data['edit_type'] = $result[0]->iextei_type;
			$data['invoice_gid'] = $result[0]->iextei_gid;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['term_doc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_terms as a left join i_ext_et_document_terms as b on a.iexteinvetm_term_id=b.iextdt_id WHERE iexteinvetm_inid = '$tid' AND iextdt_document = 'Inventory'");
			$data['p_terms'] = $query->result();

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
			$result = $query->result();
			$data['edit_cust'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_property where iexteinvept_inid = '$tid'");
			$result = $query->result();
			$data['invoice_property'] = $result;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id = '$cid' ");
			$result = $query->result();
			$data['email_ids'] = $result;

			$data['tid'] = $tid;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'inventory' AND iet_type_id = '$tid' AND iet_m_id = '$mod_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			$data['pro_tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_mutual as a LEFT JOIN i_customers as b on a.iexteinm_uid = b.ic_uid WHERE iexteinm_pid = '$tid' AND iexteinm_oid = '$oid'");
			$result = $query->result();
			$data['mutual'] = $result;

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_mid = '$mod_id' AND icd_type_id = '$tid' AND icd_owner = '$oid' ");
			$data['doc'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$mod_id' ");
			$data['helper'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$mod_id' ");
			$data['help_parameter'] = $query->result();

			$data['type'] = $type;$data['mod_id'] = $mod_id;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['mid']=$mod_id;$ert['code']=$code;$ert['mname']='Inventory';

			if ($type == "inward" || $type == "def_in" ) {
				$ert['title'] = "Edit Inward";
			} else if($type == "outward" || $type == "def_out" ) {
				$ert['title'] = "Edit Outward";
			}

			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('inventory/inventory_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_group_list($code,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT iextptg_name as gname , iextptg_id as pgid FROM i_ext_pro_task_group WHERE iextptg_p_id = '$pid' AND iextptg_owner = '$oid' ");
			$data['grp_list'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function save_to_project($code,$tid,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Inventory_new') {
					$mid = $module[$i]->mid;
				}
				if ($module[$i]->mname == 'Projects') {
					$to_mid = $module[$i]->mid;
				}
			}
			$data = array(
				'iextemt_from_mid' => $mid,
				'iextemt_from_txn' => $tid,
				'iextemt_to_mid' => $to_mid,
				'iextemt_to_txn' => $pid,
				'iextemt_created' => date('Y-m-d H:i:s'),
				'iextemt_created_by' => $uid,
				'iextemt_owner' => $oid
			);
			$this->db->insert('i_ext_et_mapping_txn',$data);
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function update_inventory($inid,$code,$type) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('product');
			$dt = date('Y-m-d H:i:s');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$status = $this->input->post('status');
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$note = $this->input->post('note');
			$wrnt = $this->input->post('wrnt');

			$module_id = '';

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'inventory') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			$dt1 = date('Y-m-d');

			$this->db->WHERE(array('iet_type_id'=>$inid,'iet_owner' => $oid, 'iet_type' => 'inventory', 'iet_m_id' => $module_id));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE(array('iexteinm_pid'=>$inid, 'iexteinm_oid' => $oid));
			$this->db->delete('i_ext_et_inventory_mutual');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cust_name' AND ic_owner='$oid'");
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => 'customer',
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
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
					$tgid = $this->db->insert_id();
				} else {
					$tgid = $result[0]->it_id;
				}

				$data5 = array(
					'iet_type_id' => $inid,
					'iet_type' => 'inventory',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
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
							'iexteinm_pid' => $inid,
							'iexteinm_uid' => $m_uid,
							'iexteinm_oid' => $oid
						);
						$this->db->insert('i_ext_et_inventory_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $inid, 
				'in_type' => $type,
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Inventory - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'close',
				'iua_categorise' => 'update',
				'iua_p_activity' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid,
			);
			$this->db->insert('i_user_activity', $data);
			$aid = $this->db->insert_id();
			$data = array(
				'iuap_a_id' => $aid,
				'iuap_p_id' => $cid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);

			$data = array(
				'iextei_customer_id' => $cid,
				'iextei_txn_id' => $txn_no,
				'iextei_txn_date' => $txn_date,
				'iextei_modified' => $dt,
				'iextei_modified_by' => $oid,
				'iextei_status' => $status,
				'iextei_note' => $note,
				'iextei_warranty' => $wrnt
			);
			$this->db->where('iextei_id', $inid);
			$this->db->update('i_ext_et_inventory', $data);

			$this->db->where('iin_order_txn', $inid);
			$this->db->delete('i_inventory_new');

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_star = 1 ");
			$result = $query->result();
			$star_acc = 0;
			if (count($result) > 0) {
				$star_acc = $result[0]->iia_id;
			}

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i]['product'];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;
				} else {
					$data1 = array(
						'ip_product' => $pd,
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

				$inward = $products[$i]['qty'];
				$outward = 0;
				$balance = $products[$i]['qty'];
				if ($type == 'inward') {
					$from_id = $cid;
					$from_type = 'contact';
					$to_id = $star_acc;
					$to_type = 'account';
				}else{
					$from_id = $star_acc;
					$from_type = 'account';
					$to_id = $cid;
					$to_type = 'contact';
				}
				$data = array(
					'iin_from' => $from_id,
					'iin_from_type' => $from_type,
					'iin_to' => $to_id,
					'iin_to_type' => $to_type,
					'iin_order_txn' => $inid,
					'iin_p_id' => $prid,
					'iin_inward' => $inward,
					'iin_outward' => $outward,
					'iin_owner' => $oid,
					'iin_modified' => $dt,
					'iin_modified_by' => $uid,
					'iin_serial_number' => $products[$i]['sn'],
					'iin_alias' => $products[$i]['alias'],
					'iin_gid' => $gid,
					'iin_txn_type' => $type
				);
				$this->db->insert('i_inventory_new', $data);
			}

			$this->db->WHERE(array('iexteinvept_inid' => $inid));
			$this->db->delete('i_ext_et_inventory_property');

			$this->db->where(array('iextett_txn_id' => $inid));
			$this->db->delete('i_ext_et_inventory_tags');

			$this->db->where(array('iet_type_id' => $inid,'iet_type' => $type,'iet_owner' => $oid,'iet_m_id' => $module_id));
			$this->db->delete('i_ext_tags');

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $inid,
						'iexteinvept_property_value' => $property[$i]['value'],
						'iexteinvept_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_inventory_property',$data);	
				}
			}

			if (count($tags) > 0) {
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

					$data4 = array(
						'iextett_txn_id' => $inid,
						'iextett_tag_id' => $tid);

					$this->db->insert('i_ext_et_inventory_tags', $data4);

					$data5 = array(
						'iet_type_id' => $inid,
						'iet_type' => $type,
						'iet_tag_id' => $tid,
						'iet_owner' => $oid,
						'iet_m_id' => $module_id
					);
					$this->db->insert('i_ext_tags', $data5);
				}	
			}

			$this->db->WHERE(array('iexteinvetm_inid' => $inid));
			$this->db->delete('i_ext_et_inventory_terms');

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $inid,
						'iexteinvetm_term_id' => $terms[$i]['id'],
						'iexteinvetm_status' => $terms[$i]['status'],
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);
				}
			}
			$data['inid'] = $inid;
			$data['cid'] = $cid;
			// echo $inid;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_inventory($code,$prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'inventory') {
						$mod_id = $module[$i]->mid;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$this->db->where('iextei_id', $prid);
			$this->db->delete('i_ext_et_inventory');

			$this->db->where('iin_order_txn',$prid);
			$this->db->delete('i_inventory_new');

			$this->db->where('iexteinvept_inid', $prid);
			$this->db->delete('i_ext_et_inventory_property');

			$this->db->WHERE('iexteinvetm_inid',$prid);
			$this->db->delete('i_ext_et_inventory_terms');

			redirect(base_url().'Inventory/inventory_new/'.$mod_id.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_outward_print($code,$mod_id,$out_id,$type) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
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

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers As b ON a.iextei_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextei_id='$out_id'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers As b ON a.iextei_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextei_id='$out_id'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_address'] = '';
				$data['type'] = $result[0]->iextei_type;
				$data['s_txn_id'] = $result[0]->iextei_txn_id;
				$data['s_txn_date'] = $result[0]->iextei_txn_date;
				$data['s_txn_note'] = $result[0]->iextei_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['type'] = $result[0]->iextei_type;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextei_txn_id;
				$data['s_txn_date'] = $result[0]->iextei_txn_date;
				$data['s_txn_note'] = $result[0]->iextei_note;
			}

			$query = $this->db->query("SELECT * FROM i_inventory_new AS a LEFT JOIN i_product AS b ON a.iin_p_id=b.ip_id LEFT JOIN i_p_price AS c ON b.ip_id=c.ipp_p_id WHERE a.iin_order_txn='$out_id' AND a.iin_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='$type' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;
			$data['s_title'] = "Inventory Outward";

			$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_property WHERE iexteinvept_inid ='$out_id' AND iexteinvept_status = 'true' ");
			$result = $query->result();
			$data['property'] = $result;

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

	public function check_template($code,$mod_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * from i_user_template WHERE iut_mid = '$mod_id' and iut_owner = '$oid';");
			$result = $query->result();
			if (count($result) > 0) {
				echo "true";	
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
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

	public function inventory_ship_label($code,$mod_id,$inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_customers as b on a.iextei_customer_id = b.ic_id LEFT JOIN i_c_basic_details as c on b.ic_id = c.icbd_customer_id LEFT JOIN i_property as d on d.ip_id = c.icbd_property WHERE iextei_id = '$inid' AND iextei_owner = '$oid' AND iextei_gid = '$gid' AND ip_property LIKE '%address%' AND ip_owner = '$oid' ");
			$result = $query->result();

			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);
			$code_text = $uid.$dt_str;
			$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
			$code = $Bar->getBarcode($code_text, $Bar::TYPE_INTERLEAVED_2_5_CHECKSUM, 2, 50);


			$page = '<table style="width:30%;">';
			$page .= '<tr><td colspan="2" style="width:30%;">'.$code.'</td></tr>';
			$page .= '<tr><td style="width:10%;">To :</td><td style="width:20%;"></td></tr>';
			if (count($result) > 0 ) {
				$page .= '<tr><td style="width:10%;"></td><td style="width:20%;">'.$result[0]->ic_name.'</td></tr>';
				for ($i=0; $i <count($result) ; $i++) { 
					if ($result[$i]->icbd_value != '') {
						$page .= '<tr><td style="width:10%;"></td><td style="width:20%;">'.$result[$i]->icbd_value.'</td></tr>';	
					}
				}
			}
			$page .= '<tr><td style="width:10%;">From :</td><td style="width:20%;"></td></tr>';
			$page .= '<tr><td style="width:10%;"></td><td style="width:20%;">'.$sess_data['user_details'][0]->iud_company.'</td></tr>';
			$page .= '<tr><td style="width:10%;"></td><td style="width:20%;">'.$sess_data['user_details'][0]->iud_address.'</td></tr>';
			$page.='</table>';

			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/inventory_new/';
		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$dt = strtotime(date('Y-m-d H:i:s'));
		    $htmlfile = $inid.'.html';
		    $invoicefile = $inid.'.pdf';
		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
		    redirect(base_url().'assets/data/'.$oid.'/inventory_new/'.$invoicefile);
		} else {
			redirect(base_url().'Account/login');
		}
	}
######################## Status #################################

	public function inventory_status($code) {
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
					if ($module[$i]->mname == 'Inventory_new') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid='$oid' AND iproc_pid='0'");
			$data['categories'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid'");
			$data['products'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_cat_id='0' AND a.ip_owner='$oid'");
			$result = $query->result();
			$x=[];
			for($i=0;$i<count($result);$i++) {
			    $que = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			    $res = $que->result();
			    
			    $pid = $result[$i]->ip_id;
			    $y=[];
			    for($j=0;$j<count($res);$j++) {
			        $aid=$res[$j]->iia_id;
			        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_to_type='account' AND iin_to='$aid' AND iin_from_type != 'location' AND iin_to_type != 'location' ) - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_from_type='account' AND iin_from='$aid' AND iin_from_type != 'location' AND iin_to_type != 'location' )) AS bal FROM i_inventory_new WHERE iin_gid = '$gid' AND iin_p_id='$pid' GROUP BY iin_p_id");
			        $res2 = $que2->result();
			        
			        if(count($res2) > 0) {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => $res2[0]->bal));
			        } else {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => 0));
			        }
			    }

			    array_push($x,array(
			        'id' => $result[$i]->ip_id,
			        'name' => $result[$i]->ip_product,
			        'category' => $result[$i]->ip_cat_id,
			        'limit' => $result[$i]->ip_limit,
			        'stock' => $y
			    ));
			}
			$data['product'] = $x;
			
			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			$data['accounts'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid'");
            $data["vendors"] = $query->result();

			$ert['search_placeholder'] = "Search Vendors";
			$data['oid'] = $oid;$data['code']=$code;
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
			$this->load->view('inventory/inventory_status', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}

	public function inventory_new_get_product_category_child($code,$ctid) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid='$oid' AND iproc_pid='$ctid'");
			$data['category'] = $query->result();

			$query = $this->db->query("SELECT iproc_pid FROM i_product_cat WHERE iproc_id='$ctid' AND iproc_oid='$oid'");
			if(count($query->result()) > 0) {
			    $data['parent'] = $query->result()[0]->iproc_pid;
			} else {
			    $data['parent'] = 0;
			}
			
			$query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_cat_id='$ctid' AND a.ip_owner='$oid' ");
			$result = $query->result();
			$x=[];
			for($i=0;$i<count($result);$i++) {
			    $que = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			    $res = $que->result();
			    
			    $pid = $result[$i]->ip_id;
			    $y=[];
			    for($j=0;$j<count($res);$j++) {
			        $aid=$res[$j]->iia_id;
			        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_to_type='account' AND iin_to='$aid') - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_from_type='account' AND iin_from='$aid')) AS bal FROM `i_inventory_new` WHERE iin_gid = '$gid' AND iin_p_id='$pid' GROUP BY iin_p_id");
			        $res2 = $que2->result();
			        
			        if(count($res2) > 0) {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => $res2[0]->bal));
			        } else {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => 0));
			        }
			    }
			    
			    array_push($x,array(
			        'id' => $result[$i]->ip_id,
			        'name' => $result[$i]->ip_product,
			        'category' => $result[$i]->ip_cat_id,
			        'limit' => $result[$i]->ip_limit,
			        'stock' => $y
			    ));
			}
			$data['product'] = $x;
			print_r(json_encode($data));
		}
    }

    public function inventory_new_search_product_category_child($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$data['category'] = [];

			$data['parent'] = 0;

			$pn = $this->input->post('pn');
			$query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_product LIKE '%$pn%' AND a.ip_owner='$oid'");
			$result = $query->result();
			
			$x=[];
			for($i=0;$i<count($result);$i++) {
			    $que = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			    $res = $que->result();
			    
			    $pid = $result[$i]->ip_id;
			    $y=[];
			    for($j=0;$j<count($res);$j++) {
			        $aid=$res[$j]->iia_id;
			        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_to_type='account' AND iin_to='$aid') - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_from_type = 'account' AND iin_from='$aid')) AS bal FROM `i_inventory_new` WHERE iin_gid = '$gid' AND iin_p_id='$pid' GROUP BY iin_p_id");
			        $res2 = $que2->result();
			        
			        if(count($res2) > 0) {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => $res2[0]->bal));    
			        } else {
			            array_push($y, array('account' => $res[$j]->iia_name, 'bal' => 0));
			        }
			    }
			    
			    array_push($x,array(
			        'id' => $result[$i]->ip_id,
			        'name' => $result[$i]->ip_product,
			        'category' => $result[$i]->ip_cat_id,
			        'limit' => $result[$i]->ip_limit,
			        'stock' => $y
			    ));
			}
			$data['product'] = $x;
			print_r(json_encode($data));
		}
    }

    public function save_inventory_new_account($code,$aid=null) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			
			if($aid==null) {
			    $this->db->insert('i_inventory_accounts', array('iia_name' => $this->input->post('n'), 'iia_owner' => $oid, 'iia_created' => $dt, 'iia_created_by' => $uid , 'iia_gid' => $gid , 'iia_barcode' => $this->input->post('b')));
			} else {
			    $this->db->where(array('iia_owner' => $oid, 'iia_id' => $aid));
			    $this->db->update('i_inventory_accounts', array('iia_name' => $this->input->post('n'), 'iia_modified' => $dt, 'iia_modified_by' => $uid, 'iia_barcode' => $this->input->post('b') ));
			}
			
			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid'");
			print_r(json_encode($query->result()));
		}
    }

    public function delete_inventory_new_account($code,$aid) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
		    $this->db->where(array('iia_owner' => $oid, 'iia_id' => $aid , 'iia_gid' => $gid));
			$this->db->delete('i_inventory_accounts');
			
			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			print_r(json_encode($query->result()));
		}
    }

    public function star_inventory_new_account($code,$aid) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
		    $this->db->where(array('iia_owner' => $oid , 'iia_gid' => $gid));
			$this->db->update('i_inventory_accounts', array('iia_star' => 0));
			
			$this->db->where(array('iia_owner' => $oid, 'iia_id' => $aid , 'iia_gid' => $gid));
			$this->db->update('i_inventory_accounts', array('iia_star' => 1));
			
			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			print_r(json_encode($query->result()));
		}
    } 

    public function inventory_new_get_list($code,$type) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$term = $this->input->post('term');
			if($type == "c") {
			    $query = $this->db->query("SELECT ic_id AS value, ic_name AS label FROM i_customers WHERE ic_owner='$oid' AND ic_name LIKE '%$term%'");    
			} else if($type == "i") {
			    $query = $this->db->query("SELECT iia_id AS value, iia_name AS label FROM i_inventory_accounts WHERE iia_gid = '$gid' AND iia_owner='$oid' AND iia_name LIKE '%$term%'");    
			}
			print_r(json_encode($query->result()));
		}
    }

    public function save_inventory_new_records($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			
			$f = $this->input->post('f');
			if($this->input->post('f_t') == "true") {
			    $f_t="contact";
			} else {
			    $f_t="account";
			}
			
			$t = $this->input->post('t');
			if($this->input->post('t_t') == "true") {
			    $t_t="contact";
			} else {
			    $t_t="account";
			}
			
			$d = $this->input->post('d');
			$l = $this->input->post('l');
			
			for($i=0;$i<count($l);$i++) {
			    $p=$l[$i]['p']; $q=$l[$i]['q'];
			    $que = $this->db->query("SELECT * FROM i_product WHERE ip_product='$p' AND ip_owner='$oid'");
			    $res = $que->result();
			    
			    if(count($res) > 0) {
			        $this->db->insert('i_inventory_new', array(
			            'iin_from' => $f,
			            'iin_from_type' => $f_t,
			            'iin_to' => $t,
			            'iin_to_type' => $t_t,
			            'iin_p_id' => $res[0]->ip_id,
			            'iin_inward' => $q,
			            'iin_outward' =>0,
			            'iin_date' => $d,
			            'iin_owner' => $oid,
			            'iin_created' => $dt,
			            'iin_created_by' => $uid,
			            'iin_gid' => $gid,
			            'iin_serial_number' => $l[$i]['sn'],
			            'iin_txn_type' => 'internal'
			        ));
			    }
			}
			echo 'true';
		} else {
		    echo 'logout';
		}
    }

    public function fetch_inventory_new_records($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$a = $this->input->post('a');
			$p = $this->input->post('p');
			$f = $this->input->post('f');
			$t = $this->input->post('t');
			if($this->input->post('a_t') == "true") {
			    $a_t = "contact";
			} else {
			    $a_t = "account";
			}
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid' AND ip_product='$p'");
			$result = $query->result();
			
			$pid=0;
			if(count($result) > 0) {
			    $pid=$result[0]->ip_id;
			}
			$query = $this->db->query("SELECT a.iin_id AS id, a.iin_from_type AS from_type, a.iin_from AS frm, a.iin_to AS t_o, a.iin_to_type AS to_type, b.ic_name AS from_name, c.ic_name AS to_name, d.iia_name AS from_acc, e.iia_name AS to_acc, f.ip_product AS product, a.iin_inward AS qty, a.iin_date AS dt FROM i_inventory_new AS a LEFT JOIN i_customers AS b ON a.iin_from=b.ic_id LEFT JOIN i_customers AS c ON a.iin_to=c.ic_id LEFT JOIN i_inventory_accounts AS d ON a.iin_from=d.iia_id LEFT JOIN i_inventory_accounts AS e ON a.iin_to=e.iia_id LEFT JOIN i_product AS f ON a.iin_p_id=f.ip_id WHERE (a.iin_from_type='$a_t' AND a.iin_from='$a' OR a.iin_to_type='$a_t' AND a.iin_to='$a') AND a.iin_gid = '$gid' AND ( d.iia_gid = '$gid' OR e.iia_gid = '$gid' ) AND a.iin_p_id='$pid' AND a.iin_date BETWEEN '$f' AND '$t' AND a.iin_owner='$oid' AND a.iin_from_type != 'location' AND iin_to_type != 'location' ");
			print_r(json_encode($query->result()));
		}
    }

    public function inventory_new_order_list_update($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			
			$p = $this->input->post('p');
			$q = $this->input->post('q');
			
			$this->db->insert('i_inventory_new_order', array('iino_p_id' => $p, 'iino_qty' => $q, 'iino_date' => date('Y-m-d'), 'iino_owner' => $oid, 'iino_created_by' => $uid, 'iino_created' => $uid , 'iino_gid' => $gid ));
			echo 'true';
		}
    }

    public function inventory_new_fetch_order_list($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$query = $this->db->query("SELECT * FROM i_inventory_new_order AS a LEFT join i_product AS b ON a.iino_p_id=b.ip_id WHERE a.iino_owner='$oid' AND iino_gid = '$gid' ");
			print_r(json_encode($query->result()));
		}
    }

    public function inventory_new_delete_order_item($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$i=$this->input->post('i');
			
			$this->db->where(array('iino_id' => $i, 'iino_owner' => $oid , 'iino_gid' => $gid ));
			$this->db->delete('i_inventory_new_order');
			
			$query = $this->db->query("SELECT * FROM i_inventory_new_order AS a LEFT join i_products AS b ON a.iino_p_id=b.ip_id WHERE a.iino_owner='$oid' AND iino_gid = '$gid' ");
			print_r(json_encode($query->result()));
		}
    }

    public function inventory_new_clear_order_list($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$i=$this->input->post('i');
			$this->db->where(array('iino_owner' => $oid , 'iino_gid' => $gid));
			$this->db->delete('i_inventory_new_order');
		}
    }

	################### Barcode Search #################################
 //    public function inventory_search_barcode($code){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];
	// 		$data['oid'] = $oid;
	// 		$module = $sess_data['user_mod'];
	// 		$mod_id=0;$dom='';
	// 		 if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 			for ($i=0; $i <count($module) ; $i++) { 
	// 				if ($module[$i]->mname == 'Inventory_new') {
	// 					$mod_id = $module[$i]->mid;
	// 					$dom = $module[$i]->domain;
	// 					$alias = $module[$i]->m_alias;
	// 					break;
	// 				}
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' ");
	// 		$data['customer'] = $query->result();

	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
	// 		$ert['user_connection']=$sess_data['user_connection'];
	// 		$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mod_id;$ert['mname']='Inventory';$ert['dom']=$dom;
	// 		$data['mod_id'] = $mod_id;
	// 		if ($alias == '') {
	// 			$ert['title'] = "Inventory Serach Barcode";	
	// 		}else{
	// 			$ert['title'] = $alias." Serach Barcode";
	// 		}
	// 		$ert['search'] = "true";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('inventory/inventory_search_barcode', $data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}	
	// }

	// public function get_barcode_details($code){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$barcode = $this->input->post('barcode');
	// 		$a_t = "account";

	// 		$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_barcode = '$barcode' ");
	// 		$result = $query->result();
	// 		if (count($result) > 0 ) {
	// 			////////////////// Account details ////////////////////
	// 			$data['acc_det'] = $result;
	// 			$aid = $result[0]->iia_id;
	// 			$a_name = $result[0]->iia_name;
	// 			$query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_owner='$oid'");
	// 			$result = $query->result();
	// 			$x=[];
	// 			for($i=0;$i<count($result);$i++) {
	// 			    $pid = $result[$i]->ip_id;
	// 		        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_to_type='account' AND iin_to='$aid') - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_p_id='$pid' AND iin_from_type='account' AND iin_from='$aid')) AS bal FROM `i_inventory_new` WHERE iin_gid = '$gid' AND iin_p_id='$pid' GROUP BY iin_p_id");
	// 		        $res2 = $que2->result();
	// 		        if(count($res2) > 0 ) {
	// 		        	if ($res2[0]->bal > 0) {
	// 		        		array_push($x , array('id' => $result[$i]->ip_id,'name' => $result[$i]->ip_product,'bal' => $res2[0]->bal ));
	// 		        	}
	// 		        }
	// 			}
	// 			$data['acc_pro'] = $x;
	// 		}else{
	// 			////////////////// Product details ////////////////////
	// 			$x = [];
	// 			// $query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_owner='$oid' AND a.ip_barcode = '$barcode' ");
	// 			// $result = $query->result();
	// 			// $data['pro_det'] = $result;
	// 			// if (count($result) > 0 ) {
	// 			// 	$pid = $result[0]->ip_id;
	// 			$que = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
	// 		    $res = $que->result();
	// 		    for($j=0;$j<count($res);$j++) {
	// 		        $aid=$res[$j]->iia_id;
	// 		        $que2 = $this->db->query("SELECT ((SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_serial_number='$barcode' AND iin_to_type='account' AND iin_to='$aid') - (SELECT IFNULL(SUM(iin_inward),0) FROM i_inventory_new WHERE iin_serial_number='$barcode' AND iin_from_type='account' AND iin_from='$aid')) AS bal , iin_p_id FROM `i_inventory_new` WHERE iin_gid = '$gid' AND iin_serial_number = '$barcode' GROUP BY iin_p_id");
	// 		        $res2 = $que2->result();
	// 		        if(count($res2) > 0) {
	// 		        	if ($res2[0]->bal > 0) {
	// 		            	array_push($x, array('aid' => $res[$j]->iia_id, 'account' => $res[$j]->iia_name, 'bal' => $res2[0]->bal));
	// 		            }
	// 		            $pid = $res2[0]->iin_p_id;
	// 		            $query = $this->db->query("SELECT * FROM i_product AS a WHERE a.ip_owner='$oid' AND a.ip_id = '$pid' ");
	// 					$result = $query->result();
	// 					$data['pro_det'] = $result;
	// 		        }
	// 		    }
	// 			// }
	// 			$data['pro_acc'] = $x;
	// 		}
	// 		print_r(json_encode($data));
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function proceed_to_outward($code) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$u_ref = $sess_data['user_details'][0]->i_ref;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$cust_name = $this->input->post('c_name');
	// 		$products = $this->input->post('p_arr');
	// 		$acc_name = $this->input->post('acc_name');
	// 		$txn_date = date('Y-m-d');
	// 		$dt = date('Y-m-d H:i:s');
	// 		$status = 'dispatch';

	// 		$module_id = '';
	// 		$module = $sess_data['user_mod'];
	// 		if (count($module) > 0) {
	// 			for ($i=0; $i <count($module) ; $i++) { 
	// 				if ($module[$i]->mname == 'Inventory_new') {
	// 					$module_id = $module[$i]->mid;
	// 					break;
	// 				}
	// 			}
	// 		}

	// 		$invoice_txn_id = '';
	// 		$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$module_id' ORDER BY iumdi_id;");
	// 		$result = $query->result();
	// 		for ($i=0; $i <count($result) ; $i++) {
	// 			if ($result[$i]->iumdi_variable == 'false') {
	// 				$invoice_txn_id .= $result[$i]->iumdi_doc_syntax;
	// 			}else{
	// 				if ($result[$i]->iumdi_doc_syntax == 'acc_yr') {
	// 					$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
	// 					$result1 = $query->result();
	// 					if (count($result1) > 0) {
	// 						$val = $result1[0]->iua_year_code;
	// 					}else{
	// 						$val = '';
	// 					}
	// 				}else{
	// 					$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='outward' AND iextei_gid = '$gid' ");
	// 					$result2 = $query->result();
	// 					$val = count($result2)+1;
	// 				}
	// 				$invoice_txn_id .= $val;
	// 			}
	// 		}
	// 		$txn_no = $invoice_txn_id;

	// 		$dt1 = date('Y-m-d');
			
	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cust_name' AND ic_owner='$oid'");
	// 		$result = $query->result();
	// 		if(count($result) > 0) {
	// 			$cid = $result[0]->ic_id;
	// 		} else {
	// 			$data1 = array(
	// 				'ic_name' => $customer,
	// 				'ic_owner' => $oid,
	// 				'ic_created' => $dt,
	// 				'ic_section' => $ctype,
	// 				'ic_created_by' => $oid );
	// 			$this->db->insert('i_customers', $data1);
	// 			$cid = $this->db->insert_id();
	// 		}

	// 		$data = array(
	// 			'iextei_customer_id' => $cid,
	// 			'iextei_txn_id' => $txn_no,
	// 			'iextei_txn_date' => $txn_date,
	// 			'iextei_type' => 'outward',
	// 			'iextei_owner' => $oid,
	// 			'iextei_created' => $dt,
	// 			'iextei_created_by' => $oid,
	// 			'iextei_status' => $status,
	// 			'iextei_gid' => $gid,
	// 			'iextei_fid' => $uid
	// 		);
	// 		$this->db->insert('i_ext_et_inventory', $data);
	// 		$inid = $this->db->insert_id();

	// 		$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
	// 		$result = $query->result();
	// 		for ($i=0; $i <count($result) ; $i++) { 
	// 			$status = 'false';
	// 			$data = array(
	// 				'iexteinvetm_inid' => $inid,
	// 				'iexteinvetm_term_id' => $result[$i]->iextdt_term,
	// 				'iexteinvetm_status' => $status
	// 			);	
	// 			$this->db->insert('i_ext_et_inventory_terms',$data);	
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_customer_id = '$cid' ");
	// 		$result = $query->result();
	// 		if (count($result) > 0) {
	// 			for ($i=0; $i <count($result) ; $i++) { 
	// 				$data = array(
	// 					'iexteinvept_inid' => $inid,
	// 					'iexteinvept_property_value' => $result[$i]->icbd_value,
	// 					'iexteinvept_status' => 'false'
	// 				);
	// 				$this->db->insert('i_ext_et_inventory_property',$data);	
	// 			}
	// 		}

	// 		$data1 = array(
	// 			'in_type_id' => $inid,
	// 			'in_type' => 'outward',
	// 			'in_m_id' => $module_id,
	// 			'in_person' => $cid,
	// 			'in_owner' => $oid,
	// 			'in_status' => 0,
	// 			'in_date' => $dt1
	// 		);
	// 		$this->db->insert('i_notifications',$data1);

	// 		$data = array(
	// 			'iua_type' => 'module',
	// 			'iua_title' => 'Inventory - '.$txn_no,
	// 			'iua_date' => $dt,
	// 			'iua_to_do' => 0,
	// 			'iua_owner' => $oid,
	// 			'iua_created_by'=> $uid,
	// 			'iua_created' => $dt,
	// 			'iua_status' => 'close',
	// 			'iua_categorise' => 'create',
	// 			'iua_p_activity' => 0,
	// 			'iua_shortcuts' => 0,
	// 			'iua_m_shortcuts' => 0,
	// 			'iua_g_id' => $gid
	// 		);
	// 		$this->db->insert('i_user_activity', $data);
	// 		$aid = $this->db->insert_id();
	// 		$data = array(
	// 			'iuap_a_id' => $aid,
	// 			'iuap_p_id' => $cid,
	// 			'iuap_owner' => $oid
	// 		);
	// 		$this->db->insert('i_u_a_person',$data);

	// 		$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' AND iia_name = '$acc_name' ");
	// 		$result = $query->result();
	// 		$star_acc = 0;
	// 		if (count($result) > 0) {
	// 			$star_acc = $result[0]->iia_id;
	// 		}

	// 		for ($i=0; $i < count($products) ; $i++) { 
	// 			$pd = $products[$i]['name'];
	// 			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid'");
	// 			$result = $query->result();

	// 			if(count($result)>0) {
	// 				$prid = $result[0]->ip_id;
	// 			} else {
	// 				$data1 = array(
	// 					'ip_product' => $pd,
	// 					'ip_section' => 'Products',
	// 					'ip_owner' => $oid,
	// 					'ip_created' => $dt,
	// 					'ip_created_by' => $oid,
	// 					'ip_gid' => $gid,
	// 					'ip_cat_id' => 0
	// 				);
	// 				$this->db->insert('i_product', $data1);
	// 				$prid = $this->db->insert_id();
	// 			}
	// 			$inward = 1;
	// 			$outward = 0;
	// 			$from_id = $star_acc;
	// 			$from_type = 'account';
	// 			$to_id = $cid;
	// 			$to_type = 'contact';

	// 			$data = array(
	// 				'iin_from' => $from_id,
	// 				'iin_from_type' => $from_type,
	// 				'iin_to' => $to_id,
	// 				'iin_to_type' => $to_type,
	// 				'iin_date' => $txn_date,
	// 				'iin_order_txn' => $inid,
	// 				'iin_p_id' => $prid,
	// 				'iin_inward' => $inward,
	// 				'iin_outward' => $outward,
	// 				'iin_owner' => $oid,
	// 				'iin_created' => $dt,
	// 				'iin_created_by' => $uid,
	// 				'iin_alias' => 'false',
	// 				'iin_gid' => $gid
	// 			);
	// 			$this->db->insert('i_inventory_new', $data);
	// 		}

	// 		echo $inid;
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function proceed_to_outward_product($code) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$u_ref = $sess_data['user_details'][0]->i_ref;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$cust_name = $this->input->post('c_name');
	// 		$products = $this->input->post('p_name');
	// 		$acc_arr = $this->input->post('acc_arr');
	// 		$txn_date = date('Y-m-d');
	// 		$dt = date('Y-m-d H:i:s');
	// 		$status = 'dispatch';

	// 		$module_id = '';
	// 		$module = $sess_data['user_mod'];
	// 		if (count($module) > 0) {
	// 			for ($i=0; $i <count($module) ; $i++) { 
	// 				if ($module[$i]->mname == 'Inventory_new') {
	// 					$module_id = $module[$i]->mid;
	// 					break;
	// 				}
	// 			}
	// 		}

	// 		$invoice_txn_id = '';
	// 		$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$module_id' ORDER BY iumdi_id;");
	// 		$result = $query->result();
	// 		for ($i=0; $i <count($result) ; $i++) {
	// 			if ($result[$i]->iumdi_variable == 'false') {
	// 				$invoice_txn_id .= $result[$i]->iumdi_doc_syntax;
	// 			}else{
	// 				if ($result[$i]->iumdi_doc_syntax == 'acc_yr') {
	// 					$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
	// 					$result1 = $query->result();
	// 					if (count($result1) > 0) {
	// 						$val = $result1[0]->iua_year_code;
	// 					}else{
	// 						$val = '';
	// 					}
	// 				}else{
	// 					$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='outward' AND iextei_gid = '$gid' ");
	// 					$result2 = $query->result();
	// 					$val = count($result2)+1;
	// 				}
	// 				$invoice_txn_id .= $val;
	// 			}
	// 		}
	// 		$txn_no = $invoice_txn_id;

	// 		$dt1 = date('Y-m-d');
			
	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cust_name' AND ic_owner='$oid'");
	// 		$result = $query->result();
	// 		if(count($result) > 0) {
	// 			$cid = $result[0]->ic_id;
	// 		} else {
	// 			$data1 = array(
	// 				'ic_name' => $customer,
	// 				'ic_owner' => $oid,
	// 				'ic_created' => $dt,
	// 				'ic_section' => $ctype,
	// 				'ic_created_by' => $oid );
	// 			$this->db->insert('i_customers', $data1);
	// 			$cid = $this->db->insert_id();
	// 		}

	// 		$data = array(
	// 			'iextei_customer_id' => $cid,
	// 			'iextei_txn_id' => $txn_no,
	// 			'iextei_txn_date' => $txn_date,
	// 			'iextei_type' => 'outward',
	// 			'iextei_owner' => $oid,
	// 			'iextei_created' => $dt,
	// 			'iextei_created_by' => $oid,
	// 			'iextei_status' => $status,
	// 			'iextei_gid' => $gid,
	// 			'iextei_fid' => $uid
	// 		);
	// 		$this->db->insert('i_ext_et_inventory', $data);
	// 		$inid = $this->db->insert_id();

	// 		$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
	// 		$result = $query->result();
	// 		for ($i=0; $i <count($result) ; $i++) { 
	// 			$status = 'false';
	// 			$data = array(
	// 				'iexteinvetm_inid' => $inid,
	// 				'iexteinvetm_term_id' => $result[$i]->iextdt_term,
	// 				'iexteinvetm_status' => $status
	// 			);	
	// 			$this->db->insert('i_ext_et_inventory_terms',$data);	
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND a.icbd_customer_id = '$cid' ");
	// 		$result = $query->result();
	// 		if (count($result) > 0) {
	// 			for ($i=0; $i <count($result) ; $i++) { 
	// 				$data = array(
	// 					'iexteinvept_inid' => $inid,
	// 					'iexteinvept_property_value' => $result[$i]->icbd_value,
	// 					'iexteinvept_status' => 'false'
	// 				);
	// 				$this->db->insert('i_ext_et_inventory_property',$data);	
	// 			}
	// 		}

	// 		$data1 = array(
	// 			'in_type_id' => $inid,
	// 			'in_type' => 'outward',
	// 			'in_m_id' => $module_id,
	// 			'in_person' => $cid,
	// 			'in_owner' => $oid,
	// 			'in_status' => 0,
	// 			'in_date' => $dt1
	// 		);
	// 		$this->db->insert('i_notifications',$data1);

	// 		$data = array(
	// 			'iua_type' => 'module',
	// 			'iua_title' => 'Inventory - '.$txn_no,
	// 			'iua_date' => $dt,
	// 			'iua_to_do' => 0,
	// 			'iua_owner' => $oid,
	// 			'iua_created_by'=> $uid,
	// 			'iua_created' => $dt,
	// 			'iua_status' => 'close',
	// 			'iua_categorise' => 'create',
	// 			'iua_p_activity' => 0,
	// 			'iua_shortcuts' => 0,
	// 			'iua_m_shortcuts' => 0,
	// 			'iua_g_id' => $gid
	// 		);
	// 		$this->db->insert('i_user_activity', $data);
	// 		$aid = $this->db->insert_id();
	// 		$data = array(
	// 			'iuap_a_id' => $aid,
	// 			'iuap_p_id' => $cid,
	// 			'iuap_owner' => $oid
	// 		);
	// 		$this->db->insert('i_u_a_person',$data);

	// 		$star_acc = 0;
	// 		for ($i=0; $i < count($acc_arr) ; $i++) { 
	// 			if ($acc_arr[$i]['flg'] == 'true') {
	// 				$star_acc = $acc_arr[$i]['id'];
	// 			}
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$products' AND ip_owner='$oid'");
	// 		$result = $query->result();
	// 		if(count($result)>0) {
	// 			$prid = $result[0]->ip_id;
	// 		} else {
	// 			$data1 = array(
	// 				'ip_product' => $pd,
	// 				'ip_section' => 'Products',
	// 				'ip_owner' => $oid,
	// 				'ip_created' => $dt,
	// 				'ip_created_by' => $oid,
	// 				'ip_gid' => $gid,
	// 				'ip_cat_id' => 0
	// 			);
	// 			$this->db->insert('i_product', $data1);
	// 			$prid = $this->db->insert_id();
	// 		}
	// 		$inward = 1;
	// 		$outward = 0;
	// 		$from_id = $star_acc;
	// 		$from_type = 'account';
	// 		$to_id = $cid;
	// 		$to_type = 'contact';

	// 		$data = array(
	// 			'iin_from' => $from_id,
	// 			'iin_from_type' => $from_type,
	// 			'iin_to' => $to_id,
	// 			'iin_to_type' => $to_type,
	// 			'iin_date' => $txn_date,
	// 			'iin_order_txn' => $inid,
	// 			'iin_p_id' => $prid,
	// 			'iin_inward' => $inward,
	// 			'iin_outward' => $outward,
	// 			'iin_owner' => $oid,
	// 			'iin_created' => $dt,
	// 			'iin_created_by' => $uid,
	// 			'iin_alias' => 'false',
	// 			'iin_gid' => $gid
	// 		);
	// 		$this->db->insert('i_inventory_new', $data);

	// 		echo $inid;
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }
######################## Reports #################################
    public function inventory_report($code) {
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
					if ($module[$i]->mname == 'Inventory_new') {
						$mod_id = $module[$i]->mid;
						$dom = $module[$i]->domain;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mod_id;$ert['mname']='Inventory';$ert['dom']=$dom;
			$data['mod_id'] = $mod_id;
			if ($alias == '') {
				$ert['title'] = "Inventory Analyse";	
			}else{
				$ert['title'] = $alias. " Analyse";
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('inventory/inventory_report', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}

	public function in_out_report($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			
			$fr_date = $this->input->post('fr_date');
			$to_date = $this->input->post('to_date');
			$array = [];
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			if (count($result > 0 )) {
				for ($i=0; $i < count($result) ; $i++) {
					$pid = $result[$i]->ip_id;
					$pname = $result[$i]->ip_product;
					$stock = 0;
					$in_stock = 0;
					$out_stock = 0;
					$bal_stock = 0;
					$q1 = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_date < '$fr_date' AND iin_txn_type IN ('inward','outward') AND iin_p_id = '$pid' AND iin_owner = '$oid' AND iin_gid = '$gid' ");
					$r1 = $q1->result();
					for ($j=0; $j < count($r1) ; $j++) { 
						if ($r1[$j]->iin_txn_type == 'inward') {
							$stock += $r1[$j]->iin_inward;
						}else{
							$stock -= $r1[$j]->iin_inward;
						}
					}

					$q2 = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_date BETWEEN '$fr_date' AND '$to_date' AND iin_txn_type IN ('inward','outward') AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_p_id = '$pid' ");
					$r2 = $q2->result();
					for ($j=0; $j < count($r2) ; $j++) { 
						if ($r2[$j]->iin_txn_type == 'inward') {
							$in_stock += $r2[$j]->iin_inward;
						}else{
							$out_stock += $r2[$j]->iin_inward;
						}
					}

					$bal_stock = $stock + $in_stock - $out_stock;
					array_push($array, array('bal' => $bal_stock , 'pid' => $pid ,'pname' => $pname ,'s_stock' => $stock , 'in' => $in_stock , 'out' => $out_stock ));
				}
			}
			array_multisort($array,SORT_DESC);
			$data['in_out'] = $array;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}

	public function most_least_report($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			
			$fr_date = $this->input->post('fr_date');
			$to_date = $this->input->post('to_date');

			$array = [];
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$pro = [];
			$out = [];
			if (count($result > 0 )) {
				for ($i=0; $i < count($result) ; $i++) {
					$pid = $result[$i]->ip_id;
					$pname = $result[$i]->ip_product;
					$out_stock = 0;
					$q2 = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_date BETWEEN '$fr_date' AND '$to_date' AND iin_txn_type = 'outward' AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_p_id = '$pid' ");
					$r2 = $q2->result();
					for ($j=0; $j < count($r2) ; $j++) { 
						$out_stock += $r2[$j]->iin_inward;
					}
					array_push($pro, $pname);
					array_push($out, $out_stock);
					array_push($array, array('out' => $out_stock , 'pid' => $pid ,'pname' => $pname));
				}
			}
			array_multisort($array,SORT_DESC);
			$data['in_out'] = $array;
			$data['pro'] = $pro;
			$data['out'] = $out;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}

	public function pop_in_out_report($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			
			$fr_date = $this->input->post('fr_date');
			$to_date = $this->input->post('to_date');

			$in_array = [];
			$out_array = [];
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			if (count($result > 0 )) {
				for ($i=0; $i < count($result) ; $i++) {
					$pid = $result[$i]->ip_id;
					$pname = $result[$i]->ip_product;
					$in_stock = 0;
					$out_stock = 0;
					$q2 = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_date BETWEEN '$fr_date' AND '$to_date' AND iin_txn_type IN ('outward','inward') AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_p_id = '$pid' ");
					$r2 = $q2->result();
					for ($j=0; $j < count($r2) ; $j++) {
						if ($r2[$j]->iin_txn_type == 'inward') {
							$in_stock += $r2[$j]->iin_inward;
						}else{
							$out_stock += $r2[$j]->iin_inward;
						}
					}
					array_push($out_array, array('qty' => $out_stock , 'pid' => $pid ,'pname' => $pname));
					array_push($in_array, array('qty' => $in_stock , 'pid' => $pid ,'pname' => $pname));
				}
			}
			array_multisort($out_array,SORT_DESC);
			array_multisort($in_array,SORT_DESC);
			$data['in'] = $in_array;
			$data['out'] = $out_array;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}
	}

	public function get_product_track($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			
			$fr_date = $this->input->post('fr_date');
			$to_date = $this->input->post('to_date');
			$pro_barcode = $this->input->post('pro_barcode');

			$q2 = $this->db->query("SELECT * FROM i_inventory_new as a LEFT JOIN i_product as b on a.iin_p_id = b.ip_id WHERE iin_date BETWEEN '$fr_date' AND '$to_date' AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_serial_number = '$pro_barcode' AND ip_owner = '$oid' ");
			$r2 = $q2->result();
			$data['pro_tarck'] = $r2;

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_gid = '$gid' ");
			$data['account'] = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' ");
            $data['cust'] = $query->result();

            $query = $this->db->query("SELECT * FROM i_ext_et_godown_location WHERE iextetgdl_gid = '$gid' AND iextetgdl_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetgdl_file;
				$path = $this->config->item('document_rt')."assets/data/godown/";
	            $fl = $path.$file_name;
	            $data['location'] = json_decode(file_get_contents($fl));
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}
	}

	public function get_doc_track($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid=0;
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Inventory_new') {
					$mid = $module[$i]->mid;
					break;
				}
			}

			$pro_txn = $this->input->post('pro_txn');

			$q1 = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_txn_id = '$pro_txn' AND iextei_owner = '$oid' AND iextei_gid = '$gid' ");
			$r1 = $q1->result();
			$data['inv'] = $r1;
			$txn_id = 0;
			if (count($r1) > 0 ) {
				$txn_id = $r1[0]->iextei_id;
			}
			$q2 = $this->db->query("SELECT * FROM i_ext_et_mapping_txn WHERE (iextemt_from_txn = '$txn_id' OR iextemt_to_txn = '$txn_id' ) AND (iextemt_from_mid = '$mid' OR iextemt_to_mid = '$mid') AND iextemt_owner = '$oid' ORDER BY iextemt_created ASC ");
			$r2 = $q2->result();
			$data['inv_list'] = $r2;

			$id_arr = [];
			if (count($r2) > 0 ) {
				array_push($id_arr , $r2[0]->iextemt_from_txn);
				array_push($id_arr , $r2[0]->iextemt_to_txn);
			}
			if (count($id_arr) > 0 ) {
				$id = implode(',', $id_arr);
			}else{
				$id = 0;
			}

			$q3 = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id IN ($id) AND iextein_owner = '$oid' ");
			$r3 = $q3->result();
			$data['invoice'] = $r3;

			$q3 = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_id IN ($id) AND iextepro_owner = '$oid' ");
			$r3 = $q3->result();
			$data['proposal'] = $r3;

			$q3 = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_id IN ($id) AND iextep_owner = '$oid' ");
			$r3 = $q3->result();
			$data['purchase'] = $r3;

			$q3 = $this->db->query("SELECT * FROM i_ext_et_orders WHERE iextetor_id IN ($id) AND iextetor_owner = '$oid' ");
			$r3 = $q3->result();
			$data['order'] = $r3;

			$data['mid'] = $mid;
			$data['module'] = $module;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}
	}

	public function get_product_limit($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			
			$fr_date = $this->input->post('fr_date');
			$to_date = $this->input->post('to_date');

			$array = [];
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$pro = [];
			$out = [];
			if (count($result > 0 )) {
				for ($i=0; $i < count($result) ; $i++) {
					$pid = $result[$i]->ip_id;
					$p_limit = $result[$i]->ip_limit;
					$pname = $result[$i]->ip_product;
					$in_stock = 0;
					$q2 = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_txn_type IN ('outward','inward') AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_p_id = '$pid' ");
					$r2 = $q2->result();
					for ($j=0; $j < count($r2) ; $j++) {
						if ($r2[$j]->iin_txn_type == 'inward') {
							$in_stock += $r2[$j]->iin_inward;
						}else{
							$in_stock -= $r2[$j]->iin_inward;
						}
					}
					if ($in_stock <= $p_limit) {
						array_push($pro, $pname);
						array_push($out, $in_stock);
						array_push($array, array('out' => $in_stock , 'pid' => $pid ,'pname' => $pname));
					}
				}
			}
			array_multisort($array,SORT_DESC);
			$data['in_out'] = $array;
			$data['pro'] = $pro;
			$data['out'] = $out;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'distributors/Account/login');
		}		
	}
}
?>