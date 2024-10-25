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
    <span><?= Language::getTranslation("statusServer") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("templateContent") ?></a></li>
        <li class="active"><?= Language::getTranslation("statusServer") ?></li>
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
                        if (isset($_POST["add_service"])) {

                            $title = $_POST["title"];
                            $ip = $_POST["ip"];
                            $port = $_POST["port"];

                            $panels->addServerService($title, $ip, $port);
                            $result = Core::result(Language::getTranslation("serverServiceAdded"), 1);
                        }


                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=server-status&action=add" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("ip") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="ip" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("port") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="port" class="form-control" required>
                                </div>
                            </div>


                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="add_service"><?= Language::getTranslation("submit") ?></button>
                            </div>
                        </form>
                    <?php
                    } elseif(isset($_GET["edit"]) AND $panels->panelExists($_GET["edit"]))
                    {
                        $info = $panels->serverServiceInfo($_GET["edit"]);

                        if (isset($_POST["update_service"])) {

                            $title = $_POST["title"];
                            $ip = $_POST["ip"];
                            $port = $_POST["port"];

                            $panels->updateServerService($title, $ip, $port, $_GET["edit"]);
                            $result = Core::result(Language::getTranslation("serverServiceUpdated"), 1);

                        }


                        if (isset($result)) {
                            echo $result;
                        }

                        ?>
                        <form method="POST" action="index.php?page=server-status&edit=<?= $_GET["edit"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="title" value="<?= $info["name"] ?>" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("ip") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="ip" value="<?= $info["ip"] ?>" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("port") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["port"] ?>" name="port" class="form-control" required>
                                </div>
                            </div>


                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update_service"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>
                    <?php

                    } else {

                        if(isset($_GET["delete"]) AND $panels->serverServiceExists($_GET["delete"]))
                        {
                            $panels->deleteServerService($_GET["delete"]);
                            $result = Core::result(Language::getTranslation("serverServiceDeleted"), 1);
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        echo '<a href="index.php?page=server-status&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addNewService").'</button></a>';

                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = $panels->numberOfServerServices();
                        $perPage = 10;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=server-status", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $panels->printAdminServerStatus("SELECT * FROM " . $dbname . ".server_status ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=server-status&pagination=", "pagination");
                        // Print all news and pagination links
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>