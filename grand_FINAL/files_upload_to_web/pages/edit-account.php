<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box">';
    echo '<h2><a href="'.Links::getUrl("account").'">'.Language::getTranslation("accountTitle").'</a> - '.Language::getTranslation("editAccountTitle").'</h2>';
    echo '<div class="list-group">';
    echo '<a href="'.Links::getUrl("account change-pw").'" class="list-group-item">'.Language::getTranslation("editAccountChangePW").'</a>';
    echo '<a href="'.Links::getUrl("account change-warehouse-pw").'" class="list-group-item">'.Language::getTranslation("changeWarehousePasswordTitle").'</a>';
    if(Core::changeEmailEnabled())
    {
        echo '<a href="'.Links::getUrl("account change-email").'" class="list-group-item">'.Language::getTranslation("changeEmailTitle").'</a>';
    }
    echo '</div>';
    echo '</div>';


}

?>