<?php
namespace App\Config;
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'youmvc');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', 'http://localhost/youdemymvc');
// Site Name
define('SITENAME', 'EduLearn');

// Public Path
define('PUBLICPATH', dirname(dirname(__DIR__)) . '/public'); 