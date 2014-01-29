<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - TOP 100 HOT Girls</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../../src/fbjssdk.php';

        include_once '../src/alexfacemashclass.php';
        $facemash = new AlexFacemashClass();
        ?>

        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <h3>TOP 100 HOT Girls</h3>

                    <div id="imgBlock">
                        <p>
                            <table border="0" align="center" class="images">
                                <?php
                                $showMode = 'FacemashGirlsRatings';

                                $top100Array = $facemash->getTop100($showMode);

                                $count = count($top100Array) - 1;

                                $maxRating = $top100Array[$count][1];

                                for ($i = $count; $i > 0; --$i) {
                                    $user = $top100Array[$i][0];
                                    $rating = $top100Array[$i][1];

                                    $userFacebookId = $facemash->getFacebookUserId($user);
                                    $userName = $facemash->getFacebookUserName($user);

                                    if ($rating == $maxRating) {
                                        $hotOrNot = '                                        
                                        <a href="' . 'https://www.facebook.com/profile.php?id=' . $userFacebookId . '" class="hotname">
                                        <p>
                                        <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" alt="The Hottest Facemash Girl" align="bottom" />
                                        </p>
                                        <p style="color:red;">
                                        ' . 'THE HOTTEST &hearts; ' . $userName . ' &hearts; THE HOTTEST' . '
                                        </p>
                                        </a>                                        
                                        ';
                                    } else {
                                        $hotOrNot = '
                                        <a href="' . 'https://www.facebook.com/profile.php?id=' . $userFacebookId . '" class="hotname">
                                        <p>
                                        <img src="http://graph.facebook.com/' . $userFacebookId . '/picture?type=large" alt="Facemash TOP 100 Girl" align="bottom" />
                                        </p>' . $userName . ' (' . intval($rating / $maxRating * 100) . '%)' . '</a>
                                        ';
                                    }

                                    echo '
                                        <tr>
                                        <td align="center">'
                                    . $hotOrNot . '
                                        </td>
                                        </tr>                                        
                                        ';
                                }
                                ?>
                            </table>
                        </p>
                    </div>

                    <p>
                        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like show_faces="true" width="450"></fb:like>
                    </p>

                    <table align="center" border="0">
                        <tr>
                            <td>
                                <div style="float: right; padding: 4px;">
                                    <a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
                                </div>
                            </td>
                            <td>
                                <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="thefacemash">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                            </td>
                        </tr>
                    </table>
                    <p>
                        <a href="https://www.facebook.com/dialog/apprequests?app_id=129040597150831&redirect_uri=http://www.atenwood.com/facemash/index.php&message=Facemash%20/%20The%20Social%20Network%20/%20Who's%20Hotter?%20Click%20to%20Choose.%20http://www.atenwood.com/facemash/" class="invitefriends">&spades; Invite Friends &spades;</a>
                    </p>

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