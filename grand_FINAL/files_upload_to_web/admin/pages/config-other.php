<?php
if(Admin::hasRight($_SESSION["username"], "l1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("otherConfig") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("Configuration") ?></a></li>
        <li class="active"><?= Language::getTranslation("otherConfig") ?></li>
    </ol>
</section>

<section class="content">

    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($_POST["update_config"]))
                    {
                        if(isset($_POST["change_email_enable"]))
                        {
                            $change_email_enable = 1;
                        } else {
                            $change_email_enable = 0;
                        }
                        $change_email_mail_verification = $_POST["change_email_mail_verification"];
                        $change_pw_mail_verification = $_POST["change_pw_mail_verification"];
                        $show_warehouse_pw = $_POST["show_warehouse_pw"];
                        $rank_per_page = $_POST["rank_per_page"];
                        if(isset($_POST["prefix_not_show_rankings"]) AND mb_strlen($_POST["prefix_not_show_rankings"]) > 0)
                        {
                            $prefix_not_show_rankings = str_replace(' ', '', $_POST["prefix_not_show_rankings"]);
                        } else {
                            $prefix_not_show_rankings = '';
                        }
                        $show_delete_code = $_POST["show_delete_code"];
                        $mail_type = $_POST["mail_type"];
                        $mail_from = $_POST["mail_from"];
                        $mail_from_name = $_POST["mail_from_name"];
                        $smtp_secure = $_POST["smtp_secure"];
                        $smtp_host = $_POST["smtp_host"];
                        $smtp_port = $_POST["smtp_port"];
                        $smtp_user = $_POST["smtp_user"];
                        $smtp_password = $_POST["smtp_password"];
                        $debug_disconnect_wait = $_POST["debug_disconnect_wait"];
                        $debug_shinso_map = $_POST["debug_shinso_map"];
                        $debug_chunjo_map = $_POST["debug_chunjo_map"];
                        $debug_jinno_map = $_POST["debug_jinno_map"];
                        $debug_shinso_x = $_POST["debug_shinso_x"];
                        $debug_chunjo_x = $_POST["debug_chunjo_x"];
                        $debug_jinno_x = $_POST["debug_jinno_x"];
                        $debug_shinso_y = $_POST["debug_shinso_y"];
                        $debug_chunjo_y = $_POST["debug_chunjo_y"];
                        $debug_jinno_y = $_POST["debug_jinno_y"];
                        if(isset($_POST["coupon_log"]))
                        {
                            $coupon_log = 1;
                        } else {
                            $coupon_log = 0;
                        }
                        if(isset($_POST["change_account_pw_log"]))
                        {
                            $change_account_pw_log = 1;
                        } else {
                            $change_account_pw_log = 0;
                        }
                        if(isset($_POST["change_warehouse_pw_log"]))
                        {
                            $change_warehouse_pw_log = 1;
                        } else {
                            $change_warehouse_pw_log = 0;
                        }
                        if(isset($_POST["change_email_log"]))
                        {
                            $change_email_log = 1;
                        } else {
                            $change_email_log = 0;
                        }
                        if(isset($_POST["password_recovery_log"]))
                        {
                            $password_recovery_log = 1;
                        } else {
                            $password_recovery_log = 0;
                        }
                        if(isset($_POST["referral_log"]))
                        {
                            $referral_log = 1;
                        } else {
                            $referral_log = 0;
                        }
                        Core::updateSettings("change_email_enable", $change_email_enable);
                        Core::updateSettings("change_email_mail_verification", $change_email_mail_verification);
                        Core::updateSettings("change_pw_mail_verification", $change_pw_mail_verification);
                        Core::updateSettings("show_warehouse_pw", $show_warehouse_pw);
                        Core::updateSettings("rank_per_page", $rank_per_page);
                        Core::updateSettings("prefix_not_show_rankings", $prefix_not_show_rankings);
                        Core::updateSettings("show_delete_code", $show_delete_code);
                        Core::updateSettings("mail_type", $mail_type);
                        Core::updateSettings("mail_from", $mail_from);
                        Core::updateSettings("mail_from_name", $mail_from_name);
                        Core::updateSettings("smtp_secure", $smtp_secure);
                        Core::updateSettings("smtp_host", $smtp_host);
                        Core::updateSettings("smtp_port", $smtp_port);
                        Core::updateSettings("smtp_user", $smtp_user);
                        Core::updateSettings("smtp_password", $smtp_password);
                        Core::updateSettings("debug_disconnect_wait", $debug_disconnect_wait);
                        Core::updateSettings("debug_shinso_map", $debug_shinso_map);
                        Core::updateSettings("debug_chunjo_map", $debug_chunjo_map);
                        Core::updateSettings("debug_jinno_map", $debug_jinno_map);
                        Core::updateSettings("debug_shinso_x", $debug_shinso_x);
                        Core::updateSettings("debug_chunjo_x", $debug_chunjo_x);
                        Core::updateSettings("debug_jinno_x", $debug_jinno_x);
                        Core::updateSettings("debug_shinso_y", $debug_shinso_y);
                        Core::updateSettings("debug_chunjo_y", $debug_chunjo_y);
                        Core::updateSettings("debug_jinno_y", $debug_jinno_y);
                        Core::updateSettings("coupon_log", $coupon_log);
                        Core::updateSettings("change_account_pw_log", $change_account_pw_log);
                        Core::updateSettings("change_warehouse_pw_log", $change_warehouse_pw_log);
                        Core::updateSettings("change_email_log", $change_email_log);
                        Core::updateSettings("password_recovery_log", $password_recovery_log);
                        Core::updateSettings("referral_log", $referral_log);
                        $result = Core::result(Language::getTranslation("configUpdated"), 1);

                    }


                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="post" action="index.php?page=config-other" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("userCanChangeMail") ?></label>
                        <div class="col-sm-7">
                            <input type="checkbox" name="change_email_enable" class="js-switch"
                                <?php if(Core::changeEmailEnabled()) { echo " checked"; } ?>
                                >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("changeEmailType") ?></label>
                        <div class="col-sm-7">
                            <select name="change_email_mail_verification" class="form-control">
                                <?php
                                if(Core::changeEmailVerificationEnabled())
                                {
                                    ?>
                                    <option value="1" selected><?= Language::getTranslation("changePWMail") ?></option>
                                <?php
                                } else {
                                    ?>
                                    <option value="1"><?= Language::getTranslation("changePWMail") ?></option>
                                <?php
                                }

                                if(!Core::changeEmailVerificationEnabled())
                                {
                                    ?>
                                    <option value="0" selected><?= Language::getTranslation("changePWNormal") ?></option>
                                <?php
                                } else {
                                    ?>
                                    <option value="0"><?= Language::getTranslation("changePWNormal") ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("changePWType") ?></label>
                            <div class="col-sm-7">
                                <select name="change_pw_mail_verification" class="form-control">
                                    <?php
                                    if(Core::changePasswordMailVerification())
                                    {
                                        ?>
                                        <option value="1" selected><?= Language::getTranslation("changePWMail") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="1"><?= Language::getTranslation("changePWMail") ?></option>
                                    <?php
                                    }

                                    if(!Core::changePasswordMailVerification())
                                    {
                                        ?>
                                        <option value="0" selected><?= Language::getTranslation("changePWNormal") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="0"><?= Language::getTranslation("changePWNormal") ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("warehousePassword") ?></label>
                            <div class="col-sm-7">
                                <select name="show_warehouse_pw" class="form-control">
                                    <?php
                                    if(Core::showWarehousePasswordEnabled())
                                    {
                                        ?>
                                        <option value="1" selected><?= Language::getTranslation("classicShow") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="1"><?= Language::getTranslation("classicShow") ?></option>
                                    <?php
                                    }

                                    if(!Core::showWarehousePasswordEnabled())
                                    {
                                        ?>
                                        <option value="0" selected><?= Language::getTranslation("mailSendShow") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="0"><?= Language::getTranslation("mailSendShow") ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("playersPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="rank_per_page" value="<?= Rankings::perPage() ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("prefixDontShow") ?></label>
                            <div class="col-sm-7">
                                <textarea name="prefix_not_show_rankings" class="form-control"><?= Rankings::prefixNotShow() ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("deleteCodeShow") ?></label>
                            <div class="col-sm-7">
                                <select name="show_delete_code" class="form-control">
                                    <?php
                                    if(Core::showDeleteCodeEnabled())
                                    {
                                        ?>
                                        <option value="1" selected><?= Language::getTranslation("classicShow") ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="1"><?= Language::getTranslation("classicShow") ?></option>
                                    <?php
                                    }

                                    if(!Core::showDeleteCodeEnabled())
                                    {
                                        ?>
                                        <option value="0" selected><?= Language::getTranslation("mailSendShow") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="0"><?= Language::getTranslation("mailSendShow") ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("mailType") ?></label>
                            <div class="col-sm-7">
                                <select name="mail_type" class="form-control">
                                    <?php
                                    if(!Core::usingSMTP())
                                    {
                                        ?>
                                        <option value="normal" selected><?= Language::getTranslation("mailNormal") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="normal"><?= Language::getTranslation("mailNormal") ?></option>
                                    <?php
                                    }

                                    if(Core::usingSMTP())
                                    {
                                        ?>
                                        <option value="smtp" selected><?= Language::getTranslation("mailSMTP") ?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="smtp"><?= Language::getTranslation("mailSMTP") ?></option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("serverEmail") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="mail_from" value="<?= Core::getMailFrom() ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("serverEmailName") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="mail_from_name" value="<?= Core::getMailFromName() ?>" class="form-control" required>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("smtpProtocol") ?></label>
                            <div class="col-sm-7">
                                <select name="smtp_secure" class="form-control">
                                    <?php
                                    if(Core::getSMTPProtocol() == 'ssl')
                                    {
                                        ?>
                                        <option value="ssl" selected>SSL</option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="ssl">SSL</option>
                                    <?php
                                    }

                                    if(Core::getSMTPProtocol() == 'tls')
                                    {
                                        ?>
                                        <option value="tls" selected>TLS</option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="tls">TLS</option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("smtpHost") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="smtp_host" value="<?= Core::getSMTPHost() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("smtpPort") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="smtp_port" value="<?= Core::getSMTPPort() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("smtpUser") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="smtp_user" value="<?= Core::getSMTPUser() ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("smtpPw") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="smtp_password" value="<?= Core::getSMTPPassword() ?>" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("waitBeforeDebug") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="debug_disconnect_wait" value="<?= Core::debugDisconnectWaitTime() ?>" class="form-control" required>
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("shinsoDebugMap") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_shinso_map" value="<?= Core::debugShinsoMap() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("chunjoDebugMap") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_chunjo_map" value="<?= Core::debugChunjoMap() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("jinnoDebugMap") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_jinno_map" value="<?= Core::debugJinnoMap() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("shinsoDebugX") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_shinso_x" value="<?= Core::debugShinsoX() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("chunjoDebugX") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_chunjo_x" value="<?= Core::debugChunjoX() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("jinnoDebugX") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_jinno_x" value="<?= Core::debugJinnoX() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("shinsoDebugY") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_shinso_y" value="<?= Core::debugShinsoY() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("chunjoDebugY") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_chunjo_y" value="<?= Core::debugChunjoY() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("jinnoDebugY") ?></label>
                        <div class="col-sm-7">
                            <input type="number" name="debug_jinno_y" value="<?= Core::debugJinnoY() ?>" class="form-control" required>
                        </div>
                    </div>
                        <hr />

                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("couponLog") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="coupon_log" class="js-switch"
                                    <?php if(Core::couponLogEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("changePWLog") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="change_account_pw_log" class="js-switch"
                                    <?php if(Core::changeAccountPasswordLog()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("changeWarehouseLog") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="change_warehouse_pw_log" class="js-switch"
                                    <?php if(Core::changeWarehousePasswordLog()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("emailChangeLog") ?></label>
                        <div class="col-sm-7">
                            <input type="checkbox" name="change_email_log" class="js-switch"
                                <?php if(Core::changeEmailLog()) { echo " checked"; } ?>
                                >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("enablePasswordRecoveryLog") ?></label>
                        <div class="col-sm-7">
                            <input type="checkbox" name="password_recovery_log" class="js-switch"
                                <?php if(Core::passwordRecoveryLogEnabled()) { echo " checked"; } ?>
                                >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= Language::getTranslation("enableReferralLog") ?></label>
                        <div class="col-sm-7">
                            <input type="checkbox" name="referral_log" class="js-switch"
                                <?php if(Referral::staticLogEnabled()) { echo " checked"; } ?>
                                >
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