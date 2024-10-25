<?php
if(Admin::hasRight($_SESSION["username"], "j1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$ref = new Referral();

if(isset($_POST["update_settings"]))
{
    if(isset($_POST["enable_referral"]))
    {
        $enable_referral = 1;
    } else {
        $enable_referral = 0;
    }
    if(isset($_POST["enable_log"]))
    {
        $enable_log = 1;
    } else {
        $enable_log = 0;
    }
    $rewards_per_page = $_POST["rewards_per_page"];
    $limit = $_POST["limit"];
    if(isset($_POST["enable_goal_1"]))
    {
        $goal_1_level = ($_POST["goal_1_level"] > 0) ? $_POST["goal_1_level"] : null;
        $goal_1_reward = ($_POST["goal_1_reward"] > 0) ? $_POST["goal_1_reward"] : null;
    } else {
        $goal_1_level = null;
        $goal_1_reward = 0;
    }
    if(isset($_POST["enable_goal_2"]) AND $goal_1_level != null)
    {
        $goal_2_level =  ($_POST["goal_2_level"] > 0) ? $_POST["goal_2_level"] : null;
        $goal_2_reward = ($_POST["goal_2_reward"] > 0) ? $_POST["goal_2_reward"] : null;
    } else {
        $goal_2_level = null;
        $goal_2_reward = 0;
    }
    if(isset($_POST["enable_goal_3"]) AND $goal_2_level != null)
    {
        $goal_3_level = ($_POST["goal_3_level"] > 0) ? $_POST["goal_3_level"] : null;
        $goal_3_reward = ($_POST["goal_3_reward"] > 0) ? $_POST["goal_3_reward"] : null;
    } else {
        $goal_3_level = null;
        $goal_3_reward = 0;
    }
    if(isset($_POST["enable_goal_4"]) AND $goal_3_level != null)
    {
        $goal_4_level = ($_POST["goal_4_level"] > 0) ? $_POST["goal_4_level"] : null;
        $goal_4_reward = ($_POST["goal_4_reward"] > 0) ? $_POST["goal_4_reward"] : null;
    } else {
        $goal_4_level = null;
        $goal_4_reward = 0;
    }
    if(isset($_POST["enable_goal_5"]) AND $goal_4_level != null)
    {
        $goal_5_level = ($_POST["goal_5_level"] > 0) ? $_POST["goal_5_level"] : null;
        $goal_5_reward = ($_POST["goal_5_reward"] > 0) ? $_POST["goal_5_reward"] : null;
    } else {
        $goal_5_level = null;
        $goal_5_reward = 0;
    }
    if(isset($_POST["enable_goal_6"]) AND $goal_5_level != null)
    {
        $goal_6_level = ($_POST["goal_6_level"] > 0) ? $_POST["goal_6_level"] : null;
        $goal_6_reward = ($_POST["goal_6_reward"] > 0) ? $_POST["goal_6_reward"] : null;
    } else {
        $goal_6_level = null;
        $goal_6_reward = 0;
    }
    if(isset($_POST["enable_goal_7"]) AND $goal_6_level != null)
    {
        $goal_7_level = ($_POST["goal_7_level"] > 0) ? $_POST["goal_7_level"] : null;
        $goal_7_reward = ($_POST["goal_7_reward"] > 0) ? $_POST["goal_7_reward"] : null;
    } else {
        $goal_7_level = null;
        $goal_7_reward = 0;
    }
    if(isset($_POST["enable_goal_8"]) AND $goal_7_level != null)
    {
        $goal_8_level = ($_POST["goal_8_level"] > 0) ? $_POST["goal_8_level"] : null;
        $goal_8_reward = ($_POST["goal_8_reward"] > 0) ? $_POST["goal_8_reward"] : null;
    } else {
        $goal_8_level = null;
        $goal_8_reward = 0;
    }
    if(isset($_POST["enable_goal_9"]) AND $goal_8_level != null)
    {
        $goal_9_level = ($_POST["goal_9_level"] > 0) ? $_POST["goal_9_level"] : null;
        $goal_9_reward = ($_POST["goal_9_reward"] > 0) ? $_POST["goal_9_reward"] : null;
    } else {
        $goal_9_level = null;
        $goal_9_reward = 0;
    }
    if(isset($_POST["enable_goal_10"]) AND $goal_9_level != null)
    {
        $goal_10_level = ($_POST["goal_10_level"] > 0) ? $_POST["goal_10_level"] : null;
        $goal_10_reward = ($_POST["goal_10_reward"] > 0) ? $_POST["goal_10_reward"] : null;
    } else {
        $goal_10_level = null;
        $goal_10_reward = 0;
    }


    if($rewards_per_page <= 0)
    {
        $result = Core::result(Language::getTranslation("perPageError"), 1);
    } elseif($limit <= 0) {
        $result = Core::result(Language::getTranslation("limitError"), 1);
    } else {
        Core::updateSettings("referral_system", $enable_referral);
        Core::updateSettings("referral_log", $enable_log);
        Core::updateSettings("referral_rewards_per_page", $rewards_per_page);
        Core::updateSettings("referral_limit", $limit);
        Core::updateSettings("referral_level_1", $goal_1_level);
        Core::updateSettings("referral_level_2", $goal_2_level);
        Core::updateSettings("referral_level_3", $goal_3_level);
        Core::updateSettings("referral_level_4", $goal_4_level);
        Core::updateSettings("referral_level_5", $goal_5_level);
        Core::updateSettings("referral_level_6", $goal_6_level);
        Core::updateSettings("referral_level_7", $goal_7_level);
        Core::updateSettings("referral_level_8", $goal_8_level);
        Core::updateSettings("referral_level_9", $goal_9_level);
        Core::updateSettings("referral_level_10", $goal_10_level);
        Core::updateSettings("referral_reward_1", $goal_1_reward);
        Core::updateSettings("referral_reward_2", $goal_2_reward);
        Core::updateSettings("referral_reward_3", $goal_3_reward);
        Core::updateSettings("referral_reward_4", $goal_4_reward);
        Core::updateSettings("referral_reward_5", $goal_5_reward);
        Core::updateSettings("referral_reward_6", $goal_6_reward);
        Core::updateSettings("referral_reward_7", $goal_7_reward);
        Core::updateSettings("referral_reward_8", $goal_8_reward);
        Core::updateSettings("referral_reward_9", $goal_9_reward);
        Core::updateSettings("referral_reward_10", $goal_10_reward);
        $result = Core::result(Language::getTranslation("settingsUpdated"), 1);
    }

}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("settings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("referralSystem") ?></a></li>
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
                    <form method="post" action="index.php?page=referral-settings" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("refEnableDisable") ?></label>
                            <div class="col-sm-7">
                            <?php
                            if(Core::referralSystemEnabled())
                            {
                                echo '<input type="checkbox" name="enable_referral" class="js-switch" checked>';
                            } else {
                                echo '<input type="checkbox" name="enable_referral" class="js-switch">';
                            }
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("logEnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->logEnabled())
                                {
                                    echo '<input type="checkbox" name="enable_log" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_log" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("rewardsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->rewardsPerPage() ?>" name="rewards_per_page" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("referralLimit") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLimit() ?>" name="limit" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('1'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_1" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_1" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('1') ?>" name="goal_1_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('1') ?>" name="goal_1_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal2EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('2'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_2" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_2" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('2') ?>" name="goal_2_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('2') ?>" name="goal_2_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal3EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('3'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_3" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_3" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('3') ?>" name="goal_3_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('3') ?>" name="goal_3_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal4EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('4'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_4" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_4" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('4') ?>" name="goal_4_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('4') ?>" name="goal_4_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal5EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('5'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_5" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_5" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('5') ?>" name="goal_5_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('5') ?>" name="goal_5_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal6EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('6'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_6" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_6" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('6') ?>" name="goal_6_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('6') ?>" name="goal_6_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal7EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('7'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_7" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_7" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('7') ?>" name="goal_7_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('7') ?>" name="goal_7_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal8EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('8'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_8" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_8" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('8') ?>" name="goal_8_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('8') ?>" name="goal_8_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal9EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('9'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_9" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_9" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('9') ?>" name="goal_9_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('9') ?>" name="goal_9_reward" class="form-control">
                            </div>
                        </div>
                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal10EnableDisable") ?></label>
                            <div class="col-sm-7">
                                <?php
                                if($ref->levelIsSet('10'))
                                {
                                    echo '<input type="checkbox" name="enable_goal_10" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="enable_goal_10" class="js-switch">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Level") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getLevel('10') ?>" name="goal_10_level" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("goal1Reward") ?></label>
                            <div class="col-sm-7">
                                <input type="number" value="<?= $ref->getPoints('10') ?>" name="goal_10_reward" class="form-control">
                            </div>
                        </div>
                        <hr />


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