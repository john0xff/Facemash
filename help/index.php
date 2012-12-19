<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta name="description" content="Facemash / The Social Network / Who's Hotter? Click to Choose. / Facemash is a service that allows users to rate the attractiveness of people's photos submitted voluntarily by others." />
        <meta name="keywords" content="Facemash" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facemash - Help</title>
        <link type="text/css" rel="stylesheet" href="../src/facemash-main.css" />
        <?php include '../../src/googlewebcounter.php'; include '../../src/sitemeterwebcounter.php'; ?>
    </head>
    <body>
        <?php
        include_once '../../src/fbjssdk.php';
        ?>
        
        <table cellspacing="0" class="facemash">
            <tr class="facemash">
                <th class="facemash"><a href="http://www.atenwood.com/facemash/" class="facemash">FACEMASH</a></th>
            </tr>
            <tr class="facemash">
                <td class="facemash">
                    <h3>Help</h3>

                    <p>
                        <fb:comments href="http://www.atenwood.com/facemash/help/" num_posts="20" width="700"></fb:comments>
                    </p>

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