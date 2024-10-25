<div class="box">
<h2><?= Language::getTranslation("regTitle");?></h2>

<?php
if(User::isLogged())
{
    echo "<p>".Language::getTranslation("alreadyLogged")."</p>";
} else {

    $reg = new Registration();
    $ref = new Referral();
    if (Core::isCaptchaEnabled()) {
        $securimage = new Securimage();
    }
    if (!$reg->isEnabled()) {
        echo '<p>' . Language::getTranslation("regDisabled") . '</p>';
    } else {

        if(isset($_GET['ref']) AND ctype_digit($_GET['ref']) AND Core::referralSystemEnabled())
        {
            $_SESSION["ref"] = $_GET["ref"];
        }

        if (isset($_POST["reg"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $pw = $_POST["pw"];
            $pw2 = $_POST["pw2"];
            $dcode = $_POST["deleteCode"];
            if (Core::isCaptchaEnabled()) {
                $captcha = $_POST["captcha"];
            }

            if (empty($username) OR empty($email) OR empty($pw) OR empty($pw2) OR empty($dcode) OR empty($captcha)) {
                $result = Core::result(Language::getTranslation("fillInAllFields"), 2);
            } elseif (!ctype_alnum($username)) {
                $result = Core::result(Language::getTranslation("regAlphanumeric"), 2);
            } elseif (mb_strlen($username) < Registration::getUsernameMin() OR mb_strlen($username) > Registration::getPasswordMax()) {
                $result = Core::result(Language::getTranslation("regUsernameRange"), 2);
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $result = Core::result(Language::getTranslation("emailNotValid"), 2);
            } elseif ($reg->emailExists($email)) {
                $result = Core::result(Language::getTranslation("emailExists"), 2);
            } elseif ($reg->usernameExists($username)) {
                $result = Core::result(Language::getTranslation("usernameExists"), 2);
            } elseif (mb_strlen($pw) < Registration::getPasswordMin() OR mb_strlen($pw) > Registration::getPasswordMax()) {
                $result = Core::result(Language::getTranslation("regPasswordRange"), 2);
            } elseif (Registration::needToContainNumber() AND !preg_match('@[0-9]@', $pw)) {
                $result = Core::result(Language::getTranslation("regPasswordNeedNumber"), 2);
            } elseif ($pw != $pw2) {
                $result = Core::result(Language::getTranslation("pwDontMatchPw2"), 2);
            } elseif (mb_strlen($dcode) != 7 OR !ctype_alnum($dcode)) {
                $result = Core::result(Language::getTranslation("regDeleteCode"), 2);
            } elseif (Registration::weakPasswordListEnabled() AND Registration::isWeakPassword($pw)) {
                $result = Core::result(Language::getTranslation("weakPassword"), 2);
            } elseif ($securimage->check($captcha) == false) {
                $result = Core::result(Language::getTranslation("captchaWong"), 2);
            } else {
                // Let's register
                if ($reg->register($username, $pw, $email, $dcode) > 0) {
                    $result = Core::result(Language::getTranslation("regSuccessful"), 1);
                    if(isset($_POST["ref"]) AND User::idExists($_POST["ref"]) AND
                        $ref->remainingUserLimit(User::getUserNameFromId($_POST["ref"])) != 0 AND Core::referralSystemEnabled()) {
                        Referral::updateReferrer($username, $_POST["ref"]);
                    }
                }
            }
        }

        if (isset($result)) {
            echo $result;
        }
        ?>
        <p><?= Language::getTranslation("regDesc"); ?></p>
        <ul>
            <li><?= Language::getTranslation("regAlphanumeric"); ?></li>
            <li><?= Language::getTranslation("regUsernameRange"); ?></li>
            <li><?= Language::getTranslation("regPasswordRange"); ?></li>
            <?php
            if (Registration::needToContainNumber()) {
                echo "<li>" . Language::getTranslation('regPasswordNeedNumber') . "</li>";
            }
            ?>
            <li><?= Language::getTranslation("regDeleteCode"); ?></li>
        </ul>
        <form method="post" action="<?= Links::getUrl("register"); ?>">
            <div class="form-group">
                <label for="reg_username"><?= Language::getTranslation("regUsername"); ?></label>
                <input type="text" name="username" class="form-control" id="reg_username"
                       maxlength="<?= Registration::getUsernameMax(); ?>"
                       placeholder="<?= Language::getTranslation("regEnter") . " " . Language::getTranslation("regUsername"); ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="reg_email"><?= Language::getTranslation("regEmail"); ?></label>
                <input type="email" name="email" class="form-control" id="reg_email"
                       placeholder="<?= Language::getTranslation("regEnter") . " " . Language::getTranslation("regEmail"); ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="reg_pass"><?= Language::getTranslation("regPassword"); ?></label>
                <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="pw" class="form-control"
                       id="reg_pass" placeholder="<?= Language::getTranslation("regPassword"); ?>" required>
            </div>
            <div class="form-group">
                <label for="reg_pass2"><?= Language::getTranslation("regPasswordAgain"); ?></label>
                <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="pw2"
                       class="form-control" id="reg_pass2" placeholder="<?= Language::getTranslation("regPassword"); ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="reg_delete"><?= Language::getTranslation("regDelete"); ?></label>
                <input type="text" maxlength="7" name="deleteCode" class="form-control" id="reg_delete"
                       placeholder="<?= Language::getTranslation("regEnter") . " " . Language::getTranslation("regDelete"); ?>"
                       required>
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

            if(isset($_GET['ref']) AND ctype_digit($_GET['ref']) AND Core::referralSystemEnabled())
            {
                echo '<input type="hidden" name="ref" value="'.$_GET['ref'].'">';
            } elseif(isset($_SESSION["ref"]) AND ctype_digit($_SESSION["ref"]) AND Core::referralSystemEnabled()) {
                echo '<input type="hidden" name="ref" value="'.$_SESSION['ref'].'">';
            }
            ?>
            <button type="submit" name="reg"
                    class="btn btn-primary"><?= Language::getTranslation("register"); ?></button>
        </form>
    <?php

    }
}
?>
</div>