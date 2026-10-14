<?php
// Nur für den lokalen PHP-Entwicklungsserver: saubere URLs wie auf dem Live-Server (.htaccess).
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false;
}
$php = __DIR__ . rtrim($path, '/') . '.php';
if ($path === '/' ) {
    require __DIR__ . '/index.php';
} elseif (is_file($php) && !str_contains($path, '/inc/')) {
    require $php;
} else {
    http_response_code(404);
    require __DIR__ . '/fehler.php';
}
