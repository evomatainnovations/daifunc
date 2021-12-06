<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('directory');
		$this->load->helper('cookie');
		$this->load->model('Code','log_code');
	}

	public function home($mid,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mname = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'HR') {
					$mid = $module[$i]->mid;
					$mname = $module[$i]->mname;
					$alias = $module[$i]->m_alias;
				}
			}
			
			$data['oid'] = $oid;$data['uid'] = $uid;$data['gid'] = $gid;$data['code'] = $code;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['mid'] = $mid;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['user_connection']= $sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "false";
			$ert['name'] = $sess_data['user_details'][0]->iud_name;

			$this->load->view('navbar', $ert);
			$this->load->view('hr/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

############################## Add employee ##############################

	public function add_employee($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mname = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'HR') {
					$mid = $module[$i]->mid;
					$mname = $module[$i]->mname;
					$alias = $module[$i]->m_alias;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' ");
			$result = $query->result();
			$data['dept_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			$data['shift_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_devices WHERE iu_d_owner = '$oid' ");
			$result = $query->result();
			$data['device_list'] = $result;
			
			$data['oid'] = $oid;$data['uid'] = $uid;$data['gid'] = $gid;$data['code'] = $code;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['mid'] = $mid;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['title'] = 'HR : Add Employee';

			$ert['search'] = "false";
			$ert['name'] = $sess_data['user_details'][0]->iud_name;

			$this->load->view('navbar', $ert);
			$this->load->view('hr/add_employee', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_card_details($code,$did){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$query = $this->db->query("SELECT * FROM i_c_attendance as a LEFT JOIN i_user_devices as b on a.ica_device_id = b.iu_d_serial_number WHERE iu_d_owner = '$oid' AND iu_d_id = '$did' AND ica_card_id NOT IN (SELECT ic_card_id FROM i_customers WHERE ic_owner = '$oid' AND ic_card_id IS NOT NULL) ORDER BY ica_date DESC limit 1 ");
			$data['card_list'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_shift($code,$inid=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$s_name = $this->input->post('name');
			$s_in = $this->input->post('in_time');
			$s_out = $this->input->post('out_time');

			if ($inid == null) {
				$data = array(
					'iexteths_shift_name' => $s_name,
					'iexteths_in_time' => $s_in,
					'iexteths_out_time' => $s_out,
					'iexteths_owner' => $oid,
					'iexteths_created' => $dt,
					'iexteths_created_by' => $uid,
					'iexteths_gid' => $gid
				);
				$this->db->insert('i_ext_et_hr_shift',$data);
			}else{
				$data = array(
					'iexteths_shift_name' => $s_name,
					'iexteths_in_time' => $s_in,
					'iexteths_out_time' => $s_out,
					'iexteths_modified' => $dt,
					'iexteths_modified_by' => $uid,
				);
				$this->db->WHERE(array('iexteths_owner' => $oid , 'iexteths_id' => $inid));
				$this->db->update('i_ext_et_hr_shift',$data);
			}
			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			$data['shift_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_shift($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$s_name = $this->input->post('name');
			$s_in = $this->input->post('in_time');
			$s_out = $this->input->post('out_time');

			$this->db->WHERE(array('iexteths_owner' => $oid , 'iexteths_id' => $inid));
			$this->db->delete('i_ext_et_hr_shift');

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			$data['shift_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_department($code,$inid = null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$d_name = $this->input->post('name');

			if ($inid != 0 && $inid != null) {
				$data = array(
					'iextethd_dept_name' => $d_name,
					'iextethd_modified' => $dt,
					'iextethd_modified_by' => $uid
				);
				$this->db->where(array('iextethd_id' => $inid , 'iextethd_owner' => $oid));
				$this->db->update('i_ext_et_hr_department',$data);
			}else{
				$data = array(
					'iextethd_dept_name' => $d_name,
					'iextethd_owner' => $oid,
					'iextethd_created' => $dt,
					'iextethd_created_by' => $uid,
					'iextethd_gid' => $gid
				);
				$this->db->insert('i_ext_et_hr_department',$data);
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' ");
			$result = $query->result();
			$data['dept_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_department($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$this->db->WHERE(array('iextethd_owner' => $oid , 'iextethd_id' => $id ));
			$this->db->delete('i_ext_et_hr_department');

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' ");
			$result = $query->result();
			$data['dept_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_employee($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$e_name = $this->input->post('e_name');
			$card_no = $this->input->post('card_no');
			$e_sal = $this->input->post('e_sal');
			$e_unit = $this->input->post('e_unit');
			$e_dept = $this->input->post('e_dept');
			$e_shift = $this->input->post('e_shift');

			$data = array(
				'ic_name' => $e_name,
				'ic_owner' => $oid,
				'ic_created' => $dt,
				'ic_created_by' => $uid,
				'ic_section' => 'employee',
				'ic_card_id' => $card_no
			);
			$this->db->insert('i_customers',$data);
			$cust_id = $this->db->insert_id();

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' AND iextethd_dept_name = '$e_dept' ");
			$result = $query->result();
			$dept_id = 0;
			if (count($result) > 0 ) {
				$dept_id = $result[0]->iextethd_id;
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' AND iexteths_shift_name = '$e_shift' ");
			$result = $query->result();
			$shift_id = 0;
			if (count($result) > 0 ) {
				$shift_id = $result[0]->iexteths_id;
			}

			$data = array(
				'iexteth_cid' => $cust_id,
  				'iexteth_dept_id' => $dept_id,
  				'iexteth_shift_id' => $shift_id,
  				'iexteth_salary' => $e_sal,
  				'iexteth_unit' => $e_unit,
  				'iexteth_owner' => $oid,
  				'iexteth_created' => $dt,
  				'iexteth_created_by' => $uid,
  				'iexteth_gid' => $gid,
			);
			$this->db->insert('i_ext_et_hr',$data);
			$inid = $this->db->insert_id();

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function update_employee($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');

			$e_name = $this->input->post('e_name');
			$card_no = $this->input->post('card_no');
			$e_sal = $this->input->post('e_sal');
			$e_unit = $this->input->post('e_unit');
			$e_dept = $this->input->post('e_dept');
			$e_shift = $this->input->post('e_shift');

			$query = $this->db->query("SELECT * FROM i_ext_et_hr WHERE iexteth_id = '$inid' AND iexteth_owner = '$oid'");
			$result = $query->result();
			$cid = 0;
			if (count($result) > 0 ) {
				$cid = $result[0]->iexteth_cid;	
			}

			$data = array(
				'ic_name' => $e_name,
				'ic_modified' => $dt,
				'ic_modified_by' => $uid
			);
			$this->db->WHERE(array('ic_id' => $cid , 'ic_owner' => $oid ));
			$this->db->update('i_customers',$data);

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' AND iextethd_dept_name = '$e_dept' ");
			$result = $query->result();
			$dept_id = 0;
			if (count($result) > 0 ) {
				$dept_id = $result[0]->iextethd_id;
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' AND iexteths_shift_name = '$e_shift' ");
			$result = $query->result();
			$shift_id = 0;
			if (count($result) > 0 ) {
				$shift_id = $result[0]->iexteths_id;
			}

			$data = array(
  				'iexteth_dept_id' => $dept_id,
  				'iexteth_shift_id' => $shift_id,
  				'iexteth_salary' => $e_sal,
  				'iexteth_unit' => $e_unit,
  				'iexteth_modified' => $dt,
  				'iexteth_modified_by' => $uid
			);
			$this->db->where(array('iexteth_owner' => $oid , 'iexteth_id' => $inid ));
			$this->db->update('i_ext_et_hr',$data);

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}
	
	public function hr_doc_upload($code,$e_id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$cid = 0;
			$module_id = '';
			$module = $sess_data['user_mod'];
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'HR') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr WHERE iexteth_id = '$e_id' AND iexteth_owner = '$oid'");
			$result = $query->result();
			if (count($result) > 0 ) {
				$cid = $result[0]->iexteth_cid;	
			}

			$this->db->where(array('icd_type' => 'hr_profile','icd_owner' => $oid,'icd_type_id' => $e_id));
			$this->db->delete('i_c_doc');

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
				
					$this->db->where('icp_c_id', $cid);
					$this->db->delete('i_c_pic');

					$data = array(
						'icd_file' => $file_name,
						'icd_owner' => $oid,
						'icd_cid' => $cid,
						'icd_date' => $dt,
						'icd_type' => 'hr_profile',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $module_id,
						'icd_type_id' => $e_id,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);

					$data = array('icp_c_id' => $cid, 'icp_path' => $timestamp_value.'.'.$ext );
					$this->db->insert('i_c_pic', $data);

					$timestamp_value = '';
				}	
				$img_path = '';
			}

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function search_emp($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$name = $this->input->post('name');

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' AND ic_name LIKE '%$name%' ");
			$result = $query->result();
			$data['emp_list'] = $result;
			
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function edit_emp($code,$eid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' LEFT JOIN i_ext_et_hr_shift as e on b.iexteth_shift_id = e.iexteths_id WHERE iexteth_owner = '$oid' AND iexteth_id = '$eid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function delete_emp($code,$eid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_et_hr WHERE iexteth_owner = '$oid' AND iexteth_id = '$eid' ");
			$result = $query->result();
			$cid = 0 ;
			if (count($result) > 0 ) {
				$cid = $result[0]->iexteth_cid;
			}

			$this->db->WHERE(array('iexteth_id' => $eid , 'iexteth_owner' => $oid ));
			$this->db->delete('i_ext_et_hr');

			$this->db->WHERE(array('icd_type_id' => $eid , 'icd_owner' => $oid , 'icd_type' => 'hr_profile' ));
			$this->db->delete('i_c_doc');

			$this->db->WHERE(array('ic_id' => $cid , 'ic_owner' => $oid ));
			$this->db->delete('i_customers');

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_ext_et_hr as b on a.ic_id = b.iexteth_cid LEFT JOIN i_ext_et_hr_department as c on b.iexteth_dept_id = c.iextethd_id LEFT JOIN i_c_doc as d on b.iexteth_id = d.icd_type_id AND icd_type = 'hr_profile' WHERE iexteth_owner = '$oid' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

############################## View Attendance ###########################

	public function view_attendance($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mname = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'HR') {
					$mid = $module[$i]->mid;
					$mname = $module[$i]->mname;
					$alias = $module[$i]->m_alias;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' ");
			$result = $query->result();
			$data['dept_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			$data['shift_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_section = 'employee' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_hr WHERE iexteth_owner = '$oid' group by iexteth_unit ");
			$result = $query->result();
			$data['unit_list'] = $result;
			
			$data['oid'] = $oid;$data['uid'] = $uid;$data['gid'] = $gid;$data['code'] = $code;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['mid'] = $mid;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['title'] = 'HR : View Attendance';

			$ert['search'] = "false";
			$ert['name'] = $sess_data['user_details'][0]->iud_name;

			$this->load->view('navbar', $ert);
			$this->load->view('hr/view_attendance', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_attend_report($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$e_name = $this->input->post('name');
			$dept_name = $this->input->post('dept_name');
			$shift_name = $this->input->post('shift_name');
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$unit = $this->input->post('emp_unit');
			$data['today'] = date('Y-m-d');

			$data['emp_attend'] = [];
			$query = $this->db->query("SELECT * FROM i_c_attendance as a LEFT JOIN i_customers as b on a.ica_card_id = b.ic_card_id WHERE ic_owner = '$oid' AND DATE(ica_date) > '$from_date' AND DATE(ica_date) < '$to_date' ORDER BY ica_date ASC");
			$result = $query->result();
			for ($i=0; $i < count($result) ; $i++) {
				$date_l = $result[$i]->ica_date;
				array_push($data['emp_attend'], array('ica_date' => date('Y-m-d' ,strtotime($date_l)) , 'ica_card_id' => $result[$i]->ica_card_id , 'time' => date('H:i' ,strtotime($date_l)) ));
			}

			$date_arr = [];
			$interval = new DateInterval('P1D');
		    $realEnd = new DateTime($to_date);
		    $realEnd->add($interval);
		    $period = new DatePeriod(new DateTime($from_date), $interval, $realEnd);
		    foreach($period as $date) { 
		        $date_arr[] = $date->format('Y-m-d');
		    }
		    $data['date_list'] = $date_arr;

			$this->db->select('*');
			$this->db->from('i_customers');
			$this->db->join('i_ext_et_hr', 'i_ext_et_hr.iexteth_cid = i_customers.ic_id','left');
			$this->db->join('i_ext_et_hr_department', 'i_ext_et_hr.iexteth_dept_id = i_ext_et_hr_department.iextethd_id','left');
			$this->db->join('i_ext_et_hr_shift', 'i_ext_et_hr.iexteth_shift_id = i_ext_et_hr_shift.iexteths_id','left');
			$this->db->where('iexteth_owner', $oid);
			if ($dept_name != '') {
				$this->db->where('iextethd_dept_name', $dept_name);
			}
			if ($e_name != '') {
				$this->db->where('ic_name', $e_name);
			}
			if ($shift_name != '') {
				$this->db->where('iexteths_shift_name', $shift_name);
			}
			if ($unit != '') {
				$this->db->where('iexteth_unit', $unit);
			}
			$query = $this->db->get();
			$data['emp_list'] = $query->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

############################## Process Salary ###########################

	public function process_salary($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mname = '';
			for ($i=0; $i <count($module) ; $i++) {
				if ($module[$i]->mname == 'HR') {
					$mid = $module[$i]->mid;
					$mname = $module[$i]->mname;
					$alias = $module[$i]->m_alias;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_policie WHERE iextethp_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$data['edit_policies'] = $result;
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_department WHERE iextethd_owner = '$oid' ");
			$result = $query->result();
			$data['dept_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			$data['shift_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_section = 'employee' ");
			$result = $query->result();
			$data['emp_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_hr WHERE iexteth_owner = '$oid' group by iexteth_unit ");
			$result = $query->result();
			$data['unit_list'] = $result;
			
			$data['oid'] = $oid;$data['uid'] = $uid;$data['gid'] = $gid;$data['code'] = $code;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['mid'] = $mid;$ert['mname']=$mname;$ert['code']=$code;$ert['gid']=$gid;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['title'] = 'HR : Process Salary';

			$ert['search'] = "false";
			$ert['name'] = $sess_data['user_details'][0]->iud_name;

			$this->load->view('navbar', $ert);
			$this->load->view('hr/process_salary', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_salary_report($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$e_name = $this->input->post('name');
			$dept_name = $this->input->post('dept_name');
			// $shift_name = $this->input->post('shift_name');
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			// $unit = $this->input->post('emp_unit');
			// $data['today'] = date('Y-m-d');

			$data['emp_attend'] = [];
			$query = $this->db->query("SELECT * FROM i_c_attendance as a LEFT JOIN i_customers as b on a.ica_card_id = b.ic_card_id WHERE ic_owner = '$oid' AND DATE(ica_date) > '$from_date' AND DATE(ica_date) < '$to_date' ORDER BY ica_date ASC");
			$result = $query->result();
			for ($i=0; $i < count($result) ; $i++) {
				$date_l = $result[$i]->ica_date;
				array_push($data['emp_attend'], array('ica_date' => date('Y-m-d' ,strtotime($date_l)) , 'ica_card_id' => $result[$i]->ica_card_id , 'time' => date('H:i' ,strtotime($date_l)) ));
			}

			$date_arr = [];
			$interval = new DateInterval('P1D');
		    $realEnd = new DateTime($to_date);
		    $realEnd->add($interval);
		    $period = new DatePeriod(new DateTime($from_date), $interval, $realEnd);
		    foreach($period as $date) { 
		        $date_arr[] = $date->format('Y-m-d');
		    }
		    $data['date_list'] = $date_arr;

		    $query = $this->db->query("SELECT * FROM i_ext_et_hr_policie WHERE iextethp_owner = '$oid' ");
			$result = $query->result();
			$in_time = 0;
			if (count($result) > 0 ) {
				$in_time = $result[0]->iextethp_late;
			}
			$data['shift_list'] = [];
		    $query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			for ($i=0; $i < count($result); $i++) {
				$time = new DateTime($result[$i]->iexteths_in_time);
				$time->add(new DateInterval('PT' . $in_time . 'M'));
				$stamp = $time->format('H:i');
				array_push($data['shift_list'] , array('iexteths_in_time' => $stamp , 'iexteths_id' => $result[$i]->iexteths_id ));
			}

			$this->db->select('*');
			$this->db->from('i_customers');
			$this->db->join('i_ext_et_hr', 'i_ext_et_hr.iexteth_cid = i_customers.ic_id','left');
			if ($dept_name != '') {
				$this->db->join('i_ext_et_hr_department', 'i_ext_et_hr.iexteth_dept_id = i_ext_et_hr_department.iextethd_id','left');
			}
			$this->db->join('i_ext_et_hr_shift', 'i_ext_et_hr.iexteth_shift_id = i_ext_et_hr_shift.iexteths_id','left');
			$this->db->where('iexteth_owner', $oid);
			if ($dept_name != '') {
				$this->db->where('iextethd_dept_name', $dept_name);
			}
			if ($e_name != '') {
				$this->db->where('ic_name', $e_name);
			}
			$query = $this->db->get();
			$data['query'] = $query;
			$data['emp_list'] = $query->result();
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function save_salary_policies($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$in_time_exeed = $this->input->post('in_time_exeed');
			$in_time_exeed_deduct = $this->input->post('in_time_exeed_deduct');
			$absent_exeed = $this->input->post('absent_exeed');
			$absent_exeed_deduct = $this->input->post('absent_exeed_deduct');
			$dt = date('Y-m-d H:i:s');
			
			$query = $this->db->query("SELECT * FROM i_ext_et_hr_policie WHERE iextethp_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$hid = $result[0]->iextethp_id;
				$data = array(
					'iextethp_late_deduct' => $in_time_exeed_deduct,
					'iextethp_late' => $in_time_exeed,
					'iextethp_absent_deduct' => $absent_exeed_deduct,
					'iextethp_absent' => $absent_exeed,
					'iextethp_modified' => $dt,
					'iextethp_modified_by' => $uid,
					'iextethp_gid' => $gid
				);
				$this->db->WHERE(array('iextethp_owner' => $oid, 'iextethp_id' => $hid));
				$this->db->update('i_ext_et_hr_policie',$data);
			}else{
				$data = array(
					'iextethp_late_deduct' => $in_time_exeed_deduct,
					'iextethp_late' => $in_time_exeed,
					'iextethp_absent_deduct' => $absent_exeed_deduct,
					'iextethp_absent' => $absent_exeed,
					'iextethp_owner' => $oid,
					'iextethp_created' => $dt,
					'iextethp_created_by' => $uid,
					'iextethp_gid' => $gid
				);
				$this->db->insert('i_ext_et_hr_policie',$data);
			}

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_salary_slip($code,$inid,$from_date,$to_date){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
	 		$page = file_get_contents(base_url().'Hr/print_salary_slip/'.$code.'/'.$inid.'/'.$from_date.'/'.$to_date, false, $context);

		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/Hr/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $inid.'.html';
		    $invoicefile = $inid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
			redirect(base_url().'assets/data/'.$oid.'/Hr/'.$invoicefile);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_salary_slip_all($code,$from_date,$to_date,$dept_name=null,$e_name=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$this->db->select('*');
			$this->db->from('i_customers');
			$this->db->join('i_ext_et_hr', 'i_ext_et_hr.iexteth_cid = i_customers.ic_id','left');
			if ($dept_name != '' && $dept_name != 'null' && $dept_name != null) {
				$this->db->join('i_ext_et_hr_department', 'i_ext_et_hr.iexteth_dept_id = i_ext_et_hr_department.iextethd_id','left');
			}
			$this->db->join('i_ext_et_hr_shift', 'i_ext_et_hr.iexteth_shift_id = i_ext_et_hr_shift.iexteths_id','left');
			$this->db->where('iexteth_owner', $oid);
			if ($dept_name != '' && $dept_name != 'null' && $dept_name != null) {
				$this->db->where('iextethd_dept_name', $dept_name);
			}
			if ($e_name != '' && $e_name != 'null' && $e_name != null) {
				$this->db->where('ic_name', $e_name);
			}
			$query = $this->db->get();
			$result = $query->result();

			$opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
		    $context = stream_context_create($opts);
		    session_write_close();
		    $page = '';
		    if (count($result) > 0 ) {
		    	for ($i=0; $i < count($result) ; $i++) { 
		    		$inid = $result[$i]->iexteth_id;
		    		$page .= file_get_contents(base_url().'Hr/print_salary_slip/'.$code.'/'.$inid.'/'.$from_date.'/'.$to_date, false, $context);		
		    	}
		    }
		    session_start();

		    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/Hr/';

		    if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
		   
		    $htmlfile = $inid.'.html';
		    $invoicefile = $inid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');
			redirect(base_url().'assets/data/'.$oid.'/Hr/'.$invoicefile);
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function print_salary_slip($code,$inid,$from_date,$to_date){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['month'] = date('M Y',strtotime($from_date));
			$data['emp_attend'] = [];
			$query = $this->db->query("SELECT * FROM i_c_attendance as a LEFT JOIN i_customers as b on a.ica_card_id = b.ic_card_id WHERE ic_owner = '$oid' AND DATE(ica_date) BETWEEN '$from_date' AND '$to_date' ORDER BY ica_date ASC");
			$result = $query->result();
			for ($i=0; $i < count($result) ; $i++) {
				$date_l = $result[$i]->ica_date;
				array_push($data['emp_attend'], array('ica_date' => date('Y-m-d' ,strtotime($date_l)) , 'ica_card_id' => $result[$i]->ica_card_id , 'time' => date('H:i' ,strtotime($date_l)) ));
			}

			$date_arr = [];
			$interval = new DateInterval('P1D');
		    $realEnd = new DateTime($to_date);
		    $realEnd->add($interval);
		    $period = new DatePeriod(new DateTime($from_date), $interval, $realEnd);
		    foreach($period as $date) { 
		        $date_arr[] = $date->format('Y-m-d');
		    }
		    $data['date_list'] = $date_arr;

		    $query = $this->db->query("SELECT * FROM i_ext_et_hr_policie WHERE iextethp_owner = '$oid' ");
			$result = $query->result();
			$in_time = 0;
			if (count($result) > 0 ) {
				$in_time = $result[0]->iextethp_late;
			}
			$data['shift_list'] = [];
		    $query = $this->db->query("SELECT * FROM i_ext_et_hr_shift WHERE iexteths_owner = '$oid' ");
			$result = $query->result();
			for ($i=0; $i < count($result); $i++) {
				$time = new DateTime($result[$i]->iexteths_in_time);
				$time->add(new DateInterval('PT' . $in_time . 'M'));
				$stamp = $time->format('H:i');
				array_push($data['shift_list'] , array('iexteths_in_time' => $stamp , 'iexteths_id' => $result[$i]->iexteths_id ));
			}

			$data['in_time_exeed'] = 0;
			$data['in_time_exeed_deduct'] = 0;
			$data['absent_exeed'] = 0;
			$data['absent_exeed_deduct'] = 0;
			$query = $this->db->query("SELECT * FROM i_ext_et_hr_policie WHERE iextethp_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$data['in_time_exeed'] = $result[0]->iextethp_late;
				$data['in_time_exeed_deduct'] = $result[0]->iextethp_late_deduct;
				$data['absent_exeed'] = $result[0]->iextethp_absent;
				$data['absent_exeed_deduct'] = $result[0]->iextethp_absent_deduct;
			}

			$this->db->select('*');
			$this->db->from('i_customers');
			$this->db->join('i_ext_et_hr', 'i_ext_et_hr.iexteth_cid = i_customers.ic_id','left');
			$this->db->join('i_ext_et_hr_department', 'i_ext_et_hr.iexteth_dept_id = i_ext_et_hr_department.iextethd_id','left');
			$this->db->join('i_ext_et_hr_shift', 'i_ext_et_hr.iexteth_shift_id = i_ext_et_hr_shift.iexteths_id','left');
			$this->db->where('iexteth_owner', $oid);
			$this->db->where('iexteth_id', $inid);
			$query = $this->db->get();
			$data['emp_list'] = $query->result();
			$this->load->view('hr/salary_slip_print', $data);

		}else{
			redirect(base_url().'account/login');
		}
	}
}