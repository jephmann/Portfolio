
        <div class="content">
            <div id="header">
                <div class="left">
                    <h1><?=$profile->namefirst; ?><span><?=$profile->namelast; ?></span></h1>
                    <?=$profile->urllinkedin; ?>&nbsp;<?=$profile->fileresume; ?>
                </div>
                <div class="right">
                    <h2>WELCOME TO THE PORTFOLIO OF <?=$profile->namefirst.'&nbsp;'.$profile->namelast; ?></h2>
                </div>
            </div>
            <br /><?php echo $link_back; ?> | <?php echo $link_back2; ?>
        </div>
