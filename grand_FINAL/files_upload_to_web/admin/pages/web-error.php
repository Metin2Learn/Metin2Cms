<?php
if(Admin::hasRight($_SESSION["username"], "d") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

if(isset($_GET["clear"]) AND $_GET["clear"] == 'ok')
{
    file_put_contents('../inc/errors.log', null);
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("error") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("webApplicationError") ?></a></li>
        <li class="active"><?= Language::getTranslation("error") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    echo Core::result("Please contact me on skype: lol-m4n with these error messages and i will fix it as soon as possible !", 3);
                    echo '<div class="btn-group">';
                    echo '<a href="index.php?page=web-error&clear=ok"><button type="submit" class="btn btn-primary">'.Language::getTranslation("clearLog").'</button></a>';
                    echo '</div>';
                    if(filesize('../inc/errors.log') > 0)
                    {
                        $log = file_get_contents('../inc/errors.log');
                        echo '<textarea class="form-control" rows="20" readonly>'.$log.'</textarea>';
                    } else {
                        echo Core::result(Language::getTranslation("errorLogIsClear"), 1);
                    }



                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
