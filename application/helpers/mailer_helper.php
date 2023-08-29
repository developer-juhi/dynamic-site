<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('mailer'))
{   
   function send_mail($subject,$tomail,$frommail,$body,$altbody)
	{
		include 'PHPMailerAutoload.php';	
		$mail = new PHPMailer();
		
		$mail->SMTPDebug = 0;                              // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		// $mail->Username = 'dev2.macymind@gmail.com';                 // SMTP username
		// $mail->Password = 'macymind123';                           // SMTP password
		$mail->Username = 'kothwalajuhi5844@gmail.com';                 // SMTP username
		$mail->Password = 'kokoko';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->setFrom('kothwalajuhi5844@gmail.com','Advocate Ankit Raval');
		$mail->addBCC('kothwalajuhi5844@gmail.com');

		// $mail->addBCC('bv_multiproject@yahoo.co.in');
		// $mail->setFrom($frommail, '');
		//$mail->addAddress(''.$email, ' User'); 
		 $mail->AddAddress($tomail);
		//  $mail->AddAddress('bv_multiproject@yahoo.co.in');
		//  $mail->AddAddress('multiproject2005@gmail.com');
		 //$mail->addAddress('manish@macymind.com'); 
		// $mail->to($tomail);
		    // Add a recipient
		/*
		$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('info@example.com', 'Information');
		
		$mail->addBCC('bcc@example.com');

		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');
		*/    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AltBody = $altbody;
		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} else 	{
			//echo 'Message has been sent';
			return true;
		}
	}
 }
 ?>