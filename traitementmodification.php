<?php
session_start();
include "conn.php";
if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header('Location: auth.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = $_POST['reference'];
    $libelle = $_POST['libelle'];
    $prixUnitaire = $_POST['prixUnitaire'];
    $dateAchat = $_POST['dateAchat'];
    $idCategorie = $_POST['categorie'];

    if (!empty($_FILES['nouvellePhotoProduit']['name'])) {
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["nouvellePhotoProduit"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["nouvellePhotoProduit"]["tmp_name"]);
        if ($check === false) {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        
        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        
        if ($_FILES["nouvellePhotoProduit"]["size"] > 500000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

       
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

       
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
        } else {
            // Si tout est ok, téléchargez le fichier
            if (move_uploaded_file($_FILES["nouvellePhotoProduit"]["tmp_name"], $target_file)) {
                echo "Le fichier " . htmlspecialchars(basename($_FILES["nouvellePhotoProduit"]["name"])) . " a été téléchargé.";
                // Mettez à jour le chemin de la nouvelle image dans la base de données
                $sql = "UPDATE produit SET libelle=:libelle, prixUnitaire=:prixUnitaire, dateAchat=:dateAchat, photoProduit=:photoProduit, idCategorie=:idCategorie WHERE reference=:reference";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(':libelle', $libelle);
                $stmt->bindParam(':prixUnitaire', $prixUnitaire);
                $stmt->bindParam(':dateAchat', $dateAchat);
                $stmt->bindParam(':photoProduit', $target_file);
                $stmt->bindParam(':idCategorie', $idCategorie);
                $stmt->bindParam(':reference', $reference);

                if ($stmt->execute()) {
                    echo "produit a été modifié avec succé";
                    
                } else {
                    echo "Erreur lors de la modification du produit.";
                }
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    } else {
        // Si aucune nouvelle image n'a été téléchargée, mettez simplement à jour les autres champs
        $sql = "UPDATE produit SET reference=:reference ,libelle=:libelle, prixUnitaire=:prixUnitaire, dateAchat=:dateAchat  WHERE idCategorie=:idCategorie";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':prixUnitaire', $prixUnitaire);
        $stmt->bindParam(':dateAchat', $dateAchat);
        $stmt->bindParam(':idCategorie', $idCategorie);
        $stmt->bindParam(':reference', $reference);

        if ($stmt->execute()) {
            echo '<script>alert("Le produit a été modifié avec succès!"); window.location.href = "acc.php";</script>';
        } else {
            echo "Erreur lors de la modification du produit.";
        }
    }
}
?>
