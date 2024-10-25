<div class="box">
<?php
$news = new News();

if($news->getNumberOfNews() > 0) {
    global $dbname;

    //Read more
    if (isset($_GET["id"]) AND ctype_digit($_GET["id"]) AND $news->doesExists($_GET["id"])) {
        echo $news->details($_GET["id"]);

        if($news->commentsEnabled()) {

            // Paginator
            $page2 = isset($_GET["comments_page"]) ? (int)$_GET["comments_page"] : 1;
            $totalCount2 = Database::query("SELECT * FROM " . $dbname . ".news_comments WHERE news_id = ?", array($_GET["id"]));
            $perPage2 = $news->commentsPerPage();
            $paginator2 = new Paginator($page2, $totalCount2, $perPage2);
            // Paginator

            // Validate page
            if (isset($_GET["comments_page"]) AND (!ctype_digit($_GET["comments_page"]) OR $_GET["comments_page"] > ceil($totalCount2 / $perPage2) OR $_GET["comments_page"] < 1)) {
                Core::redirect(Links::getUrl("home") . "/full/" . $_GET["id"], 0);
                die();
            }
            // Validate page


            // Print all news and pagination links
            global $dbname;
            echo '<div class="comments">';
            if ($news->numberOfComments($_GET["id"]) > 0) {
                echo '<ol class="commentlist">';
                echo $news->printComments("SELECT * FROM " . $dbname . ".news_comments WHERE news_id = ? ORDER BY `date` DESC LIMIT ? OFFSET ?", array($_GET["id"], $perPage2, $paginator2->offset()), $_GET["id"]);
                $paginator2->printLinks("news/full/" . $_GET["id"] . "/comments/", "comments_page");
                echo '</ol>';
            } else {
                echo '<h2>' . Language::getTranslation("zeroComments") . '</h2>';
            }
            echo '</div>';


            //Add coment
            echo '<div id="respond" class="comment-respond">
            <h3 id="reply-title" class="comment-reply-title">' . Language::getTranslation("writeComment") . '</h3>';

            if (Core::isCaptchaEnabled()) {
                $securimage = new Securimage();
            }




            if (User::isLogged()) {
                if (isset($_POST["add_comment"])) {
                    $author = $_POST["author"];
                    $comment = htmlspecialchars($_POST["comment"]);
                    if (Core::isCaptchaEnabled() AND isset($_POST["captcha"])) {
                        $captcha = $_POST["captcha"];
                    }

                    if (mb_strlen($comment) < 2 OR mb_strlen($comment) > 999) {
                        $result = Core::result(Language::getTranslation("commentRange"), 2);
                    } elseif (!Player::isAccountProperty($author, $_SESSION["username"])) {
                        $result = Core::result(Language::getTranslation("commentAuthorError"), 2);
                    } elseif (Core::isCaptchaEnabled() AND $securimage->check($captcha) == false) {
                        $result = Core::result(Language::getTranslation("captchaWong"), 2);
                    } else {
                        $news->addComment($_GET["id"], $author, $comment);
                        $result = Core::result(Language::getTranslation("commentSuccess"), 1);
                    }
                }

                if (isset($result)) {
                    echo $result;
                }
                ?>
                <form method="post" action="<?= Links::getUrl("home") . "/full/" . $_GET["id"]; ?>" id="commentform"
                      class="comment-form">
                    <?php
                    if (User::getCountOfChars($_SESSION["username"]) > 0) {
                        echo '<div class="form-group">';
                        echo '<label for="author">' . Language::getTranslation("publishAsField") . '</label>';
                        echo '<select class="form-control" id="author" name="author">';
                        echo '<option name="' . $_SESSION["username"] . '">' . $_SESSION["username"] . '</option>';
                        foreach (User::getAllCharsName($_SESSION["username"]) as $row2) {
                            echo '<option name="' . $row2["name"] . '">' . $row2["name"] . '</option>';
                        }
                        echo '</select>';
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group">
                        <label for="comment"><?= Language::getTranslation("commentField"); ?></label>
                        <textarea class="form-control" id="comment" name="comment" required></textarea>
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
                    <button class="btn btn-primary" name="add_comment"
                            type="submit"><?= Language::getTranslation("submit"); ?></button>
                </form>
            <?php
            } elseif (!Core::newsCommentsOnlyLoggedUsers() AND !User::isLogged()) {
                // Everybody can comment
                if (isset($_POST["add_comment"])) {
                    if(empty($_POST["author"]) OR $_POST["author"] == "")
                    {
                        $author = Language::getTranslation("publishedAnonym");
                    } else {
                        $author = htmlspecialchars($_POST["author"]);
                    }
                    $comment = htmlspecialchars($_POST["comment"]);
                    if (Core::isCaptchaEnabled() AND isset($_POST["captcha"])) {
                        $captcha = $_POST["captcha"];
                    }

                    if (mb_strlen($author) < 3 OR mb_strlen($author) > 19)
                    {
                        $result = Core::result(Language::getTranslation("authorRange"), 2);
                    } elseif (mb_strlen($comment) < 2 OR mb_strlen($comment) > 999) {
                        $result = Core::result(Language::getTranslation("commentRange"), 2);
                    } elseif($author != Language::getTranslation("publishedAnonym") AND (User::usernameExists($author) OR Player::playerNameExists($author))) {
                        $result = Core::result(Language::getTranslation("cannotChooseThisName"), 2);
                    } elseif (Core::isCaptchaEnabled() AND $securimage->check($captcha) == false) {
                        $result = Core::result(Language::getTranslation("captchaWong"), 2);
                    } else {
                        $news->addComment($_GET["id"], $author, $comment);
                        $result = Core::result(Language::getTranslation("commentSuccess"), 1);
                    }
                }

                if (isset($result)) {
                    echo $result;
                }
                ?>
                <form method="post" action="<?= Links::getUrl("home") . "/full/" . $_GET["id"]; ?>" id="commentform"
                      class="comment-form">
                    <div class="form-group comment-form-author">
                        <label for="author"><?= Language::getTranslation("publishAsField");?></label>
                        <input class="form-control" id="author" name="author" type="text" value="">
                    </div>
                    <div class="form-group">
                        <label for="comment"><?= Language::getTranslation("commentField");?></label>
                        <textarea class="form-control" id="comment" name="comment" required></textarea>
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
                    <button name="add_comment" class="btn btn-primary" type="submit"><?= Language::getTranslation("submit"); ?></button>
                </form>
            <?php

            } else {
                echo Core::result(Language::getTranslation("notLogged"), 4);
            }

            echo '</div>';
            //Add coment
        }


    //Read more
    } else {
        //All news

        // Paginator
        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
        $totalCount = Database::query("SELECT * FROM " . $dbname . ".news");
        $perPage = $news->getNewsPerPage();
        $paginator = new Paginator($page, $totalCount, $perPage);
        // Paginator

        // Validate page
        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
            Core::redirect(Links::getUrl("home"), 0);
            die();
        }
        // Validate page


        // Print all news and pagination links
        $news->printNews("SELECT * FROM " . $dbname . ".news ORDER BY `important` DESC, `date` DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
        $paginator->printLinks("news/", "pagination");
        // Print all news and pagination links

    }
}


?>
</div>
