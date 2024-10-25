<?php

class Tasks
{

    public static function count($pending = false)
    {
        global $dbname;
        if($pending == true)
        {
            $query = Database::query("SELECT * FROM ".$dbname.".admin_task WHERE `percent` != 100");
        } else {
            $query = Database::query("SELECT * FROM ".$dbname.".admin_task");
        }
        return $query;
    }

    public static function printDashboard()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".admin_task LIMIT 10");
        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        echo '<tbody>';
        $i = 0;
        foreach($query as $row)
        {
            $i++;
            echo '<tr>';
            echo '<td>'.$i.'</td>';
            echo '<td>'.$row["title"].'</td>';
            echo '<td>'.Core::makeNiceDate($row["date"]).'</td>';
            if($row["percent"] <= 20)
            {
                echo '<td><span class="label label-danger">'.$row["percent"].'%</span></td>';
            } elseif($row["percent"] > 20 AND $row["percent"] <= 50)
            {
                echo '<td><span class="label label-warning">'.$row["percent"].'%</span></td>';
            } elseif($row["percent"] > 50 AND $row["percent"] <= 85)
            {
                echo '<td><span class="label label-info">'.$row["percent"].'%</span></td>';
            } elseif($row["percent"] > 85)
            {
                echo '<td><span class="label label-success">'.$row["percent"].'%</span></td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }

    public static function printPending()
    {
        global $dbname;
        $query = Database::queryAll("SELECT * FROM ".$dbname.".admin_task WHERE `percent` != 100 ORDER BY `percent`, `date` LIMIT 4");
        foreach($query as $row)
        {
            echo "<li>";
            echo '<a href="index.php?page=edit-task&id='.$row["id"].'">';
            echo '<div class="task-info">';
            echo '<div class="task-desc">'.$row["title"].'</div>';
            echo '<div class="task-percent">'.$row["percent"].'%</div>';
            echo '</div>';
            echo '<div class="progress">';
            if($row["percent"] <= 20)
            {
                echo '<div class="progress-bar progress-bar-danger" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 20 AND $row["percent"] <= 50)
            {
                echo '<div class="progress-bar progress-bar-warning" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 50 AND $row["percent"] <= 85)
            {
                echo '<div class="progress-bar progress-bar-info" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 85)
            {
                echo '<div class="progress-bar progress-bar-success" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            }
            echo '<span class="sr-only">'.$row["percent"].'% Complete</span>';
            echo '</div></div></a>';
            echo "</li>";
        }
        echo '<li class="footer"><a href="index.php?page=all-tasks">'.Language::getTranslation("viewAllTasks").'</a></li>';
    }

    public function exists($id)
    {
        global $dbname;
        $query = Database::query("SELECT * FROM ".$dbname.".admin_task WHERE id = ?", array($id));
        if($query > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function printTasks($query, $param)
    {
        $mainQuery = Database::queryAll($query, $param);
        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("title").'</th>
                        <th class="text-center">'.Language::getTranslation("description").'</th>
                        <th class="text-center">'.Language::getTranslation("status").'</th>
                        <th class="text-center">'.Language::getTranslation("added").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach($mainQuery as $row)
        {
            echo '<tr>';
            echo '<td class="text-center">'.$row["title"].'</td>';
            echo '<td class="text-center">'.$row["description"].'</td>';
            echo '<td class="text-center"><div class="progress">';
            if($row["percent"] <= 20)
            {
                echo '<div class="progress-bar progress-bar-danger" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 20 AND $row["percent"] <= 50)
            {
                echo '<div class="progress-bar progress-bar-warning" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 50 AND $row["percent"] <= 85)
            {
                echo '<div class="progress-bar progress-bar-info" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            } elseif($row["percent"] > 85)
            {
                echo '<div class="progress-bar progress-bar-success" role="progressbar"
                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: '.$row["percent"].'%">';
            }
            echo '<span class="sr-only">'.$row["percent"].'% Complete</span>';
            echo '</div></div></td>';
            echo '<td class="text-center">'.Core::makeNiceDate($row["date"]).'</td>';
            echo '<td class="text-center">';
            if(Admin::hasRight($_SESSION["username"], "i1")) {

                echo '<a href="index.php?page=all-tasks&done=' . $row["id"] . '" ';
                ?>
                onclick="return confirm('<?= Language::getTranslation("markAsDone") ?>');">
                <?php
                echo '<i class="fa fa-check bg-yellow action"></i></a> ';
                echo '<a href="index.php?page=edit-task&id=' . $row["id"] . '"><i class="fa fa-pencil bg-blue action"></i></a> ';
                echo '<a href="index.php?page=all-tasks&delete=' . $row["id"] . '" ';
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

    public function getInfo($id)
    {
        global $dbname;
        $query = Database::queryAlone("SELECT * FROM ".$dbname.".admin_task WHERE id = ?", array($id));
        return $query;
    }

    public function addTask($title, $desc, $percent)
    {
        global $dbname;
        Database::query("INSERT INTO ".$dbname.".admin_task
        (title, description, percent, `date`) VALUES (?, ?, ?, ?)",
            array($title, $desc, $percent, date('Y-m-d H:i:s')));
    }

    public function updateTask($title, $desc, $percent, $id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".admin_task SET title = ?, description = ?, percent = ? WHERE id = ?",
            array($title, $desc, $percent, $id));
    }

    public function markAsDone($id)
    {
        global $dbname;
        Database::query("UPDATE ".$dbname.".admin_task SET percent = 100 WHERE id = ?", array($id));
    }

    public function delete($id)
    {
        global $dbname;
        Database::query("DELETE FROM ".$dbname.".admin_task WHERE id = ?", array($id));
    }

}

?>