<?php
if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    echo '<div class="box">';
    echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - <a href="' . Links::getUrl("account edit") . '">
    ' . Language::getTranslation("editAccountTitle") . '</a> - ' . Language::getTranslation("changeEmailTitle") . '</h2>';

    if(Core::changeEmailEnabled())
    {
        if(Core::changeEmailVerificationEnabled()) {

            if (isset($_GET["finish"])) {

                if(ActionLog::hasBlock($_SESSION["username"], "change-email-mail"))
                {
                    echo Core::result(Language::getTranslation("changeEmailMailNotSent").
                        ActionLog::blockTime($_SESSION["username"], "change-email-mail").
                        Language::getTranslation("changeEmailNextMail").ActionLog::unblockTime($_SESSION["username"], "change-email-mail"), 3);
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
                    $mail->Subject = Core::getSiteTitle() . " - " . Language::getTranslation("changeEmailMailTitle");
                    $token = Token::generate();
                    Token::record($token, "change-email");
                    $mail->Body = Language::getTranslation("changeEmailMailText") . "<b>" . $token . "</b>" .
                        Language::getTranslation("emailFooter");

                    try {
                        $mail->Send();
                    } catch (Exception $e) {
                        //Something went bad
                        echo "Fail - " . $mail->ErrorInfo;
                    }
                    ActionLog::write($_SESSION["username"], "change-email-mail");
                }

                if (Core::isCaptchaEnabled()) {
                    $securimage = new Securimage();
                }
                if(isset($_POST["change_email"])) {
                    $old_email = $_POST["old_email"];
                    $password = $_POST["password"];
                    $verif_code = $_POST["verif_code"];
                    $new_email = $_POST["new_email"];
                    $new_email_again = $_POST["new_email_again"];
                    if (Core::isCaptchaEnabled()) {
                        $captcha = $_POST["captcha"];
                    }

                    if (ActionLog::hasBlock($_SESSION["username"], "change-email")) {
                        $result = Core::result(Language::getTranslation("changeEmailHasBlock") . ActionLog::unblockTime($_SESSION["username"], "change-email"), 2);
                    } elseif (!Token::isCorrect($verif_code, "change-email")) {
                        $result = Core::result(Language::getTranslation("changeEmailVerificationCodeNotCorrect"), 2);
                    } elseif (!User::isCorrectEmail($_SESSION["username"], $old_email)) {
                        $result = Core::result(Language::getTranslation("changeEmailBadOldEmail"), 2);
                    } elseif (!User::isCorrectPassword($password)) {
                        $result = Core::result(Language::getTranslation("changeEmailBadPassword"), 2);
                    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                        $result = Core::result(Language::getTranslation("changeEmailBadFormat"), 2);
                    } elseif (User::emailExists($new_email)) {
                        $result = Core::result(Language::getTranslation("changeEmailAlreadyExists"), 2);
                    } elseif ($new_email != $new_email_again) {
                        $result = Core::result(Language::getTranslation("changeEmailNotMatch"), 2);
                    } elseif (Core::isCaptchaEnabled() AND $securimage->check($captcha) == false) {
                        $result = Core::result(Language::getTranslation("captchaWong"), 2);
                    } else {
                        User::changeEmail($_SESSION["username"], $old_email, $new_email);
                        ActionLog::write($_SESSION["username"], "change-email");
                        Token::delete($verif_code);
                        $result = Core::result(Language::getTranslation("changeEmailSuccess"), 1);
                        //Change mail
                    }
                }

                if(isset($result)) { echo $result; }
                ?>
                <form method="post" action="<?= Links::getUrl("account change-email-finish"); ?>">
                    <div class="form-group">
                        <label for="old_email"><?= Language::getTranslation("changeEmailOldEmail"); ?></label>
                        <input type="text" name="old_email"
                               class="form-control"
                               id="old_email" required>
                    </div>
                    <div class="form-group">
                        <label for="curr_password"><?= Language::getTranslation("changeEmailYourPassword"); ?></label>
                        <input type="password" name="password" class="form-control"
                               id="curr_password" required>
                    </div>
                    <div class="form-group">
                        <label for="verif_code"><?= Language::getTranslation("changeEmailVerificationCode"); ?></label>
                        <input type="text" name="verif_code" class="form-control"
                               id="verif_code" required>
                    </div>
                    <div class="form-group">
                        <label for="new_email"><?= Language::getTranslation("changeEmailNewEmail"); ?></label>
                        <input type="text" name="new_email"
                               class="form-control"
                               id="new_email" required>
                    </div>
                    <div class="form-group">
                        <label
                            for="new_email_again"><?= Language::getTranslation("changeEmailNewEmailAgain"); ?></label>
                        <input type="text" name="new_email_again"
                               class="form-control"
                               id="new_email_again" required>
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
                    <button type="submit" name="change_email"
                            class="btn btn-primary login-btn"><?= Language::getTranslation("changeEmailButton"); ?></button>
                </form>
            <?php

            } else {
                echo Language::getTranslation("changeEmailVerificationInfo");
                echo '<br /><a class="btn btn-primary" href="' . Links::getUrl("account change-email-finish") . '">
            ' . Language::getTranslation("changeEmailContinueButton") . '</a>';

            }
        } else {
            if (Core::isCaptchaEnabled()) {
                $securimage = new Securimage();
            }
            if(isset($_POST["change_email"]))
            {
                $old_email = $_POST["old_email"];
                $password = $_POST["password"];
                $new_email = $_POST["new_email"];
                $new_email_again = $_POST["new_email_again"];
                if(Core::isCaptchaEnabled()) {
                    $captcha = $_POST["captcha"];
                }

                if(ActionLog::hasBlock($_SESSION["username"], "change-email")) {
                    $result = Core::result(Language::getTranslation("changeEmailHasBlock") . ActionLog::unblockTime($_SESSION["username"], "change-email"), 2);
                } elseif(!User::isCorrectEmail($_SESSION["username"], $old_email))
                {
                    $result = Core::result(Language::getTranslation("changeEmailBadOldEmail"),2);
                } elseif(!User::isCorrectPassword($password)) {
                    $result = Core::result(Language::getTranslation("changeEmailBadPassword"),2);
                } elseif(!filter_var($new_email, FILTER_VALIDATE_EMAIL))
                {
                    $result = Core::result(Language::getTranslation("changeEmailBadFormat"),2);
                } elseif(User::emailExists($new_email))
                {
                    $result = Core::result(Language::getTranslation("changeEmailAlreadyExists"),2);
                } elseif($new_email != $new_email_again) {
                    $result = Core::result(Language::getTranslation("changeEmailNotMatch"), 2);
                } elseif(Core::isCaptchaEnabled() AND $securimage->check($captcha) == false)
                {
                    $result = Core::result(Language::getTranslation("captchaWong"), 2);
                } else {
                    User::changeEmail($_SESSION["username"], $old_email, $new_email);
                    ActionLog::write($_SESSION["username"], "change-email");
                    $result = Core::result(Language::getTranslation("changeEmailSuccess"), 1);
                    //Change mail
                }
            }
            if(isset($result)) { echo $result; }
            ?>
    <form method="post" action="<?= Links::getUrl("account change-email"); ?>">
    <div class="form-group">
        <label for="old_email"><?= Language::getTranslation("changeEmailOldEmail"); ?></label>
        <input type="text" name="old_email"
               class="form-control"
               id="old_email" required>
    </div>
    <div class="form-group">
        <label for="curr_password"><?= Language::getTranslation("changeEmailYourPassword"); ?></label>
        <input type="password" name="password" class="form-control"
               id="curr_password" required>
    </div>
    <div class="form-group">
        <label for="new_email"><?= Language::getTranslation("changeEmailNewEmail"); ?></label>
        <input type="text" name="new_email"
               class="form-control"
               id="new_email" required>
    </div>
    <div class="form-group">
        <label
            for="new_email_again"><?= Language::getTranslation("changeEmailNewEmailAgain"); ?></label>
        <input type="text" name="new_email_again"
               class="form-control"
               id="new_email_again" required>
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
    <button type="submit" name="change_email"
            class="btn btn-primary login-btn"><?= Language::getTranslation("changeEmailButton"); ?></button>
</form>
<?php
        }
    } else {
        echo Core::result(Language::getTranslation("changeEmailDisabled"),4);
    }

    echo '</div>';

}

?>