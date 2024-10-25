<?php
if (Admin::hasRight($_SESSION["username"], "o") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

$team = new Team();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewTeamMember") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("teamMembers") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewTeamMember") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["delete"]) AND $team->memberExists($_GET["delete"]) AND Admin::hasRight($_SESSION["username"], "r"))
                    {
                        $team->deleteMember($_GET["delete"]);
                        $result = Core::result(Language::getTranslation("memberDeleted"), 1);
                    }

                    if(isset($result)) { echo $result; }

                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    $totalCount = $team->numberOfAllMembers();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-team-members", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $team->printAllMembers("SELECT * FROM " . $dbname . ".team_members LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-team-members&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>