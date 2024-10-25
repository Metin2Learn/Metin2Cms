<?php
if(Admin::hasRight($_SESSION["username"], "h") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$news = new News();
?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("newsComments") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("news") ?></a></li>
        <li class="active"><?= Language::getTranslation("newsComments") ?></li>
    </ol>
</section>

<?php
if(isset($_GET["show"]) AND $news->doesExists($_GET["show"]))
{
    if(isset($_GET["delete"]) AND $news->commentExists($_GET["delete"]))
    {
        $news->deleteComment($_GET["delete"]);
        $result = Core::result(Language::getTranslation("commentDeleted"),1);
    }
    ?>
    <section class="content">
        <div class="row">
            <!-- BEGIN CUSTOM TABLE -->
            <div class="col-md-12">
                <div class="grid no-border">
                    <div class="grid-header">
                        <span class="grid-title"><?= Language::getTranslation("showingCommentsFor").$_GET["show"].
                            " (".$news->getTitle($_GET["show"]).")" ?></span>
                    </div>
                    <div class="grid-body">
                        <?php
                        if(isset($result)) { echo $result; }
                        if($news->numberOfComments($_GET["show"]) > 0)
                        {

                            // Paginator
                            $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                            $totalCount = $news->numberOfComments($_GET["show"]);
                            $perPage = $news->commentsPerPage();
                            $paginator = new Paginator($page, $totalCount, $perPage);
                            // Paginator

                            // Validate page
                            if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                                Core::redirect("index.php?page=news-comments&show=".$_GET["show"], 0);
                                die();
                            }
                            // Validate page


                            // Print all news and pagination links
                            global $dbname;
                            $news->printAdminComments("SELECT * FROM " . $dbname . ".news_comments WHERE news_id = ? ORDER BY `date` DESC LIMIT ? OFFSET ?",
                                array($_GET["show"], $perPage, $paginator->offset()), $_GET["show"]);
                            $paginator->printLinks("index.php?page=news-comments&show=".$_GET["show"]."&pagination=", "pagination");
                            // Print all news and pagination links

                        } else {
                            echo Core::result(Language::getTranslation("zeroComments"), 4);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    Core::redirect("index.php?page=all-news");
}
?>