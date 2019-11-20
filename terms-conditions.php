<?php
  session_start();

  #echo date("Y-m-d H:i:s");
  #echo "<br/>";
  
  
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("library/Component.php"); $component = new Component(); ?>
<?php $component->getHead(); ?>
<body>
<?php $component->getTopBar(); ?>
<?php $component->getHeader(basename($_SERVER['PHP_SELF'])); ?>

<!-- Content Starts here -->
  
  <section class="section1">
    <div class="container" >      
      
      <h2> I Lab U Privacy Policy </h2>
      <br/>
      <p> <strong> 
        This privacy policy will explain how I Lab U uses the personal data we collect from you when you use our website. Topics:
      </strong> <p>
    <ol>
      <li>What data do we collect?</li>
      <li>How do we collect your data?</li>
      <li>How will we use your data?</li>
      <li>How do we store your data?</li>
      <li>Marketing</li>
      <li>What are your data protection rights?</li>
      <li>Privacy policies of other websites</li>
      <li>Changes to our privacy policy</li>
      <li>How to contact us</li>
      <li>How to contact the appropriate authorities</li>
    <ol>
    <p> <strong> What data do we collect? I Lab U collects the following data:</strong> <p>

  <ul>
    <li>Email address</li>
    <li>Questionnaire answers on some demographics (voluntary) and science interests (compulsory)</li>
  <ul>
  <p> <strong> How do we collect your data? You directly provide I Lab U with most of the data we collect. We collect data and process data when you:</p> </strong>
<ul>
    <li>Register online</li>
    <li>Voluntarily complete a customer survey or provide feedback on any of our message boards or via email.</li>
</ul>

<p> <strong> How will we use your data? I Lab U collects your data so that we can: </p> </strong>

<ol>
    <li>Invite you to our events</li>
    <li>Produce scientific research based on the data you provided</li>
    <li>Email you our newsletter</li>
</ol>

<p> <strong> How do we store your data? </p> </strong> 
<p> I Lab U securely stores your data on a Erasmus MC secured server</p>
<p>I Lab U will keep your personal data for 4 years or until publication. Once this time period has expired, we will delete your data.</p>

<h4>Marketing</h4>
<p>I Lab U would like to send you information in form of invites and newsletter if you subscribe to it. 
If you have agreed to receive marketing, you may always opt out at a later date.</p>
<p>You have the right at any time to stop I Lab U from contacting you for marketing purposes.</p>

<p>What are your data protection rights?
I Lab U would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:
The right to access – You have the right to request I Lab U for copies of your personal data. 
The right to rectification – You have the right to request that I Lab U corrects any information you believe is inaccurate. You also have the right to request I Lab U to complete the information you believe is incomplete.
The right to erasure – You have the right to request that I Lab U erase your personal data, under certain conditions.
The right to restrict processing – You have the right to request that I Lab U restrict the processing of your personal data, under certain conditions.
The right to object to processing – You have the right to object to I Lab U’s processing of your personal data, under certain conditions.
The right to data portability – You have the right to request that I Lab U transfers the data that we have collected to another organization, or directly to you, under certain conditions.
</p>
<p>
If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us at our email: ilabu@erasmusmc.nl
Privacy policies of other websites
The I Lab U website contains links to other websites. Our privacy policy applies only to our website, so if you click on a link to another website, you should read their privacy policy.
Changes to our privacy policy
I Lab U keeps its privacy policy under regular review and places any updates on this web page. This privacy policy was last updated on 11 November 2019.
</p>

<h4>How to contact us</h4>
<p>If you have any questions about I Lab U’s privacy policy, the data we hold on you, or you would like to exercise one of your data protection rights, please do not hesitate to contact us.</p>

<p>Email us at: ilabu@erasmusmc.nl</p>

<h4>How to contact the appropriate authority</h4>
<p>Should you wish to report a complaint or if you feel that I Lab U has not addressed your concern in a satisfactory manner, you may contact the Information Dutch Data Protection Authority.</p>

<p>Postal address</p>
<p>Autoriteit Persoonsgegevens</p>
<p>PO Box 93374</p>
<p>2509 AJ DEN HAAG</p>

<p>Telephone</p>
<p>Telephone number: (+31) - (0)70 - 888 85 00</p>
<p>Fax: (+31) - (0)70 - 888 85 01  </p>

<br/>
<h1>ILabU</h1>
      
      
    </div>    
  </section>
<!-- Content Ends hhere -->

  <?php $component->getFooter(); ?>
  <?php $component->getJavascriptLibraries(); ?>
  <div class="dmtop">Scroll to Top</div>
</body>
</html>
