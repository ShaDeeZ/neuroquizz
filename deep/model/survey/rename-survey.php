<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$id_survey = sanatizeString($_SESSION['survey_neurotest']);
$newName = sanatizeString($_POST['newName']);
//var_dump($id_survey);

renameSurvey($id_survey, $newName, $bdd);

