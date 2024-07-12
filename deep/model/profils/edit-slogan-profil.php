<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/personality/index.php');

$slogan = sanatizeString($_POST['slogan']);

addDetailProfil('slogan','1',$slogan,$_SESSION['profil_to_edit'],$bdd);
goPreviousUrl();
?>