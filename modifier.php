<?php
session_start();
include "conn.php";


if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header('Location: auth.php');
    exit();
}
if (isset($_GET['id'])) {
    $idProduit = $_GET['id'];

    // Récupérez les informations du produit à partir de la base de données
    $sql = "SELECT reference, libelle, prixUnitaire, dateAchat, photoProduit, idCategorie FROM produit WHERE reference = :idProduit";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
    $stmt->execute();

    // Vérifiez si le produit existe
    if ($stmt->rowCount() > 0) {
        // Récupérez les données du produit
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $reference = $row['reference'];
        $libelle = $row['libelle'];
        $prixUnitaire = $row['prixUnitaire'];
        $dateAchat = $row['dateAchat'];
        $photoProduit = $row['photoProduit'];
        $idCategorie = $row['idCategorie'];

    } else {
        
        header('Location: acc.php');
        exit();
    }
} else {
    header('Location: acc.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Link rel="stylesheet" href="modifier.css">
    <title>Modifier le Produit</title>
</head>
<body>

<h2>Modifier le Produit</h2>

<form action="traitementmodification.php" method="post" enctype="multipart/form-data">
    <!-- Utilisez les variables PHP pour remplir les champs du formulaire -->
    <label for="reference">Référence:</label>
    <input type="text" id="reference" name="reference" value="<?php echo $reference; ?>" readonly>

    <label for="libelle">Libellé:</label>
    <input type="text" id="libelle" name="libelle" value="<?php echo $libelle; ?>" required>

    <label for="prixUnitaire">Prix Unitaire:</label>
    <input type="number" id="prixUnitaire" name="prixUnitaire" value="<?php echo $prixUnitaire; ?>" required>

    <label for="dateAchat">Date d'Achat:</label>
    <input type="date" id="dateAchat" name="dateAchat" value="<?php echo date('Y-m-d', strtotime($dateAchat)); ?>" required>


    <label for="photoProduit">Photo du Produit:</label>
<img src='<?php echo $photoProduit; ?>' style='width: 50px; height: 50px;'>
<input type="file" id="photoProduit" name="nouvellePhotoProduit" accept="image/*">


    <label for="categorie">Catégorie:</label>
    <input type="text" id="categorie" name="categorie" value="<?php echo $idCategorie; ?>" required>

    <button type="submit">Modifier</button>
</form>

</body>
</html>
