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
        <title>Facemash - Report Abuse - Result</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
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
                        <h3>Report Abuse Result</h3>
                        <p>
                            Trying to contact us? You just might email [with attachment] to <a href="#" class="simple">fm-report-abuse@atenwood.com</a>
                        </p>
                    <?php
                    } else {
                    ?>

                    <?php
                        if ($_POST) {
                            $postData =
                                    $_POST['userName'] .
                                    $_POST['userId'] .
                                    $_POST['userEmail'] .
                                    $_POST['userMessage'];

                            if (strlen($postData) < 1200) {
                                $okUserMessage = htmlspecialchars(trim($_POST['userMessage']), ENT_QUOTES, "UTF-8");

                                $isPostDataOk = true;
                            } else {
                                $isPostDataOk = false;
                            }
                        } else {
                            $isPostDataOk = false;
                        }
                    ?>

                    <?php if ($isPostDataOk) {
                    ?>
                            <h3>
                                Success! Thank you for report!
                            </h3>

                    <?php
                            include '../src/alexfacemashclass.php';
                            $facemash = new AlexFacemashClass();

                            $userAFacebookId = $facemash->getFacebookUserId($_SESSION['facemash_userAId']);
                            $userBFacebookId = $facemash->getFacebookUserId($_SESSION['facemash_userBId']);
                    ?>

                            <table width="100%" border="0">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td width="500" align="center">
                                        <p class="main">
                                            <form>
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
                                                        <label for="userMessage">Message:</label>
                                                        <textarea name="userMessage" rows="10" cols="45" readonly><?php echo $okUserMessage; ?></textarea>
                                                    </p>
                                                    <p class="main">
                                                        <label for="images">Images:</label>
                                                        <img src="<?php echo 'http://graph.facebook.com/' . $userAFacebookId . '/picture'; ?>" align="middle" />
                                                        &nbsp;&nbsp;
                                                        <img src="<?php echo 'http://graph.facebook.com/' . $userBFacebookId . '/picture'; ?>" align="middle" />
                                                    </p>
                                                </fieldset>
                                            </form>
                                        </p>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                    <?php
                        }
                    ?>

                        Go to <a href="../../facemash/" class="simple">Facemash</a>.
                        <br /><br />

                    <?php
                        if ($isPostDataOk) {
                            $userName = $me['name'];
                            $userId = $me['id'];
                            $userEmail = $me['email'];

                            $playerAFacebookId = $userAFacebookId;
                            $playerBFacebookId = $userBFacebookId;

                            $message =
                                    '<p>' .
                                    'Name: ' . $userName . ';' . '<br />' .
                                    'FB Id: ' . 'https://www.facebook.com/profile.php?id=' . $userId . ';' . '<br />' .
                                    'Email: ' . $userEmail . '.' .
                                    '</p>' .
                                    '<p>' .
                                    'Message: ' . $okUserMessage . '.' .
                                    '</p>' .
                                    '<p>' .
                                    'Player A FB Id: ' . 'https://www.facebook.com/profile.php?id=' . $playerAFacebookId . ';' . '<br />' .
                                    'Player B FB Id: ' . 'https://www.facebook.com/profile.php?id=' . $playerBFacebookId . ';' .
                                    '</p>';

                            $to = 'To: Facemash Abuse Team <anwer.man@gmail.com>';
                            $subject = 'Facemash Report Abuse';

                            $headers = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                            //additional headers
                            $headers .= 'From: Facemash Email Robot <facemash-email-robot@atenwood.com>' . "\r\n";

                            $mailcontent =
                                    '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                                    <html xmlns="http://www.w3.org/1999/xhtml">
                                    <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <title>' . $subject . '</title>
                                    </head>
                                    <body>' . $message . '</body></html>';

                            mail($to, $subject, $mailcontent, $headers);
                        }
                    ?>

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