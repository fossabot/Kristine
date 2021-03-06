<?php
require "../data/init.php";
require '../utils/ranks.php';
require "../lang/lang.php";
$fol = false;

if (isset($_GET['username']) && isset($_SESSION['name'])) {
    $username = $_GET['username'];
    $tried = $_SESSION['name'];

    $adminQuery = $mysql->query("SELECT * FROM `users` WHERE `name` = '$tried'");

    if ($username != $tried) {
        if ($adminQuery->fetch_object()->rank != 5) {
            header("Location: ../index.php");
        }
    }
} else {
    header("Location: ../index.php");
}

if (isset($_GET['msg'])) $msg = $_GET['msg'];

$usersQuery = $mysql->query("SELECT * FROM `users` WHERE `name` = '$username'");
$user = $usersQuery->fetch_object();

$headerTag = $lang['SET_AC'].' - '.forumName;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../static/head.php"; ?>
</head>

<body>

    <?php include "../static/header.php"; ?>


    <!-- Page -->
    <section class="section">
        <div class="container">
            <div class="container">
                <h2 class="title is-3" style="margin-bottom: -10px"><?php echo $lang['SET_AC']; ?></h2>
                <hr style="margin-bottom: 0">

                <div class="columns">
                    <div class="column">
                        <?php
                            if (isset($msg)) {
                                echo '<div class="notification ';
                                switch ($msg) {
                                    case 1:
                                        echo 'is-success">'.$lang['CONTACT'].' '.$lang['UPD'];
                                        break;
                                    case 2:
                                        echo 'is-success">'.$lang['U_PIC'];
                                        break;
                                    case 3:
                                        echo 'is-danger">'.$lang['FILE_EXT'];
                                        break;
                                    case 4:
                                        echo 'is-danger">'.$lang['FILE_SIZE'];
                                        break;
                                    case 5:
                                        echo 'is-success">'.$lang['CONTACT'].' '.$lang['UPD'];
                                        break;

                                    default:
                                        echo 'is-danger">'.$lang['ERROR'].'';
                                        break;
                                }
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-3">
                        <aside class="menu">
                            <p class="menu-label"><?php echo $lang['PROF_SETTINGS']; ?></p>
                            <ul class="menu-list">
                                <li><a href="" class="is-active"><?php echo $lang['SET_AC']; ?></a></li>
                                <li><a href="security.php?username=<?php echo $username; ?>"><?php echo $lang['SET_SECURITY']; ?></a></li>
                                <li><a href="preferences.php?username=<?php echo $username; ?>"><?php echo $lang['SET_PREFERENCES']; ?></a></li>
                                <li><a href="signature.php?username=<?php echo $username; ?>"><?php echo $lang['SET_SIGNATURE']; ?></a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="column is-6">
                        <label class="label"><?php echo $lang['USER'].': '.$username.'</label>';  ?>
                        <label class="label"><?php Ranks::getRank($lang, $user->rank, true); ?></label><br>

                        <form class="is-form" method="POST" action=<?php echo "../core/avatarUpdate.php?userName=$username"; ?> enctype="multipart/form-data">
                            <label class="label"><?php echo $lang['E_PIC']; ?></label>
                            <div class="field is-horizontal">
                                <div class="field-label">
                                    <figure class="image is-128x128 is-profile">
                                        <?php
                                            if (hash_equals($user->icon, "")) {
                                                echo '<img src="../img/user.png" alt="avatar">';
                                            } else {
                                                echo '<img src="../img/profiles/'.$user->icon.'" alt="'.$username.'">';
                                            }
                                        ?>
                                    </figure>
                                </div>
                                <div class="field-body">
                                    <div class="field-body">
                                        <div class="field">
                                            <input class="file-input" type="file" name="image" id="file" onchange="setfilename(this.value)"></input>
                                            <label for="file" class="tag is-medium is-danger"><span class="file-label" id="filename"><span class="file-icon"><i class="fa fa-upload"></i></span> Choose a file…</span></label>
                                        </div>
                                        <div class="field">
                                            <div class="control">
                                                <button class="button is-info" type="submit"><?php echo $lang['UPD'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>

                        <form class="is-form" method="POST" action="../core/update_mail.php">
                            <label class="label"><?php echo $lang['NEW'].' '.$lang['EMAIL']; ?></label>
                            <div class="field has-addons">
                                <div class="control has-icons-left is-expanded">
                                    <input class="input" type="text" name="email" placeholder="e.g. kristine@kristine.com"></input>
                                    <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                                </div>
                                <div class="control">
                                    <button class="button is-info" type="submit"><?php echo $lang['UPD'] ?></button>
                                </div>
                            </div>
                        </form>

                        <br>

                        <form class="is-form" method="POST" action="../core/update_contact.php">
                            <label class="label"><?php echo $lang['UPD'].' '.$lang['CONTACT']; ?></label>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static"><span class="icon is-small is-left"><i class="fab fa-twitter"></i></span> <span>@<?php if ($user->twitter != '') echo $user->twitter; ?></span></a>
                                </p>
                                <div class="control is-expanded">
                                    <input class="input" type="text" name="twitter" placeholder="e.g. @cadox8"></input>
                                </div>
                            </div>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static"><span class="icon is-small is-left"><i class="fab fa-facebook-f"></i></span> <span><?php if ($user->facebook != '') echo $user->facebook; ?></span></a>
                                </p>
                                <div class="control is-expanded">
                                    <input class="input" type="text" name="face" placeholder="e.g. cadox8"></input>
                                </div>
                            </div>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static"><span class="icon is-small is-left"><i class="fab fa-skype"></i></span> <span><?php if ($user->skype != '') echo $user->skype; ?></span></a>
                                </p>
                                <div class="control is-expanded">
                                    <input class="input" type="text" name="skype" placeholder="e.g. cadox8"></input>
                                </div>
                            </div>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static"><span class="icon is-small is-left"><i class="fab fa-discord"></i></span> <span><?php if ($user->skype != '') echo $user->skype; ?></span></a>
                                </p>
                                <div class="control is-expanded">
                                    <input class="input" type="text" name="discord" placeholder="e.g. cadox8#5249"></input>
                                </div>
                            </div>

                            <div class="control">
                                <button class="button is-info" type="submit"><?php echo $lang['UPD'] ?></button>
                            </div>
                        </form>

                    </div>
                    <div class="column"></div>
                </div>
            </div>
        </div>
    </section>

    <?php include "../static/footer.php"; ?>

</body>
</html>
