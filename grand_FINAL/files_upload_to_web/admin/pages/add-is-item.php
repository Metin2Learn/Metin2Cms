<?php
if(Admin::hasRight($_SESSION["username"], "z") == false)
{
    Core::redirect("index.php?page=no-permissions");
    die();
}

$is = new Itemshop();

if(isset($_POST["add_news"]))
{

    $title = $_POST["title"];
    if(isset($_POST["intro"]) AND mb_strlen($_POST["intro"]) > 11) {
        $intro = $_POST["intro"];
    } else {
        $intro = NULL;
    }
    $full = $_POST["full"];
    $img = $_FILES["image"];
    if($img["size"] > 0)
    {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $path = "../assets/images/news/";
        $img_ext = pathinfo($img["name"], PATHINFO_EXTENSION);
        $new_file_name = mb_strtolower(Core::generateToken(10, false).".".$img_ext);
        $img_submitted = true;
    } else {
        $new_file_name = NULL;
        $img_submitted = false;
    }
    $author = $_POST["author"];
    if(isset($_POST["important"]))
    {
        $important = 1;
    } else {
        $important = 0;
    }

    if(empty($title) OR empty($full) OR empty($author)) {
        $result = Core::result(Language::getTranslation("emptyError"), 2);
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
        $result = Core::result(Language::getTranslation("newsSubmitted"), 1);
        News::addNews($title, $intro, $full, $author, $important, $new_file_name);
        if($img_submitted)
        {
            move_uploaded_file($img["tmp_name"], $path.$new_file_name);
        }
    }

}

?>


<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("addItem") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("isTitle") ?></a></li>
        <li class="active"><?= Language::getTranslation("addItem") ?></li>
    </ol>
</section>
<!-- END CONTENT HEADER -->

<!-- BEGIN MAIN CONTENT -->
<section class="content">
    <div class="row">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="col-md-12">
            <div class="grid">
                <div class="grid-body">
                    <?php


                    if(isset($_GET["type"]) AND $_GET["type"] == 'item') {
                        // Clasic item
                        if(isset($_POST["add_item"]))
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
                                $new_file_name = '';
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
                                if($img_submitted)
                                {
                                    move_uploaded_file($img["tmp_name"], $path.$new_file_name);
                                }
                                $is->addItem($name, $vnum, $category, $description, $quantity, $price, $new_file_name, $socket0, $socket1, $socket2, $addon_type, $time_limit, $can_choose_quantity, $max_quantity);
                                $result = Core::result(Language::getTranslation("itemAdded"), 1);
                            }

                        }

                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <form method="POST" action="index.php?page=add-is-item&type=item&type=item" class="form-horizontal" role="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("itemVnum") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="item_vnum" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("category") ?></label>
                                <div class="col-sm-5">
                                    <select id="source" class="form-control" name="category">
                                        <?php
                                        foreach($is->categories() as $row2)
                                        {
                                            echo '<option value="'.$row2["id"].'">'.$row2["name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("quantity") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="count" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

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
                            <hr />
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("userCanChooseQuantity") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="can_choose_quantity" class="js-switch"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("maxQuantity") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="max_quantity" class="form-control">
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("enableDisableTimeLimit") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="time_limit_enabled" class="js-switch"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("timeLimitInSeconds") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="seconds" class="form-control">
                                </div>
                            </div>
                            <hr />
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
                            <hr />
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><?= Language::getTranslation("averageDamage") ?></label>

                                <div class="col-sm-7">
                                    <input type="checkbox" name="average_damage" class="js-switch"/>
                                </div>
                            </div>
                            <hr />
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="add_item"><?= Language::getTranslation("submit") ?></button>
                            </div>
                        </form>
                    <?php
                    } elseif(isset($_GET["type"]) AND $_GET["type"] == 'premium')
                    {
                        //Premium
                        if(isset($_POST["add_premium"]))
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
                                $new_file_name = '';
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
                                $is->addItem($name, 0, $category, $description, 0, $price, $new_file_name, $length, $type, 0, 0, 0, 100, 0);
                                $result = Core::result(Language::getTranslation("itemAdded"), 1);
                            }
                        }


                        if (isset($result)) {
                            echo $result;
                        }
                        //Premium

                        ?>
                        <form method="POST" action="index.php?page=add-is-item&type=premium" class="form-horizontal" role="form"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                                <div class="col-sm-7">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("category") ?></label>
                                <div class="col-sm-7">
                                    <select id="source" class="form-control" name="category">
                                        <?php
                                        foreach($is->categories() as $row2)
                                        {
                                            echo '<option value="'.$row2["id"].'">'.$row2["name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("selectType") ?></label>

                                <div class="col-sm-7">
                                    <select id="source" class="form-control" name="type" required>
                                        <option value="1"><?= Language::getTranslation("silverPremium") ?></option>
                                        <option value="2"><?= Language::getTranslation("goldPremium") ?></option>
                                        <option value="3"><?= Language::getTranslation("yangPremium") ?></option>
                                        <option value="123"><?= Language::getTranslation("premiumAll") ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("howManyDays") ?></label>

                                <div class="col-sm-7">
                                    <input type="number" name="days" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("referralRewardPrice") ?></label>

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
                            <hr />
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"
                                        name="add_premium"><?= Language::getTranslation("submit") ?></button>
                            </div>
                        </form>
                        <?php




                    } else {
                        echo '<h2>'.Language::getTranslation("chooseType").'</h2>';
                        ?>
                        <div class="list-group">
                            <a href="index.php?page=add-is-item&type=item" class="list-group-item active"><?= Language::getTranslation("classicItem") ?></a>
                            <a href="index.php?page=add-is-item&type=premium" class="list-group-item"><?= Language::getTranslation("premium") ?></a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>