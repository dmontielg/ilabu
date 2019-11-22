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
          $query = $user->getAllUsersAdmin();              
          
          $header = array('ID', 'email', 'verified', 'createdate');            
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
                <!--
                        <div>
                            
                        <input  style="width: 25%; float:left; " type="text" class="form-control" placeholder="email" name="email">
                        <input style="width: 25%; float:left;" type="text" class="form-control" placeholder="status" name="status">
                        <input style="width: 25%; float:left;" type="text" class="form-control" placeholder="Occupation" name="email">
                        <input style="width: 25%; float:left;" type="text" class="form-control" placeholder="Event" name="event">
                        </div>
                        <button  style="width: 100%; float:left;" type="submit" name="submit-search" class="button">Search</button>
                -->
                </form>
            </div>

      <table class="table table-striped" data-effect="fade">
          <thead>
            <tr>
              <th>ID</th>
              <th>WAITING LIST</th>
              <th>STATUS</th>
              <th>EMAIL</th>
              <th>ROLE</th>
              <th>EVENT</th>
              <th>CREATE DATE</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $query_users = $user->getAllUsersAdmin();  

            foreach($query_users as $key => $value):
                echo "<tr>";
                    echo "<td>";
                    echo $value["id_user"];
                    echo "</td>";
                    echo "<td>";
                    if($value["waiting_list"] == 1)
                    {echo "YES";}
                    else
                    {echo "NO";}                    
                    echo "</td>";
                    echo "<td>";
                    if($value["verified"] == 1)
                    {echo "ACTIVE";}
                    elseif($value["verified"] == 2)
                    {echo "TERMINATED";}                    
                    echo "</td>";
                    echo "<td>";
                    echo $value["email"];
                    echo "</td>";
                    echo "<td>";
                    echo $value["role"];
                    echo "</td>";
                    echo "<td>";
                    echo $value["event"];
                    echo "</td>";
                    echo "<td>";
                    echo $value["createdate"];
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
