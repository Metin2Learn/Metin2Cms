<?php

class Admin
{
    /*
     * RIGHTS :
     * a = dashboard
     * b = view tasks
     * c = view tickets
     * d = view notifications
     * e = add news
     * f = view all news
     * g = news settings
     * h = delete comments
     * ch = edit news
     * i = delete news
     * j = view downloads
     * k = add downloads
     * l = edit downloads
     * m = download settings
     * n = remove downloads
     */


    public static function isAdmin($username)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".admins WHERE username = ?", array($username));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function isWebAdmin($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".admins WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function hasRight($username, $right)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT rights FROM ".$dbname.".admins WHERE username = ?", array($username));
        $rights = trim($query["rights"]);
        $arrayRights = explode(",", $rights);
        if(in_array($right, $arrayRights))
        {
            return true;
        } else {
            return false;
        }
    }

    public static function router()
    {
        if(isset($_GET["page"]))
        {
            switch($_GET["page"])
            {
                case "home":
                    require_once("pages/home.php");
                    break;
                case "logout":
                    require_once("pages/logout.php");
                    break;
                case "account":
                    require_once("pages/account.php");
                    break;
                case "add-news":
                    require_once("pages/add-news.php");
                    break;
                case "all-news":
                    require_once("pages/all-news.php");
                    break;
                case "edit-news":
                    require_once("pages/edit-news.php");
                    break;
                case "no-permissions":
                    require_once("pages/no-permissions.php");
                    break;
                case "news-settings":
                    require_once("pages/news-settings.php");
                    break;
                case "news-comments":
                    require_once("pages/news-comments.php");
                    break;
                case "add-download":
                    require_once("pages/add-download.php");
                    break;
                case "download-settings":
                    require_once("pages/download-settings.php");
                    break;
                case "all-downloads":
                    require_once("pages/all-downloads.php");
                    break;
                case "edit-download":
                    require_once("pages/edit-download.php");
                    break;
                case "add-team-category":
                    require_once("pages/add-team-category.php");
                    break;
                case "all-team-categories":
                    require_once("pages/all-team-categories.php");
                    break;
                case "edit-team-category":
                    require_once("pages/edit-team-category.php");
                    break;
                case "add-team-member":
                    require_once("pages/add-team-member.php");
                    break;
                case "all-team-members":
                    require_once("pages/all-team-members.php");
                    break;
                case "edit-team-member":
                    require_once("pages/edit-team-member.php");
                    break;
                case "all-tickets":
                    require_once("pages/all-tickets.php");
                    break;
                case "view-ticket":
                    require_once("pages/view-ticket.php");
                    break;
                case "all-ticket-categories":
                    require_once("pages/all-ticket-categories.php");
                    break;
                case "edit-ticket-category":
                    require_once("pages/edit-ticket-category.php");
                    break;
                case "add-ticket-category":
                    require_once("pages/add-ticket-category.php");
                    break;
                case "ticket-settings":
                    require_once("pages/ticket-settings.php");
                    break;
                case "all-is-items":
                    require_once("pages/all-is-items.php");
                    break;
                case "all-is-categories":
                    require_once("pages/all-is-categories.php");
                    break;
                case "add-is-item":
                    require_once("pages/add-is-item.php");
                    break;
                case "add-is-category":
                    require_once("pages/add-is-category.php");
                    break;
                case "is-settings":
                    require_once("pages/is-settings.php");
                    break;
                case "edit-is-item":
                    require_once("pages/edit-is-item.php");
                    break;
                case "is-coupons":
                    require_once("pages/is-coupons.php");
                    break;
                case "all-game-admins":
                    require_once("pages/all-game-admins.php");
                    break;
                case "add-game-admin":
                    require_once("pages/add-game-admin.php");
                    break;
                case "edit-game-admin":
                    require_once("pages/edit-game-admin.php");
                    break;
                case "all-web-admins":
                    require_once("pages/all-web-admins.php");
                    break;
                case "add-web-admin":
                    require_once("pages/add-web-admin.php");
                    break;
                case "edit-web-admin":
                    require_once("pages/edit-web-admin.php");
                    break;
                case "add-task":
                    require_once("pages/add-task.php");
                    break;
                case "all-tasks":
                    require_once("pages/all-tasks.php");
                    break;
                case "edit-task":
                    require_once("pages/edit-task.php");
                    break;
                case "referral-settings":
                    require_once("pages/referral-settings.php");
                    break;
                case "referral-rewards":
                    require_once("pages/referral-rewards.php");
                    break;
                case "menu-links":
                    require_once("pages/menu-links.php");
                    break;
                case "slider":
                    require_once("pages/slider.php");
                    break;
                case "partners":
                    require_once("pages/partners.php");
                    break;
                case "footer-box":
                    require_once("pages/footer-box.php");
                    break;
                case "panels":
                    require_once("pages/panels.php");
                    break;
                case "server-status":
                    require_once("pages/server-status.php");
                    break;
                case "config-main":
                    require_once("pages/config-main.php");
                    break;
                case "config-register":
                    require_once("pages/config-register.php");
                    break;
                case "config-other":
                    require_once("pages/config-other.php");
                    break;
                case "view-players":
                    require_once("pages/view-players.php");
                    break;
                case "view-banlist":
                    require_once("pages/view-banlist.php");
                    break;
                case "log-ban":
                    require_once("pages/log-ban.php");
                    break;
                case "log-change-email":
                    require_once("pages/log-change-email.php");
                    break;
                case "log-change-password":
                    require_once("pages/log-change-password.php");
                    break;
                case "log-warehouse-password":
                    require_once("pages/log-warehouse-password.php");
                    break;
                case "log-coupons":
                    require_once("pages/log-coupons.php");
                    break;
                case "log-itemshop":
                    require_once("pages/log-itemshop.php");
                    break;
                case "log-password-recovery":
                    require_once("pages/log-password-recovery.php");
                    break;
                case "log-referral-rewards":
                    require_once("pages/log-referral-rewards.php");
                    break;
                case "log-gm-chat":
                    require_once("pages/log-gm-chat.php");
                    break;
                case "log-gm-command":
                    require_once("pages/log-gm-command.php");
                    break;
                case "log-hack":
                    require_once("pages/log-hack.php");
                    break;
                case "log-shout":
                    require_once("pages/log-shout.php");
                    break;
                case "custom-pages":
                    require_once("pages/custom-pages.php");
                    break;
                case "search":
                    require_once("pages/search.php");
                    break;
                case "web-error":
                    require_once("pages/web-error.php");
                    break;
                case "psc-pins":
                    require_once("pages/psc-pins.php");
                    break;
                case "amazon-codes":
                    require_once("pages/amazon-codes.php");
                    break;
                case "paypal":
                    require_once("pages/paypal.php");
                    break;
                case "log-paypal":
                    require_once("pages/log-paypal.php");
                    break;

                default:
                    require_once("pages/home.php");
                    break;
            }
        } else {
            require_once("pages/home.php");
        }
    }

    public static function printMenu()
    {

        /*
         * RIGHTS :
         * a = dashboard
         * b = view tasks
         * c = view tickets
         * d = view notifications
         * e = add news
         * f = view all news
         * g = news settings
         * h = delete comments
         * ch = edit news
         * i = delete news
         * j = view downloads
         * k = add downloads
         * l = edit downloads
         * m = download settings
         * n = remove downloads
         * o = view team members
         * p = add team member
         * q = edit team member
         * r = delete team member
         * s = add / edit / remove team member category
         * t = view tickets ********* + c
         * u = answer tickets
         * v = close ticket / reopen ticket
         * w = add / edit / remove ticket category
         * x = edit ticket settings
         * y = view item shop - items/categories
         * z = add item shop - items/categories
         * a1 = edit item shop - items/categories
         * b1 = delete item shop - items/categories
         * c1 = edit item shop settings
         * d1 = add / delete coupons
         * e1 = view coupons
         * f1 = view game administrators
         * g1 = view web administrators
         * h1 = add / delete / edit game administrators
         * ch1 = add / delete / edit web administrators
         * i1 = add / delete / edit tasks
         * j1 = edit referral system
         * k1 = add / edit / delete template content ( such like server status, panels, partners, menu links...)
         * l1 = configuration
         * m1 = game administration (players etc.), search
         * n1 = access logs
         */

        echo '<ul class="sidebar-menu">';
        // MENU ITEM //
        if(!isset($_GET["page"]))
        {
            echo '<li class="active">';
        } else {
            echo '<li>';
        }
        echo '<a href="index.php">';
        echo '<i class="fa fa-home"></i><span>'.Language::getTranslation("dashboard").'</span>';
        echo '</a></li>';

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "e") OR self::hasRight($_SESSION["username"], "f") OR self::hasRight($_SESSION["username"], "g")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-newspaper-o"></i><span>' . Language::getTranslation("news") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(self::hasRight($_SESSION["username"], "e")) {
                echo '<li><a href="index.php?page=add-news">' . Language::getTranslation("addNews") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "f")) {
                echo '<li><a href="index.php?page=all-news">' . Language::getTranslation("viewNews") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "g")) {
                echo '<li><a href="index.php?page=news-settings">' . Language::getTranslation("settings") . '</a></li>';
            }
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "j") OR self::hasRight($_SESSION["username"], "k") OR self::hasRight($_SESSION["username"], "m")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-download"></i><span>' . Language::getTranslation("downloads") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(self::hasRight($_SESSION["username"], "k")) {
                echo '<li><a href="index.php?page=add-download">' . Language::getTranslation("addDownload") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "j")) {
                echo '<li><a href="index.php?page=all-downloads">' . Language::getTranslation("viewDownloads") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "m")) {
                echo '<li><a href="index.php?page=download-settings">' . Language::getTranslation("settings") . '</a></li>';
            }
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "o") OR self::hasRight($_SESSION["username"], "p") OR self::hasRight($_SESSION["username"], "s")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-group"></i><span>' . Language::getTranslation("teamMembers") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(self::hasRight($_SESSION["username"], "p")) {
                echo '<li><a href="index.php?page=add-team-member">' . Language::getTranslation("addTeamMember") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "o")) {
                echo '<li><a href="index.php?page=all-team-members">' . Language::getTranslation("viewTeamMember") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "s")) {
                echo '<li><a href="index.php?page=add-team-category">' . Language::getTranslation("addCategory") . '</a></li>';
                echo '<li><a href="index.php?page=all-team-categories">' . Language::getTranslation("viewCategories") . '</a></li>';
            }
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "t")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-envelope"></i><span>' . Language::getTranslation("ticketSystem") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=all-tickets">' . Language::getTranslation("viewOpenTickets") . '</a></li>';
            if(self::hasRight($_SESSION["username"], "w"))
            {
                echo '<li><a href="index.php?page=add-ticket-category">' . Language::getTranslation("addCategory") . '</a></li>';
                echo '<li><a href="index.php?page=all-ticket-categories">' . Language::getTranslation("ticketCategories") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "x"))
            {
                echo '<li><a href="index.php?page=ticket-settings">' . Language::getTranslation("settings") . '</a></li>';
            }
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "y") OR self::hasRight($_SESSION["username"], "z")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-shopping-cart"></i> <span>' . Language::getTranslation("isTitle") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(self::hasRight($_SESSION["username"], "y"))
            {
                echo '<li><a href="index.php?page=all-is-items">' . Language::getTranslation("viewItems") . '</a></li>';
                echo '<li><a href="index.php?page=all-is-categories">' . Language::getTranslation("viewCategories") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "z"))
            {
                echo '<li><a href="index.php?page=add-is-item">' . Language::getTranslation("addItem") . '</a></li>';
                echo '<li><a href="index.php?page=add-is-category">' . Language::getTranslation("addCategory") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "e1"))
            {
                echo '<li><a href="index.php?page=is-coupons">' . Language::getTranslation("coupons") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "c1"))
            {
                echo '<li><a href="index.php?page=is-settings">' . Language::getTranslation("settings") . '</a></li>';
                echo '<li><a href="index.php?page=psc-pins">' . Language::getTranslation("paysafecardPins") . '</a></li>';
                echo '<li><a href="index.php?page=amazon-codes">' . Language::getTranslation("amazonCodes") . '</a></li>';
                echo '<li><a href="index.php?page=paypal">' . Language::getTranslation("paypalSettings") . '</a></li>';
            }

            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "f1") OR self::hasRight($_SESSION["username"], "g1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-key"></i> <span>' . Language::getTranslation("administrators") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(Admin::hasRight($_SESSION["username"],"f1")) {
                echo '<li><a href="index.php?page=all-game-admins">' . Language::getTranslation("viewGameAdministrators") . '</a></li>';
            }
            if(Admin::hasRight($_SESSION["username"], "g1")) {
                echo '<li><a href="index.php?page=all-web-admins">' . Language::getTranslation("viewWebAdministrators") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "h1"))
            {
                echo '<li><a href="index.php?page=add-game-admin">' . Language::getTranslation("addGameAdmin") . '</a></li>';
            }
            if(self::hasRight($_SESSION["username"], "ch1"))
            {
                echo '<li><a href="index.php?page=add-web-admin">' . Language::getTranslation("addWebAdmin") . '</a></li>';
            }

            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "b") OR self::hasRight($_SESSION["username"], "i1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-thumb-tack"></i> <span>' . Language::getTranslation("tasks") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            if(Admin::hasRight($_SESSION["username"],"b")) {
                echo '<li><a href="index.php?page=all-tasks">' . Language::getTranslation("viewTasks") . '</a></li>';
            }
            if(Admin::hasRight($_SESSION["username"], "i1")) {
                echo '<li><a href="index.php?page=add-task">' . Language::getTranslation("addTask") . '</a></li>';
            }

            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "j1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-hand-o-right"></i> <span>' . Language::getTranslation("referralSystem") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=referral-rewards">' . Language::getTranslation("rewards") . '</a></li>';
            echo '<li><a href="index.php?page=referral-settings">' . Language::getTranslation("settings") . '</a></li>';

            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "k1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-pencil"></i> <span>' . Language::getTranslation("templateContent") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=custom-pages">' . Language::getTranslation("customPages") . '</a></li>';
            echo '<li><a href="index.php?page=menu-links">' . Language::getTranslation("menuLinks") . '</a></li>';
            echo '<li><a href="index.php?page=slider">' . Language::getTranslation("slider") . '</a></li>';
            echo '<li><a href="index.php?page=partners">' . Language::getTranslation("partners") . '</a></li>';
            echo '<li><a href="index.php?page=footer-box">' . Language::getTranslation("footerBox") . '</a></li>';
            echo '<li><a href="index.php?page=panels">' . Language::getTranslation("panels") . '</a></li>';
            echo '<li><a href="index.php?page=server-status">' . Language::getTranslation("statusServer") . '</a></li>';


            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "m1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-gamepad"></i> <span>' . Language::getTranslation("game") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=view-players">' . Language::getTranslation("viewPlayers") . '</a></li>';
            echo '<li><a href="index.php?page=view-banlist">' . Language::getTranslation("viewBanList") . '</a></li>';
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "n1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-sticky-note"></i> <span>' . Language::getTranslation("logs") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=log-gm-chat">' . Language::getTranslation("logGameChat") . '</a></li>';
            echo '<li><a href="index.php?page=log-gm-command">' . Language::getTranslation("logGameCommand") . '</a></li>';
            echo '<li><a href="index.php?page=log-hack">' . Language::getTranslation("logHackLog") . '</a></li>';
            echo '<li><a href="index.php?page=log-shout">' . Language::getTranslation("logShoutLog") . '</a></li>';
            echo '<li><a href="index.php?page=log-ban">' . Language::getTranslation("logBan") . '</a></li>';
            echo '<li><a href="index.php?page=log-change-email">' . Language::getTranslation("logChangeEmail") . '</a></li>';
            echo '<li><a href="index.php?page=log-change-password">' . Language::getTranslation("logChangePW") . '</a></li>';
            echo '<li><a href="index.php?page=log-warehouse-password">' . Language::getTranslation("logWarehousePW") . '</a></li>';
            echo '<li><a href="index.php?page=log-coupons">' . Language::getTranslation("logCoupons") . '</a></li>';
            echo '<li><a href="index.php?page=log-itemshop">' . Language::getTranslation("logItemshop") . '</a></li>';
            echo '<li><a href="index.php?page=log-password-recovery">' . Language::getTranslation("logPasswordRecovery") . '</a></li>';
            echo '<li><a href="index.php?page=log-referral-rewards">' . Language::getTranslation("logReferral") . '</a></li>';
            echo '<li><a href="index.php?page=log-paypal">' . Language::getTranslation("logPaypal") . '</a></li>';
            echo '</ul></li>';
        }
        // MENU ITEM //

        // MENU ITEM //
        if(self::hasRight($_SESSION["username"], "l1")) {
            echo '<li class="menu">';
            echo '<a href="#">';
            echo '<i class="fa fa-cog"></i> <span>' . Language::getTranslation("Configuration") . '</span>
            <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="sub-menu">';
            echo '<li><a href="index.php?page=config-main">' . Language::getTranslation("mainConfiguration") . '</a></li>';
            echo '<li><a href="index.php?page=config-register">' . Language::getTranslation("registerConfiguration") . '</a></li>';
            echo '<li><a href="index.php?page=config-other">' . Language::getTranslation("otherConfig") . '</a></li>';
            echo '</ul></li>';
        }
        // MENU ITEM //


        echo '</ul>';


        /*
         * 				<ul class="sidebar-menu">
					<li class="menu">
						<a href="index.php">
							<i class="fa fa-home"></i><span><?= Language::getTranslation("dashboard") ?></span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-laptop"></i><span>UI Elements</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="ui-general.html">General</a></li>
							<li><a href="ui-buttons.html">Buttons</a></li>
							<li><a href="ui-grid.html">Grid</a></li>
							<li><a href="ui-group-list.html">Group List</a></li>
							<li><a href="ui-icons.html">Icons</a></li>
							<li><a href="ui-messages.html">Messages & Notifications</a></li>
							<li><a href="ui-modals.html">Modals</a></li>
							<li><a href="ui-tabs.html">Tabs & Accordions</a></li>
							<li><a href="ui-typography.html">Typography</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-align-left"></i><span>Forms</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="forms-components.html">Components</a></li>
							<li><a href="forms-masks.html">Input Masks</a></li>
							<li><a href="forms-validation.html">Validation</a></li>
							<li><a href="forms-wizard.html">Wizard</a></li>
							<li><a href="forms-wysiwyg.html">WYSIWYG Editor</a></li>
							<li><a href="forms-upload.html">Multi Upload</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-table"></i><span>Tables</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="tables-basic.html">Basic Tables</a></li>
							<li><a href="tables-datatables.html">Data Tables</a></li>
						</ul>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-map-marker"></i><span>Maps</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="maps-google.html">Google Map</a></li>
							<li><a href="maps-vector.html">Vector Map</a></li>
						</ul>
					</li>
					<li>
						<a href="charts.html">
							<i class="fa fa-bar-chart-o"></i><span>Charts</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-archive"></i><span>Pages</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="404.html">404 Page</a></li>
							<li><a href="500.html">500 Page</a></li>
							<li><a href="pages-blank.html">Blank Page</a></li>
							<li><a href="pages-blank-header.html">Blank Page Header</a></li>
							<li><a href="pages-calendar.html">Calendar</a></li>
							<li><a href="pages-code.html">Code Editor</a></li>
							<li><a href="pages-gallery.html">Gallery</a></li>
							<li><a href="pages-invoice.html">Invoice</a></li>
							<li><a href="lockscreen.html">Lock Screen</a></li>
							<li><a href="login.html">Login</a></li>
							<li><a href="register.html">Register</a></li>
							<li><a href="pages-search.html">Search Result</a></li>
							<li><a href="pages-support.html">Support Ticket</a></li>
							<li><a href="pages-timeline.html">Timeline</a></li>
							<li><a href="pages-user.html">User Profile</a></li>
						</ul>
					</li>
					<li>
						<a href="email.html">
							<i class="fa fa-envelope"></i><span>Email</span><small class="badge pull-right bg-blue">12</small>
						</a>
					</li>
					<li>
						<a href="frontend/index.html">
							<i class="fa fa-flag"></i><span>Frontend</span>
						</a>
					</li>
					<li class="menu">
						<a href="#">
							<i class="fa fa-folder-open"></i><span>Menu Levels</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="sub-menu">
							<li><a href="#">Level 1</a></li>
							<li class="menu">
								<a href="#">
									<span>Level 2</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="sub-menu">
									<li><a href="#">Sub Menu</a></li>
									<li><a href="#">Sub Menu</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
         */
    }

    public static function numberOfGameAdmins()
    {
        $common_db = Core::getCommonDatabase();
        $query = Database::query("SELECT * FROM ".$common_db.".gmlist");
        return $query;
    }

    public static function numberOfWebAdmins()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".admins");
        return $query;
    }

    public static function gameAdminExists($mid)
    {
        $common_db = Core::getCommonDatabase();
        $query = Database::query("SELECT * FROM ".$common_db.".gmlist WHERE mID = ?", array($mid));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function webAdminExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".admins WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function webAdminInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".admins WHERE id = ?", array($id));
        return $query;
    }

    public static function gameAdminInfo($mid)
    {
        $common_db = Core::getCommonDatabase();
        $query = Database::queryAlone("SELECT * FROM ".$common_db.".gmlist WHERE mID = ?", array($mid));
        return $query;
    }

    public static function updateGameAdmin($account, $ingame, $ip, $authority, $mid)
    {
        $common_db = Core::getCommonDatabase();
        Database::query("UPDATE ".$common_db.".gmlist SET
        mAccount = ?, mName = ?, mContactIP = ?, mAuthority = ? WHERE mID = ?",
            array($account, $ingame, $ip, $authority, $mid));
    }

    public static function addGameAdmin($account, $ingame, $ip, $authority)
    {
        $common_db = Core::getCommonDatabase();
        Database::query("INSERT INTO ".$common_db.".gmlist
        (mAccount, mName, mContactIP, mServerIP, mAuthority) VALUES (?, ?, ?, 'ALL', ?)",
            array($account, $ingame, $ip, $authority));
    }

    public static function addWebAdmin($account, $rights)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".admins
        (username, rights, added) VALUES (?, ?, ?)", array($account, $rights, date('Y-m-d H:i:s')));
    }

    public static function updateWebAdmin($account, $rights, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".admins SET username = ?, rights = ? WHERE id = ?",
            array($account, $rights, $id));
    }

    public static function deleteGameAdmin($mid)
    {
        $common_db = Core::getCommonDatabase();
        Database::query("DELETE FROM ".$common_db.".gmlist WHERE mID = ?", array($mid));
    }

    public static function deleteWebAdmin($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".admins WHERE id = ?", array($id));
    }

    public static function printWebAdmins($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("regUsername").'</th>
                        <th class="text-center">'.Language::getTranslation("rights").'</th>
                        <th class="text-center">'.Language::getTranslation("adminSince").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["username"].'</td>';
            echo '<td class="text-center">'.$row["rights"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["added"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "h1")) {
                echo '<a href="index.php?page=edit-web-admin&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';


                echo '<a href="index.php?page=all-web-admins&delete=' . $row["id"] . '" ';
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

    public static function printGameAdmins($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("regUsername").'</th>
                        <th class="text-center">'.Language::getTranslation("ingameName").'</th>
                        <th class="text-center">'.Language::getTranslation("authority").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["mAccount"].'</td>';
            echo '<td class="text-center">'.$row["mName"].'</td>';
            echo '<td class="text-center">'.$row["mAuthority"].'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "h1")) {
                echo '<a href="index.php?page=edit-game-admin&id=' . $row["mID"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';


                echo '<a href="index.php?page=all-game-admins&delete=' . $row["mID"] . '" ';
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