<?php
session_start();
require_once("../inc/init.php");

if(User::isLogged())
{
    Core::redirect("index.php");
    die();
}

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

$websiteTitle = Core::getSiteTitle();

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $captcha = isset($_POST["captchik"]) ? $_POST["captchik"] : null;

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
        } elseif (Admin::isAdmin($username) == false) {
            $result = Core::result(Language::getTranslation("youAreNotAdmin"), 2);
        } else {
            $result = Core::result(Language::getTranslation("logged"), 1);
            // Let's LOGIN !
            $_SESSION["username"] = $username;
            $login->saveLastIP($username);
            Core::redirect("index.php", 2);
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?= $websiteTitle ?> - <?= Language::getTranslation("loginTitle") ?></title>
	
	<link rel="icon" href="assets/img/favicon.ico">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- BEGIN CSS FRAMEWORK -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
	<!-- END CSS FRAMEWORK -->
	
	<!-- BEGIN CSS PLUGIN -->
	<link rel="stylesheet" href="assets/plugins/pace/pace-theme-minimal.css">
	<!-- END CSS PLUGIN -->
	
	<!-- BEGIN CSS TEMPLATE -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- END CSS TEMPLATE -->
</head>

<body class="login">
	<div class="outer">
		<div class="middle">
			<div class="inner">
				<div class="row">

                    <?php
                    if(isset($result)) { echo $result; }
                    ?>

					<!-- BEGIN LOGIN BOX -->
					<div class="col-lg-12">
						<h3 class="text-center login-title"><?= Language::getTranslation("loginToContinue") ?></h3>
						<div class="account-wall">
							<!-- BEGIN PROFILE IMAGE -->
							<img class="profile-img" src="assets/img/photo.png" alt="">
							<!-- END PROFILE IMAGE -->
							<!-- BEGIN LOGIN FORM -->
							<form method="post" name="login" action="<?= $_SERVER["PHP_SELF"] ?>" class="form-login">
								<input type="text" name="username" class="form-control"
                                       placeholder="<?= Language::getTranslation("regUsername") ?>" autofocus required>
								<input type="password" name="password" class="form-control"
                                       placeholder="<?= Language::getTranslation("regPassword") ?>" required>

                                <?php
                                if (isset($captcha_enabled)) {
                                    ?>
                                        <label for="captcha"><img id="captcha" src="../assets/securimage/securimage_show.php" alt="CAPTCHA Image"/>
                                            <a href="#"
                                               onclick="document.getElementById('captcha').src = '../assets/securimage/securimage_show.php?' + Math.random(); return false">[ <?= Language::getTranslation("anotherCaptcha"); ?>
                                                ]</a>
                                        </label>
                                        <input type="text" name="captchik" class="form-control" id="captcha"
                                               placeholder="<?= Language::getTranslation("regCaptcha"); ?>" required>
                                <?php
                                }
                                ?>

								<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
                                    <?= Language::getTranslation("loginButton") ?>
								</button>
							</form>
							<!-- END LOGIN FORM -->
						</div>
						<a href="<?= Links::getUrl("lost-pw") ?>" target="_blank" class="text-center new-account"><?= Language::getTranslation("fpHint") ?></a>
					</div>
					<!-- END LOGIN BOX -->
				</div>
			</div>
		</div>
	</div>

	<!-- BEGIN JS FRAMEWORK -->
	<script src="assets/plugins/jquery-2.1.0.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- END JS FRAMEWORK -->
	
	<!-- BEGIN JS PLUGIN -->
	<script src="assets/plugins/pace/pace.min.js"></script>
	<!-- END JS PLUGIN -->
</body>

</html>