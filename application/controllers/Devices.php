<?php
class Devices extends CI_Controller {
	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('directory');
		$this->load->helper('cookie');
	}

	public function rfid_reader() {
	    $dt = date('Y-m-d H:i:s');
	    $s = $this->input->post('s');
	    $sv = $this->input->post('sv');
	    $data = array(
	        'ica_device_id' => $s,
	        'ica_card_id' => $sv,
	        'ica_date' => $dt);
	   $this->db->insert('i_c_attendance', $data);
	   echo "Okay Mr.";
	}
}
