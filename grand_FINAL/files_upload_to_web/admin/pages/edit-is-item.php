<?php
if(Admin::hasRight($_SESSION["username"], "a1") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$is = new Itemshop();

if(!isset($_GET["id"]) OR (isset($_GET["id"]) AND $is->itemExists($_GET["id"]) == false))
{
    Core::redirect("index.php?page=all-is-items");
    die();
}

?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editItem") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li><a href="index.php?page=all-is-items"><?= Language::getTranslation("viewItems") ?></a></li>
        <li class="active"><?= Language::getTranslation("editItem") ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">

                    <?php
                    $info = $is->getItemInfo($_GET["id"]);
                    if($info["can_change_amount"] == 100)
                    {
                        if(isset($_POST["update"]))
                        {
                            $types = array(1,2,3,123);
                            $name = $_POST["name"];
                            $type = $_POST["type"];
                            $length = $_POST["days"];
                            $category = $_POST["category"];
                            $price = $_POST["price"];
                            $img = $_FILES["image"];
                            if($img["size"] > 0)
                            {
                                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                                $path = "../assets/images/itemshop/";
                                $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                                $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
                                $img_submitted = true;
                            } else {
                                $new_file_name = $info["img"];
                                $img_submitted = false;
                            }
                            $description = $_POST["description"];


                            if(empty($name)) {
                                $result = Core::result(Language::getTranslation("nameCannotBeEmpty"), 2);
                            } elseif(!in_array($type, $types)) {
                                $result = Core::result(Language::getTranslation("invalidPremiumType"), 2);
                            } elseif($length <= 0)
                            {
                                $result = Core::result(Language::getTranslation("invalidPremiumDuration"), 2);
                            } elseif(!$is->categoryExists($category))
                            {
                                $result = Core::result(Language::getTranslation("categoryDoesntExists"), 2);
                            } elseif($img_submitted AND $img["error"] == 1)
                            {
                                $result = Core::result(Language::getTranslation("imageTooBig"), 2);
                            } elseif($img_submitted AND ($img["error"] != 0))
                            {
                                $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
                            } elseif($img_submitted AND getimagesize($img["tmp_name"]) == false)
                            {
                                $result = Core::result(Language::getTranslation("isNotImage"), 2);
                            } elseif($img_submitted AND !in_array($img_ext, $allowed))
                            {
                                $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
                            } elseif($img_submitted AND file_exists($path.$new_file_name))
                            {
                                $result = Core::result(Language::getTranslation("imageExists"), 2);
                            } else {
                                if($img_submitted)
                                {
                                    move_uploaded_file($img["tmp_name"], $path.$new_file_name);
                                }
                                $is->updateItem($name, 0, $category, $description, 0, $price, $new_file_name, $length, $type, 0, 0, 0, 100, 0, $_GET["id"]);
                                $result = Core::result(Language::getTranslation("premiumItemUpdated"), 1);
                            }
                        }

                        if (isset($result)) {
                            echo $result;
                        }
                        //Premium

                        ?>
                        <form method="POST" action="index.php?page=edit-is-item&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" value="<?= $info["name"] ?>" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("category") ?></label>
                                <div class="col-sm-7">
                                    <select id="source" class="form-control" name="category">
                                        <?php
                                        foreach($is->categories() as $row2)
                                        {
                                            if($info["category_id"] == $row2["id"])
                                            {
                                                echo '<option value="'.$row2["id"].'" selected>'.$row2["name"].'</option>';
                                            } else {
                                                echo '<option value="' . $row2["id"] . '">' . $row2["name"] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("selectType") ?></label>

                                <div class="col-sm-7">
                                    <select id="source" class="form-control" name="type" required>
                                        <?php
                                        if($info["socket1"] == 1)
                                        {
                                            ?>
                                        <option value="1" selected><?= Language::getTranslation("silverPremium") ?></option>
                                            <?php
                                        } else {
                                            ?>
                                        <option value="1"><?= Language::getTranslation("silverPremium") ?></option>
                                            <?php
                                        }


                                        if($info["socket1"] == 2)
                                        {
                                            ?>
                                            <option value="2" selected><?= Language::getTranslation("goldPremium") ?></option>
                                        <?php
                                        } else {
                                            ?>
                                            <option value="2"><?= Language::getTranslation("goldPremium") ?></option>
                                        <?php
                                        }

                                        if($info["socket1"] == 3)
                                        {
                                            ?>
                                            <option value="3" selected><?= Language::getTranslation("yangPremium") ?></option>
                                        <?php
                                        } else {
                                            ?>
                                            <option value="3"><?= Language::getTranslation("yangPremium") ?></option>
                                        <?php
                                        }

                                        if($info["socket1"] == 123)
                                        {
                                            ?>
                                            <option value="123" selected><?= Language::getTranslation("premiumAll") ?></option>
                                        <?php
                                        } else {
                                            ?>
                                            <option value="123"><?= Language::getTranslation("premiumAll") ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("howManyDays") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["socket0"] ?>" name="days" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" value="<?= $info["price"] ?>" name="price" class="form-control" required>
                                </div>
                            </div>

                            <?php
                            if($info["img"] == '')
                            {
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
                                    <img class="img-responsive" src="../assets/images/itemshop/<?= $info['img'] ?>">
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
                            <hr />
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="update"><?= Language::getTranslation("update") ?></button>
                            </div>
                        </form>
                    <?php
                    } else {
                        //Classic item

                    if(isset($_POST["update_normal"]))
                    {
                        $name = $_POST["name"];
                        $vnum = $_POST["item_vnum"];
                        $category = $_POST["category"];
                        $quantity = $_POST["count"];
                        $price = $_POST["price"];
                        $img = $_FILES["image"];
                        if($img["size"] > 0)
                        {
                            $allowed = array('jpg', 'jpeg', 'png', 'gif');
                            $path = "../assets/images/itemshop/";
                            $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
                            $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
                            $img_submitted = true;
                        } else {
                            $new_file_name = $info["img"];
                            $img_submitted = false;
                        }
                        $description = $_POST["description"];
                        if(isset($_POST["can_choose_quantity"]))
                        {
                            $can_choose_quantity = 1;
                            $max_quantity = $_POST["max_quantity"];
                        } else {
                            $can_choose_quantity = 0;
                            $max_quantity = 0;
                        }
                        if(isset($_POST["time_limit_enabled"]))
                        {
                            $time_limit = $_POST["seconds"];
                        } else {
                            $time_limit = 0;
                        }
                        if(isset($_POST["socket0_enable"]))
                        {
                            $socket0 = 1;
                        } else {
                            $socket0 = 0;
                        }
                        if(isset($_POST["socket1_enable"]))
                        {
                            $socket1 = 1;
                        } else {
                            $socket1 = 0;
                        }
                        if(isset($_POST["socket2_enable"]))
                        {
                            $socket2 = 1;
                        } else {
                            $socket2 = 0;
                        }
                        if(isset($_POST["average_damage"]))
                        {
                            $addon_type = 1;
                        } else {
                            $addon_type = 0;
                        }

                        if(empty($name) OR empty($vnum) OR empty($quantity) OR empty($price))
                        {
                            $result = Core::result(Language::getTranslation("emptyErrorIsAddItem"), 2);
                        } elseif(!$is->categoryExists($category))
                        {
                            $result = Core::result(Language::getTranslation("categoryDoesntExists"), 2);
                        } elseif($quantity <= 0)
                        {
                            $result = Core::result(Language::getTranslation("quantityMustBeGreaterThenZero"), 2);
                        } elseif($img_submitted AND $img["error"] == 1)
                        {
                            $result = Core::result(Language::getTranslation("imageTooBig"), 2);
                        } elseif($img_submitted AND ($img["error"] != 0))
                        {
                            $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
                        } elseif($img_submitted AND getimagesize($img["tmp_name"]) == false)
                        {
                            $result = Core::result(Language::getTranslation("isNotImage"), 2);
                        } elseif($img_submitted AND !in_array($img_ext, $allowed))
                        {
                            $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
                        } elseif($img_submitted AND file_exists($path.$new_file_name))
                        {
                            $result = Core::result(Language::getTranslation("imageExists"), 2);
                        } elseif($can_choose_quantity == 1 AND $max_quantity <= 0)
                        {
                            $result = Core::result(Language::getTranslation("quantityMustBeGreaterThenZero"), 2);
                        } else {
                            var_dump($category);
                            if($img_submitted)
                            {
                                move_uploaded_file($img["tmp_name"], $path.$new_file_name);
                            }
                            $is->updateItem($name, $vnum, $category, $description, $quantity, $price, $new_file_name, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_choose_quantity, $max_quantity, $_GET["id"]);
                            $result = Core::result(Language::getTranslation("itemUpdated"), 1);
                        }

                    }

                    if (isset($result)) {
                        echo $result;
                    }
                    ?>
                    <form method="POST" action="index.php?page=edit-is-item&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["name"] ?>" name="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("itemVnum") ?></label>

                            <div class="col-sm-7">
                                <input type="number" value="<?= $info["item_id"] ?>" name="item_vnum" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("category") ?></label>
                            <div class="col-sm-5">
                                <select id="source" class="form-control" name="category">
                                    <?php
                                    foreach($is->categories() as $row2)
                                    {
                                        if($info["category_id"] == $row2["id"])
                                        {
                                            echo '<option value="'.$row2["id"].'" selected>'.$row2["name"].'</option>';
                                        } else {
                                            echo '<option value="'.$row2["id"].'">'.$row2["name"].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("quantity") ?></label>

                            <div class="col-sm-7">
                                <input type="number" value="<?= $info["count"] ?>" name="count" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

                            <div class="col-sm-7">
                                <input type="number" value="<?= $info["price"] ?>" name="price" class="form-control" required>
                            </div>
                        </div>

                        <?php
                        if($info["img"] == '')
                        {
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
                                    <img class="img-responsive" src="../assets/images/itemshop/<?= $info['img'] ?>">
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
                        <hr />
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("userCanChooseQuantity") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if($info["can_change_amount"] == 1)
                                {
                                    echo '<input type="checkbox" name="can_choose_quantity" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="can_choose_quantity" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("maxQuantity") ?></label>

                            <div class="col-sm-7">
                                <input type="number" value="<?= $info["max_amount"] ?>" name="max_quantity" class="form-control">
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("enableDisableTimeLimit") ?></label>

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
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("timeLimitInSeconds") ?></label>

                            <div class="col-sm-7">
                                <input type="number" value="<?= $info["time_limit"] ?>" name="seconds" class="form-control">
                            </div>
                        </div>
                        <hr />
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
                                    echo '<input type="checkbox" name="socket1_enable" class="js-switch"/>';
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
                                    echo '<input type="checkbox" name="socket2_enable" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("averageDamage") ?></label>

                            <div class="col-sm-7">
                                <?php
                                if($info["addon_type"] == 1)
                                {
                                    echo '<input type="checkbox" name="average_damage" class="js-switch" checked>';
                                } else {
                                    echo '<input type="checkbox" name="average_damage" class="js-switch"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <hr />
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"
                                    name="update_normal"><?= Language::getTranslation("submit") ?></button>
                        </div>
                    </form>
                    <?php


                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>