<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
$_SESSION['profil_to_edit'] = intval(sanatizeString($_GET['profil']));

goPreviousUrl();
?>