<?php
require_once(APPPATH. 'vendor/autoload.php');
class Barcoding extends CI_Controller {
public function __construct()	{
	parent:: __construct();
	$this->load->database();
	$this->load->helper('url');
	$this->load->library('session');
	$this->load->library('email');
	$this->load->library('excel_reader');
	$this->load->library('pagination');
	$this->load->model('Code','log_code');
	$this->load->model('Mail','Mail');
}

########## HOME ################
	public function home($mid = null,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$data['oid'] = $sess_data['user_details'][0]->i_owner;
			$module = $sess_data['user_mod'];
			for ($i=0; $i <count($module) ; $i++) { 
				if ($module[$i]->mname == 'Barcode') {
					$mid = $module[$i]->mid;
					$alias = $module[$i]->m_alias;
					break;
				}
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_barcode WHERE iextb_owner = '$oid' ORDER BY iextb_id DESC ");
			$result = $query->result();
			$data['barcode'] = $result;

			$ert['mod'] = $sess_data['user_mod']; $ert['name'] = $sess_data['user_details'][0]->iud_name; 
			$ert['mid'] = $mid;$ert['mname']='Barcode';$ert['code']=$code;$ert['gid']=$gid;$ert['user_connection']=$sess_data['user_connection'];
			if ($alias == '') {
				$ert['title'] = "Barcode printing";
			}else{
				$ert['title'] = $alias." printing";
			}
			$ert['search'] = "true";

			$this->load->view('navbar', $ert);
			$this->load->view('barcoding/home', $data);
			$this->load->view('home/search_modal');
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function save_barcode($code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$pname = $this->input->post('p_name');
			$pqty = $this->input->post('p_qty');
			$ptype = $this->input->post('p_type');
			$pcode = $this->input->post('p_code');
			$ptitle = $this->input->post('p_title');

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pname' AND ip_owner = '$oid' ");
			$result = $query->result();
			$pid = 0;
			if (count($result) > 0) {
				$pid = $result[0]->ip_id;
			}
			$data = array(
				'iextb_pid' => $pid,
				'iextb_qty' => $pqty,
				'iextb_barcode_type' => $ptype,
				'iextb_code' => $pcode,
				'iextb_owner' => $oid,
				'iextb_created' => $dt,
				'iextb_created_by' => $uid,
				'iextb_title' => $ptitle
			);
			$this->db->insert('i_ext_et_barcode',$data);
			$inid = $this->db->insert_id();

			$query = $this->db->query("SELECT * FROM i_ext_et_barcode as a LEFT JOIN i_ext_et_barcode_printing as b on a.iextb_id = b.iextbp_barcode_id WHERE iextb_owner = '$oid' AND iextb_code = '$pcode' ORDER BY iextbp_barcode_serial_number DESC ");
			$result = $query->result();
			$b_sn = $result[0]->iextbp_barcode_serial_number + 1;

			for ($i=0; $i < $pqty ; $i++) {
				$data = array(
					'iextbp_barcode_id' => $inid,
					'iextbp_barcode_serial_number' => $b_sn
				);
				$this->db->insert('i_ext_et_barcode_printing',$data);
				if ($ptype != 'same') {
					$b_sn++;
				}
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT iextb_id , iextb_qty , iextb_barcode_type , iextb_code , DATE(iextb_created) as date1 , iextb_pid , iextb_title FROM i_ext_et_barcode WHERE iextb_owner = '$oid' ORDER BY iextb_id DESC ");
			$result = $query->result();
			$data['barcode_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function update_barcode($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];
			$dt = date('Y-m-d H:i:s');
			$pname = $this->input->post('p_name');
			$pqty = $this->input->post('p_qty');
			$ptype = $this->input->post('p_type');
			$pcode = $this->input->post('p_code');
			$ptitle = $this->input->post('p_title');

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_product = '$pname' AND ip_owner = '$oid' ");
			$result = $query->result();
			$pid = 0;
			if (count($result) > 0) {
				$pid = $result[0]->ip_id;
			}

			$data = array(
				'iextb_pid' => $pid,
				'iextb_qty' => $pqty,
				'iextb_barcode_type' => $ptype,
				'iextb_code' => $pcode,
				'iextb_title' => $ptitle
			);
			$this->db->WHERE(array('iextb_owner' => $oid, 'iextb_id' => $inid ));
			$this->db->update('i_ext_et_barcode',$data);

			$this->db->WHERE(array('iextbp_barcode_id' => $inid));
			$this->db->delete('i_ext_et_barcode_printing');

			$query = $this->db->query("SELECT * FROM i_ext_et_barcode as a LEFT JOIN i_ext_et_barcode_printing as b on a.iextb_id = b.iextbp_barcode_id WHERE iextb_owner = '$oid' AND iextb_code = '$pcode' ORDER BY iextbp_barcode_serial_number DESC ");
			$result = $query->result();
			$b_sn = $result[0]->iextbp_barcode_serial_number + 1;

			for ($i=0; $i < $pqty ; $i++) {
				$data = array(
					'iextbp_barcode_id' => $inid,
					'iextbp_barcode_serial_number' => $b_sn
				);
				$this->db->insert('i_ext_et_barcode_printing',$data);
				if ($ptype != 'same') {
					$b_sn++;
				}
			}

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT iextb_id , iextb_qty , iextb_barcode_type , iextb_code , DATE(iextb_created) as date1 , iextb_pid , iextb_title FROM i_ext_et_barcode WHERE iextb_owner = '$oid' ORDER BY iextb_id DESC ");
			$result = $query->result();
			$data['barcode_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function delete_barcode($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$this->db->WHERE(array('iextb_owner' => $oid, 'iextb_id' => $inid ));
			$this->db->delete('i_ext_et_barcode');

			$this->db->WHERE(array('iextbp_barcode_id' => $inid));
			$this->db->delete('i_ext_et_barcode_printing');

			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT iextb_id , iextb_qty , iextb_barcode_type , iextb_code , DATE(iextb_created) as date1 , iextb_pid FROM i_ext_et_barcode WHERE iextb_owner = '$oid' ORDER BY iextb_id DESC ");
			$result = $query->result();
			$data['barcode_list'] = $result;

			print_r(json_encode($data));
		}else{
			redirect(base_url().'Account/login');
		}
	}

	public function print_barcode($code,$inid){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$company_name = $sess_data['user_details'][0]->iud_company;
			
			$gid = $sess_data['gid'];
			
			$query = $this->db->query("SELECT * FROM i_product WHERE ip_owner = '$oid' ");
			$result = $query->result();
			$data['product'] = $result;

			$query = $this->db->query("SELECT * FROM i_ext_et_barcode WHERE iextb_owner = '$oid' AND iextb_id = '$inid' ");
			$result = $query->result();
			$b_sn = $result[0]->iextb_code;
			$b_title = $result[0]->iextb_title;

			$query = $this->db->query("SELECT * FROM i_ext_et_barcode_printing WHERE iextbp_barcode_id = '$inid' ");
			$result = $query->result();
			$print_barcode = [];
			for ($i=0; $i < count($result) ; $i++) { 
				$code_text = $b_sn.$result[$i]->iextbp_barcode_serial_number;
				$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
				$code = $Bar->getBarcode($code_text, $Bar::TYPE_INTERLEAVED_2_5_CHECKSUM, 2, 50);
				array_push($print_barcode, array('code' => $code , 'val' => $code_text ));
			}

			$page = '<table cellspacing="40">';
			$f=0;
			for ($i=0; $i <count($print_barcode) ; $i++) { 
				if($f==0) {
					$page.='<tr>';
				}
				$page.='<td><p style="text-align:center;margin-top:0px;font-size:0.9em;margin-bottom:2px;">'.$company_name.'<br>'.$b_title.'</p>'.$print_barcode[$i]['code'].'<p style="text-align:center;margin-top:0px;font-size:0.7em;">'.$print_barcode[$i]['val'].'</p></td>';
				$f++;
				if($f==4) {
					$page.='</tr>';
					$f=0;
				}
			}
			$page.='</table>';
			$path = $this->config->item('document_rt').'assets/data/'.$oid.'/barcode/';
		    if(!file_exists($path)) {
					mkdir($path, 0777, true);
			}
			$dt = strtotime(date('Y-m-d H:i:s'));
		    $htmlfile = $inid.'.html';
		    $invoicefile = $inid.'.pdf';

		    file_put_contents($path.$htmlfile, $page);
		    shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile.' 2>&1');

			echo $invoicefile;
		}else{
			redirect(base_url().'Account/login');
		}
	}
}