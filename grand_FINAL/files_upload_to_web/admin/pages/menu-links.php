<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}


?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("menuLinks") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("menuLinks") ?></li>
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
    if (isset($_POST["add_link"])) {

        $title = $_POST["title"];
        $link = $_POST["link"];
        if(isset($_POST["visible"]))
        {
            $visible = 1;
        } else {
            $visible = 0;
        }
        if(isset($_POST["parent"]) AND $_POST["parent"] != 'nothing')
        {
            $parent = $_POST["parent"];
        } else {
            $parent = NULL;
        }
        if(empty($title) OR empty($link))
        {
            $result = Core::result(Language::getTranslation("youMustFillInAllFields"), 2);
        } elseif($parent != NULL AND Links::exists($parent) == false)
        {
            $result = Core::result(Language::getTranslation("invalidParent"), 2);
        } else {
            Links::addLink($link, $title, $visible, $parent);
            if($parent != NULL AND Links::isParent($parent) == false)
            {
                Links::updateParent($parent, 1);
            }
            $result = Core::result(Language::getTranslation("linkAdded"), 1);
        }

    }


    if (isset($result)) {
        echo $result;
    }
    ?>
    <form method="POST" action="index.php?page=menu-links&action=add" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" name="link" class="form-control" required>
            </div>
        </div>


        <div class="form-group">
            <label
                class="col-sm-3 control-label"><?= Language::getTranslation("visible") ?></label>

            <div class="col-sm-7">
                <input type="checkbox" name="visible" class="js-switch" checked>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("parentLink") ?></label>
            <div class="col-sm-5">
                <select id="source" class="form-control" name="parent">
                    <option value="nothing"><?= Language::getTranslation("nothing") ?></option>
                    <?php
                    $links = Links::getAllLinks();
                    foreach($links as $row)
                    {
                        echo '<option value="'.$row["id"].'">'.$row["head_title"].' - '.$row["link"].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="btn-group">
            <button type="submit" class="btn btn-primary"
                    name="add_link"><?= Language::getTranslation("submit") ?></button>
        </div>
    </form>
<?php
} elseif(isset($_GET["edit"]) AND Links::exists($_GET["edit"]))
{
    $info = Links::getInfo($_GET["edit"]);

    if (isset($_POST["update_link"])) {

        $title = $_POST["title"];
        $link = $_POST["link"];
        if(isset($_POST["visible"]))
        {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if(empty($title) OR empty($link))
        {
            $result = Core::result(Language::getTranslation("youMustFillInAllFields"), 2);
        } else {
            Links::updateLink($link, $title, $visible, $_GET["edit"]);
            $result = Core::result(Language::getTranslation("linkUpdated"), 1);
        }

    }


    if (isset($result)) {
        echo $result;
    }

    ?>
    <form method="POST" action="index.php?page=menu-links&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["head_title"] ?>" name="title" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label"><?= Language::getTranslation("link") ?></label>

            <div class="col-sm-7">
                <input type="text" value="<?= $info["link"] ?>" name="link" class="form-control" required>
            </div>
        </div>


        <div class="form-group">
            <label
                class="col-sm-3 control-label"><?= Language::getTranslation("visible") ?></label>

            <div class="col-sm-7">
                <?php
                if($info["visible"] == 1)
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
                    name="update_link"><?= Language::getTranslation("update") ?></button>
        </div>
    </form>
<?php

} else {

    if(isset($_GET["delete"]) AND Links::exists($_GET["delete"]))
    {
        if(Links::canDelete($_GET["delete"]))
        {
            if(Links::isParent($_GET["delete"]) AND Links::numberOfChildren($_GET["delete"]) > 0)
            {
                $children = Links::getChildren($_GET["delete"]);
                foreach($children as $edit)
                {
                    Links::updateChild($edit["id"], NULL);
                }
            }
            if(Links::isChild($_GET["delete"]) AND Links::numberOfChildren(Links::getParentID($_GET["delete"])) == 1)
            {
                Links::updateParent(Links::getParentID($_GET["delete"]), 0);
            }
            Links::delete($_GET["delete"]);
            $result = Core::result(Language::getTranslation("linkDeleted"), 1);
        } else {
            $result = Core::result(Language::getTranslation("canNotDelete"), 2);
        }
    }

    if (isset($result)) {
        echo $result;
    }

    echo '<a href="index.php?page=menu-links&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addLink").'</button></a>';

    // Paginator
    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
    $totalCount = Links::numberOfLinks(false);
    $perPage = 20;
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
    Links::printAdminLinks("SELECT * FROM " . $dbname . ".links ORDER BY visible DESC, id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
    $paginator->printLinks("index.php?page=menu-links&pagination=", "pagination");
    // Print all news and pagination links
}
?>
</div>
</div>
</div>
</div>
</section>