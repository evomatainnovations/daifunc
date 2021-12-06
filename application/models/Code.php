<?php
class Code extends CI_Model {

	public function get_session_value($code){
		$query = $this->db->query("SELECT * FROM i_u_session AS a LEFT JOIN i_u_details AS b ON a.ius_u_id=b.iud_u_id left join i_users as c on c.i_uid=b.iud_u_id WHERE ius_s_id='$code'");
		$result = $query->result();

		$key = [];
		$dt = date('Y-m-d');
		if (count($result) > 0) {
			$gid = $result[0]->ius_gid;
			$uid = $result[0]->i_uid;

			$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' ");
			$res = $query->result();
			if (count($res) > 0) {
				$gid = $gid;
			}else{
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$uid' AND iug_id = '$gid' ");
				$res = $query->result();
				if (count($res) > 0) {
					$gid = $gid;	
				}else{
					$gid = 0;
				}
			}

			if ($gid == 0) {
				$id = $result[0]->i_uid;
				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$id' AND ium_gid = '0'");
				$result_m = $query->result();
				if (count($result_m) > 0 ) {
					for ($i=0; $i <count($result_m) ; $i++) {
						$u_mid = $result_m[$i]->ium_id;
						$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_id = '$u_mid' AND ium_subscription_start <= '$dt' AND ium_subscription_end >= '$dt'");
						$result_sm = $query->result();
						if (count($result_sm) > 0) {
							$data = array('ium_status' => 'active');
							$this->db->where('ium_id',$u_mid);
							$this->db->update('i_u_modules',$data);
						}else{
							$data = array('ium_status' => 'suspend');
							$this->db->where('ium_id',$u_mid);
							$this->db->update('i_u_modules',$data);
						}
					}
				}
				$query3 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status , a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_u_id = '$id' AND a.ium_created_by = '0' AND a.ium_status IN('active','suspend') GROUP BY iuh_mid ORDER by c_mid DESC ");
				$result3 = $query3->result();

				$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status , a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_u_id = '$id' AND a.ium_created_by = '0' AND a.ium_status IN('active','suspend') ");
				$result1 = $query1->result();

				if (count($result3) == count($result1) ) { // for most used module
					$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status , a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_u_id = '$id' AND a.ium_created_by = '0' AND a.ium_status IN('active','suspend') GROUP BY ium_m_id ORDER by c_mid DESC ");
					$result1 = $query1->result();
				}

				$result[0]->i_owner = $id;
			}else{
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_id = '$gid'");
				$result3 = $query->result();
				$result[0]->i_owner = $result3[0]->iug_owner;
				$oid = $result3[0]->iug_owner;

				if ($uid == $oid) {
					$query3 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id FROM i_u_modules WHERE ium_gid = '$gid' AND ium_status = 'active') GROUP BY a.ium_m_id ORDER by c_mid DESC ");
					$result3 = $query3->result();

					$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias  FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_gid = '0' AND ium_status = 'active') GROUP BY ium_m_id");
					$result1 = $query1->result();

					if (count($result3) == count($result1) ) { // for most used module
						$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_gid = '$gid' AND ium_status = 'active') GROUP BY a.ium_m_id ORDER by c_mid DESC");
						$result1 = $query1->result();
					}

				}else{
					$query3 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id FROM i_u_modules WHERE ium_gid = '$gid' AND ium_u_id = '$uid' AND ium_status = 'active') GROUP BY a.ium_m_id ORDER by c_mid DESC ");
					$result3 = $query3->result();

					// $query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '$gid' AND a.ium_u_id='$uid' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_u_id = '$oid' AND ium_gid != '0' AND ium_created_by = '0' AND ium_status = 'active')");
					// $result1 = $query1->result();

					$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias  FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id from i_u_modules WHERE ium_gid = '$gid' AND ium_u_id = '$uid' AND ium_status = 'active') GROUP BY ium_m_id");
					$result1 = $query1->result();

					if (count($result3) == count($result1) ) { // for most used module
						$query1 = $this->db->query("SELECT a.ium_m_id AS mid, c.idom_name AS domain, d.ifun_name AS function, b.im_name AS mname, a.ium_status AS status ,a.ium_module_alias as m_alias , COUNT(iuh_mid) as c_mid FROM i_u_modules as a LEFT JOIN i_modules as b ON a.ium_m_id=b.im_id LEFT JOIN i_domain AS c ON b.im_domain=c.idom_id LEFT JOIN i_function AS d ON b.im_function=d.ifun_id LEFT JOIN i_user_history AS e on a.ium_m_id = e.iuh_mid WHERE a.ium_gid = '0' AND a.ium_status IN('active','suspend') AND a.ium_m_id IN (SELECT ium_m_id FROM i_u_modules WHERE ium_gid = '$gid' AND ium_u_id = '$uid' AND ium_status = 'active') GROUP BY a.ium_m_id ORDER by c_mid DESC ");
						$result1 = $query1->result();
					}
				}
			}
			
			// $oid = $result[0]->i_owner;
			// $query5 = $this->db->query("SELECT ium_m_id , ium_module_alias FROM i_u_modules as a LEFT JOIN i_modules as b on a.ium_m_id = b.im_id  WHERE ium_u_id = '$oid' AND ium_gid = '0' ");
			// $result5 = $query5->result();

			$query2 = $this->db->query("SELECT * FROM i_user_group WHERE iug_id IN (SELECT ium_gid FROM i_u_modules WHERE ium_created_by = '$uid' AND ium_gid != '0' UNION SELECT ium_gid FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid != '0' )");
				$result2 = $query2->result();

			$key = array('session' => 'true', 'code' => $code,'status' => "user" , "user_details" => $result, "oid" => $result[0]->i_owner, "gid" => $gid, "user_mod" => $result1, "user_connection" => $result2 ,"account_type" => "self" );
			//, "owner_mod" => $result5 
		} else {
			$key = array('session' => 'false');
		}
		return $key;
	}

	public function login_verify($uname, $upass) {
		$query = $this->db->query("SELECT * FROM i_users WHERE i_uname='$uname' AND i_upassword='$upass'");
		$result = $query->result();

		if (count($result) > 0) {
			$code = $this->update_code($result[0]->iu_l_code, $this->generate_code(), $result[0]->i_uid);
			return $this->get_session_value($code);
		} else {
			$key = [];
			array_push($key, array('status' => 'false'));
			return $key;
		}
	}

	function generate_code() {
		$key='';
		$keys = array_merge(range(0, 9), range('a', 'z'));
	    for ($i = 0; $i < 256; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }
	    $dt=date_create();
		$timestamp = date_timestamp_get($dt);
		return $key.$timestamp;
	}

	function user_code() {
		$chars = "0123456789ABCDEFGHIJKLMN0PQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 5; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		return $res;
	}

	function update_code($old_code, $new_code, $uid) {
		$data = array('ius_u_id' => $uid, 'ius_s_id' => $new_code, 'ius_gid' => 0);
		$this->db->insert('i_u_session', $data);
		return $new_code;
	}
}