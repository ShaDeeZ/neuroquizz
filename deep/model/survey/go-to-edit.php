<?php
include('../../bdd/connexion_bdd.php');
verifAcces($_SESSION);
include('../../api/survey/index.php');

$_SESSION['survey_neurotest'] = sanatizeString($_POST['survey_id']);
$_SESSION['num_question'] = 1;
header('Location:../../views/survey/edit-survey.php');

?>