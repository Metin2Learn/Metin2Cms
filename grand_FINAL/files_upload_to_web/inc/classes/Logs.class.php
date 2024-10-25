<?php

class Logs
{
    public static function numberOfGMChat($name)
    {
        $dblog = Core::getLogDatabase();
        if($name != null)
        {
            $query = Database::query("SELECT * FROM ".$dblog.".chat_log WHERE who_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM ".$dblog.".chat_log");
        }
        return $query;
    }

    public static function numberOfGMCommands($name)
    {
        $dblog = Core::getLogDatabase();
        if($name != null)
        {
            $query = Database::query("SELECT * FROM ".$dblog.".command_log WHERE username = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM ".$dblog.".command_log");
        }
        return $query;
    }

    public static function numberOfHacks($name)
    {
        $dblog = Core::getLogDatabase();
        if($name != null)
        {
            $query = Database::query("SELECT * FROM ".$dblog.".hack_log WHERE `name` = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM ".$dblog.".hack_log");
        }
        return $query;
    }

    public static function numberOfShouts()
    {
        $dblog = Core::getLogDatabase();


        $query = Database::query("SELECT * FROM ".$dblog.".shout_log");

        return $query;
    }

    public static function numberOfBans($name)
    {
        global $dbname;
        if($name != null)
        {
            $query = Database::query("SELECT * FROM ".$dbname.".log_bans WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".log_bans");
        }
        return $query;
    }

    public static function numberOfEmailChanges($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_email WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_email");
        }
        return $query;
    }

    public static function numberOfPasswordChanges($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_pw WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_pw");
        }
        return $query;
    }

    public static function numberOfWarehousePasswordChanges($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_warehouse_pw WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_change_warehouse_pw");
        }
        return $query;
    }

    public static function numberOfCoupons($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_coupons WHERE user = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_coupons");
        }
        return $query;
    }

    public static function numberOfItemshop($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_itemshop WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_itemshop");
        }
        return $query;
    }

    public static function numberOfPasswordRecovery($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_password_recovery WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_password_recovery");
        }
        return $query;
    }

    public static function numberOfReferralRewards($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_referral_rewards WHERE user_name = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".log_referral_rewards");
        }
        return $query;
    }

    public static function numberOfPaypalRecords($name)
    {
        global $dbname;
        if($name != null) {
            $query = Database::query("SELECT * FROM " . $dbname . ".paypal_payments WHERE payer_account = ?", array($name));
        } else {
            $query = Database::query("SELECT * FROM " . $dbname . ".paypal_payments");
        }
        return $query;
    }

    public static function GMChat($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("type").'</th>
                        <th class="text-center">'.Language::getTranslation("message").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["who_name"].'</td>';
            echo '<td class="text-center">'.$row["ip"].'</td>';
            echo '<td class="text-center">'.$row["type"].'</td>';
            echo '<td class="text-center">'.$row["msg"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["when"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function GMCommands($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("command").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["username"].'</td>';
            echo '<td class="text-center">'.$row["ip"].'</td>';
            echo '<td class="text-center">'.$row["command"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function Hacks($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("type").'</th>
                        <th class="text-center">'.Language::getTranslation("server").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["ip"].'</td>';
            echo '<td class="text-center">'.$row["why"].'</td>';
            echo '<td class="text-center">'.$row["server"].'</td>';
            echo '<td class="text-center">'.$row["time"].'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function Shouts($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("message").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["4"].'</td>';
            echo '<td class="text-center">'.$row["1"].'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function emailChanges($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("oldEmail").'</th>
                        <th class="text-center">'.Language::getTranslation("newEmail").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["old_email"].'</td>';
            echo '<td class="text-center">'.$row["new_email"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function itemshop($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("itemName").'</th>
                        <th class="text-center">'.Language::getTranslation("itemID").'</th>
                        <th class="text-center">'.Language::getTranslation("quantity").'</th>
                        <th class="text-center">'.Language::getTranslation("price").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["item_name"].'</td>';
            echo '<td class="text-center">'.$row["item_id"].'</td>';
            echo '<td class="text-center">'.$row["count"].'</td>';
            echo '<td class="text-center">'.$row["price"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function coupons($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("couponID").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user"].'</td>';
            echo '<td class="text-center">'.$row["ip_address"].'</td>';
            echo '<td class="text-center">'.$row["coupon_id"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function referralRewards($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("itemName").'</th>
                        <th class="text-center">'.Language::getTranslation("itemID").'</th>
                        <th class="text-center">'.Language::getTranslation("quantity").'</th>
                        <th class="text-center">'.Language::getTranslation("price").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["item_name"].'</td>';
            echo '<td class="text-center">'.$row["item_vnum"].'</td>';
            echo '<td class="text-center">'.$row["count"].'</td>';
            echo '<td class="text-center">'.$row["price"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function passwordRecovery($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("oldPw").'</th>
                        <th class="text-center">'.Language::getTranslation("newPw").'</th>
                        <th class="text-center">'.Language::getTranslation("token").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["old_pw"].'</td>';
            echo '<td class="text-center">'.$row["new_pw"].'</td>';
            echo '<td class="text-center">'.$row["used_token"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function warehouseChanges($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("oldPw").'</th>
                        <th class="text-center">'.Language::getTranslation("newPw").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["old_pw"].'</td>';
            echo '<td class="text-center">'.$row["new_pw"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function passwordChanges($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("username").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("oldPw").'</th>
                        <th class="text-center">'.Language::getTranslation("newPw").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            echo '<td class="text-center">'.$row["user_ip"].'</td>';
            echo '<td class="text-center">'.$row["old_pw"].'</td>';
            echo '<td class="text-center">'.$row["new_pw"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function paypalPayments($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("account").'</th>
                        <th class="text-center">'.Language::getTranslation("email").'</th>
                        <th class="text-center">'.Language::getTranslation("payed").'</th>
                        <th class="text-center">'.Language::getTranslation("currency").'</th>
                        <th class="text-center">'.Language::getTranslation("paypalName").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["payer_account"].'</td>';
            echo '<td class="text-center">'.$row["payer_email"].'</td>';
            echo '<td class="text-center">'.$row["payment_amount"].'</td>';
            echo '<td class="text-center">'.$row["payment_currency"].'</td>';
            echo '<td class="text-center">'.$row["itemname"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["createdtime"]).'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }


    public static function printBans($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("type").'</th>
                        <th class="text-center">'.Language::getTranslation("reason").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("banExpire").'</th>
                        <th class="text-center">'.Language::getTranslation("admin").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["user_name"].'</td>';
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center"><span class="label label-success">'.Language::getTranslation("unban").'</span></td>';
            } else {
                echo '<td class="text-center"><span class="label label-danger">'.Language::getTranslation("ban").'</span></td>';
            }
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center">-</td>';
            } else {
                echo '<td class="text-center">'.$row["reason"].'</td>';
            }
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            if($row["ban_until"] == NULL)
            {
                echo '<td class="text-center">-</td>';
            } else {
                echo '<td class="text-center">'.Core::makeNiceDate($row["ban_until"]).'</td>';
            }
            echo '<td class="text-center">'.$row["admin"].'</td>';

            echo '</tr>';
        }
        echo '</tbody></table>';
    }

}

?>