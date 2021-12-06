<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

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

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id");
			$result = $query->result();

			$data['customer'] = $result;

			$data['oid'] = $oid;

			$opt_url = array(
				'url' => base_url().'Customers/general_properties',
				'name' => 'Properties');

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Students";
			$ert['search'] = "true";
			$ert['options'] = $opt_url;

			$this->load->view('navbar', $ert);
			$this->load->view('customers/customer', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function customer_add() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags");
			$result = $query->result();

			$data['tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Students";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('customers/customer_add', $data);
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
				if ($vv[$i] != null) {
					$data = array('icbd_customer_id'=> $cid, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
					$this->db->insert('i_c_basic_details', $data);	
				}
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
			redirect(base_url().'Account/login');
		}
	}

	public function customer_edit($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			$oid = $sess_data['user_details'][0]->i_uid;
			
			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			$data['property'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_id='$c_id'");
			$result = $query->result();

			$data['edit_customer'] = $result;

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_customer_id='$c_id'");
			$result1 = $query1->result();

			$data['edit_basic_details'] = $result1;

			$query2 = $this->db->query("SELECT * FROM i_c_t_prefernces WHERE ictp_customer_id='$c_id'");
			$result2 = $query2->result();

			$data['edit_preferences'] = $result2;

			$data['cid'] = $c_id;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Students";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('customers/customer_add', $data);
		} else {
			redirect(base_url().'Account/login');
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
				$data = array('ip_property' => $pp[$i], 'ip_owner' => $oid, 'ip_section' => 'Students');	

				$this->db->insert('i_property', $data);
				$npid = $this->db->insert_id();
				array_push($n_pp, $npid);
			}

			$vv = $c_property[0]['n_v'];
			for ($i=0; $i < count($n_pp) ; $i++) { 
				if ($vv != '') {
					$data = array('icbd_customer_id'=> $c_id, 'icbd_property' => $n_pp[$i], 'icbd_value' => $vv[$i]);
					$this->db->insert('i_c_basic_details', $data);	
				}
			}

			// for ($i=0; $i < count($c_property) ; $i++) { 
			// 	$tmp_prp = 
			// 	$tmp_val = $c_property[0]['n_v'][0];

			// 	print_r($tmp_prp);
			// 	print_r($tmp_val);


			// 	// $query = $this->db->query("SELECT * FROM i_property WHERE ip_property = '$tmp_prp' AND ip_owner = '$oid'");
			// 	// $result = $query->result();

			// 	// if(count($result) <= 0) {
			// 	// 	$data1 = array(
			// 	// 		'ip_property' => $tmp_prp,
			// 	// 		'ip_owner' => $oid );

			// 	// 	$this->db->insert('i_property', $data1);
			// 	// 	$pid = $this->db->insert_id();						
			// 	// } else {
			// 	// 	$pid = $result[0]->ip_id;
			// 	// }

			// 	// $data2 = array(
			// 	// 	'icbd_customer_id' => $c_id,
			// 	// 	'icbd_property' => $pid,
			// 	// 	'icbd_value' => $tmp_val);

			// 	// $this->db->insert('i_c_basic_details', $data2);		
			// }



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
			redirect(base_url().'Account/login');
		}
	}

	public function delete_customer($c_id) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
			
			$this->db->where('ic_id', $c_id);
			$this->db->delete('i_customers');
			
			$this->db->where('icbd_customer_id', $c_id);
			$this->db->delete('i_c_basic_details');

			redirect(base_url().'Customers');

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function general_properties() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Students General Properties";
			$ert['search'] = "false";

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			$data['property'] = $result;
			$data['thing'] = 'Student';
			
			$this->load->view('navbar', $ert);
			$this->load->view('customers/general_properties', $data);
		}
	}

	public function save_property() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			$data = array('ip_property' => $this->input->post('property'), 'ip_owner' => $oid, 'ip_section' => 'Students');	

			$this->db->insert('i_property', $data);

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			print_r(json_encode($result));
		}
	}

	public function remove_property() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;
			
			$pid = $this->input->post('pid');

			$this->db->where('ip_id', $pid);
			$this->db->delete('i_property');

			$query = $this->db->query("SELECT * FROM i_property WHERE ip_owner = '$oid' AND ip_section = 'Students'");
			$result = $query->result();

			print_r(json_encode($result));
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

	public function datetest() {
		// $dt = date_create('Tue, 15 Aug 2017 09:23:26 +0000');

		$dt = new DateTime('Tue, 15 Aug 2017 09:23:26 +0000');
		print_r($dt);
		$dt->setTimezone(new DateTimeZone('+0530'));

		ECHO "lio".$dt->format('Y-m-d H:i:s')."ghf";
		
	}

	function super_unique($array) {
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));

		foreach ($result as $key => $value) {
			if ( is_array($value) ) {
				$result[$key] = $this->super_unique($value);
			}
		}
		return $result;
	}


	public function email() {
		/* connect to gmail */
		ini_set('MAX_EXECUTION_TIME', -1);
		$hostname = '{secure220.inmotionhosting.com:993/imap/ssl}INBOX';
		$username = 'hitesh@onedynamics.in';
		$password = 'QWE!@#123';

		/* try to connect */
		$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

		/* grab emails */
		$emails = imap_search($inbox,'ALL');

		/* if emails are returned, cycle through each... */
		if($emails) {
			
			/* begin output var */
			$output = '';
			
			/* put the newest emails on top */
			rsort($emails);
			
			/* for every email... */
			foreach($emails as $email_number) {
				$overview = imap_fetch_overview($inbox,$email_number,0);
				if ($email_number==71) {

					echo gettype($overview[0]->from);
					if($overview[0]->from == 'jd vansh') {
						
					}
					$dt = date('Y-m-d H:i:s');
					print_r($email_number);
					echo "<br>-------------------------------<br>";
					echo "Subject: ".$overview[0]->subject."<br>";
					echo "From: ".$overview[0]->from."<br>";
					echo "To: ".$overview[0]->to."<br>";

					$dt = new DateTime($overview[0]->date);
					$dt->setTimezone(new DateTimeZone('+0530'));
					echo "Date: ".$dt->format('Y-m-d H:i:s')."<br>";


					// print_r($overview);
					echo "-------------------------------<br>";
					$message = imap_fetchbody($inbox,$email_number,1);
					echo $message;
					echo "<br>";

					$string = $message;
					$matches = array();
					$pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
					
					$ert = preg_match_all($pattern, $string, $matches); 
					echo "<br>";
					echo "-------------------------------<br>";

					for ($i=0; $i < count($matches) ; $i++) { 
						if (isset($matches[0][$i])) {
							if($matches[0][$i]=="mumbaifeedback@justdial.com") {
								unset($matches[0][$i]);	
							} else if($matches[0][$i]=="vansh@gmail.com") {
								unset($matches[0][$i]);
							}
						}
					}

					$matches = $this->super_unique($matches);
					echo "Email Count:".$ert;
					echo "<br>-------------------------------<br>";
					echo "Email ID's in this mail: ";
					for ($i=0; $i < $ert ; $i++) { 
						if (isset($matches[0][$i])) {
							echo "<li>".$matches[0][$i]."</li>";
						}
					}

					echo "-------------------------------<br>";
					
					$matches1 = array();
					$pattern1 = '/[+0-9]{13}|[0-9]{10}/';
					
					$ert = preg_match_all($pattern1, $string, $matches1); 
					echo "<br>";
					echo "-------------------------------<br>";

					for ($i=0; $i < count($matches1[0]); $i++) {
						if (isset($matches1[0][$i])) {
						 	if($matches1[0][$i]=='8888888888') {
								unset($matches1[0][$i]);	
							}
						} 
					}
					
					echo "Phone Count:".$ert;
					echo "<br>-------------------------------<br>";
					echo "List of Phone Numbers: ";
					for ($i=0; $i < $ert ; $i++) { 
						if (isset($matches1[0][$i])) {
							echo "<li>".$matches1[0][$i]."</li>";
						}
					}
					echo "-------------------------------<br>";
					echo "*******************************<br><br>";
					
				}
				
				

				/* get information specific to this email */
				$overview = imap_fetch_overview($inbox,$email_number,0);
				$message = imap_fetchbody($inbox,$email_number,2);
				
				/* output the email header information */
				$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
				$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
				$output.= '<span class="from">'.$overview[0]->from.'</span>';
				$output.= '<span class="date">on '.$overview[0]->date.'</span>';
				$output.= '</div>';
				
				/* output the email body */
				$output.= '<div class="body">'.$message.'</div>';
			}
			
			// echo $output;
		} 

		/* close the connection */
		imap_close($inbox);
	}
	
	public function relations() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {
		    
		    $oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();

			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid'");
			$result = $query->result();

			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_p_f_tags WHERE ipft_owner = '$oid'");
			$result = $query->result();

			$data['p_tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();

			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_c_t_prefernces WHERE ictp_owner = '$oid'");
			$result = $query->result();

			$data['c_tags'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Relations";
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('customers/relate', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function attendance() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id");
			$result = $query->result();

			$data['customer'] = $result;

			$dt = date('Y-m-d');
			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance WHERE ieea_owner='$oid' AND ieea_date='$dt'");
			$result = $query->result();

			$data['attendance'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_homework WHERE ieeh_owner='$oid' AND ieeh_date='$dt'");
			$result = $query->result();

			$data['homework'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_punishment WHERE ieep_owner='$oid' AND ieep_date='$dt'");
			$result = $query->result();

			$data['punishment'] = $result;

			$data['oid'] = $oid;

			$opt_url = array(
				'url' => base_url().'Customers/general_properties',
				'name' => 'Properties');



			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['title'] = "Attendance";
			$ert['search'] = "false";
			$ert['options'] = $opt_url;

			$this->load->view('navbar', $ert);
			$this->load->view('customers/attendance', $data);
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_attendance() {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$att = $this->input->post('attendance');
			$hmw = $this->input->post('homework');
			$pun = $this->input->post('punishment');
			$dty = $this->input->post('date');
			$dt = date('Y-m-d H:i:s');

			$this->db->where(array('ieea_owner' => $oid , 'ieea_date' => $dty));
			$this->db->delete('i_ext_ed_attendance');

			for ($i=0; $i < count($att) ; $i++) { 
				$data = array(
					'ieea_customer_id' => $att[$i]['i'],
					'ieea_status' => $att[$i]['a'],
					'ieea_date' => $dty,
					'ieea_owner' => $oid,
					'ieea_created' => $oid,
					'ieea_created_by' => $dt );
				$this->db->insert('i_ext_ed_attendance', $data);
			}

			$this->db->where(array('ieeh_owner' => $oid , 'ieeh_date' => $dty));
			$this->db->delete('i_ext_ed_homework');

			for ($i=0; $i < count($hmw) ; $i++) { 
				$data = array(
					'ieeh_customer_id' => $hmw[$i]['i'],
					'ieeh_status' => $hmw[$i]['h'],
					'ieeh_date' => $dty,
					'ieeh_owner' => $oid,
					'ieeh_created' => $oid,
					'ieeh_created_by' => $dt );
				$this->db->insert('i_ext_ed_homework', $data);
			}

			$this->db->where(array('ieep_owner' => $oid , 'ieep_date' => $dty));
			$this->db->delete('i_ext_ed_punishment');

			for ($i=0; $i < count($pun) ; $i++) { 
				$data = array(
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
			redirect(base_url().'Account/login');
		}
	}

	public function get_attendance($date) {
		$sess_data = $this->session->userdata();
		if(isset($sess_data['user_details'][0])) {

			$oid = $sess_data['user_details'][0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_customers as a LEFT JOIN i_c_pic as b ON a.ic_id=b.icp_c_id");
			$result = $query->result();

			$data['customer'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_attendance WHERE ieea_owner='$oid' AND ieea_date='$date'");
			$result = $query->result();

			$data['attendance'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_homework WHERE ieeh_owner='$oid' AND ieeh_date='$date'");
			$result = $query->result();

			$data['homework'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_ed_punishment WHERE ieep_owner='$oid' AND ieep_date='$date'");
			$result = $query->result();

			$data['punishment'] = $result;

			$data['oid'] = $oid;

			echo json_encode($data);
		} else {
			redirect(base_url().'Account/login');
		}
	}


}
