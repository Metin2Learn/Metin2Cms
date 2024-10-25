<?php

class Referral
{

    public function getUrl()
    {
        $link = '<input type="text" value="'.Links::getUrl("register-referral").User::getAccountID($_SESSION["username"]).'"
        class="form-control" readonly>';
        return $link;
    }

    public function getLimit()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'referral_limit'");
        return $query["value"];
    }

    public function rewardsPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'referral_rewards_per_page'");
        return $query["value"];
    }


    public function getRewardInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".referral_rewards WHERE id = ?", array($id));
        return $query;
    }

    public function rewardExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".referral_rewards WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReward($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".referral_rewards WHERE id = ?", array($id));
    }

    public static function getUserPoints($user)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("SELECT `rb_points` FROM ".$dbaccount.".account WHERE `login` = ?", array($user));
        return $query["rb_points"];
    }

    public function printAdminRewards($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("itemVnum").'</th>
                        <th class="text-center">'.Language::getTranslation("quantity").'</th>
                        <th class="text-center">'.Language::getTranslation("priceRP").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["item_vnum"].'</td>';
            echo '<td class="text-center">'.$row["count"].'</td>';
            echo '<td class="text-center">'.$row["price"].'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=referral-rewards&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=referral-rewards&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function addReward($name, $item_id, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".referral_rewards
        (`name`, `item_vnum`, description, `count`, price, img, socket0, socket1, socket2, addon_type, time_limit) VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($name, $item_id, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit));
    }

    public function updateReward($name, $item_id, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".referral_rewards SET `name` = ?, item_vnum = ?, description = ?, `count` = ?,
        price = ?, img = ?, socket0 = ?, socket1 = ?, socket2 = ?, addon_type = ?, time_limit = ? WHERE id = ?",
            array($name, $item_id, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $id));
    }


    public function printRewards($query, $param)
    {
        echo '<div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>'.Language::getTranslation("referralRewardName").'</th>
                        <th>'.Language::getTranslation("referralRewardDesc").'</th>
                        <th>'.Language::getTranslation("referralRewardImg").'</th>
                        <th>'.Language::getTranslation("referralRewardPrice").'</th>
                        <th>'.Language::getTranslation("referralRewardAction").'</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';

        $queryMain = Database::queryAll($query, $param);
        foreach($queryMain as $row)
        {
            echo '<tr>';
            echo '<td>'.$row["name"].'</td>';
            echo '<td>'.$row["description"].'</td>';
            echo "<td><img src='assets/images/referral/".$row['img']."' style='width:80px;height:80px;' onclick='window.open(this.src)'></td>";
            echo '<td>'.$row["price"].' '.Language::getTranslation("referralSysRPShort").'</td>';
            echo '<td><a href="'.Links::getUrl("account referral rewards").'/buy/'.$row["id"].'" class="btn btn-info">'.Language::getTranslation("referralRewardBuy").'</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table></div>';
    }

    public function numberOfRewards()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".referral_rewards");
        return $query;
    }


    public function levelIsSet($level)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_".$level."'");
        if($query["value"] != NULL)
        {
            return true;
        } else {
            return false;
        }
    }

    public function rewardLog($username, $itemId, $itemVnum, $itemName, $count, $price)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".log_referral_rewards
        (user_name, user_ip, item_id, item_vnum, item_name,`count`, price, `date`) VALUES (?, ?, ?, ?, ?, ?,?,?)",
            array($username, $_SERVER["REMOTE_ADDR"], $itemId, $itemVnum, $itemName, $count, $price, date('Y-m-d H:i:s')));
    }

    public function logEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_log'");
        if($query["value"] == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function staticLogEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_log'");
        if($query["value"] == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function updateReferrer($login, $referrer)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET referrer = ? WHERE login = ?",
            array(User::getUserNameFromId($referrer), $login));
    }

    public function log($level, $account, $points)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".referrer_system
        (`referrer`, player_level, player_account, added_points, singed, `date`) VALUES (?, ?, ?, ?, 1, ?)",
            array($_SESSION["username"], $level, $account, $points, date('Y-m-d H:i:s')));
    }

    public function check($user)
    {
        $dbaccount = Core::getAccountDatabase();
        $dbplayer = Core::getPlayerDatabase();
        $query1 = Database::query("SELECT * FROM ".$dbaccount.".account WHERE referrer = ?", array($user));
        if($query1 > 0)
        {
            $query2 = Database::queryAll("SELECT * FROM ".$dbaccount.".account WHERE referrer = ?", array($user));
            foreach($query2 as $row)
            {
                $query3 = Database::queryAll("SELECT * FROM ".$dbplayer.".player WHERE account_id = ?", array($row["id"]));
                foreach($query3 as $row2)
                {
                    if(self::levelIsSet(1) AND $row2["level"] >= self::getLevel(1) AND self::redeemed(self::getLevel(1), $row["login"]) == false)
                    {
                        self::log(self::getLevel(1), $row["login"], self::getPoints(1));
                        self::updatePoints(self::getPoints(1));
                    }
                    if(self::levelIsSet(2) AND $row2["level"] >= self::getLevel(2) AND self::redeemed(self::getLevel(2), $row["login"]) == false)
                    {
                        self::log(self::getLevel(2), $row["login"], self::getPoints(2));
                        self::updatePoints(self::getPoints(2));
                    }
                    if(self::levelIsSet(3) AND $row2["level"] >= self::getLevel(3) AND self::redeemed(self::getLevel(3), $row["login"]) == false)
                    {
                        self::log(self::getLevel(3), $row["login"], self::getPoints(3));
                        self::updatePoints(self::getPoints(3));
                    }
                    if(self::levelIsSet(4) AND $row2["level"] >= self::getLevel(4) AND self::redeemed(self::getLevel(4), $row["login"]) == false)
                    {
                        self::log(self::getLevel(4), $row["login"], self::getPoints(4));
                        self::updatePoints(self::getPoints(4));
                    }
                    if(self::levelIsSet(5) AND $row2["level"] >= self::getLevel(5) AND self::redeemed(self::getLevel(5), $row["login"]) == false)
                    {
                        self::log(self::getLevel(5), $row["login"], self::getPoints(5));
                        self::updatePoints(self::getPoints(5));
                    }
                    if(self::levelIsSet(6) AND $row2["level"] >= self::getLevel(6) AND self::redeemed(self::getLevel(6), $row["login"]) == false)
                    {
                        self::log(self::getLevel(6), $row["login"], self::getPoints(6));
                        self::updatePoints(self::getPoints(6));
                    }
                    if(self::levelIsSet(7) AND $row2["level"] >= self::getLevel(7) AND self::redeemed(self::getLevel(7), $row["login"]) == false)
                    {
                        self::log(self::getLevel(7), $row["login"], self::getPoints(7));
                        self::updatePoints(self::getPoints(7));
                    }
                    if(self::levelIsSet(8) AND $row2["level"] >= self::getLevel(8) AND self::redeemed(self::getLevel(8), $row["login"]) == false)
                    {
                        self::log(self::getLevel(8), $row["login"], self::getPoints(8));
                        self::updatePoints(self::getPoints(8));
                    }
                    if(self::levelIsSet(9) AND $row2["level"] >= self::getLevel(9) AND self::redeemed(self::getLevel(9), $row["login"]) == false)
                    {
                        self::log(self::getLevel(9), $row["login"], self::getPoints(9));
                        self::updatePoints(self::getPoints(9));
                    }
                    if(self::levelIsSet(10) AND $row2["level"] >= self::getLevel(10) AND self::redeemed(self::getLevel(10), $row["login"]) == false)
                    {
                        self::log(self::getLevel(10), $row["login"], self::getPoints(10));
                        self::updatePoints(self::getPoints(10));
                    }
                }
            }
        }
    }

    public function updatePoints($coins, $action = "+")
    {
        $dbaccount = Core::getAccountDatabase();
        if($action == "+")
        {
            $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET rb_points = rb_points + ? WHERE login = ?",
                array($coins, $_SESSION["username"]));
        } else {
            $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET rb_points = rb_points - ? WHERE login = ?",
                array($coins, $_SESSION["username"]));
        }
    }

    public static function statUpdatePoints($username, $coins, $action = "+")
    {
        $dbaccount = Core::getAccountDatabase();
        if($action == "+")
        {
            $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET rb_points = rb_points + ? WHERE login = ?",
                array($coins, $username));
        } else {
            $query = Database::queryAlone("UPDATE ".$dbaccount.".account SET rb_points = rb_points - ? WHERE login = ?",
                array($coins, $username));
        }
    }

    public function redeemed($level, $playerAccountUsername)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".referrer_system WHERE referrer = ? AND player_level = ? AND
        player_account = ? AND singed = 1",
            array($_SESSION["username"], $level, $playerAccountUsername));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function printTable($user)
    {
        $output = '';

        $output .= '
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>'.Language::getTranslation("referralSysUsername").'</th>';
        if(self::levelIsSet(1))
        {
            $output .= '<th>'.Language::getTranslation("referralSys1").'</th>';
        }
        if(self::levelIsSet(2))
        {
            $output .= '<th>'.Language::getTranslation("referralSys2").'</th>';
        }
        if(self::levelIsSet(3))
        {
            $output .= '<th>'.Language::getTranslation("referralSys3").'</th>';
        }
        if(self::levelIsSet(4))
        {
            $output .= '<th>'.Language::getTranslation("referralSys4").'</th>';
        }
        if(self::levelIsSet(5))
        {
            $output .= '<th>'.Language::getTranslation("referralSys5").'</th>';
        }
        if(self::levelIsSet(6))
        {
            $output .= '<th>'.Language::getTranslation("referralSys6").'</th>';
        }
        if(self::levelIsSet(7))
        {
            $output .= '<th>'.Language::getTranslation("referralSys7").'</th>';
        }
        if(self::levelIsSet(8))
        {
            $output .= '<th>'.Language::getTranslation("referralSys8").'</th>';
        }
        if(self::levelIsSet(9))
        {
            $output .= '<th>'.Language::getTranslation("referralSys9").'</th>';
        }
        if(self::levelIsSet(10))
        {
            $output .= '<th>'.Language::getTranslation("referralSys10").'</th>';
        }

                $output .= '
                </tr>
                </thead>
                <tbody>
                ';
        $dbaccount = Core::getAccountDatabase();
        $queryMain = Database::queryAll("SELECT * FROM ".$dbaccount.".account WHERE `referrer` = ? ORDER BY `create_time`",array($user));
        foreach($queryMain as $row)
        {
            $output .= '<tr>';
            $output .= '<td>'.$row["login"].'</td>';

            $dbplayer = Core::getPlayerDatabase();
            $confirm = Database::query("SELECT * FROM ".$dbplayer.".player WHERE account_id = ?",
                array(User::getAccountID($row["login"])));


            if(self::levelIsSet(1)) {
                if($confirm <= 0)
                {
                    $good_1 = false;
                } else {
                    if(self::redeemed(self::getLevel(1), $row["login"]))
                    {
                        $good_1 = true;
                    } else {
                        $good_1 = false;
                    }
                }
                if($good_1)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(2)) {
                if($confirm <= 0)
                {
                    $good_2 = false;
                } else {
                    if(self::redeemed(self::getLevel(2), $row["login"]))
                    {
                        $good_2 = true;
                    } else {
                        $good_2 = false;
                    }
                }
                if($good_2)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(3)) {
                if($confirm <= 0)
                {
                    $good_3 = false;
                } else {
                    if(self::redeemed(self::getLevel(3), $row["login"]))
                    {
                        $good_3 = true;
                    } else {
                        $good_3 = false;
                    }
                }
                if($good_3)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(4)) {
                if($confirm <= 0)
                {
                    $good_4 = false;
                } else {
                    if(self::redeemed(self::getLevel(4), $row["login"]))
                    {
                        $good_4 = true;
                    } else {
                        $good_4 = false;
                    }
                }
                if($good_4)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(5)) {
                if($confirm <= 0)
                {
                    $good_5 = false;
                } else {
                    if(self::redeemed(self::getLevel(5), $row["login"]))
                    {
                        $good_5 = true;
                    } else {
                        $good_5 = false;
                    }
                }
                if($good_5)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(6)) {
                if($confirm <= 0)
                {
                    $good_6 = false;
                } else {
                    if(self::redeemed(self::getLevel(6), $row["login"]))
                    {
                        $good_6 = true;
                    } else {
                        $good_6 = false;
                    }
                }
                if($good_6)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(7)) {
                if($confirm <= 0)
                {
                    $good_7 = false;
                } else {
                    if(self::redeemed(self::getLevel(7), $row["login"]))
                    {
                        $good_7 = true;
                    } else {
                        $good_7 = false;
                    }
                }
                if($good_7)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(8)) {
                if($confirm <= 0)
                {
                    $good_8 = false;
                } else {
                    if(self::redeemed(self::getLevel(8), $row["login"]))
                    {
                        $good_8 = true;
                    } else {
                        $good_8 = false;
                    }
                }
                if($good_8)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(9)) {
                if($confirm <= 0)
                {
                    $good_9 = false;
                } else {
                    if(self::redeemed(self::getLevel(9), $row["login"]))
                    {
                        $good_9 = true;
                    } else {
                        $good_9 = false;
                    }
                }
                if($good_9)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            if(self::levelIsSet(10)) {
                if($confirm <= 0)
                {
                    $good_10 = false;
                } else {
                    if(self::redeemed(self::getLevel(10), $row["login"]))
                    {
                        $good_10 = true;
                    } else {
                        $good_10 = false;
                    }
                }
                if($good_10)
                {
                    $output .= '<td><i class="fa fa-check"></i></td>';
                } else {
                    $output .= '<td><i class="fa fa-times"></i></td>';
                }
            }
            $output .= '</tr>';
        }


        $output .= '
                </tbody>
            </table>
        </div>';
        return $output;
    }

    public function remainingUserLimit($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE `referrer` = ?", array($username));
        return (self::getLimit() - $query);
    }

    public function numberOfReferrals($username)
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE `referrer` = ?", array($username));
        return $query;
    }

    public static function getLevel($i)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_".$i."'");
        return $query["value"];
    }

    public static function getPoints($i)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_".$i."'");
        return $query["value"];
    }

    public function rewardInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".referral_rewards WHERE id = ?", array($id));
        return $query;
    }

    public function getRewardsInfo()
    {
        global $dbname;
        $output = '';
        $query1 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_1'");
        $query2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_2'");
        $query3 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_3'");
        $query4 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_4'");
        $query5 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_5'");
        $query6 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_6'");
        $query7 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_7'");
        $query8 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_8'");
        $query9 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_9'");
        $query10 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_level_10'");

        if($query1["value"] != NULL)
        {   $output .= "<li>";
            $query1_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_1'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query1["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query1_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query2["value"] != NULL)
        {   $output .= "<li>";
            $query2_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_2'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query2["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query2_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query3["value"] != NULL)
        {   $output .= "<li>";
            $query3_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_3'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query3["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query3_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query4["value"] != NULL)
        {   $output .= "<li>";
            $query4_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_4'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query4["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query4_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query5["value"] != NULL)
        {   $output .= "<li>";
            $query5_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_5'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query5["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query5_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query6["value"] != NULL)
        {   $output .= "<li>";
            $query6_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_6'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query6["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query6_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query7["value"] != NULL)
        {   $output .= "<li>";
            $query7_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_7'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query7["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query7_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query8["value"] != NULL)
        {   $output .= "<li>";
            $query8_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_8'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query8["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query8_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query9["value"] != NULL)
        {   $output .= "<li>";
            $query9_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_9'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query9["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query9_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        if($query10["value"] != NULL)
        {   $output .= "<li>";
            $query10_2 = Database::queryAlone("SELECT * FROM ".$dbname.".web_settings WHERE `option` = 'referral_reward_10'");
            $output .= Language::getTranslation("referralSysRewardInfo").$query10["value"].
                Language::getTranslation("referralSysRewardInfo2").'<b>+'.$query10_2["value"].' '.Language::getTranslation("referralSysRPShort").'</b>';
            $output .= "</li>";
        }
        return $output;
    }

}

?>