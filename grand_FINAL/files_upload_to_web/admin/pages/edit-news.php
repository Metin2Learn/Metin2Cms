<?php
if(Admin::hasRight($_SESSION["username"], "g") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editNews") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("news") ?></a></li>
        <li><a href="index.php?page=all-news"><?= Language::getTranslation("viewNews") ?></a></li>
        <li class="active"><?= Language::getTranslation("editNews") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
<?php
$news = new News();
if(isset($_GET["id"]) AND $news->doesExists($_GET["id"]))
{
    $info = News::adminInfo($_GET["id"]);

    if(isset($_POST["edit_news"]))
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
            $new_file_name = $info["img"];
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
            $result = Core::result(Language::getTranslation("successfullyUpdated"), 1);
            global $dbname;
            if($img_submitted)
            {
                Database::query("UPDATE ".$dbname.".news SET title = ?, intro = ?, content = ?, author = ?,
                important = ?, img = ? WHERE id = ?",
                    array($title, $intro, $full, $author, $important, $new_file_name, $_GET["id"]));
                move_uploaded_file($img["tmp_name"], $path.$new_file_name);
            } else {
                Database::query("UPDATE ".$dbname.".news SET title = ?, intro = ?, content = ?, author = ?,
                important = ? WHERE id = ?",
                    array($title, $intro, $full, $author, $important, $_GET["id"]));
            }
        }

    }


    if(isset($result)) { echo $result; }
    ?>
    <form method="POST" action="index.php?page=edit-news&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>
            <div class="col-sm-7">
                <input type="text" name="title" value="<?= $info["title"] ?>" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("introNews") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="intro_news" name="intro"><?= $info["intro"] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("fullNews") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="full_news" name="full"><?= $info["content"] ?></textarea>
            </div>
        </div>
        <?php
        if($info["img"] == NULL OR $info["img"] == '') {
            ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>

                <div class="col-sm-7">
                    <input type="file" name="image" id="fileToUpload" class="form-control">
                </div>
            </div>
        <?php
        } else {
            ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>

                <div class="col-sm-7">
                    <img class="img-responsive" src="../assets/images/news/<?= $info["img"] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= Language::getTranslation("newImage") ?></label>

                <div class="col-sm-7">
                    <input type="file" name="image" id="fileToUpload" class="form-control">
                </div>
            </div>
            <?php
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("author") ?></label>
            <div class="col-sm-7">
                <input type="text" value="<?= $info["author"] ?>" name="author" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("stickToTop") ?></label>
            <div class="col-sm-7">
                <input type="checkbox" name="important" class="js-switch"
                <?php if($info["important"] == 1) { echo " checked"; } ?>
                >
            </div>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-primary" name="edit_news"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
    <?php


} else {
    echo Core::result(Language::getTranslation("newsWasNotFound"), 2);
}

?>
                </div>
            </div>
        </div>
    </div>
</section>