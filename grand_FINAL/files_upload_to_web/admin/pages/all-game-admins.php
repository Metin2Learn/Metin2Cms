<?php
if(Admin::hasRight($_SESSION["username"], "f1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

if(isset($_GET["delete"]) AND Admin::gameAdminExists($_GET["delete"]) AND Admin::hasRight($_SESSION["username"], "h1"))
{
    Admin::deleteGameAdmin($_GET["delete"]);
    $result = Core::result(Language::getTranslation("gameAdminDeleted"), 1);
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewGameAdministrators") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewGameAdministrators") ?></li>
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
                    $totalCount = Admin::numberOfGameAdmins();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-game-admins", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    $common_db = Core::getCommonDatabase();
                    Admin::printGameAdmins("SELECT * FROM " . $common_db . ".gmlist ORDER BY mID LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-game-admins&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>