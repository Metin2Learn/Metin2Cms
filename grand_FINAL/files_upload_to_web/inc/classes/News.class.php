<?php

class News
{

    public function getNumberOfNews()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news");
        return $query;
    }

    public static function addNews($title, $intro, $content, $author, $important, $img)
    {
        global $dbname;
        $query = Database::query("INSERT INTO ".$dbname.".news
        (title, intro, content, author, important, `date`, img) VALUES (?,?,?,?,?,?,?)",
            array($title, $intro, $content, $author, $important, date('Y-m-d H:i:s'), $img));
    }

    public static function NumberOfNews()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news");
        return $query;
    }

    public function getNewsPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'news_per_page'");
        return $query["value"];
    }

    public function doesExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news WHERE id = ?", array($id));
        return $query > 0 ? true : false;
    }

    public function remove($id)
    {
        global $dbname;
        $query = Database::query("DELETE FROM ".$dbname.".news WHERE id = ?", array($id));
    }

    public function commentsUsersPerPage()
    {
        return 9992681;
    }

    public function printNews($query, $lol)
    {
        if(self::getNumberOfNews() > 0)
        {
            $html = '';
            $query = Database::queryAll($query, $lol);
            foreach($query as $row)
            {
                $dateOriginal = $row["date"];
                $date = explode("-", $dateOriginal);
                $day = explode(" ", $date[2]);
                $month = $date[1];
                $year = $date[0];
                $html .= '<article class="post">'."\n";
                $html .= '<div class="post-date-wrapper">'."\n";
                $html .= '<div class="post-date">'."\n";
                $html .= '<div class="day">'.$day[0].'</div>'."\n";
                $html .= '<div class="month">'.Language::getMonth($month, true).' '.$year.'</div>'."\n";
                $html .= '</div>'."\n";
                $html .= '</div>'."\n";
                $html .= '<div class="post-body">'."\n";
                $html .= '<h2>'.$row["title"].'</h2>'."\n";
                $html .= '<p>'."\n";
                if($row["img"] != NULL OR $row["img"] != "")
                {
                    $html .= '<img src="assets/images/news/'.$row["img"].'" class="img-responsive" alt="">';
                }
                if($row["intro"] != NULL AND $row["intro"] != '')
                {
                    $html .= $row["intro"];
                } else {
                    if(mb_strlen($row["content"]) > 800) {
                        $html .= mb_substr($row["content"], 0, 790) . Language::getTranslation("clickOnViewMore");
                    } else {
                        $html .= $row["content"];
                    }
                }
                $html .= '</p>'."\n";
                $html .= '<div class="post-info">'."\n";
                $html .= '<span>'.Language::getTranslation("postedBy").' : '.$row["author"].'</span>'."\n";
                $html .= '<a href="'.Links::getUrl("home").'/full/'.$row["id"].'" class="btn btn-inverse">'.Language::getTranslation("viewMore").'</a>'."\n";
                $html .= '</div></div></article>';
            }
            echo $html;
        } else {
            echo "<code>News was not found !</code>";
        }
    }

    public function commentsPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'news_comments_per_page'");
        return $query["value"];
    }

    public function deleteComment($id)
    {
        global $dbname;
        $query = Database::query("DELETE FROM ".$dbname.".news_comments WHERE id = ?", array($id));
    }

    public function commentExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news_comments WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function addComment($news_id, $author, $text)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".news_comments
        (news_id, author, content, `date`) VALUES (?, ?, ?, ?)", array($news_id, $author, $text, date('Y-m-d H:i:s')));
    }

    public function printComments($query, $param, $id)
    {
        $html = '';
        $query = Database::queryAll($query, $param);
        foreach($query as $row)
        {
            $html .= '<li class="comment"><div class="avatar"><img src="assets/images/avatars/no_avatar.jpg" alt=""></div>';
            $html .= '<div class="comment-body">';
            $html .= '<div class="author">';
            $html .= '<h3>'.$row["author"].'</h3>';
            $html .= '<div class="meta"><span class="date" title="'.Core::makeNiceDate($row["date"]).'">
            '.Core::makeNiceDate($row["date"]).'</span></div>';
            $html .= '</div>';
            $html .= '<p class="message">'.$row["content"].'</p>';
            $html .= '</div>';
            if(User::isLogged() AND Admin::hasRight($_SESSION["username"], "h") == true)
            {
                $html .= '<b>admin</b> : <a target="_blank" href="admin/index.php?page=news-comments&show='.$id.'&delete='.$row["id"].'">'.Language::getTranslation("deleteComment").'</a>';
            }
            $html .= '</li>';

        }

        return $html;
    }

    public function printAdminComments($query, $param, $id)
    {
        echo '<table class="table table-striped">';
        $query = Database::queryAll($query, $param);
        foreach($query as $row)
        {
            // TODO : Přidat odkaz na uživatele (admin info)
            echo '<tr>';
            echo '<td><strong><a href="">'.$row["author"].'</a></strong><br>'.$row["content"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-right"><a href="index.php?page=news-comments&show='.$id.'&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a></td>
            <?php
            echo '</tr>';

        }

        echo '</table>';
    }

    public static function adminInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".news WHERE id = ?", array($id));
        return $query;
    }

    public static function getTitle($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `title` FROM ".$dbname.".news WHERE id = ?", array($id));
        return $query["title"];
    }

    public static function printAdminNews($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th>'.Language::getTranslation("title").'</th>
                        <th>'.Language::getTranslation("content").'</th>
                        <th>'.Language::getTranslation("comments").'</th>
                        <th>'.Language::getTranslation("author").'</th>
                        <th>'.Language::getTranslation("date").'</th>
                        <th>'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td>'.$row["title"].'</td>';
            echo '<td>'.mb_substr(htmlspecialchars($row["content"]),0, 30).' ...</td>';
            echo '<td><span class="label label-primary">'.self::comments($row["id"]).'</span></td>';
            echo '<td>'.$row["author"].'</td>';
            echo '<td>'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td>';
            if(Admin::hasRight($_SESSION["username"], "ch") == true) {
                echo '<a href="index.php?page=edit-news&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            }
            if(Admin::hasRight($_SESSION["username"], "i") == true) {
                echo '<a href="index.php?page=all-news&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            }
            if(Admin::hasRight($_SESSION["username"], "h") == true)
            {
                echo '<a href="index.php?page=news-comments&show=' . $row["id"] . '"><i class="fa fa-comments bg-green action"></i></a>';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>
                </table>';
    }


    public function details($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".news WHERE `id` = ?", array($id));
        $dateOriginal = $query["date"];
        $date = explode("-", $dateOriginal);
        $day = explode(" ", $date[2]);
        $month = $date[1];
        $year = $date[0];
        $html = '';
        $html .= '<article class="post">'."\n";
        $html .= '<div class="post-date-wrapper">'."\n";
        $html .= '<div class="post-date">'."\n";
        $html .= '<div class="day">'.$day[0].'</div>'."\n";
        $html .= '<div class="month">'.Language::getMonth($month, true).' '.$year.'</div>'."\n";
        $html .= '</div>'."\n";
        $html .= '</div>'."\n";
        $html .= '<div class="post-body">'."\n";
        $html .= '<h2>'.$query["title"].'</h2>'."\n";
        $html .= '<p>'."\n";
        if($query["img"] != NULL OR $query["img"] != "")
        {
            $html .= '<img src="assets/images/news/'.$query["img"].'" class="img-responsive" alt="">';
        }
        if($query["intro"] != NULL AND $query["intro"] != '')
        {
            $html .= $query["intro"];
            $html .= '<br /><br />';
            $html .= $query["content"];
        } else {
            $html .= $query["content"];
        }
        $html .= '</p>'."\n";
        $html .= '<div class="post-info">'."\n";
        $html .= '<span>'.Language::getTranslation("postedBy").' : '.$query["author"].'</span>'."\n";
        //$html .= '<a href="'.Links::getUrl("home").'" class="btn btn-inverse">'.Language::getTranslation("viewMore").'</a>'."\n";
        if(self::commentsEnabled()) {
            $html .= '<a href="#respond" class="btn btn-primary scroll">' . Language::getTranslation("addComment") . '</a>';
        } else {
            $html .= '<a class="btn btn-primary scroll">' . Language::getTranslation("commentsDisabled") . '</a>';
        }
        $html .= '</div></div></article>';

        return $html;
    }

    public function numberOfComments($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news_comments WHERE news_id = ?", array($id));
        return $query;
    }

        public static function comments($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".news_comments WHERE news_id = ?", array($id));
        return $query;
    }

    public function commentsEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'news_comments'");
        return $query["value"] == 1 ? true : false;
    }

    public function onlyUsersComments()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'news_comments_login_only'");
        return $query["value"] == 1 ? true : false;
    }

}

?>