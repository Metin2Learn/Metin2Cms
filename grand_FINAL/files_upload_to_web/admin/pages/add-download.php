<?php
if(Admin::hasRight($_SESSION["username"], "k") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$dl = new Download();

if(isset($_POST["add_download"]))
{
    $title = $_POST["title"];
    $link = $_POST["link"];
    $size = $_POST["size"];
    if(isset($_POST["desc"]) AND mb_strlen($_POST["desc"]) > 1) {
        $desc = $_POST["desc"];
    } else {
        $desc = '';
    }
    if(empty($title) OR empty($link) OR empty($size))
    {
        $result = Core::result(Language::getTranslation("youNeedToEnter"), 2);
    } elseif(filter_var($link, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) == false)
    {
        $result = Core::result(Language::getTranslation("linkInvalid"), 2);
    } else {
        $dl->addDownload($title, $desc, $size, $link, $_SESSION["username"]);
        $result = Core::result(Language::getTranslation("downloadAdded"), 1);
    }
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addDownload") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("downloads") ?></a></li>
        <li class="active"><?= Language::getTranslation("addDownload") ?></li>
    </ol>
</section>
<!-- END CONTENT HEADER -->

<!-- BEGIN MAIN CONTENT -->
<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="POST" action="index.php?page=add-download" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("descriptionOptional") ?></label>
                            <div class="col-sm-7">
                                <textarea class="form-control" rows="2" id="intro_news" name="desc"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>
                            <div class="col-sm-7">
                                <input type="text" placeholder="<?= Language::getTranslation("withHttp") ?>" name="link" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("dlTableSize") ?></label>
                            <div class="col-sm-7">
                                <input type="text" placeholder="<?= Language::getTranslation("includeUnits") ?>" name="size" class="form-control" required>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_download"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
