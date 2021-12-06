<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {
	
	public function mailing($a,$b){
		return $a.$b;
	}
}