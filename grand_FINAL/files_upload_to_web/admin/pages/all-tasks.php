<?php
if(Admin::hasRight($_SESSION["username"], "b") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$task = new Tasks();

if(isset($_GET["delete"]) AND $task->exists($_GET["delete"]) AND Admin::hasRight($_SESSION["username"], "i1"))
{
    $task->delete($_GET["delete"]);
    $result = Core::result(Language::getTranslation("taskDeleted"), 1);
} elseif(isset($_GET["done"]) AND $task->exists($_GET["done"]) AND Admin::hasRight($_SESSION["username"], "i1"))
{
    $task->markAsDone($_GET["done"]);
    $result = Core::result(Language::getTranslation("taskDone"), 1);
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewTasks") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("tasks") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewTasks") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }

                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    $totalCount = $task->count(false);
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-tasks", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $task->printTasks("SELECT * FROM " . $dbname . ".admin_task ORDER BY `percent` ASC, `date` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-tasks&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>