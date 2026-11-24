<?php

$host = getenv('PALEOPEDIA_DB_HOST') ?: 'localhost';
$db = getenv('PALEOPEDIA_DB_NAME') ?: 'paleo_db';
$user = getenv('PALEOPEDIA_DB_USER') ?: 'root';
$envPassword = getenv('PALEOPEDIA_DB_PASSWORD');
$pass = $envPassword === false ? '' : $envPassword;

try {
    $conn = new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('[Paleopedia] Falha na conexão com o banco: ' . $e->getMessage());

    if (!headers_sent()) {
        http_response_code(503);
        header('Content-Type: text/plain; charset=UTF-8');
    }

    exit('Serviço temporariamente indisponível. Tente novamente mais tarde.');
}
