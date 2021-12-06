<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_data extends CI_Controller {

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

	public function db_insert(){

	############################### Contact and property ##############################
		$file = $this->config->item('document_rt').'import_data/cust_list.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$cust_array = array();
			$cust_arr = [] ;
			foreach ($lines as $line) {
				$cust_array[] = str_getcsv($line);
			}
			$old_oid = 2;
			$new_oid = 6;
			$file = $this->config->item('document_rt').'import_data/property.csv';
			$ext = pathinfo($file);
			if ($ext['extension'] == 'csv') {
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$property_arr = array();

				foreach ($lines as $line) {
					$property_arr[] = str_getcsv($line);
				}
			}
			$prop_arr = [];
			for ($j=1; $j < count($property_arr) ; $j++) { 
				$old_pid = $property_arr[$j][0];
				if ($old_oid == $property_arr[$j][2]) {

					$data = array(
						'ip_property' => $property_arr[$j][1],
						'ip_owner' => $new_oid,
						'ip_section' => $property_arr[$j][3]
					);
					$this->db->insert('i_property',$data);
					$new_pid = $this->db->insert_id();	
					array_push($prop_arr, array('new_pid' => $new_pid, 'old_pid' => $old_pid ));
				}
			}
			
			$file = $this->config->item('document_rt').'import_data/cust_details.csv';
			$ext = pathinfo($file);
			if ($ext['extension'] == 'csv') {
				$csvData = file_get_contents($file);
				$lines = explode(PHP_EOL, $csvData);
				$c_details_arr = array();

				foreach ($lines as $line) {
					$c_details_arr[] = str_getcsv($line);
				}
			}

			for ($i=1; $i < count($cust_array) ; $i++) {
				if ($cust_array[$i][2] == $old_oid ) {
					$old_cid = $cust_array[$i][0];
					$data = array(
						'ic_name' => $cust_array[$i][1],
						'ic_owner' => $new_oid,
						'ic_created' => $cust_array[$i][3],
						'ic_created_by' => $new_oid,
						'ic_modified' => $cust_array[$i][5],
						'ic_modified_by' => $new_oid,
						'ic_section' => $cust_array[$i][7]
					);
					$this->db->insert('i_customers',$data);
					$new_cid = $this->db->insert_id();
					array_push($cust_arr, array('old_id' => $old_cid , 'new_id' => $new_cid ));

					for ($ij=0; $ij < count($c_details_arr) ; $ij++) {
						$old_pid = $c_details_arr[$ij][2];
						for ($j=0; $j < count($prop_arr) ; $j++) {
							if ($old_pid == $prop_arr[$j]['old_pid']) {
								$new_pid = $prop_arr[$j]['new_pid'];
								break;
							}
						}
						if ($old_cid == $c_details_arr[$ij][1]) {
							$data = array(
								'icbd_customer_id' => $new_cid,
								'icbd_property' => $new_pid,
								'icbd_value' => $c_details_arr[$ij][3]
							);
							$this->db->insert('i_c_basic_details',$data);
						}
					}
				}	
			}
		}
	############################### TAX ###################################
		$tax_arr = [];
		array_push($tax_arr, array( 'old_tax' => 1 , 'new_tax' => 12 ));
		array_push($tax_arr, array( 'old_tax' => 2 , 'new_tax' => 10 ));
		array_push($tax_arr, array( 'old_tax' => 3 , 'new_tax' => 10 ));
		array_push($tax_arr, array( 'old_tax' => 4 , 'new_tax' => 11 ));

	############################### Documents ##############################
		$doc_arr = [];
		$file = $this->config->item('document_rt').'import_data/document_terms.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$document_arr = array();

			foreach ($lines as $line) {
				$document_arr[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($document_arr) ; $i++) {
			if ($document_arr[$i][3] == $old_oid ) {
				$old_doc_id = $document_arr[$i][0];
				if ($document_arr[$i][2] == "Quotation" ) {
					$type = 'Proposal';
				}else if ($document_arr[$i][2] == "AMC" ) {
					$type = 'Subscription';
				}else{
					$type = $document_arr[$i][2];
				}
				$data = array(
					'iextdt_term' => $document_arr[$i][1],
					'iextdt_document' => $type,
					'iextdt_owner' => $new_oid,
					'iextdt_created' => $document_arr[$i][4],
					'iextdt_created_by' =>  $new_oid
				);
				$this->db->insert('i_ext_et_document_terms',$data);
				$new_doc_id = $this->db->insert_id();
				array_push($doc_arr, array('old_id' => $old_doc_id , 'new_id' => $new_doc_id , 'term' => $document_arr[$i][1] ,'type' => $type ));
			}
		}
	############################### Tags ##############################
		$tag_arr = [] ;
		$file = $this->config->item('document_rt').'import_data/tag_list.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$tag_array = array();

			foreach ($lines as $line) {
				$tag_array[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($tag_array) ; $i++) {
			if ($tag_array[$i][2] == $old_oid ) {
				$old_tag_id = $tag_array[$i][0];
				$data = array(
					'it_value' => $tag_array[$i][1],
					'it_owner' => $new_oid
				);
				$this->db->insert('i_tags',$data);
				$new_tag_id = $this->db->insert_id();
				array_push($tag_arr, array('old_id' => $old_tag_id , 'new_id' => $new_tag_id ));
			}
		}
	############################### Product ##############################

		$file = $this->config->item('document_rt').'import_data/product_list.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_arr = array();

			foreach ($lines as $line) {
				$product_arr[] = str_getcsv($line);
			}
		}
		$prod_arr = [] ;
		for ($i=1; $i < count($product_arr) ; $i++) {
			if ($product_arr[$i][2] == $old_oid ) {
				$old_product_id = $product_arr[$i][0];
				$data = array(
					'ip_product' => $product_arr[$i][1],
					'ip_owner' => $new_oid,
					'ip_created' => $product_arr[$i][3],
					'ip_created_by' => $new_oid,
					'ip_modified' => $product_arr[$i][5],
					'ip_modified_by' => $new_oid,
					'ip_section' => $product_arr[$i][7],
					'ip_gid' => 0,
					'ip_cat_id' => 0,
				);
				$this->db->insert('i_product',$data);
				$new_product_id = $this->db->insert_id();
				array_push($prod_arr, array('old_pid' => $old_product_id , 'new_pid' => $new_product_id ));
			}
		}

		$file = $this->config->item('document_rt').'import_data/product_additional_info.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_add_arr = array();
			foreach ($lines as $line) {
				$product_add_arr[] = str_getcsv($line);
			}
		}
		$unit_arr = [];
		array_push($unit_arr, array('old_id' => 1, 'new_id' => 199 ));
		array_push($unit_arr, array('old_id' => 2, 'new_id' => 200 ));


		for ($i=1; $i < count($product_add_arr) ; $i++) {
			if ($product_add_arr[$i][5] == $old_oid ) {
				$old_pid = $product_add_arr[$i][1];
				for ($ij=0; $ij <count($prod_arr) ; $ij++) {
					if ($old_pid == $prod_arr[$ij]['old_pid']) {
						$new_product_id = $prod_arr[$ij]['new_pid'];
						$unit_id = '';
						for ($ijk=0; $ijk < count($unit_arr) ; $ijk++) { 
							if ($unit_arr[$ijk]['old_id'] == $product_add_arr[$i][4] ) {
								$unit_id = $unit_arr[$ijk]['new_id'];
							}
						}
						$data = array(
							'ipai_p_id' => $new_product_id,
							'ipai_hsn_code' => $product_add_arr[$i][2],
							'ipai_description' => $product_add_arr[$i][3],
							'ipai_unit' => $unit_id,
							'ipai_owner' => $new_oid
						);
						$this->db->insert('i_p_additional_info',$data);
						break;
					}
				}
			}
		}
		
		$file = $this->config->item('document_rt').'import_data/product_features.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_features = array();
			foreach ($lines as $line) {
				$product_features[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($product_features) ; $i++) {
			$pid = 0 ;
			for ($ij=0; $ij < count($prod_arr) ; $ij++) {
				if ($product_features[$i][1] == $prod_arr[$ij]['old_pid'] ) {
					$pid = $prod_arr[$ij]['new_pid'];
				}
			}
			if ($pid != 0) {
				$data = array(
					'ipf_product_id' => $pid,
					'ipf_feature' => $product_features[$i][2]
				);
				$this->db->insert('i_p_features',$data);	
			}
		}

		$file = $this->config->item('document_rt').'import_data/product_f_tag.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_f_tag = array();
			foreach ($lines as $line) {
				$product_f_tag[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($product_f_tag) ; $i++) {
			$tid = 0 ;$pid = 0;
			for ($ij=0; $ij < count($prod_arr) ; $ij++) { 
				if ($product_f_tag[$i][1] == $prod_arr[$ij]['old_pid'] ) {
					$pid = $prod_arr[$ij]['new_pid'];
				}
			}
			for ($ik=0; $ik < count($tag_arr) ; $ik++) { 
				if ($product_f_tag[$i][2] == $tag_arr[$ik]['old_id'] ) {
					$tid = $tag_arr[$ik]['new_id'];
				}
			}
			if ($tid != 0 && $pid != 0 ) {
				$data = array(
					'ipft_product_id' => $pid,
					'ipft_tag_id' => $tid,
					'ipft_owner' => $new_oid
				);
				$this->db->insert('i_p_f_tags',$data);	
			}
		}

		$file = $this->config->item('document_rt').'import_data/product_price.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_price = array();
			foreach ($lines as $line) {
				$product_price[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($product_price) ; $i++) {
			$pid = 0;
			for ($ij=0; $ij < count($prod_arr) ; $ij++) { 
				if ($product_price[$i][1] == $prod_arr[$ij]['old_pid'] ) {
					$pid = $prod_arr[$ij]['new_pid'];
				}
			}
			if ($pid != 0 ) {
				$data = array(
					'ipp_p_id' => $pid,
					'ipp_alias' => $product_price[$i][2],
					'ipp_cost_price' => $product_price[$i][3],
					'ipp_sell_price' => $product_price[$i][4],
					'ipp_active_date' => $product_price[$i][5]
				);
				$this->db->insert('i_p_price',$data);
			}
		}		

		$file = $this->config->item('document_rt').'import_data/product_taxes.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$product_tax = array();
			foreach ($lines as $line) {
				$product_tax[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($product_tax) ; $i++) {
			$pid = 0;$tax_id = 0;
			if ($product_tax[$i][3] == $old_oid) {
				for ($ij=0; $ij < count($prod_arr) ; $ij++) { 
					if ($product_tax[$i][1] == $prod_arr[$ij]['old_pid'] ) {
						$pid = $prod_arr[$ij]['new_pid'];
					}
				}
				for ($ij=0; $ij < count($tax_arr) ; $ij++) { 
					if ($product_tax[$i][2] == $tax_arr[$ij]['old_tax'] ) {
						$tax_id = $tax_arr[$ij]['new_tax'];
					}
				}
				if ($pid != 0 && $tax_id != 0) {
					$data = array(
						'ipt_p_id' => $pid,
						'ipt_t_id' => $tax_id,
						'ipt_oid' => $new_oid,
						'ipt_created' => $product_tax[$i][4],
						'ipt_created_by' => $new_oid,
						'ipt_modified' => $product_tax[$i][6],
						'ipt_modified_by' => $new_oid
					);
					$this->db->insert('i_p_taxes',$data);
				}
			}
		}
	############################### AMC ##############################

		$file = $this->config->item('document_rt').'import_data/AMC.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$amc = array();
			foreach ($lines as $line) {
				$amc[] = str_getcsv($line);
			}
		}
		$amc_arr = [];
		for ($i=0; $i < count($amc) ; $i++) {
			if ($amc[$i][10] == $old_oid ) {
				$cid = 0 ;
				for ($ij=0; $ij <count($cust_arr) ; $ij++) { 
					if ($cust_arr[$ij]['old_id'] == $amc[$i][1]) {
						$cid = $cust_arr[$ij]['new_id'];
						break;
					}
				}
				if ($cid != 0) {
					$old_id = $amc[$i][0];
					$data = array(
						'iextamc_customer_id' => $cid,
						'iextamc_txn_id' => $amc[$i][2],
						'iextamc_txn_date' => $amc[$i][3],
						'iextamc_period_from' => $amc[$i][4],
						'iextamc_period_to' => $amc[$i][5],
						'iextamc_type' => 'formal',
						'iextamc_owner' => $new_oid,
						'iextamc_created' => $amc[$i][11],
						'iextamc_created_by' => $new_oid,
						'iextamc_status' => $amc[$i][8],
						'iextamc_note' => $amc[$i][9],
						'iextamc_gid' => 0,
						'iextamc_amount' => $amc[$i][7]
					);
					$this->db->insert('i_ext_et_amc', $data);
					$new_id = $this->db->insert_id();

					$file = $this->config->item('document_rt').'import_data/amc_product.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$amc_product = [];
						foreach ($lines as $line) {
							$amc_product[] = str_getcsv($line);
						}
					}
					for ($ij=0; $ij < count($amc_product) ; $ij++) { 
						if ($amc_product[$ij][1] == $old_id) {
							for ($ijk=0; $ijk < count($prod_arr) ; $ijk++) { 
								if ($prod_arr[$ijk]['old_pid'] == $amc_product[$ij][2] ) {
									$pid = $prod_arr[$ijk]['new_pid'];
								}
							}
							$data = array(
								'iextamcpd_d_id' => $new_id,
								'iextamcpd_product_id' => $pid,
								'iextamcpd_qty' => $amc_product[$ij][6],
								'iextamcpd_serial_number' => $amc_product[$ij][4],
								'iextamcpd_owner' => $new_oid,
								'iextamcpd_alias' => $amc_product[$ij][12],
							);
							$this->db->insert('i_ext_et_amc_product_details', $data);
						}
					}

					$file = $this->config->item('document_rt').'import_data/amc_tags.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$amc_tags = [];
						foreach ($lines as $line) {
							$amc_tags[] = str_getcsv($line);
						}
					}
					for ($ij=0; $ij < count($amc_tags) ; $ij++) { 
						if ($amc_tags[$ij][1] == $old_id) {
							for ($ijk=0; $ijk < count($tag_arr) ; $ijk++) { 
								if ($tag_arr[$ijk]['old_id'] == $amc_tags[$ij][2] ) {
									$tid = $tag_arr[$ijk]['new_id'];
								}
							}
							$data = array(
								'iet_type_id' => $new_id,
								'iet_type' => 'subscription',
								'iet_tag_id' => $tid,
								'iet_owner' => $new_oid,
								'iet_m_id' => 42
							);
							$this->db->insert('i_ext_tags', $data);
						}
					}
				}
			}
		}

	############################### Inventory ########################
		$file = $this->config->item('document_rt').'import_data/inventory.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$inv = array();
			foreach ($lines as $line) {
				$inv[] = str_getcsv($line);
			}
		}
		$amc_arr = [];
		for ($i=0; $i < count($inv) ; $i++) {
			if ($inv[$i][5] == $old_oid ) {
				$cid = '' ;
				for ($ij=0; $ij <count($cust_arr) ; $ij++) { 
					if ($cust_arr[$ij]['old_id'] == $inv[$i][1]) {
						$cid = $cust_arr[$ij]['new_id'];
						break;
					}
				}
				// if ($cid != 0) {
					$old_id = $inv[$i][0];
					$data = array(
						'iextei_customer_id' => $cid,
						'iextei_txn_id' => $inv[$i][2],
						'iextei_txn_date' => $inv[$i][3],
						'iextei_type' => $inv[$i][4],
						'iextei_owner' => $new_oid,
						'iextei_created' => $inv[$i][6],
						'iextei_created_by' => $new_oid,
						'iextei_modified' => $inv[$i][8],
						'iextei_modified_by' => $new_oid,
						'iextei_gid' => 0,
						'iextei_fid' => $new_oid
					);
					$this->db->insert('i_ext_et_inventory', $data);
					$new_id = $this->db->insert_id();

					$file = $this->config->item('document_rt').'import_data/inventory_details.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$inv_product = [];
						foreach ($lines as $line) {
							$inv_product[] = str_getcsv($line);
						}
					}
					for ($ij=0; $ij < count($inv_product) ; $ij++) { 
						if ($inv_product[$ij][1] == $old_id) {
							for ($ijk=0; $ijk < count($prod_arr) ; $ijk++) {
								if ($prod_arr[$ijk]['old_pid'] == $inv_product[$ij][2] ) {
									$pid = $prod_arr[$ijk]['new_pid'];
									break;
								}
							}
							if ($inv[$i][4] == 'inward') {
								$bal = $inv_product[$ij][3];
							}else{
								$bal = $inv_product[$ij][4];
							}
							$data = array(
								'iexteid_e_id' => $new_id,
								'iexteid_product_id' => $pid,
								'iexteid_inward' => 0,
								'iexteid_outward' => 0,
								'iexteid_balance' => $bal,
								'iexteid_owner' => $new_oid,
								'iexteid_serial_number' => $inv_product[$ij][8],
								'iexteid_alias' => $inv_product[$ij][9]
							);
							$this->db->insert('i_ext_et_inventory_details', $data);
						}
					}
				// }
			}
		}

	############################### Invoice ########################
		$temp_array = [] ;
		array_push($temp_array, array('tid' => 6 , 'tgid' => 10 ));
		array_push($temp_array, array('tid' => 7 , 'tgid' => 10 ));
		array_push($temp_array, array('tid' => 8 , 'tgid' => 11 ));
		array_push($temp_array, array('tid' => 9 , 'tgid' => 11 ));
		// array_push($temp_array, array('tid' => 6 , 'tgid' => 88 ));
		// array_push($temp_array, array('tid' => 7 , 'tgid' => 88 ));
		// array_push($temp_array, array('tid' => 8 , 'tgid' => 89 ));
		// array_push($temp_array, array('tid' => 9 , 'tgid' => 89 ));

		$file = $this->config->item('document_rt').'import_data/invoice.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$invoice = array();
			foreach ($lines as $line) {
				$invoice[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($invoice) ; $i++) {
			if ($invoice[$i][10] == $old_oid ) {
				$cid = '' ;
				for ($ij=0; $ij <count($cust_arr) ; $ij++) { 
					if ($cust_arr[$ij]['old_id'] == $invoice[$i][1]) {
						$cid = $cust_arr[$ij]['new_id'];
						break;
					}
				}
				// if ($cid != 0) {
					$old_id = $invoice[$i][0];
					$data = array(
						'iextein_customer_id' => $cid,
						'iextein_txn_id' => $invoice[$i][2],
						'iextein_txn_date' => $invoice[$i][3],
						'iextein_type' => 'formal',
						'iextein_amount' => $invoice[$i][5],
						'iextein_status' => $invoice[$i][6],
						'iextein_note' => $invoice[$i][7],
						'iextein_owner' => $new_oid,
						'iextein_created' => $invoice[$i][9],
						'iextein_created_by' => $new_oid,
						'iextein_modified' => $invoice[$i][11],
						'iextein_modified_by' => $new_oid,
						'iextein_gid' => 0
					);
					$this->db->insert('i_ext_et_invoice', $data);
					$new_id = $this->db->insert_id();

					$file = $this->config->item('document_rt').'import_data/invoice_details.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$invoice_product = [];
						foreach ($lines as $line) {
							$invoice_product[] = str_getcsv($line);
						}
					}
					for ($ij=0; $ij < count($invoice_product) ; $ij++) { 
						if ($invoice_product[$ij][1] == $old_id) {
							$pid = 0;
							for ($ijk=0; $ijk < count($prod_arr) ; $ijk++) {
								if ($prod_arr[$ijk]['old_pid'] == $invoice_product[$ij][2] ) {
									$pid = $prod_arr[$ijk]['new_pid'];
									break;
								}
							}
							if ($pid != 0) {
								$file = $this->config->item('document_rt').'import_data/invoice_tax.csv';
								$ext = pathinfo($file);
								if ($ext['extension'] == 'csv') {
									$csvData = file_get_contents($file);
									$lines = explode(PHP_EOL, $csvData);
									$invoice_tax = [];
									foreach ($lines as $line) {
										$invoice_tax[] = str_getcsv($line);
									}
								}
								$old_in_id = $invoice_product[$ij][0];

								$disc = $invoice_product[$ij][7];
								$disc = str_replace('%',"",$disc);
								$data = array(
									'iexteinpd_d_id' => $new_id,
									'iexteinpd_product_id' => $pid,
									'iexteinpd_rate' => $invoice_product[$ij][5],
									'iexteinpd_qty' => $invoice_product[$ij][6],
									'iexteinpd_discount' => $disc,
									'iexteinpd_serial_number' => $invoice_product[$ij][4],
									'iexteinpd_amount' => $invoice_product[$ij][8],
									'iexteinpd_owner' => $new_oid,
									'iexteinpd_alias' => $invoice_product[$ij][12]
								);
								$this->db->insert('i_ext_et_invoice_product_details', $data);
								$new_in_id = $this->db->insert_id();
								$tax_gid = 0 ;
								for ($ik=1; $ik < count($invoice_tax) ; $ik++) {
									for ($jk=0; $jk < count($temp_array) ; $jk++) {
										if ($invoice_tax[$ik][3] == $temp_array[$jk]['tid'] && $invoice_tax[$ik][2] == $old_in_id && $invoice_tax[$ik][1] == $old_id ) {
											$tax_gid = $temp_array[$jk]['tgid'];
											break;
										}
									}
								}
								if ($tax_gid != 0) {
									$data = array('iexteinpd_tax' => $tax_gid);
									$this->db->where(array('iexteinpd_id' => $new_in_id, 'iexteinpd_owner' => $new_oid ));
									$this->db->update('i_ext_et_invoice_product_details', $data);
								}
							}
						}
					}
				// }
			}
		}
	############################### Quotation ########################
		
		$file = $this->config->item('document_rt').'import_data/quotation.csv';
		$ext = pathinfo($file);
		if ($ext['extension'] == 'csv') {
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			$proposal = array();
			foreach ($lines as $line) {
				$proposal[] = str_getcsv($line);
			}
		}
		for ($i=1; $i < count($proposal) ; $i++) {
			if ($proposal[$i][8] == $old_oid ) {
				$cid = '' ;
				for ($ij=0; $ij <count($cust_arr) ; $ij++) { 
					if ($cust_arr[$ij]['old_id'] == $proposal[$i][1]) {
						$cid = $cust_arr[$ij]['new_id'];
						break;
					}
				}
					$old_id = $proposal[$i][0];
					$data = array(
						'iextepro_customer_id' => $cid,
						'iextepro_txn_id' => $proposal[$i][2],
						'iextepro_txn_date' => $proposal[$i][3],
						'iextepro_type' => 'formal',
						'iextepro_amount' => $proposal[$i][5],
						'iextepro_status' => $proposal[$i][6],
						'iextepro_note' => $proposal[$i][7],
						'iextepro_owner' => $new_oid,
						'iextepro_created' => $proposal[$i][9],
						'iextepro_created_by' => $new_oid,
						'iextepro_gid' => 0
					);
					$this->db->insert('i_ext_et_proposal', $data);
					$new_id = $this->db->insert_id();

					$file = $this->config->item('document_rt').'import_data/quotation_term.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$proposal_term = [];
						foreach ($lines as $line) {
							$proposal_term[] = str_getcsv($line);
						}
					}
					for ($pt=0; $pt < count($proposal_term) ; $pt++) { 
						for ($dt=0; $dt < count($doc_arr) ; $dt++) {
							if ($doc_arr[$dt]['type'] == 'Proposal') {
								if ($proposal_term[$pt][1] == $old_id ) {
									$status = 'false';
									if ($proposal_term[$pt][2] == $doc_arr[$dt]['term']) {
										$status = 'true';
										$data = array(
											'iexteptm_pid' => $new_id,
											'iexteptm_term_id' => $doc_arr[$dt]['new_id'],
											'iexteptm_status' => $status
										);
										$this->db->insert('i_ext_et_proposal_terms',$data);
									}
								}	
							}
						}
					}

					$file = $this->config->item('document_rt').'import_data/quotation_details.csv';
					$ext = pathinfo($file);
					if ($ext['extension'] == 'csv') {
						$csvData = file_get_contents($file);
						$lines = explode(PHP_EOL, $csvData);
						$proposal_product = [];
						foreach ($lines as $line) {
							$proposal_product[] = str_getcsv($line);
						}
					}

					for ($ij=0; $ij < count($proposal_product) ; $ij++) {
						if ($proposal_product[$ij][1] == $old_id) {
							$pid = 0;
							for ($ijk=0; $ijk < count($prod_arr) ; $ijk++) {
								if ($prod_arr[$ijk]['old_pid'] == $proposal_product[$ij][2] ) {
									$pid = $prod_arr[$ijk]['new_pid'];
									break;
								}
							}
							if ($pid != 0) {
								$file = $this->config->item('document_rt').'import_data/quotation_tax.csv';
								$ext = pathinfo($file);
								if ($ext['extension'] == 'csv') {
									$csvData = file_get_contents($file);
									$lines = explode(PHP_EOL, $csvData);
									$proposal_tax = [];
									foreach ($lines as $line) {
										$proposal_tax[] = str_getcsv($line);
									}
								}
								$old_in_id = $proposal_product[$ij][0];

								$disc = $proposal_product[$ij][7];
								$disc = str_replace('%',"",$disc);
								$data = array(
									'iexteprod_pro_id' => $new_id,
									'iexteprod_product_id' => $pid,
									'iexteprod_rate' => $proposal_product[$ij][5],
									'iexteprod_qty' => $proposal_product[$ij][6],
									'iexteprod_discount' => $disc,
									'iexteprod_amount' => $proposal_product[$ij][8],
									'iexteprod_owner' => $new_oid,
									'iexteprod_alias' => $proposal_product[$ij][10]
								);
								$this->db->insert('i_ext_et_proposal_product_details', $data);
								$new_in_id = $this->db->insert_id();
								$tax_gid = 0 ;
								for ($ik=1; $ik < count($proposal_tax) ; $ik++) {
									for ($jk=0; $jk < count($temp_array) ; $jk++) {
										if ($proposal_tax[$ik][3] == $temp_array[$jk]['tid'] && $proposal_tax[$ik][2] == $old_in_id && $proposal_tax[$ik][1] == $old_id ) {
											$tax_gid = $temp_array[$jk]['tgid'];
											break;
										}
									}
								}
								if ($tax_gid != 0) {
									$data = array('iexteprod_tax' => $tax_gid);
									$this->db->where(array('iexteprod_id' => $new_in_id, 'iexteprod_owner' => $new_oid ));
									$this->db->update('i_ext_et_proposal_product_details', $data);
								}
							}
						}
					}
			}
		}
	}
}