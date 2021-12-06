<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

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
########## USER ACCOUNT AND DETAILS ########
	public function index($code) {
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

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();

			$data['gid'] = $gid;
			$ert['code'] = $code;
			$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['mname'] = $mname;
			$ert['mid'] = $mid;
			$ert['title'] = "Account";
			$ert['search'] = "false";

			if($uid == $oid) {
				$data['admin'] = 'true';
				$this->load->view('navbar', $ert);
				$this->load->view('account/home', $data);
				$this->load->view('home/search_modal');
			} else {
				$cid = $sess_data['user_details'][0]->i_ref;
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id='$cid'");
				$result = $query->result();
				$data['basic'] = $result;
				$sec = $result[0]->ic_section;

				$query2 = $this->db->query("SELECT * FROM i_property WHERE ip_section = '$sec' AND ip_owner = '$oid'");
				$result2 = $query2->result();
				$data['property'] = $result2;

				$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id='$cid'");
				$result1 = $query1->result();
				$data['details'] = $result1;

				$data['cid'] = $cid;
				$this->load->view('navbar', $ert);
				$this->load->view('account/home', $data);
				$this->load->view('home/search_modal');
			}
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function details($uid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;

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
			
			$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE a.i_uid = '$uid'");
			$result = $query->result();
			$data['user_info'] = $result;

			if (count($result) >0 ) {
				if ($result[0]->iud_logo != '') {
					$data['logo'] = base_url().'assets/uploads/'.$oid.'/'.$result[0]->iud_logo;
				}
			}

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();

			$ert['code'] = $code;
			$ert['gid'] = $gid;
			$ert['mname'] = 0;
			$ert['mid'] = 0;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']= $sess_data['user_connection'];
			$ert['title'] = "My Details";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/user_detail', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_details($uid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$data = array(
				'iud_name' => $this->input->post('name'),
				'iud_company' => $this->input->post('company'),
				'iud_email' => $this->input->post('email'),
				'iud_phone' => $this->input->post('phone'),
				'iud_address' => $this->input->post('address'),
				'iud_gst' => $this->input->post('gst'),
			);
			$this->db->where('iud_u_id', $uid);
			$this->db->update('i_u_details', $data);
			
			echo $uid;
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_account($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id='$c_id' AND ic_owner='$oid'");
			$result = $query->result();

			$sec = $result[0]->ic_section;

			$c_name = $this->input->post('name');
			$c_property = $this->input->post('new_property');
			$c_value = $this->input->post('value');
			
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ic_name' => $c_name,
				'ic_modified' => $dt,
				'ic_modified_by' => $uid );

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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => $sec);	
				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}

			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 
				$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
				$this->db->insert('i_c_basic_details', $data);
			}
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function logo_upload($uid,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$upload_dir = $this->config->item('document_rt').'assets/uploads/'.$oid.'/';
			
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
				
			}

			$data = array('iud_logo' => $img_path);

			$this->db->where('iud_u_id', $uid);
			$this->db->update('i_u_details', $data);
			echo $uid;
		}
	}

########## New user registration ###########
	public function register(){
		$this->load->view('account/reg_user');
	}

	public function reg_user($code=0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] != 'true') {
			$dt = date('Y-m-d H:i:s');
			$flag='n';
			$u_mail=$this->input->post('email');
			$phone_number=$this->input->post('phone');

			$status = '';
			$flag = '' ;
			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_email = '$u_mail'");
			$result1 = $query->result();
			if (count($result1)>0) {
				$flag='nn';
			}
			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_phone = '$phone_number'");
			$result2 = $query->result();
			if (count($result2)>0) {
				$flag='nnn';
			}
			if ($flag != '') {
				echo $flag;
			}else{
				$data = array(
					'i_uname' => $this->input->post('email'),
					'i_status' => 'verify',
					'i_created' => $dt,
					'i_storage' => '1000',
					'i_g_limit' => '0',
					'i_view' => 'false'
				);
				$this->db->insert('i_users', $data);
				$id = $this->db->insert_id();

				$data = array(
					'ium_u_id' => $id,
					'ium_m_id' => 33,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => 0
				);
				$this->db->insert('i_u_modules', $data);
				$data = array(
					'ium_u_id' => $id,
					'ium_m_id' => 38,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => 0
				);
				$this->db->insert('i_u_modules', $data);

				$data = array(
					'ium_u_id' => $id,
					'ium_m_id' => 34,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => 0
				);
				$this->db->insert('i_u_modules', $data);

				$chars = "0123456789ABCDEFGHIJKLMN0PQRSTUVWXYZ";
				$res = "";
				for ($i = 0; $i < 4; $i++) {
				    $res .= $chars[mt_rand(0, strlen($chars)-1)];
				}
				$res .= $id;

				$query = $this->db->query("SELECT * FROM i_user_scheme WHERE iush_default = '1' ");
				$result = $query->result();
				$sh_id = 0;
				if (count($result) > 0 ) {
					$sh_id = $result[0]->iush_id;
				}

				$data = array(
					'i_owner' => $id,'i_created_by' => $id,'i_user_code' => $res, 'i_user_scheme' => $sh_id
				);
				$this->db->where('i_uid', $id);
				$this->db->update('i_users', $data);

				$data1 = array(
					'iud_u_id' => $id,
					'iud_name' => $this->input->post('name'),
					'iud_company' => $this->input->post('company'),
					'iud_email' => $this->input->post('email'),
					'iud_phone' => $this->input->post('phone'),
					'iud_address' => $this->input->post('address'),
					'iud_gst' => $this->input->post('gst'),
					'iud_ref_code' => $this->input->post('ref_code')
				);
				$this->db->insert('i_u_details', $data1);

				echo $id;
			}
		} else {
			redirect(base_url().'Home/index/'.$code);
		}
	}

	public function reg_upload($in_id,$code=0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] != 'true') {
			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$in_id."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";
			
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
		        $sourcePath = $_FILES[0]['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES[0]['name']; // Target path where file is to be stored

				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
				$img_path = $_FILES[0]['name'];
				
        		$data = array('iud_profile' => $img_path);
				$this->db->where('iud_u_id',$in_id);
				$this->db->update('i_u_details', $data);

				$sourcePath = $_FILES[1]['tmp_name']; // Storing source path of the file in a variable
				$targetPath = $upload_dir.$_FILES[1]['name']; // Target path where file is to be stored
				
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
				$img_path = $_FILES[1]['name'];
				
        		$data = array('iud_logo' => $img_path);
				$this->db->where('iud_u_id',$in_id);
				$this->db->update('i_u_details', $data);
			}
			// echo "true";
			$this->reg_email($in_id);
		} else {
			redirect(base_url().'Home/index/'.$code);
		}
	}

	public function reg_email($in_id){
		$data = $this->db->query("SELECT * FROM i_users WHERE i_uid='$in_id'");
		$result = $data->result();

		$subject = "Evomata - Verify your Account";
		$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3 style="font-weight: normal; ">Please click on the button to verify your daifunc account.</h3><a href="'.base_url().'Account/reg_verify/'.urlencode($in_id).'"><button class="btn btn-lg btn-danger pic_button">Verify</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/reg_verify/'.urlencode($in_id).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

		$temp = $this->Mail->daifunc_reg_mail($subject,$result[0]->i_uname,null,$body);

		echo "success";
	}

	public function reg_verify($in_id,$code=0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] != 'true') {
			$dt = date('Y-m-d H:i:s');
			$cust_id = '';
			$data1 = array(
				'i_status' => 'password update'
			);
			$this->db->where('i_uid', $in_id);
			$this->db->update('i_users', $data1);

			$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$in_id'");
			$result = $query->result();
			$c_name = $result[0]->iud_name;
			$c_mail = $result[0]->iud_email;

			$query1 = $this->db->query("SELECT * FROM i_customers WHERE ic_name = '$c_name' AND ic_owner = '$in_id' ");
			$result1 = $query1->result();

			if (count($result1) > 0) {
				$cust_id = $result1[0]->ic_id;
			}else{
				$data = array(
					'ic_name' =>$result[0]->iud_name,
					'ic_owner'=>$result[0]->iud_u_id,
					'ic_created'=>$dt,
					'ic_created_by'=>$result[0]->iud_u_id,
					'ic_section'=>'customer',
					'ic_uid' => $result[0]->iud_u_id
				);
				$this->db->insert('i_customers', $data);
				$cust_id = $this->db->insert_id();

				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$in_id' AND ip_property LIKE '%email%'");
				$result = $query->result();

				if (count($result) > 0) {
					$pid = $result[0]->ip_id;	
				}else{
					$data = array(
						'ip_property' => 'email', 
						'ip_owner' => $in_id,
						'ip_section' => 'customer'
					);
					$this->db->insert('i_property',$data);
					$pid = $this->db->insert_id();
				}

				$data2 = array(
					'icbd_customer_id'=>$cust_id,
					'icbd_value'=>$c_mail,
					'icbd_property' => $pid
					);
				$this->db->insert('i_c_basic_details', $data2);	
			}

			$data1 = array(
				'i_ref' => $cust_id
			);
			$this->db->where('i_uid', $in_id);
			$this->db->update('i_users', $data1);

			redirect(base_url().'Account/reset_password/'.$in_id);
		} else {
			redirect(base_url().'Home');
		}
	}

########## FORGOT PASSWORD #################
	public function forgot_password(){
		$this->load->view('account/forgot_password');
	}

	public function forgot_mail($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] != 'true') {
			$email = $this->input->post('email');
			$query = $this->db->query("SELECT * FROM i_users WHERE i_uname ='$email'");
			$result = $query->result();
			$id = $result[0]->i_uid;
			if (count($result) > 0) {
				$subject = "Evomata - Reset Your Password";
				$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3 style="font-weight: normal; ">Please click on the button to reset your daifunc account password.</h3><a href="'.base_url().'Account/reg_verify/'.urlencode($id).'"><button class="btn btn-lg btn-danger pic_button">Verify</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/reg_verify/'.urlencode($id).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';
				$temp = $this->Mail->daifunc_reg_mail($subject,$result[0]->i_uname,null,$body);
			}else{
				echo "email";
			}
		}else{
			redirect(base_url().'Home');
		}
	}

########## LOGIN, PWD UPDATE ###############

	public function login($id = null,$code = 0)	{
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			redirect(base_url().'Home/index/'.$code);
		} else {
			$data['mode'] = "user";
			$this->load->view('account/login', $data);
		}
	}

	public function verify(){
		$uname = $this->input->post('uname');
		$upass = $this->input->post('upass');

	    $query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details AS b ON a.i_uid=b.iud_u_id WHERE i_uname = '$uname'");
		$result = $query->result();

		$dt = date('Y-m-d');

		if (count($result) > 0) {
			if ($result[0]->i_status == 'password update') {
				$id = $result[0]->i_uid;
				echo $id;
			} else if ($result[0]->i_status == 'false') {
				echo "sub";
			}else if ($result[0]->i_upassword==$upass) {
				$id = $result[0]->i_uid;

				$query = $this->db->query("SELECT * FROM i_u_session WHERE ius_u_id = '$id' ");
				$result1 = $query->result();

				if (count($result1) >= 3) {
					echo 's'.$id;
				}else{
					$key = $this->input->post('key');

					$this->db->WHERE(array('ius_s_id' => $key));
					$this->db->delete('i_u_session');

					$a = $this->log_code->login_verify($uname, $upass);
		
					if ($a['session'] == 'true') {
						echo 't'.$a['code'];
					} else {
						echo "false";
					}
				}
			} else {
				echo "unknown";
			}			
		} else {
			echo "false";
		}		
	}

	public function reset_password($uid,$code=0) {
		$data['uid'] = $uid;
		$data['code'] = $code;
		$this->load->view('account/reset', $data);
	}

	public function reset_update($uid) {
		$oid = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'i_upassword' => $this->input->post('upass'),
			'i_status' => 'true',
			'i_modified' => $dt,
			'i_modified_by' => $oid
		);
		$this->db->where('i_uid', $uid);
		$this->db->update('i_users', $data);
		
		echo "true";
	}

	public function logout($code) {
		$this->db->query("DELETE FROM i_u_session WHERE ius_s_id = '$code'");
		echo "true";
	}

	public function check_ses($key){
		$query = $this->db->query("SELECT * FROM i_u_session WHERE ius_s_id = '$key'");
		$result_s = $query->result();
		if (count($result_s)>0) {
			echo 'true';
		}else{
			// delete_cookie('CI_key');
			echo "false";
		}
	}

	public function logout_session(){
		$uname = $this->input->post('uname');
		$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_u_details AS b ON a.i_uid=b.iud_u_id WHERE i_uname = '$uname'");
		$result = $query->result();
		$uid = $result[0]->i_uid;
		$this->db->query("DELETE FROM i_u_session WHERE ius_u_id = '$uid'");
		echo "true";
	}

########## EXCEl MOUDLES ###################
	// public function create_module() {
	// 	$sess_data = $this->log_code->get_session_value($code,true);
	// 	if($sess_data['session'] == 'true') {
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner='$oid'");
	// 		$result = $query->result();
	// 		$data['tags'] = $result;

	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
	// 		$ert['title'] = "Module Create";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('account/module_create', $data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function save_module() {
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {

	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$c_name = $this->input->post('name');
	// 		$c_tags = $this->input->post('tags');

	// 		$dt = date('Y-m-d H:i:s');

	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$data = array(
	// 			'icem_name' => $c_name,
	// 			'icem_owner' => $oid,
	// 			'icem_created' => $dt,
	// 			'icem_created_by' => $oid );

	// 		$this->db->insert('i_c_excel_module', $data);
	// 		$mid = $this->db->insert_id();

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

	// 			$data4 = array(
	// 				'icemp_m_id' => $mid,
	// 				'icemp_tag_id' => $tid);

	// 			$this->db->insert('i_c_e_m_prefernces', $data4);
	// 		}

	// 		echo $mid;

	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function uploadfile($mid) {
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {

	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/irene/assets/data/".$oid."/";
	// 		if(!file_exists($upload_dir)) {
	// 			mkdir($upload_dir, 0777, true);
	// 		}

	// 		$img_path = "";
	// 		if (is_dir($upload_dir) && is_writable($upload_dir)) {
	// 			$sourcePath = $_FILES['use']['tmp_name']; // Storing source path of the file in a variable
	// 			$targetPath = $upload_dir.$_FILES['use']['name']; // Target path where file is to be stored
	// 			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
	// 			// $img_path = $targetPath;
			
	// 			$img_path = $_FILES['use']['name'];
	// 		}

	// 		$data = array('icem_path' => $img_path, 'icem_status' => 'Pending');
	// 		$this->db->where('icem_id', $mid);
	// 		$this->db->update('i_c_excel_module', $data);
			
	// 		// redirect(base_url().'Account/module_details/'.$mid);
	// 		echo $mid;
	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function module_details($mid) {
	// 	$sess_data = $this->session->userdata();
	// 	if(isset($sess_data['user_details'][0])) {

	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$query = $this->db->query("SELECT * FROM i_c_excel_module WHERE icem_owner='$oid' AND icem_status = 'Pending' AND icem_id='$mid'");
	// 		$result = $query->result();
			
	// 		if (count($result)) {
	// 			$doc = $_SERVER['DOCUMENT_ROOT'] . "/irene/assets/data/".$oid."/".$result[0]->icem_path;

	// 			$this->excel_reader->read($doc);
	// 			// Get the contents of the first worksheet
	// 			$worksheet = $this->excel_reader->sheets[0];

	// 			$cells = $worksheet['cells']; // the 1st row are usually the field's name
	// 			// print_r($cells);

	// 			$db_char_full = str_replace(' ', '_', strtolower($result[0]->icem_name));
	// 			$db_char_full = str_replace('/', '', $db_char_full);
	// 			$db_char_full = 'i_c_mx_'.$db_char_full;
	// 			$db_char = substr($db_char_full, 0, 3);

	// 			$sql_query = "";
	// 			$fields = array();
	// 			$prefix = 'icmx_'.$db_char.'_';
	// 			$sec_arr= array();

	// 			$sql_query = $prefix."_id int primary key auto_increment";
	// 			$this->dbforge->add_field($sql_query);

	// 			for ($j=1; $j <= count($cells[1]) ; $j++) { 
	// 				if(isset($cells[1][$j])) {

						
	// 					array_push($sec_arr, str_replace('.', '', str_replace('/', '', str_replace(' ', '_', strtolower($cells[1][$j])))));

	// 					$word = $prefix.str_replace('.', '', str_replace('/', '', str_replace(' ', '_', strtolower($cells[1][$j]))));
	// 					array_push($fields, $word);
	// 					if ($j <= count($cells[1]) - 1) {							
	// 						$sql_query=$word." varchar(200)";
	// 					} else {
	// 						$sql_query=$word." varchar(200)";
	// 					}
	// 					$this->dbforge->add_field($sql_query);
	// 				}
	// 			}
	// 			$attributes = array('ENGINE' => 'InnoDB');
	// 			$this->dbforge->create_table($db_char_full, TRUE, $attributes);
				
	// 			for ($i=0; $i < count($sec_arr) ; $i++) { 
	// 				$data = array('icemc_m_id' => $mid , 'icemc_column' => $sec_arr[$i] );
	// 				$this->db->insert('i_c_e_m_columns', $data);
	// 			}
				
	// 			for ($i=2; $i <= count($cells) ; $i++) { 
	// 				$data = array();
	// 				for ($j=0; $j < count($fields) ; $j++) { 
	// 					if(isset($cells[$i][$j + 1])) {
	// 						$data[(string)$fields[$j]] = $cells[$i][$j+1];
	// 					} else {
	// 						$data[(string)$fields[$j]] = "N/A";
	// 					}
	// 				}
	// 				$this->db->insert($db_char_full, $data);
	// 			}

	// 			$data = array('icem_table' => $db_char_full, 'icem_status' => 'Complete', 'icem_col_prefix' => $prefix);
	// 			$this->db->where('icem_id', $mid); 
	// 			$this->db->update('i_c_excel_module', $data);
	// 		}

	// 		redirect(base_url().'account');
	// 	} else {
	// 		redirect(base_url().'account/login');
	// 	}
	// }

	// public function read_excel() {
	// 	$this->excel_reader->read('./uploads/file.xls');
	// 	// Get the contents of the first worksheet
	// 	$worksheet = $this->excel_reader->sheets[0];

	// 	$numRows = $worksheet['numRows']; // ex: 14
	// 	$numCols = $worksheet['numCols']; // ex: 4
	// 	$cells = $worksheet['cells']; // the 1st row are usually the field's name
	// }

########## SELECT GROUPS, CREATE USERS, ASSIGN MODULES ################
	// public function load_customers() {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){
	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$sec = $this->input->post('group');

	// 		$query = $this->db->query("SELECT ic_id,ic_name FROM i_customers WHERE ic_owner='$oid' AND ic_section='$sec'");
	// 		$result = $query->result();
	// 		$data['customer'] = $result;
			
	// 		$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner='$oid' /*AND ip_section='$sec'*/");
	// 		$result = $query->result();
	// 		$data['property'] = $result;

	// 		print_r(json_encode($data));

	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function user_list() {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_customers AS b ON a.i_ref=b.ic_id  WHERE i_owner='$oid' AND i_uid <> i_owner");
	// 		$result = $query->result();
	// 		$data['users'] = $result;

	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
	// 		$ert['title'] = "List of Users";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('account/create_users_list', $data);
	// 		$this->load->view('home/search_modal');			
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}	
	// }

	// public function add_user() {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){

	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$data['oid'] = $sess_data['user_details'][0]->i_owner;
	// 		$module = $sess_data['user_mod'];

	// 		if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}

	// 		$query = $this->db->query("SELECT * FROM i_users AS a LEFT JOIN i_customers AS b ON a.i_ref=b.ic_id  WHERE i_owner='$oid' AND i_uid <> i_owner");
	// 		$result = $query->result();
	// 		$data['users'] = $result;

	// 		$query = $this->db->query("SELECT ic_section FROM i_customers WHERE ic_owner='$oid' GROUP BY ic_section");
	// 		$result = $query->result();
	// 		$data['groups'] = $result;
			
	// 		$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
	// 		$ert['title'] = "Add User";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('account/create_users_add', $data);
	// 		$this->load->view('home/search_modal');

	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}	
	// }

	// public function save_user() {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){
	// 		$oid = $sess_data['user_details'][0]->i_uid;

	// 		$group = $this->input->post('group');
	// 		$customer = $this->input->post('customer');
	// 		$module = $this->input->post('module');
	// 		$property = $this->input->post('property');

	// 		for ($i=0; $i < count($customer) ; $i++) { 
	// 			$cid = $customer[$i];

	// 			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$property' AND icbd_customer_id='$cid'");
	// 			$result = $query->result();

	// 			if(count($result) > 0) {
	// 				$val = $result[0]->icbd_value;
	// 				$data = array(
	// 					'i_uname' => $val,
	// 					'i_status' => 'password update',
	// 					'i_subscription_start' => $sess_data['user_details'][0]->i_subscription_start,
	// 					'i_subscription_renew' => $sess_data['user_details'][0]->i_subscription_renew,
	// 					'i_duration' => $sess_data['user_details'][0]->i_duration,
	// 					'i_owner' => $oid,
	// 					'i_ref' => $cid,
	// 					'i_created' => $dt,
	// 					'i_created_by' => $oid
	// 					);
	// 				$this->db->insert('i_users', $data);
	// 				$u_id = $this->db->insert_id();

	// 				for ($j=0; $j < count($module) ; $j++) { 
	// 					$data1 = array(
	// 						'ium_u_id' => $u_id,
	// 						'ium_m_id' => $module[$j],
	// 						'ium_status' => 'true',
	// 						'ium_created' => $dt,
	// 						'ium_created_by' => $oid
	// 					);
	// 					## IF USER ID <> OWNER ID THEN USER ELSE OWNER. IF USER THEN $OID IS OWNER ID ELSE PORTAL UID
	// 					$this->db->insert('i_u_modules', $data1);
	// 				}
	// 			}
	// 		}

	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}	
	// }

########## ACCOUNTING SETTING ##############
	public function user_accounting_setting($code,$type = null) {
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
			$data['type'] = $type;
			if ($type == 'home') {
				$this->db->where('i_uid',$oid);
				$this->db->update('i_users',array('i_view'=>'true'));
			}

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
			$result = $query->result();
			$data['edit_acc'] = $result;

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();

			$ert['mod'] = $sess_data['user_mod']; 
			$ert['gid'] = $gid;$ert['code']=$code;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Settings";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/user_accounting_setting',$data);
			$this->load->view('home/search_modal');			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_accounting_setting($code,$tid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$yr_start = $this->input->post('year_start');
			$yr_end = $this->input->post('year_end');
			$yr_code = $this->input->post('year_code');

			if ($tid == 0) {
				$data = array(
					'iua_customer_id' => $oid ,
					'iua_start_date' => $yr_start,
					'iua_end_date' => $yr_end,
					'iua_year_code' => $yr_code );
				$this->db->insert('i_u_accounting', $data);
			}else{
				$data = array(
					'iua_start_date' => $yr_start,
					'iua_end_date' => $yr_end,
					'iua_year_code' => $yr_code);
				$this->db->where(array('iua_customer_id' => $oid,'iua_id' => $tid));
				$this->db->update('i_u_accounting',$data);
			}

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
			$result = $query->result();
			$data['edit_acc'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function status_accounting_setting($code,$tid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$yr_start = $this->input->post('year_start');
			$yr_end = $this->input->post('year_end');
			$yr_code = $this->input->post('year_code');

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
			$result = $query->result();
			for ($i=0; $i < count($result) ; $i++) { 
				$aid = $result[$i]->iua_id;
				$status = 'false';
				if ($aid == $tid) {
					$status = 'true';
				}
				$data = array('iua_status' => $status);
				$this->db->where(array('iua_customer_id' => $oid,'iua_id' => $aid));
				$this->db->update('i_u_accounting',$data);
			}

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
			$result = $query->result();
			$data['edit_acc'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_accounting_setting($code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->WHERE(array('iua_customer_id' => $oid, 'iua_id' => $tid));
			$this->db->delete('i_u_accounting');

			$query = $this->db->query("SELECT * FROM i_u_accounting WHERE iua_customer_id = '$oid' ");
			$result = $query->result();
			$data['edit_acc'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

########## DATA EXPORT #####################
  //   public function data_export() {
  //       $sess_data = $this->session->userdata();
		// if($sess_data['user_details'][0]){
		// 	$oid = $sess_data['user_details'][0]->i_uid;
		// 	$data['oid'] = $sess_data['user_details'][0]->i_owner;
		// 	$module = $sess_data['user_mod'];

		// 	if (count($module) > 0) {
		// 		if($module[0]->domain) {
		// 			$data['dom'] = "[".$module[0]->domain."]";
		// 		} else {
		// 			$data['dom'] = "[]";
		// 		}
		// 	} else {
		// 		$data['dom'] = "[]";
		// 	}
  //           //$data = [];
            
		// 	$ert['mod'] = $sess_data['user_mod'];
		// 	$ert['name'] = $sess_data['user_details'][0]->iud_name;
		// 	$ert['title'] = "Data Export";
		// 	$ert['search'] = "false";

		// 	$this->load->view('navbar', $ert);
		// 	$this->load->view('account/data_export', $data);
		// 	$this->load->view('home/search_modal');			
		// } else {
		// 	redirect(base_url().'Account/login');
		// }
  //   }
    
  //   public function download_files() {
  //       $mods = $this->input->post("mods");
        
  //       // for($i=0;$i < count($mods); $i++) {
            
  //           $query = $this->db->query("SELECT * FROM i_customers");
  //           $array = $query->result();
  //           $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
  //           echo $this->array2csv($array);
  //           die();            
  //       // }
  //   }
  //   function array2csv(array &$array) {
  //       if (count($array) == 0) {
  //        return null;
  //       }
  //       ob_start();
  //       $df = fopen("php://output", 'w');
  //       fputcsv($df, array_keys(reset($array)));
  //       foreach ($array as $row) {
  //         fputcsv($df, $row);
  //       }
  //       fclose($df);
  //       return ob_get_clean();
  //   }
    
  //   function download_send_headers($filename) {
  //       // disable caching
  //       $now = gmdate("D, d M Y H:i:s");
  //       header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
  //       header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
  //       header("Last-Modified: {$now} GMT");
    
  //       // force download  
  //       header("Content-Type: application/force-download");
  //       header("Content-Type: application/octet-stream");
  //       header("Content-Type: application/download");
    
  //       // disposition / encoding on response body
  //       header("Content-Disposition: attachment;filename={$filename}");
  //       header("Content-Transfer-Encoding: binary");
  //   }

########## Modules settings ################
	// 	public function module_setting($code) {
	// 		$sess_data = $this->log_code->get_session_value($code,true);
	// 		if($sess_data['session'] == 'true') {
	// 			$uid = $sess_data['user_details'][0]->i_uid;
	// 			$oid = $sess_data['user_details'][0]->i_owner;
	// 			$gid = $sess_data['gid'];
	// 			$data['uid'] = $uid;
	// 			$data['oid'] = $oid;
	// 			$data['gid'] = $gid;

	// 			$module = $sess_data['user_mod'];
	// 			if (count($module) > 0) {
	// 				if($module[0]->domain) {
	// 					$data['dom'] = "[".$module[0]->domain."]";
	// 				} else {
	// 					$data['dom'] = "[]";
	// 				}
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}			
				
	// 			$data['module'] = $sess_data['user_mod'];
	// 			$tmp = [];
	// 			for ($i=0; $i < count($data['module']); $i++) { 
	// 				array_push($tmp, $data['module'][$i]->mid);
	// 			}
	// 			$tmpstr = implode(',', $tmp);

	// 		$query = $this->db->query("SELECT * from i_user_template AS a LEFT JOIN i_template AS b ON a.iut_tempid=b.itemp_id WHERE a.iut_owner='$oid' AND b.itemp_module IN ($tmpstr)");
	// 		$data['template'] = $query->result();

	// 		$query = $this->db->query("SELECT * FROM i_template AS a LEFT JOIN i_modules AS b ON a.itemp_module=b.im_id WHERE a.itemp_module IN ($tmpstr) GROUP BY a.itemp_module");
	// 		$data['mod_temp'] = $query->result();

	// 		$ert['mod'] = $sess_data['user_mod']; 
	// 		$ert['user_connection'] = $sess_data['user_connection']; 
	// 		$ert['name'] = $sess_data['user_details'][0]->iud_name;
	// 		$ert['gid'] = $gid;
	// 		$ert['code'] = $code;
	// 		$ert['title'] = "Settings";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('account/module_setting', $data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }
 //    public function template_list($mod_id) {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){
	// 		$oid = $sess_data['user_details'][0]->i_uid;
			
	// 		$module = $sess_data['user_mod'];

	// 		if (count($module) > 0) {
	// 			if($module[0]->domain) {
	// 				$data['dom'] = "[".$module[0]->domain."]";
	// 			} else {
	// 				$data['dom'] = "[]";
	// 			}
	// 		} else {
	// 			$data['dom'] = "[]";
	// 		}
	// 		$did = $mod_id;
	// 		$data = [];
	// 		$data['oid'] = $oid;
			
	// 		$query = $this->db->query("SELECT * from i_template WHERE itemp_module in (SELECT im_id from i_modules WHERE im_id='$did');");
	// 		$result = $query->result();
	// 		$data['template'] = $result;
			
	// 		$tmp = [];
	// 		for ($i=0; $i < count($result); $i++) { 
	// 			array_push($tmp, $result[$i]->itemp_id);
	// 		}
	// 		$tmpstr = implode(',', $tmp);
	// 		$query = $this->db->query("SELECT * FROM i_u_t_copies WHERE iutc_owner='$oid' AND iutc_temp_id IN ($tmpstr)");
	// 		if(count($query->result())) {
	// 			$data['selected_template'] = $query->result();	
	// 		}

	// 		$data['mod_id'] = $mod_id;
	// 		$ert['mod'] = $sess_data['user_mod']; 
	// 		$ert['name'] = $sess_data['user_details'][0]->iud_name;
	// 		$ert['title'] = "Settings";
	// 		$ert['search'] = "false";

	// 		$this->load->view('navbar', $ert);
	// 		$this->load->view('template/t_view',$data);
	// 		$this->load->view('home/search_modal');
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

	// public function change_template($mod_id) {
	// 	$sess_data = $this->session->userdata();
	// 	if($sess_data['user_details'][0]){
	// 		$oid = $sess_data['user_details'][0]->i_uid;
	// 		$temp_id=$this->input->post('id');
	// 		$temp_array =$this->input->post('arr');

	// 		$this->db->where(array('iut_owner' => $oid, 'iut_mid' => $mod_id));
	// 		$this->db->delete('i_user_template');

	// 		$this->db->insert('i_user_template', array('iut_owner' => $oid, 'iut_mid' => $mod_id, 'iut_tempid' => $temp_id));

	// 		$this->db->where(array('iutc_owner' => $oid, 'iutc_mod_id' => $mod_id));
	// 		$this->db->delete('i_u_t_copies');

	// 		for ($i=0; $i <count($temp_array) ; $i++) { 
	// 			$this->db->insert('i_u_t_copies', array('iutc_owner' => $oid, 'iutc_temp_id' => $temp_id, 'iutc_mod_id' => $mod_id ,'iutc_copies' => $temp_array[$i] ));
	// 		}
	// 		echo "true";
	// 	} else {
	// 		redirect(base_url().'Account/login');
	// 	}
	// }

########## Email settings ##################

	public function email_setting($code,$type=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;

			$data['type'] = $type;

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

			$query = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid = '$uid' ");
			$result = $query->result();
			if (count($result) > 0) {
				$data['u_mail'] = $result;
			}

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
			$data['use_modules'] = $query->result();

			$ert['oid'] = $oid;$ert['gid'] = $gid;$ert['code']=$code;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Settings";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/email_setting',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function email_save($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

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

			$dom_name=$this->input->post('dom_name');
			$dom_email=$this->input->post('dom_email');
			$dom_pass=$this->input->post('dom_pass');
			$port_no=$this->input->post('port_no');

			$this->db->WHERE('iumail_uid',$oid);
			$this->db->DELETE('i_u_mail');

			$data = array(
				'iumail_uid' => $oid,
				'iumail_owner' => $oid,
				'iumail_domain' => $dom_name,
				'iumail_mail' => $dom_email,
				'iumail_password' => $dom_pass,
				'iumail_port' => $port_no
			);
			$this->db->insert('i_u_mail', $data);
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}	

########## Invite User #####################

	public function invite_setting($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
 			$data['oid'] = $oid;
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

			$query=$this->db->query("SELECT ium_m_id as mid , count(ium_m_id) as mid_limit from i_u_modules WHERE ium_created_by = '$oid' GROUP BY ium_m_id ");
			$data['modules_limit']=$query->result();
			$dt = date('Y-m-d');
			if ($gid == 0) {
				$data['create_group'] = "true";
				$data['admin'] = "true";
				$query=$this->db->query("SELECT im_id as mid, im_name as mname, ium_user_limit as m_limit , ium_module_alias as m_alias FROM i_modules as a left join i_u_modules as b on a.im_id=b.ium_m_id WHERE ium_u_id = '$oid' AND ium_status = 'active' AND ium_gid = '0' group BY ium_m_id");
				$data['modules']=$query->result();

				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid'");
				$result = $query->result();
				$data['user_con'] = $result;

			}else{
				if ($uid == $oid) {
					$data['admin'] = "true";
					$data['create_group'] = "true";
					$query=$this->db->query("SELECT im_id as mid, im_name as mname , ium_user_limit as m_limit , ium_module_alias as m_alias FROM i_modules as a left join i_u_modules as b on a.im_id=b.ium_m_id WHERE ium_u_id = '$oid' AND ium_status = 'active' AND ium_gid = '0' group BY ium_m_id");
					$data['modules']=$query->result();

					$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid'");
					$result = $query->result();
					$data['user_con'] = $result;

				}else{
					$data['create_group'] = "false";
					$query=$this->db->query("SELECT im_id as mid, im_name as mname , ium_user_limit as m_limit , ium_module_alias as m_alias FROM i_modules as a left join i_u_modules as b on a.im_id=b.ium_m_id WHERE ium_status = 'active' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_u_id = '$uid' group BY ium_m_id");
					$data['modules']=$query->result();

					$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' AND iug_id IN(SELECT ium_gid FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_created_by = '$oid')");
					$result = $query->result();
					$data['user_con'] = $result;
				}
			}
			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
			$result = $query->result();
			$data['g_limit'] = $result[0]->i_g_limit;

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' ");
			$result = $query->result();
			$data['g_created'] = count($result);

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
	        $result = $query->result();
	        $data['user_list'] = $result;

			$data['uname'] = $sess_data['user_details'][0]->i_uname;
			$data['umail'] = $sess_data['user_details'][0]->iud_email;
			$data['ucont'] = $sess_data['user_details'][0]->iud_phone;
			$data['uadd'] = $sess_data['user_details'][0]->iud_address;
			$data['p_key'] = $this->config->item('p_key');

			$ert['mod'] = $sess_data['user_mod'];
			$ert['gid'] = $gid;
			$ert['mid'] = 0;
			$ert['code'] = $code;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Settings";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/invite_setting',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_edit($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $this->input->post('id');
			
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$oid'");
			$result = $query->result();
			$p_id = $result[0]->ip_id;
			
			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$gid'");
			$data['g_name'] = $query->result();

			$query=$this->db->query("SELECT * from i_u_modules WHERE ium_u_id = '$oid' AND ium_status = 'active' AND ium_gid = '0'");
			$data['modules_limit']=$query->result();

			if ($uid == $oid) {
				$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$oid' LEFT join i_c_basic_details as d on d.icbd_customer_id=c.ic_id or d.icbd_value=a.ium_u_id WHERE a.ium_gid='$gid' AND d.icbd_property = '$p_id'");
				$result = $query->result();
				$data['user_list'] = $result;

				$query=$this->db->query("SELECT im_id as mid, im_name as mname FROM i_modules as a left join i_u_modules as b on a.im_id=b.ium_m_id WHERE ium_u_id = '$oid' group BY ium_m_id ");
				$data['modules']=$query->result();

				$data['create_group'] = 'true';
			}else{
				$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$oid' LEFT join i_c_basic_details as d on d.icbd_customer_id=c.ic_id WHERE a.ium_gid='$gid' AND d.icbd_property = '$p_id' AND a.ium_admin = 'true'");
				$result = $query->result();
				$data['user_list'] = $result;

				$query=$this->db->query("SELECT im_id as mid, im_name as mname FROM i_modules as a left join i_u_modules as b on a.im_id=b.ium_m_id WHERE ium_status = 'active' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_u_id = '$uid' group BY ium_m_id");
				$data['modules']=$query->result();

				$data['create_group'] = 'false';
			}
			
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_exit($code,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_id ='$gid' AND iug_owner = $oid");
			$result = $query->result();
			$mid = $result[0]->iug_m_group;

			$this->db->WHERE(array('ium_gid' => $gid,'ium_u_id' => $uid, 'ium_created_by' => $oid));
			$this->db->delete('i_u_modules');

			$this->db->WHERE(array('imm_c_id'=>$uid , 'imm_owner'=>$oid, 'imm_m_id' => $mid));
			$this->db->delete('i_m_members');

			redirect(base_url().'Account/switch_account/'.$code.'/0');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_delete($code,$gid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_id ='$gid' AND iug_owner = $oid");
			$result = $query->result();
			$mid = $result[0]->iug_m_group;

			$this->db->WHERE(array('iug_id' => $gid,'iug_owner' => $oid));
			$this->db->delete('i_user_group');

			$this->db->WHERE(array('ium_gid' => $gid,'ium_created_by' => $oid));
			$this->db->delete('i_u_modules');

			$this->db->WHERE(array('ime_id' => $mid, 'ime_owner'=>$oid));
			$this->db->update('i_messaging',array('ime_status'=> 'false'));

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function purchase_user_payment($code,$uno,$mid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_m_id = '$mid' AND ium_created_by = '0' AND ium_status = 'active' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$dt = date('Y-m-d');
				$end_date = $result[0]->ium_subscription_end;
				$date1=date_create($dt);
				$date2=date_create($end_date);
				$diff=date_diff($date1,$date2);
				$year = intval($diff->format('%y')) * 12;
				$month = $diff->format('%m');
				$days = $diff->format('%d');
				if ($days > 0 ) {
					$days = 1;
				}
				$t_month = intval($year) + intval($month) + intval($days);				
			}else{
				$t_month = 0 ;
			}

			$query = $this->db->query("SELECT * FROM i_users_cart WHERE iuc_uid = '$uid'");
			$result = $query->result();
			if (count($result) > 0) {
				$inid = $result[0]->iuc_id;
			}else{
				$data = array(
					'iuc_uid' => $uid,
					'iuc_group' => 0,
					'iuc_storage' => 0
				);
				$this->db->insert('i_users_cart',$data);
				$inid = $this->db->insert_id();
			}
			$data = array(
				'iucm_iuc_id' => $inid,
				'iucm_mid' => $mid,
				'iucm_users' => $uno,
				'iucm_status' => 'add_on',
				'iucm_sub_month' => $t_month
			);
			$this->db->insert('i_users_cart_modules',$data);

			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_invite_send($code,$g){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$u = $this->input->post('users');
			$g_name = $this->input->post('gname');
			$a = '';$m_group='';$m_id = '';
			$dt = date('Y-m-d H:i:s');
			$inv_group = $this->input->post('inv_group');
			$users = $this->input->post('users');
			$group = $this->input->post('group');
			$mod['mod'] = [];

			$query1 = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$g'");
			$result1 = $query1->result();
			$m_id = $result1[0]->iug_m_group;
			
			if($group == 'false'){
				$m_group = 'false';
			}else{
				$m_group = 'true';
			}

			$this->db->WHERE('iug_id',$g);
			$this->db->update('i_user_group',array('iug_name' => $g_name));

			$this->db->WHERE('ime_id',$m_id);
			$this->db->update('i_messaging',array('ime_status' => $m_group));

			$query1 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_owner = '$oid'");
			$result1 = $query1->result();

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_uid IN (SELECT ium_u_id FROM i_u_modules WHERE ium_gid = '$g')");
			$result = $query->result();

			$this->db->WHERE(array('ium_gid' => $g));
			$this->db->delete('i_u_modules');

			$query1 = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$g'");
			$result1 = $query1->result();

			$this->db->WHERE(array('imm_m_id' => $result1[0]->iug_m_group));
			$this->db->delete('i_m_members');

			for ($i=0; $i <count($u) ; $i++) {
				$cid = $u[$i]['id'];
				$query = $this->db->query("SELECT * FROM i_property WHERE ip_property LIKE '%email%' AND ip_owner = '$oid'");
				$result = $query->result();
				$pid = $result[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$pid' ");
				$result = $query->result();
				$email = $result[0]->icbd_value;

				$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
				$result = $query->result();
				if(count($result) > 0){
					$cid = $result[0]->i_uid;
					$c_status = 'true';
				}else{
					$cid = $email;
					$c_status = 'false';
				}
				$modid = $u[$i]['mid'];

				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_m_id = '$modid' and ium_u_id = '$oid' ");
				$result = $query->result();
				$alias = $result[0]->ium_module_alias;
				$data1 = array(
					'ium_u_id' => $cid,
					'ium_m_id'=> $modid,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => $oid,
					'ium_insert_id' => 0,
					'ium_gid' => $g,
					'ium_admin' => $u[$i]['admin'],
					'ium_reg_status' => $c_status,
					'ium_user_limit' => 0,
					'ium_module_alias' => $alias
				);
				$this->db->insert('i_u_modules',$data1);
			}

			for ($i=0; $i < count($u); $i++) {
				if ($u[$i]['flg']=='new') {
					$mid = $u[$i]['mid'];
					$query1 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_owner = '$oid'");
					$result1 = $query1->result();
					
					$data = $this->db->query("SELECT * FROM i_users WHERE i_uname ='".$u[$i]['email']."'");
					$result2 = $data->result();

					$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$oid' ");
					$result3 = $data->result();

					$data = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$mid' ");
					$result4 = $data->result();

					if(count($result2)>0){
						$s_email = "exist";
					}else{
						$s_email = "not";
					}

					$subject = "Evomata - Invitation mail";

					$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3>'.$result3[0]->iud_name.' invite you for '.$result4[0]->im_name.' Module</h3><h3 style="font-weight: normal; ">Please click on the button to accept request.</h3><a href="'.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($u[$i]['id']).'"><button class="btn btn-lg btn-danger pic_button">Accept</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($u[$i]['id']).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

					$temp = $this->Mail->send_mail($subject,$u[$i]['email'],null,$body,$code);
				}
				$a = '';
			}
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_users_list($code,$mid=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');
			$user = $this->input->post('i_users');
			$p_id = '';
			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$oid'");
			$result = $query->result();
			
			if (count($result) > 0) {
				$p_id = $result[0]->ip_id;
			}else{
				$data = array(
					'ip_property' => 'email',
					'ip_owner' =>$oid,
					'ip_section' => 'customer'
				);
				$this->db->insert('i_property',$data);
				$p_id = $this->db->insert_id();
			}

			$query5 = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name ='$user'");
			$result5 = $query5->result();
			if (count($result5) > 0 ) {
				$query1 = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id  LEFT JOIN i_users as c on c.i_uname=b.icbd_value where  ic_owner = '$oid' AND a.ic_name = '$user' AND b.icbd_property = '$p_id' ");
				$result = $query1->result();
				$data['c_details'] = $result;
			}else{
				$data = array(
					'ic_name' => $user, 
					'ic_owner' => $oid,
					'ic_created' => $dt,
					'ic_created_by' => $uid,
					'ic_section' => 'customer'
				);
				$this->db->insert('i_customers', $data);
				$cid = $this->db->insert_id();
				$query1 = $this->db->query("SELECT * FROM i_customers   where ic_owner = '$oid' AND ic_id = '$cid' ");
				$result = $query1->result();
				$data['c_details'] = $result;
			}
			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_email_add($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$s_email = $this->input->post('cust_email');
			$s_id = $this->input->post('cust_id');

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$oid'");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			$query = $this->db->query("SELECT * from i_users where i_uname = '$s_email'");
			$result = $query->result();
			if (count($result)>0) {
				$data = array(
					'ic_uid' => $result[0]->i_uid
				);
				$this->db->where('ic_id',$s_id);
				$this->db->update('i_customers',$data);
				$data['status'] = 'register';
			}else{
				$data['status'] = 'not_register';
			}
			
			$data = array(
				'icbd_customer_id' => $s_id,
				'icbd_property' => $p_id,
				'icbd_value' =>$s_email
			);
			$this->db->insert('i_c_basic_details',$data);

			$query1 = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b on a.ic_id=b.icbd_customer_id where ic_id = '$s_id' AND ic_owner = '$oid' AND icbd_property = '$p_id'");
			$result = $query1->result();
			$data['c_details'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_user_delete($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$module_id = $this->input->post('mid');
			$user_id = $this->input->post('uid');
			$group_id = $this->input->post('gid');

			$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id ='$oid'");
			$result3 = $data->result();

			$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE icbd_value = '$user_id' AND ic_owner = '$oid'");
			$result = $query->result();
			$uid = $result[0]->ic_uid;
			if ($uid == '') {
				$uid = $result[0]->icbd_value;
				$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_email ='$uid'");
				$result2 = $data->result();
			}else{
				$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id ='$uid'");
				$result2 = $data->result();
			}
			$user_id = $result2[0]->iud_u_id;

			$this->db->WHERE(array('ium_u_id'=> $user_id,'ium_m_id'=>$module_id, 'ium_gid' => $group_id));
			$this->db->delete('i_u_modules');

			$query1 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_owner = '$oid'");
			$result1 = $query1->result();

			$data = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$module_id' ");
			$result4 = $data->result();

			$data = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$group_id' ");
			$result5 = $data->result();

			$subject = "Remove from group";

			$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><h3> Dear '.$result2[0]->iud_name.',</h3><h4>'.$result3[0]->iud_name.' remove you from '.$result5[0]->iug_name.' Group for '.$result4[0]->im_name.' module.</h4><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

			$temp = $this->Mail->send_mail($subject,$result2[0]->iud_email,null,$body,$code);
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function invite_user_admin($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$module_id = $this->input->post('mid');
			$user_id = $this->input->post('uid');
			$group_id = $this->input->post('gid');
			$status = $this->input->post('status');

			$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id ='$oid'");
			$result3 = $data->result();

			$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id WHERE icbd_value = '$user_id' AND ic_owner = '$oid'");
			$result = $query->result();
			$uid = $result[0]->ic_uid;
			if ($uid == '') {
				$uid = $result[0]->icbd_value;
				$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_email ='$uid'");
				$result2 = $data->result();
			}else{
				$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id ='$uid'");
				$result2 = $data->result();
			}
			$user_id = $result2[0]->iud_u_id;

			$data = array('ium_admin'=>$status);
			$this->db->WHERE(array('ium_u_id'=> $user_id,'ium_m_id'=>$module_id, 'ium_gid' => $group_id));
			$this->db->update('i_u_modules',$data);

			$query1 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_owner = '$oid'");
			$result1 = $query1->result();

			$data = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$module_id' ");
			$result4 = $data->result();

			$data = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$group_id' ");
			$result5 = $data->result();

			$subject = "Admin for module";

			$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;">';
			if ($status == 'true') {
				$body .= '<h3> Dear '.$result2[0]->iud_name.',</h3><h4>'.$result3[0]->iud_name.' make you admin in '.$result5[0]->iug_name.' group for '.$result4[0]->im_name.' module.</h4>';
			}else{
				$body .= '<h3> Dear '.$result2[0]->iud_name.',</h3><h4>'.$result3[0]->iud_name.' remove you as a admin in '.$result5[0]->iug_name.' group for '.$result4[0]->im_name.' module.</h4>';
			}
			$body .= '<p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

			$temp = $this->Mail->send_mail($subject,$result2[0]->iud_email,null,$body,$code);
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function group_invite_send($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid']=$oid;
			$cid = '';
			$dt = date('Y-m-d H:i:s');
			$inv_group = $this->input->post('inv_group');
			$users = $this->input->post('users');
			$group = $this->input->post('group');
			$mod['mod'] = [];
			
			$data = array(
				'iug_name' => $inv_group,
				'iug_created_by' => $uid,
				'iug_created' =>$dt,
				'iug_owner' => $oid
			);
			$this->db->insert('i_user_group',$data);
			$gid = $this->db->insert_id();
			$c_status = '';
			for ($i=0; $i <count($users) ; $i++) {
				$cid = $users[$i]['id'];
				$query = $this->db->query("SELECT * FROM i_property WHERE ip_property LIKE '%email%' AND ip_owner = '$oid'");
				$result = $query->result();
				$pid = $result[0]->ip_id;

				$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cid' AND icbd_property = '$pid' ");
				$result = $query->result();
				$email = $result[0]->icbd_value;

				$query = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email'");
				$result = $query->result();
				if(count($result) > 0){
					$cid = $result[0]->i_uid;
					$c_status = 'true';
				}else{
					$cid = $email;
					$c_status = 'false';
				}
				$modid = $users[$i]['mid'];
				
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_m_id = '$modid' and ium_u_id = '$oid' ");
				$result = $query->result();
				$alias = $result[0]->ium_module_alias;

				$data1 = array(
					'ium_u_id' => $cid,
					'ium_m_id'=> $modid,
					'ium_status' => 'active',
					'ium_created' => $dt,
					'ium_created_by' => $oid,
					'ium_insert_id' => 0,
					'ium_gid' => $gid,
					'ium_admin' => $users[$i]['admin'],
					'ium_reg_status' => $c_status,
					'ium_user_limit' => 0,
					'ium_module_alias' => $alias
				);
				$this->db->insert('i_u_modules',$data1); //insert group users
				array_push($mod['mod'],$users[$i]['mid']);
			}

			if($group == 'true'){

				$dt1=date_create(); $dt_str = date_timestamp_get($dt1);

				$data = array(
					'ime_title' => $inv_group,
					'ime_file' => $dt_str,
					'ime_owner' => $oid,
					'ime_created' => $dt,
					'ime_created_by' => $oid,
					'ime_status' => 'true'
				);
				$this->db->insert('i_messaging',$data);
				$insid = $this->db->insert_id();

				$this->db->WHERE('iug_id',$gid);
				$this->db->update('i_user_group',array('iug_m_group' => $insid));				

				$data = array(
					'imm_c_id' => $oid,
					'imm_m_id' => $insid,
					'imm_owner' => $oid
				);
				$this->db->insert('i_m_members', $data);
				
				for ($i=0; $i <count($users) ; $i++) { 
					$uid = $users[$i]['id'];
					$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id = '$uid'");
					$result = $query->result();

					if (count($result)>0) {
						if ( $result[0]->ic_uid == '' || $result[0]->ic_uid == 'null') {
							$cid = $result[0]->ic_id;
						}else{
							$cid = $result[0]->ic_uid;
						}
					}else{
						$cid = $uid;
					}

					$data = array(
						'imm_c_id' => $cid,
						'imm_m_id' => $insid,
						'imm_owner' => $oid
					);
					$this->db->insert('i_m_members', $data);
				}

				$jarr = [];
				array_push($jarr, array('mid' => $insid, 'title' => $inv_group, 'data' => array('type' => $oid,'attachment'=>"null" ,'message' => 'Group created', 'date' => $dt)));
				$jstr = json_encode($jarr);

				$upload_dir = $this->config->item('document_rt')."assets/data/msg/";

				if(!file_exists($upload_dir) || !file_exists($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}

				if (is_dir($upload_dir) && is_writable($upload_dir)) {
					$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
					fwrite($handle, $jstr);
				}
				fclose($handle);
				
			}else{

				$this->db->WHERE('iug_id',$gid);
				$this->db->update('i_user_group',array('iug_m_group' => 0));	
			}

			$query1 = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_owner = '$oid'");
			$result1 = $query1->result();

			for ($j=0; $j <count($users) ; $j++) {
				$mid = $users[$j]['mid'];
				$data = $this->db->query("SELECT * FROM i_users WHERE i_uname ='".$users[$j]['email']."'");
				$result2 = $data->result();

				$data = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$oid' ");
				$result3 = $data->result();

				$data = $this->db->query("SELECT * FROM i_modules WHERE im_id = '$mid' ");
				$result4 = $data->result();

				if(count($result2)>0){
					$s_email = "exist";
				}else{
					$s_email = "not";
				}

				$subject = "Evomata - Invitation mail";

				$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3>'.$result3[0]->iud_name.' invite you for '.$result4[0]->im_name.' Module</h3><h3 style="font-weight: normal; ">Please click on the button to accept request.</h3><a href="'.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($users[$j]['id']).'"><button class="btn btn-lg btn-danger pic_button">Accept</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/invite_registre/'.urlencode($oid).'/'.urlencode($s_email).'/'.urlencode($users[$j]['id']).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

				$temp = $this->Mail->send_mail($subject,$users[$j]['email'],null,$body,$code);
			}
			echo "true";
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function invite_registre($e_oid,$status,$cust_id){
		if ($status=="exist") {
			$query = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id = '$cust_id' AND ic_owner = '$e_oid' ");
			$result = $query->result();
			$email_id = $result[0]->icbd_value;
			$dt = date('Y-m-d H:i:s');

			$data1 = $this->db->query("SELECT * FROM i_users WHERE i_uname = '$email_id'");
			$result1 = $data1->result();
			$uid = $result1[0]->i_uid;
			$uname = $result1[0]->i_uname;
			$upass = $result1[0]->i_upassword;

			$data = array(
				'ic_uid' => $uid
			);
			$this->db->WHERE(array('ic_id' => $cust_id, 'ic_owner' => $e_oid));
			$this->db->update('i_customers',$data);

			$data2 = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$e_oid'");
			$result2 = $data2->result();

			$data = $this->db->query("SELECT * from i_property WHERE ip_owner = '$uid'");
			$result = $data->result();

			if(count($result) <= 0 ){
				$data1 = array(
					'ip_property' => 'email',
					'ip_owner' => $uid,
					'ip_section' =>'customer'
				);
				$this->db->insert('i_property',$data1);
				$pid = $this->db->insert_id();
			}

			$data1 = array(
				'ic_name' => $result2[0]->iud_name,
				'ic_owner' => $uid,
				'ic_created' => $dt,
				'ic_created_by' => $result1[0]->i_uid,
				'ic_section' => 'customer',
				'ic_uid' => $e_oid
			);
			$this->db->insert('i_customers',$data1);
			$insert_id = $this->db->insert_id();

			$data2 = array(
				'icbd_customer_id' => $insert_id,
				'icbd_property' => $pid,
				'icbd_value' => $email_id
			);
			$this->db->insert('i_c_basic_details',$data2);

			$data3 = array(
					'imm_c_id' => $uid
				);
			$this->db->WHERE(array('imm_owner' => $e_oid, 'imm_c_id' =>$cust_id));
			$this->db->update('i_m_members',$data3);
			$code = 0;
			$a = $this->log_code->login_verify($uname, $upass);
			if ($a['session'] == 'true') {
				$code = $a['code'];
			}

			redirect(base_url().'Home/index/'.$code);
			 
		}else if($status=="not"){
			$data['status'] = $status;
			$data['e_oid'] = $e_oid;
			$data['cust_id'] = $cust_id;
			$data['mode'] ='user';
			$this->load->view('account/login', $data);
		}
	}

	public function invite_reg_user($e_oid,$status,$cust_id){
		$dt = date('Y-m-d H:i:s');
		$flag=0;
		$u_mail=$this->input->post('email');
		$u_phone=$this->input->post('phone');
		$status = '';
		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_email = '$u_mail' AND iud_phone='$u_phone'");
		$result = $query->result();
		if (count($result) > 0) {
			echo "email_phone";
		} else {
			$query1 = $this->db->query("SELECT * FROM i_u_details WHERE iud_phone='$u_phone'");
			$result1 = $query1->result();
			if (count($result1) > 0) {
				echo "phone";
			} else {
				$query2 = $this->db->query("SELECT * FROM i_u_details WHERE iud_email='$u_mail'");
				$result2 = $query2->result();
				if (count($result2) > 0) {
					echo "email";
				} else {
					$data = array(
						'i_uname' => $this->input->post('email'),
						'i_status' => 'verify',
						'i_created' => $dt,
						'i_storage' => '1000',
						'i_g_limit' => '0',
						'i_view' => 'false');
					$this->db->insert('i_users', $data);
					$id = $this->db->insert_id();
					
					$data = array(
						'i_owner' => $id,'i_created_by' => $id
						);
					$this->db->where('i_uid', $id);
					$this->db->update('i_users', $data);
					
					$data1 = array(
						'iud_u_id' => $id,
						'iud_name' => $this->input->post('name'),
						'iud_company' => $this->input->post('company'),
						'iud_email' => $this->input->post('email'),
						'iud_phone' => $this->input->post('phone'),
						'iud_address' => $this->input->post('address'),
						'iud_gst' => $this->input->post('gst')
					);
					$this->db->insert('i_u_details', $data1); // user registration

					$data = array(
						'ium_u_id' => $id,
						'ium_m_id' => 33,
						'ium_status' => 'active',
						'ium_created' => $dt,
						'ium_created_by' => 0
					);
					$this->db->insert('i_u_modules', $data);
					
					$data = array(
						'ium_u_id' => $id,
						'ium_m_id' => 38,
						'ium_status' => 'active',
						'ium_created' => $dt,
						'ium_created_by' => 0
					);
					$this->db->insert('i_u_modules', $data);

					$data = array(
						'ium_u_id' => $id,
						'ium_m_id' => 34,
						'ium_status' => 'active',
						'ium_created' => $dt,
						'ium_created_by' => 0
					);
					$this->db->insert('i_u_modules', $data);

					$data = array(
						'ium_u_id' => $id,
						'ium_reg_status' => 'true'
					);
					$this->db->WHERE(array('ium_u_id' => $this->input->post('email'),'ium_reg_status' => 'false'));
					$this->db->update('i_u_modules',$data);
					
					$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_basic_details as b ON a.ic_id = b.icbd_customer_id WHERE a.ic_id = '$cust_id'");
					$result = $query->result();

					$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$e_oid'");
					$result = $query->result();
					$p_id = $result[0]->ip_id;
					
					$query = $this->db->query("SELECT * FROM i_users as a LEFT JOIN i_u_details as b ON a.i_uid=b.iud_u_id WHERE i_uid='$e_oid'");
					$result2 = $query->result();
					
					$data4 = array(
						'ic_name' => $result2[0]->iud_name,
						'ic_owner' =>$id,
						'ic_created' =>$dt,
						'ic_created_by' =>$id,
						'ic_section' =>"customer",
						'ic_uid' => $e_oid
					);
					$this->db->insert('i_customers',$data4); //insert owner 
					$cid1 = $this->db->insert_id();
					
					$data5 = array(
						'icbd_customer_id'=>$cid1,
						'icbd_property' =>$p_id,
						'icbd_value' => $result2[0]->i_uname
					);
					$this->db->insert('i_c_basic_details',$data5); //insert owner details

					$data7 = array(
						'ic_uid' => $id
					);
					$this->db->WHERE(array('ic_owner' => $e_oid, 'ic_id' =>$cust_id));
					$this->db->update('i_customers',$data7);

					$data9 = array(
						'imm_c_id' => $id
					);
					$this->db->WHERE(array('imm_owner' => $e_oid, 'imm_c_id' =>$cust_id));
					$this->db->update('i_m_members',$data9);

					echo $id;
				}
			}
		}	
	}

	public function invite_reg_upload($e_oid,$status,$id){
		$sess_data = $this->session->userdata();
		if(!isset($sess_data['user_details'])){
			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$id."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$img_path = "";
			
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
			    
			   //for first file upload
			        $sourcePath = $_FILES[0]['tmp_name']; // Storing source path of the file in a variable
    				$targetPath = $upload_dir.$_FILES[0]['name']; // Target path where file is to be stored
    				// $img_path = $targetPath;
    				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
    				$img_path = $_FILES[0]['name'];
    				
            		$data = array('iud_profile' => $img_path);
					$this->db->where('iud_id',$in_id);
					$this->db->update('i_u_details', $data);
				//for second file upload
					$sourcePath = $_FILES[1]['tmp_name']; // Storing source path of the file in a variable
    				$targetPath = $upload_dir.$_FILES[1]['name']; // Target path where file is to be stored
    				// $img_path = $targetPath;
    				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file		
    				$img_path = $_FILES[1]['name'];
    				
            		$data = array('iud_logo' => $img_path);
					$this->db->where('iud_id',$in_id);
					$this->db->update('i_u_details', $data);
			    
			}
			echo $this->invite_reg_email($oid,$status,$id);
		}else{
			redirect(base_url().'Home');
		}	
	}

	public function invite_reg_email($e_oid,$status,$id){
		$data = $this->db->query("SELECT * FROM i_users WHERE i_uid='$id'");
		$result = $data->result();
		$email1 = $result[0]->i_uname;
		$subject = "Evomata - Verify your Account";

		$body = '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css">body{background-color: #fff;padding: 20px;margin: 20px;}@media only screen and (min-width: 320px) and (max-width: 767px) {body {margin: 30px;padding: 20px;}}@media only screen and (min-width: 768px) and (max-width: 1030px) {body {margin: 60px;padding: 20px;}}html, body, h1, h2, h3, h4, h5, h6, a {font-family: "Muli", sans-serif !important;color: #000;text-align: center;}.pic_button {border-radius: 10px;box-shadow: 0px 4px 10px #ccc;padding: 20px;position: relative;overflow: hidden;width: 50%;background: rgb(244,67,54);color: rgb(255,255,255);font-size: 3em;box-shadow: 0px 6px 10px #ccc;border: 1px;}h3 {font-size: 2em;}</style></head><body><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;"><div style="background-color border-radius: 10px;"><h3 style="font-weight: normal; ">Please click on the button to verify your daifunc account.</h3><a href="'.base_url().'Account/invite_reg_verify/'.urlencode($id).'/'.urlencode($e_oid).'/'.urlencode($status).'"><button class="btn btn-lg btn-danger pic_button">Verify</button></a><br><h4>OR</h4><br><h3 style="font-weight:normal;font-size: 1.2em; word-break: break-all;">Please copy and paste '.base_url().'Account/invite_reg_verify/'.urlencode($id).'/'.urlencode($e_oid).'/'.urlencode($status).' in the browser.</h3></div><p style="font-size: 0.7em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></body></html>';

		$temp = $this->Mail->daifunc_reg_mail($subject,$email1,null,$body);
		echo "true";
		echo $email1;
	}

	public function invite_reg_verify($id,$e_oid,$status){
		$property = '';
		$dt = date('Y-m-d H:i:s');
		$data1 = array(
			'i_status' => 'password update'
		);
		$this->db->where('i_uid', $id);
		$this->db->update('i_users', $data1);

		$query1 = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$id' and ip_property like '%email%'");
		$result1 = $query1->result();
		if(count($result1)>0){
			$property = $result1[0]->ip_id;
		}else{
			$data = array(
				'ip_property' => 'email',
				'ip_owner' => $id,
				'ip_section' => 'customer'
			);
			$this->db->insert('i_property',$data);
			$property = $this->db->insert_id();
		}

		$query = $this->db->query("SELECT * FROM i_u_details WHERE iud_u_id = '$id'");
		$result = $query->result();
		$data = array(
			'ic_name' =>$result[0]->iud_name,
			'ic_owner'=>$result[0]->iud_u_id,
			'ic_created'=>$dt,
			'ic_created_by'=>$result[0]->iud_u_id,
			'ic_section'=>'customer',
			'ic_uid' => $id
		);
		$this->db->insert('i_customers', $data);
		$cust_id = $this->db->insert_id();

		$data2 = array(
			'icbd_customer_id'=>$cust_id,
			'icbd_value'=>$result[0]->iud_email,
			'icbd_property' => $property
		);
		$this->db->insert('i_c_basic_details', $data2);

		$data1 = array(
			'i_ref' => $cust_id
		);
		$this->db->where('i_uid', $id);
		$this->db->update('i_users', $data1);

		redirect(base_url().'Account/invite_reset_password/'.$id.'/'.$e_oid.'/'.$status);
	}

	public function invite_reset_password($id,$e_oid,$status){
		$data['uid'] = $id;
		$data['e_oid'] = $e_oid;
		$data['status'] = $status;
		$this->load->view('account/reset', $data);
	}

	public function invite_reset_update($uid,$e_oid,$status) {
		$id = 0;
		$dt = date('Y-m-d H:i:s');

		$data = array(
			'i_upassword' => $this->input->post('upass'),
			'i_status' => 'true',
			'i_modified' => $dt,
			'i_modified_by' => $id
			);
		$this->db->where('i_uid', $uid);
		$this->db->update('i_users', $data);

		$data1= array('iui_u_id' => $uid);
		$this->db->where('iui_id', $e_oid);
		$this->db->update('i_user_invite', $data1);

		$data2 = array('ium_u_id' => $uid);
		$this->db->WHERE('ium_insert_id',$e_oid);
		$this->db->update('i_u_modules',$data2);

		echo "true";
	}

########## Switch to Invite user ###########

	public function switch_account($code,$gid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('ius_u_id' => $uid, 'ius_s_id' => $code));
			$this->db->update('i_u_session',array('ius_gid' => $gid));
			$dt = date('Y-m-d');

			$query = $this->db->query("SELECT * from i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '0' AND ium_created_by = '0'");
			$result = $query->result();

			for ($i=0; $i <count($result) ; $i++) {
				if (intval($result[$i]->ium_renewal_month) > 0) {
					$e_day = $result[$i]->ium_subscription_end;
					$s_day = intval($result[$i]->ium_renewal_month) * 30;
					$e_t = date('Y-m-d',strtotime('+'.$s_day.' days',strtotime(DATE($e_day))));
					$modid = $result[$i]->ium_m_id;

					$query2 = $this->db->query("SELECT * from i_u_modules WHERE ium_created_by = '$oid' AND ium_m_id = '$modid'");
					$result2 = $query2->result();

					if ($result[$i]->ium_renewal_user >= count($result2)) {
						$data = array(
							'ium_status' => 'active',
							'ium_user_limit'=> $result[$i]->ium_renewal_user,
							'ium_subscription_end' => $e_t,
							'ium_renewal_month' => 0,
							'ium_renewal_user' => 0
						);
						$this->db->WHERE(array('ium_u_id' => $uid,'ium_m_id' => $modid ,'ium_gid' => '0','ium_created_by' => '0'));
						$this->db->update('i_u_modules',$data);
					}
				}
			}
			redirect(base_url().'Home/index/'.$code);
		} else {
			redirect(base_url().'Account/login');
		}
	}

########## File storage details ############

	public function storage_details($code,$mid = 0,$fid = 0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$size = 0;

			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}

			$f = $this->config->item('document_rt').'assets/uploads/'.$uid.'/';
		    $io = popen ( '/usr/bin/du -sk ' . $f, 'r' );
		    $size = fgets ( $io, 4096);
		    $size1 = substr ( $size, 0, strpos ( $size, "\t" ) );
		    pclose ( $io );
		    $data['size'] = $size1;

		    $query = $this->db->query("SELECT i_storage FROM i_users WHERE i_uid = '$uid'");
			$result = $query->result();
			$data['total_storage'] = $result[0]->i_storage;

			if ($mid == 0 && $fid == 0 ) {
				$data['m_list'] = $sess_data['user_mod'];
				$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$uid' AND icd_mid = '$mid' AND icd_id IN (SELECT iuff_doc_id FROM i_users_folder_files WHERE iuff_folder_id = '$fid' ) ");
				$result = $query->result();
				$data['doc'] = $result;

				$query = $this->db->query("SELECT * FROM i_users_folder WHERE iuf_owner = '$uid' AND iuf_p_folder = '0' ");
				$result = $query->result();
				$data['u_folder'] = $result;
			}else{
				$query = $this->db->query("SELECT * FROM i_users_folder WHERE iuf_owner = '$uid' AND iuf_p_folder = '$fid' ");
				$result = $query->result();
				$data['u_folder'] = $result;
				if ($mid == 0 ) {
					$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$uid' AND icd_id IN (SELECT iuff_doc_id FROM i_users_folder_files WHERE iuff_folder_id = '$fid' ) ");
				}else{

					$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$uid' AND icd_mid = '$mid' AND icd_status != 'false' AND icd_id NOT IN (SELECT iuff_doc_id FROM i_users_folder_files WHERE iuff_created_by = '$uid' ) ");
				}
				$result = $query->result();
				$data['doc'] = $result;
			}

			for ($i=0; $i <count($module) ; $i++) { 
				if ($mid == $module[$i]->mid) {
					$mname = $module[$i]->mname;
					break;
				}else{
					$mname = '';
				}
			}
			$data['move_doc'] = $this->session->userdata('doc_id');
			$data['mid'] = $mid;
			$data['fid'] = $fid;
			$data['mname'] = $mname;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['mname'] ='';
			$ert['mid'] = $mid;
			$ert['gid'] = $gid;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $code;
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Storage usage";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/storage_details',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function doc_download($code,$cid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$file = '';

		    $path = $this->config->item('document_rt').'assets/uploads/'.$uid.'/';
	    	$this->load->helper('download');
			force_download($path.$cid, NULL);
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function doc_delete($code,$mid,$fid,$file_id,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

	 		if ($mid == 0) {
	 			$this->db->WHERE(array('iuff_doc_id' => $tid ,'iuff_created_by' => $oid , 'iuff_folder_id' => $fid ));
				$this->db->delete('i_users_folder_files');

				$query = $this->db->query("SELECT * FROM i_users_folder_files WHERE iuff_doc_id = '$tid' ");
				$result = $query->result();
				if (count($result) > 0) {
					$this->db->WHERE(array('icd_owner' => $oid , 'icd_id' => $tid));
		 			$this->db->update('i_c_doc',array('icd_status' => 'true'));
				}else{
					$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$uid'  AND icd_id = '$tid' ");
					$result = $query->result();
					if (count($result) > 0 ) {
						if ($result[0]->icd_status != 'true') {
							$this->db->WHERE(array('icd_owner' => $oid , 'icd_id' => $tid));
		 					$this->db->delete('i_c_doc');
		 					unlink($this->config->item('document_rt').'assets/uploads/'.$oid.'/'.$file_id);
						}
					}
				}
	 		}else{
	 			$query = $this->db->query("SELECT * FROM i_users_folder_files WHERE iuff_doc_id = '$tid' ");
				$result = $query->result();
				if (count($result) > 0) {
					$this->db->WHERE(array('icd_owner' => $oid , 'icd_id' => $tid));
		 			$this->db->update('i_c_doc',array('icd_status' => 'false'));
				}else{
					$this->db->WHERE(array('icd_owner' => $oid , 'icd_id' => $tid));
		 			$this->db->delete('i_c_doc');
		 			unlink($this->config->item('document_rt').'assets/uploads/'.$oid.'/'.$file_id);
				}
	 		}

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function doc_move($code,$mid,$fid,$doc_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$this->db->WHERE(array('icd_id' => $doc_id , 'icd_owner' => $oid ));
			$this->db->update('i_c_doc',array('icd_status' => 'false' ));

			$this->db->WHERE(array('iuff_doc_id' => $doc_id ,'iuff_created_by' => $uid , 'iuff_folder_id' => $fid ));
			$this->db->delete('i_users_folder_files');

			$this->session->set_userdata('doc_id', $doc_id);

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function doc_copy($code,$mid,$fid,$doc_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			
			$this->db->WHERE(array('icd_id' => $doc_id , 'icd_owner' => $oid ));
			$this->db->update('i_c_doc',array('icd_status' => 'true' ));

			// $this->db->WHERE(array('iuff_doc_id' => $doc_id ,'iuff_created_by' => $uid , 'iuff_folder_id' => $fid ));
			// $this->db->delete('i_users_folder_files');

			$this->session->set_userdata('doc_id', $doc_id);

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function doc_paste($code,$mid,$fid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$doc_id = $this->session->userdata('doc_id');
			$dt = date('Y:m:d H:i:s');

			$data = array(
				'iuff_doc_id' => $doc_id,
				'iuff_created' => $dt,
				'iuff_created_by' => $uid,
				'iuff_folder_id' => $fid
			);
			$this->db->insert('i_users_folder_files' ,$data);

			$this->session->set_userdata('doc_id', '');
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}	

	public function add_folder($code,$fid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$f_name = $this->input->post('f_name');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iuf_folder_name' => $f_name,
				'iuf_p_folder' => $fid,
				'iuf_owner' => $oid,
				'iuf_created' => $dt,
				'iuf_created_by' => $uid
			);
			$this->db->insert('i_users_folder',$data);
			$data['add_fid'] = $this->db->insert_id();

			$query = $this->db->query("SELECT * FROM i_users_folder WHERE iuf_owner = '$uid' AND iuf_p_folder = '$fid' ORDER BY iuf_id ASC ");
			$result = $query->result();
			$data['u_folder'] = $result;

			print_r(json_encode($data));

		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function update_folder($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$f_name = $this->input->post('f_name');
			$f_id = $this->input->post('f_id');
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iuf_folder_name' => $f_name,
				'iuf_modify' => $dt,
				'iuf_modified_by' => $uid
			);
			$this->db->WHERE(array('iuf_owner' => $oid , 'iuf_id' => $f_id ));
			$this->db->update('i_users_folder',$data);

			$query = $this->db->query("SELECT * FROM i_users_folder WHERE iuf_owner = '$uid' AND iuf_p_folder = '$fid' ORDER BY iuf_id ASC ");
			$result = $query->result();
			$data['u_folder'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function delete_folder($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$f_id = $this->input->post('f_id');
			$dt = date('Y-m-d H:i:s');

			$this->db->WHERE(array('iuf_owner' => $oid , 'iuf_id' => $f_id ));
			$this->db->delete('i_users_folder');

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

########## Email Template ##############
	public function email_template($code){
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

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$uid' ORDER BY iuetemp_title ASC");
			$result = $query->result();
			$data['e_temp'] = $result;

			$ert['mod'] = $sess_data['user_mod']; 
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['gid'] = $sess_data['gid'];
			$ert['mid'] = 0;
			$ert['code'] = $code;
			$ert['title'] = "Email Template";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/email_template_add',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function email_template_add($code,$temp_id = null){
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
			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;

			if ($temp_id != null) {
				$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$uid' AND iuetemp_id = '$temp_id'");
				$result = $query->result();
				$data['temp_id'] = $result[0]->iuetemp_id;
				$data['temp_title'] = $result[0]->iuetemp_title;
				$upload_dir = $this->config->item('document_rt')."assets/data/".$uid."/email_template/";
				$file_name = $upload_dir.$result[0]->iuetemp_file;
				$data['temp_content'] = file_get_contents($file_name);
				$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner = '$oid' AND icd_cid = '$cid' AND icd_type_id = '$temp_id' AND icd_type = 'temp_attach' ");
				$data['files'] = $query->result();
			}

			$ert['mid'] = 0; 
			$ert['gid'] = $sess_data['gid'];
			$ert['code'] = $code;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['mod'] = $sess_data['user_mod'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Email Template Add";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/email_template',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function email_temp_save($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt1=date_create(); 
			$dt_str = date_timestamp_get($dt1);

			$title=$this->input->post('t_title');
			$t_body=$this->input->post('t_body');
			$doc_arr = $this->input->post('doc_arr');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;
			
			$data = array(
				'iuetemp_title' => $title,
				'iuetemp_owner' => $uid,
				'iuetemp_file' => $dt_str.'.txt' 
			);
			$this->db->insert('i_user_email_template',$data);
			$inid = $this->db->insert_id();

			$upload_dir = $this->config->item('document_rt')."assets/data/".$uid."/email_template/";

			if(!file_exists($upload_dir) || !file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $t_body);
			}
			fclose($handle);

			for ($i=0; $i < count($doc_arr) ; $i++) {
				$doc_id = $doc_arr[$i]['id'];
				if ($doc_arr[$i]['flg'] == 'true' ) {
					$data = array(
						'icd_type_id' => $inid
					);
					$this->db->where(array('icd_owner' => $oid ,'icd_cid' => $cid , 'icd_id' => $doc_id));
					$this->db->update('i_c_doc', $data);
				}
			}

			$this->db->where(array('icd_owner' => $oid , 'icd_cid' => $cid , 'icd_type_id' => '0' ));
			$this->db->delete('i_c_doc');

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function email_temp_update($tid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt1=date_create(); 
			$dt_str = date_timestamp_get($dt1);

			$title=$this->input->post('t_title');
			$t_body=$this->input->post('t_body');
			$doc_arr = $this->input->post('doc_arr');

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;
			
			$this->db->WHERE(array('iuetemp_id' => $tid));
			$this->db->delete('i_user_email_template');

			$data = array(
				'iuetemp_title' => $title,
				'iuetemp_owner' =>$uid,
				'iuetemp_file' => $dt_str.'.txt' 
			);
			$this->db->insert('i_user_email_template',$data);
			$inid = $this->db->insert_id();

			$upload_dir = $this->config->item('document_rt')."assets/data/".$uid."/email_template/";

			if(!file_exists($upload_dir) || !file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.txt', 'w') or die('Error');
				fwrite($handle, $t_body);
			}
			fclose($handle);

			for ($i=0; $i < count($doc_arr) ; $i++) {
				$doc_id = $doc_arr[$i]['id'];
				if ($doc_arr[$i]['flg'] == 'true' ) {
					$data = array(
						'icd_type_id' => $inid
					);
					$this->db->where(array('icd_owner' => $oid ,'icd_cid' => $cid , 'icd_id' => $doc_id));
					$this->db->update('i_c_doc', $data);	
				}else{
					$this->db->where(array('icd_owner' => $oid , 'icd_cid' => $cid , 'icd_id' => $doc_id ));
					$this->db->delete('i_c_doc');
				}
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function delete_email_temp($tid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iuetemp_id' => $tid , 'iuetemp_owner' => $oid));
			$this->db->delete('i_user_email_template');

			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function email_template_attach($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;
			$img_path = "";
			$doc_arr = [];
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
						'icd_type' => 'temp_attach',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => '0',
						'icd_type_id' => '0',
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);
					$doc_id = $this->db->insert_id();
					array_push($doc_arr, $doc_id);
					$timestamp_value = '';
				}
				$img_path = '';
			}
			$doc_ids = implode(',', $doc_arr);
			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_id IN($doc_ids) AND icd_owner = '$oid'");
			$result = $query->result();
			$data['files']=$result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

########## My orders #############
	public function my_orders($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$data['oid'] = $uid;
			$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_uid = '$uid'");
			$data['txn'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid'");
			$result = $query->result();
			$data['credit_amt'] = $result[0]->i_credit_amount;

			$ert['mod'] = $sess_data['user_mod'];
			$ert['code'] = $code;
			$ert['gid'] = $sess_data['gid'];
			$ert['mid'] = 0;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "My orders";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/my_orders',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function order_details($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'group'");
			$data['g_amount'] = $query->result();

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'storage'");
			$data['s_amount'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_uid = '$uid' AND iutxn_id = '$id'");
			$result = $query->result();
			$data['group'] = $result[0]->iutxn_group;
			$data['storage'] = $result[0]->iutxn_storage;
			$data['g_month'] = $result[0]->iutxn_group_month;
			$data['s_month'] = $result[0]->iutxn_storage_month;
			$data['disc_amount'] = $result[0]->iutxn_discount_amount;
			$data['ref_code'] = $result[0]->iutxn_ref_code;

			$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$id'");
			$data['order'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function template_email(){
		$this->load->view('index.html');
		$subject = "Payment Successful";

		$body = '<!DOCTYPE html><html><head><style>.centered {text-align: left;margin-left: 10%;}.centered img {width: 150px;border-radius: 50%;}td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;} h3{font-weight: normal;}</style></head><body><div style="text-align: center;"><img src="https://daifunc.com/assets/images/daifunc_logo.png" style="max-width: 8em;max-height: 8em;padding:20px;"><h1 style="height: 30px;font-weight: bold;">DAIFUNC</h1><h1 style="padding:20px;color: green;">Your payment succesfully done.</h1></div><div><h3>Your payment will be received by 13th oct 2018.</div><div><h3> Payment Details ..</h3><table><tbody><tr><td style="width:30%;">Amount</td><td style="width:70%;">'.$amount.'</td></tr><tr><td style="width:30%;">Payment ID </td><td style="width:70%;">'.$id.'</td></tr><tr><td style="width:30%;">Module</td><td style="width:70%;">'.$pid.'</td></tr><tr><td style="width:30%;">Group</td><td style="width:70%;">'.$group.'</td></tr><tr><td style="width:30%;">Storage</td><td style="width:70%;">'.$storage.'</td></tr></tbody></table><br><h3>Thank you for connecting with DAIFUNC .</h3></div><div style="text-align: center;"><p style="font-size: 0.8em;">© Copyright 2018 Evomata Innovations (OPC) Pvt. Ltd. - All Rights Reserved.</p></div></body></html>';
		try {
			$config = array();
	        $config['useragent'] = "CodeIgniter";
	        $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	        $config['protocol'] = "smtp";
	        $config['smtp_host'] = "evomata.com";
	        $config['smtp_user'] = "noreply@evomata.com";
	        $config['smtp_pass'] = "ASD789456";
	        $config['smtp_port'] = "587";
	        $config['mailtype'] = 'html';
	        $config['charset'] = 'utf-8';
	        $config['newline'] = "\r\n";
	        $config['wordwrap'] = TRUE;

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from('noreply@evomata.com');
			$this->email->to('krishnakant@evomata.com');
			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->send();
 			//echo $this->email->print_debugger();	
		} catch (Exception $e) {
			echo "Exception";
		}
	}

	public function mobile_login(){
		$data['mode'] = "user";
		$this->load->view('account/login1', $data);
	}

########## Referrer code ############
	public function user_ref_code($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;

			$ref_code = $sess_data['user_details'][0]->i_user_code;

			$query = $this->db->query("SELECT * FROM i_user_scheme_txn as a LEFT JOIN i_user_transaction as b on a.iushtxn_txn_id = b.iutxn_id LEFT JOIN i_u_details as c on a.iushtxn_uid = c.iud_u_id LEFT JOIN i_user_scheme as d on a.iushtxn_sid = d.iush_id WHERE iushtxn_ref_code = '$ref_code' ");
			$data['ref_income'] = $query->result();

			$data['u_code'] = $sess_data['user_details'][0]->i_user_code;
			$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];

			$ert['title'] = "Referrer code";
			$ert['search'] = "false";
			$this->load->view('navbar', $ert);
			$this->load->view('account/referrer_code', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_txn_details($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'group'");
			$data['g_amount'] = $query->result();

			$query = $this->db->query("SELECT ipprice_amount FROM i_portal_price WHERE ipprice_name = 'storage'");
			$data['s_amount'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_user_transaction WHERE iutxn_id = '$id'");
			$result = $query->result();
			$data['group'] = $result[0]->iutxn_group;
			$data['storage'] = $result[0]->iutxn_storage;
			$data['g_month'] = $result[0]->iutxn_group_month;
			$data['s_month'] = $result[0]->iutxn_storage_month;
			// $data['disc_amount'] = $result[0]->iutxn_discount_amount;
			// $data['ref_code'] = $result[0]->iutxn_ref_code;

			$query = $this->db->query("SELECT * FROM i_users_cart_modules as a LEFT JOIN i_modules as b on a.iucm_mid=b.im_id WHERE iucm_txn_id = '$id'");
			$data['order'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

########## Add devices ##############################

	public function add_devices($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;

			$query = $this->db->query("SELECT * FROM i_user_devices WHERE iu_d_owner = '$uid' ");
			$result = $query->result();
			$data['d_list'] = $result;

			$query = $this->db->query("SELECT COUNT(iuh_mid),iuh_mid,iuh_owner FROM i_user_history WHERE iuh_owner = '$oid' GROUP BY iuh_mid ORDER by COUNT(iuh_mid) DESC");
	        $data['use_modules'] = $query->result();

			$data['u_code'] = $sess_data['user_details'][0]->i_user_code;
			$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];

			$ert['title'] = "Add devices";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('account/add_devices', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_device($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$dt = date('Y-m-d H:i:s');

			$d_name = $this->input->post('d_name');
			$d_loc = $this->input->post('d_loc');
			$d_sn = $this->input->post('d_sn');

			$data = array(
				'iu_d_name' => $d_name, 
				'iu_d_location' => $d_loc,
				'iu_d_serial_number' => $d_sn,
				'iu_d_uid' => $uid,
				'iu_d_owner' => $oid,
				'iu_d_created' => $dt,
				'iu_d_created_by' => $uid,
				'iu_d_gid' => $gid
			);
			$this->db->insert('i_user_devices',$data);

			$query = $this->db->query("SELECT * FROM i_user_devices WHERE iu_d_owner = '$uid' ");
			$result = $query->result();
			$data['d_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_device($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$dt = date('Y-m-d H:i:s');

			$d_name = $this->input->post('d_name');
			$d_loc = $this->input->post('d_loc');
			$d_sn = $this->input->post('d_sn');

			$data = array(
				'iu_d_name' => $d_name, 
				'iu_d_location' => $d_loc,
				'iu_d_serial_number' => $d_sn,
				'iu_d_modify' => $dt,
				'iu_d_modified_by' => $uid
			);
			$this->db->where(array('iu_d_id' => $id , 'iu_d_owner' => $uid ));
			$this->db->update('i_user_devices',$data);

			$query = $this->db->query("SELECT * FROM i_user_devices WHERE iu_d_owner = '$uid' ");
			$result = $query->result();
			$data['d_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_device($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;

			$this->db->where(array('iu_d_id' => $id , 'iu_d_owner' => $uid ));
			$this->db->delete('i_user_devices');

			$query = $this->db->query("SELECT * FROM i_user_devices WHERE iu_d_owner = '$uid' ");
			$result = $query->result();
			$data['d_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}	

########## Rename module ####################

	public function module_rename($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;

			$data['module'] = $sess_data['user_mod'];
			$data['u_code'] = $sess_data['user_details'][0]->i_user_code;
			$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];

			$ert['title'] = "Module Rename";
			$ert['search'] = "false";
			$this->load->view('navbar', $ert);
			$this->load->view('account/module_rename', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_mod_name($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$mod_arr = $this->input->post('mod_arr');

			for ($i=0; $i < count($mod_arr) ; $i++) { 
				$data = array('ium_module_alias' => $mod_arr[$i]['alias']);
				$this->db->WHERE(array('ium_m_id' => $mod_arr[$i]['mid'] , 'ium_u_id' => $oid ));
				$this->db->update('i_u_modules',$data);
			}

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	// public function test_sql(){
	// 	$mem = memory_get_usage(true);
	// 	if ($mem < 1024) {
	// 		$$memory = $mem .' B'; 
	// 	} elseif ($mem < 1048576) {
	// 		$memory = round($mem / 1024, 2) .' KB';
	// 	} else {
	// 		$memory = round($mem / 1048576, 2) .' MB';
	// 	}
	// 	print_r('Memory Usage : '.$memory);

	// 	$load = sys_getloadavg();
	// 	print_r('<br>Load : '.$load[0]);

	// 	$coreCount = 2; $interval = 1;
	// 	$rs = sys_getloadavg();
	// 	$interval = $interval >= 1 && 3 <= $interval ? $interval : 1;
	// 	$load = $rs[$interval];
	// 	print_r('<br>load as percentage : '.round(($load * 100) / $coreCount,2));

	// 	$disktotal = disk_total_space ('/');
	// 	$diskfree  = disk_free_space  ('/');
	// 	$diskuse   = round (100 - (($diskfree / $disktotal) * 100)) .'%';
	// 	print_r('<br>Disc usage : '.$diskuse);


	// 	$this->load->view('sql_data');
	// }

########## Mobile_users ####################

	public function mobile_users($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['gid'] = $gid;

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$uid' ");
			$result1 = $query->result();
			$data['mobile_set'] = $result1;
			if (count($result1) > 0 ) {
				$grp_id = $result1[0]->iextetm_gid;
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' AND iug_id = '$grp_id' ");
				$result = $query->result();
				if (count($result) > 0) {
					$data['grp_name'] = $result[0]->iug_name;
				}
			}


			$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_owner = '$uid' ");
			$result1 = $query->result();
			$data['mob_user'] = $result1;

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$oid' ");
			$result1 = $query->result();
			$data['mob_group'] = $result1;

			$data['module'] = $sess_data['user_mod'];
			$data['u_code'] = $sess_data['user_details'][0]->i_user_code;
			$ert['code'] = $code;$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];

			$ert['title'] = "Mobile Users";
			$ert['search'] = "false";
			$this->load->view('navbar', $ert);
			$this->load->view('account/mobile_users', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_mobile_users($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_owner = '$uid' AND iextetmu_id = '$id' ");
			$result1 = $query->result();
			$data['mob_user'] = $result1;

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$uid' ");
			$result1 = $query->result();
			$data['mobile_set'] = $result1;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function search_mobile_users($code,$id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$cname = $this->input->post('c_name');

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_owner = '$uid' AND iextetmu_id = '$id' AND iextetmu_name like '%$cname%' ");
			$result1 = $query->result();
			$data['mob_user'] = $result1;

			$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_owner_id = '$uid' ");
			$result1 = $query->result();
			$data['mobile_set'] = $result1;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function mobile_user_update($code,$usr_id,$status=null) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$data = array(
				'iextetmu_status' => $status
			);
			$this->db->WHERE(array('iextetmu_owner' => $oid , 'iextetmu_id' => $usr_id));
			$this->db->update('i_ext_et_mobile_users',$data);

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function mobile_user_delete($code,$usr_id) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->WHERE(array('iextetmu_owner' => $oid , 'iextetmu_id' => $usr_id));
			$this->db->delete('i_ext_et_mobile_users');

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function mobile_user_feedback_type($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$status = $this->input->post('status');
			$grp_arr = $this->input->post('group');
			$grp_name = '';
			if (count($grp_arr) > 0 ) {
				$grp_name = $grp_arr[0];
			}

			$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_name = '$grp_name' AND iug_owner = '$oid' ");
			$result = $query->result();
			$gid = 0;
			if (count($result) > 0 ) {
				$gid = $result[0]->iug_id;
			}

			$data = array(
				'iextetm_feedback_type' => $status,
				'iextetm_gid' => $gid
			);
			$this->db->WHERE(array('iextetm_owner_id' => $oid));
			$this->db->update('i_ext_et_mobile',$data);

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}
}