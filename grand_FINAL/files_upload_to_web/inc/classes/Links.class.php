<?php

class Links
{

    //TODO: Při přidávání nějakého odkazu do menu dát na `title` strtolower !

    public static function getUrl($title)
    {
        $title = mb_strtolower($title);
        global $dbname;
        $query = Database::queryAlone("SELECT `link` FROM ".$dbname.".links WHERE `title` = ?", array($title));
        return $query["link"];
    }

    public static function getTitle($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT head_title FROM ".$dbname.".links WHERE id = ?", array($id));
        return $query["head_title"];
    }

    public static function getActiveLinks()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".links WHERE visible = 1");
        return $query;
    }

    public static function sub($items, $id){
        echo '<ul class="dropdown-menu">';
        foreach($items as $item){
            if($item['parent_id'] == $id){
                echo "<li><a href='".$item['link']."'><i class='fa fa-plus'></i>".$item['head_title']."</a>";
                self::sub($items, $item['id']);
                echo "</li>";
            }
        }
        echo "</ul>";
    }

    public static function canDelete($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".links WHERE id = ? AND can_delete = 1", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".links WHERE id = ?", array($id));
    }

    public static function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".links WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function numberOfLinks($only_visible = false)
    {
        global $dbname;
        if($only_visible == true)
        {
            $query = Database::query("SELECT * FROM ".$dbname.".links WHERE visible = 1");
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".links");
        }
        return $query;
    }

    public static function numberOfChildren($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".links WHERE parent_id = ?", array($id));
        return $query;
    }

    public static function getChildren($parent)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".links WHERE parent_id = ?", array($parent));
        return $query;
    }


    public static function makeMenu()
    {
        global $dbname;
        $rows = Database::queryAll("SELECT * FROM ".$dbname.".links WHERE `visible` = 1");
        $items = $rows;
        $id = '';
        echo '<ul class="nav navbar-nav">';
        foreach($items as $item){
            if($item['parent_id'] == 0){
                if($item['is_parent'] == 1)
                {
                    echo '<li class="dropdown">';
                    echo "<a href='' class='dropdown-toggle' data-toggle='dropdown'>".$item['head_title']."</a>";
                } else {
                    echo "<li><a href='" . $item['link'] . "'>" . $item['head_title'] . "</a></li>";
                }
                $id = $item['id'];
                self::sub($items, $id);
                echo "</li>";
            }
        }
        echo "</ul>";

    }

    public static function isParent($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".links WHERE id = ? AND is_parent = 1", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function getParentID($child)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT parent_id FROM ".$dbname.".links WHERE id = ?", array($child));
        return $query["parent_id"];
    }

    public static function isChild($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".links WHERE id = ? AND parent_id != NULL", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function updateParent($id, $status)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".links SET is_parent = ? WHERE id = ?", array($status, $id));
    }

    public static function updateChild($id, $status)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".links SET parent_id = ? WHERE id = ?", array($status, $id));
    }

    public static function getAllLinks()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".links");
        return $query;
    }

    public static function addLink($link, $title, $visible, $parent)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".links
        (title, link, head_title, visible, parent_id, is_parent, can_delete) VALUES ('', ?, ?, ?, ?, 0, 1)",
            array($link, $title, $visible, $parent));
    }

    public static function updateLink($link, $title, $visible, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".links SET link = ?, head_title = ?, visible = ? WHERE id = ?",
            array($link, $title, $visible, $id));
    }

    public static function getInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".links WHERE id = ?", array($id));
        return $query;
    }

    public static function printAdminLinks($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("link").'</th>
                        <th class="text-center">'.Language::getTranslation("visible").'</th>
                        <th class="text-center">'.Language::getTranslation("parentLink").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["head_title"].'</td>';
            echo '<td class="text-center">'.$row["link"].'</td>';
            echo '<td class="text-center">'.$row["visible"].'</td>';
            echo '<td class="text-center">'.self::getTitle($row["parent_id"]).'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=menu-links&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=menu-links&delete=' . $row["id"] . '" ';
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