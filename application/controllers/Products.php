<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
	}

	public function index() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$query = $this->db->query("SELECT * FROM i_product");
			$result = $query->result();

			$data['product'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Products";
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('product/product', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function products_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$query = $this->db->query("SELECT * FROM i_tags");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['title'] = "Products";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('product/product_add', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_products() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$pr_name = $this->input->post('name');
			$pr_feature = $this->input->post('feature');
			$pr_tags = $this->input->post('tags');
			$dt = date('Y-m-d H:i:s');

			$oid = $sess_data['user_details'][0]->i_uid;

			$data = array(
				'ip_product' => $pr_name,
				'ip_owner' => $oid,
				'ip_created' => $dt,
				'ip_created_by' => $oid );

			$this->db->insert('i_product', $data);
			$prid = $this->db->insert_id();

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
			$query = $this->db->query("SELECT * FROM i_tags");
			$result = $query->result();

			$data['tags'] = $result;
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_id='$p_id'");
			$result = $query->result();

			$data['edit_product'] = $result;
			
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
			$this->load->view('product/product_add', $data);	
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function update_products($prid) {
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
}
