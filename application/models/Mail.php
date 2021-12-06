<?php
use PHPMailer\PHPMailer\PHPMailer AS phpmail;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH. 'PHPMailer/src/Exception.php');
require_once(APPPATH. 'PHPMailer/src/PHPMailer.php');
require_once(APPPATH. 'PHPMailer/src/SMTP.php');
class Mail extends CI_Model {
	public function send_mail($sub,$to,$attach,$body,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {

			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$query = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
			$result = $query->result();

			$mail = new phpmail(true);
			try {
				$mail->SMTPDebug = 2;                                 // Enable verbose debug output
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    // $mail->Host = $result[0]->iumail_domain;  // Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    // $mail->Username = $result[0]->iumail_mail;                 // SMTP username
			    // $mail->Password = $result[0]->iumail_password;                           // SMTP password
			    // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = $result[0]->iumail_port;                                    // TCP port to connect to
			    // $mail->setFrom($result[0]->iumail_mail);
			    $mail->Host = 'mail.evomata.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'noreply@evomata.com';
			    $mail->Password = 'ASD789456';
			    $mail->SMTPSecure = 'tls';
			    $mail->Port = '587';
			    $mail->setFrom('noreply@evomata.com');
			    $mail->addAddress($to);
			    if ($attach != null) {
			    	$mail->addAttachment($attach);	
			    }
			    $mail->isHTML(true);                                // Set email format to HTML
			    $mail->Subject = $sub;
			    $mail->Body    = $body;
				$mail->send();
			}catch(Exception $e) {
				return 'false';
			}
			return 'true';
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function send_daifunc_mail($sub,$to,$attach,$body,$code){
		$sess_data = $this->log_code->get_session_value($code,true);
		if($sess_data['session'] == 'true') {
			$uid = $sess_data['user_details'][0]->i_uid;
			$oid = $sess_data['user_details'][0]->i_owner;
			$gid = $sess_data['gid'];

			$mail = new phpmail(true);
			try {
				$mail->SMTPDebug = 2;
			    $mail->isSMTP();
			    $mail->Host = 'mail.evomata.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'noreply@evomata.com';
			    $mail->Password = 'ASD789456';
			    $mail->SMTPSecure = 'tls';
			    $mail->Port = '587';
			    $mail->setFrom('noreply@evomata.com');
			    $mail->addAddress($to);
			    $mail->isHTML(true);
			    $mail->Subject = $sub;
			    $mail->Body = $body;
				if ($mail->send()) {
					$temp = 'true';
				}else{
					$temp = 'false';
				}	
			} catch (Exception $e) {
				$temp = 'true';
			}
			return $temp;
		}else{
			redirect(base_url().'account/login');
		}
	}

	public function daifunc_reg_mail($sub,$to,$attach,$body){
		$mail = new phpmail(true);
		try {
			$mail->SMTPDebug = 2;
		    $mail->isSMTP();
		    $mail->Host = 'mail.evomata.com';
		    $mail->SMTPAuth = true;
		    $mail->Username = 'noreply@evomata.com';
		    $mail->Password = 'ASD789456';
		    $mail->SMTPSecure = 'tls';
		    $mail->Port = '587';
		    $mail->setFrom('noreply@evomata.com');
		    $mail->addAddress($to);
		    $mail->isHTML(true);
		    $mail->Subject = $sub;
		    $mail->Body = $body;
			if ($mail->send()) {
				$temp = 'true';
			}else{
				$temp = 'false';
			}	
		} catch (Exception $e) {
			$temp = 'true';
		}
		return $temp;
	}

	public function broadcast_mail($sub,$to,$body,$oid){
		$query = $this->db->query("SELECT * FROM i_u_mail WHERE iumail_uid='$oid'");
		$result = $query->result();
		if (count($result) > 0 ) {
			$mail = new phpmail(true);
			try {
				$mail->SMTPDebug = 2;
			    $mail->isSMTP();
			    // $mail->Host = $result[0]->iumail_domain;
			    // $mail->SMTPAuth = true;
			    // $mail->Username = $result[0]->iumail_mail;
			    // $mail->Password = $result[0]->iumail_password;
			    // $mail->SMTPSecure = 'tls';
			    // $mail->Port = $result[0]->iumail_port;
			    // $mail->setFrom($result[0]->iumail_mail);
			    $mail->Host = 'mail.evomata.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'noreply@evomata.com';
			    $mail->Password = 'ASD789456';
			    $mail->SMTPSecure = 'tls';
			    $mail->Port = '587';
			    $mail->setFrom('noreply@evomata.com');
			    $mail->addAddress($to);
			    $mail->isHTML(true);
			    $mail->Subject = $sub;
			    $mail->Body    = $body;
				$mail->send();
			}catch(Exception $e) {
				return 'false';
			}
			return 'true';	
		}else{
			return 'false';
		}
	}

	public function mobile_app_send_mail($sub,$to,$attach,$body){
		$mail = new phpmail(true);
		try {
			$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();
		    $mail->Host = 'mail.evomata.com';
		    $mail->SMTPAuth = true;
		    $mail->Username = 'noreply@evomata.com';
		    $mail->Password = 'ASD789456';
		    $mail->SMTPSecure = 'tls';
		    $mail->Port = '587';
		    $mail->setFrom('noreply@evomata.com');
		    $mail->addAddress($to);
		    if ($attach != null) {
		    	$mail->addAttachment($attach);	
		    }
		    $mail->isHTML(true);                                // Set email format to HTML
		    $mail->Subject = $sub;
		    $mail->Body    = $body;
			$mail->send();
		}catch(Exception $e) {
			return 'false';
		}
	}
}
?>