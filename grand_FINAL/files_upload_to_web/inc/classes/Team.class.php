<?php

class Team
{

    public function categories()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".team_category");
        return $query;
    }

    public function addMember($cat, $name, $ingame, $avatar, $contact, $position, $desc, $facebook, $twitter, $gplus)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".team_members
        (cat_id, `name`, ingame_nick, avatar, since, contact, `position`, `desc`, facebook, twitter, gplus) VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            array($cat, $name, $ingame, $avatar, date('Y-m-d H:i:s'), $contact, $position, $desc, $facebook, $twitter, $gplus));
    }

    public function updateMember($cat, $id, $name, $ingame, $avatar, $contact, $position, $desc, $facebook, $twitter, $gplus)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".team_members SET
        cat_id = ?,`name` = ?, ingame_nick = ?, avatar = ?, contact = ?, `position` = ?, `desc` = ?, facebook = ?, twitter = ?, gplus = ?
        WHERE id = ?",
            array($cat,$name, $ingame, $avatar, $contact, $position, $desc, $facebook, $twitter, $gplus, $id));
    }

    public function categoryExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_category WHERE `id` = ?", array($id));
        if ($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function memberExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_members WHERE `id` = ?", array($id));
        if ($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function removeCategory($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".team_category WHERE id = ?", array($id));
    }

    public function addCategory($name,$added)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".team_category (`name`, added) VALUES (?, ?)", array($name,$added));
    }

    public function memberInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".team_members WHERE id = ?", array($id));
        return $query;
    }

    public function deleteMember($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".team_members WHERE id = ?", array($id));
    }

    public function catExists($title)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_category WHERE `name` = ?", array($title));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function firstCategory()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `id` FROM ".$dbname.".team_category ORDER BY `id` LIMIT 1");
        return $query["id"];
    }

    public function getCategoryName($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT `name` FROM ".$dbname.".team_category WHERE id = ?", array($id));
        return $query["name"];
    }

    public function numberOfCategories()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_category");
        return $query;
    }

    public function updateCategory($id, $name)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".team_category SET `name` = ? WHERE id = ?", array($name, $id));
    }

    public function categoryInfo($cat)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".team_category WHERE id = ?", array($cat));
        return $query;
    }

    public function numberOfMembers($cat)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_members WHERE cat_id = ?", array($cat));
        return $query;
    }

    public function numberOfAllMembers()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".team_members");
        return $query;
    }

    public function allMembers($cat)
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".team_members WHERE `cat_id` = ? ORDER BY `since`", array($cat));
        return $query;
    }

    public function printAdminMembers($query, $param)
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
            echo '<td class="text-center">'.$row["added"].'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=edit-team-category&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=all-team-categories&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function printAllMembers($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("name").'</th>
                        <th class="text-center">'.Language::getTranslation("position").'</th>
                        <th class="text-center">'.Language::getTranslation("category").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["position"].'</td>';
            echo '<td class="text-center">'.self::getCategoryName($row["cat_id"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "q")) {
                echo '<a href="index.php?page=edit-team-member&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            }
            if(Admin::hasRight($_SESSION["username"], "r")) {
                echo '<a href="index.php?page=all-team-members&delete=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
                    class="fa fa-times bg-red action"></i></a>
            <?php
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

}

?>