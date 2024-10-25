<?php

class PasswordRecovery
{

    public function combinationExists($username, $email)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE login = ? AND email = ?", array($username, $email));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function requestExists($username)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".password_recovery WHERE user_name = ? AND date_expired > ?",
            array($username, date('Y-m-d H:i:s')));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function deleteToken($user, $token)
    {
        global $dbname;
        $query = Database::queryAlone("DELETE FROM ".$dbname.".password_recovery WHERE user_name = ? AND token = ?",
            array($user, $token));
    }

    public function log($user, $new_pw, $token)
    {
        $dbaccount = Core::getAccountDatabase();
        $old_pw = Database::queryAlone("SELECT `password` FROM ".$dbaccount.".account WHERE login = ?", array($user));

        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".log_password_recovery
        (user_name, user_ip, old_pw, new_pw, used_token, `date`) VALUES (?, ?, ?, ?, ?, ?)",
            array($user, $_SERVER["REMOTE_ADDR"], $old_pw["password"], User::mysqlPassword($new_pw), $token, date('Y-m-d H:i:s')));
    }

    public function isValidToken($username, $token)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".password_recovery WHERE user_name = ? AND token = ? AND date_expired > ?",
            array($username,$token, date('Y-m-d H:i:s')));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function sendEmail($user, $email, $token)
    {
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
        $mail->AddAddress($email, $user);
        $mail->SetFrom(Core::getMailFrom(), Core::getMailFromName());
        $mail->Subject = Core::getSiteTitle()." - ".Language::getTranslation("fpEmailTitle");
        $mail->Body = Language::getTranslation("fpEmailText")."<b>
        <a href='".Links::getUrl("lost-pw")."/user/".$user."/token/".$token."'>".Links::getUrl("lost-pw")."/user/".$user."/token/".$token."</a></b>".
            Language::getTranslation("emailFooter");

        try{
            $mail->Send();
        } catch(Exception $e){
            //Something went bad
            echo "Fail - " . $mail->ErrorInfo;
        }

    }

    public function saveRequest($username, $token)
    {
        $date = new DateTime(date('Y-m-d H:i:s'));
        $date->add(new DateInterval('P1D'));
        $date_exired = $date->format('Y-m-d H:i:s');

        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".password_recovery
        (user_name, user_ip, token, date_created, date_expired) VALUES (?, ?, ?, ?, ?)",
            array($username, $_SERVER["REMOTE_ADDR"], $token, date('Y-m-d H:i:s'), $date_exired));
    }



}

?>