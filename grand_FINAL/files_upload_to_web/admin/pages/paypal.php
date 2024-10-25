<?php
if(Admin::hasRight($_SESSION["username"], "c1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}
$is = new Itemshop();

if(isset($_POST["update_settings"]))
{
    $paypal_email = $_POST["paypal_email"];
    $paypal_currency = $_POST["paypal_currency"];
    Core::updateSettings("paypal_email", $paypal_email);
    Core::updateSettings("paypal_currency", $paypal_currency);
    $result = Core::result(Language::getTranslation("settingsUpdated"), 1);
} elseif(isset($_POST["add_option"]))
{
    $price = $_POST["price"];
    $coins = $_POST["coins"];
    $is->addPaypalOption($price, $coins);
    $result = Core::result(Language::getTranslation("paypalOptionAdded"), 1);
} elseif(isset($_GET["delete"]) AND $is->optionExists($_GET["delete"])) {
    $is->deletePaypalOption($_GET["delete"]);
    $result = Core::result(Language::getTranslation("paypalOptionDeleted"), 1);
}

?>
<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("paypalSettings") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("paypalSettings") ?></li>
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
                    <form method="post" action="index.php?page=paypal" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("paypalEmail") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= Core::getPaypalEmail() ?>" type="text" name="paypal_email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("paypalCurrency") ?></label>
                            <div class="col-sm-7">
                                <input value="<?= Core::getPaypalCurrency() ?>" type="text" name="paypal_currency" class="form-control">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" onclick="return confirm('<?= Language::getTranslation("areYouSure") ?>');"
                                    class="btn btn-primary" name="update_settings"><?= Language::getTranslation("update") ?></button>
                        </div
                    </form>
                    <hr />
                    <h2><?= Language::getTranslation("paymentOptions") ?></h2>
                    <form method="post" action="index.php?page=paypal" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("price") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("coins") ?></label>
                            <div class="col-sm-7">
                                <input type="number" name="coins" class="form-control">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" name="add_option"><?= Language::getTranslation("add") ?></button>
                        </div
                    </form>
                    <hr />
                    <?php
                    if($is->numberOfPaypalOptions() > 0)
                    {
                        echo '<table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">'.Language::getTranslation("price").'</th>
                        <th class="text-center">'.Language::getTranslation("coins").'</th>
                        <th class="text-center">'.Language::getTranslation("action").'</th>
                    </tr>
                    </thead>
                    <tbody>';
                        $info = $is->getAllPaypalOptions();
                        foreach($info as $row)
                        {
                            echo '<tr>';
                            echo '<td class="text-center">'.$row["price"].'</td>';
                            echo '<td class="text-center">'.$row["coins"].'</td>';
                            echo '<td class="text-center"><a href="index.php?page=paypal&delete=' . $row["id"] . '" class="fa fa-times bg-red action"></i></a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo Core::result(Language::getTranslation("paypalOptionsNotAdded"), 2);
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- END BASIC ELEMENTS -->
    </div>
</section>