<?php

class Rankings
{

    public function numberOfPlayers()
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbPlayer.".player");
        return $query;
    }

    public function numberOfGuilds()
    {
        $dbPlayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbPlayer.".guild");
        return $query;
    }

    public function showPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'rank_per_page'");
        return $query["value"];
    }

    public static function perPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'rank_per_page'");
        return $query["value"];
    }

    public function printPlayersRanking($query, $param)
    {
        $query = Database::queryAll($query, $param);
        $html = '
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>'.Language::getTranslation("playerRankOrder").'</th>
                <th>'.Language::getTranslation("playerRankKingdom").'</th>
                <th>'.Language::getTranslation("playerRankName").'</th>
                <th>'.Language::getTranslation("playerRankLevel").'</th>
                <th>'.Language::getTranslation("playerRankChar").'</th>
                <th>'.Language::getTranslation("playerRankGuild").'</th>';
        if(Core::isPlayerInfoEnabled())
        {
            $html .= '<th>'.Language::getTranslation("playerRankInfo").'</th>';
        }

            $html .= '</tr>
            </thead>
            <tbody>';
        if(isset($_GET["pagination"]) AND $_GET["pagination"] > 1)
        {
            $i = ($_GET["pagination"] * self::showPerPage()) - (self::showPerPage() - 1);
        } else {
            $i = 1;
        }
        foreach($query as $row)
        {
            $html .= '<tr>';
            $html .= '<td>'.$i.'.</td>';
            switch(Player::getPlayerKingdom($row["account_id"])) {
                case 1:
                    $img = "<img src='assets/images/icons/shinso.jpg' alt=''>";
                    break;
                case 2:
                    $img = "<img src='assets/images/icons/chunjo.jpg' alt=''>";
                    break;
                case 3:
                    $img = "<img src='assets/images/icons/jinno.jpg' alt=''>";
                    break;
                default:
                    $img = "";
                    break;
            }
            $html .= '<td>'.$img.'</td>';
            $html .= '<td>'.$row["name"].'</td>';
            $html .= '<td>'.$row["level"].'</td>';
            $html .= '<td>'.Player::getPlayerChar($row["id"]).'</td>';
            $html .= '<td>'.Player::getPlayerGuild($row["id"]).'</td>';
            if(Core::isPlayerInfoEnabled())
            {
                $html .= '<td><a href="'.Links::getUrl("player").'/'.$row["id"].'"><i class="fa fa-search"></i></a></td>';
            }
            $html .= '</tr>';
            $i++;
        }
        $html .= '</tbody>
        </table>
    </div>';
        echo $html;
    }

    public function printGuildsRanking($query, $param)
    {
        $query = Database::queryAll($query, $param);
        $html = '
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>'.Language::getTranslation("guildRankOrder").'</th>
                <th>'.Language::getTranslation("guildRankName").'</th>
                <th>'.Language::getTranslation("guildRankLevel").'</th>
                <th>'.Language::getTranslation("guildRankMembers").'</th>
                <th>'.Language::getTranslation("guildRankPoints").'</th>';
            $html .= '</tr>
            </thead>
        <tbody>';

        if(isset($_GET["pagination"]) AND $_GET["pagination"] > 1)
        {
            $i = ($_GET["pagination"] * self::showPerPage()) - (self::showPerPage() - 1);
        } else {
            $i = 1;
        }
        foreach($query as $row)
        {
            $html .= '<tr>';
            $html .= '<td>'.$i.'.</td>';
            $html .= '<td>'.$row["name"].'</td>';
            $html .= '<td>'.$row["level"].'</td>';
            $html .= '<td>'.Player::getGuildMembers($row["id"]).'</td>';
            $html .= '<td>'.$row["ladder_point"].'</td>';
            $html .= '</tr>';
            $i++;
        }
        $html .= '</tbody>
        </table>
    </div>';
        echo $html;
    }

    public static function prefixNotShow()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'prefix_not_show_rankings'");
        return $query["value"];
    }


}

?>