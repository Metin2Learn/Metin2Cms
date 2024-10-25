<?php
if (Admin::hasRight($_SESSION["username"], "q") == false) {
    Core::redirect("index.php?page=no-permissions");
    die();
}

$team = new Team();
?>

<section class="content-header">
    <i class="fa fa-align-left"></i>
    <span><?= Language::getTranslation("editMember") ?></span>
    <ol class="breadcrumb">
        <li><?= Language::getTranslation("teamMembers") ?></a></li>
        <li><a href="index.php?page=all-team-members"><?= Language::getTranslation("viewTeamMember") ?></a></li>
        <li class="active"><?= Language::getTranslation("editMember") ?></li>
    </ol>
</section>

<section class="content">
<div class="row">
    <!-- BEGIN BASIC ELEMENTS -->
    <div class="col-md-12">
        <div class="grid">
            <div class="grid-body">
                <?php
                if(isset($_GET["id"]) AND $team->memberExists($_GET["id"])) {

                    $info = $team->memberInfo($_GET["id"]);

                    if(isset($_POST["edit_member"])) {
                        $name = $_POST["name"];
                        $ingame_name = $_POST["ingame_name"];
                        $position = $_POST["position"];
                        $contact = (isset($_POST["contact"]) AND mb_strlen($_POST["contact"]) > 0) ? $_POST["contact"] : NULL;
                        $fb = (isset($_POST["facebook"]) AND mb_strlen($_POST["facebook"]) > 0) ? $_POST["facebook"] : NULL;
                        $twitter = (isset($_POST["twitter"]) AND mb_strlen($_POST["twitter"]) > 0) ? $_POST["twitter"] : NULL;
                        $gplus = (isset($_POST["gplus"]) AND mb_strlen($_POST["gplus"]) > 0) ? $_POST["gplus"] : NULL;
                        $category = $_POST["category"];
                        $description = (isset($_POST["desc"]) AND mb_strlen($_POST["desc"]) > 0) ? $_POST["desc"] : '';
                        $avatar = $_FILES["avatar"];
                        if ($avatar["size"] > 0) {
                            $allowed = array('jpg', 'jpeg', 'png', 'gif');
                            $path = "../assets/images/avatars/";
                            $img_ext = pathinfo($avatar["name"], PATHINFO_EXTENSION);
                            $new_file_name = mb_strtolower(Core::generateToken(10, false) . "." . $img_ext);
                            $img_submitted = true;
                        } else {
                            $new_file_name = $info["avatar"];
                            $img_submitted = false;
                        }

                        if (empty($name) OR empty($ingame_name) OR empty($position)) {
                            $result = Core::result(Language::getTranslation("emptyError2"), 2);
                        } elseif ($team->categoryExists($category) == false) {
                            $result = Core::result(Language::getTranslation("categoryDoesntExists"), 2);
                        } elseif ($img_submitted AND $avatar["error"] == 1) {
                            $result = Core::result(Language::getTranslation("imageTooBig"), 2);
                        } elseif ($img_submitted AND ($avatar["error"] != 0)) {
                            $result = Core::result(Language::getTranslation("imageErrorCorrupted"), 2);
                        } elseif ($img_submitted AND getimagesize($avatar["tmp_name"]) == false) {
                            $result = Core::result(Language::getTranslation("isNotImage"), 2);
                        } elseif ($img_submitted AND !in_array($img_ext, $allowed)) {
                            $result = Core::result(Language::getTranslation("notSupportedImage"), 2);
                        } elseif ($img_submitted AND file_exists($path . $new_file_name)) {
                            $result = Core::result(Language::getTranslation("imageExists"), 2);
                        } else {
                            $result = Core::result(Language::getTranslation("memberUpdated"), 1);
                            if($img_submitted)
                            {
                                move_uploaded_file($avatar["tmp_name"], $path.$new_file_name);
                            }
                            $team->updateMember($category, $_GET["id"], $name, $ingame_name, $new_file_name, $contact, $position, $description, $fb, $twitter, $gplus);
                            Core::redirect("index.php?page=edit-team-member&id=".$_GET["id"],1);
                        }
                    }

                    if (isset($result)) {
                        echo $result;
                    }
                    ?>
                    <form method="POST" action="index.php?page=edit-team-member&id=<?= $_GET["id"] ?>" class="form-horizontal" role="form"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("name") ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" value="<?= $info["name"] ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("ingameName") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["ingame_nick"] ?>" name="ingame_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("position") ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="position" value="<?= $info["position"] ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("contact") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["contact"] ?>" placeholder="<?= Language::getTranslation("notRequired") ?>" name="contact" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("facebook") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["facebook"] ?>" placeholder="<?= Language::getTranslation("notRequired") ?>" name="facebook" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("twitter") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["twitter"] ?>" placeholder="<?= Language::getTranslation("notRequired") ?>" name="twitter" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("gplus") ?></label>

                            <div class="col-sm-7">
                                <input type="text" value="<?= $info["gplus"] ?>" placeholder="<?= Language::getTranslation("notRequired") ?>" name="gplus" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("category") ?></label>
                            <div class="col-sm-5">
                                <select id="source" class="form-control" name="category">
                                    <?php
                                    $cats = $team->categories();
                                    foreach($cats as $row2)
                                    {
                                        if($row2["id"] == $info["cat_id"])
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
                            <label
                                class="col-sm-3 control-label"><?= Language::getTranslation("description") ?></label>

                            <div class="col-sm-7">
                                <textarea class="form-control" placeholder="<?= Language::getTranslation("notRequired") ?>" name="desc"><?= $info["desc"] ?></textarea>
                            </div>
                        </div>
                        <?php
                        if($info["avatar"] == NULL)
                        {
                            ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Language::getTranslation("avatar") ?></label>

                            <div class="col-sm-7">
                                <input type="file" name="avatar" id="avatar" class="form-control">
                            </div>
                        </div>
                        <?php
                        } else {
                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("avatar") ?></label>

                                <div class="col-sm-7">
                                    <img class="img-responsive" src="../assets/images/avatars/<?= $info["avatar"] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= Language::getTranslation("newAvatar") ?></label>

                                <div class="col-sm-7">
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"
                                    name="edit_member"><?= Language::getTranslation("update") ?></button>
                        </div>
                    </form>
                <?php
                } else {
                    echo Core::result(Language::getTranslation("memberWasNotFound"), 4);
                }
                ?>
            </div>
        </div>
    </div>
</div>
</section>

