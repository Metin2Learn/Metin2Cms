<?php
if(Admin::hasRight($_SESSION["username"], "w") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ticket =  new TicketSystem();

if(isset($_POST["add_category"]))
{
    $name = $_POST["name"];
    if(mb_strlen($name) < 1)
    {
        $result = Core::result(Language::getTranslation("nameMustBeAtLeast2chars"), 2);
    } elseif($ticket->categoryNameExists($name)) {
        $result = Core::result(Language::getTranslation("categoryAlreadyExists"), 2);
    } else {
        $ticket->addCategory($name, $_SESSION["username"]);
        $result = Core::result(Language::getTranslation("categoryAdded"), 1);
    }
}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addCategory") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("ticketSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("addCategory") ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php
                    if(isset($result)) { echo $result; }
                    ?>
                    <form method="POST" action="index.php?page=add-ticket-category" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_category"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
