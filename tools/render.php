<?php
// Rendert eine PHP-Seite als statisches HTML (für die Demo-Version). Aufruf: php tools/render.php seite.php [query]
define('DEMO_EXPORT', true);
chdir(dirname(__DIR__));
parse_str($argv[2] ?? '', $_GET);
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
require $argv[1];
