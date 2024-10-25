<?php
if(Admin::hasRight($_SESSION["username"], "w") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ticket = new TicketSystem();

if(isset($_GET["delete"]) AND $ticket->categoryExists($_GET["delete"]))
{
    $ticket->deleteCategory($_GET["delete"]);
    $result = Core::result(Language::getTranslation("categoryDeleted"), 1);
}
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("ticketCategories") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("ticketCategories") ?></li>
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
                    $totalCount = $ticket->numberOfCategories();
                    $perPage = 10;
                    $paginator = new Paginator($page, $totalCount, $perPage);
                    // Paginator

                    // Validate page
                    if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                        Core::redirect("index.php?page=all-ticket-categories", 0);
                        die();
                    }
                    // Validate page


                    // Print all news and pagination links
                    global $dbname;
                    $ticket->printAdminCategories("SELECT * FROM " . $dbname . ".ticket_system_category LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                    $paginator->printLinks("index.php?page=all-ticket-categories&pagination=", "pagination");
                    // Print all news and pagination links
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>