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
        <title>Facemash - Previous</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <script type="text/javascript">
            function resizeImages()
            {
                var allImg = document.getElementById('imgBlock').getElementsByTagName('img');
                var count = allImg.length;
                for (var i = 0; i < count; ++i)
                {
                    if (allImg[i].width > 400)
                    {
                        allImg[i].height = allImg[i].height*(400/allImg[i].width);
                        allImg[i].width = 400;
                    }
                    if (allImg[i].height > 240)
                    {
                        allImg[i].width = allImg[i].width*(240/allImg[i].height);
                        allImg[i].height = 240;
                    }
                }
            }
            onload = resizeImages;
        </script>
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../src/alexfacemashclass.php';
        $facemash = new AlexFacemashClass();
        ?>

        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <h3>Previous Faces</h3>

                    <div id="imgBlock">
                        <?php
                        if (is_numeric($_SESSION['facemash_nextPlayer'])) {
                            if ($_SESSION['facemash_nextPlayer'] == 0) {
                                if (is_numeric($_SESSION['facemash_userAId'])) {
                                    $facemash_userAId = $_SESSION['facemash_userAId'];

                                    $userFacebookId = $facemash->getFacebookUserId($facemash_userAId);
                                    $userName = $facemash->getFacebookUserName($facemash_userAId);
                                }

                                echo
                                '<p>
                            <table border="0" align="center" class="images">
                            <tr>
                            <td align="center">
                            <a href="'
                                . 'https://www.facebook.com/profile.php?id=' . $userFacebookId .
                                '" class="hotname">
                            <p>
                            <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" align="middle" />
                            </p>'
                                . $userName .
                                '</a>
                            </td>

                            <td>&nbsp; AND &nbsp;</td>';

                                if (is_numeric($_SESSION['facemash_userBId'])) {
                                    $facemash_userBId = $_SESSION['facemash_userBId'];

                                    $userFacebookId = $facemash->getFacebookUserId($facemash_userBId);
                                    $userName = $facemash->getFacebookUserName($facemash_userBId);
                                }

                                echo
                                '<td align="center">
                            <a href="'
                                . 'https://www.facebook.com/profile.php?id=' . $userFacebookId .
                                '" class="hotname">
                            <p>
                            <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" align="middle" />
                            </p>'
                                . $userName .
                                '</a>
                            </td>
                            </tr>
                            </table>
                            </p>';
                            } else {
                                if (is_numeric($_SESSION['facemash_nextPlayer'])) {
                                    $facemash_nextPlayer = $_SESSION['facemash_nextPlayer'];

                                    $lastPlayer = $facemash_nextPlayer - 1;
                                }

                                if ($lastPlayer > 0) {
                                    $stopNumber = 0;
                                    if ($lastPlayer > 3) {
                                        $stopNumber = 2;
                                    }
                                    if ($lastPlayer > 50) {
                                        $stopNumber = $lastPlayer - 50;
                                    }
                                    for ($i = $lastPlayer; $i > $stopNumber; --$i) {
                                        if (is_numeric($_SESSION['facemash_player_' . $i])) {
                                            $facemash_player_i = $_SESSION['facemash_player_' . $i];

                                            $userFacebookId = $facemash->getFacebookUserId($facemash_player_i);
                                            $userName = $facemash->getFacebookUserName($facemash_player_i);
                                        }

                                        echo
                                        '<p>
                            <table border="0" align="center" class="images">
                            <tr>
                            <td align="center">
                            <a href="'
                                        . 'https://www.facebook.com/profile.php?id=' . $userFacebookId .
                                        '" class="hotname">
                            <p>
                            <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" align="middle" />
                            </p>'
                                        . $userName .
                                        '</a>
                            </td>

                            <td>&nbsp; AND &nbsp;</td>';

                                        --$i;

                                        if (is_numeric($_SESSION['facemash_player_' . $i])) {
                                            $facemash_player_i = $_SESSION['facemash_player_' . $i];

                                            $userFacebookId = $facemash->getFacebookUserId($facemash_player_i);
                                            $userName = $facemash->getFacebookUserName($facemash_player_i);
                                        }

                                        echo
                                        '<td align="center">
                            <a href="'
                                        . 'https://www.facebook.com/profile.php?id=' . $userFacebookId .
                                        '" class="hotname">
                            <p>
                            <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" align="middle" />
                            </p>'
                                        . $userName .
                                        '</a>
                            </td>
                            </tr>
                            </table>
                            </p>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>

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