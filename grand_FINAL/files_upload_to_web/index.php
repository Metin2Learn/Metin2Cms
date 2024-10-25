<?php
session_start();
require_once("inc/init.php");
// Load basic settings into variables so it wont be loading database queries more times then needed
$websiteTitle = Core::getSiteTitle();
// Load basic settings into variables so it wont be loading database queries more times then needed
?>

<!DOCTYPE html>
<html>

<head>
    <base href="http://localhost/mt2grand-cms/"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $websiteTitle.Core::printTitle();?></title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.transitions.css" rel="stylesheet" type="text/css">
    <link href="assets/css/creative-brands.css" rel="stylesheet" type="text/css">
    <link href="assets/css/jquery.vegas.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<?php
if(!Core::maintenanceEnabled()) {

    ?>
    <header class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?= Links::getUrl("index"); ?>" class="navbar-brand visible-xs"><?= $websiteTitle; ?></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i
                        class="fa fa-bars"></i></button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php
                    Links::makeMenu();
                    ?>
                </ul>
                <div class="pull-right navbar-buttons hidden-xs">
                    <?php
                    if (User::isLogged()) {
                        echo '<a href="' . Links::getUrl("account") . '" class="btn btn-primary">' . Language::getTranslation("accountButton") . '</a>';
                        echo '<a href="' . Links::getUrl("logout") . '" class="btn btn-inverse">' . Language::getTranslation("logoutButton") . '</a>';
                    } else {
                        echo '<a href="' . Links::getUrl("register") . '" class="btn btn-primary">' . Language::getTranslation("register") . '</a>';
                        echo '<a href="' . Links::getUrl("login") . '" class="btn btn-inverse">' . Language::getTranslation("login") . '</a>';
                    }
                    ?>
                    <a class="navbar-icon show2" id="open-search"><i class="fa fa-search"></i></a>
                    <a class="navbar-icon hidden" id="close-search"><i class="fa fa-times"></i></a>

                    <div class="hidden" id="navbar-search-form">
                        <form method="POST" action="<?= Links::getUrl("search"); ?>" role="search">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" value="" name="phrase" id="navbar-search" class="form-control"
                                           placeholder="<?= Language::getTranslation("search"); ?>">
                                    <span class="input-group-btn"><button class="btn btn-primary" type="submit"
                                                                          name="search" id="navbar-search-submit"><i
                                                class="fa fa-search"></i></button></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php
}
?>

<div class="container hidden-xs">
    <div class="header-title">
        <div class="pull-left">
            <h2><a href="<?= Links::getUrl("index");?>"><?= Core::getHeaderTitle(false);?></a></h2>
            <p><?= Core::getHeaderSlogan();?></p>
        </div>
    </div>
</div>

<div class="container">
    <div class="jumbotron">
        <div class="jumbotron-panel">
            <div class="panel panel-primary collapse-horizontal">
                <a data-toggle="collapse" class="btn btn-primary collapsed" data-target="#toggle-collapse">
                    <?= Language::getTranslation("serverStatus");?> <i class="fa fa-caret-down"></i>
                </a>
                <div class="jumbotron-brands">
                    <ul class="brands brands-sm brands-inline brands-circle">
                        <?= Core::getSocialLink("facebook");?>
                        <?= Core::getSocialLink("twitter");?>
                        <?= Core::getSocialLink("youtube");?>
                        <?= Core::getSocialLink("twitch");?>
                    </ul>
                </div>
                <div id="toggle-collapse" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?= Panel::getServerStatusPanel();?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if(!Core::maintenanceEnabled()) {
            $slider = new Slider();
            $slider->makeSlider();
        }
        ?>
    </div>
</div>
<?php
$panels = new Panel();
?>
<div class="container">
    <section class="content-wrapper">


            <?php
            if(Core::maintenanceEnabled())
            {
                echo '<div class="error">';
                echo '<h2>'.Language::getTranslation("maintenanceTitle").'</h2>';
                echo '<p>'.Core::getMaintenanceText().'</p>';
                echo '</div>';
            }
            elseif(isset($_GET["page"]) AND $_GET["page"] == "itemshop")
            {
                if(file_exists("pages/itemshop.php"))
                {
                    require_once("pages/itemshop.php");
                }
            } else
            {
                ?>
            <div class="row">
                <div class="col-sm-4 hidden-xs">
                    <?php
                    $panels->printPanels();
                    ?>
                </div>

                <div class="col-sm-8">

                    <?php
                    $partners = new Partners();
                    $partners->makePanel();
                    ?>

                    <?php
                    $router = new Router();
                    ?>

                </div>
            </div>
            <?php
            }
            ?>

    </section>
</div>

<div class="container">
    <?php
    if(!Core::maintenanceEnabled()) {
        $panels->printFooterBox();
    }
    ?>
    <footer class="navbar navbar-default">
        <div class="row">
            <div class="col-md-6 hidden-xs hidden-sm">
                <p class="copyright2"><?= Core::getFooterText();?></p>
            </div>
            <div class="col-md-6">
                <p class="copyright">MT2Grand CMS by <a href="skype:lol-m4n?add">ondry</a></p>
            </div>
        </div>
    </footer>
</div>

<!-- Scripts are in the end of the file -  so page loads faster -->
<script src="assets/js/jquery-latest.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/creative-brands.js"></script>
<script src="assets/js/jquery.vegas.min.js"></script>
<script src="assets/js/twitterFetcher_min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>
<script src="assets/js/custom.js"></script>
</body>

</html>