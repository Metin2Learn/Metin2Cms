<?php
if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box">';
    echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - <a href="' . Links::getUrl("account edit") . '">
    ' . Language::getTranslation("editAccountTitle") . '</a> - ' . Language::getTranslation("editAccountChangePW") . '</h2>';

    if(Core::changePasswordMailVerification())
    {
        // Change pw with email verification
        if(isset($_GET["finish"])) {

            //Send Email
            if(ActionLog::hasBlock($_SESSION["username"], "change-pw-email"))
            {
                echo Core::result(Language::getTranslation("editAccountChangePWMailNotSent").
                    ActionLog::blockTime($_SESSION["username"], "change-pw-email").
                    Language::getTranslation("editAccountChangePWNextMail").ActionLog::unblockTime($_SESSION["username"], "change-pw-email"), 3);
            } else {
                $mail = new PHPMailer();
                if (Core::usingSMTP()) {
                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->SMTPAuth = true; // enable SMTP authentication
                    $mail->SMTPSecure = Core::getSMTPProtocol(); // sets the prefix to the servier
                    $mail->Host = Core::getSMTPHost(); // sets GMAIL as the SMTP server
                    $mail->Port = intval(Core::getSMTPPort()); // set the SMTP port for the GMAIL server
                    $mail->Username = Core::getSMTPUser(); // GMAIL username
                    $mail->Password = Core::getSMTPPassword(); // GMAIL password
                }
                $mail->isHTML(true);
                $mail->AddAddress(User::getUserEmail($_SESSION["username"]), $_SESSION["username"]);
                $mail->SetFrom(Core::getMailFrom(), Core::getMailFromName());
                $mail->Subject = Core::getSiteTitle() . " - " . Language::getTranslation("editAccountChangePWMailTitle");
                $token = Token::generate();
                Token::record($token, "change-pw");
                $mail->Body = Language::getTranslation("editAccountChangePWMailText") . "<b>" . $token . "</b>" .
                    Language::getTranslation("emailFooter");

                try {
                    $mail->Send();
                } catch (Exception $e) {
                    //Something went bad
                    echo "Fail - " . $mail->ErrorInfo;
                }
                ActionLog::write($_SESSION["username"], "change-pw-email");
            }

            if (Core::isCaptchaEnabled()) {
                $securimage = new Securimage();
            }
            $reg = new Registration();
            if (isset($_POST["change_pw"])) {
                $old_pw = $_POST["old_pw"];
                $new_pw = $_POST["new_pw"];
                $new_pw_again = $_POST["new_pw_again"];
                $code = $_POST["email_code"];
                if(Core::isCaptchaEnabled()) {
                    $captcha = $_POST["captcha"];
                }
                if (ActionLog::hasBlock($_SESSION["username"], "change-pw")) {
                    $result = Core::result(Language::getTranslation("editAccountChangePWHasBlock") . ActionLog::unblockTime($_SESSION["username"], "change-pw"), 2);
                } elseif (!Token::isCorrect($code, "change-pw")) {
                    $result = Core::result(Language::getTranslation("editAccountChangePWVerificationCodeNotValid"), 2);
                } elseif (!User::isCorrectPassword($old_pw)) {
                    $result = Core::result(Language::getTranslation("editAccountChangePWOldPWisWrong"), 2);
                } elseif (mb_strlen($new_pw) < Registration::getPasswordMin() OR mb_strlen($new_pw) > Registration::getPasswordMax()) {
                    $result = Core::result(Language::getTranslation("regPasswordRange"), 2);
                } elseif (Registration::needToContainNumber() AND !preg_match('@[0-9]@', $new_pw)) {
                    $result = Core::result(Language::getTranslation("regPasswordNeedNumber"), 2);
                } elseif (Registration::weakPasswordListEnabled() AND Registration::isWeakPassword($new_pw)) {
                    $result = Core::result(Language::getTranslation("weakPassword"), 2);
                } elseif ($new_pw != $new_pw_again) {
                    $result = Core::result(Language::getTranslation("pwDontMatchPw2"), 2);
                } elseif ($securimage->check($captcha) == false) {
                    $result = Core::result(Language::getTranslation("captchaWong"), 2);
                } else {
                    Token::delete($code);
                    User::changePassword($_SESSION["username"], $old_pw, $new_pw);
                    ActionLog::write($_SESSION["username"], "change-pw");
                    $result = Core::result(Language::getTranslation("editAccountChangePWSuccess"), 1);
                }
            }
            if (isset($result)) {
                echo $result;
            }
            ?>
            <ul>
                <li><?= Language::getTranslation("regPasswordRange"); ?></li>
                <?php
                if ($reg->needToContainNumber()) {
                    echo "<li>" . Language::getTranslation('regPasswordNeedNumber') . "</li>";
                }
                ?>
            </ul>
            <form method="post" action="<?= Links::getUrl("account change-pw-finish"); ?>">
                <div class="form-group">
                    <label for="old_password"><?= Language::getTranslation("editAccountChangePWOldPW"); ?></label>
                    <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="old_pw"
                           class="form-control"
                           id="old_password" required>
                </div>
                <div class="form-group">
                    <label for="email_code"><?= Language::getTranslation("editAccountChangePWEmailCode"); ?></label>
                    <input type="text" name="email_code" class="form-control"
                           id="email_code" required>
                </div>
                <div class="form-group">
                    <label for="new_password"><?= Language::getTranslation("editAccountChangePWNewPW"); ?></label>
                    <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="new_pw"
                           class="form-control"
                           id="new_password" required>
                </div>
                <div class="form-group">
                    <label
                        for="new_password_again"><?= Language::getTranslation("editAccountChangePWNewPWAgain"); ?></label>
                    <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="new_pw_again"
                           class="form-control"
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
                <button type="submit" name="change_pw"
                        class="btn btn-primary login-btn"><?= Language::getTranslation("editAccountChangePWButton"); ?></button>
            </form>
        <?php
        } else {
            echo Language::getTranslation("editAccountChangePWMailVerificationInfo");
            echo "<br />";
            echo '<form method="POST" action="'.Links::getUrl("account change-pw").'">';
            //echo '<a href="'.Links::getUrl("account change-pw-finish").'"><button type="submit" class="btn btn-primary">
            //'.Language::getTranslation("editAccountChangePWMailContinue").'</button></a></form>';
            echo '<a class="btn btn-primary" href="'.Links::getUrl("account change-pw-finish").'">'.Language::getTranslation("editAccountChangePWMailContinue").'</a>';
        }
    } else {
        if (Core::isCaptchaEnabled()) {
            $securimage = new Securimage();
        }
        $reg = new Registration();
        if(isset($_POST["change_pw"]))
        {
            $old_pw = $_POST["old_pw"];
            $new_pw = $_POST["new_pw"];
            $new_pw_again = $_POST["new_pw_again"];
            if(Core::isCaptchaEnabled()) {
                $captcha = $_POST["captcha"];
            }
            if(ActionLog::hasBlock($_SESSION["username"], "change-pw"))
            {
                $result = Core::result(Language::getTranslation("editAccountChangePWHasBlock").ActionLog::unblockTime($_SESSION["username"], "change-pw"), 2);
            } elseif(!User::isCorrectPassword($old_pw))
            {
                $result = Core::result(Language::getTranslation("editAccountChangePWOldPWisWrong"), 2);
            } elseif (mb_strlen($new_pw) < Registration::getPasswordMin() OR mb_strlen($new_pw) > Registration::getPasswordMax()) {
                $result = Core::result(Language::getTranslation("regPasswordRange"), 2);
            } elseif (Registration::needToContainNumber() AND !preg_match('@[0-9]@', $new_pw)) {
                $result = Core::result(Language::getTranslation("regPasswordNeedNumber"), 2);
            } elseif (Registration::weakPasswordListEnabled() AND Registration::isWeakPassword($new_pw)) {
                $result = Core::result(Language::getTranslation("weakPassword"), 2);
            } elseif ($new_pw != $new_pw_again) {
                $result = Core::result(Language::getTranslation("pwDontMatchPw2"), 2);
            } elseif ($securimage->check($captcha) == false) {
                $result = Core::result(Language::getTranslation("captchaWong"), 2);
            } else {
                User::changePassword($_SESSION["username"], $old_pw, $new_pw);
                ActionLog::write($_SESSION["username"], "change-pw");
                $result = Core::result(Language::getTranslation("editAccountChangePWSuccess"), 1);
            }
        }
        if(isset($result)) { echo $result; }
    ?>
        <ul>
            <li><?= Language::getTranslation("regPasswordRange"); ?></li>
            <?php
            if ($reg->needToContainNumber()) {
                echo "<li>" . Language::getTranslation('regPasswordNeedNumber') . "</li>";
            }
            ?>
        </ul>
        <form method="post" action="<?= Links::getUrl("account change-pw"); ?>">
            <div class="form-group">
                <label for="old_password"><?= Language::getTranslation("editAccountChangePWOldPW"); ?></label>
                <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="old_pw" class="form-control"
                       id="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password"><?= Language::getTranslation("editAccountChangePWNewPW"); ?></label>
                <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="new_pw" class="form-control"
                       id="new_password" required>
            </div>
            <div class="form-group">
                <label for="new_password_again"><?= Language::getTranslation("editAccountChangePWNewPWAgain"); ?></label>
                <input type="password" maxlength="<?= Registration::getPasswordMax(); ?>" name="new_pw_again" class="form-control"
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
            <button type="submit" name="change_pw" class="btn btn-primary login-btn"><?= Language::getTranslation("editAccountChangePWButton"); ?></button>
        </form>
        <?php
    }

    echo '</div>';
}

?>