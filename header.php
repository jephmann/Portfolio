
<div class="content">
    <div id="header">
        <div class="left">
            <h1><?=$this->session->userdata('profilenamefirst'); ?><span><?=$this->session->userdata('profilenamelast'); ?></span></h1>
            <?=$this->session->userdata('urllinkedin'); ?>&nbsp;<?=$this->session->userdata('fileresume'); ?>&nbsp;<?=$this->session->userdata('contactemail'); ?>
        </div>
        <div class="right">
            <h2>WELCOME TO THE PORTFOLIO OF <?=$this->session->userdata('profilenamefirst').'&nbsp;'.$this->session->userdata('profilenamelast'); ?></h2>
        </div>
    </div>
    <br /><?=anchor('profile/profileupdate/', 'Update Your Profile',array('class'=>'update')); ?> | <?=anchor('profile/resumeupdate/', 'Update Your Resume',array('class'=>'update')); ?>
</div>
