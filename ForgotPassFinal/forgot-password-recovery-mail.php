<?php


if(!class_exists('PHPMailer')) {
   // require('phpmailer/PHPMailer.php');
	//require('phpmailer/class.smtp.php');
	require 'F:\xampp\htdocs\ForgotPassFinal\class.smtp.php';
	require 'F:\xampp\htdocs\ForgotPassFinal\class.phpmailer.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\class.smtp.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\class.phpmailer.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\PHPMailer\src\PHPMailer.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\PHPMailer\src\Exception.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\PHPMailer\src\OAuth.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\PHPMailer\src\POP3.php';
	//require 'D:\xampp\htdocs\ForgotPass\ForgotPass\PHPMailer\src\SMTP.php';
}
 error_reporting(E_ALL);
    ini_set('display_errors', '1');
require_once("mail_configuration.php");

$mail = new PHPMailer();

$emailBody = "<div>" . $user["member_name"] . ",<br><br><p>Click this link to recover your password<br><a href='" . PROJECT_HOME . "php-forgot-password-recover-code/reset_password.php?name=" . $user["member_name"] . "'>" . PROJECT_HOME . "php-forgot-password-recover-code/reset_password.php?name=" . $user["member_name"] . "</a><br><br></p>Regards,<br> Admin.</div>";

$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port     = 587;  
$mail->Username = "samiksha.gupta@somaiya.edu";
$mail->Password = "Samiksh0599";
//$mail->Host     = "localhost";
$mail->Host = 'smtp.gmail.com';
$mail->Mailer   = "smtp";

$mail->SetFrom('samiksha.gupta@somaiya.edu', 'Samiksha');
$mail->AddReplyTo('samiksha.gupta@somaiya.edu', 'Admin');
$mail->ReturnPath=SENDER_EMAIL;	
$mail->AddAddress($user["member_email"]);
//$mail->AddAddress("het.joshi@somaiya.edu");
$mail->Subject = "Forgot Password Recovery";		
$mail->MsgHTML($emailBody);
$mail->IsHTML(true);
 $mail->Subject = 'Your Password';
        $mail->Body    = "Your Password is :";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
          
        } else {
            echo 'Message has been sent';
        }
		
if(!$mail->Send()) {
	$error_message = 'Problem in Sending Password Recovery Email';
} else {
	$success_message = 'Please check your email to reset password!';
} 




?>





