<?php
if(Admin::hasRight($_SESSION["username"], "m1") == false OR !isset($_GET["phrase"]))
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$phrase = str_replace(' ', '', $_GET["phrase"]);
$search = new Search();
?>
    <section class="content-header">
        <i class="fa fa-align-left"></i>
        <span><?= Language::getTranslation("search") ?></span>
        <ol class="breadcrumb">
            <li><?= Language::getTranslation("search") ?></a></li>
        </ol>
    </section>

<section class="content">
    <div class="row">
    <!-- BEGIN CUSTOM TABLE -->
    <div class="col-md-12">
    <div class="grid no-border">
    <div class="grid-body">
        <?php

        ?>
    <form method="get" class="form-horizontal" role="form">
        <div class="form-group">
            <input type="hidden" class="hidden" name="page" value="search">
            <div class="col-sm-2">
                <input type="text" value="<?= $phrase ?>" name="phrase" class="form-control" required>
            </div>
            <div class="col-sm-3">
                <input type="submit" value="<?= Language::getTranslation("search") ?>" class="btn btn-primary">
            </div>
        </div>
    </form>
        <?= Core::result(Language::getTranslation("searchHint"), 3) ?>

        <hr />
    <?php
    ///////////////////////////////ACCOUNTS///////////////////////////
    // Paginator
    echo "<h4 class='text-danger'>".Language::getTranslation('accounts')."</h4>";
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = $search->numberOfAccounts($phrase);
    $perPage = 10;
    $paginator = new Paginator($page, $totalCount, $perPage);
    // Paginator

    // Validate page
    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
        Core::redirect("index.php?page=search&phrase=".$phrase, 0);
        die();
    }
    // Validate page


    // Print all news and pagination links
    if($search->numberOfAccounts($phrase) > 0) {

        $dbaccount = Core::getAccountDatabase();
        $search->printAccounts("SELECT * FROM " . $dbaccount . ".account WHERE login = ? OR
            login LIKE ? OR login LIKE ? OR login LIKE ? OR register_ip = ? OR last_ip = ? LIMIT ? OFFSET ?",
            array($phrase, '%' . $phrase, $phrase . '%', '%' . $phrase . '%',$phrase,$phrase, $perPage, $paginator->offset()));
        $paginator->printLinks("index.php?page=search&phrase=" . $phrase . "&pagination=", "pagination");
        // Print all news and pagination links
    } else {
        echo Core::result(Language::getTranslation("accountsNotFound"), 4);
    }
    ///////////////////////////////PLAYERS///////////////////////////
    ?>
        <br /><hr />
        <?php
        // Paginator
        echo "<h4 class='text-danger'>".Language::getTranslation('players')."</h4>";
        $page2 = isset($_GET["pagination2"]) ? (int)$_GET["pagination2"] : 1;
        $totalCount2 = $search->numberOfPlayers($phrase);
        $perPage2 = 10;
        $paginator2 = new Paginator($page2, $totalCount2, $perPage2);
        // Paginator

        // Validate page
        if (isset($_GET["pagination2"]) AND (!ctype_digit($_GET["pagination2"]) OR $_GET["pagination2"] > ceil($totalCount2 / $perPage2) OR $_GET["pagination2"] < 1)) {
            Core::redirect("index.php?page=search&phrase=".$phrase, 0);
            die();
        }
        // Validate page


        // Print all news and pagination links
        if($search->numberOfPlayers($phrase) > 0) {

            $dbplayer = Core::getPlayerDatabase();
            $search->printPlayers("SELECT * FROM ".$dbplayer.".player WHERE `name` = ? OR
            `name` LIKE ? OR `name` LIKE ? OR `name` LIKE ? OR ip = ? LIMIT ? OFFSET ?",
                array($phrase, '%' . $phrase, $phrase . '%', '%' . $phrase . '%',$phrase, $perPage2, $paginator2->offset()));
            $paginator2->printLinks("index.php?page=search&phrase=" . $phrase . "&pagination2=", "pagination2");
            // Print all news and pagination links
        } else {
            echo Core::result(Language::getTranslation("playersNotFound"), 4);
        }
        ?>
        <hr />
    </div>
    </div>
    </div>
    </div>
</section>