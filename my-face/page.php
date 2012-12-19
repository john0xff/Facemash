<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - My Public Face Page</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../../src/fbjssdk.php';

        include_once '../src/alexfacemashclass.php';
        $facemash = new AlexFacemashClass();

        if (is_numeric($_GET['id'])) {
            $facemash_userId = $_GET['id'];

            $userFacebookId = $facemash->getFacebookUserId($facemash_userId);
            $userName = $facemash->getFacebookUserName($facemash_userId);

            $facemashUserRatingStatus = $facemash->getFacemashUserRatingStatus($userFacebookId);
        }
        ?>

        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <?php
                    if ($facemashUserRatingStatus === 'public') {
                        echo '<h3>' . $userName . ' Public Face Page</h3>';

                        echo '
                            <a href="https://www.facebook.com/profile.php?id=' . $userFacebookId . '" class="simpe">
                            <img src="https://graph.facebook.com/' . $userFacebookId . '/picture?type=large" border="0" align="middle" />
                            </a>
                            ';
                        echo '<p>User Rating: ';
                        $facemashUserRating = $facemash->getFacemashUserRating($userFacebookId);
                        if ($facemashUserRating) {
                            echo '<span style="color:green;">' . $facemashUserRating . '</span>';
                        } else {
                            echo '0';
                        }
                        echo '</p>';
                    } else {
                        echo '<h3>Public Face Page</h3><p>No public page for this user.</p>';
                    }
                    ?>

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