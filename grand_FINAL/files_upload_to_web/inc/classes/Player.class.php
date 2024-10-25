<?php

class Player
{

    public static function getPlayerKingdom($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT empire FROM ".$dbPlayer.".player_index WHERE id = ?", array($id));
        return $query["empire"];
    }

    public static function getPlayerAccountID($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT account_id FROM ".$dbPlayer.".player WHERE id = ?", array($id));
        return $query["account_id"];
    }

    public static function getPlayerAccountUsername($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT account_id FROM ".$dbPlayer.".player WHERE id = ?", array($id));

        $dbaccount = Core::getAccountDatabase();
        $query2 = Database::queryAlone("SELECT login FROM ".$dbaccount.".account WHERE id = ?", array($query["account_id"]));
        return $query2["login"];

    }

    public static function playerExists($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbPlayer.".player WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function debug($player)
    {
        $kingdom = self::getPlayerKingdom($player);
        $playerdb = Core::getPlayerDatabase();
        switch($kingdom)
        {
            case 1:
                $shinso = Core::debugShinso();
                $query1 = Database::queryAlone("UPDATE ".$playerdb.".player SET map_index = ?, x = ?, y = ?, exit_x = 0,
                exit_y = 0, exit_map_index = ?, horse_riding = 0 WHERE id = ?",
                    array($shinso[0], $shinso[1], $shinso[2], $shinso[0], $player));
                break;
            case 2:
                $chunjo = Core::debugChunjo();
                $query2 = Database::queryAlone("UPDATE ".$playerdb.".player SET map_index = ?, x = ?, y = ?, exit_x = 0,
                exit_y = 0, exit_map_index = ?, horse_riding = 0 WHERE id = ?",
                    array($chunjo[0], $chunjo[1], $chunjo[2], $chunjo[0], $player));
                break;
            case 3:
                $jinno = Core::debugJinno();
                $query3 = Database::queryAlone("UPDATE ".$playerdb.".player SET map_index = ?, x = ?, y = ?, exit_x = 0,
                exit_y = 0, exit_map_index = ?, horse_riding = 0 WHERE id = ?",
                    array($jinno[0], $jinno[1], $jinno[2], $jinno[0], $player));
                break;
        }
    }

    public static function getLastPlayTime($player)
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT last_play FROM ".$dbplayer.".player WHERE id = ?", array($player));
        return $query["last_play"];
    }

    public static function hasPermission($player)
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbplayer.".player WHERE id = ? AND account_id = ?",
            array($player, User::getAccountID($_SESSION["username"])));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function getPlayerInfo($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$dbPlayer.".player WHERE id = ?", array($id));
        return $query;
    }

    public static function getPlayerName($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT `name` FROM ".$dbPlayer.".player WHERE id = ?", array($id));
        return $query["name"];
    }

    public static function getPlayerId($name)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT `id` FROM ".$dbPlayer.".player WHERE name = ?", array($name));
        return $query["id"];
    }

    public static function getGuildName($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT `name` FROM ".$dbPlayer.".guild WHERE id = ?", array($id));
        return $query["name"];
    }

    public static function getGuildMembers($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbPlayer.".guild_member WHERE guild_id = ?", array($id));
        return $query;
    }

    public static function getPlayerChar($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT `job` FROM ".$dbPlayer.".player WHERE id = ?", array($id));
        switch($query["job"])
        {
            case 0:
                $html = Language::getTranslation("warrior");
                break;
            case 1:
                $html = Language::getTranslation("ninja");
                break;
            case 2:
                $html = Language::getTranslation("sura");
                break;
            case 3:
                $html = Language::getTranslation("shaman");
                break;
            case 4:
                $html = Language::getTranslation("warrior");
                break;
            case 5:
                $html = Language::getTranslation("ninja");
                break;
            case 6:
                $html = Language::getTranslation("sura");
                break;
            case 7:
                $html = Language::getTranslation("shaman");
                break;

        }
        return $html;
    }

    public static function playerNameExists($name)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$playerdb.".player WHERE `name` = ?",
            array($name));
        if ($query > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function playersOnline()
    {
        $playerdb = Core::getPlayerDatabase();
        $date = new DateTime(date('Y-m-d H:i:s'));
        $interval = new DateInterval('PT5M');
        $interval->invert = 1;
        $date->add($interval);
        $online = $date->format('Y-m-d H:i:s');


        $query = Database::query("SELECT * FROM ".$playerdb.".player WHERE last_play > ?", array($online));
        return $query;
    }

    public static function isAccountProperty($player, $account)
    {
        $playerdb = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$playerdb.".player WHERE `name` = ? AND account_id = ?",
            array($player, User::getAccountID($account)));

        if($player == $account)
        {
            return true;
        } else {
            if ($query > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function getPlayerGuild($id)
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$dbPlayer.".guild_member WHERE pid = ?", array($id));
        if($query > 0)
        {
            return self::getGuildName($query["guild_id"]);
        } else {
            return Language::getTranslation("playerRankNoGuild");
        }
    }

    public static function printAdminPlayers($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("regEmail").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["login"].'</td>';
            echo '<td class="text-center">'.$row["email"].'</td>';
            if(User::isBanned($row["login"]))
            {
                echo '<td class="text-center"><span class="label label-danger">'.Language::getTranslation("banned").'</span></td>';
            } else {
                echo '<td class="text-center"><span class="label label-success">'.Language::getTranslation("ok").'</span></td>';
            }
            echo '<td class="text-center">';
            echo '<a href="index.php?page=view-players&id=' . $row["id"] . '"><i class="fa fa-search bg-blue action"></i></a> ';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

}

?>