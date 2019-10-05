<?php
error_reporting(E_ALL);
include "connection.php";
require 'PHPMailer.php';
//require_once('PHPMailer_old.php');
require 'class.smtp.php';

//define('GUSER', 'meetfreelancerscwp@gmail.com'); // GMail username
//define('GPWD', 'oKuHzYwX'); // GMail password

/*function smtpmailer($to, $from, $from_name, $subject, $body) { 
 global $error;
 $mail = new PHPMailer();  // create a new object
 $mail->IsSMTP(); // enable SMTP
 $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
 $mail->SMTPAuth = true;  // authentication enabled
 $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
 $mail->Host = 'smtp.gmail.com';
 $mail->Port = 587; 
 $mail->Username = 'meetfreelancerscwp@gmail.com';  
 $mail->Password = 'oKuHzYwX';           
 //$mail->SetFrom($from, $from_name);
 $mail->From = $from;
 $mail->FromName = $from_name;
 $mail->Subject = $subject;
 $mail->Body = $body;
 $mail->AddAddress($to);
 $mail->isHTML(true);
 if(!$mail->Send()) {
 $error = 'Mail error: '.$mail->ErrorInfo; 
 return false;
 } else {
 $error = 'Message sent!';
 return true;
 }
}*/

//function smtpmailer($to, $from, $from_name, $subject, $body) {

$toemail = 'chanikya@design-master.com';
					
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
$mail->Username = "meetfreelancerscwp@gmail.com";                 
$mail->Password = "oKuHzYwX";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";                           
//Set TCP port to connect to 
$mail->Port = 587;                                   

$mail->From = 'notifications@meetfreelancers.com';
$mail->FromName = 'yourName';

$mail->addAddress($toemail, "Recepient Name");

$mail->isHTML(true);

$mail->Subject = 'test mail message';

$mail->Body = 'Hello World!';

//smtpmailer('chanikya@design-master.com', 'from@mail.com', 'yourName', 'test mail message', 'Hello World!');
//}


if ($mail->send()) {
 echo "sent";
} else {
	echo "not sent";
}
//if (!empty($error)) echo $error;


?>