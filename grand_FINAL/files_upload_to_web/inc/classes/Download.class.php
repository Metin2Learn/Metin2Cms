<?php

class Download
{

    public function numberOfDownloads()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".downloads");
        return $query;
    }

    public static function count()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".downloads");
        return $query;
    }

    public function showPerPage()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'dl_per_page'");
        return $query["value"];
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".downloads WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".downloads WHERE id = ?", array($id));
        return $query;
    }

    public function remove($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".downloads WHERE id = ?", array($id));
    }

    public function addDownload($title, $desc, $size, $link, $user)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".downloads
        (title, `desc`, `size`, link, `date`, author) VALUES (?, ?, ?, ?, ?, ?)",
            array($title, $desc, $size, $link, date('Y-m-d H:i:s'), $user));
    }

    public function update($title,$desc, $size, $link, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".downloads SET title = ?, `desc` = ?, `size` = ?, link = ? WHERE id = ?",
            array($title, $desc, $size, $link, $id));
    }

    public function printAdminDownloads($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("link").'</th>
                        <th class="text-center">'.Language::getTranslation("size").'</th>
                        <th class="text-center">'.Language::getTranslation("addedBy").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            echo '<td class="text-center">'.$row["link"].'</td>';
            echo '<td class="text-center"><span class="label label-primary">'.$row["size"].'</span></td>';
            echo '<td class="text-center">'.$row["author"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "l") == true) {
                echo '<a href="index.php?page=edit-download&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            }
            if(Admin::hasRight($_SESSION["username"], "n") == true) {
                echo '<a href="index.php?page=all-downloads&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>
                </table>';
    }

    public function printDownloads($query,$param)
    {
        $html = '';
        $html .= '
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>'.Language::getTranslation("dlTableTitle").'</th>
                    <th>'.Language::getTranslation("date").'</th>
                    <th>'.Language::getTranslation("dlTableSize").'</th>
                    <th>'.Language::getTranslation("dlTableDownload").'</th>
                </tr>
                </thead>
                <tbody>';
        $query = Database::queryAll($query,$param);
        foreach($query as $row)
        {
            $html .= '<tr>';
            $html .= '<td>'.$row["title"].'</td>';
            if(mb_strlen($row["desc"]) <= 0 OR $row["desc"] == NULL)
            {
                $html .= '<td>'.Language::getTranslation("dlAdded").Core::makeNiceDate($row["date"]).'</td>';
            } else {
                $html .= '<td>' . $row["desc"] . '</td>';
            }
            $html .= '<td>'.$row["size"].'</td>';
            $html .= '<td><a href="'.$row["link"].'" target="_blank"><img src="assets/icons/download.png" alt=""></a></td>';
            $html .= '</tr>';
        }
        $html .= '
                </tbody>
            </table>
        </div>';
        echo $html;
    }

}

?>