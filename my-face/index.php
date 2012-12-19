<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - My Face</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <script type="text/javascript">
            function playerFaceDestroyed() {
                var r=confirm("Your player will be destroyed. Continue?");
                if (r==true) {
                    var d=confirm("Your really wonna destroy your player?");
                    if (d==true) {
                        window.location = "http://www.atenwood.com/facemash/my-face/?action=stop-game";
                        return;
                    }
                }
                alert("Okay, kick some ass!");
            }
        </script>
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../src/alexfacemashclass.php';
        $facemash = new AlexFacemashClass();

        include_once '../src/pagefacebookon.php';
        ?>

        <?php
        if ($_GET['action']) {
            if ($_GET['action'] === 'start-game') {
                $facemash->setFacemashUserGameStatus($me['id'], 'on');
            } else if ($_GET['action'] === 'stop-game') {
                $facemash->setFacemashUserGameStatus($me['id'], 'off');
            } else if ($_GET['action'] === 'make-rating-public') {
                $facemash->setFacemashUserRatingStatus($me['id'], 'public');
            } else if ($_GET['action'] === 'make-rating-private') {
                $facemash->setFacemashUserRatingStatus($me['id'], 'private');
            };
        }
        ?>

        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <h3>My Face Page</h3>

                    <?php if (!$me) {
                    ?>
                        <p>
                            Facemash
                            <br />is a service that allows users to rate the attractiveness
                            <br />of people's photos submitted voluntarily by others.
                        </p>
                        <p>
                            <img src="../about/images/fm-about-1.jpg" width="700" border="0" alt="Facemash" align="middle" />
                        </p>
                        <p>
                            We are glad to see you here, but you are not connected :-(
                        </p>
                        <p>
                            To sign in, please, login with your <a href="https://www.facebook.com/" class="simple">Facebook</a> account:
                            <br /><br />
                        <?php include '../src/fbloginbutton.php' ?>
                    </p>
                    <p>
                        To use Facemash, you have to read and accept Facemash <a href="../terms/" class="simple">Terms</a> and <a href="../privacy/" class="simple">Privacy</a> policies.
                    </p>
                    <?php } ?>

                    <?php
                    if ($me) {
                        echo '<p>Hi, ' . $me['name'] . '!</p>';
                    }
                    ?>                    

                    <?php if ($me) {
                    ?>
                        <a href="http://www.atenwood.com/facemash/my-face/" class="simpe">
                            <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture?type=large" border="0" align="middle" />
                        </a>

                        <table width="100%" border="0">
                            <tr>
                                <td>&nbsp;</td>
                                <td width="500" align="center">

                                    <p>
                                        My rating:

                                    <?php
                                    $facemashUserRating = $facemash->getFacemashUserRating($me['id']);
                                    if ($facemashUserRating) {
                                        echo '<span style="color:green;">' . $facemashUserRating . '</span>';
                                    } else {
                                        echo '0';
                                    }
                                    ?>

                                </p>

                                <p>
                                    My game status:

                                    <?php
                                    $facemashUserGameStatus = $facemash->getFacemashUserGameStatus($me['id']);
                                    if ($facemashUserGameStatus == 'on') {
                                        echo '<span style="color:green;">on</span>';
                                    } else {
                                        echo '<span style="color:crimson;">off</span>';
                                    }
                                    ?>

                                    <br />
                                    (<a href="?action=start-game" class="green">start game</a> | <a href="javascript:playerFaceDestroyed()" class="darkred">stop game</a>)
                                </p>

                                <p>
                                    My rating status:

                                    <?php
                                    $facemashUserRatingStatus = $facemash->getFacemashUserRatingStatus($me['id']);
                                    if ($facemashUserRatingStatus == 'public') {
                                        echo '<span style="color:green;">public</span>';
                                    } else {
                                        echo '<span style="color:crimson;">private</span>';
                                    }
                                    ?>

                                    <br />
                                    (<a href="?action=make-rating-public" class="green">make public</a> | <a href="?action=make-rating-private" class="darkred">make private</a>)
                                </p>

                                <p>
                                    <br />
                                    <?php
                                    $facemashUserId = $facemash->getFacemashUserId($me['id']);
                                    if (!$facemashUserId) {
                                        $facemashUserId = '0';
                                    }
                                    ?>
                                    <a href="page.php?id=<?php echo $facemashUserId; ?>" class="simple">Link to My Public Face Page</a>
                                </p>

                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>

                    <?php } ?>

                    <?php
                                include '../src/pagesociallike.php';
                    ?>

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