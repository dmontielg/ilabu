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
<br><br>
  <center>
            <h1>Speed Date a Scientist</h1>      
        </center>
  <section id="intro">  
    <div class="container">    
        <div class ="container">        
            <img src="img/ilabu/banner.png" alt="banner-ilabu" />
        </div>
    </div>
  </section>

  <section class="section1">
    <div class="container" >
    <center>
    <p style=""><strong>Because everybody is looking for someone to... lab!</strong> </p>      
    </center>
      <br/><br/>
      <p>          
      Have you ever wondered what scientists actually do? Do they just run around in their white coats, mumbling incomprehensible words, and mixing random chemicals? Or are they locked in a room behind stacks of papers pulling their hair out coming up with the next Frankenstein’s monster? Do astronomers sit all day long behind a computer working on complicated algorithms that will allow us to observe far away galaxies? Are economists real wolves of Wall Street? If you want to find out what actual scientists look like, you are in the right place.
      </p>
      <p>
      Or maybe, you are a scientist and you have always wondered why the average Julia or Lucas do not know what is happening in science or do not understand much of what you do? When was the last time you had the chance to meet with the public and talk to them about your research? This is why we made I Lab U. Come gain science communication experience!
      </p>
      <p>
      We created the I Lab U platform so people can meet in an informal setting, kind of like ‘speed-dating’, and talk about what their views on science are. Our speed dates are not about romance but about connecting people. You will get paired with people (scientists or public) and have five minutes to… just talk about science. What exactly you talk about is up to you. Do you want to talk about current research? Do you want to see the public’s opinion on your scientific topic? Do you have a burning question on a topic? Or maybe you have no idea why research is important. You are free to ask anything you want and get straight to the point.  
      </p>
      <p>
      All our events are completely free, and we also provide you with drinks and snacks. The only thing we need in return is an open mind and your answers to a few questions that we have for you. We will use your answers to better understand how we can help communication between scientists and the public, but also how to improve our next events. So, in a way we are all scientists for a night!
      </p>
      <center>
      <br><br>
      <h3><a href="register.php">Register here </a>and join our events! </h3>
      <br><br>      
      </center>
      
    </div>    
  </section>
<!-- Content Ends hhere -->

  <?php $component->getFooter(); ?>
  <?php $component->getJavascriptLibraries(); ?>
  <div class="dmtop">Scroll to Top</div>
</body>
</html>
