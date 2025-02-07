<?php
namespace App\Config;
// DB Params for PostgreSQL
define('DB_HOST', 'localhost');
define('DB_USER', 'postgres');
define('DB_PASS', 'ashraf1998');
define('DB_NAME', 'youmvc');
define('DB_PORT', '5432'); // Default PostgreSQL port

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', 'http://localhost/youdemymvc');
// Site Name
define('SITENAME', 'EduLearn');

// Public Path
define('PUBLICPATH', dirname(dirname(__DIR__)) . '/public'); 