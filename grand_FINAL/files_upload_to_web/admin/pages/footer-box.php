<?php
if(Admin::hasRight($_SESSION["username"], "k1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$panel = new Panel();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("footerBox") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("footerBox") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php

                    if(isset($_GET["edit"]) AND $panel->footerBoxExists($_GET["edit"]))
                    {
                        $info = $panel->getFooterBoxInfo($_GET["edit"]);

                        if (isset($_POST["update_box"])) {

                            $title = $_POST["title"];
                            $content = $_POST["content"];

                            $panel->updateFooterBox($_GET["edit"], $title, $content);
                            $result = Core::result(Language::getTranslation("footerBoxUpdated"), 1);

                        }


                        if (isset($result)) {
                            echo $result;
                        }

                        ?>
                        <form method="POST" action="index.php?page=footer-box&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["title"] ?>" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("contentHtml") ?></label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" rows="5" id="full_news" name="content"><?= $info["content"] ?></textarea>
                                </div>
                            </div>


                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update_box"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>
                    <?php

                    } else {

                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = 3;
                        $perPage = 3;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=footer-box", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $panel->printAdminFooterBox("SELECT * FROM " . $dbname . ".footer_box ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=slider&pagination=", "pagination");
                        // Print all news and pagination links
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>