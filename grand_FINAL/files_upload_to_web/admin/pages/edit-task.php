<?php
if (Admin::hasRight($_SESSION["username"], "i1") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

$task = new Tasks();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editTask") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("tasks") ?></a></li>
        <li><a href="index.php?page=all-tasks"><?= Language::getTranslation("viewTasks") ?></a></li>
        <li class="active"><?= Language::getTranslation("editTask") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">

                    <?php
                    if (isset($_GET["id"]) AND $task->exists($_GET["id"])) {
                        if (isset($_POST["update_task"])) {
                            $title = $_POST["title"];
                            if(isset($_POST["description"]) AND $_POST["description"] != '<p><br></p>')
                            {
                                $desc = $_POST["description"];
                            } else {
                                $desc = '';
                            }
                            $percent = $_POST["percent"];
                            if(empty($title))
                            {
                                $result = Core::result(Language::getTranslation("youMustFillInAllFields"), 2);
                            } elseif($percent < 0 OR $percent > 100)
                            {
                                $result = Core::result(Language::getTranslation("invalidPercent"), 2);
                            } else {
                                $task->updateTask($title, $desc, $percent, $_GET["id"]);
                                $result = Core::result(Language::getTranslation("taskUpdated"), 1);
                            }
                        }

                        $info = $task->getInfo($_GET["id"]);
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=edit-task&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["title"] ?>" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" rows="2" id="intro_news" name="description"><?= $info["description"] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("percentFinished") ?></label>
                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["percent"] ?>" name="percent" class="form-control" required>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary" name="update_task"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>

                    <?php
                    } else {
                        echo Core::result(Language::getTranslation("taskNotExists"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
