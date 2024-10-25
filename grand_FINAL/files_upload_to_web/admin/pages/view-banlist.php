<?php
if(Admin::hasRight($_SESSION["username"], "m1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewBanList") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("game") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewBanList") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }

                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    $totalCount = User::bannedUsers();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=view-banlist", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    $dbaccount = Core::getAccountDatabase();
                    User::printBanList("SELECT * FROM " . $dbaccount . ".account WHERE status = 'BLOCK' LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=view-banlist&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>