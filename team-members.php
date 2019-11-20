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
          <li>Team Members</li>
        </ul>
        <h2>TEAM MEMBERS</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->


      
          <div class="general-title text-center">
          <h3>About our Team</h3>
          <p>We are a team of seven researchers based at the <br> Department of Genetic Identification <br> at Erasmus MC in Rotterdam. </p>          
          
        </div>
        
      


        
             

  <section class="section1">
    <div class="container clearfix">

      <div class="column">
        <div class="card">                  
            <div class="container">
                  <img src="img/staff/athina.jpg" alt="athina" style="width:15%;">
                  <h2>Dr. Athina Vidaki</h2>
                  <p>
                  Athina is a postdoctoral research fellow, conducting innovative research in the field of epigenetics for forensic and medical applications. She is the initiator and coordinator of the I Lab U project, overviewing all ongoing activities. She is passionate about science communication, with plenty of experience as a STEMNET forensic science ambassador. She always tries to find a chance to connect to the public and talk about her research – and yes, she loves talking too!
                  </p>        
                <!-- <p><button class="button">Contact</button></p> -->                
              </div>              
            </div>          
</div>
<p class="title"> </p>
<br>

  <div class="column">
    <div class="card">
    
      <div class="container">
      <img src="img/staff/gabriela.jpg" alt="gabriela" style="width:10%">
        <h2>Gabriela Dankova</h2>        
        <p>
        Gabriela is a PhD candidate, investigating how our appearance is encoded in our DNA. She is the main I Lab U event organizer, making sure that everything runs smoothly and all participants are happy. Organizing events (and people) is her big hobby. She gains experience from being a board member of Erasmus PhD Association Rotterdam. If you need to bring some more structure into your life, she is your “go-to person”.
        </p>        
      </div>
    </div>
  </div>

<p class="title"> </p>
<br>
  <div class="column">
    <div class="card">      
      <div class="container">
          <img src="img/staff/ben.jpg" alt="ben" style="width:10%">
        <h2>Benjamin Planterose</h2>        
        <p>
        Ben is a PhD candidate, investigating the hypervariability of our (epi)genome. He is responsible for the I Lab U data analysis. Give him data and he will be happy!
        </p>        
      </div>
    </div>
  </div>
 
  <p class="title"> </p>
<br>
  <div class="column">
    <div class="card">
    
      
      <div class="container">
        <img src="img/staff/celia.jpg" alt="ben" style="width:10%">
        <h2>Celia Díez López</h2>                
        <p>
        Celia is a PhD candidate, investigating novel uses of the microbiome in forensic genetics. She is responsible for the project finance and administration, taking care that I Lab U ‘makes ends meet’. She believes that one of the main points of science communication is to reach people in an attractive and efficient way, and I Lab U is a great platform for it!
        </p>        
      </div>
    </div>
  </div>

  <p class="title"> </p>
<br>
  <div class="column">
    <div class="card">
      
      <div class="container">
      <img src="img/staff/lucy.jpg" alt="ben" style="width:10%">
        <h2>Lucie Kulhankova</h2>                
        <p>
        Lucie is PhD student, working on analyzing mixed DNA samples. She takes care of communication and social media. She became passionate about science communication during her time in the iGEM competition. In her personal live she loves a good novel, tea, and all the podcasts you can find.
        </p>        
      </div>
    </div>
  </div>

  <p class="title"> </p>
<br>
      <div class="column">
        <div class="card">
          
          <div class="container">
          <img src="img/staff/vivian.jpg" alt="ben" style="width:10%">
            <h2>Vivian Kalamara</h2>            
            <p>
            Vivian is a research analyst, developing and applying potentially useful forensic (epi)genetic tools. She is responsible for the I Lab U data collection via questionnaires. She believes that data tend to survive when they are loved, so I Lab U must be the right place to be for such purpose!
            </p>        
          </div>
        </div>
      </div>

<p class="title"> </p>
<br>
      <div class="column">
        <div class="card">
          
          <div class="container">
          <img src="img/staff/diego.jpg" alt="ben" style="width:10%">
            <h2>Diego Montiel González</h2>            
            <p>
            Diego is a bioinformatician, passionate about how technology can be implemented to help others. He is in charge of the I Lab U digital platform and other cool stuffs!
            </p>        
          </div>
        </div>
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
