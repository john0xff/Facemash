<?php
require_once '../../src/facebook.php';

$facebook = new Facebook(array(
            'appId' => '', //TODO
            'secret' => '', //TODO
            'cookie' => true,
        ));

$me = null;
$uid = null;

try {
    // Proceed knowing you have a logged in user who's authenticated.
    $me = $facebook->api('/me');
	$uid = $facebook->getUser();
} catch (FacebookApiException $e) {
    $me = null;
}

if ($me) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLoginUrl();
}
?>

<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId   : '<?php echo $facebook->getAppId(); ?>',
            //session : <?php //echo json_encode($session); ?>,
            status  : true,
            cookie  : true,
            xfbml   : true
        });

        FB.Event.subscribe('auth.login', function() {
            window.location.reload();
        });
    };

    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
