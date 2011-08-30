<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title><?=$namefull ?> Portfolio</title>
        <link rel="stylesheet" media="screen" href="../portfolio/style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script src="../portfolio/js/extrajs.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div id="contactback">
            <div id="contacttop">
                <a href="#" class="exit"></a>
                <h2>CONTACT ME</h2>
                <p><?=$contactmessage ?></p>
                <form action="../portfolio/contact.php?nf=<?=$namefirst ?>&nl=<?=$namelast ?>&em=<?=$contactemail ?>&un=<?=$username ?>" method="post" id="contactform">
                    <div class="line">
                        <div class="input_caption">Name</div>
                        <input class="input" type="text" name="name">
                    </div>
                    <div class="line">
                        <div class="input_caption">Email Address</div>
                        <input class="input" type="text" name="email">
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
        <div class="page">
            <div id="header">
                <div class="left">
                    <h1><a href="./index.php"><?=$namefirst ?><span><?=$namelast ?></span></a></h1>
                    <?=$linkedin ?>&nbsp;<?=$resume ?>
                </div>
                <div class="right">
                    <h2>WELCOME TO THE PORTFOLIO OF <?=$namefull ?></h2>
                </div>
            </div>
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