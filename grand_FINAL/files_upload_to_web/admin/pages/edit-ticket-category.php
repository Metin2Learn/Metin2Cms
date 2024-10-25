<?php
if (Admin::hasRight($_SESSION["username"], "w") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ticket = new TicketSystem();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editCategory") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li><a href="index.php?page=all-ticket-categories"><?= Language::getTranslation("ticketCategories") ?></a></li>
        <li class="active"><?= Language::getTranslation("editCategory") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">

                    <?php
                    if (isset($_GET["id"]) AND $ticket->categoryExists($_GET["id"])) {
                        if (isset($_POST["update_category"])) {
                            $name = $_POST["name"];
                            if (mb_strlen($name) < 1) {
                                $result = Core::result(Language::getTranslation("nameMustBeAtLeast2chars"), 2);
                            } elseif ($ticket->categoryNameExists($name)) {
                                $result = Core::result(Language::getTranslation("categoryAlreadyExists"), 2);
                            } else {
                                $ticket->updateCategory($_GET["id"], $name);
                                $result = Core::result(Language::getTranslation("categoryUpdated"), 1);
                            }
                        }

                        $info = $ticket->getCategoryInfo($_GET["id"]);
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=edit-ticket-category&id=<?= $_GET["id"] ?>" class="form-horizontal"
                              role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input value="<?= $info["name"] ?>" type="text" name="name" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update_category"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>

                    <?php
                    } else {
                        echo Core::result(Language::getTranslation("categoryWasNotFound"), 4);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
