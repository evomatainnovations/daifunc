<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enterprise extends CI_Controller {
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
########## HOME ################
	public function index() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Home";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('home/search_modal');
			$this->load->view('customers/customer', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}
########## GENERAL PROPERTIES ################
	public function general_properties($section,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['title'] = "Contact General Properties";
			$ert['search'] = "false";
			$ert['code']=$code;
			$ert['gid']=$gid;$ert['mid']=$mid;$ert['mname']=$mname;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid'");
			$result = $query->result();

			$data['property'] = $result;
			$data['thing'] = $section;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/general_properties', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_property($section,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data = array('ip_property' => $this->input->post('p_property'), 'ip_owner' => $oid, 'ip_section' => $section);	
			$this->db->insert('i_property', $data);
			$inid = $this->db->insert_id();
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_id = '$inid'");
			$result = $query->result();

			print_r(json_encode($result));
		}
	}

	public function remove_property($section,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$pid = $this->input->post('pid');

			$this->db->where('ip_id', $pid);
			$this->db->delete('i_property');

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' ");
			$result = $query->result();

			print_r(json_encode($result));
		}	
	}
########## IMPORT FILE ###############
 	public function excel_import_file($section,$code){
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = $section." Import Details";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['mid'] = $mid;$ert['mname']=$mname;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$section'");
			$result = $query->result();

			$data['property'] = $result;
			$data['thing'] = $section;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/import_file', $data);
			$this->load->view('home/search_modal');
		}
 	}

 	public function excel_upload_file($code){
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

			$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				$img_path = $targetPath;
			
				$img_path = $_FILES['use']['name'];
			}

			$data = array(
				'icem_path' => $img_path,
				'icem_owner' => $oid,
				'icem_created' => $dt,
				'icem_created_by' => $uid
			);
			$this->db->insert('i_c_excel_module', $data);
			$in_id = $this->db->insert_id();
			echo $in_id;
		} else {
			redirect(base_url().'Account/login');
		}
 	}

 	public function read_excel($code,$in_id) {
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];

			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

	 		$query = $this->db->query("SELECT icem_path FROM i_c_excel_module WHERE icem_id = '$in_id' AND icem_owner = '$oid'");
	 		$result = $query->result(); 
	 		$data['in_id'] = $in_id;

	 		$file = $this->config->item('document_rt').'assets/data/'.$oid.'/'.$result[0]->icem_path;
			$ext = pathinfo($file);
			
			if ($ext['extension'] == 'csv') {
				
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$array = array();
	
				foreach ($lines as $line) {
					$array['numRows'] = str_getcsv($line);
					$array[] = str_getcsv($line);
				}

				$data['csv'] = $array[0];
				// print_r($data['csv']);
			}else{
				$this->excel_reader->read($file);
				 //Get the contents of the first worksheet
				$worksheet = $this->excel_reader->sheets[0];
				$data['numRows'] = $worksheet['numRows']; // ex: 14
				$data['numCols'] = $worksheet['numCols']; // ex: 4
				$data['cells'] = $worksheet['cells']; // the 1st row are usually the field's name
			}
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid'");
			$result = $query->result();
			$data['property'] = $result;

			$query = $this->db->query("SELECT ic_section FROM i_customers GROUP BY ic_section");
			$result = $query->result();
			$data['options'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			if ($alias == '') {
				$ert['title'] = "Customers Import Details";
			}else{
				$ert['title'] = $alias." Import Details";
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/import_mapping', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_excel_data($in_id,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$name = '';$con='';
			$name1 ='';$con1='';
			$dt = date('Y-m-d H:i:s');
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
			$btn_array = $this->input->post('btn_array');
			$type = $this->input->post('type');
			// print_r($btn_array);
			$query = $this->db->query("SELECT icem_path FROM i_c_excel_module WHERE icem_id = '$in_id' AND icem_owner ='$oid'");
	 		$result = $query->result(); 

	 		$file = $this->config->item('document_rt').'assets/data/'.$oid.'/'.$result[0]->icem_path;
			$ext = pathinfo($file);
			
			$output="";
			if ($ext['extension'] == 'csv') {
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$array = array();
	
				foreach ($lines as $line) {
					$array['numRows'] = str_getcsv($line);
					$array[] = str_getcsv($line);
				}
				$data['csv'] = $array;
				// print_r($data['csv'][0][$btn_array[0]["multi_d_array"][3]['d_id']]);
				for ($i=1; $i <= count($data['csv']) ; $i++) {
					for ($j=0; $j < count($btn_array); $j++) {
						for ($k=0; $k < count($btn_array[$j]['multi_d_array']); $k++) { 
							if ($btn_array[$j]['p_val'] == 'name' ) {
								if ($data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']]) {
									if ($con == '') {
										$con.=$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con.=' '.$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
									
								}	
							}else{
								if ($data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']]) {
									if ($con1 == '') {
										$con1.=$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con1.=' '.$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}
						}
						if ($btn_array[$j]['p_val'] == 'name' ) {
							$data1 = array(
								'ic_name' => $con,
								'ic_owner' => $oid,
								'ic_created' => $dt,
								'ic_created_by' => $uid,
								'ic_section' => $type
							);
							$this->db->insert('i_customers',$data1);
							$insert_id = $this->db->insert_id();
						}
							$data2 = array(
								'icbd_customer_id' => $insert_id,
								'icbd_property' => $btn_array[$j]['p_id'],
								'icbd_value' => $con1
							);
							$this->db->insert('i_c_basic_details',$data2);
						
						$con='';$con1='';
					}
				}
			}else{

				$this->excel_reader->read($file);
				$worksheet = $this->excel_reader->sheets[0];
				$data['cells'] = $worksheet['cells'];
				
				for ($i=2; $i <= count($data['cells']) ; $i++) {
					for ($j=0; $j < count($btn_array); $j++) {
						for ($k=0; $k < count($btn_array[$j]['multi_d_array']); $k++) {
							if ($btn_array[$j]['p_val'] == 'name' ) {
								if (isset($data['cells'][$i][$btn_array[$j]['multi_d_array'][$k]['d_id']])) {
									if ($con == ''){
										$con.=$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con.=' '.$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}else{
								if (isset($data['cells'][$i][$btn_array[$j]['multi_d_array'][$k]['d_id']])) {
									if ($con1 == '') {
										$con1.=$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];	
									}else{
										$con1.=' '.$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}	
						}
						if ($btn_array[$j]['p_val'] == 'name' ) {
							$data1 = array(
								'ic_name' => $con,
								'ic_owner' => $oid,
								'ic_created' => $dt,
								'ic_created_by' => $uid,
								'ic_section' => $type
							);
							$this->db->insert('i_customers',$data1);
							$insert_id = $this->db->insert_id();
						}
							$data2 = array(
								'icbd_customer_id' => $insert_id,
								'icbd_property' => $btn_array[$j]['p_id'],
								'icbd_value' => $con1
							);
							$this->db->insert('i_c_basic_details',$data2);
						
						$con='';$con1='';$name="";$name1="";
					}
				}
			}	
			$this->db->where('icem_id',$in_id);
			$this->db->delete('i_c_excel_module');
			echo "true";	
		}
	}
########## CUSTOMERS ################
	public function customers($mid=0,$code,$cid=0) {
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
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT ic_section FROM i_customers WHERE ic_owner='$oid' GROUP BY ic_section");
			$result = $query->result();
			$data['section'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b on a.ic_id = b.icp_c_id WHERE ic_owner='$oid' ORDER BY ic_id DESC limit 100 ");
			$result1 = $query->result();
			$data['customer'] = $result1;

	        $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
	        $result = $query->result();
	        $data['tags'] = $result;

	        $query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'customer'");
			$result = $query->result();
			$data['property'] = $result;
			
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
			$data['cid'] = $cid;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function cust_add($code,$c_id=0) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['code'] = $code;
			$data['cid'] = $c_id;
			$p_cid = 0;
			if ($c_id != 0) {
				$query1 = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$c_id'");
				$result1 = $query1->result();
				if (count($result1) > 0 ) {
					$p_cid = $result1[0]->ic_p_cid;
				}
				$data['edit_cust'] = $result1;

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_id = '$p_cid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['edit_cust_parent'] = $result;	
				}

				$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$c_id' ");
				$result1 = $query1->result();
				$data['cust_details'] = $result1;

				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'email%' ");
				$data['email_prop'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'phone%' ");
				$data['phone_prop'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ");
				$data['address_prop'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_id NOT IN (SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'email%' UNION SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'phone%' UNION SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ) ");
				$data['custom_prop'] = $query->result();

				$query2= $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid = '$c_id' AND icd_type != 'profile' ");
				$result2 = $query2->result();
				$data['edit_doc'] = $result2;

				$query2= $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid = '$c_id' AND icd_type = 'profile' ");
				$result2 = $query2->result();
				if (count($result2) > 0 ) {
					$data['doc_profile'] = $result2;
				}
				$query2= $this->db->query("SELECT * FROM i_ext_tags as a LEFT JOIN i_tags as b on a.iet_tag_id = b.it_id WHERE iet_type_id = '$c_id' AND iet_type = 'customers' ");
				$result2 = $query2->result();
				$data['edit_tags'] = $result2;
			}

			$this->load->view('enterprise/customer_save',$data);
		} else {
			redirect(base_url().'account/login');
		}
	}
	public function customers_show_more($code,$flg) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
			$c_type = $this->input->post('c_type');

			if ($c_type == 'all') {
				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_owner='$oid' ORDER BY ic_id DESC limit $flg ");
				$result = $query->result();
			}else{
				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_owner='$oid' AND a.ic_section = '$c_type' ORDER BY ic_id DESC limit $flg");
				$result = $query->result();
			}
			$data['customer'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function customer_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_name LIKE '%".$search."%'  AND a.ic_owner='$oid' ORDER BY ic_id DESC ");
			$result = $query->result();

			$data['customer'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

    public function customer_filter($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

            $section = $this->input->post('filter');
			if($section == "all") {
				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_owner='$oid' ORDER BY ic_id DESC");
				$result = $query->result();
			} else {
				$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_section = '$section' AND a.ic_owner='$oid' ORDER BY ic_id DESC limit 100");
				$result = $query->result();
			}

			$data['customer'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function customer_add($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$data['oid'] = $oid;
			$mid=0;$mname='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_owner='$oid'");
			$result = $query->result();

			$data['customer'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'customer'");
			$result = $query->result();
			$data['property'] = $result;

            $query = $this->db->query("SELECT ic_section FROM i_customers WHERE ic_owner='$oid' GROUP BY ic_section");
			$result = $query->result();
			$data['section'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();
			$data['tags'] = $result;
			$data['thing'] = 'Customer';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			if ($alias == '') {
				$ert['title'] = "Add ".$mname;
			}else{
				$ert['title'] = "Add ".$alias;
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;$ert['mid'] = $mid;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	// public function save_customer($code) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$c_name = $this->input->post('name');
	// 		$c_prop = $this->input->post('property');
	// 		$c_tags = $this->input->post('tags');
	// 		$c_section = $this->input->post('section');
	// 		$c_parent = $this->input->post('cust_parent');
	// 		$p_rel = $this->input->post('p_rel');

	// 		$module = $sess_data['user_mod'];
	// 		if (count($module) > 0) {
	// 			for ($i=0; $i <count($module) ; $i++) { 
	// 				if ($module[$i]->mname == 'Contact') {
	// 					$module_id = $module[$i]->mid;
	// 					break;
	// 				}
	// 			}
	// 		}
	// 		$dt = date('Y-m-d H:i:s');
	// 		$c_pid = 0;
	// 		if ($c_parent != '') {
	// 			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$c_parent' AND ic_owner = '$oid' ");
	// 			$result = $query->result();	
	// 			if (count($result) > 0 ) {
	// 				$c_pid = $result[0]->ic_id;
	// 			}
	// 		}

	// 		$data = array(
	// 			'ic_name' => $c_name,
	// 			'ic_owner' => $oid,
	// 			'ic_created' => $dt,
	// 			'ic_section' => $c_section,
	// 			'ic_created_by' => $oid,
	// 			'ic_p_cid' => $c_pid,
	// 			'ic_p_rel' => $p_rel
	// 		);
	// 		$this->db->insert('i_customers', $data);
	// 		$cid = $this->db->insert_id();

	// 		for ($i=0; $i < count($c_prop) ; $i++) {
	// 			$prp = $c_prop[$i]['prop'];
	// 			$val = $c_prop[$i]['val'];
	// 			if ($val != '') {
	// 				$q = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property = '$prp' ");
	// 				$res = $q->result();
	// 				$p_id = 0 ;
	// 				if (count($res) > 0 ) {
	// 					$p_id = $res[0]->ip_id;
	// 				}else{
	// 					$data = array('ip_property' => $prp, 'ip_owner' => $oid);
	// 					$this->db->insert('i_property', $data);
	// 					$p_id = $this->db->insert_id();
	// 				}
	// 				$data = array('icbd_customer_id'=> $cid, 'icbd_property' => $p_id, 'icbd_value' => $val);
	// 				$this->db->insert('i_c_basic_details', $data);	
	// 			}
	// 		}
	// 		for ($j=0; $j < count($c_tags) ; $j++) { 
	// 			$tmp_tag = $c_tags[$j];

	// 			$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
	// 			$result = $query->result();

	// 			if(count($result) <= 0) {
	// 				$data3 = array(
	// 					'it_value' => $tmp_tag,
	// 					'it_owner' => $oid );

	// 				$this->db->insert('i_tags', $data3);
	// 				$tid = $this->db->insert_id();
	// 			} else {
	// 				$tid = $result[0]->it_id;
	// 			}

	// 			$data5 = array(
	// 				'iet_type_id' => $cid,
	// 				'iet_type' => 'customers',
	// 				'iet_tag_id' => $tid,
	// 				'iet_owner' => $oid,
	// 				'iet_m_id' => $module_id
	// 			);
	// 			$this->db->insert('i_ext_tags', $data5);				
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' ORDER BY ic_id DESC limit 100 ");
	// 		$result1 = $query->result();
	// 		$data['customer'] = $result1;

	// 		$data['cid'] = $cid;

	// 		print_r(json_encode($data));
	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function update_customer($c_id,$code) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$c_name = $this->input->post('name');
	// 		$c_prop = $this->input->post('property');
	// 		$old_c_prop = $this->input->post('old_property');
	// 		$c_tags = $this->input->post('tags');
	// 		$c_section = $this->input->post('section');
	// 		$c_parent = $this->input->post('cust_parent');
	// 		$p_rel = $this->input->post('p_rel');
	// 		$dt = date('Y-m-d H:i:s');

	// 		$module = $sess_data['user_mod'];
	// 		if (count($module) > 0) {
	// 			for ($i=0; $i <count($module) ; $i++) { 
	// 				if ($module[$i]->mname == 'Contact') {
	// 					$module_id = $module[$i]->mid;
	// 					break;
	// 				}
	// 			}
	// 		}

	// 		$c_pid = 0;
	// 		if ($c_parent != '') {
	// 			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$c_parent' AND ic_owner = '$oid' ");
	// 			$result = $query->result();	
	// 			if (count($result) > 0 ) {
	// 				$c_pid = $result[0]->ic_id;
	// 			}
	// 		}

	// 		$data = array(
	// 			'ic_name' => $c_name,
	// 			'ic_modified' => $dt,
	// 			'ic_section' => $c_section,
	// 			'ic_modified_by' => $oid,
	// 			'ic_p_cid' => $c_pid,
	// 			'ic_p_rel' => $p_rel
	// 		);
	// 		$this->db->where('ic_id', $c_id);
	// 		$this->db->update('i_customers', $data);
			
	// 		$this->db->where('icbd_customer_id', $c_id);
	// 		$this->db->delete('i_c_basic_details');

	// 		for ($i=0; $i < count($c_prop) ; $i++) {
	// 			$prp = $c_prop[$i]['prop'];
	// 			$val = $c_prop[$i]['val'];
	// 			if ($val != '') {
	// 				$q = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property = '$prp' ");
	// 				$res = $q->result();
	// 				$p_id = 0 ;
	// 				if (count($res) > 0 ) {
	// 					$p_id = $res[0]->ip_id;
	// 				}else{
	// 					$data = array('ip_property' => $prp, 'ip_owner' => $oid);
	// 					$this->db->insert('i_property', $data);
	// 					$p_id = $this->db->insert_id();
	// 				}
	// 				$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $p_id, 'icbd_value' => $val);
	// 				$this->db->insert('i_c_basic_details', $data);	
	// 			}
	// 		}

	// 		for ($i=0; $i < count($old_c_prop) ; $i++) {
	// 			$prp = $old_c_prop[$i]['lable'];
	// 			$val = $old_c_prop[$i]['val'];
	// 			if ($val != '') {
	// 				$q = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property = '$prp' ");
	// 				$res = $q->result();
	// 				$p_id = 0 ;
	// 				if (count($res) > 0 ) {
	// 					$p_id = $res[0]->ip_id;
	// 				}else{
	// 					$data = array('ip_property' => $prp, 'ip_owner' => $oid);
	// 					$this->db->insert('i_property', $data);
	// 					$p_id = $this->db->insert_id();
	// 				}
	// 				$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $p_id, 'icbd_value' => $val);
	// 				$this->db->insert('i_c_basic_details', $data);
	// 			}
	// 		}

	// 		$data = array(
	// 			'iet_type_id' => $c_id,
	// 			'iet_type' => 'customers',
	// 			'iet_owner' => $oid,
	// 			'iet_m_id' => $module_id
	// 		);
	// 		$this->db->WHERE($data);
	// 		$this->db->delete('i_ext_tags');

	// 		for ($j=0; $j < count($c_tags) ; $j++) { 
	// 			$tmp_tag = $c_tags[$j];

	// 			$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag'");
	// 			$result = $query->result();

	// 			if(count($result) <= 0) {
	// 				$data3 = array(
	// 					'it_value' => $tmp_tag,
	// 					'it_owner' => $oid );

	// 				$this->db->insert('i_tags', $data3);
	// 				$tid = $this->db->insert_id();
	// 			} else {
	// 				$tid = $result[0]->it_id;
	// 			}

	// 			$data5 = array(
	// 				'iet_type_id' => $c_id,
	// 				'iet_type' => 'customers',
	// 				'iet_tag_id' => $tid,
	// 				'iet_owner' => $oid,
	// 				'iet_m_id' => $module_id
	// 			);
	// 			$this->db->insert('i_ext_tags', $data5);
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' ORDER BY ic_id DESC limit 100 ");
	// 		$result1 = $query->result();
	// 		$data['customer'] = $result1;

	// 		$data['cid'] = $c_id;

	// 		print_r(json_encode($data));
	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	public function view_customer($code,$c_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['mod'] = $sess_data['user_mod'];
			$data['oid'] = $oid;
			$data['code'] = $code;
			$module = $sess_data['user_mod'];
			$data['activity'] = [];
			$data['invoice'] = [];
			$data['inventory'] = [];
			$data['amc'] = [];
			$data['quotation'] = [];
			$data['purchase'] = [];
			$data['proposal'] = [];

			$query1 = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$c_id'");
			$result1 = $query1->result();
			$data['edit_cust'] = $result1;
			
			$query1 = $this->db->query("SELECT a.ic_id as cid , a.ic_p_rel as rel , a.ic_name as cname FROM i_customers as a LEFT JOIN i_customers as b on a.ic_p_cid = b.ic_id  WHERE a.ic_p_cid = '$c_id'");
			$result1 = $query1->result();
			$data['child_cust'] = $result1;

			$query1 = $this->db->query("SELECT b.ic_id as cid , a.ic_p_rel as rel , b.ic_name as cname FROM i_customers as a LEFT JOIN i_customers as b on a.ic_p_cid = b.ic_id  WHERE a.ic_id = '$c_id'");
			$result1 = $query1->result();
			$data['parent_cust'] = $result1;

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$c_id' ");
			$result1 = $query1->result();
			$data['cust_details'] = $result1;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'email%' ");
			$data['email_prop'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'phone%' ");
			$data['phone_prop'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ");
			$data['address_prop'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_id NOT IN (SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'email%' UNION SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'phone%' UNION SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ) ");
			$data['custom_prop'] = $query->result();

			$query2= $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid = '$c_id'");
			$result2 = $query2->result();
			$data['doc'] = $result2;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_customer_id = '$c_id' AND iextein_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) {
				array_push($data['invoice'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_customer_id = '$c_id' AND iextei_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) {
				array_push($data['inventory'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id = '$c_id' AND iextamc_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['amc'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_customer_id = '$c_id' AND iextep_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['purchase'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_user_activity as a LEFT JOIN i_u_a_person as b on a.iua_id = b.iuap_a_id WHERE iuap_p_id = '$c_id' AND iua_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['activity'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_customer_id = '$c_id' AND iextepro_owner = '$oid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['proposal'], $result2[$j]);
			}$tid = '';

			$data['cid'] = $c_id;

			$this->load->view('enterprise/customer_view', $data);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_customer($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			$c_tags = $this->input->post('tags');
            $c_rel_contact = $this->input->post('rel_contact');
			$c_rel_desc = $this->input->post('rel_desc');
			$c_section = $this->input->post('section');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_name' => $c_name,
				'ic_owner' => $oid,
				'ic_created' => $dt,
				'ic_section' => $c_section,
				'ic_created_by' => $oid );

			$this->db->insert('i_customers', $data);
			$cid = $this->db->insert_id();

			for ($i=0; $i < count($c_value) ; $i++) { 
				$tmp_prp = $c_value[$i]['v'];
				$tmp_val = $c_value[$i]['p'];

				$data2 = array(
					'icbd_customer_id' => $cid,
					'icbd_property' => $tmp_prp,
					'icbd_value' => $tmp_val);

				$this->db->insert('i_c_basic_details', $data2);		
			}

			$vv = $c_property[0]['n_v'];
			$pp = $c_property[0]['n_p'];
			$n_pp = array();
			$n_pv = array();
			for ($i=0; $i < count($pp) ; $i++) {
				if ($pp[$i] != "") {
					$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'customer');	
					$this->db->insert('i_property', $data);
					$npid = $this->db->insert_id();
					array_push($n_pp, $npid);
					array_push($n_pv, $vv[$i]);
				}
			}

			for ($i=0; $i < count($n_pp) ; $i++) { 
				$data = array('icbd_customer_id'=> $cid, 'icbd_property' => $n_pp[$i], 'icbd_value' => $n_pv[$i]);
				$this->db->insert('i_c_basic_details', $data);
			}

			for ($j=0; $j < count($c_tags) ; $j++) { 
				$tmp_tag = $c_tags[$j];

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
					'iet_type_id' => $cid,
					'iet_type' => 'customers',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);				
			}
            $deldata = array(
                    "icr_parent_id" => $cid,
                    "icr_owner" => $oid
                );
                
            $this->db->where($deldata);
            $this->db->delete('i_customers_relations');
            
            for($i=0; $i< count($c_rel_contact); $i++) {
                $tmp_con = $c_rel_contact[$i];
                $tmp_rel = $c_rel_desc[$i];
                
                $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$tmp_con'");
                $result = $query->result();
                
                if(count($result) > 0) {
                    $childid = $result[0]->ic_id;
                } else {
                    $data = array(
        				'ic_name' => $tmp_con,
        				'ic_owner' => $oid,
        				'ic_created' => $dt,
        				'ic_section' => $c_section,
        				'ic_created_by' => $oid );
        
        			$this->db->insert('i_customers', $data);
        			$childid = $this->db->insert_id();
                }
                
                
                $insdata = array(
                    "icr_parent_id" => $cid,
                    "icr_child_id" => $childid,
                    "icr_relation" => $tmp_rel,
                    "icr_owner" => $oid,
                    "icr_created" => $dt,
                    "icr_created_by" => $oid);
                    
                $this->db->insert('i_customers_relations', $insdata);
            }
			
			echo $cid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function cust_redirect($type,$code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->function == $type) {
					if ($type == 'invoice') {
						redirect(base_url().$module[$i]->domain.'/invoice_add/'.$module[$i]->mid.'/'.$code.'/'.$id);
						break;
					}
					if ($type == 'inventory') {
						$query = $this->db->query("SELECT * from i_ext_et_inventory WHERE iextei_id='$id' AND iextei_owner='$oid'");
						$result = $query->result();
						$subtype = $result[0]->iextei_type;
						if ($subtype == 'inward') {
							redirect(base_url().$module[$i]->domain.'/inventory_edit/inward/'.$code.'/'.$module[$i]->mid.'/'.$id);
							break;
						}else if($subtype == 'outward'){
							redirect(base_url().$module[$i]->domain.'/inventory_edit/outward/'.$code.'/'.$module[$i]->mid.'/'.$id);
							break;
						}
					}
					if ($type == 'amc') {
						redirect(base_url().$module[$i]->domain.'/amc_edit/'.$module[$i]->mid.'/'.$code.'/'.$id);
						break;
					}
					if ($type == 'purchase') {
						redirect(base_url().$module[$i]->domain.'/purchase_edit/'.$module[$i]->mid.'/'.$code.'/'.$id);
						break;
					}
					if ($type == 'proposal') {
						redirect(base_url().$module[$i]->domain.'/proposal_add/'.$code.'/'.$module[$i]->mid.'/'.$id);
						break;
					}
				}	
			}
		}else{
			redirect(base_url().'account/login');
		}	
	}

	public function customer_details($c_id,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$data['activity'] = [];
			$data['invoice'] = [];
			$data['inventory'] = [];
			$data['amc'] = [];
			$data['quotation'] = [];
			$data['purchase'] = [];
			$data['proposal'] = [];
			$mid=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query1 = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$c_id'");
			$result1 = $query1->result();
			$data['c_name'] = $result1;

			$query2= $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid = '$c_id'");
			$result2 = $query2->result();
			$data['doc'] = $result2;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_customer_id = '$c_id'");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) {
				array_push($data['invoice'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_customer_id = '$c_id' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) {
				array_push($data['inventory'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_customer_id = '$c_id' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['amc'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_customer_id = '$c_id' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['purchase'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_user_activity as a LEFT JOIN i_u_a_person as b on a.iua_id = b.iuap_a_id WHERE iuap_p_id = '$c_id' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['activity'], $result2[$j]);
			}$tid = '';

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal WHERE iextepro_customer_id = '$c_id' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['proposal'], $result2[$j]);
			}$tid = '';

			$data['cid'] = $c_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			if ($alias == '') {
				$ert['title'] = $mname." Details";
			}else{
				$ert['title'] = $alias." Details";
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];$ert['mid'] = $mid;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer_details', $data);
			$this->load->view('home/search_modal');

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function leads_convert($cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_section' => 'customer'
			);
			$this->db->where('ic_id', $cid);
			$this->db->update('i_customers', $data);

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	// public function doc_download($type,$cid){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$file = '';

	// 		if ($type == 'd') {
	// 			$query = $this->db->query("SELECT * FROM i_c_doc where icd_id = '$cid'");
	// 			$result = $query->result();
	// 			$file = $result[0]->icd_file;
	// 		}else{
	// 			$query = $this->db->query("SELECT * FROM i_c_pic where icp_id = '$cid'");
	// 			$result = $query->result();
	// 			$file = $result[0]->icp_path;
	// 		}

	// 	    $path = $this->config->item('document_rt').'assets/uploads/'.$oid.'/';

	//     	$this->load->helper('download');
	// 		force_download($path.$file, NULL);
			
	// 	}else{
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	public function customer_edit($code,$c_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section like '%customer%' ");
			$result = $query->result();
			$data['property'] = $result;

            $query = $this->db->query("SELECT ic_section FROM i_customers WHERE ic_owner='$oid' GROUP BY ic_section");
			$result = $query->result();
			$data['section'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	  //       $data['use_modules'] = $query->result();

	  //       $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
	  //       $result = $query->result();
	  //       $data['status'] = $result;

	  //       $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
	  //       $result = $query->result();
	  //       $data['place'] = $result;

	  //       $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
	  //       $result = $query->result();
	  //       $data['cat'] = $result;

	  //       $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	  //       $result = $query->result();
	  //       $data['user_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id='$c_id' AND ic_owner='$oid'");
			$result = $query->result();
			$data['edit_customer'] = $result;

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id='$c_id'");
			$result1 = $query1->result();
			$data['edit_basic_details'] = $result1;

			$query2 = $this->db->query("SELECT * FROM i_ext_tags as a LEFT JOIN i_tags as b on a.iet_tag_id = b.it_id WHERE iet_type_id='$c_id' AND iet_type = 'customers' ");
			$result2 = $query2->result();
			$data['edit_preferences'] = $result2;

			$query2 = $this->db->query("SELECT * FROM i_customers_relations AS a LEFT JOIN i_customers AS b ON a.icr_child_id=b.ic_id WHERE a.icr_parent_id='$c_id' AND a.icr_owner='$oid'");
			$result2 = $query2->result();

			$data['edit_relations'] = $result2;

			$query3 = $this->db->query("SELECT * FROM i_c_doc WHERE icd_cid = '$c_id' AND icd_owner = '$oid'");
			$data['user_files'] = $query3->result();

			$data['cid'] = $c_id;

			$data['thing'] = 'Customer';
			$ert['mid'] = $mid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			if ($alias == '') {
				$ert['title'] = $mname." Edit";
			}else{
				$ert['title'] = $alias." Edit";
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/customer_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_customer($c_id,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			$c_tags = $this->input->post('tags');
            $c_rel_contact = $this->input->post('rel_contact');
			$c_rel_desc = $this->input->post('rel_desc');
			$c_section = $this->input->post('section');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_name' => $c_name,
				'ic_modified' => $dt,
				'ic_section' => $c_section,
				'ic_modified_by' => $oid );

			$this->db->where('ic_id', $c_id);
			$this->db->update('i_customers', $data);
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			for ($i=0; $i < count($c_value) ; $i++) { 
				$tmp_prp = $c_value[$i]['v'];
				$tmp_val = $c_value[$i]['p'];

				$data2 = array(
					'icbd_customer_id' => $c_id,
					'icbd_property' => $tmp_prp,
					'icbd_value' => $tmp_val);

				$this->db->insert('i_c_basic_details', $data2);		
			}

			$pp = $c_property[0]['n_p'];

			$n_pp = array();
			$n_pv = array();
			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($pp) ; $i++) {
				if ($pp[$i] != "") {
					$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'customer');	
					$this->db->insert('i_property', $data);
					$npid = $this->db->insert_id();
					array_push($n_pp, $npid);
					array_push($n_pv, $vv[$i]);
				}
			}

			for ($i=0; $i < count($n_pp) ; $i++) { 
				$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $n_pp[$i], 'icbd_value' => $n_pv[$i]);
				$this->db->insert('i_c_basic_details', $data);
			}

			$data = array(
				'iet_type_id' => $c_id,
				'iet_type' => 'customers',
				'iet_owner' => $oid,
				'iet_m_id' => $module_id
			);
			$this->db->WHERE($data);
			$this->db->delete('i_ext_tags');

			for ($j=0; $j < count($c_tags) ; $j++) { 
				$tmp_tag = $c_tags[$j];

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag'");
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
					'iet_type_id' => $c_id,
					'iet_type' => 'customers',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}
			
			$deldata = array(
                    "icr_parent_id" => $c_id,
                    "icr_owner" => $oid
                );
                
            $this->db->where($deldata);
            $this->db->delete('i_customers_relations');
            
            for($i=0; $i< count($c_rel_contact); $i++) {
                $tmp_con = $c_rel_contact[$i];
                $tmp_rel = $c_rel_desc[$i];
                
                $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '$tmp_con'");
                $result = $query->result();
                
                if(count($result) > 0) {
                    $childid = $result[0]->ic_id;
                } else {
                    $data = array(
        				'ic_name' => $tmp_con,
        				'ic_owner' => $oid,
        				'ic_created' => $dt,
        				'ic_section' => $c_section,
        				'ic_created_by' => $oid );
        
        			$this->db->insert('i_customers', $data);
        			$childid = $this->db->insert_id();
                }
                
                
                $insdata = array(
                    "icr_parent_id" => $c_id,
                    "icr_child_id" => $childid,
                    "icr_relation" => $tmp_rel,
                    "icr_owner" => $oid,
                    "icr_created" => $dt,
                    "icr_created_by" => $oid);
                    
                $this->db->insert('i_customers_relations', $insdata);
            }
			
			echo $c_id;
		} else {
			redirect(base_url().'account/login');
		}
	}

	// public function delete_cust($code,$c_id) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;

	// 		$this->db->where('ic_id', $c_id);
	// 		$this->db->delete('i_customers');
			
	// 		$this->db->where('icbd_customer_id', $c_id);
	// 		$this->db->delete('i_c_basic_details');

	// 		$this->db->where(array('icd_type_id' => $c_id , 'icd_owner' => $oid ));
	// 		$this->db->delete('i_c_doc');

	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' ORDER BY ic_id DESC limit 100 ");
	// 		$result1 = $query->result();
	// 		$data['customer'] = $result1;

	// 		print_r(json_encode($data));

	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }
	public function delete_customer($code,$c_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->where('ic_id', $c_id);
			$this->db->delete('i_customers');
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			$this->db->where(array('icd_type_id' => $c_id , 'icd_owner' => $oid ));
			$this->db->delete('i_c_doc');

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' ORDER BY ic_id DESC limit 100 ");
			// $result1 = $query->result();
			// $data['customer'] = $result1;

			// print_r(json_encode($data));

			redirect(base_url().'Enterprise/customers/null/'.$code);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function uploadfile($code,$cid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
					}
				}
			}
			$dt = date('Y-m-d H:i:s');
			$upload_dir = $this->config->item('document_rt')."/assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				for ($i=0; $i <count($_FILES['use']['tmp_name']) ; $i++) {
					$sourcePath = $_FILES['use']['tmp_name'][$i]; // Storing source path of the file in a variable
					$target = $upload_dir.$_FILES['use']['name'][$i]; // Target path where file is to be stored

					$path_parts = pathinfo($target);
					$file_name = $path_parts['filename'];
					$ext = $path_parts['extension'];
					$dt = date('Y-m-d H:i:s');
					$dt1=date_create();
					$dt_str = date_timestamp_get($dt1);
					$timestamp_value = $uid.$dt_str;

					$targetPath = $upload_dir.$timestamp_value.'.'.$ext;

					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				}
			}

			$this->db->where('icp_c_id', $cid);
			$this->db->delete('i_c_pic');

			$data = array(
				'icd_owner' => $oid,
				'icd_cid' => $cid,
				'icd_type' => 'profile',
				'icd_type_id' => $cid
			);
			$this->db->where($data);
			$this->db->delete('i_c_doc');

			$path_parts = pathinfo($targetPath);
			$file_name = $path_parts['filename'];
			$ext = $path_parts['extension'];

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); 
			$dt_str = date_timestamp_get($dt1);
			$timestamp_value = $i.$dt_str;
			
			$data = array(
				'icd_file' => $file_name,
				'icd_owner' => $oid,
				'icd_cid' => $cid,
				'icd_date' => $dt,
				'icd_type' => 'profile',
				'icd_timestamp' => $timestamp_value.'.'.$ext,
				'icd_status' => 'true',
				'icd_mid' => $mid,
				'icd_type_id' => $cid
			);
			$this->db->insert('i_c_doc', $data);

			$data = array('icp_c_id' => $cid, 'icp_path' => $timestamp_value.'.'.$ext );
			$this->db->insert('i_c_pic', $data);
			
			$timestamp_value = '';

			echo "true";
		}
	}

	public function cust_doc_upload($code,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			// $data = array(
			// 	'icd_owner' => $oid,
			// 	'icd_cid' => $cid,
			// 	'icd_type' => 'document',
			// 	'icd_type_id' => $cid
			// );
			// $this->db->where($data);
			// $this->db->delete('i_c_doc');

			$module = $sess_data['user_mod'];
			$mid = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						break;
					}
				}
			}

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
						'icd_type_id' => $cid,
						'icd_mid' => $mid
					);
					$this->db->insert('i_c_doc', $data);
					$timestamp_value = '';
				}	
				$img_path = '';
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}	
	}

	public function timestamp_check(){
		for ($i=0; $i < 10 ; $i++) {
			// $date = new DateTime();
			// echo $date->getTimestamp().'<br>';
			$dt1=date_create(date("Y-m-d H:i:s")); $dt_str = date_timestamp_get($dt1);
			echo $i.$dt_str.'<br>';
		}
	}
########## Product Import Files #############

	public function product_import_file($section,$code){
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = $section." Import Details";
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];
			$ert['mid'] = $mid;$ert['mname']=$mname;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$section'");
			$result = $query->result();

			$data['property'] = $result;
			$data['thing'] = $section;

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/import_file', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
 	}

 	public function product_upload_file($code){
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

			$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				$img_path = $targetPath;
			
				$img_path = $_FILES['use']['name'];
			}

			$data = array(
				'icem_path' => $img_path,
				'icem_owner' => $oid,
				'icem_created' => $dt,
				'icem_created_by' => $uid
			);
			$this->db->insert('i_c_excel_module', $data);
			$in_id = $this->db->insert_id();
			echo $in_id;
		} else {
			redirect(base_url().'Account/login');
		}
 	}

 	public function read_product($code,$in_id) {
 		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];

			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Contact') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

	 		$query = $this->db->query("SELECT icem_path FROM i_c_excel_module WHERE icem_id = '$in_id' AND icem_owner = '$oid'");
	 		$result = $query->result(); 
	 		$data['in_id'] = $in_id;

	 		$file = $this->config->item('document_rt').'assets/data/'.$oid.'/'.$result[0]->icem_path;
			$ext = pathinfo($file);
			
			if ($ext['extension'] == 'csv') {
				
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$array = array();
	
				foreach ($lines as $line) {
					$array['numRows'] = str_getcsv($line);
					$array[] = str_getcsv($line);
				}

				$data['csv'] = $array[0];
				// print_r($data['csv']);
			}else{
				$this->excel_reader->read($file);
				 //Get the contents of the first worksheet
				$worksheet = $this->excel_reader->sheets[0];
				$data['numRows'] = $worksheet['numRows']; // ex: 14
				$data['numCols'] = $worksheet['numCols']; // ex: 4
				$data['cells'] = $worksheet['cells']; // the 1st row are usually the field's name
			}
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid'");
			$result = $query->result();
			$data['property'] = $result;

			$query = $this->db->query("SELECT ic_section FROM i_customers GROUP BY ic_section");
			$result = $query->result();
			$data['options'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			if ($alias == '') {
				$ert['title'] = "Customers Import Details";
			}else{
				$ert['title'] = $alias." Import Details";
			}
			$ert['search'] = "false";
			$ert['gid'] = $sess_data['gid'];$ert['mid']=$mid;$ert['mname']=$mname;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/import_mapping', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_product_data($in_id,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$name = '';$con='';
			$name1 ='';$con1='';
			$dt = date('Y-m-d H:i:s');
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
			$btn_array = $this->input->post('btn_array');
			$type = $this->input->post('type');
			// print_r($btn_array);
			$query = $this->db->query("SELECT icem_path FROM i_c_excel_module WHERE icem_id = '$in_id' AND icem_owner ='$oid'");
	 		$result = $query->result(); 

	 		$file = $this->config->item('document_rt').'assets/data/'.$oid.'/'.$result[0]->icem_path;
			$ext = pathinfo($file);
			
			$output="";
			if ($ext['extension'] == 'csv') {
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$array = array();
	
				foreach ($lines as $line) {
					$array['numRows'] = str_getcsv($line);
					$array[] = str_getcsv($line);
				}
				$data['csv'] = $array;
				// print_r($data['csv'][0][$btn_array[0]["multi_d_array"][3]['d_id']]);
				for ($i=1; $i <= count($data['csv']) ; $i++) {
					for ($j=0; $j < count($btn_array); $j++) {
						for ($k=0; $k < count($btn_array[$j]['multi_d_array']); $k++) { 
							if ($btn_array[$j]['p_val'] == 'name' ) {
								if ($data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']]) {
									if ($con == '') {
										$con.=$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con.=' '.$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
									
								}	
							}else{
								if ($data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']]) {
									if ($con1 == '') {
										$con1.=$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con1.=' '.$data['csv'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}
						}
						if ($btn_array[$j]['p_val'] == 'name' ) {
							$data1 = array(
								'ic_name' => $con,
								'ic_owner' => $oid,
								'ic_created' => $dt,
								'ic_created_by' => $uid,
								'ic_section' => $type
							);
							$this->db->insert('i_customers',$data1);
							$insert_id = $this->db->insert_id();
						}
							$data2 = array(
								'icbd_customer_id' => $insert_id,
								'icbd_property' => $btn_array[$j]['p_id'],
								'icbd_value' => $con1
							);
							$this->db->insert('i_c_basic_details',$data2);
						
						$con='';$con1='';
					}
				}
			}else{

				$this->excel_reader->read($file);
				$worksheet = $this->excel_reader->sheets[0];
				$data['cells'] = $worksheet['cells'];
				
				for ($i=2; $i <= count($data['cells']) ; $i++) {
					for ($j=0; $j < count($btn_array); $j++) {
						for ($k=0; $k < count($btn_array[$j]['multi_d_array']); $k++) {
							if ($btn_array[$j]['p_val'] == 'name' ) {
								if (isset($data['cells'][$i][$btn_array[$j]['multi_d_array'][$k]['d_id']])) {
									if ($con == ''){
										$con.=$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}else{
										$con.=' '.$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}else{
								if (isset($data['cells'][$i][$btn_array[$j]['multi_d_array'][$k]['d_id']])) {
									if ($con1 == '') {
										$con1.=$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];	
									}else{
										$con1.=' '.$data['cells'][$i][$btn_array[$j]["multi_d_array"][$k]['d_id']];
									}
								}
							}	
						}
						if ($btn_array[$j]['p_val'] == 'name' ) {
							$data1 = array(
								'ic_name' => $con,
								'ic_owner' => $oid,
								'ic_created' => $dt,
								'ic_created_by' => $uid,
								'ic_section' => $type
							);
							$this->db->insert('i_customers',$data1);
							$insert_id = $this->db->insert_id();
						}
							$data2 = array(
								'icbd_customer_id' => $insert_id,
								'icbd_property' => $btn_array[$j]['p_id'],
								'icbd_value' => $con1
							);
							$this->db->insert('i_c_basic_details',$data2);
						
						$con='';$con1='';$name="";$name1="";
					}
				}
			}	
			$this->db->where('icem_id',$in_id);
			$this->db->delete('i_c_excel_module');
			echo "true";	
		}
	}
########## PRODUCTS & SERVICES ##############

	public function products($mid=null,$code,$p_cat=0) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;$data['gid']=$gid;
			$module = $sess_data['user_mod'];
			$mid =0;$mname='';

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Products') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_pic as b on a.ip_id=b.ipp_pid WHERE ip_owner = '$oid' AND ip_cat_id = '$p_cat' GROUP BY ip_id ");
				$result = $query->result();
				$data['product'] = $result;
				$data['admin'] = 'true';
			}else{
				if ($uid == $oid) {
					$data['admin'] = 'true';
				}else{
					$data['admin'] = 'false';
				}
				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_pic as b on a.ip_id=b.ipp_pid WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_gid = '$gid' AND ip_cat_id = '$p_cat' GROUP BY ip_id ");
				$result = $query->result();
				$data['product'] = $result;
			}

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' AND iproc_pid= '$p_cat' ");
			$result = $query->result();
			$data['cat_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' ");
			$result = $query->result();
			$data['p_cat'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;$ert['code']=$code;
			$ert['user_connection'] = $sess_data['user_connection'];

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/product', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function product_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_gid = '$gid' AND ip_product LIKE '%".$search."%'");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_gid = '$gid' AND iproc_oid = '$oid' AND iproc_name LIKE '%".$search."%'  ");
			$result = $query->result();
			$data['p_cat'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_category($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cname = $this->input->post('cname');
			$pcat = $this->input->post('pcat');

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_name = '$cname' AND iproc_oid = '$oid' AND iproc_gid = '$gid' ");
			$result = $query->result();
			if (count($result) > 0) {
				echo "exist";
			}else{
				if (count($pcat)>0) {
					$p_cat = $pcat[0];
					$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_name = '$p_cat' AND iproc_oid = '$oid' AND iproc_gid = '$gid' ");
					$result = $query->result();
					if (count($result) > 0) {
						$pid = $result[0]->iproc_id;	
					}else{
						$pid = 0;
					}
				}else{
					$pid = 0;
				}
				$data = array(
					'iproc_name' => $cname,
					'iproc_oid' => $oid,
					'iproc_gid' => $gid,
					'iproc_pid' => $pid
				);
				$this->db->insert('i_product_cat',$data);
				$inid = $this->db->insert_id();
				echo $inid;
			}
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function get_child_category($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_product as a left JOIN i_product_pic as b on a.ip_id=b.ipp_pid WHERE ip_owner='$oid' AND ip_gid='$gid' AND ip_cat_id ='$id' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' AND iproc_pid='$id' ");
			$result = $query->result();
			$data['cat_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function cat_doc_upload($code,$pid){
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
					if ($module[$i]->function == 'products') {
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

					$data = array(
						'iproc_img' => $timestamp_value.'.'.$ext
					);
					$this->db->WHERE(array('iproc_oid'=>$oid,'iproc_gid'=>$gid,'iproc_id'=>$pid));
					$this->db->update('i_product_cat', $data);
					$timestamp_value = '';
				}	
				$img_path = '';
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function product_add($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Products') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value");
			$result = $query->result();
			$data['tags'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();
			$data['tax_group'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_units WHERE ipu_owner = '$oid'");
			$result = $query->result();
			$data['units'] = $result;

			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' ");
			$result = $query->result();
			$data['p_cat'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['pro_list'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; $ert['user_connection'] = $sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname." Add";
			}else{
				$ert['title'] = $alias." Add";
			}
			$ert['search'] = "false";
			$ert['gid'] = $gid;$ert['code']=$code;$ert['mid']=$mid;$ert['mname']=$mname;

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/product_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_product($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$module_id = 0;
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Products') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_tags = $this->input->post('tags');
			$pr_units = $this->input->post('units');
			$pr_hsn = $this->input->post('hsn_sac');
			$pr_desc = $this->input->post('desc');
			$pro_list = $this->input->post('pro_list');
			$pro_limit = $this->input->post('p_limit');
			$p_d_qty = $this->input->post('p_d_qty');
			$p_barcode = $this->input->post('p_barcode');
			$p_publish = $this->input->post('p_publish');
			
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$pr_cat = $this->input->post('pcat');
			$cat_id;
			if (count($pr_cat) > 0) {
				$pname = $pr_cat[0];
				$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' AND iproc_name = '$pname' ");
				$result = $query->result();
				if (count($result)>0) {
					$cat_id = $result[0]->iproc_id;
				}else{
					$cat_id = 0;
				}
			}else{
				$cat_id = 0;
			}

			$data = array(
				'ip_product' => $pr_name,
				'ip_section' => 'Products',
				'ip_owner' => $oid,
				'ip_created' => $dt,
				'ip_created_by' => $oid,
				'ip_gid' => $gid,
				'ip_cat_id' => $cat_id,
				'ip_limit' => $pro_limit,
				'ip_default_qty' => $p_d_qty,
				'ip_barcode' => $pro_limit,
				'ip_publish' => $p_publish
			);
			$this->db->insert('i_product', $data);
			$prid = $this->db->insert_id();

			$data = array(
				'ipp_p_id' => $prid,
				'ipp_alias' => $this->input->post('alias'),
				'ipp_cost_price' => $this->input->post('cprice'),
				'ipp_sell_price' => $this->input->post('sprice'),
				'ipp_active_date' => $oid);

			$this->db->insert('i_p_price', $data);
            
            $unt = $pr_units[0];
            
            $quer = $this->db->query("SELECT * FROM i_units WHERE ipu_unit_name = '$unt' AND ipu_owner = '$oid'");
            $resu = $quer->result();
            
            if(count($resu) <= 0) {
                $data = array(
    				'ipu_unit_name' => $unt,
    				'ipu_owner' => $oid,
    				'ipu_created' => $dt,
    				'ipu_created_by' => $oid,
    				
    			);
    			$this->db->insert('i_units', $data);
    			$unit_id = $this->db->insert_id();
            } else {
                $unit_id = $resu[0]->ipu_id;
            }
            
            $deldata = array(
                'ipai_p_id' => $prid,
                'ipai_owner' => $oid
                );
            
            $this->db->where($deldata);
            $this->db->delete('i_p_additional_info');
            
            $data = array(
				'ipai_p_id' => $prid,
				'ipai_hsn_code' => $pr_hsn,
				'ipai_description' => $pr_desc,
				'ipai_unit' => $unit_id,
				'ipai_owner' => $oid,
			);
			$this->db->insert('i_p_additional_info', $data);
		
            $data = array(
				'ipt_p_id' => $prid,
				'ipt_t_id' => $this->input->post('tax'),
				'ipt_oid' => $oid,
				'ipt_created' => $dt,
				'ipt_created_by' => $oid);

			$this->db->insert('i_p_taxes', $data);

			for ($i=0; $i < count($pr_feature) ; $i++) { 
				$tmp_prp = $pr_feature[$i];

				$data1 = array(
					'ipf_product_id' => $prid,
					'ipf_feature' => $tmp_prp);

				$this->db->insert('i_p_features', $data1);
			}

			for ($j=0; $j < count($pr_tags) ; $j++) {
				$tmp_tag = $pr_tags[$j];

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
					'iet_type_id' => $prid,
					'iet_type' => 'products',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			for ($i=0; $i < count($pro_list); $i++) { 
				$data = array(
					'ipcp_p_pid' => $prid,
					'ipcp_c_pid' => $pro_list[$i]['id'],
					'ipcp_owner' => $oid,
					'ipcp_qty' => $pro_list[$i]['qty']
				);
				$this->db->insert('i_p_child_product',$data);
			}

			echo $prid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function product_doc_upload($code,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$module_id = 0;
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'products') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			$query = $this->db->query("SELECT * from i_users WHERE i_uid='$oid'");
			$result = $query->result();
			$cid = $result[0]->i_ref;

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
						'icd_mid' => $module_id,
						'icd_type_id' => $pid,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);

					$data = array(
						'ipp_file' => $file_name,
						'ipp_pid' => $pid,
						'ipp_timestamp' => $timestamp_value.'.'.$ext
					);
					$this->db->insert('i_product_pic', $data);

					$timestamp_value = '';
				}	
				$img_path = '';
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}	
	}

	public function product_details($code,$p_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid='';$mname='';
			$data['activity'] = [];
			$data['invoice'] = [];
			$data['inventory'] = [];
			$data['amc'] = [];
			$data['quotation'] = [];
			$data['purchase'] = [];
			$data['proposal'] = [];
			$data['doc'] = [];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) {
					if ($module[$i]->mname == 'Products') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			if ($uid == $oid) {
				$data['admin'] = 'true';
			}else{
				$query=$this->db->query("SELECT * FROM i_u_modules WHERE ium_m_id = '$mid' AND ium_u_id = '$uid' AND ium_created_by = '$oid' AND ium_gid = '$gid' ");
				$result = $query->result();
				$data['admin'] = $result[0]->ium_admin;
			}

			$query1 = $this->db->query("SELECT * FROM i_product WHERE ip_id = '$p_id'");
			$result1 = $query1->result();
			$data['p_name'] = $result1;
			$data['p_id'] = $result1[0]->ip_id;

			$query2= $this->db->query("SELECT * FROM i_product_pic WHERE ipp_pid = '$p_id'");
			$result2 = $query2->result();
			$data['doc'] = $result2;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a LEFT JOIN i_ext_et_invoice_product_details as b on a.iextein_id = b.iexteinpd_d_id WHERE b.iexteinpd_product_id = '$p_id' AND iextein_gid = '$gid' AND iextein_owner = '$oid'");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['invoice'], $result2[$j]);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id=b.iexteid_e_id WHERE b.iexteid_product_id = '$p_id' AND iextei_owner = '$oid' AND iextei_gid = '$gid'");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['inventory'], $result2[$j]);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_amc as a LEFT JOIN i_ext_et_amc_product_details as b on a.iextamc_id=b.iextamcpd_d_id WHERE b.iextamcpd_product_id = '$p_id' AND iextamc_owner = '$oid' AND iextamc_gid = '$gid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['amc'], $result2[$j]);
			}

			// $query = $this->db->query("SELECT * FROM i_ext_et_quotation as a LEFT JOIN i_ext_et_quotation_product_details as b on a.iexteq_id=b.iexteqpd_d_id WHERE b.iexteqpd_product_id = '$p_id' AND iexteq_owner = '$oid' AND iexteq_gid = '$gid' ");
			// $result2 = $query->result();
			// for ($j=0; $j < count($result2) ; $j++) { 
			// 	array_push($data['quotation'], $result2[$j]);
			// }

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a LEFT JOIN i_ext_et_purchase_product_details as b on a.iextep_id=b.iexteppd_d_id WHERE b.iexteppd_product_id = '$p_id' AND iextep_owner = '$oid' AND iextep_gid = '$gid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['purchase'], $result2[$j]);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a LEFT JOIN i_ext_et_proposal_product_details as b on a.iextepro_id=b.iexteprod_pro_id WHERE iexteprod_product_id = '$p_id' AND iextepro_owner = '$oid' AND iextepro_gid = '$gid' ");
			$result2 = $query->result();
			for ($j=0; $j < count($result2) ; $j++) { 
				array_push($data['proposal'], $result2[$j]);
			}

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
   //          $data['use_modules'] = $query->result();

   //          $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
   //          $result = $query->result();
   //          $data['tags'] = $result;

   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
   //          $result = $query->result();
   //          $data['status'] = $result;

   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
   //          $result = $query->result();
   //          $data['place'] = $result;

   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
   //          $result = $query->result();
   //          $data['cat'] = $result;

   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
   //          $result = $query->result();
   //          $data['user_list'] = $result;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['gid']=$gid;$ert['mid']=$mid;$ert['mname']=$mname;$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = $mname." Details";
			}else{
				$ert['title'] = $alias." Details";
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/product_details', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}	
	}

	public function product_edit($code,$p_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
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
					if ($module[$i]->mname == 'Products') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' ");
			$result = $query->result();
			$data['p_cat'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_product_pic WHERE ipp_pid='$p_id'");
			$result = $query->result();
			$data['products'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();
			$data['tax_group'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_id != '$p_id' ");
			$result = $query->result();
			$data['edit_pro_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_p_child_product WHERE ipcp_owner = '$oid' AND ipcp_p_pid = '$p_id' ");
			$result = $query->result();
			$data['child_pro_list'] = $result;

			if ($uid == $oid) {
				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_cat as b on a.ip_cat_id=b.iproc_id WHERE ip_id='$p_id' AND ip_owner='$oid'");
				$result = $query->result();
				$data['edit_product'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_product_cat as b on a.ip_id=b.iproc_pid WHERE ip_id='$p_id' AND ip_owner='$oid' AND ip_gid = '$gid' ");
				$result = $query->result();
				$data['edit_product'] = $result;
			}
			$data['p_gid'] = $result[0]->ip_gid;
			
			$query = $this->db->query("SELECT * FROM i_units WHERE ipu_owner = '$oid'");
			$result = $query->result();
			$data['units'] = $result;
			
            $query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$p_id' ORDER BY ipp_id DESC");
			$result = $query->result();

			if(count($result) > 0) {
				$cnt = count($result)-1;
				$data['edit_product_alias'] = $result[$cnt]->ipp_alias;
				$data['edit_product_cprice'] = $result[$cnt]->ipp_cost_price;
				$data['edit_product_sprice'] = $result[$cnt]->ipp_sell_price;
			} else {
				$data['edit_product_alias'] = "";
				$data['edit_product_cprice'] = 0;
				$data['edit_product_sprice'] = 0;
			}
			
			$query = $this->db->query("SELECT * FROM i_p_taxes WHERE ipt_p_id='$p_id' AND ipt_oid = '$oid'");
			$result = $query->result();
			$data['edit_product_tax'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_p_features WHERE ipf_product_id='$p_id'");
			$result = $query->result();
			$data['edit_features'] = $result;

			$query = $this->db->query("SELECT * FROM i_p_specification WHERE ips_pid ='$p_id'");
			$result = $query->result();
			$data['edit_sp'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_ext_tags as a LEFT JOIN i_tags as b on a.iet_tag_id = b.it_id WHERE iet_type_id = '$p_id' AND iet_m_id = '$mid' AND it_owner = '$oid' ");
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$query = $this->db->query("SELECT * FROM i_p_additional_info WHERE ipai_p_id = '$p_id' AND ipai_owner = '$oid'");
			$result = $query->result();
			$data['edit_description'] = $result;

			$data['pid'] =$p_id;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname." Edit";	
			}else{
				$ert['title'] = $alias." Edit";
			}
			$ert['search'] = "false";
			$ert['mid']=$mid;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/product_add', $data);
			$this->load->view('home/search_modal');	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_product_details($code,$prid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$sp_arr = $this->input->post('sp_arr');
			$fe_arr = $this->input->post('fe_arr');

			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			for ($i=0; $i < count($fe_arr) ; $i++) { 
				$tmp_prp = $fe_arr[$i];
				$data1 = array(
					'ipf_product_id' => $prid,
					'ipf_feature' => $tmp_prp);

				$this->db->insert('i_p_features', $data1);
			}

			$this->db->where('ips_pid', $prid);
			$this->db->delete('i_p_specification');

			for ($i=0; $i < count($sp_arr) ; $i++) { 
				$prp_name = $sp_arr[$i]['name'];
				$prp_cat = $sp_arr[$i]['cat'];

				$data1 = array(
					'ips_pid' => $prid,
					'ips_cat' => $prp_cat,
					'ips_val' => $prp_name
				);
				$this->db->insert('i_p_specification', $data1);
			}

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function update_product($prid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_spsf = $this->input->post('p_spsf');
			$pr_tags = $this->input->post('tags');
			$pr_units = $this->input->post('units');
			$pr_hsn = $this->input->post('hsn_sac');
			$pr_desc = $this->input->post('desc');
			$pro_list = $this->input->post('pro_list');
			$pro_limit = $this->input->post('p_limit');
			$p_d_qty = $this->input->post('p_d_qty');
			$p_barcode = $this->input->post('p_barcode');
			$p_publish = $this->input->post('p_publish');

			$dt = date('Y-m-d H:i:s');
            
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Products') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$pr_cat = $this->input->post('pcat');
			$cat_id;
			if (count($pr_cat) > 0) {
				$pname = $pr_cat[0];
				$query = $this->db->query("SELECT * FROM i_product_cat WHERE iproc_oid = '$oid' AND iproc_gid = '$gid' AND iproc_name = '$pname' ");
				$result = $query->result();
				if (count($result)>0) {
					$cat_id = $result[0]->iproc_id;
				}else{
					$cat_id = 0;
				}
			}else{
				$cat_id = 0;
			}

			$data = array(
				'ip_product' => $pr_name,
				'ip_modified' => $dt,
				'ip_modified_by' => $oid,
				'ip_cat_id' => $cat_id,
				'ip_limit' => $pro_limit,
				'ip_default_qty' => $p_d_qty,
				'ip_barcode' => $pro_limit,
				'ip_publish' => $p_publish
			);
			$this->db->where('ip_id', $prid);
			$this->db->update('i_product', $data);

			$unt = $pr_units[0];
            
            echo $unt;
            
            $quer = $this->db->query("SELECT * FROM i_units WHERE ipu_unit_name = '$unt' AND ipu_owner = '$oid'");
            $resu = $quer->result();
            
            if(count($resu) <= 0) {
                $data = array(
    				'ipu_unit_name' => $unt,
    				'ipu_owner' => $oid,
    				'ipu_created' => $dt,
    				'ipu_created_by' => $oid
    			);
    			$this->db->insert('i_units', $data);
    			$unit_id = $this->db->insert_id();
            } else {
                $unit_id = $resu[0]->ipu_id;
            }
            
            $deldata = array(
                'ipai_p_id' => $prid,
                'ipai_owner' => $oid
                );
            
            $this->db->where($deldata);
            $this->db->delete('i_p_additional_info');
            
            $data = array(
				'ipai_p_id' => $prid,
				'ipai_hsn_code' => $pr_hsn,
				'ipai_description' => $pr_desc,
				'ipai_unit' => $unit_id,
				'ipai_owner' => $oid,
			);
			$this->db->insert('i_p_additional_info', $data);
		
            $this->db->where('ipp_p_id', $prid);
			$this->db->delete('i_p_price');

			$data = array(
				'ipp_p_id' => $prid,
				'ipp_alias' => $this->input->post('alias'),
				'ipp_cost_price' => $this->input->post('cprice'),
				'ipp_sell_price' => $this->input->post('sprice'),
				'ipp_active_date' => $oid);
			$this->db->insert('i_p_price', $data);

			$this->db->where('ipt_p_id', $prid);
			$this->db->delete('i_p_taxes');

			$data = array(
				'ipt_p_id' => $prid,
				'ipt_t_id' => $this->input->post('tax'),
				'ipt_oid' => $oid,
				'ipt_created' => $dt,
				'ipt_created_by' => $oid);
			$this->db->insert('i_p_taxes', $data);

			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			for ($i=0; $i < count($pr_feature) ; $i++) { 
				$tmp_prp = $pr_feature[$i];

				$data1 = array(
					'ipf_product_id' => $prid,
					'ipf_feature' => $tmp_prp);

				$this->db->insert('i_p_features', $data1);
			}

			$this->db->where('ips_pid', $prid);
			$this->db->delete('i_p_specification');

			for ($i=0; $i < count($pr_spsf) ; $i++) { 
				$prp_name = $pr_spsf[$i]['name'];
				$prp_cat = $pr_spsf[$i]['cat'];

				$data1 = array(
					'ips_pid' => $prid,
					'ips_cat' => $prp_cat,
					'ips_val' => $prp_name
				);
				$this->db->insert('i_p_specification', $data1);
			}

			$this->db->WHERE('iet_type_id',$prid);
			$this->db->delete('i_ext_tags');
			
			for ($j=0; $j < count($pr_tags) ; $j++) { 
				$tmp_tag = $pr_tags[$j];

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
					'iet_type_id' => $prid,
					'iet_type' => 'products',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			$this->db->WHERE(array('ipcp_p_pid' => $prid , 'ipcp_owner' => $oid ));
			$this->db->delete('i_p_child_product');

			for ($i=0; $i < count($pro_list); $i++) { 
				$data = array(
					'ipcp_p_pid' => $prid,
					'ipcp_c_pid' => $pro_list[$i]['id'],
					'ipcp_owner' => $oid,
					'ipcp_qty' => $pro_list[$i]['qty']
				);
				$this->db->insert('i_p_child_product',$data);
			}

			echo $prid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_product($code,$prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
            $oid = $sess_data['user_details'][0]->i_owner;
            $uid = $sess_data['user_details'][0]->i_uid;
            
			$this->db->where('ip_id', $prid);
			$this->db->delete('i_product');

			$this->db->where('ipp_p_id',$prid);
			$this->db->delete('i_p_price');

			
			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			$data = array('ipft_owner' => $oid, 'ipft_product_id' => $prid );
			$this->db->where($data);
			$this->db->delete('i_p_f_tags');

			redirect(base_url().'Enterprise/products/0/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function product_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ip_modified' => $dt,
				'ip_modified_by' => $oid,
				'ip_gid' => $gid,
				'ip_cat_id' => 0
			);
			$this->db->where('ip_id', $pid);
			$this->db->update('i_product', $data);

			echo "true";
		}else{
			redirect(base_url().'Account/login');	
		}
	}
#################################################################

	public function services() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Services'");
			$result = $query->result();

			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Services";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/service', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function service_search() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$search = $this->input->post('search');
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Services' AND ip_product LIKE '%".$search."%'");
			$result = $query->result();

			$data['product'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function service_add() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Service Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/service_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_service() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_tags = $this->input->post('tags');
			$dt = date('Y-m-d H:i:s');

			$dt1 = date('Y-m-d');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ip_product' => $pr_name,
				'ip_section' => 'Services',
				'ip_owner' => $oid,
				'ip_created' => $dt,
				'ip_created_by' => $oid );

			$this->db->insert('i_product', $data);
			$prid = $this->db->insert_id();

			$data = array(
				'ipp_p_id' => $prid,
				'ipp_alias' => $this->input->post('alias'),
				'ipp_cost_price' => $this->input->post('cprice'),
				'ipp_sell_price' => $this->input->post('sprice'),
				'ipp_active_date' => $oid);

			$this->db->insert('i_p_price', $data);

			for ($i=0; $i < count($pr_feature) ; $i++) { 
				$tmp_prp = $pr_feature[$i];

				$data1 = array(
					'ipf_product_id' => $prid,
					'ipf_feature' => $tmp_prp);

				$this->db->insert('i_p_features', $data1);
			}

			for ($j=0; $j < count($pr_tags) ; $j++) { 
				$tmp_tag = $pr_tags[$j];

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
					'ipft_product_id' => $prid,
					'ipft_tag_id' => $tid,
					'ipft_owner' => $owner);

				$this->db->insert('i_p_f_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function service_edit($p_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_id='$p_id' AND ip_owner='$oid' AND ip_section='Services'");
			$result = $query->result();

			$data['edit_product'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$p_id' ORDER BY ipp_id DESC");
			$result = $query->result();

			$data['edit_product_alias'] = $result[0]->ipp_alias;
			$data['edit_product_cprice'] = $result[0]->ipp_cost_price;
			$data['edit_product_sprice'] = $result[0]->ipp_sell_price;

			
			$query = $this->db->query("SELECT * FROM i_p_features WHERE ipf_product_id='$p_id'");
			$result = $query->result();

			$data['edit_features'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_p_f_tags WHERE ipft_product_id = '$p_id'");
			$result = $query->result();

			$data['edit_preferences'] = $result;

			$data['pid'] =$p_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Services Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/service_add', $data);
			$this->load->view('home/search_modal');	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_service($prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_tags = $this->input->post('tags');
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ip_product' => $pr_name,
				'ip_modified' => $dt,
				'ip_modified_by' => $oid );

			$this->db->where('ip_id', $prid);
			$this->db->update('i_product', $data);

			$data = array(
				'ipp_p_id' => $prid,
				'ipp_alias' => $this->input->post('alias'),
				'ipp_cost_price' => $this->input->post('cprice'),
				'ipp_sell_price' => $this->input->post('sprice'),
				'ipp_active_date' => $oid);

			$this->db->insert('i_p_price', $data);

			
			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			for ($i=0; $i < count($pr_feature) ; $i++) { 
				$tmp_prp = $pr_feature[$i];

				$data1 = array(
					'ipf_product_id' => $prid,
					'ipf_feature' => $tmp_prp);

				$this->db->insert('i_p_features', $data1);
			}

			$this->db->where('ipft_product_id', $prid);
			$this->db->delete('i_p_f_tags');
			
			for ($j=0; $j < count($pr_tags) ; $j++) { 
				$tmp_tag = $pr_tags[$j];

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
					'ipft_product_id' => $prid,
					'ipft_tag_id' => $tid);

				$this->db->insert('i_p_f_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_service($prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

            $oid = $sess_data['user_details'][0]->i_uid;

			$this->db->where('ip_id', $prid);
			$this->db->delete('i_product');

			$this->db->where('ipp_p_id',$prid);
			$this->db->delete('i_p_price');

			
			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			$this->db->where('ipft_product_id', $prid);
			$this->db->delete('i_p_f_tags');

			redirect(base_url().'Enterprise/services');
		} else {
			redirect(base_url().'Account/login');
		}
	}
########## INVENTORY ################
	public function inventory($mod_id=null,$code) {
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
					if ($module[$i]->function == 'inventory') {
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
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/inventory', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
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

######################### inventory spare #############################
	public function inventory_spare($code,$mid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$ert['oid'] = $oid;
			$ert['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->function == 'inventory') {
					$mod_id = $module[$i]->mid;
					$dom = $module[$i]->domain;
					$alias = $module[$i]->m_alias;
					break;
				}
			}
			$pro_id;
			$pro_list = [];
			$que = $this->db->query("SELECT iexteid_product_id FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' GROUP BY iexteid_product_id");
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
				array_push($pro_list, array('pid' => $pro_id, 'bal' => $bal ));
			}
			$data['product_list'] = $pro_list;

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type = 'spare' ORDER BY iextei_id DESC ");
			$result = $que->result();
			if (count($result) > 0 ) {
				$data['doc_id'] = $result[0]->iextei_txn_id + 1 ;
			}else{
				$data['doc_id'] = 1 ;
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$data['product'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name IS NOT NULL ");
			$data['cust_list'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
   //          $data['use_modules'] = $query->result();

   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
   //          $result = $query->result();
   //          $data['status'] = $result;

   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
   //          $result = $query->result();
   //          $data['place'] = $result;

   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
   //          $result = $query->result();
   //          $data['cat'] = $result;

   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
   //          $result = $query->result();
   //          $data['user_list'] = $result;

			$ert['search'] = "false";
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['mname'] = 'Inventory';$ert['mid']=$mod_id;$ert['code']=$code;$ert['gid']=$gid;
			if ($alias == '') {
				$ert['title'] = "Inventory Spare";
			}else{
				$ert['title'] = $alias." Spare";
			}
			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/inventory_spare',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function product_bal_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$p_name = $this->input->post('p_name');
			$pid = 0;
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$p_name' AND ip_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$pid = $result[0]->ip_id;	
			}

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('inward') AND iextei_owner = '$oid' AND iextei_fid = '$oid' AND iexteid_product_id = '$pid' ORDER BY iextei_id DESC");
			$result = $que->result();
			$def_ret_pid = [];
			$def_ret_sn = [];
			for ($i=0; $i <count($result) ; $i++) {
				$pro_id = $result[$i]->iexteid_product_id;
				$pro_sn = $result[$i]->iexteid_serial_number;
				$sid = $result[$i]->iexteid_id;
				$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('spare','outward') AND  iextei_owner = '$oid' AND iextei_fid = '$oid' AND iexteid_product_id = '$pid' ORDER BY iextei_id DESC");
				$res = $que->result();
				if (count($res) > 0 ) {
					for ($j=0; $j < count($res) ; $j++) {
						$spid = $res[$j]->iexteid_product_id;
						$spsn = $res[$j]->iexteid_serial_number;
						if ($pro_id == $spid && $pro_sn == $spsn ) {
							array_push($def_ret_pid, $res[$j]->iexteid_id);
							array_push($def_ret_pid, $sid);
						}
					}
				}
			}
			$r_pid = 0;
			if (count($def_ret_pid) > 0 ) {
				$r_pid = implode(',', $def_ret_pid);
			}else{
				$r_pid = 0;
			}

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iexteid_id NOT IN ($r_pid) AND  iextei_owner = '$oid' AND iextei_fid = '$oid' AND iexteid_product_id = '$pid' ORDER BY iextei_id DESC");
			$result = $que->result();
			$data['balance_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}	

	public function emp_spare_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$e_name = $this->input->post('e_name');
			$cid = 0;
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$e_name' AND ic_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;
			}
			$def_ret_sn = [];
			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_customer_id = $cid OR iextei_fid = $cid AND iextei_owner = '$oid' ORDER BY iextei_id ASC");
			$result = $que->result();
			for ($i=0; $i <count($result) ; $i++) {
				$pro_id = $result[$i]->iexteid_product_id;
				$pro_qty = $result[$i]->iexteid_balance;
				$pro_sn = $result[$i]->iexteid_serial_number;
				$sid = $result[$i]->iexteid_e_id;
				$type = $result[$i]->iextei_type;
				$date = $result[$i]->iextei_txn_date;
				$pname = $result[$i]->ip_product;

				if ($type == 'spare' && $cid == $result[$i]->iextei_customer_id && $pro_id != '' ) {
					if ($pro_sn != '' ) {
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1' ));
					}else{
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => $pro_qty ));
					}
				}else if ($type == 'def_return') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) {
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'spare' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}	
					}
				}else if ($type == 'defective' && $cid == $result[$i]->iextei_customer_id && $pro_id != '') {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));
				}else if ($type == 'def_sys') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) { 
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'defective' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}
					}
				}else if ($type == 'not_defective' && $cid == $result[$i]->iextei_customer_id && $pro_id != '') {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));

				}else if ($type == 'not_def_ret') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) { 
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'spare' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}
					}
				}
				$def_ret_sn = array_values($def_ret_sn);
				// print_r($def_ret_sn);
			}
			$data['defective_list'] = array_values($def_ret_sn);
			$data['c_name'] = $e_name;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function emp_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$e_name = $this->input->post('e_name');
			$cid = 0;
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$e_name' AND ic_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;	
			}
			$def_ret_sn = [];
			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_customer_id = $cid OR iextei_fid = $cid AND iextei_owner = '$oid' ORDER BY iextei_id ASC");
			$result = $que->result();
			for ($i=0; $i <count($result) ; $i++) {
				$pro_id = $result[$i]->iexteid_product_id;
				$pro_sn = $result[$i]->iexteid_serial_number;
				$pro_qty = $result[$i]->iexteid_balance;
				$sid = $result[$i]->iexteid_id;
				$type = $result[$i]->iextei_type;
				$date = $result[$i]->iextei_txn_date;
				$pname = $result[$i]->ip_product;
				if ($type == 'spare' && $cid == $result[$i]->iextei_customer_id ) {
					if ($pro_sn != '') {
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));	
					}else{
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => $pro_qty));
					}
				}
				if ($type == 'def_return') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) {
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'spare' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}	
					}
				}
				if ($type == 'defective' && $cid == $result[$i]->iextei_customer_id ) {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));	
				}
				if ($type == 'def_sys') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) { 
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'defective' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}
					}
				}
				if ($type == 'not_defective' && $cid == $result[$i]->iextei_customer_id ) {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => $pro_qty));
				}
				if ($type == 'not_def_ret') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) { 
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'not_defective' && $def_ret_sn[$j]['qty'] != '0' ) {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}
					}
				}
				$def_ret_sn = array_values($def_ret_sn);
			}
			$data['spare_list'] = array_values($def_ret_sn);
			$data['c_name'] = $e_name;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function add_spare_defective($code,$sid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$cid = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_id = '$sid' AND iextei_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->iextei_customer_id;

				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = $oid AND iextei_type = 'def_sys' ");
				$res = count($query->result());
				$data = array(
					'iextei_customer_id' => $cid,
					'iextei_txn_id' => $res + 1,
					'iextei_txn_date' => $dt,
					'iextei_type' => 'def_sys',
					'iextei_owner' => $oid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_gid' => $gid,
					'iextei_fid' => $oid
				);
				$this->db->insert('i_ext_et_inventory', $data);
				$inid = $this->db->insert_id();
				
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_e_id = '$sid' AND iexteid_owner = '$oid' ");
				$result = $query->result();
				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $result[0]->iexteid_product_id,
					'iexteid_inward' => 0,
					'iexteid_outward' => 0,
					'iexteid_balance' => 1,
					'iexteid_owner' => $oid,
					'iexteid_serial_number' => $result[0]->iexteid_serial_number );
				$this->db->insert('i_ext_et_inventory_details', $data);
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function cust_pro_details($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mod_id=0;$dom='';
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->function == 'inventory') {
					$mod_id = $module[$i]->mid;
					$dom = $module[$i]->domain;
					break;
				}
			}

			$e_name = $this->input->post('e_name');
			$cid = 0;
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$e_name' AND ic_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->ic_id;	
			}
			$data['spare_list'] = [];

			$def_ret_sn = [];
			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_customer_id = $cid OR iextei_fid = $cid AND iextei_owner = '$oid' ORDER BY iextei_id ASC");
			$result = $que->result();
			for ($i=0; $i <count($result) ; $i++) {
				$pro_id = $result[$i]->iexteid_product_id;
				$pro_sn = $result[$i]->iexteid_serial_number;
				$pro_qty = $result[$i]->iexteid_balance;
				$sid = $result[$i]->iexteid_id;
				$type = $result[$i]->iextei_type;
				$date = $result[$i]->iextei_txn_date;
				$pname = $result[$i]->ip_product;
				if ($type == 'outward' ) {
					if ($pro_sn != '') {
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));	
					}else{
						array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => $pro_qty));
					}
				}
				if ($type == 'defective') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) {
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'outward') {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}	
					}
				}
				if ($type == 'def_return') {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => '1'));	
				}
				if ($type == 'not_defective') {
					if (count($def_ret_sn) > 0) {
						for ($j=0; $j < count($def_ret_sn)  ; $j++) {
							if ($def_ret_sn[$j]['pid'] == $pro_id && $def_ret_sn[$j]['sn'] == $pro_sn ) {
								if ($def_ret_sn[$j]['sn'] != '') {
									unset( $def_ret_sn[$j] );
									break;
								}else{
									if ($def_ret_sn[$j]['type'] == 'def_return') {
										$qty = intval($def_ret_sn[$j]['qty']) - 1 ;
										$def_ret_sn[$j]['qty'] = $qty;
										break;
									}
								}
							}
						}
					}
				}
				if ($type == 'not_def_ret') {
					array_push($def_ret_sn, array('pid' => $pro_id, 'pname' => $pname, 'date' => $date, 'inid' => $sid ,'sn' => $pro_sn , 'type' => $type , 'qty' => $pro_qty));
				}
				$def_ret_sn = array_values($def_ret_sn);
			}
			$data['spare_list'] = array_values($def_ret_sn);
			// $que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('outward','def_return','not_def_ret') AND iextei_owner = '$oid' AND iextei_fid = '$oid' AND iextei_customer_id = '$cid' ORDER BY iextei_id DESC");
			// $result = $que->result();
			// $def_ret_pid = [];
			// $def_ret_sn = [];
			// for ($i=0; $i <count($result) ; $i++) {
			// 	$pro_id = $result[$i]->iexteid_product_id;
			// 	$pro_sn = $result[$i]->iexteid_serial_number;
			// 	$sid = $result[$i]->iexteid_id;
			// 	$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('defective') AND  iextei_owner = '$oid' AND iextei_fid = '$cid' ORDER BY iextei_id DESC");
			// 	$res = $que->result();
			// 	if (count($res) > 0 ) {
			// 		for ($j=0; $j < count($res) ; $j++) {
			// 			$spid = $res[$j]->iexteid_product_id;
			// 			$spsn = $res[$j]->iexteid_serial_number;
			// 			if ($pro_id == $spid && $pro_sn == $spsn ) {
			// 				array_push($def_ret_pid, $res[$j]->iexteid_id);
			// 				array_push($def_ret_pid, $sid);
			// 			}
			// 		}
			// 	}
			// }
			// if (count($def_ret_pid) > 0 ) {
			// 	$r_pid = implode(',', $def_ret_pid);
			// }else{
			// 	$r_pid = 0;
			// }
			// $que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iexteid_id NOT IN ($r_pid) AND  iextei_owner = '$oid' AND iextei_customer_id = '$cid' ORDER BY iextei_id DESC");
			// $result = $que->result();
			// $data['spare_list'] = $result;
			$data['txn_details'] = [];
			// $p_array = [];
			// for ($i=0; $i < count($result) ; $i++) { 
			// 	if ($result[$i]->iextei_type == 'outward' || $result[$i]->iextei_type == 'def_return' || $result[$i]->iextei_type == 'not_def_ret' ) {
			// 		array_push($p_array, array('pid' => $result[$i]->iexteid_product_id , 'sn' => $result[$i]->iexteid_serial_number ));
			// 	}
			// }

			for ($i=0; $i < count($def_ret_sn) ; $i++) {
				$pid = $def_ret_sn[$i]['pid'];
				$sn = $def_ret_sn[$i]['sn'];
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a left join i_ext_et_invoice_product_details as b on a.iextein_id = b.iexteinpd_d_id WHERE iextein_owner = '$oid' AND iextein_customer_id = '$cid' AND iexteinpd_product_id = '$pid' AND iexteinpd_serial_number = '$sn' ");
				$result = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_amc as a LEFT JOIN i_ext_et_amc_product_details as b on a.iextamc_id = b.iextamcpd_d_id WHERE iextamc_customer_id = '$cid' AND iextamc_owner = '$oid' AND iextamc_gid = '$gid' AND iextamcpd_product_id = '$pid' AND iextamcpd_serial_number = '$sn' ");
				$res = $query->result();
				if (count($res) > 0 ) {
					$amcid = $res[0]->iextamc_id;
				}else{
					$amcid = 0;
				}
				for ($j=0; $j < count($result) ; $j++) {
					array_push($data['txn_details'], array('pid' => $pid, 'sn' => $sn ,'date' => $result[$j]->iextein_txn_date, 'warranty' => $result[$j]->iextein_warranty , 'inid' => $result[$j]->iextein_id , 'amc_id' => $amcid ));
				}
			}

			for ($i=0; $i < count($def_ret_sn) ; $i++) {
				$pid = $def_ret_sn[$i]['pid'];
				$sn = $def_ret_sn[$i]['sn'];

				$query = $this->db->query("SELECT * FROM i_ext_et_inventory_replacement WHERE iexteir_owner = '$oid' AND iexteir_to_pid = '$pid' AND iexteir_to_serial_number = '$sn' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$t_pid = $result[0]->iexteir_from_pid;
					$t_sn = $result[0]->iexteir_from_serial_number;
					$que = $this->db->query("SELECT * FROM i_ext_et_invoice as a left join i_ext_et_invoice_product_details as b on a.iextein_id = b.iexteinpd_d_id WHERE iextein_owner = '$oid' AND iextein_customer_id = '$cid' AND iexteinpd_product_id = '$t_pid' AND iexteinpd_serial_number = '$t_sn' ");
					$res = $que->result();

					$query = $this->db->query("SELECT * FROM i_ext_et_amc as a LEFT JOIN i_ext_et_amc_product_details as b on a.iextamc_id = b.iextamcpd_d_id WHERE iextamc_customer_id = '$cid' AND iextamc_owner = '$oid' AND iextamc_gid = '$gid' AND iextamcpd_product_id = '$pid' AND iextamcpd_serial_number = '$sn' ");
					$res1 = $query->result();
					if (count($res1) > 0 ) {
						$amcid = $res1[0]->iextamc_id;
					}else{
						$amcid = 0;
					}

					for ($j=0; $j < count($res) ; $j++) {
						array_push($data['txn_details'], array('pid' => $pid, 'sn' => $sn ,'date' => $res[$j]->iextein_txn_date , 'warranty' => $res[$j]->iextein_warranty ,'inid' => $res[$j]->iextein_id , 'amc_id' => $amcid ));
					}
				}
			}
			$que = $this->db->query("SELECT * FROM i_ext_support WHERE ies_cid = '$cid' AND ies_owner = '$oid' ORDER BY ies_id DESC ");
			$result = $que->result();
			$data['comp_list'] = $result;

			$data['c_name'] = $e_name;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_invoice_details($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$pro_det = $this->input->post('pro_det');
			for ($i=0; $i < count($pro_det) ; $i++) { 
				if ($pro_det[$i]['id'] == $inid ) {
					$invoice_id = $pro_det[$i]['inid'];
					$amc_id = $pro_det[$i]['amc_id'];
					break;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a LEFT JOIN i_ext_et_invoice_product_details as b on a.iextein_id = b.iexteinpd_d_id WHERE iextein_id = '$invoice_id' ");
			$res = $query->result();
			$data['in_det'] = $res;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc as a LEFT JOIN i_ext_et_amc_product_details as b on a.iextamc_id = b.iextamcpd_d_id WHERE iextamc_id = '$amc_id'");
			$res = $query->result();
			$data['sub_det'] = $res;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_purchase_details($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a LEFT JOIN i_ext_et_purchase_product_details as b on a.iextep_id = b.iexteppd_d_id WHERE iextep_id = '$inid' ");
			$res = $query->result();
			$data['in_det'] = $res;
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function replace_spare_inventory($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Inventory') {
					$in_mid = $module[$i]->mid;
					break;
				}
			}

			$cname = $this->input->post('cust_name');
			$ename = $this->input->post('emp_name');
			$sel_data = $this->input->post('sel_data');
			$c_tkt = $this->input->post('sel_c_tkt');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$ename' AND ic_owner = '$oid'");
			$result = $query->result();
			$eid = $result[0]->ic_id;

			for ($i=0; $i < count($sel_data) ; $i++) {
				if ($sel_data[$i]['flg'] == 'true' ) {
					$type1 = 'defective';
					$type2 = 'def_return';
				}else{
					$type1 = 'not_defective';
					$type2 = 'not_def_ret';
				}
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = $oid AND iextei_type = '$type1' ");
				$result = count($query->result());
				$data = array(
					'iextei_customer_id' => $eid,
					'iextei_txn_id' => $result + 1,
					'iextei_txn_date' => $dt,
					'iextei_type' => $type1,
					'iextei_owner' => $oid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_gid' => $gid,
					'iextei_fid' => $cid,
					'iextei_ticket_id' => $c_tkt[0]
				);
				$this->db->insert('i_ext_et_inventory', $data);
				$inid = $this->db->insert_id();

				$sinid = $sel_data[$i]['c_r_id'];
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_id = '$sinid' AND iexteid_owner = '$oid' ");
				$result = $query->result();
				$fpid = $result[0]->iexteid_product_id;
				$fsn = $result[0]->iexteid_serial_number;
				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $fpid,
					'iexteid_inward' => 0,
					'iexteid_outward' => 0,
					'iexteid_amount' => $sel_data[$i]['amt'],
					'iexteid_balance' => 1,
					'iexteid_owner' => $oid,
					'iexteid_serial_number' => $fsn );
				$this->db->insert('i_ext_et_inventory_details', $data);

				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = $oid AND iextei_type = '$type2' ");
				$invoice_txn_id = count($query->result()) + 1;
				$data = array(
					'iextei_customer_id' => $cid,
					'iextei_txn_id' => $invoice_txn_id,
					'iextei_txn_date' => $dt,
					'iextei_type' => $type2,
					'iextei_owner' => $oid,
					'iextei_created' => $dt,
					'iextei_created_by' => $uid,
					'iextei_gid' => $gid,
					'iextei_fid' => $eid,
					'iextei_ticket_id' => $c_tkt[0]
				);
				$this->db->insert('i_ext_et_inventory', $data);
				$inid = $this->db->insert_id();

				$sinid = $sel_data[$i]['e_r_id'];
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_id = '$sinid' AND iexteid_owner = '$oid' ");
				$result = $query->result();
				$tpid = $result[0]->iexteid_product_id;
				$tsn = $result[0]->iexteid_serial_number;
				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $tpid,
					'iexteid_inward' => 0,
					'iexteid_amount' => $sel_data[$i]['amt'],
					'iexteid_outward' => 0,
					'iexteid_balance' => 1,
					'iexteid_owner' => $oid,
					'iexteid_serial_number' => $tsn );
				$this->db->insert('i_ext_et_inventory_details', $data);


				if ($type1 == 'defective') {
					$data = array(
						'iexteir_from_pid' => $fpid,
						'iexteir_from_serial_number' => $fsn,
						'iexteir_to_pid' => $tpid,
						'iexteir_to_serial_number' => $tsn,
						'iexteir_created' => $dt,
						'iexteir_created_by' => $uid,
						'iexteir_owner' => $oid
					);
					$this->db->insert('i_ext_et_inventory_replacement', $data);	
				}
			}

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

######################### inventory defective #############################

	public function inventory_defective($code,$mid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$ert['oid'] = $oid;
			$ert['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->function == 'inventory') {
					$mod_id = $module[$i]->mid;
					$dom = $module[$i]->domain;
					$alias = $module[$i]->m_alias;
					break;
				}
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name IS NOT NULL ");
			$data['cust_list'] = $query->result();

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('def_sys') AND iextei_owner = '$oid' AND iextei_fid = '$oid' ORDER BY iextei_id DESC");
			$result = $que->result();
			$def_sys_arr = [];
			for ($i=0; $i < count($result) ; $i++) { 
				array_push($def_sys_arr, array('pid' => $result[$i]->iexteid_product_id , 'sn' => $result[$i]->iexteid_serial_number , 'inid' => $result[$i]->iexteid_id , 'qty' => '1' ) );
			}
			$def_ret_pid = [];
			$def_ret_sn = [];
			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('def_out','repaired') AND  iextei_owner = '$oid' AND iextei_fid = '$oid' ORDER BY iextei_id DESC");
			$res = $que->result();
			$def_out_arr = [] ;
			for ($i=0; $i < count($res) ; $i++) {
				array_push($def_out_arr, array('pid' => $res[$i]->iexteid_product_id , 'sn' => $res[$i]->iexteid_serial_number , 'inid' => $res[$i]->iexteid_id , 'qty' => '1' ) );
			}

			for ($i=0; $i < count($def_out_arr) ; $i++) { 
				for ($j=0; $j < count($def_sys_arr) ; $j++) { 
					if ($def_out_arr[$i]['pid'] == $def_sys_arr[$j]['pid'] && $def_out_arr[$i]['sn'] == $def_sys_arr[$j]['sn'] && $def_sys_arr[$j]['qty'] != '0' ) {
						array_push($def_ret_pid, $def_sys_arr[$j]['inid']);
						$def_sys_arr[$j]['qty'] = '0';
						break;
					}
				}
			}
			// print_r($def_sys_arr);
			// for ($i=0; $i <count($result) ; $i++) {
			// 	$pro_id = $result[$i]->iexteid_product_id;
			// 	$pro_sn = $result[$i]->iexteid_serial_number;
			// 	$sid = $result[$i]->iexteid_id;
			// 	$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('def_out','repaired') AND  iextei_owner = '$oid' AND iextei_fid = '$oid' ORDER BY iextei_id DESC");
			// 	$res = $que->result();
			// 	if (count($res) > 0 ) {
			// 		for ($j=0; $j < count($res) ; $j++) {
			// 			$spid = $res[$j]->iexteid_product_id;
			// 			$spsn = $res[$j]->iexteid_serial_number;
			// 			if ($pro_id == $spid && $pro_sn == $spsn) {
			// 				array_push($def_ret_pid, $sid);
			// 			}
			// 		}
			// 	}
			// }
			if (count($def_ret_pid) > 0 ) {
				$r_pid = implode(',', $def_ret_pid);	
			}else{
				$r_pid = 0;
			}

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id LEFT JOIN i_customers as d on a.iextei_customer_id = d.ic_id WHERE iextei_owner = '$oid' AND iextei_type = 'def_sys' AND iextei_fid = '$oid' AND iexteid_id NOT IN ($r_pid) ORDER BY iextei_id DESC");
			$result = $que->result();
			$data['def_sys'] = $result;

			$p_array = [];
			for ($i=0; $i < count($result) ; $i++) { 
				array_push($p_array, array('pid' => $result[$i]->iexteid_product_id , 'sn' => $result[$i]->iexteid_serial_number ));
			}
			$data['txn_details'] = [];
			for ($i=0; $i < count($p_array) ; $i++) {
				$pid = $p_array[$i]['pid'];
				$sn = $p_array[$i]['sn'];
				$que = $this->db->query("SELECT * FROM i_ext_et_purchase as a left join i_ext_et_purchase_product_details as b on a.iextep_id = b.iexteppd_d_id WHERE iextep_owner = '$oid' AND iexteppd_product_id = '$pid' AND iexteppd_serial_number = '$sn' ");
				$res = $que->result();
				for ($j=0; $j < count($res) ; $j++) {
					array_push($data['txn_details'], array('pid' => $pid, 'sn' => $sn ,'date' => $res[$j]->iextep_txn_date , 'warranty' => $res[$j]->iextep_warranty ,'inid' => $res[$j]->iextep_id ));
				}
			}

			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('def_out') AND iextei_owner = '$oid' AND iextei_fid = '$oid' ORDER BY iextei_id DESC");
			$result = $que->result();
			$def_ret_pid = [];
			$def_ret_sn = [];
			for ($i=0; $i <count($result) ; $i++) {
				$pro_id = $result[$i]->iexteid_product_id;
				$pro_sn = $result[$i]->iexteid_serial_number;
				$sid = $result[$i]->iexteid_id;
				$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_type IN ('def_in') AND  iextei_owner = '$oid' AND iextei_fid = '$oid' ORDER BY iextei_id DESC");
				$res = $que->result();
				if (count($res) > 0 ) {
					for ($j=0; $j < count($res) ; $j++) {
						$spid = $res[$j]->iexteid_product_id;
						$spsn = $res[$j]->iexteid_serial_number;
						if ($pro_id == $spid && $pro_sn == $spsn ) {
							if ($sid != '') {
								array_push($def_ret_pid, $sid);
							}
							if ($res[$j]->iexteid_id) {
								array_push($def_ret_pid, $res[$j]->iexteid_id);
							}
						}
					}
				}
			}
			if (count($def_ret_pid) > 0 ) {
				$r_pid = implode(',', $def_ret_pid);	
			}else{
				$r_pid = 0;
			}
			$que = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id LEFT JOIN i_customers as d on a.iextei_customer_id = d.ic_id WHERE iextei_owner = '$oid' AND iextei_type = 'def_out' AND iextei_fid = '$oid' AND iexteid_id NOT IN ($r_pid) ORDER BY iextei_id DESC");
			$data['def_out'] = $que->result();

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
   //          $data['use_modules'] = $query->result();

   //          $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
   //          $result = $query->result();
   //          $data['tags'] = $result;

   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
   //          $result = $query->result();
   //          $data['status'] = $result;

   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
   //          $result = $query->result();
   //          $data['place'] = $result;

   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
   //          $result = $query->result();
   //          $data['cat'] = $result;

   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
   //          $result = $query->result();
   //          $data['user_list'] = $result;

			$ert['search'] = "false";
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['mname'] = 'Inventory';$ert['mid']=$mod_id;$ert['code']=$code;$ert['gid']=$gid;
			if ($alias == '') {
				$ert['title'] = "Inventory Defective";	
			}else{
				$ert['title'] = $alias." Defective";
			}

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/inventory_defective',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function proceed_to_def_out($type,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$ert['oid'] = $oid;
			$ert['gid'] = $gid;
			$dt = date('Y-m-d H:i:s');
			$module = $sess_data['user_mod'];
			$mod_id=0;$dom='';
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->function == 'inventory') {
					$mod_id = $module[$i]->mid;
					$dom = $module[$i]->domain;
					break;
				}
			}

			$pro_list = $this->input->post('prod_list');
			$c_name = $this->input->post('v_name');
			
			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id = b.icbd_customer_id WHERE ic_owner = '$oid' AND ic_name = '$c_name' AND icbd_value != '' ");
			$result_c = $query->result();
			$cid = $result_c[0]->ic_id;

			$invoice_txn_id = '';
			if ($type == 'def_out') {
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
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='inward'");
				$result2 = $query->result();
				$val = count($result2)+1;
				$invoice_txn_id = $val;
			}

			$data = array(
				'iextei_txn_id' => $invoice_txn_id,
				'iextei_customer_id' => $cid,
				'iextei_txn_date' => $dt,
				'iextei_type' => $type,
				'iextei_owner' => $oid,
				'iextei_gid' => $gid,
				'iextei_created' => $dt,
				'iextei_created_by' => $uid,
				'iextei_fid' => $uid
			);
			$this->db->insert('i_ext_et_inventory',$data);
			$inid = $this->db->insert_id();

			if (count($result_c) > 0) {
				for ($i=0; $i <count($result_c) ; $i++) { 
					$data = array(
						'iexteinvept_inid' => $inid,
						'iexteinvept_property_value' => $result_c[$i]->icbd_value,
						'iexteinvept_status' => 'false'
					);
					$this->db->insert('i_ext_et_inventory_property',$data);
				}
			}

			for ($i=0; $i < count($pro_list) ; $i++) { 
				if ($pro_list[$i]['flg'] == 'true' ) {
					$data = array(
						'iexteid_e_id' => $inid,
						'iexteid_product_id' => $pro_list[$i]['pid'],
						'iexteid_balance' => '1',
						'iexteid_inward' => '0',
						'iexteid_outward' => '0',
						'iexteid_owner' => $oid,
						'iexteid_serial_number' => $pro_list[$i]['sn'],
						'iexteid_amount' => $pro_list[$i]['amt']
					);
					$this->db->insert('i_ext_et_inventory_details', $data);	
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			if (count($result) >0 ) {
				for ($i=0; $i <count($result) ; $i++) { 
					$data = array(
						'iexteinvetm_inid' => $inid,
						'iexteinvetm_term_id' => $result[$i]->iextdt_id,
						'iexteinvetm_status' => 'false'
					);	
					$this->db->insert('i_ext_et_inventory_terms',$data);				
				}	
			}
			echo $inid;
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function proceed_to_repaired($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$pro_list = $this->input->post('prod_list');
			$cmt = $this->input->post('comment');

			$que = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$res = $que->result();

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_type = 'repaired' AND iextei_owner = '$oid' ");
			$result = count($query->result()) + 1;
			$data = array(
				'iextei_txn_id' => $result,
				'iextei_customer_id' => $res[0]->i_ref,
				'iextei_txn_date' => $dt,
				'iextei_type' => 'repaired',
				'iextei_note' => $cmt,
				'iextei_owner' => $oid,
				'iextei_gid' => $gid,
				'iextei_created' => $dt,
				'iextei_created_by' => $uid,
				'iextei_fid' => $uid
			);
			$this->db->insert('i_ext_et_inventory',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($pro_list) ; $i++) { 
				if ($pro_list[$i]['flg'] == 'true' ) {
					$data = array(
						'iexteid_e_id' => $inid,
						'iexteid_product_id' => $pro_list[$i]['pid'],
						'iexteid_balance' => '1',
						'iexteid_inward' => '0',
						'iexteid_outward' => '0',
						'iexteid_owner' => $oid,
						'iexteid_serial_number' => $pro_list[$i]['sn'],
						'iexteid_amount' => $pro_list[$i]['amt']
					);
					$this->db->insert('i_ext_et_inventory_details', $data);	
				}
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

######################### INWARD AND OUTWARD #############################	

	public function inventory_doc_upload($code,$pid,$cname){
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
					if ($module[$i]->function == 'inventory') {
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
					if ($module[$i]->function == 'inventory') {
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

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid' AND ip_gid = '$gid'");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			$result = $query->result();
			$data['serial_number'] = $result;

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
		//          $data['use_modules'] = $query->result();

		//          $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
		//          $result = $query->result();
		//          $data['tags'] = $result;

		//          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
		//          $result = $query->result();
		//          $data['status'] = $result;

		//          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
		//          $result = $query->result();
		//          $data['place'] = $result;

		//          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
		//          $result = $query->result();
		//          $data['cat'] = $result;

		//          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
		//          $result = $query->result();
		//          $data['user_list'] = $result;

			// $pro_list = [];
			// $que = $this->db->query("SELECT iexteid_product_id FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' GROUP BY iexteid_product_id");
			// $result = $que->result();

			// for ($j=0; $j < count($result) ; $j++) {
			// 	$pro_id = $result[$j]->iexteid_product_id;
			// 	$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id WHERE iextei_owner = '$oid' AND iexteid_product_id = '$pro_id' GROUP BY iextei_type ORDER BY inv DESC");
			// 	$res = $que->result();
			// 	$bal = 0 ;
			// 	for ($i=0; $i <count($res); $i++) {
			// 		if ($res[$i]->iextei_type == 'inward') {
			// 			$bal = $bal + $res[$i]->inv;
			// 		}else if ($res[$i]->iextei_type == 'outward') {
			// 			$bal = $bal - $res[$i]->inv;
			// 		}else if ($res[$i]->iextei_type == 'spare') {
			// 			$bal = $bal - $res[$i]->inv;
			// 		}else if ($res[$i]->iextei_type == 'def_sys') {
			// 			$bal = $bal + $res[$i]->inv;
			// 		}else if ($res[$i]->iextei_type == 'def_out') {
			// 			$bal = $bal - $res[$i]->inv;
			// 		}else if ($res[$i]->iextei_type == 'def_in') {
			// 			$bal = $bal + $res[$i]->inv;
			// 		}
			// 	}
			// 	array_push($pro_list, array('pid' => $pro_id, 'bal' => $bal ));
			// }
			// $data['product_list'] = $pro_list;
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
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/inventory_add', $data);
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

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pname' AND ip_owner = '$oid' ");
			$res = $query->result();
			if (count($res) > 0 ) {
				$pid = $res[0]->ip_id;
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
			}
			
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
					if ($module[$i]->function == 'inventory') {
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
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
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

				$inward = 0;
				$outward = 0;
				$balance = $products[$i]['qty'];
				// if($type=="inward") {
				// 	$inward = $products[$i]['qty'];
				// } else if($type == "outward") {
				// 	$outward = $products[$i]['qty'];
				// }

				// $balance = $balance + $inward - $outward;

				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $prid,
					'iexteid_inward' => $inward,
					'iexteid_outward' => $outward,
					'iexteid_balance' => $balance,
					'iexteid_owner' => $oid,
					'iexteid_serial_number' => $products[$i]['sn'],
					'iexteid_alias' => $products[$i]['alias']
				);
				$this->db->insert('i_ext_et_inventory_details', $data);
			}

			echo $inid;
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
	 		$page = file_get_contents(base_url().'Enterprise/inventory_outward_print/'.$code.'/'.$mod_id.'/'.$invoiceid.'/Inventory', false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/inventory/';

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
		    	redirect(base_url().'assets/data/'.$oid.'/inventory/'.$invoicefile);
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
		 		$page = file_get_contents(base_url().'Enterprise/inventory_outward_print/'.$code.'/'.$mod_id.'/'.$invoiceid.'/Inventory', false, $context);
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
					if ($module[$i]->mname == 'Inventory') {
						$mod_id = $module[$i]->mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			// $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			// $result = $query->result();
			// $data['tags'] = $result;

			// $query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			// $result = $query->result();
			// $data['customer'] = $result;
			// $data['mod_id'] = $mod_id;

			// $query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' ");
			// $data['project_list'] = $query->result();

			// $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' GROUP BY iua_place");
			// $result = $query->result();
			// $data['place'] = $result;

			// $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' GROUP BY iua_categorise");
			// $result = $query->result();
			// $data['cat'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a left JOIN i_ext_et_inventory_details as b on a.iextei_id=b.iexteid_e_id LEFT join i_product as c on b.iexteid_product_id=c.ip_id WHERE a.iextei_id ='$tid' AND a.iextei_owner = '$oid'");
			$result = $query->result();	
			$data['edit_invoice'] = $result;
			$cid = $result[0]->iextei_customer_id;
			$data['edit_type'] = $result[0]->iextei_type;
			$data['invoice_gid'] = $result[0]->iextei_gid;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Inventory' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['term_doc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_terms as a left join i_ext_et_document_terms as b on a.iexteinvetm_term_id=b.iextdt_id WHERE iexteinvetm_inid = '$tid' AND iextdt_document = 'Inventory' ");
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
			$this->load->view('enterprise/inventory_add', $data);
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
				if ($module[$i]->mname == 'Inventory') {
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

			$this->db->where('iexteid_e_id', $inid);
			$this->db->delete('i_ext_et_inventory_details');

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

				$inward = 0;
				$outward = 0;
				$balance = $products[$i]['qty'];

				// $query = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id='$prid' AND iexteid_owner='$oid'");
				// $result = $query->result();
				// if (count($result) > 0) {
				// 	$len = count($result);
				// 	$balance = $result[$len - 1]->iexteid_balance;
				// }

				// if($type=="inward") {
				// 	$inward = $products[$i]['qty'];
				// } else if($type == "outward") {
				// 	$outward = $products[$i]['qty'];
				// }
				// $balance = $balance + $inward - $outward;

				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $prid,
					'iexteid_inward' => $inward,
					'iexteid_outward' => $outward,
					'iexteid_balance' => $balance,
					'iexteid_owner' => $oid,
					'iexteid_serial_number' => $products[$i]['sn'],
					'iexteid_alias' => $products[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_inventory_details', $data);
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

			echo $inid;
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

			$this->db->where('iexteid_e_id',$prid);
			$this->db->delete('i_ext_et_inventory_details');
			
			$this->db->where('iexteinvept_inid', $prid);
			$this->db->delete('i_ext_et_inventory_property');

			$this->db->WHERE('iexteinvetm_inid',$prid);
			$this->db->delete('i_ext_et_inventory_terms');

			redirect(base_url().'Enterprise/inventory/'.$mod_id.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_status($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid=0;
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'inventory') {
						$mid = $module[$i]->mid;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			####### balance #######
			$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id WHERE iextei_owner = '$oid' GROUP BY iextei_type ORDER BY inv DESC");
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
			$data['bal'] = $bal;
			$spare = 0 ;
			for ($i=0; $i <count($res); $i++) {
				if ($res[$i]->iextei_type == 'spare') {
					$spare = $spare + $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'defective') {
					$spare = $spare + $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'def_return') {
					$spare = $spare - $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'def_sys') {
					$spare = $spare - $res[$i]->inv;
				}
			}
			$data['spare'] = $spare;

			$def = 0 ;
			for ($i=0; $i <count($res); $i++) {
				if ($res[$i]->iextei_type == 'def_sys') {
					$def = $def + $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'def_out') {
					$def = $def - $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'repaired') {
					$def = $def - $res[$i]->inv;
				}
			}
			$data['def'] = $def;

			$c_co = 0 ;
			for ($i=0; $i <count($res); $i++) {
				if ($res[$i]->iextei_type == 'outward') {
					$c_co = $c_co + $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'def_return') {
					$c_co = $c_co + $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'defective') {
					$c_co = $c_co - $res[$i]->inv;
				}
			}
			$data['c_co'] = $c_co;

			$ven = 0 ;
			for ($i=0; $i <count($res); $i++) {
				if ($res[$i]->iextei_type == 'def_in') {
					$ven = $ven - $res[$i]->inv;
				}else if ($res[$i]->iextei_type == 'def_out') {
					$ven = $ven + $res[$i]->inv;
				}
			}
			$data['ven'] = $ven;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_gid= '$gid' GROUP BY ip_product ");
			$result = $query->result();
			$data['products'] = $result;

			$pro_id;
			$cust_id = [];
			$que = $this->db->query("SELECT iexteid_product_id FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' GROUP BY iexteid_product_id");
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
				array_push($cust_id, array('pid' => $pro_id, 'bal' => $bal ));
			}
			$data['product_list'] = $cust_id;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name IS NOT NULL");
			$result = $query->result();
			$data['customers'] = $result;

			$query = $this->db->query("SELECT iexteid_serial_number as sn FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' GROUP BY iexteid_serial_number ");
			$result = $query->result();
			$data['sn'] = $result;

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['mid'] = $mid;$ert['mname']='Inventory';$ert['code']=$code;$ert['gid']=$gid;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = "Inventory Status";	
			}else{
				$ert['title'] = $alias." Status";
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/inventory_status', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_get_status($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$product = $this->input->post("product");
			$customer = $this->input->post("customer");
			$sn = $this->input->post("sn");
			$prod_id = [];
			$cust_id = [];
			$sn_id = [];

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a LEFT JOIN i_ext_et_invoice_product_details as b on a.iextein_id = b.iexteinpd_d_id WHERE a.iextein_owner = '$oid' AND a.iextein_gid = '$gid' ");
			$result = $query->result();
			$data['in_wrnt'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a LEFT JOIN i_ext_et_purchase_product_details as b on a.iextep_id = b.iexteppd_d_id WHERE iextep_owner = '$oid' AND iextep_gid = '$gid' ");
			$result = $query->result();
			$data['p_wrnt'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_replacement WHERE iexteir_owner = '$oid' ");
			$data['r_invoice'] = $query->result();

			for ($i=0; $i < count($product) ; $i++) {
			    $prd = $product[$i];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_product='$prd'");
				$result = $query->result();
				array_push($prod_id, $result[0]->ip_id);
			}
			
			for ($i=0; $i < count($customer) ; $i++) {
			    $tcust = $customer[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name='$tcust'");
				$result = $query->result();
				array_push($cust_id, $result[0]->ic_id);
			}
			
			for ($i=0; $i < count($sn) ; $i++) {
			    $t_sn = $sn[$i];
				array_push($sn_id, $t_sn);
			}

			$cust_str = implode(",", $cust_id);
			$prod_str = implode(",", $prod_id);
			$sn_str = implode(",", $sn_id);

			if (count($prod_id) > 0 && count($cust_id) > 0 && count($sn_id) > 0 ) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND a.iextei_customer_id IN ($cust_str) AND b.iexteid_product_id IN ($prod_str) AND b.iexteid_serial_number IN ($sn_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "";
				print_r(json_encode($data));

			} else if (count($prod_id) > 0 && count($cust_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND a.iextei_customer_id IN ($cust_str) AND b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "";
				print_r(json_encode($data));

			} else if (count($sn_id) > 0 && count($cust_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND a.iextei_customer_id IN ($cust_str) AND b.iexteid_serial_number IN ($sn_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "";
				print_r(json_encode($data));

			} else if (count($prod_id) > 0 && count($sn_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND b.iexteid_serial_number IN ($sn_str) AND b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "";
				print_r(json_encode($data));

			} else if (count($prod_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND b.iexteid_owner = '$oid' AND b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC, a.iextei_txn_date DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";

				$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type , c.ip_product as name FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id LEFT JOIN i_product as c on b.iexteid_product_id = c.ip_id WHERE iextei_owner = '$oid' AND iexteid_product_id IN ($prod_str) GROUP BY iextei_type ORDER BY inv DESC");
				$res = $que->result();
				$data['balance'] = [];
				$bal = 0 ;
				for ($i=0; $i <count($res); $i++) {
					$prod_id = $res[$i]->product;
					$pname = $res[$i]->name;
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
				array_push($data['balance'], "<h3>Current Available Balance of ".$pname." : ".$bal."</h3><hr>");
				print_r(json_encode($data));

			} else if (count($cust_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND a.iextei_customer_id IN ($cust_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else if (count($sn_id) > 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_owner = '$oid' AND b.iexteid_serial_number IN ($sn_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else {
				$data['type'] = "none";
				$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id WHERE iextei_owner = '$oid' GROUP BY iextei_type ORDER BY inv DESC");
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
				$data['bal'] = $bal;
				$spare = 0 ;
				for ($i=0; $i <count($res); $i++) {
					if ($res[$i]->iextei_type == 'spare') {
						$spare = $spare + $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'defective') {
						$spare = $spare + $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'def_return') {
						$spare = $spare - $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'def_sys') {
						$spare = $spare - $res[$i]->inv;
					}
				}
				$data['spare'] = $spare;

				$def = 0 ;
				for ($i=0; $i <count($res); $i++) {
					if ($res[$i]->iextei_type == 'def_sys') {
						$def = $def + $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'def_out') {
						$def = $def - $res[$i]->inv;
					}
				}
				$data['def'] = $def;

				$c_co = 0 ;
				for ($i=0; $i <count($res); $i++) {
					if ($res[$i]->iextei_type == 'outward') {
						$c_co = $c_co + $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'def_return') {
						$c_co = $c_co + $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'defective') {
						$c_co = $c_co - $res[$i]->inv;
					}
				}
				$data['c_co'] = $c_co;

				$ven = 0 ;
				for ($i=0; $i <count($res); $i++) {
					if ($res[$i]->iextei_type == 'def_in') {
						$ven = $ven - $res[$i]->inv;
					}else if ($res[$i]->iextei_type == 'def_out') {
						$ven = $ven + $res[$i]->inv;
					}
				}
				$data['ven'] = $ven;

				$pro_id;
				$cust_id = [];
				$que = $this->db->query("SELECT iexteid_product_id FROM i_ext_et_inventory_details WHERE iexteid_owner = '$oid' GROUP BY iexteid_product_id");
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
					array_push($cust_id, array('pid' => $pro_id, 'bal' => $bal ));
				}
				$data['product_list'] = $cust_id;

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_gid= '$gid' GROUP BY ip_product ");
				$result = $query->result();
				$data['products'] = $result;

				print_r(json_encode($data));
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_reconcile($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_gid = '$gid' ");
			$result = $query->result();
			$p_details = [] ;
			for ($i=0; $i < count($result) ; $i++) { 
				$pid = $result[$i]->ip_id;
				// $query1 = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id='$pid' AND iexteid_owner='$oid' ORDER BY iexteid_e_id");
				// $result1 = $query1->result();

				$que = $this->db->query("SELECT SUM(b.iexteid_balance) as inv , b.iexteid_product_id as product, a.iextei_type FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id WHERE iextei_owner = '$oid' AND iexteid_product_id='$pid' GROUP BY iextei_type ORDER BY inv DESC");
				$res = $que->result();
				// $inw = 0;
				// $owd = 0;
				// $bln = 0;
				$bal = 0;
				for ($j=0; $j < count($res) ; $j++) {
					if ($res[$j]->iextei_type == 'inward') {
						$bal = $bal + $res[$i]->inv;
					}else if ($res[$j]->iextei_type == 'outward') {
						$bal = $bal - $res[$j]->inv;
					}else if ($res[$j]->iextei_type == 'spare') {
						$bal = $bal - $res[$j]->inv;
					}else if ($res[$j]->iextei_type == 'def_sys') {
						$bal = $bal + $res[$j]->inv;
					}else if ($res[$j]->iextei_type == 'def_out') {
						$bal = $bal - $res[$j]->inv;
					}else if ($res[$j]->iextei_type == 'def_in') {
						$bal = $bal + $res[$j]->inv;
					}
					// $id = $res[$j]->iexteid_id;
					// $inw = $result1[$j]->iexteid_inward;
					// $owd = $result1[$j]->iexteid_outward;

					// if ($j==0) {
					// 	$bln = $inw - $owd;
					// } else {
					// 	$bln = $bln + $inw - $owd;
					// }

					// $data = array(
					// 	// 'iexteid_inward' => $inw,
					// 	// 'iexteid_outward' => $owd,
					// 	'iexteid_balance' => $bln);
					// $this->db->where('iexteid_id', $id );
					// $this->db->update('i_ext_et_inventory_details', $data);
				}
				array_push($p_details, array('pid' => $pid, 'bal' => $bal));
			}
			$data['pro'] = $p_details;
			print_r(json_encode($data));
			// echo "Stock Data Reconciled.";
		} else {
			echo "Please refresh to login again.";
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

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id LEFT JOIN i_p_price AS c ON b.ip_id=c.ipp_p_id WHERE a.iexteid_e_id='$out_id' AND a.iexteid_owner='$oid'");
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

########## INVENTORY LOCATIONS ################
	public function inventory_locator($mod_id) {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_locations WHERE iexteil_owner = '$oid'");
			$result = $query->result();

			$data['location'] = $result;

			$query = $this->db->query("SELECT a.iexteiml_id AS id, b.iexteil_name AS location, d.ip_product AS product, a.iexteiml_txn_no AS txnno FROM i_ext_et_inventory_material_location AS a LEFT JOIN i_ext_et_inventory_locations AS b ON a.iexteiml_location_id=b.iexteil_id LEFT JOIN i_ext_et_inventory_details AS c ON a.iexteiml_txn_p_id=c.iexteid_id LEFT JOIN i_product AS d ON c.iexteid_product_id=d.ip_id WHERE a.iexteiml_owner = '$oid' ORDER BY a.iexteiml_id DESC");
			$result = $query->result();

			$data['inventory'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE iextei_owner = '$oid' AND iextei_type='outward' ORDER BY iextei_id DESC");
			$result = $query->result();
			
			$data['outward'] = $result;
			
			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Inventory Locations";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_locator', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_search() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$search = $this->input->post('search');
			$type_search = $this->input->post('type_search');

			if ($type_search == "product") {
				$query = $this->db->query("SELECT a.iexteiml_id AS id, d.ip_product AS product, e.iextei_txn_id AS txnno, c.iexteid_serial_number AS srno, c.iexteid_inward AS qty, b.iexteil_name AS location FROM i_ext_et_inventory_material_location AS a LEFT JOIN i_ext_et_inventory_locations AS b ON a.iexteiml_location_id=b.iexteil_id LEFT JOIN i_ext_et_inventory_details AS c ON a.iexteiml_txn_p_id=c.iexteid_id LEFT JOIN i_product AS d ON c.iexteid_product_id=d.ip_id LEFT JOIN i_ext_et_inventory AS e ON a.iexteiml_txn_no=e.iextei_id WHERE a.iexteiml_owner = '$oid' AND d.ip_product LIKE '%$search%' ORDER BY a.iexteiml_id DESC");
				$result = $query->result();	
			} else {
				$query = $this->db->query("SELECT a.iexteiml_id AS id, d.ip_product AS product, e.iextei_txn_id AS txnno, c.iexteid_serial_number AS srno, c.iexteid_inward AS qty, b.iexteil_name AS location FROM i_ext_et_inventory_material_location AS a LEFT JOIN i_ext_et_inventory_locations AS b ON a.iexteiml_location_id=b.iexteil_id LEFT JOIN i_ext_et_inventory_details AS c ON a.iexteiml_txn_p_id=c.iexteid_id LEFT JOIN i_product AS d ON c.iexteid_product_id=d.ip_id LEFT JOIN i_ext_et_inventory AS e ON a.iexteiml_txn_no=e.iextei_id WHERE a.iexteiml_owner = '$oid' AND b.iexteil_name LIKE '%$search%' ORDER BY a.iexteiml_id DESC");
				$result = $query->result();
			}
			

			$data['inventory'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	// public function inventory_locator_select_dispatch_detail_load() {
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data = $this->input->post('data');

	// 		$data_str = implode("','", $data);

	// 		$query = $this->db->query("SELECT a.iexteiml_id AS id, d.ip_product AS product, e.iextei_txn_id AS txnno, c.iexteid_serial_number AS srno, c.iexteid_inward AS qty, b.iexteil_name AS location FROM i_ext_et_inventory_material_location AS a LEFT JOIN i_ext_et_inventory_locations AS b ON a.iexteiml_location_id=b.iexteil_id LEFT JOIN i_ext_et_inventory_details AS c ON a.iexteiml_txn_p_id=c.iexteid_id LEFT JOIN i_product AS d ON c.iexteid_product_id=d.ip_id LEFT JOIN i_ext_et_inventory AS e ON a.iexteiml_txn_no=e.iextei_id WHERE a.iexteiml_owner = '$oid' AND a.iexteiml_id IN ('$data_str') ORDER BY a.iexteiml_id DESC");
	// 		$result = $query->result();

	// 		print_r(json_encode($result));
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}	
	// }

	public function inventory_locator_add($type, $mod_id) {
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

			$data['mod_id'] = $mod_id;

			if ($type == "store") {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='inward' ORDER BY iextei_id DESC");	
				$data['sec_type'] = "Inward";
			} else if($type == "dispatch") {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_owner = '$oid' AND iextei_type='outward' ORDER BY iextei_id DESC");
				$data['sec_type'] = "Outward";
			}

			$result = $query->result();
			$data['inventory'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_locations WHERE iexteil_owner = '$oid'");
			$result = $query->result();
			$data['locations'] = $result;

			$data['type'] = $type;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 

			if ($type == "store") {
				$ert['title'] = "Store Materials";
			} else if($type == "dispatch" ) {
				$ert['title'] = "Dispatch Materials";
			}

			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_location_materials', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_search_document($type) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id WHERE a.iexteid_owner = '$oid' AND a.iexteid_e_id = '$search'");
			$result = $query->result();
			$data['materials'] = [];

			if ($type == "store") {
				for ($i=0; $i < count($result) ; $i++) { 
					$txnid = $result[$i]->iexteid_id;
					$que = $this->db->query("SELECT * FROM i_ext_et_inventory_material_location WHERE iexteiml_txn_p_id = '$txnid' AND iexteiml_owner = '$oid' AND iexteiml_txn_no='$search'");
					$res = $que->result();

					if (count($res) <= 0) {
						array_push($data['materials'], $result[$i]);
					}
				}
			} else if($type == "dispatch") {
				for ($i=0; $i < count($result) ; $i++) { 
					$txnid = $result[$i]->iexteid_id;
					$que = $this->db->query("SELECT * FROM i_ext_et_inventory_material_location WHERE iexteiml_txn_p_id = '$txnid' AND iexteiml_owner = '$oid' AND iexteiml_txn_no='$search'");
					$res = $que->result();

					if (count($res) > 0) {
						array_push($data['materials'], $result[$i]);
					}
				}
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function save_inventory_locator($type, $mod_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$location = $this->input->post('location');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('products');
			
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_locations WHERE iexteil_name='$location' AND iexteil_owner='$oid'");
			$result = $query->result();

			if(count($result) > 0) {
				$lid = $result[0]->iexteil_id;
			} else {
				$data1 = array(
					'iexteil_name' => $this->input->post('name'),
					'iexteil_code' => $this->input->post('code'),
					'iexteil_owner' => $oid,
					'iexteil_created' => $dt,
					'iexteil_created_by' => $oid
				 );
				$this->db->insert('i_ext_et_inventory_locations', $data1);
				$lid = $this->db->insert_id();
			}


			for ($i=0; $i < count($products) ; $i++) { 

				$que = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_id = '$products[$i]' AND iexteid_owner = '$oid'");
				$res = $que->result();

				$available = 0;
				$prod_id = 0;
				if (count($res) > 0) {
					$available = $res[0]->iexteid_inward;
					$prod_id = $res[0]->iexteid_product_id;
				}

				$data = array(
					'iexteiml_type' => $type,
					'iexteiml_txn_no' => $txn_no,
					'iexteiml_txn_date' => $txn_date,
					'iexteiml_txn_p_id'	=> $products[$i],
					'iexteiml_p_id' => $prod_id,
					'iexteiml_location_id' => $lid,
					'iexteiml_available' => $available,
					'iexteiml_owner' => $oid,
					'iexteiml_created' => $dt,
					'iexteiml_created_by' => $oid);
				$this->db->insert('i_ext_et_inventory_material_location', $data);
			}

			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_location_update($mod_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$location = $this->input->post('location');
			$txn_no = $this->input->post('items');
			
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_locations WHERE iexteil_name='$location' AND iexteil_owner='$oid'");
			$result = $query->result();

			if(count($result) > 0) {
				$lid = $result[0]->iexteil_id;
			} else {
				$data1 = array(
					'iexteil_name' => $this->input->post('location'),
					'iexteil_code' => '',
					'iexteil_owner' => $oid,
					'iexteil_created' => $dt,
					'iexteil_created_by' => $oid
				 );
				$this->db->insert('i_ext_et_inventory_locations', $data1);
				$lid = $this->db->insert_id();
			}


			for ($i=0; $i < count($txn_no) ; $i++) { 
				
				$upd = array('iexteiml_id' => $txn_no[$i]);

				$data = array(
					'iexteiml_location_id' => $lid,
					'iexteiml_modified' => $dt,
					'iexteiml_modified_by' => $oid);
				$this->db->where($upd);
				$this->db->update('i_ext_et_inventory_material_location', $data);
			}

			print_r($txn_no);
			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_dispatch_update($mod_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$txn_no = $this->input->post('items');
			$outward = $this->input->post('outward');
			$outward_date = $this->input->post('outward_date');

			
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$txn_no_str = implode("','", $txn_no);
			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_material_location AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iexteiml_txn_p_id=b.iexteid_id WHERE a.iexteiml_id IN ('$txn_no_str') AND a.iexteiml_owner='$oid'");
			$result = $query->result();

			// for ($i=0; $i < count($result) ; $i++) { 
			// 	$loc_id = $result[$i]->iexteiml_location_id;
			// 	$pro_id = $result[$i]->iexteiml_p_id;
			// 	$pro_sn = $result[$i]->iexteid_serial_number;

			// 	$que = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_e_id = '$outward' AND iexteid_owner='$oid' AND iexteid_product_id = '$pro_id' AND iexteid_serial_number = '$pro_sn'");
			// 	$res = $que->result();

			// 	if (count($res) > 0) {
			// 		$available = 0;
			// 		if (count($res) > 0) {
			// 			$available = -1 * $res[0]->iexteid_outward;
			// 		}

			// 		$data = array(
			// 			'iexteiml_type' => 'dispatch',
			// 			'iexteiml_txn_no' => $outward,
			// 			'iexteiml_txn_date' => $outward_date,
			// 			'iexteiml_txn_p_id'	=> $txn_no[$i],
			// 			'iexteiml_p_id' => $pro_id,
			// 			'iexteiml_location_id' => $loc_id,
			// 			'iexteiml_available' => $available,
			// 			'iexteiml_owner' => $oid,
			// 			'iexteiml_created' => $dt,
			// 			'iexteiml_created_by' => $oid);
			// 		$this->db->insert('i_ext_et_inventory_material_location', $data);
			// 	}
			// }

			for ($i=0; $i < count($result) ; $i++) { 
				$tx_id = $result[$i]->iexteiml_id;

				$this->db->where('iexteiml_id', $tx_id);
				$this->db->delete('i_ext_et_inventory_material_location');
			}
			print_r($txn_no);
			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_getoutward_items() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$txn_no = $this->input->post('txn_no');

			$query = $this->db->query("SELECT b.ip_product AS product, a.iexteid_outward AS qty, a.iexteid_serial_number AS sn FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id WHERE a.iexteid_owner = '$oid' AND a.iexteid_e_id = '$txn_no'");
			$result = $query->result();
			
			print_r(json_encode($result));
		} else {
			redirect(base_url()."Account/login");
		}
	}
	## Pending ##
	public function inventory_locator_edit($type, $mod_id , $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/inventory/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			if ($type == "inward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='vendor'");
			} else if($type == "outward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='customer'");
			}

			$data['mod_id'] = $mod_id;

			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_section='Products'  AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE iextei_owner='$oid' AND iextei_id='$inid'");	
			$result = $query->result();
			$data['edit_inventory'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id WHERE iexteid_owner='$oid' AND iexteid_e_id='$inid'");	
			$result = $query->result();
			$data['edit_inventory_details'] = $result;

			$query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			$result = $query->result();
			$data['serial_number'] = $result;

			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_tags WHERE iextett_txn_id='$inid'");	
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$data['type'] = $type;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 

			if ($type == "inward") {
				$ert['title'] = "Inward";
			} else if($type == "outward" ) {
				$ert['title'] = "Outward";
			}
			

			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_inventory_locator($type, $mod_id, $inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$alias = $this->input->post('alias');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			if($type == "inward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='vendor' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'vendor';
			} else if ($type == "outward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='customer' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'customer';
			}
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$data = array(
				'iextei_customer_id' => $cid,
				'iextei_txn_id' => $txn_no,
				'iextei_txn_date' => $txn_date,
				'iextei_type' => $type,
				'iextei_modified' => $dt,
				'iextei_modified_by' => $oid);
			$this->db->where('iextei_id', $inid);
			$this->db->update('i_ext_et_inventory', $data);
			

			$this->db->where('iexteid_e_id', $inid);
			$this->db->delete('i_ext_et_inventory_details');

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;
				} else {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				}

				$inward = 0;
				$outward = 0;
				$balance = 0;

				$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id='$prid' AND iexteid_owner='$oid'");
				$result = $query->result();
				if (count($result) > 0) {
					$len = count($result);
					$balance = $result[$len - 1]->iexteid_balance;
				}

				if($type=="inward") {
					$inward = $qty[$i];
				} else if($type == "outward") {
					$outward = $qty[$i];
				}

				$balance = $balance + $inward - $outward;

				$data = array(
					'iexteid_e_id' => $inid,
					'iexteid_product_id' => $prid,
					'iexteid_inward' => $inward,
					'iexteid_outward' => $outward,
					'iexteid_balance' => $balance,
					'iexteid_owner' => $oid,
					'iexteid_alias' => $alias[$i],
					'iexteid_serial_number' => $sn[$i]);
				$this->db->insert('i_ext_et_inventory_details', $data);
			}

			$this->db->where('iextett_txn_id', $inid);
			$this->db->delete('i_ext_et_inventory_tags');

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
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_inventory_locator($prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$this->db->where('ip_id', $prid);
			$this->db->delete('i_product');

			$this->db->where('ipp_p_id',$prid);
			$this->db->delete('i_p_price');

			
			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			$this->db->where('ipft_product_id', $prid);
			$this->db->delete('i_p_f_tags');

			redirect(base_url().'Enterprise/products');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_status() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_gid = '$gid' ");
			$result = $query->result();

			$data['products'] = $result;

			for ($i=0; $i < count($result) ; $i++) { 
				$pid = $result[$i]->ip_id;
				$pname = $result[$i]->ip_product;

				$que = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id = '$pid'");
				$res = $que->result();

				if (count($res) >0) {
					$a = count($res) - 1;
					$data['pname'][$i] = $pname;
					$data['pqty'][$i] = $res[$a]->iexteid_balance;
				} else {
					$data['pname'][$i] = $pname;
					$data['pqty'][$i] = "N/A";
				}
				
			}
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE (ic_section='customer' OR ic_section='vendor') AND  ic_owner = '$oid'");
			$result = $query->result();

			$data['customers'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Inventory Status";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_status', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_get_status() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;

			$product = $this->input->post("product");
			$customer = $this->input->post("customer");

			$prod_id = [];
			$cust_id = [];
			for ($i=0; $i < count($product) ; $i++) { 
			    $prd = $product[$i];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_product='$prd'");
				$result = $query->result();

				array_push($prod_id, $result[0]->ip_id);
			}
			
			for ($i=0; $i < count($customer) ; $i++) { 
			    $tcust = $customer[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE (ic_section = 'customer' OR ic_section = 'vendor') AND ic_owner = '$oid' AND ic_name='$tcust'");
				$result = $query->result();

				array_push($cust_id, $result[0]->ic_id);
			}
			

			$cust_str = implode(",", $cust_id);
			$prod_str = implode(",", $prod_id);

			if ((count($prod_id) > 0) && (count($cust_id) > 0)) {
				$query = $this->db->query("SELECT ic_name, iexteid_serial_number, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_customer_id IN ($cust_str) AND b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "";
				print_r(json_encode($data));

			} else if ((count($prod_id)) > 0) {
				$query = $this->db->query("SELECT ic_name, iexteid_serial_number, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC, b.iexteid_id DESC, a.iextei_txn_date DESC");
				$result = $query->result();

				$cnt = count($result) - 1;

				$data['result']  = $result;
				$data['type'] = "record";
				$data['balance'] = "<h3>Current Available Balance:".$result[0]->iexteid_balance."</h3><hr>";
				print_r(json_encode($data));

			} else if ((count($cust_id) > 0)) {
				$query = $this->db->query("SELECT  ic_name, iexteid_serial_number, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_customer_id IN ($cust_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else {
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products' AND ip_gid = '$gid' ");
				$result = $query->result();

				for ($i=0; $i < count($result) ; $i++) { 
					$pid = $result[$i]->ip_id;
					$pname = $result[$i]->ip_product;

					$que = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id = '$pid'");
					$res = $que->result();

					if (count($res) >0) {
						$a = count($res) - 1;
						$data['pname'][$i] = $pname;
						$data['pqty'][$i] = $res[$a]->iexteid_balance;
					} else {
						$data['pname'][$i] = $pname;
						$data['pqty'][$i] = "N/A";
					}
					
				}

				$data['type'] = "none";
				print_r(json_encode($data));
			}
			

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_locator_reconcile() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$u_owner = $sess_data['user_details'][0]->i_owner;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid'");
			$result = $query->result();
			
			for ($i=0; $i < count($result) ; $i++) { 
				$pid = $result[$i]->ip_id;
				$query1 = $this->db->query("SELECT * FROM i_ext_et_inventory_details WHERE iexteid_product_id='$pid' AND iexteid_owner='$oid' ORDER BY iexteid_e_id");
				$result1 = $query1->result();

				$inw = 0;
				$owd = 0;
				$bln = 0;

				for ($j=0; $j < count($result1) ; $j++) { 
					$id = $result1[$j]->iexteid_id;
					$inw = $result1[$j]->iexteid_inward;
					$owd = $result1[$j]->iexteid_outward;

					if ($j==0) {
						$bln = $inw - $owd;
					} else {
						$bln = $bln + $inw - $owd;
					}

					$data = array(
						'iexteid_inward' => $inw,
						'iexteid_outward' => $owd,
						'iexteid_balance' => $bln);
					$this->db->where('iexteid_id', $id );
					$this->db->update('i_ext_et_inventory_details', $data);
				}
			}

			echo "Stock Data Reconciled.";
		} else {
			echo "Please refresh to login again.";
		}
	}

	public function inventory_locator_outward_print($mod_id, $out_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers As b ON a.iextei_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextei_id='$out_id'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers As b ON a.iextei_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextei_id='$out_id'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextei_txn_id;
				$data['s_txn_date'] = $result[0]->iextei_txn_date;
				// $data['s_txn_note'] = $result[0]->iextein_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextei_txn_id;
				$data['s_txn_date'] = $result[0]->iextei_txn_date;
				// $data['s_txn_note'] = $result[0]->iextein_note;
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id LEFT JOIN i_p_price AS c ON b.ip_id=c.ipp_p_id WHERE a.iexteid_e_id='$out_id' AND a.iexteid_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Outward' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;

			$data['s_title'] = "Inventory Outward";

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;

			$this->load->view('enterprise/inventory_outward_print', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	#### manage locations ## 
	public function inventory_location_manage() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_locations WHERE iexteil_owner = '$oid'");
			$result = $query->result();

			$data['location'] = $result;

			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Inventory Locations Manage";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_location_manage', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_location_manage_save() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			if ($this->input->post('id') == "N/A") {
				$data = array(
					'iexteil_name' => $this->input->post('name'),
					'iexteil_code' => $this->input->post('code'),
					'iexteil_owner' => $oid,
					'iexteil_created' => $dt,
					'iexteil_created_by' => $oid
				);
				$this->db->insert('i_ext_et_inventory_locations', $data);
			} else {
				$data = array(
					'iexteil_name' => $this->input->post('name'),
					'iexteil_code' => $this->input->post('code'),
					'iexteil_modified' => $dt,
					'iexteil_modified_by' => $oid
				);
				$this->db->where('iexteil_id', $this->input->post('id'));
				$this->db->update('i_ext_et_inventory_locations', $data);
			}

			redirect(base_url().'Enterprise/inventory_location_manage');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_location_manage_getdetail() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$lid = $this->input->post('id');
			$query = $this->db->query("SELECT iexteil_name AS name, iexteil_code AS code FROM i_ext_et_inventory_locations WHERE iexteil_owner = '$oid' AND iexteil_id='$lid'");
			$result = $query->result();
			print_r(json_encode($result));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_location_manage_delete($lid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$this->db->where('iexteil_id', $lid);
			$this->db->delete('i_ext_et_inventory_locations');
			
			redirect(base_url().'Enterprise/inventory_location_manage');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## TAX ################
	public function tax($mid=0,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Taxes') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$data['tax'] = $query->result();

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	  //       $data['use_modules'] = $query->result();

	  //       $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
	  //       $result = $query->result();
	  //       $data['tags'] = $result;

	  //       $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
	  //       $result = $query->result();
	  //       $data['status'] = $result;

	  //       $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
	  //       $result = $query->result();
	  //       $data['place'] = $result;

	  //       $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
	  //       $result = $query->result();
	  //       $data['cat'] = $result;

	  //       $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	  //       $result = $query->result();
	  //       $data['user_list'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['code']=$code;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/tax', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_add($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Taxes') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$data['tax'] = $query->result();

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	  //       $data['use_modules'] = $query->result();

	  //       $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
	  //       $result = $query->result();
	  //       $data['tags'] = $result;

	  //       $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
	  //       $result = $query->result();
	  //       $data['status'] = $result;

	  //       $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
	  //       $result = $query->result();
	  //       $data['place'] = $result;

	  //       $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
	  //       $result = $query->result();
	  //       $data['cat'] = $result;

	  //       $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	  //       $result = $query->result();
	  //       $data['user_list'] = $result;

			$ert['mid'] = $mid; $ert['mname'] = $mname; $ert['gid'] = $gid; $ert['code'] = $code; $ert['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname." Add";
			}else{
				$ert['title'] = $alias." Add";
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/tax_add');
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_tax($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$name = $this->input->post('name');
			$taxes = $this->input->post('taxes');
			
			$data = array(
				'ittxg_group_name' => $name,
				'ittxg_owner' => $oid
			);
			$this->db->insert('i_tax_group', $data);
			$tg_id = $this->db->insert_id();

			$dt = date('Y-m-d H:i:s');
			for ($i=0; $i <count($taxes) ; $i++) {
				$tp = str_replace('', '%', $taxes[$i]['t_amt']);
				$tname = $taxes[$i]['t_name'];

				$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
				$result = $query->result();

				if(count($result) > 0) {
					$txid = $result[0]->itx_id;
				} else {
					$data = array(
						'itx_name' => $tname,
						'itx_percent' => $tp,
						'itx_owner' => $oid
					);
					$this->db->insert('i_taxes', $data);
					$txid = $this->db->insert_id();
				}

				$data1 = array(
					'itxgc_tg_id' => $tg_id,
					'itxgc_tx_id' => $txid );
				$this->db->insert('i_tax_group_collection', $data1);
			}

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_edit($code,$t_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$mid = 0;$mname='';
			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Taxes') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_id = '$t_id' ");
			$result = $query->result();
			$tgid = $result[0]->ittxg_id;
			$data['g_name'] = $result[0]->ittxg_group_name;

			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid' AND itx_id IN(SELECT itxgc_tx_id FROM i_tax_group_collection WHERE itxgc_tg_id = '$tgid')");
			$result = $query->result();
			$data['taxes'] = $result;

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	  //       $data['use_modules'] = $query->result();

	  //       $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
	  //       $result = $query->result();
	  //       $data['tags'] = $result;

	  //       $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
	  //       $result = $query->result();
	  //       $data['status'] = $result;

	  //       $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
	  //       $result = $query->result();
	  //       $data['place'] = $result;

	  //       $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
	  //       $result = $query->result();
	  //       $data['cat'] = $result;

	  //       $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	  //       $result = $query->result();
	  //       $data['user_list'] = $result;
			
			$data['tid'] =$tgid;
			$ert['mid'] = $mid; $ert['mname'] = $mname; $ert['gid'] = $gid; $ert['code'] = $code; $ert['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname." Edit";
			}else{
				$ert['title'] = $alias." Edit";
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/tax_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_tax($tid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;

			$query = $this->db->query("SELECT * FROM i_tax_group_collection WHERE itxgc_tg_id = '$tid' ");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$this->db->WHERE(array('itx_id'=>$result[$i]->itxgc_tx_id)); 
					$this->db->delete('i_taxes');
				}
			}
			$this->db->WHERE(array('itxgc_tg_id'=>$tid));
			$this->db->delete('i_tax_group_collection');

			$name = $this->input->post('name');
			$taxes = $this->input->post('taxes');

			$data = array('ittxg_group_name' => $name);
			$this->db->where(array('ittxg_id'=>$tid , 'ittxg_owner' =>$oid));
			$this->db->update('i_tax_group', $data);

			$dt = date('Y-m-d H:i:s');
			for ($i=0; $i <count($taxes) ; $i++) {
				$tp = str_replace('', '%', $taxes[$i]['t_amt']);
				$tname = $taxes[$i]['t_name'];

				$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
				$result = $query->result();

				if(count($result) > 0) {
					$txid = $result[0]->itx_id;
				} else {
					$data = array(
						'itx_name' => $tname,
						'itx_percent' => $tp,
						'itx_owner' => $oid
					);
					$this->db->insert('i_taxes', $data);
					$txid = $this->db->insert_id();
				}

				$data1 = array(
					'itxgc_tg_id' => $tid,
					'itxgc_tx_id' => $txid );
				$this->db->insert('i_tax_group_collection', $data1);
			}

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_tax($tid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$this->db->WHERE(array('ittxg_id'=>$tid));
			$this->db->delete('i_tax_group');

			$query = $this->db->query("SELECT * FROM i_tax_group_collection WHERE itxgc_tg_id = '$tid' ");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i <count($result) ; $i++) {
					$this->db->WHERE(array('itx_id'=>$result[$i]->itxgc_tx_id)); 
					$this->db->delete('i_taxes');
				}
			}
			$this->db->WHERE(array('itxgc_tg_id'=>$tid));
			$this->db->delete('i_tax_group_collection');

			redirect(base_url().'Enterprise/tax/0/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	// public function tax_group() {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		 if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
	// 		$result = $query->result();

	// 		$data['tax_group'] = $result;

	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
	// 		$ert['title'] = "Tax Group";
	// 		$ert['search'] = "true";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('enterprise/tax_group', $data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function tax_group_add() {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		 if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid'");
	// 		$result = $query->result();

	// 		$data['tax'] = $result;

	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
	// 		$ert['title'] = "Tax Add";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('enterprise/tax_group_add', $data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function save_tax_group() {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {

	// 		$name = $this->input->post('name');
	// 		$taxes = $this->input->post('taxes');
			
	// 		$dt = date('Y-m-d H:i:s');
	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$data = array(
	// 			'ittxg_group_name' => $name,
	// 			'ittxg_owner' => $oid);
	// 		$this->db->insert('i_tax_group', $data);
	// 		$tg_id = $this->db->insert_id();

	// 		for ($i=0; $i < count($taxes) ; $i++) { 
	// 			$tname = $taxes[$i];
	// 			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
	// 			$result = $query->result();

	// 			if(count($result) > 0) {
	// 				$txid = $result[0]->itx_id;
	// 			} else {
	// 				$data = array(
	// 					'itx_name' => $tname,
	// 					'itx_owner' => $oid);
	// 				$this->db->insert('i_taxes', $data);
	// 				$txid = $this->db->insert_id();
	// 			}

	// 			$data1 = array(
	// 				'itxgc_tg_id' => $tg_id,
	// 				'itxgc_tx_id' => $txid );
	// 			$this->db->insert('i_tax_group_collection', $data1);
	// 		}

			
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function tax_group_edit($t_id) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		 if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_id = '$t_id' AND ittxg_owner='$oid'");
	// 		$result = $query->result();
	// 		$data['edit_tax_group'] = $result;
			
	// 		$query = $this->db->query("SELECT * FROM i_tax_group_collection WHERE itxgc_tg_id = '$t_id'");
	// 		$result = $query->result();
	// 		$data['edit_tax_group_item'] = $result;

	// 		$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid'");
	// 		$result = $query->result();

	// 		$data['tax'] = $result;
			
	// 		$data['tid'] =$t_id;
			
	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
	// 		$ert['title'] = "Tax Group Edit";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('enterprise/tax_group_add', $data);
	// 		$this->load->view('home/search_modal');	
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function update_tax_group($tid) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {

	// 		$name = $this->input->post('name');
	// 		$taxes = $this->input->post('taxes');
			
	// 		$dt = date('Y-m-d H:i:s');
	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$data = array(
	// 			'ittxg_group_name' => $name,
	// 			'ittxg_owner' => $oid);
	// 		$this->db->where('ittxg_id', $tid);
	// 		$this->db->update('i_tax_group', $data);
			
	// 		$this->db->where('itxgc_tg_id', $tid);
	// 		$this->db->delete('i_tax_group_collection');

	// 		for ($i=0; $i < count($taxes) ; $i++) { 
	// 			$tname = $taxes[$i];
	// 			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
	// 			$result = $query->result();

	// 			if(count($result) > 0) {
	// 				$txid = $result[0]->itx_id;
	// 			} else {
	// 				$data = array(
	// 					'itx_name' => $tname,
	// 					'itx_owner' => $oid);
	// 				$this->db->insert('i_taxes', $data);
	// 				$txid = $this->db->insert_id();
	// 			}

	// 			$data1 = array(
	// 				'itxgc_tg_id' => $tid,
	// 				'itxgc_tx_id' => $txid );
	// 			$this->db->insert('i_tax_group_collection', $data1);
	// 		}

			
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function delete_tax_group($prid) {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {

	// 		$this->db->where('ittxg_id', $prid);
	// 		$this->db->delete('i_tax_group');

	// 		$this->db->where('itxgc_tg_id', $prid);
	// 		$this->db->delete('i_tax_group_collection');

	// 		redirect(base_url().'Enterprise/tax_group');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

########## TERMS ################
	public function document_terms($document,$code) {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document'");
			$result = $query->result();

			$data['doc'] = $result;
			$data['document'] = $document;
			$ert['mid']=0;$ert['mname']='';$ert['gid']=$gid;$ert['code']=$code;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['title'] = $document." Terms";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/document_terms', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_document_terms ($document,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$data = array(
				'iextdt_term' => $this->input->post('name'),
				'iextdt_document' => $document,
				'iextdt_owner' => $oid,
				'iextdt_created' => $dt,
				'iextdt_created_by' => $oid );
			$this->db->insert('i_ext_et_document_terms', $data);
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function edit_document_terms ($document, $did, $code) {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document'");
			$result = $query->result();

			$data['doc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document' AND iextdt_id = '$did'");
			$result = $query->result();
			$data['edit_doc'] = $result;
			$data['did'] = $did;

			$data['document'] = $document;
			$data['gid']=$gid;$data['code']=$code;
			$ert['mid']=0;$ert['mname']='';$ert['gid']=$gid;$ert['code']=$code;
			$ert['user_connection']=$sess_data['user_connection'];$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = $document." Terms";
			$ert['search'] = "false";

			$this->load->view('navbar',$ert);
			$this->load->view('enterprise/document_terms', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_document_terms ($document, $did,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$data = array(
				'iextdt_term' => $this->input->post('name'),
				'iextdt_document' => $document);
			$this->db->where('iextdt_id', $did);
			$this->db->update('i_ext_et_document_terms', $data);

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_document_terms ($document, $did,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$this->db->where('iextdt_id', $did);
			$this->db->delete('i_ext_et_document_terms');

			redirect(base_url().'Enterprise/document_terms/'.$document.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## INVOICE ################
	public function invoice($module_id,$code) {
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
					if ($module[$i]->mname == 'Invoice') {
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
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND a.iextein_gid = '0' AND a.iextein_txn_type = 'invoice' ORDER BY a.iextein_id DESC");
				$result = $query->result();
				$data['invoice'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND a.iextein_gid = '$gid' AND a.iextein_txn_type = 'invoice' ORDER BY a.iextein_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_gid = '$gid' AND a.iextein_created_by = '$uid' UNION SELECT * FROM i_ext_et_invoice AS c LEFT JOIN i_customers AS d ON c.iextein_customer_id=d.ic_id WHERE c.iextein_gid = '$gid' AND a.iextein_txn_type = 'invoice' AND c.iextein_id IN(SELECT iexteim_pid FROM i_ext_et_invoice_mutual WHERE iexteim_uid = '$uid' AND iexteim_oid = '$oid')");
					$result = $query->result();
					$data['invoice'] = $result;
				}
			}

			$query = $this->db->query("SELECT iextein_status FROM i_ext_et_invoice WHERE iextein_status != '' AND iextein_txn_type = 'invoice' GROUP BY iextein_status");
			$result = $query->result();
			$data['status'] = $result;

			$data['mod_id'] = $module_id;$data['gid']=$gid;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/invoice', $data);
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

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' AND AND a.iextein_txn_type = 'invoice' a.iextein_txn_id LIKE '%".$search."%' OR b.ic_name LIKE '%".$search."%' ORDER BY a.iextein_id DESC");
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
			$this->db->where('i_ext_et_invoice.iextein_txn_type', 'invoice');
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
		    // redirect(base_url().'Enterprise/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid);
	 		$page = file_get_contents(base_url().'Enterprise/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
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

			$this->db->WHERE(array('iextein_id' => $pid, 'iextein_owner' => $oid));
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
				$this->db->where(array('iextein_id' => $inid, 'iextein_owner' => $oid , 'iextein_txn_type' => 'invoice'));
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
					if ($module[$i]->mname == 'Invoice') {
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
						$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_owner = '$oid' AND iextein_txn_type = 'invoice' ");
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
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a WHERE a.iextein_id ='$tid' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'invoice' ");
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
					$this->db->WHERE(array('iextein_id'=>$tid,'iextein_owner'=>$oid, 'iextein_txn_type' => 'invoice'));
					$this->db->update('i_ext_et_invoice',array('iextein_status'=>'paid'));
				}else{
					if ($status == 'paid') {
						$this->db->WHERE(array('iextein_id'=>$tid,'iextein_owner'=>$oid, 'iextein_txn_type' => 'invoice'));
						$this->db->update('i_ext_et_invoice',array('iextein_status'=>'unpaid'));
					}
				}
				$pay['bal_amount'] = $in_amount;
				$data['tid'] = $tid;

				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$module_id' ");
				$data['helper'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$module_id' ");
				$data['help_parameter'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_invoice as a left JOIN i_ext_et_invoice_product_details as b on a.iextein_id=b.iexteinpd_d_id LEFT join i_product as c on b.iexteinpd_product_id=c.ip_id WHERE a.iextein_id ='$tid' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'invoice' ");
				$result = $query->result();	
				$data['edit_invoice'] = $result;
				$data['edit_type'] = $result[0]->iextein_type;
				$data['invoice_gid'] = $result[0]->iextein_gid;
				if ($alias == '') {
				$ert['title'] = $mname." Edit";
				}else{
					$ert['title'] = $alias." Edit";
				}
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='Invoice'");
				$result = $query->result();
				$data['term_doc'] = $result;
				$pay=0;
				if ($alias == '') {
					$ert['title'] = $mname." Add";
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
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/invoice_add', $data);
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
					if ($module[$i]->mname == 'Invoice') {
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
				'iextein_txn_type' => 'invoice'
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
				'iua_title' => 'Invoice - '.$txn_no,
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
			echo $pid;
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
					if ($module[$i]->mname == 'Invoice') {
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
			$cid ='';

			$module_id = '';

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'invoice') {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner='$oid' AND a.iextein_txn_type = 'invoice' ");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner = '$oid' AND a.iextein_txn_type = 'invoice' ");
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
            
			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_invoice_terms as b on a.iextdt_id=b.iexteintm_term_id WHERE iextdt_document='Invoice' AND iextdt_owner='$oid' AND iexteintm_inid= '$invoice_id' AND iexteintm_status = 'true' ");
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
					if ($module[$i]->mname == 'Invoice') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE('iexteintm_inid',$tid);
			$this->db->delete('i_ext_et_invoice_terms');

			$this->db->WHERE('iexteinpt_inid',$tid);
			$this->db->delete('i_ext_et_invoice_property');

			$this->db->WHERE(array('iet_type_id'=>$tid,'iet_owner' => $oid, 'iet_type' => 'invoice', 'iet_m_id' => $module_id));
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
				'iet_type' => 'invoice',
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
					'iet_type' => 'invoice',
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
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
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
				'iua_title' => 'Invoice - '.$txn_no,
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

			echo $tid;

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

	// public function invoice_email_doc_upload($code,$cname){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$dt = date('Y-m-d H:i:s');
	// 		$in_cid ='';
	// 		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
	// 		$result = $query->result();
	// 		$cid = $result[0]->ic_id;

	// 		$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
	// 		if(!file_exists($upload_dir)) {
	// 			mkdir($upload_dir, 0777, true);
	// 		}

	// 		$img_path = "";
	// 		if (is_dir($upload_dir) && is_writable($upload_dir)) {
	// 			for ($i=0; $i <count($_FILES['used']['tmp_name']) ; $i++) {
					
	// 				$sourcePath = $_FILES['used']['tmp_name'][$i]; // Storing source path of the file in a variable
	// 				$target = $upload_dir.$_FILES['used']['name'][$i]; // Target path where file is to be stored

	// 				$path_parts = pathinfo($target);
	// 				$file_name = $path_parts['filename'];
	// 				$ext = $path_parts['extension'];
	// 				$dt = date('Y-m-d H:i:s');
	// 				$dt1=date_create(); 
	// 				$dt_str = date_timestamp_get($dt1);
	// 				$timestamp_value = $i.$dt_str;

	// 				$targetPath = $upload_dir.$timestamp_value.'.'.$ext;
	// 				$img_path = $targetPath;
	// 				//print_r($targetPath);
	// 				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				
	// 				$data = array(
	// 					'icd_file' => $file_name,
	// 					'icd_owner' => $oid,
	// 					'icd_cid' => $cid,
	// 					'icd_date' => $dt,
	// 					'icd_type' => 'document',
	// 					'icd_timestamp' => $timestamp_value.'.'.$ext
	// 				);
	// 				$this->db->insert('i_c_doc', $data);
	// 				if ($in_cid == '') {
	// 					$in_cid = $this->db->insert_id();	
	// 				}else{
	// 					$in_cid .= ','.$this->db->insert_id();
	// 				}
	// 			}	
	// 			$img_path = '';
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_id IN($in_cid) AND icd_owner = '$oid'");
	// 		$result = $query->result();
	// 		$data['files']=$result;

	// 		print_r(json_encode($data));
	// 	}else{
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

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

			redirect(base_url().'Enterprise/invoice/'.$mod_id.'/'.$code);
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
				if ($module[$i]->mname == 'Invoice') {
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
				'iextein_txn_type' => 'invoice',
			);
			$this->db->insert('i_ext_et_invoice',$data);
			$inid = $this->db->insert_id();

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Invoice - '.$txn_no,
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

			$query = $this->db->query("SELECT * from i_ext_et_invoice WHERE iextein_id='$invoiceid' AND iextein_txn_type = 'invoice' ");
			$result2 = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();
			if (count($result3)>0) {

				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close();
		 		$page = file_get_contents(base_url().'Enterprise/invoice_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
			    session_start();

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/invoice/';

			    if(!file_exists($path)) {
						mkdir($path, 0777, true);
				}
			    $htmlfile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextein_txn_date)).'.html';
			    $invoicefile = $result1[0]->ic_name.'-'.date("d-m-Y", strtotime($result2[0]->iextein_txn_date)).'.pdf';

			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

				$subject = $result[0]->iud_company.' - Invoice - '.$result2[0]->iextein_txn_id;

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

########## PURCHASES ################
	public function purchase($mod_id,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$module_id = 0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase') {
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
				$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' ORDER BY a.iextep_id DESC");
				$result = $query->result();
				$data['invoice'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' AND iextep_gid = '$gid' ORDER BY a.iextep_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;		
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' AND a.iextep_created_by = '$uid' AND iextep_gid = '$gid' ORDER BY a.iextep_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;
				}
			}

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
   //          $data['use_modules'] = $query->result();

   //          $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
   //          $result = $query->result();
   //          $data['tags'] = $result;

   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
   //          $result = $query->result();
   //          $data['status'] = $result;

   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
   //          $result = $query->result();
   //          $data['place'] = $result;

   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
   //          $result = $query->result();
   //          $data['cat'] = $result;

   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
   //          $result = $query->result();
   //          $data['user_list'] = $result;

			$data['mod_id'] = $module_id;

			$query = $this->db->query("SELECT iextep_status FROM i_ext_et_purchase WHERE iextep_owner = '$oid' GROUP BY iextep_status");
			$result = $query->result();
			$data['status'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['gid'] = $gid;$ert['mid']=$module_id;$ert['mname']=$mname;$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = $mname;	
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/purchase', $data);
			$this->load->view('home/search_modal');
			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;

			$search = $this->input->post('search');
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' AND b.ic_name LIKE '%".$search."%' OR a.iextep_txn_id LIKE '%".$search."%' ORDER BY a.iextep_id DESC");
				$result = $query->result();
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' AND b.ic_name LIKE '%".$search."%' OR a.iextep_txn_id LIKE '%".$search."%' AND iextep_gid = '$gid' ORDER BY a.iextep_id DESC");
					$result = $query->result();
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS b ON a.iextep_customer_id=b.ic_id WHERE a.iextep_owner = '$oid' AND a.iextep_created_by = '$uid' AND b.ic_name LIKE '%".$search."%' OR a.iextep_txn_id LIKE '%".$search."%' AND iextep_gid = '$gid' ORDER BY a.iextep_id DESC");
					$result = $query->result();
				}
			}

			$data['purchase'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_filter($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$from_date = $this->input->post('p_from');
			$to_date = $this->input->post('p_to');
			$min_amount = $this->input->post('p_min_amount');
			$max_amount = $this->input->post('p_max_amount');
			$status = $this->input->post('p_in_status');

			$this->db->select('*');
			$this->db->from('i_ext_et_purchase');
			$this->db->join('i_customers', 'i_customers.ic_id = i_ext_et_purchase.iextep_customer_id','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('iextep_txn_date >=', $from_date);
				$this->db->where('iextep_txn_date <=', $to_date);
			}

			if ($status != '') {
				$this->db->where('iextep_status', $status);
			}
			if ($min_amount != '') {
				$this->db->where('iextep_amount >=', $min_amount);
			}
			if ($max_amount != '') {
				$this->db->where('iextep_amount <=', $max_amount);
			}
			$this->db->where('i_ext_et_purchase.iextep_owner', $oid);
			$this->db->group_by('i_ext_et_purchase.iextep_id');
			$query = $this->db->get();
			$data['filter'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_inventory_inward(){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$customer = $this->input->post('customer');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' AND a.iextei_type='inward' AND b.ic_name = '".$customer."' ORDER BY a.iextei_id DESC");
			$result = $query->result();

			$data['inward'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function purchase_inventory_inward_details(){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$txnid = $this->input->post('txnid');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id LEFT JOIN i_p_price AS c ON b.ip_id=c.ipp_p_id WHERE iexteid_owner='$oid' AND iexteid_e_id='$txnid'");
			$result = $query->result();

			$data['details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function purchase_add($code,$mod_id,$tid = null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$module_id = 0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
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
						$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_owner = '$oid'");
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

			if ($gid == 0) {
				$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid'");
				$result = $query->result();
				$data['product'] = $result;	
			}else{
				$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_gid = '$gid' ");
				$result = $query->result();
				$data['product'] = $result;
			}

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['tax'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			if ($tid != null && $tid != 'null') {

				$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a WHERE a.iextep_id ='$tid' AND a.iextep_owner = '$oid'");
				$result = $query->result();	
				$cid = $result[0]->iextep_customer_id;
				$in_amount = $result[0]->iextep_amount;
				$status = $result[0]->iextep_status;

				$query = $this->db->query("SELECT * FROM i_ext_et_purchase_terms as a left join i_ext_et_document_terms as b on a.iexteprtm_term_id=b.iextdt_id WHERE iexteprtm_inid = '$tid'");
				$data['p_terms'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='Purchase'");
				$result = $query->result();
				$data['term_doc'] = $result;

				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
				$result = $query->result();
				$data['edit_cust'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_purchase_property where iexteprpt_inid = '$tid'");
				$result = $query->result();
				$data['invoice_property'] = $result;

				$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
				$result = $query->result();
				$p_id = $result[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id = '$cid' ");
				$result = $query->result();
				$data['email_ids'] = $result;

				$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'purchase' AND iet_type_id = '$tid' AND iet_m_id = '$module_id' AND iet_owner = '$oid') ");
				$result = $query->result();
				$data['pro_tags'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_purchase_mutual as a LEFT JOIN i_customers as b on a.iexteprcm_uid = b.ic_uid WHERE iexteprcm_pid = '$tid' AND iexteprcm_oid = '$oid'");
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
					$this->db->WHERE(array('iextep_id'=>$tid,'iextep_owner'=>$oid));
					$this->db->update('i_ext_et_purchase',array('iextep_status'=>'paid'));
				}else{
					if ($status == 'paid') {
						$this->db->WHERE(array('iextep_id'=>$tid,'iextep_owner'=>$oid));
						$this->db->update('i_ext_et_purchase',array('iextep_status'=>'negotiate'));
					}
				}
				$pay['bal_amount'] = $in_amount;
				$data['tid'] = $tid;

				$query = $this->db->query("SELECT * FROM i_helper WHERE ih_from_module = '$module_id' ");
				$data['helper'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_helper_parameters as a LEFT JOIN i_helper as b on a.ihp_ih_id=b.ih_id WHERE ih_from_module = '$module_id' ");
				$data['help_parameter'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_et_purchase as a left JOIN i_ext_et_purchase_product_details as b on a.iextep_id=b.iexteppd_d_id LEFT join i_product as c on b.iexteppd_product_id=c.ip_id WHERE a.iextep_id ='$tid' AND a.iextep_owner = '$oid'");
				$result = $query->result();	
				$data['edit_invoice'] = $result;
				$data['edit_type'] = $result[0]->iextep_type;
				$data['invoice_gid'] = $result[0]->iextep_gid;
				if ($alias == '') {
					$ert['title'] = $mname." Edit";
				}else{
					$ert['title'] = $alias." Edit";
				}
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='Purchase'");
				$result = $query->result();
				$data['term_doc'] = $result;
				$pay =0;
				if ($alias == '') {
					$ert['title'] = $mname." Add";
				}else{
					$ert['title'] = $alias." Add";
				}
			}

			// $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' GROUP BY iua_place");
			// $result = $query->result();
			// $data['place'] = $result;

			// $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' GROUP BY iua_categorise");
			// $result = $query->result();
			// $data['cat'] = $result;

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			// $result = $query->result();
			// $data['user_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id LEFT JOIN i_tax_group as c on b.itxgc_tg_id=c.ittxg_id WHERE a.itx_owner = '$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$data['mod_id'] = $module_id;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['gid'] = $gid;$ert['mid']=$module_id;$ert['mname']=$mname;$ert['code']=$code;
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('payment_modal',$pay);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/purchase_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_get_price($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$product = $this->input->post('product');
			$query = $this->db->query("SELECT * FROM i_product as a left join i_p_price as b on a.ip_id = b.ipp_p_id left join i_p_taxes as c on a.ip_id = c.ipt_p_id WHERE ip_product = '$product' AND ip_created_by = '$oid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data['prod_rate'] = $result[0]->ipp_sell_price;
				$data['prod_tax'] = $result[0]->ipt_t_id;
				print_r(json_encode($data));
			}else{
				echo "false";
			}
		}else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_purchase($type,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$status = $this->input->post('status');
			$product = $this->input->post('product');
			$amount = $this->input->post('amount');
			$dt = date('Y-m-d H:i:s');
			$note = $this->input->post('note');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$wrnt = $this->input->post('wrt_mnt');
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];
			$module_id = 0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Purchase') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();

			if (count($result)>0) {
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
				'iextep_customer_id' => $cid,
				'iextep_txn_id' => $txn_no,
				'iextep_txn_date' => $txn_date,
				'iextep_type' => 'active',
				'iextep_amount' => $amount,
				'iextep_note' => $note,
				'iextep_status' => $status,
				'iextep_owner' => $oid,
				'iextep_created' => $dt,
				'iextep_created_by' => $uid,
				'iextep_gid' => $gid,
				'iextep_warranty' => $wrnt
			);
			$this->db->insert('i_ext_et_purchase', $data);
			$inid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iexteprtm_inid' => $inid,
						'iexteprtm_term_id' => $terms[$i]['id'],
						'iexteprtm_status' => $status
					);	
					$this->db->insert('i_ext_et_purchase_terms',$data);	
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
							'iexteprcm_pid' => $inid,
							'iexteprcm_uid' => $m_uid,
							'iexteprcm_oid' => $oid
						);
						$this->db->insert('i_ext_et_purchase_mutual',$data);
					}
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
					'iet_type' => 'purchase',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteprpt_inid' => $inid,
						'iexteprpt_property_value' => $property[$i]['value'],
						'iexteprpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_purchase_property',$data);
				}
			}

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Purchase - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $oid,
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

			$data1 = array(
				'in_type_id' => $inid, 
				'in_type' => 'purchase',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

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
					'iexteppd_d_id' => $inid,
					'iexteppd_product_id' => $prid,
					'iexteppd_rate' => $product[$i]['rate'],
					'iexteppd_qty' => $product[$i]['qty'],
					'iexteppd_discount' => $product[$i]['disc'],
					'iexteppd_amount' => $p_total,
					'iexteppd_serial_number' => $product[$i]['sn'],
					'iexteppd_tax' => $product[$i]['tax_id'],
					'iexteppd_owner' => $oid,
					'iexteppd_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_purchase_product_details',$data);
			}

			$data['cid'] = $cid;
			$data['tid'] = $inid;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_doc_upload($code,$pid,$cid){
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
					if ($module[$i]->function == 'purchase') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			// $query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cname' AND ic_owner = '$oid'");
			// $result = $query->result();
			// $cid = $result[0]->ic_id;

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

	public function purchase_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextep_id' => $pid, 'iextep_owner' => $oid));
			$this->db->update('i_ext_et_purchase',array('iextep_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function purchase_transfer_user($code,$inid){
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
					'iextep_created_by' => $p_uid
				);
				$this->db->where(array('iextep_id' => $inid, 'iextep_owner' => $oid));
				$this->db->update('i_ext_et_purchase',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function purchase_download($flg,$mod_id,$invoiceid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
	 		$page = file_get_contents(base_url().'Enterprise/purchase_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/purchase/';

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
		    	redirect(base_url().'assets/data/'.$oid.'/purchase/'.$invoicefile);
		    }
		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function purchase_update($type,$code,$tid){
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
			$status = $this->input->post('status');
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$wrnt = $this->input->post('wrt_mnt');
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'purchase') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->WHERE('iexteprcm_pid',$tid);
			$this->db->delete('i_ext_et_purchase_mutual');

			$this->db->WHERE('iet_type_id',$tid);
			$this->db->delete('i_ext_tags');

			$this->db->WHERE('iexteprtm_inid',$tid);
			$this->db->delete('i_ext_et_purchase_terms');

			$this->db->WHERE('iexteprpt_inid',$tid);
			$this->db->delete('i_ext_et_purchase_property');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;
			$c_uid = $result[0]->ic_uid;

			$data = array(
				'iextep_customer_id' => $cid, 
				'iextep_txn_id' => $txn_no,
				'iextep_txn_date' => $dt,
				'iextep_type' => $type,
				'iextep_amount' => $amount,
				'iextep_status' => $status,
				'iextep_note' => $note,
				'iextep_modified' => $dt,
				'iextep_modified_by' => $uid,
				'iextep_status' => $status,
				'iextep_warranty' => $wrnt
			);
			$this->db->WHERE(array('iextep_id'=> $tid , 'iextep_owner' => $oid));
			$this->db->update('i_ext_et_purchase',$data);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Purchase - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $oid,
				'iua_created' => $dt,
				'iua_status' => 'close',
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
				'iuap_p_id' => $c_uid,
				'iuap_owner' => $oid
			);
			$this->db->insert('i_u_a_person',$data);

			if (count($mutual) > 0) {
				$mflg = 1;
				for ($i=0; $i <count($mutual) ; $i++) { 
					$m_name = $mutual[$i];

					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$m_name' AND ic_owner = '$oid'");
					$result = $query->result();
					$m_uid = $result[0]->ic_uid;
					if ($m_uid != '') {
						$data = array(
							'iexteprcm_pid' => $inid,
							'iexteprcm_uid' => $m_uid,
							'iexteprcm_oid' => $oid
						);
						$this->db->insert('i_ext_et_purchase_mutual',$data);
					}
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
					'iet_type_id' => $tid,
					'iet_type' => 'purchase',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

			if (count($terms) > 0) {
				for ($i=0; $i < count($terms) ; $i++) {
					$data = array(
						'iexteprtm_inid' => $tid,
						'iexteprtm_term_id' => $terms[$i]['id'],
						'iexteprtm_status' => $terms[$i]['status']
					);
					$this->db->insert('i_ext_et_purchase_terms',$data);
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iexteprpt_inid' => $tid,
						'iexteprpt_property_value' => $property[$i]['value'],
						'iexteprpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_purchase_property',$data);
				}
			}

			$data1 = array(
				'in_type_id' => $tid, 
				'in_type' => 'purchase',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$this->db->WHERE('iexteppd_d_id',$tid);
			$this->db->delete('i_ext_et_purchase_product_details');

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
					'iexteppd_d_id' => $tid,
					'iexteppd_product_id' => $prid,
					'iexteppd_rate' => $product[$i]['rate'],
					'iexteppd_qty' => $product[$i]['qty'],
					'iexteppd_discount' => $product[$i]['disc'],
					'iexteppd_amount' => $p_total,
					'iexteppd_serial_number' => $product[$i]['sn'],
					'iexteppd_tax' => $product[$i]['tax_id'],
					'iexteppd_owner' => $oid,
					'iexteppd_alias' => $product[$i]['alias']
				);
				$this->db->INSERT('i_ext_et_purchase_product_details',$data);
			}

			$data['cid'] = $cid;
			$data['tid'] = $tid;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function purchase_delete($code,$mod_id,$prid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$this->db->where('iextep_id', $prid);
			$this->db->delete('i_ext_et_purchase');

			$this->db->where('iexteppd_d_id',$prid);
			$this->db->delete('i_ext_et_purchase_product_details');

			$this->db->where('iexteprpt_inid', $prid);
			$this->db->delete('i_ext_et_purchase_property');

			$this->db->WHERE('iexteprtm_inid',$prid);
			$this->db->delete('i_ext_et_purchase_terms');

			$this->db->WHERE('iexteprcm_pid',$prid);
			$this->db->delete('i_ext_et_purchase_mutual');

			redirect(base_url().'Enterprise/purchase/'.$mod_id.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_print($code,$mod_id, $invoice_id) {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers As b ON a.iextep_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextep_id='$invoice_id' AND a.iextep_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_purchase AS a LEFT JOIN i_customers As b ON a.iextep_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextep_id='$invoice_id' AND a.iextep_owner='$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextep_txn_id;
				$data['s_txn_date'] = $result[0]->iextep_txn_date;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextep_txn_id;
				$data['s_txn_date'] = $result[0]->iextep_txn_date;
			}

			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$u_owner'");
			$result = $query->result();
			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase_property WHERE iexteprpt_inid ='$invoice_id' AND iexteprpt_status = 'true' ");
			$result = $query->result();
			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase WHERE iextep_id='$invoice_id'");
			$result = $query->result();
			$data['note']=$result[0]->iextep_note;

			$query = $this->db->query("SELECT * FROM i_ext_et_purchase_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteppd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON a.iexteppd_tax = c.ittxg_id LEFT JOIN i_product AS d ON a.iexteppd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id WHERE a.iexteppd_d_id='$invoice_id' AND a.iexteppd_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

            $query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id WHERE itx_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;
            
			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_purchase_terms as b on a.iextdt_id=b.iexteprtm_term_id WHERE iextdt_document='Purchase' AND iextdt_owner='$oid' AND iexteprtm_inid= '$invoice_id' AND iexteprtm_status = 'true' ");
			$result = $query->result();
			$data['terms'] = $result;

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

	public function save_purchase_mail($mod_id,$inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$mail_id = $this->input->post('cust_mail_id');
			$email = '';
			$query = $this->db->query("SELECT iextep_customer_id FROM i_ext_et_purchase WHERE iextep_id='$inid' AND iextep_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iextep_customer_id;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];

					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						 echo $this->send_purchase_email($email, $mod_id, $inid,$code);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);

						echo $this->send_purchase_email($email, $mod_id, $inid,$code);
					}
				}$email = '';
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function send_purchase_email($uid, $mod_id, $invoiceid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid')");
			$result1 = $query->result();

			$query = $this->db->query("SELECT * from i_ext_et_purchase WHERE iextep_id='$invoiceid'");
			$result2 = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();
			if (count($result3)>0) {

				$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
			    $context = stream_context_create($opts);
			    session_write_close(); // unlock the file
		 		$page = file_get_contents(base_url().'Enterprise/purchase_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
			    session_start(); // unlock the file

			    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/purchase/';

			    if(!file_exists($path)) {
						mkdir($path, 0777, true);
				}
				$cname = str_replace(' ', '_', $result1[0]->ic_name);
			    $htmlfile = $cname.'-'.date("d-m-Y", strtotime($result2[0]->iextep_txn_date)).'.html';
			    $invoicefile = $cname.'-'.date("d-m-Y", strtotime($result2[0]->iextep_txn_date)).'.pdf';
			    file_put_contents($path.$htmlfile, $page);
			    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

				$subject = $result[0]->iud_company.' - Purchase - '.$result2[0]->iextep_txn_id;

				$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
				<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached purchase and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
				$attach = $path.$invoicefile;
				$this->Mail->send_mail($subject,$uid,$attach,$body,$code);

				echo "true";
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
				// 	$this->email->to($uid);
				// 	$this->email->subject($subject);
				// 	$this->email->message($body);
				// 	$this->email->attach($path.$invoicefile);
				// 	$this->email->send();
		  //           echo "true";
		 	// 		// echo $this->email->print_debugger();	
				// } catch (Exception $e) {
				// 	echo "Exception";
				// }
			}else {
				echo "enter";
			}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

########## QUOTATION ################
	public function quotation($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers AS b ON a.iexteq_customer_id=b.ic_id WHERE a.iexteq_owner = '$oid' ORDER BY a.iexteq_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			$data['mod_id'] = $mod_id;

			$query = $this->db->query("SELECT iexteq_status FROM i_ext_et_quotation GROUP BY iexteq_status");
			$result = $query->result();
			$data['status'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Quotation";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/quotation', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_search() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers AS b ON a.iexteq_customer_id=b.ic_id WHERE a.iexteq_owner = '$oid' AND b.ic_name LIKE '%".$search."%' or a.iexteq_txn_id LIKE '%".$search."%' ORDER BY a.iexteq_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_filter() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$from_date = $this->input->post('from');
			$to_date = $this->input->post('to');
			$min_amount = $this->input->post('min_amount');
			$max_amount = $this->input->post('max_amount');
			$status = $this->input->post('in_status');

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers AS b ON a.iexteq_customer_id=b.ic_id WHERE a.iexteq_owner = '$oid' AND (a.iexteq_amount BETWEEN '$min_amount' AND '$max_amount') OR (a.iexteq_txn_date BETWEEN '$from_date' AND '$to_date') OR (a.iexteq_status = '$status') ORDER BY a.iexteq_id DESC");
			$result = $query->result();
			$data['invoice'] = $result;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function quotation_mail($mod_id,$inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id IN (SELECT iexteq_customer_id FROM i_ext_et_quotation WHERE iexteq_id='$inid' AND iexteq_owner='$oid')");
			$result = $query->result();
			if (count($result) > 0) {
				echo $this->send_quotation_email($result[0]->icbd_value, $mod_id, $inid);
			//echo "email_sent";
			}else{
				echo "false";
			}
			
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_download($flg,$mod_id,$invoiceid){

		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
	 		$page = file_get_contents(base_url().'Enterprise/quotation_print/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/quotation/';

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
		    	redirect(base_url().'assets/data/'.$oid.'/quotation/'.$invoicefile);
		    }

		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function save_quotation_mail($mod_id,$inid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$mail_id = $this->input->post('cust_mail_id');
			$email = '';
			$query = $this->db->query("SELECT iexteq_customer_id FROM i_ext_et_quotation WHERE iexteq_id='$inid' AND iexteq_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iexteq_customer_id;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			// $query1 = $this->db->query("INSERT INTO i_c_basic_details (icbd_customer_id,icbd_value) VALUES ('$cust_id','$mail_id')");
			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];
					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						 echo $this->send_quotation_email($email, $mod_id, $inid);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);

						echo $this->send_quotation_email($email, $mod_id, $inid);
					}
				}$email = '';
			}
			
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function send_quotation_email($uid, $mod_id, $invoiceid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
		$result = $query->result();

		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid')");
		$result1 = $query->result();

		$query = $this->db->query("SELECT * from i_ext_et_quotation WHERE iexteq_id='$invoiceid'");
		$result2 = $query->result();

		$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
		$result3=$query3->result();
		if (count($result3)>0) {

		$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
	    $context = stream_context_create($opts);
	    session_write_close(); // unlock the file
 		$page = file_get_contents(base_url().'Enterprise/quotation_print/'.$mod_id.'/'.$invoiceid, false, $context);
	    session_start(); // unlock the file

	    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/quotation/';

	    if(!file_exists($path)) {
				mkdir($path, 0777, true);
		}
	    $htmlfile = $result1[0]->ic_name.'-'.$result2[0]->iexteq_txn_id.'-'.date("d-m-Y", strtotime($result2[0]->iexteq_txn_date)).'.html';
	    $invoicefile = $result1[0]->ic_name.'-'.$result2[0]->iexteq_txn_id.'-'.date("d-m-Y", strtotime($result2[0]->iexteq_txn_date)).'.pdf';
	    file_put_contents($path.$htmlfile, $page);
	    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

		$subject = $result[0]->iud_company.' - QUOTATION - '.$result2[0]->iexteq_txn_id;

		$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
		<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached invoice and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
		try {
			$config = array();
	        $config['useragent'] = "CodeIgniter";
	        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	        $config['protocol'] = "smtp";
	        $config['smtp_host'] = $result3[0]->iumail_domain;
	        $config['smtp_user'] = $result3[0]->iumail_mail;
	        $config['smtp_pass'] = $result3[0]->iumail_password;
	        $config['smtp_port'] = $result3[0]->iumail_port;
	        $config['mailtype'] = 'html';
	        $config['charset'] = 'utf-8';
	        $config['newline'] = "\r\n";
	        $config['wordwrap'] = TRUE;

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from($result3[0]->iumail_mail);
			$this->email->to($uid);
			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->attach($path.$invoicefile);
			$this->email->send();
            echo "true";
 			//echo $this->email->print_debugger();	
		} catch (Exception $e) {
			echo "Exception";
		}
			
		}else {
			echo "enter";
		}
		
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_inventory_outward(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$customer = $this->input->post('customer');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' AND a.iextei_type='outward' AND b.ic_name = '".$customer."' ORDER BY a.iextei_id DESC");
			$result = $query->result();

			$data['outward'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function quotation_inventory_outward_details(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$txnid = $this->input->post('txnid');

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id LEFT JOIN i_p_price AS c ON b.ip_id=c.ipp_p_id WHERE iexteid_owner='$oid' AND iexteid_e_id='$txnid'");
			$result = $query->result();

			$data['details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function quotation_add($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/quotation/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			// print_r($sess_data['user_mod']);
			$data["mod_id"] = $mod_id;

			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$mod_id' ORDER BY iumdi_id;");
			$result = $query->result();

			$data['syntax'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group");
			$result = $query->result();
			$data['tax'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid'");
			$result = $query->result();
			
			if(count($result) > 0) {
			    $data['ac_year'] = $result[0]->iua_year_code;
    			$start_yr = $result[0]->iua_start_date;
    			$end_yr = $result[0]->iua_end_date;
			} else {
			    $data['ac_year'] = 'N/A';
    			$start_yr = 'N/A';
    			$end_yr = 'N/A';
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_et_quotation WHERE iexteq_txn_date BETWEEN '$start_yr' AND '$end_yr' AND iexteq_owner = '$oid'");
			$result = $query->result();

			$a = count($result);
			if(count($result) > 0) {
				$data['inv_num'] = $a + 1;	
			} else {
				$data['inv_num'] = 1;
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='customer'");
			$result = $query->result();
			$data['customer'] = $result;

            $query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Quotation' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid' AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Quotation Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/quotation_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_get_price() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$product = $this->input->post('product');
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$product' AND ip_owner = '$oid' AND ip_gid = '$gid' ");
			$result = $query->result();

			if (count($result) > 0) {
				$pid = $result[0]->ip_id;
				$que = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$pid'");
				$res = $que->result();

				if(count($res) > 0) {
					$cnt = count($res) - 1;
					echo $res[$cnt]->ipp_sell_price;
				} else {
					echo "0";
				}
			}
		}
	}

	public function save_quotation($flg,$mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			// $txn_amount = $this->input->post('txn_amt');
			$txn_note = $this->input->post('txn_note');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$rate = $this->input->post('rate');
			$disc = $this->input->post('disc');
			$sn = $this->input->post('sn');
			$tax =$this->input->post('tax');
			$tax_id = $this->input->post('tax_id');
			$alias = $this->input->post('alias');
			$tags = $this->input->post('tags');
            $terms = $this->input->post('terms');

            $module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'quotation') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
            
			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='customer' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'customer';
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			if ($flg == 1) {
				$status = 'draft';
			}else{
				$status = $this->input->post('txn_status');
 			}

			$data = array(
				'iexteq_customer_id' => $cid,
				'iexteq_txn_id' => $txn_no,
				'iexteq_txn_date' => $txn_date,
				'iexteq_type' => 'active',
				// 'iextein_amount' => $txn_amount,
				'iexteq_note' => $txn_note,
				'iexteq_status' => $status,
				'iexteq_owner' => $oid,
				'iexteq_created' => $dt,
				'iexteq_created_by' => $oid);
			$this->db->insert('i_ext_et_quotation', $data);
			$inid = $this->db->insert_id();

			$data1 = array(
				'in_type_id' => $inid, 
				'in_type' => 'quotation',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$txn_amount = 0;
			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				$tmp_qty = $qty[$i];
				$tmp_rate = $rate[$i];
				$tmp_disc = $disc[$i];
				$srno = $sn[$i];

				$tmp_disc_calc = 0;
				if (strpos($tmp_disc, "%") !== false) {
					$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
					$tmp_disc_calc = (float)$ptst;

					$tmp_amt = $tmp_rate*$tmp_qty;
					$tmp_amt = ($tmp_amt - ($tmp_amt * $tmp_disc_calc) / 100);
				} else {
					$tmp_disc_calc = (float)$tmp_disc;

					$tmp_amt = $tmp_rate*$tmp_qty;
					$tmp_amt = $tmp_amt - $tmp_disc_calc;
				}
								
				$txn_amount = $txn_amount + $tmp_amt;

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if (count($result) <= 0) {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				} else {
					$prid = $result[0]->ip_id;
				}

				$data = array(
					'iexteqpd_d_id' => $inid,
					'iexteqpd_product_id' => $prid,
					'iexteqpd_rate' => $tmp_rate,
					'iexteqpd_qty' => $tmp_qty,
					'iexteqpd_discount' => $tmp_disc,
					'iexteqpd_serial_number' => $srno,
					'iexteqpd_amount' => $tmp_amt,
					'iexteqpd_tax'=>$tax_id[$i],
					'iexteqpd_alias' => $alias[$i],
					'iexteqpd_owner' => $oid);
				$this->db->insert('i_ext_et_quotation_product_details', $data);
				$ptxnid = $this->db->insert_id();


				$que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
				$res = $que->result();

				for ($j=0; $j < count($res) ; $j++) { 
					$tx_percent = $res[$j]->itx_percent;
					$tx_name = $res[$j]->itx_name;
					$tx_id = $res[$j]->itx_id;

					$tx_amt = $tmp_amt * $tx_percent / 100;

					$txn_amount = $txn_amount + $tx_amt;
					$data2 = array(
						'iexteqpt_d_id' => $inid,
						'iexteqpt_p_id' => $ptxnid,
						'iexteqpt_t_id' => $tx_id,
						'iexteqpt_t_name' => $tx_name,
						'iexteqpt_t_percent' => $tx_percent,
						'iexteqpt_t_amount' => $tx_amt
					);
					$this->db->insert("i_ext_et_quotation_product_taxes", $data2);
				}

				// if(count($result)>0) {
				// 	$prid = $result[0]->ip_id;

				// 	$que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
				// 	$res = $que->result();

				// 	for ($j=0; $j < count($res) ; $j++) { 
				// 		$tx_percent = $res[$j]->itx_percent;
				// 		$tx_name = $res[$j]->itx_name;
				// 		$tx_id = $res[$j]->itx_id;

				// 		$tx_amt = $tmp_amt * $tx_percent / 100;

				// 		$txn_amount = $txn_amount + $tx_amt;

				// 		$data2 = array(
				// 			'iexteinpt_d_id' => $inid,
				// 			'iexteinpt_p_id' => $prid,
				// 			'iexteinpt_t_id' => $tx_id,
				// 			'iexteinpt_t_name' => $tx_name,
				// 			'iexteinpt_t_percent' => $tx_percent,
				// 			'iexteinpt_t_amount' => $tx_amt
				// 		);

				// 		$this->db->insert("i_ext_et_invoice_product_taxes", $data2);
				// 	}
				// } else {
				// 	$data1 = array(
				// 		'ip_product' => $pd,
				// 		'ip_section' => 'Products',
				// 		'ip_owner' => $oid,
				// 		'ip_created' => $dt,
				// 		'ip_created_by' => $oid );
				// 	$this->db->insert('i_product', $data1);
				// 	$prid = $this->db->insert_id();
				// }

				// $data = array(
				// 	'iexteinpd_d_id' => $inid,
				// 	'iexteinpd_product_id' => $prid,
				// 	'iexteinpd_rate' => $tmp_rate,
				// 	'iexteinpd_qty' => $tmp_qty,
				// 	'iexteinpd_discount' => $tmp_disc,
				// 	'iexteinpd_amount' => $tmp_amt,
				// 	'iexteinpd_owner' => $oid);
				// $this->db->insert('i_ext_et_invoice_product_details', $data);
			}

			$data = array(
				'iexteq_amount' => $txn_amount,
			);
			$this->db->where('iexteq_id', $inid);
			$this->db->update('i_ext_et_quotation', $data);


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
					'iexteint_txn_id' => $inid,
					'iexteint_tag_id' => $tid);

				$this->db->insert('i_ext_et_quotation_tags', $data4);

				$data5 = array(
					'iet_type_id' => $inid,
					'iet_type' => 'quotation',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

            $deldata = array(
                "iexteqtm_q_id" => $inid,
                "iexteqtm_owner" => $oid
                );
                
            $this->db->where($deldata);
            $this->db->delete('i_ext_et_quotation_terms');
            
            
            for($i=0; $i < count($terms); $i++) {
                $tmp_term = $terms[$i];
                
                $query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_term = '$tmp_term' AND iextdt_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'iextdt_term' => $tmp_term,
						'iextdt_document' => 'Quotation',
						'iextdt_owner' => $oid,
						'iextdt_created' => $dt,
						'iextdt_created_by' => $oid);

					$this->db->insert('i_ext_et_document_terms', $data3);
				}

				$data4 = array(
					'iexteqtm_q_id' => $inid,
					'iexteqtm_terms' => $tmp_term,
					'iexteqtm_owner' => $oid);

				$this->db->insert('i_ext_et_quotation_terms', $data4);
                
            }
            redirect(base_url().'Enterprise/module_activity/'.$cid.'/'.$txn_no.'/quotation/'.$inid.'/create');
			// echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_print($mod_id, $invoice_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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


			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers As b ON a.iexteq_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iexteq_id='$invoice_id' AND a.iexteq_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers As b ON a.iexteq_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iexteq_id='$invoice_id' AND a.iexteq_owner = '$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iexteq_txn_id;
				$data['s_txn_date'] = $result[0]->iexteq_txn_date;
				$data['s_txn_note'] = $result[0]->iexteq_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iexteq_txn_id;
				$data['s_txn_date'] = $result[0]->iexteq_txn_date;
				$data['s_txn_note'] = $result[0]->iexteq_note;
			}


			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$u_owner'");
			$result = $query->result();

			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers As b ON a.iexteq_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iexteq_id='$invoice_id'");
			$result = $query->result();
			
			if(count($result) > 0) {
				$data['s_gst'] = $result[0]->icbd_value;
			} else {
				$data['s_gst'] = '';
			}


			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteqpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON b.ipt_t_id=c.ittxg_id LEFT JOIN i_product AS d ON a.iexteqpd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id WHERE a.iexteqpd_d_id='$invoice_id'");
			$result = $query->result();
			$data['details'] = $result;

            $query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;
            
			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_product_taxes WHERE iexteqpt_d_id='$invoice_id'");
			$result = $query->result();
			$data['quotation_taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_terms WHERE iexteqtm_q_id='$invoice_id' AND iexteqtm_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;

			$data['s_title'] = "Quotation";

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;

			$query1 = $this->db->query("SELECT * FROM i_template WHERE itemp_id IN (SELECT iut_tempid FROM i_user_template WHERE iut_owner = '$oid' AND iut_mid = '$mod_id');");
			$result = $query1->result();
			$temp_id = $result[0]->itemp_id;

			$query = $this->db->query("SELECT * FROM i_u_t_copies WHERE iutc_owner = '$oid' AND iutc_mod_id = '$mod_id' AND iutc_temp_id = '$temp_id'");
			$result = $query->result();
			$data['temp_copies']=$result;
			foreach ($query1->result() as $user)
			{
			        $template_name = "template/$user->itemp_file_name"; 
			}
			$this->load->view("$template_name", $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_edit($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/quotation/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='customer'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid'  AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_terms WHERE iexteqtm_q_id='$inid' AND iexteqtm_owner='$oid'");
			$result = $query->result();
			$data['edit_terms'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation AS a LEFT JOIN i_customers AS b ON a.iexteq_customer_id=b.ic_id WHERE a.iexteq_owner='$oid' AND a.iexteq_id='$inid'");	
			$result = $query->result();
			$cid = $result[0]->iexteq_customer_id;

			$data['edit_invoice'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_product_details AS a LEFT JOIN i_product AS b ON a.iexteqpd_product_id=b.ip_id WHERE a.iexteqpd_owner='$oid' AND a.iexteqpd_d_id='$inid'");	
			$result = $query->result();
			$data['edit_invoice_details'] = $result;

			// $query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			// $result = $query->result();
			// $data['serial_number'] = $result;

			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_ext_et_quotation_tags WHERE iexteqt_txn_id='$inid'");	
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id IN (SELECT iexteq_customer_id FROM i_ext_et_quotation WHERE iexteq_owner = '$oid' AND iexteq_id = '$inid')");
			$result = $query->result();
			$data['email_ids'] = $result;

			$data['payment_doc_type'] = "Quotation";
			$data['payment_doc_id'] = $inid;
			$data['payment_client'] = $cid;

			$query = $this->db->query("SELECT * FROM i_tax_group");
			$result = $query->result();
			$data['tax'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Edit quotation";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/quotation_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function quotation_delete_product() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$txnid = $this->input->post('txnid');
			$docid = $this->input->post('docid');

			$data = array('iexteqpd_owner' => $oid , 'iexteqpd_d_id' => $docid, 'iexteqpd_id' => $txnid );
			$this->db->where($data);
			$this->db->delete('i_ext_et_quotation_product_details');
		}
	}

	public function update_quotation($flg,$mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			// $txn_amount = $this->input->post('txn_amt');
			$txn_note = $this->input->post('txn_note');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$rate = $this->input->post('rate');
			$disc = $this->input->post('disc');
			$sn = $this->input->post('sn');
			$alias = $this->input->post('alias');
			$tags = $this->input->post('tags');
            $terms = $this->input->post('terms');
            $tax =$this->input->post('tax');
			$tax_id = $this->input->post('tax_id');
            
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'quotation') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='customer' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'customer';
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$this->db->where('iexteqpd_d_id', $inid);
			$this->db->delete('i_ext_et_quotation_product_details');

			$this->db->where('iexteqpt_d_id', $inid);
			$this->db->delete('i_ext_et_quotation_product_taxes');

			$txn_amount = 0;
			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				$tmp_qty = $qty[$i];
				$tmp_rate = $rate[$i];
				$tmp_disc = $disc[$i];
				$srno = $sn[$i];
				

				$tmp_disc_calc = 0;
				if (strpos($tmp_disc, "%") !== false) {
					$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
					$tmp_disc_calc = (float)$ptst;

					$tmp_amt = $tmp_rate*$tmp_qty;
					$tmp_amt = ($tmp_amt - ($tmp_amt * $tmp_disc_calc) / 100);
				} else {
					$tmp_disc_calc = (float)$tmp_disc;

					$tmp_amt = $tmp_rate*$tmp_qty;
					$tmp_amt = $tmp_amt - $tmp_disc_calc;
				}

				$txn_amount = $txn_amount + $tmp_amt;

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();


				if (count($result) <= 0) {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				} else {
					$prid = $result[0]->ip_id;
				}

				$data = array(
					'iexteqpd_d_id' => $inid,
					'iexteqpd_product_id' => $prid,
					'iexteqpd_rate' => $tmp_rate,
					'iexteqpd_qty' => $tmp_qty,
					'iexteqpd_discount' => $tmp_disc,
					'iexteqpd_serial_number' => $srno,
					'iexteqpd_tax'=>$tax_id[$i],
					'iexteqpd_amount' => $tmp_amt,
					'iexteqpd_alias' => $alias[$i],
					'iexteqpd_owner' => $oid);
				$this->db->insert('i_ext_et_quotation_product_details', $data);
				$ptxnid = $this->db->insert_id();


				if($tax_id[$i]=="") {
					$que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
					$res = $que->result();
				} else {
					$que = $this->db->query("SELECT * FROM i_tax_group AS a LEFT JOIN i_tax_group_collection AS b ON a.ittxg_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE a.ittxg_owner='$oid' AND a.ittxg_id='$tax_id[$i]'");
					$res = $que->result();
				}

				for ($j=0; $j < count($res) ; $j++) { 
					$tx_percent = $res[$j]->itx_percent;
					$tx_name = $res[$j]->itx_name;
					$tx_id = $res[$j]->itx_id;

					$tx_amt = $tmp_amt * $tx_percent / 100;

					$txn_amount = $txn_amount + $tx_amt;
					$data2 = array(
						'iexteqpt_d_id' => $inid,
						'iexteqpt_p_id' => $ptxnid,
						'iexteqpt_t_id' => $tx_id,
						'iexteqpt_t_name' => $tx_name,
						'iexteqpt_t_percent' => $tx_percent,
						'iexteqpt_t_amount' => $tx_amt
					);
					$this->db->insert("i_ext_et_quotation_product_taxes", $data2);
				}
			}

			if ($flg == 1) {
				$status = 'draft';
			}else{
				$status = $this->input->post('txn_status');
 			}

			$data = array(
				'iexteq_customer_id' => $cid,
				'iexteq_txn_id' => $txn_no,
				'iexteq_txn_date' => $txn_date,
				'iexteq_status' => $status,
				'iexteq_type' => 'active',
				'iexteq_amount' => $txn_amount,
				'iexteq_note' => $txn_note,
				// 'iextein_status' => 'unpaid',
				// 'iextein_owner' => $oid,
				// 'iextein_created' => $dt,
				// 'iextein_created_by' => $oid
			);
			$this->db->where('iexteq_id', $inid);
			$this->db->update('i_ext_et_quotation', $data);

			$this->db->where('iexteqt_txn_id', $inid);
			$this->db->delete('i_ext_et_quotation_tags');

			$this->db->WHERE('iet_type_id',$tid);
			$this->eb->delete('i_ext_tags');

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
					'iexteqt_txn_id' => $inid,
					'iexteqt_tag_id' => $tid);
				$this->db->insert('i_ext_et_quotation_tags', $data4);

				$data5 = array(
					'iet_type_id' => $inid,
					'iet_type' => 'quotation',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}

            $deldata = array(
                "iexteqtm_q_id" => $inid,
                "iexteqtm_owner" => $oid
                );
                
            $this->db->where($deldata);
            $this->db->delete('i_ext_et_quotation_terms');
            
            
            for($i=0; $i < count($terms); $i++) {
                $tmp_term = $terms[$i];
                
                $query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_term = '$tmp_term' AND iextdt_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'iextdt_term' => $tmp_term,
						'iextdt_document' => 'Quotation',
						'iextdt_owner' => $oid,
						'iextdt_created' => $dt,
						'iextdt_created_by' => $oid);

					$this->db->insert('i_ext_et_document_terms', $data3);
				}

				$data4 = array(
					'iexteqtm_q_id' => $inid,
					'iexteqtm_terms' => $tmp_term,
					'iexteqtm_owner' => $oid);

				$this->db->insert('i_ext_et_quotation_terms', $data4);
                
            }
            redirect(base_url().'Enterprise/module_activity/'.$cid.'/'.$txn_no.'/quotation/'.$inid.'/update');
			// echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_quotation($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$this->db->where('ip_id', $prid);
			$this->db->delete('i_product');

			$this->db->where('ipp_p_id',$prid);
			$this->db->delete('i_p_price');

			
			$this->db->where('ipf_product_id', $prid);
			$this->db->delete('i_p_features');

			$this->db->where('ipft_product_id', $prid);
			$this->db->delete('i_p_f_tags');

			redirect(base_url().'Enterprise/products');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## PAYMENTS ################
	public function record_payment($mod_id, $type, $doc_id, $cus_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			if ($type == "Invoice") {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner='$oid' AND a.iextein_id='$doc_id'");	
				$result = $query->result();

				$data['doc_client'] = $result[0]->ic_name;
				$data['doc_type'] = $type;
				$data['doc_id'] = $result[0]->iextein_txn_id;
				$data['doc_date'] = $result[0]->iextein_txn_date;
				$data['doc_amount'] = $result[0]->iextein_amount;
				$data['doc_note'] = $result[0]->iextein_note;
				$data['doc_status'] = $result[0]->iextein_status;
				$data['doc_url'] = base_url().'Enterprise/invoice_print/'.$mod_id.'/'.$doc_id;
				$data['mail'] = base_url().'Enterprise/mail/'.$mod_id.'/'.$doc_id;
			}

			$query = $this->db->query("SELECT * FROM i_pay_mode WHERE ipm_owner = '$oid'");
			$result = $query->result();
			$data['mode'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextpay_doc_type='$type' AND iextpay_doc_id = '$doc_id' AND  iextpay_customer_id='$cus_id' AND iextpay_owner = '$oid'");
			$result = $query->result();
			$data['records'] = $result;

			$data['type'] = $type;
			$data['doc_id'] = $doc_id;
			$data['cus_id'] = $cus_id;
			$data['mod_id'] = $mod_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Record Payment";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/record_payment', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	
	public function update_payment_record($type, $doc_id, $cus_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$mode = $this->input->post('mode');

			for ($i=0; $i < count($mode) ; $i++) { 
				$md = $mode[$i];

				$query = $this->db->query("SELECT * FROM i_pay_mode WHERE ipm_mode='$md' AND ipm_owner='$oid'");
				$result = $query->result();

				if(count($result) > 0){
					$mid = $result[0]->ipm_id;
				} else {
					$data1 = array(
						'ipm_mode' => $md,
						'ipm_owner' => $oid );
					$this->db->insert('i_pay_mode', $data1);
					$mid = $this->db->insert_id();
				}
				
				$data = array(
					'iextpay_customer_id' => $cus_id,
					'iextpay_doc_type' => $type,
					'iextpay_doc_id' => $doc_id,
					'iextpay_amount' => $this->input->post("amount"),
					'iextpay_mode' => $mid,
					'iextpay_instrument' => $this->input->post('instrument'),
					'iextpay_date' => $this->input->post('date'),
					'iextpay_details' => $this->input->post('details'),
					'iextpay_status' => 'clear',
					'iextpay_owner' => $oid,
					'iextpay_created' => $dt,
					'iextpay_created_by' => $oid);	
				$this->db->insert('i_ext_et_payment', $data);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextpay_doc_type='$type' AND iextpay_doc_id = '$doc_id' AND  iextpay_customer_id='$cus_id' AND iextpay_owner = '$oid'");
			$result = $query->result();
			
			$paid_amt = 0;
			for ($i=0; $i < count($result) ; $i++) { 
				$paid_amt = $paid_amt + $result[$i]->iextpay_amount;
			}

			$actual_amt = 0;
			$balance_amt = 0;

			if ($type == "Invoice") {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id = '$doc_id' AND iextein_customer_id='$cus_id' AND iextein_owner = '$oid'");
				$result = $query->result();
				
				if (count($result) > 0) {
					$actual_amt = $result[0]->iextein_amount;		
				}

				$balance_amt = $actual_amt - $paid_amt;

				if($balance_amt == 0 ) {
					$data = array('iextein_status' => 'paid' );
					$data2 = array('iextein_id' => $doc_id , 'iextein_owner' => $oid, 'iextein_customer_id' => $cus_id );

					$this->db->where($data2);
					$this->db->update('i_ext_et_invoice', $data);
				} else {
					$data = array('iextein_status' => 'unpaid' );
					$data2 = array('iextein_id' => $doc_id , 'iextein_owner' => $oid, 'iextein_customer_id' => $cus_id );

					$this->db->where($data2);
					$this->db->update('i_ext_et_invoice', $data);
				}
			} else if ($type == "AMC") {
				$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_id = '$doc_id' AND iextamc_customer_id='$cus_id' AND iextamc_owner = '$oid'");
				$result = $query->result();
				
				if (count($result) > 0) {
					$actual_amt = $result[0]->iextamc_amount;		
				}

				$balance_amt = $actual_amt - $paid_amt;

				if($balance_amt == 0 ) {
					$data = array('iextamc_status' => 'paid' );
					$data2 = array('iextamc_id' => $doc_id , 'iextamc_owner' => $oid, 'iextamc_customer_id' => $cus_id );

					$this->db->where($data2);
					$this->db->update('i_ext_et_amc', $data);
				} else {
					$data = array('iextamc_status' => 'unpaid' );
					$data2 = array('iextamc_id' => $doc_id , 'iextamc_owner' => $oid, 'iextamc_customer_id' => $cus_id );

					$this->db->where($data2);
					$this->db->update('i_ext_et_amc', $data);
				}
			}
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function delete_payment_record($type, $doc_id, $cus_id, $pay_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array('iextpay_id' => $pay_id , 'iextpay_owner' => $oid);
			$this->db->where($data);
			$this->db->delete('i_ext_et_payment');

			$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextpay_doc_type='$type' AND iextpay_doc_id = '$doc_id' AND  iextpay_customer_id='$cus_id' AND iextpay_owner = '$oid'");
			$result = $query->result();
			
			$paid_amt = 0;
			for ($i=0; $i < count($result) ; $i++) { 
				$paid_amt = $paid_amt + $result[$i]->iextpay_amount;
			}

			$actual_amt = 0;
			$balance_amt = 0;

			if ($type == "Invoice") {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_id = '$doc_id' AND iextein_customer_id='$cus_id' AND iextein_owner = '$oid'");
				$result = $query->result();
				
				if (count($result) > 0) {
					$actual_amt = $result[0]->iextein_amount;		
				}
			}

			$balance_amt = $actual_amt - $paid_amt;

			if($balance_amt == 0 ) {
				$data = array('iextein_status' => 'paid' );
				$data2 = array('iextein_id' => $doc_id , 'iextein_owner' => $oid, 'iextein_customer_id' => $cus_id );

				$this->db->where($data2);
				$this->db->update('i_ext_et_invoice', $data);
			} else {
				$data = array('iextein_status' => 'unpaid' );
				$data2 = array('iextein_id' => $doc_id , 'iextein_owner' => $oid, 'iextein_customer_id' => $cus_id );

				$this->db->where($data2);
				$this->db->update('i_ext_et_invoice', $data);
			}

			redirect(base_url().'Enterprise/record_payment/'.$type.'/'.$doc_id.'/'.$cus_id);
		} else {
			redirect(base_url().'Account/login');
		}	
	}

########## MAINTAINANCE CONTRACTS ################
	public function amc($mod_id = null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
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
					if ($module[$i]->mname == 'Subscription') {
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
				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' AND a.iextamc_gid = '$gid' ORDER BY a.iextamc_id DESC");
				$result = $query->result();
				$data['invoice'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' AND a.iextamc_gid = '$gid' GROUP BY iextamc_status");
				$result = $query->result();
				$data['status'] = $result;

			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' AND a.iextamc_gid = '$gid' ORDER BY a.iextamc_id DESC");
					$result = $query->result();
					$data['invoice'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' AND a.iextamc_gid = '$gid' GROUP BY iextamc_status");
					$result = $query->result();
					$data['status'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_created_by = '$uid' AND a.iextamc_gid = '$gid' UNION SELECT * FROM i_ext_et_amc AS c LEFT JOIN i_customers AS d ON c.iextamc_customer_id=d.ic_id WHERE c.iextamc_gid = '$gid' AND c.iextamc_id IN(SELECT iextamcm_pid FROM i_ext_et_amc_mutual WHERE iextamcm_uid = '$uid' AND iextamcm_oid = '$oid')");
					$result = $query->result();
					$data['invoice'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_created_by = '$uid' AND a.iextamc_gid = '$gid' UNION SELECT * FROM i_ext_et_amc AS c LEFT JOIN i_customers AS d ON c.iextamc_customer_id=d.ic_id WHERE c.iextamc_gid = '$gid' AND c.iextamc_id IN(SELECT iextamcm_pid FROM i_ext_et_amc_mutual WHERE iextamcm_uid = '$uid' AND iextamcm_oid = '$oid') GROUP BY iextamc_status");
					$result = $query->result();
					$data['status'] = $result;
				}
			}

			$data['mod_id'] = $module_id;
			$ert['mid'] = $module_id;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod'];$ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$search = $this->input->post('search');
			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' and a.iextamc_gid = '$gid' AND b.ic_name LIKE '%".$search."%' OR a.iextamc_txn_id LIKE '%".$search."%' ORDER BY a.iextamc_id DESC");
			$result = $query->result();
			$data['invoice'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_filter($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$from_date = $this->input->post('from');
			$to_date = $this->input->post('to');
			$min_amount = $this->input->post('min_amount');
			$max_amount = $this->input->post('max_amount');
			$status = $this->input->post('in_status');
			$amc_created = $this->input->post('amc_created');

			if ($amc_created != null) {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$amc_created' AND ic_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$amc_created = $result[0]->ic_uid;
				}
			}


			$this->db->select('*');
			$this->db->from('i_ext_et_amc');
			$this->db->join('i_customers', 'i_customers.ic_id = i_ext_et_amc.iextamc_customer_id','left');
			if ($from_date != '' && $to_date != '') {
				$this->db->where('iextamc_txn_date >=', $from_date);
				$this->db->where('iextamc_txn_date <=', $to_date);
			}
			if ($amc_created != '') {
				$this->db->where('iextamc_created_by', $amc_created);
			}
			if ($status != '') {
				$this->db->where('iextamc_status', $status);
			}
			if ($min_amount != '') {
				$this->db->where('iextamc_amount >=', $min_amount);
			}
			if ($max_amount != '') {
				$this->db->where('iextamc_amount <=', $max_amount);
			}
			$this->db->where('i_ext_et_amc.iextamc_owner', $oid);
			$this->db->group_by('i_ext_et_amc.iextamc_id');
			$query = $this->db->get();
			$data['filter'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');

		}
	}

	public function amc_mail($mod_id, $inid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$flg = '';
			$cust_mail = $this->input->post('cust_mail_id');

			for ($i=0; $i <count($cust_mail) ; $i++) { 
				if ($cust_mail[$i]['status'] == 'true') {
					$flg = 'true';
				}
			}
			if ($flg == 'true') {
				for ($i=0; $i <count($cust_mail) ; $i++) { 
					if ($cust_mail[$i]['status'] == 'true') {
						echo $this->send_amc_email($code,$cust_mail[$i]['email'], $mod_id, $inid);
					}
				}	
			}else{
				echo "false";
			}			
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function save_amc_mail($mod_id, $inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;
			$mail_id = $this->input->post('cust_mail_id');

			$query = $this->db->query("SELECT iextamc_customer_id FROM i_ext_et_amc WHERE iextamc_id='$inid' AND iextamc_owner='$oid'");
			$result = $query->result();
			$cust_id = $result[0]->iextamc_customer_id;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			for ($i=0; $i <count($mail_id) ; $i++) { 
				if ($mail_id[$i]['status'] == 'true') {
					$email = $mail_id[$i]['email'];
					$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_value = '$email' AND icbd_property = '$p_id' AND icbd_customer_id = '$cust_id'");
					$result = $query->result();

					if (count($result) > 0) {
						 echo $this->send_amc_email($code,$email, $mod_id, $inid);
					}else{
						$data = array(
							'icbd_customer_id' => $cust_id,
							'icbd_property' => $p_id,
							'icbd_value' => $email
						);
						$this->db->insert('i_c_basic_details',$data);

						echo $this->send_amc_email($code,$email, $mod_id, $inid);
					}
				}$email = '';
			}
			
		}else  {
			redirect(base_url().'Account/login');
		}
	}
	
	public function send_amc_email($code,$uid_mail, $mod_id, $invoiceid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
		$oid = $sess_data['user_details'][0]->i_owner;

		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id='$oid'");
		$result = $query->result();

		$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id IN (SELECT icbd_customer_id FROM i_c_basic_details WHERE icbd_value='$uid_mail')");
		$result1 = $query->result();

		$query = $this->db->query("SELECT * from i_ext_et_amc WHERE iextamc_id='$invoiceid'");
		$result2 = $query->result();

		$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
		$result3=$query3->result();
		if (count($result3)>0) {
			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
			$page = file_get_contents(base_url().'Enterprise/amc_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/amc/';

		    if(!file_exists($path)) {
					mkdir($path, 0777, true);
			}
			$c_name = str_replace(' ', '_', $result1[0]->ic_name);
		    $htmlfile = $c_name.'-'.date("d-m-Y", strtotime($result2[0]->iextamc_txn_date)).'.html';
		    $invoicefile = $c_name.'-'.date("d-m-Y", strtotime($result2[0]->iextamc_txn_date)).'.pdf';
		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

			$subject = $result[0]->iud_company.' - Subscription - '.$result2[0]->iextamc_txn_id;

			$body = '<!DOCTYPE html><!DOCTYPE html><html><head></head>
			<body>Dear '.$result1[0]->ic_name.',<br><br>Please find the attached invoice and kindly acknowledge the same.<br><br>Regards,<br>For '.$result[0]->iud_company.'<br>'.$result[0]->iud_name.'</body></html>';
			$attach = $path.$invoicefile;
			$this->Mail->send_mail($subject,$uid_mail,$attach,$body,$code);

			echo "true";
		}else {
			echo "enter";
		}
		}else  {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_doc_upload($code,$pid,$cname){
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
					if ($module[$i]->mname == 'Subscription') {
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

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				for ($i=0; $i <count($_FILES['used']['tmp_name']) ; $i++) {
					
					$sourcePath = $_FILES['used']['tmp_name'][$i];
					$target = $upload_dir.$_FILES['used']['name'][$i];

					$path_parts = pathinfo($target);
					$file_name = $path_parts['filename'];
					$ext = $path_parts['extension'];
					$dt = date('Y-m-d H:i:s');
					$dt1=date_create(); 
					$dt_str = date_timestamp_get($dt1);
					$timestamp_value = $i.$dt_str;

					$targetPath = $upload_dir.$timestamp_value.'.'.$ext;
					$img_path = $targetPath;
					move_uploaded_file($sourcePath,$targetPath) ;
					
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

	public function amc_send_email($code,$tid=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$mid = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'Subscription') {
					$mid = $module[$i]->mid;
				}
			}

			$dt = date('Y-m-d H:i:s');
			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$e_date = $this->input->post('e_date');
			$amount = $this->input->post('amount');
			$status = $this->input->post('status');
			$content = $this->input->post('content');
			$files = $this->input->post('files');
			$tags = $this->input->post('tags');
			$property = $this->input->post('property');
			$mutual = $this->input->post('mutual');
			$duration = $this->input->post('duration');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$cust_name' AND ic_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->ic_id;
			// eval("\$content = \"$content\";");
			if ($tid == null) {
				$data = array(
					'iextamc_customer_id' => $cid,
					'iextamc_txn_id' => $txn_no,
					'iextamc_txn_date' => $txn_date,
					'iextamc_period_from' => $txn_date,
					'iextamc_period_to' => $e_date,
					'iextamc_type' => 'email',
					'iextamc_owner' => $oid,
					'iextamc_created' => $dt,
					'iextamc_created_by' => $uid,
					'iextamc_status' => $status,
					'iextamc_gid' => $gid,
					'iextamc_amount' => $amount,
					'iextamc_sheduled' => $duration,
					'iextamc_note' => $content
				);
				$this->db->insert('i_ext_et_amc',$data);
				$inid = $this->db->insert_id();	
			}else{
				$data = array(
					'iextamc_customer_id' => $cid,
					'iextamc_txn_id' => $txn_no,
					'iextamc_txn_date' => $txn_date,
					'iextamc_period_from' => $txn_date,
					'iextamc_period_to' => $e_date,
					'iextamc_modified' => $dt,
					'iextamc_modified_by' => $uid,
					'iextamc_status' => $status,
					'iextamc_amount' => $amount,
					'iextamc_sheduled' => $duration,
					'iextamc_note' => $content
				);
				$this->db->WHERE(array('iextamc_owner'=>$oid,'iextamc_id'=>$tid));
				$this->db->update('i_ext_et_amc',$data);

				$this->db->WHERE(array('iextamcpt_inid' => $tid));
				$this->db->delete('i_ext_et_amc_property');

				$this->db->WHERE(array('iet_type_id' => $tid,'iet_type' => 'subscription','iet_owner' => $oid,'iet_m_id' => $mid));
				$this->db->delete('i_ext_tags');

				$this->db->WHERE(array('iextamcm_pid' => $tid,'iextamcm_oid' => $oid));
				$this->db->delete('i_ext_et_amc_mutual');

				$inid = $tid;
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iextamcpt_inid' => $inid,
						'iextamcpt_property_value' => $property[$i]['value'],
						'iextamcpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_amc_property',$data);
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
					'iet_type' => 'subscription',
					'iet_tag_id' => $tgid,
					'iet_owner' => $oid,
					'iet_m_id' => $mid
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
							'iextamcm_pid' => $inid,
							'iextamcm_uid' => $m_uid,
							'iextamcm_oid' => $oid
						);
						$this->db->insert('i_ext_et_amc_mutual',$data);
					}
				}
			}
			
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$p_id'");
			$result = $query->result();

			$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result3=$query3->result();

			if (count($result)>0) {
				$mail_id = $result[0]->icbd_value;
				$body = '';

				$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body>'.$content.'<br><br>';
				for ($j=0; $j <count($files) ; $j++) {
					$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($files[$j]['file_name']).'"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
					$body .= '<br>';
				}
				$body .='<br>Regards</body></html>';
				$temp = $this->Mail->send_mail($subject,$mail_id,null,$body,$code);
				$mail_id = '';
			}
			echo $inid;
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function amc_add($mod_id,$code) {
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
					if ($module[$i]->mname == 'Subscription') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data["mod_id"] = $mod_id;

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
						$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_owner = '$oid'");
						$result2 = $query->result();
						$val = count($result2)+1;
					}
					$invoice_txn_id .= $val;
				}
			}
			$data['invoice_doc_id'] = $invoice_txn_id;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid'  AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document = 'AMC' AND iextdt_owner = '$oid'");
			$data['term_doc'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			$ert['gid']=$gid;$ert['mid']=$module_id;$ert['mname']=$mname;$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = "Add ".$mname;
			}else{
				$ert['title'] = "Add ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_get_price() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;

			$product = $this->input->post('product');
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$product' AND ip_owner = '$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				$pid = $result[0]->ip_id;
				$que = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$pid'");
				$res = $que->result();

				if(count($res) > 0) {
					$cnt = count($res) - 1;
					echo $res[$cnt]->ipp_sell_price;
				} else {
					echo "0";
				}
			}
		}
	}

	public function save_amc($type=null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$e_date = $this->input->post('end_date');
			$products = $this->input->post('product');
			$duration = $this->input->post('duration');
			$dt = date('Y-m-d H:i:s');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$status = $this->input->post('status');
			$module_id = '';
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$note = $this->input->post('note');
			$amc_tax = $this->input->post('amc_tax');
			$txn_amt = $this->input->post('txn_amt');
			$amc_type = $this->input->post('amc_type');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Subscription') {
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
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}
			$data = array(
				'iextamc_customer_id' => $cid,
				'iextamc_txn_id' => $txn_no,
				'iextamc_txn_date' => $txn_date,
				'iextamc_period_from' => $txn_date,
				'iextamc_period_to' => $e_date,
				'iextamc_type' => $type,
				'iextamc_owner' => $oid,
				'iextamc_created' => $dt,
				'iextamc_created_by' => $oid,
				'iextamc_status' => $status,
				'iextamc_note' => $note,
				'iextamc_gid' => $gid,
				'iextamc_amount' => $txn_amt,
				'iextamc_sheduled' => $duration,
				'iextamc_amc_type' => $amc_type,
				'iextamc_tax' => $amc_tax
			);
			$this->db->insert('i_ext_et_amc', $data);
			$inid = $this->db->insert_id();

			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iextamctm_inid' => $inid,
						'iextamctm_term_id' => $terms[$i]['id'],
						'iextamctm_status' => $status
					);	
					$this->db->insert('i_ext_et_amc_terms',$data);	
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iextamcpt_inid' => $inid,
						'iextamcpt_property_value' => $property[$i]['value'],
						'iextamcpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_amc_property',$data);
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
					'iet_type' => 'subscription',
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
							'iextamcm_pid' => $inid,
							'iextamcm_uid' => $m_uid,
							'iextamcm_oid' => $oid
						);
						$this->db->insert('i_ext_et_amc_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $inid, 
				'in_type' => 'subscription',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Subscription - '.$txn_no,
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

			for ($i=0; $i < count($products) ; $i++) {
				$pd = $products[$i]['product'];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;
				} else {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'subscription',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid,
						'ip_cat_id' => 0,
						'ip_gid' => $gid
					);
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				}

				$data = array(
					'iextamcpd_d_id' => $inid,
					'iextamcpd_product_id' => $prid,
					'iextamcpd_qty' => $products[$i]['qty'],
					'iextamcpd_serial_number' => $products[$i]['sn'],
					'iextamcpd_owner' => $oid,
					'iextamcpd_alias' => $products[$i]['alias']
				);
				$this->db->insert('i_ext_et_amc_product_details', $data);
			}



			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = $uid ");
			$result = $query->result();
			$p_name = $result[0]->iud_name;

			$pid = 0;
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%'");
			$result1 = $query->result();
			if (count($result1) > 0) {
				$pid = $result1[0]->ip_id;
			}

			$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE ic_name='$cust_name' AND ic_owner='$oid' AND icbd_property = '$pid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$c_email = $result[0]->icbd_value;
				$cid = $result[0]->icbd_customer_id;

				$sub = ' New Subscription';
				$body = '<html><style><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style><body><div><h3>'.$p_name.' raised subscription for you please click on bellow button for confirm.</div><a href="'.base_url().'Enterprise/subscription_status_update/'.urlencode($inid).'/'.$code.'/'.$cid.'/"><button class=""btn btn-lg btn-danger pic_button">Confirm</button></a></body></html>';

				$temp = $this->Mail->send_mail($sub,$c_email,null,$body,$code);	
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_email_doc_upload($code,$cname){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Subscription') {
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
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				
					$data = array(
						'icd_file' => $file_name,
						'icd_owner' => $oid,
						'icd_cid' => $cid,
						'icd_date' => $dt,
						'icd_type' => 'document',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $mid,
						'icd_type_id' => $cid,
						'icd_status' => 'true'
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

	// public function send_amc_mail($code){
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$uid = $sess_data['user_details'][0]->i_uid;
	// 		$oid = $sess_data['user_details'][0]->i_owner;
	// 		$gid = $sess_data['gid'];

	// 		$tmpstr = implode(',', $emails);

	// 		$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
	// 		$result = $query->result();
	// 		$p_id = $result[0]->ip_id;

	// 		$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_id IN($tmpstr) AND icbd_property = '$p_id'");
	// 		$result = $query->result();

	// 		$query3 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
	// 		$result3=$query3->result();

	// 		if (count($result3)>0) {
	// 			for ($i=0; $i <count($result) ; $i++) {
	// 				$mail_id = $result[$i]->icbd_value;
	// 				$body = '';

	// 				$body .= $content;
	// 				$body .='<!DOCTYPE html><!DOCTYPE html><html><head></head><body><br><br>';
	// 				for ($j=0; $j <count($files) ; $j++) {
	// 					$body .= '<a href="'.base_url().'assets/uploads/'.$oid.'/'.urldecode($files[$j]['file_name']).'"><button class="btn btn-lg btn-danger">'.$files[$j]['file_name'].'</button></a>';
	// 					$body .= '<br>';
	// 				}
	// 				$body .='<br>Regards</body></html>';
	// 				$temp = $this->Mail->send_mail($subject,$mail_id,null,$body,$code);
	// 				$mail_id = '';
	// 			}
	// 		}
	// 		echo $inid;

	// 	}else{
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	public function subscription_status_update($inid,$code,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id = '';

			 if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Subscription') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$data = array(
				'iextamc_status' => 'cb_client'
			);
			$this->db->where (array('iextamc_id'=> $inid,'iextamc_owner' => $uid));
			$this->db->update('i_ext_et_amc', $data);

			$data = array(
				'in_type_id' => $inid,
				'in_type' => 'subscription',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 'confirm',
				'in_date' => $dt
			);
			$this->db->insert('i_notifications',$data);

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$uid'");
			$result = $query->result();
			if (count($result) > 0) {
				$company = $result[0]->iud_company;
			}

			$ert['confirm'] = '<!DOCTYPE html><html><head><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} h3{font-weight: normal;}</style></head><body><div style="text-align: center;"><h1 style="padding:20px;color: green;">Your confirmation done.</h1><div><h5>'.$company.' will contact you.</h5></body></html>';

			$this->load->view('confirm_done',$ert);
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function amc_print($code,$mod_id, $amc_id) {
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

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextamc_id='$amc_id' AND a.iextamc_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextamc_id='$amc_id' AND a.iextamc_owner = '$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextamc_txn_id;
				$data['s_txn_date'] = $result[0]->iextamc_txn_date;
				$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
				$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
				$data['s_txn_note'] = $result[0]->iextamc_note;
				$data['s_txn_amount'] = $result[0]->iextamc_amount;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextamc_txn_id;
				$data['s_txn_date'] = $result[0]->iextamc_txn_date;
				$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
				$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
				$data['s_txn_note'] = $result[0]->iextamc_note;
				$data['s_txn_amount'] = $result[0]->iextamc_amount;
			}

            $tx = $data['basic'][0]->iextamc_tax;
            $query1 = $this->db->query("SELECT * FROM i_tax_group_collection AS a LEFT JOIN i_taxes AS b ON a.itxgc_tx_id=b.itx_id  WHERE a.itxgc_tg_id='$tx' AND b.itx_owner='$oid'");
            $result1 = $query1->result();
			$data['taxes'] = $result1;

			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();
			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iextamc_id='$amc_id'");
			$result = $query->result();
			
			if(count($result) > 0) {
				$data['s_gst'] = $result[0]->icbd_value;
			} else {
				$data['s_gst'] = '';
			}
			$query = $this->db->query("SELECT * FROM i_ext_et_amc_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iextamcpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON a.iextamcpd_tax = c.ittxg_id LEFT JOIN i_product AS d ON a.iextamcpd_product_id=d.ip_id LEFT JOIN i_p_price AS e ON d.ip_id=e.ipp_p_id LEFT JOIN i_p_additional_info AS f ON d.ip_id=f.ipai_p_id LEFT JOIN i_ext_et_amc as g on g.iextamc_id = a.iextamcpd_d_id WHERE a.iextamcpd_d_id='$amc_id' AND a.iextamcpd_owner='$oid'");
			$result = $query->result();
			$data['details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms as a LEFT JOIN i_ext_et_amc_terms as b on a.iextdt_id=b.iextamctm_term_id WHERE iextdt_document='AMC' AND iextdt_owner='$oid' AND iextamctm_inid= '$amc_id' AND iextamctm_status = 'true' ");
			$result = $query->result();
			$data['terms'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_property WHERE iextamcpt_inid ='$amc_id' AND iextamcpt_status = 'true' ");
			$result = $query->result();
			$data['property'] = $result;

			$data['s_title'] = "Annual Maintainance Contract";

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

	public function amc_edit($mod_id,$code,$inid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$module_id = '';$mname = '';

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Subscription') {
						$module_id = $module[$i]->mid;
						$mname = 'Subscription';
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid' GROUP BY it_value");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner='$oid'");
			$result = $query->result();
			$data['pro_title'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc as a WHERE a.iextamc_id ='$inid' AND a.iextamc_owner = '$oid'");
			$result = $query->result();
			$cid = $result[0]->iextamc_customer_id;
			$in_amount = $result[0]->iextamc_amount;
			$status = $result[0]->iextamc_status;
			$duration_type = $result[0]->iextamc_sheduled;

			$s_date = strtotime($result[0]->iextamc_period_from);
			$e_date = strtotime($result[0]->iextamc_period_to);
			$year1 = date('Y', $s_date);
			$year2 = date('Y', $e_date);
			$month1 = date('m', $s_date);
			$month2 = date('m', $e_date);
			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			$d_flg = 0;
			if ($result[0]->iextamc_sheduled == 'monthly' ) {
				$d_flg = $diff;
			}else if ($result[0]->iextamc_sheduled == 'by_monthly' ) {
				$d_flg = $diff / 2 ;
			}else if ($result[0]->iextamc_sheduled == 'quarterly'){
				$d_flg = $diff / 3 ;
			}else if ($result[0]->iextamc_sheduled == 'half_year'){
				$d_flg = $diff / 6 ;
			}
			$data['d_flg'] = $d_flg;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_terms as a left join i_ext_et_document_terms as b on a.iextamctm_term_id=b.iextdt_id WHERE iextamctm_inid = '$inid'");
			$data['p_terms'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document = 'AMC' AND iextdt_owner = '$oid'");
			$data['term_doc'] = $query->result();

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_id='$cid'");
			$result = $query->result();
			$data['edit_cust'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_property where iextamcpt_inid = '$inid'");
			$result = $query->result();
			$data['invoice_property'] = $result;

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_owner = '$oid' AND ip_property LIKE '%email%' ");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id = '$cid' ");
			$result = $query->result();
			$data['email_ids'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_type = 'subscription' AND iet_type_id = '$inid' AND iet_m_id = '$module_id' AND iet_owner = '$oid') ");
			$result = $query->result();
			$data['pro_tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_mutual as a LEFT JOIN i_customers as b on a.iextamcm_uid = b.ic_uid WHERE iextamcm_pid = '$inid' AND iextamcm_oid = '$oid'");
			$result = $query->result();
			$data['mutual'] = $result;

			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_c_basic_details as a LEFT JOIN i_property as b on a.icbd_property=b.ip_id WHERE a.icbd_value !='' AND b.ip_property LIKE '%email%' AND b.ip_owner = '$oid' AND a.icbd_customer_id = '$cid'");
			$result = $query->result();
			$data['e_details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextepay_mid = '$module_id' AND iextepay_mname = '$mname' AND iextepay_oid = '$oid' AND iextepay_gid = '$gid' AND iextepay_tx_no = '$inid' ");
			$result = $query->result();
			$pay['history'] = $result;

			$p_amount = 0;
			for ($i=0; $i <count($result); $i++) { 
				$p_amount = $p_amount + $result[$i]->iextepay_amount;
			}
			$in_amount = $in_amount - $p_amount;
			if ($in_amount == 0) {
				$this->db->WHERE(array('iextamc_id'=>$inid,'iextamc_owner'=>$oid));
				$this->db->update('i_ext_et_amc',array('iextamc_status'=>'paid'));
			}else{
				if ($status == 'paid') {
					$this->db->WHERE(array('iextamc_id'=>$inid,'iextamc_owner'=>$oid));
					$this->db->update('i_ext_et_amc',array('iextamc_status'=>'negotiate'));
				}
			}
			$pay['bal_amount'] = $in_amount;
			$data['tid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_task as a LEFT JOIN i_user_activity as b on a.iextamct_aid = b.iua_id WHERE iextamct_amc_id = '$inid' AND iextamct_owner = '$oid' ");
			$result = $query->result();
			$data['amc_act'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc as a left JOIN i_ext_et_amc_product_details as b on a.iextamc_id=b.iextamcpd_d_id LEFT join i_product as c on b.iextamcpd_product_id=c.ip_id WHERE a.iextamc_id ='$inid' AND a.iextamc_owner = '$oid'");
			$result = $query->result();	
			$data['edit_invoice'] = $result;
			$data['edit_type'] = $result[0]->iextamc_type;
			$data['invoice_gid'] = $result[0]->iextamc_gid;

			$ert['gid'] = $gid;$ert['mid'] = $module_id;$ert['mname'] = $mname;$ert['code'] = $code;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = "Edit ".$mname;	
			}else{
				$ert['title'] = "Edit ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('payment_modal',$pay);
			// $this->load->view('activity_modal',$data);
			$this->load->view('enterprise/amc_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_transfer($code,$pid,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextamc_id' => $pid, 'iextamc_owner' => $oid));
			$this->db->update('i_ext_et_amc',array('iextamc_gid' => $gid));
			
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function amc_transfer_user($inid,$code){
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
					'iextamc_created_by' => $p_uid
				);
				$this->db->where(array('iextamc_id' => $inid, 'iextamc_owner' => $oid));
				$this->db->update('i_ext_et_amc',$data);

				echo "true";
			}else{
				echo "false";
			}
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function amc_download($flg,$mod_id,$invoiceid,$code){

		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$oid = $sess_data['user_details'][0]->i_uid;
			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close(); // unlock the file
		    // redirect(base_url().'Enterprise/amc_print/'.$code.'/'.$mod_id.'/'.$invoiceid);
	 		$page = file_get_contents(base_url().'Enterprise/amc_print/'.$code.'/'.$mod_id.'/'.$invoiceid, false, $context);
		    session_start(); // unlock the file

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/amc/';

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
		    	redirect(base_url().'assets/data/'.$oid.'/amc/'.$invoicefile);
		    }

		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function amc_delete_product() {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;

			$txnid = $this->input->post('txnid');
			$docid = $this->input->post('docid');

			$data = array('iextamcpd_owner' => $oid , 'iextamcpd_d_id' => $docid, 'iextamcpd_id' => $txnid );
			$this->db->where($data);
			$this->db->delete('i_ext_et_amc_product_details');
		}
	}

	public function update_amc($type,$inid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
		    $uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cust_name = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$e_date = $this->input->post('end_date');
			$duration = $this->input->post('duration');
			$products = $this->input->post('product');
			$dt = date('Y-m-d H:i:s');
			$terms = $this->input->post('terms');
			$property = $this->input->post('property');
			$status = $this->input->post('status');
			$module_id = '';
			$mutual = $this->input->post('mutual');
			$tags = $this->input->post('tags');
			$note = $this->input->post('note');
			$txn_amt = $this->input->post('txn_amt');
			$amc_tax = $this->input->post('amc_tax');
			$amc_type = $this->input->post('amc_type');

			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->function == 'amc') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_name='$cust_name' AND ic_owner='$oid'");
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$data = array(
				'iextamc_customer_id' => $cid,
				'iextamc_txn_id' => $txn_no,
				'iextamc_txn_date' => $txn_date,
				'iextamc_period_from' => $txn_date,
				'iextamc_period_to' => $e_date,
				'iextamc_type' => $type,
				'iextamc_owner' => $oid,
				'iextamc_modified' => $dt,
				'iextamc_modified_by' => $uid,
				'iextamc_status' => $status,
				'iextamc_note' => $note,
				'iextamc_gid' => $gid,
				'iextamc_amount' => $txn_amt,
				'iextamc_sheduled' => $duration,
				'iextamc_amc_type' => $amc_type,
				'iextamc_tax' => $amc_tax
			);
			$this->db->where('iextamc_id', $inid);
			$this->db->update('i_ext_et_amc', $data);

			$this->db->where('iextamcpd_d_id', $inid);
			$this->db->delete('i_ext_et_amc_product_details');

			$this->db->WHERE(array('iet_type_id'=>$inid,'iet_type'=>'subscription'));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE('iextamctm_inid',$inid);
			$this->db->delete('i_ext_et_amc_terms');

			$this->db->WHERE('iextamcpt_inid',$inid);
			$this->db->delete('i_ext_et_amc_property');

			$this->db->where('iextamcm_pid', $inid);
			$this->db->delete('i_ext_et_amc_mutual');
			
			if (count($terms) > 0) {
				for ($i=0; $i <count($terms) ; $i++) { 
					if ($terms[$i]['status'] == 'true') {
						$status = 'true';
					}else{
						$status = 'false';
					}
					$data = array(
						'iextamctm_inid' => $inid,
						'iextamctm_term_id' => $terms[$i]['id'],
						'iextamctm_status' => $status
					);	
					$this->db->insert('i_ext_et_amc_terms',$data);
				}
			}

			if (count($property) > 0) {
				for ($i=0; $i <count($property) ; $i++) { 
					$data = array(
						'iextamcpt_inid' => $inid,
						'iextamcpt_property_value' => $property[$i]['value'],
						'iextamcpt_status' => $property[$i]['status']
					);
					$this->db->insert('i_ext_et_amc_property',$data);	
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
					'iet_type' => 'subscription',
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
							'iextamcm_pid' => $inid,
							'iextamcm_uid' => $m_uid,
							'iextamcm_oid' => $oid
						);
						$this->db->insert('i_ext_et_amc_mutual',$data);
					}
				}
			}

			$data1 = array(
				'in_type_id' => $inid, 
				'in_type' => 'subscription',
				'in_m_id' => $module_id,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt1
			);
			$this->db->insert('i_notifications',$data1);

			$data = array(
				'iua_type' => 'module',
				'iua_title' => 'Subscription - '.$txn_no,
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

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i]['product'];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;
				} else {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'amc',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid,
						'ip_cat_id' => 0,
						'ip_gid' => $gid
					);
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				}

				$data = array(
					'iextamcpd_d_id' => $inid,
					'iextamcpd_product_id' => $prid,
					'iextamcpd_qty' => $products[$i]['qty'],
					'iextamcpd_serial_number' => $products[$i]['sn'],
					'iextamcpd_owner' => $oid,
					'iextamcpd_alias' => $products[$i]['alias']
					);
				$this->db->insert('i_ext_et_amc_product_details', $data);
			}
			
			echo $inid;
			// redirect(base_url().'Enterprise/module_activity/'.$cid.'/'.$txn_no.'/maintainance/'.$inid.'/update');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_amc($inid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data[''];
			$module = $sess_data['user_mod'];
			$module_id = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Subscription') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$this->db->where('iextamc_id', $inid);
			$this->db->delete('i_ext_et_amc');

			$this->db->where('iextamcm_pid', $inid);
			$this->db->delete('i_ext_et_amc_mutual');

			$this->db->where('iextamcpd_d_id', $inid);
			$this->db->delete('i_ext_et_amc_product_details');

			$this->db->WHERE(array('iet_type_id'=>$inid,'iet_type'=>'amc'));
			$this->db->delete('i_ext_tags');

			$this->db->WHERE('iextamctm_inid',$inid);
			$this->db->delete('i_ext_et_amc_terms');

			$this->db->WHERE('iextamcpt_inid',$inid);
			$this->db->delete('i_ext_et_amc_property');

			redirect(base_url().'Enterprise/amc/'.$module_id.'/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## EXPENSES ################
	public function expenses($mid=0,$code,$eid=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Expenses') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			if ($eid != null) {
				$query = $this->db->query("SELECT * FROM i_ext_et_expenses as a LEFT JOIN i_ext_tags as b on a.iextete_id=b.iet_type_id  left JOIN i_tags as c on b.iet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iextete_id = '$eid' AND iet_type_id = '$eid' GROUP BY iet_tag_id");
				$result = $query->result();
				$data['edit_expense'] = $result;

				$data['eid'] = $eid;
			}

			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' ORDER BY iextete_date DESC");
				$result = $query->result();
				$data['expense'] = $result;
				$data['admin'] = true;

				$query = $this->db->query("SELECT it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_tags as b on a.iextete_id=b.iet_type_id  left JOIN i_tags as c on b.iet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iet_m_id = '$module_id' AND iet_owner = '$oid' GROUP BY iet_tag_id ORDER BY iextete_date DESC");
				$result = $query->result();
				$data['e_expense'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND iextete_gid = '$gid' ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['expense'] = $result;
					$data['admin'] = true;

					$query = $this->db->query("SELECT it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_tags as b on a.iextete_id=b.iet_type_id  left JOIN i_tags as c on b.iet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iet_m_id = '$module_id' AND iet_owner = '$oid' AND iextete_gid = '$gid' GROUP BY iet_tag_id ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['e_expense'] = $result;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND iextete_gid = '$gid' AND iextete_created_by = '$uid' ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['expense'] = $result;
					$data['admin'] = false;

					$query = $this->db->query("SELECT it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_tags as b on a.iextete_id=b.iet_type_id  left JOIN i_tags as c on b.iet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iet_m_id = '$module_id' AND iet_owner = '$oid' AND iextete_gid = '$gid' AND iextete_created_by = '$uid' GROUP BY iet_tag_id ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['e_expense'] = $result;
				}
			}

			// $query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
   //          $data['use_modules'] = $query->result();

            $query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
            $result = $query->result();
            $data['tags'] = $result;

   //          $query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
   //          $result = $query->result();
   //          $data['status'] = $result;

   //          $query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
   //          $result = $query->result();
   //          $data['place'] = $result;

   //          $query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
   //          $result = $query->result();
   //          $data['cat'] = $result;

   //          $query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
   //          $result = $query->result();
   //          $data['user_list'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['user_connection']=$sess_data['user_connection'];
			$ert['mid']=$module_id;$ert['mname']=$mname;$ert['gid']=$gid;$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = $mname;	
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			// $this->load->view('activity_modal', $data);
			$this->load->view('enterprise/expenses', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function expense_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$search = $this->input->post('search');

			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND (iextete_details LIKE '%".$search."%' OR iextete_date LIKE '%".$search."%') ORDER BY iextete_date DESC, iextete_id DESC");
				$result = $query->result();	
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND iextete_gid = '$gid' AND (iextete_details LIKE '%".$search."%' OR iextete_date LIKE '%".$search."%') ORDER BY iextete_date DESC, iextete_id DESC");
					$result = $query->result();
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND iextete_gid = '$gid' AND iextete_created_by = '$uid' AND (iextete_details LIKE '%".$search."%' OR iextete_date LIKE '%".$search."%') ORDER BY iextete_date DESC, iextete_id DESC");
					$result = $query->result();
				}
			}

			print_r(json_encode($result));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function expense_filter($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$filter = $this->input->post('filter');
			$f_array=implode("','", $filter);
			if ($gid == 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_id IN (SELECT iextetet_e_id FROM i_ext_et_expense_tag WHERE iextetet_tag_id IN(SELECT it_id FROM i_tags WHERE it_value IN ('$f_array')));");
				$result=$query->result();
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_gid = $gid AND iextete_id IN (SELECT iextetet_e_id FROM i_ext_et_expense_tag WHERE iextetet_tag_id IN(SELECT it_id FROM i_tags WHERE it_value IN ('$f_array')));");
					$result=$query->result();
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_gid = $gid AND iextete_created_by = '$uid' AND iextete_id IN (SELECT iextetet_e_id FROM i_ext_et_expense_tag WHERE iextetet_tag_id IN(SELECT it_id FROM i_tags WHERE it_value IN ('$f_array')));");
					$result=$query->result();
				}
			}

			print_r(json_encode($result));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_expenses($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Expenses') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						break;
					}
				}
			}

			$data = array(
				'iextete_details' => $this->input->post('details'),
				'iextete_amount' => $this->input->post('amt'),
				'iextete_date' => $this->input->post('date'),
				'iextete_owner' => $oid,
				'iextete_created' => $dt,
				'iextete_created_by' => $uid,
				'iextete_gid' => $gid
			);
			$this->db->insert('i_ext_et_expenses', $data);
			$eid = $this->db->insert_id();

			$cat = $this->input->post('categories');

			for ($j=0; $j < count($cat) ; $j++) { 
				$tmp_tag = $cat[$j];

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
					'iet_type_id' => $eid,
					'iet_type' => 'expenses',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}
			echo $eid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function expenses_upload($code,$in_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			echo $code;
			echo $in_id;

			$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/expenses/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				if (strpos($_FILES['use']['tmp_name'], ".jpg")) {
					$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					// $img_path = $targetPath;
					//print_r($targetPath);
					$image = imagecreatefromjpeg($targetPath);
					imagejpeg($image, $targetPath, 10);

				} else if (strpos($_FILES['use']['tmp_name'], ".png")) {
					$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
					// $img_path = $targetPath;
					//print_r($targetPath);
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file


				} else {
					$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
					// $img_path = $targetPath;
					//print_r($targetPath);
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				}

				$img_path = $_FILES['use']['name'];

			}
			$data = array('iextete_file' => $img_path);
			$this->db->where(array('iextete_owner' => $oid, 'iextete_id' => $in_id));
			$this->db->update('i_ext_et_expenses', $data);
			echo "Img Path".$img_path;
		}
	}

	public function download_expenses($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/expenses/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_expenses WHERE iextete_owner='$oid' AND iextete_id = '$id' ");
			$result = $query->result();
			$file_name = $result[0]->iextete_file;

	    	$this->load->helper('download');
			force_download($path.$file_name, NULL);

		}else{
			redirect(base_url().'Account/login');
		}    
	}

	public function sort_chart($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$fdate = $this->input->post('fr_date');
			$edate = $this->input->post('to_date');

			if ($gid == 0) {
				$query = $this->db->query("SELECT iextete_date,it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_et_expense_tag as b on a.iextete_id=b.iextetet_e_id  left JOIN i_tags as c on b.iextetet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iextete_date BETWEEN '$fdate' AND '$edate' GROUP BY iextetet_tag_id ORDER BY iextete_date DESC");
				$result = $query->result();
				$data['e_expense'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_admin = 'true' AND ium_u_id = '$uid' AND ium_m_id = '$module_id' AND ium_gid = '$gid'");
				$result = $query->result();
				if (count($result) > 0 || $uid == $oid) {
					$query = $this->db->query("SELECT it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_et_expense_tag as b on a.iextete_id=b.iextetet_e_id  left JOIN i_tags as c on b.iextetet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iextete_gid = '$gid' GROUP BY iextetet_tag_id ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['e_expense'] = $result;
				}else{
					$query = $this->db->query("SELECT it_value,sum(iextete_amount) as amount FROM i_ext_et_expenses as a LEFT JOIN i_ext_et_expense_tag as b on a.iextete_id=b.iextetet_e_id  left JOIN i_tags as c on b.iextetet_tag_id=c.it_id WHERE iextete_owner = '$oid' AND iextete_gid = '$gid' AND iextete_created_by = '$uid' GROUP BY iextetet_tag_id ORDER BY iextete_date DESC");
					$result = $query->result();
					$data['e_expense'] = $result;
				}
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_expenses($code,$eid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$cat = $this->input->post('categories');

			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Expenses') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						break;
					}
				}
			}
			
			$data = array(
				'iextete_details' => $this->input->post('details'),
				'iextete_amount' => $this->input->post('amt'),
				'iextete_date' => $this->input->post('date'),
				'iextete_modified' => $dt,
				'iextete_modified_by' => $uid,
				'iextete_gid' => $gid
			);
			$this->db->WHERE('iextete_id',$eid);
			$this->db->update('i_ext_et_expenses', $data);

			$this->db->WHERE(array('iet_type_id'=>$eid,'iet_owner' => $oid, 'iet_m_id' => $module_id));
			$this->db->delete('i_ext_tags');

			for ($j=0; $j < count($cat) ; $j++) { 
				$tmp_tag = $cat[$j];

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
					'iet_type_id' => $eid,
					'iet_type' => 'expenses',
					'iet_tag_id' => $tid,
					'iet_owner' => $oid,
					'iet_m_id' => $module_id
				);
				$this->db->insert('i_ext_tags', $data5);
			}
			echo $eid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_expenses($code,$eid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$data = array( 'iextete_id' => $eid, 'iextete_owner' => $oid );
			$this->db->where($data);
			$this->db->delete('i_ext_et_expenses');

			$this->db->where('iextetet_e_id', $eid);
			$this->db->delete('i_ext_et_expense_tag');
			
			redirect(base_url().'Enterprise/expenses/0/'.$code);
		} else {
			redirect(base_url().'account/login');
		}
	}

########## FOLLOW UPS ################
	public function follow_up($mid, $txn_no,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$mname = '';
			$module = $sess_data['user_mod'];
			$dt = date('Y-m-d H:i:s');

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			}else{
				$data['dom'] = "[]";
			}

			for ($i=0; $i < count($sess_data['user_mod']) ; $i++) { 
				if ($sess_data['user_mod'][$i]->mid == $mid) {
					$mname = $sess_data['user_mod'][$i]->mname;
					$data['module_title'] = $mname;
					break;
				}
			}

			$data = array(
				'iua_type' => 'module',
				'iua_title' => $mname.' - '.$txn_no,
				'iua_date' => $dt,
				'iua_to_do' => 0,
				'iua_owner' => $oid,
				'iua_created_by'=> $uid,
				'iua_created' => $dt,
				'iua_status' => 'pending',
				'iua_categorise' => 'follow up',
				'iua_p_activity' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid
			);
			$this->db->insert('i_user_activity', $data);
			
			// $query = $this->db->query("SELECT * FROM i_ext_ed_followup WHERE iextfu_owner='$oid' AND iextfu_customer_id='$cid' AND iextfu_module='$module' ORDER BY iextfu_created DESC");
			// $result = $query->result();
			// $data['follow'] = $result;

			// $ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			// $ert['title'] = "Follow Up";
			// $ert['search'] = "false";

			// $data['module'] = $module;
			
			// $data['sid'] = $cid;

			// $this->load->view('navbar', $ert);
			// $this->load->view('Enterprise/follow_up', $data);
			// $this->load->view('home/search_modal');
			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	// public function update_follow_up($module, $cid) {
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {

	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$dt = date('Y-m-d H:i:s');

	// 		$data = array(
	// 			'iextfu_module' => $module,
	// 			'iextfu_customer_id' => $cid, 
	// 			'iextfu_followup' => $dt,
	// 			'iextfu_remind' => $this->input->post('remind'),
	// 			'iextfu_remarks' => $this->input->post('remarks'),
	// 			'iextfu_status' => 'Pending',
	// 			'iextfu_owner' => $oid, 
	// 			'iextfu_created' => $dt,
	// 			'iextfu_created_by' => $oid);

	// 		$this->db->insert('i_ext_ed_followup', $data);

	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

########## ACCOUNTING ################
	public function accounts() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM ((SELECT 'purchase' AS type, 'debit' AS method,  ac.ic_name AS name, a.iextep_txn_id AS txn, a.iextep_txn_date AS txn_date, '0' AS credit, a.iextep_amount AS debit, a.iextep_created AS created, a.iextep_owner AS oid FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS ac ON a.iextep_customer_id=ac.ic_id) UNION ALL (SELECT 'invoice' AS type, 'credit' AS method,  ab.ic_name AS name, b.iextein_txn_id AS txn, b.iextein_txn_date AS txn_date, b.iextein_amount AS credit, '0' AS debit, b.iextein_created AS created, b.iextein_owner AS oid FROM i_ext_et_invoice AS b LEFT JOIN i_customers AS ab ON b.iextein_customer_id=ab.ic_id) ) results WHERE oid='$oid' ORDER BY created DESC"); 
			$result = $query->result();
			$data['accounts'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Accounts";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/accounts', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function account_search() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;
			$search = $this->input->post('search');
			$from = $this->input->post('from');
			$to = $this->input->post('to');


			$query = $this->db->query("SELECT results.* FROM ((SELECT 'purchase' AS type, 'debit' AS method, ac.ic_name AS name, a.iextep_txn_id AS txn, a.iextep_txn_date AS txn_date, '0' AS credit, a.iextep_amount AS debit, a.iextep_created AS created, a.iextep_owner AS oid FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS ac ON a.iextep_customer_id=ac.ic_id) UNION ALL (SELECT 'invoice' AS type, 'credit' AS method,  ab.ic_name AS name, b.iextein_txn_id AS txn, b.iextein_txn_date AS txn_date, b.iextein_amount AS credit, '0' AS debit, b.iextein_created AS created, b.iextein_owner AS oid FROM i_ext_et_invoice AS b LEFT JOIN i_customers AS ab ON b.iextein_customer_id=ab.ic_id) ) results WHERE oid='$oid' AND (txn_date BETWEEN '$from' AND '$to') AND name LIKE '%$search%' ORDER BY created DESC"); 
			$result = $query->result();
		// 			print_r(json_encode($result));

            echo "SELECT results.* FROM ((SELECT 'purchase' AS type, 'debit' AS method, ac.ic_name AS name, a.iextep_txn_id AS txn, a.iextep_txn_date AS txn_date, '0' AS credit, a.iextep_amount AS debit, a.iextep_created AS created, a.iextep_owner AS oid FROM i_ext_et_purchase AS a LEFT JOIN i_customers AS ac ON a.iextep_customer_id=ac.ic_id) UNION ALL (SELECT 'invoice' AS type, 'credit' AS method,  ab.ic_name AS name, b.iextein_txn_id AS txn, b.iextein_txn_date AS txn_date, b.iextein_amount AS credit, '0' AS debit, b.iextein_created AS created, b.iextein_owner AS oid FROM i_ext_et_invoice AS b LEFT JOIN i_customers AS ab ON b.iextein_customer_id=ab.ic_id) ) results WHERE oid='$oid' AND (txn_date BETWEEN '$from' AND '$to') AND name LIKE '%$search%' ORDER BY created DESC";
		} else {
			redirect(base_url().'account/login');
		}
	}

########## LETTER ################
	public function letter($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' ORDER BY a.iextamc_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "AMC";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function letter_add($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/amc/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			// print_r($sess_data['user_mod']);
			$data["mod_id"] = $mod_id;

			$query = $this->db->query("SELECT * FROM i_u_m_document_id WHERE iumdi_customer_id = '$oid' AND iumdi_module_id='$mod_id' ORDER BY iumdi_id;");
			$result = $query->result();

			$data['syntax'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid'");
			$result = $query->result();
			
			if(count($result) > 0) {
			    $data['ac_year'] = $result[0]->iua_year_code;
    			$start_yr = $result[0]->iua_start_date;
    			$end_yr = $result[0]->iua_end_date;
			} else {
			    $data['ac_year'] = 'N/A';
    			$start_yr = 'N/A';
    			$end_yr = 'N/A';
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_et_amc WHERE iextamc_txn_date BETWEEN '$start_yr' AND '$end_yr' AND iextamc_owner = '$oid'");
			$result = $query->result();

			$a = count($result);
			if(count($result) > 0) {
				$data['inv_num'] = $a + 1;	
			} else {
				$data['inv_num'] = 1;
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='customer'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid' AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "AMC Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_letter($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$txn_from = $this->input->post('txn_period_from');
			$txn_to = $this->input->post('txn_period_to');
			
			$txn_amount = $this->input->post('txn_amt');
			$txn_note = $this->input->post('txn_note');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$rate = $this->input->post('rate');
			$disc = $this->input->post('disc');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='customer' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'customer';
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$data = array(
				'iextamc_customer_id' => $cid,
				'iextamc_txn_id' => $txn_no,
				'iextamc_txn_date' => $txn_date,
				'iextamc_period_from' => $txn_from,
				'iextamc_period_to' => $txn_to,
				'iextamc_type' => 'active',
				'iextamc_amount' => $txn_amount,
				'iextamc_note' => $txn_note,
				'iextamc_status' => 'unpaid',
				'iextamc_owner' => $oid,
				'iextamc_created' => $dt,
				'iextamc_created_by' => $oid);
			$this->db->insert('i_ext_et_amc', $data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				$tmp_qty = $qty[$i];
				// $tmp_rate = $rate[$i];
				// $tmp_disc = $disc[$i];

				// $tmp_disc_calc = 0;
				// if (strpos($tmp_disc, "%") !== false) {
				// 	$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
				// 	$tmp_disc_calc = (float)$ptst;

				// 	$tmp_amt = $tmp_rate*$tmp_qty;
				// 	$tmp_amt = ($tmp_amt - ($tmp_amt * $tmp_disc_calc) / 100);
				// } else {
				// 	$tmp_disc_calc = (float)$tmp_disc;

				// 	$tmp_amt = $tmp_rate*$tmp_qty;
				// 	$tmp_amt = $tmp_amt - $tmp_disc_calc;
				// }
								

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;

					// $que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
					// $res = $que->result();

					// for ($j=0; $j < count($res) ; $j++) { 
					// 	$tx_percent = $res[$j]->itx_percent;
					// 	$tx_name = $res[$j]->itx_name;
					// 	$tx_id = $res[$i]->itx_id;

					// 	$tx_amt = $tmp_amt * $tx_percent / 100;

					// 	$data2 = array(
					// 		'iexteinpt_d_id' => $inid,
					// 		'iexteinpt_p_id' => $prid,
					// 		'iexteinpt_t_id' => $tx_id,
					// 		'iexteinpt_t_name' => $tx_name,
					// 		'iexteinpt_t_percent' => $tx_percent,
					// 		'iexteinpt_t_amount' => $tx_amt
					// 	);

					// 	$this->db->insert("i_ext_et_invoice_product_taxes", $data2);
					// }
				} else {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				}

				$data = array(
					'iextamcpd_d_id' => $inid,
					'iextamcpd_product_id' => $prid,
					// 'iextamcpd_rate' => $tmp_rate,
					'iextamcpd_qty' => $tmp_qty,
					// 'iextamcpd_discount' => $tmp_disc,
					// 'iextamcpd_amount' => $tmp_amt,
					'iextamcpd_owner' => $oid);
				$this->db->insert('i_ext_et_amc_product_details', $data);
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

				$data4 = array(
					'iextamctg_txn_id' => $inid,
					'iextamctg_tag_id' => $tid);

				$this->db->insert('i_ext_et_amc_tags', $data4);
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function letter_print($mod_id, $amc_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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


			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextamc_id='$amc_id' AND a.iextamc_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextamc_id='$amc_id' AND a.iextamc_owner = '$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextamc_txn_id;
				$data['s_txn_date'] = $result[0]->iextamc_txn_date;
				$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
				$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
				$data['s_txn_note'] = $result[0]->iextamc_note;
				$data['s_txn_amount'] = $result[0]->iextamc_amount;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextamc_txn_id;
				$data['s_txn_date'] = $result[0]->iextamc_txn_date;
				$data['s_txn_start_date'] = $result[0]->iextamc_period_from;
				$data['s_txn_end_date'] = $result[0]->iextamc_period_to;
				$data['s_txn_note'] = $result[0]->iextamc_note;
				$data['s_txn_amount'] = $result[0]->iextamc_amount;
			}


			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$u_owner'");
			$result = $query->result();

			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers As b ON a.iextamc_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iextamc_id='$amc_id'");
			$result = $query->result();
			
			if(count($result) > 0) {
				$data['s_gst'] = $result[0]->icbd_value;
			} else {
				$data['s_gst'] = '';
			}


			$query = $this->db->query("SELECT * FROM i_ext_et_amc_product_details AS a LEFT JOIN i_product AS d ON a.iextamcpd_product_id=d.ip_id WHERE a.iextamcpd_d_id='$amc_id'");
			$result = $query->result();
			$data['details'] = $result;

			// $query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_taxes WHERE iexteinpt_d_id='$invoice_id'");
			// $result = $query->result();
			// $data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='AMC' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;

			$data['s_title'] = "Annual Maintainance Contract";

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;

			$this->load->view('enterprise/amc_print', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function leter_edit($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/amc/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
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

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='customer'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE (ip_section='Products' OR ip_section='Services') AND ip_owner='$oid' AND ip_gid = '$gid' ");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner='$oid' AND a.iextamc_id='$inid'");	
			$result = $query->result();
			$data['edit_amc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_product_details AS a LEFT JOIN i_product AS b ON a.iextamcpd_product_id=b.ip_id WHERE a.iextamcpd_owner='$oid' AND a.iextamcpd_d_id='$inid'");	
			$result = $query->result();
			$data['edit_amc_details'] = $result;

			// $query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			// $result = $query->result();
			// $data['serial_number'] = $result;

			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc_tags WHERE iextamctg_txn_id='$inid'");	
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Edit AMC";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc_add', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_letter($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$txn_from = $this->input->post('txn_period_from');
			$txn_to = $this->input->post('txn_period_to');
			
			$txn_amount = $this->input->post('txn_amt');
			$txn_note = $this->input->post('txn_note');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$rate = $this->input->post('rate');
			$disc = $this->input->post('disc');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');


			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='customer' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'customer';
			$result = $query->result();

			if(count($result) > 0) {
				$cid = $result[0]->ic_id;
			} else {
				$data1 = array(
					'ic_name' => $customer,
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_section' => $ctype,
					'ic_created_by' => $oid );
				$this->db->insert('i_customers', $data1);
				$cid = $this->db->insert_id();
			}

			$data = array(
				'iextamc_customer_id' => $cid,
				'iextamc_txn_id' => $txn_no,
				'iextamc_txn_date' => $txn_date,
				'iextamc_period_from' => $txn_from,
				'iextamc_period_to' => $txn_to,
				'iextamc_amount' => $txn_amount,
				'iextamc_note' => $txn_note);
			$this->db->where('iextamc_id', $inid);
			$this->db->update('i_ext_et_amc', $data);
			
			$this->db->where('iextamcpd_d_id', $inid);
			$this->db->delete('i_ext_et_amc_product_details');

			$this->db->where('iextamct_d_id', $inid);
			$this->db->delete('i_ext_et_amc_taxes');

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				
				$tmp_qty = $qty[$i];
				// $tmp_rate = $rate[$i];
				// $tmp_disc = $disc[$i];

				// $tmp_disc_calc = 0;
				// if (strpos($tmp_disc, "%") !== false) {
				// 	$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
				// 	$tmp_disc_calc = (float)$ptst;

				// 	$tmp_amt = $tmp_rate*$tmp_qty;
				// 	$tmp_amt = ($tmp_amt - ($tmp_amt * $tmp_disc_calc) / 100);
				// } else {
				// 	$tmp_disc_calc = (float)$tmp_disc;

				// 	$tmp_amt = $tmp_rate*$tmp_qty;
				// 	$tmp_amt = $tmp_amt - $tmp_disc_calc;
				// }

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;

					// $que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
					// $res = $que->result();



					// for ($j=0; $j < count($res) ; $j++) { 
					// 	$tx_percent = $res[$j]->itx_percent;
					// 	$tx_name = $res[$j]->itx_name;
					// 	$tx_id = $res[$i]->itx_id;

					// 	$tx_amt = $tmp_amt * $tx_percent / 100;

					// 	$data2 = array(
					// 		'iexteinpt_d_id' => $inid,
					// 		'iexteinpt_p_id' => $prid,
					// 		'iexteinpt_t_id' => $tx_id,
					// 		'iexteinpt_t_name' => $tx_name,
					// 		'iexteinpt_t_percent' => $tx_percent,
					// 		'iexteinpt_t_amount' => $tx_amt
					// 	);

					// 	$this->db->insert("i_ext_et_invoice_product_taxes", $data2);
					// }
				} else {
					$data1 = array(
						'ip_product' => $pd,
						'ip_section' => 'Products',
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $oid );
					$this->db->insert('i_product', $data1);
					$prid = $this->db->insert_id();
				}

				$data = array(
					'iextamcpd_d_id' => $inid,
					'iextamcpd_product_id' => $prid,
					// 'iextamcpd_rate' => $tmp_rate,
					'iextamcpd_qty' => $tmp_qty,
					// 'iexteinpd_discount' => $tmp_disc,
					// 'iexteinpd_amount' => $tmp_amt,
					'iextamcpd_owner' => $oid);
				$this->db->insert('i_ext_et_amc_product_details', $data);
			}

			$this->db->where('iextamctg_txn_id', $inid);
			$this->db->delete('i_ext_et_amc_tags');

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
					'iextamctg_txn_id' => $inid,
					'iextamctg_tag_id' => $tid);
				$this->db->insert('i_ext_et_amc_tags', $data4);
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_letter($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			// $this->db->where('ip_id', $prid);
			// $this->db->delete('i_product');

			// $this->db->where('ipp_p_id',$prid);
			// $this->db->delete('i_p_price');

			
			// $this->db->where('ipf_product_id', $prid);
			// $this->db->delete('i_p_features');

			// $this->db->where('ipft_product_id', $prid);
			// $this->db->delete('i_p_f_tags');

			redirect(base_url().'Enterprise/products');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## MODULE ACTIVITY #########
	public function module_activity($cid,$txn_no,$mname,$inid,$type){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$gid = $sess_data['gid'];
			$data = array(
				'iua_type' => 'module',
				'iua_title' => $mname.' - '.$txn_no,
				'iua_date' => $dt,
				'iua_owner' => $oid,
				'iua_created_by' => $oid,
				'iua_created' => $dt,
				'iua_status' => 'pending',
				'iua_categorise' => $type,
				'iua_p_activity' => 0,
				'iua_to_do' => 0,
				'iua_shortcuts' => 0,
				'iua_m_shortcuts' => 0,
				'iua_g_id' => $gid
			);
			$this->db->insert('i_user_activity',$data);

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## Module Setting ##########

	public function module_setting($type,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';$func='';$dom_loc='';
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == $type) {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$func = $module[$i]->function;
						$dom_loc = $module[$i]->domain;
						$data['mod_id']=$mid;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * from i_template WHERE itemp_module=$mid ;");
			$result = $query->result();
			$data['template'] = $result;

			$query = $this->db->query("SELECT * from i_u_m_document_id where iumdi_customer_id = '$oid' and iumdi_module_id = '$mid' ");
			$result = $query->result();
			$data['doc_id'] = $result;

			$query = $this->db->query("SELECT * from i_user_template as a LEFT JOIN i_u_t_copies as b on a.iut_tempid=b.iutc_temp_id WHERE iut_mid = $mid and iut_owner = '$oid';");
			$result = $query->result();
			if (count($result) > 0 ) {
				$data['s_temp'] = $result[0]->iut_tempid;
			}else{
				$data['s_temp'] = 0;
			}
			$data['temp_cat'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['title'] = $mname." Setting";
			$ert['search'] = "false";
			$ert['code']=$code;
			$ert['gid']=$gid;$ert['mid']=$mid;$ert['mname']=$mname;$ert['fname']=$func;$ert['dom_loc']=$dom_loc;
			$query = $this->db->query("SELECT * FROM i_template AS a LEFT JOIN i_modules AS b ON a.itemp_module=b.im_id WHERE a.itemp_module = '$mid' GROUP BY a.itemp_module");
			$data['mod_temp'] = $query->result();
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/module_setting', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}	

	public function save_template_copies($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$tid = $this->input->post('tid');
			$mid = $this->input->post('mid');
			$copies = $this->input->post('copies');

			$this->db->where(array('iut_owner' => $oid, 'iut_mid' => $mid));
			$this->db->delete('i_user_template');

			$this->db->insert('i_user_template', array('iut_owner' => $oid, 'iut_mid' => $mid, 'iut_tempid' => $tid));

			$this->db->where(array('iutc_owner' => $oid, 'iutc_mod_id' => $mid));
			$this->db->delete('i_u_t_copies');

			for ($i=0; $i <count($copies) ; $i++) { 
				$this->db->insert('i_u_t_copies', array('iutc_owner' => $oid, 'iutc_temp_id' => $tid, 'iutc_mod_id' => $mid ,'iutc_copies' => $copies[$i] ));
			}

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_module_doc($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$doc_variable = $this->input->post('doc_variable');
			$mid = $this->input->post('mid');

			$data1 = array('iumdi_customer_id' => $oid, 'iumdi_module_id' => $mid);
			$this->db->where($data1);
			$this->db->delete('i_u_m_document_id');

			for ($i=0; $i < count($doc_variable) ; $i++) { 
				$flg = 'true';
				if($doc_variable[$i]['val'] != "acc_yr" && $doc_variable[$i]['val'] != "txn_no") {
					$flg = 'false';
				}
				$data = array(
					'iumdi_customer_id' => $oid,
					'iumdi_module_id' => $mid,
					'iumdi_doc_syntax' => $doc_variable[$i]['val'],
					'iumdi_variable' => $flg
				);
				$this->db->insert('i_u_m_document_id', $data);
			}

			echo "true";
		}else{
			redirect(base_url().'account/login');
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

########## payment #################

	public function pay_save($module_id,$code,$tid,$flg){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mname = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mid == $module_id) {
					$mname = $module[$i]->mname;
					break;
				}
			}
			$dt = date('Y-m-d H:i:s');
			$p_mode = $this->input->post('p_mode');
			$p_date = $this->input->post('p_date');
			$p_desc = $this->input->post('p_desc');
			$p_amt = $this->input->post('p_amt');
			$p_vno = $this->input->post('p_vno');

			if ($flg == 0) {
				$data = array(
					'iextepay_tx_no' => $tid,
					'iextepay_mode' => $p_mode, 
					'iextepay_date' => $p_date,
					'iextepay_desc' => $p_desc,
					'iextepay_amount'=> $p_amt,
					'iextepay_vno' => $p_vno,
					'iextepay_oid' => $oid,
					'iextepay_created' => $dt,
					'iextepay_created_by' => $uid,
					'iextepay_gid' => $gid,
					'iextepay_mid' => $module_id,
					'iextepay_mname' => $mname
				);
				$this->db->insert('i_ext_et_payment',$data);
			}else{
				$data = array(
					'iextepay_mode' => $p_mode, 
					'iextepay_date' => $p_date,
					'iextepay_desc' => $p_desc,
					'iextepay_amount'=> $p_amt,
					'iextepay_vno' => $p_vno,
					'iextepay_modified' => $dt,
					'iextepay_modified_by' => $uid
				);
				$this->db->WHERE(array('iextepay_id'=>$flg,'iextepay_oid'=>$oid,'iextepay_gid'=>$gid,'iextepay_mid'=>$module_id));
				$this->db->update('i_ext_et_payment',$data);
			}

			// echo "true";
			echo $module_id;
			echo $mname;
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function pay_delete($module_id,$code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->WHERE(array('iextepay_id'=>$tid,'iextepay_oid'=>$oid,'iextepay_gid'=>$gid,'iextepay_mid'=>$module_id));
			$this->db->delete('i_ext_et_payment');
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function pay_edit($module_id,$code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_payment WHERE iextepay_oid = '$oid' AND iextepay_gid = '$gid' AND iextepay_id = '$tid' AND iextepay_mid = '$module_id' ");
			$result = $query->result();
			$data['pay_details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function get_amount_word($number){
		$no = round($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
		 $divider = ($i == 2) ? 10 : 100;
		 $number = floor($no % $divider);
		 $no = floor($no / $divider);
		 $i += ($divider == 10) ? 1 : 2;
		 if ($number) {
		    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		    $str [] = ($number < 21) ? $words[$number] .
		        " " . $digits[$counter] . $plural . " " . $hundred
		        :
		        $words[floor($number / 10) * 10]
		        . " " . $words[$number % 10] . " "
		        . $digits[$counter] . $plural . " " . $hundred;
		 } else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
		"." . $words[$point / 10] . " " . 
		      $words[$point = $point % 10] : '';
		echo $result . "only ";
	}
}