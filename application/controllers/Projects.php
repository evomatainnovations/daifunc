<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->model('Code','log_code');
	}

	public function view($mod_id = null,$code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$oid = $sess_data['user_details'][0]->i_owner;
			$admin = '';
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

			$mid = 0;$mname='';$alias='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			}
			$ert['mid'] = $mid;$ert['mname'] = $mname;

			if($gid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$uid' AND iug_id = '$gid'");
				$result = $query->result();
				if (count($result) > 0){
					$admin = 'true';
				}else{
					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$mid'");
					$result = $query->result();
					if (count($result) > 0) {
						$admin = 'true';
					}
				}
				$pro_act = [];
				if ($admin == 'true') {
					$pro_act_list = [];
					$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid'");
					$result = $query->result();
	    			$data['projects'] = $result;
	    			$data['userflow'] = "true";
	    			for ($ij=0; $ij < count($result) ; $ij++) {
	    				$pro_id = $result[$ij]->iextpp_id ;
	    				$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' GROUP BY b.iua_status ");
	    				$res = $q->result();
	    				for ($i=0; $i < count($res) ; $i++) {
	    					array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
	    				}
	    				$que = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND b.iua_owner = '$oid' AND b.iua_g_id = '$gid' AND b.iua_status = 'progress' ORDER BY b.iua_id DESC limit 5 ");
		    			$res1 = $que->result();
		    			for ($i=0; $i < count($res1) ; $i++) {
	    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res1[$i]->iua_id , 'title' => $res1[$i]->iua_title ));
	    				}
	    			}
	    			$data['act_list'] = $pro_act_list;
	    			$data['pro_act'] = $pro_act;
				}else{
					$pro_act_list = [];
					$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' AND iextpp_id IN(SELECT iextprour_pid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_group = 'true')");
					$result = $query->result();
	    			$data['projects'] = $result;
	    			$data['userflow'] = "false";
	    			for ($ij=0; $ij < count($result) ; $ij++) {
	    				$pro_id = $result[$ij]->iextpp_id ;
	    				$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND a.iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL)  GROUP BY b.iua_status ");
	    				$res = $q->result();
	    				
	    				for ($i=0; $i < count($res) ; $i++) { 
	    					array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
	    				}

	    				$q = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND iua_status = 'progress' AND a.iextpt_tg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ORDER BY iua_id DESC limit 5 ");
		    			$res = $q->result();
		    			for ($i=0; $i < count($res) ; $i++) {
	    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res[$i]->iua_id , 'title' => $res[$i]->iua_title ));
	    				}
	    			}

	    			$data['act_list'] = $pro_act_list;
	    			$data['pro_act'] = $pro_act;
				}
			} else {
			    $query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' ");
    			$result = $query->result();
    			$data['projects'] = $result;
    			$pro_act = [];
    			$pro_act_list = [];
    			for ($ij=0; $ij < count($result) ; $ij++) {
					$pro_id = $result[$ij]->iextpp_id ;
					$q = $this->db->query("SELECT count(b.iua_id) as aid , b.iua_status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' GROUP BY b.iua_status ");
					$res = $q->result();
					for ($i=0; $i < count($res) ; $i++) { 
						array_push($pro_act, array('pid' => $pro_id , 'aid' => $res[$i]->aid , 'status' => $res[$i]->iua_status ));
					}

					$q = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid = b.iua_id WHERE a.iextpt_p_id = '$pro_id' AND a.iextpt_owner = '$oid' AND iua_owner = '$oid' AND b.iua_g_id = '$gid' AND iua_status = 'progress' ORDER BY iua_id DESC limit 5 ");
	    			$res = $q->result();
	    			for ($i=0; $i < count($res) ; $i++) { 
    					array_push($pro_act_list, array('pid' => $pro_id , 'aid' => $res[$i]->iua_id , 'title' => $res[$i]->iua_title ));
    				}
				}
				$data['act_list'] = $pro_act_list;
				$data['pro_act'] = $pro_act;
			}

			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$ert['gid'] = $gid;
			$ert['mid'] = $mid;$ert['mname'] = $mname;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['search'] = 'false';
			if ($alias == '') {
				$ert['title'] = $mname;	
			}else{
				$ert['title'] = $alias;
			}
			$this->load->view('navbar', $ert);
			$this->load->view('projects/project', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

    public function add_projects($code) {
        $sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$data['oid'] = $oid;
			$gid = $sess_data['gid'];
			$data['gid'] = $gid;
			$module = $sess_data['user_mod'];

			$mid = 0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			}
			$ert['mid'] = $mid;$ert['mname'] = $mname;

			if ($gid != 0) {
				$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$uid' WHERE a.ium_gid='$gid' AND a.ium_m_id='$mid' AND i_uname IS NOT NULL ");
				$result = $query->result();
				$data['p_user_list'] = $result;
			}

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			$data['pid'] = 0;
            $data['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['gid'] = $sess_data['gid'];
			if ($alias == '') {
				$ert['title'] = "Add ".$mname;	
			}else{
				$ert['title'] = "Add ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('projects/add_project', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
    }

    public function project_delete($pid,$code){
    	$sess_data = $sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)){
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;

			$this->db->where(array('iextpp_id' => $pid , 'iextpp_owner' => $oid));
            $this->db->delete('i_ext_pro_project');

            $query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_p_id = '$pid'");
            $result = $query->result();
            if (count($result) > 0) {
            	for ($i=0; $i <count($result) ; $i++) { 
            		$aid = $result[$i]->iextpt_aid;
            		$this->db->where(array('iua_id' => $aid));
            		$this->db->update('i_user_activity',array('iua_status'=>'cancel'));
            	}
            }

            $this->db->where(array('iextpt_p_id' => $pid));
            $this->db->delete('i_ext_pro_task');

            $this->db->where(array('iextptg_p_id' => $pid));
            $this->db->delete('i_ext_pro_task_group');

            $this->db->where(array('iextprour_pid' => $pid));
            $this->db->delete('i_ext_pro_user_role');

			redirect(base_url().'Projects/view/null/'.$code);
		}else{
			redirect(base_url().'Account/login');
		}	
    }

    public function add_user_list(){
    	$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)){
			$oid = $sess_data['user_details'][0]->i_owner;
			$uid = $sess_data['user_details'][0]->i_uid;
			$dt = date('Y-m-d H:i:s');
			$user = $this->input->post('i_users');

			$query5 = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name ='$user'");
			$result5 = $query5->result();

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$oid'");
			$result = $query->result();
			
			if (count($result) == 0) {
				$data = array(
					'ip_property' => 'email',
					'ip_owner' =>$oid,
					'ip_section' => 'customer'
				);
				$this->db->insert('i_property',$data);
				$p_id = $this->db->insert_id();
			}else{
				$p_id = $result[0]->ip_id;	
			}
			
			if (count($result5) <= 0) {
				$data = array(
					'ic_name' => $user,
					'ic_owner' => $oid,
					'ic_created' =>$dt,
					'ic_created_by' =>$oid,
					'ic_section' => "customer"
				);
				$this->db->insert('i_customers',$data);
				$insert_id = $this->db->insert_id();

				$data1 = array(
					'icbd_customer_id' => $insert_id,
					'icbd_property' => $p_id,
					'icbd_value' => 'null'
				);
				$this->db->insert('i_c_basic_details',$data1);
			}

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id IN(SELECT ic_id FROM i_customers WHERE ic_owner = '$oid' AND ic_name ='$user')");
			$data['c_details'] = $query1->result();

			$query2 = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_name IN('$user')");
			$data['c_name'] = $query2->result();

			print_r(json_encode($data));

		} else {
			redirect(base_url().'Account/login');
		}
    }

    public function add_email(){
    	$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)){
			$oid = $sess_data['user_details'][0]->i_uid;

			$s_email = $this->input->post('cust_email');
			$s_id = $this->input->post('cust_id');

			$query = $this->db->query("SELECT ip_id FROM i_property WHERE ip_property like '%email%' AND ip_owner= '$oid'");
			$result = $query->result();
			$p_id = $result[0]->ip_id;

			if ($p_id == null) {
				$data = array(
					'ip_property' => 'email',
					'ip_owner' => $oid,
					'ip_section' => 'customer');
				$this->db->insert('i_property',$data);
				$p_id = $this->db->insert_id();
			}

			$data = array('icbd_value' => $s_email );
			$this->db->WHERE(array('icbd_customer_id' => $s_id, 'icbd_property' => $p_id));
			$this->db->update('i_c_basic_details',$data);

			$query1 = $this->db->query("SELECT * FROM i_c_basic_details WHERE icbd_property = '$p_id' AND icbd_customer_id ='$s_id'");
			$data['e_details'] = $query1->result();

			$query2 = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id ='$s_id'");
			$data['e_name'] = $query2->result();

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
    }

	public function save_project($code) {
		$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$users = $this->input->post('users');
			$tags = $this->input->post('tags');
			$dt = date('Y-m-d H:i:s');
			$module = $sess_data['user_mod'];
			$module_id = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			$data = array(
				'iextpp_p_name' => $name,
				'iextpp_p_description' => $description,
				'iextpp_owner' => $oid,
				'iextpp_created' => $dt,
				'iextpp_created_by' => $uid,
				'iextpp_gid' => $gid,
				'iextpp_p_start_date' => $this->input->post('s_date'),
				'iextpp_p_end_date' => $this->input->post('e_date'),
				'iextpp_p_status' => $this->input->post('p_status')
			);
			$this->db->insert('i_ext_pro_project', $data);
			$pid = $this->db->insert_id();

			for ($i=0; $i <count($users) ; $i++) {
				if ($users[$i]['admin'] != 'true' ) {
					$data = array(
						'iextprour_uid' => $users[$i]['id'],
						'iextprour_pid' => $pid,
						'iextprour_project' => $users[$i]['project'],
						'iextprour_group' =>$users[$i]['group']
					);
					$this->db->insert('i_ext_pro_user_role',$data);
				}
			}

			for ($i=0; $i <count($tags) ; $i++) {
				$tname = $tags[$i];
				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0) {
					$tid = $result[0]->it_id;
				}else{
					$data = array(
						'it_value' => $tname,
						'it_owner' =>$oid
					);
					$this->db->insert('i_tags',$data);
					$tid = $this->db->insert_id();
				}

				$data = array(
					'iet_type_id' => $pid,
					'iet_type' => 'project',
					'iet_m_id' => $module_id,
					'iet_tag_id' => $tid,
					'iet_owner' => $oid
				);
				$this->db->insert('i_ext_tags',$data);
			}

			echo $pid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

    public function edit_project($pid,$code) {
        $sess_data = $sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$data['oid'] =$oid;
			$mid = 0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			}
			$ert['mid'] = $mid;$ert['mname'] = $mname;
			if ($gid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$uid' AND iug_id = '$gid'");
				$result = $query->result();
				$admin = '';
				if (count($result) > 0){
					$admin = 'true';
				}else{
					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_admin = 'true'");
					$result = $query->result();
					if (count($result) > 0) {
						$admin = 'true';
					}
				}
				if ($admin == 'true') {
					$data['userflow'] = "true";

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid' AND iextpp_gid = '$gid' ");
	    			$result = $query->result();
	                $proj_name = $result[0]->iextpp_p_name;
	    			$data['edit_project'] = $result;

	    			$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$uid' LEFT JOIN i_ext_pro_user_role as d on a.ium_u_id=d.iextprour_uid AND d.iextprour_pid = '$pid' WHERE a.ium_gid='$gid' AND a.ium_m_id = '$mid' AND b.i_uname IS NOT NULL GROUP BY ium_u_id");
	    			$result = $query->result();
	    			$data['edit_user_list']= $result;
				}else{
					$data['userflow'] = "false";
	    			$query = $this->db->query("SELECT * FROM i_ext_pro_project as a  WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid'  AND iextpp_gid = '$gid'");
	    			$result = $query->result();
	                $proj_name = $result[0]->iextpp_p_name;
	    			$data['edit_project'] = $result;
				}
			}else{
				$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid'");
				$result = $query->result();
				$data['edit_project'] = $result;
				$data['userflow'] = "true";
			}
			$query = $this->db->query("SELECT it_value FROM i_tags WHERE it_owner = '$oid' AND it_id IN(SELECT iet_tag_id FROM i_ext_tags WHERE iet_owner = '$oid' AND iet_type = 'project' AND iet_type_id = '$pid')");
			$result = $query->result();
			$data['pro_tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid' GROUP BY it_value ");
			$result = $query->result();
			$data['tags'] = $result;

			$data['pid'] = $pid;
			$data['gid'] = $gid;
			$ert['gid'] = $gid;
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			if ($alias == '') {
				$ert['title'] = "Edit ".$mname;	
			}else{
				$ert['title'] = "Edit ".$alias;
			}
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('projects/add_project', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
    }
    
    public function update_project($pid,$code) {
		$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$users = $this->input->post('users');
			$tags = $this->input->post('tags');
			$module = $sess_data['user_mod'];
			$module_id = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$module_id = $module[$i]->mid;
						break;
					}
				}
			}
			$dt = date('Y-m-d H:i:s');
			$uid = $sess_data['user_details'][0]->i_uid;
			$data = array(
				'iextpp_p_name' => $name,
				'iextpp_p_description' => $description,
				'iextpp_modified' => $dt,
				'iextpp_modified_by' => $oid,
				'iextpp_p_start_date' => $this->input->post('s_date'),
				'iextpp_p_end_date' => $this->input->post('e_date'),
				'iextpp_p_status' => $this->input->post('p_status')
			);

            $upd_data = array(
                'iextpp_owner' => $oid,
                'iextpp_id' => $pid,
                'iextpp_gid' => $gid );
            $this->db->where($upd_data);
			$this->db->update('i_ext_pro_project', $data);

            $this->db->WHERE(array('iet_owner'=> $oid, 'iet_type' => 'project','iet_type_id'=> $pid));
			$this->db->delete('i_ext_tags');

			for ($i=0; $i <count($users) ; $i++) {
				$us_id = $users[$i]['id'];
				$query = $this->db->query("SELECT * FROM i_ext_pro_user_role WHERE iextprour_uid = '$us_id' AND iextprour_pid = '$pid' ");
				$result = $query->result();
				if (count($result) > 0) {
					$data = array(
						'iextprour_project' => $users[$i]['project'],
						'iextprour_group' =>$users[$i]['group']
					);
					$this->db->WHERE(array('iextprour_uid' => $users[$i]['id'],'iextprour_pid' => $pid));
					$this->db->update('i_ext_pro_user_role',$data);
				}else{
					if ($users[$i]['admin'] != 'true' ) {
						$data = array(
							'iextprour_uid' => $users[$i]['id'],
							'iextprour_pid' => $pid,
							'iextprour_project' => $users[$i]['project'],
							'iextprour_group' =>$users[$i]['group']
						);
						$this->db->insert('i_ext_pro_user_role',$data);
					}
				}
			}

			for ($i=0; $i <count($tags) ; $i++) {
				$tname = $tags[$i];
				$query = $this->db->query("SELECT * FROM i_tags WHERE it_value = '$tname' AND it_owner = '$oid'");
				$result = $query->result();
				if (count($result) > 0) {
					$tid = $result[0]->it_id;
				}else{
					$data = array(
						'it_value' => $tname,
						'it_owner' =>$oid
					);
					$this->db->insert('i_tags',$data);
					$tid = $this->db->insert_id();
				}

				$data = array(
					'iet_type_id' => $pid,
					'iet_type' => 'project',
					'iet_m_id' => $module_id,
					'iet_tag_id' => $tid,
					'iet_owner' => $oid
				);
				$this->db->insert('i_ext_tags',$data);
			}
			echo $pid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_filter($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$oid = $sess_data['user_details'][0]->i_owner;

			$fdate = $this->input->post('fdate');
			$tdate = $this->input->post('tdate');
			$title = $this->input->post('title');
			$cat = $this->input->post('cat');
			$status = $this->input->post('status');
			$p_gid = $this->input->post('p_gid');
			$pid = $this->input->post('pid');
			
			$this->db->select('*');
			$this->db->from('i_user_activity');
			$this->db->join('i_ext_pro_task', 'i_user_activity.iua_id = i_ext_pro_task.iextpt_aid','left');
			if ($fdate != '' && $tdate != '') {
				$this->db->where('iua_date >=', date('Y-m-d H:i:s', strtotime($fdate)));
				$this->db->where('iua_end_date <=', date('Y-m-d H:i:s', strtotime($tdate)));
			}
			if ($status != '' && $status != 'null') {
				$this->db->where('iua_status', $status);
			}
			if ($title != '' && $title != 'null') {
				$this->db->like('iua_title', $title);
			}
			if ($cat != '' && $cat != 'null') {
				$this->db->where('iua_categorise', $cat);
			}
			$this->db->where('iextpt_owner', $oid);
			$this->db->where('iextpt_p_id', $pid);
			$this->db->where('iextpt_tg_id', $p_gid);
			$query = $this->db->get();

			$data['g_task'] = $query->result();

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}
	
	public function edit_project_details($code,$pid,$p_grp=0,$aid=0) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];

			$mid = 0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			}
			$ert['mid'] = $mid;$ert['mname'] = $mname;

			$admin = 'false';
			$data['p_grp'] = $p_grp;

			$child_group_arr=[];$parent_group_arr=[];

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' AND ip_product != '' ");
			$result = $query->result();
			$data['prod_list'] = $result;

			if($gid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_group WHERE iug_owner = '$uid' AND iug_id = '$gid'");
				$result = $query->result();
				if (count($result) > 0){
					$admin = 'true';
				}else{
					$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_u_id = '$uid' AND ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$mid'");
					$result = $query->result();
					if (count($result) > 0) {
						$admin = 'true';
					}
				}
				if ($admin == 'true') {
					$data['admin'] = "true";

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid' AND iextpp_gid = '$gid' ");
	    			$result = $query->result();
	                $proj_name = $result[0]->iextpp_p_name;
	    			$data['edit_project'] = $result;

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid'  ");
					$result = $query->result();
					$data['project_grp'] = $result;

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_product_list as a LEFT JOIN i_product as b on a.iextppl_product_id = b.ip_id WHERE iextppl_owner = '$oid' AND iextppl_project_id = '$pid' AND iextppl_project_group = '$p_grp' ");
					$data['product'] = $query->result();

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_gid = '$gid' AND iextptg_p_grp = '$p_grp' AND iextptg_p_id='$pid' ");
	    			$result = $query->result();
	    			$data['project_details'] = $result;

	    			for ($i=0; $i < count($result); $i++) { 
	    				array_push($child_group_arr, array('key' => $result[$i]->iextptg_id, 'group_ids' => [$result[$i]->iextptg_id], 'current' => [$result[$i]->iextptg_id], 'activities' => []));
	    				$flg_while=false;
	    				while ($flg_while==false) {
		    				$str_tmp = implode(',', $child_group_arr[$i]['current']);

		    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid'");
		    				$res123 = $que123->result();

		    				if(count($res123) > 0) {
		    					$child_group_arr[$i]['current'] = [];
		    					for ($ijk=0; $ijk < count($res123); $ijk++) {
			    					array_push($child_group_arr[$i]['group_ids'], $res123[$ijk]->iextptg_id);
			    					array_push($child_group_arr[$i]['current'], $res123[$ijk]->iextptg_id);
			    				}
		    				} else {
		    					$flg_while=true;
		    				}
		    			}
	    			}
				}else{
					$query = $this->db->query("SELECT * FROM i_ext_pro_product_list as a LEFT JOIN i_product as b on a.iextppl_product_id = b.ip_id WHERE iextppl_owner = '$oid' AND iextppl_created_by = '$uid' AND iextppl_project_id = '$pid' AND iextppl_project_group = '$p_grp' ");
					$data['product'] = $query->result();

					$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ");
					$result = $query->result();
					$data['project_grp'] = $result;

					$query = $this->db->query("SELECT * FROM i_ext_pro_project as a LEFT JOIN i_ext_pro_user_role as b on a.iextpp_id=b.iextprour_pid WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' AND iextprour_uid = '$uid' AND iextprour_project = 'true'");
	    			$result = $query->result();
	    			if (count($result) > 0) {
	    				$proj_name = $result[0]->iextpp_p_name;
		    			$data['edit_project'] = $result;

		    			if ($result[0]->iextprour_project == 'true') {
		    				$data['project'] = "true";
		    			}else{
		    				$data['project'] = 'false';
		    			}
	    			}else{
	    				$query = $this->db->query("SELECT * FROM i_ext_pro_project as a LEFT JOIN i_ext_pro_user_role as b on a.iextpp_id=b.iextprour_pid WHERE iextpp_owner = '$oid' AND iextpp_gid = '$gid' AND iextprour_pid = '$pid' ");
	    				$result = $query->result();
	    				$proj_name = $result[0]->iextpp_p_name;
		    			$data['edit_project'] = $result;

	    				$data['project'] = 'false';
	    			}

	    			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_p_grp = '$p_grp' AND iextptg_id IN (SELECT iextprour_task_gid FROM i_ext_pro_user_role WHERE iextprour_uid = '$uid' AND iextprour_task_gid IS NOT NULL) ");
	    			$result = $query->result();
	    			$data['project_details'] = $result;

	    			for ($i=0; $i < count($result); $i++) { 
	    				array_push($child_group_arr, array('key' => $result[$i]->iextptg_id, 'group_ids' => [$result[$i]->iextptg_id], 'current' => [$result[$i]->iextptg_id], 'activities' => []));
	    				$flg_while=false;
	    				while ($flg_while==false) {
		    				$str_tmp = implode(',', $child_group_arr[$i]['current']);

		    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid' AND iextptg_p_id='$pid'");
		    				$res123 = $que123->result();

		    				if(count($res123) > 0) {
		    					$child_group_arr[$i]['current'] = [];
		    					for ($ijk=0; $ijk < count($res123); $ijk++) { 
			    					array_push($child_group_arr[$i]['group_ids'], $res123[$ijk]->iextptg_id);
			    					array_push($child_group_arr[$i]['current'], $res123[$ijk]->iextptg_id);
			    				}
		    				} else {
		    					$flg_while=true;
		    				}
		    			}
	    			}
				}
			} else {
    			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid'");
    			$result = $query->result();
                $proj_name = $result[0]->iextpp_p_name;
    			$data['edit_project'] = $result;

    			$query = $this->db->query("SELECT * FROM i_ext_pro_product_list as a LEFT JOIN i_product as b on a.iextppl_product_id = b.ip_id WHERE iextppl_owner = '$oid' AND iextppl_project_id = '$pid' AND iextppl_project_group = '$p_grp' ");
				$data['product'] = $query->result();

				$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' ");
				$result = $query->result();
				$data['project_grp'] = $result;
    
                $query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_p_grp = '$p_grp' ");
    			$result = $query->result();
    			$data['project_details'] = $result;

    			for ($i=0; $i < count($result); $i++) { 
    				array_push($child_group_arr, array('key' => $result[$i]->iextptg_id, 'group_ids' => [$result[$i]->iextptg_id], 'current' => [$result[$i]->iextptg_id], 'activities' => []));
    				$flg_while=false;
    				while ($flg_while==false) {
	    				$str_tmp = implode(',', $child_group_arr[$i]['current']);
	    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid' AND iextptg_p_id='$pid'");
	    				$res123 = $que123->result();

	    				if(count($res123) > 0) {
	    					$child_group_arr[$i]['current'] = [];
	    					for ($ijk=0; $ijk < count($res123); $ijk++) { 
		    					array_push($child_group_arr[$i]['group_ids'], $res123[$ijk]->iextptg_id);
		    					array_push($child_group_arr[$i]['current'], $res123[$ijk]->iextptg_id);
		    				}
	    				} else {
	    					$flg_while=true;
	    				}
	    			}
    			}
    			$data['admin'] = "true";
			}
			$group_cost = [] ;
			for ($i=0; $i < count($child_group_arr) ; $i++) { 
				$grp_str_tmp = implode(',', $child_group_arr[$i]['group_ids']);
				$key = $child_group_arr[$i]['key'];

				$query = $this->db->query("SELECT * FROM i_ext_pro_product_list WHERE iextppl_project_id = '$pid' AND iextppl_project_group IN ($grp_str_tmp) AND iextppl_owner = $oid ");
				$result = $query->result();
				$tamount = 0 ;
				for ($ij=0; $ij < count($result) ; $ij++) { 
					$rate = $result[$ij]->iextppl_rate;
					$qty = $result[$ij]->iextppl_qty;
					$tamount =  $tamount + intval($rate) * intval($qty) ;
				}
				array_push($group_cost, array('key' => $key , 'cost' => $tamount ));
			}
			$data['grp_cost'] = $group_cost;
			$act_status = [];
			$act_cat = [];
			for ($i=0; $i < count($child_group_arr); $i++) { 
				$grp_str_tmp = implode(',', $child_group_arr[$i]['group_ids']);

				$query = $this->db->query("SELECT iua_status AS status, COUNT(iua_status) AS count FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id = '$pid' AND iextpt_tg_id IN ($grp_str_tmp) GROUP BY iua_status");
				$result = $query->result();

				for ($ij=0; $ij < count($result); $ij++) {
					array_push($child_group_arr[$i]['activities'], array('status' => $result[$ij]->status, 'count' => $result[$ij]->count));
				}
				$data['project_details_tasks'] = $child_group_arr;
			}
			$query = $this->db->query("SELECT iua_status AS status FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id = '$pid' GROUP BY iua_status");
			$result = $query->result();
			for ($ij=0; $ij < count($result) ; $ij++) {
				array_push($act_status, $result[$ij]->status);
			}

			$query = $this->db->query("SELECT iua_categorise AS cat FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id = '$pid' GROUP BY iua_categorise");
			$result = $query->result();
			for ($ij=0; $ij < count($result) ; $ij++) {
				array_push($act_cat, $result[$ij]->cat);
			}
			$data['act_cat'] = $act_cat;
			$data['act_status'] = $act_status;
			if ($aid != 0) {
				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_id = '$aid'");
				$result = $query->result();
				if ($result[0]->iua_owner != $oid) {
					$oid = $result[0]->iua_owner;
					$data['sid'] = $oid;
					$data['act_cat'] = $iua_categorise;
				}

				$str1 = preg_replace('/\s+/', ' ', trim($result[0]->iua_note));
				if ($str1 != '') {
					$txt_file = $result[0]->iua_note;
					$path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
					$data['note'] = file_get_contents($path.$txt_file);
				}

				$query = $this->db->query("SELECT * FROM i_user_activity WHERE iua_owner='$oid' AND iua_id='$aid'");
				$result = $query->result();
				$data['edit_activity'] = $result;
				$fid = $result[0]->iua_shortcuts;

				$query = $this->db->query("SELECT * FROM i_m_shortcuts where ims_function = '$fid'");
				$result = $query->result();
				if (count($result) > 0) {
					$data['f_name'] = $query->result();
				}

				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid' AND ic_id IN (SELECT iuap_p_id FROM i_u_a_person WHERE iuap_owner ='$oid' AND iuap_a_id = '$aid')");
				$result = $query->result();
				$data['edit_person'] = $result;
				
				$query = $this->db->query("SELECT * FROM i_u_a_todo WHERE iuat_owner = '$oid' AND iuat_a_id = '$aid'");
				$result = $query->result();
				$data['edit_todo'] = $result;
				$data['aid'] = $aid;
			}
			$p_arr = [];
			if ($p_grp != '0') {
				$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_gid = '$gid' AND iextptg_id = '$p_grp' AND iextptg_p_id='$pid' ");
				$result = $query->result();
				$child_group_arr = [];
				array_push($child_group_arr, $result[0]->iextptg_id);
				for ($i=0; $i < count($result); $i++) {
    				$flg = 0 ;
    				while ($flg == 0) {
    					$str_tmp = implode(',', $child_group_arr);
    					$q123 = $this->db->query("SELECT iextptg_p_grp FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_gid = '$gid' AND iextptg_id IN ($str_tmp) ");
						$r123 = $q123->result();
						if (count($r123)) {
							for ($ij=0; $ij < count($r123) ; $ij++) {
								if ($r123[$ij]->iextptg_p_grp == '0') {
									array_push($child_group_arr, $r123[0]->iextptg_p_grp);
									$flg = 1;
								}else{
									array_push($child_group_arr, $r123[0]->iextptg_p_grp);
								}
							}
							$p_arr = [];
							for ($ijk=0; $ijk < count($r123) ; $ijk++) {
								array_push($p_arr, $r123[$ijk]->iextptg_p_grp);
							}
						}
    				}
				}
				array_push($p_arr, $result[0]->iextptg_id);
			}
			if (count($p_arr) > 0 ) {
				$nav_q = implode(',', $p_arr);
				$q123 = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_gid = '$gid' AND iextptg_id IN ($nav_q) ");
				$r123 = $q123->result();
				$data['nav_project'] = $r123;
			}
			
			$query = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id='$pid' AND iextpt_tg_id = '$p_grp' ORDER BY iua_date DESC ");
			$result = $query->result();
			$data['g_task'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_a_todo as a LEFT JOIN i_ext_pro_task as b on a.iuat_a_id=b.iextpt_aid WHERE iextpt_owner = '$oid' AND iextpt_p_id='$pid' AND iextpt_tg_id = '$p_grp' ");
			$data['task_todo'] = $query->result();

			$query = $this->db->query("SELECT ic_name,ic_uid FROM i_customers WHERE ic_owner = '$oid' AND ic_uid IN (SELECT iua_modified_by FROM i_user_activity )");	
			$data['task_perform'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_a_person as a left join i_customers as b on a.iuap_p_id=b.ic_id LEFT JOIN i_ext_pro_task as c on a.iuap_a_id=c.iextpt_aid WHERE ic_owner = '$oid' AND iextpt_owner = '$oid' AND iextpt_p_id='$pid' AND iextpt_tg_id = '$p_grp'");
			$data['task_person'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_comments as a left join i_customers as b on a.iextptc_created_by=b.ic_uid LEFT JOIN i_ext_pro_task as c on a.iextptc_t_id=c.iextpt_id WHERE iextpt_owner = '$oid' AND iextpt_p_id='$pid' AND ic_owner = '$oid' AND iextpt_tg_id = '$p_grp' ORDER BY iextptc_id DESC");
			$data['task_comment'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$uid' LEFT JOIN i_ext_pro_user_role as d on a.ium_u_id=d.iextprour_uid AND d.iextprour_pid = '$pid' WHERE a.ium_gid='$gid' AND a.ium_m_id = '$mid' GROUP BY ium_u_id");
    		$result = $query->result();
    		$data['project_users'] = $result;

    		$query = $this->db->query("SELECT * FROM i_ext_pro_user_role AS a LEFT JOIN i_customers AS b ON a.iextprour_uid=b.ic_uid LEFT JOIN i_u_modules as c on a.iextprour_uid=c.ium_u_id WHERE a.iextprour_pid='$pid' AND b.ic_owner = '$oid' AND iextprour_task_gid IS NOT NULL AND iextprour_group = 'true' AND ium_m_id = '$mid' ");
			$result = $query->result();
    		$data['g_user'] = $result;

			$query = $this->db->query("SELECT * FROM i_m_shortcuts as a LEFT JOIN i_function as b on a.ims_function=b.ifun_id LEFT JOIN i_domain as c on b.ifun_domain_id=c.idom_id");
			$data['m_shortcuts'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_tags WHERE it_owner = '$oid'");
			$result = $query->result();
			$data['tags'] = $result;

			$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
			$result = $query->result();
			$data['user_list'] = $result;
			$data['project_activity'] = 0;

			$data['pid'] = $pid;
            $data['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['gid'] = $sess_data['gid'];
			if ($alias == '') {
				$ert['title'] = $mname." : ".$proj_name;
			}else{
				$ert['title'] = $alias." : ".$proj_name;
			}

			$ert['search'] = "true";
			$this->load->view('navbar',$ert);
			$this->load->view('projects/edit_project_details', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function save_product_list($code,$pid,$p_grp){
		$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$p_list = $this->input->post('p_list');
			if ($uid != $oid) {
				$this->db->WHERE(array('iextppl_owner' => $oid , 'iextppl_created_by' => $uid , 'iextppl_project_id' => $pid , 'iextppl_project_group' => $p_grp ));
				$this->db->delete('i_ext_pro_product_list');
			}else{
				$this->db->WHERE(array('iextppl_owner' => $oid , 'iextppl_project_id' => $pid , 'iextppl_project_group' => $p_grp ));
				$this->db->delete('i_ext_pro_product_list');
			}
			for ($i=0; $i < count($p_list) ; $i++) { 
				$pname = $p_list[$i]['name'];
				$prate = $p_list[$i]['rate'];
				$pqty =	$p_list[$i]['qty'];
				$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pname' AND ip_owner = '$oid' ");
				$result = $query->result();
				if (count($result) > 0 ) {
					$prd_id = $result[0]->ip_id;
				}else{
					$data = array(
						'ip_product' => $pname,
						'ip_owner' => $oid,
						'ip_created' => $dt,
						'ip_created_by' => $uid,
						'ip_section' => 'Products',
						'ip_gid' => $gid,
						'ip_cat_id' => 0
					);
					$this->db->insert('i_product',$data);
					$prd_id = $this->db->insert_id();
				}

				$data = array(
					'iextppl_product_id' => $prd_id,
					'iextppl_qty' => $pqty,
					'iextppl_rate' => $prate,
					'iextppl_project_id' => $pid,
					'iextppl_project_group' => $p_grp,
					'iextppl_owner' => $oid,
					'iextppl_created' => $dt,
					'iextppl_created_by' => $uid
				);
				$this->db->insert('i_ext_pro_product_list',$data);
			}
			echo "true";
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function project_costing ($code,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$gid = $sess_data['gid'];
			$oid = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
						$alias = $module[$i]->m_alias;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_pro_product_list as a LEFT JOIN i_product as b on a.iextppl_product_id = b.ip_id WHERE iextppl_owner = '$oid' AND iextppl_project_id = '$pid' ");
			$data['product'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_p_id = '$pid' AND iextptg_owner = '$oid' ");
			$data['pro_grp'] = $query->result();

			// estimate cost
			$query = $this->db->query("SELECT * FROM i_product as a LEFT JOIN i_p_price as b on a.ip_id = b.ipp_p_id LEFT JOIN i_p_taxes as c on a.ip_id = c.ipt_p_id WHERE ip_owner = '$oid' ");
			$data['p_list'] = $query->result();

			$query = $this->db->query("SELECT * FROM i_tax_group WHERE ittxg_owner='$oid'");
			$result = $query->result();
			$data['tax'] = $result;

			$query = $this->db->query("SELECT * FROM i_taxes as a LEFT JOIN i_tax_group_collection as b on a.itx_id=b.itxgc_tx_id LEFT JOIN i_tax_group as c on b.itxgc_tg_id=c.ittxg_id WHERE a.itx_owner = '$oid'");
			$result = $query->result();
			$data['taxes'] = $result;
			$to_mid = '';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Proposal') {
						$to_mid = $module[$i]->mid;
					}
				}
			}
			$query = $this->db->query("SELECT * FROM i_ext_et_mapping_txn WHERE iextemt_to_mid = '$mid' AND iextemt_from_mid = '$to_mid' AND iextemt_to_txn = '$pid' AND iextemt_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$proposal_id = $result[0]->iextemt_from_txn;
				$query = $this->db->query("SELECT * FROM i_ext_et_proposal as a LEFT JOIN i_ext_et_proposal_product_details as b on a.iextepro_id = b.iexteprod_pro_id where iextepro_id = '$proposal_id' AND iextepro_owner = '$oid' ");
				$data['proposal_list'] = $query->result();
			}
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Inventory') {
						$to_mid = $module[$i]->mid;
					}
				}
			}
			$query = $this->db->query("SELECT * FROM i_ext_et_mapping_txn WHERE iextemt_to_mid = '$mid' AND iextemt_from_mid = '$to_mid' AND iextemt_to_txn = '$pid' AND iextemt_owner = '$oid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$inv_id = $result[0]->iextemt_from_txn;
				// echo "SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id where iextei_id = '$inv_id' AND iextei_owner = '$oid' ";
				$query = $this->db->query("SELECT * FROM i_ext_et_inventory as a LEFT JOIN i_ext_et_inventory_details as b on a.iextei_id = b.iexteid_e_id where iextei_id = '$inv_id' AND iextei_owner = '$oid' ");
				$data['inv_list'] = $query->result();
			}


			$data['oid'] = $oid;
			$data['gid'] = $gid;
			$ert['gid'] = $gid;
			$ert['mid'] = $mid;$ert['mname'] = $mname;
			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection'] = $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['search'] = 'false';
			if ($alias == '') {
				$ert['title'] = $mname . ' : Group costing';	
			}else{
				$ert['title'] = $alias . ' : Group costing';
			}
			$this->load->view('navbar', $ert);
			$this->load->view('projects/project_costing', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function project_transfer($pid,$code,$gid){
		$sess_data = $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$dt = date('Y-m-d H:i:s');

				$data = array(
					'iextpp_gid' => $gid,
					'iextpp_modified' => $dt,
					'iextpp_modified_by' => $uid
				);
				$this->db->where(array('iextpp_id' => $pid));
				$this->db->update('i_ext_pro_project',$data);

				$data = array(
					'iextptg_gid' => $gid,
					'iextptg_modified' => $dt,
					'iextptg_modified_by' => $uid
				);
				$this->db->where(array('iextptg_p_id' => $pid));
				$this->db->update('i_ext_pro_task_group',$data);

				$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_p_id = '$pid' AND iextpt_owner = '$oid' ");
				$result = $query->result();
				for ($i=0; $i <count($result) ; $i++) {
					$aid = $result[$i]->iextpt_aid;
					$data = array(
						'iua_g_id' => $gid
					);
					$this->db->where(array('iua_id' => $aid,'iua_owner'=>$oid));
					$this->db->update('i_user_activity',$data);	
				}
				
				$data = array(
					'iextpt_gid' => $gid
				);
				$this->db->where(array('iextpt_p_id' => $pid));
				$this->db->update('i_ext_pro_task',$data);

			echo "true";

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_search($code) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$search = $this->input->post('search');
			$p_gid = $this->input->post('p_gid');
			$pid = $this->input->post('pid');

			$query = $this->db->query("SELECT * FROM i_ext_pro_task as a LEFT JOIN i_user_activity as b on a.iextpt_aid=b.iua_id WHERE iextpt_owner = '$oid' AND iextpt_p_id='$pid' AND iextpt_tg_id = '$p_gid' AND iua_title LIKE '%$search%' ORDER BY iua_date DESC ");
			$result = $query->result();
			$data['g_task'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}
	
	public function add_task_group($code,$pid) {
	    $sess_data = $sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod'];
			$mid = 0;$mname='';
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$mname = $module[$i]->mname;
					}
				}
			}
			$ert['mid'] = $mid;$ert['mname'] = $mname;

			if ($gid != 0) {

				$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$uid' LEFT JOIN i_ext_pro_user_role as d on a.ium_u_id=d.iextprour_uid AND d.iextprour_pid = '$pid' WHERE a.ium_gid='$gid' AND a.ium_m_id = '$mid' GROUP BY b.i_uid ");
	    		$result = $query->result();
				$data['edit_user_list'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid' AND iextpp_gid = '$gid' ");
				$result = $query->result();
	            $proj_name = $result[0]->iextpp_p_name;
				$data['edit_project'] = $result;
	            
	            $query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id = '$pid'");
				$result = $query->result();
				$data['edit_task_group'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_pro_user_role AS a LEFT JOIN i_customers AS b ON a.iextprour_uid=b.ic_uid WHERE a.iextprour_pid = '$pid' AND b.ic_owner = '$oid'");
				$result = $query->result();
				$data['edit_task_group_users'] = $result;

			}else{
				$query = $this->db->query("SELECT * FROM i_customers WHERE ic_owner = '$oid'");
				$result = $query->result();
				$data['employees'] = $result;
				
				$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid'");
				$result = $query->result();
	            $proj_name = $result[0]->iextpp_p_name;
				$data['edit_project'] = $result;
	            
	            $query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id = '$pid'");
				$result = $query->result();
				$data['edit_task_group'] = $result;

				$query = $this->db->query("SELECT * FROM i_ext_pro_user_role AS a LEFT JOIN i_customers AS b ON a.iextprour_uid=b.ic_uid WHERE a.iextprour_pid = '$pid' AND b.ic_owner = '$oid'");
				$result = $query->result();
				$data['edit_task_group_users'] = $result;
			}
            
            $data['pid'] = $pid;
            $data['oid'] = $oid;
            $data['gid'] = $sess_data['gid'];
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['gid'] = $sess_data['gid'];
            
			$ert['title'] = $proj_name.' - Add Task Groups';
			$ert['search'] = "false";

			$this->load->view('navbar', $ert);
			$this->load->view('projects/add_task_groups', $data);
			$this->load->view('home/search_modal');
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function delete_task_group($code,$tid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_id='$tid' AND iextptg_owner= '$oid' ");
			$result = $query->result();
			$pid = $result[0]->iextptg_p_id;
			$msg_id = $result[0]->iextptg_msg_id;

			$this->db->where(array('iextptg_id' => $tid,'iextptg_p_id' => $pid));
			$this->db->delete('i_ext_pro_task_group');

			$this->db->where(array('iextprour_task_gid' => $tid,'iextprour_pid'=>$pid));
			$this->db->delete('i_ext_pro_user_role');

			$this->db->where(array('ime_owner' => $oid , 'ime_id' => $msg_id));
			$this->db->delete('i_messaging');

			$this->db->where(array('imm_owner' => $oid , 'imm_m_id' => $msg_id));
			$this->db->delete('i_m_members');

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid' AND iextptg_p_grp = '$tid' AND iextptg_p_id='$pid' ");
			$result = $query->result();
			$data['project_details'] = $result;
			$child_group_arr= [];
			for ($i=0; $i < count($result); $i++) { 
				array_push($child_group_arr, array('key' => $result[$i]->iextptg_id, 'group_ids' => [$result[$i]->iextptg_id], 'current' => [$result[$i]->iextptg_id], 'activities' => []));
				$flg_while=false;
				while ($flg_while==false) {
    				$str_tmp = implode(',', $child_group_arr[$i]['current']);

    				$que123 = $this->db->query("SELECT iextptg_id FROM i_ext_pro_task_group WHERE iextptg_p_grp IN ($str_tmp) AND iextptg_owner='$oid'");
    				$res123 = $que123->result();

    				if(count($res123) > 0) {
    					$child_group_arr[$i]['current'] = [];
    					for ($ijk=0; $ijk < count($res123); $ijk++) { 
	    					array_push($child_group_arr[$i]['group_ids'], $res123[$ijk]->iextptg_id);
	    					array_push($child_group_arr[$i]['current'], $res123[$ijk]->iextptg_id);
	    				}
    				} else {
    					$flg_while=true;
    				}
    			}
			}

			for ($i=0; $i <count($child_group_arr[0]['group_ids']) ; $i++) { 
				$tsk_id = $child_group_arr[0]['group_ids'][$i];
				$this->db->where(array('iextptg_id' => $tsk_id,'iextptg_p_id' => $pid));
				$this->db->delete('i_ext_pro_task_group');

				$this->db->where(array('iextprour_task_gid' => $tsk_id,'iextprour_pid'=>$pid));
				$this->db->delete('i_ext_pro_user_role');
			}

			redirect(base_url().'Projects/edit_project_details/'.$code.'/'.$pid.'/0');
		} else {
			redirect(base_url().'Account/login');
		}	
	}
	
	public function get_task_group_details($pid,$code) {
	    $sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			
			$g=$this->input->post('tgid');

			$mid = 0;
			$module = $sess_data['user_mod'];

			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
					}
				}
			}
			$data['mid'] =$mid;
			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_id = '$g' AND iextptg_p_id='$pid'");
			$result = $query->result();
			$data['group'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_owner = '$oid' AND iextptg_p_id='$pid'");
			$result = $query->result();
			$data['g_list'] = $result;

			$query = $this->db->query("SELECT * FROM i_u_modules AS a LEFT JOIN i_users AS b ON a.ium_u_id=b.i_uid LEFT JOIN i_customers AS c ON a.ium_u_id=c.ic_uid AND c.ic_owner='$uid'  LEFT JOIN i_ext_pro_user_role as d on d.iextprour_uid=a.ium_u_id WHERE  d.iextprour_pid = '$pid' AND a.ium_m_id = '$mid' GROUP BY ium_u_id ");
    		$result = $query->result();
    		$data['edit_user_list'] = $result;

    		$query = $this->db->query("SELECT iextprour_uid FROM i_ext_pro_user_role WHERE iextprour_pid = '$pid' AND iextprour_task_gid = '$g'");
    		$result = $query->result();
    		$data['grp_user'] = $result;

			print_r(json_encode($data));
		} else {
			redirect(base_url().'Account/login');
		}
	}
	
	public function save_task_group($pid,$code) {
		$sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$dt = date('Y-m-d H:i:s');

			$name = $this->input->post('name');
			$staff = $this->input->post('people');
			$sel=$this->input->post('sel');
			
			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_id = '$pid' AND iextpp_owner = '$oid' ");
			$result = $query->result();
			$gid = $result[0]->iextpp_gid;

			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);
			$data = array(
				'ime_title' => $name,
				'ime_file' => (string)$dt_str,
				'ime_owner' => $oid,
				'ime_created' => $dt,
				'ime_created_by' => $uid,
				'ime_status' => 'true'
			);
			$this->db->insert('i_messaging', $data);
			$insid = $this->db->insert_id();

			$data = array(
				'imm_c_id' => $oid,
				'imm_m_id' => $insid,
				'imm_owner' => $oid
			);
			$this->db->insert('i_m_members', $data);
			$user_arr = [];

			$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$mid'");
			$result = $query->result();
			if (count($result) > 0) {
				for ($i=0; $i < count($result) ; $i++) { 
					$m_uid = $result[$i]->ium_u_id;
					$data = array(
						'imm_c_id' => $m_uid,
						'imm_m_id' => $insid,
						'imm_owner' => $oid
					);
					$this->db->insert('i_m_members', $data);
					array_push($user_arr , $m_uid);
				}
			}


			$data = array(
				'iextptg_p_id' => $pid,
				'iextptg_name' => $name,
				'iextptg_owner' => $oid,
				'iextptg_created' => $dt,
				'iextptg_created_by' => $uid,
				'iextptg_gid' => $gid,
				'iextptg_p_grp' => $sel,
				'iextptg_msg_id' => $insid
			);
			$this->db->insert('i_ext_pro_task_group', $data);
			$ptgid = $this->db->insert_id();

			$dt1=date_create();
			$dt_str = date_timestamp_get($dt1);

			for($i=0;$i < count($staff); $i++) {
				if ($staff[$i]['project'] == 'false' && $staff[$i]['project'] != '') {
					if ($staff[$i]['group'] == 'true') {
						$data = array(
							'iextprour_task_gid' => $ptgid,
							'iextprour_uid' => $staff[$i]['id'],
							'iextprour_pid' => $pid,
							'iextprour_project' => 'false',
							'iextprour_group' => 'true'
						);
						$this->db->insert('i_ext_pro_user_role', $data);

						$data = array(
							'imm_c_id' => $staff[$i]['id'],
							'imm_m_id' => $insid,
							'imm_owner' => $oid
						);
						$this->db->insert('i_m_members', $data);
						array_push($user_arr , $staff[$i]['id']);
					}
				}
			}

			$jarr = [];
			array_push($jarr, array('mid' => $insid, 'title' => $name, 'data' => array('from' => $oid, 'read' => array() , 'unread' => $user_arr , 'attachment' => 'null', 'message' => 'created group', 'date' => $dt , 'msg_type' => 'grp_create' , 'msg_type_id' => $name )));
			$jstr = json_encode($jarr);
			$upload_dir = $this->config->item('document_rt')."assets/data/msg/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				$handle = fopen($upload_dir.$dt_str.'.json', 'w') or die('Error');
				fwrite($handle, $jstr);
			}
			fclose($handle);

			echo $pid;
		} else {
			redirect(base_url().'Account/login');
		}
	}
	
	public function update_task_group($pid,$code) {
		$sess_data = $this->log_code->get_session_value($code,false);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid; 
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$dt = date('Y-m-d H:i:s');

			$name = $this->input->post('name');
			$staff = $this->input->post('people');
			$sel=$this->input->post('sel');
			$sel_gid = $this->input->post('sel_gid');
			
			$data = array(
				'iextptg_name' => $name,
				'iextptg_p_grp' => $sel,
				'iextptg_modified' => $dt,
				'iextptg_modified_by' => $uid
			);
			$this->db->WHERE(array('iextptg_p_id' => $pid,'iextptg_owner' => $oid,'iextptg_id'=>$sel_gid));
			$this->db->update('i_ext_pro_task_group', $data);

			$query = $this->db->query("SELECT * FROM i_ext_pro_task_group WHERE iextptg_p_id = '$pid' AND iextptg_owner = '$oid' AND iextptg_id = '$sel_gid' ");
			$res = $query->result();
			$msg_id = 0;
			if (count($res) > 0 ) {
				$msg_id = $res[0]->iextptg_msg_id;
			}

			$data = array('ime_title' => $name);
			$this->db->where(array('ime_owner' => $oid , 'ime_id' => $msg_id));
			$this->db->update('i_messaging', $data);

			if (count($staff) > 0) {
				$this->db->WHERE(array('iextprour_task_gid' => $sel_gid));
				$this->db->delete('i_ext_pro_user_role');

				$this->db->where(array('imm_owner' => $oid , 'imm_m_id' => $msg_id));
				$this->db->delete('i_m_members');

				for($i=0;$i < count($staff); $i++) {
					if ($staff[$i]['project'] == 'false' && $staff[$i]['project'] != '') {
						if ($staff[$i]['group'] == 'true') {
							$data = array(
								'iextprour_task_gid' => $sel_gid,
								'iextprour_uid' => $staff[$i]['id'],
								'iextprour_pid' => $pid,
								'iextprour_project' => 'false',
								'iextprour_group' => 'true'
							);
							$this->db->insert('i_ext_pro_user_role', $data);

							$data = array(
								'imm_c_id' => $staff[$i]['id'],
								'imm_m_id' => $msg_id,
								'imm_owner' => $oid
							);
							$this->db->insert('i_m_members', $data);
						}
					}
				}

				$data = array(
					'imm_c_id' => $oid,
					'imm_m_id' => $msg_id,
					'imm_owner' => $oid
				);
				$this->db->insert('i_m_members', $data);

				$query = $this->db->query("SELECT * FROM i_u_modules WHERE ium_gid = '$gid' AND ium_admin = 'true' AND ium_m_id = '$mid'");
				$result = $query->result();
				if (count($result) > 0) {
					for ($i=0; $i < count($result) ; $i++) { 
						$m_uid = $result[$i]->ium_u_id;
						$data = array(
							'imm_c_id' => $m_uid,
							'imm_m_id' => $msg_id,
							'imm_owner' => $oid
						);
						$this->db->insert('i_m_members', $data);
					}
				}
			}

			echo $pid;
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_activity_comments($code,$pid,$grp){
		$sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$tid=0;
			$aid = $this->input->post('id');
			$p_note = $this->input->post('p_note');
			$query = $this->db->query("SELECT * FROM i_ext_pro_task WHERE iextpt_p_id = '$pid' AND iextpt_tg_id = '$grp' AND iextpt_aid = '$aid' ");
			$result = $query->result();
			if (count($result) > 0 ) {
				$tid = $result[0]->iextpt_id;
			}
			$data = array(
				'iextptc_p_id' => $pid,
				'iextptc_tg_id' => $grp,
				'iextptc_t_id' => $tid,
				'iextptc_comment' => $p_note,
				'iextptc_created' => $dt,
				'iextptc_owner' => $oid,
				'iextptc_created_by' => $uid
			);
			$this->db->insert('i_ext_pro_task_comments',$data);

			echo "true";

		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_doc_details($code,$pid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if(isset($sess_data)) {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod']; 
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
						$alias = $module[$i]->m_alias;
						$mname = $module[$i]->mname;
					}
				}
			}

			$query = $this->db->query("SELECT * FROM i_ext_pro_project WHERE iextpp_owner = '$oid' AND iextpp_id='$pid'");
			$result = $query->result();
            $proj_name = $result[0]->iextpp_p_name;
			$data['edit_project'] = $result;

			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner= '$oid' AND icd_mid = '$mid' AND icd_type_id = '$pid' ");
			$result = $query->result();
			$data['doc'] = $result;

			$data['pid'] = $pid;
            $data['oid'] = $oid;
			$ert['mod'] = $sess_data['user_mod']; 
			$ert['name'] = $sess_data['user_details'][0]->iud_name;
			$ert['user_connection']= $sess_data['user_connection'];
			$ert['code'] = $sess_data['code'];
			$ert['gid'] = $sess_data['gid'];
			if ($alias == '') {
				$ert['title'] = $mname." : ".$proj_name;
			}else{
				$ert['title'] = $alias." : ".$proj_name;
			}
			$ert['search'] = "false";
			$this->load->view('navbar',$ert);
			$this->load->view('projects/project_doc', $data);
			$this->load->view('home/search_modal');			
		} else {
			redirect(base_url().'Account/login');
		}
	}

	public function project_upload_file($code,$pid) {
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$module = $sess_data['user_mod']; 
			if (count($module) > 0) {
				for ($i=0; $i <count($module) ; $i++) { 
					if ($module[$i]->mname == 'Projects') {
						$mid = $module[$i]->mid;
					}
				}
			}

			$dt = date('Y-m-d H:i:s');
			$upload_dir = $this->config->item('document_rt')."assets/uploads/".$oid."/";
			if(!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

			$img_path = "";
			if (is_dir($upload_dir) && is_writable($upload_dir)) {
				for ($i=0; $i <count($_FILES['used']['tmp_name']) ; $i++) {
					
					$sourcePath = $_FILES['used']['tmp_name'][$i];
					$target = $upload_dir.$_FILES['used']['name'][$i];

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
						'icd_cid' => $uid,
						'icd_date' => $dt,
						'icd_type' => 'document',
						'icd_timestamp' => $timestamp_value.'.'.$ext,
						'icd_mid' => $mid,
						'icd_type_id' => $pid,
						'icd_status' => 'true'
					);
					$this->db->insert('i_c_doc', $data);
					$timestamp_value = '';
				}	
				$img_path = '';
			}
			$query = $this->db->query("SELECT * FROM i_c_doc WHERE icd_owner= '$oid' AND icd_mid = '$mid' AND icd_type_id = '$pid' ");
			$result = $query->result();
			$data['doc'] = $result;
			
			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}
}
