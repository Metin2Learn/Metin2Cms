<?php
if(Admin::hasRight($_SESSION["username"], "l1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("registerConfiguration") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("Configuration") ?></a></li>
        <li class="active"><?= Language::getTranslation("registerConfiguration") ?></li>
    </ol>
</section>

<section class="content">

    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($_POST["update_config"])) {


                        if (isset($_POST["register_enable"])) {
                            $register_enable = 1;
                        } else {
                            $register_enable = 0;
                        }

                        $reg_pw_min = $_POST["reg_pw_min"];
                        $reg_pw_max = $_POST["reg_pw_max"];
                        if (isset($_POST["reg_pw_num"])) {
                            $reg_pw_num = 1;
                        } else {
                            $reg_pw_num = 0;
                        }
                        if (isset($_POST["reg_weak_passwords"])) {
                            $reg_weak_passwords = 1;
                        } else {
                            $reg_weak_passwords = 0;
                        }
                        if(isset($_POST["reg_disabled_passwords"]) AND mb_strlen($_POST["reg_disabled_passwords"]) > 0)
                        {
                            $reg_disabled_passwords = str_replace(' ', '', $_POST["reg_disabled_passwords"]);
                        } else {
                            $reg_disabled_passwords = '';
                        }
                        $reg_nick_min = $_POST["reg_nick_min"];
                        $reg_nick_max = $_POST["reg_nick_max"];
                        $reg_safebox_expire = $_POST["reg_safebox_expire"];
                        $reg_gold_expire = $_POST["reg_gold_expire"];
                        $reg_silver_expire = $_POST["reg_silver_expire"];
                        $reg_autoloot_expire = $_POST["reg_autoloot_expire"];
                        $reg_fish_expire = $_POST["reg_fish_expire"];
                        $reg_marriage_expire = $_POST["reg_marriage_expire"];
                        $reg_money_expire = $_POST["reg_money_expire"];
                        if(isset($_POST["reg_coins"]) AND $_POST["reg_coins"] > 0)
                        {
                            $reg_coins = $_POST["reg_coins"];
                        } else {
                            $reg_coins = 0;
                        }
                        Core::updateSettings("register_enable", $register_enable);
                        Core::updateSettings("reg_pw_min", $reg_pw_min);
                        Core::updateSettings("reg_pw_max", $reg_pw_max);
                        Core::updateSettings("reg_pw_num", $reg_pw_num);
                        Core::updateSettings("reg_weak_passwords", $reg_weak_passwords);
                        Core::updateSettings("reg_disabled_passwords", $reg_disabled_passwords);
                        Core::updateSettings("reg_nick_min", $reg_nick_min);
                        Core::updateSettings("reg_nick_max", $reg_nick_max);
                        Core::updateSettings("reg_safebox_expire", $reg_safebox_expire);
                        Core::updateSettings("reg_gold_expire", $reg_gold_expire);
                        Core::updateSettings("reg_silver_expire", $reg_silver_expire);
                        Core::updateSettings("reg_autoloot_expire", $reg_autoloot_expire);
                        Core::updateSettings("reg_fish_expire", $reg_fish_expire);
                        Core::updateSettings("reg_marriage_expire", $reg_marriage_expire);
                        Core::updateSettings("reg_money_expire", $reg_money_expire);
                        Core::updateSettings("reg_coins", $reg_coins);
                        $result = Core::result(Language::getTranslation("configUpdated"), 1);
                    }

                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="post" action="index.php?page=config-register" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableRegister") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="register_enable" class="js-switch"
                                    <?php if(Core::registerEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("minPWLength") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_pw_min" value="<?= Registration::getPasswordMin() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("maxPWLength") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_pw_max" value="<?= Registration::getPasswordMax() ?>" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("pwNeedNumber") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="reg_pw_num" class="js-switch"
                                    <?php if(Registration::needToContainNumber()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableWeakPasswordProtection") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="reg_weak_passwords" class="js-switch"
                                    <?php if(Registration::weakPasswordListEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("weakPasswords") ?></label>
                            <div class="col-sm-7">
                                <textarea name="reg_disabled_passwords" class="form-control"><?= Registration::getWeakPasswords() ?></textarea>
                            </div>
                        </div>

                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("minNameLength") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_nick_min" value="<?= Registration::getUsernameMin() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("maxNameLength") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_nick_max" value="<?= Registration::getUsernameMax() ?>" class="form-control">
                            </div>
                        </div>

                        <hr />
                        <h3><?= Language::getTranslation("leaveEmpty") ?></h3>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("safeboxExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_safebox_expire" value="<?= Registration::getSafeboxExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goldExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_gold_expire" value="<?= Registration::getGoldExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("silverExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_silver_expire" value="<?= Registration::getSilverExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("autolootExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_autoloot_expire" value="<?= Registration::getAutolootExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("fishExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_fish_expire" value="<?= Registration::getFishExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("marriageExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_marriage_expire" value="<?= Registration::getMarriageExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("moneyExpire") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_money_expire" value="<?= Registration::getMoneyExpire(true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("startCoins") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="reg_coins" value="<?= Registration::getRegCoins() ?>" class="form-control">
                            </div>
                        </div>

                        <hr />


                        <div class="btn-group">
                            <button type="submit" onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"
                                    class="btn btn-primary" name="update_config"><?= Language::getTranslation("update") ?></button>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <!-- END BASIC ELEMENTS -->
    </div>
</section>