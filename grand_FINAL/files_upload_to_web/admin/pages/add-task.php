<?php
if(Admin::hasRight($_SESSION["username"], "i1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$task = new Tasks();

if(isset($_POST["add_task"]))
{
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
        $task->addTask($title, $desc, $percent);
        $result = Core::result(Language::getTranslation("taskAdded"), 1);
    }
}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addCategory") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("addCategory") ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="POST" action="index.php?page=add-task" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("title") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>
                            <div class="col-sm-7">
                                <textarea class="form-control" rows="2" id="intro_news" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("percentFinished") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="0" name="percent" class="form-control" required>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_task"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
