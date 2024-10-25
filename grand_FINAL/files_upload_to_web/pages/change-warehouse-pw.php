<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if (Core::isCaptchaEnabled()) {
        $securimage = new Securimage();
    }
    if(isset($_POST["change_pw"]))
    {
        if(!User::isDefaultWarehousePassword($_SESSION["username"])) {
            $old_pw = $_POST["old_pw"];
        }
        $new_pw = $_POST["new_pw"];
        $new_pw_again = $_POST["new_pw_again"];
        if(Core::isCaptchaEnabled()) {
            $captcha = $_POST["captcha"];
        }
        if(ActionLog::hasBlock($_SESSION["username"], "change-warehouse-pw"))
        {
            $result = Core::result(Language::getTranslation("changeWarehousePasswordHasBlock").
                ActionLog::unblockTime($_SESSION["username"], "change-warehouse-pw"), 2);
        } elseif(!User::isDefaultWarehousePassword($_SESSION["username"]) AND !User::isCorrectWarehousePassword($_SESSION["username"], $old_pw))
        {
            $result = Core::result(Language::getTranslation("changeWarehousePasswordOldNotValid"), 2);
        } elseif(!ctype_alnum($new_pw)) {
            $result = Core::result(Language::getTranslation("changeWarehousePasswordNotAlphanumeric"), 2);
        } elseif(mb_strlen($new_pw) != 6) {
            $result = Core::result(Language::getTranslation("changeWarehousePasswordNot6Chars"), 2);
        } elseif($new_pw != $new_pw_again) {
            $result = Core::result(Language::getTranslation("changeWarehousePasswordNotMatch"), 2);
        } elseif ($securimage->check($captcha) == false) {
            $result = Core::result(Language::getTranslation("captchaWong"), 2);
        } else {
            if(!User::isDefaultWarehousePassword($_SESSION["username"]))
            {
                User::changeWarehousePassword($_SESSION["username"], $old_pw, $new_pw);
            } else {
                User::changeWarehousePassword($_SESSION["username"], "000000", $new_pw);
            }
            ActionLog::write($_SESSION["username"], "change-warehouse-pw");
            $result = Core::result(Language::getTranslation("changeWarehousePasswordSuccess"), 1);
        }
    }

    echo '<div class="box">';
    echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - <a href="' . Links::getUrl("account edit") . '">
    ' . Language::getTranslation("editAccountTitle") . '</a> - ' . Language::getTranslation("changeWarehousePasswordTitle") . '</h2>';
    if(isset($result)) { echo $result; }
    echo '<ul>';
    echo '<li>'.Language::getTranslation("changeWarehousePasswordRange").'</li>';
    echo '</ul>';
?>
    <form method="post" action="<?= Links::getUrl("account change-warehouse-pw"); ?>">
        <div class="form-group">
            <label for="old_password"><?= Language::getTranslation("changeWarehousePasswordOld"); ?></label>
            <input type="password" maxlength="6" name="old_pw" class="form-control"
                   id="old_password">
        </div>
        <div class="form-group">
            <label for="new_password"><?= Language::getTranslation("changeWarehousePasswordNew"); ?></label>
            <input type="password" maxlength="6" name="new_pw" class="form-control"
                   id="new_password" required>
        </div>
        <div class="form-group">
            <label for="new_password_again"><?= Language::getTranslation("changeWarehousePasswordNewAgain"); ?></label>
            <input type="password" maxlength="6" name="new_pw_again" class="form-control"
                   id="new_password_again" required>
        </div>
        <?php
        if (Core::isCaptchaEnabled()) {
            ?>
            <div class="form-group">
                <label for="captcha"><img id="captcha" src="assets/securimage/securimage_show.php"
                                          alt="CAPTCHA Image"/>
                    <a href="#"
                       onclick="document.getElementById('captcha').src = 'assets/securimage/securimage_show.php?' + Math.random(); return false">[ <?= Language::getTranslation("anotherCaptcha"); ?>
                        ]</a>
                </label>
                <input type="text" name="captcha" class="form-control" id="captcha"
                       placeholder="<?= Language::getTranslation("regCaptcha"); ?>" required>
            </div>
        <?php
        }
        ?>
        <button type="submit" name="change_pw" class="btn btn-primary login-btn"><?= Language::getTranslation("changeWarehousePasswordButton"); ?></button>
    </form>
<?php

    echo '</div>';
}

?>