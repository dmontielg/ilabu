<?php 
session_start() ;

$string = file_get_contents("img/gallery/spark.json");
if ($string === false) {
    // deal with error...
}

$json_a = json_decode($string, true);
if ($json_a === null) {
    // deal with error...
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("library/Component.php"); $component = new Component(); ?>
<?php $component->getHead(); ?>
    <body>
    <?php $component->getTopBar(); ?>
    <?php $component->getHeader(basename($_SERVER['PHP_SELF'])); ?>


            <section class="post-wrapper-top">
                <div class="container">                

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Photos</li>
                    </ul>
                    <h2>PHOTOS</h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        
                </div>
                </div>
            </section>

                <div class="general-title text-center">
                          <h4>Get a sneak peek to our recent events! </h4> 
                          <h3>The spark between us - 24.01.2020</h3>                         
                </div>                             
                    <div class="container clearfix">
                        <center>
                          <p>
                          Our first event this year was a success! We talked, learned and enjoyed all types of scientific.. sparks!<br/>
                          We would like to thank the Bibliotheek in Rotterdam for hosting us and of course all our participants for joining!<br/>
                          Photos: Helene Vidaki                        
                          </p>          
                        </center>                
                </div>
                <!-- end post-wrapper-top -->
            <section class="gallery-section">
                    <div class="col-lg-12 col-md-12 col-sm-24"> 
                                    <div class="home">
                                        <div class="demo-gallery">
                                            <ul id="lightgallery" class="list-unstyled row">
                                                <?php
                                                    /*
                                                    $directory = "img/gallery/spark_original/";
                                                    if (!is_dir($directory)) { exit('Invalid diretory path'); }                                       
                                                    $files = array();
                                                    foreach (scandir($directory) as $file) {if ($file !== '.' && $file !== '..') { $files[] = $file;}}
                                                    #foreach ($files as $key => $value) {}
                                                    */

                                                $folderName     = $json_a["folderName"];
                                                $galleryName    = $json_a["galleryName"];
                                                $date           = $json_a["date"];
                                                                                      
                                                foreach ($json_a["images"] as $img)
                                                {    
                                                    $title          = $img["title"];
                                                    $description    = $img["description"];
                                                    $img_375        = $img["img_375"];
                                                    $img_480        = $img["img_480"];
                                                    $img_160        = $img["img_1600"];
                                                    $thumbnail      = $img["thumbnail"];                                                                                                                                                                                                                                        
                                                ?>
                                                        <li class="col-xs-6 col-sm-4 col-md-3"                                                         
                                                            data-responsive="
                                                            <?php echo $folderName.$img_375; ?> 375 
                                                            <?php echo $folderName.$img_480; ?> 480
                                                            <?php echo $folderName.$img_160; ?> 1600"                                                         
                                                            data-src="<?php echo $folderName.$img_160; ?>"                                                             
                                                            data-sub-html="<h4>
                                                            <?php echo $title; ?>
                                                            </h4>
                                                            <p>
                                                            <?php echo $description; ?>
                                                            </p>">
                                                            <a href="">
                                                                <img class="img-responsive" src="<?php echo $folderName.$thumbnail; ?>">
                                                            </a>
                                                        </li>                                                       
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                        
                    </div>
            </section>
    </body>

    <script type="text/javascript">
      $(document).ready(function(){
          $('#lightgallery').lightGallery();
      });
      </script>
<?php $component->getFooter(); ?>
<?php $component->getJavascriptLibraries(); ?>

<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="js/lightgallery-all.min.js"></script>
<script src="js/jquery.mousewheel.min.js"></script>
</html>

