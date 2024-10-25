<?php

if(User::isLogged())
{
    Core::redirect(Links::getUrl("account"));
} else {

    $pr = new PasswordRecovery();

    if(isset($_GET["user"]) AND User::usernameExists($_GET["user"]) AND
    isset($_GET["token"]) AND $pr->isValidToken($_GET["user"], $_GET["token"]))
    {
        if(isset($_POST["choose_pw"]))
        {
            $pw = $_POST["pw"];
            $pw_again = $_POST["pw_again"];
            if (mb_strlen($pw) < Registration::getPasswordMin() OR mb_strlen($pw) > Registration::getPasswordMax()) {
                $result2 = Core::result(Language::getTranslation("regPasswordRange"), 2);
            } elseif (Registration::needToContainNumber() AND !preg_match('@[0-9]@', $pw)) {
                $result2 = Core::result(Language::getTranslation("regPasswordNeedNumber"), 2);
            } elseif ($pw != $pw_again) {
                $result2 = Core::result(Language::getTranslation("pwDontMatchPw2"), 2);
            } elseif (Registration::weakPasswordListEnabled() AND Registration::isWeakPassword($pw)) {
                $result2 = Core::result(Language::getTranslation("weakPassword"), 2);
            } elseif (!$pr->isValidToken($_GET["user"], $_GET["token"])) {
                Core::redirect(Links::getUrl("account"));
                die();
            } else {
                if(Core::passwordRecoveryLogEnabled())
                {
                    //Log
                    $pr->log($_GET["user"], $pw, $_GET["token"]);
                }
                $pr->deleteToken($_GET["user"], $_GET["token"]);
                User::changePassword($_GET["user"], "nothing", $pw, false);
                $result2 = Core::result(Language::getTranslation("fpChangeSuccess"),1);
            }

        }

        echo '<div class="box">';
        echo '<h2>'.Language::getTranslation("fpChangeTitle").'</h2>';
        echo '<p><span class="label label-info">'.Language::getTranslation("fpChangeDesc").$_GET["user"].'</span></p>';
        if(isset($result2))
        {
            echo $result2;
        }
        ?>
        <ul>
        <li><?= Language::getTranslation("regPasswordRange"); ?></li>
        <?php
        if (Registration::needToContainNumber()) {
            echo "<li>" . Language::getTranslation('regPasswordNeedNumber') . "</li>";
        }
        ?>
        </ul>
    <form method="post" action="<?= Links::getUrl("lost-pw")."/user/".$_GET["user"]."/token/".$_GET["token"]; ?>">
        <div class="form-group">
            <label for="pw"><?= Language::getTranslation("fpChangeNewPassword"); ?></label>
            <input type="password" class="form-control" name="pw" id="pw" required>
        </div>
        <div class="form-group">
            <label for="pw_again"><?= Language::getTranslation("fpChangeNewPasswordAgain"); ?></label>
            <input type="password" class="form-control" name="pw_again" id="pw_again" required>
        </div>
        <button type="submit" name="choose_pw" class="btn btn-primary"><?= Language::getTranslation("fpChangeButton"); ?></button>
        <?php
        echo '</div>';
    } else {

        if (Core::isCaptchaEnabled()) {
            $securimage = new Securimage();
        }

        if (isset($_POST["forg_pw"])) {
            $username = $_POST["forg_username"];
            $email = $_POST["forg_email"];
            if (Core::isCaptchaEnabled()) {
                $captcha = $_POST["captcha"];
            }

            if (Core::isCaptchaEnabled() AND $securimage->check($captcha) == false) {
                $result = Core::result(Language::getTranslation("captchaWong"), 2);
            } elseif (!$pr->combinationExists($username, $email)) {
                $result = Core::result(Language::getTranslation("fpCombinationNotFound"), 2);
            } elseif ($pr->requestExists($username)) {
                $result = Core::result(Language::getTranslation("fpRequestExists"), 4);
            } else {
                $token = Core::generateToken(mt_rand(6, 20));
                $pr->saveRequest($username, $token);
                $pr->sendEmail($username, $email, $token);
                $result = Core::result(Language::getTranslation("fpSuccess"), 1);
            }
        }


        ?>

        <div class="box registration-form">
            <h2><?= Language::getTranslation("fpTitle"); ?></h2>

            <p><?= Language::getTranslation("fpDesc"); ?></p>

            <?php
            if (isset($result)) {
                echo $result;
            }
            ?>

            <form method="post" action="<?= Links::getUrl("lost-pw"); ?>">
                <div class="form-group">
                    <label for="forg_username"><?= Language::getTranslation("regUsername"); ?></label>
                    <input type="text" class="form-control" name="forg_username" id="forg_username" required>
                </div>
                <div class="form-group">
                    <label for="forg_email"><?= Language::getTranslation("regEmail"); ?></label>
                    <input type="email" class="form-control" name="forg_email" id="forg_email" required>
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

                <button type="submit" name="forg_pw"
                        class="btn btn-primary"><?= Language::getTranslation("fpButton"); ?></button>
            </form>
        </div>
    <?php
    }
}

?>