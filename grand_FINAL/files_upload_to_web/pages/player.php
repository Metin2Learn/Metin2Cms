<div class="box hardware">
<?php

if(isset($_GET["id"]) AND ctype_digit($_GET["id"]) AND Player::playerExists($_GET["id"]))
{

    ?>
    <h2><?= Language::getTranslation("playerInfoTitle")."<strong>".Player::getPlayerName($_GET["id"])."</strong>";?></h2>
    <div class="row">
        <div class="col-md-6">
            <div class="team-member">
                <ul class="list-unstyled">
                    <?php
                    $info = Player::getPlayerInfo($_GET["id"]);
                    echo "<li><strong>".Language::getTranslation('playerInfoName')."</strong>".$info['name']."</li>";
                    echo "<li><strong>".Language::getTranslation('playerInfoLevel')."</strong>".$info['level']."</li>";
                    echo "<li><strong>".Language::getTranslation('playerInfoExp')."</strong>".$info['exp']."</li>";
                    $accountID = Player::getPlayerAccountID($_GET["id"]);
                    switch(Player::getPlayerKingdom($accountID)) {
                        case 1:
                            $kingdom = Language::getTranslation("playerInfoShinsoo");
                            break;
                        case 2:
                            $kingdom = Language::getTranslation("playerInfoChunjo");
                            break;
                        case 3:
                            $kingdom = Language::getTranslation("playerInfoJinno");
                            break;
                        default:
                            $kingdom = "";
                            break;
                    }
                    echo "<li><strong>".Language::getTranslation('playerInfoKingdom')."</strong>".$kingdom."</li>";
                    $playtime = round($info['playtime'] / 60);
                    echo "<li><strong>".Language::getTranslation('playerInfoGameTime')."</strong>".$playtime.Language::getTranslation('playerInfoHours')."</li>";
                    echo "<li><strong>".Language::getTranslation('playerInfoLastPlay')."</strong>".Core::makeNiceDate($info['last_play'])."</li>";
                    echo "<li><strong>".Language::getTranslation('playerInfoChar')."</strong>".Player::getPlayerChar($info['id'])."</li>";
                    echo "<li><strong>".Language::getTranslation('playerInfoGuild')."</strong>".Player::getPlayerGuild($info['id'])."</li>";
                    ?>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <img src="assets/images/chars/<?= $info["job"];?>.png" class="img-responsive center-block" alt="">
        </div>
    </div>
    <?php

} else {
    Core::redirect(Links::getUrl("error"), 0);
}

?>
    </div>