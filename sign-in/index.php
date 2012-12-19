<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - Sign In</title>
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
                    <h3>Sign In!</h3>

                    <p>
                        Facemash
                        <br />is a service that allows users to rate the attractiveness
                        <br />of people's photos submitted voluntarily by others.
                    </p>

                    <p>
                        <img src="../about/images/fm-about-1.jpg" width="700" border="0" alt="Facemash" align="middle" />
                    </p>

                    <?php
                    if ($me) {
                        echo 'Hi, ' . $me['name'] . '!';
                    }
                    ?>                    

                    <?php
                    if (!$me) {
                        echo '<p>We are glad to see you here, but you are not connected :-(</p>';
                    } else {
                        echo '<p> Glad to see you. You are already connected-)</p>';
                    }
                    ?>

                    <?php if ($me) {
                    ?>
                        <a href="../my-face/" class="simple" title="Go to My Face Page">
                            <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture?type=large" border="0" align="middle" />
                        </a>
                        <br /><br />
                        To Start a Game and customise your Facemash settings visit <a href="../my-face/" class="simple">My Face Page</a>.
                        <!--
                        <br /><br />
                        You also can logout from your Facebook account:
                        <br /><br />
                        <a href="<?php echo $logoutUrl; ?>"><img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif"></a>
                        -->
                    <?php } else {
                    ?>
                        <p>
                            To sign in, please, login with your <a href="https://www.facebook.com/" class="simple">Facebook</a> account:
                            <br /><br />
                        <?php include '../src/fbloginbutton.php' ?>
                    </p>
                    <p>
                        To use Facemash, you have to read and accept Facemash <a href="../terms/" class="simple">Terms</a> and <a href="../privacy/" class="simple">Privacy</a> policies.
                    </p>
                    <p>
                        To Start a Game after login visit <a href="../my-face/" class="simple">My Face Page</a>.
                    </p>
                    <?php } ?>

                    <p>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FFacemash%2F185261021509348&amp;width=700&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=true&amp;height=730" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:700px; height:730px;" allowTransparency="true"></iframe>
                    </p>
                    <p>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FAtenwood%2F153908118000636&amp;width=700&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=true&amp;height=730" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:700px; height:730px;" allowTransparency="true"></iframe>
                    </p>

                    <img src="../about/images/fm-about-9.jpg" width="700" border="0" alt="Facemash" align="middle" />

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