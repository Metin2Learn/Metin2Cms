<?php

class Search
{

    public function numberOfAccounts($account)
    {
        $account = str_replace(' ', '', $account);
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account WHERE login = ? OR
        login LIKE ? OR login LIKE ? OR login LIKE ? OR register_ip = ? OR last_ip = ?",
            array($account, '%'.$account, $account.'%', '%'.$account.'%', $account, $account));
        return $query;
    }

    public function numberOfPlayers($player)
    {
        $player = str_replace(' ', '', $player);
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbplayer.".player WHERE `name` = ? OR
        `name` LIKE ? OR `name` LIKE ? OR `name` LIKE ? OR ip = ?",
            array($player, '%'.$player, $player.'%', '%'.$player.'%', $player));
        return $query;
    }


    public function printAccounts($query, $param)
    {
        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        $mainQuery = Database::queryAll($query, $param);
        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td>'.$row["login"].' <a href="index.php?page=view-players&id='.User::getAccountID($row["login"]).'" target="_blank"><i class="fa fa-search"></i></a></td>';
            echo '<td>'.$row["register_ip"].'</td>';
            echo '</tr>';
        }
        echo '</table></div>';
    }

    public function printPlayers($query, $param)
    {
        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        $mainQuery = Database::queryAll($query, $param);
        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td>'.$row["name"].'</td>';
            echo '<td>'.Language::getTranslation("account").' - '.Player::getPlayerAccountUsername($row["id"]).'
            <a href="index.php?page=view-players&id='.User::getAccountID(Player::getPlayerAccountUsername($row["id"])).'" target="_blank"><i class="fa fa-search"></i></a></td>';
            echo '<td>'.$row["ip"].'</td>';
            echo '</tr>';
        }
        echo '</table></div>';
    }


}

?>