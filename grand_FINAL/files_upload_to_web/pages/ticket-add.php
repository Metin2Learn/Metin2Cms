<?php

if(!User::isLogged())
{
    Core::redirect(Links::getUrl("login"));
} else {
    if(Core::ticketSystemEnabled())
    {
        $ticket = new TicketSystem();

        echo '<div class="box">';
        echo '<h2><a href="' . Links::getUrl("account") . '">' . Language::getTranslation("accountTitle") .
            '</a> - <a href="' . Links::getUrl("account ticket system") . '">
    ' . Language::getTranslation("ticketSysTitle") . '</a> - ' . Language::getTranslation("ticketSysCreate") . '</h2>';

        if(ActionLog::hasBlock($_SESSION["username"], "create-ticket"))
        {
            echo Core::result(Language::getTranslation("ticketSysAddHasBlock").ActionLog::unblockTime($_SESSION["username"], "create-ticket"), 2);
        } else {

            if (Core::isCaptchaEnabled()) {
                $securimage = new Securimage();
            }

            if(isset($_POST["create_ticket"]))
            {
                $subject = htmlspecialchars($_POST["subject"]);
                $category = $_POST["category"];
                $text = htmlspecialchars($_POST["text"]);
                if (Core::isCaptchaEnabled()) {
                    $captcha = $_POST["captcha"];
                }
                if(mb_strlen($subject) < 5 OR mb_strlen($subject) > 29)
                {
                    $result = Core::result(Language::getTranslation("ticketSysSubjectRange"),2);
                }
                elseif(!$ticket->categoryExists($category))
                {
                    $result = Core::result(Language::getTranslation("ticketSysInvalidCategory"), 2);
                }
                elseif(mb_strlen($text) < 15 OR mb_strlen($text) > 2000)
                {
                    $result = Core::result(Language::getTranslation("ticketSysTextRange"),2);
                }
                elseif(Core::isCaptchaEnabled() AND $securimage->check($captcha) == false)
                {
                    $result = Core::result(Language::getTranslation("captchaWong"), 2);
                } else {
                    //Create ticket
                    $ticket->create($subject, $category, $text);
                    ActionLog::write($_SESSION["username"], "create-ticket");
                    $result = Core::result(Language::getTranslation("ticketSysAddSuccess"),1);
                }

            }

            if(isset($result)) { echo $result; }
            ?>
            <form method="post" action="<?= Links::getUrl("account ticket-add"); ?>">
                <div class="form-group">
                    <label for="subject"><?= Language::getTranslation("ticketSysAddSubject"); ?></label>
                    <input type="text" name="subject" placeholder="<?= Language::getTranslation("ticketSysAddSubjectDesc");?>" class="form-control" id="subject" required>
                </div>
                <div class="form-group">
                    <label for="category"><?= Language::getTranslation("ticketSysAddCategory"); ?></label>
                    <select class="form-control" id="category" name="category">
                        <?php
                        echo $ticket->printCategories();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="text"><?= Language::getTranslation("ticketSysAddText"); ?></label>
                    <textarea name="text" class="form-control" id="text" required></textarea>
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
                <button type="submit" name="create_ticket"
                        class="btn btn-primary"><?= Language::getTranslation("ticketSysCreate"); ?></button>
            </form>
        <?php
        }

        echo '</div>';

    } else {
        echo Core::result(Language::getTranslation("ticketSysNotEnabled"),4);
        Core::redirect(Links::getUrl("account"), 2);
    }
}

?>