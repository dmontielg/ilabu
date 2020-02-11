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
                        
       function exportCSV($query, $header, $filename)
       {
            header('Content-Type: text/csv; charset=utf-8');  
            #header("Content-Type: application/vnd.ms-excel");
            #header('Content-Disposition: attachment; filename=$filename');  
            header('Content-Disposition: attachment; filename='.$filename);  
            $output = fopen("php://output", "w");  
            fputcsv($output, $header);  
            #fputcsv($output, array('ID', 'waiting_list', 'email', 'event', 'role'));          
            foreach($query as $key => $value):                    
                fputcsv($output, $value);                              
            endforeach;
            fclose($output);  
            exit();
       }
       

if($_SESSION["verified"] == 3) ## 3 is for admin account
{                                  
        if($_POST["export-user-event"] == "export"){
            $query = $user->getAllUsersEventAdmin();  
            $header = array('ID', 'waiting_list', 'email', 'verified', 'createdate','role','event');
            
            $filename = "user-events";            
            $filename .= date("Y-m-d h:i:sa");
            $filename .= ".csv";
            exportCSV($query, $header,$filename);    
        }

        if($_POST["export-user-response"] == "export"){
            $query = $user->getAllUsersResponseAdmin();              
            $header = array('ID', 'waiting_list', 'email', 'verified', 'createdate','role','event','name_form','response','username_date', 'timestamp');
            
            $filename = "user-events-responses_";                        
            $filename .= date("Y-m-d h:i:sa");
            $filename .= ".csv";

            exportCSV($query, $header, $filename);    
        }

        if($_POST["export-questions"] == "export"){
            $query = $user->getAllQuestionsAdmin();              
            $header = array('ID', 'question', 'number', 'response', 'name_form','survey','role');            
            $filename = "questions_";                        
            $filename .= date("Y-m-d h:i:sa");
            $filename .= ".csv";

            exportCSV($query, $header, $filename);    
        }

        if($_POST["export-users"] == "export"){
          $query = $user->getAllUsersJoinedAndNotJoined();              
          
          $header = array('ID', 'email', 'verified', 'joined', 'createdate');            
          $filename = "users_";                        
          $filename .= date("Y-m-d h:i:sa");
          $filename .= ".csv";

          exportCSV($query, $header, $filename);    
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
                    <h3>Users</h3>            
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
      
      <table id="thetable" class="table table-striped" data-effect="fade">
          <thead>
            <tr>
              <th>ID</th>              
              <th>VERIFIED</th>
              <th>JOINED</th>
              <th>EMAIL</th>              
              <th>CREATE DATE</th>
              <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $query_users              = $user->getAllUsersAdmin();  
            $query_user_event         = $user_event->getAll();
            $id_user_users_event      = array();
            foreach($query_user_event as $q_user_event):                
                $id_user_users_event[] = $q_user_event["id_user"];
            endforeach;
            
            foreach($query_users as $key => $value):
                echo "<tr>";
                    
                    echo "<td>";
                        echo $value["id_user"];
                    echo "</td>";

                    echo "<td>";
                        if($value["verified"] == 0)
                        {echo "NO";}
                        elseif($value["verified"] == 1)
                        {echo "YES";}
                        elseif($value["verified"] == 2)
                        {echo "TERMINATED";}                    
                        elseif($value["verified"] == 3)
                        {echo "ADMIN";}                    
                    echo "</td>";

                    echo "<td>";
                        if(in_array($value["id_user"], $id_user_users_event))
                        {echo "YES";}
                        else{echo "NO";}                        
                    echo "</td>";

                    echo "<td>";
                        echo $value["email"];
                    echo "</td>";                    

                    echo "<td>";
                        echo $value["createdate"];
                    echo "</td>";

                    echo "<td>";                    
                        echo "<a href='user_crud.php?update=".$value['id_user']."'>Edit</a>\t\t";
                        #echo "<a href='user_crud.php?delete=".$value['id_user']."'>Delete</a>";
                    echo "</td>";
                echo "</tr>";
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
