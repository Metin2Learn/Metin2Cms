<?php
$rank = new Rankings();



?>
<div class="box servers">

    <h2><?= Language::getTranslation("playerRankTitle");?></h2>



<?php
if($rank->numberOfPlayers() <= 0)
{
    echo Core::result(Language::getTranslation("playerRankNoPlayers"),4);
} else {

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    global $dbname;
    $totalCount = $rank->numberOfPlayers();
    $perPage = $rank->showPerPage();
    $paginator = new Paginator($page, $totalCount, $perPage);
    // Paginator

    //Validate page
    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
        Core::redirect(Links::getUrl("players"), 0);
    }
    //Validate page

    //Print players and pagination
    $dbPlayer = Core::getPlayerDatabase();
    $notShow = Rankings::prefixNotShow();
    if(mb_strlen($notShow) > 1)
    {
        $notShow = str_replace(" ", "", $notShow);
        $explode = explode(",", $notShow);
        $where = "";
        foreach($explode as $row)
        {
            $where .= "`name` NOT LIKE '".$row."%' AND ";
        }
        $rank->printPlayersRanking("SELECT * FROM " . $dbPlayer . ".player WHERE ".substr($where, 0, -5)." ORDER BY `level` DESC, `exp` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    } else {
        $rank->printPlayersRanking("SELECT * FROM " . $dbPlayer . ".player ORDER BY `level` DESC, `exp` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    }
    $paginator->printLinks("players/", "pagination");
    //Print players and pagination

}
?>
</div>