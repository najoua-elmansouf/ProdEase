<?php
$host = 'localhost';
$port = '3306';
$dbname = 'gestionproduit';
$username = 'root';
$password = 'root';

try {
    $connexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    //echo "Connexion réussie!";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>