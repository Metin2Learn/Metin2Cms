<?php

echo '<div class="box footer-posts">';
	if(News::NumberOfNews() > 0)
    {
        echo '<ul class="list-unstyled">';
        $query = Database::queryAll("SELECT * FROM ".$dbname.".news ORDER BY `date` DESC LIMIT 5");
        foreach($query as $row2)
        {
            echo '<li><a href="'.Links::getUrl("home")."/full/".$row2["id"].'">'.$row2["title"].'</a>
                <span class="post-date">'.Core::makeShortDate($row2["date"]).'</li>';
        }
        echo '</ul>';
    } else {
        echo Language::getTranslation("zeroNews");
    }
echo '</div>';

?>