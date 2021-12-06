<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
	}

########## HOME ################
	public function index() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Files";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('file_storage/file_storage', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}
	
	public function new_file() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Files";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			// $this->load->view('customers/customer', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## CUSTOMERS ################
	public function customers() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_section = 'Customers' AND a.ic_owner='$oid'");
			$result = $query->result();

			$data['customer'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Customers";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function customer_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Customers'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$data['thing'] = 'Customer';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Customer";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_customer() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			$c_tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_name' => $c_name,
				'ic_owner' => $oid,
				'ic_created' => $dt,
				'ic_section' => 'Customers',
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

			
			$pp = $c_property[0]['n_p'];
			$n_pp = array();
			for ($i=0; $i < count($pp) ; $i++) { 
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Customers');	

				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}


			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 

				$data = array('icbd_customer_id'=> $cid, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
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

				$data4 = array(
					'ictp_customer_id' => $cid,
					'ictp_tag_id' => $tid,
					'ictp_created' => $dt);

				$this->db->insert('i_c_t_prefernces', $data4);
			}

			echo $cid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function customer_edit($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Customers'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id='$c_id' AND ic_owner='$oid'");
			$result = $query->result();

			$data['edit_customer'] = $result;

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id='$c_id'");
			$result1 = $query1->result();

			$data['edit_basic_details'] = $result1;

			$query2 = $this->db->query("SELECT * FROM i_c_t_prefernces WHERE ictp_customer_id='$c_id'");
			$result2 = $query2->result();

			$data['edit_preferences'] = $result2;

			$data['cid'] = $c_id;

			$data['thing'] = 'Customer';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Customer Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/customer_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_customer($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			

			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			$c_tags = $this->input->post('tags');

			print_r($c_property);

			print_r($c_value);

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_name' => $c_name,
				'ic_modified' => $dt,
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
			for ($i=0; $i < count($pp) ; $i++) { 
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Customers');	

				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}

			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 

				$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
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

				$data4 = array(
					'ictp_customer_id' => $c_id,
					'ictp_tag_id' => $tid,
					'ictp_created' => $dt);

				$this->db->insert('i_c_t_prefernces', $data4);
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_customer($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$this->db->where('ic_id', $c_id);
			$this->db->delete('i_customers');
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			redirect(base_url().'Enterprise/customers');

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function uploadfile($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
		
			$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/irene/assets/uploads/".$oid."/";
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
					$image = imagecreatefromjpeg($targetPath);
					imagejpeg($image, $targetPath, 10);

				} else if (strpos($_FILES['use']['tmp_name'], ".png")) {
					$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
					// $img_path = $targetPath;
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file


				} else {
					$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
					// $img_path = $targetPath;
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file	
				}
				
				$img_path = $_FILES['use']['name'];
				echo $_FILES['use']['name'];

			}

			$this->db->where('icp_c_id', $cid);
			$this->db->delete('i_c_pic');

			$data = array('icp_c_id' => $cid, 'icp_path' => $img_path );
			$this->db->insert('i_c_pic', $data);
		}
	}

########## PRODUCTS & SERVICES ################
	public function products() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products'");
			$result = $query->result();

			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Products";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/product', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function product_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();

			$data['tax_group'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Product Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/product_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_product() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_tags = $this->input->post('tags');
			$dt = date('Y-m-d H:i:s');

			$dt1 = date('Y-m-d');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ip_product' => $pr_name,
				'ip_section' => 'Products',
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

				$data4 = array(
					'ipft_product_id' => $prid,
					'ipft_tag_id' => $tid);

				$this->db->insert('i_p_f_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function product_edit($p_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();

			$data['tax_group'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_id='$p_id' AND ip_owner='$oid' AND ip_section='Products'");
			$result = $query->result();

			$data['edit_product'] = $result;
			
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
			
			$query = $this->db->query("SELECT * FROM i_p_f_tags WHERE ipft_product_id = '$p_id'");
			$result = $query->result();

			$data['edit_preferences'] = $result;

			$data['pid'] =$p_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Products Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/product_add', $data);	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_product($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

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

	public function delete_product($prid) {
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

	public function services() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Services'");
			$result = $query->result();

			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Services";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/service', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function service_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Service Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/service_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_service() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

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
					'ipft_tag_id' => $tid);

				$this->db->insert('i_p_f_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function service_edit($p_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

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
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_service($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

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

			redirect(base_url().'Enterprise/services');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## INVENTORY ################
	public function inventory($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_owner = '$oid' ORDER BY a.iextei_id DESC");
			$result = $query->result();

			$data['inventory'] = $result;

			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Inventory";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_add($type, $mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/inventory/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$data['mod_id'] = $mod_id;

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
			

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory WHERE iextei_txn_date BETWEEN '$start_yr' AND '$end_yr' AND iextei_owner = '$oid' AND iextei_type='outward'");
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

			if ($type == "inward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Vendors'");
			} else if($type == "outward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			}

			
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			$result = $query->result();
			$data['serial_number'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_section='Products'");	
			$result = $query->result();
			$data['product'] = $result;

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
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_inventory($type, $mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			if($type == "inward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Vendors' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'Vendors';
			} else if ($type == "outward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'Customers';
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
				'iextei_owner' => $oid,
				'iextei_created' => $dt,
				'iextei_created_by' => $oid);
			$this->db->insert('i_ext_et_inventory', $data);
			$inid = $this->db->insert_id();

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
					'iexteid_serial_number' => $sn[$i]);
				$this->db->insert('i_ext_et_inventory_details', $data);
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
					'iextett_txn_id' => $inid,
					'iextett_tag_id' => $tid);

				$this->db->insert('i_ext_et_inventory_tags', $data4);
			}
			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_edit($type, $mod_id , $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/inventory/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			if ($type == "inward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Vendors'");
			} else if($type == "outward") {
				$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			}

			$data['mod_id'] = $mod_id;

			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_owner='$oid' AND ip_section='Products'");	
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
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_inventory($type, $mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			if($type == "inward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Vendors' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'Vendors';
			} else if ($type == "outward") {
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
				$ctype = 'Customers';
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

	public function delete_inventory($prid) {
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

	public function inventory_status() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products'");
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
			
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' OR ic_section='Vendors' AND  ic_owner = '$oid'");
			$result = $query->result();

			$data['customers'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Inventory Status";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/inventory_status', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function inventory_get_status() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
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
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section = 'Customers' AND ic_owner = '$oid' AND ic_name='$tcust' OR ic_section = 'Vendors' AND ic_owner = '$oid' AND ic_name='$tcust'");
				$result = $query->result();

				array_push($cust_id, $result[0]->ic_id);
			}
			

			$cust_str = implode(",", $cust_id);
			$prod_str = implode(",", $prod_id);

			if ((count($prod_id) > 0) && (count($cust_id) > 0)) {
				$query = $this->db->query("SELECT ic_name, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_customer_id IN ($cust_str) AND b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else if ((count($prod_id)) > 0) {
				$query = $this->db->query("SELECT ic_name, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE b.iexteid_product_id IN ($prod_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else if ((count($cust_id) > 0)) {
				$query = $this->db->query("SELECT  ic_name, iextei_txn_id, iextei_txn_date, iextei_type, ip_product, iexteid_inward, iexteid_outward, iexteid_balance FROM i_ext_et_inventory AS a LEFT JOIN i_ext_et_inventory_details AS b ON a.iextei_id=b.iexteid_e_id LEFT JOIN i_customers AS c ON a.iextei_customer_id=c.ic_id LEFT JOIN i_product AS d ON b.iexteid_product_id=d.ip_id WHERE a.iextei_customer_id IN ($cust_str) ORDER BY a.iextei_id DESC");
				$result = $query->result();
				$data['result']  = $result;
				$data['type'] = "record";
				print_r(json_encode($data));

			} else {
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Products'");
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

	public function inventory_outward_print($mod_id, $out_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$u_owner = $sess_data['user_details'][0]->i_owner;

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

			$query = $this->db->query("SELECT * FROM i_ext_et_inventory_details AS a LEFT JOIN i_product AS b ON a.iexteid_product_id=b.ip_id WHERE a.iexteid_e_id='$out_id' AND a.iexteid_owner='$oid'");
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

########## TAX ################
	public function tax() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid'");
			$result = $query->result();

			$data['tax'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax_add');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_tax() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$name = $this->input->post('name');
			$percent = $this->input->post('percent');
			
			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'itx_name' => $name,
				'itx_percent' => $percent,
				'itx_owner' => $oid);

			$this->db->insert('i_taxes', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_edit($t_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_id = '$t_id' AND itx_owner='$oid'");
			$result = $query->result();

			$data['edit_tax'] = $result;
			
			$data['tid'] =$t_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax_add', $data);	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_tax($tid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$name = $this->input->post('name');
			$percent = $this->input->post('percent');
			
			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'itx_name' => $name,
				'itx_percent' => $percent);
			$this->db->where('itx_id', $tid);
			$this->db->update('i_taxes', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_tax($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$this->db->where('itx_id', $prid);
			$this->db->delete('i_taxes');

			redirect(base_url().'Enterprise/tax');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_group() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner = '$oid'");
			$result = $query->result();

			$data['tax_group'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax_group', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_group_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid'");
			$result = $query->result();

			$data['tax'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax_group_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_tax_group() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$name = $this->input->post('name');
			$taxes = $this->input->post('taxes');
			
			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ittxg_group_name' => $name,
				'ittxg_owner' => $oid);
			$this->db->insert('i_tax_group', $data);
			$tg_id = $this->db->insert_id();

			for ($i=0; $i < count($taxes) ; $i++) { 
				$tname = $taxes[$i];
				$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
				$result = $query->result();

				if(count($result) > 0) {
					$txid = $result[0]->itx_id;
				} else {
					$data = array(
						'itx_name' => $tname,
						'itx_owner' => $oid);
					$this->db->insert('i_taxes', $data);
					$txid = $this->db->insert_id();
				}

				$data1 = array(
					'itxgc_tg_id' => $tg_id,
					'itxgc_tx_id' => $txid );
				$this->db->insert('i_tax_group_collection', $data1);
			}

			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function tax_group_edit($t_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_id = '$t_id' AND ittxg_owner='$oid'");
			$result = $query->result();
			$data['edit_tax_group'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_tax_group_collection WHERE itxgc_tg_id = '$t_id'");
			$result = $query->result();
			$data['edit_tax_group_item'] = $result;

			$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_owner = '$oid'");
			$result = $query->result();

			$data['tax'] = $result;
			
			$data['tid'] =$t_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tax Group Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/tax_group_add', $data);	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_tax_group($tid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$name = $this->input->post('name');
			$taxes = $this->input->post('taxes');
			
			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ittxg_group_name' => $name,
				'ittxg_owner' => $oid);
			$this->db->where('ittxg_id', $tid);
			$this->db->update('i_tax_group', $data);
			
			$this->db->where('itxgc_tg_id', $tid);
			$this->db->delete('i_tax_group_collection');

			for ($i=0; $i < count($taxes) ; $i++) { 
				$tname = $taxes[$i];
				$query = $this->db->query("SELECT * FROM i_taxes WHERE itx_name = '$tname' AND itx_owner = '$oid'");
				$result = $query->result();

				if(count($result) > 0) {
					$txid = $result[0]->itx_id;
				} else {
					$data = array(
						'itx_name' => $tname,
						'itx_owner' => $oid);
					$this->db->insert('i_taxes', $data);
					$txid = $this->db->insert_id();
				}

				$data1 = array(
					'itxgc_tg_id' => $tid,
					'itxgc_tx_id' => $txid );
				$this->db->insert('i_tax_group_collection', $data1);
			}

			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_tax_group($prid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$this->db->where('itxgc_tg_id', $prid);
			$this->db->delete('i_tax_group_collection');

			redirect(base_url().'Enterprise/tax');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## TERMS ################
	public function document_terms ($document) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document'");
			$result = $query->result();

			$data['doc'] = $result;

			$data['document'] = $document;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = $document." Terms";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/document_terms', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_document_terms ($document) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$data = array(
				'iextdt_term' => $this->input->post('name'),
				'iextdt_document' => $document,
				'iextdt_owner' => $oid,
				'iextdt_created' => $dt,
				'iextdt_created_by' => $oid );

			$this->db->insert('i_ext_et_document_terms', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function edit_document_terms ($document, $did) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document'");
			$result = $query->result();

			$data['doc'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_owner = '$oid' AND iextdt_document='$document' AND iextdt_id = '$did'");
			$result = $query->result();

			$data['edit_doc'] = $result;

			$data['did'] = $did;


			$data['document'] = $document;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = $document." Terms";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/document_terms', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_document_terms ($document, $did) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$data = array(
				'iextdt_term' => $this->input->post('name'),
				'iextdt_document' => $document);
			$this->db->where('iextdt_id', $did);
			$this->db->update('i_ext_et_document_terms', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_document_terms ($document, $did) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$this->db->where('iextdt_id', $did);
			$this->db->delete('i_ext_et_document_terms');

			redirect(base_url().'Enterprise/document_terms/'.$document);
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## TAX INVOICE ################
	public function invoice($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner = '$oid' ORDER BY a.iextein_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Invoice";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/invoice', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_add($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/invoice/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

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
			
			$query = $this->db->query("SELECT * FROM i_ext_et_invoice WHERE iextein_txn_date BETWEEN '$start_yr' AND '$end_yr' AND iextein_owner = '$oid'");
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

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
			$result = $query->result();
			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Invoice Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/invoice_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_get_price() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
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

	public function save_invoice($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
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

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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
				'iextein_customer_id' => $cid,
				'iextein_txn_id' => $txn_no,
				'iextein_txn_date' => $txn_date,
				'iextein_type' => 'active',
				'iextein_amount' => $txn_amount,
				'iextein_note' => $txn_note,
				'iextein_status' => 'unpaid',
				'iextein_owner' => $oid,
				'iextein_created' => $dt,
				'iextein_created_by' => $oid);
			$this->db->insert('i_ext_et_invoice', $data);
			$inid = $this->db->insert_id();

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				$tmp_qty = $qty[$i];
				$tmp_rate = $rate[$i];
				$tmp_disc = $disc[$i];

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
								

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;

					$que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
					$res = $que->result();

					for ($j=0; $j < count($res) ; $j++) { 
						$tx_percent = $res[$j]->itx_percent;
						$tx_name = $res[$j]->itx_name;
						$tx_id = $res[$i]->itx_id;

						$tx_amt = $tmp_amt * $tx_percent / 100;

						$data2 = array(
							'iexteinpt_d_id' => $inid,
							'iexteinpt_p_id' => $prid,
							'iexteinpt_t_id' => $tx_id,
							'iexteinpt_t_name' => $tx_name,
							'iexteinpt_t_percent' => $tx_percent,
							'iexteinpt_t_amount' => $tx_amt
						);

						$this->db->insert("i_ext_et_invoice_product_taxes", $data2);
					}
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
					'iexteinpd_d_id' => $inid,
					'iexteinpd_product_id' => $prid,
					'iexteinpd_rate' => $tmp_rate,
					'iexteinpd_qty' => $tmp_qty,
					'iexteinpd_discount' => $tmp_disc,
					'iexteinpd_amount' => $tmp_amt,
					'iexteinpd_owner' => $oid);
				$this->db->insert('i_ext_et_invoice_product_details', $data);
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
					'iexteint_txn_id' => $inid,
					'iexteint_tag_id' => $tid);

				$this->db->insert('i_ext_et_invoice_tags', $data4);
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_print($mod_id, $invoice_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$u_owner = $sess_data['user_details'][0]->i_owner;


			$dat = array('skip_edit' => "true");
			$this->session->set_userdata($dat);

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%Address%' AND a.iextein_id='$invoice_id' AND a.iextein_owner='$oid'");
			$result = $query->result();
			$data['basic'] = $result;

			if(count($result) <= 0) {
				$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE a.iextein_id='$invoice_id' AND a.iextein_owner = '$oid'");
				$result = $query->result();
				$data['basic'] = $result;

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_txn_id'] = $result[0]->iextein_txn_id;
				$data['s_txn_date'] = $result[0]->iextein_txn_date;
				$data['s_txn_note'] = $result[0]->iextein_note;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_txn_id'] = $result[0]->iextein_txn_id;
				$data['s_txn_date'] = $result[0]->iextein_txn_date;
				$data['s_txn_note'] = $result[0]->iextein_note;
			}


			$query = $this->db->query("SELECT iud_gst FROM i_u_details WHERE iud_u_id='$u_owner'");
			$result = $query->result();

			$data['u_gst'] = $result[0]->iud_gst;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers As b ON a.iextein_customer_id=b.ic_id LEFT JOIN i_c_basic_details AS c ON b.ic_id=c.icbd_customer_id LEFT JOIN i_property AS d ON c.icbd_property=d.ip_id WHERE d.ip_property LIKE '%GST%' AND a.iextein_id='$invoice_id'");
			$result = $query->result();
			
			if(count($result) > 0) {
				$data['s_gst'] = $result[0]->icbd_value;
			} else {
				$data['s_gst'] = '';
			}


			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_details AS a LEFT JOIN i_p_taxes AS b ON a.iexteinpd_product_id=b.ipt_p_id LEFT JOIN i_tax_group AS c ON b.ipt_t_id=c.ittxg_id LEFT JOIN i_product AS d ON a.iexteinpd_product_id=d.ip_id WHERE a.iexteinpd_d_id='$invoice_id'");
			$result = $query->result();
			$data['details'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_taxes WHERE iexteinpt_d_id='$invoice_id'");
			$result = $query->result();
			$data['taxes'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_document_terms WHERE iextdt_document='Invoice' AND iextdt_owner='$oid'");
			$result = $query->result();
			$data['terms'] = $result;

			$data['s_title'] = "Tax Invoice";

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;



			$this->load->view('enterprise/invoice_print', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_edit($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/invoice/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice AS a LEFT JOIN i_customers AS b ON a.iextein_customer_id=b.ic_id WHERE a.iextein_owner='$oid' AND a.iextein_id='$inid'");	
			$result = $query->result();
			$data['edit_invoice'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_product_details AS a LEFT JOIN i_product AS b ON a.iexteinpd_product_id=b.ip_id WHERE a.iexteinpd_owner='$oid' AND a.iexteinpd_d_id='$inid'");	
			$result = $query->result();
			$data['edit_invoice_details'] = $result;

			$query = $this->db->query("SELECT iexteid_serial_number AS sn FROM i_ext_et_inventory_details GROUP BY iexteid_serial_number HAVING COUNT(1) = 1");
			$result = $query->result();
			$data['serial_number'] = $result;

			$data['inid'] = $inid;

			$query = $this->db->query("SELECT * FROM i_ext_et_invoice_tags WHERE iexteint_txn_id='$inid'");	
			$result = $query->result();
			$data['edit_preferences'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Invoice";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/invoice_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invoice_delete_product() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$txnid = $this->input->post('txnid');
			$docid = $this->input->post('docid');

			$data = array('iexteinpd_owner' => $oid , 'iexteinpd_d_id' => $docid, 'iexteinpd_id' => $txnid );
			$this->db->where($data);
			$this->db->delete('i_ext_et_invoice_product_details');
		}
	}

	public function update_invoice($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$customer = $this->input->post('customer');
			$txn_no = $this->input->post('txn_no');
			$txn_date = $this->input->post('txn_date');
			$txn_amount = $this->input->post('txn_amt');
			$products = $this->input->post('products');
			$qty = $this->input->post('qty');
			$rate = $this->input->post('rate');
			$disc = $this->input->post('disc');
			$sn = $this->input->post('sn');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$dt1 = date('Y-m-d');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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
				'iextein_customer_id' => $cid,
				'iextein_txn_id' => $txn_no,
				'iextein_txn_date' => $txn_date,
				'iextein_type' => 'active',
				'iextein_amount' => $txn_amount,
				'iextein_status' => 'unpaid',
				'iextein_owner' => $oid,
				'iextein_created' => $dt,
				'iextein_created_by' => $oid);
			$this->db->where('iextein_id', $inid);
			$this->db->update('i_ext_et_invoice', $data);
			
			$this->db->where('iexteinpd_d_id', $inid);
			$this->db->delete('i_ext_et_invoice_product_details');

			$this->db->where('iexteinpt_d_id', $inid);
			$this->db->delete('i_ext_et_invoice_product_taxes');

			for ($i=0; $i < count($products) ; $i++) { 
				$pd = $products[$i];
				
				$tmp_qty = $qty[$i];
				$tmp_rate = $rate[$i];
				$tmp_disc = $disc[$i];

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

				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product='$pd' AND ip_owner='$oid' AND ip_section='Products'");
				$result = $query->result();

				if(count($result)>0) {
					$prid = $result[0]->ip_id;

					$que = $this->db->query("SELECT * FROM i_p_taxes AS a LEFT JOIN i_tax_group_collection AS b ON a.ipt_t_id=b.itxgc_tg_id LEFT JOIN i_taxes AS c ON b.itxgc_tx_id=c.itx_id WHERE ipt_p_id = '$prid'");
					$res = $que->result();



					for ($j=0; $j < count($res) ; $j++) { 
						$tx_percent = $res[$j]->itx_percent;
						$tx_name = $res[$j]->itx_name;
						$tx_id = $res[$i]->itx_id;

						$tx_amt = $tmp_amt * $tx_percent / 100;

						$data2 = array(
							'iexteinpt_d_id' => $inid,
							'iexteinpt_p_id' => $prid,
							'iexteinpt_t_id' => $tx_id,
							'iexteinpt_t_name' => $tx_name,
							'iexteinpt_t_percent' => $tx_percent,
							'iexteinpt_t_amount' => $tx_amt
						);

						$this->db->insert("i_ext_et_invoice_product_taxes", $data2);
					}
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
					'iexteinpd_d_id' => $inid,
					'iexteinpd_product_id' => $prid,
					'iexteinpd_rate' => $tmp_rate,
					'iexteinpd_qty' => $tmp_qty,
					'iexteinpd_discount' => $tmp_disc,
					'iexteinpd_amount' => $tmp_amt,
					'iexteinpd_owner' => $oid);
				$this->db->insert('i_ext_et_invoice_product_details', $data);
			}

			$this->db->where('iexteint_txn_id', $inid);
			$this->db->delete('i_ext_et_invoice_tags');

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
				$this->db->insert('i_ext_et_invoice_tags', $data4);
			}

			echo $inid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_invoice($prid) {
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

########## MAINTAINANCE CONTRACTS ################
	public function amc($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' ORDER BY a.iextamc_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "AMC";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_add($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/amc/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

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

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
			$result = $query->result();
			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "AMC Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_get_price() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
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

	public function save_amc($mod_id) {
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

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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

	public function amc_print($mod_id, $amc_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$u_owner = $sess_data['user_details'][0]->i_owner;


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

	public function amc_edit($mod_id, $inid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['skip_edit'])) {
			$this->session->unset_userdata('skip_edit');
			redirect(base_url().'Enterprise/amc/'.$mod_id);	
		} else if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
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
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function amc_delete_product() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$txnid = $this->input->post('txnid');
			$docid = $this->input->post('docid');

			$data = array('iextamcpd_owner' => $oid , 'iextamcpd_d_id' => $docid, 'iextamcpd_id' => $txnid );
			$this->db->where($data);
			$this->db->delete('i_ext_et_amc_product_details');
		}
	}

	public function update_amc($mod_id, $inid) {
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

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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

	public function delete_amc($prid) {
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

########## LETTER ################
	public function letter($mod_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_et_amc AS a LEFT JOIN i_customers AS b ON a.iextamc_customer_id=b.ic_id WHERE a.iextamc_owner = '$oid' ORDER BY a.iextamc_id DESC");
			$result = $query->result();

			$data['invoice'] = $result;

			$data['mod_id'] = $mod_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "AMC";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc', $data);
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

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
			$result = $query->result();
			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "AMC Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('enterprise/amc_add', $data);
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

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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

			$data["mod_id"] = $mod_id;
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='Customers'");
			$result = $query->result();
			$data['customer'] = $result;

			$query = $this->db->query("SELECT ip_product FROM i_product WHERE ip_section='Products' OR ip_section='Services' AND ip_owner='$oid'");	
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

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_section='Customers' AND ic_name='$customer' AND ic_owner='$oid'");
			$ctype = 'Customers';
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
}