<?php
session_start();
if (empty($_SESSION['isValid'])) {
    session_regenerate_id();
    $_SESSION['isValid'] = true;
}
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
?>
<?php
include_once 'src/alexfacemashclass.php';
$facemash = new AlexFacemashClass();

include_once 'src/maintopphp.php';
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash</title>
        <link type="text/css" rel="stylesheet" href="facemash-main.css" />
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
        <?php include '../src/googlewebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../src/fbjssdk.php';
        ?>
        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <p class="firstline">Were we let in for our looks? No. Will we be judged on them? Yes.</p>
                    <p class="seconline">Who's Hotter? Click to Choose.</p>
                    <p>
                        <div id="hotfaces" class="displaybox">
                            <?php
                            if (is_numeric($_SESSION['facemash_userAId'])) {
                                $facemash_userAId = $_SESSION['facemash_userAId'];
                            } else {
                                $facemash_userAId = 0;
                            }

                            if (is_numeric($_SESSION['facemash_userBId'])) {
                                $facemash_userBId = $_SESSION['facemash_userBId'];
                            } else {
                                $facemash_userBId = 0;
                            }

                            $userAFacebookId = $facemash->getFacebookUserId($facemash_userAId);
                            $userBFacebookId = $facemash->getFacebookUserId($facemash_userBId);

                            $_SESSION['facemash_leftUserAId'] = $facemash_userAId;
                            $_SESSION['facemash_rightUserBId'] = $facemash_userBId;

                            $userAName = $facemash->getFacebookUserName($facemash_userAId);
                            $userBName = $facemash->getFacebookUserName($facemash_userBId);
                            ?>
                            <div id="imgBlock">
                                <table border="0" align="center" class="images">
                                    <tr>
                                        <td align="center">
                                            <a href="?face=left" class="hotname">
                                                <p>
                                                    <img src="<?php echo 'http://graph.facebook.com/' . $userAFacebookId . '/picture?type=large'; ?>" align="middle" />
                                                </p>
                                                <?php echo $userAName; ?>
                                            </a>
                                        </td>
                                        <td>&nbsp; OR &nbsp;</td>
                                        <td align="center">
                                            <a href="?face=right" class="hotname">
                                                <p>
                                                    <img src="<?php echo 'http://graph.facebook.com/' . $userBFacebookId . '/picture?type=large'; ?>" align="middle" />
                                                </p>
                                                <?php echo $userBName; ?>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </p>
                    <p class="next">
                        <a href="http://www.atenwood.com/facemash/" class="next" title="Next Players">&rarr;</a>
                    </p>
                    <?php
                                                include 'src/mainsociallike.php';
                    ?>
                    <?php
                                                $modeLinkColor = 'deeppink';
                    ?>
                                                <ul class="uppercase">
                                                    <li>
                                                        <a href="?face=no&mode=boys" class="upperlink"
                            <?php
                                                if ($_SESSION['facemash_showMode'] === 'FacemashBoysRatings') {
                                                    echo 'style="color:' . $modeLinkColor . ';"';
                                                }
                            ?>
                                                   >
                                                    Boys
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?face=no&mode=celebrities" class="upperlink"
                            <?php
                                                if ($_SESSION['facemash_showMode'] === 'FacemashCelebritiesRatings') {
                                                    echo 'style="color:' . $modeLinkColor . ';"';
                                                }
                            ?>
                                                   >
                                                    Celebrities
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?face=no&mode=random" class="upperlink"
                            <?php
                                                if ($_SESSION['facemash_showMode'] === 'FacemashGirlsRatings') {
                                                    echo 'style="color:' . $modeLinkColor . ';"';
                                                }
                            ?> 
                                                   >
                                                    Random [Girls]
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="footer">
                                            <div class="container">
                            <?php
                                                include 'src/mainbottommenu.php';
                                                include 'src/mainbottomcopyright.php';
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>