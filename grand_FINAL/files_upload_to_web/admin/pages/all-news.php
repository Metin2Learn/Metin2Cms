<?php
if(Admin::hasRight($_SESSION["username"], "f") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$news = new News();

if(isset($_GET["delete"]) AND $news->doesExists($_GET["delete"]))
{
    $news->remove($_GET["delete"]);
    $result = Core::result(Language::getTranslation("newsRemoved"), 1);
}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewNews") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("news") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewNews") ?></li>
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
                $totalCount = News::NumberOfNews();
                $perPage = $news->getNewsPerPage();
                $paginator = new Paginator($page, $totalCount, $perPage);
                // Paginator

                // Validate page
                if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                    Core::redirect("index.php?page=all-news", 0);
                    die();
                }
                // Validate page


                // Print all news and pagination links
                global $dbname;
                News::printAdminNews("SELECT * FROM " . $dbname . ".news ORDER BY `important` DESC, `date` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                $paginator->printLinks("index.php?page=all-news&pagination=", "pagination");
                // Print all news and pagination links
                ?>
            </div>
        </div>
    </div>
</div>
</section>
    <!-- END CUSTOM TABLE -->