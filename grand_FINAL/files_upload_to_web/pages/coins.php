<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if (Core::isCaptchaEnabled()) {
        $securimage = new Securimage();
    }
    //Paypal - START
    if(Core::paypalEnabled())
    {
        if(isset($_POST["pay_paypal"]))
        {
            $is = new Itemshop();
            $option_info = $is->getPaypalOptionInfo($_POST["type"]);
            $coins = $option_info["coins"];
            $price = $option_info["price"];
            $return_url = Links::getUrl('account coins');
            $cancel_url = Links::getUrl('account coins');
            $notify_url = Links::getUrl('paypal_script');

            $item_name = $coins.' coins - Account: '.$_SESSION["username"];
            $item_amount = $price;
            $querystring = '';

            // Firstly Append paypal account to querystring
            $querystring .= "?business=".urlencode(Core::getPaypalEmail())."&";

            // Append amount& currency (£) to quersytring so it cannot be edited in html

            //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
            $querystring .= "item_name=".urlencode($item_name)."&";
            $querystring .= "amount=".urlencode($item_amount)."&";

            //loop for posted values and append to querystring
            foreach($_POST as $key => $value){
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }

            // Append paypal return addresses
            $querystring .= "return=".urlencode(stripslashes($return_url))."&";
            $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
            $querystring .= "notify_url=".urlencode($notify_url);

            // Append querystring with custom field
            $querystring .= "&custom=".$_SESSION["username"];

            // Redirect to paypal IPN
            Core::redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring, 0);
            exit();
        }
        echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - ' . Language::getTranslation("paypal") . '</h2>';
        ?>
        <form method="post" action="<?= Links::getUrl("account coins"); ?>" target="_blank">
            <div class="form-group">
                <label for="type"><?= Language::getTranslation("choosePlease"); ?></label>
                <select class="form-control" id="type" name="type">
                    <?php
                    $is = new Itemshop();
                    $options = $is->getAllPaypalOptions();
                    foreach($options as $row3)
                    {
                        echo '<option value="'.$row3["id"].'">'.$row3["coins"].' '.Language::getTranslation("coins").' - '
                        .$row3["price"].' '.Core::getPaypalCurrency().'</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="no_shipping" value="1" />
                <input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="rm" value="2" />
                <input type="hidden" name="currency_code" value="<?= Core::getPaypalCurrency() ?>" />
            </div>

            <button type="submit" name="pay_paypal" class="btn btn-primary"><?= Language::getTranslation("payWithPaypal"); ?></button>

        </form>
        <?php
        echo '</div>';
    }
    //Paypal - END


    //Paysafecard
    if(Core::paysafecardEnabled()) {
        if(isset($_GET["delete"]) AND ctype_digit($_GET["delete"]) AND User::hasPropertyToDeletePin($_SESSION["username"], $_GET["delete"]))
        {
            User::deletePin($_GET["delete"]);
            $result2 = Core::result(Language::getTranslation("pinDeleted"), 3);
        }
        if(isset($_POST["add_psc"]))
        {
            $pin = isset($_POST["psc"]) ? $_POST["psc"] : null;
            if(Core::isCaptchaEnabled())
            {
                $captcha = isset($_POST["captcha"]) ? $_POST["captcha"] : null;
            }
            if(!ctype_digit($pin) OR mb_strlen($pin) != 16)
            {
                $result2 = Core::result(Language::getTranslation("psc_pin_error"), 2);
            } elseif(User::numberOfPaysafecardPins($_SESSION["username"], "processing") > 0)
            {
                $result2 = Core::result(Language::getTranslation("processingPscPinExists"), 2);
            } elseif(Core::isCaptchaEnabled() AND $securimage->check($captcha) == false)
            {
                $result2 = Core::result(Language::getTranslation("captchaWong"), 2);
            } else {
                User::add_psc_pin($_SESSION["username"], $pin, "processing", 0);
                $result2 = Core::result(Language::getTranslation("pscSubmitted"), 1);
            }
        }
        if(isset($result2)) { echo $result2; }
        echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - ' . Language::getTranslation("paysafecard") . '</h2>';
        //!!! Your payment method HERE !!!
        ?>
        <form method="post" action="<?= Links::getUrl("account coins"); ?>">
            <div class="form-group">
                <label for="psc_pin"><?= Language::getTranslation("psc_pin"); ?></label>
                <input type="number" name="psc" class="form-control" placeholder="xxxxxxxxxxxxxxxx" id="psc_pin" required>
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
            <button type="submit" name="add_psc" class="btn btn-primary"><?= Language::getTranslation("submit_psc"); ?></button>
        </form>
        <?php
        if(User::numberOfPaysafecardPins($_SESSION["username"], "all") > 0)
        {
            echo '<hr /><h2>'.Language::getTranslation("last5Pins").'</h2>';
            echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("pin").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                    </tr>
                    </thead>
                    <tbody>';
            $info = User::getLast5Pins($_SESSION["username"]);
            foreach($info as $row)
            {
                echo '<tr>';
                echo '<td class="text-center">'.$row["pin"].'</td>';
                echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
                if($row["status"] == "processing")
                {
                    echo '<td class="text-center"><span class="text-warning">'.Language::getTranslation($row["status"]).'</span>
                    <a href="'.Links::getUrl("coins delete").$row["id"].'">'.Language::getTranslation("delete").'</a></td>';
                } elseif($row["status"] == "denied")
                {
                    echo '<td class="text-center"><span class="text-danger">'.Language::getTranslation($row["status"]).'</span></td>';
                } elseif($row["status"] == "allowed")
                {
                    echo '<td class="text-center"><span class="text-success">'.Language::getTranslation($row["status"]).'</span>
                    <span class="label label-success">+ '.$row["coins"].' '.Language::getTranslation("coins").'</span></td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        echo '</div>';

    }
    //Paysafecard - END

    //Amazazon - START
    if(Core::amazonEnabled()) {
        if(isset($_GET["delete_amazon"]) AND User::hasPropertyToDeleteAmazonCode($_SESSION["username"], $_GET["delete_amazon"]))
        {
            User::deleteAmazonCode($_GET["delete_amazon"]);
            $result3 = Core::result(Language::getTranslation("amazonCodeDeleted"), 3);
        }
        if(isset($_POST["add_amazon"]))
        {
            $amazon_code = isset($_POST["amazon_code"]) ? htmlspecialchars($_POST["amazon_code"]) : null;
            if(Core::isCaptchaEnabled())
            {
                $captcha = isset($_POST["captcha"]) ? $_POST["captcha"] : null;
            }
            if(User::numberOfAmazonCodes($_SESSION["username"], "processing") > 0)
            {
                $result3 = Core::result(Language::getTranslation("processingAmazonCodeExists"), 2);
            } elseif(Core::isCaptchaEnabled() AND $securimage->check($captcha) == false)
            {
                $result3 = Core::result(Language::getTranslation("captchaWong"), 2);
            } else {
                User::add_amazon_code($_SESSION["username"], $amazon_code, "processing", 0);
                $result3 = Core::result(Language::getTranslation("amazonCodeSubmitted"), 1);
            }
        }
        if(isset($result3)) { echo $result3; }
        echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") . '</a> - ' . Language::getTranslation("amazonCode") . '</h2>';
        ?>
        <form method="post" action="<?= Links::getUrl("account coins"); ?>">
            <div class="form-group">
                <label for="amazon_code"><?= Language::getTranslation("amazonCode"); ?></label>
                <input type="text" name="amazon_code" class="form-control" id="amazon_code" required>
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
            <button type="submit" name="add_amazon" class="btn btn-primary"><?= Language::getTranslation("submitAmazonCode"); ?></button>
        </form>
        <?php
        if(User::numberOfAmazonCodes($_SESSION["username"], "all") > 0)
        {
            echo '<hr /><h2>'.Language::getTranslation("last5AmazonCodes").'</h2>';
            echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("amazonCode").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                    </tr>
                    </thead>
                    <tbody>';
            $info = User::getLast5AmazonCodes($_SESSION["username"]);
            foreach($info as $row)
            {
                echo '<tr>';
                echo '<td class="text-center">'.$row["pin"].'</td>';
                echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
                if($row["status"] == "processing")
                {
                    echo '<td class="text-center"><span class="text-warning">'.Language::getTranslation($row["status"]).'</span>
                    <a href="'.Links::getUrl("coins delete amazon").$row["id"].'">'.Language::getTranslation("delete").'</a></td>';
                } elseif($row["status"] == "denied")
                {
                    echo '<td class="text-center"><span class="text-danger">'.Language::getTranslation($row["status"]).'</span></td>';
                } elseif($row["status"] == "allowed")
                {
                    echo '<td class="text-center"><span class="text-success">'.Language::getTranslation($row["status"]).'</span>
                    <span class="label label-success">+ '.$row["coins"].' '.Language::getTranslation("coins").'</span></td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        echo '</div>';

    }
    //Amazon - END

    if(Core::couponSystemEnabled())
    {
        $coupons = new Coupons();
        if(isset($_POST["apply_coupon"]))
        {
            $coupon = $_POST["coupon"];
            if(!$coupons->is_valid($coupon))
            {
                $result = Core::result(Language::getTranslation("couponNotValid"), 2);
            } elseif($coupons->is_used($coupon))
            {
                $result = Core::result(Language::getTranslation("couponAlreadyUsed"), 2);
            } elseif(Core::isCaptchaEnabled() AND $securimage->check($_POST["captcha"]) == false)
            {
                $result = Core::result(Language::getTranslation("captchaWong"), 2);
            } else {
                $result = $coupons->get_result($coupon);

                //Success
            }
        }
        echo '<div class="box">';
        echo '<h2><a href="'.Links::getUrl("account").'">'.Language::getTranslation("accountTitle").'</a> - '.Language::getTranslation("couponsTitle").'</h2>';
        if (isset($result)) {
            echo $result;
        }
        echo '<p>'.Language::getTranslation("couponDesc").'</p>';
        ?>
        <form method="post" action="<?= Links::getUrl("account coins"); ?>">
        <div class="form-group">
            <label for="coupon_code"><?= Language::getTranslation("couponCode"); ?></label>
            <input type="text" name="coupon" class="form-control" id="coupon_code" required>
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
        <button type="submit" name="apply_coupon" class="btn btn-primary"><?= Language::getTranslation("applyCoupon"); ?></button>
        </form>
    <?php
        echo '</div>';
    }
}

?>