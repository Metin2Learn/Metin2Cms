<?php
if(Admin::hasRight($_SESSION["username"], "n1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("logGameCommand") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("logs") ?></a></li>
        <li class="active"><?= Language::getTranslation("logGameCommand") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <form action="index.php?page=log-gm-command" method="get" class="form-horizontal" role="form">
                        <div class="form-group">
                            <input type="hidden" class="hidden" name="page" value="log-gm-command">
                            <div class="col-sm-2">
                                <input type="text" placeholder="<?= Language::getTranslation("enterName") ?>" name="name" class="form-control" required>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" value="<?= Language::getTranslation("search") ?>" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <?php
                    if(isset($_GET["name"]))
                    {
                        $name = $_GET["name"];
                        $search = true;
                    } else {
                        $name = null;
                        $search = false;
                    }

                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    if($search == true AND Logs::numberOfGMCommands($name) > 0)
                    {
                        $totalCount = Logs::numberOfGMCommands($name);
                    } else {
                        $totalCount = Logs::numberOfGMCommands(null);
                    }
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=log-gm-command", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    $dblog = Core::getLogDatabase();
                    if($name != null AND Logs::numberOfGMCommands($name) > 0)
                    {
                        Logs::GMCommands("SELECT * FROM " . $dblog . ".command_log WHERE username = ? ORDER BY `date` LIMIT ? OFFSET ?", array($name, $perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=log-gm-command&name=".$_GET["name"]."&pagination=", "pagination");
                    } else {
                        Logs::GMCommands("SELECT * FROM " . $dblog . ".command_log ORDER BY `date` LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=log-gm-command&pagination=", "pagination");
                    }
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>