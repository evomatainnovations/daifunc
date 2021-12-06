<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {
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
	public function activity_modal($code,$type=null,$type_id = 0,$mod_id = 0){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['code'] = $code;
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['type'] = $type;
			$data['date'] = '';
			$data['cat_display'] = '';
			$data['shortcut'] = '';
			$data['mod_id'] = $mod_id;
			if ($type == 'project') {
				$data['project_id'] = $type_id;
			}else{
				$data['txn_id'] = $type_id;
			}

			if ($type != null) {
				$query = $this->db->query("SELECT * FROM i_portal_module_activity_type WHERE ipmat_act_type = '$type'");
				$result = $query->result();
				if (count($result) > 0 ) {
					if ($type == 'purchase_order') {
						$type = 'Event';
						$data['purchase_order'] = 'true';
					}else{
						$data['type'] = $type;
					}
					$data['shortcut'] = $result[0]->ipmat_shortcut_display;
					$data['date'] = $result[0]->ipmat_date_display;
					$data['cat_display'] = $result[0]->ipmat_category_display;
				}
			}
			// if ($type == 'purchase_order') {
			// 	$type = 'Event';
			// 	$data['type'] = 'Event';
			// 	$data['shortcut'] = 'yes';
			// }

			if ($type == 'Event' && $type_id != 0 ) {
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$type_id' AND iua_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['parent_title'] = $result[0]->iua_title;
					$data['parent_aid'] = $result[0]->iua_id;
				}
			}

			if ($type == 'support') {
				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ");
				$result = $query->result();
				$a_pid = 0;
				if (count($result) > 0 ) {
					$a_pid = $result[0]->ip_id;
				}

				$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_id = '$type_id' AND ies_owner = '$oid' ");
				$result = $query->result();
				$cid = 0;
				$s_uid = 0;

				if (count($result) > 0) {
					$data['support_details'] = $result;
					$s_uid = $result[0]->ies_user_id;
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_owner = '$oid' AND iextetmu_id = '$s_uid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['c_name'] = $result[0]->iextetmu_name;
					$data['c_add'] = $result[0]->iextetmu_address;
				}
			}

			if ($type == 'project') {
				if ($oid == $uid) {
					$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$type_id'  ");
					$result = $query->result();
					$data['project_grp'] = $result;
				}else{
					$admin = 'false';
					$module = $sess_data['user_mod'];
					$mid = 0;
					for ($i=0; $i <count($module) ; $i++) { 
						if ($module[$i]->mname == 'Projects') {
							$mid = $module[$i]->mid;
						}
					}
					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$mid'");
					$result = $query->result();
					if (count($result) > 0) {
						$admin = 'true';
					}
					if ($admin == 'true') {
						$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$type_id'  ");
						$result = $query->result();
						$data['project_grp'] = $result;
					}else{
						$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$type_id' AND iextptg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ");
						$result = $query->result();
						$data['project_grp'] = $result;
					}
				}
			}

			if ($type == 'opportunity') {
				$query = $this->db->query("SELECT * FROM i_ext_et_opportunity WHERE iextetop_owner = '$oid' AND iextetop_id='$type_id'  ");
				$result = $query->result();
				$data['oppo_name'] = $result[0]->iextetop_title;
			}

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' UNION SELECT * FROM i_u_a_todo WHERE iuat_a_id IN(SELECT iuap_a_id FROM i_u_a_person WHERE iuap_p_id IN ( SELECT ic_id FROM i_customers WHERE ic_uid = '$uid'))");
			$data['activity_todo'] = $query->result();

			$query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
			$result = $query->result();
			$data['status'] = $result;

			$query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
			$result = $query->result();
			$data['place'] = $result;

			$query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
			$result = $query->result();
			$data['cat'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['user_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			$this->load->view('activity_modal',$data);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function activity_save ($code,$option_type=null){ //option type is used for activity update but dont remove from this 
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['code'] = $code;
			$dt = date('Y-m-d H:i:s');
			$title = $this->input->post('title');
			$type = $this->input->post('type');
			$f_date = $this->input->post('f_date');
			$t_date = $this->input->post('t_date');
			$repeat = $this->input->post('repeat');
			$repeat_end = $this->input->post('repeat_end');
			$color = $this->input->post('color');
			$mod_shortcut = $this->input->post('mod_shortcut');
			$category = $this->input->post('category');
			$todo = $this->input->post('todo');
			$notes = $this->input->post('notes');
			$person = $this->input->post('share');
			$location = $this->input->post('location');
			$remind = $this->input->post('remind');
			$priority = $this->input->post('priority');
			$project_grp = $this->input->post('project_grp');
			$txn_id = $this->input->post('txn_id');
			$parent_id = $this->input->post('parent_id');

			$flg = '0';
			if (count($todo) > 0 ) {
				$flg = '1';
			}

			if ($f_date == '' ) {
				$type = 'Note';
			}else{
				if ($t_date == '') {
					$t_date = $f_date;
				}
			}
			$fid = 0;
			$mod_id = 0;
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_id = '$mod_shortcut'");
			$result = $query->result();
			if (count($result) > 0) {
				$fid = $result[0]->ims_function;
				$mod_id = $result[0]->ims_m_id;	
			}

			$aid = $this->repeat_activity_save($type,$title,$f_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$parent_id,$fid,$mod_id,$gid,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes,'true');

			if ($type == 'project') {
				$data = array(
					'iextpt_p_id' => $txn_id,
					'iextpt_tg_id' => $project_grp,
					'iextpt_aid' => $aid,
					'iextpt_owner' => $oid,
					'iextpt_created_by' => $uid,
					'iextpt_gid' => $gid
				);
				$this->db->insert('i_ext_pro_task', $data);
			}

			if ($type == 'support') {
				$chars = "0123456789";
				$res = "";
				for ($i = 0; $i < 6; $i++) {
				    $res .= $chars[mt_rand(0, strlen($chars)-1)];
				}

				$data = array(
					'iesa_sid' => $txn_id,
					'iesa_aid' => $aid,
					'iesa_code' => $res,
					'iesa_created' => $dt,
					'iesa_created_by' => $uid,
					'iesa_owner' => $oid
				);
				$this->db->insert('i_ext_support_activity',$data);
			}

			if ($type == 'subscription') {
				$chars = "0123456789";
				$res = "";
				for ($i = 0; $i < 6; $i++) {
				    $res .= $chars[mt_rand(0, strlen($chars)-1)];
				}

				$data = array(
					'iextamct_owner' => $oid,
					'iextamct_amc_id' => $txn_id,
					'iextamct_created_by' => $uid,
					'iextamct_gid' => $gid,
					'iextamct_aid' => $aid,
					'iextamct_code' => $res
				);
				$this->db->insert('i_ext_et_amc_task',$data);
			}

			if ($type == 'opportunity') {
				$data = array(
					'iexteoa_aid' => $aid,
					'iexteoa_oppo_id' => $txn_id
				);
				$this->db->insert('i_ext_et_opportunity_activity',$data);
			}

			if ($repeat != 'one_time') {
				$from_date = $f_date;
				$to_date = $t_date;

				$this->count_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
			}

			echo $type;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function activity_doc_upload($code,$aid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['code'] = $code;
			$dt = date('Y-m-d H:i:s');

			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$uid' ");
			$result = $query->result();
			$cid = $result[0]->i_ref;
			$img_path = "";

			$this->db->WHERE(array('icd_type_id' => $aid , 'icd_owner' => $oid , 'icd_type' => 'activity_attach'));
			$this->db->delete('i_c_doc');

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
						'icd_type' => 'activity_attach',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => '0',
						'icd_type_id' => $aid,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);
					$timestamp_value = '';
				}
				$img_path = '';
			}

			echo 'true';
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function activity_edit($code,$aid,$txn_id=0,$type=null){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['code'] = $code;
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$data['type'] = '';
			$data['date'] = '';
			$data['cat_display'] = '';
			$data['shortcut'] = '';
			$data['aid'] = $aid;

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$aid' AND iua_owner = '$oid' ");
			$result = $query->result();
			$data['edit_activity'] = $result;
			$type = $result[0]->iua_type;
			$mid = $result[0]->iua_m_shortcuts;
			
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_m_id = '$mid'");
			$result = $query->result();
			if (count($result) > 0) {
				$data['mod_shortcut'] = $result[0]->ims_id;
			}else{
				$data['mod_shortcut'] = 0 ;
			}

			if ($type != null) {
				$query = $this->db->query("SELECT * FROM i_portal_module_activity_type WHERE ipmat_act_type = '$type'");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['type'] = $type;
					$data['date'] = $result[0]->ipmat_date_display;
					$data['cat_display'] = $result[0]->ipmat_category_display;
					$data['shortcut'] = $result[0]->ipmat_shortcut_display;
				}
			}

			if ($type == 'support') {
				$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_property like 'address%' ");
				$result = $query->result();
				$a_pid = 0;
				if (count($result) > 0 ) {
					$a_pid = $result[0]->ip_id;
				}

				$query = $this->db->query("SELECT * FROM i_ext_support WHERE ies_id = '$txn_id' AND ies_owner = '$oid' ");
				$result = $query->result();
				$cid = 0;
				$s_uid = 0;
				if (count($result) > 0) {
					$data['support_details'] = $result;
					$s_uid = $result[0]->ies_user_id;
				}

				$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_owner = '$oid' AND iextetmu_id = '$s_uid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$data['c_name'] = $result[0]->iextetmu_name;
					$data['c_add'] = $result[0]->iextetmu_address;
				}
			}

			if ($type == 'project') {
				if ($oid == $uid) {
					$data['project_id'] = $txn_id;
					$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$txn_id'  ");
					$result = $query->result();
					$data['project_grp'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_aid='$aid'  ");
					$result = $query->result();
					$data['edit_grp'] = $result[0]->iextpt_tg_id;
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$txn_id' AND iextptg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ");
					$result = $query->result();
					$data['project_grp'] = $result;	

					$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_owner = '$oid' AND iextpt_aid='$aid'  ");
					$result = $query->result();
					$data['edit_grp'] = $result[0]->iextpt_tg_id;
				}
			}

			$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner='$oid' AND iuat_a_id = '$aid' ");
			$data['edit_todo'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_person as a LEFT JOIN i_customers as b on a.iuap_p_id = b.ic_id WHERE ic_owner = '$oid' AND iuap_owner = '$oid' AND iuap_a_id = '$aid' ");
			$data['edit_person'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_type_id = '$aid' AND icd_owner = '$oid' AND icd_type = 'activity_attach' ");
			$data['edit_files'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_type = 'activity_attach' AND icd_owner = '$oid' AND icd_type_id = '$aid' ");
			$data['edit_files'] = $query->result();

			$query = $this->db->query("SELECT iua_status FROM i_user_activity WHERE iua_status != '' AND iua_g_id = '$gid' GROUP BY iua_status");
			$result = $query->result();
			$data['status'] = $result;

			$query = $this->db->query("SELECT iua_place FROM i_user_activity WHERE iua_owner = '$oid' AND iua_place != '' AND iua_g_id = '$gid' GROUP BY iua_place");
			$result = $query->result();
			$data['place'] = $result;

			$query = $this->db->query("SELECT iua_categorise FROM i_user_activity WHERE iua_owner = '$oid' AND iua_categorise != '' AND iua_g_id = '$gid' GROUP BY iua_categorise");
			$result = $query->result();
			$data['cat'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['user_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			$this->load->view('activity_modal',$data);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function activity_update ($code,$aid,$option_type){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['code'] = $code;
			$dt = date('Y-m-d H:i:s');
			$title = $this->input->post('title');
			$type = $this->input->post('type');
			$f_date = $this->input->post('f_date');
			$t_date = $this->input->post('t_date');
			$repeat = $this->input->post('repeat');
			$repeat_end = $this->input->post('repeat_end');
			$color = $this->input->post('color');
			$mod_shortcut = $this->input->post('mod_shortcut');
			$category = $this->input->post('category');
			$todo = $this->input->post('todo');
			$notes = $this->input->post('notes');
			$person = $this->input->post('share');
			$location = $this->input->post('location');
			$remind = $this->input->post('remind');
			$priority = $this->input->post('priority');
			$project_grp = $this->input->post('project_grp');
			$txn_id = $this->input->post('txn_id');
			$flg = '0';
			if (count($todo) > 0 ) {
				$flg = '1';
			}

			if ($f_date == '' ) {
				$type = 'Note';
			}else{
				if ($t_date == '') {
					$t_date = $f_date;
				}
			}
			$fid = 0;
			$mod_id = 0;
			$query = $this->db->query("SELECT * from i_m_shortcuts where ims_id = '$mod_shortcut'");
			$result = $query->result();
			if (count($result) > 0) {
				$fid = $result[0]->ims_function;
				$mod_id = $result[0]->ims_m_id;	
			}

			$query = $this->db->query("SELECT * from i_user_activity where iua_id = '$aid' AND iua_owner = '$oid' ");
			$result = $query->result();
			$priv_repeat_date = $result[0]->iua_repeat_date;
			$priv_repeat_type = $result[0]->iua_repeat;
			$p_remind = $result[0]->iua_reminder;
			$paid = $result[0]->iua_p_activity;
			$today = date('Y-m-d' , strtotime($result[0]->iua_date));
			if ($paid == 0) {
				$query = $this->db->query("SELECT * from i_user_activity where iua_p_activity = '$aid' AND iua_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$paid = $aid;
				}
			}

			$this->repeat_activity_update($type,$title,$f_date,$location,$flg,$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);


			if ($type == 'project') {
				$data = array(
					'iextpt_tg_id' => $project_grp
				);
				$this->db->WHERE(array('iextpt_aid' => $aid ,'iextpt_owner' => $oid));
				$this->db->update('i_ext_pro_task', $data);
			}

		///////////////////////////// Comment out ///////////////////////////////

			if ($option_type != 'null' && $option_type != null && $option_type != 'this') {
				if ($repeat_end > $priv_repeat_date) {
					if ($repeat == $priv_repeat_type) {
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) BETWEEN '$today' AND '$priv_repeat_date' ");
						$result = $query->result();
						for ($i=0; $i < count($result) ; $i++) {
							$d_aid = $result[$i]->iua_id;
							$f_date = $result[$i]->iua_date;
							$t_date = $result[$i]->iua_end_date;
							$this->repeat_activity_update($type,$title,$f_date,$location,$flg,$oid,$uid,$dt,$category,$d_aid,$fid,$mod_id,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
						}

						$from_date = $priv_repeat_date;
						$to_date = $repeat_end;

						$this->count_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);

					}else{
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) > '$today' ");
						$result = $query->result();
						for ($i=0; $i <= count($result)-1 ; $i++) {
							$d_aid = $result[$i]->iua_id;
							$this->db->WHERE(array('iua_id' => $d_aid , 'iua_owner' => $oid ));
							$this->db->delete('i_user_activity');
						}

						$from_date = $today;
						$to_date = $repeat_end;
						$this->count_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);

					}
				}else if ($repeat_end < $priv_repeat_date) {
					if ($repeat == $priv_repeat_type) {
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) > '$repeat_end' ");
						$result = $query->result();
						for ($i=0; $i <= count($result)-1 ; $i++) {
							$d_aid = $result[$i]->iua_id;
							$this->db->WHERE(array('iua_id' => $d_aid , 'iua_owner' => $oid ));
							$this->db->delete('i_user_activity');
						}

						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) BETWEEN '$today' AND '$repeat_end' ");
						$result = $query->result();
						for ($i=0; $i < count($result) ; $i++) {
							$d_aid = $result[$i]->iua_id;
							$f_date = $result[$i]->iua_date;
							$t_date = $result[$i]->iua_end_date;
							$this->repeat_activity_update($type,$title,$f_date,$location,$flg,$oid,$uid,$dt,$category,$d_aid,$fid,$mod_id,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
						}
					}else{
						$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) > '$today' ");
						$result = $query->result();
						for ($i=0; $i <= count($result)-1 ; $i++) {
							$d_aid = $result[$i]->iua_id;
							$this->db->WHERE(array('iua_id' => $d_aid , 'iua_owner' => $oid ));
							$this->db->delete('i_user_activity');
						}

						$from_date = $today;
						$to_date = $repeat_end;
						$this->count_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);

					}
				}else if ($repeat != $priv_repeat_type ){
					$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) > '$today' ");
					$result = $query->result();
					for ($i=0; $i <= count($result) ; $i++) {
						$d_aid = $result[$i]->iua_id;
						$this->db->WHERE(array('iua_id' => $d_aid , 'iua_owner' => $oid ));
						$this->db->delete('i_user_activity');
					}

					$from_date = $today;
					$to_date = $repeat_end;
					$this->count_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}else{
					$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$paid' AND DATE(iua_date) > '$today' ");
					$result = $query->result();
					for ($i=0; $i < count($result) ; $i++) {
						$d_aid = $result[$i]->iua_id;
						$f_date = $result[$i]->iua_date;
						$t_date = $result[$i]->iua_end_date;
						$temp = $this->repeat_activity_update($type,$title,$f_date,$location,$flg,$oid,$uid,$dt,$category,$d_aid,$fid,$mod_id,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
					}
				}
			}
			echo $aid;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function activity_delete($code,$aid,$act_type){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['code'] = $code;

			$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$aid' AND iua_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$p_aid = $result[0]->iua_p_activity;
			}else{
				$p_aid = 0 ;
			}

			$this->db->WHERE(array('iua_id' => $aid , 'iua_owner' => $oid ));
			$this->db->delete('i_user_activity');

			$this->db->WHERE(array('iuat_a_id' => $aid));
			$this->db->delete('i_u_a_todo');

			$this->db->WHERE(array('iuap_a_id' => $aid));
			$this->db->delete('i_u_a_person');

			$this->db->WHERE(array('icd_type_id' => $aid , 'icd_owner' => $oid , 'icd_type' => 'activity_attach'));
			$this->db->delete('i_c_doc');

			if ($act_type != 'one_time') {
				$today = date('Y-m-d');
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner = '$oid' AND iua_type = 'Event' AND iua_p_activity = '$p_aid' AND DATE(iua_date) > '$today' ");
				$result = $query->result();
				for ($i=0; $i <= count($result)-1 ; $i++) {
					$d_aid = $result[$i]->iua_id;
					$this->db->WHERE(array('iua_id' => $d_aid , 'iua_owner' => $oid ));
					$this->db->delete('i_user_activity');

					$this->db->WHERE(array('iuat_a_id' => $d_aid));
					$this->db->delete('i_u_a_todo');

					$this->db->WHERE(array('iuap_a_id' => $d_aid));
					$this->db->delete('i_u_a_person');

					$this->db->WHERE(array('icd_type_id' => $d_aid , 'icd_owner' => $oid , 'icd_type' => 'activity_attach'));
					$this->db->delete('i_c_doc');
				}
			}

			$this->db->WHERE(array('iextpt_aid' => $aid , 'iextpt_owner' => $oid ,'iextpt_gid' => $gid));
			$this->db->delete('i_ext_pro_task');

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function count_activity_save($type,$title,$from_date,$location,$flg,$status,$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes){
		$today = date('Y-m-d H:i:s');
		if ($repeat == 'daily') {
			if ($repeat_end == '') {
				for ($i=0; $i < 364 ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime($from_date) + (60 * 60 * 24) );
					$to_date = date('Y-m-d H:i:s', strtotime($to_date) + (60 * 60 * 24) );

					$repeat_end = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($today)) );
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}else{
				$datediff = strtotime($repeat_end) - strtotime($from_date);
				$no_of_day = round($datediff / (60 * 60 * 24));

				for ($i=0; $i < $no_of_day ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime($from_date) + (60 * 60 * 24) );
					$to_date = date('Y-m-d H:i:s', strtotime($to_date) + (60 * 60 * 24) );

					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}
		}else if($repeat == 'one_time'){
		}else if($repeat == 'weekly'){
			if ($repeat_end == '') {
				for ($i=0; $i < 52 ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime($from_date) + (60 * 60 * 24 * 7) );
					$to_date = date('Y-m-d H:i:s', strtotime($to_date) + (60 * 60 * 24 * 7) );

					$repeat_end = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($today)) );
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}else{
				$datediff = strtotime($repeat_end) - strtotime($from_date);
				$no_of_day = round($datediff / (60 * 60 * 24 * 7));
				for ($i=0; $i < $no_of_day ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime($from_date) + (60 * 60 * 24 * 7) );
					$to_date = date('Y-m-d H:i:s', strtotime($to_date) + (60 * 60 * 24 * 7) );

					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}
		}else if($repeat == 'monthly'){
			if ($repeat_end == '') {
				for ($i=0; $i < 12 ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($from_date)) );
					$to_date = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($to_date)) );

					$repeat_end = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($today)) );
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}else{
				$datediff = strtotime($repeat_end) - strtotime($from_date);
				$no_of_month = round($datediff / (60 * 60 * 24 * 30));
				for ($i=0; $i < $no_of_month ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($from_date)) );
					$to_date = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($to_date)) );
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}
		}else if($repeat == 'yearly'){
			if ($repeat_end == '') {
				$from_date = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($from_date)) );
				$to_date = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($to_date)) );

				$repeat_end = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($today)) );
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
			}else{
				$datediff = strtotime($repeat_end) - strtotime($from_date);
				$no_of_year = round($datediff / (60 * 60 * 24 * 30 * 12));
				for ($i=0; $i < $no_of_year ; $i++) {
					$from_date = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($from_date)));
					$to_date = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($to_date)));
					
					$this->repeat_activity_save($type,$title,$from_date,$location,$flg,'pending',$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes);
				}
			}
		}
	}

	public function repeat_activity_save($type,$title,$from_date,$location,$flg,$status,$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$gid,$color,$to_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes,$parent_flg = false){
		if ($parent_flg == false) {
			$query = $this->db->query("SELECT * from i_user_activity where iua_id = '$aid' AND iua_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				if ($result[0]->iua_p_activity == 0) {
					$query = $this->db->query("SELECT * from i_user_activity where iua_p_activity = '$aid' AND iua_owner = '$oid' ");
					$result1 = $query->result();
					if (count($result1) > 0 ) {
						$aid = $result1[0]->iua_p_activity;
					}
				}else{
					$aid = $result[0]->iua_p_activity;
				}
			}	
		}

		$data = array(
			'iua_type' => $type,
			'iua_title' => $title,
			'iua_date' => $from_date,
			'iua_place' => $location,
			'iua_to_do' => $flg,
			'iua_status' => $status,
			'iua_owner' => $oid,
			'iua_created_by' => $uid,
			'iua_created' => $dt,
			'iua_categorise' => $category,
			'iua_p_activity' => $aid,
			'iua_shortcuts' => $fid,
			'iua_m_shortcuts' => $mod_id,
			'iua_g_id' => $gid,
			'iua_color' => $color,
			'iua_end_date' => $to_date,
			'iua_repeat' => $repeat,
			'iua_repeat_date' => $repeat_end,
			'iua_reminder' => $remind,
			'iua_priority' => $priority
		);
		$this->db->insert('i_user_activity',$data);
		$d_aid = $this->db->insert_id();

		for ($ij=0; $ij < count($todo); $ij++) {
			$data1 = array(
				'iuat_a_id' => $d_aid,
				'iuat_title' => $todo[$ij]['title'],
				'iuat_status' => $todo[$ij]['status'],
				'iuat_owner' => $oid
			);
			$this->db->insert('i_u_a_todo',$data1);
		}

		for ($i=0; $i <count($person) ; $i++) {
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
			$result = $query->result();

			$data = array(
				'iuap_a_id' => $d_aid,
				'iuap_p_id' => $result[0]->ic_id,
				'iuap_owner'=> $oid
			);
			$this->db->insert('i_u_a_person',$data);

			$data1 = array(
				'in_type_id' => $d_aid,
				'in_type' => 'activity',
				'in_m_id' => 0,
				'in_person' => $result[0]->ic_id,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt
			);
			$this->db->insert('i_notifications',$data1);
		}

		$str1 = preg_replace('/\s+/', ' ', trim($notes));
		if ($str1 != '' && $str1 != 'null') {
			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$txt_file = $d_aid.'.txt';
			file_put_contents($path.$txt_file, $notes);

			$data = array(
				'iua_note' => $txt_file	
			);
			$this->db->where('iua_id',$d_aid);
			$this->db->update('i_user_activity',$data);
		}

		$data2 = array(
			'iual_a_id' => $d_aid,
			'iual_owner' => $oid,
			'iual_created' => $dt,
			'iual_created_by' => $uid,
			'iual_title' => 'add'
		);
		$this->db->insert('i_u_a_log',$data2);

		$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
		$result = $query->result();
		$cid = $result[0]->i_ref;

		$data1 = array(
			'in_type_id' => $d_aid,
			'in_type' => 'activity',
			'in_m_id' => 0,
			'in_person' => $cid,
			'in_owner' => $oid,
			'in_status' => 0,
			'in_date' => $from_date
		);
		$this->db->insert('i_notifications',$data1);

		$currentDate = strtotime($from_date);
		if($remind == '5 min'){
			$futureDate = $currentDate-(60*5);
		}else if($remind == '15 min'){
			$futureDate = $currentDate-(60*15);
		}else if($remind == '30 min'){
			$futureDate = $currentDate-(60*30);
		}else if($remind == '1 hr'){
			$futureDate = $currentDate-(60*60);
		}
		if ($remind != 'never' && $remind != 'null') {
			$t_date = date("Y-m-d H:i:s", $futureDate);
			$data1 = array(
				'in_type_id' => $d_aid,
				'in_type' => 'activity',
				'in_m_id' => 0,
				'in_person' => $cid,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $t_date
			);
			$this->db->insert('i_notifications',$data1);
		}

		return $d_aid;
	}

	public function repeat_activity_update($type,$title,$f_date,$location,$flg,$oid,$uid,$dt,$category,$aid,$fid,$mod_id,$color,$t_date,$repeat,$repeat_end,$remind,$priority,$todo,$person,$notes){

		$query = $this->db->query("SELECT * from i_user_activity where iua_id = '$aid' AND iua_owner = '$oid' ");
		$result = $query->result();
		$priv_repeat_date = $result[0]->iua_repeat_date;
		$priv_repeat_type = $result[0]->iua_repeat;
		$p_remind = $result[0]->iua_reminder;
		$paid = $result[0]->iua_p_activity;
		if ($paid == 0) {
			$query = $this->db->query("SELECT * from i_user_activity where iua_p_activity = '$aid' AND iua_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$paid = $aid;
			}
		}

		$data = array(
			'iua_title' => $title,
			'iua_date' => $f_date,
			'iua_place' => $location,
			'iua_categorise' => $category,
			'iua_shortcuts' => $fid,
			'iua_m_shortcuts' => $mod_id,
			'iua_modify' => $dt,
			'iua_modified_by' => $uid,
			'iua_color' => $color,
			'iua_end_date' => $t_date,
			'iua_repeat' => $repeat,
			'iua_repeat_date' => $repeat_end,
			'iua_reminder' => $remind,
			'iua_priority' => $priority
		);
		$this->db->WHERE(array('iua_id'=>$aid , 'iua_owner' => $oid));
		$this->db->update('i_user_activity',$data);

		$this->db->WHERE(array('iuap_a_id'=>$aid , 'iuap_owner' => $oid));
		$this->db->delete('i_u_a_person');

		for ($i=0; $i <count($person) ; $i++) {
			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name = '".$person[$i]."'");
			$result = $query->result();

			$data = array(
				'iuap_a_id' => $aid,
				'iuap_p_id' => $result[0]->ic_id,
				'iuap_owner'=> $oid
			);
			$this->db->insert('i_u_a_person',$data);

			$data1 = array(
				'in_type_id' => $aid,
				'in_type' => 'activity',
				'in_m_id' => 0,
				'in_person' => $result[0]->ic_id,
				'in_owner' => $oid,
				'in_status' => 0,
				'in_date' => $dt
			);
			$this->db->insert('i_notifications',$data1);
		}


		$str1 = preg_replace('/\s+/', ' ', trim($notes));
		$note_file = '';
		if ($str1 != '' && $str1 != 'null') {
			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$txt_file = $aid.'.txt';
			file_put_contents($path.$txt_file, $notes);

			$data = array(
				'iua_note' => $txt_file	
			);
			$this->db->where('iua_id',$aid);
			$this->db->update('i_user_activity',$data);
			$note_file = $txt_file;
		}

		$data2 = array(
			'iual_a_id' => $aid,
			'iual_owner' => $oid,
			'iual_created' => $dt,
			'iual_created_by' => $uid,
			'iual_title' => 'update'
		);
		$this->db->insert('i_u_a_log',$data2);

		$this->db->WHERE(array('iuat_a_id'=>$aid , 'iuat_owner' => $oid));
		$this->db->delete('i_u_a_todo');

		for ($i=0; $i < count($todo); $i++) {
			$data1 = array(
				'iuat_a_id' => $aid,
				'iuat_title' => $todo[$i]['title'],
				'iuat_status' => $todo[$i]['status'],
				'iuat_owner' => $oid
			);
			$this->db->insert('i_u_a_todo',$data1);

			$data = array(
				'iua_to_do' => '1'
			);
			$this->db->where('iua_id',$aid);
			$this->db->update('i_user_activity',$data);
		}

		$this->db->WHERE(array('in_type_id'=>$aid , 'in_owner' => $oid , 'in_type' => 'activity' ));
		$this->db->delete('i_notifications');

		$query = $this->db->query("SELECT * FROM i_users WHERE i_uid = '$oid' ");
		$result = $query->result();
		$cid = $result[0]->i_ref;
		$data1 = array(
			'in_type_id' => $aid,
			'in_type' => 'activity',
			'in_m_id' => 0,
			'in_person' => $cid,
			'in_owner' => $oid,
			'in_status' => 0,
			'in_date' => $f_date
		);
		$this->db->insert('i_notifications',$data1);

		$currentDate = strtotime($f_date);
		if ($p_remind != $remind) {

			if($remind == '5 min'){
				$futureDate = $currentDate-(60*5);
			}else if($remind == '15 min'){
				$futureDate = $currentDate-(60*15);
			}else if($remind == '30 min'){
				$futureDate = $currentDate-(60*30);
			}else if($remind == '1 hr'){
				$futureDate = $currentDate-(60*60);
			}
			if ($remind != 'never' && $remind != 'null') {
				$t_date = date("Y-m-d H:i:s", $futureDate);
				$data1 = array(
					'in_type_id' => $aid,
					'in_type' => 'activity',
					'in_m_id' => 0,
					'in_person' => $cid,
					'in_owner' => $oid,
					'in_status' => 0,
					'in_date' => $t_date
				);
				$this->db->insert('i_notifications',$data1);
			}
		}

		return $aid;
	}
}