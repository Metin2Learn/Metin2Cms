<?php

class Router
{

    public function isAllowed($what)
    {
        $allowed = array(
            "account", "account-info", "buy", "change-email", "change-pw", "change-warehouse-pw", "chars", "coins",
            "debug", "download", "edit-account", "error", "guilds", "itemshop", "login", "logout", "lost-pw", "news",
            "players", "player", "referral-rewards", "referral-system", "register", "search", "send-delcode", "send-warehouse-pw",
            "team", "ticket-add", "ticket-system", "ticket-view", "viewpage"
        );
        if(in_array($what, $allowed))
        {
            return true;
        } else {
            return false;
        }
    }

    public function __construct()
    {
        if(isset($_GET['page']))
        {
            $file = 'pages/'.$_GET['page'].'.php';
            if(file_exists($file) AND filesize($file) != 0 AND self::isAllowed($_GET["page"]))
            {
                require_once($file);
            } else {
                Core::redirect(Links::getUrl("error"),0);
                die();
            }
        } else {
            require_once('pages/news.php');
        }
    }

}

?>