<?php
    $dl = new Download();
?>
<div class="box">
    <h2><?= Language::getTranslation("dlTitle");?></h2>
    <?php
    if($dl->numberOfDownloads() <= 0)
    {
        echo Core::result(Language::getTranslation("dlNothing"), 4);
    } else {
        // Paginator
        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
        $totalCount = $dl->numberOfDownloads();
        $perPage = $dl->showPerPage();
        $paginator = new Paginator($page, $totalCount, $perPage);
        // Paginator

        //Validate page
        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
            Core::redirect(Links::getUrl("download"), 0);
            die();
        }
        //Validate page

        // Print downloads and pagination
        global $dbname;
        $dl->printDownloads("SELECT * FROM " . $dbname . ".downloads ORDER BY `order` DESC, `date` LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
        $paginator->printLinks("download/", "pagination");
        // Print downloads and pagination

        ?>
    <?php
    }
?>
</div>