<?php
	require 'include/mailer/PHPMailer.php';
	require 'include/mailer/SMTP.php';
	require 'include/mailer/Exception.php';
	use PHPMailer\PHPMailer\PHPMailer;
	
	$mail             = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug  = 0;							// enables SMTP debug information (for testing)
													// 1 = errors and messages
													// 2 = messages only
	$mail->Timeout	  =	30;							// set the timeout (seconds)
	$mail->CharSet    = 'UTF-8';					// for special chars
	$mail->SMTPAuth   = $SMTPAuth;					// enable SMTP authentication
	$mail->SMTPSecure = $SMTPSecure;				// sets the prefix to the servier
	$mail->Host       = $EmailHost;					// sets GMAIL as the SMTP server
	$mail->Port       = $emailPort;					// set the SMTP port for the GMAIL server
	$mail->Username   = $email_username;			// GMAIL username
	$mail->Password   = $email_password;			// GMAIL password
	
	$mail->SetFrom($email_username, $site_title);
	$mail->AddReplyTo($email_username, $site_title);

	$mail->Subject    = $subject;

	$mail->AltBody    = $alt_message;

	$mail->MsgHTML($html_mail);

	$mail->AddAddress($sendEmail, $sendName);

	if(!$mail->Send()) {
		print '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
			
			</button>Please contact an administrator!</br>'.$mail->ErrorInfo.'</div>';
	}
