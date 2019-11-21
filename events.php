<?php 
session_start() ;
#session_unset();
#session_destroy() ;

$message = NULL;
$flag = true;

if(isset($_POST['submit']))
{
        #print_r($_POST);
        if($_POST["id_info_event"] == "NA")
        {
            $message = "Please Select one event";
            $message .= "<br/>";
            $flag = false;
        }
        if(empty($_POST["id_role"]))
        {      
            $message .= "Please Select if you want to attend as Scientist or not";      
            $message .= "<br/>";
            $flag = false;
        }
        /*
        if(empty($_POST["public_session"]) && empty($_POST["scientist_session"]))
        {
          $message .= "Please Select a Session to attend";      
          $message .= "<br/>";
          $flag = false;
        }
        */
        if(empty($_POST["session_number"]))
        {
          $message .= "Please Select a Session to attend";      
          $message .= "<br/>";
          $flag = false;
        }
      
        if($flag == false){          
          $message = "<div class='alert alert-danger' role='alert'>".$message."</div>";
        }else
        {
          header("location:event_join.php?q=".$_POST['questionaire']."&id_info_event=".$_POST['id_info_event']."&id_role=".$_POST['id_role'].
          "&session_number=".$_POST['session_number']);
        }                                
}
if( !empty($_SESSION) )
{
?>
  <script type="text/javascript">
  //alert("Welcome to ILabU \n<?php echo $_SESSION['email'] ; ?>\n Now you can choose to join for one of our events!" );  
</script>
<?php
}
?>
    <?php echo $message; ?>
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
          <li>Events</li>
        </ul>
        <h2>EVENTS</h2>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
      </div>
    </div>
  </section>
  <!-- end post-wrapper-top -->
  <section class="section1">
 






                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">JOIN TO AN EVENT!</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="container">

                                  <!-- 
                                  <label id="paragraph">If you click on the "Hide" button, I will disappear.</label>
                                  <br/>
                                  <input type="radio" name="id_role" value="1" id="hide" > Hide
                                  <input type="radio" name="id_role" value="2" id="show" > Show      
                                  -->


                                      <form method="post" action="">                                                                                          
                                      <label>Please, select the event you want to join</label>
                                      <br/>
                                      <select name="id_info_event">
                                            <option value="NA">                                              
                                            -- Select --
                                            </option>
                                            <option value="6">
                                            Practice Session (01/11/2019)
                                            </option>
                                            <option value="1">                                              
                                            1. The Spark Between Us (01/30/2020)
                                            </option>
                                            <option value="2">                                              
                                            2. Getting closer (02/30/2020)
                                            </option>
                                            <option value="3">
                                            3. Let's talk about life (03/30/2020)
                                            </option>
                                            <option value="4">
                                            4. Who pays the bill? (04/30/2020)
                                            </option>
                                            <option value="5">
                                            5. What's next? (05/30/2020)
                                            </option>
                                            
                                      </select>
                                      <br/>
                                      <label>Join as a Scientist? </label>   
                                      <br/>         
                                      <input type="hidden" name="questionaire" value="Registration">                                                                                                              
                                      <input type="radio" name="id_role" value="1" id="opt_no" >No
                                      <input type="radio" name="id_role" value="2" id="opt_yes">Yes                                                                                
                                        <br/>
                                              <div id="div1">  
                                                <label>Please, select the session you want to join</label>
                                                    <br/>
                                                    <!-- 
                                                    <input type="radio" value="1" name="public_session">Session 1 (17:30)
                                                    <input type="radio" value="2" name="public_session">Session 2 (20:30)                                                    
                                                    -->
                                                    <input type="radio" value="1" name="session_number">Session 1 (17:30)
                                                    <input type="radio" value="2" name="session_number">Session 2 (20:30)
                                              </div>
                                              <div id="div2">  
                                              <label>Please, select the session you want to join</label>
                                                    <br/>
                                                    <!--
                                                      <input type="radio" value="1" name="scientist_session">Session 1 (17:30) *only one option                                                      
                                                    -->
                                                    <input type="radio" value="1" name="session_number">Session 1 (17:30) *only one option
                                              </div>
                                              <br/>
                                        <button type="submit" name="submit" class="button"> Submit </button>
                                      </form>
                                  </div>
                              </div>                              
                              <div class="modal-footer">                              
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>                      
                        <div class="general-title text-center">
                          <h3>Join to our events!</h3>                          
                        </div>                             
    <div class="container clearfix">
                        <center>
                          <p>
                          We have designed our I Lab U speed dating events, so they mimic the steps of a good first date,  
                          that inspired relevant interesting scientific topics. In each of our events you will get the unique 
                           chance to meet real-life scientists face-to-face and ask them all of your burning questions about their science! 
                            Whether you are interested in learning more about climate change, philosophy, pediatrics or engineering, 
                            we have a topic for you! Learn more about our events below.                        
                          </p>          
                        </center>

      <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
      
        <div class="col-lg-4 col-md-4 col-sm-12">



          <div class="dmbox">
            <div class="service-icon">
              <div class="dm-icon-effect-1" data-effect="slide-bottom">
                    <a href="#container-show-event" class="event1">
                        <img src="img/ilabu/events/spark.jpg" height="50%" width="50%" />
                    </a>
              </div>
            </div>
            <h4>Spark between us</h4>
            <p>For discussions in topics like <br> electrical engineering, neurobiology, robotics, behavioral and computer sciences.</p>
            <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Join</button>';}?>            
          </div>                            
        </div>             
        <!-- end dmbox -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="dmbox">
            <div class="service-icon">
              <div class="dm-icon-effect-1" data-effect="slide-bottom">
                <a href="#container-show-event" class="event2" >
                <img src="img/ilabu/events/closer.jpg" height="50%" width="50%" />
                </a>
              </div>
            </div>
            <h4>Getting closer</h4>
            <p>For discussions in topics like <br> virology, microbiology, transport, astronomy, nanotechnology, and psychology.</p>
            <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Join</button>';}?>            
          </div>
        </div>
        <!-- end dmbox -->


        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="dmbox">
            <div class="service-icon">
              <div class="dm-icon-effect-1" data-effect="slide-bottom">
                <a href="#container-show-event" class="event3">
                <img src="img/ilabu/events/life.jpg" height="50%" width="50%" />
                </a>
              </div>
            </div>
            <h4>Let's talk about life</h4>
            <p>For discussions in topics like <br> medicine, biomedical sciences, sociology, artificial intelligence, and philosophy.</p>
            <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Join</button>';}?>            
          </div>
        </div>    


        <!--<div class="col-lg-4 col-md-4 col-sm-12">-->
        <div class="col-lg-4 col-md-4 col-sm-12">        
            <div class="dmbox">
              <div class="service-icon">
                <div class="dm-icon-effect-1" data-effect="slide-bottom">
                  <a href="#container-show-event" class="event4" >
                  <img src="img/ilabu/events/bill.jpg" height="50%" width="50%" />
                  </a>
                </div>
              </div>
              <h4>Who pays the bill?</h4>
              <p>For discussions in topics like <br> finances, management, logistics, health economy, and psychology.</p>
              <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Join</button>';}?>            
            </div>
        </div>


        <!--<div class="col-lg-4 col-md-4 col-sm-12">-->    
        <div class="col-lg-4 col-md-4 col-sm-12">
        
              <div class="dmbox">
                <div class="service-icon">
                  <div class="dm-icon-effect-1" data-effect="slide-bottom">
                    <a href="#container-show-event" class="event5">
                    <img src="img/ilabu/events/next.jpg" height="50%" width="50%" />
                    </a>
                  </div>
                </div>
                <h4>What's next?</h4>                
                <p>For discussions in topics like <br> environment, architecture, urban planning, global warming, green energy, and pediatrics.</p>                <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Join</button>';}?>            
              </div>
        </div>

        <!-- end dmbox -->

        <div class="clearfix"></div>
        <div class="divider" id="container-show-event"></div>
          

      <section class="section1">
        <div class="container" >
            
            <div class="show-event1" style="display:none;">
              <h3>Spark Between Us</h3>
              <p>
              What causes the initial spark between two people? Is it a smile your date gives you when you meet? The first accidental touch? Or something more scientific, like a combination of chemicals flooding in your brain because of your compatible pheromones? Let’s see what the explanation for this wonderful sensation might be! In this event you may meet from neuroscientists working on the electrical synapses in our brain, to behavioral scientists shedding light on how human emotions work, or to electrical engineers discussing actual sparks! 
   <p>
     If this sparks your interest, please register and join us 
     <a href="register.php"> here </a>
   <p>.
              </p>
              <div class="general-title text-center">
                    <center>                    
                    <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">JOIN TO AN EVENT!</button>';}?>            
                    </center>
                </div>                
            </div>
            <div class="show-event2" style="display:none;">
              <h3>Getting Closer</h3>
              <p>
              The spark is in, the drinks are on the table. Time to get closer. What are the first things you exchange? A smile, touch, or… some bacteria? Yikes! Probably all three. So, let’s get comfortable with talking about being close. Virologists and microbiologists will be there to explain to you how unique every touch is, but also astronomers how we can cross the universe and move the stars! But if you are more practical, maybe a urban transport expert will tell you how the city infrastructure works to get us closer, and a psychologist will be there to help you find out how you can get closer to someone’s heart and brain. 
              </p>              
              <p>
              If you want to get closer, please register and join us 
              <a href="register.php"> here </a>
            <p>.
              <div class="general-title text-center">
                    <center>
                    <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">JOIN TO AN EVENT!</button>';}?>            
                    </center>
                </div>                
            </div>
            <div class="show-event3" style="display:none;">
              <h3>Let's talk about life</h3>
              <p>
              Time to dig deeper and discuss all the things that make us human! Will you talk over koetjes en kalfjes like the Dutch say or share your life lesson on a date? Whatever you decide, we got you. Join us for this event to ask a doctor or a biomedical researcher about how our life choices change our health. Did you ever wonder why our bodies work the way they do? Or perhaps you are interested to explore the life of mind and talk to psychologists or philosophers? In case you are also keen to learn about the life beyond… life, experts in artificial intelligence may help you out.
              </p>
              <p>
              If you want to talk about life, please register and join us 
              <a href="register.php"> here </a>
              <p>.

              <div class="general-title text-center">
                    <center>
                    <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">JOIN THIS EVENT!</button>';}?>            
                    </center>
                </div>                
            </div>
            <div class="show-event4" style="display:none;">
              <h3>Who pays the bill?</h3>
              <p>
              The end of the date is near. Now it’s a time to settle the bill. Are you going Dutch and share the bill? Or maybe you are more traditional and would like to treat your partner? Whatever you choose, talking about money is an important aspect to any new relationship. Experts from finance, management, economics, and logistics can help you settle down your finances and decide who should pay for that delicious beer you just had. Luckily on this event, it is on us! But maybe we need to show you the way into your financing decisions and give you the chance to consult a health economist, so you can make the wisest choice.
              </p>
              <p>
              If you want to save money, please register and join us 
              <a href="register.php"> here </a>
              <p>.

              <div class="general-title text-center">
                    <center>
                    <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">JOIN THIS EVENT!</button>';}?>            
                    </center>
                </div>                
            </div>
            
            <div class="show-event5" style="display:none;">
              <h3>What's next?</h3>
              <p>
              While you are anxiously waiting for your date to call you back after this amazing time you had together, it might be time to think about the next step. Let’s figure it out together. Are you going to have another date, a child together, or move to a new city? Do you want to see what goes into building your dream house? Ask an architect. Do you want to know how cities will evolve in the future? Ask an urban planner. Are you worried about the future of earth, come and discuss your worries with environmental scientists and global warming experts. And if you already have your children’s names picked out, maybe talk to a pediatrician instead.
              </p>
              <p>
              If you wonder about the future, please register and join us 
              <a href="register.php"> here </a>
              <p>.

                  <div class="general-title text-center">
                    <center>
                    <?php if( !empty($_SESSION["email"]) ){echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">JOIN THIS EVENT!</button>';}?>            
                    </center>
                </div>                
            </div>
            
  
      </div>   
    </section>


        <div class="general-title text-center">
          <h3>Calendar for Events</h3>
          <p>Pick your favourite!</p>
          <hr>
        </div>

        <div class="clearfix"></div>
        <div class="divider"></div>


        <div id="bbpress-forums">

                <table class="table">
                  <thead class="thead-dark">
                    <tr>      
                      <th scope="col">Event</th>
                      <th scope="col">Date</th>
                      <th scope="col">Venue</th>
                      <th scope="col">City</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">The Spark between us</th>      
                      <td>24.01.2020</td>
                      <td>De Bibliotek</td>
                      <td>Rotterdam</td>
                    </tr>
                    <tr>
                      <th scope="row">Getting closer</th>      
                      <td>28.02.2020</td>
                      <td>Library TU Delft</td>
                      <td>Delft</td>
                    </tr>
                    <tr>
                      <th scope="row">Let's talk about life</th>
                      <td>03.04.2020</td>
                      <td>Erasmus MC</td>
                      <td>Rotterdam</td>
                    </tr>
                    <tr>
                      <th scope="row">Who pays the bill?</th>
                      <td>24.04.2020</td>
                      <td>Erasmus Pavijloen</td>
                      <td>Rotterdam</td>
                    </tr>
                    <tr>
                      <th scope="row">What's next?</th>
                      <td>29.05.2020</td>
                      <td>To be confirmed</td>
                      <td>Delft</td>
                    </tr>    
                  </tbody>
                </table>

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
  <script>
  $(document).ready(function(){  
    
          $("#opt_no").change(function(){
            $("#div1").show();
            $("#div2").hide();
            console.log('Public has been selected!');

          });
          $("#opt_yes").change(function(){
            $("#div2").show();
            $("#div1").hide();
            console.log('Scientist has been selected!');
          });


          $("#div1").hide();
          $("#div2").hide();

  var lagtime = 500;

  $(".event1").click(function(){
    $(".show-event2").hide();
    $(".show-event3").hide();
    $(".show-event4").hide();
    $(".show-event5").hide();
    $(".show-event6").hide();        
    $(".show-event1").show(lagtime);
  });

  $(".event2").click(function(){
    $(".show-event1").hide();
    $(".show-event3").hide();
    $(".show-event4").hide();
    $(".show-event5").hide();
    $(".show-event6").hide();    
    $(".show-event2").show(lagtime);
  });

  $(".event3").click(function(){
    $(".show-event1").hide();
    $(".show-event2").hide();
    $(".show-event4").hide();
    $(".show-event5").hide();
    $(".show-event6").hide();    
    $(".show-event3").show(lagtime);
  });

  $(".event4").click(function(){
    $(".show-event1").hide();
    $(".show-event2").hide();
    $(".show-event3").hide();
    $(".show-event5").hide();
    $(".show-event6").hide();    
    $(".show-event4").show(lagtime);
  });

  $(".event5").click(function(){
    $(".show-event1").hide();
    $(".show-event2").hide();
    $(".show-event3").hide();
    $(".show-event4").hide();
    $(".show-event6").hide();    
    $(".show-event5").show(lagtime);
  });

  $(".event6").click(function(){
    $(".show-event1").hide();
    $(".show-event2").hide();
    $(".show-event3").hide();
    $(".show-event4").hide();
    $(".show-event5").hide();    
    $(".show-event6").show(lagtime);
  });

  });                          
  
  </script>
</body>
</html>
