<?php

class User
{

    public static function isBanned($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE login = ? AND status = 'BLOCK'", array($username));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public static function ban($name, $length, $reason, $admin)
    {
        $now = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $now->add(new DateInterval('PT'.$length.'M'));
        $expire = $now->format('Y-m-d H:i:s');
        $dbaccount = Core::getAccountDatabase();
        Database::query("UPDATE ".$dbaccount.".account SET status = 'BLOCK',ban_reason = ?, ban_until = ? WHERE login = ?",
            array($reason,$expire, $name));
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".log_bans
        (user_name, admin, ban_until, reason, `date`) VALUES (?, ?, ?, ?, ?)", array($name, $admin,$expire, $reason, date('Y-m-d H:i:s')));
    }

    public static function getInfo($id)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$dbaccount.".account WHERE id = ?", array($id));
        return $query;
    }

    public static function bannedTimes($username)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".log_bans WHERE user_name = ?", array($username));
        return $query;
    }

    public static function printUserBans($username)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".log_bans WHERE user_name = ? ORDER by `date` DESC", array($username));
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("type").'</th>
                        <th class="text-center">'.Language::getTranslation("reason").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("banExpire").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($query as $row)
        {
            echo '<tr>';
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center"><span class="label label-success">'.Language::getTranslation("unban").'</span></td>';
            } else {
                echo '<td class="text-center"><span class="label label-danger">'.Language::getTranslation("ban").'</span></td>';
            }
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center">-</td>';
            } else {
                echo '<td class="text-center">'.$row["reason"].'</td>';
            }
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center">-</td>';
            } else {
                echo '<td class="text-center">'.Core::makeNiceDate($row["ban_until"]).'</td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function printAdminUserCharacters($username)
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::queryAll("SELECT * FROM ".$dbplayer.".player WHERE account_id = ?", array(self::getAccountID($username)));
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("playerRankLevel").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($query as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["level"].'</td>';
            echo '<td class="text-center">'.$row["ip"].'</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function getAccountChars($username)
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::queryAll("SELECT * FROM ".$dbplayer.".player WHERE account_id = ?", array(self::getAccountID($username)));
        $html = '';
        $html .= '
<div class="table-responsive">
    <table class="table table-bordered match">
        <thead>
        <tr>';
        if(Core::isPlayerInfoEnabled()) {
            $html .= '<td></td>';
        }
        $html .= '
            <td>'.Language::getTranslation("playerRankName").'</td>
            <td>'.Language::getTranslation("playerRankChar").'</td>
            <td class="text-center">'.Language::getTranslation("playerRankLevel").'</td>
            <td>'.Language::getTranslation("playerInfoGameTime").'</td>
            <td class="text-right">'.Language::getTranslation("playerInfoGuild").'</td>
        </tr>
        </thead>

        <tbody>';
        foreach($query as $row)
        {
            $html .= '<tr>';
            if(Core::isPlayerInfoEnabled()) {
                $html .= '
            <td class="status">
                <a href="' . Links::getUrl("player") . '/' . $row["id"] . '" target="_blank"><i class="fa fa-eye"></i></a>
            </td>';
            }
            $html .= '
            <td class="game">
                <span>'.$row["name"].'</span>
                <span class="game-date"><a href="'.Links::getUrl("account chars").'/'.$row["id"].'">'.Language::getTranslation("charsDebugButton").'</a></span>
            </td>';

            $html .= '<td class="team-name right"><img class="img-responsive" src="assets/images/icons/chars/'.$row["job"].'.png"></td>';
            $html .= '<td class="team-score win">'.$row["level"].'</td>';
            $playtime = round($row['playtime'] / 60);
            $html .= '<td class="team-score lose">'.$playtime.Language::getTranslation("playerInfoHours").'</td>';
            $html .= '<td class="team-name right">'.Player::getPlayerGuild($row["id"]).'</td>';
            $html .= '</tr>';
        }
        $html .= '
        </tbody>
    </table>
</div>';
        return $html;
    }

    public static function getCountOfChars($username)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$playerdb.".player WHERE account_id = ?", array(self::getAccountID($username)));
        return $query;
    }

    public static function emailExists($email)
    {
        $accountdb = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$accountdb.".account WHERE email = ?", array($email));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public static function idExists($id)
    {
        $accountdb = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$accountdb.".account WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public static function changeEmail($username, $old_email, $new_email)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET email = ? WHERE login = ?", array($new_email, $username));
        if(Core::changeEmailLog())
        {
            global $dbname;
            $query2 = Database::queryAlone("INSERT INTO " . $dbname . ".log_change_email (`user_name`, `user_ip`, `old_email`, `new_email`, `date`)
        VALUES (?, ?, ?, ?, ?)", array($username, $_SERVER["REMOTE_ADDR"], $old_email, $new_email, date('Y-m-d H:i:s')));
        }
    }

    public static function bannedUsers()
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE status = 'BLOCK'");
        return $query;
    }

    public static function printBanList($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("userBannedUntil").'</th>
                        <th class="text-center">'.Language::getTranslation("banReason").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["login"].'</td>';
            if($row["ban_until"] == null)
            {
                echo '<td class="text-center">pernament</td>';
            } else {
                echo '<td class="text-center">'.Core::makeNiceDate($row["ban_until"]).'</td>';
            }
            echo '<td class="text-center">'.$row["ban_reason"].'</td>';
            echo '<td class="text-center">';
            echo '<a target="_blank" href="index.php?page=view-players&id=' . $row["id"] . '"><i class="fa fa-search bg-blue action"></i></a> ';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function getWarehousePassword($username)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$playerdb.".safebox WHERE account_id = ?", array(self::getAccountID($username)));
        if($query["password"] == '')
        {
            return "000000 (default)";
        } else {
            return $query["password"];
        }
    }

    public static function changeWarehousePassword($username,$old, $new_pw)
    {
        $playerdb = Core::getPlayerDatabase();
        $query1 = Database::query("SELECT * FROM ".$playerdb.".safebox WHERE `account_id` = ?", array(self::getAccountID($username)));
        if($query1 > 0) {
            $query = Database::queryAlone("UPDATE " . $playerdb . ".safebox SET `password` = ? WHERE `account_id` = ?",
                array($new_pw, self::getAccountID($username)));
        } else {
            $query2 = Database::queryAlone("INSERT INTO ".$playerdb.".safebox (`account_id`, `size`, `password`, `gold`)
            VALUES (?, 1, ?, 0)", array(self::getAccountID($username), $new_pw));
        }
        if(Core::changeWarehousePasswordLog())
        {
            global $dbname;
            $query2 = Database::queryAlone("INSERT INTO " . $dbname . ".log_change_warehouse_pw (`user_name`, `user_ip`, `old_pw`, `new_pw`, `date`)
        VALUES (?, ?, ?, ?, ?)", array($_SESSION["username"], $_SERVER["REMOTE_ADDR"], $old, $new_pw, date('Y-m-d H:i:s')));
        }
    }

    public static function isCorrectWarehousePassword($username, $password)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$playerdb.".safebox WHERE account_id = ? AND `password` = ?",
            array(self::getAccountID($username), $password));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }

    }

    public static function isCorrectEmail($username,$email)
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

    public static function isDefaultWarehousePassword($username)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$playerdb.".safebox WHERE account_id = ?", array(self::getAccountID($username)));
        if($query["password"] == '')
        {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllCharsName($account)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::queryAll("SELECT * FROM ".$playerdb.".player WHERE account_id = ?", array(self::getAccountID($account)));
        return $query;
    }

    public static function changePassword($user, $old, $new, $log=true)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET password = PASSWORD(?) WHERE login = ?",
            array($new, $user));
        if(Core::changeAccountPasswordLog() AND $log == true) {
            global $dbname;
            $query2 = Database::queryAlone("INSERT INTO " . $dbname . ".log_change_pw (`user_name`, `user_ip`, `old_pw`, `new_pw`, `date`)
        VALUES (?, ?, ?, ?, ?)", array($user, $_SERVER["REMOTE_ADDR"], self::mysqlPassword($old), self::mysqlPassword($new), date('Y-m-d H:i:s')));
        }
    }

    public static function numberOfPaysafecardPins($username, $status)
    {
        global $dbname;
        if($status == "all")
        {
            $query = Database::query("SELECT * FROM ".$dbname.".paysafecard_pins WHERE account = ?",
                array($username));
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".paysafecard_pins WHERE account = ? AND status = ?",
                array($username, $status));
        }
        return $query;
    }

    public static function numberOfAmazonCodes($username, $status)
    {
        global $dbname;
        if($status == "all")
        {
            $query = Database::query("SELECT * FROM ".$dbname.".amazon_codes WHERE account = ?",
                array($username));
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".amazon_codes WHERE account = ? AND status = ?",
                array($username, $status));
        }
        return $query;
    }

    public static function deletePin($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".paysafecard_pins WHERE id = ?", array($id));
    }

    public static function deleteAmazonCode($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".amazon_codes WHERE id = ?", array($id));
    }

    public static function hasPropertyToDeletePin($username, $id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".paysafecard_pins WHERE account = ? AND id = ?",
            array($username, $id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function hasPropertyToDeleteAmazonCode($username, $id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".amazon_codes WHERE account = ? AND id = ?",
            array($username, $id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function getLast5Pins($username)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".paysafecard_pins WHERE account = ? ORDER BY `date` DESC LIMIT 5",
            array($username));
        return $query;
    }

    public static function getLast5AmazonCodes($username)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".amazon_codes WHERE account = ? ORDER BY `date` DESC LIMIT 5",
            array($username));
        return $query;
    }

    public static function add_psc_pin($username, $pin, $status, $coins)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".paysafecard_pins (account, pin, status, `date`, coins)
        VALUES (?,?,?,?,?)", array($username, $pin, $status, date('Y-m-d H:i:s'), $coins));
    }

    public static function add_amazon_code($username, $code, $status, $coins)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".amazon_codes (account, pin, status, `date`, coins)
        VALUES (?,?,?,?,?)", array($username, $code, $status, date('Y-m-d H:i:s'), $coins));
    }

    public static function getAccountID($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `id` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["id"];
    }

    public static function mysqlPassword($raw)
    {
        return '*'.strtoupper(hash('sha1',pack('H*',hash('sha1', $raw))));
    }

    public static function isCorrectPassword($password)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE login = ? AND password = ?",
            array($_SESSION["username"], self::mysqlPassword($password)));
        if($query > 0)
        {
            return true;
        } else {
            false;
        }
    }

    public static function addCoins($username, $coins)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("UPDATE ".$dbaccount.".account SET ".Core::getCoinsColumn()." = ".Core::getCoinsColumn()." + ?
        WHERE login = ?", array($coins, $username));
    }

    public static function removeCoins($username, $coins)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("UPDATE ".$dbaccount.".account SET ".Core::getCoinsColumn()." = ".Core::getCoinsColumn()." - ?
        WHERE login = ?", array($coins, $username));
    }

    public static function usernameExists($username)
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


    public static function getUserEmail($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `email` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["email"];
    }

    public static function getUserNameFromId($id)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `login` FROM ".$dbaccount.".account WHERE id = ?", array($id));
        return $query["login"];
    }

    public static function getGoldPremium($username, $debug = false)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `gold_expire` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        if($debug == true)
        {
            return $query["gold_expire"];
        } else {
            if ($query["gold_expire"] != '0000-00-00 00:00:00' AND $query["gold_expire"] > date('Y-m-d H:i:s')) {
                $return = Language::getTranslation("accountInfoPremiumActive") . Core::makeNiceDate($query["gold_expire"]);
            } else {
                $return = Language::getTranslation("accountInfoPremiumNotActive");
            }
            return $return;
        }
    }

    public static function updateGoldPremium($user, $days)
    {
        $expire = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * $days));

        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET `gold_expire` = ? WHERE login = ?",
            array($expire, $user));
    }

    public static function getSilverPremium($username, $debug = false)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `silver_expire` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        if($debug == true)
        {
            return $query["silver_expire"];
        } else {
            if ($query["silver_expire"] != '0000-00-00 00:00:00' AND $query["silver_expire"] > date('Y-m-d H:i:s')) {
                $return = Language::getTranslation("accountInfoPremiumActive") . Core::makeNiceDate($query["silver_expire"]);
            } else {
                $return = Language::getTranslation("accountInfoPremiumNotActive");
            }
            return $return;
        }
    }

    public static function updateSilverPremium($user, $days)
    {
        $expire = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * $days));

        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET `silver_expire` = ? WHERE login = ?",
            array($expire, $user));
    }

    public static function generateItem($username, $count, $vnum, $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2)
    {
        $dbplayer = Core::getPlayerDatabase();
        //22
        $query = Database::queryAlone("INSERT INTO ".$dbplayer.".item
        (owner_id,window,pos,`count`,vnum,attrtype0, attrvalue0, attrtype1, attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3,
         attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, socket0, socket1, socket2) VALUES
         (?, 'MALL', 2, ?, ?, ?, ?, ?, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ?, ?, ?)",
            array(User::getAccountID($username), $count, $vnum, $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2));
    }

    public static function getYangPremium($username, $debug = false)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `money_drop_rate_expire` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        if($debug == true)
        {
            return $query["money_drop_rate_expire"];
        } else {
            if ($query["money_drop_rate_expire"] != '0000-00-00 00:00:00' AND $query["money_drop_rate_expire"] > date('Y-m-d H:i:s')) {
                $return = Language::getTranslation("accountInfoPremiumActive") . Core::makeNiceDate($query["money_drop_rate_expire"]);
            } else {
                $return = Language::getTranslation("accountInfoPremiumNotActive");
            }
            return $return;
        }
    }

    public static function updateYangPremium($user, $days)
    {
        $expire = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * $days));

        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET `money_drop_rate_expire` = ? WHERE login = ?",
            array($expire, $user));
    }


    public static function getCreateTime($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `create_time` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["create_time"];
    }


    public static function getDeleteCode($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `social_id` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["social_id"];
    }

    public static function hasEmptyItemShopMall($username)
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbplayer.".item WHERE owner_id = ? AND window = 'MALL'", array(self::getAccountID($username)));
        if($query > 0)
        {
            return false;
        } else {
            return true;
        }
    }

    public static function getCoins($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `".Core::getCoinsColumn()."` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query[Core::getCoinsColumn()];
    }

    public static function getLastIP($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `last_ip` FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["last_ip"];
    }

    public static function getBanLength($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT ban_until FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["ban_until"];
    }

    public static function getBanReason($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT ban_reason FROM ".$dbaccount.".account WHERE login = ?", array($username));
        return $query["ban_reason"];
    }

    public static function unban($username, $admin = 'system')
    {
        $dbaccount = Core::getAccountDatabase();
        Database::query("UPDATE ".$dbaccount.".account SET status = 'OK', ban_reason = NULL, ban_until = NULL WHERE `login` = ?", array($username));

        global $dbname;
        Database::query("INSERT INTO ".$dbname.".log_bans
        (user_name, admin, ban_until, reason, `date`) VALUES (?, ?, null, 'MT2GRAND_UNBAN', ?)", array($username, $admin, date('Y-m-d H:i:s')));
    }

    public static function isLogged()
    {
        if(isset($_SESSION["username"]) AND $_SESSION["username"] != NULL)
        {
            return true;
        } else {
            return false;
        }
    }

}

?>