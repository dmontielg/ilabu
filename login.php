<?php             
session_start();

include_once 'library/User.php';     
include_once 'library/Response.php';     

$user = new User() ;
$response = new Response() ;
$message = NULL;
if(isset($_POST['submit']))
{
        $email = $user->escape_string($_POST["email"]);
        $password = $user->escape_string($_POST["password"]);
        $password = md5($password);
        $_POST["password"] = $password;
        $resultSet = $user->getAllByEmailPass($_POST) ;                
        $row_cnt = 0;                        
        foreach ($resultSet as $query): $row_cnt += 1;  endforeach;                        
        if($row_cnt > 0)
        {
              foreach ($resultSet as $query): 
                    $id_user    = $query["id_user"];
                    $email      = $query["email"];
                    $verified   = $query["verified"];
                    $vkey       = $query["vkey"];
                    $createdate = $query["createdate"];                            
                    $createdate = strtotime($createdate);
                    $createdate = date('d M Y', $createdate);
              endforeach;                                                                                                    
              if($verified > 0 && $verified <3)
              {                    
                    $_SESSION['email'] = $id_user ;                    
                    $user_response = $response->getAllByIdUser($id_user);                                            
                    if(count($user_response) > 0)
                    {
                      #if($id_role == '1'){ header("location:1/"); }else{ header("location:2/");}
                      header("location:session.php");
                    }else{
                      header("location:events.php");
                    }
              }              
              elseif($verified == 0)
              {                  
                  $message = "<div class='alert alert-danger' role='alert'>This account has not yet been verified, 
                  please check your mailbox a mail was sent on ".$createdate."</div>";
              }          
              elseif($verified == 3)
              {
                  $_SESSION['password'] = "70722907b0a74be3734459f9ecc1940b";
                  $_SESSION['email'] = $email;                  
                  $_SESSION['verified'] = $verified;                  

                  header("location:admin/");
              }
        }
        else
        {                    
                  $message = "<div class='alert alert-danger' role='alert'>Invalid account</div>";
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
          <li>Login</li>
        </ul>
        <h2>LOGIN</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->
  <section class="section1">
    <div class="container clearfix">
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <h4 class="title">
                    	<span>Welcome Back!</span>
                    </h4>
            <p>We are happy to see you here again! Feel free to check your event profile or if you wish, change your registration
            by sending us an email at <a href="mailto:ilabu@erasmusmc.nl">ilabu@erasmusmc.nl.</a></p>
            <p >Still not registered? You can register <a href="register.php">here.</a></p>    
            <p >Do you have any question for us? You can contact us <a href="contact.php">here.</a></p>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <h4 class="title">
                    	<span>Login Form</span>
                    </h4>
          <form id="loginform" method="post" name="loginform" action="">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="e-mail" name="email">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="password" name="password">
              </div>
            </div>
            <div class="form-group">
              <button type="submit" name="submit" class="button">Sign in</button>
            </div>
            <?php 
                echo $message;
            ?>
          </form>
          <b><a href="forgot.php">Forgot password?</a></b>
        </div>
        <!-- end login -->
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