<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extras extends CI_Controller {


	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->dbforge();
	}

######### CHECK DEMO USER
	public function check_existance()	{
		if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
		$name = $this->input->post('name');
		$email = $this->input->post('email');

		$query = $this->db->query("SELECT * FROM demo_user_details WHERE dmud_name = '$name' AND dmud_email = '$email'");
		$result = $query->result();

		if (count($result) > 0) {
			echo "true";
		} else {
			echo "false";
		}
	}


	public function update_demo_user() {
		if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$company = $this->input->post('company');
		$ip = $this->input->post('ip');
		$location = $this->input->post('location');

		$data = array(
			'dmud_name' => $name ,
			'dmud_email' => $email,
			'dmud_phone' => $phone,
			'dmud_company' => $company,
			'dmud_ip' => $ip,
			'dmud_location' => $location );

		$this->db->insert('demo_user_details', $data);

		echo "true";
	}
}