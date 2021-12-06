<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		//$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		
		$this->load->dbforge();
	}
############ RESEARCH #################

	public function research(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
			$data['oid'] = $oid;

			$module = $sess_data['user_mod'];
			// print_r($module);
			 if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
			} else {
				$data['dom'] = "[]";
			}
			$dt = date('Y-m-d H:i:s');
			
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == "Research") {
					$mid = $module[$i]->mid;
				}
			}

			$data1 = array(
				'iuh_owner' => $oid,
				'iuh_mid' => $mid, 
				'iuh_date' => $dt
			);
			$this->db->insert('i_user_history', $data1);

			$query=$this->db->query("SELECT * FROM i_ext_research WHERE iextre_owner='$oid'");
			$result = $query->result();
			$data['research'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Research";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('research/research',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function research_add(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

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
			} else {
				$data['dom'] = "[]";
			}
 
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Research";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('research/research_add',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function research_save(){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$dt = date('Y-m-d H:i:s');

			$data = array(
				'iextre_title' => $this->input->post('re_title'),
				'iextre_owner' => $oid,
				'iextre_created_by' => $uid,
				'iextre_created' => $dt
			);
			$this->db->insert('i_ext_research', $data);
			$rid = $this->db->insert_id();
			
			
			$data1 = array(
				'iextred_r_id' => $rid,
				'iextred_title' => $this->input->post('n_title'),
				'iextred_link' => $this->input->post('n_link'),
				'iextred_image' => '',
				'iextred_desc' => $this->input->post('n_desc'),
				'iextred_p_id' => $this->input->post('n_parent'),
				'iextred_owner' => $oid,
				'iextred_created_by' => $uid,
				'iextred_created' => $dt
			);
			$this->db->insert('i_ext_research_details', $data1);
			$in_id = $this->db->insert_id();
			echo $in_id;
			
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function research_edit($rid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$data['rid'] = $rid;
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

			$query = $this->db->query("SELECT * FROM i_ext_research WHERE iextre_owner='$oid' AND iextre_id='$rid'");
			$data['edit_research'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid' AND iextred_p_id='0'");
			$data['edit_r_details'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid'");
			$data['edit_r_d_full'] = $query->result();

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Research";
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('research/research_add',$data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}


	public function get_nodes($rid, $nid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
			$query = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid' AND iextred_p_id='$nid'");
			$data['nodes'] = $query->result();

			$query1 = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid' AND iextred_id='$nid'");
			$data['details'] = $query1->result();
			
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_parent_nodes($rid,$flg, $p=null){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;

			if ($p!=null) {
				$que = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid' AND iextred_id='$flg'");
				$res = $que->result();
				if (count($res) > 0) {
					$flg = $res[0]->iextred_p_id;
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id='$rid' AND iextred_id ='$flg'");
			$result = $query->result();

			if (count($result) > 0) {
				$flg = $result[0]->iextred_p_id;
				if ($flg != 0) {
					$data['details'] = $result;
				} else {
					$data['details'] = [];
				}
			}

			$query1 = $this->db->query("SELECT * FROM i_ext_research_details WHERE iextred_owner='$oid' AND iextred_r_id ='$rid' AND iextred_p_id= '$flg'");
			$data['nodes'] = $query1->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function get_node_details($rid, $nid){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			
			
			print_r(json_encode($query->result()));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function research_update($rid,$flg=null){
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$dt = date('Y-m-d H:i:s');

			if ($flg==null) {
				$data = array(
					'iextre_title' => $this->input->post('re_title'),
					'iextre_modified_by' => $uid,
					'iextre_modified' => $dt
				);

				$this->db->where(array('iextre_id' => $rid, 'iextre_owner' => $oid));
				$this->db->update('i_ext_research', $data);
				
				$data1 = array(
					'iextred_r_id' => $rid,
					'iextred_title' => $this->input->post('n_title'),
					'iextred_link' => $this->input->post('n_link'),
					'iextred_desc' => $this->input->post('n_desc'),
					'iextred_p_id' => $this->input->post('n_parent'),
					'iextred_owner' => $oid,
					'iextred_created_by' => $uid,
					'iextred_created' => $dt
				);
				$this->db->insert('i_ext_research_details', $data1);
				echo $this->db->insert_id();
			} else {
				$data = array(
					'iextre_title' => $this->input->post('re_title'),
					'iextre_modified_by' => $uid,
					'iextre_modified' => $dt
				);

				$this->db->where(array('iextre_id' => $rid, 'iextre_owner' => $oid));
				$this->db->update('i_ext_research', $data);
				
				$data1 = array(
					'iextred_title' => $this->input->post('n_title'),
					'iextred_link' => $this->input->post('n_link'),
					'iextred_desc' => $this->input->post('n_desc'),
					'iextred_p_id' => $this->input->post('n_parent'),
					'iextred_modified_by' => $uid,
					'iextred_modified' => $dt
				);
				$this->db->where(array('iextred_r_id' => $rid, 'iextred_owner' => $oid, 'iextred_id' => $flg));
				$this->db->update('i_ext_research_details', $data1);
				echo $flg;	
			}
			
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function data_upload($status,$in_id){

		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$module = $sess_data['user_mod'];
			$dt = date('Y-m-d H:i:s');


			$upload_dir = $this->config->item('document_rt').'assets/uploads/'.$oid.'/research/';
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

			$data = array('iextred_image' => $img_path);
			$this->db->where(array('iextred_id' => $in_id, 'iextred_owner' => $oid));
			$this->db->update('i_ext_research_details', $data);

			echo "true";
		} else {
			redirect(base_url().'account/login');
		}
	}
		

}	