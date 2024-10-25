<?php
if(Admin::hasRight($_SESSION["username"], "g1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

if(isset($_GET["delete"]) AND Admin::webAdminExists($_GET["delete"]) AND Admin::hasRight($_SESSION["username"], "ch1"))
{
    Admin::deleteWebAdmin($_GET["delete"]);
    $result = Core::result(Language::getTranslation("webAdminDeleted"), 1);
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewWebAdministrators") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewWebAdministrators") ?></li>
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
                    $totalCount = Admin::numberOfWebAdmins();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-web-admins", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    Admin::printWebAdmins("SELECT * FROM " . $dbname . ".admins ORDER BY id LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-web-admins&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>