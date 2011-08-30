<?php
    // detect browser for mobile
    include('../portfolio/scripts/Mobile_Detect.php');
    $detect = new Mobile_Detect();
    if($detect->isMobile()){
        header('Location: mobiletest.php');
    }
    include('../portfolio/config/db.php');
    $filepath = dirname(__FILE__);
    $path_parts = pathinfo($filepath);
    $dirname = $path_parts['dirname'];
    $basename = $path_parts['basename'];
    $extension = $path_parts['extension'];
    $filename = $path_parts['filename'];    
    /*
     * Yes I want the username part of the filepath;
     * it's either that or we config a textfile for each portfolio.
     * Do I really want $basename and/or $filename for the $username?
     * What is the difference between them?
     */
    $username = ($basename);
    include('../portfolio/inc/profile.php');
    include('../portfolio/inc/project.php');
    include('../portfolio/inc/view.php');
?>