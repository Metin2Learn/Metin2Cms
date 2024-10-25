<?php
if(Admin::hasRight($_SESSION["username"], "t") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ticket = new TicketSystem();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewOpenTickets") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewOpenTickets") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if($ticket->numberOfAllTickets() > 0) {
                        if (isset($_GET["close"]) AND Admin::hasRight($_SESSION["username"], "v") AND $ticket->ticketExists($_GET["close"]) AND $ticket->isNotClosed($_GET["close"])) {
                            $result = Core::result(Language::getTranslation("ticketClosed"), 1);
                            $ticket->closeTicket($_GET["close"]);
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        if(!isset($_GET["view"]))
                        {
                            $view = 'open';
                        } elseif(isset($_GET["view"]) AND $_GET["view"] == 'open')
                        {
                            $view = 'open';
                        } elseif(isset($_GET["view"]) AND $_GET["view"] == 'closed')
                        {
                            $view = 'closed';
                        } else {
                            $view = 'open';
                        }

                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        if($view == 'open')
                        {
                            $totalCount = $ticket->numberOfUserAllOpenTickets();
                        } else {
                            $totalCount = $ticket->numberOfUserAllClosedTickets();
                        }
                        $perPage = (int)$ticket->ticketsPerPage();
                        // TODO : Dodělat počet z DB (perPage)
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=all-tickets", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        echo '<div class="btn-group">';
                        if ($ticket->numberOfUserAllOpenTickets() > 0) {
                            echo '<a href="index.php?page=all-tickets&view=open">';
                            if($view == 'open')
                            {
                                echo '<button type="button" class="btn btn-default active">
                                ' . $ticket->numberOfUserAllOpenTickets() . ' ' . Language::getTranslation("open") . '</button>';
                            } else {
                                echo '<button type="button" class="btn btn-default">' . $ticket->numberOfUserAllOpenTickets() . ' ' . Language::getTranslation("open") . '</button>';
                            }
                            echo '</a>';
                        }
                        if ($ticket->numberOfUserAllClosedTickets() > 0) {
                            echo '<a href="index.php?page=all-tickets&view=closed">';
                            if($view == 'closed')
                            {
                                echo '<button type="button" class="btn btn-default active">' . $ticket->numberOfUserAllClosedTickets() . ' ' . Language::getTranslation("closed") . '</button>';
                            } else {
                                echo '<button type="button" class="btn btn-default">' . $ticket->numberOfUserAllClosedTickets() . ' ' . Language::getTranslation("closed") . '</button>';
                            }
                            echo '</a>';
                        }
                        echo '</div>';

                        if($view == 'open') {
                            $ticket->printOpenTickets("SELECT * FROM " . $dbname . ".ticket_system_tickets WHERE
                        status != 'closed' ORDER BY `date` DESC, FIELD(status, 'open', 'processing', 'closed')
                        LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        } else {
                            $ticket->printOpenTickets("SELECT * FROM " . $dbname . ".ticket_system_tickets WHERE
                        status = 'closed' ORDER BY `date` DESC, FIELD(status, 'open', 'processing', 'closed')
                        LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        }
                        $paginator->printLinks("index.php?page=all-tickets&view=".$view."&pagination=", "pagination");
                        // Print all news and pagination links
                    } else {
                        echo Core::result(Language::getTranslation("noTickets"),4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>