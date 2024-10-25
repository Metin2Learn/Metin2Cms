<div class="box">
<h2><?= Language::getTranslation("accountTitle");?></h2>
<?php
if(User::isLogged())
{
    if(Admin::isAdmin($_SESSION["username"]))
    {
        echo '<a href="admin/index.php" class="btn btn-primary">'.Language::getTranslation("administration").'</a><br /><br />';
    }
    echo '<span class="label label-primary">'.Language::getTranslation("userGreetings").$_SESSION["username"].'</span>';
    echo '<div class="list-group">';
    echo '<a href="'.Links::getUrl("account info").'" class="list-group-item">'.Language::getTranslation("userInfo").'</a>';
    echo '<a href="'.Links::getUrl("account coins").'" class="list-group-item active">'.Language::getTranslation("userCoins").'</a>';
    echo '<a href="'.Links::getUrl("account edit").'" class="list-group-item">'.Language::getTranslation("userEditAccount").'</a>';
    echo '<a href="'.Links::getUrl("account chars").'" class="list-group-item active">'.Language::getTranslation("userChars").'</a>';
    if(Core::ticketSystemEnabled()) {
        echo '<a href="' . Links::getUrl("account ticket system") . '" class="list-group-item">' . Language::getTranslation("userTicketSystem") . '</a>';
    }
    if(Core::referralSystemEnabled())
    {
        echo '<a href="'.Links::getUrl("account referral system").'" class="list-group-item active">'.Language::getTranslation("userReferralSystem").'</a>';
    }
    echo '<a href="'.Links::getUrl("logout").'" class="list-group-item">'.Language::getTranslation("userLogout").'</a>';
    echo '</div>';
} else {
    echo Language::getTranslation("notLogged");
    Core::redirect(Links::getUrl("login"),2);
}
?>
</div>