<div class="box sidebar-box widget-wrapper">
    <h3><?= Language::getTranslation("statisticsTitle");?></h3>
    <ul class="nav nav-sidebar">
        <li><a><?= Language::getTranslation("statisticsAccounts");?><span><?= Core::numberOfAccounts();?></span></a></li>
        <li><a><?= Language::getTranslation("statisticsPlayers");?><span><?= Core::numberOfPlayers();?></span></a></li>
        <li><a><?= Language::getTranslation("statisticsOnlinePlayers");?><span><?= Player::playersOnline();?></span></a></li>
        <li><a><?= Language::getTranslation("statisticsMaxLevel");?><span>255</span></a></li>
    </ul>
</div>