

<?php

if(!class_exists('PHPMailer')) {
   // require('phpmailer/PHPMailer.php');
	//require('phpmailer/class.smtp.php');
	require 'F:\xampp\htdocs\ForgotPass\class.smtp.php';
	require 'F:\xampp\htdocs\ForgotPass\PHPMailer.php';
}
 error_reporting(E_ALL);
    ini_set('display_errors', '1');
require_once("mail_configuration.php");

$mail = new PHPMailer();

$emailBody = "<div>" . $user["member_name"] . ",<br><br><p>Click this link to recover your password<br><a href='" . PROJECT_HOME . "php-forgot-password-recover-code/reset_password.php?name=" . $user["member_name"] . "'>" . PROJECT_HOME . "php-forgot-password-recover-code/reset_password.php?name=" . $user["member_name"] . "</a><br><br></p>Regards,<br> Admin.</div>";

$mail->IsSMTP();
$mail->SMTPDebug = 2;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port     = 587;  
$mail->Username = "samiksha.gupta@somaiya.edu";
$mail->Password = "";
//$mail->Host     = "localhost";
$mail->Host = 'smtp.gmail.com';
$mail->Mailer   = "smtp";

$mail->SetFrom('samiksha.gupta@somaiya.edu', 'Samiksha');
$mail->AddReplyTo('samiksha.gupta@somaiya.edu', 'Admin');
$mail->ReturnPath=SENDER_EMAIL;	
$mail->AddAddress($user["member_email"]);
$mail->Subject = "Forgot Password Recovery";		
$mail->MsgHTML($emailBody);
$mail->IsHTML(true);
 $mail->Subject = 'Your Password';
        $mail->Body    = "Your Password is ";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
		
if(!$mail->Send()) {
	$error_message = 'Bye..Problem in Sending Password Recovery Email';
} else {
	$success_message = 'Please check your email to reset password!';
} 




?>


