<?php

      if(!empty($_POST))
      { 
          print_r($_POST);   
          
          if(isset($_POST['p1_7']))
          {
              $p1_7=$_POST['p1_7'];        
              foreach ($avatar as $p1_7=>$value)
              {
                     echo "p1_7 : ".$value."<br />";
              }                        
          }        
      }
       
      

      




?>

