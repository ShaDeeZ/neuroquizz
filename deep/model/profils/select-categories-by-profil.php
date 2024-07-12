<?php
include('../../bdd/connexion_bdd.php');

$_SESSION['categories'] = intval(sanatizeString($_GET['idCategorie']));

goPreviousUrl();
?>