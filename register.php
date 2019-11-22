<?php
session_start();
//PHPMailer starts here
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                  
// Load Composer's autoloader
require 'vendor/autoload.php';            
include_once 'library/User.php';              
include_once 'library/Mail_conf.php';            

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail_conf = new Mail_conf();
$user = new User() ;
$error = NULL;

if(isset($_POST["submit"]))
{    
      $email = $_POST["email"];
      $pass = $_POST["password"];
      $pass2 = $_POST["password2"];
      
      $flag = true;

      if(empty($_POST['checkbox']) || $_POST['checkbox'] != 'check')
      {
          $error = 'Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy';
          $flag = false;                
      }
      else if($_POST["captcha_code"] != $_SESSION["captcha_code"])
      {
        $error = 'Sorry, fill the captcha input correctly to proceed';
        $flag = false;   
      }
      else
      {
              if(strlen($email) == 0 || strlen($pass) == 0 || strlen($pass2) == 0)
              {
                  $error = 'Please do not leave any empty input field';
                  $flag = false;      
              }
              else
              {                
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                          $error .= "Your e-mail is not correct, please insert a valid e-mail";
                          $flag = false;
                        }
                        elseif(strlen($pass) < 6)
                        {
                          $error .= "Password too short, please include at least 6 characters";
                          $flag = false;
                        }
                        elseif($pass != $pass2)
                        {
                          $error .= "Your passwords do not match";
                          $flag = false;
                        }
                        if($flag !== false)
                        {                                          
                                if($user->loadIdByEmail($email) == 0)
                                {                                                                                
                                            $_POST['email'] = $email;                                                                                                                                    
                                            $_POST['vkey'] = md5(time().$email);
                                            $_POST['password'] = md5($user->escape_string($pass));                                        
                                            $vkey = $_POST['vkey'];
                                            $id_insert = $user->insert($_POST) ;                    
                                            print($id_insert);
                                            if( $id_insert > 0)
                                            {   
                                                //Send email
                                                $to = $email;
                                                $message = "<h1>I Lab U: Speed Date a Scientist</h1>";
                                                $message .= "<p>Please confirm your account by clicking the following link:</p>";                                                                  
                                                $message .= "<p><a href='";
                                                $message .= $mail_conf->getURLRegister();
                                                $message .= $vkey."'>Register Account</a></p>";                                                                                                
                                                #$message .= "<p><a href='http://10.96.25.183/ilabu/verify.php?vkey=$vkey'>Register Account</a></p>";                                                
                                                $message .= "<p>Thank you for taking part in the I Lab U initiative! Visit our website to join one of our events.</p>
                                                            <p>The I Lab U Team :)</p>";
                                                $headers = "From: ilabu@erasmusmc.nl";
                                                              
                                                try{                                                    
                                                    $mail->SMTPDebug = $mail_conf->getSMTPDebug();                 // Enable verbose debug output                        
                                                    $mail->isSMTP();                                            // Set mailer to use SMTP                                                                        
                                                    $mail->Host       = $mail_conf->getHost();  // Specify main and backup SMTP servers                                                
                                                    $mail->SMTPAuth   = $mail_conf->getSMTPAuth();                                   // Enable SMTP authentication                        
                                                    $mail->Username   = $mail_conf->getUsername();                     // SMTP username
                                                    $mail->Password   = $mail_conf->getPassword();                               // SMTP password                        
                                                    $mail->SMTPSecure = $mail_conf->getSMTPSecure();                                  // Enable TLS encryption, `ssl` also accepted
                                                    $mail->Port       = $mail_conf->getPort();                                    // TCP port to connect to                        
                                                    //Recipients                        
                                                    #$mail->setFrom($email, $name);                            
                                                    $mail->setFrom($mail_conf->getEmail(), $mail_conf->getName());                                                                                
                                                    $mail->addAddress($email, $name);               // Name is optional                                                
                                                    #$mail->addBCC($mail_conf->getEmail(), $mail_conf->getName());               // Name is optional                        
                                                    #$mail->ClearReplyTos();                                                
                                                    $mail->addReplyTo($mail_conf->getEmail(), $mail_conf->getName());
                                          
                                                    // Content
                                                    $mail->isHTML(true);                                  // Set email format to HTML
                                                    $mail->Subject = 'I Lab U Account verification';
                                                    $mail->Body    = $message;
                                                    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                                                    $mail->send();
                                                    #echo 'Message has been sent';
                                                    #header('location:thankyou.php?flag=TRUE');
                                                    $error ="<h4>Thank you for registering in our I Lab U platform!</h4>
                                                    
                                                    </b><br/><h4>Please check your e-mail to verify your account.</h4>";

                                                } catch (Exception $e) {
                                                    $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                    $flag = false;
                                                }                  
                                            }              
                                            else
                                            {
                                                $error = "Something went wrong, please try again or contact us by email";
                                                $flag = false;
                                            }                                             
                                }
                                else
                                {
                                  $error .= "Sorry, but this e-mail is already registered";
                                  $flag = false;
                                }
                          }  
                  }      
        }        
        if($flag == false){
              $error = "<div class='alert alert-danger' role='alert'>".$error."</div>";
        }else{
          $error = "<div class='alert alert-success' role='alert'>".$error."</div>";
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
          <li><a href="index.html">Home</a></li>
          <li>Register</li>
        </ul>
        <h2>REGISTER</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->

  <section class="section1">
    <div class="container clearfix">
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
      
      
        
      <!-- Old stuff for div 4 columns -->
        <!--<div class="col-lg-4 col-md-4 col-sm-12">-->
        <div class="col-lg-6 col-md-6 col-sm-12">

          <h4 class="title">
                    	<span>Join Us!</span>
                    </h4>                          
          <p>We are happy that you want to be part of I Lab U!</p>
          <p>How does it work? You fill in this quick registration and then you can choose your favourite event either as scientist or public. </p>
          <p>We ask you to fill in a few questions, so we know a little more about you and your views in science. As simple as that!</p>          
          <p>If you have a question for us let us know <a href="contact.php">here</a>.</p>
          </div>     
        <!--
        <div class="col-lg-4 col-md-4 col-sm-12">
          <h4 class="title"><span>Terms and conditions</span></h4>          
                    <p>
                      
                    </p>          
        </div>     
        -->

        <!-- end login -->
        
        <div class="col-lg-6 col-md-6 col-sm-12">
          <h4 class="title">
                    	<span>Register Form</span>
                    </h4>
          <!--<form id="registerform" method="post" name="registerform" action=""> -->
          <form id="registerform" name="registerform" method="post" action="" >
          <!-- onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }" -->
            
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email" name="email" require>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" name="password" require>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Re-enter password" name="password2" require>
            </div>
            <div class="form-group">
            <input type="checkbox" name="checkbox" value="check" id="agree" /> 
            By checking this box, you agree to our <a href="terms-conditions.php" target="_blank">Privacy Policy </a>
            </div>

            <div class="form-group">
            
            <img src="<?php echo 'captcha/simple_captcha.php'; ?>" />
            <input type="input" name="captcha_code" value="" /> 
            </div>

            <div class="form-group">
              <input type="submit" class="button" value="Register an account" name="submit">
            </div>
            

          </form>                        
                  <h5><?php echo $error; ?> </h5>                              
        </div>
        <!-- end register -->
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