<?php
require_once('PHPMailer-master/PHPMailerAutoload.php');

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'sarath300697@gmail.com';                 // SMTP username
$mail->Password = 'appleboy1';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('sarath300697@gmail.com', 'Mailer');
$mail->addAddress('domicile892@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('saraths674@gmail');               // Name is optional

$mail->addCC('sarath300697@gmail.com');
$mail->addBCC('sarath300697@gmail');
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'hai this is the message form steve';
$mail->Body    = 'your account wa verified please login <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>