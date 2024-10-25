<?php
if(Admin::hasRight($_SESSION["username"], "c1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$is = new Itemshop();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("amazonCodes") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("amazonCodes") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["allow"]) AND $is->amazonCodeExists($_GET["allow"]) AND ($is->amazonCodeStatus($_GET["allow"]) == "processing" OR  $is->amazonCodeStatus($_GET["allow"]) == "denied"))
                    {
                        $info = $is->amazonCodeInfo($_GET["allow"]);
                        if(isset($_POST["add_coins"]))
                        {
                            $coins = $_POST["coins"];
                            if($coins > 0)
                            {
                                User::addCoins($info["account"], $coins);
                                $is->updateAmazonCode($_GET["allow"], "allowed", $coins);
                                echo Core::result(Language::getTranslation("amazonSuccess"), 1);
                            } else {
                                echo Core::result(Language::getTranslation("cannotNegativeCoins"), 2);
                            }
                        }
                        ?>
                        <form method="POST" action="index.php?page=amazon-codes&allow=<?= $_GET["allow"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("PSCHowManyCoins") ?></label>
                                <div class="col-sm-7">
                                    <input type="number" name="coins" class="form-control" required>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary" name="add_coins"><?= Language::getTranslation("submit") ?></button>
                            </div>
                        </form>
                        <hr />
                    <?php
                    } elseif(isset($_GET["deny"]) AND $is->amazonCodeExists($_GET["deny"]) AND $is->amazonCodeStatus($_GET["deny"]) == "processing") {
                        $is->updateAmazonCode($_GET["deny"], "denied", 0);
                        echo Core::result(Language::getTranslation("amazonDenied"), 3);
                    }
                    if(isset($result)) { echo $result; }

                    if($is->numberOfAmazonCodes() > 0) {
                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = $is->numberOfAmazonCodes();
                        $perPage = 10;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=amazon-codes", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $is->printAmazonCodes("SELECT * FROM " . $dbname . ".amazon_codes
                        ORDER BY FIELD(status, 'processing', 'denied', 'allowed'), `date` DESC LIMIT ? OFFSET ?",
                            array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=amazon-codes&pagination=", "pagination");
                        // Print all news and pagination links
                    } else {
                        echo Core::result(Language::getTranslation("zeroAmazonCodes"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>