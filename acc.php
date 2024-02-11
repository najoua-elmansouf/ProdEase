<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="acc.css">
    <title>Accueil</title>
</head>
<body>
<div class="navbar">
    <div class="brand">Application Produit</div>
    <div class="menu">
        <a href="acc.php">Accueil</a>
        <a href="ajouterproduit.php">Ajouter Produit</a>
        <a href="quitersession.php">Quitter la Session</a>
    </div>
</div>

<?php
session_start();
include "conn.php";

if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $heure = date("H");
    $salut = ($heure >= 6 && $heure < 18) ? "Bonjour" : "Bonsoir";

    echo '<div class="message">' . $salut . " " . $prenom . " " . $nom . '</div>';

} else {
    header('Location: auth.php');
    exit();
}
$sql = "SELECT reference, libelle, prixUnitaire, dateAchat, photoProduit, idCategorie FROM produit";
$result = $connexion->query($sql);

$table_html = "<table border='1'>
                <tr>
                    <th>Reference</th>
                    <th>Libelle</th>
                    <th>Prix Unitaire</th>
                    <th>Date d'Achat</th>
                    <th>Photo Produit</th>
                    <th>Categorie</th>
                    <th>Action</th>
                </tr>";

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $table_html .= "<tr>
                        <td>{$row['reference']}</td>
                        <td>{$row['libelle']}</td>
                        <td>{$row['prixUnitaire']}</td>
                        <td>{$row['dateAchat']}</td>
                        <td><img src='{$row['photoProduit']}' alt='Image Produit' style='width: 50px; height: 50px;'></td>
                        <td>{$row['idCategorie']}</td>
                        <td>
                            <a href='modifier.php?id={$row['reference']}' style='color:green;'><i class='fa fa-pencil'></i></a>
                            <a href='supprimer.php?id={$row['reference']}'style='color:red;'><i class='fa fa-trash'></i></a>
                        </td>
                    </tr>";
}

$table_html .= "</table>";



?>

<h2>Table de produits:</h2>
    <?php echo $table_html;  ?>


    
</body>
</html>