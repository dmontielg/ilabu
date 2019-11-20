<?php

    session_start();

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
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <li>About</li>
        </ul>
        <h2>ABOUT</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->

        <div class="general-title text-center">
        <h3>About I Lab U</h3>
          <p>Learn more about this initiative</p>
          
        </div>
        
      
  <section class="section1">
    <div class="container clearfix">
      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="he-wrap tpl2">

                                    
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="img/staff/team.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="img/staff/team2.jpg" alt="Second slide">
                    </div>                    
                                    
         
            

          </div>          
        </div>
      

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                  
        <p>             
          I Lab U was born as part of a recent scientific competition in 2019, organized by one of the oldest scientific society in the Netherlands, the Bataafsch Genootschap der Proefondervindelijke Wijsbegeerte <strong>(Batavian Society for Experimental Philosophy)</strong>. The Bataafsch Genootschap der Proefondervindelijke Wijsbegeerte is a Dutch-learned society founded on June 3, 1769 and residing in Rotterdam. Currently, the Society, with around 400 members, is a forum for scientists around Rotterdam, that meets six times a year, to discuss topics mostly dedicated to medicine and engineering sciences. They also support excellent young Dutch scientists via the Steven Hoogendijk prizes. If you would like to find more information, please visit their website <a target="_blank" href="http://www.bataafschgenootschap.nl">here.</a>
            
          </p>

          <p>
          Last April, the Society organized a scientific competition for celebrating their 250th anniversary (impressive, isn’t it?!), inviting scientists to come up with ideas on how to experimentally help bridge the gap between scientists and the public. We were so excited that I Lab U was chosen amongst the three finalists and we got the chance to present our idea in front of the Society, and the former Queen of the Netherlands, Princess Beatrix! As winners of the competition and generously funded by the Society, I Lab U aims to connect scientists and the public via... speed dating! We believe that we can avoid miscommunication and misunderstanding of scientific information, evident more and more in our daily lives, by simply talking and listening to each other! In I Lab U we want everyone to feel equal and be given ways to communicate, in a way currently not possible from articles in newspapers, TV news or Facebook posts. 
          </p> 
              <div class="logo">
                  <center>
                      <img style="width:30%" src="img/ilabu/batavian.jpg" title="batavian-society" alt="batavian">
                  </center>
              </div>                      
        </div>

        <!-- end col-6 -->
      </div>

      <center><p><h3>You can find out more about our events <a href="events.php">here!</a></h3></p></center>

    </div>
    <!-- end container -->
    
                
      
  </section>
  <!-- end section 1 -->
  
  <div class="clearfix"></div>
  

  <div class="container">
    <div class="general-title text-center">
      
      
      
    </div>
    <div class="skills text-center">
    </div>
  </div>
  <!-- end container -->

  <div class="clearfix"></div>
  

  <!-- end section -->
<!-- Content Ends hhere -->
<?php $component->getFooter(); ?>
  <?php $component->getJavascriptLibraries(); ?>
  <div class="dmtop">Scroll to Top</div>
</body>
</html>
