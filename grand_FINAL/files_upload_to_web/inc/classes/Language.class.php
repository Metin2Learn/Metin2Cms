<?php

class Language
{

    public static function getLanguage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'language'");
        return $query["value"];
    }

    public static function getMonth($month, $short = false)
    {
        switch($month)
        {
            case 1:
                $string = self::getTranslation("january");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 2:
                $string = self::getTranslation("february");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 3:
                $string = self::getTranslation("march");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 4:
                $string = self::getTranslation("april");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 5:
                $string = self::getTranslation("may");
                $short = mb_substr($string, 0, 3);
                break;
            case 6:
                $string = self::getTranslation("june");
                $short = mb_substr($string, 0, 4);
                break;
            case 7:
                $string = self::getTranslation("july");
                $short = mb_substr($string, 0, 4);
                break;
            case 8:
                $string = self::getTranslation("august");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 9:
                $string = self::getTranslation("september");
                $short = mb_substr($string, 0, 4).'.';
                break;
            case 10:
                $string = self::getTranslation("october");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 11:
                $string = self::getTranslation("november");
                $short = mb_substr($string, 0, 3).'.';
                break;
            case 12:
                $string = self::getTranslation("december");
                $short = mb_substr($string, 0, 3).'.';
                break;
            default:
                $string = "<code>Error ! Bad month !</code>";
        }
        if($short == true)
        {
            return $short;
        } else {
            return $string;
        }
    }

    public static function getTranslation($string)
    {
        $lang = self::getLanguage();

        switch($lang)
        {
            case "en":
                $phrases = array(
                    // HTML allowed

                    // Top strip //
                    "register" => "Register",
                    "login" => "Login",
                    "search" => "Search...",
                    // Top strip //

                    //Itemshop - START
                    "isTitle" => "Item-Shop",
                    "isZeroCategories" => "Categories were not found.",
                    "isZeroItems" => "Items were not found in this category.",
                    "isBuy" => "Buy",
                    "isNotEnoughCoins" => "Not enough coins",
                    "isYourCoins" => "Your coins: ",
                    "isBuyCoins" => "<a href='".Links::getUrl("coins")."'>(BUY)</a>",
                    "isNotEmptyItemshopMall" => "Your itemshop warehouse is not empty. Item purchase failed.",
                    "isBuySuccess" => "Item(s) was successfully purchased. Item is in your ItemShop warehouse.",
                    "isVerifyAmount" => "Please verify amount of item: ",
                    "isSubmit" => "Let's buy",
                    "isNotValidQuantity" => "Not valid quantity",
                    "isNotValidRange" => "Invalid quantity. You can choose 1 - ",

                    //Premium
                    "isSilverActive" => "You have already silver premium until: ",
                    "isGoldActive" => "You have already gold premium until: ",
                    "isYangActive" => "You have already yang premium until: ",
                    "isActive" => "You have already activated premium.",
                    "isSilverSuccess" => "Silver premium successfully purchased.",
                    "isGoldSuccess" => "Gold premium successfully purchased.",
                    "isYangSuccess" => "Yang premium successfully purchased.",
                    "isPremiumSuccess" => "Premium successfully purchased.",
                    //Itemshop - END

                    //Search - START
                    "nothingFound" => "Nothing found...",
                    "playerFound" => "Player was found. Redirecting...",
                    //Search - STOP

                    // Server status + social links
                    "serverStatus" => "Check server status",
                    "service" => "Service",
                    "status" => "Status",
                    "online" => "Online",
                    "offline" => "Offline",
                    // Server status + social links

                    //News
                    "postedBy" => "Posted by",
                    "viewMore" => "View More",
                    "addComment" => "Add comment",
                    "zeroComments" => "<i>There are no comments.!</i>",
                    "writeComment" => "Write a comment",
                    "notLogged" => "<p>You need to login for commenting this news.</p>",
                    "publishAsField" => "Publish as: ",
                    "commentField" => "Comment: ",
                    "commentRange" => "Comment must have 3-1000 characters.",
                    "authorRange" => "Name must have 4-20 characters",
                    "commentAuthorError" => "Please choose valid name.",
                    "commentSuccess" => "Comment has been successfully submitted.",
                    "commentsDisabled" => "Coments are disabled",
                    "cannotChooseThisName" => "You cannot choose this name, because another registered user is using it.",
                    "publishedAnonym" => "Anonym",
                    "zeroNews" => "News were not found",
                    "clickOnViewMore" => "<b> ... click on view more for full news</b>",
                    //News

                    //Registration - START
                    "regTitle" => "Registration",
                    "regDisabled" => "Registration is currently disabled. Try later, please!",
                    "regDesc" => "Create your new account and became legend on our ".Core::getSiteTitle()." server.
                                    If you already have account, please <a href='".Links::getUrl('login')."'>login</a>",
                    "regAlphanumeric" => "Username must consist only of alphanumeric characters",
                    "regUsernameRange" => "Username must be between ".Registration::getUsernameMin()." and ".Registration::getUsernameMax()." characters.",
                    "regPasswordRange" => "Pasword must be unique and must be between ".Registration::getPasswordMin()." and ".Registration::getPasswordMax()." characters.",
                    "regPasswordNeedNumber" => "Password must contain at least one number.",
                    "regDeleteCode" => "Delete code must have excatly 7 characters and consists only of alphanumeric characters",

                    //Form
                    "regUsername" => "Username", // Used for login too
                    "regPassword" => "Password",
                    "regPasswordAgain" => "Password again",
                    "regEmail" => "Email address",
                    "regEnter" => "Enter",
                    "regDelete" => "Delete code",
                    "register" => "Register",
                    "regCaptcha" => "Enter the captcha code above",
                    "anotherCaptcha" => "Different captcha code",

                    //messages//
                    "fillInAllFields" => "Fill in all fields, please.",
                    "emailNotValid" => "Email is not valid.",
                    "pwDontMatchPw2" => "Password do not match.",
                    "captchaWong" => "You entered wrong captcha code.", // uses for login too
                    "weakPassword" => "The password you provided is very weak. Please choose another one.",
                    "usernameExists" => "Username already exists. Please choose another one.",
                    "emailExists" => "Email already exists. Please choose another one.",
                    "regSuccessful" => "You have been succsessfuly registred. You can download the client <a href='#'>here</a>",

                    //Registration - END

                    //Login - START
                    "loginTitle" => "Login",
                    "loginButton" => "Login",
                    "wrongData" => "You entered wrong data.",
                    "allFields" => "Enter all fields please.",
                    "alreadyLogged" => "You are already logged in.",

                    "pernamentBan" => "You have been pernament banned. Reason :",
                    "tempBan" => "You are banned until : ",
                    "reason" => "<br />Reason : ",
                    "unbanned" => "Your ban has expired. You can login now.",

                    "logged" => "You have been successfuly logged. You will be redirected now.",
                    //Login - END

                    //Team - START

                    //Team - END

                    //Forgotten password - START
                    "fpHint" => "Did you forget your password?",
                    "fpTitle" => "Forgotten password",
                    "fpDesc" => "If you've forgotten your password use this form to reset your password. Link for changing your password will be send to your email.",
                    "fpButton" => "Send password recovery request",
                    "fpCombinationNotFound" => "Combination was not found.",
                    "fpRequestExists" => "You have already got active request. Please check your email.",
                    "fpSuccess" => "Success. We have sent you instructions on your email. The link we've sent you is available only for 24 hours.",
                    "fpEmailTitle" => "Password recovery request",
                    "fpEmailText" => "<h1>Hello,</h1><br />We have noticed your password recovery request.<br />
                                    Click on the link below. Link is available for only 1 day.<br />URL: ",
                    "fpChangeTitle" => "Choose your password",
                    "fpChangeDesc" => "Changing password for account: ",
                    "fpChangeNewPassword" => "New password: ",
                    "fpChangeNewPasswordAgain" => "New password (again): ",
                    "fpChangeButton" => "Change password",
                    "fpChangeSuccess" => "Your password has been successfully changed. You can login now.",
                    //Forgotten password - END

                    //Account - START
                    "accountTitle" => "Your account",
                    "logoutTitle" => "Logout",
                    "logoutDesc" => "You have been successfully logout. You will be redirected.",
                    "accountButton" => "Account",
                    "logoutButton" => "Logout",

                    //Account - END

                    //Team - START
                    "tNoCategories" => "Team categories were not found !",
                    "tNoMembers" => "Team members were not found !",

                    "memberSince" => "Member since:",
                    "memberPosition" => "Position:",
                    "memberContact" => "Contact: ", // You can change to skype, icq, whatever
                    //Team - END

                    //Download - START
                    "dlTitle" => "Download",
                    "dlNothing" => "Download links were not added yet.",

                    //Table
                    "dlTableTitle" => "Title",
                    "dlTableDesc" => "Description",
                    "dlTableSize" => "Size",
                    "dlTableDownload" => "Download",
                    //Table

                    "dlAdded" => "Added : ", //This will show up only if description is omitted.
                    //Download - END

                    //Rankings - START

                    //Players
                    "playerRankTitle" => "Player rankings",
                    "playerRankOrder" => "#",
                    "playerRankKingdom" => "",
                    "playerRankName" => "Name",
                    "playerRankLevel" => "Level",
                    "playerRankChar" => "Race",
                    "playerRankGuild" => "Guild",
                    "playerRankInfo" => "Info",
                    "playerRankNoGuild" => " - ",

                    "playerRankNoPlayers" => "Players were not found !",

                    //Guilds
                    "guildRankTitle" => "Guilds ranking",
                    "guildRankNoGuilds" => "Guilds were not found !",
                    "guildRankOrder" => "#",
                    "guildRankName" => "Name",
                    "guildRankLevel" => "Level",
                    "guildRankMembers" => "Members",
                    "guildRankPoints" => "Points",
                    "guildRankInfo" => "Info",

                    //Rankings - END

                    //Player - START
                    "warrior" => "Warrior",
                    "ninja" => "Ninja",
                    "sura" => "Sura",
                    "shaman" => "Shaman",

                    "playerInfoTitle" => "Player info : ",
                    "playerInfoName" => "Name",
                    "playerInfoLevel" => "Level",
                    "playerInfoKingdom" => "Kingdom",
                    "playerInfoShinsoo" => "<span style='color:red;'>Shinsoo</span>",
                    "playerInfoChunjo" => "<span style='color:goldenrod;'>Chunjo</span>",
                    "playerInfoJinno" => "<span style='color:blue;'>Jinno</span>",
                    "playerInfoGameTime" => "Game time",
                    "playerInfoHours" => " hours",
                    "playerInfoLastPlay" => "Last play",
                    "playerInfoChar" => "Char",
                    "playerInfoExp" => "Exp",
                    "playerInfoGuild" => "Guild",
                    //Player - END

                    //User panel - START
                    "notLogged" => "You are not logged in.",
                    "userGreetings" => "Welcome, ",
                    "userInfo" => "Account info",
                    "userCoins" => "Buy coins",
                    "userEditAccount" => "Edit account",
                    "userChars" => "Your characters",
                    "userTicketSystem" => "Ticket system",
                    "userReferralSystem" => "Referral system",
                    //Account info
                    "accountInfoTitle" => "Account info",
                    "accountInfoUsername" => "Username: ",
                    "accountInfoEmail" => "Email: ",
                    "accountInfoLastIP" => "Last logged IP: ",
                    "accountInfoCoins" => "Coins: ",
                    "accountInfoDeleteCode" => "Delete code: ",
                    "accountInfoDCHidden" => "hidden ( <a href='".Links::getUrl('account send-delcode')."'>SEND ON EMAIL</a> )",
                    "accountInfoWarehousePassword" => "Warehouse password: ",
                    "accountInfoWarehouseHidden" => "hidden ( <a href='".Links::getUrl('account send-warehouse-pw')."'>SEND ON EMAIL</a> )",
                    "accountInfoCreated" => "Account created: ",
                    "accountInfoPremiumGold" => "Gold Premium: ",
                    "accountInfoPremiumSilver" => "Silver Premium: ",
                    "accountInfoPremiumYang" => "Yang Premium: ",
                    "accountInfoPremiumActive" => "Yes - until : ",
                    "accountInfoPremiumNotActive" => "No",

                    //Coins
                    "coinsTitle" => "Coins",
                    "couponsTitle" => "Coupons",
                    "couponDesc" => "If you have obtain any coupon code, you can use it here. You will get certain amount of coins
                    if the coupon code is correct and was not used yet.",
                    "couponCode" => "Coupon code: ",
                    "applyCoupon" => "Apply coupon",
                    "couponNotValid" => "Coupon is not valid",
                    "couponAlreadyUsed" => "Coupon has been already used",
                    "couponApplied" => "Coupon was successfully applied and you have received: ",
                    "couponCoins" => " coins",
                    "paysafecard" => "Paysafecard",
                    "psc_pin" => "Paysafecard pin (without dashes)",
                    "submit_psc" => "Submit paysafecard pin",
                    "psc_pin_error" => "Paysafecard pin has wrong format. It must contain only numbers (without dashes) and length must be exactly 16.",
                    "processingPscPinExists" => "You have already submitted one paysafecard pin that has not been checked by admin yet.
                    Please wait until admin verify your pin.",
                    "pscSubmitted" => "Paysafecard pin has been submitted. Please be patient now.
                    You have to wait until admin verify your pin.",
                    "last5Pins" => "Last 5 submitted pins:",
                    "pin" => "Pin",
                    "allowed" => "ALLOWED",
                    "denied" => "DENIED",
                    "delete" => "[delete]",
                    "pinDeleted" => "Paysafecard pin has been deleted.",
                    "confirmDenyPSC" => "Do you really want to deny this PSC ?",
                    "confirmDenyAmazon" => "Do you really want to deny this amazon code ?",
                    "confirmAllowPSC" => "Do you really want to allow this PSC and add coins to the user ?",
                    "confirmAllowAmazon" => "Do you really want to allow this amazon code and add coins to the user ?",
                    "PSCHowManyCoins" => "How many coins will user get ?",
                    "cannotNegativeCoins" => "Number of coins must be greater then 0.",
                    "PSCSuccess" => "You have successfully added coins to this user. Status of this PSC pin has been set as 'allowed'.",
                    "amazonSuccess" => "You have successfully added coins to this user. Status of this amazon code has been set as 'allowed'.",
                    "PSCDenied" => "PSC status has been set as 'denied'.",
                    "amazonDenied" => "Amazon code status has been set as 'denied'.",
                    "amazonCode" => "Amazon code",
                    "processingAmazonCodeExists" => "You have already submitted one amazon code that has not been checked by admin yet.",
                    "amazonCodeSubmitted" => "Amazon code has been submitted. Please be patient now. Admin must check the code manually.",
                    "submitAmazonCode" => "Submit amazon code",
                    "amazonCodeDeleted" => "Amazon code has been deleted.",
                    "last5AmazonCodes" => "Last 5 submitted amazon codes",
                    "paypal" => "Paypal",
                    "choosePlease" => "Choose please:",
                    "payWithPaypal" => "Pay with paypal",


                    //Send delete code
                    "sendDCTitle" => "Send delete code",
                    "sendDCHasBlock" => "You have performed this action in recent time.<br />We can send you delete code on your email
                    in :",
                    "sendDCEmailTitle" => "Your delete code",
                    "sendDCEmailText" => "<h1>Hello,</h1><br />We have noticed your request for delete code.<br />
                    Your delete code is : ",
                    "sendDCSuccess" => "Delete code has been successfully sent to your email.",

                    //Send delete code
                    "sendWarehouseTitle" => "Send warehouse password",
                    "sendWarehouseHasBlock" => "You have performed this action in recent time.<br />We can send you warehouse password on your email
                    in :",
                    "sendWarehousePasswordMailTitle" => "Your warehouse password",
                    "sendWarehouseMailText" => "<h1>Hello,</h1><br />We have noticed your request for warehouse password.<br />
                    Your warehouse password is : ",
                    "sendWarehousePasswordSuccess" => "Warehouse password has been successfully sent to your email.",

                    //Edit account
                    "editAccountTitle" => "Edit account",
                    "editAccountChangePW" => "Change account password",
                    "editAccountChangePWMailVerificationInfo" => "We will send you verification code on your email for changing your password.
                    The code will be available for 2 hours.",
                    "editAccountChangePWMailContinue" => "Continue",
                    "editAccountChangePWMailTitle" => "Change account password",
                    "editAccountChangePWMailText" => "<h1>Hello,</h1><br />We have noticed your request for changing password.<br />
                    Verification code is available for 2 hours.<br />Verification code is : ",
                    "editAccountChangePWMailNotSent" => "We have send you last email at : ",
                    "editAccountChangePWNextMail" => "<br />We can't send you another email for security issues until : ",
                    "editAccountChangePWEmailCode" => "Verification code (from email)",
                    "editAccountChangePWOldPW" => "Old password",
                    "editAccountChangePWNewPW" => "New password",
                    "editAccountChangePWNewPWAgain" => "New password (again)",
                    "editAccountChangePWButton" => "Change password",
                    "editAccountChangePWVerificationCodeNotValid" => "Verification code is not valid.",
                    "editAccountChangePWOldPWisWrong" => "Old ( current ) password is not correct.",
                    "editAccountChangePWSuccess" => "Password has been successfully changed.",
                    "editAccountChangePWHasBlock" => "You have performed this action in recent time.<br />You can change your password in:",
                    "changeWarehousePasswordTitle" => "Change warehouse password",
                    "changeWarehousePasswordRange" => "Warehouse password must be alphanumeric and have exactly 6 characters.",
                    "changeWarehousePasswordOld" => "Old password (do not enter, if is default)",
                    "changeWarehousePasswordNew" => "New password",
                    "changeWarehousePasswordNewAgain" => "New password (again)",
                    "changeWarehousePasswordButton" => "Change password",
                    "changeWarehousePasswordOldNotValid" => "Old password is not valid.",
                    "changeWarehousePasswordNotAlphanumeric" => "Password is not alphanumeric.",
                    "changeWarehousePasswordNot6Chars" => "Password don't have 6 characters.",
                    "changeWarehousePasswordNotMatch" => "Password verification failed.",
                    "changeWarehousePasswordHasBlock" => "You have performed this action in recent time.<br />You can change your warehouse password in:",
                    "changeWarehousePasswordSuccess" => "Warehouse password has been successfully changed.",
                    "changeEmailTitle" => "Change email",
                    "changeEmailDisabled" => "Change email is not possible at this time.",
                    "changeEmailVerificationInfo" => "We will send you verification code on your email for changing your
                                                        email address associated with this account.",
                    "changeEmailContinueButton" => "Continue",
                    "changeEmailOldEmail" => "Old email address",
                    "changeEmailYourPassword" => "Your password",
                    "changeEmailNewEmail" => "New email address",
                    "changeEmailNewEmailAgain" => "New email address (again)",
                    "changeEmailButton" => "Change email",
                    "changeEmailHasBlock" => "You have performed this action in recent time.<br />You can change your email in: ",
                    "changeEmailBadOldEmail" => "Old (current) email is not correct.",
                    "changeEmailBadPassword" => "Password is not correct.",
                    "changeEmailBadFormat" => "Email address has not valid format",
                    "changeEmailAlreadyExists" => "You cant use this email. This email is already using another user.",
                    "changeEmailNotMatch" => "Emails don't match.",
                    "changeEmailSuccess" => "Email has been successfully changed.",
                    "changeEmailMailNotSent" => "We have send you last email at : ",
                    "changeEmailNextMail" => "<br />We can't send you another email for security issues until : ",
                    "changeEmailMailTitle" => "Change email",
                    "changeEmailMailText" => "<h1>Hello,</h1><br />We have noticed your request for changing email.<br />
                    Verification code is available for 2 hours.<br />Verification code is : ",
                    "changeEmailVerificationCode" => "Verification code (from email)",
                    "changeEmailVerificationCodeNotCorrect" => "Verification code is not correct.",

                    //Characters
                    "charsTitle" => "My characters",
                    "charsNoChars" => "You have not created any character yet.",
                    "charsDebugInfo" => "If you are stuck in map, use 'debug' function near your character name.<br />
                    You have to be at least 5 minutes disconencted from server for using debug function.",
                    "charsDebugButton" => "debug",
                    "charsDebugHasBlock" => "You have performed this action in recent time.<br />
                                        You can debug your character in: ",
                    "charDebugNotDisconnected" => "You cannot use debug because u are not disconnected more then 10 minutes.<br />
                                                If you disconnect right now, you can use debug in: ",
                    "charDebugSuccess" => "Your character has been successfully debuged. Please wait now 5 minutes before you login.",

                    //Ticket system
                    "ticketSysTitle" => "Ticket system",
                    "ticketSysNotEnabled" => "Ticket system is not enabled.",
                    "ticketSysCreate" => "Create new ticket",
                    "ticketSysView" => "View your tickets",
                    "ticketSysAddHasBlock" => "You have performed this action in recent time.<br />
                                                You can create new ticket in: ",
                    "ticketSysAddSubject" => "Subject",
                    "ticketSysAddSubjectDesc" => "Please choose short phrase that describe your problem...",
                    "ticketSysAddCategory" => "Choose the category",
                    "ticketSysCategoriesNotFound" => "Categories not found.",
                    "ticketSysAddText" => "Text ( what is the problem? )",
                    "ticketSysSubjectRange" => "Subject must be 5-30 characters.",
                    "ticketSysInvalidCategory" => "Invalid category",
                    "ticketSysTextRange" => "Text must be 15-2000 characters",
                    "ticketSysAddSuccess" => "Ticket has been successfully created. We will answer you as soon as possible.",
                    "ticketSysNoTickets" => "You have not created any ticket yet.",
                    "ticketSysStatus" => "Status",
                    "ticketSysStatusOpen" => "<span style='color:dodgerblue;'>Open</span>",
                    "ticketSysStatusClosed" => "<span style='color:indianred;'>Closed</span>",
                    "ticketSysStatusProcessing" => "<span style='color:green'>In Processing</span>",
                    "ticketSysUser" => "User",
                    "ticketSysCategory" => "Category",
                    "ticketSysNoAnswers" => "There are not any answers.",
                    "ticketSysAdminAnswered" => "Administrator answered:",
                    "ticketSysAnswered" => " answered:",
                    "ticketAddAnswer" => "Add answer",
                    "ticketAnswer" => "Answer:",
                    "ticketAnswerRange" => "Answer must have 5-2000 characters.",
                    "ticketAnswerHasBlock" => "You have performed this action in recent time. You can add answer in: ",
                    "ticketAnswerClosed" => "Ticket has been closed.",
                    "ticketAnswerSuccess" => "Answer has been successfully added.",
                    "ticketInfoTitle" => "Ticket info",

                    //Referral system
                    "referralSysTitle" => "Referral system",
                    "referralSysIntroduce" => "Referral system is great thing. You can get really cool ingame items for almost nothing.<br />
                                                All you need is to invite your friend/s. Read more below...",
                    "referralSysHowDoesItWork" => "How does it work ?",
                    "referralSysHowDoesItWorkDesc" => "Simply.<br />Just send your unique link to your friend: ",
                    "referralSysHowDoesItWorkDesc2" => "When your friend register with this link you will receive rewards.",
                    "referralSysWhichRewards" => "Which rewards will i get?",
                    "referralSysRP" => "Referral points: ",
                    "referralSysRPShort" => "RP",
                    "referralSysRewards" => "You will receive <b>referral points</b> (RP) as reward.
                    <br />You can use these RP in <a href='".Links::getUrl('referral-shop')."'>referral shop</a>.",
                    "referralSysLimit" => "You can still invite: ",
                    "referralSysLimitFriends" => " friends",
                    "referralSysHowManyRB" => "How many referral points (RB) will i get?",
                    "referralSysRewardInfo" => "If your friend reach ",
                    "referralSysRewardInfo2" => " level, you will get ",
                    "referralSysInvitedFriends" => "Invited friends",
                    "referralSysNotReferrals" => "You have not invited any of your friends yet.",
                    "referralSysUsername" => "User",
                    "referralSys1" => Referral::getLevel(1).". lvl",
                    "referralSys2" => Referral::getLevel(2).". lvl",
                    "referralSys3" => Referral::getLevel(3).". lvl",
                    "referralSys4" => Referral::getLevel(4).". lvl",
                    "referralSys5" => Referral::getLevel(5).". lvl",
                    "referralSys6" => Referral::getLevel(6).". lvl",
                    "referralSys7" => Referral::getLevel(7).". lvl",
                    "referralSys8" => Referral::getLevel(8).". lvl",
                    "referralSys9" => Referral::getLevel(9).". lvl",
                    "referralSys10" => Referral::getLevel(10).". lvl",
                    "referralSysYourRB" => "Your RB: ",
                    "referralRewards" => "Referral rewards",
                    "referralRewardsNotFound" => "Rewards not found.",
                    "referralRewardName" => "Name",
                    "referralRewardDesc" => "Description",
                    "referralRewardImg" => "Image",
                    "referralRewardPrice" => "Price",
                    "referralRewardAction" => "Action",
                    "referralRewardBuy" => "Buy",
                    "referralRewardNotEnoughPoints" => "Not enough referral points.",
                    "referralRewardSuccess" => "Item was successfully added into your itemshop warehouse.",



                    "userLogout" => "Logout",
                    //User panel - END

                    //Panel addons - START
                    "rankingsTitle" => "TOP 5",
                    "rankingsPlayers" => "Players",
                    "rankingsLVL" => "LVL",
                    "rankingsGuild" => "Guilds",

                    "statisticsTitle" => "Statistics",
                    "statisticsAccounts" => "Accounts",
                    "statisticsPlayers" => "Players",
                    "statisticsOnlinePlayers" => "Online players",
                    "statisticsMaxLevel" => "Max level",
                    //Panel addons - END

                    //Maintenance - START
                    "maintenanceTitle" => "Maintenance",
                    //Maintenance- END

                    //Administration - START
                    "administration" => "Administration",
                    "loginTitle" => "Login",
                    "loginToContinue" => "Login to continue...",
                    "youAreNotAdmin" => "You are not administrator !",

                    //Tasks
                    "pendingTasks" => "You have ".Tasks::count(true)." pending tasks.",
                    "viewAllTasks" => "See all tasks",

                    //Tickets
                    "pendingTickets" => "You have ".TicketSystem::pendingTickets()." unanswered tickets.",
                    "viewAllTickets" => "See all tickets",

                    //Notifications
                    "newNotifications" => "You have ".Notifications::count()." new notifications.",
                    "errorFound" => "Web error occurred",
                    "userAnsweredTicket" => "User answered ticket",

                    //Me
                    "profileMe" => "Me",

                    //Menu
                    "dashboard" => "Dashboard",
                    "news" => "News",
                    "addNews" => "Add news",
                    "viewNews" => "View all news",
                    "settings" => "Settings",
                    "ticketSystem" => "Ticket system",
                    "players" => "Players",
                    "newsSettings" => "Settings",
                    "newsComments" => "Comments",
                    "downloads" => "Downloads",
                    "addDownload" => "Add download",
                    "viewDownloads" => "View downloads",
                    "teamMembers" => "Team members",
                    "viewTeamMember" => "View all members",
                    "addTeamMember" => "Add team member",
                    "addCategory" => "Add category",
                    "viewCategories" => "View categories",
                    "viewOpenTickets" => "View tickets",
                    "ticketCategories" => "Categories",
                    "viewItems" => "View items",
                    "addItem" => "Add item",
                    "paysafecardPins" => "Paysafecard pins",
                    "amazonCodes" => "Amazon codes",
                    "paypalSettings" => "Paypal",
                    "administrators" => "Administrators",
                    "viewGameAdministrators" => "View game admins",
                    "viewWebAdministrators" => "View web admins",
                    "addGameAdmin" => "Add game admin",
                    "addWebAdmin" => "Add web admin",
                    "tasks" => "Tasks",
                    "viewTasks" => "View tasks",
                    "addTask" => "Add task",
                    "referralSystem" => "Referral system",
                    "rewards" => "Rewards",
                    "templateContent" => "Template content",
                    "customPages" => "Custom pages",
                    "menuLinks" => "Menu links",
                    "statusServer" => "Server status",
                    "slider" => "Slider",
                    "partners" => "Partners",
                    "footerBox" => "Footer box",
                    "panels" => "Panels",
                    "game" => "Players",
                    "viewPlayers" => "View players",
                    "viewBanList" => "View ban list",
                    "logs" => "Logs",
                    "logChat" => "Chat log",
                    "logCommand" => "Command log",
                    "logShout" => "Shout log",
                    "logHack" => "Hack log",
                    "logBan" => "Ban log",
                    "logGameChat" => "GM chat log",
                    "logGameCommand" => "GM command log",
                    "logHackLog" => "Hack log",
                    "logShoutLog" => "Shout log",
                    "logChangeEmail" => "Change email log",
                    "logChangePW" => "Change password log",
                    "logWarehousePW" => "Change warehouse password log",
                    "logCoupons" => "Coupons log",
                    "logItemshop" => "Itemshop log",
                    "logPasswordRecovery" => "Password recovery log",
                    "logReferral" => "Referral rewards log",
                    "logPaypal" => "Paypal log",
                    "Configuration" => "Configurations",
                    "mainConfiguration" => "Main config",
                    "registerConfiguration" => "Register config",
                    "otherConfig" => "Other config",

                    //Dashboard
                    "home" => "Home",
                    "dashBoard" => "Dashboard",
                    "regUsers" => "Registered users",
                    "guilds" => "Guilds",
                    "tickets" => "Tickets",
                    "onlinePlayers" => "Online players: ",
                    "workProgress" => "Work progress",

                    //Web application error
                    "webApplicationError" => "Web application error",
                    "error" => "Error log",
                    "errorLogIsClear" => "Error log is clear...",
                    "clearLog" => "Clear log",

                    //Search
                    "searchHint" => "You can search Accounts, Players, IP addresses...",
                    "accountsNotFound" => "Accounts with this username were not found.",
                    "playersNotFound" => "Players with this name were not found.",
                    "account" => "Account",
                    "accounts" => "Accounts",
                    "emails" => "Emails",
                    "accountIP" => "Account IP addresses",

                    //Custom pages
                    "pageUpdated" => "Page has been updated.",
                    "pageAdded" => "Page has been successfully created.",
                    "rangeTitleError" => "Title range must be 1-50 characters.",
                    "addToMenu" => "Add link to the menu",
                    "createNewPage" => "Create new page",
                    "pageDeleted" => "Page has been deleted. Don't forget to delete link from menu.",

                    //Logs
                    "message" => "Message",
                    "command" => "Command",
                    "server" => "Server",
                    "username" => "Username",
                    "oldEmail" => "Old email",
                    "newEmail" => "New email",
                    "oldPw" => "Old password",
                    "newPw" => "New password",
                    "couponID" => "Coupon ID",
                    "itemName" => "Item name",
                    "itemID" => "Item ID",
                    "price" => "Price",
                    "token" => "Token",
                    "enterName" => "Enter name",
                    "payed" => "Payed",
                    "currency" => "Currency",
                    "paypalName" => "Name",
                    "email" => "Email",


                    //Players
                    "banned" => "Banned",
                    "ok" => "OK",
                    "banAccount" => "Ban account",
                    "unbanAccount" => "Unban account",
                    "created" => "Created",
                    "coins" => "Coins",
                    "lastPlay" => "Last time active",
                    "referrer" => "Referrer",
                    "rPoints" => "Referral points",
                    "registerIP" => "Register IP",
                    "lastIP" =>"Last IP",
                    "safeboxExpireAdmin" => "Safebox_expire",
                    "goldExpireAdmin" => "Gold_expire",
                    "silverExpireAdmin" => "Silver_expire",
                    "autolootExpireAdmin" => "Autoloot_expire",
                    "fishExpireAdmin" => "Fish_expire",
                    "marriageExpireAdmin" => "Marriage_expire",
                    "moneyExpireAdmin" => "Money_expire",
                    "banReason" => "Ban reason",
                    "length" => "Length (minutes)",
                    "userBanned" => "User has been banned.",
                    "userUnbanned" => "User has been unbanned.",
                    "userBannedUntil" => "User is banned until: ",
                    "editCoins" => "Edit coins",
                    "amount" => "Amount",
                    "add" => "Add",
                    "remove" => "Remove",
                    "type" => "Type",
                    "coinsUpdated" => "User coins were updated.",
                    "editRP" => "Edit RP",
                    "rpUpdated" => "User referral points were updated.",
                    "noCharacters" => "User haven't created character yet.",
                    "accountChars" => "User characters",
                    "bannedDate" => "Banned",
                    "banExpire" => "Expire",
                    "ban" => "Ban",
                    "unban" => "Unban",
                    "userNotBannedYet" => "User haven't been banned yet.",
                    "userBanLog" => "User ban log",

                    //Configuration
                    "siteTitle" => "Site title",
                    "headerTitle" => "Header title",
                    "headerSlogan" => "Header slogan",
                    "language" => "Language (do not change if you didn't edit Language.class.php)",
                    "enableSlider" => "Enable/Disable slider",
                    "fbLink" => "Facebook link (leave empty if your server don't have one)",
                    "twitterLink" => "Twitter link (leave empty if your server don't have one)",
                    "ytbLink" => "Youtube link (leave empty if your server don't have one)",
                    "twitchLink" => "Twitch link (leave empty if your server don't have one)",
                    "enablePartners" => "Enable/Disable partners(logo) panel",
                    "enableFooterBox" => "Enable/Disable footer box",
                    "footerText" => "Footer",
                    "enableRegister" => "Enable/Disable register",
                    "minPWLength" => "Min. password length",
                    "maxPWLength" => "Max. password length",
                    "minNameLength" => "Min. username length",
                    "maxNameLength" => "Max. username length",
                    "pwNeedNumber" => "Password must contain number",
                    "enableWeakPasswordProtection" => "Enable/Disable weak password protection",
                    "weakPasswords" => "Weak passwords (separate by comma)",
                    "enableCaptcha" => "Enable/Disable captcha",
                    "leaveEmpty" => "Leave empty if you want to disable",
                    "safeboxExpire" => "Safebox_expire (how many days)",
                    "goldExpire" => "Gold_expire (how many days)",
                    "silverExpire" => "Silver_expire (how many days)",
                    "autolootExpire" => "Autoloot_expire (how many days)",
                    "fishExpire" => "Fish_expire (how many days)",
                    "marriageExpire" => "Marriage_expire (how many days)",
                    "moneyExpire" => "Money_expire (how many days)",
                    "startCoins" => "Start coins",
                    "loginCaptchaAttempts" => "After how many fail login attempts will show captcha up",
                    "dateFormat" => "Date format",
                    "enablePlayerInfo" => "Enable player info",
                    "playersPerPage" => "Players/Guilds in rankings per page",
                    "prefixDontShow" => "Prefixes - don't show players in rankings with these prefixes<br />(separate by comma)",
                    "deleteCodeShow" => "Delete code",
                    "classicShow" => "Show normal",
                    "mailSendShow" => "Send on user email",
                    "enableCoupon" => "Enable/Disable coupon system",
                    "couponLog" => "Enable/Disable coupon log",
                    "mailType" => "Email type",
                    "mailNormal" => "Normal - php function",
                    "mailSMTP" => "SMTP server",
                    "serverEmail" => "Server email address",
                    "serverEmailName" => "Server name (in email)",
                    "smtpProtocol" => "SMTP protocol",
                    "smtpHost" => "SMTP hostname",
                    "smtpPort" => "SMTP port",
                    "smtpUser" => "SMTP username",
                    "smtpPw" => "SMTP password",
                    "actionSpamPenalty" => "How often can user perform actions [minutes]",
                    "changePWType" => "How will user change password",
                    "changePWNormal" => "Without email verification code",
                    "changePWMail" => "With email verification code",
                    "warehousePassword" => "Warehouse password",
                    "changePWLog" => "Enable/Disable user password change log",
                    "changeWarehouseLog" => "Enable/Disable user warehouse password change log",
                    "userCanChangeMail" => "Users can change email",
                    "changeEmailType" => "How will user change email",
                    "emailChangeLog" => "Enable/Disable user email change log",
                    "waitBeforeDebug" => "How many minutes need to user wait after logout from game before debug",
                    "shinsoDebugMap" => "Shinsoo debug map index",
                    "chunjoDebugMap" => "Chunjo debug map index",
                    "jinnoDebugMap" => "Jinno debug map index",
                    "shinsoDebugX" => "Shinsoo debug coor X",
                    "chunjoDebugX" => "Chunjo debug coor X",
                    "jinnoDebugX" => "Jinno debug coor X",
                    "shinsoDebugY" => "Shinsoo debug coor Y",
                    "chunjoDebugY" => "Chunjo debug coor Y",
                    "jinnoDebugY" => "Jinno debug coor Y",
                    "enableTicketSystem" => "Enable/Disable ticket system",
                    "enablePasswordRecoveryLog" => "Enable/Disable user password recovery log",
                    "enableMaintenance" => "Enable/Disable maintenance",
                    "maintenanceText" => "Maintenance text",
                    "enableReferralLog" => "Enable/Disable referral log",
                    "enableItemshopLog" => "Enable/Disable itemshop log",
                    "configUpdated" => "Configuration has been updated.",


                    //Server stats
                    "ip" => "IP Address",
                    "port" => "Port",
                    "addNewService" => "Add new service",
                    "serverServiceDeleted" => "Server service was deleted.",
                    "serverServiceAdded" => "Server service successfully added.",
                    "serverServiceUpdated" => "Server service has been updated.",

                    //Panels
                    "active" => "Active(visible)",
                    "addPanel" => "Add new panel",
                    "panelUpdated" => "Panel has been updated.",
                    "panelDeleted" => "Panel has been deleted.",
                    "yes" => "Yes",
                    "no" => "No",
                    "panelAdded" => "Panel has been successfully added.",

                    //Footer box
                    "contentHtml" => "Content (you can use HTML)",
                    "footerBoxUpdated" => "Footer box updated.",

                    //Partners
                    "addPartner" => "Add new partner",
                    "altDesc" => "Alt (description)",
                    "imgUrl" => "Image (URL)",
                    "partnerDeleted" => "Partner logo has been deleted.",
                    "partnerUpdated" => "Partner logo has been updated.",
                    "openInNewWindow" => "Open in new window",
                    "partnerAdded" => "Partner logo has been added.",

                    //Slider
                    "addNewSliderItem" => "Add new slider item",
                    "youHaveToUploadImage" => "You have to upload image.",
                    "sliderAdded" => "Slider item has been successfully added.",
                    "sliderUpdated" => "Slider has been successfully updated.",
                    "sliderDeleted" => "Slider has been deleted.",

                    //Links
                    "visible" => "Visible",
                    "link" => "Link",
                    "parentLink" => "Parent link",
                    "linkDeleted" => "Link has been deleted.",
                    "canNotDelete" => "You can not delete this link, because its a part of system. You can only make this link invsibile.",
                    "addLink" => "Add new link",
                    "nothing" => "- NOTHING -",
                    "invalidParent" => "Invalid parent...",
                    "linkAdded" => "Link has been successfully added.",
                    "linkUpdated" => "Link has been updated.",

                    //Referral system
                    "refEnableDisable" => "Enable/Disable referral system",
                    "logEnableDisable" => "Enable/Disable referral log",
                    "rewardDeleted" => "Referral reward has been deleted.",
                    "rewardsPerPage" => "Rewards per page",
                    "rewardAdded" => "Reward has been successfully added.",
                    "rewardUpdated" => "Reward has been successfully updated.",
                    "addReward" => "Add reward",
                    "referralLimit" => "How many friends can user invite",
                    "priceRP" => "Price (RP)",
                    "perPageError" => "Result per page cannot be less then 0.",
                    "limitError" => "Limit cannot be less then 0.",
                    "goal1EnableDisable" => "Enable/Disable 1st goal",
                    "goal2EnableDisable" => "Enable/Disable 2nd goal",
                    "goal3EnableDisable" => "Enable/Disable 3rd goal",
                    "goal4EnableDisable" => "Enable/Disable 4th goal",
                    "goal5EnableDisable" => "Enable/Disable 5th goal",
                    "goal6EnableDisable" => "Enable/Disable 6th goal",
                    "goal7EnableDisable" => "Enable/Disable 7th goal",
                    "goal8EnableDisable" => "Enable/Disable 8th goal",
                    "goal9EnableDisable" => "Enable/Disable 9th goal",
                    "goal10EnableDisable" => "Enable/Disable 10th goal",
                    "goal1Level" => "Goal - level (player must reach this level to get reward)",
                    "goal1Reward" => "Goal - reward (RP)",

                    //Tasks
                    "taskDeleted" => "Task was deleted.",
                    "added" => "Added",
                    "markAsDone" => "Do you really want to mark this task as done ?",
                    "taskDone" => "Task was marked as done. Good job.",
                    "percentFinished" => "Percent finished",
                    "youMustFillInAllFields" => "You must fill in all fields.",
                    "invalidPercent" => "Percent must be in range 0-100 ...",
                    "taskAdded" => "Task was successfully added.",
                    "editTask" => "Edit task",
                    "taskNotExists" => "Task with this ID doesn't exist.",
                    "taskUpdated" => "Task was updated.",

                    //Administrators
                    "authority" => "Authority",
                    "gameAdminDeleted" => "Game admin has been deleted.",
                    "webAdminDeleted" => "Web admin has been deleted.",
                    "usernameAccount" => "Username (account)",
                    "contactIP" => "Contact IP (do not change if u don't know what it is)",
                    "accountNotExists" => "This username (account) doesn't exists.",
                    "playerNotExists" => "This player doesn't exists.",
                    "gameAdminAdded" => "Game admin has been successfully added.",
                    "editGameAdmin" => "Edit game admin",
                    "reset" => "Reset",
                    "adminNotFound" => "Admin was not found.",
                    "adminUpdated" => "Admin has been updated.",
                    "rights" => "Rights",
                    "adminSince" => "Admin since",
                    "userIsAlreadyAdmin" => "This user is already admin.",
                    "editWebAdmin" => "Edit web admin",
                    "webAdminAdded" => "Web admin has been added.",
                    "checkAll" => "Check all",
                    "adminViewTasks" => "View tasks",
                    "adminViewNotifications" => "View notifications",
                    "adminAddNews" => "Add news",
                    "adminViewNews" => "View news",
                    "adminEditNewsSettings" => "Edit news settings",
                    "adminDeleteComments" => "Delete comments",
                    "adminEditNews" => "Edit news",
                    "adminDeleteNews" => "Delete news",
                    "adminViewDownloads" => "View downloads",
                    "adminAddDownloads" => "Add downloads",
                    "adminEditDownloads" => "Edit downloads",
                    "adminDownloadSettings" => "Edit download settings",
                    "adminDeleteDownloads" => "Delete downloads",
                    "adminViewTeamMembers" => "View team members",
                    "adminAddTeamMember" => "Add team member",
                    "adminEditTeamMember" => "Edit team member",
                    "adminDeleteTeamMember" => "Delete team member",
                    "adminTeamCategory" => "Add/edit/remove team member category",
                    "adminViewTickets" => "View tickets",
                    "adminAnswerTickets" => "Answer tickets",
                    "adminCloseTicket" => "Close/Reopen tickets",
                    "adminTicketCategory" => "Add/edit/remove ticket category",
                    "adminEditTicketSettings" => "Edit ticket settings",
                    "adminViewItemshop" => "View itemshop items and category",
                    "adminAddItemshop" => "Add itemshop items and category",
                    "adminEditItemshop" => "Edit itemshop items and category",
                    "adminDeleteItemshop" => "Delete itemshop items and category",
                    "adminEditItemshopSettings" => "Edit itemshop settings",
                    "adminCoupons" => "Add/delete coupons",
                    "adminViewCoupons" => "View coupons",
                    "adminViewGameAdmins" => "View game admins",
                    "adminViewWebAdmins" => "View web admins",
                    "adminGameAdmins" => "Add/edit/delete game admins",
                    "adminWebAdmins" => "Add/edit/delete web admins",
                    "adminEditTasks" => "Add/edit/delete tasks",
                    "adminEditReferralSystem" => "Edit referral system",
                    "adminTemplateContent" => "Add/edit/delete template content (server status, footer box, partners, panels, links, slider)",
                    "adminGame" => "Edit players / Search",
                    "adminLogs" => "Access logs",
                    "adminConfiguration" => "Configurations",

                    //Itemshop
                    "itemDeleted" => "Item was deleted.",
                    "editItem" => "Edit item",
                    "itemVnum" => "Item vnum",
                    "chooseType" => "Choose type: ",
                    "classicItem" => "Classic item",
                    "premium" => "Premium",
                    "quantity" => "Quantity",
                    "description" => "Description",
                    "userCanChooseQuantity" => "User can choose quantity (make sure the item is stackable)",
                    "maxQuantity" => "Max. quantity user can choose",
                    "enableDisableTimeLimit" => "Enable/Disable time limit",
                    "timeLimitInSeconds" => "Time limit (seconds)",
                    "enableSocket0" => "Enable/Disable socket0 (stone slot)",
                    "enableSocket1" => "Enable/Disable socket1 (stone slot)",
                    "enableSocket2" => "Enable/Disable socket2 (stone slot)",
                    "averageDamage" => "Addon type -1 (average damage)",
                    "emptyErrorIsAddItem" => "Name, item vnum, quantity and price cannot be empty.",
                    "quantityMustBeGreaterThenZero" => "Quantity must be greater then 0.",
                    "itemAdded" => "Item was successfully added.",
                    "selectType" => "Select type",
                    "silverPremium" => "Silver premium",
                    "goldPremium" => "Gold premium",
                    "yangPremium" => "Yang premium",
                    "premiumAll" => "Silver premium + Gold premium + Yang premium",
                    "howManyDays" => "How many days",
                    "nameCannotBeEmpty" => "Name cannot be empty.",
                    "invalidPremiumType" => "Invalid premium type.",
                    "invalidPremiumDuration" => "Invalid premium duration (in days). Must be greater then 0.",
                    "premiumItemUpdated" => "Premium item successfully updated.",
                    "itemUpdated" => "Item was successfully updated.",
                    "cannotDeleteCategoryItemsExist" => "You cannot delete this category because it contains items.",
                    "itemsPerPage" => "Items per page",
                    "enableDisableISLog" => "Enable/Disable IS log",
                    "isCurrency" => "IS Currency",
                    "isDiscountEnableDisable" => "Discount action - enable/disable",
                    "discountPercent" => "Discount percent",
                    "discountUntil" => "Discount until (YEAR/MONTH/DAY)<br />Hour and Mins will be automatically set to 00:00 (midnight)",
                    "itemsPerPageInvalid" => "Items per page invalid. It must be greater then 0.",
                    "coinsColumn" => "Coins column in database (do not change)",
                    "invalidDiscountUntil" => "Invalid discount until date. You have to enter newer date then today's one.",
                    "ISSettingsUpdated" => "Item Shop settings successfully updated.",
                    "coupons" => "Coupons",
                    "coupon" => "Coupon",
                    "couponDeleted" => "Coupon was deleted.",
                    "value" => "Value",
                    "used" => "Used",
                    "notUsed" => "Not used",
                    "addNewCoupon" => "Add new coupon",
                    "youCanGenerateCoupon" => "You can simply generate coupon or choose your own",
                    "iWantToAutomaticallyGenerateCoupon" => "I want to automatically generate coupon",
                    "iWantToChooseOwnCoupon" => "I want to choose my own coupon",
                    "messageCoupon" => "Message that will show up to user, when he successfully activate coupon<br />(not required)",
                    "valueCoins" => "Value (coins)",
                    "couponError1" => "You wanted to generate coupon automatically but entered your own coupon name. Please choose only one of options.",
                    "couponError2" => "Please choose coupon that will have at least 5 characters.",
                    "couponError3" => "Value field can not be empty and can not be less then 0.",
                    "couponError4" => "This coupon is already in database. Please choose another one.",
                    "couponAdded" => "Coupon successfully added.",
                    "paysafecardEnabledDisabled" => "Enable/Disable paysafecard payment for coins",
                    "amazonEnabledDisabled" => "Enable/Disable amazon payment for coins",
                    "paypalEnabledDisabled" => "Enable/Disable paypal payment for coins",
                    "zeroPins" => "There are not any paysafecard pins...",
                    "zeroAmazonCodes" => "There are not any amazon codes...",
                    "paypalEmail" => "Your paypal email",
                    "paypalCurrency" => "Paypal currency",
                    "paymentOptions" => "Payment options",
                    "paypalOptionsNotAdded" => "Paypal options does not exists, yet. Create one, for full working this payment method.",
                    "paypalOptionAdded" => "Paypal option has been successfully added.",
                    "paypalOptionDeleted" => "Paypal option has been deleted.",

                    //Ticket system
                    "unread" => "unread",
                    "doYouWantToCloseTicket" => "Do you really want to close this ticket ?",
                    "ticketClosed" => "Ticket has been closed. You can reopen it in section 'Closed tickets'.",
                    "viewTicket" => "Ticket info",
                    "open" => "OPEN",
                    "closed" => "CLOSED",
                    "processing" => "PROCESSING",
                    "openedBy" => "Opened by ",
                    "answers" => " answers",
                    "noTickets" => "There are not tickets at this moment.",
                    "createdTicket" => " created ticket:",
                    "answered" => " answered:",
                    "closeTicket" => "Close ticket",
                    "reopenTicket" => "Reopen ticket",
                    "addAnswer" => "Add answer",
                    "userWillSeeThisName" => "User will see this name. You can write your ingame name or just simply 'Admin'...",
                    "answer" => "Answer",
                    "setStatus" => "Set ticket status",
                    "emptyErrorAddTicket" => "You need to enter name and answer.",
                    "answerAdded" => "Answer successfully added.",
                    "cannotAnswer" => "Ticket is closed. You cannot answer.",
                    "ticketReopened" => "Ticket has been successfully reopened.",
                    "ticketsPerPage" => "Tickets per page",

                    //Team members
                    "nameMustBeAtLeast2chars" => "Name must have at least 2 characters.",
                    "categoryAlreadyExists" => "Category with this name already exists.",
                    "categoryAdded" => "Category successfully added.",
                    "categoryDeleted" => "Category was deleted.",
                    "editCategory" => "Edit category",
                    "categoryWasNotFound" => "Category was not found. (probably deleted)",
                    "categoryUpdated" => "Category successfully updated.",
                    "thereAreNotCategories" => "There are not categories. You need to create category before adding new member.",
                    "ingameName" => "In-game name",
                    "position" => "Position",
                    "contact" => "Contact",
                    "emptyError2" => "You need to enter Name, In-game name, Position and category.",
                    "categoryDoesntExists" => "Category doesnt exists",
                    "memberAdded" => "Member was successfully added.",
                    "memberDeleted" => "Member has been deleted.",
                    "editMember" => "Edit member",
                    "memberWasNotFound" => "Member was not found.",
                    "newAvatar" => "New avatar",
                    "memberUpdated" => "Member has been successfully updated.",

                    //Downloads
                    "descriptionOptional" => "Description (optional)",
                    "size" => "Size",
                    "withHttp" => "With HTTP://",
                    "includeUnits" => "Don't forget to include units (GB / MB / KB )",
                    "youNeedToEnter" => "You need to enter title, link and size.",
                    "linkInvalid" => "Link is invalid.",
                    "downloadAdded" => "Download has been successfully added.",
                    "downloadsPerPage" => "Downloads per page",
                    "downloadRemoved" => "Download has been removed.",
                    "addedBy" => "Added by",
                    "editDownload" => "Edit download",
                    "downloadWasNotFound" => "Download was not found. (probably deleted).",

                    //News
                    "title" => "Title",
                    "introNews" => "Intro (optional)",
                    "fullNews" => "Full news",
                    "stickToTop" => "Stick to top",
                    "author" => "Author",
                    "newsImg" => "Image",
                    "emptyError" => "Title, full news and author cannot be empty.",
                    "isNotImage" => "File is not image.",
                    "notSupportedImage" => "Not supported extension. You can use only .jpg, .jpeg, .png, .gif ...",
                    "imageExists" => "Image already exists. Please make action again",
                    "imageTooBig" => "Image is bigger then your php settings allow.",
                    "imageErrorCorrupted" => "Error while uploading file. Make sure you have enough disc space and
                    upload function is allowed on your web server.",
                    "newsSubmitted" => "News was successfully added.",
                    "content" => "Content",
                    "comments" => "Comments",
                    "action" => "Action",
                    "areYouSure" => "Are you sure ?",
                    "newsRemoved" => "News was successfully removed.",
                    "editNews" => "Edit news",
                    "newsWasNotFound" => "News was not found. (probably deleted ?)",
                    "update" => "Update",
                    "newImage" => "New image",
                    "successfullyUpdated" => "News was successfully updated.",
                    "newsPerPage" => "News per page",
                    "enableComments" => "Enable comments",
                    "onlyUsersCanComments" => "Commenting only for registered users",
                    "commentsPerPage" => "Comments per page",
                    "settingsUpdated" => "Settings was updated.",
                    "deleteComment" => "Delete this comment",
                    "showingCommentsFor" => "Showing comments for news ID: ",
                    "commentDeleted" => "Comment has been deleted.",

                    "accessDenied" => "Access denied",
                    "accessDeniedDesc" => "We are sorry,  but you dont have permissions to view this page.",
                    "updated" => "Successfully updated.",
                    //Administration - END

                    //Global - START
                    "404" => "Error 404 - Page not found",
                    "back" => "Back to Homepage",
                    "invalidDate" => "Invalid date.",
                    "right" => "Right",
                    "mid" => "Middle",
                    "left" => "Left",
                    "disabled" => "Disabled",
                    "admin" => "Administrator",
                    "created" => "Created",
                    "userIP" => "User IP",
                    "information" => "Info",
                    "avatar" => "Avatar",
                    "image" => "Image",
                    "category" => "Category",
                    "facebook" => "Facebook",
                    "twitter" => "Twitter",
                    "gplus" => "Google plus",
                    "notRequired" => "Not required",
                    "name" => "Name",
                    "submit" => "Submit",
                    "emailFooter" => "<br /><br />Request has been performed by IP address: ".$_SERVER["REMOTE_ADDR"]."
                    <br />This email is generated automatically - please do not answer.<br /><br /><a href='".Links::getUrl('index')."'>".Core::getSiteTitle()."</a>",


                    //Months
                    "date" => "Date",
                    "january" => "Januray",
                    "february" => "February",
                    "march" => "March",
                    "april" => "April",
                    "may" => "May",
                    "june" => "June",
                    "july" => "July",
                    "august" => "August",
                    "september" => "September",
                    "october" => "October",
                    "november" => "November",
                    "december" => "December"
                    //Months

                    //Global - END
                );
                break;
            case "cz":
                $phrases = array(
                    "register" => "Registrace",
                    "login" => "Přihlášení"
                );
                break;
        }
        if(!isset($phrases[$string]))
        {
            return "Error ! Please check classes/Language.class.php";
        } else {
            return $phrases[$string];
        }
    }

}

?>