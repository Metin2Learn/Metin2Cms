<div class="box">
    <h2><?= Language::getTranslation("search");?></h2>
    <?php
    if(isset($_POST["search"]))
    {
        $phrase = $_POST["phrase"];
        if(Player::playerNameExists($phrase) AND Core::isPlayerInfoEnabled())
        {
            echo Core::result(Language::getTranslation("playerFound"), 3);
            Core::redirect(Links::getUrl("player")."/".Player::getPlayerId($phrase), 1);
        } else {
            echo Core::result(Language::getTranslation("nothingFound"), 3);
        }
    }
    ?>
</div>