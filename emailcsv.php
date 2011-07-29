<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    include_once('scripts/class.phpmailer.php');
    include('scripts/class.smtp.php'); // optional, gets called from within class.phpmailer.php if not already loaded
    // include('scripts/emailthis.php');
    $feedback=('');
    if (isset($_POST['submittedForm'])) {
       $csv=('data/mydata.csv');
       // check if file exists, then keep going (yet to write this part)
       $accountname=$_POST['accountname'];
       $accountemail=$_POST['accountemail'];       
       $esubject=$_POST['emailsubject'];
       $ebody=$_POST['emailbody'];
       // open csv and loop through it
       $csv = fopen($csv, 'r');
       while (!feof($csv)) {
           $csvrecord = fgetcsv($csv, 1024);
           $useremail=$csvrecord[0];     // REQUIRED; if blank, skip to next record
           if ($useremail != null || $useremail != '' || strlen(trim($useremail)) != 0){
               $userfullname=$csvrecord[1];  // might not use at all if lastname,firstname -- unless...?
               $userstatus=$csvrecord[2];    // keyed to a dropdown selection on the form               
               // REPLACE THIS TEST...
               $feedback .= ('<p>FROM:<br />&nbsp;&nbsp;'.$accountname.'<br />&nbsp;&nbsp;'.$accountemail.'
                           <br />TO:<br />&nbsp;&nbsp;'.$userfullname.'<br />&nbsp;&nbsp;'.$useremail.'<br />&nbsp;&nbsp;Status: '.$userstatus.'
                                   <br />SUBJECT:<br />&nbsp;&nbsp;'.$esubject.'
                                       <br />BODY:<br />&nbsp;&nbsp;'.$ebody.'</p>');               
               // ...WITH ACTUAL EMAIL FUNCTION
               // emailthis($accountemail,$accountname,$useremail,$userfullname,$accountemail,$accountname,$esubject,$ebody);
                $mail = new PHPMailer();
                $mail->IsSMTP();               // set mailer to use SMTP
                $mail->Host = ('mail.iit.edu');  // specify main and backup server
                $mail->From = $accountemail;
                $mail->FromName = $accountname;
                $mail->AddAddress($useremail, $userfullname);
                $mail->AddReplyTo($accountemail, $accountname);
                $mail->WordWrap = 60;
                $mail->IsHTML(true);
                $mail->Subject = $esubject;
                $mail->Body = $ebody;
                if(!$mail->Send())  {
                    echo ('Message could not be sent.');
                    echo ('Mailer Error: '.$mail->ErrorInfo);
                    exit;
                } else {
                // OK
                }        
               
            }
        }
        fclose($csv);
    }
    else
    {
        $feedback = '<p>All fields are required.</p>';
    }

           
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Mass Email App</title>
        <link type="text/css" href="scripts/errors.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="scripts/jquery.form-validation-and-hints.js"></script>
    </head>
    <body>
    <?php echo "$feedback"; ?>
        <form method="post" action="emailcsv.php">
            <div class="row requiredRow field required error">
                <label for="accountname">Account Name</label>
                <input class="required verifyText error" name="accountname" type="text" title="Account Name is a required field" />
                <p class="iferror">Account Name is required</p>
            </div>
            <div class="row requiredRow field required error">
                <label for="accountemail">Account Email Address</label>
                <input class="required verifyText error" name="accountemail" type="text" title="Account Email is a required field" />
                <p class="iferror">Account Email is required</p>
            </div>
            <div class="row requiredRow field required error">
                <label for="emailsubject">Email Subject</label>
                <input class="required verifyText error" name="emailsubject" type="text" title="Email Subject is a required field" />
                <p class="iferror">Email Subject is required</p>
            </div>
            <div class="row requiredRow field required error">
                <label for="emailbody">Email Body</label>
                <textarea name="emailbody" rows="5" cols="51" title="Email Body is a required field"></textarea>
                <p class="iferror">Email Body is required</p>
            </div>
            <div class="row">
                <input type="submit" name="submittedForm" value="SEND EMAILS" />
            </div>
        </form>
    </body>
</html>