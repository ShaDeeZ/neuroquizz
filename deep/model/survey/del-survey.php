<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$id_survey = sanatizeString($_POST['survey_id']);
var_dump($id_survey);

delSurvey($id_survey, $bdd);
