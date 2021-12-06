<?php
class Godown extends CI_Controller {
	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('directory');
		$this->load->helper('cookie');
		$this->load->model('Code','log_code');
		$this->load->model('Mail','Mail');
	}

	public function home($mid = null,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Godown') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_godown_location WHERE iextetgdl_gid = '$gid' AND iextetgdl_created_by = '$uid' AND iextetgdl_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetgdl_file;
				$path = $this->config->item('document_rt')."assets/data/godown/";
	            $fl = $path.$file_name;
	            $data['gd_temp'] = json_decode(file_get_contents($fl));
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$data['products'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid'");
			$result = $query->result();
			$data['inv_acc'] = $result;

			$data['mod_id'] = $module_id;
			$data['gid']=$gid;
			$ert['mid'] = $module_id;
			$ert['mname']=$mname;
			$ert['code']=$code;
			$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname;
			}else{
				$ert['title'] = $alias;
			}
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('godown/home', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function add_location($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Godown') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_godown_location WHERE iextetgdl_gid = '$gid' AND iextetgdl_created_by = '$uid' AND iextetgdl_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetgdl_file;
				$path = $this->config->item('document_rt')."assets/data/godown/";
	            $fl = $path.$file_name;
	            $data['gd_temp'] = json_decode(file_get_contents($fl));
			}

			$data['mod_id'] = $module_id;
			$data['gid']=$gid;
			$ert['mid'] = $module_id;
			$ert['mname']=$mname;
			$ert['code']=$code;
			$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname.' location';
			}else{
				$ert['title'] = $alias.' location';
			}
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('godown/godown_location', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function gd_template_save($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->WHERE(array('iextetgdl_owner' => $oid,'iextetgdl_gid' => $gid , 'iextetgdl_created_by' => $uid));
			$this->db->delete('i_ext_et_godown_location');

			$arr = $this->input->post('arr');

			$dt = date('Y-m-d H:i:s');
			$dt1=date_create(); $dt_str = date_timestamp_get($dt1);
			$jstr = json_encode($arr);
			$upload_dir = $this->config->item('document_rt')."assets/data/godown/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			$data = array(
			  'iextetgdl_file' => $dt_str.'.json',
			  'iextetgdl_owner' => $oid,
			  'iextetgdl_created' => $dt,
			  'iextetgdl_created_by' => $uid,
			  'iextetgdl_gid' => $gid
			);
			$this->db->insert('i_ext_et_godown_location',$data);

			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function save_product_location($code,$to = 'location') {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {		
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$pro_loc = $this->input->post('pro_loc_arr');
			$loc_arr = $this->input->post('arr_loc');
			if ($to == 'location') {
				$from_type = 'account';$to_type = 'location';
			}else{
				$to_type = 'account';$from_type = 'location';
			}

			for ($i=0; $i < count($pro_loc) ; $i++) {
				$from_id = 0;$to_id = 0;
				$prid = 0;
				$inward = $pro_loc[$i]['qty'];
				$sn = null;
				$location = null;

				$a_name = $pro_loc[$i]['account'];
				$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid' AND iia_name = '$a_name' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					if ($to == 'location') {
						$from_id = $result[0]->iia_id;	
					}else{
						$to_id = $result[0]->iia_id;
					}
				}
				$l_name = $pro_loc[$i]['loc'];
				for ($j=0; $j < count($loc_arr) ; $j++) {
					if ($loc_arr[$j]['text'] == $l_name || $loc_arr[$j]['loc_barcode'] == $l_name ) {
						if ($to == 'location') {
							$to_id = $loc_arr[$j]['id'];
							$location = $loc_arr[$j]['loc_barcode'];	
						}else{
							$from_id = $loc_arr[$j]['id'];
						}
					}
				}
				$p_name = $pro_loc[$i]['pro'];
				$query = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_owner = '$oid' AND iin_gid = '$gid' AND iin_serial_number = '$p_name' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$prid = $result[0]->iin_p_id;
					$sn = $p_name;
				}else{
					$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_product = '$p_name' ");
					$result = $query->result();
					if (count($result) > 0 ) {
						$prid = $result[0]->ip_id;
					}
				}
				
				$data = array(
					'iin_from' => $from_id,
					'iin_from_type' => $from_type,
					'iin_to' => $to_id,
					'iin_to_type' => $to_type,
					'iin_date' => date('Y-m-d'),
					'iin_p_id' => $prid,
					'iin_inward' => $inward,
					'iin_outward' => 0,
					'iin_owner' => $oid,
					'iin_created' => date('Y-m-d H:i:s'),
					'iin_created_by' => $uid,
					'iin_serial_number' => $sn,
					'iin_gid' => $gid,
					'iin_txn_type' => 'location',
					'iin_location' => $location
				);
				$this->db->insert('i_inventory_new', $data);	
			}

			// $arr = $this->input->post('loc_arr');			
			// for ($i=0; $i < count($arr) ; $i++) { 
			// 	$pro_bar = $arr[$i]['pro'];
			// 	$loc_bar = $arr[$i]['loc'];

			// 	$query = $this->db->query("SELECT * FROM i_inventory_new WHERE iin_from_type = 'account' AND iin_to_type = 'account' AND iin_owner = '$oid' AND iin_gid = '$gid' AND iin_serial_number = '$pro_bar' ");
			// 	$result = $query->result();
			// 	if (count($result) > 0 ) {
			// 		$data = array(
			// 			'iin_location' => $loc_bar
			// 		);
			// 		$this->db->where(array('iin_owner' => $oid , 'iin_gid' => $gid ,'iin_serial_number' => $pro_bar , 'iin_from_type' => 'account' , 'iin_to_type' => 'account' ));
			// 		$this->db->update('i_inventory_new',$data);	
			// 	}else{
			// 		$data = array(
			// 			'iin_location' => $loc_bar
			// 		);
			// 		$this->db->where(array('iin_owner' => $oid , 'iin_gid' => $gid ,'iin_serial_number' => $pro_bar ,'iin_to_type' => 'account'));
			// 		$this->db->update('i_inventory_new',$data);
			// 	}
			// 	echo "true";
			// }
			echo "true";
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function unlocated_product($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$data['oid'] = $oid;
			$data['uid'] = $uid;
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];
			$module_id=0;$mname='';
			if (count($module) > 0) {
				if($module[0]->domain) {
					$data['dom'] = "[".$module[0]->domain."]";
				} else {
					$data['dom'] = "[]";
				}
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Godown') {
						$module_id = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
						break;
					}
				}
			} else {
				$data['dom'] = "[]";
			}

			$query = $this->db->query("SELECT * FROM i_ext_et_godown_location WHERE iextetgdl_gid = '$gid' AND iextetgdl_created_by = '$uid' AND iextetgdl_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$file_name = $result[0]->iextetgdl_file;
				$path = $this->config->item('document_rt')."assets/data/godown/";
	            $fl = $path.$file_name;
	            $data['gd_temp'] = json_decode(file_get_contents($fl));
			}

			// $query = $this->db->query("SELECT * FROM i_inventory_new as a left join i_product as b on a.iin_p_id = b.ip_id left join i_inventory_accounts as c on a.iin_to = c.iia_id WHERE iin_owner='$oid' AND iin_gid = '$gid' AND iin_location IS NULL AND iin_serial_number NOT IN (SELECT iin_serial_number FROM i_inventory_new WHERE iin_from_type = 'account' AND iin_to_type = 'account' ) AND iin_serial_number NOT IN (SELECT iin_serial_number FROM i_inventory_new WHERE iin_from_type = 'account' AND iin_to_type = 'contact' ) ");
			// $result = $query->result();
			// $data['inventory'] = $result;

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner='$oid'");
			$result = $query->result();
			$data['inv_acc'] = $result;

			$que0 = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid'");
			$res0 = $que0->result();

			$arr=[];
			for ($i=0; $i < count($result); $i++) { 
				$aid = $result[$i]->iia_id;
				for ($j=0; $j < count($res0); $j++) {
					$bal = 0;
					$pid = $res0[$j]->ip_id;
					$que1 = $this->db->query("SELECT * FROM i_inventory_new WHERE (iin_to='$aid' OR iin_from='$aid') AND iin_owner='$oid' AND iin_p_id='$pid' ");
					$res1 = $que1->result();
					for ($k=0; $k < count($res1); $k++) {
						if($aid == $res1[$k]->iin_from) {
							$bal-=$res1[$k]->iin_inward;
							$sn = $res1[$k]->iin_serial_number;
							$dt = $res1[$k]->iin_date;
						} else {
							$bal+=$res1[$k]->iin_inward;
							$sn = $res1[$k]->iin_serial_number;
							$dt = $res1[$k]->iin_date;
						}
					}
					if ($bal != 0) {
						array_push($arr, array('pid' => $pid, 'aid' => $aid, 'bal' => $bal , 'pname' => $res0[$j]->ip_product , 'a_name' => $result[$i]->iia_name , 'date' => $dt));
					}
				}	
			}
			$data['inventory_acc'] = $arr;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$data['products'] = $query->result();

			$data['mod_id'] = $module_id;
			$data['gid']=$gid;
			$ert['mid'] = $module_id;
			$ert['mname']=$mname;
			$ert['code']=$code;
			$ert['gid']=$gid;
			$ert['mod'] = $sess_data['user_mod'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = $mname.' : Un-located product';
			}else{
				$ert['title'] = $alias.' : Un-located product';
			}
			$ert['search'] = "true";
			
			$this->load->view('navbar', $ert);
			$this->load->view('godown/unlocated_product', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function search_location($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$val = $this->input->post('val');
			$arr_col = $this->input->post('arr_col');

			$query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner = '$oid' AND iia_gid = '$gid' AND iia_star = '1' ");
			$result = $query->result();
			$star_acc = '0';
			if (count($result) > 0 ) {
				$star_acc = $result[0]->iia_id;
			}

			$query = $this->db->query("SELECT iin_location FROM i_inventory_new WHERE iin_owner='$oid' AND iin_gid = '$gid' AND iin_serial_number = '$val' AND iin_location IS NOT NULL GROUP BY iin_location UNION SELECT iin_location FROM i_inventory_new as a left join i_product as b on a.iin_p_id = b.ip_id WHERE iin_owner='$oid' AND iin_gid = '$gid' AND ip_product = '$val' AND iin_location IS NOT NULL GROUP BY iin_location");
			$result = $query->result();
			$data['inventory'] = $result;

			$data['pro_data'] = [];
			$array1 = [];
			for ($i=0; $i < count($result) ; $i++) {
				$loc_barcode = $result[$i]->iin_location;
				$loc_id = 0;
				for ($j=0; $j < count($arr_col) ; $j++) { 
					if ($arr_col[$j]['loc_barcode'] == $loc_barcode) {
						$loc_id = $arr_col[$j]['id'];
					}
				}

				$query = $this->db->query("SELECT * FROM i_inventory_new AS a LEFT JOIN i_customers AS b ON a.iin_from=b.ic_id LEFT JOIN i_customers AS c ON a.iin_to=c.ic_id LEFT JOIN i_inventory_accounts AS d ON a.iin_from=d.iia_id LEFT JOIN i_inventory_accounts AS e ON a.iin_to=e.iia_id LEFT JOIN i_product AS f ON a.iin_p_id=f.ip_id WHERE (a.iin_from_type='location' AND a.iin_from='$loc_id' OR a.iin_to_type='location' AND a.iin_to='$loc_id') AND a.iin_gid = '$gid' AND ( d.iia_gid = '$gid' OR e.iia_gid = '$gid' ) AND a.iin_owner='$oid' ");
				$res = $query->result();
				for ($j=0; $j < count($res) ; $j++) { 
					if ($res[$j]->iin_from_type == 'location') {
						$sn = $res[$j]->iin_serial_number;
						$to_id = $res[$j]->iin_to;
						$to_type = $res[$j]->iin_to_type;
						$from_id = $res[$j]->iin_from;
						$qty = $res[$j]->iin_inward;
						for ($ij=0; $ij < count($array1) ; $ij++) {
							if ($sn == $array1[$ij]['sn'] && $to_id == $array1[$ij]['from'] && $from_id == $array1[$ij]['to'] && $to_type == $array1[$ij]['from_type'] ) {
								$array1[$ij]['qty'] = $array1[$ij]['qty'] - $qty;
							}
						}
					} else {
						array_push($array1, array('id' => $res[$j]->iin_id , 'pname' => $res[$j]->ip_product , 'from' => $res[$j]->iin_from , 'to' => $res[$j]->iin_to , 'sn' => $res[$j]->iin_serial_number , 'from_type' => $res[$j]->iin_from_type , 'to_type' => $res[$j]->iin_to_type , 'qty' => $res[$j]->iin_inward, 'loc' => $res[$j]->iin_location));
					}
				}
			}
			$data['pro_data'] = $array1;


			$arr = [];
		    $query = $this->db->query("SELECT * FROM i_inventory_accounts WHERE iia_owner = '$oid' AND iia_gid = '$gid' AND iia_name = '$val' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$aid = $result[0]->iia_id;
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner='$oid'");
				$res0 = $query->result();
				for ($i=0; $i < count($res0); $i++) {
					$bal = 0;
					$pid = $res0[$i]->ip_id;

					$que1 = $this->db->query("SELECT * FROM i_inventory_new AS a LEFT JOIN i_customers AS b ON a.iin_from=b.ic_id LEFT JOIN i_customers AS c ON a.iin_to=c.ic_id LEFT JOIN i_inventory_accounts AS d ON a.iin_from=d.iia_id LEFT JOIN i_inventory_accounts AS e ON a.iin_to=e.iia_id LEFT JOIN i_product AS f ON a.iin_p_id=f.ip_id WHERE (iin_to='$aid' OR iin_from='$aid') AND iin_owner='$oid' AND iin_p_id='$pid' AND iin_from_type != 'location' AND iin_to_type != 'location' ");
					$res = $que1->result();
					for ($j=0; $j < count($res) ; $j++) { 
						if ($res[$j]->iin_from == $aid) {
							$sn = $res[$j]->iin_serial_number;
							$from_id = $res[$j]->iin_from;
							$pro_id = $res[$j]->iin_p_id;
							$qty = $res[$j]->iin_inward;
							for ($ij=0; $ij < count($array1) ; $ij++) {
								if ($sn == $array1[$ij]['sn'] && $from_id == $array1[$ij]['to'] && $pro_id == $array1[$ij]['pid']) {
									// if ($array1[$ij]['qty'] > 1 ) {
										
									// }else{
									// 	unset($array1[$ij]);
									// 	$array1 = array_values($array1);
									// }
									$array1[$ij]['qty'] -= $qty;
								}
							}
						} else {
							array_push($array1, array('id' => $res[$j]->iin_id , 'pid' => $res[$j]->iin_p_id ,'pname' => $res[$j]->ip_product , 'from' => $res[$j]->iin_from , 'to' => $res[$j]->iin_to , 'sn' => $res[$j]->iin_serial_number , 'from_type' => $res[$j]->iin_from_type , 'to_type' => $res[$j]->iin_to_type , 'qty' => $res[$j]->iin_inward, 'loc' => $res[$j]->iin_location));
						}
					}
				}	
			}
			$arr1 = [];
			for ($i=0; $i <count($array1) ; $i++) {
				if ($array1[$i]['qty'] != 0 ) {
					array_push($arr1, $array1[$i]);	
				}
			}
			$data['acc_data'] = $arr1;
			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}

	public function search_on_click_location($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];

			$loc_barcode = $this->input->post('val');
			$arr_col = $this->input->post('arr_col');

			$loc_id = 0;
			for ($j=0; $j < count($arr_col) ; $j++) { 
				if ($arr_col[$j]['loc_barcode'] == $loc_barcode) {
					$loc_id = $arr_col[$j]['id'];
				}
			}
			$array1 = [];
			$query = $this->db->query("SELECT * FROM i_inventory_new AS a LEFT JOIN i_customers AS b ON a.iin_from=b.ic_id LEFT JOIN i_customers AS c ON a.iin_to=c.ic_id LEFT JOIN i_inventory_accounts AS d ON a.iin_from=d.iia_id LEFT JOIN i_inventory_accounts AS e ON a.iin_to=e.iia_id LEFT JOIN i_product AS f ON a.iin_p_id=f.ip_id WHERE (a.iin_from_type='location' AND a.iin_from='$loc_id' OR a.iin_to_type='location' AND a.iin_to='$loc_id') AND a.iin_gid = '$gid' AND ( d.iia_gid = '$gid' OR e.iia_gid = '$gid' ) AND a.iin_owner='$oid' ");
			$res = $query->result();
			for ($j=0; $j < count($res) ; $j++) { 
				if ($res[$j]->iin_from_type == 'location') {
					$sn = $res[$j]->iin_serial_number;
					$to_id = $res[$j]->iin_to;
					$to_type = $res[$j]->iin_to_type;
					$from_id = $res[$j]->iin_from;
					$qty = $res[$j]->iin_inward;
					for ($ij=0; $ij < count($array1) ; $ij++) {
						if ($sn == $array1[$ij]['sn'] && $to_id == $array1[$ij]['from'] && $from_id == $array1[$ij]['to'] && $to_type == $array1[$ij]['from_type'] ) {
							$array1[$ij]['qty'] = $array1[$ij]['qty'] - $qty;
						}
					}
				} else {
					array_push($array1, array('id' => $res[$j]->iin_id , 'pname' => $res[$j]->ip_product , 'from' => $res[$j]->iin_from , 'to' => $res[$j]->iin_to , 'sn' => $res[$j]->iin_serial_number , 'from_type' => $res[$j]->iin_from_type , 'to_type' => $res[$j]->iin_to_type , 'qty' => $res[$j]->iin_inward, 'loc' => $res[$j]->iin_location));
				}
			}
			$data['pro_data'] = $array1;


			print_r(json_encode($data));
		} else {
			redirect(base_url().'account/login');
		}
	}
}