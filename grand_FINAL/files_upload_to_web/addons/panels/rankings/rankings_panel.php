<?php

echo '<div class="box sidebar-box widget-wrapper widget-matches">';
echo '<h3>'.Language::getTranslation("rankingsTitle").'</h3>';
$playerdb = Core::getPlayerDatabase();
$notShow = Rankings::prefixNotShow();
if(mb_strlen($notShow) > 1)
{
    $notShow = str_replace(" ", "", $notShow);
    $explode = explode(",", $notShow);
    $where = "";
    foreach($explode as $row)
    {
        $where .= "`name` NOT LIKE '".$row."%' AND ";
    }
    $query = Database::queryAll("SELECT * FROM " . $playerdb . ".player WHERE ".substr($where, 0, -5)." ORDER BY `level` DESC, `exp` DESC LIMIT 5");
} else {
    $query = Database::queryAll("SELECT * FROM " . $playerdb . ".player ORDER BY `level` DESC, `exp` DESC LIMIT 5");
}

?>
<table class="table match-wrapper">
    <tbody>
    <tr>
        <td class="game">
            <span><?= Language::getTranslation("rankingsPlayers");?></span>
        </td>
        <td class="game-date">
            <span><?= Language::getTranslation("rankingsLVL");?></span>
        </td>
    </tr>


    <?php
    foreach($query as $row)
    {
        echo '<tr>';
        if(Core::isPlayerInfoEnabled())
        {
            echo '<td class="team-name"><img src="assets/images/icons/chars/' . $row["job"] . '.png" style="width:32px;height:32px;" alt="">
            <a href="'.Links::getUrl("player").'/'.$row["id"].'">' . $row["name"] . '</a></td>';
        } else {
            echo '<td class="team-name"><img src="assets/images/icons/chars/' . $row["job"] . '.png" style="width:32px;height:32px;" alt="">' . $row["name"] . '</td>';
        }
        echo '<td class="team-score">'.$row["level"].'</td>';
        echo '</tr>';
    }

    $query2 = Database::queryAll("SELECT * FROM " . $playerdb . ".guild ORDER BY `level` DESC, `ladder_point` DESC, `win` DESC, `exp` DESC LIMIT 5");
    ?>
    </tbody>
    </table>

    <table class="table match-wrapper">
        <tbody>
        <tr>
            <td class="game">
                <span><?= Language::getTranslation("rankingsGuild");?></span>
            </td>
            <td class="game-date">
                <span><?= Language::getTranslation("rankingsLVL");?></span>
            </td>
        </tr>


        <?php
        foreach($query2 as $row2)
        {
            echo '<tr>';
            echo '<td class="team-name"><a>'.$row2["name"].'</a></td>';
            echo '<td class="team-score">'.$row2["level"].'</td>';
        }
        ?>

        </tbody>
    </table>
    <?php
    echo '</div>';

?>