<?php

    // detect browser for mobile

    $username = ('PMS');    // change to a different source
    $host = "localhost";    // would this be the same on diamond.sat?
    $un = "cctclass";       // likely different on diamond.sat
    $pw = 'cct1232011';     // likely different on diamond.sat
    $db = "pmdb";           // might be different on diamond.sat    

    // PROFILE
    $connection=mysqli_connect($host,$un,$pw,$db) or die ('Unable to connect!');
    $query=('SELECT * FROM profile WHERE profile.username = \''.$username.'\'');
    $result=mysqli_query($connection,$query) or die ("Error in query: $query. ".mysqli_error());
    global $idprofile;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $namelast=$row['namelast'];
            $namefirst=$row['namefirst'];
            $contactmessage=$row['contactmessage'];
            $contactemail=$row['contactemail'];
            $urllinkedin=$row['urllinkedin'];
            $fileresume=$row['fileresume'];
            $idprofile=$row['idprofile'];
        }
    }
    else
    {
        // PROFILE DEFAULTS
        $namelast = ('Candidate');
        $namefirst = ('Default');
        $namefull = ($namefirst.'&nbsp;'.$namelast);
        $contactmessage = ('A sentence or two on the Contact Me form.');
        $contactemail = ('donotreply@iit.edu');
        $urllinkedin = ('http://www.linkedin.com/');
        $fileresume = ('');
        $idprofile=0;
    }        
    // PROFILE COVERAGE
    if($namefirst==''){
        $namefirst='';
    }else{
        $namefirst.='&nbsp;';
    }
    if($namelast==''){
        $namelast="[Lastname]";
    }
    $namefull=$namefirst.$namelast;
    if($contactmessage==''){
        $contactmessage='If you have any questions or comments about this porfolio, feel free to submit them in this form.';
    }
    $contactme='<a href="#" class="contactme"></a>';
    if($contactemail==''){
        $contactme='';
    }
    $linkedin='<a target="_blank" href="'.$urllinkedin.'"><img src="cms/imgs/LinkedIn_Logo16px.png"/></a>';
    if($urllinkedin==''){
        $linkedin='';
    }
    $resume='<a target="_blank" href="cms/docs/'.$fileresume.'">resume</a>';
    if($fileresume==''){
        $resume='';
    }
    
    // PROJECT
    readProjects($host, $un, $pw, $db, $idprofile);
    function readProjects($host,$un,$pw,$db, $idprofile){
        $connection=mysqli_connect($host,$un,$pw,$db) or die ('Unable to connect!');
        $query=('SELECT * FROM project WHERE project.idprofile = '.$idprofile.' ORDER BY project.idproject DESC');
        $result=mysqli_query($connection,$query) or die ("Error in query: $query. ".mysqli_error());
        global $projects;
        $screen=0;       
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                $screen = $screen+1;
                $projecttitle=$row['title'];
                if($projecttitle=='' || $projecttitle==null){
                    $projecttitle='[Title of Project]';                    
                }
                $projectdescription=$row['description'];
                if($projectdescription=='' || $projectdescription==null){
                    $projectdescription='[Write a brief single paragraph describing the Project at hand.
                        For example, you might include some basic information
                        about how your project was done
                        and/or the client for whom you created it.]';                    
                }
                $urlwork=$row['ulrwork'];
                $visitwork='<a target="_blank" href="'.$urlwork.'">Visit Work</a>';
                if($urlwork=='' || $urlwork==null){
                    $visitwork='';
                }
                $imgleft=$row['imgleft'];
                if($imgleft=='' || $imgleft==null){
                    $imgleft='1_big.jpg';                    
                }
                $altleft=$row['altleft'];
                if($altleft==''){$altleft='Main Project Image';}
                $imgrighttop=$row['imgrighttop'];
                if($imgrighttop=='' || $imgrighttop==null){
                    $imgrighttop='1a_small.jpg';                    
                    }
                $altrighttop=$row['altrighttop'];
                if($altrighttop==''){$altrighttop='Project Image Top';}
                $imgrightbottom=$row['imgrightbottom'];
                if($imgrightbottom=='' || $imgrightbottom==null){
                    $imgrightbottom='1b_small.jpg';                    
                    }
                $altrightbottom=$row['altrightbottom'];
                if($altrightbottom==''){$altrightbottom='Project Image Top';}
                // PROJECT COVERAGE
                // THE PROJECT STRING
                $projects.='<div class="box">
                                <div class="top">
                                    <div class="left">
                                        <img src="cms/imgs/'.$imgleft.'" alt="'.$altleft.'" title="'.$altleft.'">
                                    </div>
                                    <div class="right">
                                        <div class="top">
                                            <img src="cms/imgs/'.$imgrighttop.'" alt="'.$altrighttop.'" title="'.$altrighttop.'">
                                        </div>
                                        <div class="bottom">
                                            <img src="cms/imgs/'.$imgrightbottom.'" alt="'.$altrightbottom.'" title="'.$altrightbottom.'">
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <h2>Screen '.$screen.'<span>'.$projecttitle.'</span></h2>
                                    <p>'.$projectdescription.'</p>'
                                    .$visitwork.
                                '</div>
                            </div>';
            }
        }
            else
            {
                // PROJECT DEFAULTS
                $visitwork='<a target="_blank" href="http://lake14.rice.iit.edu/hartmann/PMS/index.php">Visit Work</a>';
                $projects='<div class="box">
                                <div class="top">
                                    <div class="left">
                                        <img src="cms/imgs/1_big.jpg" alt="Main Project Image">
                                    </div>
                                    <div class="right">
                                        <div class="top">
                                            <img src="cms/imgs/1a_small.jpg" alt="Project Image Top">
                                        </div>
                                        <div class="bottom">
                                            <img src="cms/imgs/1b_small.jpg" alt="Project Image Bottom">
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <h2>Screen 0<span>[Title of Project]</span></h2>
                                    <p>[Write a brief single paragraph describing the Project at hand.
        For example, you might include some basic information
        about how your project was done
        and/or the client for whom you created it.]</p>'
                                    .$visitwork.
                                '</div>
                            </div>';
            }            
    }    
   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title><?=$namefull ?> Portfolio</title>
        <link rel="stylesheet" media="screen" href="style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script src="js/extrajs.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <!-- omit from cms version -->
        <div id="contactback">
            <div id="contacttop">
                <a href="#" class="exit"></a>
                <h2>CONTACT ME</h2>
                <p><?=$contactmessage ?></p>
                <form action="./contact.php" method="post" id="contactform">
                    <div class="line">
                        <div class="input_caption">Name</div>
                        <input class="input" type="text" name="name">
                    </div>
                    <div class="line">
                        <div class="input_caption">Email Address</div>
                        <input class="input" type="text" name="email">
                    </div>
                    <div class="line">
                        <div class="input_caption">Current Website</div>
                        <input class="input" type="text" name="website">
                    </div>
                    <div class="line">
                        <div class="input_caption">Message</div>
                        <textarea rows="3" cols="100" class="textarea" name="message"></textarea>
                    </div>
                    <div class="line">
                        <input type="submit" name="submit" value="Send" id="sendbutton">
                    </div>
		</form>
            </div>
        </div>
        <!-- end omit-->
        <div class="page">
            <!-- variations on header would be included in cms -->
            <div id="header">
                <div class="left">
                    <h1><a href="./index.html"><?=$namefirst ?><span><?=$namelast ?></span></a></h1>
                    <?=$linkedin ?>&nbsp;<?=$resume ?>
                </div>
                <div class="right">
                    <h2>WELCOME TO THE PORTFOLIO OF <?=$namefull ?></h2>
                </div>
            </div>
            <!-- in cms, replace portfoliowrap and contactme with tables and forms -->
            <div id="portfoliowrap">
                <div id="portfolio">
                    <?=$projects ?>
                </div>
                <a href="#" class="portfolioarrow"></a>
            </div>
            <?=$contactme ?>
        </div>
    </body>
</html>