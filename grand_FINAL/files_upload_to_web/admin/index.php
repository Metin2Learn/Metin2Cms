<?php
session_start();
require_once("../inc/init.php");


if(User::isLogged() AND Admin::isAdmin($_SESSION["username"]) == false)
{
    Core::redirect(Links::getUrl("home"));
    die();
} elseif(User::isLogged() == false) {
    Core::redirect("login.php");
    die();
}

$websiteTitle = Core::getSiteTitle();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?= $websiteTitle ?></title>
	
	<link rel="icon" href="../assets/images/favicon/favicon.ico">

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
    <?php
    if(isset($_GET["page"]) AND ($_GET["page"] == "add-news" OR $_GET["page"] == "edit-news" OR $_GET["page"] == "news-settings"
            OR $_GET["page"] == "add-download" OR $_GET["page"] == "edit-download" OR $_GET["page"] == 'view-ticket'
            OR $_GET["page"] == 'add-is-item' OR $_GET["page"] == 'edit-is-item' OR $_GET["page"] == 'is-settings'
            OR $_GET["page"] == 'is-coupons' OR $_GET["page"] == 'add-task' OR $_GET["page"] == 'referral-settings'
            OR $_GET["page"] == 'referral-rewards' OR $_GET["page"] == 'menu-links' OR $_GET["page"] == 'partners'
            OR $_GET["page"] == 'footer-box' OR $_GET["page"] == 'panels' OR $_GET["page"] == 'config-main' OR $_GET["page"] == 'config-register'
            OR $_GET["page"] == 'config-other' OR $_GET["page"] == 'ticket-settings' OR $_GET["page"] == 'custom-pages'))
    {
        ?>

        <link rel="stylesheet" href="assets/plugins/icheck/skins/square/blue.css">
        <link rel="stylesheet" href="assets/plugins/switchery/switchery.min.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="assets/plugins/select2/select2.css">
        <link rel="stylesheet" href="assets/plugins/select2/select2-bootstrap.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-slider/css/slider.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-summernote/summernote.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-summernote/summernote-bs3.css">
    <?php
    }
    ?>
    <!-- END CSS PLUGIN -->

    <!-- BEGIN CSS TEMPLATE -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/skins.css">
    <!-- END CSS TEMPLATE -->
</head>
<body class="skin-dark">
	<!-- BEGIN HEADER -->
	<header class="header">
		<!-- BEGIN LOGO -->
		<a href="index.php" class="logo">
			<img src="assets/img/logo.png" alt="<?= $websiteTitle; ?>" height="20">
		</a>
		<!-- END LOGO -->
		<!-- BEGIN NAVBAR -->
		<nav class="navbar navbar-static-top" role="navigation">
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bars fa-lg"></span>
			</a>


			<div class="navbar-right">
				<ul class="nav navbar-nav">
                    <?php
                    if(Admin::hasRight($_SESSION["username"],"b") AND Tasks::count(true) > 0) {
                        ?>
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bookmark fa-lg"></i>
                                <span class="badge"><?= Tasks::count(true) ?></span>
                            </a>
                            <ul class="dropdown-menu box task">
                                <li>
                                    <div class="up-arrow"></div>
                                </li>
                                <li>
                                    <p><?= Language::getTranslation("pendingTasks") ?></p>
                                </li>
                                <?php
                                Tasks::printPending();
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if(Admin::hasRight($_SESSION["username"], "c") AND TicketSystem::pendingTickets() > 0) {
                        ?>
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope fa-lg"></i>
                                <span class="badge"><?= TicketSystem::pendingTickets() ?></span>
                            </a>
                            <ul class="dropdown-menu box inbox">
                                <li>
                                    <div class="up-arrow"></div>
                                </li>
                                <li>
                                    <p><?= Language::getTranslation("pendingTickets") ?></p>
                                </li>
                                <?php
                                TicketSystem::printPendingTickets();
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if(Admin::hasRight($_SESSION["username"], "d") AND Notifications::count() > 0) {
                        ?>
                        <li class="dropdown navbar-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell fa-lg"></i>
                                <span class="badge"><?= Notifications::count() ?></span>
                            </a>
                            <ul class="dropdown-menu box notification">
                                <li>
                                    <div class="up-arrow"></div>
                                </li>
                                <li>
                                    <p><?= Language::getTranslation("newNotifications") ?></p>
                                </li>
                                <?php
                                Notifications::printNotifications();
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
					<li class="dropdown profile-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-cog fa-lg"></i>
							<span class="username"><?= Language::getTranslation("profileMe") ?></span>
							<i class="caret"></i>
						</a>
						<ul class="dropdown-menu box profile">
							<li><div class="up-arrow"></div></li>
							<li class="border-top">
								<a href="<?= Links::getUrl("account") ?>" target="_blank"><i class="fa fa-user"></i><?= Language::getTranslation("accountButton") ?></a>
							</li>
							<li>
								<a href="index.php?page=logout"><i class="fa fa-power-off"></i><?= Language::getTranslation("logoutButton") ?></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<!-- END NAVBAR -->
	</header>
	<!-- END HEADER -->

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- BEGIN SIDEBAR -->
		<aside class="left-side sidebar-offcanvas">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="assets/img/photo.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><?= $_SESSION["username"] ?></p>
						<a><i class="fa fa-circle text-green"></i> Online</a>
					</div>
				</div>
				<form method="get" class="sidebar-form">
                    <input type="hidden" class="hidden" name="page" value="search">
					<div class="input-group">
						<input type="text" name="phrase" class="form-control" placeholder="<?= Language::getTranslation("search") ?>">
						<span class="input-group-btn">
							<button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
                <?php
                Admin::printMenu();
                ?>
			</section>
		</aside>
		<!-- END SIDEBAR -->

		<!-- BEGIN CONTENT -->
		<aside class="right-side">

            <?php
                Admin::router();
            ?>

		</aside>
		<!-- END CONTENT -->

		<!-- BEGIN SCROLL TO TOP -->
		<div class="scroll-to-top"></div>
		<!-- END SCROLL TO TOP -->
	</div>

    <!-- BEGIN JS FRAMEWORK -->
    <script src="assets/plugins/jquery-2.1.0.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- END JS FRAMEWORK -->

    <!-- BEGIN JS PLUGIN -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/jquery-totemticker/jquery.totemticker.min.js"></script>
    <script src="assets/plugins/jquery-resize/jquery.ba-resize.min.js"></script>
    <script src="assets/plugins/jquery-blockui/jquery.blockUI.min.js"></script>
    <?php
    if(isset($_GET["page"]) AND ($_GET["page"] == "add-news" OR $_GET["page"] == "edit-news" OR $_GET["page"] == "news-settings"
        OR $_GET["page"] == "add-download" OR $_GET["page"] == "edit-download" OR $_GET["page"] == 'view-ticket'
             OR $_GET["page"] == 'add-is-item' OR $_GET["page"] == 'edit-is-item' OR $_GET["page"] == 'is-settings'
            OR $_GET["page"] == 'is-coupons' OR $_GET["page"] == 'add-web-admin' OR $_GET["page"] == 'add-task'
        OR $_GET["page"] == 'referral-settings' OR $_GET["page"] == 'referral-rewards' OR $_GET["page"] == 'menu-links'
            OR $_GET["page"] == 'partners' OR $_GET["page"] == 'footer-box' OR $_GET["page"] == 'panels' OR $_GET["page"] == 'config-main'
            OR $_GET["page"] == 'config-register' OR $_GET["page"] == 'config-other' OR $_GET["page"] == 'ticket-settings'
        OR $_GET["page"] == 'custom-pages'))
    {
        ?>
        <script src="assets/plugins/icheck/icheck.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>
        <script src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/plugins/select2/select2.js"></script>
        <script src="assets/plugins/bootstrap-slider/js/bootstrap-slider.js"></script>
        <script src="assets/js/form.js"></script>
        <script src="assets/plugins/bootstrap-summernote/summernote.min.js"></script>
        <script type="text/javascript">
            /* SUMMERNOTE WYSIWYG */
            $('#intro_news').summernote({
                height: 100
            });
            $('#full_news').summernote({
                height: 200
            });
            $('#content').summernote({
                height: 400
            });
        </script>
    <?php
    }

    ?>
    <script>
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
    </script>
    <!-- END JS PLUGIN -->

    <!-- BEGIN JS TEMPLATE -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/skin-selector.js"></script>
    <!-- END JS TEMPLATE -->
</body>


</html>