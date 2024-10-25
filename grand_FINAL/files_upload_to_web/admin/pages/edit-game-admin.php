<?php
if (Admin::hasRight($_SESSION["username"], "h1") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editGameAdmin") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li><a href="index.php?page=all-game-admins"><?= Language::getTranslation("viewGameAdministrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("editGameAdmin") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">

                    <?php
                    if (isset($_GET["id"]) AND Admin::gameAdminExists($_GET["id"]) AND Admin::hasRight($_SESSION["username"], "h1")) {

                        if(isset($_POST["edit_admin"]))
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
                                Admin::updateGameAdmin($account, $ingame, $ip, $authority, $_GET["id"]);
                                $result = Core::result(Language::getTranslation("adminUpdated"), 1);
                            }
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        $info = Admin::gameAdminInfo($_GET["id"]);
                        ?>

                        <form method="POST" action="index.php?page=edit-game-admin&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("usernameAccount") ?></label>
                                <div class="col-sm-7">
                                    <input type="text" name="account" value="<?= $info["mAccount"] ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("ingameName") ?></label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["mName"] ?>" name="ingame" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("contactIP") ?></label>
                                <div class="col-sm-7">
                                    <input type="text" name="ip" value="<?= $info["mContactIP"] ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("authority") ?></label>
                                <div class="col-sm-7">
                                    <select id="source" class="form-control" name="authority">
                                        <?php
                                        if($info["mAuthority"] == 'IMPLEMENTOR')
                                        {
                                            echo '<option value="IMPLEMENTOR" selected>IMPLEMENTOR</option>';
                                        } else {
                                            echo '<option value="IMPLEMENTOR">IMPLEMENTOR</option>';
                                        }

                                        if($info["mAuthority"] == 'HIGH_WIZARD')
                                        {
                                            echo '<option value="HIGH_WIZARD" selected>HIGH_WIZARD</option>';
                                        } else {
                                            echo '<option value="HIGH_WIZARD">HIGH_WIZARD</option>';
                                        }

                                        if($info["mAuthority"] == 'GOD')
                                        {
                                            echo '<option value="GOD" selected>GOD</option>';
                                        } else {
                                            echo '<option value="GOD">GOD</option>';
                                        }

                                        if($info["mAuthority"] == 'LOW_WIZARD')
                                        {
                                            echo '<option value="LOW_WIZARD" selected>LOW_WIZARD</option>';
                                        } else {
                                            echo '<option value="LOW_WIZARD">LOW_WIZARD</option>';
                                        }

                                        if($info["mAuthority"] == 'PLAYER')
                                        {
                                            echo '<option value="PLAYER" selected>PLAYER</option>';
                                        } else {
                                            echo '<option value="PLAYER">PLAYER</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary" name="edit_admin"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>

                    <?php
                    } else {
                        echo Core::result(Language::getTranslation("adminNotFound"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
