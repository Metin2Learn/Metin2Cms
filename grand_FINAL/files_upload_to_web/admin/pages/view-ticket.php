<?php
if(Admin::hasRight($_SESSION["username"], "t") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ticket = new TicketSystem();

if(!isset($_GET["id"]) OR (isset($_GET["id"]) AND !$ticket->ticketExists($_GET["id"])))
{
    Core::redirect("index.php?page=all-open-tickets");
    die();
}

if($ticket->getLastSeen($_GET["id"]) == 'user')
{
    $ticket->updateLastSeen($_GET["id"], '');
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewTicket") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li><a href="index.php?page=all-tickets"><?= Language::getTranslation("viewOpenTickets") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewTicket") ?></li>
    </ol>
</section>

<section class="content">
    <?php
    if(isset($_GET["action"]) AND $_GET["action"] == "close" AND Admin::hasRight($_SESSION["username"], "v") AND $ticket->isNotClosed($_GET["id"])) {
        $ticket->changeStatus($_GET["id"], 'closed');
        $result = Core::result(Language::getTranslation("ticketClosed"), 1);
    } elseif(isset($_GET["action"]) AND $_GET["action"] == "reopen" AND Admin::hasRight($_SESSION["username"], "v") AND !$ticket->isNotClosed($_GET["id"]))
    {
        $result = Core::result(Language::getTranslation("ticketReopened"), 1);
        $ticket->changeStatus($_GET["id"], 'open');
    } elseif(isset($_POST["add_answer"]))
    {
        $answer = $_POST["answer"];
        $status = $_POST["status"];
        if(empty($answer)) {
            $result = Core::result(Language::getTranslation("emptyErrorAddTicket"), 2);
        } elseif($ticket->isNotClosed($_GET["id"]) == false) {
            $result = Core::result(Language::getTranslation("cannotAnswer"), 2);
        } elseif(Admin::hasRight($_SESSION["username"], "u") == false) {
            Core::redirect("index.php?page=no-permissions");
        } else {
            $ticket->addAdminAnswer($_GET["id"], $_SESSION["username"], $answer);
            $ticket->changeStatus($_GET["id"], $status);
            $ticket->updateLastSeen($_GET["id"], 'admin');
            $result = Core::result(Language::getTranslation("answerAdded"), 1);
        }
    }

    if(isset($result)) { echo $result; }
    ?>
    <div class="row">
        <div class="col-md-3">
            <div class="grid support">
            <div class="grid">
                <div class="grid-body">
                    <h2><i class="fa fa-info-circle"></i> <?= Language::getTranslation("information") ?></h2>
                    <hr>
                    <?php
                    $info = $ticket->getInfo($_GET["id"]);
                    ?>
                    <ul>
                        <?php
                        if(Admin::hasRight($_SESSION["username"], "u") AND $ticket->isNotClosed($_GET["id"]))
                        {
                            ?>
                            <li><h4><a href="#add_answer"><i class="fa fa-plus-circle"></i> <?= Language::getTranslation("addAnswer") ?></a></h4></li>
                        <?php
                        }
                        if(Admin::hasRight($_SESSION["username"], "v") AND $ticket->isNotClosed($_GET["id"]))
                        {
                            ?>
                            <li><h4><a href="index.php?page=view-ticket&id=<?= $_GET["id"] ?>&action=close"><i class="fa fa-times-circle-o"></i> <?= Language::getTranslation("closeTicket") ?></a></h4></li>
                            <?php
                        }
                        if(Admin::hasRight($_SESSION["username"], "v") AND !$ticket->isNotClosed($_GET["id"]))
                        {
                            ?>
                            <li><h4><a href="index.php?page=view-ticket&id=<?= $_GET["id"] ?>&action=reopen"><i class="fa fa-times-share"></i> <?= Language::getTranslation("reopenTicket") ?></a></h4></li>
                        <?php
                        }
                        ?>
                        <li><h4><?= Language::getTranslation("ticketSysAddSubject") ?>:</h4><span class="text-danger"><?= $info["subject"] ?></span></li>
                        <li><h4><?= Language::getTranslation("ticketSysCategory") ?>:</h4><span class="text-danger"><?= $ticket->getCategoryName($info["category_id"]) ?></span></li>
                        <li><h4><?= Language::getTranslation("status") ?>:</h4>
                            <?php
                            if($info["status"] == 'open')
                            {
                                echo '<span class="label label-primary">' . Language::getTranslation("open") . '</span>';
                            } elseif($info["status"] == 'closed')
                            {
                                echo '<span class="label label-danger">' . Language::getTranslation("closed") . '</span>';
                            } elseif($info["status"] == 'processing')
                            {
                                echo '<span class="label label-success">' . Language::getTranslation("processing") . '</span>';
                            }
                            ?>
                        <li><h4><?= Language::getTranslation("regUsername") ?>:</h4><span class="text-danger"><?= $info["user_name"] ?></span></li>
                        <li><h4><?= Language::getTranslation("userIP") ?>:</h4><span class="text-danger"><?= $info["user_ip"] ?></span></li>
                        <li><h4><?= Language::getTranslation("created") ?>:</h4><span class="text-danger"><?= Core::makeNiceDate($info["date"]) ?></span></li>
                    </ul>
                </div>
            </div>
         </div>
    </div>


        <div class="col-md-9">
                    <div class="grid">
                        <div class="grid-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="text-center"><?= "<span class='label label-primary'>".Core::timeAgo($info['date'])."</span><br /><a>".$info['user_name'].Language::getTranslation('createdTicket') ?></a></span></div>
                                </div>

                                <div class="col-md-10">
                                    <p><?= $info["text"] ?></p>
                                </div>
                            </div>


                            <?php
                            // Paginator
                            if($ticket->numberOfAnswers($_GET["id"])) {
                                $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                                $totalCount = $ticket->numberOfAnswers($_GET["id"]);
                                $perPage = 10;
                                $paginator = new Paginator($page, $totalCount, $perPage);
                                // Paginator

                                // Validate page
                                if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                                    Core::redirect("index.php?page=view-ticket&id=" . $_GET["id"], 0);
                                    die();
                                }
                                // Validate page


                                // Print all news and pagination links
                                global $dbname;
                                $ticket->printAdminAnswers("SELECT * FROM " . $dbname . ".ticket_system_answers WHERE ticket_id = ? ORDER BY `date` LIMIT ? OFFSET ?", array($_GET["id"], $perPage, $paginator->offset()));
                                $paginator->printLinks("index.php?page=view-ticket&id=".$_GET['id']."&pagination=", "pagination");
                                // Print all news and pagination links
                            }
                            ?>


                        </div>
                    </div>
        </div>

        <?php
        if($ticket->isNotClosed($_GET["id"]) AND Admin::hasRight($_SESSION["username"], "u")) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <span class="grid-title"><?= Language::getTranslation("addAnswer") ?></span>
                        </div>
                        <div class="grid-body">
                            <form id="add_answer" method="POST"
                                  action="index.php?page=view-ticket&id=<?= $_GET["id"] ?>" class="form-horizontal"
                                  role="form">

                                <div class="form-group">
                                    <label
                                        class="col-sm-3 control-label"><?= Language::getTranslation("answer") ?></label>

                                    <div class="col-sm-7">
                                        <textarea class="form-control" id="full_news" name="answer"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-sm-3 control-label"><?= Language::getTranslation("setStatus") ?></label>

                                    <div class="col-sm-7">
                                        <select name="status" class="form-control">
                                            <option
                                                value="processing"><?= Language::getTranslation("processing") ?></option>
                                            <option value="closed"><?= Language::getTranslation("closed") ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"
                                            name="add_answer"><?= Language::getTranslation("submit") ?></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

</section>