<?php
if(Admin::hasRight($_SESSION["username"], "x") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$ticket = new TicketSystem();

if(isset($_POST["update_settings"]))
{
    $per_page = $_POST["dl_per_page"];
    if(isset($_POST["ticket_system_enable"]))
    {
        $ticket_system_enable = 1;
    } else {
        $ticket_system_enable = 0;
    }
    Core::updateSettings("ticket_system_enable", $ticket_system_enable);
    Core::updateSettings("user_tickets_per_page", $per_page);
    $result = Core::result(Language::getTranslation("updated"), 1);
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("settings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("settings") ?></li>
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
                    <form method="post" action="index.php?page=ticket-settings" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("enableTicketSystem") ?></label>
                            <div class="col-sm-7">
                                <input type="checkbox" name="ticket_system_enable" class="js-switch"
                                    <?php if(Core::ticketSystemEnabled()) { echo " checked"; } ?>
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("ticketsPerPage") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="dl_per_page" value="<?= $ticket->ticketsPerPage() ?>" class="form-control">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"
                                    class="btn btn-primary" name="update_settings"><?= Language::getTranslation("update") ?></button>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <!-- END BASIC ELEMENTS -->
    </div>
</section>