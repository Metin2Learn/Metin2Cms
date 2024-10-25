<?php
if(Admin::hasRight($_SESSION["username"], "m1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewPlayers") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("game") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewPlayers") ?></li>
    </ol>
</section>

<section class="content">
    <?php

    if(isset($_GET["id"]) AND User::idExists($_GET["id"]))
    {
        $info = User::getInfo($_GET["id"]);
        if(isset($_POST["ban"]) AND !User::isBanned($info["login"]))
        {
            $reason = $_POST["reason"];
            $length = $_POST["length"];
            User::ban($info["login"], $length, $reason, $_SESSION["username"]);
            $result = Core::result(Language::getTranslation("userBanned"), 1);
        }

        if(isset($_POST["unban"]) AND User::isBanned($info["login"]))
        {
            User::unban($info["login"], $_SESSION["username"]);
            $result = Core::result(Language::getTranslation("userUnbanned"), 1);
        }

        if(isset($_POST["coins"]) AND $_POST["amount"] > 0)
        {
            if(isset($_POST["type"]) AND $_POST["type"] == 'plus')
            {
                User::addCoins($info["login"], $_POST["amount"]);
            } elseif(isset($_POST["type"]) AND $_POST["type"] == 'minus')
            {
                User::removeCoins($info["login"], $_POST["amount"]);
            }
            $result = Core::result(Language::getTranslation("coinsUpdated"), 1);
        }

        if(isset($_POST["rpoints"]) AND $_POST["amount2"] > 0)
        {
            if(isset($_POST["type2"]) AND $_POST["type2"] == 'plus')
            {
                Referral::statUpdatePoints($info["login"], $_POST["amount2"], "+");
            } elseif(isset($_POST["type2"]) AND $_POST["type2"] == 'minus')
            {
                Referral::statUpdatePoints($info["login"], $_POST["amount2"], "-");
            }
            $result = Core::result(Language::getTranslation("rpUpdated"), 1);
        }


        if(isset($result)) { echo $result; }
        ?>
    <div class="row">
        <!-- BEGIN USER PROFILE -->
        <div class="col-md-12">
                <div class="grid-body">
                    <ul class="nav nav-tabs">
                        <?php
                        if(User::isBanned($info["login"]))
                        {
                            echo '<li class="active"><a href="#unban" data-toggle="tab">'.Language::getTranslation("unbanAccount").'</a></li>';
                        } else {
                            echo '<li class="active"><a href="#ban" data-toggle="tab">'.Language::getTranslation("banAccount").'</a></li>';
                        }
                        ?>
                        <li><a href="#coins" data-toggle="tab"><?= Language::getTranslation("editCoins") ?></a></li>
                        <li><a href="#rpoints" data-toggle="tab"><?= Language::getTranslation("editRP") ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- BEGIN PROFILE -->
                        <?php
                        if(!User::isBanned($info["login"]))
                        {
                            echo '<div class="tab-pane active" id="ban">';

                            ?>
                            <p class="lead"><?= Language::getTranslation("banAccount") ?></p>
                            <hr>
                            <form method="POST" action="index.php?page=view-players&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("banReason") ?></label>
                                    <div class="col-sm-7">
                                        <input type="text" name="reason" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("length") ?></label>
                                    <div class="col-sm-7">
                                        <input type="number" name="length" class="form-control" required>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"
                                            name="ban"><?= Language::getTranslation("submit") ?></button>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                        <!-- END PROFILE -->
                        <!-- BEGIN TIMELINE -->
                    <?php
                    if(User::isBanned($info["login"]))
                    {
                        echo '<div class="tab-pane active" id="unban">';

                        ?>


                            <p class="lead"><?= Language::getTranslation("unbanAccount") ?></p>
                            <hr>
                    <p><b><?= Language::getTranslation("userBannedUntil") ?></b>
                    <?php
                    if($info["ban_until"] != null)
                    {
                        echo '<span class="label label-info">'.Core::makeNiceDate(User::getBanLength($info["login"])).'</span></p>';
                    } else {
                        echo '<span class="label label-info">pernament</span></p>';
                    }
                    ?>

                                <b><?= Language::getTranslation("banReason") ?>: </b>
                                <span class="label label-info"><?= User::getBanReason($info["login"]) ?></span></p>
                            <form method="POST" action="index.php?page=view-players&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                                <button type="submit" class="btn btn-primary"
                                        name="unban"><?= Language::getTranslation("unbanAccount") ?></button>
                            </form>
                        </div>
            <?php
            }

            ?>
                        <!-- END TIMELINE -->
                        <!-- BEGIN PHOTOS -->
                        <div class="tab-pane" id="coins">
                            <p class="lead"><?= Language::getTranslation("editCoins") ?></p>
                            <hr>
                            <form method="POST" action="index.php?page=view-players&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("type") ?></label>
                                    <div class="col-sm-7">
                                        <select id="source" class="form-control" name="type">
                                            <option value="plus"><?= Language::getTranslation("add") ?></option>
                                            <option value="minus"><?= Language::getTranslation("remove") ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("amount") ?></label>
                                    <div class="col-sm-7">
                                        <input type="number" name="amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"
                                            name="coins"><?= Language::getTranslation("submit") ?></button>
                                </div>
                            </form>
                        </div>
                        <!-- END PHOTOS -->
                        <!-- BEGIN SETTINGS -->
                        <div class="tab-pane" id="rpoints">
                            <p class="lead"><?= Language::getTranslation("editRP") ?></p>
                            <hr>
                            <form method="POST" action="index.php?page=view-players&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("type") ?></label>
                                    <div class="col-sm-7">
                                        <select id="source" class="form-control" name="type2">
                                            <option value="plus"><?= Language::getTranslation("add") ?></option>
                                            <option value="minus"><?= Language::getTranslation("remove") ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("amount") ?></label>
                                    <div class="col-sm-7">
                                        <input type="number" name="amount2" class="form-control" required>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"
                                            name="rpoints"><?= Language::getTranslation("submit") ?></button>
                                </div>
                            </form>
                        </div>
                        <!-- END SETTINGS -->
                    </div>
                </div>
        </div>
    </div>

    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <div class="row">

                        <div class="col-md-6">
                            <p><strong><?= Language::getTranslation("regUsername") ?>:</strong> <a><?= $info["login"] ?></a></p>
                            <p><strong><?= Language::getTranslation("regEmail") ?>:</strong> <a><?= $info["email"] ?></a></p>
                            <p><strong><?= Language::getTranslation("regDelete") ?>:</strong> <a><?= $info["social_id"] ?></a></p>
                            <p><strong><?= Language::getTranslation("created") ?>:</strong> <a><?= Core::makeNiceDate($info["create_time"]) ?></a></p>
                            <p><strong><?= Language::getTranslation("status") ?>:</strong> <a><?= $info["status"] ?></a></p>
                            <p><strong><?= Language::getTranslation("coins") ?>:</strong> <a><?= $info[Itemshop::currency()] ?></a></p>
                            <p><strong><?= Language::getTranslation("lastPlay") ?>:</strong> <a><?= Core::makeNiceDate($info["last_play"]) ?></a></p>
                            <p><strong><?= Language::getTranslation("regEmail") ?>:</strong> <a><?= $info["email"] ?></a></p>
                            <p><strong><?= Language::getTranslation("referrer") ?>:</strong> <a><?= $info["referrer"] ?></a></p>
                            <p><strong><?= Language::getTranslation("rPoints") ?>:</strong> <a><?= $info["rb_points"] ?></a></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><?= Language::getTranslation("safeboxExpireAdmin") ?>:</strong> <a><?= $info["safebox_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("goldExpireAdmin") ?>:</strong> <a><?= $info["gold_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("silverExpireAdmin") ?>:</strong> <a><?= $info["silver_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("autolootExpireAdmin") ?>:</strong> <a><?= $info["autoloot_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("fishExpireAdmin") ?>:</strong> <a><?= $info["fish_mind_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("marriageExpireAdmin") ?>:</strong> <a><?= $info["marriage_fast_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("moneyExpireAdmin") ?>:</strong> <a><?= $info["money_drop_rate_expire"] ?></a></p>
                            <p><strong><?= Language::getTranslation("registerIP") ?>:</strong> <a><?= $info["register_ip"] ?></a></p>
                            <p><strong><?= Language::getTranslation("lastIP") ?>:</strong> <a><?= $info["last_ip"] ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(User::getCountOfChars($info["login"]) > 0)
        {
            ?>
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-header">
                    <span class="grid-title"><?= Language::getTranslation("accountChars") ?></span>
                </div>
                <div class="grid-body">
                    <div class="row">
                        <?php
                            User::printAdminUserCharacters($info["login"]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        } else {
            echo Core::result(Language::getTranslation("noCharacters"), 4);
        }


        if(User::bannedTimes($info["login"]) > 0)
        {
            ?>
            <div class="row">
                <!-- BEGIN CUSTOM TABLE -->
                <div class="col-md-12">
                    <div class="grid no-border">
                        <div class="grid-header">
                            <span class="grid-title"><?= Language::getTranslation("userBanLog") ?></span>
                        </div>
                        <div class="grid-body">
                            <div class="row">
                                <?php
                                User::printUserBans($info["login"]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo Core::result(Language::getTranslation("userNotBannedYet"), 4);
        }
    } else {
    ?>


    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">

                    <?php

                    if (isset($result)) {
                        echo $result;
                    }


                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    $totalCount = Core::numberOfAccounts();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=view-players", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    $dbaccount = Core::getAccountDatabase();
                    Player::printAdminPlayers("SELECT * FROM " . $dbaccount . ".account ORDER by id LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=view-players&pagination=", "pagination");
                    // Print all news and pagination links
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>