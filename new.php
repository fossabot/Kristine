<?php
require "data/init.php";
require 'utils/ranks.php';
require "lang/lang.php";

if (isset($_GET['forumID']) && isset($_SESSION['name'])) {
    $forumID = $_GET['forumID'];
    $tried = $_SESSION['name'];
} else {
    header("Location: index.php");
}

$headerTag = $lang['NEW_POST'].' - '.forumName;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "static/head.php"; ?>
</head>

<body>

    <?php include "static/header.php"; ?>


    <!-- Page -->
    <section class="section">
        <div class="container">
            <div class="container">
                <h2 class="title is-3" style="margin-bottom: -10px"><?php echo $lang['NEW_POST']; ?></h2>
                <hr style="margin-bottom: 0">

                <div class="columns">
                    <div class="column is-2"></div>
                    <div class="column is-8">
                        <br>
                        <form class="is-form" method="POST" action="core/new_post.php">
                            <div class="field">
                                <label class="label"><?php echo $lang['TITLE']; ?></label>
                                <div class="control">
                                    <input class="input" type="text" placeholder="My new post" name="title">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <textarea class="textarea" name="content" placeholder="Write Something" rows="8"></textarea>
                                </div>
                            </div>
                            <button class="button is-info" type="submit">Create</button>
                        </form>
                    </div>
                    <div class="column"></div>
                </div>
            </div>
        </div>
    </section>

    <?php include "static/footer.php"; ?>

</body>
</html>
