<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dialogflow extends CI_Controller {

	public function __construct()	{
		parent:: __construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function receive_callback() {
	    
	    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        //$txt = implode(" ", $this->input->post());
        $txt = "Works";
        fwrite($myfile, $txt);
        fclose($myfile);
	}
}
