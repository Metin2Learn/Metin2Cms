<?php
if(Admin::hasRight($_SESSION["username"], "e1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$coupon = new Coupons();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("coupons") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("coupons") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["action"]) AND $_GET["action"] == 'add' AND Admin::hasRight($_SESSION["username"],"d1"))
                    {
                        if(isset($_POST["add_coupon"]))
                        {
                            if(isset($_POST["generate"]))
                            {
                                $generate = 1;
                            } else {
                                $generate = 0;
                            }
                            $coup = $_POST["coupon"];
                            $value = $_POST["value"];
                            if(isset($_POST["message"]) AND mb_strlen($_POST["message"]) > 0 AND $_POST["message"] != '<p><br></p>')
                            {
                                $message = $_POST["message"];
                            } else {
                                $message = '';
                            }

                            if($generate == 1 AND mb_strlen($coup) > 0)
                            {
                                $result = Core::result(Language::getTranslation("couponError1"), 2);
                            } elseif($generate == 0 AND mb_strlen($coup) < 5) {
                                $result = Core::result(Language::getTranslation("couponError2"), 2);
                            } elseif($generate == 0 AND $coupon->is_valid($coup))
                            {
                                $result = Core::result(Language::getTranslation("couponError4"), 2);
                            } elseif(empty($value) OR $value <= 0)
                            {
                                $result = Core::result(Language::getTranslation("couponError3"), 2);
                            } else {
                                if($generate == 1)
                                {
                                    $coup = mb_strtoupper(Core::generateToken(6,false));
                                    while($coupon->is_valid($coup))
                                    {
                                        $coup = mb_strtoupper(Core::generateToken(6,false));
                                    }
                                }
                                $result = Core::result(Language::getTranslation("couponAdded"), 1);
                                $coupon->add($coup, $value, $message, $_SESSION["username"]);
                            }
                        }


                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                    <form method="POST" action="index.php?page=is-coupons&action=add" class="form-horizontal" role="form">
                        <hr />
                        <div class="text-center"><h4><?= Language::getTranslation("youCanGenerateCoupon") ?></h4></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("iWantToAutomaticallyGenerateCoupon") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="generate" class="js-switch" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("iWantToChooseOwnCoupon") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="coupon" class="form-control">
                            </div>
                        </div>

                        <hr />

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("valueCoins") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="value" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("messageCoupon") ?></label>
                            <div class="col-sm-7">
                                <textarea class="form-control" rows="2" id="full_news" name="message"></textarea>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_coupon"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>
                    <?php

                    } else {

                        if(isset($_GET["delete"]) AND $coupon->exists($_GET["delete"]) AND Admin::hasRight($_SESSION["username"], "d1"))
                        {
                            $coupon->delete($_GET["delete"]);
                            $result = Core::result(Language::getTranslation("couponDeleted"), 1);
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        if(Admin::hasRight($_SESSION["username"], "d1"))
                        {
                            echo '<a href="index.php?page=is-coupons&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addNewCoupon").'</button></a>';
                        }

                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = $coupon->numberOfCoupons();
                        $perPage = 10;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=is-coupons", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $coupon->printCoupons("SELECT * FROM " . $dbname . ".coupons ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=is-coupons&pagination=", "pagination");
                        // Print all news and pagination links
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>