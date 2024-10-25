<?php
if(Admin::hasRight($_SESSION["username"], "s") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$team = new Team();

if(isset($_GET["delete"]) AND $team->categoryExists($_GET["delete"]))
{
    $team->removeCategory($_GET["delete"]);
    $result = Core::result(Language::getTranslation("categoryDeleted"), 1);
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewCategories") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("teamMembers") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewCategories") ?></li>
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
                    $totalCount = $team->numberOfCategories();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-team-categories", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $team->printAdminMembers("SELECT * FROM " . $dbname . ".team_category LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-team-categories&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>