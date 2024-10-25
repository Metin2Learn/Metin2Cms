<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$custom = new CustomPages();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("customPages") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("customPages") ?></li>
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
    if (isset($_POST["add_page"])) {

        $title = $_POST["title"];
        $content = $_POST["content"];
        if(isset($_POST["add_to_menu"]))
        {
            $add = 1;
        } else {
            $add = 0;
        }
        if(mb_strlen($title) <= 0 OR mb_strlen($title) > 50)
        {
            $result = Core::result(Language::getTranslation("rangeTitleError"), 2);
        } else {
            $custom->add($title, $content, $_SESSION["username"]);
            if($add == 1)
            {
                $lastID = $custom->getLastID();
                Links::addLink(Core::getBaseURL().'viewpage/'.$lastID, $title, 1, null);
            }
            $result = Core::result(Language::getTranslation("pageAdded"), 1);
        }
    }


    if (isset($result)) {
        echo $result;
    }
    ?>
    <form method="POST" action="index.php?page=custom-pages&action=add" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("content") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="content" name="content"></textarea>
            </div>
        </div>


        <div class="form-group">
            <label
                class="col-sm-3 control-label"><?= Language::getTranslation("addToMenu") ?></label>

            <div class="col-sm-7">
                <input type="checkbox" name="add_to_menu" class="js-switch">
            </div>
        </div>



        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="add_page"><?= Language::getTranslation("submit") ?></button>
        </div>
    </form>
<?php
} elseif(isset($_GET["edit"]) AND $custom->exists($_GET["edit"]))
{
    $info = $custom->info($_GET["edit"]);

    if (isset($_POST["update_page"])) {

        $title = $_POST["title"];
        $content = $_POST["content"];
        if(mb_strlen($title) <= 0 OR mb_strlen($title) > 50)
        {
            $result = Core::result(Language::getTranslation("rangeTitleError"), 2);
        } else {
            $custom->update($title, $content, $_GET["edit"]);

            $result = Core::result(Language::getTranslation("pageUpdated"), 1);
        }

    }


    if (isset($result)) {
        echo $result;
    }

    ?>
    <form method="POST" action="index.php?page=custom-pages&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" value="<?= $info["title"] ?>" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("content") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="content" name="content"><?= $info["content"] ?></textarea>
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="update_page"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
<?php

} else {

    if(isset($_GET["delete"]) AND $custom->exists($_GET["delete"]))
    {
        $custom->delete($_GET["delete"]);
        $result = Core::result(Language::getTranslation("pageDeleted"), 1);
    }

    if (isset($result)) {
        echo $result;
    }

    echo '<a href="index.php?page=custom-pages&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("createNewPage").'</button></a>';

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = $custom->count();
    $perPage = 10;
    $paginator = new Paginator($page, $totalCount, $perPage);
    // Paginator

    // Validate page
    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
        Core::redirect("index.php?page=custom-pages", 0);
        die();
    }
    // Validate page


    // Print all news and pagination links
    global $dbname;
    $custom->printPages("SELECT * FROM " . $dbname . ".custom_pages ORDER BY added DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    $paginator->printLinks("index.php?page=custom-pages&pagination=", "pagination");
    // Print all news and pagination links
}
?>
</div>
</div>
</div>
</div>
</section>