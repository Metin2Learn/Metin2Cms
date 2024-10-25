<?php
if(Admin::hasRight($_SESSION["username"], "y") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$is = new Itemshop();

if(isset($_GET["delete"]) AND $is->categoryExists($_GET["delete"]))
{
    if($is->numberOfItems($_GET["delete"]) > 0)
    {
        $result = Core::result(Language::getTranslation("cannotDeleteCategoryItemsExist"), 2);
    } else {
        $is->deleteCategory($_GET["delete"]);
        $result = Core::result(Language::getTranslation("categoryDeleted"), 1);
    }
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("viewCategories") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("viewCategories") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }

                    // Paginator
                    $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                    $totalCount = $is->numberOfCategories();
                    $perPage = $is->itemsPerPage();
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-is-categories", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $is->printAdminCategories("SELECT * FROM " . $dbname . ".itemshop_category ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-is-categories&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>