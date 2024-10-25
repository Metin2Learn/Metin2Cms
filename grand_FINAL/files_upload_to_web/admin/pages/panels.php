<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$panels = new Panel();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("panels") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("panels") ?></li>
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
    if (isset($_POST["add_panel"])) {

        $title = $_POST["title"];
        $content = $_POST["content"];
        if(isset($_POST["visible"]))
        {
            $visible = 1;
        } else {
            $visible = 0;
        }
        $panels->addPanel($title, $content, $visible);
        $result = Core::result(Language::getTranslation("panelAdded"), 1);
    }


    if (isset($result)) {
        echo $result;
    }
    ?>
    <form method="POST" action="index.php?page=panels&action=add" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("contentHtml") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="full_news" name="content"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label
                class="col-sm-3 control-label"><?= Language::getTranslation("visible") ?></label>

            <div class="col-sm-7">
                <input type="checkbox" name="visible" class="js-switch" checked>
            </div>
        </div>


        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="add_panel"><?= Language::getTranslation("submit") ?></button>
        </div>
    </form>
<?php
} elseif(isset($_GET["edit"]) AND $panels->panelExists($_GET["edit"]))
{
    $info = $panels->panelInfo($_GET["edit"]);

    if (isset($_POST["update_panel"])) {

        $title = $_POST["title"];
        $content = $_POST["content"];
        if(isset($_POST["visible"]))
        {
            $visible = 1;
        } else {
            $visible = 0;
        }
        $panels->updatePanel($title, $content, $visible, $_GET["edit"]);
        $result = Core::result(Language::getTranslation("panelUpdated"), 1);

    }


    if (isset($result)) {
        echo $result;
    }

    ?>
    <form method="POST" action="index.php?page=panels&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["title"] ?>" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("contentHtml") ?></label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="2" id="full_news" name="content"><?= $info["content"] ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label
                class="col-sm-3 control-label"><?= Language::getTranslation("visible") ?></label>

            <div class="col-sm-7">
                <?php
                if($info["active"] == 1)
                {
                    echo '<input type="checkbox" name="visible" class="js-switch" checked>';
                } else {
                    echo '<input type="checkbox" name="visible" class="js-switch">';
                }
                ?>
            </div>
        </div>


        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="update_panel"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
<?php

} else {

    if(isset($_GET["delete"]) AND $panels->panelExists($_GET["delete"]))
    {
        $panels->deletePanel($_GET["delete"]);
        $result = Core::result(Language::getTranslation("panelDeleted"), 1);
    }

    if (isset($result)) {
        echo $result;
    }

    echo '<a href="index.php?page=panels&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addPanel").'</button></a>';

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = $panels->getNumberOfPanels(false);
    $perPage = 10;
    $paginator = new Paginator($page, $totalCount, $perPage);
    // Paginator

    // Validate page
    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
        Core::redirect("index.php?page=panels", 0);
        die();
    }
    // Validate page


    // Print all news and pagination links
    global $dbname;
    $panels->printAdminPanels("SELECT * FROM " . $dbname . ".panels ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    $paginator->printLinks("index.php?page=panels&pagination=", "pagination");
    // Print all news and pagination links
}
?>
</div>
</div>
</div>
</div>
</section>