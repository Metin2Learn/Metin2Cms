<?php
$rank = new Rankings();

?>
<div class="box servers">

    <h2><?= Language::getTranslation("guildRankTitle");?></h2>



    <?php
    if($rank->numberOfGuilds() <= 0)
    {
        echo Core::result(Language::getTranslation("guildRankNoGuilds"),4);
    } else {

        // Paginator
        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
        global $dbname;
        $totalCount = $rank->numberOfGuilds();
        $perPage = $rank->showPerPage();
        $paginator = new Paginator($page, $totalCount, $perPage);
        // Paginator

        //Validate page
        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
            Core::redirect(Links::getUrl("guilds"), 0);
        }
        //Validate page

        //Print guilds and pagination
        $dbPlayer = Core::getPlayerDatabase();
        $rank->printGuildsRanking("SELECT * FROM " . $dbPlayer . ".guild ORDER BY `level` DESC, `ladder_point` DESC, `win` DESC, `exp` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
        $paginator->printLinks("guilds/", "pagination");
        //Print guilds and pagination

    }
    ?>
</div>