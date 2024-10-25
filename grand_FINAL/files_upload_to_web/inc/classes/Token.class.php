<?php

class Token
{

    public static function generate($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function delete($token)
    {
        global $dbname;
        $query = Database::queryAlone("DELETE FROM ".$dbname.".tokens WHERE token = ?", array($token));
    }

    public static function isCorrect($token, $type)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".tokens WHERE token = ? AND `type` = ? AND date_expire > ? AND user_name = ?",
            array($token, $type, date('Y-m-d H:i:s'), $_SESSION["username"]));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function record($token, $type)
    {
        global $dbname;
        $expire = new DateTime(date('Y-m-d H:i:s'));
        $expire->add(new DateInterval('PT120M'));
        $expireDate = $expire->format('Y-m-d H:i:s');
        $query = Database::queryAlone("INSERT INTO ".$dbname.".tokens (`user_name`, `user_ip`, `token`, `type`, `date_create`, `date_expire`)
        VALUES (?, ?, ?, ?, ?, ?)", array($_SESSION["username"], $_SERVER["REMOTE_ADDR"], $token, $type, date('Y-m-d H:i:s'), $expireDate));
    }

}

?>