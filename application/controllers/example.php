<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

	public function index()
    {
    
	    //Load the library
	    $this->load->library('html2pdf');
	    
	    //Set folder to save PDF to
	    $this->html2pdf->folder('./assets/pdfs/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename('test.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper('a4', 'portrait');
	    
	    $data = array(
	    	'title' => 'PDF Created',
	    	'message' => 'Hello World!'
	    );

	    $opts = array('http' => array('header'=> 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
	    $context = stream_context_create($opts);
	    $page = file_get_contents('http://localhost/KrishnakantPatole/irene/Enterprise/invoice_print/35/106', false,$context);
	    
	    // $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
	    $path = '/Users/krishnakant/Dropbox/KrishnakantPatole/irene/assets/uploads/6/html/';
	    $htmlfile = 'invoice.html';
	    $invoicefile = 'invoice.pdf';
	    file_put_contents($path.$htmlfile, $page);
	    
	    //echo 'sudo wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile;
	    // shell_exec('wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile);

		$output = shell_exec('/usr/local/bin/wkhtmltopdf '.$path.$htmlfile.' '.$path.$invoicefile. ' 2>&1');
		echo $output; 
	    // echo shell_exec('ls -all');
	    //Load html view
	    // $this->html2pdf->html($page);
	    
	    // print_r($page);

	    // if($this->html2pdf->create('save')) {
	    // 	//PDF was successfully saved or downloaded
	    // 	echo 'PDF saved';
	    // }
	    
    } 
    
	public function mail_pdf()
    {
		//Load the library
	    $this->load->library('html2pdf');
	    
	    $this->html2pdf->folder('./assets/pdfs/');
	    $this->html2pdf->filename('email_test.pdf');
	    $this->html2pdf->paper('a4', 'portrait');
	    
	    $data = array(
	    	'title' => 'PDF Created',
	    	'message' => 'Hello World!'
	    );
	    //Load html view
	    $this->html2pdf->html($this->load->view('pdf', $data, true));
	    //Check that the PDF was created before we send it
	    if($path = $this->html2pdf->create('save')) {
	    	
			$this->load->library('email');

			$this->email->from('your@example.com', 'Your Name');
			$this->email->to('someone@example.com'); 
			
			$this->email->subject('Email PDF Test');
			$this->email->message('Testing the email a freshly created PDF');	

			$this->email->attach($path);

			$this->email->send();
			
			echo $this->email->print_debugger();
						
	    }
	    
    } 
}

/* End of file example.php */
/* Location: ./application/controllers/example.php */