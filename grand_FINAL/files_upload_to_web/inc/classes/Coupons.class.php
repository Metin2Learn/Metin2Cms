<?php

class Coupons
{

    public function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".coupons WHERE id = ?", array($id));
    }

    public function add($coup, $value, $message, $admin)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".coupons
        (coupon, `value`, `date`, message, admin, used) VALUES (?, ?, ?, ?, ?, 0)",
            array($coup, $value, date('Y-m-d H:i:s'), $message, $admin));
    }

    public function is_valid($coupon)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".coupons WHERE coupon = ?", array($coupon));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".coupons WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function numberOfCoupons()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".coupons");
        return $query;
    }

    public function is_used($coupon)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".coupons WHERE coupon = ? AND `used` = 1", array($coupon));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function get_result($coupon)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".coupons WHERE coupon = ?", array($coupon));
        $query2 = Database::query("UPDATE ".$dbname.".coupons SET `used` = 1 WHERE coupon = ?", array($coupon));
        if(Core::couponLogEnabled())
        {
            $query3 = Database::query("INSERT INTO ".$dbname.".log_coupons (`user`, `coupon_id`, `ip_address`, `date`)
            VALUES (?,?,?,?)", array($_SESSION["username"], $query["id"], $_SERVER["REMOTE_ADDR"], date('Y-m-d H:i:s')));
        }

        User::addCoins($_SESSION["username"], $query["value"]);
        if(mb_strlen($query["message"]) > 1)
        {
            return Core::result(Language::getTranslation("couponApplied").$query["value"].Language::getTranslation("couponCoins").
                "<br />".$query["message"], 1);
        } else {
            return Core::result(Language::getTranslation("couponApplied").$query["value"].Language::getTranslation("couponCoins"), 1);
        }
    }

    public function printCoupons($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("coupon").'</th>
                        <th class="text-center">'.Language::getTranslation("value").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                        <th class="text-center">'.Language::getTranslation("addedBy").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["coupon"].'</td>';
            echo '<td class="text-center">'.$row["value"].'</td>';
            if($row["used"] == 1)
            {
                echo '<td class="text-center"><span class="label label-success">'.Language::getTranslation("used").'</span></td>';
            } else {
                echo '<td class="text-center"><span class="label label-danger">'.Language::getTranslation("notUsed").'</span></td>';
            }
            echo '<td class="text-center">'.$row["admin"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "d1")) {
                echo '<a href="index.php?page=is-coupons&delete=' . $row["id"] . '" ';
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

}

?>