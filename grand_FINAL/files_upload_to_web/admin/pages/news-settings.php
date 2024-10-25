<?php
if(Admin::hasRight($_SESSION["username"], "g") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$news = new News();

if(isset($_POST["update_settings"]))
{
    if(isset($_POST["news_per_page"]) AND ctype_digit($_POST["news_per_page"]))
    {
        $news_per_page = $_POST["news_per_page"];
        Core::updateSettings("news_per_page", $news_per_page);
    }

    if(isset($_POST["enable_comments"]))
    {
        $enable_comments = 1;
        Core::updateSettings("news_comments", $enable_comments);
    } else {
        $enable_comments = 0;
        Core::updateSettings("news_comments", $enable_comments);
    }

    if(isset($_POST["only_users_comments"]))
    {
        $only_users_comments = 1;
        Core::updateSettings("news_comments_login_only", $only_users_comments);
    } else {
        $only_users_comments = 0;
        Core::updateSettings("news_comments_login_only", $only_users_comments);
    }

    if(isset($_POST["comments_per_page"]) AND ctype_digit($_POST["comments_per_page"]))
    {
        $comments_per_page = $_POST["comments_per_page"];
        Core::updateSettings("news_comments_per_page", $comments_per_page);
    }

    $result = Core::result(Language::getTranslation("settingsUpdated"), 1);

}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("newsSettings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("news") ?></a></li>
        <li class="active"><?= Language::getTranslation("newsSettings") ?></li>
    </ol>
</section>

<section class="content">

    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="post" action="index.php?page=news-settings" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("newsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="news_per_page" value="<?= $news->getNewsPerPage() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableComments") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="enable_comments" class="js-switch"
                                    <?php if($news->commentsEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <?php
                        if($news->commentsEnabled()) {
                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("onlyUsersCanComments") ?></label>
                                <div class="col-sm-7">
                                    <input type="checkbox" name="only_users_comments" class="js-switch"
                                        <?php if($news->onlyUsersComments()) { echo " checked"; } ?>
                                        >
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("commentsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="comments_per_page" value="<?= $news->commentsPerPage() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"
                                    class="btn btn-primary" name="update_settings"><?= Language::getTranslation("update") ?></button>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <!-- END BASIC ELEMENTS -->
    </div>
</section>