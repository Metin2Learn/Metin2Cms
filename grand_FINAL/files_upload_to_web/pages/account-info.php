<?php
if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box">';
    echo '<h2><a href="'.Links::getUrl("account").'">'.Language::getTranslation("accountTitle").'</a> - '.Language::getTranslation("accountInfoTitle").'</h2>';
    echo '<ul class="list-group">';
    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoUsername").' <span class="text-primary">'.$_SESSION["username"].'</span></li>';
    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoEmail").'
    <span class="text-primary">'.User::getUserEmail($_SESSION["username"]).'</span></li>';
    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoLastIP").'
    <span class="text-primary">'.User::getLastIP($_SESSION["username"]).'</span></li>';

    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoCoins").'
    <span class="text-primary">'.User::getCoins($_SESSION["username"]).'</span></li>';

    if(Core::referralSystemEnabled())
    {
        echo '<li class="list-group-item">'.Language::getTranslation("referralSysRP").'
    <span class="text-primary">'.Referral::getUserPoints($_SESSION["username"]).'</span></li>';
    }

    if(Core::showDeleteCodeEnabled())
    {
        echo '<li class="list-group-item">'.Language::getTranslation("accountInfoDeleteCode").'
        <span class="text-primary">'.User::getDeleteCode($_SESSION["username"]).'</span></li>';
    } else {
        echo '<li class="list-group-item">'.Language::getTranslation("accountInfoDeleteCode").'
        <span class="text-primary">'.Language::getTranslation("accountInfoDCHidden").'</span></li>';
    }

    if(Core::showWarehousePasswordEnabled())
    {
        echo '<li class="list-group-item">'.Language::getTranslation("accountInfoWarehousePassword").'
        <span class="text-primary">'.User::getWarehousePassword($_SESSION["username"]).'</span></li>';
    } else {
        echo '<li class="list-group-item">'.Language::getTranslation("accountInfoWarehousePassword").'
        <span class="text-primary">'.Language::getTranslation("accountInfoWarehouseHidden").'</span></li>';
    }

    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoCreated").'
    <span class="text-primary">'.Core::makeNiceDate(User::getCreateTime($_SESSION["username"])).'</span></li>';

    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoPremiumGold").'
    <span class="text-primary">'.User::getGoldPremium($_SESSION["username"]).'</span></li>';

    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoPremiumSilver").'
    <span class="text-primary">'.User::getSilverPremium($_SESSION["username"]).'</span></li>';

    echo '<li class="list-group-item">'.Language::getTranslation("accountInfoPremiumYang").'
    <span class="text-primary">'.User::getYangPremium($_SESSION["username"]).'</span></li>';

    echo '</ul>';
    echo '</div>';
}
?>