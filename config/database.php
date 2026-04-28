<?php

$host = "localhost";
$db = "paleo_db";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}