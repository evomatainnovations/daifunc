<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library('email');
		$this->load->library('excel_reader');
		$this->load->helper('directory');
		$this->load->dbforge();
	}

	public function x($mode) {
		$ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
		$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
		$dt = date('Y-m-d H:i:s');
		if (count($query) > 0) {
			$data = array(
				'iuv_mode' => $mode,
				'iuv_agent' => $_SERVER['HTTP_USER_AGENT'],
				'iuv_date' => $dt,
				'iuv_remote_add' => $query['query'],
				'iuv_country'=> $query['country'],
				'iuv_region' => $query['regionName'],
				'iuv_city' => $query['city'],
				'iuv_zip' => $query['zip'],
				'iuv_lat' => $query['lat'],
				'iuv_lon' => $query['lon'],
				'iuv_timezone' => $query['timezone'],
				'iuv_isp' => $query['isp']
			);
			$this->db->insert('i_users_visit',$data);
			redirect(base_url().'Account');
		}
	}
}