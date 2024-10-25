<?php
$custom = new CustomPages();
if(isset($_GET["id"]) AND $custom->exists($_GET["id"]))
{
    $info = $custom->info($_GET["id"]);
    echo '<div class="box">';
    echo $info["content"];
    echo '</div>';

} else {
    Core::redirect(Links::getUrl("error"));
}

?>