<?php
                 
// Load Composer's autoloader

include_once 'library/User.php';              
include_once 'library/ResetPassword.php';              

$user = new User() ;
$reset_password = new ResetPassword() ;
$error = NULL;

$selector = $_GET['selector'];
$validator = $_GET['validator'];

$flag = NULL;

if(empty($selector) || empty($validator))
{ 
    $flag = false;
}
else
{
    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false)
    {
        $flag = true;
        
    }else
    {
        $flag = false;
    }
}

if(!$flag)
{
   header("location:index.php");
}

if(isset($_POST['submit']))
{
    $flag = NULL;

    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(empty($password) || empty($password2))
    {
        $error = 'Please, fill both password fields';
        $flag = false;     
    }
    elseif(strlen($password) == 0 || strlen($password2) == 0)
    {
        $error = 'Please, type at least 6 characters as new password';
        $flag = false;      
    }
    elseif($password !== $password2)
    {
        $error = "Sorry, passwords do not match!";
        $flag = false;     
    }else
    {    
            $currentDate = date("U");
            $query = $reset_password->getAllBySelectorExpires($selector, $currentDate);            
            if(sizeof($query) > 0)
            {
                $token = $query[0]["token"];        
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $token);

                if($tokenCheck === false){
                    $error = "Sorry, you need to re-submit your password request! ";
                    $flag = false;
                }
                elseif($tokenCheck === true)
                {            
                    $email = $query[0]["email"];
                    $findEmail = $user->getAllByEmail($email);             
                    if(sizeof($findEmail) > 0)
                    {                    
                        $password = md5($user->escape_string($password));                            
                        if($user->updatePassword($password, $email))
                        {                                                                       
                                echo "<script>
                                        alert('Success! Password reset!');
                                        window.location.href='login.php';
                                        </script>";
                        }
                    }
                    else
                    {
                        $error = "Sorry, you need to re-submit your password request! ";
                        $flag = false;
                    }                    
                }                                
            }
            else
            {
                $error = "Sorry, session has expired!, you need to re-submit your password request! ";
                $flag = false;
            }
            
    }

    if(!$flag){
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
        
        <h2>Reset Password</h2>
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
                    	<span>You can now reset your new password!</span>
                    </h4>                    
          <!--<form id="registerform" method="post" name="registerform" action=""> -->
          <form id="registerform" name="registerform" method="post" action="" >
          <!-- onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }" -->
            
            <div class="form-group">
              <input type="password" class="form-control" placeholder="password" name="password" require>
            </div>            
            <div class="form-group">
              <input type="password" class="form-control" placeholder="confirm password" name="password2" require>
            </div>            
            <center>                          
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Confirm" name="submit">
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