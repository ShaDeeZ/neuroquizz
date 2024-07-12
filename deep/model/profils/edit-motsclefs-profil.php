<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/personality/index.php');

$motsClefs = sanatizeString($_POST['motsclefs']);

addDetailProfil('motsclefs','1',$motsClefs,$_SESSION['profil_to_edit'],$bdd);

goPreviousUrl();
?>