<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$slider = new Slider();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("slider") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("slider") ?></li>
    </ol>
</section>

<section class="content">
<div class="row">
<!-- BEGIN CUSTOM TABLE -->
<div class="col-md-12">
<div class="grid no-border">
<div class="grid-body">
<?php
if(isset($_GET["action"]) AND $_GET["action"] == 'add') {
    if (isset($_POST["add_slider_item"])) {

        $title = $_POST["title"];
        if(isset($_POST["mini_description"]) AND mb_strlen($_POST["mini_description"]) > 0)
        {
            $mini_description = $_POST["mini_description"];
        } else {
            $mini_description = '';
        }
        if(isset($_POST["link"]) AND mb_strlen($_POST["link"]) > 0)
        {
            $link = $_POST["link"];
        } else {
            $link = '';
        }

        $img = $_FILES["image"];
        if($img["size"] > 0)
        {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $path = "../assets/images/slider/";
            $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
            $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
            $img_submitted = true;
        } else {
            $new_file_name = NULL;
            $img_submitted = false;
        }


        if(empty($title))
        {
            $result = Core::result(Language::getTranslation("youMustFillInAllFields"), 2);
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
        } elseif($img_submitted == false)
        {
            $result = Core::result(Language::getTranslation("youHaveToUploadImage"), 2);
        } else {
            $slider->addItem($link, $new_file_name, $title, $mini_description, $title);
            $result = Core::result(Language::getTranslation("sliderAdded"), 1);
            if($img_submitted)
            {
                move_uploaded_file($img["tmp_name"], $path.$new_file_name);
            }
        }

    }


    if (isset($result)) {
        echo $result;
    }
    ?>
    <form method="POST" action="index.php?page=slider&action=add" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>

            <div class="col-sm-7">
                <input type="text" name="mini_description" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" name="link" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("image") ?></label>
            <div class="col-sm-7">
                <input type="file" name="image" id="fileToUpload" class="form-control">
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="add_slider_item"><?= Language::getTranslation("submit") ?></button>
        </div>
    </form>
<?php
} elseif(isset($_GET["edit"]) AND $slider->exists($_GET["edit"]))
{
    $info = $slider->getInfo($_GET["edit"]);

    if (isset($_POST["update_slider"])) {

        $title = $_POST["title"];
        if(isset($_POST["mini_description"]) AND mb_strlen($_POST["mini_description"]) > 0)
        {
            $mini_description = $_POST["mini_description"];
        } else {
            $mini_description = '';
        }
        if(isset($_POST["link"]) AND mb_strlen($_POST["link"]) > 0)
        {
            $link = $_POST["link"];
        } else {
            $link = '';
        }

        $img = $_FILES["image"];
        if($img["size"] > 0)
        {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $path = "../assets/images/slider/";
            $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
            $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
            $img_submitted = true;
        } else {
            $new_file_name = $info["img"];
            $img_submitted = false;
        }


        if(empty($title))
        {
            $result = Core::result(Language::getTranslation("youMustFillInAllFields"), 2);
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
            $slider->updateItem($link, $new_file_name, $title, $mini_description, $title, $_GET["edit"]);
            $result = Core::result(Language::getTranslation("sliderUpdated"), 1);
            if($img_submitted)
            {
                move_uploaded_file($img["tmp_name"], $path.$new_file_name);
            }
        }

    }


    if (isset($result)) {
        echo $result;
    }

    ?>
    <form method="POST" action="index.php?page=slider&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["description"] ?>" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["mini_description"] ?>" name="mini_description" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["link"] ?>" name="link" class="form-control">
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
                    <img class="img-responsive" src="../assets/images/slider/<?= $info["img"] ?>">
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

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="update_slider"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
<?php

} else {

    if(isset($_GET["delete"]) AND $slider->exists($_GET["delete"]))
    {
        $slider->delete($_GET["delete"]);
        $result = Core::result(Language::getTranslation("sliderDeleted"), 1);
    }

    if (isset($result)) {
        echo $result;
    }

    echo '<a href="index.php?page=slider&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addNewSliderItem").'</button></a>';

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = $slider->getNumberOfSliderItems();
    $perPage = 10;
    $paginator = new Paginator($page, $totalCount, $perPage);
    // Paginator

    // Validate page
    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
        Core::redirect("index.php?page=menu-links", 0);
        die();
    }
    // Validate page


    // Print all news and pagination links
    global $dbname;
    $slider->printSliderItems("SELECT * FROM " . $dbname . ".slider ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    $paginator->printLinks("index.php?page=slider&pagination=", "pagination");
    // Print all news and pagination links
}
?>
</div>
</div>
</div>
</div>
</section>