<?php
if (Admin::hasRight($_SESSION["username"], "s") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

$team = new Team();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editCategory") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("teamMembers") ?></a></li>
        <li><a href="index.php?page=all-team-categories"><?= Language::getTranslation("viewCategories") ?></a></li>
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
                    if (isset($_GET["id"]) AND $team->categoryExists($_GET["id"])) {
                        if (isset($_POST["update_category"])) {
                            $name = $_POST["name"];
                            if (mb_strlen($name) < 1) {
                                $result = Core::result(Language::getTranslation("nameMustBeAtLeast2chars"), 2);
                            } elseif ($team->catExists($name)) {
                                $result = Core::result(Language::getTranslation("categoryAlreadyExists"), 2);
                            } else {
                                $team->updateCategory($_GET["id"], $name);
                                $result = Core::result(Language::getTranslation("categoryUpdated"), 1);
                            }
                        }

                        $info = $team->categoryInfo($_GET["id"]);
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=edit-team-category&id=<?= $_GET["id"] ?>" class="form-horizontal"
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
