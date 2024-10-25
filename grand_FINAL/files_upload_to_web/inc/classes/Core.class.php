<?php

class Core
{

    public static function redirect($destination, $duration = 0)
    {
        echo '<meta http-equiv="refresh" content="'.$duration.'; url='.$destination.'">';
    }

    public static function getSiteTitle()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'site_title'");
        return $query["value"];
    }

    public static function getAccountDatabase()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'account_table'");
        return $query["value"];
    }

    public static function getLogDatabase()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'log_db'");
        return $query["value"];
    }

    public static function getCommonDatabase()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'common_table'");
        return $query["value"];
    }

    public static function itemshopLogEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'itemshop_log'");
        if ($query["value"] == 1)
        {
            return true;
        } else {
            return false;
        }
    }


    public static function changePasswordMailVerification()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_pw_mail_verification'");
        return $query["value"] == 1 ? true : false;
    }

    public static function ticketSystemEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'ticket_system_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function timeAgo($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    public static function getPlayerDatabase()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'player_table'");
        return $query["value"];
    }

    public static function getCoinsColumn()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'coins_column'");
        return $query["value"];
    }

    public static function printTitle()
    {
        if(isset($_GET["page"]))
        {
            global $dbname;
            $query = Database::queryAlone("SELECT * FROM ".$dbname.".links WHERE `title` LIKE '%".$_GET['page']."%' LIMIT 1");
            if($query["head_title"] != NULL OR $query["head_title"] != '')
            {
                return ' - '.$query["head_title"];
            }
        }
    }


    public static function makeNiceDate($date)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'date_format'");
        $format = $query["value"];

        $ugly = DateTime::createFromFormat("Y-m-d H:i:s", $date);
        $niceDate = $ugly->format($format);
        return $niceDate;
    }

    public static function isValidDate($str)
    {
        $array = explode('/', $str);
        if(isset($array[0]) AND isset($array[1]) AND isset($array[2]))
        {
            $year = $array[0];
            $month = $array[1];
            $day = $array[2];

            $isDateValid = checkdate($month, $day, $year);
            return $isDateValid;
        } else {
            return false;
        }
    }

    public static function makeShortDate($date)
    {
        $ugly = DateTime::createFromFormat("Y-m-d H:i:s", $date);
        return $ugly->format('d.m. Y');
    }

    public static function getFailedLoginAttempts()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'login_captcha_attempts'");
        return $query["value"];
    }

    public static function getDateFormat()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'date_format'");
        return $query["value"];
    }

    public static function getHeaderTitle($themeLook = false)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM " . $dbname . ".web_settings WHERE `option` = 'header_title'");
        if($themeLook == false) {
            return $query["value"];
        } else {
            if(mb_strlen($query["value"]) > 5) {
                $name = "";
                $name .= '<span class="text-primary">' . mb_substr($query["value"], 0, 3) . '</span>';
                $name .= mb_substr($query["value"], 3);
                return $name;
            } else {
                $name = "";
                $name .= '<span class="text-primary">' . mb_substr($query["value"], 0, 1) . '</span>';
                $name .= mb_substr($query["value"], 1);
                return $name;
            }
        }
    }

    public static function getHeaderSlogan()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'header_slogan'");
        return $query["value"];
    }

    public static function getSocialLink($company, $plain = false)
    {
        global $dbname;
        $option = $company.'_link';
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = ?", array($option));
        if($plain == true)
        {
            return $query["value"];
        } else {
            if($query["value"] != NULL) {
                $html = '<li><a href="'.$query["value"].'"><i class="fa fa-'.$company.'"></i></a></li>';
                return $html;
            }
        }
    }

    public static function usingSMTP()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'mail_type'");
        return $query["value"] == "smtp" ? true : false;
    }

    public static function getSMTPProtocol()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'smtp_secure'");
        return $query["value"];
    }

    public static function getSMTPHost()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'smtp_host'");
        return $query["value"];
    }

    public static function getSMTPPort()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'smtp_port'");
        return $query["value"];
    }

    public static function getSMTPUser()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'smtp_user'");
        return $query["value"];
    }

    public static function getSMTPPassword()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'smtp_password'");
        return $query["value"];
    }

    public static function getMailFrom()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'mail_from'");
        return $query["value"];
    }

    public static function getMailFromName()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'mail_from_name'");
        return $query["value"];
    }

    public static function checkStatus($ip, $port)
    {
        $ip = gethostbyname($ip);
        $connection = @fsockopen($ip, $port, $errno, $errstr, 1);
        if(is_resource($connection))
        {
            fclose($connection);
            return true;
        } else {
            return false;
        }
    }


    public static function isPartnerPanelEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'partners_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function newsCommentsOnlyLoggedUsers()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'news_comments_login_only'");
        return $query["value"] == 1 ? true : false;
    }

    public static function numberOfAccounts()
    {
        $dbaccount = Core::getAccountDatabase();
        $query = Database::query("SELECT * FROM ".$dbaccount.".account");
        return $query;
    }

    public static function numberOfGuilds()
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbplayer.".guild");
        return $query;
    }

    public static function numberOfPlayers()
    {
        $dbplayer = Core::getPlayerDatabase();
        $query = Database::query("SELECT * FROM ".$dbplayer.".player");
        return $query;
    }

    public static function getMaintenanceText()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM " . $dbname . ".web_settings WHERE `option` = 'maintenance_text'");
        return $query["value"];
    }

    public static function getBaseURL()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM " . $dbname . ".web_settings WHERE `option` = 'base_url'");
        return $query["value"];
    }

    public static function couponLogEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'coupon_log'");
        return $query["value"] == 1 ? true : false;
    }

    public static function footerRecentPostsEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'footer_recent_posts'");
        return $query["value"] == 1 ? true : false;
    }

    public static function maintenanceEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'maintenance'");
        return $query["value"] == 1 ? true : false;
    }

    public static function partnersEnable()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'partners_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function footerBoxEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'footerbox_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function registerEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'register_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function passwordRecoveryLogEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'password_recovery_log'");
        return $query["value"] == 1 ? true : false;
    }

    public static function updateSettings($option, $value)
    {
        global $dbname;
        $query = Database::query("UPDATE ".$dbname.".web_settings SET `value` = ? WHERE `option` = ?",
            array($value, $option));
    }

    public static function generateToken($length, $md5 = true)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $random_hash = '';

        for($i = 0; $i < $length; $i++)
        {
            $random_hash .= $characters[rand(0, $charactersLength - 1)];
        }
        if($md5 == true) {
            return md5($random_hash);
        } else {
            return $random_hash;
        }
    }


    public static function couponSystemEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'coupon_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function getPaypalEmail()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'paypal_email'");
        return $query["value"];
    }

    public static function getPaypalCurrency()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'paypal_currency'");
        return $query["value"];
    }

    public static function referralSystemEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'referral_system'");
        return $query["value"] == 1 ? true : false;
    }

    public static function debugDisconnectWaitTime()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_disconnect_wait'");
        return $query["value"];
    }

    public static function debugShinsoMap()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_map'");
        return $query["value"];
    }

    public static function debugChunjoMap()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_map'");
        return $query["value"];
    }

    public static function debugJinnoMap()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_map'");
        return $query["value"];
    }

    public static function makeToken($what)
    {
        base64_decode($what);
    }

    public static function debugShinsoX()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_x'");
        return $query["value"];
    }

    public static function debugChunjoX()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_x'");
        return $query["value"];
    }

    public static function debugJinnoX()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_x'");
        return $query["value"];
    }

    public static function checkToken($what)
    {
        base64_decode($what);
    }

    public static function debugShinsoY()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_y'");
        return $query["value"];
    }

    public static function debugChunjoY()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_y'");
        return $query["value"];
    }

    public static function debugJinnoY()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_y'");
        return $query["value"];
    }

    public static function debugShinso()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_map'");
        $map = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_x'");
        $x = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_shinso_y'");
        $y = $query["value"];
        return array($map,$x,$y);
    }

    public static function debugChunjo()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_map'");
        $map = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_x'");
        $x = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_chunjo_y'");
        $y = $query["value"];
        return array($map,$x,$y);
    }

    public static function debugJinno()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_map'");
        $map = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_x'");
        $x = $query["value"];
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'debug_jinno_y'");
        $y = $query["value"];
        return array($map,$x,$y);
    }

    public static function showDeleteCodeEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'show_delete_code'");
        return $query["value"] == 1 ? true : false;
    }

    public static function paysafecardEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'enable_paysafecard'");
        return $query["value"] == 1 ? true : false;
    }

    public static function amazonEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'enable_amazon'");
        return $query["value"] == 1 ? true : false;
    }

    public static function paypalEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'paypal_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function changeAccountPasswordLog()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_account_pw_log'");
        return $query["value"] == 1 ? true : false;
    }

    public static function changeEmailEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_email_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function changeEmailVerificationEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_email_mail_verification'");
        return $query["value"] == 1 ? true : false;
    }

    public static function changeWarehousePasswordLog()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_warehouse_pw_log'");
        return $query["value"] == 1 ? true : false;
    }

    public static function changeEmailLog()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'change_email_log'");
        return $query["value"] == 1 ? true : false;
    }

    public static function showWarehousePasswordEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'show_warehouse_pw'");
        return $query["value"] == 1 ? true : false;
    }

    public static function isPlayerInfoEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'player_info'");
        return $query["value"] == 1 ? true : false;
    }

    public static function isGuildInfoEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'guild_info'");
        return $query["value"] == 1 ? true : false;
    }

    public static function isFooterBoxEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'footerbox_enable'");
        return $query["value"] == 1 ? true : false;
    }

    public static function getFooterText()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'footer_text'");
        return $query["value"];
    }

    public static function isCaptchaEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'captcha_enable'");
        return $query["value"] == 1 ? true : false;
    }






















    public static function result($text, $typ = 3)
    {
        if($typ == 1)
        {
            $html = '
            <div class="alert alert-success" role="alert">
              '.$text.'
            </div>';
        }
        elseif($typ == 2)
        {
            $html = '
            <div class="alert alert-danger" role="alert">
              '.$text.'
            </div>';
        }
        elseif($typ == 3)
        {
            $html = '
            <div class="alert alert-info" role="alert">
              '.$text.'
            </div>';
        }
        elseif($typ == 4)
        {
            $html = '
            <div class="alert alert-warning" role="alert">
              '.$text.'
            </div>';
        }
        return $html;
    }

}

?>