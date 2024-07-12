<?php
include('../../bdd/connexion_bdd.php');
include('../../api/personality/index.php');
include('../../api/survey/index.php');

$newValue = sanatizeString($_POST['newValue']);
$num_q  = $_SESSION['num_question'];
$survey = $_SESSION['survey_neurotest'];

changeVisibilityQuestion($survey, $num_q, $newValue, $bdd);

