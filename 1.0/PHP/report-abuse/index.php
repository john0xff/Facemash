<?php
session_start();
if (empty($_SESSION['isValid'])) {
    session_regenerate_id();
    $_SESSION['isValid'] = true;
}
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - Report Abuse</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <script type="text/javascript">
            function checkLength(limitField) {
                if (limitField.value.length > 1000) {
                    limitField.value = limitField.value.substring(0, 1000);
                    alert("Message too long. Must be 1000 characters or less!");
                }
            }
        </script>
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../src/pagefacebookon.php';
        ?>

        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <?php if (!$me) {
                    ?>
                        <h3>Report Abuse</h3>
                        <p>
                            Facemash
                            <br />is a service that allows users to rate the attractiveness
                            <br />of people's photos submitted voluntarily by others.
                        </p>
                        <p>
                            <img src="../about/images/fm-about-1.jpg" width="700" border="0" alt="Facemash" align="middle" />
                        </p>
                        <p>
                            You are not connected :-(
                        </p>
                        <p>
                            To report abuse, please, login with your <a href="https://www.facebook.com/" class="simple">Facebook</a> account:
                            <br /><br />
                        <?php include '../src/fbloginbutton.php' ?>
                    </p>
                    <p>
                        Trying to contact us? You just might email [with attachment] to <a href="#" class="simple">fm-report-abuse@atenwood.com</a>
                    </p>
                    <?php
                    } else {
                    ?>

                    <?php
                        include '../src/alexfacemashclass.php';
                        $facemash = new AlexFacemashClass();

                        if (is_numeric($_SESSION['facemash_userAId']) && is_numeric($_SESSION['facemash_userBId'])) {
                            $facemash_userAId = $_SESSION['facemash_userAId'];
                            $facemash_userBId = $_SESSION['facemash_userBId'];

                            $userAFacebookId = $facemash->getFacebookUserId($facemash_userAId);
                            $userBFacebookId = $facemash->getFacebookUserId($facemash_userBId);
                        }
                    ?>

                        <table width="100%" border="0">
                            <tr>
                                <td>&nbsp;</td>
                                <td width="500" align="center">
                                    <p class="main">
                                        <form action="result.php" method="post">
                                            <fieldset>
                                                <legend>Report Abuse Form</legend>
                                                <p class="main">
                                                    <label for="userName">Your Name:</label>
                                                    <input type="text" name="userName" size="30" maxlength=50 readonly value="<?php echo $me['name']; ?>" />
                                                </p>
                                                <p class="main">
                                                    <label for="userId">Your FB Id:</label>
                                                    <input type="text"  name="userId" size="30" maxlength=15 readonly value="<?php echo $me['id']; ?>" />
                                                </p>
                                                <p class="main">
                                                    <label for="userEmail">Your Email:</label>
                                                    <input type="text"  name="userEmail" size="30" maxlength=50 readonly value="<?php echo $me['email']; ?>" />
                                                </p>
                                                <p class="main">
                                                    <label for="userMessage">Message:<br />(max 1000)</label>
                                                    <textarea name="userMessage" rows="10" cols="45" onKeyDown="checkLength(this);"
                                                              onKeyUp="checkLength(this);"></textarea>
                                                </p>
                                                <p class="main">
                                                    <label for="images">Images:</label>
                                                    <img src="<?php echo 'http://graph.facebook.com/' . $userAFacebookId . '/picture'; ?>" align="middle" />
                                                    &nbsp;&nbsp;
                                                    <img src="<?php echo 'http://graph.facebook.com/' . $userBFacebookId . '/picture'; ?>" align="middle" />
                                                </p>
                                                <p class="submit">
                                                    <input type="submit" value="Submit" />
                                                    <input type="reset" value="Reset" />
                                                </p>
                                            </fieldset>
                                        </form>

                                        <p class="main">
                                            Templates:
                                            <br />
                                            1) This is wrong photo.
                                            <br />
                                            2) This is my photo, but I'm not Facemash player.
                                            <br />
                                            3) This is user's photo who're not Facemash player [enter Facebook user profile name].
                                        </p>
                                    </p>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

                        Trying to contact us?<br />You just might email [with attachment] to <a href="#" class="simple">fm-report-abuse@atenwood.com</a>
                        <br /><br />

                    <?php } ?>

                    <div class="footer">
                        <div class="container">
                            <?php
                            include '../src/pagebottommenu.php';
                            include '../src/pagebottomcopyright.php';
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>