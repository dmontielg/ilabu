<?php

if(isset($_GET["flag"]))
{
    if($_GET["flag"] == "TRUE")
    {            
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
              <h1>Thank you for your message!<b></b></h1>
              <h4>We have sent you an email to the address provided with your message</h4>
              <h4>We will get in touch with you as soon as possible!</h4>              
              <h4>The I Lab U Team :) </h4>
                  <div class="item">
                        <img src="img/mail.png" alt="" height="80" width="80">
                    </div>            
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
<?php
    }else{
      header("location:index.php");
    }
}else{
  header("location:index.php");
}


?>