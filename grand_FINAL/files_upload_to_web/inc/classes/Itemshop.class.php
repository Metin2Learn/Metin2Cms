<?php

class Itemshop
{

    public function numberOfCategories()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_category");
        return $query;
    }

    public function categories()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".itemshop_category");
        return $query;
    }

    public function getFirstCategory()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `id` FROM ".$dbname.".itemshop_category");
        return $query["id"];
    }

    public function itemsPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_items_per_page'");
        return $query["value"];
    }

    public function numberOfItems($cat)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_items WHERE category_id = ?", array($cat));
        return $query;
    }

    public function addCategory($name, $added_by)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".itemshop_category (`name`, `added_by`) VALUES (?, ?)", array($name, $added_by));
    }

    public function categoryNameExists($name)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_category WHERE `name` = ?", array($name));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function numberOfAllItems()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_items");
        return $query;
    }

    public function getCurrency()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_currency'");
        return $query["value"];
    }

    public static function currency()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_currency'");
        return $query["value"];
    }

    public function deleteItem($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".itemshop_items WHERE id = ?", array($id));
    }

    public function categoryExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_category WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getDiscountPercent()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_discount_percent'");
        return intval($query["value"]);
    }

    public function itemExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".itemshop_items WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getItemInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".itemshop_items WHERE id = ?", array($id));
        return $query;
    }

    public function getDiscountUntil()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_discount_until'");
        $old = DateTime::createFromFormat('Y-m-d H:i:s',$query["value"]);
        $new = $old->format('Y/m/d');
        return $new;
    }

    public function validQuantity($id, $quantity)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `max_amount` FROM ".$dbname.".itemshop_items WHERE id = ?", array($id));
        if($quantity <= $query["max_amount"] AND $quantity > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function log($username, $itemName, $vnum, $count, $price)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".log_itemshop
        (user_name, user_ip, item_name, item_id, `count`, price, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)",
            array($username, $_SERVER["REMOTE_ADDR"], $itemName, $vnum, $count, $price, date('Y-m-d H:i:s')));
    }

    public function generateItem($username, $count, $vnum, $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2)
    {
        $dbplayer = Core::getPlayerDatabase();
        //22
        $query = Database::queryAlone("INSERT INTO ".$dbplayer.".item
        (owner_id,window,pos,`count`,vnum,attrtype0, attrvalue0, attrtype1, attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3,
         attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, socket0, socket1, socket2) VALUES
         (?, 'MALL', 2, ?, ?, ?, ?, ?, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ?, ?, ?)",
            array(User::getAccountID($username), $count, $vnum, $attrtype0, $attrvalue0, $attrtype1, $attrvalue1, $socket0, $socket1, $socket2));
    }

    public function discountEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_discount_percent'");
        $query2 = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_discount_until'");
        $percent = $query["value"];
        $until = $query2["value"];
        if($percent != NULL AND intval($percent) > 0 AND $until != NULL AND $until > date('Y-m-d 00:00:00'))
        {
            return true;
        } else {
            return false;
        }
    }

    public function isPremium($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".itemshop_items WHERE id = ?", array($id));
        if($query["can_change_amount"] == 100 AND $query["socket0"] > 0 AND $query["socket1"] > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getCategoryName($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `name` FROM ".$dbname.".itemshop_category WHERE id = ?", array($id));
        return $query["name"];
    }

    public function addItem($name, $vnum, $category, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_change_quantity, $max_quantity)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".itemshop_items
        (`name`, item_id, category_id, description, `count`, price, img, socket0, socket1, socket2, addon_type, time_limit, can_change_amount, max_amount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            array($name, $vnum, $category, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_change_quantity, $max_quantity));
    }

    public function updateItem($name, $vnum, $category, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_change_quantity, $max_quantity, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".itemshop_items SET `name` = ?, item_id = ?, category_id = ?, description = ?, `count` = ?, price = ?, img = ?, socket0 = ?, socket1 = ?, socket2 = ?, addon_type = ?, time_limit = ?, can_change_amount = ?, max_amount = ? WHERE id = ?", array($name, $vnum, $category, $description, $quantity, $price, $img, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_change_quantity, $max_quantity, $id));

    }

    public function deleteCategory($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".itemshop_category WHERE id = ?", array($id));
    }

    public function printAdminCategories($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("addedBy").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["added_by"].'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "a1")) {
                echo '<a href="index.php?page=edit-is-category&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            }
            if(Admin::hasRight($_SESSION["username"], "b1")) {
                echo '<a href="index.php?page=all-is-categories&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function printAdminItems($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("referralRewardPrice").'</th>
                        <th class="text-center">'.Language::getTranslation("category").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["price"].' '.self::getCurrency().'</td>';
            echo '<td class="text-center">'.self::getCategoryName($row["category_id"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "a1")) {
                echo '<a href="index.php?page=edit-is-item&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            }
            if(Admin::hasRight($_SESSION["username"], "b1")) {
                echo '<a href="index.php?page=all-is-items&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function pinExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".paysafecard_pins WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function amazonCodeExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".amazon_codes WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }


    public function pinStatus($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT status FROM ".$dbname.".paysafecard_pins WHERE id = ?", array($id));
        return $query["status"];
    }

    public function amazonCodeStatus($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT status FROM ".$dbname.".amazon_codes WHERE id = ?", array($id));
        return $query["status"];
    }

    public function pinInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".paysafecard_pins WHERE id = ?", array($id));
        return $query;
    }

    public function amazonCodeInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".amazon_codes WHERE id = ?", array($id));
        return $query;
    }

    public function updatePin($id, $status, $coins)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".paysafecard_pins SET status = ?, coins = ? WHERE id = ?",
            array($status, $coins, $id));
    }

    public function updateAmazonCode($id, $status, $coins)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".amazon_codes SET status = ?, coins = ? WHERE id = ?",
            array($status, $coins, $id));
    }

    public function getAllPaypalOptions()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".paypal_options ORDER BY price");
        return $query;
    }

    public function optionExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".paypal_options WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getPaypalOptionInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".paypal_options WHERE id = ?", array($id));
        return $query;
    }

    public function deletePaypalOption($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".paypal_options WHERE id = ?", array($id));
    }

    public function printPins($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("pin").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["account"].'</td>';
            echo '<td class="text-center">'.$row["pin"].'</td>';
            echo '<td class="text-center">'.Language::getTranslation($row["status"]).'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-center">';
            if($row["status"] == "processing") {
                echo '<a href="index.php?page=psc-pins&allow=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmAllowPSC") ?>');"><i
                    class="fa fa-check bg-green action"></i></a>
                <?php

                echo '<a href="index.php?page=psc-pins&deny=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmDenyPSC") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            } elseif($row["status"] == "allowed") {
                echo '<span class="label label-success">+ '.$row["coins"].' '.Language::getTranslation("coins").'</span>';
            } elseif($row["status"] == "denied") {
                echo '<a href="index.php?page=psc-pins&allow=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmAllowPSC") ?>');"><i
                    class="fa fa-check bg-green action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function numberOfPaypalOptions()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".paypal_options");
        return $query;
    }

    public function addPaypalOption($price, $coins)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".paypal_options (price, coins) VALUES (?, ?)", array($price, $coins));
    }

    public function printAmazonCodes($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("amazonCode").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["account"].'</td>';
            echo '<td class="text-center">'.$row["pin"].'</td>';
            echo '<td class="text-center">'.Language::getTranslation($row["status"]).'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-center">';
            if($row["status"] == "processing") {
                echo '<a href="index.php?page=amazon-codes&allow=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmAllowAmazon") ?>');"><i
                    class="fa fa-check bg-green action"></i></a>
                <?php

                echo '<a href="index.php?page=amazon-codes&deny=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmDenyAmazon") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            } elseif($row["status"] == "allowed") {
                echo '<span class="label label-success">+ '.$row["coins"].' '.Language::getTranslation("coins").'</span>';
            } elseif($row["status"] == "denied") {
                echo '<a href="index.php?page=amazon-codes&allow=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("confirmAllowAmazon") ?>');"><i
                    class="fa fa-check bg-green action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function numberOfPins()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".paysafecard_pins");
        return $query;
    }

    public function numberOfAmazonCodes()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".amazon_codes");
        return $query;
    }

    public function printItems($query, $param)
    {
        $query = Database::queryAll($query, $param);
        foreach($query as $row)
        {
            echo '<div class="media">';
                echo '<div class="media-left media-middle">';
            if($row["img"] != '' AND mb_strlen($row["img"]) > 1) {
                echo '<img src="assets/images/itemshop/' . $row["img"] . '" alt="' . $row["name"] . '"
                    style="width:250px; height:200px;border:2px solid grey; border-radius: 10px;">';
            } else {
                echo '<img src="assets/images/itemshop/404.png" alt="' . $row["name"] . '"
                    style="width:250px; height:200px;border:2px solid grey; border-radius: 10px;">';
            }
                echo '</div>';
                echo '<div class="media-body">';
            if(self::discountEnabled())
            {
                $discount_price = ($row["price"] / 100) * (100 - self::getDiscountPercent());
                $discount_price = round($discount_price);
                echo '<h4 class="media-heading"><a>'.$row["name"].'</a> | <span class="label label-default">
                <strike>'.$row["price"].' '.self::getCurrency().'</strike></span>
                <span class="label label-info"> <i class="fa fa-bell-o"></i> '.$discount_price.' '.self::getCurrency().' <i class="fa fa-bell-o"></i></span></h4>';
            } else {
                echo '<h4 class="media-heading"><a>'.$row["name"].'</a> | <span class="label label-info">
                '.$row["price"].' '.self::getCurrency().'</span></h4>';
            }
            echo $row["description"];
                echo '</div>';
                echo '<div class="media-right media-middle">';
            if(User::isLogged())
            {
                $cat = isset($_GET["cat"]) ? $_GET["cat"] : 1;
                if((self::discountEnabled() AND User::getCoins($_SESSION["username"]) >= $discount_price)
                OR (!self::discountEnabled() AND User::getCoins($_SESSION["username"]) >= $row["price"]))
                {
                    echo '<a href="'.Links::getUrl("itemshop").'/cat/'.$cat.'/buy/'.$row["id"].'" class="btn btn-danger">'.Language::getTranslation("isBuy").'</a>';
                } else {
                    echo '<a href="'.Links::getUrl("itemshop").'/buy/'.$row["id"].'" class="btn btn-danger disabled">'.Language::getTranslation("isNotEnoughCoins").'</a>';
                }
            } else {
                echo '<a class="btn btn-danger disabled">'.Language::getTranslation("notLogged").'</a>';
            }
                echo '</div>';
            echo '</div>';
        }
    }

}

?>