<?php

class ActionLog
{

    public static function hasBlock($username, $type)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".action_spam_protection WHERE (`user_name` = ? OR `user_ip` = ?)
        AND `type` = ? AND `date_blocked_until` > ?", array($username, $_SERVER["REMOTE_ADDR"], $type, date('Y-m-d H:i:s')));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function unblockTime($username, $type)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".action_spam_protection WHERE (`user_name` = ? OR `user_ip` = ?)
        AND `type` = ? AND `date_blocked_until` > ?", array($username, $_SERVER["REMOTE_ADDR"], $type, date('Y-m-d H:i:s')));
        return Core::makeNiceDate($query["date_blocked_until"]);
    }

    public static function blockTime($username, $type)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".action_spam_protection WHERE (`user_name` = ? OR `user_ip` = ?)
        AND `type` = ? AND `date_blocked_until` > ?", array($username, $_SERVER["REMOTE_ADDR"], $type, date('Y-m-d H:i:s')));
        return Core::makeNiceDate($query["date_issued"]);
    }

    public static function penalty()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'action_spam_penalty'");
        return $query["value"];
    }

    public static function write($username, $type)
    {
        global $dbname;
        $penalty = new DateTime(date("Y-m-d H:i:s"));
        $penalty->add(new DateInterval('PT'.self::penalty().'M'));
        $datePenalty = $penalty->format('Y-m-d H:i:s');
        $query = Database::queryAlone("INSERT INTO ".$dbname.".action_spam_protection
        (`user_name`, `user_ip`, `type`, `date_issued`, `date_blocked_until`) VALUES
        (?, ?, ?, ?, ?)", array($username, $_SERVER["REMOTE_ADDR"], $type, date('Y-m-d H:i:s'), $datePenalty));
    }

}

?>