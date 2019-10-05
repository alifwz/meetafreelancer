<?php
include "connection.php";
require 'PHPMailer.php';
require 'class.smtp.php';

function smtpmailer($to, $toname, $from, $from_name, $subject, $body) {

$toemail = $to;					
$mail = new PHPMailer;
//Enable SMTP debugging. 
$mail->SMTPDebug = 2;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "Meetfreelancerscom@gmail.com";                 
$mail->Password = "Fezokhairan265";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";                           
//Set TCP port to connect to 
$mail->Port = 587;                                   

$mail->From = 'notifications@meetfreelancers.com';
$mail->FromName = 'Meetfreelancers';
$mail->addAddress($toemail, $toname);
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $body;

//smtpmailer('chanikya@design-master.com', 'from@mail.com', 'yourName', 'test mail message', 'Hello World!');

	if ($mail->send()) {
	 //echo "sent";
	} else {
		//echo "not sent";
	}
}

//smtpmailer('chanikya@design-master.com', 'Chani','from@mail.com', 'yourName', 'test mail message', 'Hello World!');
?>