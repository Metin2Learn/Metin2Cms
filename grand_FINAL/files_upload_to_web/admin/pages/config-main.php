<?php
if(Admin::hasRight($_SESSION["username"], "l1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("mainConfiguration") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("Configuration") ?></a></li>
        <li class="active"><?= Language::getTranslation("mainConfiguration") ?></li>
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
                        $site_title = $_POST["site_title"];
                        $header_title = $_POST["header_title"];
                        $header_slogan = $_POST["header_slogan"];
                        $language = $_POST["language"];
                        $date_format = $_POST["date_format"];
                        $footer_text = $_POST["footer_text"];
                        if(isset($_POST["maintenance"]))
                        {
                            $maintenance = 1;
                        } else {
                            $maintenance = 0;
                        }
                        $maintenance_text = $_POST["maintenance_text"];
                        if(isset($_POST["captcha_enable"]))
                        {
                            $captcha_enable = 1;
                        } else {
                            $captcha_enable = 0;
                        }
                        if(isset($_POST["enable_slider"]))
                        {
                            $enable_slider = 1;
                        } else {
                            $enable_slider = 0;
                        }
                        if(isset($_POST["partners_enable"]))
                        {
                            $partners_enable = 1;
                        } else {
                            $partners_enable = 0;
                        }
                        if(isset($_POST["footerbox_enable"]))
                        {
                            $footerbox_enable = 1;
                        } else {
                            $footerbox_enable = 0;
                        }
                        if(isset($_POST["player_info"]))
                        {
                            $player_info = 1;
                        } else {
                            $player_info = 0;
                        }
                        if(isset($_POST["coupon_enable"]))
                        {
                            $coupon_enable = 1;
                        } else {
                            $coupon_enable = 0;
                        }
                        $login_captcha_attempts = $_POST["login_captcha_attempts"];
                        $action_spam_penalty = $_POST["action_spam_penalty"];
                        if(isset($_POST["facebook_link"]) AND mb_strlen($_POST["facebook_link"]) > 0)
                        {
                            $facebook_link = $_POST["facebook_link"];
                        } else {
                            $facebook_link = null;
                        }
                        if(isset($_POST["twitter_link"]) AND mb_strlen($_POST["twitter_link"]) > 0)
                        {
                            $twitter_link = $_POST["twitter_link"];
                        } else {
                            $twitter_link = null;
                        }
                        if(isset($_POST["youtube_link"]) AND mb_strlen($_POST["youtube_link"]) > 0)
                        {
                            $youtube_link = $_POST["youtube_link"];
                        } else {
                            $youtube_link = null;
                        }
                        if(isset($_POST["twitch_link"]) AND mb_strlen($_POST["twitch_link"]) > 0)
                        {
                            $twitch_link = $_POST["twitch_link"];
                        } else {
                            $twitch_link = null;
                        }

                        Core::updateSettings("site_title", $site_title);
                        Core::updateSettings("header_title", $header_title);
                        Core::updateSettings("header_slogan", $header_slogan);
                        Core::updateSettings("language", $language);
                        Core::updateSettings("date_format", $date_format);
                        Core::updateSettings("footer_text", $footer_text);
                        Core::updateSettings("maintenance", $maintenance);
                        Core::updateSettings("maintenance_text", $maintenance_text);
                        Core::updateSettings("captcha_enable", $captcha_enable);
                        Core::updateSettings("enable_slider", $enable_slider);
                        Core::updateSettings("partners_enable", $partners_enable);
                        Core::updateSettings("footerbox_enable", $footerbox_enable);
                        Core::updateSettings("player_info", $player_info);
                        Core::updateSettings("coupon_enable", $coupon_enable);
                        Core::updateSettings("login_captcha_attempts", $login_captcha_attempts);
                        Core::updateSettings("action_spam_penalty", $action_spam_penalty);
                        Core::updateSettings("facebook_link", $facebook_link);
                        Core::updateSettings("twitter_link", $twitter_link);
                        Core::updateSettings("youtube_link", $youtube_link);
                        Core::updateSettings("twitch_link", $twitch_link);
                        $result = Core::result(Language::getTranslation("configUpdated"), 1);

                     }

                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="post" action="index.php?page=config-main" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("siteTitle") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="site_title" value="<?= Core::getSiteTitle() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("headerTitle") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="header_title" value="<?= htmlentities(Core::getHeaderTitle()) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("headerSlogan") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="header_slogan" value="<?= Core::getHeaderSlogan() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("language") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="language" value="<?= Language::getLanguage() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("dateFormat") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="date_format" value="<?= Core::getDateFormat() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("footerText") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="footer_text" value="<?= Core::getFooterText() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableMaintenance") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="maintenance" class="js-switch"
                                    <?php if(Core::maintenanceEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("maintenanceText") ?></label>
                            <div class="col-sm-7">
                                <textarea name="maintenance_text" class="form-control"><?= Core::getMaintenanceText() ?></textarea>
                            </div>
                        </div>

                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableCaptcha") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="captcha_enable" class="js-switch"
                                    <?php if(Core::isCaptchaEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableSlider") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="enable_slider" class="js-switch"
                                    <?php if(Slider::sliderEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enablePartners") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="partners_enable" class="js-switch"
                                    <?php if(Core::partnersEnable()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableFooterBox") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="footerbox_enable" class="js-switch"
                                    <?php if(Core::footerBoxEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enablePlayerInfo") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="player_info" class="js-switch"
                                    <?php if(Core::isPlayerInfoEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableCoupon") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="coupon_enable" class="js-switch"
                                    <?php if(Core::couponSystemEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <hr />

                        <hr />
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("loginCaptchaAttempts") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="login_captcha_attempts" value="<?= Core::getFailedLoginAttempts() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("actionSpamPenalty") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="action_spam_penalty" value="<?= ActionLog::penalty() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("fbLink") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="facebook_link" value="<?= Core::getSocialLink("facebook", true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("twitterLink") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="twitter_link" value="<?= Core::getSocialLink("twitter", true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("ytbLink") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="youtube_link" value="<?= Core::getSocialLink("youtube", true) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("twitchLink") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="twitch_link" value="<?= Core::getSocialLink("twitch", true) ?>" class="form-control">
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