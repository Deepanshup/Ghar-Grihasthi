<?php
require "PHPMailerAutoload.php";
$mail = new PHPMailer;
$mail->SMTPDebug = 0;     //give all detail while sending mail                         
$mail->isSMTP();                                      
$mail->Host = 'smtp.gmail.com';  // yhi likhna hai
$mail->SMTPAuth = true;                           
$mail->Username = 'lavinapvt@gmail.com';         // SMTP username
$mail->Password = 'lavina@1234';           // SMTP password
$mail->SMTPSecure = 'tls';                           
$mail->Port = 587;                                    
$mail->setFrom('lavinapvt@gmail.com','By lavina');
$mail->addAddress('avl.gauravpatidar@gmail.com');     // Add a recipient
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'By OfficeToolByDeepanshu';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if(!$mail->send()) {
    echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}