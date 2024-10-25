<?php
if(Admin::hasRight($_SESSION["username"], "j1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$ref = new Referral();

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("rewards") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("referralSystem") ?></a></li>
        <li class="active"><?= Language::getTranslation("rewards") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- BEGIN CUSTOM TABLE -->
        <div class="col-md-12">
            <div class="grid no-border">
                <div class="grid-body">
                    <?php
                    if(isset($_GET["action"]) AND $_GET["action"] == 'add') {
                        if (isset($_POST["add_item"])) {
                            $name = $_POST["name"];
                            $vnum = $_POST["item_vnum"];
                            $quantity = $_POST["count"];
                            $price = $_POST["price"];
                            $img = $_FILES["image"];
                            if ($img["size"] > 0) {
                                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                                $path = "../assets/images/referral/";
                                $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                                $new_file_name = mb_strtolower(Core::generateToken(10, false) . "." . $img_ext);
                                $img_submitted = true;
                            } else {
                                $new_file_name = '';
                                $img_submitted = false;
                            }
                            $description = $_POST["description"];
                            if (isset($_POST["time_limit_enabled"])) {
                                $time_limit = $_POST["seconds"];
                            } else {
                                $time_limit = 0;
                            }
                            if (isset($_POST["socket0_enable"])) {
                                $socket0 = 1;
                            } else {
                                $socket0 = 0;
                            }
                            if (isset($_POST["socket1_enable"])) {
                                $socket1 = 1;
                            } else {
                                $socket1 = 0;
                            }
                            if (isset($_POST["socket2_enable"])) {
                                $socket2 = 1;
                            } else {
                                $socket2 = 0;
                            }
                            if (isset($_POST["average_damage"])) {
                                $addon_type = 1;
                            } else {
                                $addon_type = 0;
                            }

                            if (empty($name) OR empty($vnum) OR empty($quantity) OR empty($price)) {
                                $result = Core::result(Language::getTranslation("emptyErrorIsAddItem"), 2);
                            } elseif ($quantity <= 0) {
                                $result = Core::result(Language::getTranslation("quantityMustBeGreaterThenZero"), 2);
                            } elseif ($img_submitted AND $img["error"] == 1) {
                                $result = Core::result(Language::getTranslation("imageTooBig"), 2);
                            } elseif ($img_submitted AND ($img["error"] != 0)) {
                                $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
                            } elseif ($img_submitted AND getimagesize($img["tmp_name"]) == false) {
                                $result = Core::result(Language::getTranslation("isNotImage"), 2);
                            } elseif ($img_submitted AND !in_array($img_ext, $allowed)) {
                                $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
                            } elseif ($img_submitted AND file_exists($path . $new_file_name)) {
                                $result = Core::result(Language::getTranslation("imageExists"), 2);
                            } else {
                                if ($img_submitted) {
                                    move_uploaded_file($img["tmp_name"], $path . $new_file_name);
                                }
                                $ref->addReward($name, $vnum, $description, $quantity, $price, $new_file_name, $socket0, $socket1, $socket2, $addon_type, $time_limit);
                                //$is->addItem($name, $vnum, $category, $description, $quantity, $price, $new_file_name, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_choose_quantity, $max_quantity);
                                $result = Core::result(Language::getTranslation("rewardAdded"), 1);
                            }
                        }


                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=referral-rewards&action=add" class="form-horizontal"
                              role="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("itemVnum") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="item_vnum" class="form-control" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("quantity") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="count" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>

                                <div class="col-sm-7">
                                    <input type="file" name="image" id="fileToUpload" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>

                                <div class="col-sm-7">
                                    <textarea class="form-control" id="full_news" name="description"></textarea>
                                </div>
                            </div>
                            <hr/>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableDisableTimeLimit") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="time_limit_enabled" class="js-switch"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("timeLimitInSeconds") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="seconds" class="form-control">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket0") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="socket0_enable" class="js-switch"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket1") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="socket1_enable" class="js-switch"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket2") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="socket2_enable" class="js-switch"/>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("averageDamage") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="average_damage" class="js-switch"/>
                                </div>
                            </div>
                            <hr/>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="add_item"><?= Language::getTranslation("submit") ?></button>
                            </div>
                        </form>
                    <?php
                    } elseif(isset($_GET["edit"]) AND $ref->rewardExists($_GET["edit"]))
                    {
                        $info = $ref->rewardInfo($_GET["edit"]);

                        if (isset($_POST["update_item"])) {
                            $name = $_POST["name"];
                            $vnum = $_POST["item_vnum"];
                            $quantity = $_POST["count"];
                            $price = $_POST["price"];
                            $img = $_FILES["image"];
                            if ($img["size"] > 0) {
                                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                                $path = "../assets/images/referral/";
                                $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                                $new_file_name = mb_strtolower(Core::generateToken(10, false) . "." . $img_ext);
                                $img_submitted = true;
                            } else {
                                $new_file_name = '';
                                $img_submitted = false;
                            }
                            $description = $_POST["description"];
                            if (isset($_POST["time_limit_enabled"])) {
                                $time_limit = $_POST["seconds"];
                            } else {
                                $time_limit = 0;
                            }
                            if (isset($_POST["socket0_enable"])) {
                                $socket0 = 1;
                            } else {
                                $socket0 = 0;
                            }
                            if (isset($_POST["socket1_enable"])) {
                                $socket1 = 1;
                            } else {
                                $socket1 = 0;
                            }
                            if (isset($_POST["socket2_enable"])) {
                                $socket2 = 1;
                            } else {
                                $socket2 = 0;
                            }
                            if (isset($_POST["average_damage"])) {
                                $addon_type = 1;
                            } else {
                                $addon_type = 0;
                            }

                            if (empty($name) OR empty($vnum) OR empty($quantity) OR empty($price)) {
                                $result = Core::result(Language::getTranslation("emptyErrorIsAddItem"), 2);
                            } elseif ($quantity <= 0) {
                                $result = Core::result(Language::getTranslation("quantityMustBeGreaterThenZero"), 2);
                            } elseif ($img_submitted AND $img["error"] == 1) {
                                $result = Core::result(Language::getTranslation("imageTooBig"), 2);
                            } elseif ($img_submitted AND ($img["error"] != 0)) {
                                $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
                            } elseif ($img_submitted AND getimagesize($img["tmp_name"]) == false) {
                                $result = Core::result(Language::getTranslation("isNotImage"), 2);
                            } elseif ($img_submitted AND !in_array($img_ext, $allowed)) {
                                $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
                            } elseif ($img_submitted AND file_exists($path . $new_file_name)) {
                                $result = Core::result(Language::getTranslation("imageExists"), 2);
                            } else {
                                if ($img_submitted) {
                                    move_uploaded_file($img["tmp_name"], $path . $new_file_name);
                                }
                                $ref->updateReward($name, $vnum, $description, $quantity, $price, $new_file_name, $socket0, $socket1, $socket2, $addon_type, $time_limit, $_GET["edit"]);
                                $result = Core::result(Language::getTranslation("rewardUpdated"), 1);
                            }
                        }


                        if (isset($result)) {
                            echo $result;
                        }

                        ?>
                        <form method="POST" action="index.php?page=referral-rewards&edit=<?= $_GET["edit"] ?>" class="form-horizontal"
                              role="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["name"] ?>" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("itemVnum") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["item_vnum"] ?>" name="item_vnum" class="form-control" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("quantity") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["count"] ?>" name="count" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["price"] ?>" name="price" class="form-control" required>
                                </div>
                            </div>


                            <?php
                            if($info["img"] == NULL OR $info["img"] == '') {
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>

                                    <div class="col-sm-7">
                                        <input type="file" name="image" id="fileToUpload" class="form-control">
                                    </div>
                                </div>
                            <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("newsImg") ?></label>

                                    <div class="col-sm-7">
                                        <img class="img-responsive" src="../assets/images/referral/<?= $info["img"] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= Language::getTranslation("newImage") ?></label>

                                    <div class="col-sm-7">
                                        <input type="file" name="image" id="fileToUpload" class="form-control">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>


                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>

                                <div class="col-sm-7">
                                    <textarea class="form-control" id="full_news" name="description"><?= $info["description"] ?></textarea>
                                </div>
                            </div>
                            <hr/>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("enableDisableTimeLimit") ?></label>

                                <div class="col-sm-7">
                                    <?php
                                    if($info["time_limit"] > 0)
                                    {
                                        echo '<input type="checkbox" name="time_limit_enabled" class="js-switch" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="time_limit_enabled" class="js-switch"/>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("timeLimitInSeconds") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["time_limit"] ?>" name="seconds" class="form-control">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket0") ?></label>

                                <div class="col-sm-7">
                                    <?php
                                    if($info["socket0"] == 1)
                                    {
                                        echo '<input type="checkbox" name="socket0_enable" class="js-switch" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="socket0_enable" class="js-switch"/>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket1") ?></label>

                                <div class="col-sm-7">
                                    <?php
                                    if($info["socket1"] == 1)
                                    {
                                        echo '<input type="checkbox" name="socket1_enable" class="js-switch" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="socket1_enable" class="js-switch">';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableSocket2") ?></label>

                                <div class="col-sm-7">
                                    <?php
                                    if($info["socket2"] == 1)
                                    {
                                        echo '<input type="checkbox" name="socket2_enable" class="js-switch" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="socket2_enable" class="js-switch">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("averageDamage") ?></label>

                                <div class="col-sm-7">
                                    <?php
                                    if($info["addon_type"] == 1)
                                    {
                                        echo '<input type="checkbox" name="average_damage" class="js-switch" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="average_damage" class="js-switch">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr/>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update_item"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>
                        <?php

                    } else {

                        if(isset($_GET["delete"]) AND $ref->rewardExists($_GET["delete"]))
                        {
                            $ref->deleteReward($_GET["delete"]);
                            $result = Core::result(Language::getTranslation("rewardDeleted"), 1);
                        }

                        if (isset($result)) {
                            echo $result;
                        }

                        echo '<a href="index.php?page=referral-rewards&action=add"><button type="button" class="btn btn-primary btn-lg btn-block">'.Language::getTranslation("addReward").'</button></a>';

                        // Paginator
                        $page = isset($_GET["pagination"]) ? (int)$_GET["pagination"] : 1;
                        $totalCount = $ref->numberOfRewards();
                        $perPage = $ref->rewardsPerPage();;
                        $paginator = new Paginator($page, $totalCount, $perPage);
                        // Paginator

                        // Validate page
                        if (isset($_GET["pagination"]) AND (!ctype_digit($_GET["pagination"]) OR $_GET["pagination"] > ceil($totalCount / $perPage) OR $_GET["pagination"] < 1)) {
                            Core::redirect("index.php?page=referral-rewards", 0);
                            die();
                        }
                        // Validate page


                        // Print all news and pagination links
                        global $dbname;
                        $ref->printAdminRewards("SELECT * FROM " . $dbname . ".referral_rewards ORDER BY id DESC LIMIT ? OFFSET ?", array($perPage, $paginator->offset()));
                        $paginator->printLinks("index.php?page=referral-rewards&pagination=", "pagination");
                        // Print all news and pagination links
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>