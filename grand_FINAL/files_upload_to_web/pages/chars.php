<?php
if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box list-matches">';
    echo '<h2><a href="'.Links::getUrl("account").'">'.Language::getTranslation("accountTitle").'</a> - '.Language::getTranslation("charsTitle").'</h2>';
    if(User::getCountOfChars($_SESSION["username"]) > 0)
    {
        if(isset($_GET["player"]) AND Player::playerExists($_GET["player"]) AND Player::hasPermission($_GET["player"]))
        {
            $player = $_GET["player"];
            $lastplay = Player::getLastPlayTime($player);
            $now = new DateTime(date('Y-m-d H:i:s'));
            $wait = new DateInterval('PT'.Core::debugDisconnectWaitTime().'M');
            $wait->invert = 1;
            $now->add($wait);
            $unblockTime = $now->format('Y-m-d H:i:s');
            $canDebug = new DateTime($lastplay);
            $canDebug->add(new DateInterval('PT'.Core::debugDisconnectWaitTime().'M'));
            $unblockReal = $canDebug->format('Y-m-d H:i:s');
            if(ActionLog::hasBlock($_SESSION["username"], "debug-char"))
            {
                $result = Core::result(Language::getTranslation("charsDebugHasBlock").ActionLog::unblockTime($_SESSION["username"], "debug-char"),2);
            }
            elseif($lastplay > $unblockTime)
            {
                $result = Core::result(Language::getTranslation("charDebugNotDisconnected").Core::makeNiceDate($unblockReal),2);
            } else {
                //debug
                $result = Core::result(Language::getTranslation("charDebugSuccess"),1);
                Player::debug($player);
                ActionLog::write($_SESSION["username"], "debug-char");
            }
            echo $result;
        }
        echo Core::result(Language::getTranslation("charsDebugInfo"),3);
        echo User::getAccountChars($_SESSION["username"]);
    } else {
        echo Core::result(Language::getTranslation("charsNoChars"),4);
    }
    echo '</div>';
}
?>