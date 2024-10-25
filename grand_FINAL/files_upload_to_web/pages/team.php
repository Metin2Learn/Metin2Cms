<?php
$team = new Team();
if(isset($_GET["cat"]) AND $team->categoryExists($_GET["cat"]) == false)
{
    Core::redirect(Links::getUrl("team")."/".$team->firstCategory(), 0);
    die();
}
$id = isset($_GET["cat"]) ? $_GET["cat"] : $team->firstCategory();

    ?>
    <div class="box">

    <?php
    if($team->numberOfCategories() <= 0)
    {
        echo Core::result(Language::getTranslation("tNoCategories"), 3);
    } else {
        ?>
        <ul class="list-unstyled list-inline team-categories">
            <?php
            foreach ($team->categories() as $row) {
                if($team->numberOfMembers($row["id"]) > 0) {
                    if (isset($id) AND $id == $row["id"]) {
                        echo '<li><a href="' . Links::getUrl("team") . '/' . $row["id"] . '" class="btn btn-primary active">' . $row["name"] . '</a></li>';
                    } else {
                        echo '<li><a href="' . Links::getUrl("team") . '/' . $row["id"] . '" class="btn btn-primary">' . $row["name"] . '</a></li>';
                    }
                }
            }
            ?>
        </ul>
    <?php
    }

    if($team->numberOfMembers($id) <= 0)
    {
        echo Core::result(Language::getTranslation("tNoMembers"), 4);
    } else {
        echo '<div class="team-members-wrapper">';

        foreach($team->allMembers($id) as $row2)
        {
            echo '<div class="team-member">';
            echo '<div class="row">';
            if($row2["avatar"] == NULL)
            {
                echo '<div class="col-xs-3"><img src="assets/images/avatars/no_avatar.jpg" class="img-responsive center-block img-circle" alt=""></div>';
            } else {
                echo '<div class="col-xs-3"><img src="assets/images/avatars/'.$row2["avatar"].'" class="img-responsive center-block img-circle" alt=""></div>';
            }
            echo '<div class="col-xs-9">';
            echo '<h2>'.$row2["name"].' <small>'.$row2["ingame_nick"].'</small></h2>';
            echo '<ul class="list-unstyled">';
            echo '<li><strong>'.Language::getTranslation("memberSince").'</strong>'.Core::makeNiceDate($row2["since"]).'</li>';
            echo '<li><strong>'.Language::getTranslation("memberPosition").'</strong>'.$row2["position"].'</li>';
            if($row2["contact"] != NULL) {
                echo '<li><strong>' . Language::getTranslation("memberContact") . '</strong>' . $row2["contact"] . '</li>';
            }
            echo '</ul>';
            if(mb_strlen($row2["desc"]) > 1) {
                echo '<p>' . $row2["desc"] . '</p>';
            }
            if($row2["facebook"] != NULL OR $row2["twitter"] != NULL OR $row2["gplus"] != NULL)
            {
                echo '<ul class="brands brands-tn brands-circle brands-colored brands-inline">';
                if($row2["facebook"] != NULL)
                {
                    echo '<li><a href="'.$row2["facebook"].'" target="_blank" class="brands-facebook"><i class="fa fa-facebook"></i></a></li>';
                }
                if($row2["twitter"] != NULL)
                {
                    echo '<li><a href="'.$row2["twitter"].'" target="_blank" class="brands-twitter"><i class="fa fa-twitter"></i></a></li>';
                }
                if($row2["gplus"] != NULL)
                {
                    echo '<li><a href="'.$row2["gplus"].'" target="_blank" class="brands-google-plus"><i class="fa fa-google-plus"></i></a></li>';
                }
                echo '</ul>';
            }
            echo '</div></div></div>';
        }
        
}
?>