<?php
if(Admin::hasRight($_SESSION["username"], "e") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}


if(isset($_POST["add_news"]))
{

    $title = $_POST["title"];
    if(isset($_POST["intro"]) AND mb_strlen($_POST["intro"]) > 11) {
        $intro = $_POST["intro"];
    } else {
        $intro = NULL;
    }
    $full = $_POST["full"];
    $img = $_FILES["image"];
    if($img["size"] > 0)
    {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $path = "../assets/images/news/";
        $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
        $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
        $img_submitted = true;
    } else {
        $new_file_name = NULL;
        $img_submitted = false;
    }
    $author = $_POST["author"];
    if(isset($_POST["important"]))
    {
        $important = 1;
    } else {
        $important = 0;
    }

    if(empty($title) OR empty($full) OR empty($author)) {
        $result = Core::result(Language::getTranslation("emptyError"), 2);
    } elseif($img_submitted AND $img["error"] == 1)
    {
        $result = Core::result(Language::getTranslation("imageTooBig"), 2);
    } elseif($img_submitted AND ($img["error"] != 0))
    {
        $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
    } elseif($img_submitted AND getimagesize($img["tmp_name"]) == false)
    {
        $result = Core::result(Language::getTranslation("isNotImage"), 2);
    } elseif($img_submitted AND !in_array($img_ext, $allowed))
    {
        $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
    } elseif($img_submitted AND file_exists($path.$new_file_name))
    {
        $result = Core::result(Language::getTranslation("imageExists"), 2);
    } else {
        $result = Core::result(Language::getTranslation("newsSubmitted"), 1);
        News::addNews($title, $intro, $full, $author, $important, $new_file_name);
        if($img_submitted)
        {
            move_uploaded_file($img["tmp_name"], $path.$new_file_name);
        }
    }

}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addNews") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("news") ?></a></li>
        <li class="active"><?= Language::getTranslation("addNews") ?></li>
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
                    <form method="POST" action="index.php?page=add-news" class="form-horizontal" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("introNews") ?></label>
                            <div class="col-sm-7">
                                <textarea class="form-control" rows="2" id="intro_news" name="intro"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("fullNews") ?></label>
                            <div class="col-sm-7">
                                <textarea class="form-control" rows="2" id="full_news" name="full"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>
                            <div class="col-sm-7">
                                <input type="file" name="image" id="fileToUpload" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("author") ?></label>
                            <div class="col-sm-7">
                                <input type="text" value="<?= $_SESSION["username"] ?>" name="author" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("stickToTop") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="important" class="js-switch" />
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_news"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>