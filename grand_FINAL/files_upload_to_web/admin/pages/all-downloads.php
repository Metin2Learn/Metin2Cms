<?php
if(Admin::hasRight($_SESSION["username"], "j") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$dl = new Download();

if(isset($_GET["delete"]) AND $dl->exists($_GET["delete"]))
{
    $dl->remove($_GET["delete"]);
    $result = Core::result(Language::getTranslation("downloadRemoved"), 1);
}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewDownloads") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("downloads") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewDownloads") ?></li>
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
                    $totalCount = $dl->numberOfDownloads();
                    $perPage = $dl->showPerPage();
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-downloads", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $dl->printAdminDownloads("SELECT * FROM " . $dbname . ".downloads ORDER BY `order` DESC, `date` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-downloads&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END CUSTOM TABLE -->