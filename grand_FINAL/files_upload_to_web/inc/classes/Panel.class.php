<?php

class Panel
{

    public function getNumberOfPanels($active = true)
    {
        global $dbname;
        if($active == true) {
            $query = Database::query("SELECT * FROM " . $dbname . ".panels WHERE `active` = 1 AND `title` != 'server_status'");
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".panels");
        }
        return $query;
    }

    public static function addonExists($addon)
    {
        if(file_exists("addons/panels/".$addon) AND is_dir("addons/panels/".$addon) AND
            file_exists("addons/panels/".$addon."/".$addon."_panel.php") AND
            filesize("addons/panels/".$addon."/".$addon."_panel.php") > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public static function getServerStatusPanel()
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".panels WHERE `title` = 'server_status'");
        $exec = substr($query["content"], 11, -1);
        if(ctype_alnum($exec) AND self::addonExists($exec) AND $query["active"] == 1)
        {

                require_once("addons/panels/".$exec."/".$exec."_panel.php");

        } else {
            if($query["active"] == 1)
            {
                return $query["content"];
            }
        }
    }

    public function printPanels()
    {
        if(self::getNumberOfPanels(true) > 0) {
            global $dbname;
            //$html = '';
            $query = Database::queryAll("SELECT * FROM " . $dbname . ".panels WHERE `active` = 1 AND `title` != 'server_status' ORDER BY `order` DESC");
            foreach ($query as $row) {
                $exec = substr($row["content"], 11, -1);
                if(ctype_alnum($exec) AND self::addonExists($exec) AND $row["active"] == 1 )
                {

                        require_once("addons/panels/".$exec."/".$exec."_panel.php");

                } else {
                        echo '<div class="box sidebar-box widget-wrapper">' . "\n";
                        echo '<h3>' . $row["title"] . '</h3>' . "\n";
                        echo $row["content"] . "\n";
                        echo '</div>' . "\n";

                }
            }

        } else {
            echo 'Panels not found. Please add new panel !';
        }
    }

    public function getFooterBoxInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".footer_box WHERE id = ?", array($id));
        return $query;
    }

    public function footerBoxExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".footer_box WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function updateFooterBox($id, $title, $content)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".footer_box SET title = ?, content = ? WHERE id = ?",
            array($title, $content, $id));
    }

    public function printAdminFooterBox($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("position").'</th>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.Language::getTranslation($row["position"]).'</td>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=footer-box&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function numberOfServerServices()
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".server_status");
        return $query;
    }

    public function serverServiceExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".server_status WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function addServerService($title, $ip, $port)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".server_status
        (`name`, ip, port) VALUES (?,?,?)", array($title, $ip, $port));
    }

    public function updateServerService($title, $ip, $port, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".server_status SET `name` = ?, ip = ?, port = ? WHERE id = ?",
            array($title, $ip, $port, $id));
    }

    public function deleteServerService($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".server_status WHERE id = ?", array($id));
    }

    public function serverServiceInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".server_status WHERE id = ?", array($id));
        return $query;
    }

    public function printAdminServerStatus($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("ip").'</th>
                        <th class="text-center">'.Language::getTranslation("port").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["name"].'</td>';
            echo '<td class="text-center">'.$row["ip"].'</td>';
            echo '<td class="text-center">'.$row["port"].'</td>';
            echo '<td class="text-center">';
            echo '<a href="index.php?page=server-status&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=server-status&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function panelExists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".panels WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function panelInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".panels WHERE id = ?", array($id));
        return $query;
    }

    public function addPanel($title, $content, $visible)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".panels
        (title, content, `order`, active) VALUES (?, ?, 0, ?)",
            array($title, $content, $visible));
    }

    public function updatePanel($title, $content, $visible, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".panels SET title = ?, content = ?, active = ? WHERE id = ?",
            array($title, $content, $visible, $id));
    }

    public function deletePanel($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".panels WHERE id = ?", array($id));
    }

    public function printAdminPanels($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("active").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            if($row["active"] == 1)
            {
                echo '<td class="text-center"><span class="label label-success">'.Language::getTranslation("yes").'</span></td>';
            } else {
                echo '<td class="text-center"><span class="label label-danger">'.Language::getTranslation("no").'</span></td>';
            }
            echo '<td class="text-center">';
            echo '<a href="index.php?page=panels&edit=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
            echo '<a href="index.php?page=panels&delete=' . $row["id"] . '" ';
            ?>
            onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"><i
            class="fa fa-times bg-red action"></i></a>
            <?php
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public function printFooterBox()
    {
        if(Core::isFooterBoxEnabled())
        {
            global $dbname;
            $query = Database::queryAll("SELECT * FROM ".$dbname.".footer_box ORDER BY FIELD(position, 'left','mid','right')");
            echo '<div class="footer-boxes">'."\n";
            echo '<div class="row">'."\n";

            foreach($query as $row)
            {
                if($row["position"] == 'mid')
                {
                    echo '<div class="col-sm-6 col-md-4">'."\n";
                } else {
                    echo '<div class="col-md-4 hidden-xs hidden-sm">' . "\n";
                }
                echo '<div class="box">'."\n";
                echo '<h4>'.$row["title"].'</h4>'."\n";
                $exec = substr($row["content"], 11, -1);
                if(ctype_alnum($exec) AND self::addonExists($exec))
                {
                    require_once("addons/panels/".$exec."/".$exec."_panel.php");
                } else {
                    echo '<p>' . $row["content"] . '</p>' . "\n";
                }
                echo '</div></div>'."\n";
            }
            echo '</div></div>';
        }
    }

}

?>