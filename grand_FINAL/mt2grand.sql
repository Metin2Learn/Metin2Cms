-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 23. pro 2015, 13:59
-- Verze serveru: 5.6.17
-- Verze PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `mt2grand`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `action_spam_protection`
--

CREATE TABLE IF NOT EXISTS `action_spam_protection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date_issued` datetime NOT NULL,
  `date_blocked_until` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=41 ;

--
-- Vypisuji data pro tabulku `action_spam_protection`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `rights` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `admins`
--

INSERT INTO `admins` (`id`, `username`, `rights`, `added`) VALUES
(1, 'noxel', 'a,b,d,e,f,g,h,ch,i,j,k,l,m,n,o,p,q,r,s,t,c,u,v,w,x,y,z,a1,b1,c1,d1,e1,f1,g1,h1,ch1,i1,j1,k1,l1,m1,n1', '2015-11-13 00:00:00');
-- --------------------------------------------------------

--
-- Struktura tabulky `admin_task`
--

CREATE TABLE IF NOT EXISTS `admin_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `percent` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `admin_task`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `amazon_codes`
--

CREATE TABLE IF NOT EXISTS `amazon_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `status` enum('allowed','denied','processing') COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  `coins` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `amazon_codes`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `value` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `admin` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `used` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `coupons`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `custom_pages`
--

CREATE TABLE IF NOT EXISTS `custom_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `added` datetime NOT NULL,
  `admin` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `custom_pages`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `desc` text COLLATE utf8_czech_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=64 ;

--
-- Vypisuji data pro tabulku `downloads`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `failed_login`
--

CREATE TABLE IF NOT EXISTS `failed_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `first_attempt` int(11) NOT NULL,
  `count_attempts` int(11) NOT NULL,
  `date_issued` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `failed_login`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `footer_box`
--

CREATE TABLE IF NOT EXISTS `footer_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `footer_box`
--

INSERT INTO `footer_box` (`id`, `position`, `title`, `content`) VALUES
(1, 'left', 'About us', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam auctor dictum nibh, ac gravida orci porttitor et. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.'),
(2, 'mid', 'Tags', '<div class="box footer-tags">\r\n                    <a href="#"><span class="text-10">Clean</span></a>\r\n                    <a href="#"><span class="text-20">CV</span></a>\r\n                    <a href="#"><span class="text-20">Flat</span></a>\r\n                    <a href="#"><span class="text-14">Freelance</span></a>\r\n                    <a href="#"><span class="text-20">Modern</span></a>\r\n                    <a href="#"><span class="text-12">One Page</span></a>\r\n                    <a href="#"><span class="text-14">Professional</span></a>\r\n                    <a href="#"><span class="text-14">Responsive</span></a>\r\n                    <a href="#"><span class="text-16">Resume</span></a>\r\n                    <a href="#"><span class="text-20">Business</span></a>\r\n                    <a href="#"><span class="text-16">Corporate</span></a>\r\n                    <a href="#"><span class="text-18">CSS3</span></a>\r\n                    <a href="#"><span class="text-12">HTML5</span></a>\r\n                    <a href="#"><span class="text-16">Mobile First</span></a>\r\n                    <a href="#"><span class="text-20">Multipurpose</span></a>\r\n                    <a href="#"><span class="text-14">Portfolio</span></a>\r\n</div>\r\n'),
(3, 'right', 'Recent Posts', 'GRAND_EXEC(recentPosts)');

-- --------------------------------------------------------

--
-- Struktura tabulky `itemshop_category`
--

CREATE TABLE IF NOT EXISTS `itemshop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `added_by` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `itemshop_category`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `itemshop_items`
--

CREATE TABLE IF NOT EXISTS `itemshop_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `socket0` int(11) NOT NULL,
  `socket1` int(11) NOT NULL,
  `socket2` int(11) NOT NULL,
  `addon_type` int(11) NOT NULL,
  `time_limit` int(11) NOT NULL,
  `can_change_amount` int(11) NOT NULL,
  `max_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=20 ;

--
-- Vypisuji data pro tabulku `itemshop_items`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `head_title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `visible` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_parent` int(11) NOT NULL DEFAULT '0',
  `can_delete` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=46 ;

--
-- Vypisuji data pro tabulku `links`
--

INSERT INTO `links` (`id`, `title`, `link`, `head_title`, `visible`, `parent_id`, `is_parent`, `can_delete`) VALUES
(1, 'index', 'http://localhost/mt2grand-cms/', '', 0, NULL, 0, 0),
(2, 'home', 'http://localhost/mt2grand-cms/news', 'News', 1, NULL, 0, 0),
(3, 'download', 'http://localhost/mt2grand-cms/download', 'Downloads', 1, NULL, 0, 0),
(4, 'register', 'http://localhost/mt2grand-cms/register', 'Register', 0, NULL, 0, 0),
(5, 'PLAYERS', 'http://localhost/mt2grand-cms/players', 'Player rankings', 1, 6, 0, 0),
(6, 'rankings', '', 'Rankings', 1, NULL, 1, 0),
(7, 'Itemshop', 'http://localhost/mt2grand-cms/itemshop', 'Itemshop', 1, NULL, 0, 0),
(8, 'login', 'http://localhost/mt2grand-cms/login', 'Login', 0, NULL, 0, 0),
(9, 'error', 'http://localhost/mt2grand-cms/error', '404 Error', 0, NULL, 0, 0),
(10, 'logout', 'logout', 'Logout', 0, NULL, 0, 0),
(11, 'account', 'http://localhost/mt2grand-cms/account', 'Account', 0, NULL, 0, 0),
(12, 'team', 'http://localhost/mt2grand-cms/team', 'Team', 1, NULL, 0, 0),
(13, 'GUILDS', 'http://localhost/mt2grand-cms/guilds', 'Guilds', 1, 6, 0, 0),
(14, 'player', 'http://localhost/mt2grand-cms/player', 'Player info', 0, NULL, 0, 0),
(15, 'Guild', 'guild', 'Guild info', 0, NULL, 0, 0),
(16, 'account info', 'http://localhost/mt2grand-cms/account-info', 'Account Info', 0, NULL, 0, 0),
(17, 'account coins', 'http://localhost/mt2grand-cms/coins', 'Coins', 0, NULL, 0, 0),
(18, 'account debug', 'http://localhost/mt2grand-cms/debug', 'Debug', 0, NULL, 0, 0),
(19, 'account edit', 'http://localhost/mt2grand-cms/edit-account', 'Edit account', 0, NULL, 0, 0),
(20, 'account chars', 'http://localhost/mt2grand-cms/chars', 'Characters', 0, NULL, 0, 0),
(21, 'account ticket system', 'http://localhost/mt2grand-cms/ticket-system', 'Ticket system', 0, NULL, 0, 0),
(22, 'account referral system', 'http://localhost/mt2grand-cms/referral-system', 'Referral system', 0, NULL, 0, 0),
(23, 'account send-delcode', 'http://localhost/mt2grand-cms/send-delcode', 'Delcode send', 0, NULL, 0, 0),
(24, 'account change-pw', 'http://localhost/mt2grand-cms/change-pw', 'Change password', 0, NULL, 0, 0),
(25, 'account change-pw-finish', 'http://localhost/mt2grand-cms/change-pw/finish', 'Change password', 0, NULL, 0, 0),
(26, 'account change-warehouse-pw', 'http://localhost/mt2grand-cms/change-warehouse-pw', 'Change warehouse password', 0, NULL, 0, 0),
(27, 'account send-warehouse-pw', 'http://localhost/mt2grand-cms/send-warehouse-pw', 'Send warehouse password', 0, NULL, 0, 0),
(28, 'account change-email', 'http://localhost/mt2grand-cms/change-email', 'Change email', 0, NULL, 0, 0),
(29, 'account change-email-finish', 'http://localhost/mt2grand-cms/change-email/finish', 'Change email', 0, NULL, 0, 0),
(30, 'account ticket-add', 'http://localhost/mt2grand-cms/ticket-add', 'Add ticket', 0, NULL, 0, 0),
(31, 'account ticket-view', 'http://localhost/mt2grand-cms/ticket-view', 'Your tickets', 0, NULL, 0, 0),
(32, 'account ticket-view-show', 'http://localhost/mt2grand-cms/ticket-view/id/', 'View ticket', 0, NULL, 0, 0),
(33, 'register-referral', 'http://localhost/mt2grand-cms/register/ref/', 'Register', 0, NULL, 0, 0),
(34, 'referral-shop', 'http://localhost/mt2grand-cms/referral-shop', 'Referral shop', 0, NULL, 0, 0),
(35, 'lost-pw', 'http://localhost/mt2grand-cms/lost-pw', 'Password recovery', 0, NULL, 0, 0),
(36, 'search', 'http://localhost/mt2grand-cms/search', 'Search', 0, NULL, 0, 0),
(37, 'account referral rewards', 'http://localhost/mt2grand-cms/referral-rewards', 'Referral rewards', 0, NULL, 0, 0),
(42, '', 'http://localhost/mt2grand-cms/viewpage/3', 'Custom page 99', 1, NULL, 0, 1),
(43, 'coins delete', 'http://localhost/mt2grand-cms/coins/delete/', 'Coins', 0, NULL, 0, 0),
(44, 'coins delete amazon', 'http://localhost/mt2grand-cms/coins/delete/amazon/', 'Coins', 0, NULL, 0, 0),
(45, 'paypal_script', 'http://localhost/mt2grand-cms/paypal.php', 'Paypal', 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `log_bans`
--

CREATE TABLE IF NOT EXISTS `log_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `admin` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ban_until` datetime DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `log_bans`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_change_email`
--

CREATE TABLE IF NOT EXISTS `log_change_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `old_email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `new_email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `log_change_email`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_change_pw`
--

CREATE TABLE IF NOT EXISTS `log_change_pw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `old_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `new_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `log_change_pw`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_change_warehouse_pw`
--

CREATE TABLE IF NOT EXISTS `log_change_warehouse_pw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `old_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `new_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `log_change_warehouse_pw`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_coupons`
--

CREATE TABLE IF NOT EXISTS `log_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `log_coupons`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_itemshop`
--

CREATE TABLE IF NOT EXISTS `log_itemshop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=18 ;

--
-- Vypisuji data pro tabulku `log_itemshop`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_password_recovery`
--

CREATE TABLE IF NOT EXISTS `log_password_recovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `old_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `new_pw` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `used_token` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `log_password_recovery`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `log_referral_rewards`
--

CREATE TABLE IF NOT EXISTS `log_referral_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_vnum` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `log_referral_rewards`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `intro` text COLLATE utf8_czech_ci,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `important` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `img` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=224 ;

--
-- Vypisuji data pro tabulku `news`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `news_comments`
--

CREATE TABLE IF NOT EXISTS `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `author` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `news_comments`
--



-- --------------------------------------------------------

--
-- Struktura tabulky `panels`
--

CREATE TABLE IF NOT EXISTS `panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `panels`
--

INSERT INTO `panels` (`id`, `title`, `content`, `order`, `active`) VALUES
(1, 'Facebook', '<script>(function(d, s, id) {\n        var js, fjs = d.getElementsByTagName(s)[0];\n        if (d.getElementById(id)) return;\n        js = d.createElement(s); js.id = id;\n        js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.5&appId=134478036577261";\n        fjs.parentNode.insertBefore(js, fjs);\n    }(document, ''script'', ''facebook-jssdk''));</script>\n\n<div class="fb-page" data-href="https://www.facebook.com/wordmt3/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/wordmt3/"><a href="https://www.facebook.com/wordmt3/">WordMT3.cz - Privátní server</a></blockquote></div></div>\n\n', 0, 1),
(2, 'Sample text', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.', 0, 1),
(3, 'server_status', 'GRAND_EXEC(serverStatus)', 0, 1),
(4, 'Rankings', 'GRAND_EXEC(rankings)', 1, 1),
(7, 'Statistics', 'GRAND_EXEC(statistics)', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `alt` text COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `blank` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `partners`
--

INSERT INTO `partners` (`id`, `title`, `alt`, `link`, `img`, `blank`, `order`) VALUES
(1, 'numero 1', 'Hello', '#', 'assets/images/partner_1.png', 1, 0),
(2, 'numbero two', '', '#', 'assets/images/partner_2.png', 0, 0),
(3, 'sadsad', '', '#', 'assets/images/partner_3.png', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `password_recovery`
--

CREATE TABLE IF NOT EXISTS `password_recovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_expired` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `password_recovery`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `paypal_options`
--

CREATE TABLE IF NOT EXISTS `paypal_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `paypal_options`
--

INSERT INTO `paypal_options` (`id`, `price`, `coins`) VALUES
(2, 5, 100),
(3, 10, 200),
(4, 15, 300);

-- --------------------------------------------------------

--
-- Struktura tabulky `paypal_payments`
--

CREATE TABLE IF NOT EXISTS `paypal_payments` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `payment_amount` decimal(7,2) NOT NULL,
  `payment_currency` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `payment_status` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `itemname` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `payer_email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `payer_account` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `createdtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `paysafecard_pins`
--

CREATE TABLE IF NOT EXISTS `paysafecard_pins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `status` enum('allowed','denied','processing') COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  `coins` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `paysafecard_pins`
--



-- --------------------------------------------------------

--
-- Struktura tabulky `referral_rewards`
--

CREATE TABLE IF NOT EXISTS `referral_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `item_vnum` int(11) NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `socket0` int(11) NOT NULL,
  `socket1` int(11) NOT NULL,
  `socket2` int(11) NOT NULL,
  `addon_type` int(11) NOT NULL,
  `time_limit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `referral_rewards`
--



-- --------------------------------------------------------

--
-- Struktura tabulky `referrer_system`
--

CREATE TABLE IF NOT EXISTS `referrer_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referrer` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `player_level` int(11) NOT NULL,
  `player_account` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `added_points` int(11) NOT NULL,
  `singed` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=36 ;

--
-- Vypisuji data pro tabulku `referrer_system`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `server_status`
--

CREATE TABLE IF NOT EXISTS `server_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2555) COLLATE utf8_czech_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `port` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `server_status`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `mini_description` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `slider`
--

INSERT INTO `slider` (`id`, `link`, `img`, `description`, `mini_description`, `alt`) VALUES
(1, '', '1.jpg', 'This is me', '28.10.2015', 'Yeah Me'),
(2, 'lol', '2.jpg', 'I am the proffesional', 'Lol yes i''m', 'Lol'),
(3, 'cus', '3.jpg', 'This is me with grandma', 'I like her', 'Rofl'),
(4, '', '4.jpg', 'Join us and win some free coins', 'Its easy as hell', 'Join us and win some free coins');


-- --------------------------------------------------------

--
-- Struktura tabulky `team_category`
--

CREATE TABLE IF NOT EXISTS `team_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `added` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `team_category`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `team_members`
--

CREATE TABLE IF NOT EXISTS `team_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ingame_nick` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `since` datetime NOT NULL,
  `contact` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `desc` text COLLATE utf8_czech_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `gplus` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `team_members`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `ticket_system_answers`
--

CREATE TABLE IF NOT EXISTS `ticket_system_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `from_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  `is_admin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=14 ;

--
-- Vypisuji data pro tabulku `ticket_system_answers`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `ticket_system_category`
--

CREATE TABLE IF NOT EXISTS `ticket_system_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `added_by` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `ticket_system_category`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `ticket_system_tickets`
--

CREATE TABLE IF NOT EXISTS `ticket_system_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `last_seen` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `ticket_system_tickets`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `date_expire` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `tokens`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `web_settings`
--

CREATE TABLE IF NOT EXISTS `web_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=130 ;

--
-- Vypisuji data pro tabulku `web_settings`
--

INSERT INTO `web_settings` (`id`, `option`, `value`) VALUES
(1, 'account_table', 'account'),
(2, 'site_title', 'MT2Grand CMS'),
(3, 'header_title', '<img src="http://localhost/mt2grand-cms/admin/assets/img/logo.png">'),
(4, 'language', 'en'),
(5, 'header_slogan', 'The grand website for your private metin2 server'),
(6, 'facebook_link', 'dasdsa'),
(7, 'twitter_link', 'twit'),
(8, 'youtube_link', 'xxytb'),
(9, 'twitch_link', 'ss'),
(10, 'slider_enabled', '1'),
(11, 'partners_enable', '1'),
(12, 'footerbox_enable', '1'),
(13, 'footer_text', 'Copyright (2015) NewWorld2'),
(14, 'news_per_page', '5'),
(15, 'news_comments', '1'),
(16, 'register_enable', '1'),
(17, 'reg_pw_min', '6'),
(18, 'reg_pw_max', '14'),
(19, 'reg_pw_num', '1'),
(20, 'reg_nick_min', '4'),
(21, 'reg_nick_max', '8'),
(22, 'captcha_enable', '1'),
(23, 'reg_weak_passwords', '1'),
(24, 'reg_safebox_expire', '365'),
(25, 'reg_gold_expire', ''),
(26, 'reg_silver_expire', ''),
(27, 'reg_autoloot_expire', '365'),
(28, 'reg_fish_expire', '365'),
(29, 'reg_marriage_expire', '365'),
(30, 'reg_money_expire', ''),
(31, 'coins_column', 'coins'),
(32, 'reg_coins', '0'),
(33, 'login_captcha_attempts', '3'),
(35, 'date_format', 'd. m. Y - H:i'),
(36, 'dl_per_page', '5'),
(37, 'player_info', '1'),
(38, 'rank_per_page', '10'),
(39, 'player_table', 'player'),
(40, 'prefix_not_show_rankings', '[SGM],[GP]'),
(42, 'show_delete_code', '1'),
(43, 'referral_system', '1'),
(44, 'coupon_enable', '1'),
(45, 'coupon_log', '1'),
(46, 'mail_type', 'normal'),
(47, 'smtp_secure', 'ssl'),
(48, 'smtp_host', '192.168.0.1'),
(49, 'smtp_port', '465'),
(50, 'smtp_user', 'root'),
(51, 'smtp_password', 'xxxxx'),
(52, 'mail_from', 'admin@mt2grand.cms'),
(53, 'mail_from_name', 'MT2Grand CMS'),
(54, 'action_spam_penalty', '5'),
(55, 'change_pw_mail_verification', '1'),
(56, 'show_warehouse_pw', '0'),
(57, 'change_account_pw_log', '1'),
(58, 'change_warehouse_pw_log', '1'),
(59, 'change_email_enable', '1'),
(60, 'change_email_mail_verification', '1'),
(61, 'change_email_log', '1'),
(62, 'debug_disconnect_wait', '10'),
(63, 'debug_shinso_map', '0'),
(64, 'debug_shinso_x', '459770'),
(65, 'debug_shinso_y', '953980'),
(66, 'debug_chunjo_map', '21'),
(67, 'debug_chunjo_x', '52043'),
(68, 'debug_chunjo_y', '166304'),
(69, 'debug_jinno_map', '41'),
(70, 'debug_jinno_x', '957291'),
(71, 'debug_jinno_y', '255221'),
(72, 'ticket_system_enable', '1'),
(73, 'user_tickets_per_page', '10'),
(75, 'referral_limit', '5'),
(76, 'referral_level_1', '20'),
(77, 'referral_level_2', '5'),
(78, 'referral_level_3', '25'),
(79, 'referral_level_4', '50'),
(80, 'referral_level_5', NULL),
(81, 'referral_level_6', NULL),
(82, 'referral_level_7', NULL),
(83, 'referral_level_8', NULL),
(84, 'referral_level_9', NULL),
(85, 'referral_level_10', NULL),
(86, 'referral_reward_1', '5'),
(87, 'referral_reward_2', '10'),
(88, 'referral_reward_3', '15'),
(89, 'referral_reward_4', '100'),
(90, 'referral_reward_5', '0'),
(91, 'referral_reward_6', '0'),
(92, 'referral_reward_7', '0'),
(93, 'referral_reward_8', '0'),
(94, 'referral_reward_9', '0'),
(95, 'referral_reward_10', '0'),
(96, 'password_recovery_log', '1'),
(97, 'news_comments_login_only', '0'),
(98, 'news_comments_per_page', '5'),
(100, 'maintenance', '0'),
(101, 'maintenance_text', 'We are sorry. We will be back as soon as possible.'),
(103, 'itemshop_discount_percent', '30'),
(104, 'itemshop_discount_until', '0000-00-00 00:00:00'),
(105, 'itemshop_items_per_page', '6'),
(106, 'itemshop_currency', 'coins'),
(107, 'itemshop_log', '1'),
(109, 'referral_rewards_per_page', '8'),
(120, 'referral_log', '1'),
(121, 'common_table', 'common'),
(122, 'reg_disabled_passwords', 'password,123456,ahoj,ahoj,cau,cc'),
(123, 'log_db', 'log'),
(124, 'base_url', 'http://localhost/mt2grand-cms/'),
(125, 'enable_paysafecard', '1'),
(126, 'enable_amazon', '1'),
(127, 'paypal_enable', '1'),
(128, 'paypal_email', 'borec@homo.com'),
(129, 'paypal_currency', 'EUR');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
