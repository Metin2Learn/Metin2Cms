<div class="box">
    <h2><?= Language::getTranslation("logoutTitle");?></h2>
    <p><?= Language::getTranslation("logoutDesc");?></p>
</div>
<?php

$_SESSION = array();
session_destroy();
Core::redirect(Links::getUrl("home"), 2);
?>