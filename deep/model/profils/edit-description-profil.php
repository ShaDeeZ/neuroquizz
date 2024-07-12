<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/personality/index.php');

$description = sanatizeString($_POST['description']);

addDescriptionProfil($_SESSION['profil_to_edit'],sanatizeString($_POST['categorie']),'profil_description',$description,$bdd);
//addDetailProfil('description','1',$description,$_SESSION['profil_to_edit'],$bdd);
goPreviousUrl();
?>