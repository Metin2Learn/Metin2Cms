<?php
$is = new Itemshop();
if(isset($_GET["cat"]) AND $is->categoryExists($_GET["cat"]) == false)
{
    Core::redirect(Links::getUrl("itemshop"), 0);
    die();
}
$cat = isset($_GET["cat"]) ? $_GET["cat"] : $is->getFirstCategory();
?>

<?php

if(isset($_GET["buy"]) AND $is->itemExists($_GET["buy"]) AND User::isLogged())
{
    //echo '<div class="box">';
    $itemInfo = $is->getItemInfo($_GET["buy"]);
    if($is->discountEnabled())
    {
        $discount_price = ($itemInfo["price"] / 100) * (100 - $is->getDiscountPercent());
        $price = round($discount_price);
    } else {
        $price = $itemInfo["price"];
    }

    if($is->isPremium($itemInfo["id"]))
    {

        $type = $itemInfo["socket1"]; // 1 = silver_expire ; 2 = gold_expire ; 3 = money_drop_rate_expire
        $days = $itemInfo["socket0"]; // how long premium ? (in days)
        if (User::getCoins($_SESSION["username"]) < $price) {
            echo Core::result(Language::getTranslation("isNotEnoughCoins"), 2);
        } elseif($type == 1 AND User::getSilverPremium($_SESSION["username"], true) > date('Y-m-d H:i:s')) {
            echo Core::result(Language::getTranslation("isSilverActive").Core::makeNiceDate(User::getSilverPremium($_SESSION["username"], true)), 2);
        } elseif($type == 2 AND User::getGoldPremium($_SESSION["username"], true) > date('Y-m-d H:i:s')) {
            echo Core::result(Language::getTranslation("isGoldActive").Core::makeNiceDate(User::getGoldPremium($_SESSION["username"], true)), 2);
        } elseif($type == 3 AND User::getYangPremium($_SESSION["username"], true) > date('Y-m-d H:i:s')) {
            echo Core::result(Language::getTranslation("isYangActive").Core::makeNiceDate(User::getYangPremium($_SESSION["username"], true)), 2);
        } elseif($type == 123 AND (
            User::getYangPremium($_SESSION["username"], true) > date('Y-m-d H:i:s') OR
            User::getSilverPremium($_SESSION["username"], true) > date('Y-m-d H:i:s') OR
            User::getGoldPremium($_SESSION["username"], true) > date('Y-m-d H:i:s')
            ))
        {
            echo Core::result(Language::getTranslation("isActive"), 2);
        } else {
            if($type == 1) {
                $is->log($_SESSION["username"], $itemInfo["name"], $type, $days, $price);
                User::updateSilverPremium($_SESSION["username"], $days);
                User::removeCoins($_SESSION["username"], $price);
                echo Core::result(Language::getTranslation("isSilverSuccess"), 1);
            } elseif($type == 2) {
                $is->log($_SESSION["username"], $itemInfo["name"], $type, $days, $price);
                User::updateGoldPremium($_SESSION["username"], $days);
                User::removeCoins($_SESSION["username"], $price);
                echo Core::result(Language::getTranslation("isGoldSuccess"), 1);
            } elseif($type == 3) {
                $is->log($_SESSION["username"], $itemInfo["name"], $type, $days, $price);
                User::updateYangPremium($_SESSION["username"], $days);
                User::removeCoins($_SESSION["username"], $price);
                echo Core::result(Language::getTranslation("isYangSuccess"), 1);
            } elseif($type == 123) {
                $is->log($_SESSION["username"], $itemInfo["name"], $type, $days, $price);
                User::updateSilverPremium($_SESSION["username"], $days);
                User::updateGoldPremium($_SESSION["username"], $days);
                User::updateYangPremium($_SESSION["username"], $days);
                User::removeCoins($_SESSION["username"], $price);
                echo Core::result(Language::getTranslation("isPremiumSuccess"), 1);
            }
        }


    } else {

        if (User::getCoins($_SESSION["username"]) < $price) {
            echo Core::result(Language::getTranslation("isNotEnoughCoins"), 2);
        } elseif (User::hasEmptyItemShopMall($_SESSION["username"]) == false) {
            echo Core::result(Language::getTranslation("isNotEmptyItemshopMall"), 2);
        } else {
            if ($itemInfo["can_change_amount"] == 1 AND $itemInfo["max_amount"] > 0) {
                if (isset($_POST["buy"])) {
                    $quantity = $_POST["quantity"];
                    if (!ctype_digit($quantity)) {
                        $result = Core::result(Language::getTranslation("isNotValidQuantity"), 2);
                    } elseif (!$is->validQuantity($_GET["buy"], $quantity)) {
                        $result = Core::result(Language::getTranslation("isNotValidRange") . $itemInfo["max_amount"], 2);
                    } elseif (User::getCoins($_SESSION["username"]) < $price * $quantity) {
                        $result = Core::result(Language::getTranslation("isNotEnoughCoins"), 2);
                    } else {

                        if ($itemInfo['addon_type'] == 0) {
                            $attrtype0 = 0;
                            $attrtype1 = 0;
                            $attrvalue0 = 0;
                            $attrvalue1 = 0;
                        } else {
                            $attrtype0 = 72;
                            $attrtype1 = 71;
                            $skoda = mt_rand(8, 30);
                            $poskozeni = mt_rand(-18, -1);
                            $attrvalue0 = $skoda;
                            $attrvalue1 = $poskozeni;
                        }

                        if ($itemInfo["time_limit"] > 0) {
                            $socket0 = strtotime("+ " . $itemInfo['time_limit'] . " seconds");
                        } else {
                            $socket0 = $itemInfo["socket0"];
                        }
                        $socket1 = $itemInfo["socket1"];
                        $socket2 = $itemInfo["socket2"];

                        User::removeCoins($_SESSION["username"], $price * $quantity);

                        $is->generateItem($_SESSION["username"], $quantity, $itemInfo["item_id"],
                            $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2);
                        if (Core::itemshopLogEnabled()) {
                            $is->log($_SESSION["username"], $itemInfo["name"], $itemInfo["item_id"], $quantity, $price * $quantity);
                        }


                        $result = Core::result(Language::getTranslation("isBuySuccess"), 1);
                        Core::redirect(Links::getUrl("itemshop"), 2);
                    }
                }

                if (isset($result)) {
                    echo $result;
                }
                ?>
                <div class="box">
                    <h2><?= Language::getTranslation("isVerifyAmount") ?></h2>

                    <form method="post" action="<?= Links::getUrl("itemshop") . "/cat/".$cat."/buy/" . $_GET['buy'] ?>">
                        <div class="form-group">
                            <input type="number" name="quantity" class="form-control" id="quantity" required>
                        </div>
                        <button type="submit" name="buy"
                                class="btn btn-primary login-btn"><?= Language::getTranslation("isSubmit"); ?></button>
                    </form>
                </div>
            <?php
            } else {

                if ($itemInfo['addon_type'] == 0) {
                    $attrtype0 = 0;
                    $attrtype1 = 0;
                    $attrvalue0 = 0;
                    $attrvalue1 = 0;
                } else {
                    $attrtype0 = 72;
                    $attrtype1 = 71;
                    $skoda = mt_rand(8, 30);
                    $poskozeni = mt_rand(-18, -1);
                    $attrvalue0 = $skoda;
                    $attrvalue1 = $poskozeni;
                }

                if ($itemInfo["time_limit"] > 0) {
                    $socket0 = strtotime("+ " . $itemInfo['time_limit'] . " seconds");
                } else {
                    $socket0 = $itemInfo["socket0"];
                }
                $socket1 = $itemInfo["socket1"];
                $socket2 = $itemInfo["socket2"];

                User::removeCoins($_SESSION["username"], $price);

                $is->generateItem($_SESSION["username"], $itemInfo["count"], $itemInfo["item_id"],
                    $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2);
                if (Core::itemshopLogEnabled()) {
                    $is->log($_SESSION["username"], $itemInfo["name"], $itemInfo["item_id"], $itemInfo["count"], $price);
                }
                echo Core::result(Language::getTranslation("isBuySuccess"), 1);
                Core::redirect(Links::getUrl("itemshop"), 2);

            }
        }
    }

}

?>

<div class="box tournament-detail">
    <div class="row">

        <div class="col-xs-9">
            <h2><?= Language::getTranslation("isTitle");?></h2>
                <div style="margin-top:50px;">
                    <?php
                    if($is->numberOfCategories() > 0) {
                        foreach ($is->categories() as $row) {
                            if(isset($cat) AND $cat == $row["id"])
                            {
                                echo ' <a href="' . Links::getUrl("itemshop") . '/cat/' . $row["id"] . '"
                        class="btn btn-primary btn-lg" style="margin-bottom:5px;">' . $row["name"] . '</a>';
                            } else {
                                echo ' <a href="' . Links::getUrl("itemshop") . '/cat/' . $row["id"] . '"
                        class="btn btn-inverse btn-lg" style="margin-bottom:5px;">' . $row["name"] . '</a>';
                            }
                        }
                    } else {
                        echo Core::result(Language::getTranslation("isZeroCategories"),4);
                    }
                    ?>
                    <br /><br />
                    <?php
                    if(User::isLogged()) {
                        echo '<li class="list-group-item">' . Language::getTranslation("isYourCoins") . '
                    <span class="text-primary">' . User::getCoins($_SESSION["username"]) . '</span> ' . Language::getTranslation("isBuyCoins") . '</li>';
                    }
                    ?>
                </div>

        </div>

        <div class="col-xs-3">
            <img src="assets/images/shop.png" class="img-responsive center-block" alt="">
        </div>
    </div>
    <?php
    if($is->discountEnabled()) {
        ?>
        <p class="countdown-info"><i class="fa fa-bell-o"></i>
            Discount <span class="label label-danger"><?= $is->getDiscountPercent() ?> %</span> on all items: <i class="fa fa-bell-o"></i>
        </p>
        <div id="discountdate" class="hidden"><?= $is->getDiscountUntil() ?></div>
        <div class="countdown"></div>
    <?php
    }
    ?>
</div>



<div class="box">

    <?php
    if($is->numberOfItems($cat) > 0)
    {

        // Paginator
        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
        $totalCount = $is->numberOfItems($cat);
        $perPage = $is->itemsPerPage();
        $paginator = new Paginator($page, $totalCount, $perPage);
        // Paginator

        // Validate page
        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
            Core::redirect(Links::getUrl("itemshop"), 0);
            die();
        }
        // Validate page


        // Print all news and pagination links
        global $dbname;
        $is->printItems("SELECT * FROM " . $dbname . ".itemshop_items WHERE category_id = ? LIMIT ? OFFSET ?", array($cat, $perPage, $paginator->offset()));
        $paginator->printLinks("itemshop/cat/".$cat."/page/", "pagination");
        // Print all news and pagination links

    } else {
        echo Core::result(Language::getTranslation("isZeroItems"), 4);
    }
    ?>



</div>
