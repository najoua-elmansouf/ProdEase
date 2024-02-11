<?php
session_start();

if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("Location: auth.php");
    exit();
}

include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = $_POST['reference'];
    $libelle = $_POST['libelle'];
    $prixUnitaire = $_POST['prixUnitaire'];
    $dateAchat = $_POST['dateAchat'];
    $categorie = $_POST['categorie'];

    // Traitement de l'image
    $target_dir = "uploads/"; // Dossier de téléchargement
    $target_file = $target_dir . basename($_FILES["photoProduit"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifie si le fichier image est une image réelle ou une fausse image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photoProduit"]["tmp_name"]);
        if ($check !== false) {
            echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    }

    // Vérifie si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifie la taille du fichier
    if ($_FILES["photoProduit"]["size"] > 500000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autorise certains formats de fichiers
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifie si $uploadOk est défini à 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        // Si tout est ok, télécharge le fichier
        if (move_uploaded_file($_FILES["photoProduit"]["tmp_name"], $target_file)) {
            // Insérer le chemin du fichier dans la base de données
            $sql = "INSERT INTO produit (reference, libelle, prixUnitaire, dateAchat, photoProduit, idCategorie) 
                    VALUES (:reference, :libelle, :prixUnitaire, :dateAchat, :photoProduit, :idCategorie)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':reference', $reference);
            $stmt->bindParam(':libelle', $libelle);
            $stmt->bindParam(':prixUnitaire', $prixUnitaire);
            $stmt->bindParam(':dateAchat', $dateAchat);
            $stmt->bindParam(':photoProduit', $target_file); // Enregistrez le chemin du fichier
            $stmt->bindParam(':idCategorie', $categorie);

            if ($stmt->execute()) {
                echo "Le produit a été ajouté avec succès.";
                // Ajout du script JavaScript pour l'alerte et la redirection
                echo '<script>alert("Le produit a été ajouté avec succès."); window.location.href = "acc.php";</script>';
            } else {
                echo "Erreur lors de l'ajout du produit.";
            }
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}
?>
