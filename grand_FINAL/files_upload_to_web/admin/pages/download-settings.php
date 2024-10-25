<?php
if(Admin::hasRight($_SESSION["username"], "m") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$dl = new Download();

if(isset($_POST["update_settings"]))
{
    $dl_per_page = $_POST["dl_per_page"];
    Core::updateSettings("dl_per_page", $dl_per_page);
    $result = Core::result(Language::getTranslation("updated"), 1);
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("settings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("downloads") ?></a></li>
        <li class="active"><?= Language::getTranslation("settings") ?></li>
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
                    <form method="post" action="index.php?page=download-settings" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("downloadsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="dl_per_page" value="<?= $dl->showPerPage() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"
                                    class="btn btn-primary" name="update_settings"><?= Language::getTranslation("update") ?></button>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <!-- END BASIC ELEMENTS -->
    </div>
</section>