<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$partners = new Partners();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("partners") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("partners") ?></li>
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
    if (isset($_POST["add_partner"])) {

        $title = $_POST["title"];
        $link = $_POST["link"];
        $img = $_POST["img"];
        $alt = $_POST["alt"];
        if(isset($_POST["blank"]))
        {
            $blank = 1;
        } else {
            $blank = 0;
        }
        $partners->addPartner($title, $alt, $link, $img, $blank);
        $result = Core::result(Language::getTranslation("partnerAdded"), 1);

    }


    if (isset($result)) {
        echo $result;
    }
    ?>
    <form method="POST" action="index.php?page=partners&action=add" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" name="link" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("imgUrl") ?></label>

            <div class="col-sm-7">
                <input type="text" name="img" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("altDesc") ?></label>
            <div class="col-sm-7">
                <input type="text" name="alt" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("openInNewWindow") ?></label>
            <div class="col-sm-7">
                <input type="checkbox" name="blank" class="js-switch" />
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="add_partner"><?= Language::getTranslation("submit") ?></button>
        </div>
    </form>
<?php
} elseif(isset($_GET["edit"]) AND $partners->exists($_GET["edit"]))
{
    $info = $partners->info($_GET["edit"]);

    if (isset($_POST["edit_partner"])) {

        $title = $_POST["title"];
        $link = $_POST["link"];
        $img = $_POST["img"];
        $alt = $_POST["alt"];
        if(isset($_POST["blank"]))
        {
            $blank = 1;
        } else {
            $blank = 0;
        }
        $partners->updatePartner($title, $alt, $link, $img, $blank, $_GET["edit"]);
        $result = Core::result(Language::getTranslation("partnerUpdated"), 1);

    }


    if (isset($result)) {
        echo $result;
    }

    ?>
    <form method="POST" action="index.php?page=partners&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["title"] ?>" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["link"] ?>" name="link" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("imgUrl") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["img"] ?>" name="img" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("altDesc") ?></label>
            <div class="col-sm-7">
                <input type="text" value="<?= $info["alt"] ?>" name="alt" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("openInNewWindow") ?></label>
            <div class="col-sm-7">
                <?php
                if($info["blank"] == 1)
                {
                    echo '<input type="checkbox" name="blank" class="js-switch" checked>';
                } else {
                    echo '<input type="checkbox" name="blank" class="js-switch" />';
                }
                ?>
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="edit_partner"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
<?php

} else {

    if(isset($_GET["delete"]) AND $partners->exists($_GET["delete"]))
    {
        $partners->delete($_GET["delete"]);
        $result = Core::result(Language::getTranslation("partnerDeleted"), 1);
    }

    if (isset($result)) {
        echo $result;
    }

    echo '<a href="index.php?page=partners&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addPartner").'</button></a>';

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = $partners->getNumberOfPartners();
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
    $partners->printAdmin("SELECT * FROM " . $dbname . ".partners ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    $paginator->printLinks("index.php?page=slider&pagination=", "pagination");
    // Print all news and pagination links
}
?>
</div>
</div>
</div>
</div>
</section>