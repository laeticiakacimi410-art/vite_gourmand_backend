
<?php

$host = getenv('MYSQLHOST') ?: 'localhost';
$dbname = getenv('MYSQLDATABASE') ?: 'vite_gourmand';
$username = getenv('MYSQLUSER') ?: 'vite_user';
$password = getenv('MYSQLPASSWORD') ?: 'Vite1234!';
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion MySQL : " . $e->getMessage());
}
