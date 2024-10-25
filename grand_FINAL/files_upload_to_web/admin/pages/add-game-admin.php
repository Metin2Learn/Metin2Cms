<?php
if(Admin::hasRight($_SESSION["username"], "h1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

if(isset($_POST["add_admin"]))
{
    $account = $_POST["account"];
    $ingame = $_POST["ingame"];
    $ip = $_POST["ip"];
    $authority = $_POST["authority"];
    if(!User::usernameExists($account))
    {
        $result = Core::result(Language::getTranslation("accountNotExists"), 2);
    } elseif(!Player::playerNameExists($ingame))
    {
        $result = Core::result(Language::getTranslation("playerNotExists"), 2);
    } else {
        Admin::addGameAdmin($account, $ingame, $ip, $authority);
        $result = Core::result(Language::getTranslation("gameAdminAdded"), 1);
    }
}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addGameAdmin") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("addGameAdmin") ?></li>
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
                    <form method="POST" action="index.php?page=add-game-admin" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("usernameAccount") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="account" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("ingameName") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="ingame" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("contactIP") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="ip" value="*.*.*.*" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("authority") ?></label>
                            <div class="col-sm-7">
                                <select id="source" class="form-control" name="authority">
                                    <option value="IMPLEMENTOR">IMPLEMENTOR</option>
                                    <option value="HIGH_WIZARD">HIGH_WIZARD</option>
                                    <option value="GOD">GOD</option>
                                    <option value="LOW_WIZARD">LOW_WIZARD</option>
                                    <option value="PLAYER">PLAYER</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_admin"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
