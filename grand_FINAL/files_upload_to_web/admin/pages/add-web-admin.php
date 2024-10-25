<?php
if(Admin::hasRight($_SESSION["username"], "ch1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}


if(isset($_POST["add_admin"]))
{
    $account = $_POST["account"];
    $rights = "a";
    if(isset($_POST["b"]))
    {
        $rights .= ",b";
    }

    if(isset($_POST["d"]))
    {
        $rights .= ",d";
    }
    if(isset($_POST["e"]))
    {
        $rights .= ",e";
    }
    if(isset($_POST["f"]))
    {
        $rights .= ",f";
    }
    if(isset($_POST["g"]))
    {
        $rights .= ",g";
    }
    if(isset($_POST["h"]))
    {
        $rights .= ",h";
    }
    if(isset($_POST["ch"]))
    {
        $rights .= ",ch";
    }
    if(isset($_POST["i"]))
    {
        $rights .= ",i";
    }
    if(isset($_POST["j"]))
    {
        $rights .= ",j";
    }
    if(isset($_POST["k"]))
    {
        $rights .= ",k";
    }
    if(isset($_POST["l"]))
    {
        $rights .= ",l";
    }
    if(isset($_POST["m"]))
    {
        $rights .= ",m";
    }
    if(isset($_POST["n"]))
    {
        $rights .= ",n";
    }
    if(isset($_POST["o"]))
    {
        $rights .= ",o";
    }
    if(isset($_POST["p"]))
    {
        $rights .= ",p";
    }
    if(isset($_POST["q"]))
    {
        $rights .= ",q";
    }
    if(isset($_POST["r"]))
    {
        $rights .= ",r";
    }
    if(isset($_POST["s"]))
    {
        $rights .= ",s";
    }
    if(isset($_POST["t"]))
    {
        $rights .= ",t,c";
    }
    if(isset($_POST["u"]))
    {
        $rights .= ",u";
    }
    if(isset($_POST["v"]))
    {
        $rights .= ",v";
    }
    if(isset($_POST["w"]))
    {
        $rights .= ",w";
    }
    if(isset($_POST["x"]))
    {
        $rights .= ",x";
    }
    if(isset($_POST["y"]))
    {
        $rights .= ",y";
    }
    if(isset($_POST["z"]))
    {
        $rights .= ",z";
    }
    if(isset($_POST["a1"]))
    {
        $rights .= ",a1";
    }
    if(isset($_POST["b1"]))
    {
        $rights .= ",b1";
    }
    if(isset($_POST["c1"]))
    {
        $rights .= ",c1";
    }
    if(isset($_POST["d1"]))
    {
        $rights .= ",d1";
    }
    if(isset($_POST["e1"]))
    {
        $rights .= ",e1";
    }
    if(isset($_POST["f1"]))
    {
        $rights .= ",f1";
    }
    if(isset($_POST["g1"]))
    {
        $rights .= ",g1";
    }
    if(isset($_POST["h1"]))
    {
        $rights .= ",h1";
    }
    if(isset($_POST["ch1"]))
    {
        $rights .= ",ch1";
    }
    if(isset($_POST["i1"]))
    {
        $rights .= ",i1";
    }
    if(isset($_POST["j1"]))
    {
        $rights .= ",j1";
    }
    if(isset($_POST["k1"]))
    {
        $rights .= ",k1";
    }
    if(isset($_POST["l1"]))
    {
        $rights .= ",l1";
    }
    if(isset($_POST["m1"]))
    {
        $rights .= ",m1";
    }
    if(isset($_POST["n1"]))
    {
        $rights .= ",n1";
    }



    if(!User::usernameExists($account))
    {
        $result = Core::result(Language::getTranslation("accountNotExists"), 2);
    } elseif(Admin::isAdmin($account))
    {
        $result = Core::result(Language::getTranslation("userIsAlreadyAdmin"), 2);
    } else {
        Admin::addWebAdmin($account, $rights);
        $result = Core::result(Language::getTranslation("webAdminAdded"), 1);
    }
}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addWebAdmin") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("addWebAdmin") ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="POST" action="index.php?page=add-web-admin" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("usernameAccount") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="account" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("rights") ?></label>
                            <div class="col-sm-7">
                                <label><input type="checkbox" class="check" id="checkAll"><?= Language::getTranslation("checkAll") ?></label>
                                <hr />
                                <label><input type="checkbox" name="b" class="check"> <?= Language::getTranslation("adminViewTasks") ?> </label>
                                <label><input type="checkbox" name="i1" class="check"> <?= Language::getTranslation("adminEditTasks") ?> </label>
                                <label><input type="checkbox" name="d" class="check"> <?= Language::getTranslation("adminViewNotifications") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="e" class="check"> <?= Language::getTranslation("adminAddNews") ?> </label>
                                <label><input type="checkbox" name="f" class="check"> <?= Language::getTranslation("adminViewNews") ?> </label>
                                <label><input type="checkbox" name="g" class="check"> <?= Language::getTranslation("adminEditNewsSettings") ?> </label>
                                <label><input type="checkbox" name="h" class="check"> <?= Language::getTranslation("adminDeleteComments") ?> </label>
                                <label><input type="checkbox" name="ch" class="check"> <?= Language::getTranslation("adminEditNews") ?> </label>
                                <label><input type="checkbox" name="i" class="check"> <?= Language::getTranslation("adminDeleteNews") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="j" class="check"> <?= Language::getTranslation("adminViewDownloads") ?> </label>
                                <label><input type="checkbox" name="k" class="check"> <?= Language::getTranslation("adminAddDownloads") ?> </label>
                                <label><input type="checkbox" name="l" class="check"> <?= Language::getTranslation("adminEditDownloads") ?> </label>
                                <label><input type="checkbox" name="m" class="check"> <?= Language::getTranslation("adminDownloadSettings") ?> </label>
                                <label><input type="checkbox" name="n" class="check"> <?= Language::getTranslation("adminDeleteDownloads") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="o" class="check"> <?= Language::getTranslation("adminViewTeamMembers") ?> </label>
                                <label><input type="checkbox" name="p" class="check"> <?= Language::getTranslation("adminAddTeamMember") ?> </label>
                                <label><input type="checkbox" name="q" class="check"> <?= Language::getTranslation("adminEditTeamMember") ?> </label>
                                <label><input type="checkbox" name="r" class="check"> <?= Language::getTranslation("adminDeleteTeamMember") ?> </label>
                                <label><input type="checkbox" name="s" class="check"> <?= Language::getTranslation("adminTeamCategory") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="t" class="check"> <?= Language::getTranslation("adminViewTickets") ?> </label>
                                <label><input type="checkbox" name="u" class="check"> <?= Language::getTranslation("adminAnswerTickets") ?> </label>
                                <label><input type="checkbox" name="v" class="check"> <?= Language::getTranslation("adminCloseTicket") ?> </label>
                                <label><input type="checkbox" name="w" class="check"> <?= Language::getTranslation("adminTicketCategory") ?> </label>
                                <label><input type="checkbox" name="x" class="check"> <?= Language::getTranslation("adminEditTicketSettings") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="y" class="check"> <?= Language::getTranslation("adminViewItemshop") ?> </label>
                                <label><input type="checkbox" name="z" class="check"> <?= Language::getTranslation("adminAddItemshop") ?> </label>
                                <label><input type="checkbox" name="a1" class="check"> <?= Language::getTranslation("adminEditItemshop") ?> </label>
                                <label><input type="checkbox" name="b1" class="check"> <?= Language::getTranslation("adminDeleteItemshop") ?> </label>
                                <label><input type="checkbox" name="c1" class="check"> <?= Language::getTranslation("adminEditItemshopSettings") ?> </label>
                                <label><input type="checkbox" name="d1" class="check"> <?= Language::getTranslation("adminCoupons") ?> </label>
                                <label><input type="checkbox" name="e1" class="check"> <?= Language::getTranslation("adminViewCoupons") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="f1" class="check"> <?= Language::getTranslation("adminViewGameAdmins") ?> </label>
                                <label><input type="checkbox" name="g1" class="check"> <?= Language::getTranslation("adminViewWebAdmins") ?> </label>
                                <label><input type="checkbox" name="h1" class="check"> <?= Language::getTranslation("adminGameAdmins") ?> </label>
                                <label><input type="checkbox" name="ch1" class="check"> <?= Language::getTranslation("adminWebAdmins") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="j1" class="check"> <?= Language::getTranslation("adminEditReferralSystem") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="k1" class="check"> <?= Language::getTranslation("adminTemplateContent") ?> </label>
                                <label><input type="checkbox" name="l1" class="check"> <?= Language::getTranslation("adminConfiguration") ?> </label>
                                <hr />
                                <label><input type="checkbox" name="m1" class="check"> <?= Language::getTranslation("adminGame") ?> </label>
                                <label><input type="checkbox" name="n1" class="check"> <?= Language::getTranslation("adminLogs") ?> </label>

                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_admin"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
