<?php

require_once 'ProgressBar.class.php';   
$bar = new ProgressBar();   
    
$elements = 100000; // total number of elements to process   
$bar->initialize($elements); // print the empty bar   
    
for($i=0;$i<$elements;$i++){   
       // do something here...   
    $bar->increase(); // calls the bar with every processed element   
}   

?>
