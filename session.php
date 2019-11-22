<?php             
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once 'library/User.php';              
include_once 'library/UserEvent.php';              
include_once 'library/Role.php';      
include_once 'library/Mail_conf.php';            
require 'vendor/autoload.php';                            

## If there are not any session
if( !empty($_SESSION["email"]))
{        
    $user = new User()            ;
    $user_event = new UserEvent() ;
    $role = new Role()            ;
    $mail_conf = new Mail_conf()  ;    
    $mail = new PHPMailer(true);

    $error = NULL;
    $message = NULL;    
    $user_role = NULL;
    
    $id_user = $_SESSION["email"];
    $user->loadById($id_user);
    $eventResult = $user_event->getEventByIdUser($id_user);

    $id_role = $eventResult[0]["id_role"];
    $role->loadById($id_role);        
    if($role->getRole() == "scientist"){$user_role = "Scientist"; }else{ $user_role = "User";}

    $event = $eventResult[0]["event"];
    $session_number = $eventResult[0]["session_number"];
    $address = $eventResult[0]["address"];
    $time = $eventResult[0]["time"];
    $date = $eventResult[0]["date"];
    $code = $eventResult[0]["code"];
    $email_confirmation = $eventResult[0]["email_confirmation"];    
    $waiting_list = $eventResult[0]["waiting_list"];    

    if(empty($event))
    {
      $message .="
      <p>          
      Thanks for registering to ILabU! 
      You now can join to an event and session! Please choose the <a href='events.php'>event</a> you like the most!.
      </p>
      <p><h3>We are looking forward seeing you soon!</h3> </p>
      ";
    
    }
    else
    {
      $message .="      
      <p>          
      Thanks for participate in ILabU! You are already registered to an event and a session! Please see the info below.
      </p>
      <p>
      Event: ".$event."
      </p>
      <p>
      Session: ".$session_number."
      </p>
      <p>
      Address: ".$address."
      </p>
      <p>
      Time: ".$time."
      </p>
      <p>
      Date: ".$date."
      </p>
      <p><h3>We are looking forward seeing you soon!</h3> </p>
      ";
      
      if($waiting_list == 0) #if is not in the waiting list == 0
      {
          $message .= "
          <div class='content col-lg-12 col-md-12 col-sm-12 clearfix'>      
              <form role='form' action='' method='POST'>
                <div class='form-group'>
                  <input type='name' name='code' require class='form-control' id='contact-name' placeholder='ILabU-CODE' data-rule='minlen:5' data-msg='Please enter at least 5 chars' >
                  <div class='validate'>
                  </div>
                </div>            
                <button name='submit' type='submit' class='btn btn-large btn-primary'>Send Code</button>                        
              </form>
              <p><small>In case you have any question or want to change the event you are register please send us an email to ilabu@erasmusmc.nl </small></p>
          </div>      
          ";
      }
             
          if($email_confirmation == 0)
          {
                          try
                          {                              
                            $message_for_email ="<p>Event: ".$event."</p><p>Session: ".$session_number."</p><p>Address: ".$address."</p><p>Time: ".$time."</p><p>Date: ".$date."</p>
                            <p>
                            <small>If you want to log in to your I Lab U account, please follow this link: www.ilabu.erasmusmc.nl/login </small>
                            <small>In case you have any question or want to change the event you are register please send us an email to ilabu@erasmusmc.nl </small>
                            </p>
                            <h3>We are looking forward to meeting you in person!</h3>                    
                            </div>";

                                $mail->SMTPDebug = $mail_conf->getSMTPDebug();                 // Enable verbose debug output                        
                                $mail->isSMTP();                                            // Set mailer to use SMTP                                                                        
                                $mail->Host       = $mail_conf->getHost();  // Specify main and backup SMTP servers                                                
                                $mail->SMTPAuth   = $mail_conf->getSMTPAuth();                                   // Enable SMTP authentication                        
                                $mail->Username   = $mail_conf->getUsername();                     // SMTP username
                                $mail->Password   = $mail_conf->getPassword();                               // SMTP password                        
                                $mail->SMTPSecure = $mail_conf->getSMTPSecure();                                  // Enable TLS encryption, `ssl` also accepted
                                $mail->Port       = $mail_conf->getPort();                                    // TCP port to connect to                        
                                //Recipients                        
                                
                                #$mail->setFrom($user->getEmail());                                                            
                                $mail->setFrom($mail_conf->getEmail(), $mail_conf->getName());                            
                                $mail->addAddress($user->getEmail());               // Name is optional                                                
                                $mail->addBCC($mail_conf->getEmail(), $mail_conf->getName());               // Name is optional                        
                                #$mail->ClearReplyTos();                                                
                                $mail->addReplyTo($mail_conf->getEmail(), $mail_conf->getName());

                                // Content
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = 'Thank you for your registration to the I Lab U event!';                                                                
                                #$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                                $mail_message = "<h1> ILabU: Speed date a Scientist </h1>";                        
                                $mail_message .= "<h3>Thank you for your interest in our event and for filling in the registration. We will confirm your participation as soon as possible.</h3>";
                                $mail_message .= "<h3>Here is a summary of the event: </h3>";
                                $mail_message .= "<br/>";                           
                                $mail_message .= '<p>Message: '.$message_for_email.'</p>';    
                                $mail_message .= "<br/>";                           
                                $mail_message .= "<br/>";               
                                
                                $mail_message .= '<p><br/>The ILabU Team</p>';            
                                $mail->Body   = $mail_message;                        
                                $mail->send();                                   
                                $user_event->updateEmailConfirmationbyIdUser($id_user);
                      } 
                      catch (Exception $e)
                      {
                          #echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";            
                          $message_show = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";          
                          $flag = false;                  
                      }   
              
            }
               

    }
    if(isset($_POST['submit']))
    {      
      if($_POST["code"] == $code)      
      {       
       #$_SESSION["status"] = 1;
       $_SESSION["status"] = $user->getVerified();
       header("location:1/index.php?survey=Speed date");
      }
      else
      {
        $error .= "Sorry!, wrong code :( please, try again <br/>";                    
        $error = "<div class='alert alert-danger' role='alert'>".$error."</div>";       
      }
    }
    echo $error;
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("library/Component.php"); $component = new Component(); ?>
<?php $component->getHead(); ?>
<body>
<?php $component->getTopBar(); ?>
<?php $component->getHeader("session"); ?>

<!-- Content Starts here -->
  <section class="post-wrapper-top">
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
        <h2><?php echo $user_role; ?></h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->
  <section class="section1">
    <div class="container clearfix">

    <section class="section1">
    <div class="container" >
      <h1>The I Lab u Project</h1>
      <h4>Welcome <?php echo $user->getEmail(); ?></h4>

      <?php echo $message;?>
     
      <p>-Because everybody is looking for someone to lab.</p>
    </div>    
  </section>            
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
<?php
}else{ header("location:index.php"); }
?>