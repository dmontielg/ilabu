<?php             
session_start();

        include_once '../library/Component_.php'; 
        include_once '../library/User.php';              
        include_once '../library/UserEvent.php';              
        include_once '../library/Question.php';              
        include_once '../library/Response.php';              
        include_once '../library/Transaction.php';              
        
        $transaction = new Transaction()  ;
        $user_event = new UserEvent()     ;
        $question = new Question()        ;
        $component = new Component_()     ;
        $response_ = new Response()       ;
        $user = new User()                ;


  if(isset($_POST["submit_event"]))
  {
    if($_POST["finish_event"] == "yes")
    {
        ### This is gonna set user verified to 2             
        $user->updateVerifiedById($_SESSION["email"]);
        $user->loadById($_SESSION["email"]);
        #echo $user->getVerified();
        $_SESSION["status"] = $user->getVerified();     
    }
  }

if($_SESSION["status"] == 1)
{                        
        #print_r($_GET);
        $survey = $_GET["survey"];
        #$survey = "Speed date";


        $message = NULL;
        $id_user = $_SESSION["email"];

        $user->loadById($id_user);
        $eventResult = $user_event->getEventByIdUser($id_user);
        $id_info_event = $eventResult[0]["id_info_event"];
        $id_role = $eventResult[0]["id_role"];
        $time = $eventResult[0]["time"];
        $date = $eventResult[0]["date"];
        $code = $eventResult[0]["code"];

        $resultIdDates = $question->getAllIdDates($id_user);        
        $array_id_user = "";
        
        if(count($resultIdDates) > 0)
        {
            foreach($resultIdDates  as $value):               
              $array_id_user .= $value["username_date"]; 
              $array_id_user .= ",";               
            endforeach;
            $array_id_user = substr_replace($array_id_user ,"", -1);       
            $resultDateNames = $question->getFilteredDateNames($id_info_event,$id_role, $array_id_user);
        }
        else
        {
          $resultDateNames = $question->getAllDateNames($id_info_event,$id_role);
        }                                
        $query_question = $question->getQuestionaire($survey, $id_role);    
            
                if ($query_question->connect_error)
                {
                  die("Connection failed: " . $conn->connect_error);
                }
                $row_cnt = 0;
                foreach ($query_question as $query): $row_cnt += 1;  endforeach;			
                $form = NULL;    
                if ($row_cnt > 0)
                {
                    $form = $question->getFormComponents($query_question);
                }
                else
                {
                    //In case there are no forms or something went wrong
                    //Show an error message or something
                }      
                
                if(isset($_POST["submit"]))
                {             
                    //Questionaire submitted and is not empty     
                    #print_r($_POST);
                    #foreach($query_question as $query): echo $query["name_form"]; echo "<br/>"; endforeach;          
                    $email = $_SESSION["email"];
                    $event = $_SESSION["event"];                                                  
                    $opt_radio = array();
                    $opt_no_radio = array();
                    foreach($_POST as $key => $value):           
                        if(strpos($key,"other") !== false){$opt_radio[] = $key;}
                    endforeach;          
                    $new_opt_radio = array();
                    foreach($opt_radio as $v):
                        $new_opt_radio[] = $v;
                        $new_opt_radio[] = str_replace("_other","",$v);
                    endforeach;
                    //foreach($new_opt_radio as $r): echo $r; echo "<br/>"; endforeach;
                    #print_r($_POST);                    
                    $error = "";
                    #$error .= "Please fill the following questions to proceed:<br/>";
                    $myObj = NULL;      
                    $array_keys = array();  
                    foreach($_POST as $key => $value):  
                            
                            $array_keys[] = $key;                                    
                            $response = "";      
                            //$response .= $key.": ";
                            ## Not an optional question (just regular one)
                            if(!in_array($key, $new_opt_radio))
                            {
                                if(is_array($value)){ foreach($value as $index): $response .= $index.";"; endforeach; }
                                else{ $response .= $value; }                                        
                            }
                            else
                            {   ## An optional question radio button with optional question                        
                                if(!empty($_POST[$key]))
                                {                                                
                                  $response .= $_POST[$key];
                                  $key = str_replace("_other","",$key);                                                
                                }                      
                            }                                                                
                            if(!empty(str_replace(";","",$response)) || !empty($response)){ $myObj->$key = $response;}                                     
                            
                    endforeach;         
                                    
                        $new_array_keys = array();
                        foreach($array_keys as $key):$new_array_keys[] = str_replace("_other","",$key);endforeach;
                        $array_keys = array_unique($new_array_keys);                                                
                        $array_json = array();              
                        foreach($myObj as $key => $object): $array_json[] = $key; endforeach;              
                        /// here starts the sql to insert in the database
                        #echo count($array_json); #Array containing names where contain info after submit by the user
                        #echo count($array_keys); #Array containing all names from $_POSt                                                                      
                        
                        #print_r($array_json);
                        #print_r($array_keys);                
                        
                        ## removes submit button as an element from the array
                        if (($key = array_search('submit', $array_keys)) !== false){ unset($array_keys[$key]); }                
                        
                        if(count($array_keys) == count($array_json))
                        {                                           
                            #$sqlQuery = "BEGIN; ";                                                        
                            $sqlQuery = "";                                                        
                            foreach($myObj as $name_form => $response): 
                                                                
                                $id_question = NULL;
                                $objResponse = NULL;

                                $q_question = $question->loadIdByNameForm($name_form);                          
                                $id_question = $question->getId();                                       
                                
                                $objResponse["id_user"] = $id_user;
                                $objResponse["id_question"] = $id_question;
                                $objResponse["response"] = $response;
                                ## In case there is a date                                                                                                        
                                if(!empty($_POST["username_date"])){ $objResponse["username_date"] = $_POST["username_date"]; }else{ $objResponse["username_date"] = "NA"; }                        
                                if($q_question > 0){ $sqlQuery .= $response_->insertConcat($objResponse); }                        
                            endforeach;                                                                                
                            #$sqlQuery = $sqlQuery." COMMIT;";                                                                                                                      
                            #$resultSet = $response_->executeMultiSQL($sqlQuery); #this works                                                            
                            $resultSet = $transaction->execute($sqlQuery); #this also works with PDO                                                    
                            #$resultSet = $response_->executeSQL($sqlQuery);                    
                            #echo $resultSet;                    
                            if($resultSet)
                            {
                              echo "<script>
                                  alert('Success! Questionnaire submitted');
                                  window.location.href='index.php?survey=".$survey."';
                                  </script>";
                            ?>                              
                            <?php                                                                                   
                            }
                            else
                            {
                              $error .= "Sorry!, Something went wrong :( please fill the form again.<br/>";                    
                              $error = "<div class='alert alert-danger' role='alert'>".$error."</div>";       
                            }                                                                 
                        }
                          /// here shows a message error of which questions are missing
                        else
                        {                                                
                          $error .= "Please fill the following questions to proceed:<br/>";
                          foreach(array_diff($array_keys, $array_json) as $key):
                            $error  .= $key;
                            $error  .= "<br/>";              
                          endforeach;
                          $error = "<div class='alert alert-danger' role='alert'>".$error."</div>";                
                        }                                                        
                  #}
                }
?>



<!DOCTYPE html>
<html lang="en">
<?php $component->getHead(); ?>
<body>
<?php $component->getTopBar(); ?>
<?php $component->getHeader("user_1"); ?>



            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Finish event</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="container">                                  
                                      <form method="post" action="">                                                                                          
                                      <label>Do you want to finish this event?</label>                                      
                                      <br/>                                               
                                      <input type="radio" name="finish_event" value="yes" >Yes
                                      <input type="radio" name="finish_event" value="no" >No                                                                                
                                      <br/>
                                        <button type="submit" name="submit_event" class="button"> Send </button>
                                      </form>
                                  </div>
                              </div>                              
                              <div class="modal-footer">                              
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
            <!--/// Modal ends here -->


<!-- Content Starts here -->
  <section class="post-wrapper-top">  
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
        <h2><?php echo $_GET["survey"]; ?></h2>
      </div>    
      <div>              
          <div>
              <?php $component->getSessionFormLink(); ?>                    
          </div>
      </div>
    </div>    
  </section>  
  <!-- end post-wrapper-top -->
  <section class="section1">  
    <div class="container clearfix">           
    <section class="section1">    
    <div class="container" >    

      <h3>Please, answer as honestly as possible:</h3>            
    </div>    
  </section>
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">      
          <form role="form" action="" method="POST">          
                      <?php 
                      if($survey == "Speed date")
                      {           
                      ?>                    
                                <div class="form-group">
                                <select name="username_date" >
                                <option value="">--- Select Date --- </option>
                                  <?php
                                    foreach ($resultDateNames as $elemento):
                                  ?>
                                <option value="<?php echo $elemento['id_user']; ?>" 
                                <?php echo ($id_empleado==$elemento['id_user']) ? "selected='selected'" : '' ; ?> >
                                <?php echo "0000".$elemento['id_user']; ?></option>
                                  <?php
                                    endforeach;
                                  ?>
                                </select>          
                                </div>                                
                      <?php 
                      }
                      ?>         
                <div class="form-group">
                  <?php echo $form;?>
                </div>
                <div class="form-group">
                  <button name="submit" type="submit" class="btn btn-large btn-primary">Submit</button>                        
                </div>
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
else if($_SESSION["status"] == 2)
{
  echo "<script>
                                  alert('Thanks for your assistance! You have already finished with this event!');
                                  window.location.href='../session.php';
                                  </script>";
}
else{
  header("location:../session.php");
}

?>