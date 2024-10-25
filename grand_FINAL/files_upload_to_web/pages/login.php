<div class="box registration-form">
<h2><?= Language::getTranslation("loginTitle");?></h2>
<?php
if(User::isLogged())
{
    echo "<p>".Language::getTranslation("alreadyLogged")."</p></div>";
} else {
$login = new Login();
$securimage = new Securimage();

if ($login->failedLoginExists()) {
    $info = $login->failedLoginInfo();
    if ((time() - $info["first_attempt"]) > 600) {
        $login->clearFailedLogin();
    }
    if ($info["count_attempts"] >= Core::getFailedLoginAttempts() AND (time() - $info["first_attempt"]) < 600) {
        $captcha_enabled = true;
    }
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
	if(isset($captcha_enabled) AND isset($_POST["captchik"]))
	{
		$captcha = $_POST["captchik"];
	} else {
		$captcha = null;
	}

    if (empty($username) OR empty($password)) {
        $result = Core::result(Language::getTranslation("allFields"), 2);
    } elseif (isset($captcha_enabled) AND $securimage->check($captcha) == false) {
        $result = Core::result(Language::getTranslation("captchaWong"), 2);
    } elseif (!$login->enteredRightData($username, $password)) {
        $result = Core::result(Language::getTranslation("wrongData"), 2);
        $login->recordFailedLogin();
    } else {
        if (User::isBanned($username) AND User::getBanLength($username) == '0000-00-00 00:00:00') {
            $result = Core::result(Language::getTranslation("pernamentBan") . " " . User::getBanReason($username), 2);
        } elseif (User::isBanned($username) AND User::getBanLength($username) > date('Y-m-d H:i:s')) {
            $result = Core::result(Language::getTranslation("tempBan") . Core::makeNiceDate(User::getBanLength($username)) .
                Language::getTranslation("reason") . User::getBanReason($username), 2);
        } elseif (User::isBanned($username) AND User::getBanLength($username) < date('Y-m-d H:i:s')) {
            User::unban($username);
            $result = Core::result(Language::getTranslation("unbanned"), 3);
        } else {
            $result = Core::result(Language::getTranslation("logged"), 1);
            // Let's LOGIN !
            $_SESSION["username"] = $username;
            $login->saveLastIP($username);
            Core::redirect(Links::getUrl("account"), 0);
        }
    }
}


if (isset($result)) {
    echo $result;
}
?>

    <form method="post" action="<?= Links::getUrl("login"); ?>">
        <div class="form-group">
            <label for="login_username"><?= Language::getTranslation("regUsername"); ?></label>
            <input type="text" name="username" class="form-control" id="login_username" required>
        </div>
        <div class="form-group">
            <label for="login_pass"><?= Language::getTranslation("regPassword"); ?></label>
            <input type="password" name="password" class="form-control" id="login_pass" required>
        </div>
        <?php
        if (isset($captcha_enabled)) {
            ?>
            <div class="form-group">
                <label for="captcha"><img id="captcha" src="assets/securimage/securimage_show.php" alt="CAPTCHA Image"/>
                    <a href="#"
                       onclick="document.getElementById('captcha').src = 'assets/securimage/securimage_show.php?' + Math.random(); return false">[ <?= Language::getTranslation("anotherCaptcha"); ?>
                        ]</a>
                </label>
                <input type="text" name="captchik" class="form-control" id="captcha"
                       placeholder="<?= Language::getTranslation("regCaptcha"); ?>" required>
            </div>
        <?php
        }
        ?>
        <button type="submit" name="login"
                class="btn btn-primary login-btn"><?= Language::getTranslation("loginButton"); ?></button>
        <a href="<?= Links::getUrl("lost-pw");?>" id="reset-password-toggle" class=""><?= Language::getTranslation("fpHint"); ?></a>
    </form>

</div>
<?php
}
?>