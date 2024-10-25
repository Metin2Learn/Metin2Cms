<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if (Core::referralSystemEnabled()) {
        $ref = new Referral();
        echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> -
        <a href="'.Links::getUrl("account referral system").'">' .
            Language::getTranslation("referralSysTitle") . '</a> - '. Language::getTranslation("referralRewards").'</h2>';

        if(Core::referralSystemEnabled())
        {
            echo '<li class="list-group-item">'.Language::getTranslation("referralSysRP").'
    <span class="text-primary">'.Referral::getUserPoints($_SESSION["username"]).'</span></li><br />';
        }
        ?>

<?php
        if($ref->numberOfRewards() > 0)
        {

            if(isset($_GET["buy"]) AND $ref->rewardExists($_GET["buy"]))
            {
                $rewardInfo = $ref->getRewardInfo($_GET["buy"]);
                if(Referral::getUserPoints($_SESSION["username"]) < $rewardInfo["price"]) {
                    echo Core::result(Language::getTranslation("referralRewardNotEnoughPoints"), 2);
                } elseif (User::hasEmptyItemShopMall($_SESSION["username"]) == false) {
                    echo Core::result(Language::getTranslation("isNotEmptyItemshopMall"), 2);
                } else {
                    if ($rewardInfo['addon_type'] == 0) {
                        $attrtype0 = 0;
                        $attrtype1 = 0;
                        $attrvalue0 = 0;
                        $attrvalue1 = 0;
                    } else {
                        $attrtype0 = 72;
                        $attrtype1 = 71;
                        $skoda = mt_rand(8, 30);
                        $poskozeni = mt_rand(-18, -1);
                        $attrvalue0 = $skoda;
                        $attrvalue1 = $poskozeni;
                    }

                    if ($rewardInfo["time_limit"] > 0) {
                        $socket0 = strtotime("+ " . $rewardInfo['time_limit'] . " seconds");
                    } else {
                        $socket0 = $rewardInfo["socket0"];
                    }
                    $socket1 = $rewardInfo["socket1"];
                    $socket2 = $rewardInfo["socket2"];

                    User::generateItem($_SESSION["username"], $rewardInfo["count"], $rewardInfo["item_vnum"],
                        $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2);
                    $ref->updatePoints($rewardInfo["price"], "-");
                    if($ref->logEnabled())
                    {
                        $ref->rewardLog($_SESSION["username"], $_GET["buy"], $rewardInfo["item_vnum"],
                            $rewardInfo["name"], $rewardInfo["count"], $rewardInfo["price"]);
                    }
                    echo Core::result(Language::getTranslation("referralRewardSuccess"), 1);
                }
            }

            // Paginator
            $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
            $totalCount = $ref->numberOfRewards();
            $perPage = $ref->rewardsPerPage();
            $paginator = new Paginator($page, $totalCount, $perPage);
            // Paginator

            // Validate page
            if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                Core::redirect(Links::getUrl("account referral system"), 0);
                die();
            }
            // Validate page


            // Print all news and pagination links
            global $dbname;
            $ref->printRewards("SELECT * FROM " . $dbname . ".referral_rewards LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
            $paginator->printLinks("referral-rewards/page/", "pagination");
            // Print all news and pagination links

        } else {
            echo Core::result(Language::getTranslation("referralRewardsNotFound"), 4);
        }

        echo '</div>';

    } else {
        Core::redirect(Links::getUrl("account"));
    }
}

?>