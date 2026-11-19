
<?php

$host = 'localhost';
$dbname = 'vite_gourmand';
$username = 'vite_user';
$password = 'Vite1234!';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion MySQL : " . $e->getMessage());
}
