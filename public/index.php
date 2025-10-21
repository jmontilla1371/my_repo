<?php

require __DIR__ . '/../src/bootstrap.php';

use App\Db\Connection;

$driver = getenv('DB_DRIVER') ?: 'pdo_pgsql';
$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '5432';
$db = getenv('DB_NAME') ?: 'app';
$user = getenv('DB_USER') ?: 'app';
$pass = getenv('DB_PASS') ?: 'secret';

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";

try {
    $conn = new Connection($driver, $dsn, $user, $pass);
    $dbx = $conn->get();
    $row = $dbx->GetRow('SELECT 1 as ok');
    echo '<h1>PHP 8.2 + PostgreSQL 14 OK</h1>';
    echo '<pre>' . htmlspecialchars(print_r($row, true)) . '</pre>';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre>Error: ' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
