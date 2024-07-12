<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/personality/index.php');


$nom = sanatizeString($_POST['name_profil']);

$persoExist = 0;

$personnality = checkPersoExist($nom,$bdd);
foreach($personnality as $perso){
    $persoExist = 1;
}

if ($persoExist == 0) {
    addProfil($nom, $bdd);

    header('Location:../../views/profils/edit-profil.php');
} else {
    header('Location:../../views/profils/add-profil.php?errPersoExist=1');
}


?>