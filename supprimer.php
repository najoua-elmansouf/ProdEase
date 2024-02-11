<?php
session_start();

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("Location: auth.php");
    exit();
}
include "conn.php";

// Récupérez l'ID du produit à partir de l'URL
if (isset($_GET['id'])) {
    $reference_produit = $_GET['id'];

    // Exécutez la requête de suppression
    $sql = "DELETE FROM produit WHERE reference = :reference";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':reference', $reference_produit);

    if ($stmt->execute()) {
        // Redirigez l'utilisateur vers la page d'accueil après la suppression
        header("Location: acc.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
} else {
    echo "ID du produit non spécifié.";
}
?>
