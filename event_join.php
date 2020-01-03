<?php
session_start() ;

if( !empty($_SESSION) && !empty($_GET))
{        
    #print_r($_GET);
    #print_r($_SESSION);    
    include_once 'library/Question.php';    
    include_once 'library/User.php';        
    include_once 'library/Response.php';     
    include_once 'library/UserEvent.php';           
    include_once 'library/Event.php';        
    include_once 'library/Transaction.php';        

    $question   = new Question() ;        
    $response_  = new Response() ;        
    $event      = new Event()    ;        
    $user_event = new UserEvent();
    $user       = new User()     ;            
    $transaction= new Transaction()     ;            
    
    #$survey_option  = "Registration";
    #$role_option    = "public";
    $survey         = $_GET["q"];    
    $id_role        = $_GET["id_role"];  
    $id_info_event  = $_GET["id_info_event"];
    $session_number = $_GET["session_number"];    
    $id_user        = $_SESSION["email"];    
    
    
    $event->loadIdByRegistration($id_role, $id_info_event, $session_number);        
    $id_event = $event->getId();
    ### Verify which role is and send to the appropiate one 1: Public 2:Scientist    
    $user_response = $response_->getAllByIdUser($_SESSION["email"]);    
    if(count($user_response)>0)
    {
      #if($id_role == '1'){ header("location:1/"); }else{ header("location:2/");}
      header("location:session.php");
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
            #$form = $question->getForm($query_question);
            $form = $question->getFormComponents($query_question);
        }
        else
        {
            //In case there are no forms or something went wrong
            //Show an error message or something
        }      
      if(isset($_POST["submit"]))
      {             
          #print_r($_POST);                    
          //Questionaire submitted and is not empty     
          //print_r($query_question);
          //foreach($query_question as $query): echo $query["name_form"]; echo "<br/>"; endforeach;          
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
                  if(!empty(str_replace(";","",$response)) || !empty($response)){
                    #echo str_replace(";","",$response);
                    #if(empty(str_replace(";","",$response) !== 1)){ ## if not empty
                      $myObj->$key = $response;
                    }                                     
          endforeach;                       
              #print_r($myObj);
              $new_array_keys = array();
              foreach($array_keys as $key):$new_array_keys[] = str_replace("_other","",$key);endforeach;
              $array_keys = array_unique($new_array_keys);                                                
              $array_json = array();              
              foreach($myObj as $key => $object): $array_json[] = $key; endforeach;              
              /// here starts the sql to insert in the database
              #echo count($array_json); #Array containing names where contain info after submit by the user
              #echo count($array_keys); #Array containing all names from $_POSt                                                        

              ## removes submit button as an element from the array
              if (($key = array_search('submit', $array_keys)) !== false){ unset($array_keys[$key]); }                
              
              if(count($array_keys) == count($array_json))
              {                
                  #echo "<h1>Success! we are going to stored this form now!</h1>";
                  ## Add in case there is a date in the questionaire and store it                                                                        
                  #$myJSON = json_encode($myObj);   
                  
                  $objUserEvent = NULL;
                  $objUserEvent["id_user"] = $id_user;
                  $objUserEvent["id_event"] = $id_event;                      
                  $objUserEvent["waiting_list"] = '1';                      
                  #Implement in case there are more than 20 events already register add waiting list 1
                  #if there is space add waiting list 0
                  #if(){}else{}
                  $sqlQuery = "BEGIN; ";                                  
                  $sqlQuery .= $user_event->insertConcat($objUserEvent);
                  
                  #print_r($objUserEvent);                  
                  foreach($myObj as $name_form => $response): 
                      #echo $_SESSION["email"];
                      $user->loadById($_SESSION["email"]);                      
                      $id_user = $user->getId();                      
                      $id_question = NULL;
                      $q_question = $question->loadIdByNameForm($name_form);                          
                      $id_question = $question->getId();               
                      
                      $objResponse = NULL;
                      $objResponse["id_user"] = $id_user;
                      $objResponse["id_question"] = $id_question;
                      $objResponse["response"] = $response;
                      ## In case there is a date                                                                                                        
                      $objResponse["username_date"] = "NA";                                  
                      if($q_question > 0){ $sqlQuery .= $response_->insertConcat($objResponse); }
                      #$id_insert      = $response_->insert($objResponse);                                                    
                      #$id_user_event  = $user_event->insert($objUserEvent);                                            
                  endforeach;                                        
                  $sqlQuery = $sqlQuery." COMMIT;";                  

                    #$resultSet = $response_->executeMultiSQL($sqlQuery); #this works                    
                    #print_r($sqlQuery);                    
                    $resultSet = $transaction->execute($sqlQuery); #this also works with PDO                                                    
                    
                    if($resultSet)
                    {                        
                        echo "<script>
                        alert('Success! Registration submitted');
                        window.location.href='session.php';
                        </script>";                                                                          
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
echo $error;
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
    <div class="container clearfix">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
      <div class="clearfix"></div>
        <div class="divider"></div>
        <h5 class="title">Registration</h5>
        <p><strong>Please, answer as honestly as possible</strong></p>
          <?php #echo $form;?>

          <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">                    
                    <div style="display: block; width: 80%; min-width: 400px; text-align:left;">                       
                        <div style="display: inline-block; text-align: left; width: 60%">                                                                                                            
                                <form role="form" action="" method="POST">                               
                                        <div class="form-group">
                                          <?php echo $form;?>
                                        </div>
                                        <div class="form-group">
                                          <button name="submit" type="submit" class="btn btn-large btn-primary">Submit</button>                        
                                        </div>
                                </form>                       
                        </div>
                    </div>

                  
                  
                  

                
          </div>
      </div>
    </div>
    <br><br><br><br><br>
  </section>

<?php $component->getFooter(); ?>
<?php $component->getJavascriptLibraries(); ?>
<div class="dmtop">Scroll to Top</div>
</body>
</html>
<?php
  }
  else{ header("location:index.php");  }
?>