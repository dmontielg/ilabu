<?php
session_start();
//PHPMailer starts here
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                  
// Load Composer's autoloader
require 'vendor/autoload.php';            
include_once 'library/User.php';              
include_once 'library/ResetPassword.php';              
include_once 'library/Mail_conf.php';            


function random_str(
  int $length = 64,
  string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
  if ($length < 1) {
      throw new \RangeException("Length must be a positive integer");
  }
  $pieces = [];
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) {
      $pieces []= $keyspace[random_int(0, $max)];
  }
  return implode('', $pieces);
}
#echo random_str();
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail_conf = new Mail_conf();
$user = new User() ;
$reset_password = new ResetPassword() ;
$error = NULL;

if(isset($_POST["submit"]))
{            
      
      $email = $_POST["email"];
      $email2 = $_POST["email2"];      
      
      $flag = true;
      
      if($_POST["captcha_code"] != $_SESSION["captcha_code"])
      {
        $error = 'Sorry, fill the captcha input correctly to proceed';
        $flag = false;   
      }
      else
      {
              if(strlen($email) == 0 || strlen($email2) == 0)
              {
                  $error = 'Please do not leave any empty input field';
                  $flag = false;      
              }
              if($email !== $email2)
              {
                  $error = 'Sorry, these email accounts do not match';
                  $flag = false;      
              }
              else
              {                
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                          $error .= "Your e-mail is not correct, please insert a valid e-mail";
                          $flag = false;
                        }                        
                        if($flag !== false)
                        {                                                                                                                                   
                                        #$a = random_str(32);
                                        #$b = random_str(8, 'abcdefghijklmnopqrstuvwxyz');
                                        #$c = random_str();                                        
                                        #$token = random_str(32);  
                                        #echo $token;    
                                        
                                        $selector = bin2hex(random_bytes(8));
                                        $token = random_bytes(32);
                                        $seconds = 300;
                                        $expires = date("U")+$seconds; #1800 number of seconds e.g. 300s: 5 min                                                                              
                                        
                                        $hashedToken = password_hash($token, PASSWORD_DEFAULT);                                                                                

                                        $_POST['selector'] = $selector;
                                        $_POST['token'] = $hashedToken;                                                                                
                                        $_POST['expires'] = $expires;                                                                                
                                        
                                        $reset_password->deleteByEmail($_POST['email']);                                                
                                        $id_insert = $reset_password->insert($_POST);
                                                                                                                            
                                            if( $id_insert > 0)
                                            {   
                                                //Send email
                                                $to = $email;
                                                
                                                $message = "<h1>ILabU: Speed Date a Scientist</h1>";
                                                $message .= "<p>Please reset your password with the following link:</p>";                                                                  
                                                $message .= "<p><a href='";
                                                $message .= $mail_conf->getURLResetPassword();
                                                $message .= "selector=" . $selector . "&validator=". bin2hex($token) ."";
                                                $message .= "'>Reset password</a></p>";                                                                                                                                        
                                                $message .= "<p>Regards from the ILabU Team :)</p>";
                                                                                                
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
                                                    $mail->setFrom($email, $name);                            
                                                    $mail->addAddress($email, $name);               // Name is optional                                                                                                    
                                                    #$mail->ClearReplyTos();                                                
                                                    $mail->addReplyTo($mail_conf->getEmail(), 'Information');
                                                   
                                                    // Content
                                                    $mail->isHTML(true);                                  // Set email format to HTML
                                                    $mail->Subject = 'ILabU: Reset Password';
                                                    $mail->Body    = $message;
                                                    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                                                    $mail->send();
                                                    #echo 'Message has been sent';
                                                    #header('location:thankyou.php?flag=TRUE');

                                                    $error = "A password request has been sent to yout e-mail!";                    
                                                    

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
        
        <h2>Forgot password?</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->

  <section class="section1">
    <div class="container clearfix">
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
        
   

        <div class="col-lg-4 col-md-4 col-sm-12">          
        </div>     
        <!-- end login -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <h4 class="title">
                    	<span>Reset password via email</span>
                    </h4>
                    <p>An e-mail will be send to you with instructions on how to reset your password  </p>
          <!--<form id="registerform" method="post" name="registerform" action=""> -->
          <form id="registerform" name="registerform" method="post" action="" >
          <!-- onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }" -->
            
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email" name="email" require>
            </div>            
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Confirm Email" name="email2" require>
            </div>            
            <center>
            <div class="form-group">                                            
              <img src="<?php echo 'captcha/simple_captcha.php'; ?>" />            
                <input type="input" class="form-control" name="captcha_code" value="" placeholder="######" style="width:50%" /> 
            </div>
              
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Send" name="submit">
            </div>
            
            </center>

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