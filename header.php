<?php
    $ssnurllinkedin=$this->session->userdata('urllinkedin');
    if(strlen(trim($ssnurllinkedin))==0){
        $ssnurllinkedin="No";
    }
    $ssnfileresume=$this->session->userdata('fileresume');
    if(strlen(trim($ssnfileresume))==0){
        $ssnfileresume="No";
    }
    $ssncontactemail=$this->session->userdata('contactemail');
    if(strlen(trim($ssncontactemail))==0){
        $ssncontactemail="No";
    }
?>
<header>
    <div class="left">
        <h1><a><?=$this->session->userdata('profilenamefirst'); ?><span><?=$this->session->userdata('profilenamelast'); ?></span></a></h1>
    </div>
    <div class="right">
        <ul class="ulistdisc">
            <li>LinkedIn:&nbsp;<?=$ssnurllinkedin ?></li>
            <li>Resume:&nbsp;<?=$ssnfileresume ?></li>
            <li>E-Mail (Contact Me):&nbsp;<?=$ssncontactemail ?></li>
        </ul>
    </div>
    <div class="navmsg">
        <p class="linkback">
        <?=anchor('profile/logout/', 'Log Out',array('class'=>'back')); ?> | <?=anchor('profile/profileupdate/', 'Update Your Profile',array('class'=>'update')); ?> | <?=anchor('profile/resumeupdate/', 'Update Your Resume',array('class'=>'update')); ?> | <?=$this->session->userdata('headermessage'); ?>
        </p>
    </div>
</header>
<div class="clear"></div>