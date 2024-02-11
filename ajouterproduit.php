<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ajouterproduit.css">
    <title>Ajouter un Produit</title>
</head>
<body>

<h2>Ajouter un Produit</h2>

<form action="traitement.php" method="post" enctype="multipart/form-data">
    <label for="reference">Référence:</label>
    <input type="text" id="reference" name="reference" required>

    <label for="libelle">Libellé:</label>
    <input type="text" id="libelle" name="libelle" required>

    <label for="prixUnitaire">Prix Unitaire:</label>
    <input type="number" id="prixUnitaire" name="prixUnitaire" required>

    <label for="dateAchat">Date d'Achat:</label>
    <input type="date" id="dateAchat" name="dateAchat" placeholder="YYYY-MM-DD" required>

    <label for="photoProduit">Photo du Produit:</label>
    <input type="file" id="photoProduit" name="photoProduit" accept="image/*" required>

    <label for="categorie">Catégorie:</label>
    <input type="text" id="categorie" name="categorie" required>

    <button type="submit">Ajouter</button>
</form>

</body>
</html>
