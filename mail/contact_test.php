<?php

if(isset($_POST))
{ 
  echo empty($_POST);
    print_r($_POST);
    echo "<br/>";
    foreach($_POST as $key ){
      echo $key;
    }
        echo "Send message!!";
        echo $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        #echo $name;
        echo $email;
        echo $subject;
        echo $message;
}

?>

