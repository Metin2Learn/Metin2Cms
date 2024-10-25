<?php

class TicketSystem
{

    public function numberOfCategories()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_category");
        return $query;
    }

    public function getCategory($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `name` FROM ".$dbname.".ticket_system_category WHERE id = ?", array($id));
        return $query["name"];
    }

    public function ticketExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function closeTicket($id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".ticket_system_tickets SET status = 'closed' WHERE id = ?", array($id));
    }

    public function categoryExists($category)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_category WHERE `id` = ?", array($category));
        return $query >= 1 ? true : false;
    }

    public function categoryNameExists($name)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_category WHERE `name` = ?", array($name));
        return $query >= 1 ? true : false;
    }

    public static function getStatus($status)
    {
        switch($status)
        {
            case "open":
                $html = Language::getTranslation("ticketSysStatusOpen");
                break;
            case "closed":
                $html = Language::getTranslation("ticketSysStatusClosed");
                break;
            case "processing":
                $html = Language::getTranslation("ticketSysStatusProcessing");
                break;
        }
        return $html;
    }

    public function isValidTicket($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE id = ? AND user_name = ?",
            array($id, $_SESSION["username"]));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }


    public static function unseenTickets($who)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE last_seen = ?", array($who));
        return $query;
    }


    public static function pendingTickets()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status = 'open'");
        return $query;
    }

    public static function printPendingTickets()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status = 'open' ORDER BY `date` DESC LIMIT 4");
        foreach($query as $row)
        {
            echo '<li>';
            echo '<a href="index.php?page=view-ticket&id='.$row["id"].'">';
            echo '<span class="subject">';
            echo '<span class="from">'.$row["user_name"].'</span>';
            echo '<span class="time">'.Core::timeAgo($row["date"]).'</span>';
            if(mb_strlen($row["subject"]) > 30)
            {
                echo '<span class="message">'.substr($row["subject"], 0, 28).'...</span>';
            } else {
                echo '<span class="message">'.$row["subject"].'</span>';
            }
            echo '</span>';
            echo '</a></li>';
        }
        echo '<li class="footer"><a href="index.php?page=all-tickets">'.Language::getTranslation("viewAllTickets").'</a></li>';
    }

    public function addAnswer($id, $text)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".ticket_system_answers
        (`ticket_id`,`text`,`from_name`,`from_ip`, `date`) VALUES (?, ?, ?, ?, ?)",
            array($id, $text, $_SESSION["username"], $_SERVER["REMOTE_ADDR"], date('Y-m-d H:i:s')));
    }

    public function isClosed($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `status` FROM ".$dbname.".ticket_system_tickets WHERE `id` = ?", array($id));
        return $query["status"] == "closed" ? true : false;
    }

    public function printUserTickets($query, $param)
    {
        $html = '<div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                <th></th>
                    <th class="text-center">'.Language::getTranslation("ticketSysAddSubject").'</th>
                    <th class="text-center">'.Language::getTranslation("ticketSysStatus").'</th>
                    <th class="text-center">'.Language::getTranslation("date").'</th>
                </tr>
                </thead>
                <tbody>';

        $query = Database::queryAll($query, $param);
        foreach($query as $row)
        {
            $html .= '<tr>';
            $html .= '<td class="text-center"><a href="'.Links::getUrl("account ticket-view-show").$row["id"].'"><i class="fa fa-eye"></i></a></td>';
            $html .= '<td class="text-center">'.$row["subject"].'</td>';
            $html .= '<td class="text-center">'.strtoupper(self::getStatus($row["status"])).'</td>';
            $html .= '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            $html .= '</tr>';
        }
        $html .= '
                </tbody>
            </table>
        </div>';
        return $html;
    }

    public function showInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE id = ? AND user_name = ?",
            array($id, $_SESSION["username"]));
        $html = '
<div class="box forum-post-wrapper">
    <div class="row">
        <div class="col-sm-3">
            <div class="author-detail">
                <h3><a>'.$query["user_name"].'</a></h3>
                <p class="function">'.Language::getTranslation("ticketSysUser").'</p>
                <ul class="list-unstyled">
                    <li><strong>'.Language::getTranslation("date").'</strong><br />'.Core::makeNiceDate($query["date"]).'</li>
                    <li><strong>'.Language::getTranslation("ticketSysCategory").'</strong><br />'.self::getCategory($query["category_id"]).'</li>
                    <li><strong>'.Language::getTranslation("ticketSysStatus").'</strong><br />'.self::getStatus($query["status"]).'</li>
                </ul>
            </div>
        </div>
        <div class="col-sm-9">
            <article class="forum-post">
                <div class="date">'.$query["subject"].'</div>
                    <p>'.$query["text"].'</p>
            </article>
        </div>
    </div>
</div>';

        return $html;


    }

    public function getInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE id = ?", array($id));
        return $query;
    }

    public function printAnswers($id)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".ticket_system_answers WHERE ticket_id = ? ORDER BY `date` ASC", array($id));
        $html = '';
        foreach($query as $row)
        {
            $html .= '<div class="box forum-post-wrapper">';
            $html .= '<div class="row">';
            $html .= '<article class="forum-post">';
            if($row["is_admin"] == 1)
            {
                $html .= '<h2><span class="label label-danger">'.Language::getTranslation("ticketSysAdminAnswered").'</span></h2>';
            } else {
                $html .= '<h2>'. $row["from_name"] .Language::getTranslation("ticketSysAnswered").'</h2>';
            }
            $html .= '<p>'.$row["text"].'</p>';
            $html .= '<br /><span class="btn-info">'.Core::makeNiceDate($row["date"]).'</span>';
            $html .= '</article></div></div>';
        }
        return $html;
    }

    public function numberOfAnswers($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_answers WHERE ticket_id = ?", array($id));
        return $query;
    }

    public function isNotClosed($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status != 'closed' AND id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function ticketsPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'user_tickets_per_page'");
        return $query["value"];
    }

    public function getCategoryName($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `name` FROM ".$dbname.".ticket_system_category WHERE id = ?", array($id));
        return $query["name"];
    }

    public function numberOfAllTickets()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets");
        return $query;
    }

    public static function count()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets");
        return $query;
    }

    public function addCategory($name, $added_by)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".ticket_system_category
        (`name`, `added_by`) VALUES (?, ?)", array($name, $added_by));
    }

    public function printOpenTickets($query, $param)
    {

        echo '<div class="grid support-content"><ul class="list-group fa-padding">';
        $mainQuery = Database::queryAll($query, $param);

        foreach($mainQuery as $row) {
            ?>
            <li class="list-group-item"
                onclick="window.location.href = 'index.php?page=view-ticket&id=<?= $row["id"] ?>';">
                <div class="media">
                    <i class="fa fa-file-o pull-left"></i>

                    <div class="media-body">
                        <?php
                        echo '<strong>' . $row["subject"] . '</strong> ';
                        if ($row["status"] == 'open') {
                            echo '<span class="label label-primary">' . Language::getTranslation("open") . '</span>';
                        } elseif ($row["status"] == 'processing') {
                            echo '<span class="label label-success">' . Language::getTranslation("processing") . '</span>';
                        } elseif ($row["status"] == 'closed') {
                            echo '<span class="label label-danger">' . Language::getTranslation("closed") . '</span>';
                        }
                        echo '<span class="number pull-right">';

                        echo '# '.$row["id"].'</span>';
                        // TODO : Dát do odkazu jméno na uživatele
                        echo '<p class="info">' . Language::getTranslation("openedBy") .'<a>'. $row["user_name"] . '</a> | <i class="fa fa-clock-o"></i> ' . Core::makeNiceDate($row["date"]) . '';
                        echo ' | <i class="fa fa-list-alt"></i> ' . Language::getTranslation("category").': <a>' . self::getCategoryName($row["category_id"]) . '</a>';
                        if (self::numberOfAnswers($row["id"]) > 0) {
                            echo ' | <i class="fa fa-comments"></i> <a href="#">' . self::numberOfAnswers($row["id"]) . Language::getTranslation("answers") . '</a>';
                        }
                        if($row["last_seen"] == 'user')
                        {
                            echo ' | <span class="label label-warning">'.Language::getTranslation("unread").'</span>';
                        }
                        echo '</p>';
                        ?>
                    </div>
                </div>
            </li>
        <?php
        }

        echo '</ul></div>';
    }

    public function addAdminAnswer($id, $name, $answer)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".ticket_system_answers
        (ticket_id, `text`, `from_name`, `from_ip`, `date`, is_admin) VALUES (?, ?, ?, ?, ?, 1)",
            array($id, $answer, $name, $_SERVER["REMOTE_ADDR"], date('Y-m-d H:i:s')));
    }

    public function changeStatus($id, $status)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".ticket_system_tickets SET status = ? WHERE id = ?", array($status, $id));
    }

    public function printAdminAnswers($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        foreach($mainQuery as $row)
        {
            echo '<div class="row support-content-comment">';
            echo '<div class="col-md-2">';
            echo '<div class="text-center"><span class="label label-info">'.Core::timeAgo($row["date"]).'</span><br />';
            echo $row["from_name"].Language::getTranslation("answered").'</div>';
            echo '</div>';
            echo '<div class="col-md-10">';
            if($row["is_admin"] == 1) {
                echo '<span class="label label-danger pull-right">'.Language::getTranslation("admin").'</span><br /><p>' . $row["text"] . '</p>';
            } else {
                echo '<p>' . $row["text"] . '</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    }

    public function getCategoryInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".ticket_system_category WHERE id = ?", array($id));
        return $query;
    }

    public function numberOfUserTickets($username)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE user_name = ?", array($username));
        return $query;
    }

    public function numberOfUserAllClosedTickets()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status = 'closed'");
        return $query;
    }

    public function updateCategory($id, $new_name)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".ticket_system_category SET `name` = ? WHERE id = ?", array($new_name, $id));
    }

    public function printAdminCategories($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("addedBy").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["added_by"].'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=edit-ticket-category&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=all-ticket-categories&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function deleteCategory($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".ticket_system_category WHERE id = ?", array($id));
    }

    public function getLastSeen($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT last_seen FROM ".$dbname.".ticket_system_tickets WHERE id = ?", array($id));
        return $query["last_seen"];
    }

    public function updateLastSeen($id, $set)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".ticket_system_tickets SET last_seen = ? WHERE id = ?", array($set, $id));
    }

    public function numberOfUserAllOpenTickets()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status = 'open' OR status = 'processing'");
        return $query;
    }

    public function numberOfClosedTickets()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".ticket_system_tickets WHERE status = 'closed'");
        return $query;
    }

    public function create($subject, $category, $text)
    {
        global $dbname;
        $query = Database::queryAlone("INSERT INTO ".$dbname.".ticket_system_tickets
        (`user_name`,`user_ip`,`subject`,`category_id`,`text`,`status`, `last_seen`, `date`) VALUES
        (?, ?, ?, ?, ?, 'open', 'user', ?)", array($_SESSION["username"], $_SERVER["REMOTE_ADDR"], $subject, $category, $text, date('Y-m-d H:i:s')));
    }

    public function printCategories()
    {
        if(self::numberOfCategories() > 0) {

            global $dbname;
            $query = Database::queryAll("SELECT * FROM " . $dbname . ".ticket_system_category");
            $html = '';
            foreach ($query as $row) {
                $html .= '<option value="' . $row["id"] . '">';
                $html .= $row["name"];
                $html .= '</option>';
            }
            return $html;
        } else {
            return "<option value='error'>".Language::getTranslation('ticketSysCategoriesNotFound')."</option>";
        }

    }

}

?>