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
    <span><?= Language::getTranslation("paysafecardPins") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("paysafecardPins") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["allow"]) AND $is->pinExists($_GET["allow"]) AND ($is->pinStatus($_GET["allow"]) == "processing" OR  $is->pinStatus($_GET["allow"]) == "denied"))
                    {
                        $info = $is->pinInfo($_GET["allow"]);
                        if(isset($_POST["add_coins"]))
                        {
                            $coins = $_POST["coins"];
                            if($coins > 0)
                            {
                                User::addCoins($info["account"], $coins);
                                $is->updatePin($_GET["allow"], "allowed", $coins);
                                echo Core::result(Language::getTranslation("PSCSuccess"), 1);
                            } else {
                                echo Core::result(Language::getTranslation("cannotNegativeCoins"), 2);
                            }
                        }
                        ?>
                        <form method="POST" action="index.php?page=psc-pins&allow=<?= $_GET["allow"] ?>" class="form-horizontal" role="form">
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
                    } elseif(isset($_GET["deny"]) AND $is->pinExists($_GET["deny"]) AND $is->pinStatus($_GET["deny"]) == "processing") {
                        $is->updatePin($_GET["deny"], "denied", 0);
                        echo Core::result(Language::getTranslation("PSCDenied"), 3);
                    }
                    if(isset($result)) { echo $result; }

                    if($is->numberOfPins() > 0) {
                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = $is->numberOfPins();
                        $perPage = 10;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=psc-pins", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $is->printPins("SELECT * FROM " . $dbname . ".paysafecard_pins
                        ORDER BY FIELD(status, 'processing', 'denied', 'allowed'), `date` DESC LIMIT ? OFFSET ?",
                            array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=psc-pins&pagination=", "pagination");
                        // Print all news and pagination links
                    } else {
                        echo Core::result(Language::getTranslation("zeroPins"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>