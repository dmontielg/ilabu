<?php             
session_start();

        
        include_once '../library/Component_.php'; 
        
        include_once '../library/User.php';              
        include_once '../library/UserEvent.php';              
        include_once '../library/Question.php';              
        include_once '../library/Response.php';              
        include_once '../library/Transaction.php';              
        include_once '../library/Survey.php';              
        
        $transaction = new Transaction()  ;
        $user_event = new UserEvent()     ;
        $question = new Question()        ;
        $component = new Component_()     ;
        $response_ = new Response()       ;
        $user = new User()                ;
        $survey = new Survey()            ;                                  

if($_SESSION["verified"] == 3) ## 3 is for admin account
{                                              

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
                                    <li><a href="users_event.php">Users-Events</a></li>
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
                    <h3>Questionnaires</h3>            
            </center>
    </div>    
  </section>
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">      

            <div class="container">

                <form method="post" name="search-submit" action="">
                <div>        
                    <p>Export:</p>
                <button  style="width: 12%;" type="submit" value="export" name="export-user-event" class="button">User-Events</button>                
                <button  style="width: 10%; float:center; " type="submit" value="export" name="export-user-response" class="button">Responses</button>
                <button  style="width: 10%; float:center; " type="submit" value="export" name="export-questions" class="button">Questions</button>
                <button  style="width: 10%; float:center; " type="submit" value="export" name="export-users" class="button">Users</button>
                </div>                
                </form>
            </div>

      <table class="table table-striped" data-effect="fade">
          <thead>
            <tr>
              <th class="col-md-2">NUMBER</th>
              <th class="col-md-2">QUESTION</th>              
              
              <th class="col-md-2">TYPE</th>
              <th class="col-md-2">NAME_FORM</th>
              <th class="col-md-2">SURVEY</th>
              <th class="col-md-2">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $query_question = $question->getAllSorted();  

            #print_r($query_question)

            foreach($query_question as $key => $value):
              echo "<tr>"; 
                    echo "<td>";  
                    echo $value["question_number"];
                    echo "</td>";
                    echo "<td>";  
                    echo $value["question"];
                    echo "</td>";
              
                    echo "<td>";  
                    echo $value["type"];
                    echo "</td>";
                    echo "<td>";  
                    echo $value["name_form"];
                    echo "</td>";
                    echo "<td>";  
                    $survey->loadById($value["id_survey"]);
                    #echo $value["id_survey"];
                    echo $survey->getSurvey();
                    echo "</td>";
                    echo "<td>";
                    
                    echo "<a href='question_crud.php?update=".$value['id_question']."'>Edit</a>\t\t";
                    #$echo "<a href='user_crud.php?delete=".$value['id_user']."'>Delete</a>";
                    echo "</td>";
                echo "</tr>" ;
            endforeach;
       
          ?>            
          </tbody>
        </table>

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
  header("location:../login.php");
}

?>
