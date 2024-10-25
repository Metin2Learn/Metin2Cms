<?php

class CustomPages
{

    public function count()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".custom_pages");
        return $query;
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".custom_pages WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getLastID()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT id FROM ".$dbname.".custom_pages ORDER by id DESC LIMIT 1");
        return $query["id"];
    }

    public function add($title, $content, $admin)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".custom_pages
        (title, content, added, admin) VALUES (?, ?, ?, ?)", array($title, $content, date('Y-m-d H:i:s'), $admin));
    }

    public function update($title, $content, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".custom_pages SET title = ?, content = ? WHERE id = ?",
            array($title, $content, $id));
    }

    public function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".custom_pages WHERE id = ?", array($id));
    }

    public function info($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".custom_pages WHERE id = ?", array($id));
        return $query;
    }

    public function printPages($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("link").'</th>
                        <th class="text-center">'.Language::getTranslation("admin").'</th>
                        <th class="text-center">'.Language::getTranslation("date").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            echo '<td class="text-center"><a href="'.Core::getBaseURL().'viewpage/'.$row["id"].'">'.Core::getBaseURL().'viewpage/'.$row["id"].'</a></td>';
            echo '<td class="text-center">'.$row["admin"].'</td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["added"]).'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=custom-pages&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=custom-pages&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

}

?>