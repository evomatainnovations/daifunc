<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Broadcast extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->helper('directory');
		$this->load->dbforge();
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}

	public function home($mid=null,$code){
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
					if ($module[$i]->mname == 'Broadcast') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_broadcast WHERE iebrod_owner = '$oid' AND iebrod_gid = '$gid'");
			$result = $query->result();
			$data['brod_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_bro_contact WHERE iebrodc_brod_id IN(SELECT iebrod_id FROM i_ext_broadcast WHERE iebrod_owner = '$oid' AND iebrod_gid = '$gid')");
			$result = $query->result();
			$data['status_list'] = $result;

			$data['uid'] = $uid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['gid']=$gid;$ert['mid']=$mid;$ert['mname']=$mname;$ert['code']=$code;
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar',$ert);
			$this->load->view('broadcast/home',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function add_broadcast($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname = '';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Broadcast') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT ic_section FROM i_customers where ic_owner = '$uid' GROUP BY ic_section");
			$result = $query->result();
			$data['c_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = $oid");
			$data['email_temp'] = $query->result();

			$data['uid'] = $uid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $code;$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = "Add ".$mname;
			}else{
				$ert['title'] = "Add ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar',$ert);
			$this->load->view('broadcast/add_broadcast',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function email_temp($code,$temp_id){
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
			if ($temp_id != null) {
				$query = $this->db->query("SELECT * FROM i_user_email_template WHERE iuetemp_owner = '$oid' AND iuetemp_id = '$temp_id'");
				$result = $query->result();
				$data['temp_title'] = $result[0]->iuetemp_title;
				$upload_dir = $this->config->item('document_rt')."assets/data/".$oid."/email_template/";
				$file_name = $upload_dir.$result[0]->iuetemp_file;
				$data['temp_content'] = file_get_contents($file_name);
			}

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function broadcast_list($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$ctype = $this->input->post('ctype');

			$query = $this->db->query("SELECT * FROM i_property where ip_owner = '$oid' AND ip_property like '%email%'");
			$result = $query->result();
			$pid = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id where ic_owner = '$uid' AND ic_section = '$ctype' AND icbd_property = '$pid' ");
			$result = $query->result();
			$data['ctype_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function broadcast_mail($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$t_content = '';
			$t_type = $this->input->post('t_type');
			$t_content = $this->input->post('t_content');

			$m_user = $this->input->post('m_user');
			$m_subject = $this->input->post('m_subject');
			$camp_name = $this->input->post('camp_name');
			$camp_date = $this->input->post('camp_date');
			$dt = date('Y-m-d H:i:s');
			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);
			$path = $this->config->item('document_rt')."assets/data/".$oid."/broadcast/";
			if(!file_exists($path)) {
				mkdir($path, 0777, true);
			}

			if (is_dir($path)&& is_writable($path)) {
				$handle = fopen($path.$dt_str.$oid.'.txt', 'w') or die('Error');
				fwrite($handle, $t_content);
				fclose($handle);
			}

			$data = array(
				'iebrod_owner' => $oid,
				'iebrod_name' => $camp_name,
				'iebrod_date' => $camp_date,
				'iebrod_sub' => $m_subject,
				'iebrod_content_type' => $t_type,
				'iebrod_content' => $dt_str.$oid,
				'iebrod_created' => $dt,
				'iebrod_created_by' => $uid,
				'iebrod_gid' => $gid
			);
			$this->db->insert('i_ext_broadcast',$data);
			$inid = $this->db->insert_id();

			for ($i=0; $i <count($m_user) ; $i++) {
				$status = '';
				// eval("\$t_content = \"$t_content_main\";");
				if ($m_user[$i]['status'] == 'true') {
					$uid = $m_user[$i]['email'];
					$cid = $m_user[$i]['id'];

					// $t_content = $t_content.'<img style="display:none;" src="'.base_url().'Broadcast/check_status/'.$m_user[$i]['id'].'/'.$inid.'"/>';
					// $temp = $this->Mail->send_mail($m_subject,$uid,null,$t_content,$code);

					$data = array(
						'iebrodc_brod_id' => $inid,
						'iebrodc_oid' => $oid,
						'iebrodc_cid' => $m_user[$i]['id'],
						'iebrodc_status' => 'pending'
					);
					$this->db->insert('i_ext_bro_contact',$data);
					$b_inid = $this->db->insert_id();

					$data = array(
						'iextbmb_email_id' => $uid,
						'iextbmb_content' => $dt_str.$oid,
						'iextbmb_sub' => $m_subject,
						'iextbmb_brod_id' => $b_inid,
						'iextbmb_owner' => $oid,
						'iextbmb_date' => $camp_date
					);
					$this->db->insert('i_ext_broadcast_mail_batch',$data);
				}
			}
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function broadcast_test_mail($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			$t_type = $this->input->post('t_type');
			$t_content = $this->input->post('t_content');
			$m_user = $this->input->post('m_user');
			$m_subject = $this->input->post('m_subject');

			$temp = $this->Mail->send_mail($m_subject,$m_user,null,$t_content,$code);
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function check_status($inid){
		$this->db->WHERE(array('iebrodc_id'=>$inid));
		$this->db->update('i_ext_bro_contact',array('iebrodc_status' => 'view'));
	}

	public function edit_broadcast($code,$id){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$module = $sess_data['user_mod'];
			$mid=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Broadcast') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			} else {
				$data['dom'] = "[]";
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_broadcast WHERE iebrod_owner = '$oid' AND iebrod_gid = '$gid' AND iebrod_id = '$id' ");
			$result = $query->result();
			$data['brod_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_property where ip_owner = '$uid' AND ip_property like '%email%'");
			$result = $query->result();
			$pid = $result[0]->ip_id;

			$query = $this->db->query("SELECT * FROM i_customers as a left join i_c_basic_details as b on a.ic_id=b.icbd_customer_id left join i_ext_bro_contact as c on a.ic_id=c.iebrodc_cid WHERE icbd_property = '$pid' AND iebrodc_brod_id ='$id'");
			$result = $query->result();
			$data['status_list'] = $result;

			$data['inid'] = $id;
			$data['uid'] = $uid;
			$data['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $code;$ert['gid'] = $gid;$ert['mid']=$mid;$ert['mname']=$mname;
			if ($alias == '') {
				$ert['title'] = "Edit ".$mname;
			}else{
				$ert['title'] = "Edit ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar',$ert);
			$this->load->view('broadcast/edit_broadcast',$data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function fail_broadcast_mail($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$t_content = '';
			$m_user = $this->input->post('m_user');
			$query = $this->db->query("SELECT * FROM i_ext_broadcast WHERE iebrod_owner = '$oid' AND iebrod_gid = '$gid' AND iebrod_id = $inid");
			$result = $query->result();
			if (count($result) > 0) {
				$m_subject = $result[0]->iebrod_sub;
				$t_type = $result[0]->iebrod_content_type;
				$t_content_file = $result[0]->iebrod_content;
			}
			$path = $this->config->item('document_rt')."assets/data/".$oid."/broadcast/".$t_content_file.'.txt';
			$t_content_main = file_get_contents($path);

			$query = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result = $query->result();

			for ($i=0; $i <count($m_user) ; $i++) {
				$status = '';
				eval("\$t_content = \"$t_content_main\";");
				$uid = $m_user[$i]['email'];
				$t_content = $t_content.'<img style="display:none;" src="'.base_url().'Broadcast/check_status/'.$m_user[$i]['id'].'/'.$inid.'"/>';
				$temp = $this->Mail->send_mail($m_subject,$uid,null,$t_content,$code);
				$this->db->WHERE(array('iebrodc_brod_id' => $inid,'iebrodc_cid' => $m_user[$i]['id'],'iebrodc_oid' => $oid));
				$this->db->update('i_ext_bro_contact',array('iebrodc_status' => $temp));
			}
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function delete_broadcast($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->where(array('iebrod_id' => $inid, 'iebrod_owner'=>$oid));
			$this->db->delete('i_ext_broadcast');

			redirect(base_url().'Broadcast/home/null/'.$code);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function discard_broadcast_list($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->where(array('iebrodc_brod_id' => $inid, 'iebrodc_status' => 'false', 'iebrodc_oid'=>$oid));
			$this->db->delete('i_ext_bro_contact');

			redirect(base_url().'Broadcast/edit_broadcast/'.$code.'/'.$inid);
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function discard_broadcast($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;

			$this->db->where(array('iebrodc_id' => $inid, 'iebrodc_status' => 'false', 'iebrodc_oid'=>$oid));
			$this->db->delete('i_ext_bro_contact');

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function broadcast_mail_send(){
		$dt = date('Y-m-d');
		$query = $this->db->query("SELECT * FROM i_ext_broadcast_mail_batch WHERE date(iextbmb_date) <= '$dt' ORDER BY iextbmb_id ASC limit 50");
		$result = $query->result();
		if (count($result) > 0 ) {
			for ($i=0; $i < count($result) ; $i++) {
				$id = $result[$i]->iextbmb_id;
				$content_file = $result[$i]->iextbmb_content;
				$sub = $result[$i]->iextbmb_sub;
				$oid = $result[$i]->iextbmb_owner;
				$email = $result[$i]->iextbmb_email_id;
				$inid = $result[$i]->iextbmb_brod_id;

				$path = $this->config->item('document_rt')."assets/data/".$oid."/broadcast/".$content_file.'.txt';
				$t_content_main = file_get_contents($path);

				$status = '';
				eval("\$t_content = \"$t_content_main\";");

				$t_content = $t_content.'<img style="display:none;" src="'.base_url().'Broadcast/check_status/'.$inid.'"/>';

				$temp = $this->Mail->broadcast_mail($sub,$email,$t_content,$oid);
				$this->db->WHERE(array('iebrodc_brod_id' => $inid,'iebrodc_oid' => $oid));
				$this->db->update('i_ext_bro_contact',array('iebrodc_status' => $temp));

				$this->db->WHERE(array('iextbmb_id' => $id,'iextbmb_owner' => $oid));
				$this->db->delete('i_ext_broadcast_mail_batch');
			}
		}
	}
}