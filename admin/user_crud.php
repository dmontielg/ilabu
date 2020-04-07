<?php             
session_start();

        include_once '../library/Component_.php';         
        include_once '../library/User.php';                      
        $component = new Component_()     ;
        $user = new User()                ;
                        
if(isset($_GET["update"]))
{
    $user->loadById($_GET["update"]);

    if(isset($_POST["submit"]))
    {
        $user->updateAdmin($_POST);              
        $affected = $user->getAffectedRows();
        if($affected >= 1)
        {        
            echo "<script>
              alert('Success! form updated');
              window.location.href='user_crud.php?update=".$_GET['update']."';
              </script>";            
        }else{
          echo "<script>
          alert('No changes were maded!');
          window.location.href='user_crud.php?update=".$_GET['update']."';
          </script>";            
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<?php $component->getHead(); ?>
<body>
<?php $component->getTopBar(); ?>
<?php $component->getHeader($_SESSION["email"]); ?>

<!-- Content Starts here -->
  <section class="post-wrapper-top">  
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
        <h2><?php echo $_GET["survey"]; ?></h2>
      </div>    
      <div>              
        
          
                    <div class="col-lg-9 col-md-12 col-sm-12">
                          <div id="nav" class="right">
                            <div class="container clearfix">
                              <ul id="jetmenu_session" class="jetmenu_session blue">
                                    <li><a href="index.php">Users</a></li>
                                    <li><a href="question.php">Questionnaires</a></li>
                            </ul>
                            </div>
                        </div>
                    </div>
        

        
      </div>
    </div>    
  </section>  
  <!-- end post-wrapper-top -->
  <section class="section1">  
    <div class="container clearfix">           
    <section class="section1">    
    <div class="container" >    
            <center>
                    <h3><?php echo $_SESSION['email']; ?> </h3>            
                    <a href="index.php"><p>Back</p></a>
            </center>
    </div>    
  </section>
      
<center>
            <div class="container">
                <form method="post" name="search-submit" action="">                
                    <input type="hidden" name="id_user" value="<?php echo $_GET["update"]; ?>"> 
                    <label for="">Email:</label>
                    <input name="email" type="text" value="<?php echo $user->getEmail(); ?>">
                    <br>
                    <label for="">Verified:</label>
                    <input name="verified" type="text" value="<?php echo $user->getVerified(); ?>">
                    <br>
                    <label for="">Username:</label>
                    <input name="username" type="text" value="<?php echo $user->getUsername(); ?>">
                    <br>
                    <button name="submit" value="update">update</button>
                </form>
            </div>
</center>
      
      
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
}
else{
  header("location:index.php");
}

?>

