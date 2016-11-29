<?php

ini_set('display_errors', 1);
ini_set('error_reporting', -1);

define('CONTROLLERS_PATH', 'App\Core\Controllers\\');

define('DB_DSN', 'mysql:host=localhost;dbname=lightit_comment');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

define('TWIG_TEMPLATES_PATH', './views');
define('TWIG_OPTIONS', array('cache' => false));

define('FACEBOOK_ID', '1603057430001147');
define('FACEBOOK_SECRET', '97a12c16e8de35246a4d3df62b1a7d5c');
define('FACEBOOK_LOGIN_CALLBACK', 'http://0dda2790.ngrok.io/callback/fblogincallback');
define('FACEBOOK_SESSION_NAME_TOKEN', 'facebook_access_token');