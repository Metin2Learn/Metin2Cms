<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box list-matches">';
    echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - ' .
        Language::getTranslation("ticketSysTitle") . '</h2>';
    if(Core::ticketSystemEnabled())
    {
        echo '<div class="list-group">';
        echo '<a href="'.Links::getUrl("account ticket-add").'" class="list-group-item active">'.Language::getTranslation("ticketSysCreate").'</a>';
        echo '<a href="'.Links::getUrl("account ticket-view").'" class="list-group-item">'.Language::getTranslation("ticketSysView").'</a>';
        echo '</div>';
    } else {
        echo Core::result(Language::getTranslation("ticketSysNotEnabled"),4);
        Core::redirect(Links::getUrl("account"), 2);
    }
}

?>