<?php
// Router cho PHP Development Server
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Nếu truy cập /admin (không có slash cuối hoặc có slash)
if ($uri === '/admin' || $uri === '/admin/') {
    $_SERVER['SCRIPT_NAME'] = '/admin/index.php';
    chdir(__DIR__ . '/admin'); // Change working directory
    include __DIR__ . '/admin/index.php';
    return true;
}

// Nếu truy cập /login.php, redirect đến admin login
if ($uri === '/login.php') {
    header('Location: /admin/login.php');
    return true;
}

// Nếu là file tĩnh và tồn tại, serve trực tiếp
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff|woff2|ttf|eot)$/', $uri)) {
    return false; // serve file tĩnh
}

// Nếu file PHP tồn tại, chạy nó
$file = __DIR__ . $uri;
if (is_file($file)) {
    return false;
}

// Default: index.php
if ($uri === '/' || $uri === '') {
    include __DIR__ . '/index.php';
    return true;
}

return false;
