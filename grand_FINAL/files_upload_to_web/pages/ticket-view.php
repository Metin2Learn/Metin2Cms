<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if (Core::ticketSystemEnabled()) {

        $ticket = new TicketSystem();

        if(isset($_GET["id"]) AND ctype_digit($_GET["id"]) AND $ticket->isValidTicket($_GET["id"]))
        {
            echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") .
                '</a> - <a href="' . Links::getUrl("account ticket system") . '">
    ' . Language::getTranslation("ticketSysTitle") . '</a> - <a href="'.Links::getUrl("account ticket-view").'">' .
                Language::getTranslation("ticketSysView") . '</a> - '.Language::getTranslation("ticketInfoTitle").'</h2>';

            if (Core::isCaptchaEnabled()) {
                $securimage = new Securimage();
            }
            if(isset($_POST["add_answer"]))
            {
                $answer = htmlspecialchars($_POST["answer"]);
                if (Core::isCaptchaEnabled()) {
                    $captcha = $_POST["captcha"];
                }

                if(mb_strlen($answer) < 5 OR mb_strlen($answer) > 1999)
                {
                    $result = Core::result(Language::getTranslation("ticketAnswerRange"), 2);
                }
                elseif(Core::isCaptchaEnabled() AND $securimage->check($captcha) == false)
                {
                    $result = Core::result(Language::getTranslation("captchaWong"), 2);
                }
                elseif(ActionLog::hasBlock($_SESSION["username"], "ticket-answer")) {
                    $result = Core::result(Language::getTranslation("ticketAnswerHasBlock") . ActionLog::unblockTime($_SESSION["username"], "ticket-answer"), 2);
                }
                elseif($ticket->isClosed($_GET["id"]))
                {
                    $result = Core::result(Language::getTranslation("ticketAnswerClosed"),2);
                } else {
                    $result = Core::result(Language::getTranslation("ticketAnswerSuccess"),1);
                    $ticket->addAnswer($_GET["id"], $answer);
                    $ticket->updateLastSeen($_GET["id"], 'user');
                    ActionLog::write($_SESSION["username"], "ticket-answer");
                }
            }


            echo $ticket->showInfo($_GET["id"]);

            if(isset($result)) { echo $result; }

            if($ticket->numberOfAnswers($_GET["id"]) > 0)
            {
                echo $ticket->printAnswers($_GET["id"]);
            } else {
                echo Core::result(Language::getTranslation("ticketSysNoAnswers"),4);
            }
            if(!$ticket->isClosed($_GET["id"])) {

                echo '<div class="box">';

                ?>
                <h2><?= Language::getTranslation("ticketAddAnswer");?></h2>
                <form method="post" action="<?= Links::getUrl("account ticket-view-show").$_GET["id"]; ?>">
                    <div class="form-group">
                        <label for="answer"><?= Language::getTranslation("ticketAnswer"); ?></label>
                        <textarea name="answer" class="form-control" id="answer" required></textarea>
                    </div>
                    <?php
                    if (Core::isCaptchaEnabled()) {
                        ?>
                        <div class="form-group">
                            <label for="captcha"><img id="captcha" src="assets/securimage/securimage_show.php"
                                                      alt="CAPTCHA Image"/>
                                <a href="#"
                                   onclick="document.getElementById('captcha').src = 'assets/securimage/securimage_show.php?' + Math.random(); return false">[ <?= Language::getTranslation("anotherCaptcha"); ?>
                                    ]</a>
                            </label>
                            <input type="text" name="captcha" class="form-control" id="captcha"
                                   placeholder="<?= Language::getTranslation("regCaptcha"); ?>" required>
                        </div>
                    <?php
                    }
                    ?>
                    <button type="submit" name="add_answer" class="btn btn-primary"><?= Language::getTranslation("ticketAddAnswer"); ?></button>
                </form>
                <?php

                echo "</div>";
            }
            ?>


<?php


        } else {

            echo '<div class="box">';
            echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") .
                '</a> - <a href="' . Links::getUrl("account ticket system") . '">
    ' . Language::getTranslation("ticketSysTitle") . '</a> - ' . Language::getTranslation("ticketSysView") . '</h2>';
            //Here
            if ($ticket->numberOfUserTickets($_SESSION["username"]) > 0) {


                // Paginator
                $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                $totalCount = $ticket->numberOfUserTickets($_SESSION["username"]);
                $perPage = 10;
                // TODO : Zkontrolovat proč nejde brát z DB ticketsPerPage
                $paginator = new Paginator($page, $totalCount, $perPage);
                // Paginator

                //Validate page
                if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                    Core::redirect(Links::getUrl("account ticket-view"), 0);
                    die();
                }
                //Validate page

                // Print downloads and pagination
                global $dbname;
                echo $ticket->printUserTickets("SELECT * FROM " . $dbname . ".ticket_system_tickets WHERE user_name = ?
                ORDER BY FIELD(`status`, 'processing', 'open', 'closed') ASC, `date` DESC LIMIT ? OFFSET ?", array($_SESSION["username"] ,$perPage, $paginator->offset()));
                $paginator->printLinks("ticket-view/", "pagination");
                // Print downloads and pagination


            } else {
                Core::result(Language::getTranslation("ticketSysNoTickets"), 4);
            }
        }

    } else {
        Core::redirect(Links::getUrl("login"));
    }
    echo '</div>';
}

?>