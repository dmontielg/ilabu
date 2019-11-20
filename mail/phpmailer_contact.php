<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if(isset($_POST["submit"]))
{
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        try {
            //Server settings
            $mail->SMTPDebug = 1;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            #$mail->Host      = 'smtp.sendgrid.net/';  // Specify main and backup SMTP servers
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'diegoomontiel@gmail.com';                     // SMTP username
            $mail->Password   = 'FIRSTflight12';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            #$mail->setFrom('from@example.com', 'IlabU');    
            $mail->setFrom($email, $name);    
            $mail->addAddress('diegoomontiel@gmail.com');               // Name is optional
            #$mail->addAddress('ilabu@erasmusmc.nl');               // Name is optional
            #$mail->addAddress('d.montielgonzalez@erasmusmc.nl');               // Name is optional
            $mail->addReplyTo('ilabu@erasmusmc.nl', 'Information');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            #$mail->Subject = 'Here is the subject';
            $mail->Subject = $subject;
            #$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail_message = "<h1> ILabU: Speed date a Scientist </h1>";
            $mail_message .= "<h3>This Message was sent from the Contact info </h3>";
            $mail_message .= '<p>Name: '.$name.'</p>';            
            $mail_message .= '<p>E-mail: '.$email.'</p>';            
            $mail_message .= '<p>Message: '.$message.'</p>';            
            $mail->Body   = $mail_message;

            #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $message = '<h1>Message has been sent</h1>';
            echo $message;
        } 
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";            
        }

    }
}

?>