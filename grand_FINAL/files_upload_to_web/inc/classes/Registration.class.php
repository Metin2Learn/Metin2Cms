<?php

class Registration
{

    public function isEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'register_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function getUsernameMin()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_nick_min'");
        return $query["value"];
    }

    public static function needToContainNumber()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_pw_num'");
        return $query["value"] == 1 ? true : false;
    }

    public static function getUsernameMax()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_nick_max'");
        return $query["value"];
    }

    public static function getPasswordMin()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_pw_min'");
        return $query["value"];
    }

    public static function getPasswordMax()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_pw_max'");
        return $query["value"];
    }

    public static function weakPasswordListEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_weak_passwords'");
        return $query["value"] == 1 ? true : false;
    }

    public static function getWeakPasswords()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_disabled_passwords'");
        return $query["value"];
    }

    public static function isWeakPassword($pw)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_disabled_passwords'");
        $disabled = array($query["value"]);
        /*
         * $weak = array(
            "1234", "12345", "123456", "1234567", "12345678", "123456789", "qwertz", "qwerty", "123123", "batman", "123123",
            "696969", "superman", "111111", "password", "admin", "000000", "princess", "password1", "sunshine", "1234567890",
            "iloveyou", "dragon", "mustang", "pussy", "ninja", "football", "welcome", "monkey"
        );
         */
        return in_array($pw, $disabled);
    }

    public static function getGoldExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_gold_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getSilverExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_silver_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getSafeboxExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_safebox_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getAutolootExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_autoloot_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getFishExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_fish_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getMarriageExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_marriage_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getMoneyExpire($debug = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_money_expire'");
        if($debug == true)
        {
            return $query["value"];
        } else {
            if($query["value"] == NULL)
            {
                return '0000-00-00 00:00:00';
            } else {
                $expiredate = date("Y-m-d H:i:s", time() + (60 * 60 * 24) * $query["value"]);
                return $expiredate;
            }
        }

    }

    public static function getRegCoins()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'reg_coins'");
        return $query["value"];
    }

    public function emailExists($email)
    {
        $dbname = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbname.".account WHERE email = ?", array($email));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public function usernameExists($username)
    {
        $dbname = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbname.".account WHERE login = ?", array($username));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public function register($username, $password, $email, $delcode)
    {
        $db = Core::getAccountDatabase();
        $query = Database::query(
            "INSERT INTO ".$db.".account (`login`, `password`, `social_id`, `email`,`create_time`,
            `status`, `gold_expire`, `silver_expire`, `safebox_expire`, `autoloot_expire`, `fish_mind_expire`,
             `marriage_fast_expire`, `money_drop_rate_expire`,`".Core::getCoinsColumn()."`, `web_admin`, `register_ip`, `last_ip`) VALUES
              (?, PASSWORD(?), ?, ?, ?, 'OK', ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, '')", array($username, $password, $delcode,
            $email, date('Y-m-d H:i:s'), self::getGoldExpire(), self::getSilverExpire(), self::getSafeboxExpire(),
            self::getAutolootExpire(), self::getFishExpire(), self::getMarriageExpire(), self::getMoneyExpire(),
            self::getRegCoins(), $_SERVER["REMOTE_ADDR"]));
        return $query;
    }

}

?>