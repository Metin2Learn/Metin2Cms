<?php

class Login
{
    public $failedLoginPunish = 600; // 60 * 10 = 600 seconds / 10 minutes

    public function hashPassword($password)
    {
        return '*'.strtoupper(hash('sha1',pack('H*',hash('sha1', $password))));
    }

    public function failedLoginExists()
    {
        global $dbname;
        $attacker = $_SERVER["REMOTE_ADDR"];
        $query1 = Database::query("SELECT * FROM ".$dbname.".failed_login WHERE ip_address = ?", array($attacker));
        if($query1 > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function failedLoginInfo()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".failed_login WHERE ip_address = ? LIMIT 1", array($_SERVER["REMOTE_ADDR"]));
        return $query;
    }

    public function recordFailedLogin()
    {
        global $dbname;
        if(self::failedLoginExists())
        {
            Database::query("UPDATE ".$dbname.".failed_login SET count_attempts = count_attempts + 1 WHERE ip_address = ?", array($_SERVER["REMOTE_ADDR"]));
        } else {
            Database::query(
                "INSERT INTO ".$dbname.".failed_login (ip_address, first_attempt, count_attempts, date_issued)
                VALUES (?,?,1,?)", array($_SERVER["REMOTE_ADDR"], time(), date('Y-m-d H:i:s')));
        }
    }

    public function clearFailedLogin()
    {
        if(self::failedLoginExists())
        {
            global $dbname;
            Database::query("DELETE FROM ".$dbname.".failed_login WHERE ip_address = ?", array($_SERVER["REMOTE_ADDR"]));
        }
    }

    public function saveLastIP($username)
    {
        $accountDB = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$accountDB.".account SET `last_ip` = ? WHERE `login` = ?", array($_SERVER["REMOTE_ADDR"], $username));
        return $query;
    }

    public function enteredRightData($username, $password)
    {
        $dbname = Core::getAccountDatabase();
        $password = self::hashPassword($password);
        $query = Database::query("SELECT * FROM ".$dbname.".account WHERE `login` = ? AND `password` = ?", array($username, $password));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

}

?>