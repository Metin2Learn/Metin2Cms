<?php

if(!User::isLogged()) {
    Core::redirect(Links::getUrl("login"));
} else {
    echo "<div class='box'>
</div>";
}

?>