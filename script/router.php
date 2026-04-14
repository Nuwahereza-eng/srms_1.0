<?php
/**
 * Router for PHP built-in development server.
 * Replicates the .htaccess rewrite rules so the app works without Apache.
 *
 * Usage:  php -S localhost:8000 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// .htaccess enables output_buffering; the built-in server doesn't read
// .htaccess, so we enable it here so header() calls work after output.
if (!ini_get('output_buffering')) {
    ob_start();
}

// --- Explicit rewrites (mirrors .htaccess) ---
$rewrites = [
    '/staff/login'    => '/staff_login.php',
    '/staff/reset_pw' => '/staff_reset_pw.php',
];

foreach ($rewrites as $pattern => $target) {
    if (rtrim($uri, '/') === $pattern) {
        routeRequire(__DIR__ . $target);
        return true;
    }
}

// --- Helper: require a PHP file with the correct working directory ---
// Apache sets CWD to the script's directory; replicate that behaviour here
// so that chdir('../') and relative require_once calls inside the scripts work.
// We also fix SCRIPT_NAME / PHP_SELF so that CSRF action_name() resolves to
// the real target file instead of "router.php".
function routeRequire(string $file): void {
    $origDir        = getcwd();
    $origScript     = $_SERVER['SCRIPT_NAME']     ?? '';
    $origPhpSelf    = $_SERVER['PHP_SELF']         ?? '';
    $origFilename   = $_SERVER['SCRIPT_FILENAME']  ?? '';

    // Make SCRIPT_NAME look like the target file (relative to docroot)
    $relative = '/' . ltrim(str_replace(__DIR__, '', $file), '/');
    $_SERVER['SCRIPT_NAME']     = $relative;
    $_SERVER['PHP_SELF']        = $relative;
    $_SERVER['SCRIPT_FILENAME'] = $file;

    chdir(dirname($file));
    require $file;
    chdir($origDir);

    $_SERVER['SCRIPT_NAME']     = $origScript;
    $_SERVER['PHP_SELF']        = $origPhpSelf;
    $_SERVER['SCRIPT_FILENAME'] = $origFilename;
}

// --- Serve existing static files directly (css, js, images, fonts, etc.) ---
$filePath = __DIR__ . $uri;
if ($uri !== '/' && is_file($filePath)) {
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    // Let PHP process .php files itself
    if (strtolower($ext) === 'php') {
        routeRequire($filePath);
        return true;
    }
    // Return false so the built-in server serves the static file natively
    return false;
}

// --- Auto-append .php extension (mirrors: RewriteRule ^(.*)$ $1.php) ---
$phpFile = __DIR__ . $uri . '.php';
if (is_file($phpFile)) {
    routeRequire($phpFile);
    return true;
}

// --- Default: serve index.php for the root ---
if ($uri === '/') {
    routeRequire(__DIR__ . '/index.php');
    return true;
}

// Not found
http_response_code(404);
echo '404 Not Found';
return true;
