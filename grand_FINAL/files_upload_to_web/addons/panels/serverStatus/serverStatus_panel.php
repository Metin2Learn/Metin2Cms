<table class="table table-bordered table-header">
    <thead>
    <tr>
        <th></th>
        <th><?= Language::getTranslation("service");?></th>
        <th><?= Language::getTranslation("status");?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    global $dbname;
    $query = Database::queryAll("SELECT * FROM ".$dbname.".server_status");
    foreach($query as $row)
    {
        echo '<tr>';
        if(Core::checkStatus($row["ip"], $row["port"]))
        {
            echo '<td class="text-center"><i class="fa fa-check"></i></td>';
            echo '<td>'.$row["name"].'</td>';
            echo '<td>'.Language::getTranslation("online").'</td>';
        } else {
            echo '<td class="text-center"><i class="fa fa-times"></i></td>';
            echo '<td>'.$row["name"].'</td>';
            echo '<td>'.Language::getTranslation("offline").'</td>';
        }
        echo '</tr>';
    }
    ?>
    </tbody>
</table>