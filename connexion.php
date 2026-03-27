<?php
$dbname = "Voiture";
$dbuser = "root";
$dbpassword = "";
$dbhost = "localhost";
try {
    $pdo = new PDO("mysql:host=$dbhost; dbname=$dbname", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion Réussie  ";
} catch (PDOException $e) {
    echo "connexion echoue" . $e->getMessage();
}
