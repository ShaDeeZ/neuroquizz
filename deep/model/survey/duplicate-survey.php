<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$id_survey = sanatizeString($_SESSION['survey_neurotest']);
//var_dump($id_survey);

duplicateSurvey($id_survey, $bdd);
header('Location:../../views/home/control.php'); 
