<?php
if(Admin::hasRight($_SESSION["username"], "l") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$dl = new Download();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editDownload") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("downloads") ?></a></li>
        <li><a href="index.php?page=all-downloads"><?= Language::getTranslation("viewDownloads") ?></a></li>
        <li class="active"><?= Language::getTranslation("editDownload") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["id"]) AND $dl->exists($_GET["id"])) {
                        if(isset($_POST["update_download"]))
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
                                $dl->update($title, $desc, $size, $link, $_GET["id"]);
                                $result = Core::result(Language::getTranslation("updated"), 1);
                            }
                        }

                        $info = $dl->getInfo($_GET["id"]);
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=edit-download&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["title"] ?>" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("descriptionOptional") ?></label>

                                <div class="col-sm-7">
                                    <textarea class="form-control" rows="2" id="intro_news" name="desc"><?= $info["desc"] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" placeholder="<?= Language::getTranslation("withHttp") ?>"
                                           value="<?= $info["link"] ?>" name="link" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("dlTableSize") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" placeholder="<?= Language::getTranslation("includeUnits") ?>"
                                           value="<?= $info["size"] ?>" name="size" class="form-control" required>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update_download"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>
                    <?php
                    } else {
                        echo Core::result(Language::getTranslation("downloadWasNotFound"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
