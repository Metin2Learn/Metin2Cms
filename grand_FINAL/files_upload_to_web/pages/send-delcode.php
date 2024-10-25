<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box">';
    echo '<h2><a href="'.Links::getUrl("account").'">'.Language::getTranslation("accountTitle").'</a> - <a href="'.Links::getUrl("account info").'">
    '.Language::getTranslation("accountInfoTitle").'</a> - '.Language::getTranslation("sendDCTitle").'</h2>';

    if(ActionLog::hasBlock($_SESSION["username"], "delete-code-email"))
    {
        echo Core::result(Language::getTranslation("sendDCHasBlock").ActionLog::unblockTime($_SESSION["username"], "delete-code-email"), 2);
    } else {
        //Send Email
        $mail = new PHPMailer();
        if(Core::usingSMTP()){
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = Core::getSMTPProtocol(); // sets the prefix to the servier
            $mail->Host = Core::getSMTPHost(); // sets GMAIL as the SMTP server
            $mail->Port = intval(Core::getSMTPPort()); // set the SMTP port for the GMAIL server
            $mail->Username = Core::getSMTPUser(); // GMAIL username
            $mail->Password = Core::getSMTPPassword(); // GMAIL password
        }
        $mail->isHTML(true);
        $mail->AddAddress(User::getUserEmail($_SESSION["username"]), $_SESSION["username"]);
        $mail->SetFrom(Core::getMailFrom(), Core::getMailFromName());
        $mail->Subject = Core::getSiteTitle()." - ".Language::getTranslation("sendDCEmailTitle");
        $mail->Body = Language::getTranslation("sendDCEmailText")."<b>".User::getDeleteCode($_SESSION["username"])."</b>".
        Language::getTranslation("emailFooter");

        try{
            $mail->Send();
        } catch(Exception $e){
            //Something went bad
            echo "Fail - " . $mail->ErrorInfo;
        }

        ActionLog::write($_SESSION["username"], "delete-code-email");
        echo Core::result(Language::getTranslation("sendDCSuccess"), 1);
    }


    echo '</div>';
}

?>