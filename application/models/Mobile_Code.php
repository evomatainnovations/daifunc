<?php
class Mobile_Code extends CI_Model {
	public function get_session_value($code){
		$query = $this->db->query("SELECT * FROM i_ext_et_mobile_users WHERE iextetmu_code = '$code' ");
		$result1 = $query->result();
		if (count($result1) > 0 ) {
			$oid = $result1[0]->iextetmu_owner;
			$mob_id = $result1[0]->iextetmu_mobile_id;
			if ($result1[0]->iextetmu_status == 'block') {
				$key = array("session" => 'false');
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_et_mobile WHERE iextetm_id = '$mob_id' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$gid = $result[0]->iextetm_gid;
					$color = $result[0]->iextetm_color;
				}else{
					$gid = 0;
					$color = 'material.red-deep_orange.min.css';
				}
				$key = array("session" => 'true', "code" => $code,"user_details" => $result1, "oid" => $oid ,"m_uid" => $result1[0]->iextetmu_id, "gid" => $gid, "color" => $color );
			}
		}else{
			$key = array("session" => 'false');
		}
		return $key;
	}
}
?>