<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/personality/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le fichier a été correctement téléchargé
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        // Dossier de destination
        $uploadDirectory = '../../assets/img/image-profil/';

        // Récupérer le nom du fichier et le chemin temporaire
        $fileName = basename($_FILES['new_image']['name']);
        $tempFilePath = $_FILES['new_image']['tmp_name'];

        // Construire le chemin final du fichier dans le dossier de destination
        $targetFilePath = $uploadDirectory . $fileName;

        // Déplacer le fichier vers le dossier de destination
        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
            echo 'Image téléchargée avec succès.';
            $image_number = sanatizeString($_POST['image_number']);
            $urlImg = $targetFilePath;

            // Trouver la première occurrence de 'img/'
            $imgUrl = strstr($urlImg, 'img/');
            // Si 'img/' est trouvé, extraire la partie après
            if ($imgUrl !== false) {
                $urlImg = substr($imgUrl, 0);  // Ne pas spécifier la longueur pour inclure 'img/'
                echo $urlImg;
            } else {
                echo 'Chaîne non valide.';
            }
            // var_dump($num_res, $id_survey, $urlImg);
            addDetailProfil('img', $image_number, $urlImg, $_SESSION['profil_to_edit'], $bdd);
            goPreviousUrl();
        } else {
            echo 'Une erreur s\'est produite lors du téléchargement de l\'image.';
        }
    } else {
        echo 'Veuillez sélectionner une image.';
    }
} else {
    // Si la requête n'est pas une méthode POST, rediriger ou afficher un message d'erreur
    echo 'Méthode de requête incorrecte.';
}
