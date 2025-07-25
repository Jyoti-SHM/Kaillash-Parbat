<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';

$mail = new PHPMailer(true);

try {

    //Recipients - main edits
    $mail->setFrom('sales@hotelkailashparbat.com', 'Message from Hotel  Kailash Parbat');             // Email Address and Name FROM
    $mail->addAddress('sales@hotelkailashparbat.com', 'Jhon Doe');                            // Email Address and Name TO - Name is optional
    $mail->addReplyTo('frontofficekp3@gmail.com', 'Message from Hotel  Kailash Parbat');       // Email Address and Name NOREPLY
    $mail->isHTML(true);                                                       
    $mail->Subject = 'Message from Hotel  Kailash Parbat';                                // Email Subject     

    // Email verification, do not edit
    function isEmail($email_newsletter ) {
        return(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email_newsletter ));
    }

    // Form fields
    $email_newsletter    = $_POST['email_newsletter'];

    if(trim($email_newsletter) == '') {
        echo '<div class="error_message">Please enter a valid email address.</div>';
        exit();
    }                        
            
    // Get the email's html content
    $email_html = file_get_contents('template-email.html');

    // Setup html content
    $e_content = "$email_newsletter would like to subscribe to the newsletter.";
    $body = str_replace(array('message'),array($e_content),$email_html);
    $mail->MsgHTML($body);

    $mail->CharSet = 'UTF-8'; //Force UTF for special characters

    $mail->send();

    // Confirmation/autoreplay email send to who fill the form
    $mail->ClearAddresses();
    $mail->addAddress($_POST['email_newsletter']); // Email address entered on form
    $mail->isHTML(true);
    $mail->Subject    = 'Thank you for join to Paradise Newsletter'; // Custom subject
    
    // Get the email's html content
    $email_html_confirm = file_get_contents('confirmation.html');

    // Setup html content, do not edit
    $body = str_replace(array('message'),array($e_content),$email_html_confirm);
    $mail->MsgHTML($body);

    $mail->CharSet = 'UTF-8'; //Force UTF for special characters

    $mail->Send();

    // Succes message
    echo '<div>
           Thank you, your subscription is submitted!!
        </div>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?> 