<?php
if (Admin::hasRight($_SESSION["username"], "ch1") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editWebAdmin") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("administrators") ?></a></li>
        <li><a href="index.php?page=all-web-admins"><?= Language::getTranslation("viewWebAdministrators") ?></a></li>
        <li class="active"><?= Language::getTranslation("editWebAdmin") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">

                    <?php
                    if (isset($_GET["id"]) AND Admin::isWebAdmin($_GET["id"])) {

                        if(isset($_POST["edit_admin"]))
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
                                } else {
                                    Admin::updateWebAdmin($account, $rights, $_GET["id"]);
                                    $result = Core::result(Language::getTranslation("adminUpdated"), 1);
                                }
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        $info = Admin::webAdminInfo($_GET["id"]);
                        ?>

                        <form method="POST" action="index.php?page=edit-web-admin&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("usernameAccount") ?></label>
                                <div class="col-sm-7">
                                    <input type="text" name="account" value="<?= $info["username"] ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("rights") ?></label>
                                <div class="col-sm-7">
                                    <label><input type="checkbox" class="check" id="checkAll"><?= Language::getTranslation("checkAll") ?></label>
                                    <hr />
                                    <?php
                                    if(Admin::hasRight($info["username"], "b"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="b" class="check" checked> <?= Language::getTranslation("adminViewTasks") ?> </label>
                                        <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="b" class="check"> <?= Language::getTranslation("adminViewTasks") ?> </label>
                                        <?php
                                    }

                                    if(Admin::hasRight($info["username"], "i1"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="i1" class="check" checked> <?= Language::getTranslation("adminEditTasks") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="i1" class="check"> <?= Language::getTranslation("adminEditTasks") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "d"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="d" class="check" checked> <?= Language::getTranslation("adminViewNotifications") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="d" class="check"> <?= Language::getTranslation("adminViewNotifications") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "e"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="e" class="check" checked> <?= Language::getTranslation("adminAddNews") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="e" class="check"> <?= Language::getTranslation("adminAddNews") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "f"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="f" class="check" checked> <?= Language::getTranslation("adminViewNews") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="f" class="check"> <?= Language::getTranslation("adminViewNews") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "g"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="g" class="check" checked> <?= Language::getTranslation("adminEditNewsSettings") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="g" class="check"> <?= Language::getTranslation("adminEditNewsSettings") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "h"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="h" class="check" checked> <?= Language::getTranslation("adminDeleteComments") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="h" class="check"> <?= Language::getTranslation("adminDeleteComments") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "ch"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="ch" class="check" checked> <?= Language::getTranslation("adminEditNews") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="ch" class="check"> <?= Language::getTranslation("adminEditNews") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "i"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="i" class="check" checked> <?= Language::getTranslation("adminDeleteNews") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="i" class="check"> <?= Language::getTranslation("adminDeleteNews") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "j"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="j" class="check" checked> <?= Language::getTranslation("adminViewDownloads") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="j" class="check"> <?= Language::getTranslation("adminViewDownloads") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "k"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="k" class="check" checked> <?= Language::getTranslation("adminAddDownloads") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="k" class="check"> <?= Language::getTranslation("adminAddDownloads") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "l"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="l" class="check" checked> <?= Language::getTranslation("adminEditDownloads") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="l" class="check"> <?= Language::getTranslation("adminEditDownloads") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "m"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="m" class="check" checked> <?= Language::getTranslation("adminDownloadSettings") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="m" class="check"> <?= Language::getTranslation("adminDownloadSettings") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "n"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="n" class="check" checked> <?= Language::getTranslation("adminDeleteDownloads") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="n" class="check"> <?= Language::getTranslation("adminDeleteDownloads") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "o"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="o" class="check" checked> <?= Language::getTranslation("adminViewTeamMembers") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="o" class="check"> <?= Language::getTranslation("adminViewTeamMembers") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "p"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="p" class="check" checked> <?= Language::getTranslation("adminAddTeamMember") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="p" class="check"> <?= Language::getTranslation("adminAddTeamMember") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "q"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="q" class="check" checked> <?= Language::getTranslation("adminEditTeamMember") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="q" class="check"> <?= Language::getTranslation("adminEditTeamMember") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "r"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="r" class="check" checked> <?= Language::getTranslation("adminDeleteTeamMember") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="r" class="check"> <?= Language::getTranslation("adminDeleteTeamMember") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "s"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="s" class="check" checked> <?= Language::getTranslation("adminTeamCategory") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="s" class="check"> <?= Language::getTranslation("adminTeamCategory") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "t"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="t" class="check" checked> <?= Language::getTranslation("adminViewTickets") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="t" class="check"> <?= Language::getTranslation("adminViewTickets") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "u"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="u" class="check" checked> <?= Language::getTranslation("adminAnswerTickets") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="u" class="check"> <?= Language::getTranslation("adminAnswerTickets") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "v"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="v" class="check" checked> <?= Language::getTranslation("adminCloseTicket") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="v" class="check"> <?= Language::getTranslation("adminCloseTicket") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "w"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="w" class="check" checked> <?= Language::getTranslation("adminTicketCategory") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="w" class="check"> <?= Language::getTranslation("adminTicketCategory") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "x"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="x" class="check" checked> <?= Language::getTranslation("adminEditTicketSettings") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="x" class="check"> <?= Language::getTranslation("adminEditTicketSettings") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "y"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="y" class="check" checked> <?= Language::getTranslation("adminViewItemshop") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="y" class="check"> <?= Language::getTranslation("adminViewItemshop") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "z"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="z" class="check" checked> <?= Language::getTranslation("adminAddItemshop") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="z" class="check"> <?= Language::getTranslation("adminAddItemshop") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "a1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="a1" class="check" checked> <?= Language::getTranslation("adminEditItemshop") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="a1" class="check"> <?= Language::getTranslation("adminEditItemshop") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "b1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="b1" class="check" checked> <?= Language::getTranslation("adminDeleteItemshop") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="b1" class="check"> <?= Language::getTranslation("adminDeleteItemshop") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "c1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="c1" class="check" checked> <?= Language::getTranslation("adminEditItemshopSettings") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="c1" class="check"> <?= Language::getTranslation("adminEditItemshopSettings") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "d1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="d1" class="check" checked> <?= Language::getTranslation("adminCoupons") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="d1" class="check"> <?= Language::getTranslation("adminCoupons") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "e1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="e1" class="check" checked> <?= Language::getTranslation("adminViewCoupons") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="e1" class="check"> <?= Language::getTranslation("adminViewCoupons") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "f1"))
                                    {
                                        ?>

                                        <hr />
                                        <label><input type="checkbox" name="f1" class="check" checked> <?= Language::getTranslation("adminViewGameAdmins") ?> </label>                                    <?php
                                    } else {
                                        ?>

                                        <hr />
                                        <label><input type="checkbox" name="f1" class="check"> <?= Language::getTranslation("adminViewGameAdmins") ?> </label>                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "g1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="g1" class="check" checked> <?= Language::getTranslation("adminViewWebAdmins") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="g1" class="check"> <?= Language::getTranslation("adminViewWebAdmins") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "h1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="h1" class="check" checked> <?= Language::getTranslation("adminGameAdmins") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="h1" class="check"> <?= Language::getTranslation("adminGameAdmins") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "ch1"))
                                    {
                                        ?>

                                        <label><input type="checkbox" name="ch1" class="check" checked> <?= Language::getTranslation("adminWebAdmins") ?> </label>
                                    <?php
                                    } else {
                                        ?>

                                        <label><input type="checkbox" name="ch1" class="check"> <?= Language::getTranslation("adminWebAdmins") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "j1"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="j1" class="check" checked> <?= Language::getTranslation("adminEditReferralSystem") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="j1" class="check"> <?= Language::getTranslation("adminEditReferralSystem") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "k1"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="k1" class="check" checked> <?= Language::getTranslation("adminTemplateContent") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="k1" class="check"> <?= Language::getTranslation("adminTemplateContent") ?> </label>
                                    <?php
                                    }
                                    if(Admin::hasRight($info["username"], "l1"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="l1" class="check" checked> <?= Language::getTranslation("adminConfiguration") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="l1" class="check"> <?= Language::getTranslation("adminConfiguration") ?> </label>
                                    <?php
                                    }

                                    if(Admin::hasRight($info["username"], "m1"))
                                    {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="m1" class="check" checked> <?= Language::getTranslation("adminGame") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <hr />
                                        <label><input type="checkbox" name="m1" class="check"> <?= Language::getTranslation("adminGame") ?> </label>
                                    <?php
                                    }
                                    if(Admin::hasRight($info["username"], "n1"))
                                    {
                                        ?>
                                        <label><input type="checkbox" name="n1" class="check" checked> <?= Language::getTranslation("adminLogs") ?> </label>
                                    <?php
                                    } else {
                                        ?>
                                        <label><input type="checkbox" name="n1" class="check"> <?= Language::getTranslation("adminLogs") ?> </label>
                                    <?php
                                    }


                                    ?>


                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary" name="edit_admin"><?= Language::getTranslation("update") ?></button>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn btn-primary"><?= Language::getTranslation("reset") ?></button>
                            </div>
                        </form>

                    <?php
                    } else {
                        echo Core::result(Language::getTranslation("adminNotFound"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
