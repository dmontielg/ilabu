<?php             
session_start();

        include_once '../library/Component_.php';         
        
        include_once '../library/Question.php';                      
        include_once '../library/Survey.php';                      
        include_once '../library/Role.php';                      
        $component = new Component_()     ;
        $question = new Question()                ;
        $survey = new Survey()                ;
        $role = new Role()                ;
                        
if(isset($_GET["update"]))
{
    $question->loadById($_GET["update"]);

    if(isset($_POST["submit"]))
    {        
        $question->updateAdmin($_POST);              
        $affected = $question->getAffectedRows();
        if($affected >= 1)
        {        
            echo "<script>
              alert('Success! form updated');
              window.location.href='question_crud.php?update=".$_GET['update']."';
              </script>";            
        }
        else
        {
          echo "<script>
          alert('No changes were maded!');
          window.location.href='question_crud.php?update=".$_GET['update']."';
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
                    <a href="question.php"><p>Back</p></a>
            </center>
    </div>    
  </section>
      

            <div class="container">
                <form method="post" name="search-submit" action="">                
                    <input type="hidden" name="id_question" value="<?php echo $_GET["update"]; ?>"> 
                    
                    <label for="">Question number:</label>
                    <input name="question_number" type="text" value="<?php echo $question->getQuestionNumber(); ?>">
                    <br>

                    <label for="">Question:</label>                                        
                    <br>
                    <textarea rows="4" cols="50" name="question" type="text" value="<?php echo ltrim($question->getQuestion()); ?>">
                    <?php echo ltrim($question->getQuestion()); ?>
                    </textarea> 
                    <br>                                        
                    
                    <label for="">Response options:</label>                    
                    <br>
                    <textarea rows="4" cols="50" name="response_options" type="text" value="<?php echo ltrim($question->getResponseOptions()); ?>">
                    <?php echo ltrim($question->getResponseOptions()); ?>
                    </textarea> 
                    <br>

                    <label for="">Type:</label>                    
                     <select name="type" >
                    <?php
                    $types = array('radio','select','input','checkbox');
                                                    
                        foreach ($types as $type):
                        ?>
                        <option value="<?php echo $type; ?>" <?php echo ($question->getType()==$type) ? "selected='selected'" : '' ; ?> >
                        <?php echo $type; ?></option>
                        <?php
                        endforeach;
                    ?>
                    </select>

                    <br>

                    <label for="">Name form:</label>
                    <input name="name_form" type="text" value="<?php echo $question->getNameForm(); ?>">
                    <br>

                    <label for="">Survey:</label>                    
                    <select name="id_survey" >
                    <?php
                                                    
                        foreach ($survey->getAllSurveyRole() as $query_survey):
                        ?>
                        <option value="<?php echo $query_survey['id_survey']; ?>" <?php echo ($question->getIdSurvey()==$query_survey['id_survey']) ? "selected='selected'" : '' ; ?> >
                        <?php echo $query_survey['survey']." - ".$query_survey['role']; ?></option>
                        <?php
                        endforeach;
                    ?>
                    </select>
                                                        
                    <br>
                    
                    <button name="submit" value="update">update</button>
                </form>
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
<?php
}
else{
  header("location:index.php");
}

?>

