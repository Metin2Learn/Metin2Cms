<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if(Core::referralSystemEnabled()) {
        $referral = new Referral();
        $referral->check($_SESSION["username"]);

        //echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> -' .
            Language::getTranslation("referralSysTitle") . '</h2>';

        //echo '</div>';
        echo Core::result(Language::getTranslation("referralSysIntroduce"), 3);

        echo '<div class="text-center"><a href="'.Links::getUrl("account referral rewards").'" class="btn btn-danger">'.Language::getTranslation("referralRewards").'</a></div><br />';

        echo '<div class="box">';

        echo '<h2>'.Language::getTranslation("referralSysHowDoesItWork").'</h2>';
        echo '<p>';
        echo Language::getTranslation("referralSysHowDoesItWorkDesc");
        echo $referral->getUrl();
        echo Language::getTranslation("referralSysHowDoesItWorkDesc2");
        echo "<br />";
        echo '<span class="label label-default">'.Language::getTranslation("referralSysLimit").
            $referral->remainingUserLimit($_SESSION["username"]).Language::getTranslation("referralSysLimitFriends").'</span>';
        echo '</p>';

        echo '<h2>'.Language::getTranslation("referralSysWhichRewards").'</h2>';
        echo '<p>';
        echo '<ul>';
        echo $referral->getRewardsInfo();
        echo '</ul>';
        echo '</p>';

        echo '<h2>'.Language::getTranslation("referralSysHowManyRB").'</h2>';
        echo '<p>';
        echo Language::getTranslation("referralSysRewards");
        echo '</p>';
        echo '</div>';

        echo '<div class="box">';
        echo '<h2>'.Language::getTranslation("referralSysInvitedFriends").'</h2>';
        if($referral->numberOfReferrals($_SESSION["username"]) > 0) {

            echo '<p>';

            echo $referral->printTable($_SESSION["username"]);

            echo '</p>';
        } else {
            echo Core::result(Language::getTranslation("referralSysNotReferrals"), 4);
        }
        echo '<span class="label label-default">'.Language::getTranslation("referralSysYourRB").Referral::getUserPoints($_SESSION["username"]).'</span>';
        echo '</div>';

    } else {
        Core::redirect(Links::getUrl("account"));
    }
}

?>