<?php

class Partners
{

    public function getNumberOfPartners()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".partners");
        return $query;
    }

    public function addPartner($title, $alt, $link, $img, $blank)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".partners
        (title, alt, link, img, blank, `order`) VALUES (?, ?, ?, ?, ?, 0)",
            array($title, $alt, $link, $img, $blank));
    }

    public function updatePartner($title, $alt, $link, $img, $blank, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".partners SET title = ?, alt = ?, link = ?, img = ?, blank = ? WHERE id = ?",
            array($title, $alt, $link, $img, $blank, $id));
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".partners WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function info($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".partners WHERE id = ?", array($id));
        return $query;

    }

    public function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".partners WHERE id = ?", array($id));
    }

    public function makePanel()
    {
        if(self::getNumberOfPartners() > 0 AND Core::isPartnerPanelEnabled())
        {
            echo '<div class="box colored tournament-partner">'."\n";
            echo '<div class="row">'."\n";
            global $dbname;
            $query = Database::queryAll("SELECT * FROM ".$dbname.".partners ORDER BY `order` DESC");
            foreach($query as $row)
            {
                echo '<div class="col-xs-4">';
                if($row["blank"] == 1) {
                    echo '<a href="' . $row["link"] . '" target="_blank">';
                } else {
                    echo '<a href="' . $row["link"] . '">';
                }
                    echo '<img src="'.$row["img"].'" class="img-responsive center-block" alt="'.$row["alt"].'">';
                    echo '</a></div>'."\n";
            }
            echo '</div></div>'."\n";

        }
    }



    public function printAdmin($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("link").'</th>
                        <th class="text-center">'.Language::getTranslation("image").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            echo '<td class="text-center">'.$row["link"].'</td>';
            echo '<td class="text-center"><img style="width:300px;height:200px;" src="'.$row["img"].'"></td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=partners&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=partners&delete=' . $row["id"] . '" ';
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