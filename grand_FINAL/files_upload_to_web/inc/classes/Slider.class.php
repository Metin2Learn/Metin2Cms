<?php

class Slider
{

    public function isSliderEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'slider_enabled'");
        if($query["value"] == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function sliderEnabled()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `value` FROM ".$dbname.".web_settings WHERE `option` = 'slider_enabled'");
        if($query["value"] == 1)
        {
            return true;
        } else {
            return false;
        }
    }

    public function getNumberOfSliderItems()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".slider");
        return $query;
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".slider WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".slider WHERE id = ?", array($id));
    }

    public function getInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".slider WHERE id = ?", array($id));
        return $query;
    }

    public function printSliderItems($query, $param)
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
            echo '<td class="text-center">'.$row["description"].'</td>';
            echo '<td class="text-center">'.$row["link"].'</td>';
            echo '<td class="text-center"><img style="width:300px;height:200px;" src="../assets/images/slider/'.$row["img"].'"></td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=slider&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=slider&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function addItem($link, $img, $description, $mini_description, $alt)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".slider
        (link, img, description, mini_description, alt) VALUES (?, ?, ?, ?, ?)",
            array($link, $img, $description, $mini_description, $alt));
    }

    public function updateItem($link, $img, $description, $mini_description, $alt, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".slider SET link = ?, img = ?, description = ?, mini_description = ?, alt = ? WHERE id = ?",
            array($link, $img, $description, $mini_description, $alt, $id));
    }


    public function makeSlider()
    {
        if(self::getNumberOfSliderItems() > 0 AND self::isSliderEnabled()) {
            global $dbname;
            $query = Database::queryAll("SELECT * FROM " . $dbname . ".slider");
            $html = '<div id="jumbotron-slider">';
            foreach ($query as $row) {
                $html .= '<div class="item">' . "\n";
                if($row["link"] != NULL AND mb_strlen($row["link"]) > 0)
                {
                    $html .= '<a href="' . $row["link"] . '">' . "\n";
                }
                $html .= '<div class="overlay-wrapper">' . "\n";
                $html .= '<img src="assets/images/slider/' . $row["img"] . '" class="img-responsive" alt="' . $row["alt"] . '">' . "\n";
                $html .= '<span class="overlay"></span>' . "\n";
                $html .= '<h2>' . $row["description"] . '<span>' . $row["mini_description"] . '</span></h2>' . "\n";
                $html .= '</div>';
                if($row["link"] != NULL AND mb_strlen($row["link"]) > 0)
                {
                    $html .= '</a>';
                }
                $html .= '</div>' . "\n";
            }
            $html .= '</div>';
            echo $html;
        }
    }

}

?>