<?php

$message = NULL;

if(isset($_GET["vkey"]))
{
    include_once 'library/User.php';              
    $user = new User() ;
    $vkey = $user->escape_string($_GET["vkey"]);
    $resultSet = $user->loadByVkeyNotVerify($vkey) ;      

    if( $resultSet > 0)
    {                           
            $verify = $user->updateVerifyAccount($vkey);
            if($verify){              
              $message = '
              <h3>Thank you for registering in <b> I Lab U </b></h3>
              <h4>Your account is now verified!</h4>
              <p>          
              <h5>Now, please <a href="login.php">login</a> and join one of our events! Registration is mandatory so that we know you are coming! </h5>
              </p>                      
                  <div class="item">
                        <img src="img/success-icon.jpg" alt="" height="80" width="80">                        
                  </div>  ';          
            }else{              
              $message = '
              <h3>We are sorry, something went wrong :( <b> ILabU </b></h3>
              <h4>Your account is not activated yet!</h4>
              <p>          
              <h5>Please try to open the link again from your mailbox, and 
              if you are still experiencing problems loggin in, please send us a <a href="contact.php"> message! </h5>
              </p>                      
                  <div class="item">                        
                        <img src="img/icon_failure.png" alt="" height="80" width="80">
                  </div>  ';          
            }
    }    
    else
    {      
      $message = '
              <h3>Sorry, this account is invalid or already verified!</h3>              
              <p>          
              <h5>If you experience problems loggin in, please send us a <a href="contact.php"> message!</a> :)</h5>
              </p>                      
                  <div class="item">                        
                        <img src="img/question-icon.png" alt="" height="80" width="80">
                  </div>  ';          
    }
}else
{      
    header("location: index.php");  
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
    <center>          
          <section class="section1">
            <div class="container" >
                  <?php
                    echo $message ;
                  ?>
              </div>    
              <br/><br/><br/><br/>
            </section>            
    </center>
    
<!-- Content Ends hhere -->

  <?php $component->getFooter(); ?>
  <?php $component->getJavascriptLibraries(); ?>
  <div class="dmtop">Scroll to Top</div>
</body>
</html>
