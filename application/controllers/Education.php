<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education extends CI_Controller {

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
			$ert['title'] = "Home";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			// $this->load->view('customers/customer', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

########## GENERAL PROPERTIES ################
	public function general_properties($section) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = $section." General Properties";
			$ert['search'] = "false";

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$section'");
			$result = $query->result();

			$data['property'] = $result;
			$data['thing'] = $section;
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/general_properties', $data);
		}
	}

	public function save_property($section) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$data = array('ip_property' => $this->input->post('property'), 'ip_owner' => $oid, 'ip_section' => $section);	

			$this->db->insert('i_property', $data);
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$section'");
			$result = $query->result();

			print_r(json_encode($result));
		}
	}

	public function remove_property($section) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$pid = $this->input->post('pid');

			$this->db->where('ip_id', $pid);
			$this->db->delete('i_property');

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$section'");
			$result = $query->result();

			print_r(json_encode($result));
		}	
	}

########## STUDENTS ################
	public function students() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_section = 'Students' AND a.ic_owner='$oid'");
			$result = $query->result();

			$data['customer'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Students";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/student', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function student_search() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$search = $this->input->post('search');
			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_section = 'Students' AND a.ic_name LIKE '%".$search."%' AND a.ic_owner='$oid'");
			$result = $query->result();

			$data['customer'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function student_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$data['thing'] = 'Student';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Students";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/student_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_student() {
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
				'ic_section' => 'Students',
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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Students');	

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

	public function student_edit($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
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

			$data['thing'] = 'Student';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Students";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/student_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_student($c_id) {
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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Students');	

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

	public function delete_student($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$this->db->where('ic_id', $c_id);
			$this->db->delete('i_customers');
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			redirect(base_url().'education/students');

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

########## FEES ################
	public function fees()	{
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_section='Students'");
			$result = $query->result();

			$data['customer'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Fees";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('education/fee', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function fee_search()	{
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$search = $this->input->post('search');

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_section='Students' AND ic_name LIKE '%".$search."%'");
			$result = $query->result();

			$data['customer'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function fee_details($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers AS a LEFT JOIN i_ext_ed_batch_allot AS b ON a.ic_id=b.iextba_customer_id LEFT JOIN i_ext_ed_batch AS c ON b.iextba_batch_id=c.iextb_id LEFT JOIN i_product AS d ON c.iextb_course=d.ip_id WHERE a.ic_id = '$cid' AND a.ic_owner='$oid' AND a.ic_section='Students'");
			$result = $query->result();

			$data['customer'] = $result;
			$courseid = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id = '$courseid' ORDER BY ipp_id DESC");
			$result = $query->result();
			$data['course_price'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid'");
			$result = $query->result();

			$data['fees'] = $result;

			$data['c_id'] = $cid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Fees";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/fee_details', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_fee_details($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextf_customer_id' => $cid,
				'iextf_paid_fee' => $this->input->post('amt'),
				'iextf_paid_date' => $this->input->post('dt'),
				'iextf_medium' => $this->input->post('medium'),
				'iextf_details' => $this->input->post('detail'),
				'iextf_status' => "Unpaid",
				'iextf_owner' => $oid,
				'iextf_created' => $dt,
				'iextf_created_by' => $oid
				);


			$this->db->insert('i_ext_ed_fees', $data);

			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid'");
			$result = $query->result();

			$data1 = array();
			for ($i=0; $i < count($result) ; $i++) { 
				$tmp = array(
					'id' => $result[$i]->iextf_id ,
					'c_id' => $cid,
					'date' => $result[$i]->iextf_paid_date,
					'amount' => $result[$i]->iextf_paid_fee,
					'medium' => $result[$i]->iextf_medium,
					'detail' => $result[$i]->iextf_details,
					'status' => $result[$i]->iextf_status);

				array_push($data1, $tmp);
			}

			echo json_encode($data1);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function reconcile_fee_details($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$total = $this->input->post('total');
			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iextf_total_fee' => $total);

			$this->db->where('iextf_customer_id', $cid);
			$this->db->update('i_ext_ed_fees', $data);
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid' AND iextf_owner='$oid'");
			$result = $query->result();

			if (count($result) <= 0) {
				$data = array(
				'iextf_customer_id' => $cid,
				'iextf_total_fee' => $total,
				'iextf_paid_fee' => 0,
				'iextf_paid_date' => $dt,
				'iextf_medium' => '',
				'iextf_details' => '',
				'iextf_status' => "Unpaid",
				'iextf_owner' => $oid,
				'iextf_created' => $dt,
				'iextf_created_by' => $oid
				);
				$this->db->insert('i_ext_ed_fees', $data);
				
				$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid' AND iextf_owner='$oid'");
				$result = $query->result();			
			}

			for ($i=0; $i < count($result) ; $i++) { 
				$txnid = $result[$i]->iextf_id;
				if ($i==0) {
					$balance = $result[$i]->iextf_total_fee;
					$amount = $result[$i]->iextf_paid_fee;
				} else {
					$balance = $result[$i - 1]->iextf_balance_fee;
					$amount = $result[$i]->iextf_paid_fee;
				}

				$new_balance = $balance - $amount;

				$data1 = array(
					'iextf_balance_fee' => $new_balance,
					'iextf_paid_fee' => $amount);

				$this->db->where('iextf_id', $txnid);
				$this->db->update('i_ext_ed_fees', $data1);
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_fee_status($txid, $cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$data1 = array('iextf_status' => 'Paid');
			$this->db->where('iextf_id', $txid);
			$this->db->update('i_ext_ed_fees', $data1);

			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid'");
			$result = $query->result();

			$data = array();
			for ($i=0; $i < count($result) ; $i++) { 
				$tmp = array(
					'id' => $result[$i]->iextf_id ,
					'c_id' => $cid,
					'date' => $result[$i]->iextf_paid_date,
					'amount' => $result[$i]->iextf_paid_fee,
					'medium' => $result[$i]->iextf_medium,
					'detail' => $result[$i]->iextf_details,
					'status' => $result[$i]->iextf_status);

				array_push($data, $tmp);
			}

			echo json_encode($data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_fee_txn($txid, $cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$this->db->where('iextf_id', $txid);
			$this->db->delete('i_ext_ed_fees');

			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id = '$cid'");
			$result = $query->result();

			$data = array();
			for ($i=0; $i < count($result) ; $i++) { 
				$tmp = array(
					'id' => $result[$i]->iextf_id ,
					'c_id' => $cid,
					'date' => $result[$i]->iextf_paid_date,
					'amount' => $result[$i]->iextf_paid_fee,
					'medium' => $result[$i]->iextf_medium,
					'detail' => $result[$i]->iextf_details,
					'status' => $result[$i]->iextf_status);

				array_push($data, $tmp);
			}

			echo json_encode($data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function generate_fee_reciept($cid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('d-m-Y');

			$dt1 = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;

			$query = $this->db->query("SELECT * FROM i_ext_ed_receipt WHERE iextr_c_id = '$cid' AND iextr_owner='$oid'");
			$result = $query->result();

			if(count($result) > 0) {
				$rid = $result[0]->iextr_id;
			} else {
				$data1 = array(
					'iextr_c_id' => $cid,
					'iextr_owner' => $oid,
					'iextr_created' => $dt1,
					'iextr_created_by' => $oid );

				$this->db->insert('i_ext_ed_receipt', $data1);
				$rid = $this->db->insert_id();
			}

			$data['s_receipt'] = $rid;
			$data['s_title'] = 'Fee Recipt';
			$data['s_date'] = $dt;

			$query = $this->db->query("SELECT ic_name, icbd_value, ip_property, ip_product, f.ip_id FROM i_customers AS a LEFT JOIN i_c_basic_details AS b ON a.ic_id=b.icbd_customer_id LEFT JOIN i_property AS c ON b.icbd_property=c.ip_id LEFT JOIN i_ext_ed_batch_allot AS d ON a.ic_id=d.iextba_customer_id LEFT JOIN i_ext_ed_batch AS e ON d.iextba_batch_id=e.iextb_id LEFT JOIN i_product AS f ON e.iextb_course=f.ip_id WHERE a.ic_id='$cid' AND ic_owner='$oid' AND c.ip_property LIKE '%Address%'");
			$result = $query->result();

			$courseid = 0;
			if(count($result) <= 0) {
				$query = $this->db->query("SELECT ic_name, ip_product, f.ip_id FROM i_customers AS a LEFT JOIN i_ext_ed_batch_allot AS d ON a.ic_id=d.iextba_customer_id LEFT JOIN i_ext_ed_batch AS e ON d.iextba_batch_id=e.iextb_id LEFT JOIN i_product AS f ON e.iextb_course=f.ip_id WHERE a.ic_id='$cid' and a.ic_owner = '$oid'");
				$result = $query->result();

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_course'] = $result[0]->ip_product;
				$courseid = $result[0]->ip_id;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_course'] = $result[0]->ip_product;
				$courseid = $result[0]->ip_id;
			}

			$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id='$cid' AND iextf_owner='$oid'");
			$result = $query->result();

			if (count($result) > 0) {
				$data['s_fees'] = $result[0]->iextf_total_fee;
				$data['fee_details'] = $result;
			} else {
				$query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$courseid'");
				$result = $query->result();

				if (count($result) > 0) {
					$data['s_fees'] = $result[0]->ipp_sell_price;
				} else {
					$data['s_fees'] = 'N/A';
				}
				
			}
			// print_r($data);
			$this->load->view('education/fee_recipt', $data);

		} else {
			redirect(base_url().'Account/login');
		}
	}
	
########## BATCH & ALLOTMENT ################
	public function batch() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;	

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid'");
			$result = $query->result();

			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid' AND ip_section='Courses'");
			$result = $query->result();

			$data['course'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Batch";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('education/batch', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_batch() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextb_batch_name' => $this->input->post('batch'),
				'iextb_year' => $this->input->post('year'),
				'iextb_status' => $this->input->post('active'),
				'iextb_course' => $this->input->post('course'),
				'iextb_owner' => $oid,
				'iextb_created' => $dt,
				'iextb_created_by' => $oid
				);

			$this->db->insert('i_ext_ed_batch', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function edit_batch($bid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_id = '$bid' AND iextb_owner='$oid'");
			$result = $query->result();

			$data['edit_batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid'");
			$result = $query->result();

			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid' AND ip_section='Courses'");
			$result = $query->result();

			$data['course'] = $result;

			$data['bid'] = $bid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Batch";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/batch', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_batch($bid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextb_batch_name' => $this->input->post('batch'),
				'iextb_year' => $this->input->post('year'),
				'iextb_course' => $this->input->post('course'),
				'iextb_status' => $this->input->post('active'),
				'iextb_modifed' => $dt,
				'iextb_modified_by' => $oid
				);
			$this->db->where('iextb_id', $bid);
			$this->db->update('i_ext_ed_batch', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function batch_allot() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_section='Students'");
			$result = $query->result();

			$data_s = array();

			for ($i=0; $i < count($result) ; $i++) { 
				$icid = $result[$i]->ic_id;
				
				$query1 = $this->db->query("SELECT * FROM i_ext_ed_batch_allot WHERE iextba_customer_id ='$icid'");
				$result1 = $query1->result();
				if (count($result1) <= 0) {
					array_push($data_s, $result[$i]);
				}			
			}
			
			$data['customer'] = $data_s;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_status='true' AND iextb_owner='$oid'");
			$result = $query->result();

			$data['batch'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Batch Allot";
			$ert['search'] = "true";
			$ert['tabs'] = '<div class="mdl-layout__tab-bar mdl-js-ripple-effect"><a href="#scroll-tab-1" class="mdl-layout__tab is-active">Allot</a><a href="#scroll-tab-2" class="mdl-layout__tab">Un-Allot</a></div>';

			$this->load->view('navbar', $ert);
			$this->load->view('education/batch_allot', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function show_alloted_batch() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$bid = $this->input->post('bid');
			$sess_data = $this->session->userdata();

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch_allot as a LEFT join i_customers as b on a.iextba_customer_id=b.ic_id WHERE a.iextba_batch_id='$bid' AND b.ic_owner='$oid' AND b.ic_section='Students'");
			$result = $query->result();

			echo json_encode($result);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function remove_alloted_batch() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$bid = $this->input->post('bid');
			$sid = $this->input->post('sid');

			$data = array('iextba_customer_id' => $sid , 'iextba_batch_id' => $bid);
			$this->db->where($data);
			$this->db->delete('i_ext_ed_batch_allot');
			

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch_allot as a LEFT join i_customers as b on a.iextba_customer_id=b.ic_id WHERE a.iextba_batch_id='$bid'");
			$result = $query->result();

			echo json_encode($result);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_alloted_batch() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$students = $this->input->post('student');
			$batch =  $this->input->post('batch');

			for ($i=0; $i < count($students) ; $i++) { 
				for ($k=0; $k < count($batch) ; $k++) { 

					$b_name = $batch[$k];
					$query = $this->db->query("SELECT * FROM i_ext_ed_batch AS a WHERE a.iextb_batch_name='$b_name' AND a.iextb_owner='$oid'");
					$result = $query->result();

					$b_id = $result[0]->iextb_id;
					$b_course = $result[0]->iextb_course;
					$sid = $students[$i];

					$data = array(
						'iextba_batch_id' => $b_id,
						'iextba_customer_id' => $sid,
						'iextba_created' => $dt,
						'iextba_created_by' => $oid
						);
					$this->db->insert('i_ext_ed_batch_allot', $data);


					$query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id = '$b_course' ORDER BY ipp_id DESC");
					$result = $query->result();
					$total = 0;
					if(count($result) > 0) {
						$total = $result[0]->ipp_sell_price;
					}
					
					$query = $this->db->query("SELECT * FROM i_ext_ed_fees WHERE iextf_customer_id='$sid' AND iextf_owner='$oid'");
					$result = $query->result();

					if(count($result) <= 0) {
						$data = array(
						'iextf_customer_id' => $sid,
						'iextf_total_fee' => $total,
						'iextf_paid_fee' => 0,
						'iextf_paid_date' => $dt,
						'iextf_medium' => '',
						'iextf_details' => '',
						'iextf_status' => "Unpaid",
						'iextf_owner' => $oid,
						'iextf_created' => $dt,
						'iextf_created_by' => $oid
						);
						$this->db->insert('i_ext_ed_fees', $data);
					}
				}
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

########## SUBJECTS & CHAPTERS ################
	public function subjects() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Subjects";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/subject', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function subject_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Subjects";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/subject_add');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function subject_save() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexts_name' => $this->input->post('name'),
				'iexts_owner' => $oid,
				'iexts_created' => $dt,
				'iexts_created_by' => $oid
				);

			$this->db->insert('i_ext_ed_subjects', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function subject_edit($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_id = '$sid' AND iexts_owner='$oid'");
			$result = $query->result();

			$data['edit_subject'] = $result;

			$data['sid'] = $sid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Subjects";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/subject_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function subject_update($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexts_name' => $this->input->post('name'));

			$this->db->where('iexts_id', $sid);
			$this->db->update('i_ext_ed_subjects', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function subject_delete($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

		
			$this->db->where('iexts_id', $sid);
			$this->db->delete('i_ext_ed_subjects');

			redirect(base_url().'education/subjects');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function chapters() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid'");
			$result = $query->result();

			$data['chapter'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Chapters";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/chapter', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function select_subject_chapter($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			if ($sid=="all") {
				$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid'");
			} else {
				$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_subject='$sid' AND iextc_owner='$oid'");
			}

			
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'account/login');	
		}
	}

	public function chapter_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query('SELECT * FROM i_ext_ed_subjects WHERE iexts_owner="$oid"');
			$result = $query->result();

			$data['subject'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Chapter";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/chapter_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function chapter_save() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextc_name' => $this->input->post('chapter'),
				'iextc_subject' => $this->input->post('subject'),
				'iextc_min_hours' => $this->input->post('min'),
				'iextc_max_hours' => $this->input->post('max'),
				'iextc_owner' => $oid,
				'iextc_created' => $dt,
				'iextc_created_by' => $oid
				);

			$this->db->insert('i_ext_ed_chapters', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function chapter_edit($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query('SELECT * FROM i_ext_ed_subjects AND iexts_owner="$oid"');
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_id = '$sid' AND iextc_owner='$oid'");
			$result = $query->result();

			$data['edit_chapter'] = $result;

			$data['sid'] = $sid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Chapter";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/chapter_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function chapter_update($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextc_name' => $this->input->post('chapter'),
				'iextc_subject' => $this->input->post('subject'),
				'iextc_min_hours' => $this->input->post('min'),
				'iextc_max_hours' => $this->input->post('max'),
				);
			$this->db->where('iextc_id', $sid);
			$this->db->update('i_ext_ed_chapters', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function chapter_delete($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

		
			$this->db->where('iextc_id', $sid);
			$this->db->delete('i_ext_ed_chapters');

			redirect(base_url().'education/chapters');
		} else {
			redirect(base_url().'account/login');
		}
	}
	
########## TEACHERS ################

	public function teachers() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_teachers AS a LEFT JOIN i_customers AS b ON a.iextt_t_id=b.ic_id WHERE a.iextt_owner='$oid' AND b.ic_section='Teachers'");
			$result = $query->result();

			$data['teacher'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Teachers";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/teacher', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function select_subject_teacher($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			if ($sid=="all") {
				$query = $this->db->query("SELECT ic_id, ic_name FROM i_ext_ed_teachers AS a LEFT JOIN i_customers AS b ON a.iextt_t_id=b.ic_id WHERE b.ic_section='Teachers' AND b.ic_owner='$oid'");
			} else {
				$query = $this->db->query("SELECT ic_id, ic_name FROM i_ext_ed_teachers AS a LEFT JOIN i_ext_ed_teacher_subjects AS b ON a.iextt_t_id=b.iextts_t_id LEFT JOIN i_customers AS c ON a.iextt_t_id=c.ic_id WHERE b.iextts_s_id='$sid' AND c.ic_section='Teachers' AND c.ic_owner='$oid'");
			}
			
			$result = $query->result();

			print_r(json_encode($result));
		} else {
			redirect(base_url().'account/login');	
		}
	}

	public function teacher_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Teachers'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Teacher";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/teacher_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function teacher_save() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$subject = $this->input->post('subject');

			$data = array(
				'ic_name' => $this->input->post('teacher'),
				'ic_section' => 'Teachers',
				'ic_owner' => $oid,
				'ic_created' => $dt,
				'ic_created_by' => $oid );

			$this->db->insert('i_customers', $data);
			$tid = $this->db->insert_id();

			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			
			for ($i=0; $i < count($c_value) ; $i++) { 
				$tmp_prp = $c_value[$i]['v'];
				$tmp_val = $c_value[$i]['p'];

				$data2 = array(
					'icbd_customer_id' => $tid,
					'icbd_property' => $tmp_prp,
					'icbd_value' => $tmp_val);

				$this->db->insert('i_c_basic_details', $data2);		
			}

			
			$pp = $c_property[0]['n_p'];
			$n_pp = array();
			for ($i=0; $i < count($pp) ; $i++) { 
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Teachers');	

				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}


			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 

				$data = array('icbd_customer_id'=> $tid, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
				$this->db->insert('i_c_basic_details', $data);
				
			}

			$data = array(
				'iextt_t_id' => $tid,
				'iextt_salary_type' => $this->input->post('salary'),
				'iextt_amount' => $this->input->post('amount'),
				'iextt_owner' => $oid,
				'iextt_created' => $dt,
				'iextt_created_by' => $oid
				);
			$this->db->insert('i_ext_ed_teachers', $data);
			
			for ($i=0; $i < count($subject) ; $i++) { 

				$tmp_sub = $subject[$i];

				$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_name = '$tmp_sub' AND iexts_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'iexts_name' => $tmp_sub,
						'iexts_owner' => $oid,
						'iexts_created' => $dt,
						'iexts_created_by' => $oid);

					$this->db->insert('i_ext_ed_subjects', $data3);
					$sid = $this->db->insert_id();
				} else {
					$sid = $result[0]->iexts_id;
				}

				$data1 = array(
					'iextts_t_id' => $tid ,
					'iextts_s_id' => $sid );
				$this->db->insert('i_ext_ed_teacher_subjects', $data1);
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function teacher_edit($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query('SELECT * FROM i_ext_ed_subjects WHERE iexts_owner="$oid"');
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_teachers AS a LEFT JOIN i_customers AS b ON a.iextt_t_id=b.ic_id WHERE b.ic_id = '$sid' AND b.ic_section='Teachers' AND b.ic_owner='$oid'");
			$result = $query->result();

			$data['edit_teacher'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_teacher_subjects WHERE iextts_t_id = '$sid'");
			$result = $query->result();

			$data['edit_teacher_subjects'] = $result;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Teachers'");
			$result = $query->result();

			$data['property'] = $result;

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id='$sid'");
			$result1 = $query1->result();

			$data['edit_basic_details'] = $result1;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$data['sid'] = $sid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Teacher";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/teacher_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function teacher_update($tid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array('ic_name' => $this->input->post('teacher'));
			$this->db->where('ic_id', $tid);
			$this->db->update('i_customers', $data);
			
			$this->db->where('icbd_customer_id', $tid);
			$this->db->delete('i_c_basic_details');

			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			
			for ($i=0; $i < count($c_value) ; $i++) { 
				$tmp_prp = $c_value[$i]['v'];
				$tmp_val = $c_value[$i]['p'];

				$data2 = array(
					'icbd_customer_id' => $tid,
					'icbd_property' => $tmp_prp,
					'icbd_value' => $tmp_val);

				$this->db->insert('i_c_basic_details', $data2);		
			}

			$pp = $c_property[0]['n_p'];

			$n_pp = array();
			for ($i=0; $i < count($pp) ; $i++) { 
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Teachers');	

				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}

			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 

				$data = array('icbd_customer_id'=> $tid, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
				$this->db->insert('i_c_basic_details', $data);
				
			}

			$data = array(
				'iextt_salary_type' => $this->input->post('salary'),
				'iextt_amount' => $this->input->post('amount'),
				);
			$this->db->where('iextt_t_id', $tid);
			$this->db->update('i_ext_ed_teachers', $data);

			$subject = $this->input->post('subject');

			$this->db->where('iextts_t_id', $tid);
			$this->db->delete('i_ext_ed_teacher_subjects');

			for ($i=0; $i < count($subject) ; $i++) { 

				$tmp_sub = $subject[$i];

				$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_name = '$tmp_sub' AND iexts_owner = '$oid'");
				$result = $query->result();

				if(count($result) <= 0) {
					$data3 = array(
						'iexts_name' => $tmp_sub,
						'iexts_owner' => $oid,
						'iexts_created' => $dt,
						'iexts_created_by' => $oid);

					$this->db->insert('i_ext_ed_subjects', $data3);
					$sid = $this->db->insert_id();
				} else {
					$sid = $result[0]->iexts_id;
				}
				echo $sid;

				$data1 = array(
					'iextts_t_id' => $tid ,
					'iextts_s_id' => $sid );
				$this->db->insert('i_ext_ed_teacher_subjects', $data1);
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function teacher_delete($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$this->db->where('ic_id', $sid);
			$this->db->delete('i_customers');

			$this->db->where('iextt_t_id', $sid);
			$this->db->delete('i_ext_ed_teachers');

			$this->db->where('iextts_t_id', $sid);
			$this->db->delete('i_ext_ed_teacher_subjects');

			redirect(base_url().'education/teachers');
		} else {
			redirect(base_url().'account/login');
		}
	}
	
########## TIPS ################
	public function tips() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_tips WHERE iexttp_owner = '$oid'");
			$result = $query->result();

			$data['tips'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Tips";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/tips', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function tip_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Tip";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/tip_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_tip() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$c_name = $this->input->post('name');
			$c_tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iexttp_tip' => $c_name,
				'iexttp_owner' => $oid,
				'iexttp_created' => $dt,
				'iexttp_created_by' => $oid );

			$this->db->insert('i_ext_ed_tips', $data);
			$tpid = $this->db->insert_id();

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
					'iexttt_tip_id' => $tpid,
					'iexttt_tag_id' => $tid);

				$this->db->insert('i_ext_ed_tip_tags', $data4);
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function edit_tip($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_tips WHERE iexttp_id='$c_id'");
			$result = $query->result();

			$data['edit_tip'] = $result;

			$query2 = $this->db->query("SELECT * FROM i_ext_ed_tip_tags WHERE iexttt_tip_id='$c_id'");
			$result2 = $query2->result();

			$data['edit_tag_tips'] = $result2;

			$data['tid'] = $c_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Tip";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/tip_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_tip($tpid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			

			$c_name = $this->input->post('name');
			$c_tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array('iexttp_tip' => $c_name);

			$this->db->where('iexttp_id', $tpid);
			$this->db->update('i_ext_ed_tips', $data);
			
			$this->db->where('iexttt_tip_id', $tpid);
			$this->db->delete('i_ext_ed_tip_tags');
		
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
					'iexttt_tip_id' => $tpid,
					'iexttt_tag_id' => $tid);
				$this->db->insert('i_ext_ed_tip_tags', $data4);
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function tip_delete($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$this->db->where('iexttp_id', $sid);
			$this->db->delete('i_ext_ed_tips');

			$this->db->where('iexttt_tip_id', $sid);
			$this->db->delete('i_ext_ed_tip_tags');

			redirect(base_url().'education/tips');
		} else {
			redirect(base_url().'account/login');
		}
	}

########## LECTURE SCHEDULE ################
	public function lecture_schedule() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Lecture Schedule";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/lecture', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function lecture_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid' AND iextb_status='true'");
			$result = $query->result();

			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_teachers AS a LEFT JOIN i_customers AS b ON a.iextt_t_id=b.ic_id WHERE a.iextt_owner='$oid' AND b.ic_section='Teachers'");
			$result = $query->result();

			$data['teacher'] = $result;

			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Lecture";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/lecture_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_chapters($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid' AND iextc_subject='$sid'");
			$result = $query->result();

			print_r(json_encode($result));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_lectures($dt) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_ext_ed_lecture_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextls_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextls_chapter_id=c.iextc_id LEFT JOIN i_customers as d ON a.iextls_teacher_id=d.ic_id  WHERE a.iextls_owner='$oid' AND d.ic_section='Teachers' AND DATE(a.iextls_from_date) = '$dt'");
			$result = $query->result();

			print_r(json_encode($result));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_lecture() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iextls_batch_id' => $this->input->post('batch'),
				'iextls_subject_id' => $this->input->post('subject'),
				'iextls_chapter_id' => $this->input->post('chapter'),
				'iextls_teacher_id' => $this->input->post('teacher'),
				'iextls_from_date' => $this->input->post('from_date'),
				'iextls_to_date' => $this->input->post('to_date'),
				'iextls_notes' => $this->input->post('notes'),
				'iextls_owner' => $oid,
				'iextls_created' => $dt,
				'iextls_created_by' => $oid );

			$this->db->insert('i_ext_ed_lecture_schedule', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function edit_lecture($l_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid' AND iextb_status='true'");
			$result = $query->result();

			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_section='Teachers'");
			$result = $query->result();

			$data['teacher'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_lecture_schedule WHERE iextls_owner='$oid' AND iextls_id='$l_id'");
			$result = $query->result();

			$data['edit_lecture'] = $result;

			$sid = $result[0]->iextls_subject_id;

			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid' AND iextc_subject='$sid'");
			$result = $query->result();

			$data['chapter'] = $result;


			$data['lid'] = $l_id;



			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Lecture";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/lecture_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_lecture($l_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iextls_batch_id' => $this->input->post('batch'),
				'iextls_subject_id' => $this->input->post('subject'),
				'iextls_chapter_id' => $this->input->post('chapter'),
				'iextls_teacher_id' => $this->input->post('teacher'),
				'iextls_from_date' => $this->input->post('from_date'),
				'iextls_to_date' => $this->input->post('to_date'),
				'iextls_notes' => $this->input->post('notes'),
				'iextls_owner' => $oid,
				'iextls_modified' => $dt,
				'iextls_modified_by' => $oid );

			$this->db->where('iextls_id', $l_id);
			$this->db->update('i_ext_ed_lecture_schedule', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_lecture($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$this->db->where('iextls_id', $sid);
			$this->db->delete('i_ext_ed_lecture_schedule');

			redirect(base_url().'education/lecture_schedule');
		} else {
			redirect(base_url().'account/login');
		}
	}

########## EXAM SCHEDULE ################
	public function exam_schedule() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Exam Schedule";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/exam', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function exam_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid' AND iextb_status='true'");
			$result = $query->result();

			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();

			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_teachers WHERE iextt_owner='$oid'");
			$result = $query->result();

			$data['teacher'] = $result;

			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Exam";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/exam_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_exam_preliem($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_ext_ed_preliem WHERE iextp_owner='$oid' AND iextp_subject_id='$sid'");
			$result = $query->result();

			print_r(json_encode($result));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_exam_chapters($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid' AND iextc_subject='$sid'");
			$result = $query->result();

			print_r(json_encode($result));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_exams($dt) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
		
			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id  WHERE a.iextes_owner='$oid' AND DATE(a.iextes_from_date) = '$dt'");
			$result = $query->result();
			
			print_r(json_encode($result));

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_exam() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$typ = $this->input->post('type');
			$pre = $this->input->post('preliem');

			if ($typ=="preliem") {
				$que = $this->db->query("SELECT * FROM i_ext_ed_preliem WHERE iextp_owner = '$oid' AND iextp_preliem_name='$pre'");
				$res = $que->result();

				if (count($res) <= 0) {
					$data1 = array(
						'iextp_subject_id' => $this->input->post('subject') ,
						'iextp_preliem_name' => $pre,
						'iextp_owner' => $oid,
						'iextp_created' => $dt,
						'iextp_created_by' => $oid);
					$this->db->insert('i_ext_ed_preliem', $data1);
					$pre = $this->db->insert_id();
				}
			}

			$data = array(
				'iextes_batch_id' => $this->input->post('batch'),
				'iextes_subject_id' => $this->input->post('subject'),
				'iextes_type' => $typ,
				'iextes_chapter_id' => $this->input->post('chapter'),
				'iextes_preliem_id' => $pre,
				'iextes_from_date' => $this->input->post('from_date'),
				'iextes_to_date' => $this->input->post('to_date'),
				'iextes_notes' => $this->input->post('notes'),
				'iextes_owner' => $oid,
				'iextes_created' => $dt,
				'iextes_created_by' => $oid );

			$this->db->insert('i_ext_ed_exam_schedule', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function edit_exam($e_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_owner='$oid' AND iextb_status='true'");
			$result = $query->result();
			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();
			$data['subject'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule WHERE iextes_owner='$oid' AND iextes_id='$e_id'");
			$result = $query->result();
			$data['edit_exam'] = $result;

			$sid = $result[0]->iextes_subject_id;

			$b = date($result[0]->iextes_from_date);
			$c = strtotime($b);
			$fdt = date('Y-m-d', $c);

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id  WHERE a.iextes_owner='$oid' AND DATE(a.iextes_from_date) = '$fdt'");
			$result = $query->result();

			$data['current'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_chapters WHERE iextc_owner='$oid' AND iextc_subject='$sid'");
			$result = $query->result();
			$data['chapter'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_preliem WHERE iextp_owner='$oid' AND iextp_subject_id='$sid'");
			$result = $query->result();
			$data['preliem'] = $result;

			$data['eid'] = $e_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Exam";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/exam_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_exam($e_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$typ = $this->input->post('type');
			$pre = $this->input->post('preliem');

			if ($typ=="preliem") {
				$que = $this->db->query("SELECT * FROM i_ext_ed_preliem WHERE iextp_owner = '$oid' AND iextp_id='$pre'");
				$res = $que->result();

				if (count($res) <= 0) {
					$data1 = array(
						'iextp_subject_id' => $this->input->post('subject') ,
						'iextp_preliem_name' => $pre,
						'iextp_owner' => $oid,
						'iextp_created' => $dt,
						'iextp_created_by' => $oid);
					$this->db->insert('i_ext_ed_preliem', $data1);
					$pre = $this->db->insert_id();
				}
			}

			$data = array(
				'iextes_batch_id' => $this->input->post('batch'),
				'iextes_subject_id' => $this->input->post('subject'),
				'iextes_type' => $typ,
				'iextes_chapter_id' => $this->input->post('chapter'),
				'iextes_preliem_id' => $pre,
				'iextes_from_date' => $this->input->post('from_date'),
				'iextes_to_date' => $this->input->post('to_date'),
				'iextes_notes' => $this->input->post('notes'),
				'iextes_modified' => $dt,
				'iextes_modified_by' => $oid );

			$this->db->where('iextes_id', $e_id);
			$this->db->update('i_ext_ed_exam_schedule', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_exam($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$this->db->where('iextes_id', $sid);
			$this->db->delete('i_ext_ed_exam_schedule');

			redirect(base_url().'education/exam_schedule');
		} else {
			redirect(base_url().'account/login');
		}
	}

########## STUDENT ATTENDANCE ################
	public function attendance() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$data['oid'] = $oid;

			$dt = date('Y-m-d');

			$pending = 0;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule WHERE iextes_att_status = 'false' AND iextes_owner='$oid'");
			$result = $query->result();
			$pending = count($result);

			$query = $this->db->query("SELECT * FROM i_ext_ed_lecture_schedule WHERE iextls_att_status = 'false' AND iextls_owner='$oid'");
			$result = $query->result();
			$pending = count($result);

			$data['pending'] = $pending;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Attendance";
			$ert['search'] = "false";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/attendance', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_attendance() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$event = $this->input->post('event');
			$event_id = $this->input->post('event_id');
			$att = $this->input->post('attendance');
			$hmw = $this->input->post('homework');
			$pun = $this->input->post('punishment');
			$dty = $this->input->post('date');
			$dt = date('Y-m-d H:i:s');

			if($event=="lecture") {
				$data = array('iextls_att_status' => 'true');

				$this->db->where(array('iextls_owner' => $oid ,'iextls_id' => $event_id));
				$this->db->update('i_ext_ed_lecture_schedule', $data);
			} else if($event == "exam") {
				$data = array('iextes_att_status' => 'true');

				$this->db->where(array('iextes_owner' => $oid ,'iextes_id' => $event_id));
				$this->db->update('i_ext_ed_exam_schedule', $data);
			}

			$this->db->where(array('ieea_owner' => $oid , 'ieea_date' => $dty, 'ieea_event' => $event, 'ieea_event_id' => $event_id));
			$this->db->delete('i_ext_ed_attendance');

			for ($i=0; $i < count($att) ; $i++) { 
				$data = array(
					'ieea_event' => $event,
					'ieea_event_id' => $event_id,
					'ieea_customer_id' => $att[$i]['i'],
					'ieea_status' => $att[$i]['a'],
					'ieea_date' => $dty,
					'ieea_owner' => $oid,
					'ieea_created' => $oid,
					'ieea_created_by' => $dt );
				$this->db->insert('i_ext_ed_attendance', $data);
			}

			$this->db->where(array('ieeh_owner' => $oid , 'ieeh_date' => $dty, 'ieeh_event' => $event, 'ieeh_event_id' => $event_id));
			$this->db->delete('i_ext_ed_homework');

			for ($i=0; $i < count($hmw) ; $i++) { 
				$data = array(
					'ieeh_event' => $event,
					'ieeh_event_id' => $event_id,
					'ieeh_customer_id' => $hmw[$i]['i'],
					'ieeh_status' => $hmw[$i]['h'],
					'ieeh_date' => $dty,
					'ieeh_owner' => $oid,
					'ieeh_created' => $oid,
					'ieeh_created_by' => $dt );
				$this->db->insert('i_ext_ed_homework', $data);
			}

			$this->db->where(array('ieep_owner' => $oid , 'ieep_date' => $dty, 'ieep_event' => $event, 'ieep_event_id' => $event_id));
			$this->db->delete('i_ext_ed_punishment');

			for ($i=0; $i < count($pun) ; $i++) { 
				$data = array(
					'ieep_event' => $event,
					'ieep_event_id' => $event_id,
					'ieep_customer_id' => $pun[$i]['i'],
					'ieep_status' => $pun[$i]['p'],
					'ieep_details' => $pun[$i]['p'],
					'ieep_date' => $dty,
					'ieep_owner' => $oid,
					'ieep_created' => $oid,
					'ieep_created_by' => $dt );
				$this->db->insert('i_ext_ed_punishment', $data);
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_events_attendance($date) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id LEFT JOIN i_ext_ed_batch as e ON a.iextes_batch_id=e.iextb_id WHERE a.iextes_owner='$oid' AND DATE(a.iextes_from_date) = '$date'");
			$result = $query->result();
			$data['exam'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_lecture_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextls_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextls_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_teachers as d ON a.iextls_teacher_id=d.iextt_id  LEFT JOIN i_ext_ed_batch as e ON a.iextls_batch_id=e.iextb_id  WHERE a.iextls_owner='$oid' AND DATE(a.iextls_from_date) = '$date'");
			$result = $query->result();
			$data['lecture'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_attendance($date, $event, $id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			if ($event == "lecture") {
				$query = $this->db->query("SELECT * FROM i_ext_ed_lecture_schedule WHERE iextls_id='$id' AND iextls_owner='$oid'");
				$result = $query->result();
				$batch = $result[0]->iextls_batch_id;
			} else if($event == "exam") {
				$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule WHERE iextes_id='$id' AND iextes_owner='$oid'");
				$result = $query->result();
				$batch = $result[0]->iextes_batch_id;
			}

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_ed_batch_allot as b ON a.ic_id=b.iextba_customer_id LEFT JOIN i_c_pic as c ON a.ic_id=c.icp_c_id WHERE b.iextba_batch_id = '$batch' AND a.ic_owner='$oid' AND a.ic_section='Students'");
			$result = $query->result();

			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance WHERE ieea_event='$event' AND ieea_event_id = '$id' AND ieea_owner='$oid' AND ieea_date='$date'");
			$result = $query->result();

			$data['attendance'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_homework WHERE ieeh_event='$event' AND ieeh_event_id='$id' AND ieeh_owner='$oid' AND ieeh_date='$date'");
			$result = $query->result();

			$data['homework'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_punishment WHERE ieep_event='$event' AND ieep_event_id='$id' AND ieep_owner='$oid' AND ieep_date='$date'");
			$result = $query->result();

			$data['punishment'] = $result;

			$data['oid'] = $oid;

			echo json_encode($data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_monthly_attendance($sid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id ='$sid' AND ic_owner='$oid' AND ic_section='Students'");
			$result = $query->result();
			$data['customer'] = $result;

			$student = $result[0]->ic_name;
			$m = date('m');

			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance WHERE ieea_customer_id ='$sid' AND ieea_owner='$oid' AND MONTH(ieea_date) = '$m'");
			$result = $query->result();
			$data['attendance'] = $result;

			$present = 0;
			$absent = 0;
			for ($i=0; $i < count($result) ; $i++) { 
				if($result[$i]->ieea_status == "true") {
					$present++;
				} else if($result[$i]->ieea_status=="false") {
					$absent++;
				}
			}

			$data['present'] = $present;
			$data['absent'] = $absent;

			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance as a LEFT JOIN i_ext_ed_lecture_schedule as b ON a.ieea_event_id=b.iextls_id LEFT JOIN i_ext_ed_subjects as d ON b.iextls_subject_id=d.iexts_id LEFT JOIN i_ext_ed_chapters as e ON b.iextls_chapter_id=e.iextc_id LEFT JOIN i_ext_ed_teachers as f ON b.iextls_teacher_id=f.iextt_id WHERE a.ieea_customer_id ='$sid' AND MONTH(a.ieea_date) = '$m' AND a.ieea_status='false' AND a.ieea_event='lecture' AND a.ieea_owner='$oid'");
			$result = $query->result();
			$data['attendance_lec'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance as a LEFT JOIN i_ext_ed_exam_schedule as c ON a.ieea_event_id=c.iextes_id LEFT JOIN i_ext_ed_subjects as g ON c.iextes_subject_id=g.iexts_id LEFT JOIN i_ext_ed_chapters as h ON c.iextes_chapter_id=h.iextc_id LEFT JOIN i_ext_ed_preliem as i ON c.iextes_preliem_id=i.iextp_id WHERE a.ieea_customer_id ='$sid' AND MONTH(a.ieea_date) = '$m' AND a.ieea_status='false' AND a.ieea_event='exam' AND a.ieea_owner='$oid'");
			$result = $query->result();
			$data['attendance_exam'] = $result;

			$data['month'] = $m;

			$data['s_id'] = $sid;


			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Monthly Attendance: ".$student ;
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('education/attendance_monthly', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

########## ENQURY ################
	public function enquiry() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id WHERE a.ic_section = 'Enquiry' AND a.ic_owner='$oid'");
			$result = $query->result();

			$data['customer'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Enquiry";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/enquiry', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function enquiry_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Enquiry'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$data['thing'] = 'Enquiry';

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Add Enquiry";
			$ert['search'] = "false";


			$this->load->view('navbar', $ert);
			$this->load->view('education/enquiry_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_enquiry() {
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
				'ic_section' => 'Enquiry',
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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Enquiry');	

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

	public function enquiry_edit($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Enquiry'");
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

			$data['thing'] = 'Enquiry';
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Edit Enquiry";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/enquiry_add', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_enquiry($c_id) {
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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Enquiry');	

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

	public function delete_enquiry($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$this->db->where('ic_id', $c_id);
			$this->db->delete('i_customers');
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			redirect(base_url().'education/enquiry');

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function confirm_enquiry($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			$c_tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_section' => 'Students',
				'ic_section_update' => $dt,
				'ic_modified' => $dt,
				'ic_modified_by' => $oid );

			$this->db->where('ic_id', $c_id);
			$this->db->update('i_customers', $data);

			$data1 = array(
				'iextfu_module' => 'enquiry',
				'iextfu_owner' => $oid,
				'iextfu_customer_id' => $c_id );

			$data2 = array('iextfu_status' => 'Complete');
			$this->db->where($data1);
			$this->db->update('i_ext_ed_followup', $data2);


			
			// $this->db->where('icbd_customer_id', $c_id);
			// $this->db->delete('i_c_basic_details');

			// for ($i=0; $i < count($c_value) ; $i++) { 
			// 	$tmp_prp = $c_value[$i]['v'];
			// 	$tmp_val = $c_value[$i]['p'];

			// 	$data2 = array(
			// 		'icbd_customer_id' => $c_id,
			// 		'icbd_property' => $tmp_prp,
			// 		'icbd_value' => $tmp_val);

			// 	$this->db->insert('i_c_basic_details', $data2);		
			// }

			// $pp = $c_property[0]['n_p'];

			// $n_pp = array();
			// for ($i=0; $i < count($pp) ; $i++) { 
			// 	$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Students');	

			// 	$this->db->insert('i_property', $data);
			// 	$npid = $this->db->insert_id();
			// 	array_push($n_pp, $npid);
			// }

			// $vv = $c_property[0]['n_v'];
			// for ($i=0; $i < count($n_pp) ; $i++) { 

			// 	$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
			// 	$this->db->insert('i_c_basic_details', $data);
				
			// }

			// for ($j=0; $j < count($c_tags) ; $j++) { 
			// 	$tmp_tag = $c_tags[$j];

			// 	$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tmp_tag' AND it_owner = '$oid'");
			// 	$result = $query->result();

			// 	if(count($result) <= 0) {
			// 		$data3 = array(
			// 			'it_value' => $tmp_tag,
			// 			'it_owner' => $oid );

			// 		$this->db->insert('i_tags', $data3);
			// 		$tid = $this->db->insert_id();
			// 	} else {
			// 		$tid = $result[0]->it_id;
			// 	}

			// 	$data4 = array(
			// 		'ictp_customer_id' => $c_id,
			// 		'ictp_tag_id' => $tid,
			// 		'ictp_created' => $dt);

			// 	$this->db->insert('i_c_t_prefernces', $data4);
			// }

			redirect(base_url().'education/customer_property_transistion/'.$c_id.'/Enquiry/Students');
		} else {
			redirect(base_url().'account/login');
		}
	}

########## STUDENT PROPERTY TRANSISTION #################
	public function customer_property_transistion($c_id, $from, $to) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id = '$c_id'");
			$result = $query->result();

			$customer = $result[0]->ic_name;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$from'");
			$result = $query->result();

			$data['from'] = $result;

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$to'");
			$result = $query->result();

			$data['to'] = $result;

			$data['title_from'] = $from;
			$data['title_to'] = $to;

			$data['cid'] = $c_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Property Transition: ".$customer;
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/customer_transistion', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function customer_transistion_save($c_id, $from, $to) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$from_prp = $this->input->post('from');
			$to_prp = $this->input->post('to');

			for ($i=0; $i < count($from_prp) ; $i++) { 
				if ($to_prp[$i] == "create") {
					$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = '$from' AND ip_id='$from_prp[$i]'");
					$result = $query->result();	

					$data = array(
						'ip_property' => $result[0]->ip_property ,
						'ip_owner' => $oid,
						'ip_section' => $to );
					$this->db->insert('i_property', $data);
					$pid = $this->db->insert_id();

					$ab = $from_prp[$i];

					$data1 = array('icbd_customer_id' => $c_id , 'icbd_property' => $ab );
					$data2 = array('icbd_property' => $pid);
					$this->db->where($data1);
					$this->db->update('i_c_basic_details', $data2);
				} else if($to_prp[$i] == "none") {

				} else {
					$ab = $from_prp[$i];
					$data1 = array('icbd_customer_id' => $c_id , 'icbd_property' => $ab );
					$data2 = array('icbd_property' => $to_prp[$i]);
					$this->db->where($data1);
					$this->db->update('i_c_basic_details', $data2);
				}
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

########## FOLLOW UPS ################
	public function follow_up($module, $student_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_ext_ed_followup WHERE iextfu_owner='$oid' AND iextfu_customer_id='$student_id' AND iextfu_module='$module' ORDER BY iextfu_created DESC");
			$result = $query->result();

			$data['follow'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Follow Up";
			$ert['search'] = "false";

			$data['module'] = $module;
			$data['sid'] = $student_id;

			$this->load->view('navbar', $ert);
			$this->load->view('education/follow_up', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_follow_up($module, $student_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextfu_module' => $module,
				'iextfu_customer_id' => $student_id, 
				'iextfu_followup' => $dt,
				'iextfu_remind' => $this->input->post('remind'),
				'iextfu_remarks' => $this->input->post('remarks'),
				'iextfu_status' => 'Pending',
				'iextfu_owner' => $oid, 
				'iextfu_created' => $dt,
				'iextfu_created_by' => $oid);

			$this->db->insert('i_ext_ed_followup', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

########## COURSES ################
	public function courses() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_section='Courses'");
			$result = $query->result();

			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Courses";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('education/product', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function course_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Courses Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/product_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_course() {
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
				'ip_section' => 'Courses',
				'ip_owner' => $oid,
				'ip_created' => $dt,
				'ip_created_by' => $oid );

			$this->db->insert('i_product', $data);
			$prid = $this->db->insert_id();

			$data = array(
				'ipp_p_id' => $prid,
				'ipp_alias' => $this->input->post('alias'),
				'ipp_cost_price' => $this->input->post('price'),
				'ipp_sell_price' => $this->input->post('price'),
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

	public function course_edit($p_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();

			$data['tags'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_id='$p_id' AND ip_owner='$oid' AND ip_section='Courses'");
			$result = $query->result();

			$data['edit_product'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_p_price WHERE ipp_p_id='$p_id' ORDER BY ipp_id DESC");
			$result = $query->result();

			$data['edit_product_alias'] = $result[0]->ipp_alias;
			$data['edit_product_sprice'] = $result[0]->ipp_sell_price;

			
			$query = $this->db->query("SELECT * FROM i_p_features WHERE ipf_product_id='$p_id'");
			$result = $query->result();

			$data['edit_features'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_p_f_tags WHERE ipft_product_id = '$p_id'");
			$result = $query->result();

			$data['edit_preferences'] = $result;

			$data['pid'] =$p_id;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Products";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/product_add', $data);	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_course($prid) {
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
				'ipp_cost_price' => $this->input->post('price'),
				'ipp_sell_price' => $this->input->post('price'),
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

	public function delete_course($prid) {
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

			redirect(base_url().'Education/courses');
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## NOTES ################

########## MARKS ################
	public function marks() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_marks WHERE iextm_owner='$oid' ORDER BY iextm_created DESC");
			$result = $query->result();

			$tmp_data = array();



			for ($i=0; $i < count($result) ; $i++) { 
				$marksid = $result[$i]->iextm_id;

				if($result[$i]->iextm_event == "external") {
					$eventid = $result[$i]->iextm_event_id;
					$query1 = $this->db->query("SELECT * FROM i_ext_ed_external_exams as a LEFT JOIN i_ext_ed_subjects as b ON a.iextee_subject_id=b.iexts_id LEFT JOIN i_ext_ed_batch AS c ON a.iextee_batch_id=c.iextb_batch_name WHERE a.iextee_owner='$oid' AND a.iextee_id='$eventid'");
					$result1 = $query1->result();

					if (count($result1) > 0) {
						array_push($tmp_data, array('eventid' => $eventid , 'name' => $result1[0]->iexts_name.' '.$result1[0]->iextee_name, 'batch' => $result1[0]->iextb_batch_name, 'date' => $result1[0]->iextes_from_date));
					}
				} else if($result[$i]->iextm_event == "internal") {
					$eventid = $result[$i]->iextm_event_id;
					$query1 = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id LEFT JOIN i_ext_ed_batch AS e ON a.iextes_batch_id=e.iextb_batch_name WHERE a.iextes_owner='$oid' AND a.iextes_id='$eventid'");
					$result1 = $query1->result();
					if (count($result1) > 0) {

						if($result1[0]->iextes_type== "preliem") {

							array_push($tmp_data, array('id' => $marksid, 'eventid' => $eventid , 'name' => $result1[0]->iexts_name.' '.$result1[0]->iextp_preliem_name, 'batch' => $result1[0]->iextb_batch_name, 'date' => $result1[0]->iextes_from_date));
						} else {

							array_push($tmp_data, array('id' => $marksid, 'eventid' => $eventid , 'name' => $result1[0]->iexts_name.' '.$result1[0]->iextc_name, 'batch' => $result1[0]->iextb_batch_name, 'date' => $result1[0]->iextes_from_date));
						}
					}
				}
			}

			$data['recents'] = $tmp_data;


			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Marks";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/marks', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function marks_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id LEFT JOIN i_ext_ed_batch AS e ON a.iextes_batch_id=e.iextb_id WHERE a.iextes_owner='$oid' ORDER BY a.iextes_from_date DESC");
			$result = $query->result();
			$data['exam'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_external_exams as a LEFT JOIN i_ext_ed_subjects as b ON a.iextee_subject_id=b.iexts_id LEFT JOIN i_ext_ed_batch AS c ON a.iextee_batch_id=c.iextb_id WHERE a.iextee_owner='$oid' ORDER BY a.iextee_date DESC");
			$result = $query->result();
			$data['exam_external'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Marks Edit";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/marks_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function get_internal_exam_students($eid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_batch AS e ON a.iextes_batch_id=e.iextb_id WHERE a.iextes_owner='$oid' AND a.iextes_id='$eid'");
			$result = $query->result();

			if (count($result) > 0) {
				$bid = $result[0]->iextes_batch_id;
				$quer = $this->db->query("SELECT * FROM i_ext_ed_batch_allot AS a LEFT JOIN i_customers AS b ON a.iextba_customer_id=b.ic_id WHERE b.ic_section = 'Students' AND b.ic_owner='$oid' AND a.iextba_batch_id='$bid'");
				$resu = $quer->result();

				print_r(json_encode($resu));
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_marks() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$event = $this->input->post('event');
			$event_id = $this->input->post('event_id');
			$students = $this->input->post('students');
			$obtained = $this->input->post('obtained');
			$outof = $this->input->post('outof');
			$grade = $this->input->post('grade');
			$details = $this->input->post('details');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iextm_event' => $event,
				'iextm_event_id' => $event_id,
				'iextm_owner' => $oid,
				'iextm_created' => $dt,
				'iextm_created_by' => $oid );
			$this->db->insert('i_ext_ed_marks', $data);
			$mid = $this->db->insert_id();

			for ($i=0; $i < count($students) ; $i++) { 
				$data = array(
					'iextmr_m_id' => $mid,
					'iextmr_customer_id' => $students[$i],
					'iextmr_marks_obt' => $obtained[$i],
					'iextmr_out_of' => $outof[$i],
					'iextmr_grade' => $grade[$i],
					'iextmr_details' => $grade[$i]
				);
				$this->db->insert('i_ext_ed_marks_records', $data);	
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
					'iextemt_m_id' => $mid,
					'iextemt_tag_id' => $tid);

				$this->db->insert('i_ext_ed_marks_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function marks_edit($mid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_marks WHERE iextm_owner='$oid' AND iextm_id='$mid'");
			$result = $query->result();
			$data['edit_marks'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_marks_records AS a LEFT JOIN i_customers AS b ON a.iextmr_customer_id=b.ic_id WHERE a.iextmr_m_id='$mid' AND b.ic_owner='$oid' AND b.ic_section='Students'");
			$result = $query->result();
			$data['edit_marks_record'] = $result;

		
			$query = $this->db->query("SELECT * FROM i_ext_ed_marks_tags WHERE iextemt_m_id='$mid'");
			$result = $query->result();
			$data['edit_marks_tags'] = $result;

			$data['m_id'] = $mid;
			$query = $this->db->query("SELECT * FROM i_ext_ed_marks WHERE iextm_owner='$oid' AND iextm_id='$mid'");
			$result = $query->result();
			$data['edit_marks'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id LEFT JOIN i_ext_ed_batch AS e ON a.iextes_batch_id=e.iextb_id WHERE a.iextes_owner='$oid' ORDER BY a.iextes_from_date DESC");
			$result = $query->result();
			$data['exam'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_external_exams as a LEFT JOIN i_ext_ed_subjects as b ON a.iextee_subject_id=b.iexts_id LEFT JOIN i_ext_ed_batch AS c ON a.iextee_batch_id=c.iextb_id WHERE a.iextee_owner='$oid' ORDER BY a.iextee_date DESC");
			$result = $query->result();
			$data['exam_external'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Courses Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/marks_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_marks($mid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$event = $this->input->post('event');
			$event_id = $this->input->post('event_id');
			$students = $this->input->post('students');
			$obtained = $this->input->post('obtained');
			$outof = $this->input->post('outof');
			$grade = $this->input->post('grade');
			$details = $this->input->post('details');
			$tags = $this->input->post('tags');

			$dt = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'iextm_event' => $event,
				'iextm_event_id' => $event_id,
				'iextm_owner' => $oid,
				'iextm_created' => $dt,
				'iextm_created_by' => $oid );
			$this->db->where('iextm_id', $mid);
			$this->db->update('i_ext_ed_marks', $data);
			
			$this->db->where('iextmr_m_id', $mid);
			$this->db->delete('i_ext_ed_marks_records');

			for ($i=0; $i < count($students) ; $i++) { 
				$data = array(
					'iextmr_m_id' => $mid,
					'iextmr_customer_id' => $students[$i],
					'iextmr_marks_obt' => $obtained[$i],
					'iextmr_out_of' => $outof[$i],
					'iextmr_grade' => $grade[$i],
					'iextmr_details' => $grade[$i]
				);
				$this->db->insert('i_ext_ed_marks_records', $data);	
			}
			
			$this->db->where('iextemt_m_id', $mid);
			$this->db->delete('i_ext_ed_marks_tags');
			
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
					'iextemt_m_id' => $mid,
					'iextemt_tag_id' => $tid);

				$this->db->insert('i_ext_ed_marks_tags', $data4);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## RESULTS ################
	public function results(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch WHERE iextb_status='true' AND iextb_owner='$oid'");
			$result = $query->result();
			$data['batch'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_subjects WHERE iexts_owner='$oid'");
			$result = $query->result();
			$data['subject'] = $result;


			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Results";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/results', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function result_get_student($bid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_batch_allot AS a LEFT JOIN i_customers AS b ON a.iextba_customer_id=b.ic_id WHERE a.iextba_batch_id='$bid' AND b.ic_owner='$oid' AND b.ic_section='Students'");
			$result = $query->result();
			$data['students'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule as a LEFT JOIN i_ext_ed_subjects as b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters as c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_preliem as d ON a.iextes_preliem_id=d.iextp_id  WHERE a.iextes_owner='$oid' AND a.iextes_batch_id='$bid' ORDER BY a.iextes_from_date DESC");
			$result = $query->result();
			$data['internal_exams'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_external_exams as a LEFT JOIN i_ext_ed_subjects as b ON a.iextee_subject_id=b.iexts_id WHERE a.iextee_owner='$oid' AND a.iextee_batch_id='$bid' ORDER BY a.iextee_date DESC");
			$result = $query->result();
			$data['external_exams'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function result_get_subject_details() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;

			$subject = $this->input->post('subject');
			$view = $this->input->post('view');

			if($view == "chapter"){
				$query = $this->db->query("SELECT iextc_id AS id, iextc_name AS name FROM i_ext_ed_chapters WHERE iextc_owner='$oid' AND iextc_subject='$subject'");
				$result = $query->result();

				$data['content'] = $result;

			} else if($view == "preliem") {
				$query = $this->db->query("SELECT iextp_id AS id, iextp_preliem_name AS name FROM i_ext_ed_preliem WHERE iextp_owner='$oid' AND iextp_subject_id='$subject'");
				$result = $query->result();

				$data['content'] = $result;
			} else if($view == "external") {
				$query = $this->db->query("SELECT iextee_id AS id, iextee_name AS name FROM i_ext_ed_external_exams WHERE iextee_owner='$oid' AND iextee_subject_id='$subject'");
				$result = $query->result();

				$data['content'] = $result;
			}

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}	
	}

	public function result_generate_student($cid, $etype, $elements){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$dt = date('d-m-Y');

			$element_values = explode('~', $elements);

			$dt1 = date('Y-m-d H:i:s');
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT iud_logo FROM i_u_details WHERE iud_u_id='$oid'");
			$result = $query->result();

			$data['s_logo'] = base_url().'assets/uploads/'.$oid.'/logo/'.$result[0]->iud_logo;

			$data['s_title'] = 'Result';
			$data['s_date'] = $dt;

			$query = $this->db->query("SELECT ic_name, icbd_value, ip_property, ip_product, f.ip_id FROM i_customers AS a LEFT JOIN i_c_basic_details AS b ON a.ic_id=b.icbd_customer_id LEFT JOIN i_property AS c ON b.icbd_property=c.ip_id LEFT JOIN i_ext_ed_batch_allot AS d ON a.ic_id=d.iextba_customer_id LEFT JOIN i_ext_ed_batch AS e ON d.iextba_batch_id=e.iextb_id LEFT JOIN i_product AS f ON e.iextb_course=f.ip_id WHERE a.ic_id='$cid' AND ic_owner='$oid' AND c.ip_property LIKE '%Address%'");
			$result = $query->result();

			$courseid = 0;
			if(count($result) <= 0) {
				$query = $this->db->query("SELECT ic_name, ip_product, f.ip_id FROM i_customers AS a LEFT JOIN i_ext_ed_batch_allot AS d ON a.ic_id=d.iextba_customer_id LEFT JOIN i_ext_ed_batch AS e ON d.iextba_batch_id=e.iextb_id LEFT JOIN i_product AS f ON e.iextb_course=f.ip_id WHERE a.ic_id='$cid' and a.ic_owner = '$oid'");
				$result = $query->result();

				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] = '';
				$data['s_course'] = $result[0]->ip_product;
				$courseid = $result[0]->ip_id;
			} else {
				$data['s_name'] = $result[0]->ic_name;
				$data['s_address'] =$result[0]->icbd_value;
				$data['s_course'] = $result[0]->ip_product;
				$courseid = $result[0]->ip_id;
			}

			if($etype == "chapter") {
				$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule AS a LEFT JOIN i_ext_ed_subjects AS b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters AS c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_marks AS d ON a.iextes_id=d.iextm_event_id LEFT JOIN i_ext_ed_marks_records AS e ON d.iextm_id=e.iextmr_m_id WHERE a.iextes_type = '$etype' AND a.iextes_chapter_id IN ($element_values) AND a.iextes_owner='$oid' AND e.iextmr_customer_id='$cid'");
				$result = $query->result();

				for ($i=0; $i < count($result) ; $i++) { 
					$data['s_details'][$i]['s_particular_text'] = $result[$i]->iexts_name.' - '.$result[$i]->iextc_name.' - '.$result[$i]->iextes_from_date;
					$data['s_details'][$i]['s_particular_obt'] = $result[$i]->iextmr_marks_obt;
					$data['s_details'][$i]['s_particular_outof'] = $result[$i]->iextmr_out_of;
					$data['s_details'][$i]['s_particular_grade'] = $result[$i]->iextmr_grade;
					$data['s_details'][$i]['s_particular_detail'] = $result[$i]->iextmr_details;
				}
			} else if($etype == "preliem") {

				$arr = implode(',',$element_values);
				$query = $this->db->query("SELECT * FROM i_ext_ed_exam_schedule AS a LEFT JOIN i_ext_ed_subjects AS b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_preliem AS c ON a.iextes_preliem_id=c.iextp_id LEFT JOIN i_ext_ed_marks AS d ON a.iextes_id=d.iextm_event_id LEFT JOIN i_ext_ed_marks_records AS e ON d.iextm_id=e.iextmr_m_id WHERE a.iextes_type = '$etype' AND a.iextes_preliem_id IN ($arr) AND a.iextes_owner='$oid' AND e.iextmr_customer_id='$cid'");
				$result = $query->result();

				for ($i=0; $i < count($result) ; $i++) { 
					$data['s_details'][$i]['s_particular_text'] = $result[$i]->iexts_name.' - '.$result[$i]->iextp_preliem_name.' - '.$result[$i]->iextes_from_date;
					$data['s_details'][$i]['s_particular_obt'] = $result[$i]->iextmr_marks_obt;
					$data['s_details'][$i]['s_particular_outof'] = $result[$i]->iextmr_out_of;
					$data['s_details'][$i]['s_particular_grade'] = $result[$i]->iextmr_grade;
					$data['s_details'][$i]['s_particular_detail'] = $result[$i]->iextmr_details;

					$marks = $result[$i]->iextmr_marks_obt;
					$total = $result[$i]->iextmr_out_of;
					$percent = $marks / $total * 100;
					$data['s_details'][$i]['s_particular_percent'] = $percent;
				}
			} else if($etype == "external") {
				// $query = $this->db->query("SELECT iextes_id FROM i_ext_ed_exam_schedule AS a LEFT JOIN i_ext_ed_subjects AS b ON a.iextes_subject_id=b.iexts_id LEFT JOIN i_ext_ed_chapters AS c ON a.iextes_chapter_id=c.iextc_id LEFT JOIN i_ext_ed_marks AS d ON a.iextes_id=d.iextm_event_id LEFT JOIN i_ext_ed_marks_records AS e ON d.iextm_id=e.iextmr_m_id WHERE a.iextes_type = '$etype' AND a.iextes_chapter_id IN '$element_values' AND a.iextes_owner='$oid' AND e.iextmr_customer_id='$cid'");
				// $result = $query->result();

				// for ($i=0; $i < count($result) ; $i++) { 
				// 	$data[$i]['s_particular_text'] = $result[$i]->iexts_name.' - '.$result[$i]->iextc_name.' - '.$result[$i]->iextes_from_date;
				// 	$data[$i]['s_particular_obt'] = $result[$i]->iextmr_marks_obt;
				// 	$data[$i]['s_particular_outof'] = $result[$i]->iextmr_out_of;
				// 	$data[$i]['s_particular_grade'] = $result[$i]->iextmr_grade;
				// 	$data[$i]['s_particular_detail'] = $result[$i]->iextmr_details;
				// }
			}
			$this->load->view('education/mark_sheet', $data);

		} else {
			redirect(base_url().'Account/login');
		}
	}

########## RESULT DISPLAY ################

########## ACCOUNTING (EXPENSES/ PURCHASES PROFITS PER PARTNER/RENTAL) ################
	########## EXPENSES ################
	public function expenses() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_expenses WHERE iexte_owner='$oid' ORDER BY iexte_date DESC, iexte_id DESC");
			$result = $query->result();
			$data['expense'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Expenses";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/expenses', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_expenses() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iexte_details' => $this->input->post('details'),
				'iexte_amount' => $this->input->post('amt'),
				'iexte_date' => $this->input->post('date'),
				'iexte_owner' => $oid,
				'iexte_created' => $dt,
				'iexte_created_by' => $oid );

			$this->db->insert('i_ext_ed_expenses', $data);
			$eid = $this->db->insert_id();

			$cat = $this->input->post('categories');

			print_r($cat);
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

				$data4 = array(
					'iextet_e_id' => $eid,
					'iextet_tag_id' => $tid,
					'iextet_created' => $dt);

				$this->db->insert('i_ext_ed_expense_tag', $data4);
			}

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_expenses($eid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array( 'iexte_id' => $eid, 'iexte_owner' => $oid );
			$this->db->where($data);
			$this->db->delete('i_ext_ed_expenses');

			$this->db->where('iextet_e_id', $eid);
			$this->db->delete('i_ext_ed_expense_tag');
			
			redirect(base_url().'Education/expenses');

		} else {
			redirect(base_url().'account/login');
		}
	}

	########## PURCHASES ##############
	public function purchases() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_ext_ed_purchases AS a LEFT JOIN i_customers AS b ON a.iextp_c_id=b.ic_id WHERE a.iextp_owner='$oid' AND b.ic_section='Vendors' ORDER BY a.iextp_date DESC, a.iextp_id DESC");
			$result = $query->result();
			$data['purchase'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_section='Vendors'");
			$result = $query->result();
			$data['customer'] = $result;

			$data['oid'] = $oid;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Purchases";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('education/purchase', $data);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_purchase() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');

			$vendor = $this->input->post('vendor');
			$cid = 0;
			for ($i=0; $i < count($vendor) ; $i++) { 
				$tmpvnd = $vendor[$i];
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner='$oid' AND ic_name='$tmpvnd' AND ic_section='Vendors'");
				$result = $query->result();

				if (count($result) > 0) {
					$cid = $result[0]->ic_id;
				} else {
					$data6 = array(
						'ic_name' => $tmpvnd,
						'ic_section' => 'Vendors',
						'ic_owner' => $oid,
						'ic_created' => $dt,
						'ic_created_by' => $oid );

					$this->db->insert('i_customers', $data6);
					$cid = $this->db->insert_id();
				}
			}

			$data = array(
				'iextp_c_id' => $cid,
				'iextp_txn_no' => $this->input->post('txn_no'),
				'iextp_amount' => $this->input->post('amt'),
				'iextp_date' => $this->input->post('date'),
				'iextp_detail' => $this->input->post('details'),
				'iextp_owner' => $oid,
				'iextp_created' => $dt,
				'iextp_created_by' => $oid );

			$this->db->insert('i_ext_ed_purchases', $data);
			$pid = $this->db->insert_id();

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

				$data4 = array(
					'iextpt_e_id' => $pid,
					'iextpt_tag_id' => $tid,
					'iextpt_created' => $dt);

				$this->db->insert('i_ext_ed_purchase_tag', $data4);
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_purchase($eid) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array( 'iexte_id' => $eid, 'iexte_owner' => $oid );
			$this->db->where($data);
			$this->db->delete('i_ext_ed_expenses');

			$this->db->where('iextet_e_id', $eid);
			$this->db->delete('i_ext_ed_expense_tag');
			
			redirect(base_url().'Education/purchases');

		} else {
			redirect(base_url().'account/login');
		}
	}

########## HR(SALARY & ATTENDANCE) ################

########## HOME ################
	public function home2() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$data['oid'] = $oid;

			$module = $sess_data['user_mod'];

			$displays = array();
			for ($i=0; $i < count($module) ; $i++) { 
				$modid = $module[$i]->ium_m_id;

				$query = $this->db->query("SELECT * FROM i_time_constraint AS a LEFT JOIN i_display AS b ON a.itc_display=b.id_id WHERE itc_module = '$modid'");
				$result = $query->result();

				for ($j=0;$j<count($result);$j++) { 
					$dt = date('Y-m-d');
					$que_str = $result[$j]->itc_query;

					eval("\$que_str = \"$que_str\";");
					$que = $this->db->query($que_str);
					$res = $que->result();

					if(count($res) > 0) {
						if($result[$j]->id_name) {
							$wer = $result[$j]->id_header;
							$wer .= $result[$j]->itc_name;
							$wer .= $result[$j]->id_mid;

							$tcid = $result[$j]->itc_id;
							$que1 = $this->db->query("SELECT * FROM i_tc_columns WHERE itcc_tc_id='$tcid'");
							$res1 = $que1->result();
							for ($k=0; $k < count($res); $k++) { 
								for ($m=0; $m < count($res1) ; $m++) { 
									$col = $res1[$m]->itcc_column;
									$wer.=$res[$k]->$col.'<br/>';
								}
							}
							$wer .= $result[$j]->id_bottom;
							array_push($displays, $wer);
						} else {
							$wer = '<div class="mdl-cell mdl-cell--4-col"><div class="mdl-card mdl-shadow--4dp"><div class="mdl-card__title mdl-card--expand"><h2 class="mdl-card__title-text">'.$result[$j]->itc_name.'</h2></div><div class="mdl-card__supporting-text" style="text-align:left; font-size:1.5em;line-height:1.5em;">';
							$tcid = $result[$j]->itc_id;

							$que1 = $this->db->query("SELECT * FROM i_tc_columns WHERE itcc_tc_id='$tcid'");
							$res1 = $que1->result();

							for ($k=0; $k < count($res); $k++) { 
								// $wer.= '<tr><td>'.($k+1)."</td><td>";
								for ($m=0; $m < count($res1) ; $m++) { 
									$col = $res1[$m]->itcc_column;
									$wer.=$res[$k]->$col.'<br/>';
								}
								$wer.='<hr>';
							}
							$wer.='</div></div></div>';
							array_push($displays, $wer);
						}
					}
				}
			}
			
			$data['display'] = $displays;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Home";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/home', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function home() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$data['oid'] = $oid;

			$module = $sess_data['user_mod'];

			$query = $this->db->query("SELECT ic_section FROM i_customers GROUP BY ic_section");
			$result = $query->result();
			$data['section'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_join_index");
			$result = $query->result();
			$data['join_index'] = $result;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Home";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('education/home', $data);

		} else {
			redirect(base_url().'account/login');
		}
	}

	public function query_details() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_owner;
			$entity = $this->input->post('s');
			$module = $this->input->post('m');
			$prop = $this->input->post('p');
			$filter = $this->input->post('f');

			$entity_tbl = [];
			$entity_col = [];
			$entity_section = [];

			if (count($entity) > 0) {
				array_push($entity_tbl, 'i_customers');
				array_push($entity_col, 'ic_id');
				$entity_section = $entity;
			}

			$que = "SELECT ";

			// $prop_col = [];

			// for ($i=0; $i < count($prop) ; $i++) { 
			// 	$tmp_prop_input = $prop[$i];

			// 	// $q1 = $this->db->query("SELECT * FROM i_column_index WHERE ici_name = '");
			// }

			if(count($prop) > 0) {
				$que .= implode(', ', $prop);	
			} else {
				$que .= "*";
			}

			$que .= " FROM ".$entity_tbl[0];

			for ($i=0; $i < count($module) ; $i++) { 
				$query1 = $this->db->query("SELECT * FROM i_join_index WHERE iji_name = '$module[$i]' AND iji_table1='$entity_tbl[0]'");
				$result1 = $query1->result();
				if (count($result1) > 0) {
					$que .= ' LEFT JOIN '.$result1[0]->iji_table2.' ON '.$entity_tbl[0].'.'.$entity_col[0].'='.$result1[0]->iji_table2.'.'.$result1[0]->iji_column2;
				} else {
					$query2 = $this->db->query("SELECT * FROM i_join_index WHERE iji_name = '$module[$i]'");
					$result2 = $query2->result();
					if(count($result2) > 0) {
						$que .= ' LEFT JOIN '.$result2[0]->iji_table1.' ON '.$result2[0]->iji_table1.'.'.$result2[0]->iji_column1.'='.$result2[0]->iji_table2.'.'.$result2[0]->iji_column2;
					}
				}
			}

			if (count($filter) > 0 || count($entity_section) > 0) {
				$que .= ' WHERE ic_owner="'.$oid.'" ';
			}

			for ($i=0; $i < count($entity_section) ; $i++) { 
				$que.=" AND ";
				$que .= " i_customers.ic_section='".$entity_section[$i]."'";
			}
			
			for ($i=0; $i < count($filter) ; $i++) {
				if(strpos($filter[$i], 'GROUP BY') === 0) {

				} else {
					$que.= ' AND ';	
				}
				$que .= ' '.$filter[$i];
			}

			// echo $que;

			$query = $this->db->query($que);
			$result = $query->result();
			$data['values'] = $result;

			$data['columns'] = $prop;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}
}