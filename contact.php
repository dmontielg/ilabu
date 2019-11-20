<?php

  session_start();

  //PHPMailer starts here
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
                    
  // Load Composer's autoloader
  require 'vendor/autoload.php';            
  include_once 'library/Mail_conf.php';            
  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);
  $mail_conf = new Mail_conf();
  $message_show = NULL;
  
if(isset($_POST["submit"]))
{
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        
        $flag = true;
        if(strlen($name) > 0 & strlen($email) >0 & strlen($subject) > 0 & strlen($message) > 0)
        {
              if(strlen($name) < 1)
              {
                $message_show .= "<p>Please write a name in text field above</p>";
                $flag = false;
              }
              if(!filter_var($email, FILTER_VALIDATE_EMAIL))
              {
                $message_show .= "<p>Your e-mail is not correct, please insert a valid e-mail</p>";
                $flag = false;
              }
              elseif(strlen($subject) < 6)
              {
                $message_show .= "<p>Subject too short please add an informative description</p>";
                $flag = false;
              }
              elseif(strlen($message) < 1)
              {
                $message_show .= "<p>Please write something in the text box above</p>";
                $flag = false;
              }
        }
        else
        {
                $message_show .= "<p>Please, do not leave any empty field</p>";
                $flag = false;
        }

        if($flag !== false)
        {                                  
                    try
                    {                                            
                      
                        $mail->SMTPDebug = $mail_conf->getSMTPDebug();                 // Enable verbose debug output                        
                        $mail->isSMTP();                                            // Set mailer to use SMTP                                                                        
                        $mail->Host       = $mail_conf->getHost();  // Specify main and backup SMTP servers                                                
                        $mail->SMTPAuth   = $mail_conf->getSMTPAuth();                                   // Enable SMTP authentication                        
                        $mail->Username   = $mail_conf->getUsername();                     // SMTP username
                        $mail->Password   = $mail_conf->getPassword();                               // SMTP password                        
                        $mail->SMTPSecure = $mail_conf->getSMTPSecure();                                  // Enable TLS encryption, `ssl` also accepted
                        $mail->Port       = $mail_conf->getPort();                                    // TCP port to connect to                        
                        //Recipients                        
                        $mail->setFrom($mail_conf->getEmail(), $mail_conf->getName());                            
                        $mail->addAddress($email, $name);               // Name is optional                                                
                        $mail->addBCC($mail_conf->getEmail(), $mail_conf->getName());               // Name is optional                        
                        #$mail->ClearReplyTos();                                                
                        $mail->addReplyTo($mail_conf->getEmail(), $mail_conf->getName());

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        #$mail->Subject = 'Here is the subject';
                        $mail->Subject = $subject;
                        #$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                        $mail_message = "<h1> ILabU: Speed date a Scientist </h1>";                        
                        $mail_message .= "<h3>This Message was sent from the Contact info </h3>";
                        $mail_message .= "<h3>Your message below: </h3>";
                        $mail_message .= "<br/>";
                        $mail_message .= '<p>Name: '.$name.'</p>';            
                        $mail_message .= '<p>E-mail: '.$email.'</p>';            
                        $mail_message .= '<p>Message: '.$message.'</p>';            
                        $mail->Body   = $mail_message;

                        #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        #$message_show = '<h1>Message has been sent</h1>';
                        header('location:thankyou.php?flag=TRUE');
                        #echo $message;
                    } 
                    catch (Exception $e)
                    {
                        #echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";            
                        $message_show = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";          
                        $flag = false;
                    }        
                            
        }
        if($flag == false)
        {
            $message_show = "<div class='alert alert-danger' role='alert'>".$message_show."</div>";
        }else
        {
            $message_show = "<div class='alert alert-success' role='alert'>".$message_show."</div>";
        }
        
}


?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("library/Component.php"); $component = new Component(); ?>
<?php $component->getHead(); ?>
<body>
<?php $component->getTopBar(); ?>
<?php $component->getHeader(basename($_SERVER['PHP_SELF'])); ?>

<!-- Content Starts here -->
<section class="post-wrapper-top">
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <li>Contact</li>
        </ul>
        <h2>CONTACT</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->

  <section class="section1">
    <div class="container clearfix">
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">

        <div class="col-lg-6 col-md-6 col-sm-6">
          <h4 class="title">Contact us</h4>
          <p>Do you have a burning question or a suggestion for us?</p>
          <p>Please use this form to let us know. We will get back to you as soon as we can.</p>
          <p>You can also contact us via our social media: <a href="#">Instagram</a>, <a href="#">LinkedIn</a>, <a href="#">Facebook</a>.</p>                    
          <!-- contact_details -->
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6">
          <h4 class="title">Any comments or suggestions? Drop it below! </h4>
          <div id="message"></div>
          <!-- <form class="contact-form php-mail-form" role="form" action="contact.php" method="POST"> -->
          <form role="form" action="" method="POST">
            <div class="form-group">
              <input type="name" name="name" class="form-control" id="contact-name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" >
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control" id="contact-email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email">
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <input type="text" name="subject" class="form-control" id="contact-subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject">
              <div class="validate"></div>
            </div>

            <div class="form-group">
              <textarea class="form-control" name="message" id="contact-message" placeholder="Your Message" rows="5" data-rule="required" data-msg="Please write something for us"></textarea>
              <div class="validate"></div>
            </div>            
            <button name="submit" type="submit" class="btn btn-large btn-primary">Send Message</button>                        
          </form>
          <h5><?php echo $message_show ; ?> </h5>
        </div>

        
        <div class="clearfix"></div>
        <div class="divider"></div>
      </div>
      <!-- end content -->
    </div>
    <!-- end container -->
  </section>
  <!-- end section -->
<!-- Content Ends hhere -->
<?php $component->getFooter(); ?>
<?php $component->getJavascriptLibraries(); ?>
<div class="dmtop">Scroll to Top</div>
</body>
</html>
