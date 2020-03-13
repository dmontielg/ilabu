<?php

include_once ("UserEvent.php");

class Component{

        function getHead(){
                echo '
                <head>
                  <meta charset="utf-8">
                  <title>I Lab U: Speed Date a Scientist</title>
                  <meta content="width=device-width, initial-scale=1.0" name="viewport">
                  <meta content="" name="keywords">
                  <meta content="" name="description">

                  <!-- Favicons -->
                  
                  <!-- 
                  
                  <link href="img/favicon.png" rel="icon">
                  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
                  -->
                  

                  <!-- Google Fonts -->
                  <link href="https://fonts.googleapis.com/css?family=Ruda:400,900,700" rel="stylesheet">

                  <!-- Bootstrap CSS File -->
                  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

                  <!-- Libraries CSS Files -->
                  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                  <link href="lib/prettyphoto/css/prettyphoto.css" rel="stylesheet">
                  <link href="lib/hover/hoverex-all.css" rel="stylesheet">
                  <link href="lib/jetmenu/jetmenu.css" rel="stylesheet">
                  <link href="lib/owl-carousel/owl-carousel.css" rel="stylesheet">

                  <!-- Main Stylesheet File -->
                  <link href="css/style.css" rel="stylesheet">
                  <link rel="stylesheet" href="css/colors/blue.css">                  
                  <link href="css/bbpress.css" rel="stylesheet">

                  <link href="css/lightgallery.css" rel="stylesheet">               
                  <link href="css/gallery-ilabu.css" rel="stylesheet">
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
           
                  <!-- =======================================================
                    Template Name: MaxiBiz
                    Template URL: https://templatemag.com/maxibiz-bootstrap-business-template/
                    Author: TemplateMag.com
                    License: https://templatemag.com/license/
                  ======================================================= -->
                </head>

                ';
        }

        function getJavascriptLibraries(){
              echo '
                <!-- JavaScript Libraries -->
                <script src="lib/jquery/jquery.min.js"></script>
                <script src="lib/bootstrap/js/bootstrap.min.js"></script>
                <script src="lib/php-mail-form/validate.js"></script>
                <script src="lib/prettyphoto/js/prettyphoto.js"></script>
                <script src="lib/isotope/isotope.min.js"></script>
                <script src="lib/hover/hoverdir.js"></script>
                <script src="lib/hover/hoverex.min.js"></script>
                <script src="lib/unveil-effects/unveil-effects.js"></script>
                <script src="lib/owl-carousel/owl-carousel.js"></script>
                <script src="lib/jetmenu/jetmenu.js"></script>
                <script src="lib/animate-enhanced/animate-enhanced.min.js"></script>
                <script src="lib/jigowatt/jigowatt.js"></script>
                <script src="lib/easypiechart/easypiechart.min.js"></script>
            

            
                <!-- Template Main Javascript File -->
                <script src="js/main.js"></script>

              ';
        }

        function getFooter(){
            echo '
                    <footer class="footer">                
                    <div class="container">                                  
                          <h4 class="title">Get in touch with us!</h4>  
                        <ul class="contact_details">
                          <li><i class="fa fa-envelope-o"></i> ilabu@erasmusmc.nl</li>
                          <li><i class="fa fa-phone-square"></i> +31 10 703 80 93</li>
                          <li><i class="fa fa-home"></i> Erasmus MC, Dr.Molewaterplein 40, 3015 GD Rotterdam, The Netherlands.</li>          
                        </ul>                              
                    </div>                                
                    <div class="copyrights">
                      <div class="container">
                        <div class="col-lg-6 col-md-6 col-sm-12 columns footer-left">
                          <p>Copyright © 2019 - All rights reserved.</p>
                          <div class="credits">
                            <!--
                              You are NOT allowed to delete the credit link to TemplateMag with free version.
                              You can delete the credit link only if you bought the pro version.
                              Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/maxibiz-bootstrap-business-template/
                              Licensing information: https://templatemag.com/license/
                            -->
                            Created with MaxiBiz template by <a href="https://templatemag.com/">TemplateMag</a>
                          </div>
                        </div>        
                      </div>
                      <!-- end container -->
                    </div>
                    <!-- end copyrights -->
                  </footer>          
              ';
        }
        function getTopBar(){
              echo '
                  <div class="topbar clearfix">
                    <div class="container">
                      <div class="col-lg-12 text-right">
                        <div class="social_buttons">
                        
<!--
                          <a href="https://www.facebook.com/ilabuNL" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>
                          <a href="https://www.instagram.com/ilabu_nl/?hl=nl" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram"></i></a>                                                    
  -->                      
                        </div>
                      </div>
                    </div>
                    <!-- end container -->
                  </div>
                  <!-- end topbar -->
              ';
        }

        function getHeader($pageName){

              $menu = '            
                    <header class="header">
                    <div class="container">
                      <div class="site-header clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-12 title-area">
                          <div class="site-title" id="title">                                                          
                              <div class="logo">
                                    <!-- <center>-->
                                    <a href="index.php" title="logo">              
                                    <img src="img/ilabu/logo.png" alt="ilabu-logo" />                                                                
                                    </a>                                
                                    <a target="_blank" href="https://www.erasmusmc.nl" title="erasmus">              
                                    <img style="width:44%; float:right;" src="img/ilabu/erasmus_logo.jpg" alt="erasmus-logo" />                                                                
                                    </a>                                
                                    <!--</center>-->
                              </div>
                              
                          </div>                                                              
                        </div>                        

                        
                        <!-- title area -->
                        <div class="col-lg-9 col-md-12 col-sm-12">
                        <div id="nav" class="right">


                            <div class="container clearfix">
                              <ul id="jetmenu" class="jetmenu blue">';
                
                              
                    
                    
                    /*
                    $menu .= '
                    
                    <div class="dropdown">
                        <button class="dropbtn">Gallery</button>
                        <div class="dropdown-content">
                            <a href="gallery_spark.php">Spark between us</a>
                            <a href="#">Getting closer</a>                            
                        </div>
                        </div>
                    '; 
                    */
                    
                    if(strpos($pageName, 'index') !== false){ $menu .= '<li class="active"><a href="index.php">Home</a></li>'; }
                    else{ $menu .= '<li><a href="index.php">Home</a></li>'; }

                    if(strpos($pageName, 'about') !== false){ $menu .= '<li class="active"><a href="about.php">About Us</a></li>'; }
                    else{ $menu .= '<li><a href="about.php">About Us</a></li>'; }

                    if(strpos($pageName, 'team-members') !== false){ $menu .= '<li class="active"><a href="team-members.php">Team</a></li>'; }
                    else{ $menu .= '<li><a href="team-members.php">Team</a></li>'; }

                    if(strpos($pageName, 'events') !== false){ $menu .= '<li class="active"><a href="events.php">Events</a></li>'; }
                    else{ $menu .= '<li><a href="events.php">Events</a></li>'; }                    

                    if(strpos($pageName, 'photos') !== false){ 
                      $menu .= '
                      <li class="active"><a href="#">Photos</a>
                      <ul class="dropdown">
                        <li><a href="spark_photos.php">The spark between us</a></li>                        
                        <li><a href="closer_photos.php">Getting closer</a></li>                        
                      </ul>
                    </li>
                    ';

                    }else{

                      $menu .= '
                      <li><a href="#">Photos</a>
                      <ul class="dropdown">
                        <li><a href="spark_photos.php">The spark between us</a></li>                        
                        <li><a href="closer_photos.php">Getting closer</a></li>                        
                      </ul>
                    </li>';

                     }
                    
                     /*<li><a href="#">Getting closer</a></li>
                        <li><a href="#">Lets talk about life</a></li>
                        <li><a href="#">Who pays the bill?</a></li>
                        <li><a href="#">Whats next?</a></li> */

                    if(strpos($pageName, 'register') !== false){ $menu .= '<li class="active"><a href="register.php">Register</a></li>'; }
                    else{ $menu .= '<li><a href="register.php">Register</a></li>'; }

                    if(strpos($pageName, 'login') !== false){ $menu .= '<li class="active"><a href="login.php">Login</a></li>'; }
                    else{ $menu .= '<li><a href="login.php">Login</a></li>'; }

                    if(strpos($pageName, 'contact') !== false){ $menu .= '<li class="active"><a href="contact.php">Contact</a></li>'; }
                    else{ $menu .= '<li><a href="contact.php">Contact</a></li>'; }

                    if(!empty($_SESSION["email"]))
                    { 
                      if(strpos($pageName, 'session') !== false){ $menu .= '<li class="active"><a href="session.php">Session</a></li>'; }
                      else{ $menu .= '<li><a href="session.php">Session</a></li>'; }
                     
                        $menu .= '<li><a href="logout.php">Log out</a></li>';    
                    }
                    
                    $menu .= '                                  
                              <!-- <li><a href="testimonials.html">Testimonials</a></li> -->                                  
                              </ul>



                              
                            



                            </div>


              


                          </div>
                          <!-- nav -->
                        </div>
                        <!-- title area -->
                      </div>
                      <!-- site header -->
                    </div>
                    
                    

                    <!-- end container -->
                  </header>
                  <!-- end header -->            
              ';

              echo $menu;
        }
}
?>