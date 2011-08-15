<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    include_once('scripts/class.phpmailer.php');
    include('scripts/class.smtp.php');
    
    $get_nf = trim($_GET['nf']);    
    $get_nl = trim($_GET['nl']);
    $get_name = ($get_nf.' '.$get_nl);    
    $get_email = trim($_GET['em']);
    $ecount=0;
    $estring=('');
    $post_name = trim($_POST['name']);
    if(strlen($post_name)==0){
        $ecount++;
        $estring.=('<br />Your Name');
    }
    $post_email = trim($_POST['email']);
    if(strlen($post_email)==0){
        $ecount++;
        $estring.=('<br />Your E-Mail Address');
    }
    $post_message = trim($_POST['message']);
    if(strlen($post_message)==0){
        $ecount++;
        $estring.=('<br />Your Message');
    }
    
    if($ecount!=0){
        $estring=('Please go back and enter the following:'.$estring);
        $estring=('<h3 style="color:red;">'.$estring.'</h3>');
    }else{
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = ('mail.iit.edu');
        $mail->From = $post_email;
        $mail->FromName = $post_name;
        $mail->AddAddress($get_email, $get_name);
        $mail->AddReplyTo($post_email, $post_name);
        $mail->WordWrap = 60;
        $mail->IsHTML(true);
        $mail->Subject = 'Portfolio Message';
        $mail->Body = $post_message;
        if(!$mail->Send()) {
            echo ('<script>alert("Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'")</script>');
            exit;
        }else{
            echo ('<script>alert("MESSAGE SENT!")</script>');
            echo ('<script>window.location = "index.php"</script>');
        }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title><?=$get_name ?> Portfolio</title>
        <link rel="stylesheet" media="screen" href="style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script src="js/extrajs.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div class="page">
            <div id="header">
                <div class="left">
                    <h1><a href="./index.html"><?=$get_nf ?><span><?=$get_nl ?></span></a></h1>
                </div>
                <div class="right">
                    <h2>WELCOME TO THE PORTFOLIO OF <?=$get_name ?></h2>
                </div>
            </div>
            <div id="portfoliowrap">
                <div id="portfolio">
                    <?=$estring ?>
                </div>
            </div>
        </div>
    </body>
</html>
