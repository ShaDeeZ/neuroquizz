<?php
include('../../bdd/connexion_bdd.php');
include('../../api/control/functions.php');

$survey = sanatizeString($_POST['enquete']);
$visibility = sanatizeString($_POST['visibility']);
$newVisibilty = ($visibility == 0) ? 1 : 0;
upVisibilitySurvey($survey,$newVisibilty, $bdd);

?>