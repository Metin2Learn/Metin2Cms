<?php
if(Admin::hasRight($_SESSION["username"], "c1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$is = new Itemshop();


?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("settings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
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

                    if(isset($_POST["update"]))
                    {
                        $per_page = $_POST["per_page"];
                        if(isset($_POST["enable_log"]))
                        {
                            $enable_log = 1;
                        } else {
                            $enable_log = 0;
                        }
                        if(isset($_POST["paysafecard_enable"]))
                        {
                            $paysafecard_enable = 1;
                        } else {
                            $paysafecard_enable = 0;
                        }
                        if(isset($_POST["amazon_enable"]))
                        {
                            $amazon_enable = 1;
                        } else {
                            $amazon_enable = 0;
                        }
                        if(isset($_POST["paypal_enable"]))
                        {
                            $paypal_enable = 1;
                        } else {
                            $paypal_enable = 0;
                        }
                        if(isset($_POST["discount_enable"]))
                        {
                            $discount_enable = 1;
                        } else {
                            $good = '0000-00-00 00:00:00';
                            $discount_enable = 0;
                        }
                        $discount_until = $_POST["discount_until"];

                        if($discount_enable == 1)
                        {
                            $good = $discount_until;
                        } else {
                            $good = '0000-00-00 00:00:00';
                        }
                        if($discount_enable == 1 AND Core::isValidDate($discount_until) AND $discount_until > date('Y/m/d'))
                        {
                            $old_date = DateTime::createFromFormat('Y/m/d', $discount_until);
                            $final_date = $old_date->format('Y-m-d 00:00:00');
                        } else {
                            $final_date = '0000-00-00 00:00:00';
                        }
                        $currency = $_POST["currency"];
                        $percent = $_POST["percent"];
                        if($per_page <= 0)
                        {
                            $result = Core::result(Language::getTranslation("itemsPerPageInvalid"), 2);
                        } elseif($discount_enable == 1 AND $discount_until <= date('Y/m/d')) {
                            $result = Core::result(Language::getTranslation("invalidDiscountUntil"), 2);
                        } elseif($discount_enable == 1 AND Core::isValidDate($good) == false)
                        {
                            $result = Core::result(Language::getTranslation("invalidDate"), 2);
                        } elseif($discount_enable == 1 AND $percent <= 0)
                        {
                            $result = Core::result(Language::getTranslation("invalidPercent"), 2);
                        } else {
                            Core::updateSettings("itemshop_items_per_page", $per_page);
                            Core::updateSettings("itemshop_currency", $currency);
                            Core::updateSettings("itemshop_log", $enable_log);
                            Core::updateSettings("itemshop_discount_until", $final_date);
                            Core::updateSettings("itemshop_discount_percent", $percent);
                            Core::updateSettings("enable_paysafecard", $paysafecard_enable);
                            Core::updateSettings("enable_amazon", $amazon_enable);
                            Core::updateSettings("paypal_enable", $paypal_enable);
                            $result = Core::result(Language::getTranslation("ISSettingsUpdated"), 1);
                        }
                    }

                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="POST" action="index.php?page=is-settings" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("itemsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= $is->itemsPerPage() ?>" type="number" name="per_page" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("coinsColumn") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= Core::getCoinsColumn() ?>" type="text" name="coins_column" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("enableDisableISLog") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if(Core::itemshopLogEnabled())
                                {
                                    echo '<input type="checkbox" name="enable_log" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_log" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("isCurrency") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= $is->getCurrency() ?>" type="text" name="currency" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("isDiscountEnableDisable") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if($is->discountEnabled())
                                {
                                    echo '<input type="checkbox" name="discount_enable" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="discount_enable" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("discountPercent") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= $is->getDiscountPercent() ?>" type="number" name="percent" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("discountUntil") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($is->discountEnabled())
                                {
                                    ?>
                                    <input value="<?= $is->getDiscountUntil() ?>" type="text" name="discount_until" class="form-control">
                                    <?php
                                } else {
                                    ?>
                                    <input value="<?= Language::getTranslation("disabled") ?>" type="text" name="discount_until" class="form-control">
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("paysafecardEnabledDisabled") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if(Core::paysafecardEnabled())
                                {
                                    echo '<input type="checkbox" name="paysafecard_enable" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="paysafecard_enable" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("amazonEnabledDisabled") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if(Core::amazonEnabled())
                                {
                                    echo '<input type="checkbox" name="amazon_enable" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="amazon_enable" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("paypalEnabledDisabled") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if(Core::paypalEnabled())
                                {
                                    echo '<input type="checkbox" name="paypal_enable" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="paypal_enable" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>


                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="update"><?= Language::getTranslation("update") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
